# RAPPORT PHASE 00 — SIRH (ATS local WampServer)

> Date : 2026-11-01 · Statut : **Livrables documentaires produits — en attente de validation humaine pour la Phase 01**
> Périmètre de ce livrable : analyse et cadrage uniquement. Aucun code PHP/JS/SQL, aucune migration, aucun squelette applicatif.

## 1. Statut du dépôt (vérifié)

| Élément | Constat | Source |
|---|---|---|
| Projet | Entièrement neuf : aucun `app/`, `public/`, `vendor/`, `.env` ou SQL applicatif | Inspection arborescence + `git status` propre |
| Contenu | Pack documentaire (`docs/`, `references/`, `QWEN.md`, `AGENTS.md`, `MANIFEST.json`, modèles GitHub) | `MANIFEST.json` (39 fichiers listés) |
| Git | Branche principale propre, aucun changement non commité au démarrage de la phase | `git status --short --branch` |

## 2. Sources de vérité et hiérarchie

Hiérarchie appliquée (cf. `docs/01_REGLES_ET_SOURCE_DE_VERITE.md`) :
1. Décision explicite la plus récente de l'utilisateur ;
2. Cahier des charges PDF source (24 pages) ;
3. Spécification de phase ;
4. Registre de décisions validées ;
5. Bonne pratique technique sans invention fonctionnelle.

État des sources :
- `references/CAHIER_DES_CHARGES_SOURCE_24_PAGES.pdf` : 24 pages **sans couche texte** (0 caractère extractible, produit par « Microsoft: Print To PDF »). Analyse effectuée par rendu visuel + OCR (voir § 3).
- `references/MASTER_PROMPT_REFERENCE_COMPLET_V3.md` : **référence textuelle de travail** (validation utilisateur du 2026-11-01), 1749 lignes, structurée en 14 parties + annexes.
- `QWEN.md`, `AGENTS.md`, `docs/*` : règles d'exécution et contrats de phase.

## 3. Comparaison PDF ↔ MASTER PROMPT V3

Résultat détaillé : `01_COMPARISON_PDF_VS_MASTER_PROMPT.md`. Synthèse :
- **Alignement substantiel confirmé** sur : MVP-01→MVP-10, rôles et matrice de permissions, sitemap, grille de scoring 100 pts, résultats Nadia 90 / Salma 85 / Amine 70 / Youssef 70 / Imane 35, règle de départage proposée (compétences clés → shortlist Nadia, Salma, Amine), pipeline/Kanban, entretiens/évaluation 1–5, exports PDF/XLSX (neutralisation des formules), T-01→T-20, conditions d'acceptation MVP, plan de réalisation, scénario de démonstration, questions pédagogiques.
- **Éléments présents dans le PDF mais non repris explicitement dans le MP V3** : nom d'origine « TalentFlow ATS », mention Chart.js, hypothèse « lien Google Slides non consulté ».
- **Ajouts du MP V3 non trouvés dans le PDF (OCR)** : Partie V Administration centralisée (§24.1–24.19), préférences personnelles (§25), stack locale imposée WampServer (§27–29), stratégie de migrations et cinq bases locales (§30), stockage privé détaillé (§31), sauvegardes/restauration (§32), 150 candidatures fictives (§36), comptes de test (§37), tests complémentaires T-21→T-35 (§43), annexe équipe 5 membres.
- **Limite honnête** : l'OCR n'est pas une vérification mot à mot. Les tableaux denses ont pu être partiellement mal reconnus. La fidélité de la transcription est jugée **substantiellement fidèle sur le périmètre fonctionnel**, mais **non certifiée intégrale**. À valider : D-16 (le MP V3 peut-il servir de référence officielle complète malgré les ajouts ?).

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
| `13_DIAGNOSTIC_CINQ_ENVIRONNEMENTS.md` | Protocole de relevé des 5 postes WampServer |
| `14_PLAN_GITHUB_EQUIPE.md` | Workflow Git, branches, PR, responsabilités des 5 membres |
| `15_REGISTRE_RISQUES.md` | Risques techniques/métier/pédagogiques avec sévérité/mitigation |
| `16_DECISIONS_EN_ATTENTE.md` | Décisions ouvertes (dont **D-08 NON TRANCHÉE**), options et conséquences |

## 5. Décisions techniques proposées (PROPOSITION, sauf mention contraire)

- **Architecture** : MVC personnalisé maison (pas de framework), front controller unique `public/index.php`, router simple, Middleware auth/RBAC/CSRF, Repositories PDO, Services métier (ScoringService, MatchService, ExportService…), Views Twig-like interdites → templates PHP échappés. CONFIRMÉ PAR SOURCE (stack imposée MP §27).
- **Base** : `sirh`, InnoDB, `utf8mb4`, PDO préparé, clés étrangères, index justifiés ; dates stockées UTC. CONFIRMÉ PAR SOURCE (MP §30, PDF §15–16).
- **Migrations** : scripts ordonnés `NNNN_description.sql` + table `migrations` ; `schema.sql` de référence reproductible sur base vierge ; seeders fictifs séparés. PROPOSITION (cadre imposé par MP §30).
- **Stockage fichiers** : `storage/uploads` hors DocumentRoot, noms aléatoires, métadonnées en base (`storage_objects`), téléchargement via contrôleur autoritaire. CONFIRMÉ PAR SOURCE (MP §31).
- **Scoring** : moteurs paramétrés en base (grilles versionnées, critères pondérés, synonymes contrôlés, statut des données manquantes Oui/Non observé/À vérifier/N/A), historique des scores lié à la version de grille. CONFIRMÉ PAR SOURCE (PDF §9, MP §18).
- **IA** : niveau 1 = règles déterministes explicables (MVP) ; niveau 2 = NLP léger local (synonymes, extraction heuristique) en Bonus ; LLM local/cloud = option désactivée par défaut. CONFIRMÉ PAR SOURCE (PDF §12, MP, D-07).
- **Sécurité** : sessions PHP durcies, `password_hash()`, CSRF, échappement XSS, RBAC serveur systématique, limitation tentatives, audit immuable, erreurs masquées. CONFIRMÉ PAR SOURCE (MP §32, PDF §17).
- **Exports** : PhpSpreadsheet (XLSX, neutralisation CSV-injection/formules) ; bibliothèque PDF à arbitrer par test (Dompdf vs mPDF) → décision D-04b. Le PDF source exige accents français corrects et rendu RTL testé si arabe activé.
- **5 environnements** : versions communes PHP/MySQL/Apache/extensions à relever avant tout développement (aucune version inventée) ; tant que la page de test commune ne passe pas sur les 5 PC, la production de fonctionnalités est bloquée (MP §27).

## 6. Points en attente de validation humaine

Liste complète et conséquences dans `16_DECISIONS_EN_ATTENTE.md`. Bloquants pour la Phase 01 :
- **D-08 — Départage Amine/Youssef : NON TRANCHÉ** (options présentées, aucune règle choisie ; sans validation, le système devra afficher l'égalité et exiger une revue humaine).
- D-05/D-01b : versions exactes communes PHP & MySQL/MariaDB (relevé 5 postes requis).
- D-06 : localhost seul vs démonstration LAN ponctuelle.
- D-10 : parsing CV MVP vs Bonus (recommandation source : Bonus ; upload + saisie vérifiée d'abord).
- D-12 : vidéo différée simulation (recommandé) vs réelle (extension).
- D-15 : langues (français seul recommandé au départ).
- Durée de conservation / règles de suppression (à fixer avec l'encadrement).
- Bibliothèque PDF (test à programmer en Phase 08, choix documenté).
- D-16 : confirmation que le MP V3 tient lieu de cahier des charges textuel officiel (le PDF étant image-only).

## 7. Incohérences / divergences détectées

1. **Nom du produit** : PDF metadata et en-têtes = « TalentFlow ATS » ; MP V3 et pack = « SIRH ». Résolu par convention D-01 (nom = SIRH), divergence signalée.
2. **Départage Amine/Youssef** : PDF = compétences clés (Amine) ; note antérieure utilisateur = expérience/atouts (Youssef). Non tranchée (D-08), gérée par configurabilité + affichage de la règle avant calcul.
3. **Français non documenté** : 0 pt dans le cas pédagogique ≠ « compétence absente » en réalité ; distinction obligatoire dans l'UI (T-10).
4. **PDF sans texte** : toute citation du PDF repose sur l'OCR ; éléments non confirmés listés dans `01_COMPARISON...md`.
5. **Périmètre Administration/T-21→T-35/150 candidatures** : présents uniquement dans le MP V3 (et docs du pack), pas retrouvés dans le PDF OCR — acceptés comme exigences contractuelles si D-16 validé.
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
5. Stratégie migrations/sync des 5 bases acceptée (`08_...`).
6. Décisions ouvertes arbitrées par l'utilisateur — notamment **D-08** (ou maintien explicite de « égalité + revue humaine »).
7. Validation D-16 (MP V3 comme référence textuelle officielle) et plan de relevé des 5 postes approuvé.

**ARRÊT : la Phase 01 ne démarre qu'après validation explicite.**
