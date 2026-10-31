# Modèle conceptuel et logique de données — base `sirh`

Sources : PDF §15 + MP V3 §33–35 (`CONFIRMÉ PAR SOURCE`). Ce document est **conceptuel/logique** : aucun DDL exécutable n'est produit en Phase 00 (interdiction utilisateur). Types SQL définitifs = Phase 01 après validation.

## 1. Principes directeurs

- Un candidat ≠ une candidature : le profil est partagé, chaque candidature a son statut, son score et son historique.
- Jamais tout dans un seul tableau ; clés étrangères réelles ; InnoDB ; `utf8mb4` ; index sur champs fréquents (offre, statut, date, candidat, e-mail).
- E-mail normalisé (trim+lowercase) pour la détection de doublon, **sans fusion automatique** ; identité jamais déduite du seul nom.
- Dates/horodatages stockés UTC cohérents ; affichage selon fuseau configuré.
- Transactions pour les opérations multi-tables (dépôt candidature, changement de statut, recalcul…).
- Suppression logique/archivage quand la traçabilité l'exige (`deleted_at`, statuts, archivage) selon politique de conservation.
- Versionnement : grilles de scoring, paramètres sensibles et modèles conservent historique + auteur.

## 2. Entités du PDF (toutes requises) et extensions MP

### Cœur organisation & accès
| Table | Rôle | Clés/contraintes notables |
|---|---|---|
| `users` | Comptes internes | email unique, password_hash, statut (invité/en_attente/actif/suspendu/désactivé), last_login, created_by |
| `roles` | Rôles système+personnalisés | code unique, is_system |
| `permissions` | Permissions granulaires module.action | code unique (ex. `job.create`, `cv.download`) |
| `role_permissions` | Association rôle↔permission | PK composite |
| `user_roles` | Affectations | (user,role) unique + scope éventuel (département/offre) |
| `sessions` | Sessions révocables côté serveur | token hash, user_id, expires_at, revoked_at |
| `user_invitations` | Invitations expirantes | email, role, token_hash, expires_at, used_at |
| `user_preferences` | Préférences personnelles (§25) | user_id FK unique par préférence ; langue, thème, fuseau, formats, widgets, vues sauvegardées ; **aucun effet sur permissions** |
| `companies` | Entreprise (DMS) | nom, coordonnées, logo (→storage_objects), branding |
| `departments` | Départements | company_id FK, nom unique par entreprise, archived_at |

### Recrutement
| Table | Rôle | Clés/contraintes notables |
|---|---|---|
| `jobs` | Fiches de poste | reference unique auto/saisie, company_id, department_id, manager/recruiter users, résumé/missions/contexte/avantages, formation_min, domaine, expérience_min, ville, contract_type_id, work_time, publiee_at, cloture_at, nb_postes, scoring_template_id, statut ENUM(brouillon,à_valider,publiée,suspendue,clôturée,archivée) |
| `job_requirements` | Critères du poste | job_id FK, skill_id FK, type (obligatoire/souhaité/informatif), poids/priorité, libellé |
| `candidates` | Profil candidat (N:1 vs candidatures) | nom, prénom, email normalisé, téléphone, ville, liens pro, source_id, statut_profil, consent/info flag + date, created_at/by, archived_at/deleted_at ; index email |
| `resumes` / `candidate_documents` | CV original + pièces jointes | candidate_id FK, storage_object_id FK, type doc, nom_original_affiché, uploaded_at/by, statut |
| `educations` | Formation | candidate_id, diplôme, spécialité, établissement, année, niveau ; jamais déduit si absent |
| `experiences` | Expérience | candidate_id, poste, employeur, date_début, date_fin, missions ; durée calculée ; contrôle chevauchements applicatif |
| `skills` | Référentiel compétences | nom normalisé unique, catégorie/famille, archived_at |
| `skill_aliases` | Synonymes contrôlés (historique conservé) | skill_id FK, alias, approuvé_par, approuvé_le |
| `candidate_skills` | Relation M:N | (candidate,skill) unique, niveau (si justifié), provenance (déclarée/extraite/vérifiée), statut_validation |
| `candidate_languages` | Langues | candidate_id, langue_id, niveau documenté ; distinguer non renseigné / insuffisant |
| `applications` | Candidature candidat↔offre | candidate_id+job_id (unique ou alerte doublon paramétrée), statut pipeline, source, recruiter assigné, numéro_candidature (portail), consent_ref, created_at |
| `pipeline_stages` | Étapes administrables | ordre, final?, confirmation_requise, archived_at (jamais suppression si utilisée) |
| `pipeline_transitions` | Transitions permises | from_stage,to_stage, roles autorisés |
| `pipeline_history` | Historique statuts | application_id, ancien/nouveau statut, auteur, horodatage, motif |
| `application_notes` | Notes internes (séparées vue candidat) | application/candidate, auteur, contenu, visible_rh_only |
| `favorites`,`tags`,`application_tags` | Favoris/étiquettes sans effet score | uniques |

### Scoring (versionné, explicable)
| Table | Rôle | Contraintes |
|---|---|---|
| `scoring_templates` | Modèles de grille | nom, version, validée_par/at, published_at, archived_at ; somme poids = 100 (règle explicite alternative paramétrable) ; règle de départage active (`NULL` = Option E provisoire D-08, 2026-10-31 : égalité + revue humaine ; décision définitive ouverte) |
| `scoring_criteria` | Critères pondérés | template_id FK, libellé, poids, type (obligatoire/souhaité/informatif), règle/paramètres JSON logique, seuils indicatifs, priorité départage |
| `application_scores` | Score total | application_id, template_version_id, total, déclenché par/date, mode (auto/manuel), **figé à la date de calcul** |
| `score_details` | Points par critère | score_id FK, criterion_id, points, statut_donnée ENUM(oui,non_observe,a_verifier,absence_confirmee,sans_objet), justification/preuve, champ_source |
| `score_adjustments` | Corrections manuelles | ancien/nouveau, motif, auteur, date (traçabilité exigée MP §18) |

### Entretiens, communications, reporting, technique
| Table | Rôle | Contraintes |
|---|---|---|
| `interviews` | RDV | application_id, stage, datetime UTC+durée, type (présentiel/visio/vidéo différée), lieu/lien (visible participants), statut (à_planifier→absent), responsable |
| `interviewers` | Participants | interview_id+user_id unique, rôle participant |
| `interview_questions` / `evaluation_templates` / `evaluation_criteria` | Modèles versionnés (auteur, version) | échelle 1–5, critères PDF §21 |
| `interview_evaluations` | Fiche par évaluateur/entretien | notes par critère (→ `evaluation_scores`), preuve/question liée, recommandation ENUM(favorable,à_approfondir,défavorable) |
| `video_sessions` | Simulation vidéo différée | questions, temps préparation/réponse, statut session, observations (pas de média réel au MVP) |
| `messages` | Communications émises/simulées | application/candidate, template_id, canal, statut ENVOI ENUM(simulé,prévu,envoyé,échec) — « envoyé » uniquement sur confirmation réelle du service |
| `notification_templates` | Modèles multi-langues | événement déclencheur, variables autorisées, langue |
| `internal_notifications` | Centre notifications | user_id, lu_at |
| `exports` | Historique exports | type, format, filtres JSON, colonnes JSON, fichier (storage_object), demandeur, date, journalisé si sensible |
| `saved_report_templates` | Modèles d'export réutilisables | owner, config JSON |
| `audit_logs` | Journal append-only | utilisateur, action, objet, ancien/nouveau, ip locale, résultat, date ; **jamais mdp/secrets/CV complets** ; pas de modification via UI normale |
| `settings` | Paramètres globaux | clé unique, valeur typée, validated_by |
| `setting_versions` | Historique paramètres sensibles | old/new, auteur, date |
| `retention_policies` | Durées de conservation | par catégorie/doc, décision à valider (D-19) |
| `consent_records` | Information/consentement | personne, finalité, base légale, date, preuve |
| `storage_objects` | Métadonnées fichiers | nom_interne_aléatoire, taille, mime_réel, propriétaire, sha256, statut, chemin hors public |
| `feature_flags` | Activation contrôlée fonctions | code, activé, contexte démo/bonus |
| `demo_runs` | Exécutions/réinitialisations démo | déclencheur, périmètre supprimé, résultat |
| Référentiels | `cities`, `contract_types`, `work_time_types`, `sources`, `job_families`, `languages`, `levels`, `refusal_reasons`… | valeurs archivables, jamais supprimées si utilisées |

## 3. Relations principales (cardinalités)

- company 1—N departments 1—N jobs
- jobs 1—N applications ; candidates 1—N applications ; (candidate,job) → alerte doublon paramétrée
- candidate 1—N {documents, educations, experiences} ; candidate N—M skills via candidate_skills ; candidate N—M langues
- application N—1 scoring_template(version) ; application 1—N application_scores 1—N score_details
- application 1—N pipeline_history ; application 1—N interviews 1—N interviewers ; interview 1—N interview_evaluations (une par évaluateur)
- application 1—N messages ; user 1—N user_roles N—1 roles 1—N role_permissions N—1 permissions
- documents/exports/logos → storage_objects (1—1 usage courant, historisable)
- audit_logs/settings_versions/consent_records reliés aux entités tracées par (table, id) polymorphes assumés en phase logique

Diagramme textuel (regroupements) :

```text
[users/roles/permissions]──┐
[companies/departments]────┴─►[jobs]◄──[job_requirements]──►[skills/skill_aliases]
[candidates]──►[applications]◄──[jobs]
[candidates]──►[educations|experiences|candidate_skills|candidate_languages|candidate_documents→storage_objects]
[applications]──►[application_scores→score_details]──►[scoring_templates→scoring_criteria]
[applications]──►[pipeline_history]──►[pipeline_stages/transitions]
[applications]──►[interviews→interviewers/interview_evaluations/video_sessions]
[applications]──►[messages]──►[notification_templates]
 trasverses : [audit_logs][settings/setting_versions][exports/saved_report_templates]
              [consent_records/retention_policies][feature_flags/demo_runs][sessions/user_invitations/user_preferences]
```

## 4. Dictionnaire des données (extraits critiques)

| Champ | Règle |
|---|---|
| `users.email` | normalisé, unique ; ne révèle pas l'existence d'un compte lors d'une réinitialisation |
| `users.password_hash` | `password_hash()` bcrypt/argon2i selon version PHP retenue ; jamais clair |
| `jobs.reference` | unique, générée ou saisie selon paramètre |
| `applications.numero_candidature` | exposé au portail local (confirmation) ; non séquentiel prévisible (PROPOSITION) |
| `candidates.*` | données personnelles : minimisation, finalité recrutement, conservation bornée |
| `score_details.statut_donnée` | cœur de l'honnêteté algorithmique : « non documenté » ≠ 0 définitif hors cas pédagogique |
| `scoring_templates.version+règle_départage` | fige la règle au moment du calcul ; D-08 : `NULL` retenu provisoirement (Option E, 2026-10-31) jusqu'à validation définitive |
| `messages.statut` | « envoyé » interdit sans acquittement réel du service (T-27) |
| `storage_objects.nom_interne` | aléatoire cryptographique ; nom original conservé comme métadonnée affichée |
| dates | UTC en base ; conversion fuseau à l'affichage uniquement |

## 5. Catalogue canonique des tables (recompté et classifié — correction A-03/A-04)

Recompte officiel effectué lors de l'audit documentaire : le catalogue ci-dessous est la **référence canonique**. Les mentions « ~35 » ou « ~45 » antérieures sont remplacées par ce décomptage justifié. Distinction : tables **métier**, de **liaison**, de **référence**, techniques, d'**audit/historique**.

### 5.1 Tables métier (26)
| # | Table | Classification |
|---|---|---|
| 1 | users | métier |
| 2 | user_preferences | métier |
| 3 | user_invitations | métier |
| 4 | companies | métier |
| 5 | departments | métier |
| 6 | jobs | métier |
| 7 | job_requirements | métier |
| 8 | candidates | métier |
| 9 | educations | métier |
| 10 | experiences | métier |
| 11 | applications | métier |
| 12 | application_notes | métier |
| 13 | scoring_templates | métier (versionné) |
| 14 | scoring_criteria | métier (versionné) |
| 15 | application_scores | audit/historique (scoré figé) |
| 16 | score_details | audit/historique |
| 17 | score_adjustments | audit/historique (corrections motivées) |
| 18 | interviews | métier |
| 19 | interview_questions | métier (modèles versionnés) |
| 20 | evaluation_templates | métier (versionné) |
| 21 | evaluation_criteria | métier (versionné) |
| 22 | interview_evaluations | métier |
| 23 | video_sessions | métier (simulation D-12) |
| 24 | messages | métier |
| 25 | notification_templates | métier |
| 26 | internal_notifications | métier |

### 5.2 Tables de liaison (10)
| # | Table | Relie / rôle |
|---|---|---|
| 27 | roles | référentiel d'accès lié via user_roles/role_permissions |
| 28 | permissions | référentiel d'accès lié via role_permissions |
| 29 | role_permissions | roles ↔ permissions |
| 30 | user_roles | users ↔ roles (+ scope éventuel) |
| 31 | skills | référentiel compétences lié via candidate_skills/job_requirements |
| 32 | candidate_skills | candidates ↔ skills |
| 33 | candidate_languages | candidates ↔ languages |
| 34 | favorites | users ↔ applications/candidates (favoris) |
| 35 | application_tags | applications ↔ tags |
| 36 | interviewers | interviews ↔ users (participants, unique interview+user) |

Convention explicite : `tags` est classée **référence** (§5.4), `application_tags` est la **liaison**. Aucune table n'est comptée deux fois.

### 5.3 Tables techniques (4)
| # | Table | Rôle |
|---|---|---|
| 37 | sessions | révocation serveur (MP §32/§33) |
| 38 | storage_objects | métadonnées fichiers privés (`09_...`) |
| 39 | feature_flags | activation contrôlée fonctions/démo/bonus |
| 40 | **migrations** | table technique de suivi des migrations SQL (`version PRIMARY KEY, applied_at, checksum`) — voir §5.6 (correction A-04) |

### 5.4 Tables de référence (11)
| # | Table | Contenu |
|---|---|---|
| 41 | cities | référentiel villes |
| 42 | contract_types | types de contrat |
| 43 | work_time_types | temps de travail |
| 44 | sources | origines des candidatures |
| 45 | job_families | familles de postes |
| 46 | languages | référentiel langues |
| 47 | levels | niveaux (formation/compétence/langue) |
| 48 | pipeline_stages | étapes administrables |
| 49 | tags | étiquettes (référentiel) |
| 50 | refusal_reasons | motifs normalisés |
| 51 | skill_aliases | synonymes contrôlés (référentiel administré) |

### 5.5 Tables d'audit / historique / conformité / config (13)
| # | Table | Rôle |
|---|---|---|
| 52 | pipeline_transitions | règles de transition (config auditable) |
| 53 | pipeline_history | historique statuts (append) |
| 54 | resumes | CV versions (historique documents) |
| 55 | candidate_documents | pièces jointes rattachées (métadonnées via storage_objects) |
| 56 | exports | journal des exports |
| 57 | saved_report_templates | modèles d'export persistés |
| 58 | audit_logs | journal append-only global |
| 59 | settings | paramètres globaux (config) |
| 60 | setting_versions | historique valeurs sensibles |
| 61 | retention_policies | durées de conservation (D-19) |
| 62 | consent_records | information/consentement horodatés |
| 63 | demo_runs | journal réinitialisations démo |
| 64 | evaluation_scores | notes par critère reliées à interview_evaluations (détail historisé) |

*(Note : settings/pipeline_transitions/resumes relèvent d'une double classification config/historique ; elles sont comptées ici une seule fois. `evaluation_scores` découle explicitement de la ligne « notes par critère (→ evaluation_scores) » du §2 ; si l'utilisateur préfère la stocker en JSON dans `interview_evaluations`, le total canonique deviendrait 63 — variante à 63 tables inscrite au registre sous **D-24 (ouverte — aucune fusion sans validation explicite du propriétaire)** ; le catalogue canonique documenté reste celui des **64 tables**.)*

### 5.6 Total canonique et justification
- **Total retenu : 64 tables nommées distinctes** dans le modèle logique (dont 1 purement technique hors périmètre métier : `migrations`).
- Répartition exacte : **26 métier · 10 liaison · 4 techniques · 11 référence · 13 audit/historique/conformité/config = 64**.
- Justification du nombre supérieur aux « ~35 » évoqués en Phase 00 initiale : le MP V3 impose des exigences supplémentaires non présentes dans le PDF (user_preferences, sessions, storage_objects, retention_policies, consent_records, setting_versions, feature_flags, demo_runs, skill_aliases, video_sessions…), chacune nécessitant sa propre table pour respecter les règles de traçabilité, versionnement et séparation des responsabilités. Forcer artificiellement le chiffre à 35 aurait conduit à fusionner des tables et casser ces règles.
- La table `migrations` (A-04) est **explicitement classée technique d'infrastructure** : elle ne fait pas partie du domaine métier mais figure au catalogue pour l'exhaustivité ; elle est créée par le lot 0001 (`08_...` §2).
- Toute évolution (ex. import massif Bonus : `import_jobs`/`import_rows`, portail authentifié) ajoutera des tables **par nouvelle décision validée**, jamais silencieusement.

Chaque table sera matérialisée en migrations ordonnées en Phase 01+ (plan : `08_MIGRATIONS_ET_SYNCHRONISATION.md`).

## 6. Ouvertures liées aux décisions

- Tables IA/e-mail externes : schéma sans secret en clair (clés via config locale/chiffrées) — fournisseur désactivé par défaut (D-07/D-18).
- Portail candidat authentifié (Bonus) : réutiliser `users` avec rôle candidat + `consent_records` ; sinon dépôt sans compte (MVP, confirmé MP §12).
- Import massif (Bonus) : tables `import_jobs`/`import_rows` à ajouter seulement si D-10 évolue.
