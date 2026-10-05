#!/usr/bin/env python3
"""
Régénère data/bee_breeding.json à partir des données amont du projet BeeBreeding
(https://github.com/at-l4s/BeeBreeding), utilisées par /bees.

Usage : python3 scripts/build-bee-data.py
"""
import json
import os
import re
import urllib.request

BASE = 'https://at-l4s.github.io/BeeBreeding/data/'
OUT = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), 'data', 'bee_breeding.json')

MONTHS = ['jan', 'fév', 'mar', 'avr', 'mai', 'juin', 'juil', 'aoû', 'sep', 'oct', 'nov', 'déc']


def load(name):
    """Charge un .jsonc distant (commentaires // en début de ligne)."""
    with urllib.request.urlopen(BASE + name) as resp:
        raw = resp.read().decode('utf-8')
    return json.loads(re.sub(r'^\s*//.*$', '', raw, flags=re.M))


def date(part, month_key, day_key):
    return f"{part[day_key]} {MONTHS[part[month_key] - 1]}"


def requirement_text(key, values):
    """Transforme une condition brute en libellé lisible, ou None si non pertinente."""
    if key == 'isSecret':
        return None
    if key == 'requireExplosion':
        return 'explosion requise'
    if key == 'requirePlayer':
        return 'joueur : ' + ', '.join(str(v) for v in values)
    if key == 'dateRange':
        return ' / '.join(f"{date(v, 'startMonth', 'startDay')} → {date(v, 'endMonth', 'endDay')}" for v in values)
    if key == 'runtimeConditions':
        return ' / '.join(
            f"{c.get('target', '?')} {'actif' if c.get('active') else 'inactif'}" for c in values
        )
    labels = {
        'temperature': 'temp.',
        'humidity': 'humidité',
        'biome': 'biome',
        'block': 'bloc',
        'moonPhase': 'lune',
    }
    return f"{labels.get(key, key)} : " + ', '.join(str(v) for v in values)


def main():
    bees, mutations = load('bees.jsonc'), load('mutations.jsonc')

    out_bees = {}
    for key, bee in bees.items():
        out_bees[key] = {
            'n': bee.get('name') or key.split(':')[-1],
            'm': bee.get('mod'),
            'b': (bee.get('branch') or '').split(':')[-1],
            'c': (bee.get('colors') or {}).get('primary') or '#e0b83c',
            'p': list(dict.fromkeys(
                p['item'] if isinstance(p, dict) else str(p) for p in (bee.get('products') or [])
            )),
        }

    out_mutations = []
    for mutation in mutations:
        for child, info in mutation['children'].items():
            reqs = []
            for requirement in info.get('requirements') or []:
                for key, values in requirement.items():
                    text = requirement_text(key, values if isinstance(values, list) else [values])
                    if text:
                        reqs.append({'k': key, 't': text})
            out_mutations.append({
                'a': mutation['parents'][0],
                'b': mutation['parents'][1],
                'c': child,
                'ch': info.get('chance'),
                'r': reqs,
            })

    unknown = {b for m in out_mutations for b in (m['a'], m['b'], m['c'])} - set(out_bees)
    if unknown:
        raise SystemExit(f'Abeilles référencées mais absentes du dictionnaire : {sorted(unknown)}')

    with open(OUT, 'w', encoding='utf-8') as fh:
        json.dump({'bees': out_bees, 'mutations': out_mutations}, fh, ensure_ascii=False, separators=(',', ':'))

    print(f'{len(out_bees)} abeilles, {len(out_mutations)} croisements → {OUT}')


if __name__ == '__main__':
    main()
