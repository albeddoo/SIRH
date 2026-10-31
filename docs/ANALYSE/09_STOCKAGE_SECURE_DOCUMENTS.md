# Stratégie de stockage sécurisé des CV et documents

Sources : MP V3 §31 + PDF §7/§8/§17 (`CONFIRMÉ PAR SOURCE` / `CONFIRMÉ MP`). Conception uniquement — aucune implémentation en Phase 00.

## 1. Principe cardinal

Aucun fichier utilisateur (CV, pièce jointe, export, sauvegarde, log) n'est accessible directement par URL. Tout accès passe par un contrôleur PHP qui vérifie **session valide + permission explicite + portée sur l'objet** avant de servir le contenu.

## 2. Emplacements

| Contenu | Emplacement | HTTP | Git |
|---|---|---|---|
| CV / pièces jointes candidats | `storage/uploads/…` | hors DocumentRoot | ignoré (`.gitignore`, hors `.gitkeep`) |
| Exports générés | `storage/exports/…` | hors DocumentRoot | ignoré |
| Logs applicatifs | `storage/logs/…` | hors DocumentRoot | ignoré |
| Sauvegardes SQL/copies storage | `storage/backups/…` ou emplacement externe local | hors DocumentRoot | jamais |
| Assets légitimes (CSS/JS/images UI, logo entreprise après contrôle) | `public/assets`, `public/images` | servis | versionnés |

Si l'hébergement se fait à la racine du projet au lieu de `public/` : règles Apache restrictives explicites + test T-35 obligatoire (MP §31).

## 3. Cycle de vie d'un dépôt (upload)

1. Formulaire : affichage nom/taille acceptés ; limites serveur alignées (`upload_max_filesize`, `post_max_size`, `memory_limit`, temps exécution relevés sur chaque poste).
2. Contrôles serveur : taille max configurable ; liste extensions autorisées **ET vérification du type réel/MIME côté serveur** (pas la seule extension déclarée par le navigateur) ; fichiers PHP/exécutables refusés (T-06/T-29).
3. Écriture : nom interne **aléatoire cryptographique** sans dépendre du nom fourni ; dossier de destination non exécutable (permissions Apache « pas de handler ») ; écriture hors DocumentRoot ; checksum SHA-256 calculé.
4. Métadonnées en base (`storage_objects` + `candidate_documents`) : nom original conservé comme libellé affiché, taille, MIME réel, propriétaire, entité liée, date/auteur, statut (actif/archivé/supprimé/anonymisé).
5. Échec : message compréhensible, aucun fichier partiel conservé, journalisation technique sans secret.

## 4. Lecture / téléchargement

- Route dédiée `GET /documents/{id}/telecharger` (nom logique, pas de chemin physique en dur dans l'URL) ; middleware Auth + RBAC (`cv.download`, portée recruteur assigné/dossier lié…) ; réponse streaming avec en-têtes appropriés ; **chaque accès sensible est audité** (MP §31, T-26).
- Refus : 403 serveur (pas de redirection décorative), audit, message générique.
- Anti-énumération : identifiants non séquentiels préférentiellement (UUID/hachés) — PROPOSITION à valider techniquement en Phase 01.

## 5. Durées, archivage, suppression (loi 09-08 — voir `11_...`)

- Politique de conservation paramétrable par catégorie (`retention_policies`) — durées à fixer avec l'encadrement (**D-19 ouverte**).
- Suppression/archivage selon rôle + motif, tracés (T-17) ; suppression = retrait logique puis purge physique planifiée (anonymisation si traçabilité statistique requise) ; fichiers temporaires de parsing supprimés après traitement (PDF §8 étape 6).
- Comptes désactivés : leurs documents restent régis par la politique, jamais supprimés silencieusement.

## 6. Exports et logs

- Exports nominatifs : génération seulement après vérification des permissions au moment du clic ; fichier temporaire protégé, servi aux mêmes conditions que les CV ; historique `exports` (auteur, filtres, colonnes, format, date) ; mention de confidentialité ; neutralisation CSV-injection/formules (T-15).
- Logs : niveau configuré ; **jamais** mots de passe, secrets, tokens pleins, ni contenu de CV ; rotation locale simple.

## 7. Sauvegardes

Export SQL `sirh` + copie cohérente de `storage/` (uploads+exports utiles) vers emplacement hors HTTP et hors Git ; chiffrement recommandé si données personnelles réelles ; rétention/fréquence/nommage/responsable définis au paramétrage ; ne pas écraser la dernière sauvegarde valide avant vérification de la nouvelle ; restauration testée sur base séparée (T-28/T-34).

## 8. Vidéos différées (si activées plus tard — D-12)

Stockage chiffré au repos, durée de conservation courte définie, information claire du candidat, suppression planifiée, restriction stricte d'accès ; interdits permanents : analyse d'émotions/faciale/personnalité.

## 9. Vérifications prévues (Phase 01+)

Test direct des URLs interdites (T-35) ; upload fichier déguisé .php→refus (T-29) ; gros fichier→rejet propre (T-06) ; accès croisé entre rôles (T-26) ; intégrité après restauration (T-34).
