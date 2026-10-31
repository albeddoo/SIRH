# PHASE 00 — CADRAGE ET ANALYSE

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Analyser le besoin, confirmer les limites du produit, relever les ambiguïtés, définir les contrats de travail et préparer une architecture vérifiable. Aucun développement applicatif complet ne doit commencer durant cette phase.

## Tâches à réaliser dans l’ordre

1. Lire les exigences et établir une matrice de traçabilité (exigence → module → rôle → données → test).

2. Confirmer le périmètre SIRH centré ATS, les fonctions MVP, les Bonus et les éléments hors périmètre.

3. Lister les utilisateurs, rôles, permissions et parcours de candidature.

4. Examiner les cinq postes de développement : versions WampServer, Apache, PHP, MySQL/MariaDB, extensions PHP et Composer. Ne pas imposer de mise à niveau sans diagnostic.

5. Proposer sitemap, architecture MVC, conventions de code, structure des répertoires et contrats API/AJAX.

6. Proposer le modèle relationnel, dictionnaire de données, migrations et stratégie de stockage local privé.

7. Analyser les fonctions IA réellement faisables localement et séparer règles déterministes, NLP et LLM optionnel.

8. Documenter les risques, dépendances, règles de sécurité, sauvegardes, tests et workflow GitHub de l’équipe.

9. Présenter les décisions à confirmer, notamment la règle de départage Amine/Youssef, le parsing CV MVP/Bonus, la vidéo différée et le mode d’accès LAN.

## Références fonctionnelles et techniques à respecter

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


## 45. Principe de développement

Construire une tranche fonctionnelle complète à chaque étape, plutôt que beaucoup de pages vides. Exemple : une offre doit pouvoir être créée, publiée, recevoir une candidature, passer par le scoring, être exportée et suivie jusqu'à une décision avant d'ajouter des fonctions IA avancées.


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


## Extrait du plan de réalisation d’origine

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


## Livrables obligatoires

- [ ] Rapport de cadrage
- [ ] Matrice exigences/modules/tests
- [ ] Sitemap et parcours
- [ ] Matrice de rôles et permissions proposée
- [ ] Architecture PHP MVC
- [ ] Modèle de données conceptuel et dictionnaire
- [ ] Plan des migrations
- [ ] Diagnostic des cinq environnements WampServer
- [ ] Registre des risques et décisions
- [ ] Plan de collaboration GitHub

## Critère de sortie et règle d’arrêt

L’utilisateur valide le périmètre, la stack compatible des cinq PC, les rôles, le modèle de données conceptuel et les décisions bloquantes. Ne pas commencer Phase 1 avant validation.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_00.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Livrables détaillés attendus pour la Phase 00
- `docs/ANALYSE/INVENTAIRE_EXISTANT.md` : fichiers, modules, branches, commits récents, état Git et éléments déjà fonctionnels.
- `docs/QUALITE/CHECKLIST_INSTALLATION_CINQ_POSTES.md` : tableau à remplir pour chaque PC : Windows, WampServer, Apache, PHP, MySQL/MariaDB, extensions PHP, Composer, VS Code, Qwen.
- `docs/ARCHITECTURE.md` : schéma des couches et conventions MVC.
- `docs/DATABASE.md` : ERD textuel, tables, clés et contraintes proposées.
- `docs/API_CONTRACTS.md` : contrats internes AJAX/JSON ou routes classiques.
- `docs/PERMISSIONS.md` : matrice RBAC et périmètres d'accès.
- `docs/TRACEABILITE_EXIGENCES.md` : chaque MVP, exigence métier, module, rôle, table, écran et test.
- `docs/DECISIONS.md` : arbitrages et questions encore ouvertes.
- `docs/PLAN_IMPLEMENTATION.md` : ordre des dépendances et critères de sortie par phase.

### Audit du dépôt existant — cas obligatoire
Si le repository est déjà relié à GitHub et que Qwen a commencé à coder :
- ne pas supprimer ni recommencer ;
- inventorier les commits, branches, fichiers modifiés, fichiers non suivis et éventuelles migrations ;
- identifier ce qui est réutilisable, incomplet, incohérent ou dangereux ;
- relever les changements non commités et ne pas les écraser ;
- fournir un plan de reprise conservant le code utile.

### Interdictions de la Phase 00
Aucun module applicatif, aucune migration exécutée, aucune installation WAMP, aucune réécriture et aucun push. Les seuls fichiers éventuellement créés sont les livrables d'analyse ci-dessus, après signaler le plan.

### Questions à présenter avant Phase 01
- versions exactes des cinq environnements ;
- MySQL ou MariaDB réellement retenu et compatibilité de WampServer ;
- extensions PHP disponibles ;
- disponibilité de Composer ;
- règle de départage Amine/Youssef validée ;
- mode de fonctionnement local hors Internet ;
- périmètre IA local ;
- fonctions Bonus qui peuvent être reportées.


## Prompt exécutable — Phase 00

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_00_ANALYSE_ET_CADRAGE.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 00 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
