# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**En Plein Proust** — site web artistique pour présenter une performance collective : la lecture en 24h d'un tome d'*À la recherche du temps perdu* de Marcel Proust, un nouveau tome chaque édition.

- **Édition à préparer** : **2027 — Tome 6, *Albertine disparue***, aux Ateliers Mommen, 37 Rue de la Charité, 1210 Saint-Josse-Ten-Noode (Belgique)
- **Historique** : 5 éditions précédentes (Tomes 1-5) entre 2019 et 2026, **pas de performance en 2025**. Détail dans `docs/specs/enpleinproust-spec.md` §1.
- **Organisatrice** : Nathalie Vanderlinden ([interview](https://www.youtube.com/watch?v=FHZyMDgpc1g))
- **Hébergement** :
  - Site public : `enpleinproust.zitoon.com` (sous-domaine **provisoire**)
  - Admin Kirby Panel : `enpleinproust.zitoon.com/panel`
  - Serveur : **Avignon** (`192.168.0.222`, `ssh avignon`) — Docker + Traefik partagé
  - Doc infra : `C:\WORK\Avignon\CLAUDE.md` et `C:\WORK\Avignon\docs\specs\avignon-spec.md`

### Style visuel

L'affiche `EN PLEIN PROUST.pdf` est la référence de style pour le site :
fond noir, image de Proust à droite, polices à récupérer depuis le PDF.

### Fonctionnalités cibles

**Site public** :
- Page d'accueil
- Page "fonctionnement" (cf. `RElire Proust - flyer verso 2023 (1).docx`)
- Pages "éditions précédentes" 2021–2026 (photos, vidéos, enregistrements, témoignages)
- Page "interview de l'organisatrice"
- Page "contact / inscription" (nom, prénom, email, tél. facultatif, créneaux horaires : 2 minimum, 4 maximum, durée 1h chacun)

**Site admin** (protégé par mot de passe) :
- Voir les inscriptions + export Excel
- Ajouter des médias dans les pages d'éditions précédentes
- Modifier toutes les pages (textes, images, ajouts)
- Ajouter de nouvelles pages au site

### Stack technique (validée v0.2)

- **CMS** : **Kirby 4** (flat-file PHP, pas de base de données)
- **Container** : `php:8.3-apache` + Composer
- **Export Excel des inscriptions** : PhpSpreadsheet (plugin Kirby custom)
- **Hébergement** : container Docker sur Avignon, derrière Traefik

Détails (modèle de contenu, blueprints, alternatives écartées) : voir
`docs/specs/enpleinproust-spec.md` §6.

### Comment lancer en local

```bash
cd docker
docker compose up           # → http://localhost:8080
docker compose up --build   # après modif du Dockerfile
```

### Déploiement vers Avignon

```bash
# Sync du code
rsync -avz --delete kirby/ docker/ avignon:~/docker/enpleinproust/

# Rebuild + restart
ssh avignon "cd ~/docker/enpleinproust && docker compose up -d --build"

# Vérifier
ssh avignon "docker logs enpleinproust 2>&1 | tail -30"
curl -sv https://enpleinproust.zitoon.com/
```

---

## Workflow Rules

### Task Tracking
For any task that involves more than 3 files or more than 3 steps:
1. BEFORE starting, create/update a checklist in `docs/tasks/TASKS.md`
2. Mark each sub-step with `[ ]` (todo), `[x]` (done), or `[!]` (blocked)
3. Update the checklist AFTER completing each sub-step
4. If the session is interrupted, the checklist is the source of truth for resuming work

### Resuming Work
When starting a new session or after /clear, ALWAYS:
1. Read `docs/tasks/TASKS.md` to check current progress
2. Identify the first unchecked item
3. Resume from there — do NOT restart completed work

### Documentation Synchronization (OBLIGATOIRE)

**À chaque demande de modification, bug fix ou nouvelle feature — quelle que soit
la façon dont elle est formulée (message direct, fichier temp_*.txt, description
orale) — TOUJOURS :**

1. **Créer ou mettre à jour le fichier de bug** (`docs/bugs/BUG-XXX-*.md`)
   ou de feature (`docs/specs/FEAT-XXX-*.md`) correspondant.

2. **Mettre à jour `docs/specs/enpleinproust-spec.md`** — OBLIGATOIRE, SANS EXCEPTION.
   Ce fichier est la source de vérité de l'application. Il doit refléter à tout
   moment le comportement réel du code. Mettre à jour :
   - La section concernée (UI, architecture, algorithmes, etc.)
   - Le numéro de version en en-tête (FEAT-XXX / BUG-XXX)
   - La structure du projet si des fichiers sont ajoutés/supprimés
   - Les cas limites si un nouveau cas est géré
   Ne pas attendre qu'on le demande. Si la feature est trop petite pour un §
   dédié, intégrer l'info dans la section la plus proche.

3. **Mettre à jour `docs/tasks/TASKS.md`** — toujours, sans condition :
   ajouter l'entrée si elle n'existe pas, cocher `[x]` les étapes terminées.

Cette règle s'applique MÊME pour les petites modifications demandées directement
dans le chat. Si c'est trop petit pour un fichier BUG/FEAT dédié, au minimum
mettre à jour `docs/specs/enpleinproust-spec.md` si le comportement change.

### Règle de confirmation avant commit (OBLIGATOIRE)

**Aucun commit ne doit être créé avant que l'utilisateur ait testé et confirmé.**

Ordre impératif pour tout bug fix ou feature :

```
[code] → [docs] → [docker compose up] → [demander test] → [attendre OK] → [commit]
```

- Le commit regroupe TOUJOURS : code source + fichiers de doc + TASKS.md
- Si l'utilisateur signale un problème après test → corriger, relancer,
  re-demander confirmation AVANT de committer
- **Si un crash ou erreur est découvert lors du test** → créer `docs/bugs/BUG-XXX-*.md`
  (même si le problème a déjà été corrigé), mettre à jour `docs/specs/enpleinproust-spec.md`
  avec la règle à retenir, et référencer dans `docs/tasks/TASKS.md`
- Aucune exception : même pour une modification d'une seule ligne

### Bug Fix Workflow
1. Documenter le bug dans `docs/bugs/BUG-XXX-short-name.md` (symptôme,
   reproduction, logs/traceback, section spec impactée)
2. Analyser la cause racine AVANT d'écrire le fix (Plan Mode)
3. Implémenter le fix
4. Mettre à jour toute la documentation :
   - `docs/bugs/BUG-XXX-*.md` → statut `FIXED`, fix appliqué décrit
   - **`docs/specs/enpleinproust-spec.md` → OBLIGATOIRE** : mettre à jour la section du comportement corrigé
   - `docs/tasks/TASKS.md` → cocher `[x]` toutes les étapes terminées
5. **Lancer l'application** : `docker compose up` (en local) ou redéployer sur Avignon
6. **Demander à l'utilisateur de tester et attendre sa confirmation explicite**
   — NE PAS committer avant que l'utilisateur confirme que c'est OK
7. Une fois confirmé : committer TOUS les fichiers modifiés en un seul commit
   (code + docs + TASKS.md) : `"FIX BUG-XXX: description courte"`

### Feature Evolution Workflow
1. Écrire la spec dans `docs/specs/FEAT-XXX-short-name.md` (contexte,
   comportement, spec technique, impact sur l'existant)
2. Analyser l'impact sur le code existant (Plan Mode) : risques, conflits,
   lacunes de la spec
3. Décomposer en tâches dans `docs/tasks/TASKS.md`
4. Implémenter
5. Mettre à jour toute la documentation :
   - `docs/specs/FEAT-XXX-*.md` → statut `DONE`, implémentation décrite
   - **`docs/specs/enpleinproust-spec.md` → OBLIGATOIRE** : intégrer le nouveau comportement dans la/les
     section(s) concernée(s), incrémenter la version
   - `docs/tasks/TASKS.md` → cocher `[x]` toutes les étapes terminées
6. **Lancer l'application** : `docker compose up` (en local) ou redéployer sur Avignon
7. **Demander à l'utilisateur de tester et attendre sa confirmation explicite**
   — NE PAS committer avant que l'utilisateur confirme que c'est OK
8. Une fois confirmé : committer TOUS les fichiers modifiés en un seul commit
   (code + docs + TASKS.md) : `"FEAT-XXX: description courte"`
9. Mettre à jour CLAUDE.md si des règles d'architecture ont changé

---

## Création de skills personnalisés

Les skills Claude Code de Val suivent ces conventions :

- **Nom** : toujours préfixé `vb-` (ex: `vb-init`, `vb-release`) pour éviter les conflits avec les skills officiels
- **Structure** : un dossier par skill dans `~/.claude/skills/`, contenant un fichier `SKILL.md`
  ```
  ~/.claude/skills/vb-monSkill/SKILL.md   ✅
  ~/.claude/skills/vb-monSkill.md         ❌ (fichier plat non détecté)
  ```
- **Invocation** : `/vb-monSkill`
