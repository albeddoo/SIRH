# Stratégie de migrations SQL et synchronisation des cinq bases locales

Sources : MP V3 §30, §24.18, règles 7–9 (`CONFIRMÉ MP`) ; PDF §15 contraintes qualité (`CONFIRMÉ PAR SOURCE`). **Aucune migration n'est écrite en Phase 00** — ce document définit la stratégie validable.

## 1. Principes

1. Toute évolution du schéma passe par une **migration versionnée dans Git** ; jamais de modification manuelle directe sur une base locale (règle 9 MP).
2. Une migration = un changement cohérent, **forward-only**, numérotée `NNNN_description.sql` (ex. `0001_create_users_roles_permissions.sql`).
3. Table technique `migrations(version PRIMARY KEY, applied_at, checksum)` pour connaître l'état de chaque base.
4. Séparation stricte : **schéma (migrations)** ≠ **données de référence minimales (seeders système)** ≠ **données de démonstration fictives (seeders demo)**. Seeders démo idempotents et réinitialisables (M12/demo_runs).
5. Aucune donnée personnelle réelle ni dump de base active dans Git ; pas de données sensibles dans les logs.
6. Chaque migration doit pouvoir s'appliquer sur une base **vierge** et sur une base **à jour N-1** ; testée avant merge PR.
7. Compatibilité MySQL 8.x (version commune à confirmer D-05) ; InnoDB ; utf8mb4_unicode_ci (ou 0900_ai_ci si validé uniforme — décision D-20 à trancher après relevé des versions).

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
- Reproductibilité : sur une base vierge, `migrate` rejoue NNNN… → état identique sur les 5 PC ; vérifié par checksum de structure (test d'installation propre, critère de sortie Phase 01/09).
- Un script CLI local (PHP, Phase 01) appliquera : liste des migrations non appliquées → exécution transactionnelle par lot → inscription `migrations` → rapport d'erreurs. Son existence est prévue ici, son code est interdit en Phase 00.

## 4. Synchronisation des cinq bases locales

Modèle : **cinq environnements indépendants, un seul schéma versionné**.

1. La vérité de schéma = dépôt GitHub (`database/migrations/*`). Chaque poste clone/pull puis exécute `migrate` sur SA base `sirh`.
2. Conflit de version détecté : si `migrations` local ≠ HEAD du dépôt → le poste doit tirer les nouvelles migrations ; toute divergence (migration modifiée après merge) est interdite : on ajoute une migration corrective, on n'édite jamais une migration déjà mergée (règle forward-only).
3. Données : seeders système (rôles, permissions, étapes, grille pédagogique v1) = migrations data ou seeders versionnés rejouables idempotents ; seeders démo (~150 candidatures fictives + 5 profils exacts) = commande dédiée réinitialisable par rôle autorisé.
4. Jamais de partage de dump entre postes pour « rattraper » le schéma ; jamais de base active/dump avec données personnelles dans Git.
5. Avant chaque release/soutenance : tag Git + checklist « les 5 postes sont au même lot de migrations » (T-33 installation propre).
6. Environnement de démonstration final : un poste désigné (accord équipe) sert de référence ; sa base est reconstruite depuis migrations+seeders (pas copiée) pour garantir la reproductibilité.

## 5. Sauvegarde avant migration

Avant tout `migrate` sur une base contenant des données de travail : export SQL + copie `storage/` vers `storage/backups/` horodaté (hors Git/HTTP) ; ne pas écraser la dernière sauvegarde valide avant vérification de la nouvelle ; restauration testée périodiquement sur base séparée (MP §30 règle 8, §24.18, T-28/T-34).

## 6. Rejet/rollback

Forward-only assumé : pas de down-migration automatique en MVP ; rollback = restauration de sauvegarde + nouvelle migration corrective. Documenté pour que l'équipe ne soit jamais surprise.

## 7. Décisions ouvertes liées

- D-05/D-01b : versions PHP/MySQL communes (conditionne collation et syntaxe autorisée).
- D-20 : choix de collation uniforme après relevé.
- D-21 : outil de migration — script maison minimal vs Composer/Phinx (recommandation : script maison simple conforme « MVC personnalisé », à valider).
- Rythme/validation des lots : M3 propriétaire du schéma, revue obligatoire avant merge (cf. `14_PLAN_GITHUB_EQUIPE.md`).
