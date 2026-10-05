# MeatballCraft — Tips, choix d'options et choses à faire

Fichier compagnon de `GUIDE-MEATBALLCRAFT-FR.html`.

- **Le guide HTML** répond à : *« que dois-je faire pour avancer ? »* — il déroule la ligne
  obligatoire, quête par quête, chapitre par chapitre.
- **Ce fichier-ci** répond à : *« qu'est-ce que le pack me permet, et quelle est la bonne façon
  de le faire ? »* — les comparatifs, les raccourcis, les pièges, et ce qu'il faut monter à
  chaque étape.

Les deux se lisent en parallèle : les chapitres de la partie B portent les mêmes noms que ceux
du guide.

## Comment ce fichier est fabriqué

Les auteurs du pack **classent eux-mêmes les options** dans le titre de leurs quêtes —
`(The Best)`, `(Great)`, `(Good)`, `(OK)`, `(Recommended)` — et, dans les chapitres Armory,
Super-Enchanting et Tinkerer's Toolbox, ils **rangent en plus chaque objet dans un nœud
« Great » / « Good » / « OK » ET dans un nœud « Chapter N »**. Croiser les deux donne
directement : *« les meilleures armures disponibles au chapitre 4 »*.

Une **quatrième convention** existe au chapitre 6 : dans les longues listes de rituels et de
fleurs, 34 entrées portent `(Useful)` — c'est le tri déjà fait pour toi (voir A27).

Ce n'est donc pas mon avis, c'est celui du pack — et il est fiable, parce qu'il tient compte du
lag et de l'automatisation, pas seulement des chiffres bruts.

Quand une affirmation vient d'ailleurs (config d'un mod, script CraftTweaker, code d'un jar),
la source est citée. Tout ce qui est écrit ici a été vérifié dans les fichiers de l'instance.
La méthode de fouille est documentée dans `CLAUDE.md`.

Convention de ce fichier :
> 🏆 le meilleur · ⭐ très bon · ✅ bon · 🔸 correct sans plus · ⚠️ piège · 💡 raccourci

---

# Partie A — Les fiches « la meilleure façon de… »

## A1. Produire du RF

Le questbook consacre une ligne entière au sujet (`Quests/2/`, *Energy Sources*, racine `50147`
« Moh Powah Bebeh ») et **range les générateurs par chapitre de progression** : `50148` Chapter 1
Sources, `50177` Chapter 2, `50176` Chapter 3, `50184` Chapter 4, `50178` Chapter 5, `50179`
Chapter 6, `50180` Chapter 7, `50182` Chapter 9. **Il n'existe pas de « Chapter 8 Sources »** :
le chapitre 8 n'apporte aucune source d'énergie nouvelle.

### Début de partie (chapitre 1)

Les dynamos Thermal dominent — six d'entre elles sont notées Great :

| Générateur | Note | Ce qu'il consomme |
|---|---|---|
| ⭐ Steam Dynamo | Great | combustible solide + eau (eau automatisable à l'Aqueous Accumulator) |
| ⭐ Magmatic Dynamo | Great | lave — pompe dans le Nether au début, source infinie ensuite |
| ⭐ Compression Dynamo | Great | fluides variés — **plus le fluide demande d'étapes, plus il rapporte** |
| ⭐ Numismatic Dynamo | Great | des pièces de monnaie (oui, vraiment) |
| ⭐ Enervation Dynamo | Great | objets chargés en énergie, redstone en tête |
| ⭐ Reactant Dynamo | Great | une combinaison fluide + item |
| ✅ Diesel Generator | Good | ~4096 RF/t, multiblock IE — voir A21 |
| ✅ Thermoelectric Generator | Good | eau et lave sur faces opposées ; optimal à 2 eau + 2 lave, extraction sur une face restante |
| 🔸 Bio Reactor, Biofuel, Protein, Peat, Leaf-Eating, Zombie, Decay | OK | culs-de-sac : à faire pour la quête, pas pour la base |

💡 Le pack précise que **toutes les dynamos peuvent être converties en vapeur** (`50207` Boiler
Conversion, ✅) et que cette vapeur alimente ensuite les Extreme Turbines : les dynamos du début
ne sont donc pas jetables, elles se recyclent en fin de partie.

### Chapitre 2

| Générateur | Note | Détail |
|---|---|---|
| ⭐ Solar Array Controller | Great | **le vrai saut** — multiblock solaire, voir le tableau ci-dessous |
| ⭐ Compression Engine | Great | « dynamo surdimensionnée », accepte un mélange de carburants de dynamos |
| ⭐ Water Mill / Numbered Spectre Coil | Great | passif, lent mais pratique |
| ✅ Solar Panel, Wind Mill, Dragon Egg Energy Syphon, Empowered Monolith | Good | l'Empowered Monolith consomme des structures eldritch ; les Tartarite Monoliths sont renouvelables |
| 🔸 cellules photovoltaïques et panneaux solaires à tiers | OK | échelle linéaire, sans intérêt face aux arrays |

**Solar Arrays — RF/t par tier de contrôleur et par cellule** (chiffres donnés par les quêtes
`50187`, `50199`–`50203`) :

| Tier | Litherite | Erodium | Kyronite | Pladium | Ionite | Aethium |
|---|---|---|---|---|---|---|
| 1 | 549 | 729 | 1 098 | 1 152 | 1 152 | 1 152 |
| 2 | 3 050 | 4 075 | 6 125 | 8 175 | 12 275 | 12 800 |
| 3 | 12 005 | 16 023 | 24 059 | 32 095 | 48 167 | 64 190 |
| 4 | 39 771 | 53 055 | 79 623 | 106 110 | 159 246 | 212 301 |
| 5 | 118 943 | 158 510 | 237 886 | 317 141 | 475 772 | 634 282 |
| 6 | 332 254 | 442 949 | 664 508 | 885 898 | 1 329 016 | 1 771 965 |

⚠️ Aux tiers 1 et 2, Pladium/Ionite/Aethium ne se distinguent presque pas : ne gaspille pas les
matériaux rares avant le tier 3, où l'écart se creuse vraiment.

🔴 **Ce qui gouverne réellement ta montée en Solar Arrays, ce sont les Void Resource Miners** :
le minerai de Litherite est **désactivé** dans ce pack, et chaque tier de Void Miner débloque
exactement la cellule du palier suivant — T1 = Litherite et Erodium, T2 = Kyronite, T3 = Pladium,
T4 = Ionite, T5 = Aethium (A15). Les tables Extended Crafting ne sont que la deuxième contrainte
(A26).

### Chapitre 3

| Générateur | Note | Détail |
|---|---|---|
| ⭐ Nuclear Fission | Great | NuclearCraft. Le pack recommande **leu-235.com** pour concevoir le réacteur, et cite un design d'Uchiwars (imgur.com/gallery/vzBd16k) |
| ⭐ Token Totem | Great | démarre faiblement, mais **« un totem qui consomme tous les tokens est la 3ᵉ meilleure source d'énergie du pack »** |
| ✅ Yellorite Reactor | Good, ⭐ avec Extreme Turbine | Big Reactors : cuboïde creux, colonnes de barres, refroidissement dans le vide restant |
| ✅ Turbine Controller | Good | convertit le réacteur yellorite en producteur de vapeur → turbine |
| ✅ Endergenic Generator | Good, **mais laggy** | patate chaude entre générateurs, timing redstone |

### Chapitre 4

| Générateur | Note |
|---|---|
| ⭐ Magnetic Confinement Fusion Reactor | Great — fusion de gaz, symétrie centrale obligatoire autour du contrôleur |
| ⭐ Extreme Pressure Turbine | Great — la **boucle promethium** : silver + neutron fluid en boucle infinie avec un solid-state reactor. Plus le réacteur est gros, plus la boucle rend |
| ✅ Lightning Controller T1→T6 | Good — chaîne de six quêtes |
| 🔸 les 15 « générateurs Extra Utilities » | OK — Culinary, Death, Disenchantment, Ender, Explosive, Frosty, Furnace, Halitosis, Heated Redstone, Magmatic, Netherstar, Overclocked, Pink, Potion, Slimey, Survival |

⚠️ Ces générateurs Extra Utilities sont **tous** notés OK. Ils sont amusants et peu chers, mais
c'est un piège à temps : à ce stade la fusion et la boucle promethium sont sur la table.

### Chapitres 5 à 9

| Chapitre | Générateur | Note |
|---|---|---|
| 5 | ✅ Arc Reactor | passif, produit aussi de l'Arc Residue |
| 5 | 🔸 Salt Reactor | OK, mais **la quête `50275` est le plus long tutoriel du questbook** — à lire en entier avant de poser un bloc |
| 6 | ✅ Draconic Reactor | ⚠️ si le cœur devient plus fort que le champ de force, explosion « vraiment grosse » |
| 6 | ✅ Creative Solar Array | |
| 7 | ⭐ Rainbow Generator! | un exemplaire posé autour de chacun des **16 générateurs** en fonctionnement = énormément de RF |
| 9 | ⭐ Dyson Sphere | « un générateur créatif avec des étapes en plus » — une seule sphère alimente un très grand nombre de Dischargers |
| 9 | ⭐ Energy Queen | |

## A2. Transporter et stocker l'énergie

Quêtes de référence : `Quests/4/90300.json` (Energy Management) et `90103` (Energy Storage).

| Besoin | Choix | Pourquoi |
|---|---|---|
| 🏆 Réseau de base entier | **Flux Networks** (`90278`, ⭐) | « la méthode de transfert d'énergie **préférée du pack** ». À utiliser **dès le chapitre 2** (`1172`) |
| Facile et léger | Fluxducts | simples à craft, bons pour le lag |
| Compact / multi-usage | Conduits EnderIO | partagent l'espace de bloc avec les autres conduits |
| Base de fin de partie | Lasers Draconic Evolution | les meilleurs en performance à grande échelle |
| ⚠️ À abandonner vite | LV Wires (Immersive Engineering) | « jolis et pas chers, mais **déconseillés au-delà du chapitre 1** » (`90294`) |

**Architecture recommandée par le pack** (`90278`) — à appliquer telle quelle :
1. **Deux réseaux Flux distincts** : un des générateurs vers le stockage central, un du stockage
   vers les machines.
2. Toujours inclure du **Flux Storage** dans un réseau qui transporte beaucoup de RF/t, sinon
   coupures d'énergie.
3. ⚠️ **Limiter le nombre de Flux Plugs** : trop de plugs = lag. Pour alimenter un mur de
   machines, un **seul** Flux Point puis des conduits classiques.

⚠️ **Le Flux Core est passé sur la table Advanced 5×5** (A26). Le pack te demande d'utiliser les
Flux Networks dès le chapitre 2, mais concrètement **il faut d'abord la table Advanced** : prévois
la chaîne Extended Crafting avant de compter sur le sans-fil.

**Stockage** (`90103`) : 🏆 **le Draconic Energy Orb est le meilleur choix long terme, et il est
craftable dès le chapitre 2** — tous les tiers sauf le dernier (`90100`). En attendant, des piles
de Vibrant Capacitor Banks font l'affaire (tiers 2-3 en table Advanced 5×5).

## A3. Transporter les items

Quête de référence : `Quests/4/90240.json` (Item Management).

| Besoin | Choix | Pourquoi |
|---|---|---|
| 🏆 Automatisation générale | **Xnet** (`90095`) | « la façon recommandée de gérer les automatisations passives », **plus performant que les conduits EnderIO** pour les items |
| Compact, multi-types | Item Conduit EnderIO (`90237`) | 16 canaux de couleur, même espace de bloc |
| 1 entrée → 1 sortie | Itemduct (`90238`) | bon en perf, **se dégrade à chaque connexion ajoutée** |
| Vitesse brute | Tesslocator (`90234`), Transfer Nodes (`1178`) | les plus rapides, mais laggy |
| Sans fil | Ender Chest (`90239`) | canal défini par 3 teintures sur le couvercle |
| Très courte distance | Item Laser Relay (`90235`) | |
| ⚠️ À éviter | Pipes BuildCraft (`1136`/`1137`) | « quite unoptimized, so they are discouraged ». Obligatoires uniquement dans Vethea (chapitre 7) |

**Xnet, les règles à ne pas rater** (`90110`) :
- ⚠️ **Ne jamais alimenter le controller avec un connector Xnet** — ça crée du lag. Source
  externe obligatoire (un Flux Point est parfait).
- 8 canaux simultanés par setup : items, énergie, logique redstone, RFTools.
- ⚠️ **Le canal fluide est buggé** — pour les fluides, rester sur les conduits EnderIO.
- Câbles et connectors teintables pour faire cohabiter plusieurs réseaux.

**Itemducts** (`90249`) : ce sont les **servos, filtres et retrievers** qui déplacent les items.
Clic droit sur la jonction duct/inventaire pour les poser, **Crescent Hammer** pour les retirer.
Servo = extraire et pousser · Retriever = tirer depuis un inventaire distant · Filtre = trier.
Paliers : Hardened → Reinforced → Signalum → Resonant.

💡 Les Transfer Nodes deviennent **beaucoup plus laggy dès qu'il y a plus d'une sortie**, et le
pack dit explicitement de **ne pas y mettre de filtres**.

## A4. Transporter les fluides

Quête de référence : `Quests/4/90228.json` (Fluid Management).

| Besoin | Choix |
|---|---|
| 🏆 Polyvalence | **Ender Fluid Conduits EnderIO** — partagent l'espace de bloc |
| Performance | Fluiducts |
| Vitesse | Lasers — le transfert de fluide le plus rapide |
| Sans fil | Ender Tank |

⚠️ Rappel : **Xnet ne fait pas les fluides**. C'est le seul domaine où EnderIO reste devant Xnet.

## A5. Crafting automatique

Quête de référence : `Quests/4/90342.json`. Cinq quêtes portent l'étiquette `(Recommended)` —
c'est le seul domaine du pack qui l'utilise autant.

| Choix | Pourquoi |
|---|---|
| 🏆 **Sequential Fabricator** (`1140`) | **le meilleur pour les performances** |
| ⭐ **RFTools Crafter** T1/T2/T3 (`90347`/`90346`/`90345`) | **le plus rapide**. 💡 Astuce du pack : **mettre la même recette dans plusieurs slots** pour aller encore plus vite |
| ⭐ **AE2 Autocrafter** (`771148777`) | comme les deux précédents, mais **auto-pull et auto-push directement dans le réseau ME** |
| ✅ Mechanical Crafter (`90337`) | |

💡 Critère de choix : si la machine est **dans** un réseau ME, prendre l'AE2 Autocrafter (zéro
logistique à câbler). Sinon, Sequential Fabricator pour du volume permanent, RFTools Crafter
quand la vitesse prime.

## A6. Stocker

| Besoin | Choix | Source |
|---|---|---|
| Début de partie | 🏆 **Crates** | `90056` : « the best storage option early game are crates! » |
| Gros volumes | **Danks + murs de drawers**, branchés sur des Storage Bus AE2 | `90056` |
| Objets non empilables | **Filing Cabinets** et **Junk Storage Units** | `90056` |
| Livres enchantés | **Ender Library** | `90056` |
| Fluides, accessibilité | **Fluid Drawers** | `90085` |
| Fluides, gros volumes | 🏆 **Black Hole Tanks** | `90085` |
| Fluides, début de partie | **Drums** | `90085` |
| Énergie | voir A2 | `90103` |

**Base management** (`90130`) : AE2 gère à lui seul le stockage, le crafting auto et une bonne
partie des automatisations passives. Le pack prévient : *« attends-toi à construire un énorme
réseau AE2, et probablement une tonne de petits en plus »*.

## A7. Cultures, graines et accélération

Section : `Quests/5/1437` (All Things Agriculture!) → `20421` r/notjusttrees (récolte) et
`20422` A Green Revolution (croissance).

### Accélérer la croissance — le classement du pack

| Note | Méthode |
|---|---|
| 🏆 **The Best** | **Torcherino** (`20463`) — seule quête du pack à porter cette étiquette. ⚠️ **Mais le pack a supprimé 63 recettes du mod** : seul le niveau 1 subsiste, sur table Advanced 5×5, derrière Astral Sorcery + Career Bees + Blood Magic. **Ce n'est pas une option de début de partie — voir A26** |
| ⭐ Great | Hydrator (Industrial Foregoing, `1346`) · Lilypad of Fertility (Reliquary, `20467`) |
| ✅ Good | Growth Accelerator (Mystical Agriculture, `20456`) · Aevitas (Astral Sorcery, `20452`) |
| 🔸 OK | Agricraft Sprinklers · Sprinkler · Lamp of Growth · Harvest Moon (Blood Magic) · Greenhouse Glass · Watering Can |

### Récolter

| Choix | Verdict |
|---|---|
| 🏆 **Plant Gatherer + Plant Sower** (`20514`) | Le pack a **modifié le Plant Gatherer pour qu'il fonctionne avec les crop sticks AgriCraft** — « the preferred way of gathering resources from crop sticks » |
| ✅ Farming Station (EnderIO, `20519`) | cher mais très polyvalent (cultures **et** arbres) |
| ✅ Farm Block Forestry (`20513`) | gros rendement ; surtout utile pour le **peat**. Circuit Emerald Electron Tube pour les crop sticks, Obsidian pour le peat |
| 🔸 Phytogenic Insolator (`20520`) | ferme en un bloc, exige un fertilisant |
| 🔸 Plant Interactor (`20516`) | « ce n'est pas la meilleure option, mais c'en est une » |

💡 **Layout optimal donné par le pack** : des lots de **3×3 avec 8 cultures**, un gatherer par
lot. C'est calibré pour la vitesse des accélérateurs du pack.

### Améliorer les graines (AgriCraft)

3 stats (Growth / Gain / Strength), de 1 à 10, tout démarre en 1/1/1. Seules les plantes **sur
crop sticks** peuvent être améliorées (`20465`).

Config réelle (`config/agricraft/config.cfg`) :
- `Crop Stat Cap = 10`, `Mutation Chance = 0.2`, `Crop Stat Divisor = 2` (une mutation **divise
  les stats par 2**)
- ⚠️ `Single spread stat increase = false` → **un seul parent ne fera jamais monter les stats**
- ⚠️ `Non parent crops affect stats negatively = true` → une culture étrangère adjacente **tire
  les stats vers le bas**. Garder les lots homogènes
- `Fertilizer Mutations = false` → pas de forçage à l'engrais

💡 Le pack signale qu'**Integrated Dynamics peut automatiser** la montée en 10/10/10.

⚠️ **Piège majeur** : sur crop sticks, les plantes Mystical Agriculture acceptent `farmland`,
`fertilized dirt` (Random Things), `loamy` et `silty dirt` — **l'Essence Farmland de Mystical
Agriculture n'est pas un sol AgriCraft valide**.

Rendement : chaque plante MA donne **1 à 5 essences à 90 %** — c'est la stat **Gain** qui fait
tout le travail.

## A8. Mana Botania — les fleurs génératrices

Section `Quests/6/787`. Règle donnée par le pack : **plus une fleur est difficile à automatiser,
plus elle produit**. La première à faire est l'**Endoflame**.

| Note | Fleurs |
|---|---|
| ⭐ Great | Spectrolus · Omniviolet · Dandelifeon · Kekimurus · Munchdew |
| ✅ Good | Endoflame · Shulk Me Not · Reikar Lily · Entropinnyum · Rosa Arcana · Rafflowsia · Narslimmus · Bloody Enchantress · Thermalily · Gourmaryllis · Beegonia |
| 🔸 OK | Stonesia · Moonlight Lily · Hydroangeas · Bell Flower · Edelweiss · Gemini Orchid · Tinkle Flower · Sunshine Lily |

⚠️ Toutes doivent être **liées à un mana spreader**. Voir aussi `788` « Useful Flora » (32 fleurs
fonctionnelles).

## A9. Mob farms et data models

Section `Quests/5/20420` (Spawning Szn). Ordre de progression donné par la description JEI du
Mob Crusher (`scripts/JEIdescriptions.zs:687`) :

> **Industrial Foregoing → Woot → Deep Mob Learning → Ultimate Mob Farm**

- Démarrage : une **Drop of Evil** sur de la terre crée de la **Cursed Earth**, qui se propage
  comme l'herbe et fait exploser les spawns hostiles. **Y = 2 est le meilleur endroit**.
- Le **Mob Crusher** est la façon la plus pratique de tuer ; les **Range Addons** couvrent toute
  la parcelle.
- L'**essence** produite alimente ensuite les **Mob Duplicators**.

**Data models Deep Mob Learning** (`Quests/5/1401`, 30 modèles classés) :
- ⭐ **Great** — à prioriser : Wither · Ender Dragon · Twilight Forest · Twilight Swamp ·
  Twilight Glacier · Twilight Darkwood · Blue Slime · Thermal Elementals · Ayeraco ·
  Nethengeic Wither · BamBamBam · Smash · Corallus
- 🔸 **OK** — seulement si le drop t'intéresse : Zombie · Creeper · Witch · Shulker

**Modèles de boss de milieu de partie** (`1777`, 22 modèles, tous ✅ Good) : Baroness, Clunkhead,
Cotton Candor, Crystocore, Dracyon, Elusive, Graw, Gyro, Haven Guardians, Hive King, Hydrolisk,
Kror, Mechbot, Rockrider, Shadow Lord, Silverfoot, Skeletron, Tyrosaur, Vinocorne, Visualent,
Voxxulon, C.R.E.E.P.

Voir aussi `Quests/5/1400` « Let's Woot! » : les bons drops à farmer en Woot, réutilisables plus
tard pour les Ultimate Mob Farms.

## A10. Poules (Hatchery / Roost)

Section `Quests/5/20424` (Eggscellent). **Tous les œufs de spawn cités sont craftables** — mais
l'élevage est souvent plus pratique.

| Machine | Quand | Détail |
|---|---|---|
| **Nesting Pen** (`20425`) | début | 💡 **Pour croiser deux espèces, place deux nesting pens face à face.** Le Net sert à y mettre les poules |
| **Henhouse** (`20426`) | début | avec du foin, ramasse les drops dans un rayon |
| **Roost** (`20427`) | **chapitre 4** | les poules deviennent des items avec des stats Gain / Strength / Growth. Le Catcher les capture |
| 🏆 **Mechanized Coop** (`20416`) | plus tard | produit les drops **directement depuis les œufs de spawn**, scalable et upgradable |

Il existe aussi cinq chaînes « Mythic Shell Chickens » (`1540`, `1558`–`1561`) pour les
ressources mythiques.

## A11. Abeilles

Section `Quests/5/20417` (Apian Genetics) → `1002` « How do bees work?!? ». Le pack reconnaît que
Forestry est intimidant et prend le sujet depuis le début : **la première chose à faire est un
Scoop**, pour récolter les ruches trouvées un peu partout dans l'univers.

Voir aussi `Quests/5/1006` « Bee upgrades (Advanced) » — les addons Forestry pour de meilleures
abeilles, à aborder **après** avoir compris la reproduction et la production de base.

💡 Deux abeilles utiles citées ailleurs : celle qui donne la **Condensed Essence** (XP, dispo au
chapitre 3) et la **taxcollector bee**, nécessaire pour farmer Karot au chapitre 9.

## A12. Farmer l'XP

Section `Quests/5/339187524` (All of the Experience).

| Méthode | Quand | Détail |
|---|---|---|
| **Solidified Experience** (`20437`) | début | forme stackable de l'XP, droppée par la plupart des mobs. **N'importe quelle farm sur Cursed Earth en produit** |
| **Data Models** | chapitres 2-3 | « a good way to farm lots of XP » |
| **Condensed Essence** (`795857967`) | chapitre 3 | version améliorée, via une abeille |
| **Infernal Tear** (`1799610165`) | | consomme charbon/fer/lapis/or/diamant de l'inventaire pour générer de l'XP. Shift + clic droit pour l'activer, re-shift pour le lier |
| **Emeralds to XP** (`20498`) | | avec un Tome of Arcana, émeraude → bouteilles d'XP |
| ⭐ **Experience Bath** (`422193634`) | plus tard | multiblock qui **applique automatiquement des niveaux au joueur qui se tient dedans**. 💡 Le pack précise que **certains combats de fin de partie sont conçus autour de Last Stand** — ce bloc évite d'avoir à spammer le clic droit |

## A13. Enchanter

Section `Quests/5/2312` (Enchant Me!), en quatre branches.

**Créer** (`2314`) :
| Choix | Note |
|---|---|
| ⭐ **Altar of Corruption** (`2317`) | Great — **fait des enchantements niveau 30 sans aucun boost** |
| ⭐ **EnderIO Enchanter** (`2330`) | Great — permet de **crafter un livre enchanté précis** |
| ✅ Enchanting Table (`2316`) | la table vanilla ; les options pour monter au niveau 30 sont listées dans la quête |
| ✅ Cyclic Enchanter (`2318`) | tourne à l'XP liquide + énergie |

**Retirer** (`2313`) : Enchantment Extractor (Industrial Foregoing) · Book of Disenchantment ·
Draconic Disenchanter (💡 son coût en XP est **réduit par les bibliothèques**, comme la table
vanilla).

**Dupliquer** (`2315`) : **Bibliocraft** — Typesetting Table + Printing Press.
⚠️ **Il faut porter un Monocle**, sinon les coûts en XP sont invisibles.

**Appliquer** (`2325`) :
- ⭐ **Enchantment Applicator** (`2326`) — « comme une enclume, mais **sans limite de niveau
  d'enchantement** »
- ⭐ **Mana Enchanter** (Botania, `2328`) — applique les enchantements **sans consommer les
  livres**. Structure à former, puis clic droit sur le bloc de lapis avec la Wand of the Forest,
  objet **totalement non enchanté** sur l'enchanteur, livres jetés autour
- ✅ Anvil (`2327`)

## A14. EMC et ProjectE

Section `Quests/5/20418` (Alchemical Brothers) — la voie « ressources infinies par l'alchimie ».

- **Power Flower MK1** (`20500`) : trois briques — **Collectors** (génèrent de l'EMC à partir de
  la lumière ; 💡 **la glowstone est la meilleure source, et plus il y a de blocs de glowstone
  autour d'un collector, plus c'est rapide**), **Relays** (batteries d'EMC), et le condenser.
- **Émeraudes** (`1202`) : forte valeur EMC, farmables via **poules à émeraude** (autour des
  structures à blocs d'argent Bewitchment) et **evokers** — 💡 *« Battle Towers are your
  friend :) »*.
- **Botanic-Alchemic Catalyst** (`20503`) : item EMC de valeur, farmable au botanic condenser ou
  à l'**EMBee**.
- **Boucles EMC** (`20505`) : exploitent les recettes dont la sortie vaut plus que la somme des
  entrées. ⚠️ **Les boucles voulues par le pack sont celles à base de Dragon Hearts** — les
  auteurs demandent de leur signaler toute autre boucle trouvée. Exemple donné : 4 blaze rods =
  6 144 EMC, un diamant = 8 192.
- **Personal EMC Link** (`20509`) : entrées/sorties d'EMC vers ton réseau personnel (la tablette
  de transmutation).
- **Tome of Alkahestry** (`20499`) : globalement inférieur à la pierre philosophale, **mais il
  duplique les nether stars**. Se recharge en craft informe avec de la redstone.

## A15. Minage et ressources passives

Section `Quests/5/20423` (We go diggin').

| Machine | Ce qu'elle fait |
|---|---|
| ⭐ **Excavator** (`2230`) | quantités **infinies de minerais** depuis les veines Immersive Engineering. ⚠️ Ces veines **n'existent pas dans le monde** : une par chunk, à identifier au **Core Sample Drill** |
| ⭐ **Pumpjack** (`2231`) | même principe pour les **fluides infinis** |
| ✅ **Builder + quarry card** (`20471`) | excave de grandes régions et collecte tout. 💡 **Poser un inventaire sur le dessus du Builder pour récupérer les drops** |
| ✅ **Igneous Extruder** (`20473`) | roches passives à partir d'eau + lave ; des upgrades réduisent la consommation |
| 🏆 **Void Resource Miner** (`20474`) | ressources aléatoires. La quête dit « son intérêt principal est la mica » — ⚠️ **c'est très en dessous de la réalité**, voir juste en dessous |
| ✅ **Glacial Precipitator** (`20470`) | tout ce qui touche à la glace, à partir d'eau |

### 🔴 Le Void Resource Miner est bien plus important que la quête ne le dit

Contenu réel de `config/environmentaltech/multiblocks/void_miner/ore/tier_N.json` :

| Tier | Ce qu'il produit **en plus** du tier précédent |
|---|---|
| **1** | **Litherite** et **Erodium** · Lonsdaleite · **minerai de Draconium** · Dimensional Shard ore · Resonating ore (Deep Resonance) · minerai Astral Sorcery · **les 7 cristaux Thaumcraft** (aer, aqua, ignis, terra, ordo, perditio, vitium) |
| **2** | **Kyronite** |
| **3** | **Pladium** |
| **4** | **Ionite** |
| **5** | **Aethium** |

💡 Deux conséquences majeures :
- C'est **la seule source praticable des cristaux Environmental Tech**, dont le minerai est
  désactivé dans ce pack. Chaque tier de Void Miner débloque exactement la cellule solaire du
  palier suivant (A1) — **la montée en Solar Arrays est donc gouvernée par la montée en Void
  Miners**, pas par les tables de craft.
- C'est aussi une source passive de **cristaux Thaumcraft**, de **draconium** et de **shards
  dimensionnels** — trois ressources autrement pénibles à farmer.

⚠️ La quête `20474` dit que « monter les tiers n'est pas urgent avant la fin de partie ». C'est
faux dès que tu vises les Solar Arrays.

💡 **Ore Duplication** (`20466`) : les essences Stone et Nether créent des minerais aux propriétés
mythiques. Un minéral → un minerai ; un minerai → **plusieurs** minéraux, surtout avec un
Industrial Grinder. **La boucle est exponentielle** tant que tu as l'essence. Fonctionne avec
Rupee, Arlemite, Realmite, Rosite, Limonite, Netherite, Bloodgem, Emberstone, Runium, et les
Ascended Jade / Sapphire / Amethyst.

⚠️ La chaîne `1570` « Misc Resources » peut être **ignorée jusqu'au chapitre 3**.

## A16. Dimensions RFTools sur mesure

Section `Quests/5/1031147864` (Custom Dimensions).

- On part d'un **Empty Dimension Tab** (`1430343507`). ⚠️ Seul, il crée des dimensions
  **aléatoires** — jolies mais souvent inutiles.
- Les **Dimlets** (`1403757701`) contrôlent les propriétés. Ils se trouvent en loot dans
  certaines dimensions RFTools, ou se craftent au **Dimlet Workbench** avec les matériaux des
  **Dimlet Parcels** (`1596066184`).

⚠️ **C'est du contenu de fin de partie dans ce pack** : le Dimension Builder et le Dimlet
Workbench demandent la table Extended Crafting **Ultimate 9×9** (voir A26).

## A17. Armures — les meilleures par chapitre

Le chapitre 12 *Armory* classe chaque armure **deux fois** : par chapitre de disponibilité et par
qualité. Croisement du nœud « Great » (`1592`) avec les nœuds de chapitre :

| Chapitre | Armures ⭐ Great |
|---|---|
| 1 | Bedrock · Fire Dragonsteel · Ice Dragonsteel · Emeradic · Supremium · Crystallized Obsidian · Corrupted · Elite Realmite · Lightning Dragonsteel |
| 2 | Mithminite · Mantle of Stars · Ender · Bloodmaster · Pleiades Combat Maid · Adaminite · Red Matter · Void Fortress · Champion Token · Fluxed Electrum · Pale Ore |
| 3 | Gem · Black Metal |
| 4 | Stellar · Sideral Damascus Steel · Elite Eden |
| 5 | Sacrifice Metal · EZ Pale Metal · Elite Wildwood |
| 6 | Draconic · Wyvern · Elite Apalachia · Ascended Draconic Alloy |
| 7 | Elite Skythern |
| 8 | Elite Mortum · Ichorium |
| Vethea | Tormented · Fiery |

### Les `(Good)` — liste de repli complète

Utile quand le `(Great)` du chapitre est trop maigre ou hors de portée. Le questbook les affiche
aussi en jeu ; c'est ici pour la recherche texte.

| Ch. | Armures `(Good)` |
|---|---|
| 1 | Emerald · Diamatine · Platinum · Diamond · Ruby · Sapphire · Peridot · Superium · Cyclic Emerald · Molten · Famine · Bee · Abyssalnite · Void · Jack O'Man · Rupee · Colored Rupee · Wither Reaper · Shadow · Terran · Sentient Meatball · Utopian · Nethengeic · Lyndamyte · Infernal · Sky Obsidian · **et 10 armures de dragon** (Bronze, Red, Emerald, Silver, Sapphire, White, Blue, Gray, Electric Blue, Amethyst, Copper, Black) |
| 2 | Dreadium · Dreadium Samurai · Refined Coralium · Plated Coralium · Dreaded Abyssalnite · Boron Nitride · Depths · Ethaxium · Living · Terrasteel · Shadow Warrior · Rhino Plate · Reinforced Exoskeleton · Erebus Jade · Dark · Void Thaumaturge · Tarantula Shirt · Dark Matter · Neptune · Phoenix · Gravitite · Knightly · Steeleaf · Fiery · Valkyrie · Valonite · Ancient · Divine · Korma · Explosive · **et les 8 Battlemage** (Ice, Necromancer, Sauceror, Healer, Earth, Storm, Pyromancer, générique) |
| 3 | Osiris · Ptah · Hator · Europa · Oi · Falacer · Orcus · Haumea · Sedna · Angelic — 💡 les armures des planètes du système de Terra, cohérent avec le chapitre « L'espace » |
| 4 | Anima · Alchemy · Phasing Alloy · Wrought Plate · Vibranium · Wither · Augury · Baron · Battleborn · Creation · Embrodium · Foraging · Extraction · Expedition · Exoplate · Engineering · Hauling · Hunter · Infusion · Innervation · Logging · Runation · Predatious · Omni · Mercurial · Rockbone · Skeletal · Weaken |
| 5 | Crystallis · Lyonic · Fungal · Hydrangic · Alacrity · Phantasm · Sharpshot · Rosidian · Poison |
| 6 | Brightsteel · Commander · Elecanyte · Purity · Lunar · Hydroplate · Runic · Spaceking · Speed · Zargonite |
| 7 | Ghastly · Skythern · Ghoulish · Archaic · Necro · Nightmare · Primordial |
| 8 | Halite · Mortum · Awakened Halite · Knight |

⚠️ **Tinker's Construct est `(OK)` pour l'armure** : le pack recommande de partir sur autre chose
**dès le chapitre 2** (`Quests/13/1036`). Pour les **outils** en revanche, Tinkers reste le
conseil de départ.

Le chapitre 12 contient aussi 41 armures **Cosmetic** et 39 **Utility** — à ne pas confondre avec
les armures de combat. Les pièces Utility (`1683`) sont celles qu'on porte pour une fonction
précise :

| Fonction | Pièces |
|---|---|
| Survie hostile | Hazmat Suit · Hazmat · Radiation-Absorbing · Faraday · Space Suit · Earplugs · Face Mask |
| Déplacement | Glider · Jump Boots · Hover Boots · Sprint Leggings · Water Walking Boots · Obsidian Water Walking Boots · Lava Waders · Water Striders · Marsh Runner · Super Lubricent Boots · Sentry Boots |
| Vision / information | Goggles of Revealing · Compound Goggles · Night Vision Goggles · Vision Helmet · Spectacles · Trackman Goggles · Blindfold |
| Métier | Apiarist (abeilles) · Thaumaturge · Manaweave · Magic Hood · Blood Letter's Pack · Mush Helm |
| Divers | Crown of Rule · Coat of Arms · Starry Idol · Swine · Achelos · Oceanus · Sealord |

💡 **Protection contre les radiations** (`Quests/1/1758`) : du **shielding** s'ajoute à n'importe
quelle armure. Indispensable dès que tu touches au nucléaire.

## A18. Matériaux Tinkers — les meilleurs par chapitre

Même croisement, chapitre 13 *Tinkerer's Toolbox*, nœud « Great » (`184608226`) :

| Chapitre | Matériaux ⭐ Great |
|---|---|
| 1 | Weezer · Vibrant Alloy · Manyullum · Rupee · Netherite · Dragon Bone · Fire/Ice Dragonsteel · Reinforced Pink Slime · Platinum · Iridium · Nickel · Red Matter · Fluxed Electrum · Refined Iron · Titanium · Advanced Alloy · Amethyst · Lumium · Enderium · Emeradic · Diamatine · Demonic Ember · Hard Bone |
| 2 (magiques) | Bloodmaster · Shadowium · Orichalcos · Supremium · Terrasteel · Gaia Spirit · Ludicrite · Pladium · Ionite · Aethium · Mirion · Wyvern · Aesir Wood |
| 4 (exotiques) | Kaiyu · Wrought Iron · Phasing Alloy · Vibranium · Vibranium Alloy · Awakened · Chaotic · Barathosynium · Abyssal Flesh |
| 5 | Rosidian · Adamantium · Dragonslayer Steel · Endlessly Hungry · Infused Dread |
| 6 | Brightsteel Alloy · Neutronium · Runandium · Ascended Draconic Alloy |
| 8 | Parafrosynium · Hihi'Irokane · Orichalcum · Crystalline Ichorium |

Les `(Good)`, en repli :

| Ch. | Matériaux `(Good)` |
|---|---|
| 1 | Iron · Steel · Bronze · Invar · Silver · Mithril · Cobalt · Ardite · Alumite · Pig Iron · Knightslime · Obsidian · Cactus · Paper · Sponge · Prismarine · Emerald · Ruby · Sapphire · Peridot · Topaz · Tanzanite · Ascended Sapphire · Enori · Palis · Fluix Crystal · Bloodwood · Fusewood · Energetic Alloy · Conductive Iron · Dark Steel · Tough Alloy · Hard Carbon · Plastic · Pink Slime · Dark Matter · Abyssalnite · Refined Coralium · Emberstone · Limonite · Rosite · Realmite · Arlemite · Demonic Metal · Molten Meat · Vespa Carapace · Scythe Claw · Intermedium · Superium · Charger |
| 2 | End Steel · Steeleaf · Fiery · Knightmetal · Manasteel · Elementium · Livingwood · Blood Infused Iron · Evil Infused Iron · Boron Nitride · Tungsten · Chrome · Yellow Garnet · Red Garnet · Jade · Erodium · Kyronite · Starmetal |
| 4 | Baronyte · Blazium · Skeletal · Varsium |
| 5 | Lyon · Mystite |
| 6 | Elecanium · Lunar |
| 8 | Shyrestone |

💡 **La plupart des patterns Tinkers sont craftables dès le chapitre 2** (`Quests/13/1035`), à
l'exception des pièces de laser gun. La liste complète des traits est en A29.

## A19. Super-Enchanting — les armes qui valent le détour

Chapitre 11. Même croisement, nœud « Great » (`995`) × nœuds de chapitre. 53 objets sont notés
Great, 40 Good, 12 OK, 5 Flavor.

| Chapitre | Armes/armures ⭐ Great |
|---|---|
| 2 | Scaramanga Gadget · Suit of the Fallen Legion · Combat Maid · Durandal · Mirkwood Bow · Thunderfury · Mantle of Stars · Thorns of Villany · Bloodmaster Armor · Arcanium Blade · Blade of Terra |
| 3 | The Crucible · War · Brave |
| 4 | Claiomh Solais · Helltree · Stellar Armor · Athens Cannon · Gungnir · Stinger Samurai Helm · Brisingr · Zar'Roc · K-Room |
| 5 | Eurobeat Bow · Niernen · Radiation-Absorbing Armor · Disruptor · Nightblood · Mithminite · Dragon Slayer · Sword of Shannara · Sacrifice Metal Armor |
| 6 | 千年ロッド · Prison Realm Bow · Fishing Sticc · Caliburn · Oathbringer |
| 9 | Dyrnwyn · Tater Smasher · Heathland Bow · Gandiva · The Shieldbreaker · Lurtz Bow |

Les `(Good)`, en repli :

| Ch. | Armes `(Good)` |
|---|---|
| 2 | Primal Cutter · Soul Stealer · Morning Star · Vulcammer Maul · Tidal Greatblade · Vrangr · Sword of the Swamps · Eonic Armor · Jerry's Sword · Crabsmasher Maul |
| 3 | Chance · Mageblood |
| 4 | Scarlet · BONE STORM · Taeshalach · Walking Axe · Spicy Air Gun · Revolver · Sword of Crota · Venomous Thyrsus |
| 5 | Decalogue · Wicked Sister · Plaguesword · Sacrificial Khopesh · Eirias · Lightbringer · Vorpal Blade · Superoomerang |
| 6 | Anduril · Dauthdaert · Cornetto Pick · **et les 7 Flamberg** (Sorcery, Necromancy, Healing, Ice, Fire, Nature, Lightning) |
| 9 | Karma Blade |

## A20. Améliorer les machines Industrial Foregoing

Aucune quête dédiée. Les addons du mod (recettes **non modifiées** par le pack —
`scripts/ForegoingGating.zs` n'y touche pas) :

| Addon | Effet | Recette |
|---|---|---|
| **Range Addon** (12 paliers) | agrandit la zone de travail | `ipi/igi/ipi` — Plastic, vitre, matériau du palier : cobble (0), lapis (1), fer (2), or (7), quartz (8), **diamant (9)**, **émeraude (11)** |
| **Fortune Addon** | Fortune/Looting — ⚠️ **doit être enchanté avec Fortune** | émeraudes + Plastic + Pink Slime Ingot |
| **Energy Field Addon** | alimentation à distance via l'Energy Field Provider | redstone + Pink Slime Ingot + **Range Addon tier 9** |
| **Transfer Addon** (item/fluide, pull/push) | entrée/sortie auto — 💡 **enchantable Efficiency** | Plastic + coffre ou seau + teinture + piston collant |
| **Leaf Shearing** / **Adult Filter** | shear les feuilles / ne tuer que les adultes | |

⚠️ **Il n'existe pas d'addon de vitesse en 1.12.** Pour aller plus vite : **multiplier les
machines**. 💡 Le tooltip de chaque machine indique ce qu'elle accepte.

## A21. Le Diesel Generator d'Immersive Engineering en détail

Les carburants sont codés en dur dans le mod ; **aucun des 374 jars n'en ajoute**, aucun script
du pack non plus.

- Consommation = `1000 / burnTime` mB **par tick**, en division entière
- Sortie fixe **4096 RF/t** (`config/immersiveengineering.cfg:316`), quel que soit le nombre de
  faces connectées

| Carburant | Conso | RF/mB | RF par seau |
|---|---|---|---|
| Biodiesel (IE) | 8 mB/t | 512 | 512 000 |
| **Diesel (Immersive Petroleum)** | 5 mB/t | **819,2** | 819 200 |
| `fuel` | — | — | ⚠️ **inactif** : aucun mod du pack n'enregistre ce nom de fluide |

⚠️ La **Gasoline n'est pas** un carburant du Diesel Generator — uniquement du Portable Generator
d'IP (5 mB/t → 256 RF/t) et du Motorboat.
💡 Distillation Tower : `oil 75 mB → lubricant 9, diesel 27, gasoline 39` — 36 % seulement du
pétrole ressort en diesel. Les trois mêmes fluides alimentent la **Mining Drill** d'IE.

## A22. Confort, déplacement et machines d'interaction

**Déplacement** (`Quests/1/50060`) : 💡 le trio de départ est **Slime Sling** (saut en maintenant
le clic droit) + **Slime Boots** (annulent les dégâts de chute et font rebondir) + **Glider**.
Les trois ensemble changent complètement la mobilité de début de partie.

**Le vol** — ⚠️ `scripts/FlightGating.zs` **retire 27 recettes** : le pack reverrouille
délibérément toutes les options de vol et les réécrit. Celles qui subsistent, dans l'ordre
approximatif d'accès :

| Option | Mod |
|---|---|
| **Jetpacks** (4 tiers conservés) | Simply Jetpacks — les recettes originales sont remplacées |
| **Angel Ring** | Extra Utilities |
| **Flight Tiara** | Botania |
| **Angelic Armor** (4 pièces) | DivineRPG |
| **Supremium Armor** | Mystical Agriculture |
| **Glitch Infused Armor** | Deep Mob Learning |
| **SWRG** | ProjectE |
| **Charger Ring** | recette custom du pack (`contenttweaker`) |

**Machines d'interaction** (`Quests/4/90196`) :
- 🏆 **Mechanical User** — « le clicker le plus polyvalent et le plus configurable »
- 🏆 **Ranged Collector** — « le meilleur vacuum hopper **pour les performances** »

**Construction / destruction** (chapitre 14) : `1873` « Making » pour les outils de construction,
`1883` « Breaking » pour tout casser efficacement.

**Baubles** (`Quests/1/50054`) : le **Bauble Case** range les baubles inutilisés. Le pack précise
que **cette section se remplit au fil de la progression** — y revenir régulièrement.

## A23. Où trouver chaque minerai

Le **chapitre 7 du questbook** (*Compenduum Materialis*, hub `70054`) est un atlas complet : une
quête par minerai, avec sa couche Y et ses conditions. Le tableau ci-dessous reprend l'Overworld
en entier ; les autres mondes suivent.

### Overworld — par couche Y

| Y | Minerais |
|---|---|
| 0 – 15 | Redstone (0-18) · Diamant (0-18) · Rupee (0-17) · Arlemite (<15) · Electrotine (<15) · Ascended Sapphire (1-10) · Realmite (5-17) · Ascended Jade (5-21) |
| 5 – 30 | Platine (5-16, sous-produit du nickel) · Nickel (5-20) · Argent (5-30) · Plomb (5-30) · Lapis (1-28) · Iridium (5-60) · Runium (5-132) |
| < 24 – 32 | Magnésium (<24) · Bore et Lithium (<28) · Nitre/Niter (<30) · Uranium, Thorium (<32) |
| 0 – 35 | Or (0-35) |
| 9 – 50 | Limonite (9-70) · Salt (10-120) · Bitumen (10-80, dans le sable) · Rosite (15-49) · Prosperity Shard et Inferium (15-50) |
| 12 – 42 | Certus Quartz (12-74) · Garnet (12-42) · Opal (16-42) · Ascended Amethyst (13-31) |
| 16 – 96 | Yellorium (16-68) · Étain (20-96) · Zinc (20-40) · Cuivre (35-65) · Galena (39-40) · Aluminium (40-75) |
| 0 – 65+ | Fer (0-65) · Charbon (0-127) · Quartz du Nether **et** Black Quartz : à toutes les hauteurs |
| > 60 | Apatite (uniquement au-dessus de Y=60) |
| près du bedrock | **Rock Crystal** — 💡 tenir un **Resonating Wand** illumine les zones au-dessus des filons |

**Par biome** (gemmes Advent of Ascension, toutes sous Y=32, aussi en drop de chance des minerais AoA) :
Ruby = aride/désert · Sapphire = océan · Peridot = plaines · Topaz = jungle · Tanzanite = froid ·
Malachite = marais et froid · Amber = forêt · Émeraude = montagnes (💡 *« mais les villageois en
ont plein ! »*).

**Cas particuliers** : Coralium = marais infestés et fond des océans · Abyssalnite = biomes
Darklands et repaires de dragons · Aquamarine = lits de rivière et mares de sable · Sulfur = près
de la lave en montagne, **ou** sous-produit du broyage de matériaux du Nether · Bauxite = minerai
d'aluminium à l'Industrial Grinder · Titanium = minerai de **rutile**, très rare, par électrolyse
de la bauxite, **dans les Dimensional Doors** · Quicksilver = fonte du cinnabar · Amber
(Thaumcraft) = drop des Furious Zombies.

### Nether
Ardite · Cobalt · Sphalerite · Cinnabar · Pyrite · Lapis · Inferium · Prosperity · Nether Quartz ·
Bloodgem · Netherite (⚠️ **le minerai ressemble à un bloc plein et doit être fondu** ; drop aussi
de « The Watcher », qui apparaît depuis les Wildfires) · Emberstone (Y 5-124) · Energized
Clathrate (Y 10-40) · **Raw Firestone** (sous les lacs de lave — ⚠️ **le feu se propage autour de
toi quand tu le tiens**) · Glowstone (plafonds et falaises) · **Mana Infused Ingot** (uniquement
dans le donjon *Elemental Chamber*).

### End
Ender Amethyst · Tungsten · Sodalite · Platine (Y 20-70, depuis la sheldonite) · Resonant
Clathrate (Y 10-80) · Dimensional Shard (⚠️ aussi dans les dimensions RFTools, sous Y=40) ·
Draconium (à tous les niveaux dans l'End et le Nether, mais **sous Y=8 dans l'Overworld**).

### Betweenlands
Octine · Valonite · Syrmorite · Scabyst · Slimy Bone · Sulfur · les trois **Middle Gems**
(Crimson, Aqua, Green) — ⚠️ ils **spawnent sous la boue** et **doivent être purifiés dans un
Purifier**.

### Système de Terra (Advanced Rocketry)
Tous **sous Y=50** sur leur planète : Serpentine → Osiris · Travertine → Ptah · Pink Marble →
Hator · Metagabbro → Orcus · Feldspar → Falacer · Agate → Oi · Onyx → Europa.
**Fiery Pyrite** → à la **surface** de Hator · **Sednanite** → amas de cristaux flottants sur
Sedna · **Rhenium** → dans des **météores difficiles à voir** · **Myrmitite** → nids de Myrmex ·
**Ogerite** → à l'intérieur d'arbres spéciaux.

### Royaumes Twilight (DivineRPG)
Eden / Wildwood / Apalachia / Skythern / Mortum Fragments — chacun dans sa dimension, craftables
depuis les « souls » des mobs correspondants. Les Mortum Fragments spawnent partout où il y a de
la Twilight Stone.

Il existe aussi quatre chaînes **Mythic Shell** (`70128`–`70131`) pour les matériaux mythiques.

## A24. Deep Mob Learning — paliers, coûts et modèles

Chiffres réels de `config/deepmobevolution/` — **63 data models** dans ce pack.

### Les cinq paliers (`DataModelTiers.json`)

| Tier | Nom | Multiplicateur de kills | Données pour le tier suivant | Chance de pristine | Trial : vagues / pristine |
|---|---|---|---|---|---|
| 0 | Faulty | ×1 | 6 | — (**ne peut pas simuler**) | 1 vague, 2 pristine |
| 1 | Basic | ×4 | 48 | 5 % | 2 vagues, 5 pristine |
| 2 | Advanced | ×10 | 300 | 11 % | 4 vagues, 8 pristine |
| 3 | Superior | ×18 | 900 | 24 % | 5 vagues, 12 pristine |
| 4 | Self-Aware | — | max | **42 %** | 7 vagues, 18 pristine |

💡 Deux enseignements : un modèle **Faulty ne simule pas** — il faut d'abord le monter en tuant
des mobs à la main ; et **le Trial donne bien plus de pristine que la simulation** (18 d'un coup
au tier 4), au prix de 7 vagues et 3 affixes.

### Coût en RF par simulation (`DataModels.json`)

| Coût | Modèles |
|---|---|
| 80 RF | Zombie · Skeleton · Spider · Creeper — les modèles de départ |
| 128 – 300 | Illager · Rogue Android · Hydra · Slime |
| 400 – 500 | Witch · Thermal Elemental · Blue Slime · les quatre modèles Twilight |
| 1 000 – 1 500 | Blaze · Guardian · Shulker · Nethengeic Beast · Mother Void Walker · Sludge Worm |
| 2 000 – 3 000 | Enderman · Ghast · Smash · Wither Skeleton · Corallus |
| 4 000 – 5 000 | Ayeraco · Wither · BamBamBam |
| **6 000** | Ender Dragon, Nethengeic Wither, et **tous les modèles de boss** (statues AoA, cœurs DivineRPG, Fractallites) |

### Comment obtenir un modèle

L'ingrédient de craft est presque toujours **le drop signature du mob** : blaze powder, ender
pearl, os, chair putréfiée… Pour les boss, c'est une **statue** (`aoa3:*_statue`) ou un **cœur**
(`divinerpg:*_heart`).

💡 Quelques rendements notables : Zombie/Skeleton/Creeper donnent **64** de leur drop, Blaze 22
blaze rods, Guardian 32 prismarine, Shulker 18 shulker shells, Enderman **seulement 6** perles.
Les modèles de boss AoA rendent des matériaux d'autres mods — Silverfoot → lingot de ludicrite,
Mechbot → mirion, Crystocore → **mica** (voir A15), Gyro → carburant ProjectE, Visualent /
Clunkhead / Dracyon / Hydrolisk → **sceaux Thaumcraft**.

⚠️ Le **Wither** ne rend pas de nether star mais un item Mystical Agradditions, et le **Wither
Skeleton** rend des têtes.

## A25. Atlas des dimensions — comment y entrer

Le **chapitre 8 du questbook** (*The Book of Worlds*) liste ~55 dimensions, chacune avec sa
méthode d'accès. Les grandes familles :

| Famille | Comment entrer |
|---|---|
| **Nether** (`20255`) | allumer un cadre d'obsidienne — ⚠️ **après avoir utilisé l'Alien Material Manual**, sinon tu es rejeté |
| **End** (`20256`) | portail trouvé aux yeux de l'ender, clic droit sur le cadre |
| **DivineRPG** (Eden, Wildwood, Apalachia, Skythern, Mortum) | 💡 **Twilight Clock** sur un cadre du bloc du palier précédent : divine rock → Eden → Wildwood → Apalachia → Skythern → Mortum |
| **Advent of Ascension** (~25 mondes : Barathos, Precasia, Creeponia, Lelyetia, Gardencia, Candyland, Crystevia, Celeve, Iromine, Haven, Vox Ponds, Mysterium, Runador, L'Borean, Lunalus, Immortallis, Ancient Cavern, Greckon, Dustopia, The Abyss, The Deeplands, The Shyrelands…) | 💡 **toujours le même portail** : cadre 5×6 en **ancient rock** avec une rune de power, direction, space, reality et travel — puis **clic droit sur la rune de power avec la realmstone** de la destination |
| **Advanced Rocketry** (Luna) | lancer une fusée depuis l'Overworld |
| **Stations spatiales** (Haumea, Osiris, Ptah, Hator, Europa, Oi, Falacer, Orcus) | warp core depuis une station spatiale |
| **Stations spatiales + artefact** (Sedna, Rhenia, Myrmex, Pixonia, Proxima Belt, Akathartos, Pauram, Zoi, Nero, Alkemia) | warp core **+ l'artefact correspondant utilisé au préalable** (voir partie C) |
| **Wormholes** (Furatto, Diamerisma, Taerrapiatta, Vibe, Apichisi, Finem, Lyndenwyrm) | clic droit sur un **warper item** |
| **AbyssalCraft** (Abyssal Wasteland, Dreadlands, Omothol) | gateway key · Asorah dreaded gateway key · Cha'garoth r'lyehian gateway key |
| **Twilight Forest** (`20265`) | 💡 lâcher une **fluix lens** dans un bassin d'eau 2×2 entouré de fleurs |
| **Aether** (`20264`) | seau en skyroot sur un portail de glowstone |
| **Erebus** (`20266`) | cadre en briques de pierre rempli de feuilles vanilla |
| **The Emptiness** (`20267`) | Voidseer Caster Gauntlet + impetus conductor, chargé de rifts, utilisé sur une **fracture** (trouvée au Fracture Locator). 💡 **Le toit du Nether est un bon endroit pour en chercher** |
| **Deep Dark** (`20263`) | portail Deep Dark |
| **Iceika** (`20275`) | snow globe DivineRPG sur un cadre de blocs de neige |
| **Dungeon of Arcana** (`20274`) | 12 portails d'arcana en carré horizontal, posés en shift |
| **Dimensional Doors** (`20272`) | 💡 **mourir dans une dimensional door**, ou utiliser le *call to limbo* |
| **Vethea Nightmare** (`20315`) | le **nightmare bed** |
| **Bedrock Dimension** (`1426917301`) | clic **gauche** sur le bedrock tout en bas de l'Overworld |

## A26. ⭐ Extended Crafting — la colonne vertébrale cachée du pack

C'est **la** chose que les tutos en ligne ne disent pas : MeatballCraft **retire les recettes
d'origine** de la plupart des blocs importants et les remonte sur les tables **Extended
Crafting**. 66 scripts `scripts/*Gating.zs` s'en chargent, dont `AEGating.zs` à lui seul retire
**193 recettes**.

Les quatre tables : **Basic 3×3 → Advanced 5×5 → Elite 7×7 → Ultimate 9×9**. Chacune se craft
sur la précédente (l'Advanced se fait sur la Basic, etc.), et la **Basic elle-même est verrouillée
derrière le game stage `extendedcrafting`**, c'est-à-dire l'**Alien Material Manual**. Autrement
dit : le manuel qui ouvre le Nether ouvre aussi toute la progression du pack.

**Règle pratique** : quand une recette n'apparaît pas dans JEI à sa forme habituelle, cherche-la
sur une table Extended Crafting.

### Applied Energistics 2

| Table | Blocs concernés |
|---|---|
| **3×3 Basic** | Spatial IO Port |
| **5×5 Advanced** | **ME Interface** · **Molecular Assembler** · trois `part` AE2 · AE2 Fluid Crafting (Fluid Discretizer, Fluid Packet Decoder, Ingredient Buffer, Burette) · toutes les interfaces ExtraCells (import/export item, fluide, essentia) · Packaging Provider |
| **7×7 Elite** | 🔴 **ME Controller** · **Energy Acceptor** · **Quantum Ring** · **Quantum Link** · AE2Stuff **Inscriber**, **Grower**, **Wireless** |
| **9×9 Ultimate** | Spatial Pylon |

⚠️ Le **ME Controller** demande en plus des **lingots de netherite DivineRPG**, des chipsets
redstone BuildCraft et un Energy Acceptor au centre. Prévois la table Elite **avant** de vouloir
un réseau AE2 à canaux.

### EnderIO — l'échelle des capacitors

| Table | Items |
|---|---|
| 3×3 | Basic Capacitor · Capacitor Silver · Simple Stirling Generator · armures Dark Steel et End Steel (4 pièces chacune) |
| 5×5 | Double-Layer Capacitor · **Energetic Silver** · **Melodic** · **Stellar** · armure Stellar Alloy · Transceiver |
| 7×7 | Octadic Capacitor · **Vivid** |
| 9×9 | **Crystalline Capacitor** |

### Thermal / Redstone Arsenal

Les **augments** suivent l'échelle : Hardened 3×3 → Reinforced 5×5 → Signalum 5×5 → **Resonant
7×7**. Machine Frame et les trois matériaux de base restent en 3×3. Armure Flux en 3×3, arc Flux
en 5×5.

### RFTools

| Table | Blocs |
|---|---|
| 3×3 | Machine Frame |
| 5×5 | Storage Module Tablet |
| 7×7 | **Builder** · Matter Transmitter · Matter Receiver · **Empty Dimension Tab** · Dimension Enscriber |
| 9×9 | 🔴 **Dimension Builder** · **Dimlet Workbench** |

⚠️ Les dimensions sur mesure (A16) sont donc du **contenu de fin de partie** : il faut la table
Ultimate.

### Environmental Tech — les Solar Arrays

L'échelle des cellules et contrôleurs (A1) correspond exactement aux tables :

| Table | Éléments |
|---|---|
| 3×3 | Solar Controller 1 et 2 · cellules **Litherite** et **Erodium** |
| 5×5 | Controller 3 et 4 · cellules **Kyronite** et **Pladium** |
| 7×7 | Controller 5 et 6 · cellule **Ionite** · une recette de **Litherite Crystal** |
| 9×9 | cellule **Aethium** |

⚠️ **Le cristal de Litherite ne se mine pas** : `config/environmentaltech/main.cfg:48` désactive
son minerai (`litherite_ore=false`). Trois routes seulement :
1. la recette **Elite 7×7**, qui coûte de la **Dark Matter et de la Red Matter** (ProjectE), de
   l'uranium et un bloc de diamant — donc ProjectE avant Environmental Tech ;
2. **décompresser un bloc de litherite** (1 bloc → 9 cristaux, table normale) ;
3. 🏆 **le Void Resource Miner tier 1** — la vraie source praticable, voir A15.

### Draconic Evolution

Draconic Core **3×3** → Wyvern Core **7×7** → Awakened Core **9×9** → Chaotic Core **9×9**.
Le Celestial Manipulator et la Wyvernium Matrix sont en 9×9, le Draconic Machine Frame en 5×5
puis 9×9 selon la variante. Le Dissolution Enchanter reste en 3×3.

### ProjectE

Pierre philosophale et Destruction Catalyst en **5×5**. Le **DM Pedestal** et **toutes les Power
Flowers** (11 tiers) sont en **9×9**.

### Autres

- **Immersive Engineering** : Revolver et Railgun en 5×5 ; les décorations en pierre en 3×3.
- **Industrial Foregoing** : seuls le **Latex Processing Unit** et le **Tree Fluid Extractor**
  passent en Extended Crafting, en 3×3 (voir A20 — les addons ne sont pas touchés).
- **Deep Mob Learning** : Simulation Chamber, Extraction Chamber et Soot Covered Plate en 5×5 ;
  Machine Casing en 3×3.
- **Extra Utilities** : 18 machines en 3×3, mais le **Rainbow Generator en 9×9** (cohérent avec
  son statut de générateur de chapitre 7).
- **Extended Crafting lui-même** : l'Interface et le Compressor demandent la table **Elite 7×7** ;
  l'Ender Crafter et l'Ender Alternator la 5×5.

### Les autres mods gatés

| Mod | Ce qui monte sur les tables |
|---|---|
| **Mystical Agriculture** (58 retraits) | cristaux **Inferium / Prudentium / Intermedium en 5×5**, **Superium et Supremium en 7×7**, **Master Infusion Crystal en 7×7** |
| **NuclearCraft** (49 retraits) | l'essentiel du mod en **7×7** : Infuser, Melter, coolers, blocs de fission, murs et contrôleur de salt fission, connecteurs et électro-aimants de fusion. 🔴 **Le Fusion Core est en 9×9.** Les `part` suivent une échelle 3×3 → 5×5 → 7×7 |
| **ProjectE / sacs** | l'**Alchemical Bag** passe en **7×7** |
| **Thermal Cultivation / Mystical** | ⚠️ **tous les arrosoirs sont retirés et refaits** : les Watering Cans Mystical Agriculture (5 tiers) remplacent ceux de Thermal (A7) |
| **Simply Jetpacks & le vol** | 27 recettes retirées : **le vol est délibérément reverrouillé** (voir A22) |
| 🔴 **Flux Networks** | le **Flux Core** passe en **5×5** — or le pack te demande d'utiliser les Flux Networks dès le chapitre 2 (A2). **La table Advanced est donc un prérequis de ton réseau d'énergie**, pas seulement de l'AE2 |
| **Tesslocators** | les trois versions (item, fluide, énergie) en **5×5** — A3 |
| **Tech Reborn** | Machine Frames (3 tiers) en **7×7**, Fusion Coil en 7×7, 🔴 **Fusion Control Computer en 9×9** |
| **Advanced Rocketry** | Blast Brick et Structure Machine en 7×7 · 🔴 **Warp Core, Warp Monitor, Terraformer et Gravity Machine en 9×9** — le voyage spatial du chapitre 3 exige donc la table **Ultimate** |
| **EnderIO / Draconic (stockage)** | Capacitor Banks tiers 2-3 en 5×5 · Draconic Particle Generator et SU Tech Reborn en 7×7 |
| **Woot** | le **Stygian Iron Ingot** en 5×5 — porte d'entrée des mob farms Woot (A9) |
| **Bewitchment** | les 6 autels de sorcière en 3×3, **les 5 sigils en 5×5** |
| **Lazy AE2** | Big Assembler en 5×5 et 7×7 |
| **Extreme Reactors / Vajra / BuildCraft / AoA** | quelques pièces isolées en 7×7 |
| **Ender Chest** (34 recettes) | tout reste en 3×3 — pas de gating par table |

### ⚠️ Torcherino : le cas le plus sévère du pack

`scripts/TorcherinoGating.zs` **supprime 63 recettes** — c'est-à-dire **presque tout le mod** :
les Torcherinos niveaux 2 à 5, toutes les variantes compressées, les time wands, le time storage,
les lampes de croissance, les upgrades, les horloges et tous les composants.

Il ne reste que :
- le **Torcherino niveau 1**, sur une table **Advanced 5×5**, avec une recette qui demande de la
  poussière Astral Sorcery, un **échantillon génétique d'abeille au trait `careerbees.acceleration`**,
  un **Blood Infused Dimensional Ingot**, et un **cristal céleste accordé à Horologium**
  (taille 900, pureté 100) ;
- le **Compressed Torcherino niveau 1**, fabriqué à partir de 8 Torcherinos + 1 compressé.

💡 Conséquence directe pour A7 : le Torcherino reste `(The Best)` pour accélérer les cultures,
mais **ce n'est pas une option de début de partie**. Il faut Astral Sorcery, l'élevage d'abeilles
Career Bees et du Blood Magic avant d'y toucher. En attendant, le **Hydrator** d'Industrial
Foregoing (⭐ Great) est la vraie réponse pratique.

## A27. Les onze mods magiques — à quoi ils servent, et les rituels qui valent le coup

Racine : `Quests/6/20054` « Magic is Real ». Chaque mod a son arbre complet.
🔴 **Ordre obligatoire : Blood Magic → Thaumcraft → AbyssalCraft**, sinon tu accumules du flux et
du warp que tu ne pourras plus nettoyer.

| Mod | Ce qu'il apporte |
|---|---|
| **Blood Magic** (`20200`) | rituels et sigils. 💡 **Interagit avec Thaumcraft pour nettoyer le flux facilement** — c'est la raison de le faire en premier. Très automatisable ; le pack ajoute des multiblocs custom. Addons : Blood Arsenal, Animus |
| **Thaumcraft** (`20196`) | ⚠️ **les quêtes du pack sont écrites autour du « really scary vishroom »**, la voie recommandée. Sinon, suivre le Thaumonomicon. Quatre énergies : Vis (se régénère seule), Flux (radiation à effets néfastes), Warp (lié au joueur), Essentia. Addons : Thaumic Energistics, Wonders, Additions, Augmentation, Tinkerer |
| **AbyssalCraft** (`20061`) | horreurs lovecraftiennes, un **outil d'enchantement puissant**, beaucoup de boss et d'exploration. Tourne autour du Necronomicon |
| **Botania** (`20202`) | mana et fleurs. **Presque entièrement automatisable seul** ; le pack ajoute un multibloc pour combler le reste. Addon : ExtraBotany. Voir A8 |
| **Astral Sorcery** (`20198`) | starlight, upgrades joueur puissants, rituels de génération de ressources. ⚠️ **L'automatisation passe surtout par les multiblocs custom du pack**, pas par le mod de base |
| **ProjectE** (`20059`) | EMC, transmutation. Voir A14. Addon : ProjectEX |
| **Electroblob's Wizardry** (`20064`) | baguettes et grimoires — **de très bonnes options d'arme**. 💡 Le pack ajoute un multibloc pour automatiser ses matériaux |
| **Bewitchment** (`20328`) | magie naturelle et démons. ⚠️ **Son automatisation de base est mauvaise** — des multiblocs custom remplacent à terme ses machines |
| **Reliquary** (`20055`) | magie tirée des créatures mortes : génération de ressources et système de potions |
| **Corail Tombstone** (`1170`) | la mort et ses pouvoirs — upgrades joueur puissants et confort |
| **Dimensional Doors** (`2296`) | mondes étranges et outils de confort. 💡 Se lance simplement en explorant et en entrant dans les portes trouvées un peu partout |

### ⭐ Les 34 éléments marqués `(Useful)`

C'est une **quatrième convention d'étiquetage**, propre au chapitre 6 : dans les longues listes de
rituels et de fleurs, le pack marque explicitement ceux qui servent vraiment.

**Rituels Blood Magic** — de base (`20101`) : Peaceful Souls.
Supérieurs (`20102`) : **Ritual of Culling** · Gathering of the Forsaken Souls · Infusion de
Sanguine · Mark of the Falling Tower · Crack of the Fractured Crystal · Resonance of the Faceted
Crystal · Ritual of Eldritch Will.
⚠️ **Le Well of Suffering est explicitement déconseillé** : *« utilise le Ritual of Culling à la
place, il lag moins »*.

**Rites Bewitchment** (`20344`) : Rite of Shifting Seasons · Rite of the Spiritual Rift · Conjure
Imp · Conjure Demon · Leonard's Sabbath · Baphomet's Sabbath · Rite of Knowledge · Rite of
Purification · Rite of Hellmouth · Rite of Greater Hellmouth · Ritual of Frenzied Growth · Rite of
the Rising Twigs.

**Constellations Astral Sorcery à s'attuner** (`20123`) : **Bootes · Horologium · Lucerna ·
Mineralis**. 💡 Horologium est aussi la constellation exigée par la recette du Torcherino (A26).

**Fleurs fonctionnelles Botania** (`788`) : **Orechid** et **Orechid Ignem** (génération de
minerais) · Agricarnation · Enchanted Orchid · Jaded Amaranthus · Loonium · Marimorphosis ·
Solegnolia · Annoying Flower.

**Rituel imparfait** (`20100`) : Imperfect Night Ritual. 💡 Les rituels imparfaits, c'est une
pierre de rituel imparfait avec un bloc posé dessus — l'effet dépend du bloc, et se déclenche au
clic droit à main nue.

### Deux mécaniques à comprendre avant de se lancer

**Le Warp** (`1751`) — commun à Thaumcraft et AbyssalCraft, il est **lié au joueur**. On en gagne
en mangeant des cerveaux, en débloquant des recherches Thaumcraft, en combattant les mobs
AbyssalCraft et en explorant ses dimensions. À surveiller au **sanity checker**. Trois types :
temporaire (rose vif, redescend seul), collant (nécessite du savon sanitisant), et permanent.
⚠️ Un warp élevé donne des debuffs **et fait apparaître des mobs spéciaux autour de toi**.

**L'Essentia** (`1748`) — le creuset ne suffit pas : il faut une **essentia smeltery**, qui
« fond » les items en leurs composants d'essentia (visibles dans JEI). Poser des **alambics
arcanes** au-dessus. ⚠️ **Sans alambic, l'opération produit du flux.** Plus le tier est élevé,
meilleur est le rendement et moins il y a de flux — **à partir du tier Mithrillium, plus de flux
du tout**. Voir aussi la description JEI de l'automatisation complète de l'essentia
(`scripts/JEIdescriptions.zs:3112`) : Vis Seeds + Phytogenic Insolators + Essentia Crystallizers
+ Deep Mob Evolution, avec un insolator par graine et 7 à 8 crystallizers par insolator à vitesse
de base.

**L'infusion Thaumcraft** (`20194`) : clic droit sur la matrice avec du **salis mundus** pour
former la structure, items dans les piédestaux, essentia depuis les jarres proches, puis clic
droit sur la matrice avec le **casting gauntlet**. ⚠️ **Toute infusion peut mal tourner** — la
stabilité de la matrice se surveille visuellement.

**L'Attunement Altar Astral Sorcery** (`20123`) : clic droit au **sextant** pour la prévisualisation
du multibloc. 💡 Tenir un **papier de constellation en main secondaire** en regardant la structure
fait apparaître des particules aux emplacements où poser les **spectral relays**. Les visuels
changent quand c'est correct — **et seulement si la constellation est dans le ciel**.

## A28. Les machines qui comptent, mod par mod

Racine : `Quests/3/20481` « Machines, Machines, Machines » — *« il y a beaucoup de machines et de
procédés à automatiser, je laisse cet espace pour noter des infos sur chacun »*. Sur les 328
quêtes du chapitre, **94 seulement portent une description** : les autres sont de simples cases à
cocher. Voici ce que les 94 apprennent vraiment.

### Applied Energistics 2 — la chaîne des processeurs

| Étape | Machine | Note |
|---|---|---|
| 1 | **Inscriber** (`20691`) | un seul processeur à la fois. Demande de l'énergie **du réseau AE** — 💡 au début, un Energy Acceptor et quelques câbles suffisent |
| 2 | **Advanced Inscriber** (`20704`) | accepte des **stacks entiers** en entrée |
| 3 | 🏆 **Processor Clean Room** | ⚠️ **« pour les gros setups, spammer les Advanced Inscribers est une mauvaise idée pour le lag — utilise la clean room à la place »** |

**Cristaux** : **Crystal Growth Accelerator** (`20698`) — jusqu'à **six autour d'un bloc d'eau**,
alimentés par le réseau AE — puis passer au **Crystal Growth Chamber** (`20710`), où les graines
poussent vite sans montage. Le **Fluix Aggregator** (`1247`) et le **ME Circuit Etcher** (`1248`)
couvrent une partie des mêmes fonctions et servent aux composants du Mass Assembler.

### 🏆 Package Crafters — automatiser l'Extended Crafting depuis AE2

C'est la réponse au problème posé par A26 : comment autocrafter des recettes 5×5, 7×7 et 9×9.

| Crafter | Grille |
|---|---|
| Basic Package Crafter (`20708`) | 3×3 |
| Advanced (`20711`) | 5×5 |
| Elite (`20715`) | 7×7 |
| Ultimate (`20717`) | 9×9 |
| Ender Package Crafter (`20719`) | comme l'Ender Crafter |
| Combination Package Crafter (`20720`) | 1. poser à côté d'une interface ou d'un unpackager · 2. ajouter des piédestaux · 3. profit |

💡 Mode d'emploi commun : **poser le crafter à côté d'un Unpackager**, et avoir **un Packager
quelque part dans le réseau AE — il n'a pas besoin d'être à proximité**.

Alternative plus simple : l'**Automation Interface** d'Extended Crafting (`20689`) transforme une
table en **crafteur mono-recette** — pratique pour une automatisation passive dédiée.

**Ender Crafter** (`20696`) : ce sont les **alternators** qui l'alimentent. 💡 **Plus il y en a
dans la zone 7×7 autour de la machine, mieux c'est.**
**Crafting Core** (`20702`) : un item au centre, infusé par ce qui est sur les piédestaux —
**seul le core consomme de l'énergie**.

### Draconic Evolution — le Fusion Crafting

Le **Fusion Crafting Core** (`20690`) infuse un item depuis les injecteurs qui l'entourent.
⚠️ **Chaque injecteur consomme de l'énergie**, et **beaucoup de recettes exigent un tier minimum**.
Quatre tiers : Basic (`20697`) → Wyvern (`20703`) → Draconic (`20709`) → Chaotic (`20712`).
💡 **Plus le tier des injecteurs est élevé, plus le craft est rapide.**

### NuclearCraft — ce qu'il faut passer en autocraft

Le pack le dit explicitement pour quatre machines : **Isotope Separator**, **Fuel Reprocessor**,
**Electrolyzer** et **Chemical Reactor** — *« good to have on autocraft, I will need a decent
amount of these »*. Et pour le **Rock Crusher** : 💡 *« fais-en trois, mets-les en passif,
oublie-les »*.

Le reste du catalogue NuclearCraft remplace des multiblocs d'autres mods : **Melter** (« pas
besoin du multibloc smeltery »), **Ingot Former** (« pas besoin de tables de coulée »),
**Manufactory** (pulvérisateur), **Alloy Furnace**, **Supercooler**, **Neutron Irradiator**,
**Pressurizer**, **Salt Mixer**, **Fluid Enricher** (pour le RadAway), **Centrifuge** —
💡 « la meilleure centrifugeuse, entre toi et moi ».

### Thaumcraft

⚠️ **L'Infernal Furnace produit du flux** (`20655`) : ne l'automatise pas sans avoir un moyen de
nettoyer. Clic droit avec du **salis mundus** pour former la structure ; les items se jettent par
le haut.
**Catalyzation Chamber** (`2145`) : multibloc 3×3×3, formé au salis mundus, une **Stone de Thaumic
Wonders** à placer dans la GUI.
**Primordial Accelerator** (`2147`) : casse les Primordial Pearls en Primordial Grains **en
consommant les rifts alentour**.

### Botania

**Pure Daisy** (`20621`) : transforme les 8 blocs autour d'elle. 💡 **S'automatise facilement avec
des poseurs/casseurs de blocs, ou avec des plans de formation et d'annihilation dans un sous-réseau
AE2.**
**Mana Pool** (`20635`) : s'automatise avec un item dropper ou une precision hopper.

### Advanced Rocketry

Quatre multiblocs, tous prévisualisables **avec le holo projector** : **Precision Assembler**
(circuits et pièces de machines), **Crystallizer** (boules de silicium — 💡 « bon candidat au
passif »), **Cutting Machine**, **Chemical Reactor** (carburant de fusée) et **Electrolyser**.

### Tinkers' Construct

**Smeltery** (`20561`) : coquille de seared bricks en cuboïde, **sans toit ni arêtes**. Le
contrôleur porte l'interface et sert d'**entrée d'items pour l'automatisation** ; le tank est
l'entrée de lave. **Smart Output** (`20608`) pour une sortie de métal en fusion configurable.

### Les petites machines qui rendent service

| Machine | Mod | Pourquoi elle vaut le détour |
|---|---|---|
| **Atomic Reconstructor** (`20563`) | Actually Additions | 💡 **clic droit avec une torche de redstone pour passer en mode pulse** ; à côté d'une plaque de pression, ça zappe automatiquement ce qu'on y pose |
| **Empowerer** (`20574`) | Actually Additions | quatre display stands, à deux blocs de distance |
| **Resonator** (`20554`) | Extra Utilities | infuse des matériaux avec de la **grid power**, produite passivement par de nombreuses sources |
| **Enchanter** (`20565`) | Extra Utilities | ⚠️ demande un **boost externe** comme une table d'enchantement (bibliothèques, magical wood…) |
| **SAG Mill** (`20567`) | EnderIO | 💡 les **grinding balls** augmentent le rendement |
| **Slice'N'Splice** (`20581`) | EnderIO | consomme la durabilité d'une hache et de cisailles — 💡 **rien n'est consommé si les outils sont incassables** |
| **Alloy Smelter** (`20556`) | EnderIO | jusqu'à trois matériaux, et fait aussi office de four |
| **Assembly Table** (`20570`) | BuildCraft | alimentée par les lasers autour — **plus il y en a, mieux c'est** |
| **Heat Exchanger** (`2347`) | BuildCraft | déplace les fluides entre états Cool → Hot → Searing |
| **Stygian Iron Anvil** (`20685`) | — | ⚠️ **un magma block est requis dessous**. 💡 **Un anvil par cast** est recommandé, les items peuvent être droppés ou distribués dessus |
| **Dragonfire Forge / Crucible** (`20629`/`20628`) | Ice and Fire | 💡 **le feu s'alimente passivement par transport de fluide** ; en construire plusieurs pour automatiser les fluides à haute température |
| **Boiler Tank** (`20558`) | Railcraft | 💡 **haute pression = mieux** |

## A29. Traits Tinkers — ceux qui changent vraiment un outil

`Quests/13/201196` « All the traits!!! » contient la description des **~160 traits** du pack en un
seul bloc de texte. Voici le tri utile ; le reste est du folklore.

### 🏆 Les traits à chercher en priorité — modificateurs supplémentaires

Ils décident du plafond de ton outil, donc du choix des matériaux (A18) :

| Trait | Effet |
|---|---|
| **Magically Modifiable** | **+3 modificateurs** |
| **Soul** | **+3 modificateurs** |
| **Botanical I-II** | augmente le nombre de slots — *« l'effet se cumule fortement »* |
| **Thaumic** | +1 slot, **+2 si au moins 3 pièces l'ont** ou si l'outil est entièrement fait de pièces Thaumic |
| **Writable** / **Moldable** | modificateurs supplémentaires |

### Auto-réparation — ne plus jamais réparer à la main

**Mana** (le mana remplace la durabilité **et** répare avec le temps) · **Mana Repair** /
**Energy Repair** / **Psi Repair** (réparent juste avant de prendre des dégâts) · **Living I-II**
(via le Soul Network Blood Magic) · **Shadow** (mana + invoque des pixies sombres) ·
**Petramor** (absorbe la pierre pour se réparer) · **Ecological** (régénération passive) ·
**Synergy** (se répare si tu as des **Steeleaves dans la hotbar**) · **Cheap** / **Discounted**
(augmentent la durabilité gagnée à la réparation).

### Minage

| Trait | Effet |
|---|---|
| **Autosmelt** | les blocs minés sont fondus |
| **Direct** | 💡 **téléporte les drops directement dans l'inventaire** |
| **Global Traveler** | shift + clic droit sur un coffre : tous les drops y sont envoyés |
| **Momentum** | plus tu mines longtemps, plus tu vas vite |
| **Unnatural** | mine d'autant plus vite que le niveau de récolte dépasse le requis |
| **Ethereal Miner** | empêche les blocs au-dessus de tomber |
| **Crumbling** | casse plus vite les blocs qui ne nécessitent pas d'outil |
| **Weeee!** | détruit **tout ce qui est en dessous** (dans la limite du harvest level) |
| **Squeaky** | ⚠️ donne **Silk Touch** mais **aucun dégât** — outil de minage pur |
| **Energy Eater** / **Mana Eater** / **Psi Eater** | vitesse et dégâts boostés en consommant de l'énergie / mana / psi |
| **Infernal Energy** | efficacité massivement augmentée **quand tu es en feu** |
| **Power of the Sun** | minage et combat dépendent de la lumière (une torche suffit) |

### Rendement annexe

**Experience Boost** et **Well-Established** (XP bonus) · **Prosperous** (drop de Prosperity
Shards) · **Chunky** (Mob Chunks) · **Glitch** (Glitch Hearts) · **High in Calcium** (os et
poudre d'os) · **Mirabile Visu** (fait apparaître de l'or ou du diamant dans la pierre autour de
toi, **au prix de durabilité**) · **Bloodlust** (life essence au Soul Network) · **Vile** (une âme
de plus par kill dans ton Soul Shard) · **Soul Harvest** / **Soul Sap**.

### Dégâts

**Critikill** (toujours un coup critique) · **Overflow** (**25 % de chance d'enlever la moitié de
la vie de la cible à chaque attaque**) · **Instakill** (« one-shot kills. Slightly dangerous ») ·
**Rude Awakening** (perce l'armure des mobs) · **Undone** (les critiques retirent l'armure) ·
**Insatiable** (dégâts croissants en combat, **mais durabilité consommée croissante**) ·
**Jagged** (chaque point de durabilité perdu ajoute des dégâts) · **Slashing** (+20 % sur les
critiques) · **Fractured I-II**, **Splintering I-II**, **Runic I-II** (dégâts magiques).

**Conditionnels** : Holy (morts-vivants) · Hellish (mobs hors Nether) · Devil's Strength (mobs
hors Overworld) · Twilit (hors Twilight Forest) · Superheat (ennemis en feu) · Cold-Blooded
(cibles à pleine vie) · Spades / Payback / Precipitate (plus tu es blessé, plus tu frappes fort) ·
In the Garage (dans l'ombre) · Surf Wax America (monté).

### Défense et survie

**Stiff** (blocage plus efficace) · **Spiky** / **Prickly** (renvoient les dégâts) · **Heavy**
(annule le knockback) · **Terrafirma** (soigne avec le temps, outil en main **ou armure portée**) ·
**Uplifting** · **SOS!** (récupération d'urgence à coût élevé) · **Hail Hydra** (Absorption
occasionnelle) · **Flammable** (bloque les dégâts de feu et enflamme l'attaquant) ·
**Starfishy** (💡 **sauve de la mort** en te téléportant à un portail virtuel, si tu as assez de
cristaux enori).

### ⚠️ Les traits à éviter

| Trait | Pourquoi |
|---|---|
| **Magically Brittle** | **peut casser un outil « incassable »** — le pire du lot |
| **Cheapskate** | durabilité réduite |
| **Radioactive I-III** | faim ou empoisonnement aux radiations, au hasard |
| **Evil Aura** | apporte la malchance **au porteur** |
| **Healer** | **soigne l'ennemi** à chaque coup |
| **Famine** | inflige la Faim |
| **Alien** | les stats changent toutes seules |
| **Stonebound** | mine plus vite en s'usant, **mais fait moins de dégâts** |
| **Splinters** | se retourne contre toi |

### Utilitaires amusants mais réels

**Portly Gentleman** (shift + clic droit pour **capturer une entité**, coût en durabilité selon sa
vie ; touche « release entity », par défaut `0`) · **Brown Magic** (touche `N` pour poser un
portail virtuel, `Y` pour s'y téléporter) · **Fruit Salad** (stocke 5 types de fruits) ·
**Music of the Spheres** (l'outil fait boombox) · **Illuminati** (les entités proches brillent et
**tu deviens invisible**) · **Enderference** (empêche les endermen de se téléporter).

## A30. ⭐ Les 262 multiblocs custom du pack (Modular Machinery)

C'est le vrai contenu original de MeatballCraft, et il est **entièrement invisible dans le
questbook** : `config/modularmachinery/machinery/` contient **262 définitions de multiblocs**
écrites pour ce pack. Beaucoup de mécaniques que les autres fiches désignent (« un multibloc
custom remplacera ça ») viennent d'ici.

🔴 **Prérequis absolu** : le **Controller Manual** à clic droit, qui donne le stage `modularstage`
et débloque le Modular Machinery Controller (partie C). Sans lui, rien de tout cela n'existe.
💡 Les blocs de structure — casings, bus d'entrée/sortie sur **7 tiers**, hatches d'énergie, bus
ME, flux providers, will providers — se craftent via `scripts/ModularGating.zs`.

### Les familles

| Famille | Nombre | À quoi ça sert |
|---|---|---|
| **Mythic Processors** | 23 | la version « mythique » de chaque machine de traitement : Alloy Furnace, Grinder, Pulverizer, Centrifuge, Electrolyzer, Melter, Rock Crusher, Wiremill, Rolling Machine, Enricher, Infuser, Compactor, Purifier, Resonator, Drying Rack, Gearworking Die, Isotope Separator, Blaster, Arkencrusher, Gravitite, Chemical Reactor, Assembling Machine, Empowerer, Furnace, Muon Extractor |
| **Void Mythical Resource Miner** | 30 tiers | la montée en puissance du minage passif (voir A15) |
| **Safe Fission** | 22 | un multibloc **par carburant** (LEU-235, HEU-233, MOX-239/241, TBU, Polonium, LEB-248, LECm-243…) — c'est la version « sans meltdown » du nucléaire |
| **Active Cooled** | 7 | les mêmes, refroidis activement |
| **Dyson** | 15 | Sphere, Discharger T1→T6, Abater, Compressor, Dynamizer, Extruder, Irradiator, Revolver, Scatterer — l'énergie de chapitre 9 (A1) |
| **Warren Extractors** | 12 | extraction ciblée par ressource : Botania, Dragonsteel, Ichor, Naquadah, Radioactive, Rare Metals, Silky Jewel, Dimensional Shards, Mythic Shell, Rhenia, Actualizing Stone, et **Self Actualizing** |
| **Recursive Brain in a Vat** | 11 | un par Récursion (Kurald Galain, Kurald Emurlahn, Kurald Thyrllan, Omtose Phellack, Starvald Demelain, Tellan, Thel, Verdith Anath, Donaeth Rusen, Ahkrast Korvalain) — le cœur du **chapitre 8** |
| **Autels** | ~12 | Blood God, Blood God Enigmatic, Baphomet, Herne, Lilith, Moloch, Gaia, Elemental, Creation, Sterilized, Auto Astral Altar, Blood Altar Ziggurat |

### Les multiblocs cités ailleurs dans ce fichier

| Multibloc | Fiche | Ce qu'il résout |
|---|---|---|
| **Processor Clean Room** | A28 | remplace les piles d'Advanced Inscribers AE2 — **la solution anti-lag pour les processeurs** |
| **Experience Bath** (`xp_assimilator`) | A12 | applique automatiquement des niveaux au joueur |
| **Mechanized Coop** | A10 | drops de poules depuis les œufs de spawn |
| **Token Totem** | A1 | « la 3ᵉ meilleure source d'énergie du pack » |
| **Arc Reactor**, **Advanced Compression Engine**, **Compression Turbine**, **Empowered Monolith** | A1 | générateurs de chapitres 2 à 5 |
| **Mechanized Essentia Smeltery**, **Essentia Crystallizer**, **Essentia Solidifier** | A27 | automatisation complète de l'essentia sans flux |
| **Botanic Condenser** | A14 | farm d'Alchemical Catalyst |
| **Dragonfire Crucible / Forge**, **Wizardry Combiner**, **Corrupted / Uncorrupted Library** | A28 | les machines décrites au chapitre 3 |
| **Mythic Excavation Computer / Lattice** | — | l'excavation mythique qui alimente le Token Totem et les realmstones du chapitre 4 |
| **Hypergrowth Insolator** | A7 | version accélérée du Phytogenic Insolator |
| **T4 Woot** | A9 | le palier ultime des mob farms |
| **Soul Accumulator**, **Black Hole Juicer**, **Neutronium Cannon**, **Relativistic Collapser** | — | machines de milieu et fin de partie citées par le questbook |

### La fin de partie

Les plus gros fichiers de définition trahissent les structures les plus monumentales :
**Utopic Spires** (735 Ko), **Dyson Scatterer** (615 Ko), **Dyson Revolver** (495 Ko), **Altar to
the Name of Names** (1,5 Mo !), **The CUBE**, **Plith of Ascension**, **Tree of Life**, **Ziggurat
of Life**, **Shrine of the Sentient Meatballs**, **Twelve Gates of Heaven**, **Orb of Infinite
Wishes**, **Presbytery of the Threefold Love**, **Bastion of Flesh**, **Font of Divinity**,
**Ligature of the Three Oaths**, **Vengeance Tesseract**.

🔴 Et surtout : **`definer.json` / `definer_two.json` — le « Definer 2.0 »**, la machine du
**Defined Ingot** qui clôt le pack (chapitre 10, A partie B).

💡 **Comment explorer cette liste toi-même** :
```bash
cd config/modularmachinery/machinery
grep -l "<mot-clé>" *.json            # trouver un multibloc par ingrédient
head -8 <fichier>.json                # son nom affiché en jeu
```
Le tooltip du contrôleur et la prévisualisation en jeu restent la façon la plus lisible de voir
la structure.

---

# Partie B — Le parcours, chapitre par chapitre

Mêmes chapitres que `GUIDE-MEATBALLCRAFT-FR.html`. Chaque chapitre s'ouvre par une quête
« Welcome to chapter N » dans `Quests/0/`.

**Les trois règles générales du guide, à garder en tête partout :**
1. Faire **les carrefours** de son chapitre, pas les feuilles — sur 4 765 quêtes, 3 354 ne
   débloquent rien.
2. **À partir du chapitre 4, automatiser avant d'avancer.** Le pack le dit deux fois lui-même.
   Passé le chapitre 5, avancer sans production passive ne fonctionne plus.
3. **Ordre des mods magiques : Blood Magic → Thaumcraft → AbyssalCraft.** Dans le désordre, tu
   accumules du flux et du warp que tu ne pourras plus nettoyer.

## Chapitre 1 — Survivre sur Terra
*Quête d'entrée : `Quests/0/3` « Where the f\*\*\* am I?!? »*
> Conseil du jour 1 donné par le pack : les mobs sont dangereux, prends du bois, construis un
> abri, **reste loin de la surface**, prudence en spéléo.

- **Énergie** : dynamos Thermal (`Quests/2/50148`) — viser Steam ou Magmatic.
- **Outils** : Tinker's Construct, c'est le conseil de départ explicite.
- **Armure** : Tinkers fait le travail, mais prévois d'en changer au chapitre 2.
- **Déplacement** : Slime Sling + Slime Boots + Glider (A22).
- **Stockage** : des crates.
- **Mob farm** : Cursed Earth à **Y = 2** + Mob Crusher.
- ⚠️ **Le Nether est verrouillé** tant que tu n'as pas utilisé l'**Alien Material Manual** (voir
  partie C).
- ⚠️ Les LV Wires d'IE sont à abandonner dès la fin du chapitre.

## Chapitre 2 — Le réseau et la magie
*Quête d'entrée : `Quests/0/68` « Breakthrough »*
> « Si tu maîtrises déjà les mods magiques de cette version, tu peux foncer ; sinon l'onglet
> **magical mastery** explique comment progresser dans chacun. »

C'est le chapitre le plus dense en déblocages :
- **Énergie** : Solar Arrays, Compression Engine (`Quests/2/50177`).
- 💡 **Passe aux Flux Networks maintenant** — le pack le demande explicitement (`Quests/4/1172`).
- 💡 **Le Draconic Energy Orb est déjà craftable**, tous tiers sauf le dernier (`Quests/4/90100`).
  C'est le stockage définitif : ne construis pas d'usine à capacitor banks.
- **Magie** : les 11 mods s'ouvrent (`Quests/6/20054`). Respecter l'ordre Blood Magic →
  Thaumcraft → AbyssalCraft.
- ⚠️ **Change d'armure** : Tinkers n'est plus le bon choix (A17, ligne chapitre 2).
- 💡 La plupart des **patterns Tinkers** deviennent craftables ici.
- **XP** : les Data Models sont la bonne source pour les chapitres 2 et 3.
- 💡 `Quests/5/2216` « Basic Trees » glisse qu'il existe *« un moyen facile d'obtenir tous ces
  arbres au chapitre 2 »* — sans dire lequel.

## Chapitre 3 — L'espace
*Quête d'entrée : `Quests/0/74` « Wormhole Experiments »* — tu récupères la technologie de trous
de ver de Corallus.

- **Énergie** : Nuclear Fission (⭐), Token Totem (⭐), Yellorite Reactor (`Quests/2/50176`).
- 💡 C'est le moment d'ouvrir la chaîne **Misc Resources** (`Quests/5/1570`), inutile avant.
- 💡 L'abeille à **Condensed Essence** devient disponible : meilleure XP stackable.
- ⚠️ Nucléaire = radiations : ajoute du **shielding** à ton armure (`Quests/1/1758`).

## Chapitre 4 — Le milieu de partie
*Quête d'entrée : `Quests/0/147` « Follow the Traces »* — « tu viens d'atteindre le milieu de
partie du pack, félicitations ! ». Les **realmstones** liés au Power Stone ouvrent les régions de
voyage.

- **Énergie** : Magnetic Confinement Fusion Reactor (⭐), boucle promethium via l'Extreme Pressure
  Turbine (⭐), Lightning Controllers (`Quests/2/50184`).
- ⚠️ **Ignore les 15 générateurs Extra Utilities** — tous notés OK, pur piège à temps.
- 🔴 **C'est ici que la règle « automatise avant d'avancer » devient obligatoire.**
- 💡 Le **Roost** remplace les Nesting Pens pour les poules.
- **Équipement** : Stellar, Sideral Damascus Steel, Elite Eden (A17) ; matériaux Tinkers
  exotiques (A18).

### 🔴 Le chemin critique du milieu de partie

Si tu es quelque part entre « j'ai une table Advanced » et « mon réseau AE2 tourne », c'est
l'ordre qui compte. Tout le reste en dépend.

**1. Compte tes tables avant de les crafter.** Les recettes se consomment mutuellement :

| Pour obtenir | Il faut consommer |
|---|---|
| 1 Advanced 5×5 | **2 Basic** + bloc d'or |
| 1 Elite 7×7 | **2 Advanced** + Manyullyn + un bloc de stockage Thermal |
| 1 Ultimate 9×9 | **2 Elite** + bloc d'émeraude |

⚠️ Donc pour **garder** une Advanced et avoir une Elite, il t'en faut **trois**. Pour garder une
Elite et avoir une Ultimate, il t'en faut **six Advanced au total**. C'est l'erreur de
planification la plus coûteuse du pack — craftes-les par lots, pas à l'unité.
💡 Toutes les tables se craftent sur une **grille 3×3**, donc sur la Basic : pas besoin d'attendre.

**2. La table Elite est le vrai goulot d'étranglement.** Elle commande, à elle seule :
- le **ME Controller** — donc tout réseau AE2 à canaux (A26) ;
- l'**Energy Acceptor**, le **Quantum Ring/Link**, l'**Inscriber AE2Stuff** ;
- l'**Extended Crafting Interface**, elle-même requise par l'**Ender Package Crafter** et le
  **Combination Package Crafter** (A28) ;
- le **cristal de Litherite** par voie de craft, et les cellules solaires Ionite (A1).

**3. Ce que tu peux faire dès la table Advanced 5×5**, sans attendre : ME Interface, Molecular
Assembler, les blocs AE2 Fluid Crafting, les interfaces ExtraCells, le **Packaging Provider**, et
les capacitors EnderIO Energetic Silver / Melodic / Stellar.

💡 Le **Packager**, l'**Encoder** et l'**Unpackager** de Packaged Auto se craftent en **grille 3×3
normale** — leur coût réel est en composants (alliages EnderIO, chipsets redstone BuildCraft, ME
Package Component), pas en table. Tu peux donc préparer la logistique d'autocrafting **avant**
d'avoir l'Elite.

**4. L'ordre qui évite de tout refaire** :
```
Alien Material Manual  →  table Basic  →  ×3 Advanced
   ↳ en parallèle : Packager / Encoder / Unpackager (3×3)
        ↳ Elite  →  ME Controller + Energy Acceptor  →  réseau AE2 à canaux
              ↳ Extended Crafting Interface  →  Package Crafters  →  autocraft 5×5 / 7×7
                    ↳ ×3 Elite  →  Ultimate  →  Dimension Builder, cellule Aethium, Power Flowers
```

**5. En parallèle, monte les Void Resource Miners** (A15) : ils gouvernent l'accès aux cristaux
Environmental Tech, donc aux Solar Arrays, et donnent passivement draconium, shards dimensionnels
et cristaux Thaumcraft. C'est la seule chaîne qui ne dépend pas des tables.

## Chapitre 5 — La machinerie mythique
*Quête d'entrée : `Quests/0/274` « Power from Eden »*

Le chapitre où la progression bascule vers les **realmstones DivineRPG** et la machinerie
mythique. Jalons du guide : *Le pouvoir d'Eden · **L'infrastructure, c'est important !** · Des
cieux plus profonds · Chute de Wildwood · Mon servo est meilleur que le tien ! · Technologie
incroyable · Les insectes et le Meatball Man · La puissance du marais · Un nouvel âge ?*

- **Énergie** : Arc Reactor (✅), Salt Reactor (🔸 — lire la quête `50275` en entier d'abord).
- 🔴 **« L'infrastructure, c'est important ! »** est un titre de quête du pack, pas une métaphore :
  c'est le **deuxième avertissement explicite** à automatiser avant d'avancer. Passé ce chapitre,
  progresser sans production passive ne fonctionne plus.
- **Mythic Processors** : c'est ici que les 23 multiblocs « mythiques » (A30) prennent le relais
  des machines classiques.
- **Abeilles** : « Les insectes et le Meatball Man » — le moment de prendre Forestry au sérieux
  (A11), y compris pour la **taxcollector bee** qui servira au chapitre 9.
- **Équipement** : Sacrifice Metal, EZ Pale Metal, Elite Wildwood ; matériaux Tinkers Rosidian,
  Adamantium, Dragonslayer Steel, Endlessly Hungry, Infused Dread.

## Chapitre 6 — L'héritage de l'Arbitre
*Quête d'entrée : `Quests/0/283` « Power from Wildwood »*

Jalons : *Le pouvoir de Wildwood · Un pli dans un pli, dans un pli · Chute d'Apalachia · L'ennemi
d'à côté · Un nouvel âge ! · **Métallurgie elfique** · Perfection cristalline · Longue vie à
l'Arbitre · Signal de la ceinture · **Fabrication extrême** · Enfin, des neutrinos ! · Suis-je
assez fort ? · Demantoïde récursif*

- **Énergie** : Draconic Reactor (✅, ⚠️ explosion massive si le cœur dépasse le champ de force),
  Creative Solar Array.
- 🔴 **« Métallurgie elfique »** = le stage `brightsteelforging`, débloqué par l'**Ancient Elven
  Knowledge** (partie C). Sans lui, pas d'armure Brightsteel.
- 💡 **« Fabrication extrême »** : c'est le palier où les tables Extended Crafting **Elite 7×7 et
  Ultimate 9×9** deviennent la norme (A26) — donc le moment de monter les Package Crafters (A28).
- 💡 Le **Neutronium Cannon** sert aux multiblocs de ce chapitre (`Quests/0/161`).
- **Équipement** : Draconic, Wyvern, Elite Apalachia, Ascended Draconic Alloy ; matériaux Tinkers
  Brightsteel Alloy, Neutronium, Runandium.

## Chapitre 7 — Vethea
*Quête d'entrée : `Quests/0/291` « Power from Apalachia »*

Un chapitre à part : on y entre **par le rêve**. Jalons : *Cœur de Skythern · Éclat de Chaos · Le
bois le plus dur de l'univers · **Lit de cauchemar** · Si tu meurs dans un rêve… · **les neuf
Ascensions du cauchemar** · Pierre d'appel du rêve · **Lien de Vethea** · On sort ! · Grenat de
Vethea*

- **Énergie** : Rainbow Generator! (⭐) — un exemplaire autour de chacun des 16 générateurs.
- 🔴 **Accès** : le **Nightmare Bed** (A25). Le **Minor Vethea Binding** (stage
  `minorvetheabinding`, partie C) est requis pour la suite.
- ⚠️ **Seul endroit du pack où les pipes BuildCraft sont obligatoires** (`Quests/4/1136`).
- **Les neuf boss d'Ascension du cauchemar**, dans l'ordre du guide : Teaker · Amthirmis · Darven ·
  Cermile · Pardimal · Quadrotic · Karos · Heliosis · Arksiane.
- **Équipement** : Elite Skythern ; armures **Tormented** et **Fiery** côté Vethea.

## Chapitre 8 — Les quatre Récursions
*Quête d'entrée : `Quests/0/308` « For the few... »*

Jalons : *les quatre Récursions — **Ténèbres, Impuissance, Peur, Solitude** · Catalyseur
d'Infinité · **Fourneau infini** · Realmstone des Shyrelands · Les grottes fractales infinies ·
**La chute de l'Empire Shyre** · **La chute de la Horde Crépusculaire** · Clé de la prison de
récursion · Pierre d'appel sacrée · Gland sacré · Pousses sacrées · Cendres sacrées*

- **Aucune source d'énergie nouvelle** — il n'existe pas de « Chapter 8 Sources ».
- 💡 Les **11 « Recursive Brain in a Vat »** (A30) sont les multiblocs de ce chapitre, un par
  Récursion nommée (Kurald Galain, Kurald Emurlahn, Kurald Thyrllan, Omtose Phellack, Starvald
  Demelain, Tellan, Thel, Verdith Anath, Donaeth Rusen, Ahkrast Korvalain).
- 🔴 **Objectif de fin de chapitre**, dit explicitement par `Quests/10/138` : tu dois avoir **la
  plupart des 120 éléments du Defined Ingot en production passive** en sortant d'ici. Voir
  ci-dessous.
- **Équipement** : Elite Mortum, Ichorium ; matériaux Tinkers Parafrosynium, Hihi'Irokane,
  Orichalcum, Crystalline Ichorium.

## Chapitre 9 — Infinité et sphères de Dyson
*Quête d'entrée : `Quests/0/319` « Supreme Power in the Universe »*

Le plus long chapitre du guide (37 sections). Jalons : *Singularité de carburant blanc · Matière
lumineuse · **Lingot défini** · Gallifrey · **Sphère de Dyson** · Soleil artificiel · Irradiateur
de Dyson · **Vrai Nom** · **Lingot d'Infinité** · Cœur du désert · Compresseur de Dyson ·
**Guerre au Meatball Man** · **Épreuves de l'Arbitre** · **Le Nom des Noms** · Lingot d'Halite ·
La Langue Vraie · Briser les mensonges · Vérité militarisée · Mettre fin à la Fin · **Mort au
Meatball Man***

- **Énergie** : Dyson Sphere (⭐), Energy Queen (⭐) — les 15 multiblocs de la famille Dyson (A30).
- 🔴 **Le Defined Ingot se fabrique ici**, dans le **Definer 2.0** (A30).
- 🔴 **Le « Vrai Nom »** correspond au stage `lostcitiesstage`, débloqué par le **True Name of the
  Meatball Man** (partie C).
- ⚠️ **Tous les boss de Mortum sont requis** (`Quests/0/359`) — sauf **Karot**, qu'il faut farmer
  avec un montage à **taxcollector bee**.
- **Armes** : Dyrnwyn, Tater Smasher, Heathland Bow, Gandiva, The Shieldbreaker, Lurtz Bow.

### 🔴 Le Defined Ingot — les 120 éléments

La ligne de quêtes **`Quests/10/` « Elemental Knowledge »** est en réalité le **tableau périodique
du pack** : `138` « A large task ahead... » a **120 enfants**, un par élément chimique, du
Francium au reste des lanthanides et actinides (Caesium, Rubidium, Potassium, Sodium, Lithium,
Hélium, Béryllium, Magnésium, Calcium, Strontium, Baryum, Radium, Yttrium, Scandium, Lanthane,
Cérium, Praséodyme, Néodyme, Prométhium, Samarium…).

💡 **C'est le vrai objectif à long terme du pack**, et la raison pour laquelle toutes les fiches
de la partie A insistent sur l'automatisation : il faut **120 chaînes de production passives**
simultanées. Commence à les mettre en place bien avant le chapitre 8.

## Chapitre 10 — L'endgame
*Quête d'entrée : `Quests/0/1337626444` « Long Live the Meatball Man »*

Une seule section dans le guide : *Longue vie au Meatball Man*. 💡 C'est aussi le point où le
**Lore of the Meatball Man** donne le stage `hardmode` (partie C) — le contenu réservé à ceux qui
veulent recommencer plus dur.

---

# Partie C — Raccourcis, pièges et verrous cachés

## ⭐ Les verrous par « manuel » (game stages)

Le pack verrouille du contenu derrière **18 game stages**, chacun débloqué en **cliquant droit
sur un objet** (`scripts/GameStages.zs`). Si une recette n'apparaît pas dans JEI ou si une
dimension te rejette, c'est presque toujours ça.

| Objet à clic-droiter | Débloque |
|---|---|
| **Alien Material Manual** | `extendedcrafting` — ⚠️ **et l'accès au Nether !** |
| **Controller Manual** | `modularstage` — les multiblocs Modular Machinery du pack |
| **Bloodmaster Tome** | `bloodmasterstage` |
| **Astral Mastery Tome** | `astralmastery` |
| **Draconic Key** | `draconicstage` |
| **Singularity Master** | `divinestage` |
| **Ancient Elven Knowledge** | `brightsteelforging` |
| **Minor Vethea Binding** | `minorvetheabinding` |
| **True Name of the Meatball Man** | `lostcitiesstage` |
| **Lore of the Meatball Man** | `hardmode` |
| **Paparazzi Camera** | `camerastage` |
| **Sedna / Rhenia / Myrmex / Pixonia / Proxima / Dynatos / Alkemia Artifact** | l'accès à la dimension correspondante |

⚠️ **Le message d'erreur arrive dans le chat**, pas à l'écran : si tu es rejeté d'une dimension,
regarde le chat. Exemple réel : *« You are not allowed to enter the nether. Have you used the
Alien Material Manual? »*

💡 Le **Forgetful Serum** existe dans le même script — c'est l'objet qui retire un stage.

### Les recettes réellement verrouillées derrière un stage

`scripts/GameStagesContent.zs` liste les recettes qui n'existent tout simplement pas sans le
stage. Les trois qui comptent :

| Recette | Stage requis | Portée |
|---|---|---|
| 🔴 **Extended Crafting Table (Basic)** | `extendedcrafting` — **Alien Material Manual** | **toute la progression du pack** (voir A26) |
| 🔴 **Twilight Clock** et **realmstones AoA** | `divinestage` — **Singularity Master** | **l'accès à ~30 dimensions** DivineRPG et Advent of Ascension (A25) |
| **Modular Machinery Controller** | `modularstage` — **Controller Manual** | tous les multiblocs custom du pack |

Plus : l'armure Brightsteel (4 pièces) ← `brightsteelforging` · le Nether Sky Amber ←
`bloodmasterstage` · la Divine Stone de Sedna ← `sedna` · la Mark of Sacrifice ←
`lostcitiesstage` · et six recettes réservées au `hardmode` (Lore of the Meatball Man).

⚠️ Les verrous de dimension sont **durs**, pas seulement des messages : `DimensionStages`
associe explicitement Sedna (147), Rhenia (163), Myrmex (164), Pixonia (165), Proxima (166) et
Dynatos (170) à leur stage.

💡 **À retenir : deux objets débloquent l'essentiel du pack.** L'**Alien Material Manual** (Nether
+ Extended Crafting) et le **Singularity Master** (Twilight Clock + realmstones). Si tu es bloqué
sans comprendre pourquoi, commence par vérifier ces deux-là.

## Ce que le pack a modifié et qu'on ne devine pas

- **Plant Gatherer compatible crop sticks** — modification maison, c'est la méthode privilégiée
  de récolte AgriCraft.
- **Recettes passées en Extended Crafting** : Latex Processing Unit et Tree Fluid Extractor
  d'Industrial Foregoing, entre autres (`scripts/ForegoingGating.zs`).
- **66 scripts `*Gating.zs`** : un par mod dont les recettes ont été reverrouillées. Avant de
  suivre un tuto YouTube pour un mod, vérifier `scripts/<Mod>Gating.zs`.

## Intégrations mortes ou trompeuses

- ⚠️ Le fluide `fuel` attendu par le Diesel Generator d'IE **n'existe pas** dans ce pack :
  BuildCraft 8 fournit `fuel_light`/`fuel_dense`, pas `fuel`.
- ⚠️ **Le canal fluide de Xnet est buggé** — le questbook le dit lui-même.
- ⚠️ **Essence Farmland invalide sur crop sticks** (A7).
- ⚠️ **Pas d'EU dans ce pack** : aucun IC2. Tout est en RF/Flux.
- ⚠️ **Les veines Immersive Engineering n'existent pas dans le monde** : rien à trouver en
  creusant, il faut un Core Sample Drill par chunk.

## Réglages qui contredisent l'intuition

- AgriCraft : un seul parent ne fait **jamais** monter les stats, et une culture étrangère
  adjacente les fait **baisser**.
- Industrial Foregoing : **aucun addon de vitesse** n'existe en 1.12.
- Le Diesel Generator tronque sa consommation à l'entier inférieur, ce qui rend certains
  carburants **meilleurs** que leur valeur nominale.
- Bibliocraft : sans **Monocle**, les coûts en XP sont invisibles.

## Quêtes qui donnent gratuitement quelque chose d'utile

- `Quests/5/20514` Industrial Farming → **2 Range Addons**.
- `Quests/0/1802` Butterfly Invasion → **récompense répétable** contre le bug d'invasion de
  papillons des mods Binnie. À garder en tête si le jeu se met à ramer sans raison.

---

# État du fichier

**Tout ce qui était planifié est écrit.** 30 fiches en partie A, les 10 chapitres de la partie B,
la partie C complète.

Sources croisées et vérifiées : le questbook (179 quêtes étiquetées, 34 marquées `(Useful)`, le
double classement des chapitres 11/12/13, les 94 quêtes décrites du chapitre 3, l'atlas des
minerais du chapitre 7, l'atlas des dimensions du chapitre 8, les 120 éléments du chapitre 10),
les descriptions JEI, les 66 scripts `*Gating.zs`, les 262 définitions de multiblocs Modular
Machinery, les configs de mods (AgriCraft, Deep Mob Learning, Immersive Engineering et Petroleum,
Industrial Foregoing), le code des jars, et le guide HTML pour la structure des chapitres.

**Une correction à signaler** : une version précédente de ce fichier annonçait que
`scripts/ModularGating.zs` définissait « 447 recettes Modular Machinery ». C'est faux — ce nombre
était celui des occurrences du mot `modularmachinery` dans le script, qui ne fait que **crafter
les blocs de structure** (casings, bus sur 7 tiers, hatches). Les vraies définitions de multiblocs
sont les **262 fichiers JSON de `config/modularmachinery/machinery/`**, désormais couverts en A30.

Les **66 scripts `*Gating.zs` ont tous été passés en revue** ; les listes `(Good)` des chapitres
11, 12 et 13 sont incluses ; le chemin critique du milieu de partie est en partie B.

## Ce qui ne sera pas écrit ici, et pourquoi

- **Le détail structure par structure des 262 multiblocs.** La prévisualisation en jeu (clic droit
  au holo projector ou sur le contrôleur) est strictement plus lisible qu'une transcription de
  JSON. À consulter au cas par cas.
- **Les 25 fichiers de `config/modularmachinery/recipes/`** — à ouvrir seulement quand une machine
  refuse une entrée, pas à recopier à l'avance.
- **Tout ce qui vient des fichiers n'a pas été vérifié en jeu.** Les recettes gatées, en
  particulier, pourraient être surchargées par un script non croisé. Les trois plus structurantes
  ont été re-vérifiées (ME Controller, Torcherino niveau 1, cristal de Litherite) : aucune recette
  concurrente. Pour le reste, **JEI reste l'arbitre**.

**Outils de fouille** : toutes les commandes utilisées pour construire ce fichier (extraction des
quêtes étiquetées, croisement qualité × chapitre, taille des grilles Extended Crafting, balayage
des jars) sont documentées dans `CLAUDE.md`.
