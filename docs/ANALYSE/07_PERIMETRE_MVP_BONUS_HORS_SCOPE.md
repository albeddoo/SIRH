# Périmètre : MVP obligatoire / Bonus / Hors périmètre

Sources : PDF §3 + MP V3 §5–7 (`CONFIRMÉ PAR SOURCE`). Conformité des tests référencés aux définitions officielles MP §42/§43 vérifiée et rétablie (correction A-07, 2026-10-31).

## 1. MVP obligatoire (10 fonctions, réellement opérationnelles et reliées à la base)

| Code | Fonction | Critère d'acceptation (source) | Module | Tests |
|---|---|---|---|---|
| MVP-01 | Authentification et rôles | Accès uniquement aux pages/actions autorisées | M1/M12 | T-01, T-02, T-16, T-21, T-22, T-30 |
| MVP-02 | Offres d'emploi | Créer, modifier, publier, suspendre, clôturer, archiver | M3 | T-03, T-04 |
| MVP-03 | Candidats et CV | Fiche, CV joint, recherche, modification autorisée | M4 | T-05→T-07, T-17, T-26 |
| MVP-04 | Candidatures | Lier candidat↔offre, suivre statut | M5 | T-05, T-07, timeline/historique |
| MVP-05 | Scoring paramétrable | Critères pondérés + explication par note | M6 | T-08→T-11, T-24 |
| MVP-06 | Shortlist et Kanban | Classement, étapes modifiables avec historique | M6/M7 | T-11, T-12 |
| MVP-07 | Entretiens et évaluations | Planifier, évaluer, enregistrer recommandation/décision | M8 | T-13 |
| MVP-08 | Étude de cas | Cinq profils fictifs + restitution exacte de la grille | M6/M11 | scores exacts 90/85/70/70/35 |
| MVP-09 | Exports PDF et Excel | Listes/rapports avec colonnes et filtres choisis | M10 | T-14, T-15, T-19, T-20 |
| MVP-10 | Dashboard et sécurité | Indicateurs calculés, accès et fichiers protégés | M2/M12 | T-01, T-02, T-18, T-26, T-31, T-32, T-35 (T-29/T-30 sont des tests globaux de déploiement/RBAC, non spécifiques au dashboard — cf. `12_MATRICE_TRACABILITE.md`) |

S'y ajoutent comme exigences socle du pack : centre Administration complet (M12), préférences personnelles (M13), communications avec simulation honnête (M9), migrations/sauvegardes/installation reproductible sur les 5 PC.

Conditions d'acceptation globales du MVP (`CONFIRMÉ PAR SOURCE`) : toutes les pages MVP reliées à des données réelles ou clairement marquées « simulation » ; aucune action critique décorative ; scores reproductibles depuis la grille versionnée ; shortlist/décisions conservent auteur/date/motif ; jeu de données fictif testable sans vrais CV ; lisibilité écran + utilisabilité mobile.

## 2. Bonus (prévus dans l'architecture, ne doivent pas retarder le MVP)

| Fonction | Dépendance/précaution | Décision liée |
|---|---|---|
| Parsing avancé CV PDF/DOCX | Bibliothèques locales compatibles ; contrôle humain des champs extraits ; upload+saisie d'abord | D-10 (Bonus recommandé) |
| Import massif CSV/XLSX + lots de CV | prévisualisation, rapport erreurs, pas de rejet silencieux, lots limités | — |
| Assistant IA génératif (résumé CV, questions, brouillons, explication textuelle) | source liée, validation humaine, jamais présenté comme fait garanti | D-07/D-18 |
| Matching sémantique avancé (synonymes GA4≡Google Analytics 4…) | correspondances affichées et corrigeables | D-07 |
| Notifications e-mail réellement envoyées | SMTP configuré/testé ; modèles ; anti-erreur | D-11 |
| Portail candidat avec compte authentifié | parcours authentification/récupération ; données propres seulement | D-14b |
| Entretien vidéo différé réel | consentement, stockage sécurisé, taille/durée conservation, suppression planifiée | D-12 (simulation d'abord) |
| Intégrations systèmes RH externes | API/autorisations fournisseur | — |
| Multidiffusion LinkedIn/Indeed/Rekrute via API officielle | interdite sans API+autorisations valides ; sinon texte exportable manuel | D-13 |
| Recherche en langage naturel | traduire la requête en critères visibles avant exécution | D-07 |
| Vues sauvegardées partagées | si le temps le permet (PDF §21) | — |

Règle source : si une dépendance/autorisation/bibliothèque/temps manque → documenter la limite et livrer une alternative fonctionnelle simple.

## 3. Hors périmètre initial (ne pas développer)

Paie, congés, bulletins de salaire ; LMS complet/e-learning ; rejet ou embauche automatique par algorithme ; analyse biométrique, reconnaissance des émotions, notation par photo ; publication automatique vers plateformes externes sans API/autorisations/identifiants valides ; hébergement Internet/cloud/publique ; framework lourds ou JS hors stack tant que non demandés/explicités.

## 4. Interprétations figées pour la Phase 00

- Le « portail public » du PDF devient un **portail local** servi sur localhost/VirtualHost local (adaptation imposée par la contrainte d'hébergement, documentée, pas une invention fonctionnelle).
- La « connexion à d'autres systèmes RH » et la multidiffusion restent architecture préparée (connecteurs, feature flags), **sans implémentation simulée trompeuse**.
- Les vidéos/exports/logs sont stockés hors DocumentRoot même en mode démo.

## 5. À valider par l'utilisateur

Périmètre tel que décrit ci-dessus (rien ajouté, rien retiré par l'agent) ; arbitrages D-10, D-11, D-12, D-13, D-14b, D-15, D-18 (§ `16_DECISIONS_EN_ATTENTE.md`).
