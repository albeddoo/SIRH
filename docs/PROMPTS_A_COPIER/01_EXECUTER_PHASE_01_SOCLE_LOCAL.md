# PROMPT 01 — Socle local PHP MVC, MySQL et WampServer

**À utiliser uniquement après validation écrite de la phase précédente.**

## Prompt prêt à copier dans Qwen Coder

```text
Tu travailles dans le dépôt local SIRH déjà relié à GitHub. Le produit est un ATS pédagogique local pour Digital Maroc Solutions. L'application doit tourner sous Windows + WampServer/Apache + PHP MVC personnalisé + MySQL/MariaDB. Elle n'est pas hébergée sur Internet.

Commence par lire QWEN.md et AGENTS.md à la racine, puis docs/00_LIRE_EN_PREMIER.md, docs/01_REGLES_ET_SOURCE_DE_VERITE.md et docs/DECISIONS_A_VALIDER.md. Lis ensuite le rapport validé de la phase précédente s'il existe, puis uniquement la spécification suivante : docs/PHASES/PHASE_01_SOCLE_PHP_MYSQL_WAMP.md. Ne charge pas toutes les autres phases ni l'archive complète.

EXÉCUTE EXCLUSIVEMENT : Socle local PHP MVC, MySQL et WampServer.

Avant tout changement :
1. Affiche `git status --short --branch`, identifie la branche et les changements non commités. Ne divulgue pas de secrets.
2. Inspecte les fichiers et fonctionnalités déjà présents ; réutilise ce qui est correct.
3. Résume les dépendances, tables, routes, permissions et conventions existantes touchées.
4. Présente un plan limité aux fichiers de cette phase. Attends mon accord si un changement transversal, risqué ou non couvert par la décision approuvée est nécessaire.

Travaux de cette phase :

- Confirmer le diagnostic et les décisions approuvées de Phase 00 ; ne pas changer le stack validé.
- Créer ou compléter l’ossature MVC personnalisée : front controller, routes, contrôleurs, modèles/repositories, services, vues, middleware et gestion des erreurs.
- Configurer PDO, variables locales hors Git, connexion MySQL/MariaDB, InnoDB, utf8mb4 et migrations versionnées.
- Configurer Apache/WampServer avec chemin de base sûr pour sous-dossier ; rendre public/ seul répertoire exposé si possible ; bloquer config, database, storage et vendor.
- Préparer les commandes/scripts d’installation locale, de diagnostic et de seed de développement ; documenter les prérequis communs des cinq PC.
- Créer uniquement le socle technique ; ne pas anticiper les modules métier des phases suivantes.

Livrables et critères de sortie obligatoires :

- [ ] Application de base accessible sur localhost
- [ ] Connexion DB testée et erreur gérée proprement
- [ ] Migrations initiales exécutables sur base vierge
- [ ] Dossiers privés protégés par Apache
- [ ] README installation WAMP et rapport Phase 01

## Interdictions spécifiques
- Ne commence aucune autre phase et ne développe pas des modules futurs « par anticipation ».
- Ne change pas l'architecture, les contrats partagés, la DB commune ou la matrice RBAC sans signaler l'impact et demander validation.
- Ne fais aucun commit/push/merge/reset/clean ni suppression destructive sans autorisation explicite.

## Règles permanentes
- Suis exactement la hiérarchie : décision utilisateur la plus récente, cahier des charges source, spécification de phase, décisions validées, puis bonnes pratiques. Signale toute contradiction.
- Respecte les limites MVP/Bonus. Le parsing avancé, LLM génératif, SMTP réel et vidéo réelle ne doivent pas bloquer le MVP.
- Toutes les opérations DB passent par la couche prévue et PDO préparé. Toute évolution SQL utilise une migration versionnée.
- Toutes les permissions sont vérifiées côté serveur. Les CV et documents restent privés hors du répertoire public.
- Utilise uniquement des données fictives. Aucune donnée réelle de candidat dans GitHub.
- Scoring explicable, versionné et configurable ; le RH garde la décision finale. Aucun rejet automatique définitif.
- Pas de hosting, Cloudflare, React, Vue, Node, Laravel ou Symfony. Pas d'accès Internet public à WampServer.
- Ne prétends jamais qu'un test, une sauvegarde, un e-mail ou une fonctionnalité a réussi s'il n'a pas été exécuté et vérifié.

À la fin :
1. Exécute les tests réellement possibles et donne les commandes exactes et résultats.
2. Liste les fichiers créés/modifiés, migrations, impacts, tests non exécutés et risques restants.
3. Remplis `docs/TEMPLATES/RAPPORT_FIN_PHASE.md` dans un rapport `docs/RAPPORTS_PHASES/PHASE_01.md`.
4. Donne le statut de chaque critère : VALIDÉ / NON VALIDÉ / BLOQUÉ.
5. ARRÊTE-TOI. N'exécute pas la phase suivante. Attends ma validation explicite.

Ne commit/push/merge rien. Je déciderai séparément quand les changements seront prêts à être versionnés.
```

## Notes pour l'utilisateur
- Ce prompt correspond à une seule phase. Ne le mélange pas avec un autre prompt.
- Pour la phase suivante, attends le rapport, vérifie le résultat puis colle le prompt suivant.
