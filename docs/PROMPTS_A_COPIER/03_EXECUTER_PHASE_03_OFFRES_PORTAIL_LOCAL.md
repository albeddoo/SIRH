# PROMPT 03 — Offres d’emploi et portail candidat local

**À utiliser uniquement après validation écrite de la phase précédente.**

## Prompt prêt à copier dans Qwen Coder

```text
Tu travailles dans le dépôt local SIRH déjà relié à GitHub. Le produit est un ATS pédagogique local pour Digital Maroc Solutions. L'application doit tourner sous Windows + WampServer/Apache + PHP MVC personnalisé + MySQL/MariaDB. Elle n'est pas hébergée sur Internet.

Commence par lire QWEN.md et AGENTS.md à la racine, puis docs/00_LIRE_EN_PREMIER.md, docs/01_REGLES_ET_SOURCE_DE_VERITE.md et docs/DECISIONS_A_VALIDER.md. Lis ensuite le rapport validé de la phase précédente s'il existe, puis uniquement la spécification suivante : docs/PHASES/PHASE_03_OFFRES_ET_PORTAIL_CANDIDAT_LOCAL.md. Ne charge pas toutes les autres phases ni l'archive complète.

EXÉCUTE EXCLUSIVEMENT : Offres d’emploi et portail candidat local.

Avant tout changement :
1. Affiche `git status --short --branch`, identifie la branche et les changements non commités. Ne divulgue pas de secrets.
2. Inspecte les fichiers et fonctionnalités déjà présents ; réutilise ce qui est correct.
3. Résume les dépendances, tables, routes, permissions et conventions existantes touchées.
4. Présente un plan limité aux fichiers de cette phase. Attends mon accord si un changement transversal, risqué ou non couvert par la décision approuvée est nécessaire.

Travaux de cette phase :

- Construire CRUD des offres : champs, validations, dates, département, type de contrat, description, missions, profil, compétences, statut et historique.
- Gérer brouillon, publication locale, suspension, clôture et archivage ; empêcher les transitions incohérentes.
- Créer l’interface locale de consultation des offres actives et le formulaire local de candidature selon le cahier des charges.
- Prévoir questions de présélection, date limite, nombre de postes et règles de candidature paramétrables.
- Ne pas créer de site Internet public ni multidiffusion externe ; les plateformes externes sont hors MVP sans API officielle autorisée.
- Vérifier validation serveur, protection CSRF, contrôle d’accès et affichage Bootstrap responsive.

Livrables et critères de sortie obligatoires :

- [ ] CRUD complet des offres
- [ ] Cycle de vie et historique cohérents
- [ ] Portail/formulaire de candidature local fonctionnel
- [ ] Validations serveur et tests T-03/T-04
- [ ] Rapport Phase 03

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
3. Remplis `docs/TEMPLATES/RAPPORT_FIN_PHASE.md` dans un rapport `docs/RAPPORTS_PHASES/PHASE_03.md`.
4. Donne le statut de chaque critère : VALIDÉ / NON VALIDÉ / BLOQUÉ.
5. ARRÊTE-TOI. N'exécute pas la phase suivante. Attends ma validation explicite.

Ne commit/push/merge rien. Je déciderai séparément quand les changements seront prêts à être versionnés.
```

## Notes pour l'utilisateur
- Ce prompt correspond à une seule phase. Ne le mélange pas avec un autre prompt.
- Pour la phase suivante, attends le rapport, vérifie le résultat puis colle le prompt suivant.
