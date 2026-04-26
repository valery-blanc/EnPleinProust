# TASKS

## In Progress

### FEAT-000 — Bootstrap projet
- [x] Lecture des assets et briefs (`temp.txt`, `24hdeproust.pdf`, `EN PLEIN PROUST.pdf`)
- [x] Création `CLAUDE.md` avec workflow rules
- [x] Création structure `docs/{bugs,specs,tasks}`
- [x] Rédaction `docs/specs/enpleinproust-spec.md` v0.1

### FEAT-001 — Stack Kirby validée + hébergement Avignon
- [x] Évaluation alternatives CMS (WordPress, Kirby, Decap+Astro, Forms+Astro)
- [x] Choix retenu : Kirby 4 (flat-file PHP, container Docker)
- [x] Spec v0.2 : modèle de contenu Kirby, intégration Avignon Traefik
- [x] CLAUDE.md mis à jour (RUN_CMD = `docker compose up`, référence infra Avignon)

### FEAT-002 — Clarifications éditions + typographie
- [x] Édition à venir confirmée : 2027 = **Tome 6 *Albertine disparue***
      (pas Tome 7 comme initialement supposé)
- [x] Pas de performance en 2025 (gap dans la chronologie)
- [x] Polices : shortlist Google Fonts retenue (Big Shoulders Display / Anton
      + Inter + Cormorant Garamond), validation visuelle en Phase 4
- [x] Domaine `enpleinproust.zitoon.com` confirmé comme provisoire
- [ ] Date exacte et titre de l'édition Tome 1 (2019 ?) — à documenter quand
      Nathalie aura les infos

### FEAT-003 — Implémentation complète et déploiement initial
- [x] Repo git initialisé, remote GitHub `valery-blanc/EnPleinProust`
- [x] `.gitignore`, `README.md`
- [x] `docker/Dockerfile` (php:8.3-apache + extensions + Composer + UID 1000 aligné)
- [x] `docker/docker-compose.yml` (réseau `web` externe pour Avignon) + override local pour dev
- [x] `docker/apache-enpleinproust.conf` (DirectoryIndex, blocage internes Kirby)
- [x] Bootstrap Kirby : `composer.json`, `index.php`, `.htaccess`
- [x] `composer install` exécuté → vendor/ peuplé (Kirby 4.9 + PhpSpreadsheet 2.4)
- [x] Tous les blueprints : home, fonctionnement, editions, edition, nathalie, inscription, inscriptions, inscription-entry, default, photo, audio
- [x] Tous les templates + snippets header/footer
- [x] CSS principal (~600 lignes) — fond noir, Big Shoulders Display, Inter, Cormorant Garamond
- [x] Controller `inscription.php` : validation, écriture sous-page Kirby, emails best-effort
- [x] Plugin custom `enpleinproust/admin` : export XLSX via PhpSpreadsheet
- [x] Contenu initial : 6 éditions saisies (2019, 2022, 2023, 2024, 2026, 2027) avec témoignages extraits du PDF
- [x] Déploiement Avignon : container démarré, route Traefik créée
- [x] Certificat Let's Encrypt délivré pour `enpleinproust.zitoon.com`
- [x] Smoke test : toutes les pages répondent en 200, assets chargent, formulaire OK
- [x] Bug fix : `'date.handler' => 'intl'` interprétait `Y` en ICU week-year → retiré

### FEAT-004 — Itérations design (validé Val)
- [x] Police identifiée : **Chau Philomene One** (Google Fonts) → appliquée à tous les
      éléments uppercase (titres, nav, eyebrow, hero meta, edition meta, témoignage
      auteur, form labels, footer)
- [x] Bug Panel home corrigé : `preset: page` écrasait les `columns:` manuels → preset retiré
- [x] Champ `portrait` (files section) lu correctement via `$page->images()->first()`
      (le template lisait un champ inexistant)
- [x] Champ `signature` configurable (par défaut "Nathalie Vanderlinden")
- [x] Section "chiffres clés" supprimée (site artistique, pas un CV)
- [x] Bugs cascade des pages éditions corrigés :
  - `toDate()` sans format retournait un INT → ajout du format `'d/m/Y'`
  - `split()->join()` invalide (split retourne un array PHP) → remplacé par `implode()`
  - `toStructure()` retourne null si vide → guards `$x && $x->count() > 0`
- [x] Renommage "Éditions précédentes" → "Toutes les éditions" (titre, h1, nav, footer)
- [x] Édition 2028 (Tome 7 *Le Temps retrouvé*) ajoutée
- [x] Portrait fixe en arrière-plan à droite sur toutes les pages non-home
  - `position: fixed`, `object-fit: contain`, largeur `clamp(260px, 32vw, 460px)`
  - Caché sous 900px (mobile)
  - Footer empilé au-dessus avec `z-index: 2`
- [x] Menu mobile drawer compact (au lieu de plein écran)
  - Burger animé (3 traits → croix)
  - Backdrop semi-transparent flouté
  - Fermeture : backdrop, Esc, ou clic sur lien
- [x] Cache-bust automatique sur CSS/JS via `filemtime()` (évite le mois de cache mod_expires)
- [x] Bug `intl` date handler corrigé : `Y` était interprété en ICU week-year
      (2027-01-01 → 2026)

### FEAT-005 — Inscription : email confirmation + notif admin + backup CSV
- [x] Lire et valider la spec (temp.txt)
- [x] Créer `docs/specs/FEAT-005-inscription-email-csv.md`
- [x] Config SMTP dans `config.php` (env vars)
- [x] Volume Docker hors-container dans `docker-compose.yml` → `/home/val/data/enpleinproust`
- [x] Controller `inscription.php` : écriture CSV + emails avec tags #PRENOM etc.
- [x] Blueprint `site.yml` : onglet "Config inscriptions" (template email + destinataires)
- [x] Plugin export : retourner CSV (UTF-8 BOM pour Excel)
- [x] Déployer sur Avignon + tester (HTTP 200, CSV créé)
- [x] Mettre à jour `enpleinproust-spec.md`
- [x] Commit + push

### Backlog
- [ ] Upload du portrait définitif (le placeholder a été remplacé par Val)
- [ ] Saisie des dates précises et titre de l'édition Tome 1 (2019)
- [ ] Mise en place des créneaux structurés sur `/inscription` quand l'agenda
      2027 sera fixé
- [ ] Page mentions légales + RGPD
- [ ] Configuration SMTP pour l'envoi d'emails de notification d'inscription
- [ ] Cron de backup `kirby/content/` sur Avignon
- [ ] Bumper Kirby à une version sans advisories de sécurité
- [ ] Passer `'debug' => false` en config quand tout est stable

## Done
