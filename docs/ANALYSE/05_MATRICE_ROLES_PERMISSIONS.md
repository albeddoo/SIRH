# Matrice des rôles et permissions (RBAC)

Sources : PDF §5 + MP V3 §8–11 (`CONFIRMÉ PAR SOURCE`) ; granularité technique = `PROPOSITION`. Implémentation : permissions configurables en base, **contrôlées côté serveur pour chaque route, fichier, action et export** ; toute modification de matrice est réservée à un administrateur autorisé et journalisée (T-16/T-22).

## 1. Rôles système

| Rôle | Accès principal | Limites imposées par la source |
|---|---|---|
| Admin technique | Comptes, invitations, rôles/permissions, paramètres globaux, référentiels, workflows, sécurité, sauvegardes, connecteurs, réinitialisation démo (permission dédiée) | **Pas de décision de recrutement par défaut** ; pas d'accès automatique à tous les CV si non nécessaire ; actions sensibles journalisées ; ne peut retirer le dernier admin actif sans procédure de transfert validée |
| Responsable RH | Tout le processus : offres, candidats/candidatures, grilles autorisées, shortlist, KPI, entretiens, décisions finales humaines | Ne modifie pas les traces d'audit ; ne gère pas comptes système/permissions globales |
| Recruteur | Offres et candidatures affectées : traiter CV, compléter fiches, calculer/consulter scores, transitions permises, préparer entretiens, notes internes | Pas de gestion de comptes ni permissions globales |
| Manager recruteur | Offre et shortlist de son équipe ; valide fiche de poste ; avis ; évaluations des entretiens où il participe | Rien hors périmètre équipe |
| Intervieweur | Entretiens attribués : infos nécessaires, questions/critères, saisie évaluation+commentaires | Pas de paramètres, pas de dossiers non liés, **ne modifie pas le score technique de présélection** |
| Direction / Observateur | Rapports agrégés autorisés, lecture seule | Pas de CV complets ni notes confidentielles sans besoin justifié + permission explicite |
| Candidat externe | Portail local : déposer candidature ; (Bonus portail authentifié) consulter ses candidatures, modifier données autorisées | Jamais d'autres candidats, scores d'autrui, notes RH, espaces RH |

Multi-rôles possibles selon règles du projet ; prévisualisation de l'accès effectif d'un utilisateur exigée (§24.3).

## 2. Modèle de permission (`PROPOSITION`)

Permission = `module.action` + portée optionnelle (`scope`: all / team / assigned / own / job:x). Exemples : `job.view`, `job.create`, `job.publish`, `candidate.view`, `candidate.update`, `cv.download`, `application.move_stage`, `score.calculate`, `score.override`, `interview.evaluate`, `decision.final`, `export.nominative`, `admin.users.manage`, `admin.roles.manage`, `admin.settings.manage`, `admin.audit.view`, `admin.backup.run`, `demo.reset`.
Contrôle : middleware RBAC sur chaque route + vérification de portée dans les services (jamais seulement l'affichage du menu).

## 3. Matrice fonctionnelle (base pédagogique, valeurs de la source)

Légende : Oui = autorisé par défaut ; Non = refusé ; Param. = paramétrable par admin autorisé ; Selon X = portée conditionnelle.

| Action | Admin tech | Resp. RH | Recruteur | Manager | Intervieweur | Direction | Candidat |
|---|---|---|---|---|---|---|---|
| Voir toutes les offres | Oui* | Oui | Selon affectation | Équipe | Offres liées | — | Offres publiées locales seulement |
| Créer/publier une offre | Param. | Oui | Si autorisé | Proposer | Non | Non | Non |
| Voir fiches candidats | Param. (limité par politique) | Oui (périmètre RH) | Dossiers assignés | Shortlist liée | Dossiers liés | Non | Seulement soi |
| Modifier fiche candidat | Non (hors champs techniques) | Oui | Selon droits | Non/demande | Non | Non | Données propres limitées |
| Modifier grille de scoring | Paramètres globaux | Grilles autorisées | Si autorisé | Non | Non | Non | Non |
| Voir score détaillé | Selon autorisation | Oui | Oui | Shortlist liée | Selon besoin entretien | Non par défaut | Non |
| Évaluer un entretien | Non par défaut | Oui | Si participant | Si participant | Si attribué | Non | Non |
| Prendre décision finale | **Non par défaut** | Oui | Proposition | Avis/validation workflow | Recommandation | Non | Non |
| Exporter données nominatives | Selon autorisation, tracé | Oui, tracé | Si autorisé | Rapport limité | Non par défaut | Agrégés autorisés | Ses propres données |
| Gérer comptes/rôles/permissions | Oui (seul) | Non | Non | Non | Non | Non | Non |

\* L'admin technique voit l'état du système ; l'accès aux données candidates nominatives reste gouverné par la politique (principe « administration ≠ pouvoir RH »).

## 4. Permissions par module (extrait technique pour Phase 02+)

| Module | Lectures | Écritures/actions | Réservé admin |
|---|---|---|---|
| Dashboard | `dashboard.view` (portée rôle) | widgets via préférences | — |
| Offres | `job.view` | `job.create/update/publish/suspend/close/archive/duplicate` selon statut machine + rôle | modèles/champs (`admin.job_settings`) |
| Candidats | `candidate.view` (portée), `cv.download` | `candidate.create/update`, tags/favoris, `candidate.archive/delete` (politique T-17) | règles fichiers/conservation |
| Candidatures | `application.view` | `application.create` (portail/affectation), `application.assign_recruiter`, `application.move_stage` (transitions autorisées), notes | étapes/transitions (`admin.pipeline`) |
| Scoring | `score.view` (portée) | `score.calculate/recalculate` (action explicite auditée), `score.override` avec motif | grilles/synonymes/départage (`admin.scoring`) |
| Entretiens | `interview.view` (lié) | planifier/déplacer/annuler, évaluer (auteur daté), simulation vidéo | types/questions/grilles (`admin.interviews`) |
| Communications | voir historique | envoyer/appliquer modèle (aperçu/simulation ; réel si SMTP validé) | templates/fréquences (`admin.notifications`) |
| Rapports/exports | rapports autorisés | générer export (permissions vérifiées avant fichier, journalisé si sensible) | modèles export (`admin.exports`) |
| Étude de cas | consulter | lancer calculs démo | réinitialiser démo (`demo.reset`) |
| Administration | — | — | tous sous-modules 24.x avec confirmation + audit |
| Préférences | lire/écrire **ses seules** préférences (T-23) | — | — |

## 5. Cycle de vie des comptes (PDF §5 / MP §11)

États : invité → activation en attente → actif → suspendu → désactivé.
Règles : création par admin ou inscription contrôlée ; activation par lien/code si e-mail configuré sinon procédure manuelle sécurisée ; mot de passe haché, jamais clair ; changement de mot de passe possible ; désactivation = révocation sessions + journalisation ; réinitialisation par jeton durée limitée, à usage unique, sans révéler l'existence de l'e-mail ; invitations expirantes ; comptes désactivés perdent leurs sessions existantes ; suspension temporaire réversible tracée.

## 6. Verrous transverses imposés par la source

1. Masquer un lien ne suffit jamais : contrôle serveur systématique (MP §8/§12, T-02/T-21).
2. Séparation stricte administration technique / décision RH.
3. Toute modification de permission/paramètre sensible : qui, quand, ancien/nouveau (audit).
4. Interdiction de retirer le dernier administrateur actif sans transfert validé.
5. Les préférences personnelles ne changent jamais les permissions.
6. Les exports nominatifs sont journalisés et réduits au besoin (« éviter une diffusion excessive de données personnelles »).

## 7. Décision ouverte impactant la matrice

- **D-08** : quelle que soit la règle retenue, elle est stockée comme paramètre de grille versionné, modifiable uniquement par rôle autorisé, avec affichage obligatoire de la règle active avant tout calcul de classement. En attendant : `tie_break_rule = NULL` → le moteur doit afficher l'égalité et exiger une décision humaine motivée.
