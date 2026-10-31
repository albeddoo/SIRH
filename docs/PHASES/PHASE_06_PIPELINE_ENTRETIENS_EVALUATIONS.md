# PHASE 06 — PIPELINE ET ENTRETIENS

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Relier le suivi des candidatures au pipeline de recrutement et à la planification des entretiens, avec historique et évaluations traçables.

## Tâches à réaliser dans l’ordre

1. Créer le Kanban avec les étapes configurées et les transitions autorisées.

2. Enregistrer chaque changement de statut dans un historique horodaté avec utilisateur et motif si requis.

3. Ajouter affectations, commentaires et notes internes avec permissions.

4. Développer la planification des entretiens, participants et vérification des conflits.

5. Développer les grilles d’évaluation et recommandations individuelles.

6. Prévoir une simulation vidéo différée uniquement si la fonction est validée ; ne pas présenter une simulation comme un vrai entretien vidéo.

## Références fonctionnelles et techniques à respecter

## 20. Pipeline de candidature et Kanban

### Étapes de référence

1. Nouvelle candidature.
2. À vérifier.
3. Présélection.
4. Entretien RH.
5. Entretien technique.
6. Offre envoyée.
7. Embauché.
8. Refusé / retiré / en attente.

Le modèle PDF décrit les objectifs et transitions autorisées :

- **Nouvelle candidature :** accuser réception, vérifier la complétude, voir le CV, signaler des données manquantes et affecter à un recruteur. Transitions : à vérifier, retirée, doublon à examiner.
- **À vérifier :** contrôler les critères de base et les informations extraites, compléter le profil, lancer le scoring, demander une clarification si autorisé. Transitions : présélection, attente, refus proposé.
- **Présélection :** comparer, annoter les points à vérifier et faire valider la shortlist. Transitions : entretien RH, attente, refus validé.
- **Entretien RH :** évaluer les motivations et la communication liées au poste, planifier les questions et enregistrer l'évaluation. Transitions : entretien technique, attente, refus validé.
- **Entretien technique :** vérifier les compétences métier avec questions ou épreuve pertinente. Transitions : offre envisagée, entretien complémentaire, refus validé.
- **Offre envoyée :** suivre la proposition, l'échéance et la réponse. Transitions : embauché, offre déclinée, délai expiré.
- **Embauché :** enregistrer la date et clôturer le parcours ; transfert éventuel vers un SIRH futur.
- **Refusé / retiré / en attente :** choisir un motif normalisé et préparer la communication autorisée. Réouverture seulement si rôle et politique le permettent.

### Comportement Kanban

- Glisser-déposer une carte uniquement si l'utilisateur a la permission de transition.
- Demander confirmation pour les transitions irréversibles ou importantes.
- Conserver ancien statut, nouveau statut, auteur, date et motif.
- Afficher le nombre de candidatures dans chaque colonne.
- Filtres par offre et recruteur.
- Fournir une vue tableau accessible en complément du Kanban.
- Ne jamais faire disparaître une candidature sans motif ni historique.


## 21. Entretiens et évaluations

### Planification

Chaque entretien comprend :

- Candidature, candidat, offre et étape du pipeline.
- Date, heure et durée.
- Responsable et participants.
- Type : présentiel, visioconférence ou entretien vidéo différé.
- Adresse ou lien de réunion, visible uniquement aux personnes concernées.
- Statut : à planifier, confirmé, réalisé, annulé, reprogrammé ou absent.
- Rappels et résultat.

Valider les formats de date/heure et détecter les conflits de calendrier. En cas de conflit, afficher une alerte et permettre de choisir un autre créneau.

### Grille d'évaluation

Échelle proposée de 1 à 5 :

- Compétences techniques.
- Communication professionnelle.
- Résolution de problèmes.
- Compréhension des missions.
- Motivation liée au poste.

Chaque note doit être reliée à une question ou une preuve observée lorsque possible. La recommandation est distincte du score CV : favorable, à approfondir ou défavorable. Une fiche distincte est conservée par évaluateur/entretien.

### Vidéo différée

Pour le MVP, une simulation suffit : questions, temps de préparation/réponse, statut de session et observations de l'équipe. Le stockage réel de vidéos est une extension séparée.

Si l'enregistrement réel est activé ultérieurement : information claire, consentement adapté, accès limité, durée de conservation définie, suppression planifiée. Aucune reconnaissance d'émotions, analyse faciale ou notation automatique de personnalité.


## Extrait du plan de réalisation d’origine

### Phase 6 - Pipeline et entretiens

- Kanban et transitions autorisées.
- Historique des statuts.
- Commentaires, affectations et notes.
- Planification d'entretiens.
- Participants et détection des conflits.
- Évaluations individuelles.
- Simulation vidéo différée.

Livrable : une candidature passe du dépôt à l'entretien avec un historique complet.


## Livrables obligatoires

- [ ] Kanban opérationnel
- [ ] Historique de transitions
- [ ] Affectations et commentaires
- [ ] Planification entretiens
- [ ] Évaluations individuelles
- [ ] Tests de workflow

## Critère de sortie et règle d’arrêt

Une candidature peut passer par les étapes autorisées, chaque changement est traçable et les évaluations sont liées au bon entretien et au bon candidat.

## Rapport à remettre avant de passer à la phase suivante

- Résumé des objectifs et tâches réalisées.

- Liste exacte des fichiers créés/modifiés.

- Migrations SQL/seeders ajoutés et leur ordre d’exécution.

- Tests réellement exécutés, commandes utilisées et résultats.

- Anomalies restantes, risques et limites.

- Décisions nécessitant une validation humaine.

- Tableau des critères de sortie : validé / non validé / bloqué.

- Ne commence pas la phase suivante avant que l’utilisateur valide ce rapport.


---

# Contrat d'exécution Qwen — obligatoire

## Avant de toucher au code
1. Exécuter `git status --short --branch` et relever la branche et les changements non commités.
2. Examiner la structure actuelle du dépôt et les fichiers concernés ; ne pas supposer que le projet est vide.
3. Lire `QWEN.md`, `AGENTS.md`, `docs/00_LIRE_EN_PREMIER.md`, `docs/01_REGLES_ET_SOURCE_DE_VERITE.md`, `docs/DECISIONS_A_VALIDER.md`, le rapport de phase précédent si disponible, puis ce seul fichier de phase.
4. Ne pas lire automatiquement tous les autres fichiers de phase ou l'archive de référence.
5. Identifier les dépendances et les contrats (tables, routes, permissions, conventions) existants avant d'en créer de nouveaux.

## Pendant cette phase
- Respecter le périmètre strict de cette phase.
- Réutiliser les composants existants lorsqu'ils sont corrects ; ne pas réécrire l'application pour convenance.
- Présenter un plan court des fichiers à créer/modifier avant un changement transversal ou risqué.
- Ne jamais supprimer les changements préexistants d'un membre.
- Ajouter les migrations avant de consommer les nouvelles colonnes/tables.
- Chaque action UI doit avoir un comportement réel, un contrôle côté serveur et un état d'erreur/succès cohérent.
- Tester après chaque sous-fonctionnalité importante.
- Ne pas créer de données personnelles réelles ; utiliser des profils fictifs.

## À la fin
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_06.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Spécification pipeline et entretiens

### Étapes de référence configurables
Nouvelle candidature ; À vérifier ; Présélection ; Entretien RH ; Entretien technique ; Offre envoyée ; Embauché ; Refusé ; Retiré ; En attente. Les états finaux et transitions doivent être paramétrés, pas codés dans l'interface.

### Transitions / audit
Pour chaque changement : ancien statut, nouveau statut, candidat/candidature, offre, date, utilisateur, motif si requis, commentaire éventuel. Vérifier permission et transition côté serveur. Confirmer les opérations importantes. Aucun dossier ne disparaît sans historique.

### Kanban
Drag/drop autorisé si droit ; comptage par colonne ; filtres offre/recruteur/période ; vue tableau accessible en alternative ; chargement/erreur/état vide ; actualiser correctement après réponse serveur.

### Entretiens
Candidature, candidat, offre, étape, date/heure/durée, type (présentiel/visioconférence/simulation différée), lieu ou lien privé, organisateur, participants, statut (à planifier, confirmé, réalisé, annulé, reprogrammé, absent), rappel et résultat. Détecter chevauchements d'un même participant et alerter.

### Évaluations
Échelle de 1 à 5 : compétences techniques, communication professionnelle, résolution de problèmes, compréhension des missions, motivation liée au poste. Chaque évaluateur possède sa propre fiche. Ajouter une preuve/commentaire lorsque possible. Recommandation distincte : favorable, à approfondir, défavorable. Ne pas fusionner avec score CV.

### Vidéo différée
MVP : simulation de questions et chronométrage/état de session sans enregistrement vidéo réel. Enregistrement réel = hors MVP, consentement, accès restreint, rétention et suppression à définir. Pas d'analyse faciale, émotionnelle ou personnalité automatique.

### Critères de sortie additionnels
Transitions interdites bloquées ; historique correct ; évaluations distinctes par évaluateur ; conflits horaires signalés ; manager/intervieweur voient uniquement les entretiens autorisés.


## Prompt exécutable — Phase 06

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_06_PIPELINE_ENTRETIENS_EVALUATIONS.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 06 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
