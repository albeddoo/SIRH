# Organisation de l'équipe SIRH — 5 membres

## Composition et responsabilités
| Membre | Niveau | Responsabilité principale | Contributions |
|---|---|---|---|
| M1 | Débutant | Coordination documentaire, QA et tests | Scénarios T-01 à T-20+, données fictives, guides, rapport de bugs, petites interfaces Préférences sous revue. |
| M2 | Débutant | Frontend et UX | Layout, Dashboard UI, Offres UI, portail candidat local, formulaires, tables et responsive Bootstrap. |
| M3 | Intermédiaire | Tech Lead, PHP MVC, SQL, Auth et Administration | Architecture, schéma DB, migrations de base, PDO, routing, sécurité, rôles, paramètres globaux, audit. |
| M4 | Intermédiaire | Candidats, documents, candidatures, Matching et Scoring | Fiches, upload CV, recherche, extraction/parsing, synonymes, scoring versionné, shortlist. |
| M5 | Intermédiaire | Workflow et opérations RH | Kanban, transitions, entretiens, évaluations, communications, notifications, reporting et exports. |

Le rôle exact de chacun peut être rééquilibré après l'analyse de compétences de Phase 00, mais chaque module conserve un propriétaire clairement identifié.

## Matrice Owner / Support
| Module | Owner | Support |
|---|---|---|
| Architecture PHP MVC | M3 | M4, M5 |
| Base de données et conventions de migration | M3 | M4, M5 |
| Authentification / RBAC | M3 | M2 UI, M1 QA |
| Administration centrale | M3 backend | M2 UI, M1 QA |
| Paramètres globaux | M3 | M2 |
| Préférences personnelles | M1 UI simple | M2 UI, M3 backend |
| Design system / layout / dashboard UI | M2 | M1 |
| Offres et portail local | M2 UI | M3 backend |
| Candidats / candidatures / CV | M4 | M2 UI, M3 revue DB |
| Matching / scoring / shortlist | M4 | M3 DB, M1 tests |
| Pipeline / entretiens | M5 | M3 API, M2 UI |
| Communications / notifications | M5 | M3, M1 tests |
| Reporting / exports | M5 | M2 UI, M1 validation |
| Documentation et scénario de soutenance | M1 | Tous |
| Validation intégrée | M1 coordonne | Tous |

## Environnement local des cinq postes
Chaque membre travaille sur son propre WampServer et sa propre base `sirh`. Documenter les versions d'Apache, PHP, MySQL/MariaDB et les extensions. Partager uniquement le code, les migrations, les seeders et la documentation. Ne jamais versionner une base active ni un dump contenant des données personnelles.

## Workflow GitHub
- `main` : version stable et validée.
- `develop` : intégration de l'équipe.
- `feature/<module>-<ticket>` : nouvelle fonctionnalité.
- `fix/<bug>-<ticket>` : correction.
- Jamais de travail direct sur `main`.
- Pull Request vers `develop`, Issue liée, tests/migrations décrits, revue avant merge.
- L'agent Qwen ne commit/push/merge pas sans instruction explicite.

## Live Coding
GitHub est la source officielle du code. Live Share/partage d'écran est réservé au pair programming et au debugging. Un seul conducteur modifie le même fichier pendant une session ; l'autre guide et relit. Ne pas partager `.env`, mots de passe, CV réels ou terminal sensible.

## Routine
- Deux points de coordination courts par semaine.
- Une revue intégrée/démonstration par semaine.
- Chaque membre signale : terminé, en cours, blocage, fichiers, migration, tests, PR et tâche suivante.
