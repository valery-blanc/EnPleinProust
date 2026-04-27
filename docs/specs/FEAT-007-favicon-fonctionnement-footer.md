# FEAT-007 — Favicon, fonctionnement éditable, footer éditable

**Status:** DONE — validé par Val le 2026-04-27
**Date:** 2026-04-27

## Context

Trois petites améliorations demandées directement via temp.txt :
1. Favicon du site → utiliser `proust_200.jpg`
2. Page "fonctionnement" : le texte de la `div.prose` doit être éditable via le Panel
3. Footer : texte adresse, email, partenaires et tagline éditables via le Panel

## Behavior

### 1. Favicon
- `proust_200.jpg` (200×200 px, portrait Proust) copié dans `kirby/assets/favicon.jpg`
- `<link rel="icon">` ajouté dans `header.php`

### 2. Fonctionnement éditable
- Le blueprint `fonctionnement.yml` possède déjà un champ `blocks` (heading, text, quote, list, image)
- Le template `fonctionnement.php` lit déjà `$page->blocks()->toBlocks()` avec fallback hardcodé
- Action : pré-remplir `content/2_fonctionnement/fonctionnement.txt` avec le contenu hardcodé converti en blocs Kirby JSON
- Résultat : le texte apparaît immédiatement dans le Panel et est entièrement éditable

### 3. Footer éditable
- Ajout d'un onglet "Pied de page" dans `site.yml` avec les champs :
  - `footerCopyright` (text) : nom après © + année auto (fallback "En Plein Proust")
  - `footerAdresse` (textarea) : description + adresse
  - `footerEmail` (text) : email de contact
  - `footerPartenaires` (structure) : liste des partenaires
  - `footerTagline` (text) : accroche bas de page
- Ligne de crédit hardcodée : "Site réalisé par www.zitoon.com" (classe `.site-footer__credit`, 0.72rem / opacité 0.45)
- `footer.php` mis à jour pour lire ces champs avec fallback hardcodé si vide

## Technical spec

### Fichiers modifiés
- `kirby/assets/favicon.jpg` — nouveau (copie de `proust_200.jpg`)
- `kirby/site/snippets/header.php` — ajout `<link rel="icon">`
- `kirby/content/2_fonctionnement/fonctionnement.txt` — pré-remplissage blocks JSON
- `kirby/site/blueprints/site.yml` — onglet "Pied de page" (footerCopyright + 4 autres champs)
- `kirby/site/snippets/footer.php` — lecture des champs site avec fallbacks + ligne crédit zitoon
- `kirby/assets/css/main.css` — classe `.site-footer__credit`

## Impact on existing code

- Aucun impact sur l'UX publique (fallbacks identiques au contenu actuel)
- Le Panel Panel gagne 2 nouvelles zones éditables
- La page fonctionnement affiche le même contenu qu'avant, mais éditable
