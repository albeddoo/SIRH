# PHASE 07 — COMMUNICATIONS ET NOTIFICATIONS

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Créer les modèles et journaux de communication ainsi que les notifications internes. L’envoi réel d’emails est optionnel et ne doit jamais être simulé comme s’il avait réussi.

## Tâches à réaliser dans l’ordre

1. Créer les modèles d’accusé de réception, invitation, rappel, refus et offre.

2. Développer la prévisualisation et la personnalisation des messages.

3. Créer les notifications internes persistantes et leurs états de lecture.

4. Créer les journaux de communication avec destinataire, modèle, date, statut et initiateur.

5. Implémenter le mode simulation local par défaut.

6. Ajouter SMTP uniquement après configuration explicite et test réel.

## Références fonctionnelles et techniques à respecter

## 22. Communications et notifications

Prévoir :

- Modèles d'e-mails.
- Accusé de réception.
- Invitation et rappel d'entretien.
- Message de refus.
- Message d'offre.
- Historique des communications.
- Centre de notifications internes.

Événements : nouvelle candidature, entretien planifié, rappel, décision enregistrée, échec d'envoi.

Contrôles :

- Éviter l'envoi multiple si la candidature est modifiée.
- Utiliser le bon fuseau horaire.
- Inclure les informations d'annulation/reprogrammation si prévues.
- Rendre la fréquence des rappels configurable.
- Prévisualiser le message avant envoi lorsque nécessaire.
- En cas d'échec, afficher « échec » ; ne jamais afficher « envoyé » si le service a échoué.
- Sans fournisseur e-mail configuré, utiliser un aperçu et un journal de simulation clairement identifiés.


## Extrait du plan de réalisation d’origine

### Phase 7 - Communications et notifications

- Templates d'accusé de réception, invitation, rappel, refus et offre.
- Prévisualisation et simulation locale par défaut.
- SMTP facultatif si explicitement configuré.
- Notifications internes et journal de communication.

Livrable : communication traçable sans fausse confirmation d'envoi.


## Livrables obligatoires

- [ ] Templates personnalisables
- [ ] Notifications internes
- [ ] Preview emails
- [ ] Communication Logs
- [ ] Tests simulation/envoi réel

## Critère de sortie et règle d’arrêt

Aucun message n’est déclaré envoyé sans confirmation technique réelle. Les notifications internes et historiques sont persistants et protégés.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_07.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Spécification communication et notifications

### Modèles requis
Accusé de réception ; invitation à entretien ; confirmation ; rappel ; demande de complément si retenue ; message de refus ; message d'offre. Variables autorisées telles que nom candidat, intitulé de poste, date/heure et coordonnées de l'organisation. Échapper les variables insérées et vérifier qu'elles existent.

### Aperçu / simulation
En local, fournir un aperçu rendu du message avec destinataire, objet et contenu. Créer un log marqué `simulation` si aucun SMTP n'est configuré. Ne jamais marquer `sent` si le fournisseur n'a pas confirmé l'envoi.

### SMTP optionnel
Configuration explicite par admin ; secrets hors dépôt ; test de connexion/envoi ; erreurs détaillées sans exposer secrets ; consentement et conformité contrôlés avant envoi réel ; limiter les doubles envois ; journaliser l'état.

### Notifications internes
Événements : nouvelle candidature, changement d'étape, entretien planifié/modifié/annulé, évaluation attendue, décision RH, échec d'envoi. États non lue/lue/archivée ; lien interne sécurisé ; préférences personnelles par utilisateur ; fréquence configurable ; accès vérifié.

### Historique
Destinataire, candidat/candidature, offre, modèle/version, auteur, date, canal, statut, erreur technique non sensible. Ne pas conserver inutilement les secrets ou les pièces jointes sensibles dans le log.

### Critères de sortie additionnels
Templates variables et aperçu corrects ; notifications persistantes et propres à l'utilisateur ; simulation explicitement étiquetée ; SMTP indisponible ne bloque pas le cœur du SIRH.


## Prompt exécutable — Phase 07

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_07_COMMUNICATIONS_NOTIFICATIONS.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 07 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
