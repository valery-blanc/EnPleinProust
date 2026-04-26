# FEAT-005 — Inscription : email de confirmation + notif admin + backup CSV

**Status:** DONE
**Date:** 2026-04-26

## Context

Le bouton "Envoyer mon inscription" du formulaire `/inscription` ne fonctionnait
pas en production (pas de SMTP configuré, pas de backup des données hors
container). Cette feature rend le système d'inscription pleinement opérationnel.

## Behavior

1. **Email de confirmation** à l'utilisateur inscrit, avec un texte paramétrable
   depuis le Panel (page "Inscriptions reçues"). Le template supporte des tags
   dynamiques remplacés à l'envoi : `#PRENOM`, `#NOM`, `#EMAIL`, `#TELEPHONE`,
   `#CRENEAUX`, `#MESSAGE`.

2. **Email de notification** avec toutes les données du formulaire, envoyé à une
   liste de destinataires configurable depuis le Panel (page "Inscriptions
   reçues"). Plusieurs adresses séparées par des virgules.

3. **Backup CSV** de chaque inscription, écrit dans un fichier
   `/data/inscriptions/inscriptions.csv` **monté en volume Docker hors
   container** (survit à la destruction/recréation du container). Chaque envoi
   ajoute une ligne CSV.

4. **Export** : le lien "Exporter toutes les inscriptions en Excel" de la page
   "Inscriptions reçues" dans le Panel retourne ce fichier CSV (renommé en
   `.csv` pour l'instant, pas de conversion XLSX — plus simple et fiable).

## Technical spec

### Config SMTP (config.php)
Lire les variables d'environnement `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`,
`SMTP_PASS`, `SMTP_FROM` → injectées via `docker-compose.yml` (fichier `.env`
sur Avignon, hors repo).

### Controller `inscription.php`
- Après validation et création de la sous-page Kirby :
  1. Écrire une ligne dans `/data/inscriptions/inscriptions.csv`
  2. Envoyer l'email de confirmation (template depuis `site.emailConfirmation`)
  3. Envoyer l'email de notification (destinataires depuis `site.emailDestinataires`)
- Erreurs email best-effort (log, ne bloquent pas l'inscription)
- Erreur CSV : loguée mais ne bloque pas non plus

### Blueprint site.yml (settings globaux)
Ajouter une section "Configuration des inscriptions" avec :
- `emailConfirmation` : textarea (template avec tags)
- `emailDestinataires` : text (liste séparée par virgules)

### Volume Docker
`docker-compose.yml` : ajouter un volume `../../data/inscriptions:/data/inscriptions`
qui pointe hors du repo sur Avignon.

### Export
Plugin `enpleinproust/admin` : retourner le fichier CSV brut au lieu du XLSX
(PhpSpreadsheet trop lourd pour ce besoin ; le CSV s'ouvre directement dans
Excel).

## Impact on existing code

- `kirby/site/config/config.php` — SMTP
- `kirby/site/controllers/inscription.php` — écriture CSV + envoi emails
- `kirby/site/blueprints/site.yml` — champs email template + destinataires
- `kirby/site/plugins/enpleinproust/index.php` — export CSV
- `docker/docker-compose.yml` — volume CSV
- `kirby/site/snippets/header.php` — (pas touché)
