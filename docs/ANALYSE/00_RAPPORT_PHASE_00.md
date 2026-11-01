# RAPPORT PHASE 00 — SIRH (ATS local WampServer)

> Date : 2026-11-01 · Statut : **Corrections restantes de la Phase 00 achevées (A-03/A-04, A-05, A-07, A-08, D-08 provisoire, D-16 validée) — contrôle documentaire intégral effectué — en attente de validation humaine pour la Phase 01**
> Périmètre de ce livrable : analyse et cadrage uniquement. Aucun code PHP/JS/SQL, aucune migration, aucun squelette applicatif.

## 1. Statut du dépôt (vérifié)

| Élément | Constat | Source |
|---|---|---|
| Projet | Entièrement neuf : aucun `app/`, `public/`, `vendor/`, `.env` ou SQL applicatif | Inspection arborescence + `git status` propre |
| Contenu | Pack documentaire (`docs/`, `references/`, `QWEN.md`, `AGENTS.md`, `MANIFEST.json`, modèles GitHub) | `MANIFEST.json` (39 fichiers listés) |
| Git | Branche principale propre, aucun changement non commité au démarrage de la phase | `git status --short --branch` |

## 2. Sources de vérité et hiérarchie

Hiérarchie documentaire approuvée par le propriétaire (D-16, validation du 2026-10-31) :
1. Décisions explicitement validées par le propriétaire du projet ;
2. PDF original (24 pages) pour son contenu effectivement visuellement vérifiable ;
3. `MASTER_PROMPT_REFERENCE_COMPLET_V3.md` comme référence textuelle complémentaire officielle (exigences complémentaires et spécifications structurées) — jamais présenté comme transcription certifiée et intégrale du PDF ;
4. Documents d'analyse produits à partir de ces références.
(En tout état de cause : aucune invention fonctionnelle ; bonnes pratiques techniques uniquement si non contraires aux niveaux 1-3.)

État des sources :
- `references/CAHIER_DES_CHARGES_SOURCE_24_PAGES.pdf` : 24 pages **sans couche texte** (0 caractère extractible, produit par « Microsoft: Print To PDF »). Analyse effectuée par rendu visuel + OCR (voir § 3).
- `references/MASTER_PROMPT_REFERENCE_COMPLET_V3.md` : **référence textuelle complémentaire officielle** (D-16 validée par le propriétaire le 2026-10-31 ; jamais une transcription certifiée/intégrale du PDF), 1749 lignes, structurée en 14 parties + annexes.
- `QWEN.md`, `AGENTS.md`, `docs/*` : règles d'exécution et contrats de phase.

## 3. Comparaison PDF ↔ MASTER PROMPT V3

Résultat détaillé : `01_COMPARISON_PDF_VS_MASTER_PROMPT.md`. Synthèse :
- **Alignement substantiel confirmé** sur : MVP-01→MVP-10, rôles et matrice de permissions, sitemap, grille de scoring 100 pts, résultats Nadia 90 / Salma 85 / Amine 70 / Youssef 70 / Imane 35, règle de départage proposée (compétences clés → shortlist Nadia, Salma, Amine), pipeline/Kanban, entretiens/évaluation 1–5, exports PDF/XLSX (neutralisation des formules), T-01→T-20, conditions d'acceptation MVP, plan de réalisation, scénario de démonstration, questions pédagogiques.
- **Éléments présents dans le PDF mais non repris explicitement dans le MP V3** : nom d'origine « TalentFlow ATS », mention Chart.js, hypothèse « lien Google Slides non consulté ».
- **Ajouts du MP V3 non trouvés dans le PDF (OCR)** : Partie V Administration centralisée (§24.1–24.19), préférences personnelles (§25), stack locale imposée WampServer (§27–29), stratégie de migrations et cinq bases locales (§30), stockage privé détaillé (§31), sauvegardes/restauration (§32), 150 candidatures fictives (§36), comptes de test (§37), tests complémentaires T-21→T-35 (§43), annexe équipe 5 membres.
- **Limite honnête (correction A-05)** : l'analyse du PDF repose sur son **rendu visuel et sur un OCR texte** — le fichier ne contient aucune couche texte extractible. Par conséquent : (i) la **fidélité substantielle** du MP V3 par rapport au PDF est **confirmée** sur tout le périmètre fonctionnel critique (valeurs clés recoupées) ; (ii) la **fidélité intégrale, mot à mot, n'est PAS certifiée** : les cellules des tableaux denses (matrice de permissions p7, grille p10), la mise en forme, les logos/captures et certaines lignes bruitées des pages 22-23 ne sont pas vérifiables avec certitude. Aucune conclusion ne doit être présentée comme une transcription certifiée du PDF. Voir la liste détaillée des incertitudes résiduelles dans `01_COMPARISON_PDF_VS_MASTER_PROMPT.md`. Statut du MP V3 : **validé comme référence textuelle complémentaire officielle (D-16, validation du propriétaire du 2026-10-31)** — jamais comme transcription certifiée et intégrale du PDF.

## 4. Livrables produits dans `docs/ANALYSE/`

| Fichier | Contenu |
|---|---|
| `00_RAPPORT_PHASE_00.md` | Ce rapport |
| `01_COMPARISON_PDF_VS_MASTER_PROMPT.md` | Comparaison page à page, statuts de confiance |
| `02_ANALYSE_FONCTIONNELLE.md` | Objectifs, acteurs, parcours, sitemap complet, cas pédagogique |
| `03_ARCHITECTURE_TECHNIQUE.md` | MVC PHP 8.2+ / MySQL / WampServer, structure, routage, conventions |
| `04_MODELE_DONNEES.md` | MCD/MLD, catalogue des tables et relations, dictionnaire |
| `05_MATRICE_ROLES_PERMISSIONS.md` | Rôles, permissions granulaires, cycle de vie des comptes |
| `06_MODULES.md` | Description complète de tous les modules (dont Administration 24.1–24.19) |
| `07_PERIMETRE_MVP_BONUS_HORS_SCOPE.md` | MVP / Bonus / hors périmètre / décisions à confirmer |
| `08_MIGRATIONS_ET_SYNCHRONISATION.md` | Stratégie migrations SQL versionnées, 5 bases locales |
| `09_STOCKAGE_SECURE_DOCUMENTS.md` | Stockage privé CV/documents, contrôles upload, exports, logs |
| `10_ARCHITECTURE_IA.md` | Règles déterministes vs NLP vs LLM optionnel, moteur de scoring |
| `11_SECURITE_ET_CONFORMITE_09-08.md` | Sécurité applicative, loi 09-08/CNDP, audit, équité |
| `12_MATRICE_TRACABILITE.md` | Exigences MVP → modules → tables → écrans → T-01…T-35 |
| `13_DIAGNOSTIC_CINQ_ENVIRONNEMENTS.md` | Protocole de relevé de l'environnement WampServer local unique (adapté solo, D-25 ; titre conservé) |
| `14_PLAN_GITHUB_EQUIPE.md` | Workflow Git simplifié (dépôt personnel privé, `main` + branches feature si nécessaire), responsabilités du développeur unique |
| `15_REGISTRE_RISQUES.md` | Risques techniques/métier/pédagogiques avec sévérité/mitigation |
| `16_DECISIONS_EN_ATTENTE.md` | Registre des décisions : D-16 **validée** (2026-10-31), D-08 **Option E validée provisoirement — décision définitive ouverte**, autres décisions ouvertes avec options et conséquences |

## 5. Décisions techniques proposées (PROPOSITION, sauf mention contraire)

- **Architecture** : MVC personnalisé maison (pas de framework), front controller unique `public/index.php`, router simple, Middleware auth/RBAC/CSRF, Repositories PDO, Services métier (ScoringService, MatchService, ExportService…), Views Twig-like interdites → templates PHP échappés. CONFIRMÉ PAR SOURCE (stack imposée MP §27).
- **Base** : `sirh`, InnoDB, `utf8mb4`, PDO préparé, clés étrangères, index justifiés ; dates stockées UTC. CONFIRMÉ PAR SOURCE (MP §30, PDF §15–16).
- **Migrations** : scripts ordonnés `NNNN_description.sql` + table `migrations` ; `schema.sql` de référence reproductible sur base vierge ; seeders fictifs séparés. PROPOSITION (cadre imposé par MP §30).
- **Stockage fichiers** : `storage/uploads` hors DocumentRoot, noms aléatoires, métadonnées en base (`storage_objects`), téléchargement via contrôleur autoritaire. CONFIRMÉ PAR SOURCE (MP §31).
- **Scoring** : moteurs paramétrés en base (grilles versionnées, critères pondérés, synonymes contrôlés, statut des données manquantes Oui/Non observé/À vérifier/N/A), historique des scores lié à la version de grille. CONFIRMÉ PAR SOURCE (PDF §9, MP §18).
- **IA** : niveau 1 = règles déterministes explicables (MVP) ; niveau 2 = NLP léger local (synonymes, extraction heuristique) en Bonus ; LLM local/cloud = option désactivée par défaut. CONFIRMÉ PAR SOURCE (PDF §12, MP, D-07).
- **Sécurité** : sessions PHP durcies, `password_hash()`, CSRF, échappement XSS, RBAC serveur systématique, limitation tentatives, audit immuable, erreurs masquées. CONFIRMÉ PAR SOURCE (MP §32, PDF §17).
- **Exports** : PhpSpreadsheet (XLSX, neutralisation CSV-injection/formules) ; bibliothèque PDF à arbitrer par test (Dompdf vs mPDF) → décision D-04b. Le PDF source exige accents français corrects et rendu RTL testé si arabe activé.
- **Environnement local unique** (D-25, 01/11/2026 — développeur unique) : versions PHP/MySQL/MariaDB/Apache/extensions à relever sur le PC du développeur avant tout développement (aucune version inventée) ; tant que la page de test locale ne passe pas, la production de fonctionnalités est bloquée (MP §27 transposé). La « stratégie de migrations et cinq bases locales » (§30) conserve son exigence de reproductibilité, appliquée à un seul environnement + dépôt Git.

## 6. Points en attente de validation humaine

Liste complète et conséquences dans `16_DECISIONS_EN_ATTENTE.md`. Bloquants pour la Phase 01 :
- **D-08 — Départage Amine/Youssef : Option E validée provisoirement par le propriétaire (2026-10-31)** — Amine 70/100, Youssef 70/100, égalité conservée, aucun départage automatique, les deux profils restent accessibles à la revue humaine. La décision **définitive reste ouverte** (choix A/B/C ou reconduction de E). Aucun score modifié.
- D-05/D-01b : versions exactes PHP & MySQL/MariaDB relevées sur l'environnement local unique (développeur seul — D-25).
- D-06 : localhost seul vs démonstration LAN ponctuelle.
- D-10 : parsing CV MVP vs Bonus (recommandation source : Bonus ; upload + saisie vérifiée d'abord).
- D-12 : vidéo différée simulation (recommandé) vs réelle (extension).
- D-15 : langues (français seul recommandé au départ).
- Durée de conservation / règles de suppression (à fixer avec l'encadrement).
- Bibliothèque PDF (test à programmer en Phase 08, choix documenté).
- D-16 : confirmation que le MP V3 tient lieu de cahier des charges textuel officiel (le PDF étant image-only).

## 7. Incohérences / divergences détectées

1. **Nom du produit** : PDF metadata et en-têtes = « TalentFlow ATS » ; MP V3 et pack = « SIRH ». Résolu par convention D-01 (nom = SIRH), divergence signalée.
2. **Départage Amine/Youssef** : PDF = compétences clés (Amine) ; note antérieure utilisateur = expérience/atouts (Youssef). Divergence documentée (D-08) ; **Option E retenue provisoirement le 2026-10-31** (égalité + revue humaine, aucun départage automatique) ; décision définitive ouverte ; règle restera configurable et affichée avant calcul.
3. **Français non documenté** : 0 pt dans le cas pédagogique ≠ « compétence absente » en réalité ; distinction obligatoire dans l'UI (T-10).
4. **PDF sans texte** : toute citation du PDF repose sur l'OCR ; éléments non confirmés listés dans `01_COMPARISON...md`.
5. **Périmètre Administration/T-21→T-35/150 candidatures** : présents uniquement dans le MP V3 (et docs du pack), pas retrouvés dans le PDF OCR — **devenus contractuels au titre de la hiérarchie D-16 (validée 2026-10-31)**, avec provenance documentaire « MP V3 » conservée partout.
6. **Google Slides du cours** : jamais consultés selon le PDF lui-même ; exigences éventuelles des diapositives inconnues → question ouverte à poser à l'enseignante.

## 8. Vérification des documents

- Tous les fichiers listés au §4 créés sous `docs/ANALYSE/` ; aucun autre fichier créé/modifié hors `docs/ANALYSE/`.
- Aucun code applicatif, aucune migration, aucun `.sql`, `.php`, `.js` créé.
- Fichiers de référence (`references/`, `docs/PHASES/`, `QWEN.md`, `AGENTS.md`, `MANIFEST.json`) inchangés (`git status`/`git diff` en fin de phase).
- Cohérence croisée : chaque exigence MVP-01→10 tracée vers un module, des tables et des tests T-01→T-35 dans `12_MATRICE_TRACABILITE.md`.

## 9. Critères permettant de valider la Phase 00

1. Périmètre MVP/Bonus/hors-scope accepté tel que décrit (`07_...`).
2. Architecture et structure de dossiers acceptées (`03_...`).
3. Modèle de données conceptuel accepté (liste de tables et relations, `04_...`).
4. Matrice de permissions acceptée (`05_...`).
5. Stratégie migrations/sync de la base locale unique acceptée (`08_...`, adaptée solo par D-25 ; reproductibilité maintenue).
6. Décisions ouvertes arbitrées par l'utilisateur — notamment **validation définitive de D-08** (l'Option E est déjà actée provisoirement depuis le 2026-10-31 pour les besoins des tests).
7. ~~Validation D-16~~ **D-16 VALIDÉE le 2026-10-31** (MP V3 = référence textuelle complémentaire officielle, jamais transcription certifiée du PDF) ; reste : plan de relevé de l'environnement local unique approuvé.
8. **D-25 VALIDÉE le 01/11/2026** (développement individuel confirmé par le propriétaire : un seul développeur, un seul environnement WampServer, pas de CODEOWNERS/handles d'équipe — D-22 close ; workflow GitHub simplifié ; planning adapté au solo sans réduction du périmètre fonctionnel ni des tests T-01→T-35). **D-26 ouverte** : modalités d'exécution du test officiel T-33 en contexte mono-machine.

## 10. Addenda — corrections de reprise du 2026-10-31 (autorisées par le propriétaire)

| Anomalie | Statut final |
|---|---|
| A-01 Classification des tables (`migrations`=technique, `pipeline_transitions`=config, `resumes`=documents/historique ; totaux par catégorie recalculés, total canonique inchangé 64) | **Corrigée** lors du premier cycle (commit `ec3fe79`) — conservée, non recommencée |
| A-02 Cohérence nomenclature Administration (`admin.permissions.manage`, `interviews.schedule`, module M13 Préférences) | **Corrigée** lors du premier cycle — conservée |
| A-05 Limites OCR | **Corrigée** : §3 de ce rapport + conclusion de `01_...` — fidélité substantielle confirmée, fidélité intégrale/mot à mot non certifiée |
| A-06 | **Corrigée** lors du premier cycle (mode démo M12.19/`demo_runs`, T-25 ; seeders ~150 → Phase 09 dans `06_...`) |
| A-07 Intégrité T-01→T-35 | **Corrigée** : définitions rétablies verbatim depuis MP §42/§43 dans `12_...` ; aucun ID réaffecté ; répercussions dans 03 (déjà conforme), 06, 07, 09, 11, 13 (`04`/`05` vérifiés conformes ; table `application_status_history` harmonisée en doc 12) |
| A-08 Références de décisions | **Corrigée** : références inexistantes « D-04 » (contrainte) et « D-09 » éliminées ; **D-04b ajouté au registre** (déjà présent, conservé sans modification d'ID) ; D-07 et D-01b ajoutés au registre car référencés ailleurs ; références croisées vérifiées |
| D-08 | **Option E inscrite comme décision opérationnelle provisoire (2026-10-31)** partout où elle était mentionnée ; scores intacts (Amine 70/100, Youssef 70/100) ; décision définitive ouverte |
| D-16 | **Validée (2026-10-31)** : hiérarchie 1) décisions du propriétaire 2) PDF (éléments visuellement vérifiables) 3) MP V3 = référence textuelle complémentaire officielle 4) documents d'analyse ; interdiction de présenter le MP V3 comme transcription certifiée du PDF |
| A-03/A-04 Modèle de données | Catalogue canonique **64 tables** conservé ; **D-24 ouverte** (variante 63 si fusion `evaluation_scores` en JSON) ; aucune table fusionnée |

Contrôle documentaire intégral après corrections : relecture des 17 documents ; 35 tests conformes aux définitions officielles ; toutes les références D-xx existantes ou supprimées ; 64 tables classées et reliées ; cohérence Administration/Rôles/Permissions/Préférences vérifiée ; cinq candidats de référence intacts (90/85/70/70/35) ; périmètres MVP/Bonus/Hors-scope cohérents avec les tests corrigés ; traçabilité exigences→modules→tests bouclée.

**ARRÊT : la Phase 01 ne démarre qu'après validation explicite du propriétaire.**
