# PHASE 02 — AUTHENTIFICATION, RÔLES ET ADMINISTRATION

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Mettre en place la sécurité d’accès et le centre de contrôle du système. L’Administration doit être complète, mais les permissions métier et les décisions RH restent séparées des privilèges techniques.

## Tâches à réaliser dans l’ordre

1. Implémenter login/logout, sessions, hachage des mots de passe et cycle de vie des comptes.

2. Implémenter les rôles, permissions et contrôles côté serveur conformément à la matrice validée.

3. Développer le Dashboard Administration et la gestion des utilisateurs.

4. Développer le constructeur/gestion des rôles et permissions, sans permettre à un utilisateur de s’accorder lui-même des droits.

5. Développer les paramètres globaux, identité de l’entreprise, langues, référentiels, offres, pipeline et scoring.

6. Développer paramètres de notifications, conservation, confidentialité, sécurité, exports, audit et sauvegardes.

7. Développer les préférences personnelles indépendantes : langue, thème, notifications, vues et accessibilité.

8. Tester l’isolation des rôles et la protection des opérations administratives sensibles.

## Références fonctionnelles et techniques à respecter

## 8. Principes de gestion des comptes

Un utilisateur interne possède un compte et un rôle principal. Des permissions complémentaires ou plusieurs rôles peuvent être affectés lorsque cela est nécessaire.

Les candidats externes ne partagent jamais les mêmes écrans que l'équipe RH. Un candidat ne peut consulter que ses propres candidatures et les données qu'il est autorisé à modifier.

Le menu s'adapte au rôle, mais **masquer un lien dans l'interface ne suffit jamais** : chaque route, requête API, fichier, export et action doit vérifier la permission côté serveur.


## 9. Rôles à implémenter

### 9.1 Administrateur technique (Admin)

Accès principal : administration et maintenance de la plateforme.

Actions autorisées :
- Gérer les comptes, invitations, rôles et permissions.
- Configurer les paramètres de l'entreprise, la marque, les langues et le fuseau horaire.
- Gérer les taxonomies, référentiels et paramètres globaux.
- Configurer les modèles de scoring autorisés, les étapes de recrutement et modèles d'évaluation.
- Gérer les modèles de messages, les règles de conservation et les paramètres de fichiers.
- Consulter les journaux d'audit, l'état du système et l'état des sauvegardes.
- Exécuter ou superviser les opérations de sauvegarde et de restauration autorisées.
- Configurer les connecteurs, fournisseurs IA et notifications, sans exposer les secrets.
- Réinitialiser l'environnement de démonstration, selon une permission dédiée.

Limites :
- Aucun pouvoir de décision de recrutement par défaut.
- Pas d'accès automatique à tous les CV complets si cet accès n'est pas nécessaire et autorisé.
- Les actions sensibles et les changements de permissions doivent être journalisés.

### 9.2 Responsable RH

Accès principal : ensemble du processus de recrutement.

Actions autorisées :
- Créer et gérer les offres.
- Consulter les candidats et candidatures autorisés.
- Configurer les grilles de scoring dans le périmètre permis.
- Valider la shortlist.
- Suivre les KPI.
- Organiser les entretiens.
- Prendre et enregistrer les décisions finales humaines.

Limites : ne modifie pas les traces d'audit et ne gère pas les comptes système ni les permissions globales.

### 9.3 Recruteur

Accès principal : offres et candidatures qui lui sont affectées.

Actions autorisées :
- Traiter les CV et compléter les fiches.
- Calculer et consulter les scores autorisés.
- Déplacer une candidature dans le pipeline selon les transitions permises.
- Préparer les entretiens et ajouter des notes internes.

Limites : ne gère pas les comptes système ni les permissions globales.

### 9.4 Manager recruteur

Accès principal : offres et shortlist de son équipe.

Actions autorisées :
- Valider une fiche de poste.
- Consulter la shortlist liée à ses besoins.
- Donner un avis et évaluer les entretiens auxquels il participe.

Limites : pas d'accès aux autres offres ou dossiers hors de son périmètre.

### 9.5 Intervieweur

Accès principal : entretiens qui lui sont attribués.

Actions autorisées :
- Consulter les informations nécessaires à l'entretien.
- Consulter les questions et critères attribués.
- Saisir son évaluation et ses commentaires.

Limites : aucun accès aux paramètres, aux dossiers non liés, ni à la modification du score technique de présélection.

### 9.6 Direction / Observateur

Accès principal : rapports agrégés.

Actions autorisées : consulter les indicateurs et rapports non sensibles autorisés.

Limites : pas d'accès aux CV complets ni aux notes confidentielles sans besoin justifié et permission explicite.

### 9.7 Candidat externe

Accès principal : portail candidat.

Actions autorisées : déposer une candidature, consulter ses propres candidatures si le portail authentifié est activé et modifier les données personnelles explicitement autorisées.

Limites : aucun accès à la liste d'autres candidats, à leurs scores, aux notes internes ou aux espaces RH.


## 10. Matrice de permissions de référence

La matrice doit être implémentée sous forme de permissions configurables et contrôlées côté serveur. Les valeurs ci-dessous sont la base pédagogique ; l'Admin technique peut gérer la matrice, mais toute modification est auditée.

| Action | Accès principal | Limites et contrôles |
|---|---|---|
| Voir les offres | Resp. RH : toutes ; recruteur : selon affectation ; manager : équipe ; intervieweur : offres liées ; candidat : offres publiques | Le candidat ne voit jamais les offres privées ou non publiées. |
| Créer ou publier une offre | Resp. RH ; recruteur si autorisé ; manager peut proposer | Validation et publication soumises au rôle et au workflow. |
| Voir les fiches candidats | Resp. RH : périmètre RH ; recruteur : dossiers assignés ; manager : shortlist liée ; intervieweur : dossiers liés ; candidat : soi uniquement | Accès aux données nominatives et CV limité au besoin professionnel. |
| Modifier une fiche candidat | Resp. RH ; recruteur selon droits ; candidat : données personnelles limitées | Manager/intervieweur ne modifient pas le profil ; aucune fusion automatique. |
| Modifier la grille de scoring | Admin pour les paramètres globaux ; Resp. RH pour les grilles autorisées | Recruteur seulement si autorisé ; manager, intervieweur et candidat : non. |
| Voir un score détaillé | Resp. RH et recruteur autorisé ; manager selon shortlist ; intervieweur selon besoin | Candidat : non par défaut. Toute exception est tracée. |
| Évaluer un entretien | Resp. RH ; recruteur/manager s'ils participent ; intervieweur si attribué | Une évaluation est associée à son auteur et à l'entretien. |
| Prendre une décision finale | Resp. RH ; manager selon validation du workflow | Recruteur propose ; intervieweur recommande ; Admin technique n'a pas ce pouvoir par défaut. |
| Exporter des données nominatives | Selon permission, rôle et périmètre | Exports journalisés ; intervieweur non autorisé par défaut ; candidat limité à ses propres données. |
| Gérer les comptes et rôles | Admin technique uniquement | Toute modification est enregistrée dans l'audit ; ne pas supprimer le dernier Admin actif. |


## 11. Cycle de vie des comptes

Implémenter les états suivants : invité, activation en attente, actif, suspendu, désactivé.

Cycle de vie :

1. Création par un administrateur ou inscription candidat contrôlée.
2. Activation par lien ou code si un service e-mail est configuré ; sinon procédure d'activation manuelle sécurisée.
3. Connexion avec mot de passe haché de manière robuste ; jamais stocké en clair.
4. Modification du profil et changement du mot de passe.
5. Désactivation, révocation des sessions et journalisation en cas de départ.
6. Réinitialisation via jeton à durée limitée, à usage unique ; ne pas révéler si une adresse e-mail existe.

Les invitations doivent expirer. Les comptes désactivés ne doivent plus pouvoir utiliser leurs sessions existantes.

---

# PARTIE IV - MODULES FONCTIONNELS


## 24. Module Administration - Centre de contrôle global

Ce module est un élément central et obligatoire. Il doit donner à l'Administrateur technique le contrôle des paramètres du système, des utilisateurs, des rôles, des référentiels, des workflows, de la sécurité, des sauvegardes et des intégrations.

Il ne doit pas donner automatiquement le pouvoir de prendre une décision de recrutement. La séparation entre administration technique et décision RH doit être respectée.

Créer une entrée de navigation **Administration** réservée aux rôles autorisés, avec des sous-modules clairs. Le menu doit être dynamique selon les permissions.

### 24.1 Tableau de bord Administration

Afficher :

- Nombre de comptes actifs, invités, suspendus et désactivés.
- Rôles et permissions configurés.
- Statut de la base de données et du stockage des fichiers.
- Espace disque local utilisé et volume des documents stockés.
- État du service de notifications/e-mail.
- État du service IA et fournisseur actuellement actif.
- Dernière sauvegarde et résultat du dernier test de restauration.
- Dernières actions sensibles.
- Erreurs système récentes sous une forme non sensible.
- État des modules et fonctions activés/désactivés.

Afficher clairement les fonctions non configurées, simulées ou indisponibles. Ne pas afficher un statut vert si le test réel n'a pas été fait.

### 24.2 Gestion des utilisateurs et invitations

- Liste avec recherche, filtres et pagination.
- Création d'un compte interne.
- Invitation d'un utilisateur.
- Affectation d'un rôle et d'un périmètre d'accès.
- Modification et désactivation.
- Suspension temporaire.
- Révocation de toutes les sessions.
- Réinitialisation sécurisée du mot de passe.
- Historique des connexions et actions sensibles.
- Date de création, dernière connexion et statut du compte.
- Expiration des invitations.

L'administrateur ne doit jamais pouvoir lire les mots de passe. Toute réinitialisation est faite par un jeton sécurisé ou une procédure administrative auditée.

### 24.3 Gestion des rôles et permissions

- Matrice de rôles et permissions consultable.
- Création ou modification de rôles personnalisés si autorisé.
- Permissions par module, action et périmètre de données.
- Restrictions par offre, équipe, candidature ou participant.
- Prévisualisation de l'accès effectif d'un utilisateur.
- Confirmation avant une modification globale.
- Historique des anciennes et nouvelles permissions.
- Interdiction de retirer le dernier administrateur actif sans procédure de transfert validée.

### 24.4 Entreprise, identité et marque

Paramètres :

- Nom de l'entreprise.
- Nom du produit (SIRH par défaut, modifiable par un administrateur autorisé).
- Logo.
- Coordonnées publiques.
- Adresse et ville.
- Couleurs principales et secondaires.
- Texte de pied de page.
- Modèle de page publique.
- Informations affichées dans les exports.

Contrôler format et taille du logo et afficher un aperçu avant application.

### 24.5 Langue, date, heure et fuseau horaire

- Langue initiale : français.
- Prévoir l'architecture i18n.
- Anglais et arabe en option selon qualité des traductions et tests.
- RTL arabe uniquement après vérification de l'alignement, des tableaux, formulaires, rapports et exports.
- Fuseau horaire par défaut du cas : Africa/Casablanca, modifiable par l'organisation ou l'utilisateur selon permissions.
- Stocker les dates/horodatages dans un format cohérent en UTC, puis afficher dans le fuseau choisi.
- Ne jamais mélanger dates serveur et dates locales.
- Formats de date et nombres configurables.

### 24.6 Référentiels et taxonomies

Administrer :

- Départements.
- Villes.
- Types de contrat.
- Types de travail.
- Sources de candidature.
- Familles de postes.
- Compétences et catégories.
- Alias et synonymes contrôlés.
- Langues et niveaux.
- Motifs de refus, retrait, attente et annulation.
- Étiquettes et catégories.

Empêcher la suppression d'une valeur déjà utilisée ; proposer l'archivage ou le remplacement contrôlé. Garder l'historique des alias/synonymes utilisés.

### 24.7 Paramètres des offres et contrats

- Modèles d'offres.
- Départements, villes et types de contrat.
- Champs obligatoires et facultatifs.
- Règles de publication et validation.
- Référence automatique.
- Valeurs par défaut.
- Champs personnalisés si le schéma le permet proprement.

### 24.8 Administration du pipeline

- Étapes.
- Ordre des étapes.
- Transitions permises.
- Statuts finaux.
- Motifs de fin.
- Confirmations obligatoires.
- Permissions de transition par rôle.

Ne pas supprimer une étape déjà utilisée dans des candidatures historiques. L'archiver ou migrer les données selon une procédure explicite.

### 24.9 Administration du scoring

- Création de modèles de grille.
- Nom, description, version et offres concernées.
- Critères, poids, règles, seuils indicatifs et priorités.
- Type de critère : obligatoire, souhaité, informatif.
- Dictionnaire de synonymes approuvés.
- Gestion des données manquantes.
- Règle de départage.
- Prévisualisation du résultat sur profils fictifs.
- Validation avant publication.
- Conservation des anciennes versions.
- Recalcul uniquement via une action explicite et auditée.

Un changement de grille ne doit jamais modifier silencieusement les scores historiques.

### 24.10 Modèles d'entretiens et évaluations

- Types d'entretien.
- Durées par défaut.
- Questions.
- Grilles d'évaluation.
- Critères et échelles.
- Modèles par famille de postes.
- Version et auteur de chaque modèle.

### 24.11 Notifications et modèles de communication

- Modèles d'accusé de réception, invitation, rappel, refus et offre.
- Langues disponibles.
- Événements déclencheurs.
- Fréquence des rappels.
- Variables autorisées.
- Prévisualisation.
- Envoi de test si le service est réellement configuré.
- État des envois et erreurs.

### 24.12 Fichiers et conservation

- Formats autorisés.
- Taille maximale.
- Emplacement de stockage.
- Politique d'accès privé.
- Durée de conservation par type de document.
- Suppression des fichiers temporaires.
- Règles d'archivage et de suppression.
- Rapport d'usage du stockage.

Le stockage ne doit jamais être public par défaut. Les téléchargements doivent passer par un contrôle d'autorisation côté serveur.

### 24.13 Confidentialité et protection des données

- Politique/notice de confidentialité.
- Finalités de collecte.
- Données obligatoires et facultatives.
- Registre du consentement/information si requis.
- Durée de conservation par catégorie.
- Demandes de rectification, accès ou suppression selon procédure.
- Limitation des accès et exports nominatifs.
- Journalisation des actions sur données personnelles.
- Vérification de la localisation et des transferts de données si un fournisseur externe est utilisé.

Le système peut aider à appliquer ces règles, mais ne doit jamais s'auto-déclarer « certifié CNDP » ou « totalement conforme » sans validation juridique et réglementaire appropriée.

### 24.14 Sécurité, sessions et mots de passe

- Politique de mot de passe.
- Durée de session.
- Révocation des sessions.
- Limitation des tentatives.
- Politique de verrouillage.
- Paramètres CSRF/CORS/cookies.
- Journalisation des connexions.
- Gestion des secrets et clés API.

Les préférences de sécurité ne doivent pas permettre de désactiver silencieusement les protections obligatoires.

### 24.15 IA et intégrations

- Sélection du moteur local disponible.
- Activation/désactivation des fonctions IA.
- Connecteur de fournisseur externe désactivé par défaut.
- Gestion sécurisée des clés côté serveur uniquement.
- Vérification de la disponibilité du moteur local.
- Mode de secours par règles explicables si le moteur local est indisponible.
- Paramètres de conservation et d'envoi des données.
- Historique des analyses et moteur utilisé.

Aucun CV réel ne doit être envoyé à un fournisseur externe par défaut. Une intégration doit être activée uniquement après vérification de ses conditions, de l'âge/éligibilité du titulaire du compte, de la confidentialité, des transferts et de l'autorisation nécessaire.

### 24.16 Exports et modèles de rapports

- Modèles PDF/XLSX.
- Colonnes, ordre, regroupements et filtres.
- Logo, couleurs et pied de page.
- Formats et orientation.
- Champs sensibles inclus/exclus.
- Permissions par rôle.
- Historique des exports.

### 24.17 Journal d'audit

Tracer au minimum :

- Connexions et échecs de connexion significatifs.
- Création, modification, désactivation et changement de rôle.
- Modification des permissions.
- Changement d'offre et de statut de candidature.
- Modification de grille, critère, poids ou seuil.
- Recalcul de scores.
- Décisions, motifs et exceptions manuelles.
- Accès ou téléchargement de documents sensibles si possible.
- Exports nominatifs.
- Changements des règles de conservation.
- Sauvegarde, restauration et réinitialisation de démonstration.

Le journal ne doit jamais contenir de mots de passe, clés secrètes ou CV complets. Les entrées d'audit ne sont pas modifiables depuis l'interface normale.

### 24.18 Sauvegardes et état du système

- Afficher la date et le résultat de la dernière sauvegarde.
- Sauvegarder la base et les fichiers selon une politique définie.
- Documenter fréquence, rétention et emplacement.
- Tester périodiquement la restauration.
- Prévoir export de secours de la base et liste de contrôle des objets fichiers.
- Chiffrer les sauvegardes contenant des données personnelles.
- Ne jamais stocker de CV réels dans le dépôt Git.

Aucun mécanisme Cloud n’est requis. Les sauvegardes SQL et les documents sont gérés localement, avec une procédure de restauration documentée et testée.

### 24.19 Mode Démonstration et réinitialisation

- Données fictives clairement identifiées.
- Compte Démonstration à droits limités.
- Compte Administrateur séparé.
- Fonction de réinitialisation protégée par rôle dédié et confirmation explicite.
- Prévisualisation de ce qui sera supprimé.
- La réinitialisation ne touche jamais les données de production.
- Afficher clairement « Réinitialiser la démonstration supprimera les modifications de cet environnement ».


## 25. Préférences personnelles de chaque utilisateur

Les préférences personnelles sont distinctes des paramètres globaux de l'organisation. Elles ne donnent aucun droit supplémentaire.

Créer un espace **Mon profil / Mes préférences** pour chaque utilisateur connecté :

- Nom d'affichage et photo/avatar facultatif.
- Langue préférée parmi les langues effectivement disponibles.
- Thème clair/sombre/système si implémenté.
- Fuseau horaire personnel si autorisé.
- Format d'affichage date et heure.
- Préférences de notifications : événements, fréquence et canaux disponibles.
- Préférences du tableau de bord : widgets visibles et ordre.
- Filtres et vues sauvegardées.
- Préférences d'accessibilité : contraste, taille de texte ou options effectivement implémentées.
- Gestion des sessions et changement de mot de passe selon les règles de sécurité.

Chaque utilisateur ne peut modifier que ses propres préférences. Certaines politiques de sécurité ou valeurs globales peuvent être imposées par l'Administrateur.

Prévoir une action de réinitialisation des préférences personnelles aux valeurs par défaut, sans toucher aux données RH.


## 26. Règles communes de paramétrage

- Fournir des valeurs initiales raisonnables.
- Valider chaque paramètre avant enregistrement et afficher l'erreur près du champ.
- Demander confirmation pour les changements à fort impact.
- Enregistrer qui a modifié quoi et quand.
- Proposer une réinitialisation aux valeurs par défaut avec confirmation et sauvegarde.
- Ne pas modifier silencieusement les anciens scores : toute nouvelle grille a sa version et tout recalcul est conservé dans l'historique.
- Ne pas autoriser la suppression d'une valeur encore utilisée sans stratégie de migration ou d'archivage.
- Prévisualiser les modèles d'e-mail, export, branding et grilles avant activation.

---

# PARTIE VI - ARCHITECTURE TECHNIQUE ET ENVIRONNEMENT LOCAL


## Extrait du plan de réalisation d’origine

### Phase 2 - Authentification, rôles et Administration de base

- Login/logout et sessions.
- Gestion des comptes, rôles et permissions.
- Contrôles d'accès côté serveur.
- Structure du centre Administration.
- Paramètres globaux et préférences personnelles.
- Audit des opérations sensibles.

Livrable : utilisateurs de test avec accès effectivement différenciés.


## Livrables obligatoires

- [ ] Authentification sécurisée
- [ ] Matrice RBAC opérationnelle
- [ ] Centre Administration
- [ ] Gestion des comptes
- [ ] Paramètres globaux et métier
- [ ] Préférences personnelles
- [ ] Audit des actions sensibles
- [ ] Tests de permissions

## Critère de sortie et règle d’arrêt

Les comptes de test accèdent uniquement aux actions permises. Les paramètres sont persistants, les opérations sensibles sont journalisées et les préférences personnelles ne modifient pas les paramètres globaux.

## Rapport à remettre avant de passer à la phase suivante

- Résumé des objectifs et tâches réalisées.

- Liste exacte des fichiers créés/modifiés.

- Migrations SQL/seeders ajoutés et leur ordre d’exécution.

- Tests réellement exécutés, commandes utilisées et résultats.

- Anomalies restantes, risques et limites.

- Décisions nécessitant une validation humaine.

- Tableau des critères de sortie : validé / non validé / bloqué.

- Ne commence pas la phase suivante avant que l’utilisateur valide ce rapport.


---

# Contrat d'exécution Qwen — obligatoire

## Avant de toucher au code
1. Exécuter `git status --short --branch` et relever la branche et les changements non commités.
2. Examiner la structure actuelle du dépôt et les fichiers concernés ; ne pas supposer que le projet est vide.
3. Lire `QWEN.md`, `AGENTS.md`, `docs/00_LIRE_EN_PREMIER.md`, `docs/01_REGLES_ET_SOURCE_DE_VERITE.md`, `docs/DECISIONS_A_VALIDER.md`, le rapport de phase précédent si disponible, puis ce seul fichier de phase.
4. Ne pas lire automatiquement tous les autres fichiers de phase ou l'archive de référence.
5. Identifier les dépendances et les contrats (tables, routes, permissions, conventions) existants avant d'en créer de nouveaux.

## Pendant cette phase
- Respecter le périmètre strict de cette phase.
- Réutiliser les composants existants lorsqu'ils sont corrects ; ne pas réécrire l'application pour convenance.
- Présenter un plan court des fichiers à créer/modifier avant un changement transversal ou risqué.
- Ne jamais supprimer les changements préexistants d'un membre.
- Ajouter les migrations avant de consommer les nouvelles colonnes/tables.
- Chaque action UI doit avoir un comportement réel, un contrôle côté serveur et un état d'erreur/succès cohérent.
- Tester après chaque sous-fonctionnalité importante.
- Ne pas créer de données personnelles réelles ; utiliser des profils fictifs.

## À la fin
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_02.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Contrôles obligatoires de l'Administration

### Cycle de vie utilisateur
- création par Admin, activation/désactivation, modification contrôlée, invitation locale si email non configuré, réinitialisation avec jeton temporaire sécurisé, révocation de sessions ;
- empêcher la désactivation ou rétrogradation du dernier administrateur actif sans procédure de transfert ;
- ne jamais enregistrer un mot de passe en clair ou un mot de passe temporaire dans un log.

### RBAC
- permissions par module et action : view/create/update/delete/export/approve/manage ;
- portée des données : toutes, équipe, offres affectées, entretiens attribués, profil personnel ;
- vérification dans middleware/controller/service sur chaque requête ;
- masquer les menus ne constitue pas une protection ;
- test d'accès direct aux URL et aux endpoints AJAX.

### Centre Administration à couvrir
Dashboard Admin ; utilisateurs/invitations ; rôles/permissions ; entreprise/branding ; langue/date/fuseau ; référentiels/taxonomies ; offres/contrats ; étapes/transition pipeline ; grilles scoring/versions ; modèles d'entretien ; notifications/templates ; fichiers/conservation ; confidentialité ; sécurité/sessions ; IA/connecteurs (désactivés par défaut) ; modèles d'export ; audit ; sauvegardes/état système ; mode démonstration/reset.

### Préférences personnelles
Profil, langue disponible, thème si implémenté, fuseau horaire, format date/heure, notifications, widgets du dashboard, vues/filtres enregistrés, accessibilité et sessions. Un utilisateur ne peut modifier que ses propres préférences. Les préférences ne donnent aucun droit supplémentaire.

### Paramètres et audit
- validation serveur et prévisualisation ;
- confirmation des opérations à fort impact ;
- versionner les grilles et paramètres métier sensibles ;
- conserver valeur précédente/nouvelle, acteur, date et motif ;
- ne jamais permettre via Settings de désactiver CSRF, RBAC ou protections obligatoires.

### Critères de sortie additionnels
Les comptes de test ont des droits différents ; chaque permission est testée côté serveur ; Administration est inaccessible aux rôles non autorisés ; préférences d'un utilisateur sont privées ; changements sensibles apparaissent dans l'audit.


## Prompt exécutable — Phase 02

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_02_AUTHENTIFICATION_ADMINISTRATION.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 02 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
