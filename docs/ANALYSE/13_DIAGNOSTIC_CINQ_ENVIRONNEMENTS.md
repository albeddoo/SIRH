# Diagnostic à effectuer sur l'environnement WampServer local

> **MISE À JOUR CONTEXTUELLE (01/11/2026)** — Le propriétaire du projet a confirmé qu'il est **le seul développeur du projet**. Il n'y a pas d'équipe de cinq développeurs ni de cinq postes. Les mentions de « cinq environnements / 5 postes » proviennent des hypothèses initiales issues des sources (MP V3 Annexe B, PDF) et sont **abrogées pour l'organisation** ; le périmètre fonctionnel reste inchangé. L'historique de cette évolution est tracé via **D-25** (`16_DECISIONS_EN_ATTENTE.md`). Titre du fichier conservé pour la stabilité des références croisées.

Objectif : établir la **vérité technique de l'unique environnement local** (le PC du développeur) avant toute Phase 01 (principe MP §27 transposé : tant que la page de test locale ne passe pas, aucune fonctionnalité n'est produite). Ce document est un protocole ; son exécution relève du développeur unique, avec Qwen Code comme assistant. Aucune valeur n'est supposée ici.

## 1. Périmètre du relevé (environnement unique)

À remplir dans `docs/QUALITE/DIAGNOSTIC_ENVIRONNEMENT_LOCAL.md` (fichier de résultats à créer en Phase 01, pas maintenant) :

| # | Élément | Comment obtenir |
|---|---|---|
| 1 | Nom du poste unique (développeur propriétaire) | — |
| 2 | Windows 10/11 + édition/build | `winver` |
| 3 | WampServer installé ? version | icône système / `wampmanager` |
| 4 | Apache up/down, port HTTP (80 ou autre), VirtualHost existants | interface Wamp + `httpd -v`, fichiers vhosts |
| 5 | PHP actif (version exacte, ordre php.ini utilisé) | `php -v`, page info Wamp |
| 6 | Extensions PHP requises : pdo_mysql, mbstring, intl, gd ou équivalent pour PDF, zip, fileinfo, openssl, curl (local only) | `php -m` |
| 7 | Limites upload/mémoire/exécution : upload_max_filesize, post_max_size, memory_limit, max_execution_time, max_file_uploads | phpinfo |
| 8 | MySQL : service démarré, version exacte, port 3306 libre, moteur InnoDB, collation disponible utf8mb4 | `mysql --version`, `SHOW VARIABLES LIKE 'character_set_server'`… |
| 9 | Autres bases/projects présents dans `www` et `mysql` (à NE PAS écraser) | listing dossiers + `SHOW DATABASES` |
| 10 | Git version + SSH clé GitHub + accès dépôt privé | `git --version`, `ssh -T git@github.com` |
| 11 | Composer version | `composer --version` |
| 12 | VS Code présent (rôle dev) | — |
| 13 | Antivirus/Firewall susceptibles de bloquer Apache/MySQL 3306 | panneau de config |
| 14 | Emplacement disque/réserves pour `www\SIRH` + `storage/backups` | explorateur |
| 15 | Fuseau horaire OS (doit permettre Africa/Casablanca en app) | paramètres |

## 2. Page de test commune (critère d'acceptation sur l'environnement unique)

En Phase 01 uniquement : script unique versionné testant ① connexion PDO MySQL à une base de test locale ② affichage versions PHP/Apache/MySQL/extensions ③ écriture/lecture fichier dans `storage/` hors DocumentRoot ④ création/lecture/suppression d'une table temporaire de test ⑤ rendu d'une page accentuée UTF-8. L'environnement est VALIDÉ quand la page s'affiche sans erreur sur le navigateur local du développeur (critère directement lié à T-29 : démarrage WampServer via localhost). La définition officielle de T-33 (« le script SQL et les migrations installent une base vierge sur chacun des cinq PC », MP §43) n'est **pas modifiée** ; en contexte de développement individuel, elle ne peut être exécutée littéralement que si plusieurs machines sont réellement disponibles — sinon elle devra être revalidée/réinterprétée par le propriétaire (documenté dans `12_MATRICE_TRACABILITE.md`, statut « à revalider »). La synchronisation continue des schémas/version/seeders relève du contrôle permanent §30 du MP, appliqué à un seul environnement + dépôt Git.

## 3. Arbitrages dépendant du relevé (décisions attendues)

- **D-05/D-01b** : versions PHP & MySQL/MariaDB **réelles installées sur le PC du développeur** = vérité de référence directe (plus de minimisation inter-postes ni mise à niveau uniforme d'équipe) ; MySQL vs MariaDB tranché au relevé. Aucune valeur inventée avant le relevé.
- **D-20** : collation uniforme selon la version réelle relevée (utf8mb4_unicode_ci vs 0900_ai_ci).
- Choix VirtualHost (`sirh.local`) vs URL sous-dossier `localhost/SIRH/public` — documenté pour l'environnement unique, cohérent via `.env.example`.
- Port Apache conflictuel (Skype/IIS) résolu sur le poste unique.

## 4. Sécurité des manipulations

- Sauvegarder avant tout changement : configs Wamp/Apache/PHP existantes, listes des bases et projets voisins ; ne jamais toucher aux autres projets (MP §28).
- Ne jamais exposer MySQL/Apache au réseau : localhost bind ; pas de port forwarding ; LAN désactivé par défaut (D-06).
- Aucun mot de passe root partagé en clair dans les docs/Git ; configuration locale ignorée.

## 5. Livrables du diagnostic (Phase 01)

1. Tableau des 15 points rempli pour l'environnement unique, daté et validé par le propriétaire.
2. Synthèse des éventuels écarts avec les prérequis MP + plan de mise à niveau éventuel.
3. PV « page de test locale OK » → débloque la production de fonctionnalités.
4. Mise à jour du registre de décisions (statut D-05/D-20) après validation utilisateur.

## 6. Risques anticipés (extraits, détail dans `15_REGISTRE_RISQUES.md`)

Version PHP incompatible avec les bibliothèques retenues ; port 80 occupé ; MariaDB au lieu de MySQL (à trancher explicitement) ; extensions manquantes (intl/gd) ; antivirus bloquant ; limites upload trop faibles pour les CV ; absence de redondance humaine (un seul développeur → cf. nouveau risque R-16 dans `15_...`).
