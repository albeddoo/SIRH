# Architecture technique — PHP MVC / MySQL / WampServer

Base : MP V3 §27–32 (`CONFIRMÉ MP`) complété par PDF §16 (`CONFIRMÉ PAR SOURCE`). Les choix fins non imposés sont `PROPOSITION`. **Aucun code n'est écrit en Phase 00.**

## 1. Stack cible

| Couche | Technologie | Rôle | Statut |
|---|---|---|---|
| OS dev | Windows 10/11 (5 postes) | Environnement équipe | CONFIRMÉ MP |
| Serveur local | WampServer 64-bit | Apache/PHP/MySQL | CONFIRMÉ MP |
| HTTP | Apache 2.4.x | Sert `public/` via localhost ou VirtualHost | CONFIRMÉ MP |
| Backend | PHP 8.2+ — **version exacte commune à confirmer sur les 5 PC** | Contrôleurs, services, règles métier | À VÉRIFIER SUR LES PC |
| Architecture | MVC personnalisé (pas de framework) | Séparation C/M/V | CONFIRMÉ MP |
| BDD | MySQL 8.x (version commune à confirmer ; pas de mélange MariaDB sans test documenté) | Stockage relationnel | CONFIRMÉ MP / versions À RELEVER |
| Accès SQL | PDO MySQL, requêtes préparées, `ERRMODE_EXCEPTION`, transactions | Sécurité d'accès | CONFIRMÉ MP |
| Encodage | UTF-8 / `utf8mb4` | Accents + arabe éventuel | CONFIRMÉ MP |
| Frontend | HTML5, CSS3, Bootstrap 5, JS natif + AJAX/Fetch | UI responsive | CONFIRMÉ MP |
| Graphiques | Librairie légère (Chart.js « ou équivalent » cité par le PDF ; alternative locale sans CDN à arbitrer pour le mode hors Internet T-31) | KPI/pipeline | PROPOSITION / À VÉRIFIER |
| Composer | phpoffice/phpspreadsheet (XLSX) ; Dompdf **ou** mPDF (PDF, choix après test accents/RTL/perf) ; autres libs justifiées et compatibles PHP retenu | Dépendances contrôlées | CONFIRMÉ MP, arbitrage PDF = D-04b |
| Versionnement | Git + GitHub privé | Code/migrations/tests/docs | CONFIRMÉ MP |
| Éditeur | VS Code | Dev | CONFIRMÉ MP |

Contraintes : pas de Laravel/Symfony/Node/React/Vue/Next sans demande explicite + validation enseignant ; aucun chemin `C:\wamp64\...` codé en dur ; `BASE_URL` centralisée ; toute lib vérifiée contre la version PHP commune avant adoption.

## 2. Structure de dossiers de référence (`CONFIRMÉ MP` §29)

```text
SIRH/
├── app/{Controllers,Models,Services,Repositories,Middleware,Validators,Views}
├── config/{app.example.php,database.example.php}
├── public/{index.php,.htaccess,assets/{css,js,images}}
├── routes/web.php
├── database/{schema.sql,migrations/,seeders/}
├── storage/{uploads,exports,logs,backups}
├── tests/{unit,integration,acceptance}
├── docs/ · vendor/ · .env.example · .gitignore · composer.json/lock · README.md
```

- Seul `public/` est exposé par Apache ; `app/`, `config/`, `database/`, `storage/`, `tests/` inaccessibles en HTTP (T-35). Si racine projet au lieu de `public/` : règles Apache strictes + test obligatoire.
- CV/documents/exports/logs/sauvegardes **hors DocumentRoot**, servis par contrôleur PHP après vérification session+permission.
- Config locale (hôte, base, user, mdp, BASE_URL) ignorée par Git ; dépôt = exemples sans secret ; jamais `vendor/`, logs, dumps, CV dans Git.

## 3. Flux d'exécution MVC (`PROPOSITION`, conforme aux couches imposées)

```
Requête → public/index.php (front controller)
 → Router (routes/web.php, correspondance méthode+chemin)
 → Middleware chaîne : Session|Auth|RBAC(permission)|CSRF(POST)|Throttle
 → Controller (validation des entrées via Validators, orchestration)
 → Service (logique métier : ScoringService, PipelineService, ExportService…)
 → Repository (PDO préparé, transactions) → MySQL sirh
 → View (template PHP, échappement systématique) + layout Bootstrap
 → Réponse HTML ou JSON (AJAX)
```

Règles : logique métier hors des vues ; SQL uniquement dans Repositories/Services ; aucune requête dans les Views ; chaque action critique a un résultat vérifiable en base (pas de décoratif).

## 4. Routage et conventions (`PROPOSITION`)

- URLs propres via `.htaccess` rewrite vers `index.php` ; schéma `/{module}/{action}` et ressources `GET /offres`, `POST /offres`, `GET /offres/{id}/candidatures`…
- Portail local sans auth : `/`, `/offres`, `/offres/{reference}`, `/candidature` (POST), `/confirmation/{numero}` , `/confidentialite`.
- Espace RH derrière `/auth/login` ; Admin derrière `/admin/...` (permission serveur, T-21).
- Conventions code : PSR-12 ; namespaces `App\...` chargés par Composer autoload ; contrôleurs maigres, services épaissis ; un repository par agrégat ; erreurs utilisateur génériques + détails techniques en log protégé (`display_errors=Off` en prod locale).
- AJAX : endpoints JSON sous `/api/...` avec mêmes middlewares RBAC/CSRF que les routes HTML ; contrats documentés avant usage (cf. `docs/ANALYSE/CONTRATS_API_PROPOSES.md` à produire en Phase 01 seulement si retenu).

## 5. Gestion des sessions et sécurité applicative intégrée

Sessions PHP durcies : cookies `HttpOnly`, `SameSite` (Strict/Lax à trancher), `Secure` si HTTPS local configuré ; régénération d'ID après login et changement de privilèges ; destruction à la déconnexion/désactivation/révocation ; table `sessions` pour révocation multi-périphérique (`CONFIRMÉ MP` §32, §33). Détails : `11_SECURITE_ET_CONFORMITE_09-08.md`.

## 6. Configuration et environnement

- `.env` local (ignoré) + `config/*.example.php` versionnés ; valeurs lues via une classe `Config` centralisée.
- Fuseau par défaut Africa/Casablanca ; dates stockées UTC, affichées selon fuseau utilisateur/organisation ; formats date/nombre configurables (`CONFIRMÉ MP` §24.5).
- Limites upload cohérentes : `upload_max_filesize`, `post_max_size`, `memory_limit`, `max_execution_time` relevées sur chaque poste puis alignées (Phase 01).

## 7. Tests et qualité

- `tests/unit` (règles de scoring, validateurs, neutralisation formules Excel), `tests/integration` (repositories, RBAC), `tests/acceptance` (scénarios T-01→T-35 pilotés par M1). Framework de test PHP à choisir parmi les compatibilités WampServer validées (PROPOSITION ; ex. PHPUnit selon version PHP retenue).
- Page de test commune (connexion MySQL + affichage versions) devant passer sur les 5 PC avant toute fonctionnalité (`CONFIRMÉ MP` §27).

## 8. Installation cible (résumé procédure MP §28 — exécutée en Phase 01, pas maintenant)

Vérifier prérequis et sauvegarder configs existantes → installer/vérifier WampServer sans écraser les autres projets → démarrer Apache/MySQL, versions communes → extensions PHP et limites upload → Git/VS Code/Composer → dossier `C:\wamp64\www\SIRH\` séparé → VirtualHost servant `public/` (ou URL sous-dossier documentée) → base `sirh` `utf8mb4` sans toucher les autres bases → config locale ignorée Git → `composer install` depuis lock → migrations ordonnées → seeders fictifs → comptes démo sécurisés → tests de démarrage localhost. LAN : désactivé par défaut, temporaire et contrôlé si demandé (D-06). Jamais de port forwarding ni exposition Internet.

## 9. Sauvegardes locales

Export SQL `sirh` + copie cohérente de `storage/` dans un emplacement non HTTP, hors Git ; fréquence/rétention/nommage/responsable définis ; ne pas écraser la dernière sauvegarde valide avant vérification de la nouvelle ; restauration testée sur base séparée (T-28/T-34) ; chiffrement des sauvegardes contenant des données personnelles si usage réel (`CONFIRMÉ MP` §24.18, §32).

## 10. Décision attendue (blocages Phase 01)

- Relevé des versions réelles sur les 5 PC (aucune valeur supposée) → D-05/D-01b.
- Arbitrage bibliothèque PDF après test comparatif (accents français, RTL, tableaux multipages, performance) → D-04b.
- Choix graphique local (Chart.js auto-hébergé vs rendu serveur vs simple) compatible T-31 hors Internet → D-17.
