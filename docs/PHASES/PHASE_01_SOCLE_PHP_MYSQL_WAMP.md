# PHASE 01 — SOCLE LOCAL PHP/MYSQL

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Construire une base technique reproductible sur WampServer, avec un squelette MVC minimal, une connexion PDO fiable, des migrations et un dépôt Git commun. Ne pas développer encore les modules métier complets.

## Tâches à réaliser dans l’ordre

1. Vérifier les versions retenues sur les cinq PC et documenter les extensions requises.

2. Initialiser le dépôt privé, .gitignore, .env.example, composer.json et composer.lock.

3. Créer le squelette PHP MVC, le routeur, BASE_URL, le point d’entrée public et les vues communes.

4. Configurer Apache/WampServer et l’accès localhost ; vérifier le sous-dossier ou VirtualHost retenu.

5. Créer la base SIRH, l’accès PDO, la gestion des erreurs et les journaux.

6. Mettre en place migrations SQL versionnées, seeders fictifs et contraintes/index nécessaires.

7. Créer le stockage local privé pour documents et exports, avec règles de nommage et d’accès.

8. Vérifier le démarrage reproductible sur tous les PC et la procédure de mise à jour locale.

## Références fonctionnelles et techniques à respecter

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


## Extrait du plan de réalisation d’origine

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


## Références techniques officielles

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

## Livrables obligatoires

- [ ] Squelette MVC fonctionnel
- [ ] Connexion MySQL PDO
- [ ] Migrations initiales
- [ ] Seeders initiaux
- [ ] Configuration WampServer documentée
- [ ] Layout Bootstrap de base
- [ ] README installation
- [ ] Tests de démarrage sur les postes

## Critère de sortie et règle d’arrêt

Chaque membre peut cloner le dépôt, configurer son environnement, exécuter les migrations et ouvrir une page locale connectée à MySQL. Aucun module métier complet n’est déclaré terminé à ce stade.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_01.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Détails techniques supplémentaires

### Diagnostic et reproductibilité
- Vérifier que la version PHP retenue est commune aux postes et compatible avec les bibliothèques prévues.
- Vérifier Apache, `mod_rewrite` si utilisé, extensions PDO MySQL, fileinfo, mbstring, intl si nécessaire, openssl et gd selon besoins.
- Ne pas mettre à jour WampServer ou MySQL sans sauvegarde et accord de l'équipe.
- Choisir MySQL ou MariaDB après vérification réelle ; documenter exactement le moteur/version.

### Socle MVC
- `public/index.php` comme front controller unique.
- Router central avec méthodes HTTP et routes nommées.
- Controllers minces ; services pour les règles métier ; modèles/repositories pour SQL ; vues PHP sans requêtes SQL.
- Gestion centralisée des erreurs 400/401/403/404/419/422/500.
- Configuration hors webroot, `.env.example` sans secrets, `.env` local ignoré.
- Base URL compatible sous-dossier `http://localhost/SIRH/` et Virtual Host local.
- Gestion des sessions sécurisée préparée mais authentification métier réalisée en Phase 02.
- Helpers de validation, échappement, CSRF, redirection, réponse JSON et journalisation.

### SQL / Migrations
- InnoDB, `utf8mb4`, clés primaires, étrangères, index et contraintes uniques.
- Migration versionnée et table de suivi `migrations`.
- Scripts `install.sql`/migrations réexécutables de manière sûre ; ne pas supprimer les données existantes.
- Seed de données techniques non sensibles uniquement à ce stade.
- PDO en mode exceptions, émulation des prepared statements désactivée lorsque compatible.

### Critère de sortie additionnel
Une installation vierge de la base et un démarrage depuis WampServer sont reproductibles à partir du README, sans module RH encore implémenté.


## Prompt exécutable — Phase 01

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_01_SOCLE_PHP_MYSQL_WAMP.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 01 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
