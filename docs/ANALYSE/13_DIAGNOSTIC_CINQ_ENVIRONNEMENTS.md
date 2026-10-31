# Diagnostic à effectuer sur les cinq environnements WampServer

Objectif : établir la **vérité technique des 5 postes** avant toute Phase 01 (règle MP §27 : tant que la page de test commune ne passe pas partout, aucune fonctionnalité n'est produite). Ce document est un protocole ; l'exécution relève de l'équipe (M4 + chaque membre), avec M2 qui centralise. Aucune valeur n'est supposée ici.

## 1. Périmètre du relevé (par poste)

À remplir dans `docs/QUALITE/DIAGNOSTIC_CINQ_ENVIRONNEMENTS.md` (fichier de résultats à créer en Phase 01, pas maintenant) :

| # | Élément | Comment obtenir |
|---|---|---|
| 1 | Nom du poste / responsable | — |
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

## 2. Page de test commune (critère d'acceptation par poste)

En Phase 01 uniquement : script unique versionné testant ① connexion PDO MySQL à une base de test locale ② affichage versions PHP/Apache/MySQL/extensions ③ écriture/lecture fichier dans `storage/` hors DocumentRoot ④ création/lecture/suppression d'une table temporaire de test ⑤ rendu d'une page accentuée UTF-8. Un poste est VALIDÉ quand la page s'affiche sans erreur sur son navigateur local (critère directement lié à T-29 : démarrage WampServer via localhost). Résultat attendu identique sur les 5 postes, vérifié en amont par T-33 (script SQL + migrations installent une base vierge sur chacun des cinq PC) ; la synchronisation continue des schémas/version/seeders entre postes relève du contrôle permanent §30 du MP et des revues d'équipe (`14_PLAN_GITHUB_EQUIPE.md`).

## 3. Arbitrages dépendant du relevé (décisions attendues)

- **D-05/D-01b** : version PHP commune cible = min des versions compatibles présentes ou mise à niveau uniforme décidée ; idem MySQL/MariaDB (si un poste n'a que MariaDB → décision explicite de mise à niveau ou d'exclusion documentée, MP §27).
- **D-20** : collation uniforme (utf8mb4_unicode_ci vs 0900_ai_ci selon versions réelles).
- Choix VirtualHost (`sirh.local`) vs URL sous-dossier `localhost/SIRH/public` — documenté par poste, cohérent via `.env.example`.
- Ports Apache conflictuels (Skype/IIS) résolus poste par poste.

## 4. Sécurité des manipulations

- Sauvegarder avant tout changement : configs Wamp/Apache/PHP existantes, listes des bases et projets voisins ; ne jamais toucher aux autres projets (MP §28).
- Ne jamais exposer MySQL/Apache au réseau : localhost bind ; pas de port forwarding ; LAN désactivé par défaut (D-06).
- Aucun mot de passe root partagé en clair dans les docs/Git ; configuration locale ignorée.

## 5. Livrables du diagnostic (Phase 01)

1. Tableau des 15 points × 5 postes rempli et signé par chaque membre (responsabilité individuelle).
2. Synthèse des écarts + plan de mise à niveau (M4).
3. PV « page de test commune OK sur 5/5 » → débloque la production de fonctionnalités.
4. Mise à jour de `docs/DECISIONS_A_VALIDER.md` (statut D-05/D-20) après validation utilisateur.

## 6. Risques anticipés (extraits, détail dans `15_REGISTRE_RISQUES.md`)

Versions PHP divergentes entre postes ; port 80 occupé ; MariaDB au lieu de MySQL ; extensions manquantes (intl/gd) ; antivirus bloquant ; limites upload trop faibles pour les CV ; utilisateurs partageant un même compte (interdit par la règle équipe).
