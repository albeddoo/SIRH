# Sécurité, confidentialité et conformité (loi marocaine 09-08)

Sources : PDF §17 + MP V3 §32/§40 (`CONFIRMÉ PAR SOURCE` / `CONFIRMÉ MP`).

## 1. Menaces considérées comme prioritaires en contexte local pédagogique

Injection SQL ; accès non autorisé par URL directe (IDOR) ; XSS dans champs libres/commentaires ; CSRF sur formulaires d'état ; upload malveillant (extension déguisée, taille) ; fuite de CV par chemin HTTP direct ou dossier listable ; brute force de connexion ; sessions volées/non expirées ; secrets exposés (clés API, .env) ; logs contenant des données personnelles ; export Excel exécutant des formules ; suppression non tracée ; divergence entre ce qui est affiché (« envoyé ») et la réalité.

## 2. Contrôles minimaux exigés par la source

| Domaine | Contrôle | Test associé |
|---|---|---|
| Authentification | `password_hash()` robuste, jamais de mot de passe en clair ; limitation des tentatives/verrouillage progressif ; expiration de session configurée ; déconnexion effective | T-01 |
| Autorisation | permission vérifiée **côté serveur** pour chaque page, action, fichier, export ; portée (assigné/équipe/lié) respectée | T-02, T-12, T-21, T-26 |
| Base de données | requêtes préparées PDO uniquement ; validation serveur ; transactions sur opérations critiques | revue PR M3 |
| Formulaires | anti-CSRF sur POST ; échappement de sortie systématique (XSS) ; messages d'erreur non sensibles | contrôle transverse permanent (revue de code + revue sécurité ; pas d'ID de test officiel réservé — cf. note de complétude `12_MATRICE_TRACABILITE.md` §2) |
| Fichiers CV | taille/type réels vérifiés ; nom interne sûr ; stockage non public ; accès via contrôleur autorisé | T-05, T-06, T-26, T-35 |
| Audit | journalisation login critique, changement de rôle, modification de grille, changement de statut, suppression, export sensible | T-16, T-22 |
| Exports | permissions préalables ; réduction des colonnes au besoin ; neutralisation des valeurs Excel dangereuses | T-14, T-15 |
| Erreurs | aucune trace technique/chemin/secrets à l'utilisateur final ; détails en log protégé | revue |
| Sauvegarde | base+fichiers selon politique ; restauration périodiquement testée | T-28, T-34 |
| Réseau | localhost par défaut ; LAN seulement si demandé/temporaire/autorisé ; **aucun port forwarding/cloud/URL publique** | T-29, T-31 (décision D-06 pour le périmètre LAN) |

Compléments techniques (`PROPOSITION`) : cookies `HttpOnly`/`SameSite`, régénération d'ID de session après login/élévation ; en-têtes de sécurité basiques (X-Content-Type-Options, CSP simple) ; hachage des jetons de réinitialisation en base, durée limitée, à usage unique ; pas d'énumération d'e-mails en cas d'oubli de mot de passe ; dépendances suivies via `composer.lock` (audit manuel en l'absence de CI connectée).

## 3. Loi 09-08 (protection des données personnelles — Maroc)

Cadre : la loi 09-08 encadre la collecte et le traitement de données personnelles au Maroc ; les traitements doivent être déclarés/autorisés auprès de la **CNDP** selon leur nature ; principes : finalité déterminée, loyauté, minimisation, exactitude, conservation limitée, sécurité, droits des personnes (accès, rectification, opposition).

Application au SIRH (documentaire, proportionnée à un projet pédagogique local — toute mise en œuvre réelle devra être validée juridiquement) :

1. **Registre des traitements local** (§24.12) : finalité = gestion du recrutement ; catégories = identité/contact/profils/CV ; destinataires = rôles RH habilités ; durées = `retention_policies` (**D-19 ouverte**, à fixer avec l'encadrement).
2. **Information de la personne** : page « Politique de confidentialité et contact » du portail (exigence sitemap PDF) ; case d'information/consentement au dépôt de candidature ; `consent_records` horodatés.
3. **Minimisation** : collecter seulement les champs utiles au poste ; photo/genre/origine non requis et interdits comme critères de scoring (PDF §12).
4. **Exactitude/honnêteté** : données manquantes signalées « à vérifier », jamais converties en négatif définitif hors barème pédagogique assumé.
5. **Conservation/suppression** : archivage et suppression contrôlés par rôle + motif + politique (T-17) ; purge physique planifiée ; anonymisation possible pour statistiques.
6. **Droits d'accès/rectification** : parcours documenté (demande traitée manuellement au MVP ; portail candidat authentifié = amélioration Bonus).
7. **Sécurité** : table 2 ci-dessus ; sauvegardes chiffrées si données personnelles réelles ; pas de secrets/CV dans logs ni Git.
8. **Transferts** : aucun envoi vers service externe (cloud IA/e-mail) sans autorisation explicite et évaluation de conformité préalable — fournisseur désactivé par défaut (§24.15).
9. **Cas pédagogique** : données 100 % fictives → la démonstration de conformité porte sur les mécanismes, pas sur des données réelles ; ne pas assimiler les données fictives de test à des obligations réelles (principe de proportionnalité documenté — correction A-08 : la référence « D-09 », inexistante au registre `16_DECISIONS_EN_ATTENTE.md`, a été supprimée).

## 4. Équité algorithmique (exigence pédagogique explicite)

Le système doit rendre visibles : critères, poids, version de grille, données utilisées, données manquantes, règle de départage active, corrections manuelles (motif/auteur/date). Interdits : rejet automatique, biométrie/émotions, critères hors périmètre (photo, genre, origine). La décision finale reste humaine, justifiée et traçable.

## 5. Journal d'audit — spécification minimale

Append-only (pas d'édition UI) ; colonnes : utilisateur, action, objet (table+id), ancien/nouveau, IP locale, résultat, horodatage UTC ; filtres/export réservé rôle habilité ; exclusion stricte des mots de passe, tokens complets et contenus de CV ; rétention paramétrée.

## 6. Points en attente humains

Durées de conservation (D-19) ; déclaration CNDP pertinente ou non pour un usage réellement exploité (à confirmer avec l'encadrement — hors périmètre étudiant tant que données fictives) ; activation LAN (D-06) ; tout connecteur e-mail/IA externe (D-11/D-18).
