# En Plein Proust — Spécification

**Version** : 0.6 (FEAT-005 — Inscription : email confirmation + notif admin + backup CSV)
**Dernière mise à jour** : 2026-04-26
**Statut** : LIVE en pré-production sur https://enpleinproust.zitoon.com — premier commit GitHub poussé

---

## 1. Vue d'ensemble

Site web artistique pour **En Plein Proust** : performance collective de
lecture en 24h sans interruption de l'œuvre de Marcel Proust *À la recherche
du temps perdu*, organisée chaque année aux **Ateliers Mommen** (37 rue de la
Charité, 1210 Saint-Josse-Ten-Noode, Bruxelles) par Nathalie Vanderlinden et
son équipe.

### Édition à venir (cible principale du site)

- **2027 — Tome 6 : *Albertine disparue*** (avant-dernier tome)

L'édition **2028** clôturera le cycle avec le **Tome 7 — *Le Temps retrouvé***.

### Toutes les éditions

| Tome | Titre du livre                          | Édition  | Dates             | Titre de l'édition  |
| ---- | --------------------------------------- | -------- | ----------------- | ------------------- |
| 1    | Du côté de chez Swann                   | 2019 (?) | à documenter     | à documenter        |
| 2    | À l'ombre des jeunes filles en fleurs   | 2022     | 05-06.02.2022     | Désacraliser Proust |
| 3    | Du côté de Guermantes                   | 2023     | 23-24.09.2023     | Relire Proust       |
| 4    | Sodome et Gomorrhe                      | 2024     | 09-10.11.2024     | (sans titre)        |
| —    | (pas d'édition en 2025)                 | —        | —                 | —                   |
| 5    | La Prisonnière                          | 2026     | 18-19.04.2026     | En Plein Proust     |
| **6** | **Albertine disparue**                 | **2027** | à confirmer       | à confirmer         |
| 7    | Le Temps retrouvé                       | 2028     | à confirmer       | à confirmer         |

> ℹ Date exacte et titre de l'édition Tome 1 à documenter (peu d'infos
> disponibles dans `24hdeproust.pdf`).

### Organisateur·ices

- **Nathalie Vanderlinden** (initiatrice, performeuse depuis 2019)
- **Manon Blanc** (depuis 2023)
- **Jean-Philippe Convert** (2023, 2024)
- **Amandine Thiry** (depuis 2024)
- **Stevie Qngo**, **William Vanstraten** (depuis 2026)

### Partenaires récurrents

- **Librairie Météores** (Marolles, Bruxelles) — partenaire libraire
- **Commune de Saint-Josse**
- **Fédération Wallonie-Bruxelles**
- **Francophonies Bruxelles**

### Hébergement

- **Site public** : `enpleinproust.zitoon.com` (sous-domaine **provisoire** — domaine
  définitif à choisir plus tard ; le sous-domaine de zitoon.com sert de vitrine
  en attendant)
- **Admin Kirby Panel** : `enpleinproust.zitoon.com/panel`
- **Serveur d'hébergement** : **Avignon** (Debian, IP LAN `192.168.0.222`,
  IP publique `31.164.198.65`, Docker + Traefik v2.11 + Let's Encrypt)
- **Documentation infra** : `C:\WORK\Avignon\CLAUDE.md` et
  `C:\WORK\Avignon\docs\specs\avignon-spec.md` — source de vérité pour
  l'architecture du serveur, les certificats SSL, le routing Traefik.
- **Email de contact existant** : `24hdeproust@gmail.com`

---

## 2. Public cible

- **Lecteurices potentiel·les** : amoureux·ses de littérature, lecteur·ices de
  Proust, communauté grandissante depuis 2019, non-lecteurices ("certains
  viennent juste pour écouter")
- **Visiteurices curieux·ses** : public bruxellois, presse culturelle, étudiant·es
  en lettres
- **Anciens participants** : pour retrouver photos, enregistrements,
  témoignages des éditions précédentes
- **Administratrice principale** : Nathalie Vanderlinden (non-développeuse —
  l'admin doit être utilisable sans aucune connaissance technique)

---

## 3. Identité visuelle

Référence absolue : l'affiche `EN PLEIN PROUST.pdf` (édition 2026, Tome 5).

### Direction artistique

- **Fond** : noir profond (`#000000` ou très proche), partout
- **Typographie titres** : sans-serif condensé, géométrique, lourd, presque
  brutaliste, toujours en MAJUSCULES — référence visuelle = la police de
  l'affiche `EN PLEIN PROUST.pdf`, qui ressemble à **Druk Wide Bold**
  (Commercial Type, payante, ~250 €).
- **Typographie corps de texte** : sans-serif lisible et haut contraste sur
  fond noir
- **Typographie longs textes proustiens** (témoignages, citations) : serif
  élégant pour respecter le rythme proustien
- **Couleur principale** : blanc cassé sur fond noir
- **Accent** : jaune fluo (cf. logo Francophonies sur l'affiche) — à utiliser
  avec parcimonie pour CTA, hover, accents typographiques
- **Image emblématique** : portrait peint de Proust (visage doré, lèvres
  rouges, col blanc — voir `EN PLEIN PROUST.pdf`). Présent sur la home, en
  pleine hauteur à droite, comme sur l'affiche.

### Polices retenues (Google Fonts gratuites)

Police de l'affiche identifiée par Val : **Chau Philomene One**.

| Usage              | Police                  | Source       |
| ------------------ | ----------------------- | ------------ |
| Tous les éléments uppercase (titres, nav, eyebrow, footer, meta, labels de formulaire) | **Chau Philomene One** | Google Fonts |
| Corps de texte courant | **Inter**           | Google Fonts |
| Long form, citations, témoignages | **Cormorant Garamond** | Google Fonts |

### Atmosphère

- **Sobre, dense, littéraire** — pas de gadget visuel, pas d'animations
  parasites
- **Place au texte** : Proust = phrases longues, donc respect de la mise en
  page et du rythme de lecture
- **Discrète touche de mouvement** : éventuellement un effet subtil sur le
  portrait de Proust (parallax léger, ou révélation à l'arrivée), animations
  d'apparition douces, rien de plus
- **Mobile-first** : tenir compte que beaucoup découvriront l'événement via
  Facebook/Instagram sur mobile

### Mots-clés guides

> brutaliste · littéraire · nuit · auberge espagnole · espace douillet ·
> communauté · vulnérabilité · 24h · marathon · cordée · respiration

---

## 4. Structure du site public

### 4.1 Page d'accueil — `/`

Au-dessus du pli, l'identité immédiate de l'événement :

- Titre **EN PLEIN PROUST** en très grand, typo de l'affiche
- Sous-titre : édition à venir (ex. *"Lecture & écoute collective en 24h sans
  interruption — Le Temps retrouvé — 2027"*)
- Portrait de Proust (composition affiche)
- Date / lieu / appel à lecteurices
- CTA principal : **"S'inscrire comme lecteurice"** → `/inscription`
- CTA secondaire : *"Découvrir le fonctionnement"* → `/fonctionnement`

Sections sous le pli :
- Citation/intro courte (extraite des textes de Nathalie sur la lecture à voix
  haute)
- Quelques chiffres / mots-clés (6 éditions, 24h, ~30 lecteurices/édition…)
- Aperçu galerie des éditions précédentes (mosaïque cliquable → `/editions`)
- Bandeau partenaires (Ateliers Mommen, Librairie Météores, Saint-Josse, FWB)
- Footer : email contact, liens réseaux, mentions

### 4.2 Page fonctionnement — `/fonctionnement`

Explique en quoi consiste la performance, basé sur les textes des éditions
précédentes (cf. `RElire Proust - flyer verso 2023 (1).docx` et les textes
extraits du PDF).

Sections :
- L'origine du projet (2019, San Francisco — cf. lien missionlocal.org)
- Le principe : 24h sans interruption, lecture collective à voix haute,
  Ateliers Mommen
- Le déroulé : sections de ~10 minutes, 2 passages minimum par lecteur,
  intervalle de 45 minutes minimum entre passages
- L'édition à utiliser (Folio classique 2022 révisée et augmentée)
- L'auberge espagnole / bar / espace douillet / la nuit
- Témoignage / mot de Nathalie

### 4.3 Pages éditions précédentes

Une page **index** `/editions` listant les 6 (ou 7) éditions sous forme de
grille chronologique : couverture du tome × année × titre de l'édition × extrait.

Une page **détail** `/editions/<slug>` par édition (ex. `/editions/2022-jeunes-filles-en-fleurs`),
avec :
- En-tête : tome, titre de l'édition, dates, lieu, organisateurices, partenaires
- **Galerie photos** (CMS-éditable)
- **Vidéos** (embed YouTube/Vimeo)
- **Enregistrements audio** (lecteur intégré, fichiers hébergés)
- **Témoignages écrits** (texte riche, citations de participants)
- Liens externes (presse, Facebook event, etc.)

> Données initiales : importer les témoignages et liens du PDF
> `24hdeproust.pdf` lors du premier remplissage du site.

### 4.4 Page interview de l'organisatrice — `/nathalie`

- Embed YouTube : https://www.youtube.com/watch?v=FHZyMDgpc1g
- Bio courte de Nathalie Vanderlinden
- Texte sur sa démarche (matière disponible dans les textes du PDF)

### 4.5 Page contact / inscription — `/inscription`

**Formulaire d'inscription** :

| Champ                      | Type        | Obligatoire |
| -------------------------- | ----------- | ----------- |
| Prénom                     | texte       | oui         |
| Nom                        | texte       | oui         |
| Email                      | email       | oui         |
| Téléphone                  | texte       | non         |
| Préférences de créneaux    | sélection   | oui         |
| Message libre              | textarea    | non         |
| Consentement RGPD          | case        | oui         |

**Préférences de créneaux** :
- Le formulaire propose **2 créneaux minimum, 4 créneaux maximum** d'1h chacun,
  à choisir parmi les plages de l'événement (ex. samedi 20h-21h, samedi 21h-22h,
  …, dimanche 19h-20h).
- L'organisatrice attribuera ensuite l'ordre de passage exact (sections de
  ~10 min) après inscription, par email — l'inscription web ne fixe que les
  préférences horaires.

**Confirmation** :
- Page de remerciement après envoi
- Email de confirmation auto au lecteurice
- Notification email à l'organisatrice (ou simplement visible dans l'admin)

**Page contact distinct** (si nécessaire) : email `24hdeproust@gmail.com`,
liens réseaux, adresse Ateliers Mommen, plan.

---

## 5. Site d'administration — `/admin`

### 5.1 Authentification

- Login + mot de passe (un seul compte admin pour démarrer, ou multi-comptes
  selon stack)
- Session sécurisée, HTTPS obligatoire
- Limitation des tentatives de connexion (anti-brute-force)
- 2FA optionnel (selon stack)

### 5.2 Gestion des inscriptions

- Liste paginée de toutes les inscriptions reçues (Panel, tri par date)
- Détail d'une inscription avec marquage de statut (en attente / confirmé / annulé)
- **Export CSV** (UTF-8 + BOM pour Excel) via `/panel/plugins/enpleinproust/export-csv`
- **Backup CSV** automatique à chaque inscription dans `/home/val/data/enpleinproust/inscriptions.csv`
  sur Avignon, **hors container** (volume Docker monté depuis l'hôte)
- **Email de confirmation** à l'inscrit·e : sujet et corps paramétrables dans le
  Panel (onglet "Config inscriptions" du site). Tags disponibles : `#PRENOM`,
  `#NOM`, `#EMAIL`, `#TELEPHONE`, `#CRENEAUX`, `#MESSAGE`
- **Email de notification** à une liste de destinataires configurable (séparés
  par virgules) dans le même onglet Panel
- **SMTP** : configuré via variables d'environnement dans `/home/val/docker/enpleinproust/.env`
  (non versionné) : `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASS`, `SMTP_FROM`

### 5.3 Gestion des médias

- Bibliothèque média (photos, vidéos, audio)
- Upload simple (drag & drop)
- Association à une édition / page
- Pour les vidéos longues : préférer l'embed YouTube/Vimeo plutôt que stocker

### 5.4 Édition des pages

- Toutes les pages publiques sont éditables (texte + images + médias)
- Éditeur WYSIWYG ou champs structurés selon stack
- Possibilité d'ajouter de nouvelles pages sans intervention dev (pour les
  besoins futurs : page presse, page partenaires, etc.)

### 5.5 Gestion des éditions

- Page de gestion dédiée par édition (ajout/édition de témoignages, médias,
  liens)
- Création d'une nouvelle édition (pour 2027 puis au-delà)

---

## 6. Stack technique

### 6.1 Choix retenu : **Kirby CMS** (flat-file PHP)

Validé avec Val le 2026-04-26.

| Critère                       | Pourquoi Kirby fit |
| ----------------------------- | ------------------ |
| Admin pour Nathalie           | **Kirby Panel** : interface d'admin moderne, sobre, pensée pour les éditeurices non-tech (bien plus propre que WP). |
| Pas de base de données        | Contenu stocké en fichiers texte/Markdown sur disque → backup = `tar` du dossier, versionnable en git. |
| Hébergement Avignon Docker    | Tourne dans un container `php:8.3-apache` standard, intégré à Traefik comme tout autre site `*.zitoon.com`. |
| Liberté de design             | Templates PHP écrits à la main → contrôle total HTML/CSS/JS pour l'identité artistique de l'affiche. |
| Pas de plugin treadmill       | Kirby = noyau stable, peu de plugins externes nécessaires. Surface d'attaque réduite. |
| Licence                       | **Gratuite pour usage non commercial / association** (En Plein Proust est un événement gratuit soutenu par la Commune et la FWB → éligible). |
| Inscriptions + export Excel   | À écrire en PHP custom (~80 lignes : controller `inscription.php` + page admin custom listant les inscriptions + export CSV/XLSX via [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io)). |

### 6.2 Plugins / dépendances Kirby

- **Kirby 4** (core)
- **PhpSpreadsheet** (via Composer) — export Excel des inscriptions
- **kirby-boilerplate** ou starter custom — point de départ propre
- Optionnel plus tard :
  - `bnomei/kirby3-feed` si on veut un flux RSS
  - `getkirby/staticache` si la perf devient un sujet (mise en cache HTML)

### 6.3 Modèle de contenu Kirby

Structure des **content blueprints** prévue :

```
site/blueprints/
├── pages/
│   ├── home.yml              # Page d'accueil
│   ├── fonctionnement.yml    # Page "comment ça marche"
│   ├── editions.yml          # Index des éditions (parent)
│   ├── edition.yml           # Une édition (enfant de editions/)
│   ├── nathalie.yml          # Interview
│   ├── inscription.yml       # Page formulaire (config des créneaux dispos)
│   └── default.yml           # Page générique pour ajouts futurs
├── files/
│   ├── photo.yml
│   ├── video.yml             # ou simple champ "embed YouTube"
│   └── audio.yml
└── users/
    └── admin.yml             # Rôle admin (Nathalie)
```

Une **édition** (page enfant de `editions/`) contient :
- `tome` (nombre 1-7)
- `titreEdition` (texte, ex. "Désacraliser Proust")
- `dates` (date début + fin)
- `lieu` (texte, défaut "Ateliers Mommen")
- `organisateurices` (liste structurée)
- `partenaires` (liste structurée)
- `description` (texte riche)
- `temoignages` (blocks ou structure répétable : auteur, date, texte)
- `galerie` (files multiples : photos)
- `videos` (liste : titre + url embed)
- `audio` (files multiples)
- `liens` (liste : titre + url)

**Données d'inscription** (stockées en fichiers JSON ou structure répétable Kirby
sous une page `inscriptions/` non publiée) :
- `prenom`, `nom`, `email`, `telephone` (optionnel)
- `creneaux` (array de 2-4 créneaux choisis)
- `message` (textarea, optionnel)
- `statut` (en attente / confirmé / annulé)
- `dateInscription` (timestamp auto)
- `consentementRgpd` (bool)

### 6.4 Alternatives évaluées (archivées)

| Stack | Verdict |
|-------|---------|
| WordPress + thème custom | Solide mais "marécage à plugins", treadmill sécurité, admin moins jolie. |
| Django + Wagtail | Pertinent en Python mais plus de code à maintenir. |
| Astro + Decap CMS | Beau mais fragmente l'inscription (service tiers) ; admin moins polie pour ajouter des pages. |
| Astro + Google Forms | Inscription/export Excel triviaux mais pas de CMS pour les pages. |
| Site statique fait main | Échec sur "Nathalie modifie les pages elle-même". |

---

## 7. Architecture / structure du projet

### 7.1 Repo local (Windows, `C:\WORK\Enpleinproust\`)

```
enpleinproust/
├── CLAUDE.md
├── docs/
│   ├── bugs/
│   ├── specs/
│   │   └── enpleinproust-spec.md
│   └── tasks/
│       └── TASKS.md
├── docker/
│   ├── docker-compose.yml        # service "enpleinproust" (php:8.3-apache)
│   ├── Dockerfile                # custom image : php + extensions + composer
│   └── apache-vhost.conf         # rewrite rules Kirby
├── kirby/                        # Code de l'app Kirby (monté en volume)
│   ├── index.php                 # bootstrap Kirby
│   ├── composer.json
│   ├── content/                  # ⚠ contenu éditable (pages + médias) — backupé séparément
│   │   ├── home/
│   │   ├── fonctionnement/
│   │   ├── editions/
│   │   ├── nathalie/
│   │   ├── inscription/
│   │   └── inscriptions/         # données du formulaire (non publié)
│   ├── site/
│   │   ├── config/
│   │   │   └── config.php
│   │   ├── blueprints/           # cf. §6.3
│   │   ├── templates/            # PHP par type de page
│   │   ├── snippets/             # header, footer, partials
│   │   ├── controllers/          # ex. inscription.php (POST handler)
│   │   ├── plugins/              # éventuels plugins custom (export-xlsx)
│   │   └── languages/            # FR (peut-être EN plus tard)
│   ├── assets/                   # CSS/JS/fonts/img du thème
│   │   ├── css/
│   │   ├── js/
│   │   ├── fonts/                # polices identifiées depuis l'affiche
│   │   └── img/
│   └── kirby/                    # sources Kirby (vendored ou via composer)
└── deploy/
    ├── traefik-route.yml         # à copier vers ~/docker/traefik/dynamic/
    └── README.md                 # procédure de déploiement vers Avignon
```

### 7.2 Déploiement sur Avignon (production)

Le service vit à côté de `platform` et `traefik` dans `~/docker/` :

```
~/docker/
├── traefik/                      # (existant)
│   └── dynamic/
│       └── enpleinproust.zitoon.com.yml   ← AJOUTÉ : route vers le container Kirby
├── platform/                     # (existant — sites statiques *.zitoon.com)
└── enpleinproust/                ← NOUVEAU
    ├── docker-compose.yml        # service "enpleinproust" (php:8.3-apache)
    ├── Dockerfile
    ├── apache-vhost.conf
    └── kirby/                    # même structure que dev — synchro via rsync ou git
```

**Routing Traefik** (`~/docker/traefik/dynamic/enpleinproust.zitoon.com.yml`) :

```yaml
http:
  routers:
    enpleinproust:
      rule: "Host(`enpleinproust.zitoon.com`)"
      entryPoints: [websecure]
      service: enpleinproust-svc
      priority: 10                # > 1 du HostRegexp de platform
      tls:
        certResolver: letsencrypt
  services:
    enpleinproust-svc:
      loadBalancer:
        servers:
          - url: "http://enpleinproust:80"
```

Le container Kirby rejoint le réseau Docker `web` partagé pour être joignable
par Traefik (cf. `avignon-spec.md` §2.3).

### 7.3 Flux de données sensibles (inscriptions)

- Soumission POST → controller `inscription.php` → écrit un fichier JSON
  horodaté dans `content/inscriptions/<timestamp>-<slug>.txt` (Kirby file-page
  pattern), invisible du site public
- Email de notification automatique à `24hdeproust@gmail.com`
- Email de confirmation au lecteurice
- Page admin custom `panel/inscriptions` : liste + filtres + export XLSX
- Backup quotidien du dossier `content/` via cron sur Avignon (à mettre en
  place — cf. roadmap)

---

## 8. Sécurité

- HTTPS obligatoire — certificat Let's Encrypt délivré automatiquement par
  Traefik (cf. `avignon-spec.md` §5)
- Admin Kirby Panel :
  - Mot de passe fort
  - Limitation des tentatives de connexion (config Kirby + éventuel rate-limit
    Apache via mod_evasive)
  - 2FA via plugin Kirby si disponible (à évaluer)
  - Restriction d'accès au Panel par IP LAN si possible (option : Traefik
    middleware comme pour `admin.zitoon.com`)
- Permissions filesystem : utilisateur `www-data` propriétaire de `content/`,
  pas d'exécution PHP dans `content/` ni `assets/uploads/`
- RGPD :
  - Consentement explicite sur le formulaire d'inscription
  - Page de politique de confidentialité publique
  - Mentions légales
  - Procédure documentée pour suppression des données sur demande

---

## 9. Hébergement & déploiement

### 9.1 Infrastructure cible

- **Serveur** : **Avignon** (`192.168.0.222`, IP publique `31.164.198.65`)
- **Domaine actuel** : `enpleinproust.zitoon.com` (sous-domaine provisoire)
- **Domaine futur** : à définir (potentiellement un .be ou .com dédié)
- **Reverse proxy** : Traefik v2.11 partagé (cf. `avignon-spec.md`)
- **SSL** : Let's Encrypt via file provider Traefik
- **Stack container** : `php:8.3-apache` + extensions (gd, mbstring, zip,
  intl) + Composer

### 9.2 Procédure de déploiement (initiale)

1. Construire l'image Kirby en local : `docker compose build`
2. Tester en local sur `http://localhost:8080` : `docker compose up`
3. Déployer sur Avignon via SSH :
   - Créer `~/docker/enpleinproust/` sur le serveur
   - `rsync` du code (`kirby/`, `Dockerfile`, `docker-compose.yml`)
   - `ssh avignon "cd ~/docker/enpleinproust && docker compose up -d --build"`
4. Créer `~/docker/traefik/dynamic/enpleinproust.zitoon.com.yml` (cf. §7.2)
   → certificat SSL délivré automatiquement
5. Vérifier : `curl -sv https://enpleinproust.zitoon.com/`

### 9.3 Sauvegardes

- **Code** : versionné via git (à initialiser)
- **Contenu** (`content/`) : backup quotidien rsync vers un dossier
  `~/backups/enpleinproust/` sur Avignon, rotation 30 jours
- **Inscriptions** : incluses dans le backup `content/inscriptions/`

---

## 10. Roadmap

### Phase 1 — Bootstrap (terminée)
- [x] Lecture des assets, identification du périmètre
- [x] Création CLAUDE.md, structure docs
- [x] Spec v0.1
- [x] Validation stack technique : Kirby
- [x] Spec v0.2 (Kirby + hébergement Avignon)
- [x] Clarification éditions : 2027 = Tome 6 Albertine disparue, pas de
      performance en 2025
- [x] Polices : shortlist Google Fonts (Big Shoulders / Anton + Inter +
      Cormorant), validation visuelle reportée en Phase 4

### Phase 2 — Setup technique
- [ ] Initialiser le repo git
- [ ] Créer `docker/Dockerfile` (php:8.3-apache + extensions + Composer)
- [ ] Créer `docker/docker-compose.yml` (service `enpleinproust`, volume
      `kirby/`, port 8080 en local)
- [ ] Créer `docker/apache-vhost.conf` (rewrite rules Kirby, document root
      `kirby/`)
- [ ] `composer require getkirby/cms` dans `kirby/`
- [ ] Vérifier que Kirby tourne en local : `docker compose up` →
      `http://localhost:8080`
- [ ] Configurer le Panel admin (créer utilisateur Nathalie)
- [ ] Tester : édition d'une page de démo via le Panel

### Phase 3 — Modèle de contenu
- [ ] Blueprints pages (home, fonctionnement, editions, edition, nathalie,
      inscription, default)
- [ ] Blueprints fichiers (photo, video, audio)
- [ ] Création des pages racine via Panel
- [ ] Création de la première édition de démo (par ex. Tome 5 — La Prisonnière)

### Phase 4 — Frontend (templates)
- [ ] Layout commun (header / footer / typo de l'affiche)
- [ ] Template `home` (composition affiche, portrait Proust)
- [ ] Template `fonctionnement`
- [ ] Templates `editions` (index) et `edition` (détail)
- [ ] Template `nathalie` (embed YouTube)
- [ ] Template `inscription` (form + JS validation 2-4 créneaux)
- [ ] Responsive mobile-first

### Phase 5 — Inscription & Admin custom
- [ ] Controller `inscription.php` : validation, écriture JSON, emails
- [ ] Page Panel custom : liste des inscriptions
- [ ] Plugin Kirby `export-xlsx` (PhpSpreadsheet)
- [ ] Tests : envoi email confirmation + notif organisatrice

### Phase 6 — Contenu réel
- [ ] Saisie des éditions 2019-2026 (témoignages du PDF + photos/vidéos
      existantes — par Nathalie ou import)
- [ ] Saisie de l'édition 2027 à venir
- [ ] Page interview avec embed YouTube et bio

### Phase 7 — Mise en ligne sur Avignon
- [ ] Build de l'image Docker en local
- [ ] Création `~/docker/enpleinproust/` sur Avignon
- [ ] rsync code + content
- [ ] Création `~/docker/traefik/dynamic/enpleinproust.zitoon.com.yml`
- [ ] Vérification SSL (cert Let's Encrypt délivré)
- [ ] Tests prod : navigateurs / mobile / Lighthouse
- [ ] RGPD : politique de confidentialité, mentions légales
- [ ] Mise en place du backup cron `content/`
- [ ] Communication ouverture site

---

## 11. Glossaire

- **La Recherche** : *À la recherche du temps perdu*, roman de Marcel Proust en
  7 tomes
- **Lecteurice** : personne qui s'inscrit pour lire à voix haute pendant
  l'événement
- **Section** : unité de découpage du livre (~10 minutes de lecture)
- **Créneau** : plage horaire d'1h pendant laquelle un·e lecteurice est présent·e
  (2 minimum, 4 maximum)
- **Auberge espagnole** : tradition de l'événement — chacun·e apporte de quoi
  partager (collations, soupe), bar ouvert
- **Ateliers Mommen** : lieu artistique bruxellois historique, hôte de
  l'événement depuis 2022
