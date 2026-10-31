# SIRH — Pack Qwen Coder : nouveau projet depuis zéro

Ce dépôt contient les spécifications et prompts pour créer une application SIRH/ATS locale avec PHP MVC personnalisé, MySQL et WampServer. Il ne contient pas encore le code applicatif.

## Objectif

Créer depuis zéro une application locale Windows : PHP 8.2+ (version commune à confirmer), Apache/WampServer, MySQL 8.x, PDO, Bootstrap 5 et JavaScript natif. GitHub sert uniquement à versionner le code, les migrations et la documentation. **Aucun hébergement Internet n'est prévu.**

## Démarrage conseillé

1. Créez un nouveau dossier de projet, par exemple `C:\\wamp64\\www\\SIRH`. S'il existe déjà, ne l'écrasez pas : choisissez un nouveau nom ou sauvegardez-le d'abord.
2. Décompressez ce pack dans ce nouveau dossier. Le dossier doit contenir `QWEN.md`, `AGENTS.md`, `docs/` et `references/` à sa racine.
3. Créez un nouveau dépôt GitHub privé et vide, ou initialisez Git localement puis reliez-le au nouveau dépôt. Ne réutilisez pas un dépôt contenant l'ancien code sans sauvegarde et décision explicite.
4. Ouvrez le nouveau dossier racine dans VS Code avec Qwen Coder.
5. Vérifiez que Qwen a accès aux fichiers `QWEN.md` et `AGENTS.md`. Si l'extension ne les charge pas automatiquement, demandez-lui explicitement de les lire.
6. Copiez uniquement le prompt `docs/PROMPTS_A_COPIER/00_NOUVEAU_PROJET_DEPUIS_ZERO_PHASE_00.md`.
7. Phase 00 est une analyse sans code. Lisez le rapport, faites valider les décisions, puis autorisez séparément Phase 01.

## Si un ancien projet existe déjà

Ce pack est conçu pour un dépôt neuf. Ne supprimez pas l'ancien dossier ou dépôt. Gardez-en une sauvegarde séparée. N'utilisez pas ce pack dans l'ancien dépôt tant que vous n'avez pas décidé explicitement de le remplacer.

## Arborescence de la documentation

- `QWEN.md` : instructions permanentes pour Qwen.
- `AGENTS.md` : règles de collaboration et de sécurité.
- `docs/00_LIRE_EN_PREMIER.md` : contexte global.
- `docs/01_REGLES_ET_SOURCE_DE_VERITE.md` : règles métier et fonctionnelles.
- `docs/DECISIONS_A_VALIDER.md` : décisions ouvertes.
- `docs/PHASES/` : spécifications détaillées des dix phases.
- `docs/PROMPTS_A_COPIER/` : prompts prêts à copier, un seul à la fois.
- `docs/EQUIPE/` : organisation des cinq membres.
- `docs/QUALITE/` : tests et checklists.
- `references/` : cahier des charges PDF et référence complète.

## Ordre des phases

00. Analyse et cadrage — sans coder.
01. Socle local PHP MVC / MySQL / WampServer.
02. Authentification et Administration.
03. Offres et portail candidat local.
04. Candidats, documents et candidatures.
05. IA, matching, scoring et présélection.
06. Pipeline, entretiens et évaluations.
07. Communications et notifications.
08. Dashboard, reporting et exports.
09. Tests finaux, validation et remise locale.

Chaque phase nécessite un rapport de sortie et une validation humaine avant de passer à la suivante.

## Sécurité et collaboration

- Une base locale `sirh` par poste ; les migrations et seeders versionnés sont partagés via GitHub, pas les données réelles.
- Ne jamais pousser `.env`, mots de passe, CV, documents personnels, dumps réels, sauvegardes privées ou fichiers `vendor/` non nécessaires.
- Toute modification SQL passe par une migration versionnée.
- Aucun reset, clean, suppression massive, commit, push ou merge sans autorisation explicite.
- L'application et les fichiers de candidats restent locaux et privés. Ne pas exposer WampServer sur Internet.
