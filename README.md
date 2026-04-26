# En Plein Proust

Site web de la performance collective **En Plein Proust** — lecture en 24h sans interruption d'un tome de *À la recherche du temps perdu* de Marcel Proust, aux Ateliers Mommen (Bruxelles).

**Édition à venir** : 2027 — Tome 6, *Albertine disparue*

## Stack

- **Kirby 4** (CMS flat-file PHP, pas de base de données)
- **Docker** : `php:8.3-apache` + Composer
- **PhpSpreadsheet** pour l'export Excel des inscriptions
- Hébergement : serveur Avignon (Debian/Docker LAN), derrière Traefik partagé

## Démarrer en local

```bash
cd docker
docker compose up --build         # premier lancement (build de l'image)
docker compose up                 # lancements suivants
```

→ http://localhost:8080
→ http://localhost:8080/panel (admin Kirby)

## Documentation

- `CLAUDE.md` — règles de workflow et commandes courantes
- `docs/specs/enpleinproust-spec.md` — **source de vérité** de l'application
- `docs/tasks/TASKS.md` — suivi de progression

## Déploiement

```bash
rsync -avz --delete kirby/ docker/ avignon:~/docker/enpleinproust/
ssh avignon "cd ~/docker/enpleinproust && docker compose up -d --build"
```
