# Comparaison PDF source (24 pages) ↔ MASTER PROMPT V3

Méthode : le PDF ne contient aucun texte extractible (0 caractère/page, producteur « Microsoft: Print To PDF »). Chaque page a été rendue en image 200 dpi puis reconnue par OCR Tesseract (français). Cette comparaison est donc **substantielle, pas certifiée mot à mot** ; les tableaux denses peuvent comporter des artefacts d'OCR.

Statuts utilisés : `CONFIRMÉ PAR SOURCE` (présent dans PDF-OCR ET MP V3) · `AJOUT MP V3` (trouvé seulement dans MP V3/docs pack) · `PDF UNIQUEMENT` · `NON VÉRIFIABLE` (risque OCR).

## Tableau de correspondance

| Section PDF (page OCR) | Correspondance MP V3 | Statut |
|---|---|---|
| p1 — Page de garde « TalentFlow ATS », e-GRH mini-projet 1, principe « la décision finale reste humaine » | En-tête MP (nom changé en SIRH), règles non négociables 11/26 | CONFIRMÉ (nom = divergence documentée, voir Divergences) |
| p1 — Note : lien Google Slides non consulté, cahier fondé sur brief conversation | Non mentionné | PDF UNIQUEMENT — question ouverte (exigences diapositives inconnues) |
| p2 — §1 Résumé exécutif, espace public candidature, rôles, scoring explicable, exports, cas DMS | Parties I–II, §12 portail local | CONFIRMÉ (MP adapte « espace public » en portail LOCAL uniquement) |
| p2 — §2 Alignement cours e-GRH (SIRH/ERP/Cloud, digitalisation, biais IA) | §3 objectifs pédagogiques | CONFIRMÉ |
| p3-4 — §3 MVP-01→MVP-10 + critères | §5 table identique | CONFIRMÉ |
| p3-4 — Fonctions avancées (parsing, vidéo réelle, assistant IA, e-mails réels, portail avec compte, import masse, intégrations) | §6 Bonus | CONFIRMÉ |
| p4 — Hors périmètre (paie, LMS, rejet auto, biométrie, publication auto) | §7 | CONFIRMÉ |
| p4-5 — §4 Sitemap (portail, auth, dashboard, offres, candidats, candidatures, matching, kanban, entretiens, communications, rapports, étude de cas, admin) | §12–24 + Partie V | CONFIRMÉ ; le détail Administration 24.1–24.19 est AJOUT MP V3 (le PDF a une section ADMIN plus brève p5-6) |
| p6-7 — §5 Rôles (admin technique, Resp RH, recruteur, manager, intervieweur, direction, candidat) + matrice simplifiée + cycle de vie comptes | §8–11 quasi identiques | CONFIRMÉ |
| p8 — §6 Offres : champs fiche de poste, actions, statuts brouillon→archivée | §14 | CONFIRMÉ |
| p8-9 — §7 Candidats/CV : fiche, recherche, doublons, favoris, notes internes, archivage | §15 | CONFIRMÉ |
| p9-10 — §8 Parsing CV : parcours dépôt→contrôle→extraction→préremplissage→vérification→historique ; import de masse ; choix MVP = upload + saisie | §16 | CONFIRMÉ |
| p10-11 — §9 Grille 100 pts (Formation 20, Exp 20, SEO/RS/GA/Excel 10, Français 10, Canva+CRM 5×2) | §18 table identique | CONFIRMÉ |
| p10-11 — Résultats : Nadia 90, Salma 85, Amine 70, Youssef 70, Imane 35 + hypothèses (finance Imane non liée, 4 compétences clés ×10, français non documenté = 0, Canva/CRM 5) | §18 identique | CONFIRMÉ |
| p11 — Interprétation « non documenté ≠ compétence absente » | §18 traitement données manquantes | CONFIRMÉ |
| p11 — Départage : règle annoncée avant notation → compétences clés (Amine 40/40 vs Youssef 20/40) ; shortlist proposée Nadia, Salma, Amine ; sinon revue humaine | §18 « Égalité Amine/Youssef » + signalement divergence note antérieure | CONFIRMÉ (divergence avec note utilisateur = D-08 ; Option E validée provisoirement le 2026-10-31, décision définitive ouverte) |
| p11-12 — §10 Pipeline 8 étapes + transitions + comportement Kanban | §20 | CONFIRMÉ |
| p12-13 — §11 Entretiens : planification, statuts, conflits ; grille évaluation 1–5 (5 critères + recommandation) ; simulation vidéo différée | §21 | CONFIRMÉ |
| p13-14 — §12 IA : niveau 1 automatisation explicable (recommandé MVP), niveau 2 fonctions IA facultatives (résumé CV, matching sémantique, questions, rédaction, recherche NL) ; risques (mot-clé absent, biais, fausse précision 82/100, seuil…) ; mesures ; phrase à défendre | §18 équité/limites + Partie IX §41 | CONFIRMÉ |
| p14-16 — §13 Dashboard KPI (définitions), exports PDF/XLSX/CSV, paramètres dynamiques, exigences Excel (neutraliser formules) et PDF (pagination, accents, RTL testé) | §13, §23 | CONFIRMÉ |
| p16 — §14 Paramètres dynamiques (catégories entreprise, langue, référentiels, compétences, scoring, pipeline, entretiens, notifications, exports, fichiers, confidentialité, comptes, audit) | §24–26 | CONFIRMÉ (MP développe en 19 sous-modules) |
| p17 — §15 Modèle de données : users, roles/permissions/user_roles, companies/departments, jobs, job_requirements, candidates, resumes/candidate_documents, educations/experiences, skills/candidate_skills, applications, scoring_templates/criteria, application_scores/score_details, pipeline_history, interviews/interviewers, interview_evaluations, messages/notification_templates, exports/saved_report_templates, audit_logs, settings | §33 liste identique + tables complémentaires | CONFIRMÉ (+ AJOUT MP : user_preferences, sessions, consent_records, retention_policies, storage_objects, setting_versions, feature_flags, demo_runs…) |
| p18 — §16 Architecture : HTML5/CSS/Bootstrap5/JS vanilla ; PHP 8.2+ MVC ; MySQL/MariaDB ; bibliothèque PDF + XLSX ; **Chart.js ou équivalent** ; structure de dossiers public/app/config/routes/storage/database/tests | §27–29 (MySQL imposé, MariaDB exclu sans décision ; PhpSpreadsheet + Dompdf/mPDF ; « Chart.js ou équivalent » non nommé) | CONFIRMÉ avec précisions MP ; Chart.js = PDF UNIQUEMENT (devient PROPOSITION graphique) ; mention « ou technologie imposée par le cours » = PDF UNIQUEMENT |
| p18-19 — §17 Sécurité/confidentialité/audit (hash, RBAC serveur, préparées, CSRF/XSS, fichiers, audit, conservation, sauvegarde, erreurs, exports) | §32, §40 | CONFIRMÉ |
| p19-20 — §18 Tests T-01→T-20 + conditions d'acceptation MVP | §42 table identique, §44 | CONFIRMÉ |
| p20 — §19 Plan de réalisation 0→8 (cadrage, socle, offres/candidats, pipeline, scoring, entretiens, dashboard, durcissement, bonus) | §46 Phases 0→9 | CONFIRMÉ (découpage MP en 10 phases = remaniage pédagogique cohérent) |
| p21 — §20 Scénario démo 10 étapes + réponses aux questions du cours | §38–39 | CONFIRMÉ |
| p22 — §21 Compléments : recherche/filtres/vues sauvegardées, notifications (jamais « envoyé » si échec), UX/accessibilité, mode démonstration réinitialisable | §22, §47, §24.19 | CONFIRMÉ |
| p23 — §22 Hypothèses + décisions à confirmer (stack validée enseignante, portail compte, parsing bonus, vidéo simu, IA externe désactivée, langues, conservation, départage, formats) + glossaire | Règles + Phase 0 décisions + Annexe glossaire | CONFIRMÉ |
| p24 — §23 Synthèse finale (« la meilleure version n'est pas celle qui promet le plus d'IA… ») | Esprit général MP | CONFIRMÉ |

## Éléments du MP V3 non retrouvés dans le PDF (AJOUT MP V3)

Ces éléments proviennent des exigences « partagées dans la conversation » organisées par le MP (règle 1 du MP). **D-16 étant validée le 2026-10-31**, ils sont contractuels au titre de référence textuelle complémentaire officielle, en conservant leur provenance « MP V3 » (aucune attribution au PDF) :
1. Nommage projet **SIRH** et dossier WampServer cible (`C:\wamp64\www\SIRH`).
2. Interdiction totale d'hébergement Internet/Cloud ; GitHub = versionnement seul.
3. Partie V complète : centre Administration §24.1→24.19 et préférences personnelles §25.
4. Contraintes stack : MySQL de référence (pas de mélange MariaDB), PDO ERRMODE_EXCEPTION, DocumentRoot `public/`, BASE_URL sans chemin codé en dur.
5. Stratégie migrations SQL versionnées + 5 bases locales synchronisées par GitHub (§30).
6. Stockage privé détaillé (§31) : noms aléatoires, MIME réel, cohérence upload_max_filesize…
7. Sauvegardes locales chiffrées + restauration testée (§32).
8. Jeu de démonstration ~**150 candidatures fictives** (§36) et comptes de test (§37).
9. Tests complémentaires **T-21→T-35** (§43).
10. Workflow équipe 5 membres (Annexe B), branches protégées, PR obligatoires.
11. Loi marocaine **09-08 / CNDP** explicitement nommée (§40) — le PDF parle de « confidentialité/conservation » sans citer la loi.
12. Exigence i18n UTC + fuseau Africa/Casablanca.

## Éléments du PDF non repris explicitement dans le MP V3

1. Nom original « TalentFlow ATS ».
2. Chart.js nommé pour les graphiques.
3. Note d'honnêteté sur les Google Slides inaccessibles (à conserver : les diapositives peuvent contenir des exigences supplémentaires).
4. Formulation « ou technologie imposée par le cours » (la stack doit être confirmée par l'enseignante).

## Incertitudes résiduelles (non vérifiables par OCR)

- Contenu exact des cellules des tableaux denses (matrice de permissions p7, grille p10) : les valeurs clés (20/20/10/10/10/10/10/5+5, totaux 90/85/70/70/35) ont été recoupées avec le MP V3 et concordent ; les libellés fins peuvent différer.
- Mise en forme, logos, captures éventuelles du PDF : non analysables par OCR texte.
- Pages 22-23 : quelques lignes bruitées ; sens général recoupé avec MP §Phase 0 « décisions à confirmer ».

**Conclusion** : le MP V3 est retenu comme **référence textuelle complémentaire officielle** du projet (validation explicite du propriétaire du projet, D-16, 2026-10-31). Sa fidélité substantielle au PDF est confirmée sur tout le périmètre fonctionnel critique ; elle n'est **pas certifiée intégrale ni mot à mot** (limites OCR détaillées ci-dessus). Le MP V3 ne doit **jamais** être présenté comme une transcription certifiée et intégrale du PDF original : les ajouts qui ne figurent pas dans le PDF (Administration §24, T-21→T-35, confidentialité, etc., listés plus haut) conservent leur provenance documentaire propre (« MP V3 ») dans tous les livrables.
