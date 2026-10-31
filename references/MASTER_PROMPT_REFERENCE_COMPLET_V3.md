---
title: "MASTER PROMPT V3 - SIRH LOCAL WAMP"
subtitle: "Cahier des charges fonctionnel, technique et opérationnel - Application locale PHP/MySQL"
date: "31 octobre 2026"
lang: fr-FR
---

**Projet pédagogique e-GRH - Mini-projet 1**  
**Nom de l’application : SIRH**  
**Périmètre fonctionnel : gestion numérique du recrutement (ATS)**  
**Entreprise du cas pratique : Digital Maroc Solutions - Casablanca, Maroc**

---

## INSTRUCTIONS À L'AGENT IA - À LIRE AVANT TOUTE ACTION

Tu es un architecte logiciel senior et développeur Full-Stack, spécialiste des systèmes RH/e-GRH, des applications PHP MVC, de MySQL, de WampServer, de la sécurité applicative et de l’IA explicable.

Ta mission est de concevoir, développer, tester et documenter **SIRH**, une application locale de gestion du recrutement (ATS) destinée à une PME fictive appelée **Digital Maroc Solutions**.

Le livrable final doit être une application web réellement fonctionnelle sur un environnement local Windows avec **WampServer, Apache, PHP et MySQL**. L’application sera lancée depuis `localhost` sur le PC qui héberge WampServer. Elle ne doit pas être publiée sur Internet et ne nécessite aucun hébergement Cloud. L’enseignant pourra la tester pendant une démonstration sur le PC hôte ou, si l’équipe le décide et sécurise le réseau local, depuis un autre appareil connecté au même LAN. Une installation locale documentée doit également permettre de reproduire le projet sur un autre PC.

### Règles non négociables

1. Le cahier des charges PDF fourni par l'utilisateur et les exigences fonctionnelles partagées dans la conversation constituent les références principales. Ce MASTER PROMPT les organise et les complète avec les choix techniques locaux et les exigences explicites de l'utilisateur.
2. Le nom du projet et de l'application est **SIRH**. Son périmètre de première version reste centré sur le recrutement (ATS) décrit dans le cahier des charges. Ne transforme pas silencieusement le projet en SIRH général avec paie, congés, pointage ou gestion complète des employés.
3. L'application est **locale uniquement** : WampServer + Apache + PHP + MySQL. Aucun hébergement Internet, domaine public, Cloudflare, Firebase, Supabase, serveur distant ou déploiement public n'est demandé ni autorisé par défaut.
4. Ne supprime, ne remplace et ne simplifie pas silencieusement une exigence du cahier des charges.
5. Distingue toujours **MVP obligatoire**, **fonction avancée/Bonus**, **hors périmètre** et **décision à confirmer**.
6. Ne code pas avant d'avoir terminé la Phase 0 - Cadrage et analyse - et présenté son rapport.
7. Toute action importante doit être reliée à une donnée persistante, à une règle métier et à un contrôle d'autorisation côté serveur. Une page décorative ou un bouton sans effet réel n'est pas une fonctionnalité terminée.
8. Ne crée pas de table, colonne, statut, droit ou règle métier sans le documenter et sans migration SQL correspondante.
9. Ne détruis aucune donnée et ne réinitialise pas les données de démonstration sans confirmation explicite.
10. N'expose jamais de mot de passe, jeton, clé API, CV ou donnée confidentielle dans GitHub, les journaux ou les messages d'erreur.
11. Ne transforme jamais le score en probabilité de réussite ni en décision automatique d'embauche ou de rejet.
12. Ne collecte pas de données de vrais candidats pour la démonstration. Utilise exclusivement des profils et documents fictifs.
13. Aucun membre de l'équipe ne doit travailler directement sur `main`. Les changements passent par branches, Pull Requests, revue et tests.
14. Les cinq membres utilisent les mêmes versions de PHP, MySQL, extensions PHP et dépendances Composer, définies et documentées en Phase 0.
15. Ne mélange pas MySQL et MariaDB entre les postes de développement sans décision explicite, vérification de compatibilité et tests communs.
16. N'expose jamais WampServer directement sur Internet. Le mode par défaut est `localhost` uniquement. Un accès LAN peut être autorisé ponctuellement pour une démonstration interne, après contrôle réseau et sans ouvrir le serveur au public.
17. Le dépôt GitHub contient le code, les migrations, les seeders fictifs et la documentation, mais jamais les bases de données réelles, les CV réels, les mots de passe ou les fichiers `.env`.
18. Après chaque phase, fournis les fichiers créés/modifiés, les migrations, les tests exécutés, les résultats, les limites connues et les étapes restantes.

**Première instruction : exécuter uniquement la Phase 0. Ne commence pas la programmation avant validation du cadrage.**
---

# PARTIE I - CONTEXTE, OBJECTIFS ET PÉRIMÈTRE

## 1. Présentation du produit

**SIRH** est le nom de l’application pédagogique. Dans cette première version, son module principal est un Applicant Tracking System (ATS) spécialisé dans la gestion du recrutement d’une PME. Il centralise les offres, les candidats, les candidatures, la présélection, le scoring, les entretiens, les décisions, les communications et les rapports.

**Digital Maroc Solutions** est l'entreprise fictive utilisée pour le cas pédagogique. Elle se situe à Casablanca et sert de contexte à la démonstration.

Le projet est un ATS spécialisé. Il ne doit pas devenir un SIRH complet dans sa première version.

## 2. Objectifs métier

- Centraliser les offres et les candidatures.
- Décrire et suivre le parcours numérique d'une candidature.
- Réduire les tâches administratives répétitives.
- Appliquer une grille de présélection pertinente, configurable et explicable.
- Créer une shortlist vérifiable.
- Planifier les entretiens et enregistrer les évaluations.
- Communiquer avec les candidats et conserver l'historique.
- Produire des tableaux de bord et rapports PDF/Excel.
- Protéger les données personnelles et maîtriser les accès.
- Maintenir une décision finale humaine, justifiée et traçable.

## 3. Objectifs pédagogiques e-GRH

L'application doit permettre de démontrer :

- La définition et l'utilité d'un ATS.
- La digitalisation du parcours de recrutement.
- La différence entre un suivi dispersé sur des fichiers et un pipeline centralisé.
- Le rôle des acteurs RH, managers, intervieweurs et candidats.
- L'application d'une grille de présélection explicable.
- Les limites des filtres, des mots-clés, des données manquantes et des algorithmes.
- La sécurité, les rôles, la confidentialité, la traçabilité et les KPI d'un système RH.

## 4. Périmètre fonctionnel

Le parcours de référence est :

**Offre d'emploi → Candidature → Profil candidat → Vérification → Scoring → Shortlist → Entretien RH → Entretien technique → Offre → Décision finale → Communication → Reporting.**

Les fonctions de paie, congés, bulletins de salaire, LMS complet et e-learning ne font pas partie de la version de base.

---

# PARTIE II - PRIORITÉS ET PÉRIMÈTRE MVP

## 5. Fonctions obligatoires du MVP

Les 10 fonctions suivantes sont obligatoires. Elles doivent être réellement opérationnelles et reliées à la base de données.

| Code | Fonction obligatoire | Critère d'acceptation |
|---|---|---|
| MVP-01 | Authentification et rôles | Chaque utilisateur accède uniquement aux pages et actions autorisées. |
| MVP-02 | Offres d'emploi | Créer, modifier, publier, suspendre, clôturer et archiver une offre. |
| MVP-03 | Candidats et CV | Créer une fiche, joindre un CV, rechercher et modifier les informations autorisées. |
| MVP-04 | Candidatures | Lier un candidat à une offre et suivre son statut. |
| MVP-05 | Scoring paramétrable | Appliquer les critères pondérés et expliquer chaque note. |
| MVP-06 | Shortlist et Kanban | Classer les candidats, visualiser et modifier les étapes avec historique. |
| MVP-07 | Entretiens et évaluations | Planifier un entretien, saisir une évaluation et enregistrer une recommandation/décision. |
| MVP-08 | Étude de cas | Charger les cinq profils fictifs et restituer correctement la grille fournie. |
| MVP-09 | Exports PDF et Excel | Exporter les listes et rapports avec colonnes et filtres choisis. |
| MVP-10 | Dashboard et sécurité | Afficher des indicateurs calculés et protéger les accès et fichiers. |

## 6. Fonctions avancées / Bonus

Les fonctions suivantes sont prévues dans l'architecture, mais ne doivent pas retarder la livraison d'un MVP complet :

- Parsing automatique avancé de CV PDF/DOCX.
- Import massif CSV/XLSX et lots de CV.
- Assistant IA génératif.
- Matching sémantique avancé.
- Notifications e-mail réellement envoyées.
- Portail candidat avec compte et suivi authentifié.
- Entretien vidéo différé réel avec enregistrement sécurisé.
- Intégrations à des systèmes RH externes.
- Multidiffusion automatique d'offres vers LinkedIn, Indeed et Rekrute via API autorisée.

Si une dépendance, une autorisation, une API, une bibliothèque ou le temps disponible ne permet pas de livrer une fonction Bonus proprement, documente la limite et livre d'abord une alternative fonctionnelle simple.

## 7. Fonctions hors périmètre initial

Ne pas développer dans cette version :

- Paie, congés et bulletins de salaire.
- Plateforme LMS complète ou e-learning.
- Rejet ou embauche automatiques par algorithme.
- Analyse biométrique, reconnaissance des émotions ou notation à partir d'une photo.
- Publication automatique sur une plateforme externe sans API, autorisation et identifiants valides.

---

# PARTIE III - UTILISATEURS, RÔLES ET PERMISSIONS

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

## 12. Portail candidat local

Créer une page d'accueil locale et un mini-portail de candidature accessible depuis l'installation WampServer, par exemple via `http://localhost/SIRH/public/` ou un Virtual Host local documenté.

Pages prévues :

- Accueil et présentation de SIRH / Digital Maroc Solutions.
- Liste des offres ouvertes dans l'environnement local.
- Détail d'une offre.
- Formulaire de candidature.
- Confirmation et numéro de candidature.
- Politique de confidentialité et contact.

Le terme « portail public » désigne ici une page accessible sans connexion RH **sur l'instance locale**. Il ne signifie pas que le site est accessible depuis Internet. Le dépôt de candidature doit fonctionner sans compte candidat pour le MVP, dans les limites de l'installation locale.

Le formulaire doit valider les champs, contrôler les fichiers, présenter les erreurs et enregistrer la candidature sans double soumission accidentelle.

Comme l'application n'est pas hébergée sur Internet, les candidats externes ne peuvent pas déposer une candidature à distance. Cette limite doit être clairement indiquée dans la documentation et pendant la démonstration. Un accès depuis le réseau local ne peut être activé que pour une démonstration interne contrôlée.
## 13. Dashboard RH

Afficher des KPI calculés à partir des données persistées :

- Candidatures reçues sur une période.
- Nombre de candidats à chaque étape du pipeline.
- Taux de passage à l'entretien.
- Délai de recrutement.
- Entretiens à venir.
- Sources de candidature.
- Offres actives.
- Offres converties en embauche.
- Activité récente et raccourcis.

### Définitions à rendre configurables/documentées

- **Candidatures reçues :** nombre de candidatures créées sur la période.
- **Candidats par étape :** nombre de candidatures actuellement dans chaque statut.
- **Taux de passage à l'entretien :** nombre ayant atteint une étape d'entretien / nombre de candidatures éligibles selon la règle choisie.
- **Délai de recrutement :** nombre de jours entre l'ouverture/publication du besoin et la décision ; la date de départ doit être définie clairement.
- **Entretiens à venir :** entretiens planifiés dans la période sélectionnée.
- **Sources :** répartition selon la source enregistrée.
- **Offres converties en embauche :** embauches finalisées selon une définition documentée.

Les graphiques doivent inclure les états vides. Une période sans données doit afficher zéro ou « aucune donnée », sans erreur serveur.

## 14. Gestion des offres d'emploi

### Champs de la fiche de poste

**Identification :** référence, titre, entreprise, département, responsable recruteur. La référence est unique et peut être générée automatiquement.

**Présentation :** résumé, missions, responsabilités, contexte et avantages.

**Exigences :** formation minimale, domaine, expérience, compétences obligatoires et souhaitées.

**Conditions :** ville, type de contrat, temps de travail, date de publication, date de clôture et nombre de postes.

**Scoring :** modèle de grille associé, critères et poids.

**Publication :** brouillon, à valider, publiée, suspendue, clôturée, archivée.

Séparer les exigences impératives des atouts souhaités. Éviter les exigences non nécessaires.

### Actions

- Créer une offre à partir d'un formulaire ou d'un modèle.
- Prévisualiser avant publication.
- Dupliquer une offre en créant une nouvelle référence.
- Publier, suspendre, reprendre, clôturer et archiver selon permissions.
- Voir les candidatures rattachées, les volumes par étape et les délais.
- Exporter la fiche de poste ou le rapport associé.

Toute transition de statut doit être autorisée selon le rôle et enregistrée.

### Diffusion externe

Prévoir une architecture de connecteurs pour le site carrière, LinkedIn, Indeed et Rekrute. Aucune publication automatique ne doit être simulée. Sans API officielle, autorisation et identifiants valides, fournir un texte exportable et une procédure de publication manuelle.

## 15. Gestion des candidats

### Fiche candidat

**Identité et contact :** nom, prénom, e-mail, téléphone, ville et liens professionnels facultatifs.

**Formation :** diplôme, spécialité, établissement, année et niveau. Ne jamais déduire un diplôme qui n'est pas renseigné.

**Expérience :** poste, employeur, dates, missions et durée calculée si les dates sont disponibles. Éviter le double comptage de périodes qui se chevauchent.

**Compétences :** compétences normalisées, niveau si justifié et provenance de l'information.

**Langues :** langue et niveau documenté. Distinguer « non renseigné » de « niveau insuffisant ».

**Pièces jointes :** CV original, portfolio et documents autorisés.

**Traçabilité :** date de création, origine, information/consentement, mises à jour et historique.

### Fonctions de recherche et de qualité

- Recherche par nom, e-mail, référence, compétence ou offre.
- Filtres combinables : statut, ville, formation, expérience, date, recruteur et score.
- Tri par date, nom, score ou étape.
- Pagination pour les volumes importants.
- Détection d'un e-mail déjà utilisé et suggestion de doublon.
- Aucune fusion irréversible automatique.
- Favoris et étiquettes sans modification du score.
- Notes internes séparées des informations visibles au candidat.
- Archivage et suppression contrôlée selon le rôle et les règles de conservation.

Un même candidat peut répondre à plusieurs offres. Le profil candidat est séparé de ses candidatures.

## 16. Importation des CV et parsing

Le parsing avancé est une fonction utile mais non obligatoire pour le premier prototype. **L'upload du CV et la saisie manuelle vérifiée sont prioritaires.**

### Parcours cible

1. **Dépôt :** accepter les formats autorisés, afficher le nom et la taille.
2. **Contrôle :** vérifier extension, type réel/MIME, taille, nom interne sûr ; stocker dans un espace non public.
3. **Extraction :** extraire le texte et détecter, si possible, coordonnées, formations, dates et compétences.
4. **Préremplissage :** proposer des champs avec provenance et niveau de confiance si disponible.
5. **Vérification :** RH corrige ou confirme chaque donnée avant tout scoring sensible.
6. **Historique :** conserver le fichier original et l'horodatage de traitement ; supprimer les fichiers temporaires selon la politique.

Gérer les erreurs : format non autorisé, fichier trop volumineux, nom invalide, fichier suspect, échec d'analyse, accès refusé, PDF scanné, langue non prise en charge, mise en page complexe, champ incertain ou contradiction.

Ne jamais enregistrer comme certaine une extraction erronée. Ne jamais inventer des informations absentes du CV.

### Import massif

Si l'import de masse est développé :

- Prévisualiser le nombre de lignes/fichiers avant import.
- Afficher un rapport : créés, ignorés, doublons possibles et erreurs.
- Permettre le téléchargement d'un fichier d'erreurs sans exposer les données à des utilisateurs non autorisés.
- Ne rejeter silencieusement aucune ligne incorrecte ; expliquer la raison.
- Limiter la taille des lots et ne pas bloquer toute l'interface.

## 17. Candidatures

Une candidature (`application`) relie un candidat (`candidate`) à une offre (`job`). Elle conserve ses propres informations : source, date, statut, documents liés, affectation, notes, score et historique.

Fonctionnalités :

- Liste filtrable par offre, statut et date.
- Détail d'une candidature.
- Timeline des changements.
- Affectation à un recruteur.
- Scoring détaillé.
- Shortlist, décision et motif documentés.
- Commentaires et notes internes contrôlés par permissions.

Les informations du profil candidat restent séparées des informations propres à chaque candidature.

## 18. Matching et scoring explicable

### Principe

Le score rapproche les informations documentées d'un candidat des exigences d'une offre. Les critères, poids, règles et seuils doivent être visibles, configurables et versionnés. Le score aide au tri ; il ne prédit pas avec certitude la réussite future.

### Grille pédagogique sur 100 points

| Critère | Maximum | Règle du cas |
|---|---:|---|
| Formation liée au poste | 20 | Domaine pertinent : 20 ; autre domaine : 0. |
| Expérience | 20 | 1 an ou plus : 20 ; 6 à 11 mois : 10 ; moins de 6 mois : 0. |
| SEO | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Réseaux sociaux | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Google Analytics | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Excel | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Français professionnel | 10 | Mentionné : 10 ; non documenté : 0 pour le cas pédagogique. |
| Canva et CRM | 10 | 5 points par outil maîtrisé. |

La somme des poids doit être égale à 100, ou une autre échelle doit être explicitement configurée et affichée. Les règles, poids, synonymes, seuils et priorités de départage ne doivent pas être codés en dur.

### Traitement des données manquantes

Dans l'exercice pédagogique, le français non documenté vaut 0 conformément au tableau fourni. Dans une candidature réelle, l'interface doit afficher distinctement :

- Oui / documenté.
- Non observé.
- À vérifier.
- Non applicable, si la règle le prévoit.

Une information absente ne doit pas automatiquement être interprétée comme une compétence absente. Afficher les champs manquants et leur impact sur le score.

### Résultats de référence

| Candidat | Formation /20 | Exp. /20 | Compétences /40 | Français /10 | Atouts /10 | Total /100 |
|---|---:|---:|---:|---:|---:|---:|
| Nadia | 20 | 20 | 40 | 0 | 10 | **90** |
| Salma | 20 | 20 | 40 | 0 | 5 | **85** |
| Amine | 20 | 10 | 40 | 0 | 0 | **70** |
| Youssef | 20 | 20 | 20 | 0 | 10 | **70** |
| Imane | 0 | 20 | 10 | 0 | 5 | **35** |

Hypothèses de calcul : la formation en finance d'Imane n'est pas considérée comme directement liée au poste ; les quatre compétences clés valent 10 points chacune ; le français professionnel n'est pas documenté dans les cinq profils et vaut donc 0 pour ce cas ; Canva et CRM valent 5 points chacun.

### Égalité Amine / Youssef - décision à conserver visible

Le PDF propose de départager Amine et Youssef par la priorité accordée aux compétences clés : Amine obtient 40/40 contre 20/40 pour Youssef. La shortlist pédagogique proposée dans le PDF est donc **Nadia, Salma et Amine** si cette règle est annoncée avant le scoring.

Une note fournie auparavant par l'utilisateur proposait au contraire de placer Youssef avant Amine en privilégiant l'expérience puis les atouts. Il existe donc une divergence entre les deux versions. Ne la masque pas et ne change pas la règle silencieusement :

- rendre la priorité de départage configurable ;
- afficher la règle active avant le calcul ;
- présenter la règle « compétences clés » comme proposition par défaut du PDF ;
- demander une validation en Phase 0 si l'enseignant impose l'autre règle ;
- si aucune règle n'est validée, afficher l'égalité et demander une revue humaine au lieu d'inventer un classement.

### Paramètres du moteur de scoring

- Nom et version du modèle/grille.
- Offre ou famille de postes concernée.
- Liste des critères, description, poids et type : obligatoire, souhaité ou informatif.
- Règles de calcul et éventuelles équivalences contrôlées de termes.
- Règle de départage annoncée avant le calcul.
- Traitement des données manquantes.
- Seuil indicatif de revue manuelle, jamais un rejet final automatique.
- Détail du score, date, version de grille et utilisateur déclencheur.
- Possibilité de recalculer après changement des données, en conservant l'historique.

Toute correction manuelle d'un score ou d'un statut nécessite un motif, un auteur, une date et une ancienne/nouvelle valeur. Un résultat historique doit rester associé à la version de grille utilisée.

### Équité et limites

Démontrer au minimum les risques suivants :

- Mot-clé absent ou synonyme inconnu.
- CV incomplet ou format atypique.
- Biais de données historiques.
- Surpondération du diplôme ou du nombre d'années.
- Fausse précision : un score de 82/100 ne signifie pas 82 % de probabilité de réussite.
- Effet de seuil : un candidat juste sous le seuil n'est pas nécessairement dépourvu de potentiel.
- Données non comparables entre profils.

Mesures :

- Séparer « oui », « non observé » et « à vérifier ».
- Autoriser les synonymes et compétences équivalentes contrôlées.
- Afficher notes, champs utilisés et informations manquantes.
- Tester des profils fictifs variés.
- Tracer toute modification manuelle et demander son motif.
- Interdire les critères non pertinents comme photo, genre ou origine.
- Garder la décision finale humaine.

Phrase de démonstration à pouvoir expliquer : « Notre ATS automatise les tâches répétitives et rend les critères visibles, mais il ne remplace pas le jugement professionnel. Chaque score est explicable, contestable et soumis à une validation humaine. »

## 19. Shortlist et comparateur de profils

- Produire une liste de profils proposés selon la grille active.
- Afficher le score total, le détail par critère, les points forts et les informations à vérifier.
- Comparer plusieurs candidats dans une vue commune.
- Afficher la règle de départage appliquée.
- Permettre au Responsable RH de retenir, écarter ou revoir un profil avec motif documenté.
- Conserver l'historique des décisions et des exceptions.

Aucun candidat ne doit être rejeté définitivement par un filtre ou un seuil sans revue humaine prévue par les règles du projet.

## 20. Pipeline de candidature et Kanban

### Étapes de référence

1. Nouvelle candidature.
2. À vérifier.
3. Présélection.
4. Entretien RH.
5. Entretien technique.
6. Offre envoyée.
7. Embauché.
8. Refusé / retiré / en attente.

Le modèle PDF décrit les objectifs et transitions autorisées :

- **Nouvelle candidature :** accuser réception, vérifier la complétude, voir le CV, signaler des données manquantes et affecter à un recruteur. Transitions : à vérifier, retirée, doublon à examiner.
- **À vérifier :** contrôler les critères de base et les informations extraites, compléter le profil, lancer le scoring, demander une clarification si autorisé. Transitions : présélection, attente, refus proposé.
- **Présélection :** comparer, annoter les points à vérifier et faire valider la shortlist. Transitions : entretien RH, attente, refus validé.
- **Entretien RH :** évaluer les motivations et la communication liées au poste, planifier les questions et enregistrer l'évaluation. Transitions : entretien technique, attente, refus validé.
- **Entretien technique :** vérifier les compétences métier avec questions ou épreuve pertinente. Transitions : offre envisagée, entretien complémentaire, refus validé.
- **Offre envoyée :** suivre la proposition, l'échéance et la réponse. Transitions : embauché, offre déclinée, délai expiré.
- **Embauché :** enregistrer la date et clôturer le parcours ; transfert éventuel vers un SIRH futur.
- **Refusé / retiré / en attente :** choisir un motif normalisé et préparer la communication autorisée. Réouverture seulement si rôle et politique le permettent.

### Comportement Kanban

- Glisser-déposer une carte uniquement si l'utilisateur a la permission de transition.
- Demander confirmation pour les transitions irréversibles ou importantes.
- Conserver ancien statut, nouveau statut, auteur, date et motif.
- Afficher le nombre de candidatures dans chaque colonne.
- Filtres par offre et recruteur.
- Fournir une vue tableau accessible en complément du Kanban.
- Ne jamais faire disparaître une candidature sans motif ni historique.

## 21. Entretiens et évaluations

### Planification

Chaque entretien comprend :

- Candidature, candidat, offre et étape du pipeline.
- Date, heure et durée.
- Responsable et participants.
- Type : présentiel, visioconférence ou entretien vidéo différé.
- Adresse ou lien de réunion, visible uniquement aux personnes concernées.
- Statut : à planifier, confirmé, réalisé, annulé, reprogrammé ou absent.
- Rappels et résultat.

Valider les formats de date/heure et détecter les conflits de calendrier. En cas de conflit, afficher une alerte et permettre de choisir un autre créneau.

### Grille d'évaluation

Échelle proposée de 1 à 5 :

- Compétences techniques.
- Communication professionnelle.
- Résolution de problèmes.
- Compréhension des missions.
- Motivation liée au poste.

Chaque note doit être reliée à une question ou une preuve observée lorsque possible. La recommandation est distincte du score CV : favorable, à approfondir ou défavorable. Une fiche distincte est conservée par évaluateur/entretien.

### Vidéo différée

Pour le MVP, une simulation suffit : questions, temps de préparation/réponse, statut de session et observations de l'équipe. Le stockage réel de vidéos est une extension séparée.

Si l'enregistrement réel est activé ultérieurement : information claire, consentement adapté, accès limité, durée de conservation définie, suppression planifiée. Aucune reconnaissance d'émotions, analyse faciale ou notation automatique de personnalité.

## 22. Communications et notifications

Prévoir :

- Modèles d'e-mails.
- Accusé de réception.
- Invitation et rappel d'entretien.
- Message de refus.
- Message d'offre.
- Historique des communications.
- Centre de notifications internes.

Événements : nouvelle candidature, entretien planifié, rappel, décision enregistrée, échec d'envoi.

Contrôles :

- Éviter l'envoi multiple si la candidature est modifiée.
- Utiliser le bon fuseau horaire.
- Inclure les informations d'annulation/reprogrammation si prévues.
- Rendre la fréquence des rappels configurable.
- Prévisualiser le message avant envoi lorsque nécessaire.
- En cas d'échec, afficher « échec » ; ne jamais afficher « envoyé » si le service a échoué.
- Sans fournisseur e-mail configuré, utiliser un aperçu et un journal de simulation clairement identifiés.

## 23. Rapports, tableaux de bord et exports PDF/Excel

### Rapports à fournir

- Tableau de bord analytique.
- Rapport par offre, période et recruteur.
- Rapport shortlist et scores.
- Rapport des entretiens.
- Rapport d'audit.
- Fiche candidat autorisée.

### Formats

PDF et XLSX prioritaires ; CSV en option.

### Paramètres dynamiques d'export

- Période, offre, département, recruteur, étape, statut, source et score minimal si autorisé.
- Sélecteur de colonnes et ordre des colonnes.
- Tri et regroupements.
- Titre du rapport, logo, nom de société, date de génération, auteur et filtres appliqués.
- Couleurs et style d'en-tête.
- Numéros de page, pied de page et commentaires de confidentialité.
- Inclusion/exclusion des notes, graphiques, totaux et résumés.
- Nom de fichier personnalisable avec variables telles que nom du rapport et date.
- Modèles d'export sauvegardés.
- Vérification des permissions avant génération et journalisation des exports sensibles.

### Exigences Excel

- Fichier XLSX avec en-têtes clairs et formats adaptés aux dates/nombres.
- Ne pas insérer de formules à partir de données utilisateur non fiables.
- Neutraliser les chaînes pouvant être interprétées comme formules.
- Feuille « Données » et, si utile, feuille « Résumé ».
- Respecter colonnes sélectionnées, filtres et tri.

### Exigences PDF

- Mise en page lisible, logo si configuré, date et filtres.
- Tableaux répétés proprement sur plusieurs pages.
- Aucune colonne coupée.
- Orientation portrait/paysage selon le rapport.
- Accents français correctement rendus ; RTL testé si l'arabe est activé.

---

# PARTIE V - ADMINISTRATION CENTRALE, PARAMÈTRES ET PRÉFÉRENCES

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

## 27. Stack technique imposée pour le projet local

L'application doit être développée avec une architecture web PHP classique, adaptée à WampServer et au travail académique en équipe.

| Couche | Technologie | Rôle |
|---|---|---|
| Système de développement | Windows 10/11 | Environnement des cinq membres |
| Serveur local | WampServer 64-bit | Environnement Apache/PHP/MySQL local |
| Serveur HTTP | Apache 2.4.x | Servir l'application depuis `localhost` |
| Backend | PHP 8.2+ (version commune à confirmer en Phase 0) | Contrôleurs, services et règles métier |
| Architecture | MVC personnalisé en PHP | Séparation Controllers / Models / Views |
| Base de données | MySQL 8.x | Stockage relationnel persistant local |
| Accès SQL | PDO MySQL + requêtes préparées | Accès sûr à la base |
| Encodage | UTF-8 / `utf8mb4` | Français, accents et caractères arabes si activés |
| Frontend | HTML5 + CSS3 | Structure et présentation |
| Framework UI | Bootstrap 5 | Mise en page responsive et composants |
| JavaScript | JavaScript natif (Vanilla JS) + AJAX/Fetch | Interactions dynamiques |
| Dépendances PHP | Composer | Gestion contrôlée des bibliothèques |
| Excel | PhpSpreadsheet | Import/export XLSX si retenu |
| PDF | Dompdf ou mPDF | Génération des rapports PDF, choix à valider par test |
| Versionnement | Git + GitHub privé | Historique du code et collaboration |
| Éditeur | Visual Studio Code | Développement sur chaque PC |

### Contraintes de stack

- Utiliser PHP MVC personnalisé ; ne pas remplacer le projet par Laravel, Symfony, Node.js, React, Vue ou Next.js sans demande explicite de l'utilisateur et validation de l'enseignant.
- Le frontend peut utiliser Bootstrap 5 et JavaScript natif. Éviter les frameworks JavaScript supplémentaires non nécessaires.
- Utiliser exclusivement MySQL comme moteur de référence de l'équipe, avec une version commune. Ne pas laisser certains membres développer sur MariaDB et d'autres sur MySQL sans test de compatibilité documenté.
- Utiliser PDO avec `PDO::ATTR_ERRMODE = PDO::ERRMODE_EXCEPTION`, requêtes préparées et transactions pour les opérations multi-tables.
- Utiliser `InnoDB`, `utf8mb4`, clés étrangères, index et contraintes SQL pertinentes.
- Ne jamais coder en dur un chemin de type `C:\wamp64\www\SIRH` dans la logique métier. Prévoir `BASE_URL` ou une configuration équivalente, compatible avec un sous-dossier WAMP et un Virtual Host local.
- Tous les chemins et redirections doivent être construits via une configuration centrale. Aucun chemin absolu spécifique à un PC dans le code partagé.
- Vérifier la compatibilité réelle de chaque bibliothèque Composer avec la version PHP commune et l'environnement WampServer avant son adoption.

### Environnement commun à définir en Phase 0

L'équipe doit relever sur les cinq PC :

- Version exacte de Windows.
- Version de WampServer.
- Version d'Apache.
- Version de PHP active.
- Version de MySQL active.
- Extensions PHP activées (`pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `gd`, `intl` si nécessaire, `zip` et autres justifiées).
- Version de Composer et de Git.

Choisir ensuite une combinaison qui fonctionne sur les cinq postes et consigner les versions exactes dans `docs/ENVIRONMENT.md`. Le projet ne doit pas commencer à produire des fonctionnalités tant que les cinq environnements ne peuvent pas exécuter la même page de test et se connecter à une base `SIRH` locale.

## 28. Installation WampServer et démarrage local

L’application est exécutée localement. Préserver les autres projets déjà présents sur WampServer : ne pas renommer leurs dossiers, ne pas supprimer leurs bases et ne pas modifier les ports ou versions globales sans accord et sauvegarde. La procédure cible est :

1. Vérifier les prérequis système et sauvegarder la configuration WampServer existante avant toute modification.
2. Installer ou vérifier WampServer sur chaque PC de développement sans écraser les autres projets locaux.
3. Vérifier que les services Apache et MySQL démarrent sans erreur et que les versions communes sont sélectionnées.
4. Vérifier les extensions PHP nécessaires et les limites d’upload.
5. Vérifier Git, VS Code et Composer.
6. Placer le projet dans un dossier séparé, par exemple `C:\wamp64\www\SIRH\`, sans remplacer un autre dossier de projet.
7. Configurer Apache pour servir le dossier `public/` comme racine web, idéalement via un Virtual Host local ; à défaut, documenter l’URL sous-dossier utilisée.
8. Créer une base MySQL nommée `sirh` avec encodage `utf8mb4` et collation adaptée, sans modifier ni supprimer les autres bases existantes.
9. Configurer les accès locaux à la base dans un fichier de configuration ignoré par Git.
10. Installer les dépendances Composer à partir de `composer.lock`.
11. Exécuter les migrations SQL dans l’ordre.
12. Charger les données fictives via des seeders.
13. Créer les comptes de démonstration de manière sécurisée.
14. Ouvrir l’application depuis `localhost` et exécuter les tests de démarrage.

L'URL locale de référence peut être `http://localhost/SIRH/public/` ou `http://sirh.local/` selon la configuration Apache. La valeur réelle doit être écrite dans le fichier `.env` local et ne doit pas être supposée identique sur tous les PC.

### Accès réseau local (LAN)

Par défaut, l'application écoute uniquement sur le PC local et s'utilise avec `localhost`. Un accès LAN peut être utilisé pour une démonstration en présentiel uniquement si l'équipe le configure volontairement, limite l'accès aux appareils de confiance et vérifie le pare-feu. Ne jamais faire de port forwarding, ne jamais publier l'adresse IP publique et ne jamais exposer WampServer sur Internet.

## 29. Organisation des fichiers et configuration locale

Organisation de référence :

```text
SIRH/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   ├── Repositories/
│   ├── Middleware/
│   ├── Validators/
│   └── Views/
├── config/
│   ├── app.example.php
│   └── database.example.php
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── assets/
│       ├── css/
│       ├── js/
│       └── images/
├── routes/
│   └── web.php
├── database/
│   ├── schema.sql
│   ├── migrations/
│   └── seeders/
├── storage/
│   ├── uploads/
│   ├── exports/
│   ├── logs/
│   └── backups/
├── tests/
│   ├── unit/
│   ├── integration/
│   └── acceptance/
├── docs/
├── vendor/
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
└── README.md
```

Le dossier `public/` est le seul dossier exposé par Apache. `app/`, `config/`, `database/`, `storage/`, `tests/` et `docs/` ne doivent pas être accessibles directement par HTTP. Si WampServer est configuré avec la racine du projet plutôt que `public/`, ajouter des règles Apache strictes et tester qu'aucun fichier sensible ne peut être téléchargé.

Le stockage des CV, pièces jointes, exports sensibles, journaux et sauvegardes reste hors de `public/`. L'accès aux fichiers passe par un contrôleur PHP qui vérifie la session et la permission avant de servir le fichier.

Le fichier contenant les paramètres locaux (hôte, base, utilisateur, mot de passe, `BASE_URL`) est ignoré par Git. Le dépôt contient uniquement un exemple sans secret. `vendor/`, logs, caches, exports personnels, CV, bases locales et sauvegardes ne sont pas ajoutés au dépôt.

## 30. Base de données et migrations SQL

- Base locale de référence : `sirh`.
- SGBD : MySQL 8.x, version commune aux cinq postes.
- Moteur : InnoDB.
- Charset : `utf8mb4`.
- Accès : PDO MySQL uniquement dans les services/repositories ; pas de requêtes SQL dans les Views.
- Utiliser des clés primaires, clés étrangères, contraintes `UNIQUE`, `NOT NULL` et index justifiés.
- Versionner chaque évolution de schéma dans `database/migrations/`.
- Les migrations doivent être ordonnées, documentées et exécutables sur une base vierge.
- Fournir un `schema.sql` de référence et des seeders fictifs.
- Ne jamais utiliser une copie de base de données personnelle comme méthode de synchronisation entre développeurs.
- Les cinq membres ont chacun leur propre base locale `sirh`; GitHub synchronise le schéma et le code, pas les données de travail.
- Toute modification de table partagée est annoncée dans une Issue, revue par le référent technique, puis ajoutée sous forme de migration.

## 31. Stockage des CV, documents et exports en local

- Stocker les fichiers sous `storage/uploads/` ou dans un répertoire local externe configuré, jamais sous `public/`.
- Générer des noms de fichiers internes non prévisibles ; ne pas utiliser directement le nom fourni par l'utilisateur comme chemin de stockage.
- Vérifier extension autorisée, type MIME réel, taille, nom et erreurs d'upload.
- Refuser les fichiers exécutables ou formats non autorisés.
- Prévoir une taille maximale configurable, en cohérence avec `upload_max_filesize`, `post_max_size`, `memory_limit` et `max_execution_time` de PHP.
- Garder en base les métadonnées : propriétaire, candidat, candidature, nom original affiché, nom interne, type, taille, date et statut.
- Ne jamais servir un CV directement avec un lien public ; passer par un contrôleur avec authentification et permission.
- Séparer les fichiers temporaires et supprimer ceux-ci après traitement.
- Prévoir une sauvegarde locale des documents et une procédure de restauration.

## 32. Sécurité, sauvegardes et collaboration locale

### Sécurité applicative

- Authentification basée sur les sessions PHP sécurisées.
- Cookies `HttpOnly`, `SameSite` et `Secure` lorsque HTTPS local est configuré ; expliquer les paramètres selon l'environnement.
- Régénérer l'identifiant de session après connexion et changement de privilèges.
- Détruire les sessions à la déconnexion et lors de la désactivation/révocation.
- Hacher les mots de passe avec `password_hash()` et vérifier avec `password_verify()` ; ne jamais stocker de mot de passe en clair.
- Protection CSRF sur les formulaires et actions sensibles.
- Échapper les sorties HTML pour réduire les risques XSS.
- PDO et requêtes préparées contre l'injection SQL.
- Validation côté serveur même si une validation JavaScript existe.
- Contrôle RBAC côté serveur pour chaque route, fichier, action et export.
- Limiter les tentatives de connexion et journaliser les événements nécessaires.
- Interdire les messages d'erreur contenant chemins internes, requêtes SQL, mots de passe ou secrets.
- Désactiver l'affichage des erreurs PHP dans l'interface ; écrire les détails techniques dans un log protégé.
- Configurer `.htaccess`/Apache pour interdire l'accès aux dossiers et fichiers sensibles.
- Protéger les opérations de sauvegarde, restauration, export et réinitialisation par permission et confirmation.

### Sauvegardes locales

- Prévoir une sauvegarde SQL de `sirh` et une copie cohérente du dossier de documents.
- Stocker les sauvegardes dans un emplacement local non accessible par HTTP, distinct du dépôt Git.
- Définir fréquence, rétention, nommage et responsable.
- Ne jamais écraser la dernière sauvegarde valide avant d'avoir vérifié la nouvelle.
- Tester la restauration sur une base séparée avant la livraison.
- Documenter la procédure dans `docs/BACKUP_RESTORE.md`.

### Collaboration des cinq membres

- Chaque membre possède une copie du code sur son PC et son propre WampServer/MySQL local.
- GitHub est le référentiel commun du code, des migrations, seeders fictifs, tests et documentation.
- Les branches `main` et `develop` sont protégées autant que possible ; aucun membre ne pousse directement sur `main`.
- Une Issue décrit la tâche, son propriétaire et ses critères d'acceptation.
- Chaque tâche est développée dans une branche `feature/...` ou `fix/...`.
- Les changements sont proposés par Pull Request, revus et testés avant fusion.
- Live Share ou le partage d'écran sert aux sessions de pair programming et au débogage, mais ne remplace jamais Git/GitHub.
- Aucun membre ne partage sa base locale via GitHub. Les évolutions de schéma sont des migrations SQL.
- Ne jamais partager de vrais CV, mots de passe, fichiers `.env`, exports nominatifs ou sauvegardes contenant des données personnelles.

---

# PARTIE VII - MODÈLE DE DONNÉES

## 33. Entités logiques recommandées

Le modèle doit éviter de stocker toutes les informations dans un seul tableau. Un candidat peut répondre à plusieurs offres ; chaque candidature possède son propre statut et son propre score.

Tables logiques du PDF à couvrir :

- `users` : comptes internes.
- `roles`, `permissions`, `user_roles` : droits d'accès.
- `companies`, `departments` : organisation.
- `jobs` : fiches de poste.
- `job_requirements` : critères du poste.
- `candidates` : profil principal du candidat.
- `resumes`, `candidate_documents` : CV et pièces jointes.
- `educations`, `experiences` : formation et parcours.
- `skills`, `candidate_skills` : référentiel de compétences et relations.
- `applications` : candidature d'un candidat à une offre.
- `scoring_templates`, `scoring_criteria` : modèles et critères pondérés.
- `application_scores`, `score_details` : score total et points par critère.
- `pipeline_history` : historique des statuts.
- `interviews`, `interviewers` : rendez-vous et participants.
- `interview_evaluations` : évaluations individuelles.
- `messages`, `notification_templates` : communications.
- `exports`, `saved_report_templates` : historique et profils d'export.
- `audit_logs` : actions sensibles.
- `settings` : paramètres dynamiques.

Tables complémentaires nécessaires selon l'architecture :

- `user_preferences` : préférences personnelles séparées des paramètres globaux.
- `user_invitations` et `sessions` : invitations et sessions.
- `consent_records` et `retention_policies` : information/consentement et conservation.
- `storage_objects` : métadonnées des fichiers stockés.
- `setting_versions` : historique/version des paramètres sensibles.
- `feature_flags` : activation contrôlée des fonctions.
- `demo_runs` ou registre équivalent : exécutions et réinitialisations de démonstration.
- Tables d'intégration IA/e-mail sans stockage de secrets en clair.

## 34. Relations principales

- Un département peut avoir plusieurs offres.
- Une offre peut recevoir plusieurs candidatures.
- Un candidat peut déposer plusieurs candidatures.
- Une candidature appartient à un candidat et à une offre.
- Un candidat peut avoir plusieurs documents, formations, expériences et compétences.
- Une candidature est liée à une version de grille et à un score calculé.
- Une candidature possède plusieurs entrées d'historique de pipeline.
- Une candidature peut avoir plusieurs entretiens.
- Un entretien peut avoir plusieurs participants et plusieurs évaluations individuelles.
- Un utilisateur peut avoir un ou plusieurs rôles selon les règles du projet.

## 35. Contraintes qualité des données

- Identifiants techniques stables et clés étrangères.
- E-mail normalisé, sans fusion automatique des personnes sur le seul nom.
- Dates et horodatages stockés de façon cohérente, affichage selon fuseau choisi.
- Transactions pour les opérations impliquant plusieurs tables.
- Index sur les champs fréquents : offre, statut, date, candidat et e-mail.
- Séparation des données du candidat et des informations propres à une candidature.
- Suppression logique ou archivage lorsqu'il faut préserver la traçabilité, selon la politique configurée.

---

# PARTIE VIII - DONNÉES DE DÉMONSTRATION ET CAS PÉDAGOGIQUE

## 36. Cas Digital Maroc Solutions

Offre de référence : **Chargé(e) de Marketing Digital Junior**.

Générer environ **150 candidatures fictives** pour permettre de tester les volumes, filtres, recherches, rapports et étapes du pipeline.

Les noms, coordonnées, CV, expériences, formations et documents de démonstration doivent être fictifs et ne doivent correspondre à aucune personne réelle identifiable. Prévoir une réinitialisation contrôlée de l'environnement Démonstration.

Inclure obligatoirement les cinq profils de référence : Nadia, Salma, Amine, Youssef et Imane, avec les valeurs exactes du tableau de scoring de la section 18.

## 37. Comptes de test

Prévoir au minimum :

- Un compte Démonstration à droits limités permettant de tester le parcours RH principal sur le PC local.
- Un compte Administrateur permettant de tester l’administration, les rôles et les paramètres.
- Des comptes de test pour Intervieweur, Manager/Observateur et candidat externe afin de démontrer les limites d’accès.

Les comptes sont créés par un seeder ou une procédure locale sécurisée. Les mots de passe initiaux doivent être modifiés lors de la première connexion et ne doivent jamais être codés en dur dans le dépôt Git.

## 38. Scénario de démonstration devant l'enseignant

1. **Présenter le dashboard :** montrer le volume des offres, candidatures et entretiens à partir des données de démonstration. Message : les données RH sont centralisées et mesurables.
2. **Créer une offre :** ouvrir Digital Maroc Solutions et définir la fiche de poste et ses critères. Message : le recrutement commence avec des critères explicites.
3. **Ajouter les cinq candidats :** afficher formation, expérience, compétences et outils. Message : les informations structurées facilitent l'analyse.
4. **Lancer le scoring :** afficher le détail de chaque critère et les scores calculés. Message : le classement est reproductible et explicable.
5. **Traiter l'égalité :** montrer Amine et Youssef à 70, puis appliquer uniquement la règle de départage préalablement validée. Message : un score seul ne règle pas toutes les décisions.
6. **Préparer les entretiens :** planifier des entretiens de la shortlist et compléter une grille d'évaluation. Message : le workflow continue au-delà du CV.
7. **Montrer un biais :** simuler un synonyme inconnu ou une langue non documentée et expliquer la revue humaine. Message : l'ATS peut être mal configuré ; le contrôle humain reste essentiel.
8. **Exporter :** produire un PDF de shortlist et un Excel détaillé avec filtres. Message : les résultats sont partageables et auditables.
9. **Montrer les rôles :** se connecter comme intervieweur ou candidat sur l’instance WampServer locale pour démontrer les limites d’accès. Message : la confidentialité fait partie de la digitalisation RH.
10. **Conclusion :** résumer gain de temps, traçabilité, limites et prochaines améliorations. Message : le logiciel assiste le professionnel RH sans décider seul.

## 39. Questions pédagogiques et réponses attendues

**Pourquoi Nadia obtient-elle le meilleur score ?**  
Formation liée (20), expérience (20), toutes les compétences clés (40), Canva et CRM (10), soit 90/100. Le français n'est pas documenté et vaut 0 selon la règle pédagogique.

**Amine a moins d'expérience mais possède toutes les compétences clés : faut-il le privilégier ?**  
Il obtient 70/100, ex aequo avec Youssef. Il peut être préféré si une règle de départage priorisant les compétences clés a été définie avant le scoring. La décision doit être justifiée et humaine.

**Un candidat compétent peut-il être défavorisé par un ATS mal configuré ?**  
Oui. Synonymes non reconnus, données manquantes, poids inadaptés ou extraction imparfaite peuvent entraîner un score incorrect.

**Le logiciel peut-il rejeter seul une candidature ?**  
Non. Il peut signaler les critères, proposer une shortlist et aider au tri, mais un humain examine les exceptions et valide les décisions.

**Quel est le rôle du Responsable RH ?**  
Définir des critères pertinents, vérifier les données, contrôler les biais, expliquer les choix, décider et garder une trace professionnelle des décisions.

---

# PARTIE IX - CONFIDENTIALITÉ, CONFORMITÉ ET ÉQUITÉ

## 40. Données personnelles

Le projet doit prendre en compte la loi marocaine 09-08 et les exigences applicables de la CNDP : information des personnes, finalités déterminées, proportionnalité, qualité des données, durée de conservation, sécurité, gestion des accès et formalités applicables.

Avant tout usage de vrais CV :

- Faire confirmer par le responsable compétent les formalités CNDP applicables.
- L’application étant locale et sans hébergement Cloud, les données de démonstration restent sur le PC WampServer. Si un fournisseur IA ou e-mail externe est activé ultérieurement, examiner les lieux de traitement et les éventuels transferts de données à l’étranger.
- Vérifier les garanties, contrats, autorisations ou conditions de transfert qui s’appliquent avant toute activation d’un service externe.
- Définir la durée de conservation et le processus de suppression.
- Informer les candidats sur les finalités et les destinataires.
- Limiter les accès aux personnes qui en ont besoin.

Pour la démonstration académique, utiliser uniquement des données fictives. Ne pas conclure que le simple fait d'ajouter une case « consentement » rend automatiquement l'application conforme.

## 41. Limites algorithmiques

- Le score est une aide au tri, pas une prédiction certaine.
- L'IA doit expliquer les données utilisées et les limites.
- Les candidats doivent pouvoir être revus par un humain.
- Ne pas utiliser photo, genre, origine, âge, handicap, émotions ou caractéristiques sensibles comme critères de présélection.
- Ne pas reproduire mécaniquement les décisions historiques sans vérifier les biais.
- Ne jamais masquer les champs manquants.

---

# PARTIE X - TESTS ET ACCEPTATION

## 42. Tests d'acceptation T-01 à T-20 du cahier des charges

| ID | Test | Résultat attendu |
|---|---|---|
| T-01 | Connexion avec un compte valide | Accès au dashboard autorisé selon le rôle. |
| T-02 | Un candidat ouvre une page RH par URL directe | Accès refusé côté serveur. |
| T-03 | Créer une offre avec champs obligatoires manquants | Erreur claire ; aucune publication incohérente. |
| T-04 | Publier puis clôturer une offre | États corrects et historique conservé. |
| T-05 | Déposer un CV autorisé | Fichier enregistré de manière protégée et rattaché au candidat. |
| T-06 | Déposer un fichier interdit ou trop volumineux | Rejet avec message compréhensible. |
| T-07 | Créer deux profils avec le même e-mail | Alerte de doublon ; aucune fusion automatique. |
| T-08 | Calculer le scoring de l'étude de cas | Nadia 90 ; Salma 85 ; Amine 70 ; Youssef 70 ; Imane 35. |
| T-09 | Modifier un poids de scoring | Validation de la somme des poids et version de grille distincte. |
| T-10 | Scoring avec français non documenté | Le cas pédagogique donne 0 ; l'interface signale « non documenté ». |
| T-11 | Départager Amine et Youssef | La règle préétablie est affichée ; priorité aux compétences clés si cette règle est retenue. |
| T-12 | Déplacer une carte Kanban sans droit | Action refusée ; statut inchangé. |
| T-13 | Créer un entretien en conflit d'horaire | Alerte et possibilité de choisir un autre créneau. |
| T-14 | Exporter un rapport PDF avec filtres | Le fichier contient les colonnes sélectionnées et affiche les filtres utilisés. |
| T-15 | Exporter en XLSX avec un texte commençant par = | La valeur est traitée comme texte non exécutable. |
| T-16 | Modifier une permission | Changement réservé à un administrateur autorisé et enregistré dans l'audit. |
| T-17 | Supprimer/archiver un candidat | La politique de conservation est appliquée ; action autorisée et tracée. |
| T-18 | Générer des statistiques sur une période vide | Affichage zéro/aucune donnée, sans erreur serveur. |
| T-19 | Afficher le français avec accents | Aucun caractère manquant ou remplacé par des carrés. |
| T-20 | Activer l'arabe/RTL si prévu | Alignement, tableaux, police et exports vérifiés avant livraison. |

## 43. Tests complémentaires de l'Administration et du déploiement

- T-21 : un recruteur ne peut pas ouvrir l'administration par URL directe.
- T-22 : une modification de rôle prend effet côté serveur et est inscrite dans l'audit.
- T-23 : un utilisateur ne peut pas lire ou modifier les préférences d'un autre utilisateur.
- T-24 : une modification de scoring crée une nouvelle version et ne réécrit pas l'historique.
- T-25 : la réinitialisation Démonstration ne touche jamais la production.
- T-26 : un CV privé n'est pas accessible avec une URL non autorisée.
- T-27 : l'état « envoyé » n'est pas affiché si le fournisseur e-mail échoue ou n'est pas configuré.
- T-28 : une sauvegarde peut être restaurée dans un environnement de test.
- T-29 : l’application démarre correctement sur WampServer via `localhost`, sans dépendre d’un hébergement Internet.
- T-30 : les comptes Démonstration et Administrateur disposent de permissions différentes.
- T-31 : l’application continue de fonctionner pour les fonctions cœur lorsque l’accès Internet est absent ; les services externes facultatifs sont signalés comme indisponibles.
- T-32 : toutes les pages principales sont utilisables sur ordinateur et mobile.
- T-33 : le script SQL et les migrations installent une base vierge sur chacun des cinq PC.
- T-34 : une sauvegarde locale de MySQL et des documents peut être restaurée sur une installation de test.
- T-35 : aucun fichier de `config/`, `database/`, `storage/` ou `vendor/` n’est directement téléchargeable via Apache.

## 44. Conditions d'acceptation du MVP

- Toutes les pages MVP du menu sont reliées à des données réelles ou indiquent clairement leur mode Simulation.
- Aucune action critique n'est uniquement décorative : créer, modifier, filtrer, déplacer et exporter produit un résultat vérifiable.
- Les scores sont reproductibles à partir de la grille versionnée.
- La shortlist et les décisions conservent l'auteur, la date et le motif lorsque nécessaire.
- Le fonctionnement est stable avec un jeu de données fictif, sans utiliser de vrais CV.
- Les pages principales sont lisibles sur ordinateur et utilisables sur mobile.
- Les accès sont vérifiés côté serveur.
- Les sauvegardes et la procédure de restauration sont documentées et testées.
- L’URL locale WampServer a été testée sur le PC de démonstration et l’installation a été reproduite sur au moins un autre PC de l’équipe.

---

# PARTIE XI - PLAN DE RÉALISATION

## 45. Principe de développement

Construire une tranche fonctionnelle complète à chaque étape, plutôt que beaucoup de pages vides. Exemple : une offre doit pouvoir être créée, publiée, recevoir une candidature, passer par le scoring, être exportée et suivie jusqu'à une décision avant d'ajouter des fonctions IA avancées.

## 46. Phases de travail

### Phase 0 - Cadrage et analyse

Travaux : valider le périmètre ATS du SIRH, les rôles, le workflow, la grille, le cas d'étude, les contraintes de cours, la stack PHP/MySQL/WampServer et les cinq environnements de développement.

Livrables :
- Cahier des charges fonctionnel consolidé.
- Matrice de permissions.
- Diagramme de données et dictionnaire des données.
- Architecture PHP MVC et sitemap.
- Plan des migrations SQL.
- Liste des versions et extensions communes WampServer/PHP/MySQL.
- Maquettes des pages principales.
- Registre des décisions, risques et divergences.
- Plan de collaboration GitHub pour les cinq membres.

Décisions à confirmer :
- Version exacte commune de PHP et MySQL sur les cinq PC.
- Règle de départage Amine/Youssef.
- Portail candidat local sans compte ou portail authentifié en extension.
- Parsing CV inclus dans le MVP ou en Bonus.
- Entretien vidéo différé simulé ou réel.
- Moteur IA local disponible et éventuelle API externe facultative.
- Langues additionnelles.
- Durée de conservation et règles de suppression.
- Accès localhost uniquement ou démonstration LAN ponctuelle contrôlée.

### Phase 1 - Socle local PHP/MySQL

- Vérification WampServer sur les cinq PC.
- Création du dépôt Git privé et des branches.
- Création du projet PHP MVC personnalisé.
- Configuration Apache, `BASE_URL` et routage.
- Connexion PDO à MySQL.
- Création de la base `sirh`, `schema.sql` et première migration.
- Configuration des erreurs et journaux.
- Mise en place Bootstrap 5 et du layout principal.

Livrable : page d'accueil locale, connexion MySQL fonctionnelle et démarrage reproductible sur les cinq PC.

### Phase 2 - Authentification, rôles et Administration de base

- Login/logout et sessions.
- Gestion des comptes, rôles et permissions.
- Contrôles d'accès côté serveur.
- Structure du centre Administration.
- Paramètres globaux et préférences personnelles.
- Audit des opérations sensibles.

Livrable : utilisateurs de test avec accès effectivement différenciés.

### Phase 3 - Offres et portail candidat local

- CRUD des offres.
- Modèles, validation et publication locale.
- Liste locale des offres et détail.
- Formulaire de candidature local.
- Référentiels de départements, villes et contrats.

Livrable : créer une offre et recevoir une candidature sur localhost.

### Phase 4 - Candidats, documents et candidatures

- Fiches candidats.
- Formation, expériences, compétences et langues.
- Upload CV et documents en stockage local privé.
- Détection des doublons.
- Recherche, filtres, pagination et favoris.
- Liaison candidat/offre et historique de candidature.

Livrable : consulter et suivre les dossiers et candidatures avec droits corrects.

### Phase 5 - Scoring, présélection et IA

- Modèles de scoring et versions.
- Critères configurables et poids.
- Synonymes contrôlés.
- Données manquantes et score détaillé.
- Shortlist et comparateur.
- Matching explicable local.
- CV Parsing avancé et assistant IA en Bonus selon faisabilité.

Livrable : reproduction correcte du barème pédagogique et justification de chaque score.

### Phase 6 - Pipeline et entretiens

- Kanban et transitions autorisées.
- Historique des statuts.
- Commentaires, affectations et notes.
- Planification d'entretiens.
- Participants et détection des conflits.
- Évaluations individuelles.
- Simulation vidéo différée.

Livrable : une candidature passe du dépôt à l'entretien avec un historique complet.

### Phase 7 - Communications et notifications

- Templates d'accusé de réception, invitation, rappel, refus et offre.
- Prévisualisation et simulation locale par défaut.
- SMTP facultatif si explicitement configuré.
- Notifications internes et journal de communication.

Livrable : communication traçable sans fausse confirmation d'envoi.

### Phase 8 - Dashboard, reporting, exports et durcissement

- KPI calculés depuis MySQL.
- Rapports filtrables.
- Export PDF/XLSX/CSV.
- Options d'export et modèles.
- Tests de sécurité, validation, confidentialité, sauvegarde et restauration.
- Administration avancée et configuration finale.

Livrable : rapport PDF/Excel cohérent, tests réussis et sauvegarde restaurée en environnement de test.

### Phase 9 - Validation locale et remise à l'enseignant

- Initialiser les 150 candidatures fictives et les cinq profils de référence.
- Créer les comptes Démonstration, Administrateur et autres comptes de test.
- Exécuter T-01 à T-35.
- Vérifier WampServer sur le PC de démonstration.
- Reproduire l'installation sur un deuxième PC de l'équipe.
- Préparer le paquet de livraison : code, SQL, migrations, seeders, `composer.lock` et documentation.
- Préparer le guide d'installation locale et le scénario de démonstration.
- Vérifier la procédure de backup/restore.

Livrable : application SIRH locale opérationnelle, installable sur un PC Windows équipé de WampServer, sans URL publique ni hébergement Internet.
---

# PARTIE XII - EXIGENCES UX, ACCESSIBILITÉ ET QUALITÉ

## 47. Expérience utilisateur

- Design cohérent : même emplacement pour recherche, filtres, actions principales et messages.
- Formulaires avec étiquettes explicites, champs obligatoires et erreurs localisées.
- États visibles : chargement, aucun résultat, erreur, succès et opération en attente.
- Confirmation avant suppression, clôture d'offre ou action difficile à annuler.
- Couleurs de statut accompagnées d'un libellé texte.
- Navigation clavier et contraste suffisants.
- Responsive de base.
- Français comme langue initiale ; autres langues seulement si réellement testées.

## 48. Direction visuelle

Créer une interface professionnelle de gestion RH locale :

- Sidebar claire et organisée.
- Barre supérieure avec compte, notifications et préférences.
- Dashboard avec KPI et graphiques lisibles.
- Tables filtrables et paginées.
- Kanban et calendrier réellement interactifs.
- Pages de détail avec sections cohérentes.
- Formulaires accessibles et messages explicites.
- Pas d'animations inutiles ni de widgets décoratifs sans fonction.

L'application doit rester agréable sur écran d'ordinateur, tablette et téléphone.

---

# PARTIE XIII - LIVRABLES ATTENDUS

## 49. Livrables techniques et utilisateur

Le dépôt final doit contenir au minimum :

- Application web frontend et backend.
- Base de données et migrations versionnées.
- Stockage sécurisé des documents si l'option est activée.
- Authentification et rôles.
- Modules MVP opérationnels.
- Centre Administration et préférences personnelles.
- Scoring explicable et versionné.
- Données fictives de démonstration (150 candidatures et 5 profils de référence).
- Tests automatisés et rapport de résultats.
- Documentation architecture.
- Documentation base de données.
- Guide d'installation locale.
- Guide d’installation WampServer sur Windows.
- Guide utilisateur.
- Guide administrateur.
- Scripts SQL et migrations.
- Seeders de données fictives.
- Procédure de sauvegarde/restauration locale.
- Paquet de livraison locale et procédure de transfert vers un autre PC.
- Guide du scénario de démonstration à l’enseignant.
- Registre des limites, décisions à confirmer et fonctionnalités Bonus.

## 50. Fichiers de documentation à créer

- `README.md` : présentation, démarrage et liens.
- `docs/CAHIER_DES_CHARGES.md` : exigences fonctionnelles.
- `docs/ARCHITECTURE.md` : couches, composants et flux.
- `docs/DATABASE.md` : tables, relations et migrations.
- `docs/PERMISSIONS.md` : rôles et matrice d'accès.
- `docs/ADMINISTRATION.md` : réglages globaux et préférences utilisateur.
- `docs/SCORING.md` : critères, règles, versions et cas de test.
- `docs/SECURITY_PRIVACY.md` : sécurité et données personnelles.
- `docs/INSTALLATION_WAMP.md` : installation et configuration locale WampServer.
- `docs/ENVIRONMENT.md` : versions PHP/MySQL/Apache et extensions communes.
- `docs/GIT_WORKFLOW.md` : branches, Issues, Pull Requests et règles d’équipe.
- `docs/BACKUP_RESTORE.md` : sauvegarde et restauration locales.
- `docs/DEMO_PROFESSEUR.md` : scénario de démonstration locale.
- `docs/DECISIONS.md` : décisions, ambiguïtés et validations.

---

# PARTIE XIV - RÈGLES FINALES POUR L'AGENT IA

## 51. Méthode de travail

1. Lire ce MASTER PROMPT en entier avant toute intervention.
2. Examiner les fichiers, le dépôt Git et l'environnement WampServer existants avant toute modification.
3. Comparer les exigences au code déjà présent ; ne pas supposer l'état du projet.
4. Établir la Phase 0 et identifier les contradictions ou informations manquantes.
5. Respecter la stack locale : PHP 8.2+ en MVC personnalisé, MySQL 8.x, Apache/WampServer, Bootstrap 5 et JavaScript natif.
6. Ne pas ajouter Laravel, Symfony, React, Vue, Node.js, Cloudflare, D1, R2 ou hébergement public sans demande et validation explicites.
7. Documenter la règle de départage active pour Amine et Youssef avant d'exécuter le scoring.
8. Définir les migrations SQL et critères d'acceptation avant le développement de chaque module.
9. Développer une fonctionnalité de bout en bout à la fois : interface, contrôleur, service, modèle/repository, base, validation, sécurité et test.
10. Garder la logique métier hors des vues et les requêtes SQL hors des templates.
11. Utiliser PDO préparé, transactions, InnoDB et `utf8mb4`.
12. Tester localement sous WampServer après chaque changement important.
13. Mettre à jour la documentation et le registre de décisions.
14. Ne pas passer à la phase suivante tant que les critères de la phase courante ne sont pas atteints, sauf dérogation documentée.
15. Ne jamais inventer l'existence d'une fonction, d'une API, d'un envoi d'e-mail, d'un moteur IA ou d'un test.
16. Ne jamais exposer WampServer à Internet. Un test LAN doit être temporaire, contrôlé et explicitement demandé.
17. Utiliser exclusivement des données fictives dans les tests et dans GitHub.
18. Toute modification de schéma passe par une migration SQL versionnée et une revue.
19. Toute fusion de code passe par une Pull Request et des tests.
20. Signaler les limitations et proposer une solution de remplacement locale avant toute dépendance externe.

## 52. Format du rapport de fin de phase

À la fin de chaque phase, produire :

- Objectif de la phase.
- Éléments livrés.
- Fichiers créés/modifiés.
- Migrations SQL ajoutées.
- Tests exécutés et résultats réels.
- Captures locales si elles existent.
- Défauts connus.
- Risques et limites.
- Compatibilité vérifiée sur les versions PHP/MySQL/Apache retenues.
- Décisions nécessaires.
- Critère autorisant le passage à la phase suivante.

## 53. Instruction initiale à exécuter maintenant

**Commence par la Phase 0 - Cadrage et analyse uniquement.**

Tu dois :

1. Résumer les exigences du cahier des charges et de ce MASTER PROMPT sans en perdre.
2. Confirmer que le périmètre du produit est l'application **SIRH**, centrée sur le recrutement/ATS, et non un SIRH général avec paie ou congés.
3. Comparer les 10 fonctions obligatoires du MVP aux pages et modules prévus.
4. Produire le sitemap complet.
5. Produire la matrice de permissions détaillée.
6. Concevoir le modèle relationnel MySQL, les relations et le dictionnaire des données.
7. Décrire le centre Administration et les préférences personnelles.
8. Formaliser le moteur de scoring, les données manquantes et la divergence de départage Amine/Youssef.
9. Vérifier les versions exactes de PHP, MySQL, Apache et extensions PHP disponibles sur les cinq PC WampServer.
10. Proposer une structure PHP MVC personnalisée et les règles de routage/BASE_URL.
11. Définir le plan des migrations SQL et des seeders.
12. Définir la stratégie de stockage local protégé des CV et documents.
13. Définir les fonctions IA locales réellement faisables et distinguer matching déterministe, NLP et LLM éventuel.
14. Définir les rôles, contrôles d'accès, sécurité, confidentialité et audit.
15. Définir les sauvegardes locales et la restauration testée.
16. Préparer le workflow GitHub pour cinq membres avec des responsabilités, sans que plusieurs personnes modifient simultanément les mêmes fichiers.
17. Définir les critères d'acceptation par module et les tests T-01 à T-35.
18. Préparer les phases de réalisation et leurs dépendances.
19. Lister uniquement les décisions qui nécessitent réellement la validation de l'utilisateur ou de l'enseignant.

Présente le rapport de cadrage et attends la validation avant de commencer la Phase 1. Ne crée pas encore les modules applicatifs complets et ne génère pas de gros fichiers de code pendant la Phase 0.

**PRIORITÉ ABSOLUE : construire une application SIRH locale réellement fonctionnelle sur WampServer, dans le périmètre recrutement/ATS, avec PHP MVC et MySQL, tous les modules essentiels, un centre Administration complet, des préférences personnelles, un scoring explicable, une sécurité vérifiable, des sauvegardes locales et une installation reproductible sur les PC de l’équipe. Aucun hébergement Internet ni publication publique n’est requis.**
---

# ANNEXE A - RÉFÉRENCES TECHNIQUES ET DOCUMENTATION

Les références suivantes servent à vérifier les fonctions et la compatibilité des technologies retenues. L’agent doit consulter la documentation correspondant aux versions réellement installées, sans mettre à jour les environnements de force.

- PHP Manual : https://www.php.net/manual/fr/
- PHP PDO : https://www.php.net/manual/fr/book.pdo.php
- PHP Password Hashing : https://www.php.net/manual/fr/book.password.php
- MySQL Reference Manual : https://dev.mysql.com/doc/refman/8.4/en/
- Apache HTTP Server Documentation : https://httpd.apache.org/docs/2.4/
- WampServer : https://www.wampserver.com/
- Bootstrap 5 Documentation : https://getbootstrap.com/docs/5.3/
- Composer Documentation : https://getcomposer.org/doc/
- PhpSpreadsheet Documentation : https://phpspreadsheet.readthedocs.io/
- Dompdf Documentation : https://github.com/dompdf/dompdf
- mPDF Documentation : https://mpdf.github.io/
- Git Documentation : https://git-scm.com/doc
- GitHub Pull Requests : https://docs.github.com/pull-requests

Aucun lien de déploiement Cloud ou d’hébergement public ne fait partie du périmètre.

## Références de protection des données au Maroc

- Loi n° 09-08 - texte officiel : https://bdj.mmsp.gov.ma/Fr/Document/8974-Loi-n-09-08-promulgu%C3%A9e-par-le-dahir-n-1-09-15-du.aspx
- CNDP - notifier un traitement : https://www.cndp.ma/notifier-un-traitement/
- CNDP - transfert de données à l'étranger : https://www.cndp.ma/transfert-de-donnees-a-letranger/
- CNDP - textes et lois : https://www.cndp.ma/textes-et-lois/

---

# ANNEXE B - ORGANISATION DU DÉVELOPPEMENT EN ÉQUIPE (5 MEMBRES)

Cette annexe organise le travail humain de l'équipe. Elle ne remplace pas les responsabilités fonctionnelles des rôles utilisateurs dans l'application.

## B.1 Principes de collaboration

- Un seul dépôt GitHub privé pour le code du projet.
- Chaque membre possède une copie locale du projet et sa propre base MySQL `sirh`.
- Le code, les migrations, les seeders fictifs, les tests et la documentation sont partagés ; les bases locales et documents réels ne le sont pas.
- `main` contient les versions stables ; `develop` sert à l'intégration ; chaque fonctionnalité possède sa branche.
- Les changements sont soumis par Pull Request et revus avant fusion.
- Live Share ou Google Meet sert au pair programming et au débogage, pas au remplacement de Git.
- Une seule personne est propriétaire d'une migration à la fois ; toute modification de table partagée est annoncée et revue.
- Les tâches sont suivies dans GitHub Issues/Projects avec un responsable, une description, des critères d'acceptation et un statut.

## B.2 Répartition recommandée selon les niveaux communiqués

| Membre | Niveau | Responsabilité principale | Contributions |
|---|---|---|---|
| Membre 1 | Débutant | Coordination, documentation et assurance qualité | Plan de tests, cas d'acceptation, données fictives, guide utilisateur, rapports de bugs, tests de préférences personnelles et petites corrections UI supervisées. |
| Membre 2 | Débutant | Interface utilisateur et intégration frontend | Layout, navigation, Dashboard UI, formulaires, pages des offres et candidats, Bootstrap 5, responsive, raccordement des vues aux routes préparées avec le référent backend. |
| Membre 3 | Intermédiaire | Référent technique, PHP MVC, MySQL et Administration | Architecture, routing, PDO, schéma SQL, migrations communes, authentification, rôles, permissions, Administration, paramètres globaux, sécurité et intégration. |
| Membre 4 | Intermédiaire | Candidats, candidatures, CV et scoring/IA | Fiches candidats, documents, applications, recherche, parsing, extraction de compétences, matching, scoring, shortlist et tests des cinq profils. |
| Membre 5 | Intermédiaire | Workflow, entretiens, communication et reporting | Kanban, transitions, historique, entretiens, évaluations, notifications, templates, journaux de communication, rapports et exports. |

Membre 1 n'est pas limité à un rôle de secrétariat : il possède la responsabilité des tests et de la documentation vérifiables. Membre 2 développe réellement les interfaces, avec revue et accompagnement technique. Les membres 3, 4 et 5 portent les modules backend/métier principaux. Chaque module doit toutefois être revu par au moins une autre personne.

## B.3 Dépendances et binômes

- Membre 2 + Membre 3 : contrats de vues, routes PHP, formulaires et endpoints AJAX.
- Membre 3 + Membre 4 : tables candidats/candidatures, documents et scoring.
- Membre 3 + Membre 5 : transitions du pipeline, entretiens et notifications.
- Membre 1 + tous : critères d'acceptation, tests de régression, documentation et scénario de démonstration.
- Membre 4 + Membre 5 : passage de la shortlist vers les entretiens et conservation de la décision humaine.

## B.4 Règle de fin de tâche

Une tâche n'est considérée comme terminée que lorsque :

1. son code est dans une branche dédiée ;
2. le test local WampServer est passé ;
3. les migrations éventuelles sont incluses ;
4. les critères d'acceptation sont vérifiés ;
5. la documentation est mise à jour ;
6. la Pull Request a été revue et fusionnée dans `develop`.

---

# ANNEXE B - GLOSSAIRE

| Terme | Définition |
|---|---|
| ATS | Applicant Tracking System : module de suivi des candidatures intégré au SIRH de ce projet. |
| e-GRH | Gestion des ressources humaines soutenue par les technologies numériques. |
| SIRH | Système d’information des ressources humaines ; dans ce projet, le périmètre fonctionnel initial est centré sur le recrutement (ATS). |
| Candidature / Application | Lien entre une personne candidate et une offre précise. |
| CV parsing | Extraction de texte et d'informations depuis un CV. |
| Scoring | Calcul structuré d'un score à partir de critères et de poids définis. |
| Shortlist | Liste de candidats retenus pour l'étape suivante, généralement un entretien. |
| Kanban | Vue en colonnes représentant les étapes d'un processus. |
| KPI | Indicateur clé utilisé pour suivre une activité ou un résultat. |
| Audit log | Historique horodaté des actions importantes dans le système. |
| RBAC | Contrôle d’accès basé sur les rôles. |
| WampServer | Environnement local Windows réunissant notamment Apache, PHP et MySQL. |
| MVC | Séparation entre Modèles, Vues et Contrôleurs. |
| Migration SQL | Script versionné permettant de faire évoluer le schéma de base de données de manière reproductible. |
| Donnée manquante | Information non disponible ; ce n'est pas nécessairement une réponse négative. |
| Préférence utilisateur | Paramètre personnel d'affichage ou d'utilisation, sans effet sur les permissions. |
| Paramètre global | Configuration de l'organisation ou du système, administrée par un rôle habilité. |
