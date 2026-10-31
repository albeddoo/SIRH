# PHASE 09 — TESTS FINAUX, VALIDATION LOCALE ET REMISE

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Valider l’application locale de bout en bout, préparer le jeu de démonstration, tester les exigences métier et sécurité, reproduire l’installation sur un autre PC et remettre un paquet complet à l’enseignant.

## Tâches à réaliser dans l’ordre

1. Créer les données fictives de Digital Maroc Solutions, les 150 candidatures et les cinq profils de référence.

2. Créer les comptes de test sans mots de passe codés en dur dans le dépôt.

3. Exécuter T-01 à T-20 ainsi que les tests complémentaires définis dans la référence.

4. Exécuter les tests de sécurité, rôles, documents, scoring, exports, sauvegarde et restauration.

5. Vérifier WampServer sur le PC de démonstration et reproduire l’installation sur un deuxième PC.

6. Préparer le scénario de démonstration et les réponses pédagogiques.

7. Préparer code, SQL, migrations, seeders, composer.lock, guides et registre des limites.

8. Confirmer qu’aucune URL publique ou dépendance d’hébergement Internet n’est requise.

## Références fonctionnelles et techniques à respecter

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


## Extrait du plan de réalisation d’origine

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


## Références de protection des données au Maroc

## Références de protection des données au Maroc

- Loi n° 09-08 - texte officiel : https://bdj.mmsp.gov.ma/Fr/Document/8974-Loi-n-09-08-promulgu%C3%A9e-par-le-dahir-n-1-09-15-du.aspx
- CNDP - notifier un traitement : https://www.cndp.ma/notifier-un-traitement/
- CNDP - transfert de données à l'étranger : https://www.cndp.ma/transfert-de-donnees-a-letranger/
- CNDP - textes et lois : https://www.cndp.ma/textes-et-lois/

---

## Livrables obligatoires

- [ ] Rapport de tests
- [ ] Données fictives complètes
- [ ] Application locale validée
- [ ] Installation reproduite sur un second PC
- [ ] Guide utilisateur et administrateur
- [ ] Guide WampServer
- [ ] Scénario professeur
- [ ] Paquet final et backup/restore vérifié

## Critère de sortie et règle d’arrêt

Tous les critères d’acceptation MVP sont satisfaits ou les exceptions sont explicitement documentées. Le projet démarre localement sur WampServer et peut être réinstallé depuis le paquet de livraison.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_09.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Validation finale détaillée

### Données fictives
Entreprise Digital Maroc Solutions ; offre Chargé(e) de Marketing Digital Junior ; 150 candidatures fictives variées ; 5 profils Nadia, Salma, Amine, Youssef, Imane avec scores de référence. Comptes Admin et Démonstration distincts. Ne jamais inclure de données personnelles réelles dans GitHub.

### Tests T-01 à T-35
| ID | Test | Résultat attendu |
|---|---|---|
| T-01 | Login valide | Dashboard selon rôle |
| T-02 | Candidat ouvre URL RH directe | Refus serveur |
| T-03 | Offre sans champs requis | Erreur, pas de publication |
| T-04 | Publier puis clôturer offre | États/historique corrects |
| T-05 | CV autorisé | Stockage privé et lien candidat correct |
| T-06 | Fichier interdit/trop volumineux | Rejet clair |
| T-07 | Email candidat dupliqué | Alerte, pas de fusion auto |
| T-08 | Scoring profils de référence | Nadia 90, Salma 85, Amine 70, Youssef 70, Imane 35 |
| T-09 | Modifier poids | Somme cohérente et nouvelle version |
| T-10 | Français non documenté | 0 dans cas pédagogique, état visible |
| T-11 | Départage | Règle préétablie affichée ; égalité si non validée |
| T-12 | Kanban sans permission | Refus et statut inchangé |
| T-13 | Entretien en conflit | Alerte |
| T-14 | PDF filtré | Colonnes et filtres corrects |
| T-15 | XLSX texte commençant par = | Texte non exécutable |
| T-16 | Modifier permission | Admin autorisé + audit |
| T-17 | Archiver/supprimer candidat | Politique appliquée + audit |
| T-18 | Période sans données | Zéro/aucune donnée, pas d'erreur |
| T-19 | Accents français | Affichage correct |
| T-20 | Arabe/RTL si activé | Alignement/polices/exports vérifiés |
| T-21 | Recruteur ouvre Administration | Refus |
| T-22 | Modification rôle | Effet serveur et audit |
| T-23 | Lire préférences autre utilisateur | Refus |
| T-24 | Changement scoring | Nouvelle version, ancien résultat conservé |
| T-25 | Reset Demo | Ne touche pas aux données non-demo |
| T-26 | Accès direct CV privé | Refus sans autorisation |
| T-27 | SMTP absent/échec | Pas de statut envoyé |
| T-28 | Backup SQL/fichiers | Restauration test réussie |
| T-29 | Démarrage Wamp localhost | Fonctionne sans hosting |
| T-30 | Comptes Demo/Admin | Permissions différentes |
| T-31 | Perte Internet | Fonctions cœur locales disponibles ; services externes signalés |
| T-32 | Écrans principaux | Responsive desktop/mobile |
| T-33 | Install vierge sur 5 PC | Schéma installé avec migrations |
| T-34 | Backup/restore autre installation | Données/fichiers retrouvés |
| T-35 | Chemins privés | config/database/storage/vendor non téléchargeables |

### Tests complémentaires à ajouter
Tests CSRF, XSS, SQL injection, session expirée/révocation, brute-force/rate limit, rôles, périmètre de données, transaction rollback, upload MIME spoofé, nom de fichier path traversal, permission export, double soumission, historique scoring et transitions non autorisées.

### Livrables de remise
Source ; migrations SQL ; seeders ; `composer.json` et `composer.lock` si Composer ; `.env.example` sans secrets ; guide WAMP ; guide installation sur une seconde machine ; guide utilisateur ; guide admin ; architecture ; dictionnaire DB ; matrice permissions ; guide backup/restore ; rapport tests ; scénario de démo ; registre des bonus/non réalisés.

### Critère final
L'application fonctionne sur WampServer sans dépendre d'un hosting Internet. L'installation vierge est reproductible sur un second PC. Les tests échoués/non faits sont explicitement identifiés. Aucun faux succès n'est présenté.


## Prompt exécutable — Phase 09

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_09_TESTS_FINAUX_ET_REMISE.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 09 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
