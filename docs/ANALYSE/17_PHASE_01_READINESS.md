# PHASE 01 READINESS — Décisions et prérequis

Document préparé le **2026-11-01**. Source principale : `16_DECISIONS_EN_ATTENTE.md` (lu intégralement), croisé avec `03_ARCHITECTURE_TECHNIQUE.md`, `04_MODELE_DONNEES.md`, `08_MIGRATIONS_ET_SYNCHRONISATION.md`, `09_STOCKAGE_SECURE_DOCUMENTS.md`, `10_ARCHITECTURE_IA.md`, `11_SECURITE_ET_CONFORMITE_09-08.md`, `12_MATRICE_TRACABILITE.md`, `13_DIAGNOSTIC_CINQ_ENVIRONNEMENTS.md`, `15_REGISTRE_RISQUES.md`.

**Aucune décision n'est prise à la place du propriétaire.** Les recommandations sont techniques, neutres et non contraignantes. Aucun code (PHP/JS/SQL), aucune migration, aucun début Phase 01 dans ce document.

---

## 1. Tableau consolidé des décisions ouvertes

| ID | Sujet | Options disponibles | Recommandation technique neutre | Conséquence sur le projet | Phase concernée | Bloquante Phase 01 |
|---|---|---|---|---|---|---|
| D-05/D-01b | Versions PHP & MySQL communes aux 5 postes | Valeurs fixées **après relevé réel** (`13_...`) ; aucune valeur inventée à ce jour | Cible = version commune minimale compatible présente sur les 5 PC (ou mise à niveau uniforme décidée) ; MySQL vs MariaDB tranché au relevé (MP §27) | Sans cela : stack non verrouillable, syntaxe SQL et extensions indéterminées | Phase 01 (setup) | **OUI** |
| D-20 | Collation MySQL uniforme | `utf8mb4_unicode_ci` vs `utf8mb4_ai_ci` selon versions réelles | Trancher immédiatement après D-05 ; uniformiser sur les 5 bases | Migrations non verrouillables ; risques d'incohérence de tri/recherche | Phase 01 | **OUI** |
| D-21 | Outil de migration | Script maison minimal vs Phinx/outil Composer | Script simple conforme « MVC personnalisé » (esprit MP) ; éviter les dépendances lourdes non validées | Lot 0001 non écrit → pas d'installation reproductible (T-33) | Phase 01 | **OUI** |
| D-22 | Handles GitHub des 5 membres | Information humaine manquante (signalée dès le PDF) | Fournir les usernames au kickoff | CODEOWNERS, invitations et responsabilités `14_...` incomplets | Phase 01 | **OUI** (partiellement : bloque l'organisation Git, pas le codage local) |
| D-23 | CI GitHub Actions (lint/tests sans base) | Oui limitée vs tout local | Décision d'équipe à acter ; une CI minimale (lint PSR + tests unitaires sans base) est compatible avec la confidentialité locale | Qualité dépend des revues manuelles si absent | Phase 01+ | NON |
| D-01b | Nom officiel du produit | PDF visible = « TalentFlow ATS » ; MP V3/pack = « SIRH » | Confirmer nom affiché, nom de base (`sirh`), intitulés des livrables | Incohérence graphique/textile si figé sans accord | Phase 01 (naming/scaffolding) | **OUI** (faible coût mais transversal) |
| D-06 | Périmètre réseau | localhost seul vs LAN temporaire ponctuel | localhost par défaut ; LAN = accord explicite, temporaire, contrôlé | Démos multi-postes impossibles si requis sans décision | Phase 01 (config Apache) | NON (défaut localhost documenté) |
| D-04b | Bibliothèque PDF | Dompdf vs mPDF (test accents/RTL/multipages/perf) | Réaliser le test comparatif écrit avant choix ; rien installé pour l'instant | Exports PDF non développables en Phase 08 | Phase 08 | NON |
| (Excel) | Bibliothèque Excel | PhpSpreadsheet (référence usuelle) vs export CSV minimal | À valider avec le même protocole que D-04b (accents, T-15 neutralisation formules, .xlsx réel) | Exports XLSX (T-15) non développables sans choix | Phase 08 | NON |
| D-17 | Graphiques dashboard | Chart.js auto-hébergé (cité PDF) vs rendu serveur vs abstraction | Auto-hébergement local obligatoire (compatibilité T-31 hors Internet, pas de CDN) | Dashboard M2 partiellement bloqué | Phase 04-05 | NON |
| D-07 / D-18 | IA générative externe (LLM local/cloud), matching sémantique avancé | Désactivée par défaut (position des sources) vs activée avec autorisation écrite + journalisation + validation humaine + conformité | Désactivée par défaut ; NLP léger local en Bonus uniquement ; aucune donnée envoyée sans accord écrit (loi 09-08) | Fonctions N2/N3 (assistant IA, recherche langage naturel) indisponibles | Phase 06+ | NON (défaut source = désactivée) |
| D-10 | Parsing CV | MVP (risque R-03) vs Bonus (position des sources) | Bonus : upload + saisie vérifiée d'abord ; parsing ensuite | Seeders/saisie manuelle seuls au démarrage | Phase 06 | NON |
| D-11 | E-mails réels | SMTP local/test autorisé vs simulation | Simulation honnête tant que non validé ; jamais faux « envoyé » (T-27) | Notifications limitées à l'aperçu simulé | Phase 07 | NON |
| D-12 | Vidéo différée | Simulation (sources) vs enregistrement réel | Simulation d'abord marquée comme telle ; réel = extension encadrée | Fonction livrée en simulation | Phase 07 | NON |
| D-13 | Multidiffusion offres | API officielle validée vs texte exportable manuel | Manuel documenté en attendant | Publication externe indisponible | Bonus | NON |
| D-14b | Portail candidat avec compte | Sans compte (MVP) vs authentifié (Bonus) | Sans compte au MVP | Suivi candidature limité au numéro de dépôt | Phase 05+ | NON |
| D-15 | Langues | FR seul vs +EN/+AR (RTL) | FR d'abord ; autres langues seulement si testées (T-20) | T-20 non applicable sinon | Phase 04+ | NON |
| D-19 | Durées de conservation / suppression | Barèmes à fixer avec l'encadrement (loi 09-08) | À valider explicitement ; valeurs provisoires signalées en attendant | `retention_policies` non définitives ; conformité partielle | Phase 01 (seed réf.) puis continue | NON (valeurs provisoires admises) |
| **D-08** | Départage Amine/Youssef | A compétences clés / B expérience-atouts / C ancienneté / D (exclu, discriminatoire) / **E aucune règle automatique** | **Option E validée provisoirement par le propriétaire le 31/10/2026** : Amine 70/100, Youssef 70/100, égalité conservée, aucun départage automatique, revue humaine accessible (`tie_break_rule = NULL`). **Décision définitive OUVERTE** — l'agent ne choisit pas | Impact direct T-11, scénario démo étape 5, shortlist officielle | Phase 06 (moteur scoring) | NON (règle provisoire opérationnelle actée) |
| **D-24** | `evaluation_scores` : table distincte (**64 tables**, canonique actuel) vs fusion JSON dans `interview_evaluations` (**63**) | 64 / 63 | Conserver 64 tant que la fusion n'est pas validée ; **aucune fusion sans validation explicite** | Catalogue officiel et migrations Phase 01 non figés sur ce point | **Phase 01 (migrations)** | **OUI** (le catalogue doit être gelé avant d'écrire les migrations) |
| D-16 | Statut du MP V3 | — | **VALIDÉE le 31/10/2026** : hiérarchie 1) décisions propriétaire, 2) PDF visible, 3) MP V3 référence textuelle complémentaire officielle, 4) documents d'analyse. Jamais présenté comme transcription certifiée/intégrale | Acté, appliqué transversalement | Toutes | NON (validée) |
| Q-01 | Diapositives Google Slides du cours jamais consultées (aveu du PDF) | Obtenir le contenu ou confirmation d'absence d'exigences supplémentaires | Question à poser à l'enseignante **avant le gel du périmètre** | Risque R-14 : exigences inconnues possibles | Avant Phase 01 | **OUI** (gel du périmètre) |
| Q-02 | Validation de la stack par l'enseignante (« technologie imposée par le cours ») | Confirmation écrite | À demander formellement | Conformité pédagogique incertaine | Avant Phase 01 | **OUI** (validation formelle du cadre) |

**Résumé des bloquantes Phase 01 :** D-05/D-01b, D-20, D-21, D-22, D-01b (nommage), D-24, plus questions Q-01/Q-02. Tout le reste a un défaut documentaire sûr ou ne concerne que des phases ultérieures.

---

## 2. Examen des points spécialement demandés

### 2.1 Versions PHP et MySQL (D-05/D-01b)
Aucune version n'est supposée dans les documents (règle : aucune valeur inventée). Le MP §27 impose une version commune aux 5 postes. L'état actuel : **inconnu jusqu'au relevé**. La page d'information Wamp et `php -v` / `mysql --version` sur chaque PC fourniront la donnée brute ; la cible sera la min(versions compatibles présentes) ou une mise à niveau uniforme décidée par le propriétaire. Si un poste n'a que MariaDB : décision explicite de mise à niveau ou d'exclusion documentée.

### 2.2 Compatibilité des cinq installations WampServer
Le protocole complet existe dans `13_DIAGNOSTIC_CINQ_ENVIRONNEMENTS.md` (§1 relevé, §2 validation, §3 conséquences D-05/D-20). Voir liste minimale §3 ci-dessous. Critère de réussite lié à T-29 (démarrage localhost) et T-33 (base vierge sur les 5 PC).

### 2.3 Bibliothèques PDF et Excel (D-04b + Excel)
Aucune bibliothèque installée ni choisie. D-04b (Dompdf vs mPDF) attend un test comparatif écrit : accents français (T-19), RTL si arabe (T-20), tableaux multipages, performances, compatibilité avec la version PHP issue de D-05. Pour Excel : décision symétrique à ouvrir (PhpSpreadsheet vs alternative), critère clé = génération .xlsx réelle avec neutralisation des chaînes commençant par `=` (T-15). **Recommandation neutre : consigner ces deux choix dans le registre au même format que D-04b quand le propriétaire voudra bien les arbitrer** (pas d'ID inventé ici).

### 2.4 Architecture IA locale et externe (D-07/D-18/D-10)
Par défaut (position des sources) : moteur de scoring **déterministe et paramétré en base** (grilles versionnées, poids, synonymes contrôlés) ; NLP léger local éventuel en Bonus ; **toute IA externe/cloud désactivée** sans autorisation écrite + journalisation + validation humaine + analyse de conformité 09-08. Aucune donnée candidate ne quitte la machine locale. Non bloquant Phase 01 (le socle déterministe ne dépend pas de ces décisions).

### 2.5 D-08 — Départage Amine / Youssef
Statut : **Option E provisoire validée par le propriétaire le 31/10/2026** (70/70 conservé, égalité affichée, `tie_break_rule = NULL`, revue humaine tracée auteur/date/motif). **La décision définitive reste OUVERTE** (choix A/B/C ou reconduction explicite de E). Aucun score individuel modifié : Nadia 90, Salma 85, Amine 70, Youssef 70, Imane 35. Impact futur : T-11, scénario démo étape 5, shortlist officielle.

### 2.6 D-24 — 63 ou 64 tables
Catalogue canonique actuel : **64 tables** (26 métier · 10 liaison · 4 techniques · 11 référence · 13 audit/historique/conformité/config) dans `04_MODELE_DONNEES.md` §5. Variante 63 = fusion de `evaluation_scores` en JSON dans `interview_evaluations`. **Aucune fusion effectuée.** Tant que le propriétaire n'a pas tranché, les migrations Phase 01 ne peuvent pas être figées → **bloquante Phase 01**. Trade-off neutre : 64 = requêtes analytiques et contraintes SQL directes sur les notes par critère ; 63 = schéma plus léger mais interrogation des notes via fonctions JSON, collation/indexation moins directes.

### 2.7 Stratégie de stockage des documents
Décrite dans `09_STOCKAGE_SECURE_DOCUMENTS.md` : hors DocumentRoot, noms internes aléatoires, service de téléchargement contrôlé (Auth + RBAC + audit), MIME réel vérifié, sauvegarde cohérente avec la base. Points restant à valider humainement : durées de conservation (D-19) et éventuel chiffrement au repos (recommandé si données personnelles réelles ; cas pédagogique = fictives). Structurellement non bloquant Phase 01 (la conception dossier `storage/` peut être posée ; les barèmes D-19 arrivent dans les seeders de référence).

### 2.8 Authentification et permissions
Modèle complet dans `05_MATRICE_ROLES_PERMISSIONS.md` : rôles (Administrateur, RH/Recruteur, Compte Démonstration…), permissions granulaires vérifiées **côté serveur**, sessions, isolation stricte des préférences (T-23), interdiction de retirer le dernier admin actif. Verrous transverses conformes. Aucun choix humain supplémentaire requis pour démarrer, sauf confirmations de naming (D-01b) et périmètre réseau (D-06, défaut localhost).

### 2.9 Sauvegarde et restauration
Politique dans `03_...` §Sauvegarde, `09_...` §9 et `08_...` : export SQL + copie cohérente de `storage/`, hors HTTP/Git, rétention/nommage/responsable paramétrés, pas d'écrasement de la dernière sauvegarde valide avant vérification, restauration testée sur base séparée (T-28/T-34). Fréquences et responsables = paramètres à confirmer en Phase 01 (non bloquants, valeurs provisoires documentables).

---

## 3. Liste minimale de vérifications sur les cinq ordinateurs (avant développement)

Protocole détaillé : `13_DIAGNOSTIC_CINQ_ENVIRONNEMENTS.md`. Version minimale pour le PV de kickoff :

1. Version exacte de **WampServer** installée (icône/`wampmanager`).
2. Version exacte de **PHP active** (`php -v` + page info Wamp) et **quel php.ini** est utilisé.
3. Extensions PHP requises présentes : `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `zip`, `gd` (ou autre selon D-04b retenu), intl.
4. Version exacte de **MySQL/MariaDB**, service démarré, port **3306 libre**, moteur **InnoDB** par défaut, collations `utf8mb4` disponibles.
5. Version **Apache**, VirtualHost/DocumentRoot prévu (`public/` recommandé), possibilité de placer `storage/` hors racine web.
6. **Git** installé, clé SSH ajoutée, accès au dépôt privé (`ssh -T git@github.com`).
7. **Composer** installé et fonctionnel (sans encore ajouter de dépendance).
8. Espace disque disponible pour `storage/` + exports + sauvegardes locales.
9. Accès **localhost** depuis le navigateur sans proxy forcé ; vérification du fonctionnement attendu **hors Internet** (T-31).
10. Fuseau horaire système (cohérence `Africa/Casablanca` attendue dans l'application).
11. Permissions NTFS/écriture sur le dossier projet et le futur `storage/`.
12. Un poste « référent » désigné pour reproduire la procédure d'installation propre (base vierge + migrations — futur T-33).

Livrable attendu : tableau de relevé rempli par poste (5 colonnes), signé/daté, alimentant directement **D-05** et **D-20**.

---

## 4. Conditions de passage en Phase 01 (checklist de validation propriétaire)

- [ ] PV diagnostic des 5 postes réalisé → D-05/D-01b tranchées (versions PHP/MySQL/Apache communes).
- [ ] D-20 tranchée (collation uniforme).
- [ ] D-21 tranchée (outil de migration).
- [ ] D-24 tranchée (64 tables canonique **ou** variante 63) → gel du catalogue.
- [ ] D-01b confirmé (nom officiel affiché + nom de base).
- [ ] D-22 fournis (handles GitHub des 5 membres).
- [ ] Q-01 et Q-02 obtenus (diapositives du cours + validation stack par l'enseignante) ou renoncement écrit.
- [ ] D-06 confirmé (localhost par défaut accepté).
- [ ] Autorisation explicite du propriétaire de démarrer la Phase 01.

Non bloquants mais à planifier : D-04b et choix Excel (avant Phase 08), D-17 (avant dashboard), D-07/D-18/D-10 (avant Phase 06), D-11/D-12 (Phase 07), D-19 (paramétrage conservation), D-23 (décision équipe CI), D-08 définitive (avant soutenance/scénario démo final).

---

*Rappel : D-16 validée le 31/10/2026 ; D-08 en option E provisoire (définitive ouverte) ; D-24 ouverte. Ce document ne crée aucun code, aucune migration et ne modifie aucune règle métier.*
