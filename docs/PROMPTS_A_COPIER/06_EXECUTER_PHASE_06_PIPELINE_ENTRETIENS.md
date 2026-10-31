# PROMPT 06 — Pipeline, entretiens et évaluations

**À utiliser uniquement après validation écrite de la phase précédente.**

## Prompt prêt à copier dans Qwen Coder

```text
Tu travailles dans le dépôt local SIRH déjà relié à GitHub. Le produit est un ATS pédagogique local pour Digital Maroc Solutions. L'application doit tourner sous Windows + WampServer/Apache + PHP MVC personnalisé + MySQL/MariaDB. Elle n'est pas hébergée sur Internet.

Commence par lire QWEN.md et AGENTS.md à la racine, puis docs/00_LIRE_EN_PREMIER.md, docs/01_REGLES_ET_SOURCE_DE_VERITE.md et docs/DECISIONS_A_VALIDER.md. Lis ensuite le rapport validé de la phase précédente s'il existe, puis uniquement la spécification suivante : docs/PHASES/PHASE_06_PIPELINE_ENTRETIENS_EVALUATIONS.md. Ne charge pas toutes les autres phases ni l'archive complète.

EXÉCUTE EXCLUSIVEMENT : Pipeline, entretiens et évaluations.

Avant tout changement :
1. Affiche `git status --short --branch`, identifie la branche et les changements non commités. Ne divulgue pas de secrets.
2. Inspecte les fichiers et fonctionnalités déjà présents ; réutilise ce qui est correct.
3. Résume les dépendances, tables, routes, permissions et conventions existantes touchées.
4. Présente un plan limité aux fichiers de cette phase. Attends mon accord si un changement transversal, risqué ou non couvert par la décision approuvée est nécessaire.

Travaux de cette phase :

- Construire le Kanban des candidatures avec les étapes configurées dans l’application et les états de référence du cahier des charges.
- Gérer transitions autorisées, motif si nécessaire, responsable, commentaire, date/auteur et historique non altérable par l’utilisateur standard.
- Permettre filtres par offre, responsable, statut et recherche ; drag-and-drop seulement si la mise à jour serveur est confirmée.
- Planifier les entretiens : date/heure, type, lieu/lien local ou externe selon disponibilité, participants, responsable et rappel.
- Créer grilles d’évaluation paramétrables (échelle 1–5), notes, points forts, points à vérifier, recommandation et décision RH distincte du score automatique.
- La vidéo différée réelle reste Bonus ; ne pas enregistrer de vidéo en MVP.

Livrables et critères de sortie obligatoires :

- [ ] Pipeline réellement persistant
- [ ] Transitions et historique auditables
- [ ] Entretiens et évaluations fonctionnels
- [ ] Contrôle de conflit horaire testé
- [ ] Tests T-12/T-13 et rapport Phase 06

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
3. Remplis `docs/TEMPLATES/RAPPORT_FIN_PHASE.md` dans un rapport `docs/RAPPORTS_PHASES/PHASE_06.md`.
4. Donne le statut de chaque critère : VALIDÉ / NON VALIDÉ / BLOQUÉ.
5. ARRÊTE-TOI. N'exécute pas la phase suivante. Attends ma validation explicite.

Ne commit/push/merge rien. Je déciderai séparément quand les changements seront prêts à être versionnés.
```

## Notes pour l'utilisateur
- Ce prompt correspond à une seule phase. Ne le mélange pas avec un autre prompt.
- Pour la phase suivante, attends le rapport, vérifie le résultat puis colle le prompt suivant.
