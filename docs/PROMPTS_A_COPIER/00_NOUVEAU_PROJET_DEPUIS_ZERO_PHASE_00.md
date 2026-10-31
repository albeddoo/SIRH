# PROMPT 00 — NOUVEAU PROJET SIRH DEPUIS ZÉRO + PHASE 00

> **À utiliser pour un dépôt neuf.** Ce prompt remplace le prompt de reprise d'un ancien projet.
> Il autorise uniquement l'analyse et le cadrage. Il n'autorise pas encore la création du code applicatif.

Copie-colle intégralement le texte ci-dessous dans Qwen Coder après avoir ouvert le dossier racine du nouveau dépôt SIRH dans VS Code.

---

## PROMPT À DONNER À QWEN CODER

Tu es l'architecte logiciel et le développeur principal chargé de préparer le projet **SIRH** depuis zéro.

### 1. Contexte confirmé du projet

- Nom de l'application : **SIRH**.
- Produit pédagogique : ATS spécialisé dans la gestion du recrutement.
- Entreprise fictive de l'étude de cas : **Digital Maroc Solutions**, Casablanca.
- Environnement : Windows + WampServer + Apache + PHP + MySQL.
- Backend : PHP 8.2+ (version exacte à confirmer sur les cinq postes), architecture MVC personnalisée.
- Frontend : HTML5, CSS3, Bootstrap 5, JavaScript natif et AJAX/Fetch.
- Base : MySQL 8.x, InnoDB, utf8mb4, accès par PDO et requêtes préparées.
- Outils : VS Code, Git, GitHub privé et Composer pour les bibliothèques justifiées.
- Exécution : locale via `localhost` ou VirtualHost strictement local.
- Aucun hébergement public, aucun Cloud Hosting et aucune publication sur Internet.
- L'équipe comporte cinq membres ; la répartition est définie dans `docs/EQUIPE/ORGANISATION_EQUIPE_5_MEMBRES.md`.

### 2. Signification de « depuis zéro »

Ce dépôt est un nouveau démarrage. Les fichiers `QWEN.md`, `AGENTS.md`, `docs/`, `references/`, les modèles GitHub et les fichiers de documentation fournis dans ce pack sont des documents de référence, pas une application déjà développée.

Tu ne dois pas chercher à reprendre un ancien code applicatif, ni importer un ancien projet, ni copier un code généré précédemment.

Si tu découvres dans le dossier des fichiers applicatifs inattendus (par exemple `app/`, `public/index.php`, `vendor/`, une ancienne base SQL ou des fichiers de configuration), arrête-toi et signale-les avant de les modifier. Ne les supprime pas.

### 3. Lecture obligatoire — limitée

Lis dans cet ordre :

1. `QWEN.md` à la racine.
2. `AGENTS.md` à la racine.
3. `docs/00_LIRE_EN_PREMIER.md`.
4. `docs/01_REGLES_ET_SOURCE_DE_VERITE.md`.
5. `docs/DECISIONS_A_VALIDER.md`.
6. `references/CAHIER_DES_CHARGES_SOURCE_24_PAGES.pdf` comme source du cahier des charges. Si ton environnement ne peut pas lire le PDF, signale-le et n'invente pas son contenu.
7. `docs/PHASES/PHASE_00_ANALYSE_ET_CADRAGE.md`.

Ne lis pas les neuf autres spécifications de phase maintenant. Ne charge pas l'archive textuelle complète sauf si une contradiction précise l'exige ; dans ce cas, indique la section consultée.

### 4. Mission autorisée : Phase 00 uniquement

Réalise l'analyse complète du projet, sans développer l'application.

Tu dois produire :

1. Une matrice de traçabilité : exigence du cahier des charges → module → rôle → données → test d'acceptation.
2. Une séparation claire entre MVP obligatoire, Bonus et hors périmètre.
3. La liste des rôles, permissions et parcours utilisateurs.
4. Un diagnostic de compatibilité WampServer sur les cinq PC : Windows, Apache, PHP, MySQL, extensions PHP, Composer et Git. Ne prétends pas connaître les versions ; indique celles qui doivent être relevées.
5. Une architecture PHP MVC personnalisée détaillée et une proposition de structure de dossiers.
6. Un modèle de données relationnel proposé : entités, attributs principaux, relations, clés, index et contraintes.
7. Une stratégie de migrations SQL versionnées et de synchronisation des cinq bases locales.
8. Les contrats API/AJAX nécessaires entre les modules et les responsabilités de chaque membre.
9. Une stratégie de stockage local privé des CV, documents, exports, journaux et sauvegardes.
10. Une analyse des capacités IA réellement faisables en local : règles déterministes, NLP, parsing et LLM local optionnel. Distingue clairement chaque catégorie ; ne présente pas un simple matching de mots-clés comme une IA générative.
11. Les exigences de sécurité, confidentialité, audit, sauvegarde et restauration.
12. Les critères d'acceptation, les tests à prévoir et les dépendances entre les phases.
13. Les décisions encore ouvertes, avec options, avantages, risques et recommandation. Ne tranche pas silencieusement les décisions explicitement marquées « à valider ».
14. Un plan de travail pour les cinq membres et les règles GitHub / Pull Request / revue de code.

### 5. Points métier à vérifier sans les réécrire arbitrairement

- La grille de scoring sur 100 et les cinq profils de référence doivent être repris fidèlement.
- Le cahier des charges et les notes antérieures présentent une divergence concernant le départage Amine/Youssef. Expose la divergence et demande une décision ; ne modifie pas le résultat de référence sans validation.
- Une information non documentée ne doit pas être confondue avec une compétence absente dans les données réelles.
- Aucune décision finale d'embauche ou de rejet ne doit être prise automatiquement par le système.
- Le parsing CV avancé, le LLM génératif, l'envoi SMTP réel et la vidéo différée réelle sont des options/Bonus tant qu'ils ne sont pas validés.
- Le cas de démonstration utilise 150 candidatures fictives et les cinq profils fournis.

### 6. Interdictions pendant cette phase

- Ne crée aucun code applicatif PHP, HTML, CSS ou JavaScript.
- Ne crée aucune table réelle, migration exécutable ou base de données.
- Ne modifie pas `composer.json`, `.env`, les configurations WampServer ou Apache.
- N'installe aucun paquet et n'exécute aucune commande destructive.
- Ne crée pas encore le squelette MVC.
- Ne commence aucune phase 01 à 09.
- Ne fais aucun commit, push, merge, reset, clean ou suppression.
- N'invente aucune version logicielle, sortie de test ou résultat d'exécution.

### 7. Livrables de Phase 00

Crée ou complète uniquement les documents d'analyse suivants :

- `docs/ANALYSE/RAPPORT_PHASE_00.md` — rapport principal structuré.
- `docs/ANALYSE/MATRICE_TRAÇABILITE.md` — exigences et tests.
- `docs/ANALYSE/ARCHITECTURE_PROPOSEE.md` — MVC, dossiers et flux.
- `docs/ANALYSE/MODELE_DONNEES_PROPOSE.md` — modèle relationnel proposé, sans migration SQL exécutable.
- `docs/ANALYSE/CONTRATS_API_PROPOSES.md` — contrats et conventions.
- `docs/ANALYSE/PLAN_EQUIPE_ET_PHASES.md` — responsabilités et dépendances.
- `docs/DECISIONS_A_VALIDER.md` — mise à jour des décisions, en conservant l'historique.

Ne remplace pas les documents source. Si un fichier existe déjà, propose les modifications et conserve son historique.

### 8. Format obligatoire de la réponse finale

Présente un résumé exécutif, puis chaque livrable, les décisions ouvertes, les risques, les points non vérifiés et les questions qui nécessitent réellement une réponse humaine.

Pour chaque élément, utilise l'un des statuts : `CONFIRMÉ PAR SOURCE`, `PROPOSITION`, `À VÉRIFIER SUR LES PC`, `À VALIDER PAR L'ÉQUIPE` ou `NON VÉRIFIÉ`.

Termine par une liste de critères permettant à l'équipe de valider Phase 00.

**ARRÊTE-TOI APRÈS PHASE 00. N'ÉCRIS PAS LE CODE. Attends une validation humaine explicite avant la Phase 01.**

---

Fin du prompt. Ne lance aucune action supplémentaire sans instruction.
