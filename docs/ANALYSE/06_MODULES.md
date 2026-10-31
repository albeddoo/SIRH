# Description complète des modules

Sources : PDF §4/§6–14 + MP V3 Parties IV–V (§12–26). Chaque module = pages, actions, règles métier, contrôles d'accès. Aucun code en Phase 00.

## M0. Portail de candidature local (`CONFIRMÉ PAR SOURCE` MP §12)
- Pages : accueil ; liste offres publiées ; détail offre ; formulaire (nom, prénom, e-mail, téléphone, ville, lien pro facultatif, CV autorisé, informations requises, case information/consentement) ; confirmation avec numéro de candidature et résumé ; page politique de confidentialité/contact.
- Règles : dépôt **sans compte obligatoire** au MVP ; création ou rattachement du candidat (alerte doublon e-mail sans fusion) ; création de la candidature liée ; dépôt du fichier via contrôleur protégé ; le candidat ne voit jamais les autres candidats ni l'espace RH ; portail authentifié de suivi = Bonus (D-14b).

## M1. Authentification et comptes (MVP-01)
Connexion ; mot de passe oublié/réinitialisation par jeton limité/à usage unique sans révéler l'existence de l'e-mail ; profil ; préférences ; déconnexion ; limitation des tentatives ; sessions durcies révocables ; états invité/en attente/actif/suspendu/désactivé ; changement mdp premier login pour comptes seedés (MP §37).

## M2. Dashboard RH (MVP-10)
KPI calculés depuis les données réelles : candidatures reçues, candidats par étape, taux de passage à l'entretien, délai de recrutement (définition documentée), entretiens à venir, sources, offres actives, offres converties ; graphiques pipeline/volumes ; activités récentes ; raccourcis ; état vide propre (T-18) ; portée selon rôle ; widgets configurables via préférences (§25).

## M3. Offres d'emploi (MVP-02)
Liste+recherche+filtres+pagination ; créer/modifier (référence unique, présentation, exigences impératives vs atouts séparées, conditions, dates cohérentes, grille de scoring associée) ; aperçu public ; dupliquer (nouvelle référence) ; cycle brouillon→à valider→publiée→suspendue→clôturée→archivée avec transitions autorisées selon rôle et historique ; candidatures associées et volumes par étape ; export fiche de poste ; diffusion externe = connecteurs préparés, aucune publication simulée (MP §13).

## M4. Candidats & documents (MVP-03)
Répertoire filtrable/triable ; fiche (identité/contact validés, formation jamais déduite, expérience avec durée calculée et contrôle de chevauchement, compétences normalisées + provenance + statut validation, langues avec niveau documenté, pièces jointes) ; upload CV contrôlé (extension+MIME réel+taille) stockage privé ; recherche nom/e-mail/référence/compétence/offre ; doublons alertés sans fusion automatique ; favoris/étiquettes sans effet score ; notes internes séparées ; archivage/suppression logique selon conservation (T-17) ; accès CV via permission explicite (T-26).

## M5. Candidatures (MVP-04)
Lien candidat↔offre ; source, date, statut, documents, affectation recruteur, notes, score, timeline/historique, shortlist/décision/motif ; liste filtrable par offre/statut/date ; dépôt portail → « nouvelle candidature » + accusé (simulation si SMTP non configuré).

## M6. Matching & Scoring (MVP-05, MVP-08)
Modèles de grilles versionnés ; critères/poids/règles/seuils indicatifs paramétrés en base ; somme poids = 100 ou règle explicite ; synonymes/équivalences contrôlés ; moteurs de règle typés (booléen compétence documentée, plage expérience, catégorie formation liée/atout, outils maîtrisés) ; statuts des données manquantes Oui/Non observé/À vérifier/Absence confirmée/N/A ; calcul déclenché explicitement, audité ; explication par critère + preuve/champ source ; recalcul historisé sans écraser l'historique (T-24) ; comparateur de profils ; correction manuelle motivée ; **règle de départage active affichée avant calcul — D-08 NON TRANCHÉE** ; cas pédagogique : Nadia 90/Salma 85/Amine 70/Youssef 70/Imane 35 (T-08), français non documenté = 0 signalé (T-10). Voir `10_ARCHITECTURE_IA.md`.

## M7. Pipeline Kanban (MVP-06)
Colonnes : nouvelles candidatures ; à vérifier/présélection ; entretien RH ; entretien technique ; offre envoyée ; embauché/refusé/retiré/en attente. Glisser-déposer AJAX soumis permission serveur (T-12) ; confirmation transitions irréversibles ; historique ancien/nouveau/auteur/date/motif ; compteurs par colonne ; filtres offre/recruteur ; vue tableau accessible ; motif normalisé pour refus ; réouverture seulement si rôle/politique le permettent ; étapes administrables sans casser l'historique.

## M8. Entretiens & évaluations (MVP-07)
Calendrier ; créer/déplacer/annuler ; participants/créneaux ; conflits horaires détectés avec autre créneau (T-13) ; types présentiel/visio/vidéo différée ; lieu/lien visible uniquement concernés ; statuts à planifier→confirmé→réalisé/annulé/reprogrammé/absent ; questions liées aux missions ; grille 1–5 (technique, communication, résolution problèmes, compréhension missions, motivation) + preuve observée quand possible ; recommandation favorable/à approfondir/défavorable distincte du score CV ; une évaluation par évaluateur/entretien ; simulation vidéo différée (questions, temps, statut session, observations) ; interdit : émotion/facial/personnalité.

## M9. Communications & notifications
Modèles multi-langues avec variables autorisées ; événements : nouvelle candidature (accusé + alerte interne), invitation, rappel, décision → message correspondant, échec → alerte interne statut « échec » ; anti-doublon envoi si candidature modifiée ; centre de notifications internes ; journal des communications ; sans SMTP : aperçu + simulation identifiés ; **jamais « envoyé » sans confirmation réelle** (T-27).

## M10. Rapports & exports (MVP-09)
Rapports : dashboard analytique, offre/période/recruteur, shortlist+scores, entretiens, audit, fiche candidat autorisée. Paramètres dynamiques : formats XLSX/PDF (+CSV option), période/offre/département/recruteur/étape/statut/source/score minimal, sélecteur colonnes/ordre/tri/regroupements, titre/logo/société/date/auteur/filtres appliqués, pied de page + mention confidentialité, pagination/orientation, inclusion détail notes/graphiques/totaux, nom de fichier avec variables, modèles sauvegardés. Exigences Excel : .xlsx en-têtes clairs, formats dates/nombres, feuilles Données(+Résumé), **neutraliser les chaînes débutant par =** (T-15). Exigences PDF : accents français intacts (T-19), tableaux répétés multipages sans colonne coupée, RTL testé si arabe activé (T-20). Permissions vérifiées avant génération ; exports sensibles journalisés.

## M11. Étude de cas pédagogique
Cas DMS intégré comme jeu de démonstration réinitialisable : offre Chargé(e) Marketing Digital Junior, barème fourni, cinq profils exacts, calcul et égalité, justification des trois retenus, démonstration biais (synonyme inconnu/langue non documentée), scénarios T-08→T-11 ; ~150 candidatures fictives au total (seeders, Phase 09).

## M12. Centre Administration (MP §24.1→24.19) (`CONFIRMÉ MP`)

Présentation structurée en 19 sous-modules numérotés A-1 → A-19 (correspondance exacte §24.x du MP V3), chacun avec contenu, règles et contrôles :

### A-1 (§24.1) Tableau de bord Administration
Santé système, versions PHP/MySQL/migrations, extensions requises, tâches critiques en attente, avertissements. Lecture admin ; aucune action décorative.

### A-2 (§24.2) Gestion des utilisateurs et invitations
Liste avec états (invité/en attente/actif/suspendu/désactivé) ; création ; invitation expirante ; rôles multiples ; suspension temporaire réversible tracée ; réactivation tracée ; transfert de permissions si dernier admin actif. Permission `admin.users.manage`.

### A-3 (§24.3) Gestion des rôles et permissions
Matrice rôles↔permissions ; rôles personnalisés ; prévisualisation de l'accès effectif d'un utilisateur ; interdiction de retirer le dernier administrateur actif sans procédure de transfert validée ; audit complet de toute modification (T-16/T-22). Permission `admin.roles.manage`.

### A-4 (§24.4) Entreprise, identité et marque
Nom, logo (contrôle type/taille), coordonnées, couleurs, pied de page, aperçu avant application.

### A-5 (§24.5) Langue, date, heure et fuseau horaire
Langue par défaut dans les langues testées (D-15) ; formats date/heure/nombre ; fuseau par défaut Africa/Casablanca ; traductions complètes sinon masquées ; RTL testé si arabe activé (T-20).

### A-6 (§24.6) Référentiels et taxonomies
Villes, départements, catégories/familles de postes, niveaux, sources… ; archivage sans suppression si entité utilisée.

### A-7 (§24.7) Paramètres des offres et contrats
Types de contrat, temps de travail, modèles de fiches de poste, champs obligatoires/optionnels paramétrés.

### A-8 (§24.8) Administration du pipeline
Étapes, ordre, transitions permises par rôle, motifs finaux normalisés, confirmation requise par transition ; historique préservé ; jamais de suppression d'une étape utilisée.

### A-9 (§24.9) Administration du scoring
Modèles de grilles, critères, poids (somme validée), synonymes/équivalences contrôlés, traitement des données manquantes, seuils indicatifs (jamais de rejet automatique), **règle de départage** (NULL tant que D-08 non tranchée), versionnement/validation/auteur ; interdiction d'écraser les anciens scores (T-09/T-24).

### A-10 (§24.10) Modèles d'entretiens et évaluations
Types d'entretien, durées, banques de questions, grilles d'évaluation 1–5, versions et auteurs.

### A-11 (§24.11) Notifications et modèles de communication
Templates multi-langues, événements déclencheurs, variables autorisées, fréquence des rappels, aperçu/test ; statut réel du fournisseur e-mail affiché ; **pas de faux « envoyé »** (T-27).

### A-12 (§24.12) Fichiers et conservation
Extensions/MIME réels/tailles maximales ; stockage hors DocumentRoot ; propriétaires ; durées de conservation (`retention_policies`, D-19) ; archivage ; suppression planifiée ; anonymisation possible pour statistiques.

### A-13 (§24.13) Confidentialité et protection des données
Notices d'information, finalités, consentement si requis, demandes d'accès/rectification (traitement manuel au MVP), registre des traitements local (loi 09-08, cf. `11_...`).

### A-14 (§24.14) Sécurité, sessions et mots de passe
Politiques de mot de passe robustes mais utilisables ; expiration de session ; révocations multi-périphériques ; verrouillage après tentatives ; HTTPS local si pertinent ; journaux sans secrets.

### A-15 (§24.15) IA et intégrations
Fournisseur IA externe désactivé par défaut (D-18) ; périmètre local ; clés chiffrées jamais affichées ; revue humaine obligatoire des sorties ; journalisation des appels.

### A-16 (§24.16) Exports et modèles de rapports
Configuration colonnes/filtres/logo/pied de page/nommage ; permissions vérifiées avant génération ; traçabilité des exports sensibles ; neutralisation formules Excel (T-15).

### A-17 (§24.17) Journal d'audit
Colonnes utilisateur/action/objet (table+id)/ancien-nouveau/IP locale/résultat/date ; filtres et export réservés à un rôle habilité ; **append-only** (aucune édition via l'UI) ; exclusion stricte des mots de passe, tokens complets et contenus de CV.

### A-18 (§24.18) Sauvegardes et état du système
Sauvegarde SQL + storage (fréquence/rétention/emplacement/nommage/responsable paramétrés) ; ne pas écraser la dernière sauvegarde valide avant vérification ; restauration testée sur base séparée (T-28/T-34) ; chiffrement recommandé si données personnelles réelles ; état technique des migrations par poste.

### A-19 (§24.19) Mode démonstration et réinitialisation
Périmètre démo clairement marqué ; réinitialisation limitée à un rôle autorisé avec double confirmation ; **jamais sur la production** (T-25) ; registre `demo_runs` (déclencheur, périmètre supprimé, résultat).

Règles communes §26 : valeurs initiales raisonnables ; validation avant enregistrement ; confirmation pour tout impact fort ; qui/quand/quoi systématique ; reset par défaut avec confirmation + sauvegarde préalable ; paramètres stockés en base, jamais en dur.

## M13. Préférences personnelles (MP §25)
Profil (nom affichage, contact, photo professionnelle éventuelle, mdp) ; préférences (langue dans langues testées, thème, fuseau, formats date/heure/nombre, widgets dashboard, colonnes/filtres favoris, notifications internes, tris par défaut) ; sécurité personnelle (sessions actives révocables, historique connexions) ; **aucun effet sur permissions** ; isolation stricte (T-23).
