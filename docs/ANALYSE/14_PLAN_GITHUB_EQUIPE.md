# Plan d'intégration GitHub et responsabilités de l'équipe

Sources : MP V3 Annexe B + règles non négociables 1–6/10 (`CONFIRMÉ MP`). Le dépôt GitHub est privé, sert au versionnement (code, migrations, tests, docs) et **jamais** comme hébergement ; le code reste local sur chaque PC.

## 1. Organisation du dépôt

- Un dépôt unique `SIRH` (déjà initialisé localement avec le pack documentaire). Structure cible = celle validée en `03_ARCHITECTURE_TECHNIQUE.md` §2.
- Fichiers racine prévus (création Phase 01, pas maintenant) : `.gitignore`, `.env.example`, `composer.json`+`composer.lock`, `README.md`.
- Ignorés strictement : `.env*` réels, `vendor/`, `node_modules/`, `storage/uploads|exports|logs|backups`, dumps SQL, tout fichier de données personnelles.
- Modèles déjà présents : `ISSUE_TEMPLATE/{bug,feature,task}.yml`, `PULL_REQUEST_TEMPLATE.md`, `CODEOWNERS` à compléter avec les vrais handles GitHub des 5 membres (information humaine manquante → **D-22**).

## 2. Workflow Git

1. Branche principale protégée (push direct interdit) ; développement uniquement par PR.
2. Une feature = une petite branche `feature/…` ou `fix/…` depuis la principale ; commits courts et explicites.
3. Avant chaque session : `git pull` ; après merge : chaque membre récupère et applique les migrations localement.
4. PR : template rempli (module, migrations ? oui/non, tests exécutés, captures si UI) ; revue obligatoire par ≥1 membre concerné + M2 pour sujets transverses (auth/RBAC/migrations/exports sensibles) ; **pas d'auto-merge**.
5. Conflits : résolus localement puis testés avant push ; jamais de force-push sur une branche partagée.
6. Interdits dans Git : dump de base active, CV/documents/logs/sauvegardes, secrets, clés API, modification silencieuse d'une migration mergée (→ migration corrective).
7. Tags de release pour jalons (fin de phase, préparation soutenance) ; checklist « 5 postes au même lot de migrations » avant tag.

## 3. Périmètres de responsabilité (5 membres — hypothèses à confirmer)

| ID | Domaine principal | Rôle technique attendu | Revues croisées |
|---|---|---|---|
| M1 | Coordination, cahier des charges, tests d'acceptation T-01→T-35, démonstration | PO/testeur | valide que chaque PR couvre son exigence |
| M2 | Authentification, RBAC, audit, sécurité, sessions | Gardien sécurité | revue obligatoire auth/permissions/exports |
| M3 | Base de données, entités, migrations, seeders (~150 candidatures fictives), cas pédagogique exact | Data owner | toute migration passe par sa revue + validation utilisateur |
| M4 | WampServer/Apache/PHP/Composer, diagnostic 5 postes, installation reproductible, sauvegardes locales | Ops | PV environnements (cf. `13_...`) |
| M5 | Interface Bootstrap 5, tableaux/recherche/filtres, Kanban JS natif, responsive/accessibilité | UI lead | ergonomie états vides/erreurs (T-18/T-32) |

Règles équipe imposées : un compte par personne ; comptes de test séparés par rôle ; pas de partage de mot de passe ; commits attribués à leur auteur réel ; documentation de bord (README/CHANGELOG) tenue à jour ; aucune fonctionnalité décorative livrée comme terminée.

## 4. Intégration avec les phases

- Phase 01 : création structure + `.gitignore`/`.env.example` + page de test commune + premières migrations (après validation utilisateur).
- Chaque phase : issues GitHub liées aux MVP/tests (traçabilité `12_...`) ; Definition of Done locale = migration appliquée sur les 5 postes + tests concernés exécutés + docs mises à jour.
- CI : pas de service cloud de build imposé (contexte local) ; vérifications faites par scripts locaux documentés + revues PR (choix à confirmer D-23 si la team veut une CI GitHub Actions limitée au lint/test sans accès base).

## 5. Informations humaines encore attendues

- **D-22** : usernames GitHub des 5 membres + acceptation invitations (le PDF note qu'ils n'ont pas été fournis).
- Visibilité du dépôt (privé confirmé MP ; accès enseignante ? à décider).
- Règles de nommage des branches/issues à figer en kickoff (propositions ci-dessus valables par défaut).
