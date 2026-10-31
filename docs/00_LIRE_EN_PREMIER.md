# SIRH — Contexte du projet et guide de lecture

## Identité
- Nom de l'application : **SIRH**.
- Type : ATS pédagogique spécialisé dans la gestion du recrutement ; ce n'est pas un SIRH paie/congés complet.
- Entreprise fictive du cas : **Digital Maroc Solutions**, Casablanca.
- Offre de référence : **Chargé(e) de Marketing Digital Junior**.
- Environnement : Windows + WampServer + Apache + PHP + MySQL/MariaDB.
- URL locale de référence : `http://localhost/SIRH/` (à adapter au chemin réel et à la configuration Apache).
- Aucun hosting, aucun domaine public, aucun déploiement Internet.

## Stack de référence
PHP 8.2+ (version exacte à vérifier), MVC personnalisé, MySQL 8.x ou MariaDB compatible avec les installations de l'équipe, PDO, InnoDB, `utf8mb4`, HTML5, CSS3, Bootstrap 5, JavaScript natif et AJAX. Composer peut être utilisé pour des bibliothèques PHP justifiées et compatibles. Aucun framework MVC lourd ou frontend SPA sans décision écrite et validation.

## Périmètre
Offres, portail de candidature local, candidats, CV, candidatures, présélection, scoring explicable, shortlist, pipeline Kanban, entretiens, évaluations, communications, notifications, reporting, exports, administration, paramètres, préférences, sécurité, audit et sauvegardes.

Hors périmètre de la première version : paie, congés, bulletins de salaire, LMS complet. Les fonctions avancées de parsing, IA générative, e-mail SMTP réel, vidéo différée réelle et intégrations externes restent Bonus.

## Comment piloter Qwen
1. Ouvrir le dossier racine du dépôt local relié à GitHub.
2. Vérifier le chargement de `QWEN.md` avec `/memory` si Qwen Code le permet.
3. Lire `AGENTS.md` et ce guide.
4. Pour ce pack de nouveau départ, démarrer avec `docs/PROMPTS_A_COPIER/00_NOUVEAU_PROJET_DEPUIS_ZERO_PHASE_00.md`. Ne pas utiliser un prompt de reprise d’un ancien dépôt.
5. Exécuter une seule phase à la fois, uniquement après validation de la phase précédente.

## Phases
| Phase | Livrable principal | Codage ? |
|---|---|---|
| 00 | Audit, cadrage, architecture, ERD, API, décisions | Non |
| 01 | Socle local PHP MVC, configuration, DB, routing | Oui après validation 00 |
| 02 | Authentification, rôles, permissions, Administration | Oui |
| 03 | Offres et portail candidat local | Oui |
| 04 | Candidats, documents, candidatures | Oui |
| 05 | Matching, scoring, présélection et IA | Oui |
| 06 | Pipeline, entretiens et évaluations | Oui |
| 07 | Communications et notifications | Oui |
| 08 | Dashboard, rapports, exports et finitions UX | Oui |
| 09 | Tests finaux, sécurité, sauvegardes, remise locale | Oui, corrections |

## Distinction importante
GitHub héberge le dépôt de code uniquement. L'application tourne localement sous WampServer sur chaque PC. Une éventuelle démonstration sur le réseau local (LAN) doit être temporaire, autorisée et sécurisée ; elle ne constitue pas un déploiement Internet.
