# Stratégie de migrations SQL et synchronisation de la base locale

> **MISE À JOUR CONTEXTUELLE (01/11/2026)** — Développement **individuel** confirmé par le propriétaire (voir D-25, `16_DECISIONS_EN_ATTENTE.md`) : un seul environnement WampServer, une seule base locale. La « synchronisation des cinq bases » est remplacée par la discipline « **un dépôt versionné = une vérité de schéma, appliquée immédiatement sur l'environnement unique** ». Les principes de reproductibilité sont **intégralement conservés** (exigence du propriétaire). Titre du fichier conservé pour la stabilité des références croisées.

Sources : MP V3 §30, §24.18, règles 7–9 (`CONFIRMÉ MP`, origine équipe → adaptée solo) ; PDF §15 contraintes qualité (`CONFIRMÉ PAR SOURCE`). **Aucune migration n'est écrite en Phase 00** — ce document définit la stratégie validable.

## 1. Principes

1. Toute évolution du schéma passe par une **migration versionnée dans Git** ; jamais de modification manuelle directe sur une base locale (règle 9 MP).
2. Une migration = un changement cohérent, **forward-only**, numérotée `NNNN_description.sql` (ex. `0001_create_users_roles_permissions.sql`).
3. Table technique `migrations(version PRIMARY KEY, applied_at, checksum)` pour connaître l'état de chaque base.
4. Séparation stricte : **schéma (migrations)** ≠ **données de référence minimales (seeders système)** ≠ **données de démonstration fictives (seeders demo)**. Seeders démo idempotents et réinitialisables (M12/demo_runs).
5. Aucune donnée personnelle réelle ni dump de base active dans Git ; pas de données sensibles dans les logs.
6. Chaque migration doit pouvoir s'appliquer sur une base **vierge** et sur une base **à jour N-1** ; testée avant commit/tag (en solo : double vérification manuelle — base de travail + recréation propre).
7. Compatibilité MySQL 8.x ou MariaDB (**version réelle du poste unique à confirmer au relevé D-05**) ; InnoDB ; utf8mb4_unicode_ci (ou 0900_ai_ci si validé — décision D-20 à trancher après relevé de la version installée).

## 2. Ordre logique des migrations (plan par phase — contenu réel produit en Phase 01+)

| Lot | Phases | Contenu | Tables concernées |
|---|---|---|---|
| 0001 | P01 | Périmètre + table `migrations` + référentiels techniques | migrations, settings (structure) |
| 0002 | P01 | Accès : comptes, rôles, permissions, sessions, invitations | users, roles, permissions, role_permissions, user_roles, sessions, user_invitations |
| 0003 | P01 | Organisation | companies, departments, referentiels (villes, contract_types, work_time_types, sources, languages, levels…) |
| 0004 | P02 | Audit & préférences | audit_logs, user_preferences |
| 0005 | P03 | Offres | jobs, job_requirements (+ index reference/statut) |
| 0006 | P04 | Candidats & documents | candidates, educations, experiences, skills, skill_aliases, candidate_skills, candidate_languages, resumes/candidate_documents, storage_objects, favorites, tags, application_tags |
| 0007 | P04 | Candidatures & pipeline | applications, pipeline_stages, pipeline_transitions, pipeline_history, application_notes |
| 0008 | P05 | Scoring versionné | scoring_templates, scoring_criteria, application_scores, score_details, score_adjustments |
| 0009 | P06 | Entretiens | interviews, interviewers, interview_questions, evaluation_templates, evaluation_criteria, interview_evaluations, video_sessions |
| 0010 | P07 | Communications | messages, notification_templates, internal_notifications |
| 0011 | P08 | Reporting/exports | exports, saved_report_templates |
| 0012 | P08/P09 | Conformité & exploitation | retention_policies, consent_records, feature_flags, demo_runs, setting_versions |
| 00xx | P09+ | Ajustements issus des tests (index additionnels, contraintes) | au cas par cas, toujours via nouvelle migration |

Contraintes à poser dès ces lots : FK ON DELETE restrict/set null selon traçabilité (jamais cascade destructrice sur historique/audit) ; uniques (users.email, skills nom normalisé, (candidate,skill), (interview,user) évaluation…) ; index : applications(statut), applications(job_id,statut), candidates(email), jobs(reference,statut), audit_logs(created_at,user_id), scores(application_id, template_version).

## 3. Schéma de référence reproductible

- Objectif : `database/schema.sql` **régénéré** (export de la base après application de toutes les migrations) comme snapshot de contrôle, non comme source d'édition.
- Reproductibilité : sur une base vierge, `migrate` rejoue NNNN… → état identique à celui du dépôt ; vérifiée périodiquement par recréation propre de la base locale (test d'installation propre, critère de sortie Phase 01/09). Cette exigence est **maintenue intégralement en développement individuel** : c'est le garant de la crédibilité de T-33 et de la soutenabilité du projet.
- Un script CLI local (PHP, Phase 01) appliquera : liste des migrations non appliquées → exécution transactionnelle par lot → inscription `migrations` → rapport d'erreurs. Son existence est prévue ici, son code est interdit en Phase 00.

## 4. Synchronisation — environnement unique + dépôt distant

Modèle : **un environnement local, un dépôt Git privé comme source de vérité** (la synchronisation multi-postes est sans objet depuis la confirmation du développement individuel, D-25).

1. La vérité de schéma = dépôt GitHub (`database/migrations/*`). Le développeur applique `migrate` sur SA base `sirh` immédiatement après tout changement mergé/commité touchant le schéma.
2. Conflit de version détecté : si `migrations` local ≠ HEAD du dépôt → appliquer les nouvelles migrations avant toute autre évolution ; toute divergence (migration modifiée après commit) est interdite : on ajoute une migration corrective, on n'édite jamais une migration déjà commitée (règle forward-only).
3. Données : seeders système (rôles, permissions, étapes, grille pédagogique v1) = migrations data ou seeders versionnés rejouables idempotents ; seeders démo (~150 candidatures fictives + 5 profils exacts) = commande dédiée réinitialisable par rôle autorisé.
4. Jamais de dump de base active avec données dans Git ; la reconstruction passe toujours par migrations + seeders.
5. Avant chaque release/soutenance : tag Git + vérification « environnement local et dépôt au même lot de migrations » ; installation propre rejouée (cf. §3). En cas de démonstration sur une machine tierce (ex. soutenance), la procédure clone+migrate+seed doit fonctionner sans adaptation → c'est l'esprit conservé de T-33 (définition officielle inchangée ; modalités d'exécution à revalider par le propriétaire, cf. D-26).
6. Environnement de démonstration : la machine du développeur sert de référence ; sa base peut être reconstruite à tout moment depuis migrations+seeders (pas copiée) pour garantir la reproductibilité.

## 5. Sauvegarde avant migration

Avant tout `migrate` sur une base contenant des données de travail : export SQL + copie `storage/` vers `storage/backups/` horodaté (hors Git/HTTP) ; ne pas écraser la dernière sauvegarde valide avant vérification de la nouvelle ; restauration testée périodiquement sur base séparée (MP §30 règle 8, §24.18, T-28/T-34). En contexte individuel, cette discipline est **renforcée** (aucun second poste de secours humain) : les sauvegardes locales + le dépôt privé GitHub constituent la seule redondance (risque R-16, `15_...`).

## 6. Rejet/rollback

Forward-only assumé : pas de down-migration automatique en MVP ; rollback = restauration de sauvegarde + nouvelle migration corrective. Documenté pour que le développeur ne soit jamais surpris.

## 7. Décisions ouvertes liées

- D-05/D-01b : versions PHP & MySQL/MariaDB **réelles du poste unique** (conditionnent collation et syntaxe autorisée) — à relever sur le PC du développeur, aucune valeur inventée.
- D-20 : choix de collation selon la version relevée.
- D-21 : outil de migration — script maison minimal vs Composer/Phinx (recommandation : script simple conforme « MVC personnalisé », à valider).
- D-26 : modalités d'exécution de T-33 en développement individuel (une machine vs validation sur machine tierce de soutenance) — à confirmer par le propriétaire.
- Rythme/validation des lots : le développeur unique est propriétaire du schéma ; auto-contrôle documenté + validation du propriétaire aux jalons (cf. `14_PLAN_GITHUB_EQUIPE.md`).
