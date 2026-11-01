# Matrice de traçabilité : exigences → modules → tables → écrans → tests T-01…T-35

Sources : PDF §3/§18 (T-01→T-20) + MP V3 §42/§43 (T-21→T-35). **Intégrité rétablie (correction A-07, 2026-10-31)** : les définitions ci-dessous sont conformes verbatim aux définitions officielles du Master Prompt (§42 pour T-01→T-20, §43 pour T-21→T-35) ; aucun identifiant de test n'a été réaffecté. Les résultats des tests sont **à exécuter en Phase 09** ; ce document ne présume aucun résultat (aucune modification silencieuse possible : chaque test aura un verdict documenté dans `docs/QUALITE/`).

## 1. Exigences MVP (PDF §3 / MP §5)

| Exigence | Module (`06_MODULES.md`) | Tables principales (`04_MODELE_DONNEES.md`) | Écrans clés (`02_ANALYSE_FONCTIONNELLE.md` §6) | Tests |
|---|---|---|---|---|
| MVP-01 Authentification et rôles | M1, M12.2/.3/.14 | users, roles, permissions, role_permissions, user_roles, sessions | §1 Auth, §12 Admin | T-01, T-02, T-16, T-21, T-22, T-30 (permissions différentes Démonstration/Administrateur) |
| MVP-02 Offres d'emploi | M3 | jobs, job_requirements, settings/modèles | §3 Offres | T-03, T-04 |
| MVP-03 Candidats et CV | M4, M12.11 | candidates, educations, experiences, skills…, candidate_documents, storage_objects | §4 Candidats | T-05, T-06, T-07, T-17, T-26 |
| MVP-04 Candidatures | M5 | applications, application_status_history | §5 Candidatures | T-05/T-07 (flux), timeline |
| MVP-05 Scoring paramétrable | M6 | scoring_templates/criteria, application_scores/score_details/adjustments | §6 Matching & scoring | T-08, T-09, T-10, T-11, T-24 |
| MVP-06 Shortlist et Kanban | M6, M7 | applications, pipeline_stages/transitions/history | §7 Pipeline | T-11, T-12 |
| MVP-07 Entretiens et évaluations | M8 | interviews, interviewers, evaluation_*, interview_evaluations, video_sessions | §8 Entretiens | T-13 |
| MVP-08 Étude de cas | M6, M11 | seeders démo + grilles versionnées | §11 Étude de cas | T-08→T-11, scénarios §38–39 |
| MVP-09 Exports PDF/Excel | M10 | exports, saved_report_templates | §10 Rapports | T-14, T-15, T-19, T-20 |
| MVP-10 Dashboard et sécurité | M2, M12 | agrégats applicatifs, audit_logs | §2 Dashboard | T-01, T-02, T-18, T-26, T-31, T-32, T-35 |

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
| T-11 Départager Amine/Youssef | PDF | MVP-05/06 | M6 | règle préétablie affichée ; **D-08 : Option E validée provisoirement par le propriétaire (2026-10-31) ⇒ Amine 70/100, Youssef 70/100, égalité conservée, aucun départage automatique, les deux profils restent accessibles à la revue humaine** ; décision définitive toujours ouverte |
| T-12 Carte Kanban sans droit | PDF | MVP-01/06 | M7 | refus, statut inchangé |
| T-13 Entretien en conflit d'horaire | PDF | MVP-07 | M8 | alerte + choix autre créneau |
| T-14 Export PDF avec filtres | PDF | MVP-09 | M10 | colonnes sélectionnées + filtres affichés |
| T-15 XLSX avec texte commençant par = | PDF | MVP-09 | M10 | valeur traitée comme texte non exécutable |
| T-16 Modifier une permission | PDF | MVP-01 | M12.3 | réservé admin + enregistré audit |
| T-17 Supprimer/archiver un candidat | PDF | MVP-03 | M4/M12.11 | politique appliquée, action autorisée+tracée |
| T-18 Statistiques période vide | PDF | MVP-10 | M2 | zéro/aucune donnée, sans erreur serveur |
| T-19 Accents français | PDF | MVP-09 | M10 | aucun caractère manquant/remplacé |
| T-20 Arabe/RTL si prévu | PDF | Bonus/D-15 | M12.5 | alignement/tableaux/police/exports vérifiés avant livraison |
| T-21 Un recruteur ne peut pas ouvrir l'administration par URL directe | MP §43 | MVP-01 | M12 | refus côté serveur |
| T-22 Une modification de rôle prend effet côté serveur et est inscrite dans l'audit | MP §43 | MVP-01/admin | M12 | effet serveur immédiat + ancienne/valeur/nouvelle + auteur/date dans audit_logs |
| T-23 Un utilisateur ne peut pas lire ou modifier les préférences d'un autre utilisateur | MP §43 | M13 | user_preferences | isolation stricte ; préférences ne changent jamais les droits |
| T-24 Une modification de scoring crée une nouvelle version et ne réécrit pas l'historique | MP §43 | MVP-05 | M6 | nouveau score lié à la version de grille, historique conservé |
| T-25 La réinitialisation Démonstration ne touche jamais la Production | MP §43 | M12.19 / mode démo | M12 | périmètre de réinitialisation strictement limité aux données marquées démo ; registre demo_runs ; double confirmation |
| T-26 Un CV privé n'est pas accessible avec une URL non autorisée | MP §43 | MVP-03 | M4/M0-sécurité | refus + journalisation |
| T-27 L'état « envoyé » n'est pas affiché si le fournisseur e-mail échoue ou n'est pas configuré | MP §43 | M9 | messages | aperçu/simulation clairement identifiés, jamais « envoyé » |
| T-28 Une sauvegarde peut être restaurée dans un environnement de test | MP §43 | exploitation | backups | base séparée restaurée avec succès |
| T-29 L'application démarre correctement sur WampServer via localhost, sans dépendre d'un hébergement Internet | MP §43 | CNF stack locale (§27–29) | install/global | démarrage local réussi sur chaque poste ; aucune dépendance à un service distant pour les fonctions cœur |
| T-30 Les comptes Démonstration et Administrateur disposent de permissions différentes | MP §43 | MVP-01 | M1/M12 | matrice appliquée côté serveur : chaque compte ne voit/exécute que ce que son rôle autorise |
| T-31 L'application continue de fonctionner pour les fonctions cœur sans accès Internet ; les services externes facultatifs sont signalés comme indisponibles | MP §43 | règle non négociable local-only (MP) | global | fonctions essentielles disponibles localement ; bandeaux explicites pour fournisseurs absents |
| T-32 Toutes les pages principales sont utilisables sur ordinateur et mobile | MP §43 | CNF UX | UI | responsive vérifié sur les écrans clés |
| T-33 Le script SQL et les migrations installent une base vierge sur chacun des cinq PC | MP §43 | install/§30 | migrations | clone+migrate+seed+login fonctionnel sur chaque poste. **Note d'exécution (D-25, 01/11/2026 — développeur unique)** : définition officielle conservée verbatim, non réaffectée ; l'équipe de 5 postes n'existant pas, la modalité d'exécution du test est à arbitrer par le propriétaire (**D-26**, `16_DECISIONS_EN_ATTENTE.md`) — ex. installation propre rejouée sur le poste unique + portabilité prouvée par clone+migrate+seed sur machine tierce de soutenance |
| T-34 Une sauvegarde locale de MySQL et des documents peut être restaurée sur une installation de test | MP §43 | D-05/§30/§32 | Git+migrations+backups | base + storage restaurés avec intégrité vérifiée |
| T-35 Aucun fichier de config/, database/, storage/ ou vendor/ n'est directement téléchargeable via Apache | MP §43 | sécurité/§31 | Apache/storage | 403/404 sur tentatives d'accès direct |

Note de complétude (règle A-07 — aucun identifiant officiel réaffecté) : les vérifications suivantes, nécessaires mais sans ID officiel, sont tracées comme contrôles de revue (PR/tests manuels), non comme tests numérotés : rejet d'un upload PHP déguisé (couvert fonctionnellement par T-06 « fichier interdit », contrôle code + revue sécurité), neutralisation injection SQL/XSS et anti-CSRF (contrôle transverse permanent, cf. `11_SECURITE_ET_CONFORMITE_09-08.md`), simulation vidéo différée questions/durées/statuts (Bonus, conditionné D-12).

## 3. Règles de gestion de la matrice

1. Toute exigence source non couverte par ≥1 test est une anomalie de périmètre → détectée ici : **toutes les MVP sont couvertes** ; les Bonus ont des tests conditionnels (T-20 selon D-15 ; la simulation vidéo différée est un contrôle de revue conditionné D-12, sans ID officiel — voir note de complétude §2).
2. Un test sans exigence = suspect ; T-21→T-35 tracés vers MP §43 + règles non négociables MP.
3. L'exécution réelle des tests (Phase 09) remplira une colonne Résultat (PASS/FAIL/BLOQUÉ + preuve) dans `docs/QUALITE/` ; **la présente matrice reste neutre** et ne doit jamais être éditée pour masquer un échec.
4. Divergence connue à traiter en Phase 09 : T-11 dépend de D-08 ; **Option E validée provisoirement (2026-10-31)** ⇒ le test validera « égalité affichée + revue humaine », PAS un classement imposé ; la décision définitive reste ouverte.
5. Intégrité des identifiants (correction A-07, 2026-10-31) : les définitions de T-01→T-35 sont rétablies **verbatim** depuis MP §42/§43 ; aucun ID officiel n'a été réaffecté ; tout test supplémentaire futur recevra un ID non conflictuel (ex. X-01) après validation du propriétaire.
