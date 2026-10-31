# QWEN.md — Instructions permanentes du projet SIRH

Tu interviens sur **SIRH**, une application locale de gestion du recrutement (ATS pédagogique) pour le cas fictif **Digital Maroc Solutions**.

## Environnement obligatoire
- Windows + WampServer + Apache.
- PHP 8.2+ (version exacte à relever sur les cinq postes), architecture MVC personnalisée.
- MySQL 8.x, InnoDB, utf8mb4 ; choisir une version commune après vérification des postes.
- PDO, requêtes préparées, HTML5, CSS3, Bootstrap 5, JavaScript natif et AJAX/Fetch.
- Composer uniquement pour des bibliothèques PHP compatibles et justifiées.
- URL locale : `http://localhost/SIRH/` ou VirtualHost strictement local, à confirmer selon Apache.
- **Aucun hébergement, aucun Cloud Hosting, aucun déploiement Internet.** GitHub sert uniquement au versionnement du code et des documents.

## Démarrage depuis zéro
- Ce pack est destiné à créer une nouvelle application. Les documents `docs/` et `references/` sont des spécifications, pas du code applicatif existant.
- La première action autorisée est le prompt `docs/PROMPTS_A_COPIER/00_NOUVEAU_PROJET_DEPUIS_ZERO_PHASE_00.md`.
- La Phase 00 est une phase d'analyse uniquement : aucun code applicatif, aucune migration exécutable et aucune installation de dépendance.
- Après validation humaine de Phase 00, exécuter une seule phase à la fois, avec son prompt dédié et son rapport de phase précédente.
- Lire `AGENTS.md`, `docs/00_LIRE_EN_PREMIER.md`, `docs/01_REGLES_ET_SOURCE_DE_VERITE.md`, puis la spécification de la phase demandée. Ne pas charger toutes les phases simultanément.

## Règles non négociables
- Le projet démarre de zéro, mais ne jamais écraser ou supprimer un fichier fourni par l'utilisateur sans approbation explicite.
- Si un ancien code applicatif inattendu est présent, l'identifier et demander quoi en faire ; ne pas le supprimer.
- Aucun `git reset`, `git clean`, suppression massive, commit, push ou merge sans demande explicite.
- Toute évolution SQL passe par une migration versionnée et documentée.
- Toute permission est vérifiée côté serveur ; masquer un bouton ne suffit pas.
- Utiliser PDO et des requêtes préparées ; validation serveur ; protection CSRF/XSS/SQLi ; secrets hors Git.
- Les CV et documents restent dans un stockage local privé, non directement exposé par Apache.
- Données fictives uniquement pour la démonstration.
- Le scoring aide le RH ; aucune décision de rejet ou d'embauche entièrement automatique.
- SMTP réel et LLM externe sont facultatifs, désactivés par défaut. Le cœur doit fonctionner localement sans eux.
- Ne jamais prétendre qu'un test, un email, une sauvegarde ou une fonction a réussi sans l'avoir réellement exécuté.

## Fin de chaque phase
Produis le rapport demandé dans `docs/RAPPORTS_PHASES/`, liste les tests exécutés et non exécutés, les fichiers touchés, migrations, risques et décisions en attente. Arrête-toi et attends la validation humaine avant la phase suivante.
