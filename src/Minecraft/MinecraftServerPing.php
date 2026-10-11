<?php

namespace App\Minecraft;

/**
 * Interroge un serveur Minecraft Java avec le protocole « Server List Ping »
 * (celui de la liste multijoueur du jeu) : version, joueurs, MOTD, icône, mods.
 * Aucune authentification : le serveur répond à n'importe quel client.
 */
class MinecraftServerPing
{
    public function __construct(
        private readonly float $timeout = 1.5,
    ) {
    }

    /**
     * @return array{version: ?string, protocol: ?int, playersOnline: int, playersMax: int, players: string[], motd: string, favicon: ?string, modLoader: ?string, modCount: ?int, latency: int}|null
     */
    public function ping(string $host, int $port): ?array
    {
        $socket = @fsockopen($host, $port, $errno, $errstr, $this->timeout);
        if ($socket === false) {
            return null;
        }

        try {
            stream_set_timeout($socket, (int) ceil($this->timeout));
            $start = microtime(true);

            // Handshake (état suivant = 1 : status), puis Status Request
            $handshake = "\x00" . $this->varInt(-1) . $this->string($host) . pack('n', $port) . $this->varInt(1);
            fwrite($socket, $this->varInt(strlen($handshake)) . $handshake);
            fwrite($socket, $this->varInt(1) . "\x00");

            $this->readVarInt($socket); // longueur du paquet
            if ($this->readVarInt($socket) !== 0x00) {
                return null;
            }
            $json = $this->readBytes($socket, $this->readVarInt($socket));
            $latency = (int) round((microtime(true) - $start) * 1000);
        } catch (\RuntimeException) {
            return null;
        } finally {
            fclose($socket);
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            return null;
        }

        return $this->parse($data, $latency);
    }

    private function parse(array $data, int $latency): array
    {
        $players = array_values(array_filter(array_map(
            fn (array $p) => $this->stripFormatting($p['name'] ?? ''),
            $data['players']['sample'] ?? [],
        ), fn (string $name) => $name !== '' && !str_contains($name, ' ')));

        [$modLoader, $modCount] = $this->detectMods($data);

        return [
            'version' => isset($data['version']['name']) ? $this->stripFormatting($data['version']['name']) : null,
            'protocol' => $data['version']['protocol'] ?? null,
            'playersOnline' => (int) ($data['players']['online'] ?? 0),
            'playersMax' => (int) ($data['players']['max'] ?? 0),
            'players' => $players,
            'motd' => trim($this->stripFormatting($this->chatToText($data['description'] ?? ''))),
            'favicon' => isset($data['favicon']) && str_starts_with($data['favicon'], 'data:image/') ? $data['favicon'] : null,
            'modLoader' => $modLoader,
            'modCount' => $modCount,
            'latency' => $latency,
        ];
    }

    /**
     * Forge annonce ses mods dans la réponse : « modinfo » jusqu'en 1.12, « forgeData » ensuite
     * (en 1.18+ la liste peut être compressée dans forgeData.d : on sait alors seulement que c'est du Forge).
     *
     * @return array{0: ?string, 1: ?int}
     */
    private function detectMods(array $data): array
    {
        if (isset($data['modinfo'])) {
            $mods = $data['modinfo']['modList'] ?? [];
            // FML compte aussi minecraft, mcp, FML et forge
            $count = count(array_filter($mods, fn (array $m) => !in_array(strtolower($m['modid'] ?? ''), ['minecraft', 'mcp', 'fml', 'forge'], true)));

            return ['Forge', $mods ? $count : null];
        }

        if (isset($data['forgeData'])) {
            $mods = $data['forgeData']['mods'] ?? [];
            $count = count(array_filter($mods, fn (array $m) => !in_array(strtolower($m['modId'] ?? ''), ['minecraft', 'forge', 'neoforge'], true)));
            $isNeo = (bool) array_filter($mods, fn (array $m) => strtolower($m['modId'] ?? '') === 'neoforge');

            return [$isNeo ? 'NeoForge' : 'Forge', $mods ? $count : null];
        }

        if (!empty($data['isModded'])) {
            return ['NeoForge', null];
        }

        return [null, null];
    }

    /** Le MOTD est soit une chaîne, soit un composant de chat JSON (text + extra récursifs). */
    private function chatToText(mixed $component): string
    {
        if (is_string($component)) {
            return $component;
        }
        if (!is_array($component)) {
            return '';
        }
        if (array_is_list($component)) {
            return implode('', array_map(fn ($c) => $this->chatToText($c), $component));
        }

        $text = (string) ($component['text'] ?? '');
        foreach ($component['extra'] ?? [] as $extra) {
            $text .= $this->chatToText($extra);
        }

        return $text;
    }

    /** Retire les codes de couleur « §x ». */
    private function stripFormatting(string $text): string
    {
        return preg_replace('/§./u', '', $text) ?? $text;
    }

    private function varInt(int $value): string
    {
        $value &= 0xFFFFFFFF;
        $out = '';
        do {
            $byte = $value & 0x7F;
            $value >>= 7;
            if ($value !== 0) {
                $byte |= 0x80;
            }
            $out .= chr($byte);
        } while ($value !== 0);

        return $out;
    }

    private function string(string $value): string
    {
        return $this->varInt(strlen($value)) . $value;
    }

    /** @param resource $socket */
    private function readVarInt($socket): int
    {
        $value = 0;
        for ($i = 0; $i < 5; ++$i) {
            $byte = ord($this->readBytes($socket, 1));
            $value |= ($byte & 0x7F) << (7 * $i);
            if (($byte & 0x80) === 0) {
                return $value;
            }
        }

        throw new \RuntimeException('VarInt trop long');
    }

    /** @param resource $socket */
    private function readBytes($socket, int $length): string
    {
        $buffer = '';
        while (strlen($buffer) < $length) {
            $chunk = fread($socket, $length - strlen($buffer));
            if ($chunk === false || $chunk === '' || stream_get_meta_data($socket)['timed_out']) {
                throw new \RuntimeException('Lecture interrompue');
            }
            $buffer .= $chunk;
        }

        return $buffer;
    }
}
