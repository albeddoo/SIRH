# Matrice de traçabilité : exigences → modules → tables → écrans → tests T-01…T-35

Sources : PDF §3/§18 (T-01→T-20) + MP V3 §42/§43 (T-21→T-35). Les résultats des tests sont **à exécuter en Phase 09** ; ce document ne présume aucun résultat (aucune modification silencieuse possible : chaque test aura un verdict documenté dans `docs/QUALITE/`).

## 1. Exigences MVP (PDF §3 / MP §5)

| Exigence | Module (`06_MODULES.md`) | Tables principales (`04_MODELE_DONNEES.md`) | Écrans clés (`02_ANALYSE_FONCTIONNELLE.md` §6) | Tests |
|---|---|---|---|---|
| MVP-01 Authentification et rôles | M1, M12.2/.3/.14 | users, roles, permissions, role_permissions, user_roles, sessions | §1 Auth, §12 Admin | T-01, T-02, T-16, T-21, T-22, T-30 |
| MVP-02 Offres d'emploi | M3 | jobs, job_requirements, settings/modèles | §3 Offres | T-03, T-04 |
| MVP-03 Candidats et CV | M4, M12.11 | candidates, educations, experiences, skills…, candidate_documents, storage_objects | §4 Candidats | T-05, T-06, T-07, T-17, T-26, T-29 |
| MVP-04 Candidatures | M5 | applications, pipeline_history | §5 Candidatures | T-05/T-07 (flux), timeline |
| MVP-05 Scoring paramétrable | M6 | scoring_templates/criteria, application_scores/score_details/adjustments | §6 Matching & scoring | T-08, T-09, T-10, T-11, T-24 |
| MVP-06 Shortlist et Kanban | M6, M7 | applications, pipeline_stages/transitions/history | §7 Pipeline | T-11, T-12 |
| MVP-07 Entretiens et évaluations | M8 | interviews, interviewers, evaluation_*, interview_evaluations, video_sessions | §8 Entretiens | T-13 |
| MVP-08 Étude de cas | M6, M11 | seeders démo + grilles versionnées | §11 Étude de cas | T-08→T-11, scénarios §38–39 |
| MVP-09 Exports PDF/Excel | M10 | exports, saved_report_templates | §10 Rapports | T-14, T-15, T-19, T-20 |
| MVP-10 Dashboard et sécurité | M2, M12 | agrégats applicatifs, audit_logs | §2 Dashboard | T-01, T-02, T-18, T-26, T-31, T-32 |

Exigences socle complémentaires du pack : Administration complète (M12) ↔ ~toutes les tables de config ; Préférences (M13) ↔ user_preferences ↔ §Profil (T-23) ; Communications honnêtes (M9) ↔ messages/notification_templates (T-27) ; Install/migrations ↔ `08_...` (T-33).

## 2. Traçabilité test par test (T-01 → T-35)

| Test | Source | Exigence/MVP | Module | Vérification attendue (sans présager le résultat) |
|---|---|---|---|---|
| T-01 Connexion compte valide | PDF | MVP-01 | M1 | redirection dashboard selon rôle |
| T-02 Accès page RH par URL directe sans droit | PDF | MVP-01 | M1/RBAC | refus serveur (403), pas de fuite |
| T-03 Offre avec champs obligatoires manquants | PDF | MVP-02 | M3 | erreur claire, aucune publication incohérente |
| T-04 Publier puis clôturer une offre | PDF | MVP-02 | M3 | états corrects + historique conservé |
| T-05 Déposer un CV autorisé | PDF | MVP-03/04 | M4/M0 | fichier protégé + rattaché au candidat |
| T-06 Fichier interdit ou trop volumineux | PDF | MVP-03 | M4 | rejet message compréhensible |
| T-07 Deux profils même e-mail | PDF | MVP-03 | M4 | alerte doublon, aucune fusion auto |
| T-08 Scoring étude de cas | PDF | MVP-05/08 | M6 | Nadia 90/Salma 85/Amine 70/Youssef 70/Imane 35 |
| T-09 Modifier un poids | PDF | MVP-05 | M6 | somme des poids validée + version distincte |
| T-10 Français non documenté | PDF | MVP-05 | M6 | 0 selon cas pédagogique + mention « non documenté » |
| T-11 Départager Amine/Youssef | PDF | MVP-05/06 | M6 | règle préétablie affichée ; **D-08 non tranchée ⇒ comportement par défaut = égalité + revue humaine tant que non validé** |
| T-12 Carte Kanban sans droit | PDF | MVP-01/06 | M7 | refus, statut inchangé |
| T-13 Entretien en conflit d'horaire | PDF | MVP-07 | M8 | alerte + choix autre créneau |
| T-14 Export PDF avec filtres | PDF | MVP-09 | M10 | colonnes sélectionnées + filtres affichés |
| T-15 XLSX avec texte commençant par = | PDF | MVP-09 | M10 | valeur traitée comme texte non exécutable |
| T-16 Modifier une permission | PDF | MVP-01 | M12.3 | réservé admin + enregistré audit |
| T-17 Supprimer/archiver un candidat | PDF | MVP-03 | M4/M12.11 | politique appliquée, action autorisée+tracée |
| T-18 Statistiques période vide | PDF | MVP-10 | M2 | zéro/aucune donnée, sans erreur serveur |
| T-19 Accents français | PDF | MVP-09 | M10 | aucun caractère manquant/remplacé |
| T-20 Arabe/RTL si prévu | PDF | Bonus/D-15 | M12.5 | alignement/tableaux/police/exports vérifiés avant livraison |
| T-21 Accès admin sans permission | MP §43 | MVP-01 | M12 | refus côté serveur |
| T-22 Modification paramètre sensible | MP | MVP-01/admin | M12 | ancienne+valeur+nouvelles+ auteur/date |
| T-23 Préférence utilisateur isolée | MP | M13 | user_preferences | ne change pas les droits, invisible aux autres |
| T-24 Recalcul après changement | MP | MVP-05 | M6 | nouveau score lié à la version, historique conservé |
| T-25 Simulation vidéo différée | MP | MVP-07/Bonus | M8 | questions/durées/statuts réels, média réel absent si désactivé |
| T-26 Ouverture CV sans droit | MP | MVP-03 | M4/M9-sécurité | refus + journalisation |
| T-27 Notification sans SMTP configuré | MP | M9 | messages | aperçu/simulation clairement identifiés, jamais « envoyé » |
| T-28 Restauration depuis sauvegarde | MP | exploitation | backups | base séparée restaurée avec succès |
| T-29 Upload fichier PHP déguisé | MP | sécurité | M4 | refus |
| T-30 Injection SQL/XSS contrôlée | MP | sécurité | global | données neutralisées |
| T-31 Fonctionnement hors Internet | MP | contrainte D-04 | global | toutes fonctions essentielles disponibles localement |
| T-32 Responsive mobile/tablette | MP | CNF | UI | pages principales utilisables |
| T-33 Installation propre sur PC neuf | MP | install | migrations | clone+migrate+seed+login fonctionnel |
| T-34 Cinq environnements synchronisés | MP | D-05/§30 | Git+migrations | mêmes schéma/version/seeders sur les 5 postes |
| T-35 Dossiers sensibles inaccessibles via HTTP | MP | sécurité | Apache/storage | 403/404 sur app/config/database/storage |

## 3. Règles de gestion de la matrice

1. Toute exigence source non couverte par ≥1 test est une anomalie de périmètre → détectée ici : **toutes les MVP sont couvertes** ; les Bonus ont des tests conditionnels (T-20/T-25 selon décisions D-12/D-15).
2. Un test sans exigence = suspect ; T-21→T-35 tracés vers MP §43 + règles non négociables MP.
3. L'exécution réelle des tests (Phase 09) remplira une colonne Résultat (PASS/FAIL/BLOQUÉ + preuve) dans `docs/QUALITE/` ; **la présente matrice reste neutre** et ne doit jamais être éditée pour masquer un échec.
4. Divergence connue à traiter en Phase 09 : T-11 dépend de D-08 ; sans décision, le test validera « égalité affichée + revue humaine », PAS un classement imposé.
