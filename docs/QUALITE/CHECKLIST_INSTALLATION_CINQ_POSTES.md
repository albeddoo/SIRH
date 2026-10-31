# Checklist de compatibilité — cinq postes WampServer

À compléter pendant Phase 00 ; ne pas deviner les versions.

| Élément | Membre 1 | Membre 2 | Membre 3 | Membre 4 | Membre 5 |
|---|---|---|---|---|---|
| Windows version | À relever | À relever | À relever | À relever | À relever |
| WampServer version | À relever | À relever | À relever | À relever | À relever |
| Apache version | À relever | À relever | À relever | À relever | À relever |
| PHP version | À relever | À relever | À relever | À relever | À relever |
| PHP extensions | À relever | À relever | À relever | À relever | À relever |
| MySQL/MariaDB version | À relever | À relever | À relever | À relever | À relever |
| Composer version | À relever | À relever | À relever | À relever | À relever |
| Git version | À relever | À relever | À relever | À relever | À relever |
| IDE | À relever | À relever | À relever | À relever | À relever |
| Port Apache/MySQL | À relever | À relever | À relever | À relever | À relever |

## Commandes de diagnostic non destructives
- PHP : `php -v` et `php -m` depuis le terminal configuré de WampServer.
- Apache : vérifier la version dans le menu WampServer ou exécuter le binaire `httpd -v` correspondant.
- MySQL/MariaDB : `SELECT VERSION();` via phpMyAdmin ou console SQL.
- Composer : `composer --version`.
- Git : `git --version`.

Ne pas installer, désinstaller ou mettre à niveau un composant sur les cinq postes avant de comparer les résultats et de valider une version commune.
