# Plan d'intégration GitHub — développement individuel

> **MISE À JOUR CONTEXTUELLE (01/11/2026)** — Le propriétaire a confirmé être **le seul développeur du projet**. Les hypothèses d'équipe de 5 membres (MP V3 Annexe B) sont **abrogées pour l'organisation** : plus de CODEOWNERS, plus de répartition M1–M5, plus de revues croisées obligatoires. Le périmètre fonctionnel et les tests T-01→T-35 sont intégralement conservés. Traçabilité : décision **D-25** (`16_DECISIONS_EN_ATTENTE.md`). Titre du fichier conservé pour la stabilité des références croisées.

Sources : MP V3 Annexe B (**adaptée au contexte individuel**) + règles non négociables 1–6/10 (`CONFIRMÉ MP`, origine équipe). Le dépôt GitHub est un **dépôt personnel privé**, servant au versionnement (code, migrations, tests, docs) et à la sauvegarde, et **jamais** comme hébergement ; le code reste local sur le PC du développeur. Qwen Code intervient comme assistant de développement (pas comme compte Git distinct).

## 1. Organisation du dépôt

- Un dépôt unique `SIRH` (déjà initialisé localement avec le pack documentaire). Structure cible = celle validée en `03_ARCHITECTURE_TECHNIQUE.md` §2.
- Fichiers racine prévus (création Phase 01, pas maintenant) : `.gitignore`, `.env.example`, `composer.json`+`composer.lock`, `README.md`.
- Ignorés strictement : `.env*` réels, `vendor/`, `node_modules/`, `storage/uploads|exports|logs|backups`, dumps SQL, tout fichier de données personnelles.
- Modèles éventuels : `ISSUE_TEMPLATE/*`, `PULL_REQUEST_TEMPLATE.md` restent utilisables en solo (checklist personnelle) ; **CODEOWNERS supprimé** (sans objet sans équipe) → la dépendance « handles GitHub des 5 membres » (**D-22**) est **close par D-25**.

## 2. Workflow Git simplifié (solo)

1. Branche principale `main` = référence stable. En solo, le push direct sur `main` est autorisé ; une protection locale (règle disciplinaire documentée) maintient `main` toujours fonctionnelle.
2. Branches `feature/…` ou `fix/…` **si nécessaire** (tâche longue ou expérimentation risquée) ; sinon commits courts, atomiques et explicites directement sur `main`.
3. Avant chaque session : `git pull` (synchronisation avec la sauvegarde distante) ; après modification du schéma : appliquer les migrations localement immédiatement.
4. Pas d'auto-revue obligatoire : la revue qualité est remplacée par (a) l'exécution des tests locaux documentés avant chaque commit important, (b) la relecture par Qwen Code des diffs sensibles (auth/RBAC/migrations/exports), (c) l'validation finale du propriétaire aux jalons.
5. Jamais de force-push sur `main` ; conflits théoriquement inexistants (un seul auteur) — si un fork/assistant pousse, résolution locale puis test avant synchronisation.
6. Interdits dans Git (inchangés) : dump de base active, CV/documents/logs/sauvegardes, secrets, clés API, modification silencieuse d'une migration mergée (→ migration corrective).
7. Tags de release pour jalons (fin de phase, préparation soutenance) ; le contrôle « tous les postes au même lot de migrations » devient « environnement local + dépôt au même lot » (cf. D-26).

## 3. Responsabilités (développeur unique)

Les anciens rôles M1–M5 ne sont plus des personnes mais des **casquettes fonctionnelles** portées par le développeur unique, assisté de Qwen Code ; elles servent uniquement de regroupement thématique pour les issues/commits :

| Casquette | Domaine (traçabilité inchangée) |
|---|---|
| Produit & tests | Cahier des charges, T-01→T-35, démonstration |
| Sécurité & accès | Auth, RBAC, audit, sessions (ex-M2) |
| Données | Entités, migrations, seeders (~150 candidatures fictives), cas pédagogique exact (ex-M3) |
| Environnement & exploitation | WampServer/Apache/PHP/Composer, diagnostic local, installation reproductible, sauvegardes (ex-M4) |
| Interface | Bootstrap 5, tableaux/recherche/filtres, Kanban JS natif, responsive/accessibilité (ex-M5) |

Règles conservées (adaptées) : comptes de test séparés par rôle ; pas de partage de mot de passe ; documentation de bord (README/CHANGELOG) tenue à jour ; aucune fonctionnalité décorative livrée comme terminée. La règle « un compte par personne » n'a plus d'objet côté équipe mais reste valable pour les comptes applicatifs de démonstration.

## 4. Intégration avec les phases

- Phase 01 : création structure + `.gitignore`/`.env.example` + page de test locale + premières migrations (après validation utilisateur).
- Chaque phase : issues GitHub liées aux MVP/tests (traçabilité `12_...`) ; Definition of Done locale = migration appliquée sur l'environnement unique + tests concernés exécutés + docs mises à jour + commit/tag poussé sur le dépôt privé (sauvegarde).
- CI : pas de service cloud imposé (contexte local + confidentialité) ; vérifications par scripts locaux documentés. **D-23** (GitHub Actions limitée lint/test sans base) reste ouverte, désormais optionnelle en solo.

## 5. Informations humaines encore attendues

- Visibilité du dépôt (privé confirmé ; accès enseignante ? à décider).
- Règles de nommage des branches/issues à figer au kickoff (propositions ci-dessus valables par défaut).
- Confirmation que la sauvegarde distante GitHub suffit comme redondance (sinon plan de backup secondaire → risque R-16 dans `15_...`).
