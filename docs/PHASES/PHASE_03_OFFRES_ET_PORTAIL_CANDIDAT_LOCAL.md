# PHASE 03 — OFFRES D’EMPLOI ET PORTAIL CANDIDAT LOCAL

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Créer la gestion des offres et un parcours de candidature local complet, sans publication Internet ni multidiffusion fictive.

## Tâches à réaliser dans l’ordre

1. Développer le CRUD des offres, les champs, validations, références et responsables.

2. Implémenter les statuts brouillon, validation, publication locale, suspension, clôture et archivage.

3. Développer la liste locale des offres et leurs pages de détail.

4. Développer le formulaire local de candidature et son accusé de réception en mode simulation si aucun email n’est configuré.

5. Créer les référentiels nécessaires et protéger les actions selon les rôles.

6. Prévoir l’export manuel du texte d’annonce ; ne pas prétendre publier automatiquement sur LinkedIn, Indeed ou Rekrute sans intégration autorisée.

## Références fonctionnelles et techniques à respecter

## 12. Portail candidat local

Créer une page d'accueil locale et un mini-portail de candidature accessible depuis l'installation WampServer, par exemple via `http://localhost/SIRH/public/` ou un Virtual Host local documenté.

Pages prévues :

- Accueil et présentation de SIRH / Digital Maroc Solutions.
- Liste des offres ouvertes dans l'environnement local.
- Détail d'une offre.
- Formulaire de candidature.
- Confirmation et numéro de candidature.
- Politique de confidentialité et contact.

Le terme « portail public » désigne ici une page accessible sans connexion RH **sur l'instance locale**. Il ne signifie pas que le site est accessible depuis Internet. Le dépôt de candidature doit fonctionner sans compte candidat pour le MVP, dans les limites de l'installation locale.

Le formulaire doit valider les champs, contrôler les fichiers, présenter les erreurs et enregistrer la candidature sans double soumission accidentelle.

Comme l'application n'est pas hébergée sur Internet, les candidats externes ne peuvent pas déposer une candidature à distance. Cette limite doit être clairement indiquée dans la documentation et pendant la démonstration. Un accès depuis le réseau local ne peut être activé que pour une démonstration interne contrôlée.


## 14. Gestion des offres d'emploi

### Champs de la fiche de poste

**Identification :** référence, titre, entreprise, département, responsable recruteur. La référence est unique et peut être générée automatiquement.

**Présentation :** résumé, missions, responsabilités, contexte et avantages.

**Exigences :** formation minimale, domaine, expérience, compétences obligatoires et souhaitées.

**Conditions :** ville, type de contrat, temps de travail, date de publication, date de clôture et nombre de postes.

**Scoring :** modèle de grille associé, critères et poids.

**Publication :** brouillon, à valider, publiée, suspendue, clôturée, archivée.

Séparer les exigences impératives des atouts souhaités. Éviter les exigences non nécessaires.

### Actions

- Créer une offre à partir d'un formulaire ou d'un modèle.
- Prévisualiser avant publication.
- Dupliquer une offre en créant une nouvelle référence.
- Publier, suspendre, reprendre, clôturer et archiver selon permissions.
- Voir les candidatures rattachées, les volumes par étape et les délais.
- Exporter la fiche de poste ou le rapport associé.

Toute transition de statut doit être autorisée selon le rôle et enregistrée.

### Diffusion externe

Prévoir une architecture de connecteurs pour le site carrière, LinkedIn, Indeed et Rekrute. Aucune publication automatique ne doit être simulée. Sans API officielle, autorisation et identifiants valides, fournir un texte exportable et une procédure de publication manuelle.


## Extrait du plan de réalisation d’origine

### Phase 3 - Offres et portail candidat local

- CRUD des offres.
- Modèles, validation et publication locale.
- Liste locale des offres et détail.
- Formulaire de candidature local.
- Référentiels de départements, villes et contrats.

Livrable : créer une offre et recevoir une candidature sur localhost.


## Livrables obligatoires

- [ ] CRUD offres
- [ ] Liste et détail des offres locales
- [ ] Formulaire local de candidature
- [ ] Référentiels nécessaires
- [ ] Tests création/publication/candidature

## Critère de sortie et règle d’arrêt

Un utilisateur autorisé peut créer et publier une offre localement, et une candidature de test est enregistrée en base et reliée à la bonne offre.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_03.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Spécification détaillée des offres

### Données d'une offre
Référence unique ; titre/intitulé ; entreprise ; département ; manager demandeur ; recruteur responsable ; résumé ; contexte ; missions ; responsabilités ; avantages ; formation ; expérience minimale ; compétences obligatoires ; compétences souhaitées ; langues ; ville ; type de contrat ; temps de travail ; date de publication ; date limite ; nombre de postes ; modèle de scoring associé ; statut ; auteur ; timestamps.

### États d'une offre
Brouillon → à valider → publiée localement → suspendue → clôturée → archivée. Valider les transitions et conserver un historique. Une offre archivée avec candidatures liées ne doit pas être supprimée physiquement sans procédure.

### Écrans
Liste filtrable/paginée ; création/édition ; détail avec sections ; aperçu avant publication ; liste des candidatures associées ; historique ; duplication avec nouvelle référence ; archivage/confirmation.

### Portail candidat local
Accueil ; liste des offres publiées ; détail ; formulaire ; confirmation avec référence de candidature ; notice de confidentialité. Le formulaire fonctionne en local et sans compte candidat pour le MVP. Mentionner dans l'aide que les personnes externes ne peuvent pas atteindre une instance `localhost` à distance.

### Validations
Champs obligatoires ; cohérence date début/fin ; nombre de postes positif ; compétences et critères référencés ; prévention double soumission ; protection CSRF ; validation email/téléphone ; upload contrôlé si document déposé.

### Diffusion externe
Aucune multidiffusion réelle ni faux badge « publié sur LinkedIn/Indeed/Rekrute ». Fournir une exportation du texte et une procédure manuelle. Connecteurs réels hors MVP et soumis à API/autorisation.

### Critères de sortie additionnels
Un utilisateur autorisé crée une offre, la fait valider, la publie sur le portail local, la suspend/clôture et garde l'historique. Une candidature fictive peut être reçue et liée à l'offre.


## Prompt exécutable — Phase 03

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_03_OFFRES_ET_PORTAIL_LOCAL.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 03 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
