# PHASE 04 — CANDIDATS, DOCUMENTS ET CANDIDATURES

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Créer les dossiers candidats, les candidatures liées à une offre, la gestion documentaire locale et les fonctions de recherche. Le parsing avancé reste optionnel si sa faisabilité n’est pas confirmée.

## Tâches à réaliser dans l’ordre

1. Développer les fiches candidats et sections identité, formation, expérience, compétences, langues et historique.

2. Développer l’upload et la consultation sécurisée des CV et documents fictifs.

3. Valider type réel, taille, nom interne, droits et stockage privé des fichiers.

4. Séparer le profil candidat de chaque candidature : un candidat peut postuler à plusieurs offres.

5. Développer recherche multicritère, filtres combinables, tri, pagination, favoris et étiquettes.

6. Détecter les doublons possibles sans fusion irréversible automatique.

7. Développer la timeline et l’affectation d’une candidature à un recruteur.

8. Ajouter parsing et import massif seulement si validés, avec contrôle humain des extractions.

## Références fonctionnelles et techniques à respecter

## 15. Gestion des candidats

### Fiche candidat

**Identité et contact :** nom, prénom, e-mail, téléphone, ville et liens professionnels facultatifs.

**Formation :** diplôme, spécialité, établissement, année et niveau. Ne jamais déduire un diplôme qui n'est pas renseigné.

**Expérience :** poste, employeur, dates, missions et durée calculée si les dates sont disponibles. Éviter le double comptage de périodes qui se chevauchent.

**Compétences :** compétences normalisées, niveau si justifié et provenance de l'information.

**Langues :** langue et niveau documenté. Distinguer « non renseigné » de « niveau insuffisant ».

**Pièces jointes :** CV original, portfolio et documents autorisés.

**Traçabilité :** date de création, origine, information/consentement, mises à jour et historique.

### Fonctions de recherche et de qualité

- Recherche par nom, e-mail, référence, compétence ou offre.
- Filtres combinables : statut, ville, formation, expérience, date, recruteur et score.
- Tri par date, nom, score ou étape.
- Pagination pour les volumes importants.
- Détection d'un e-mail déjà utilisé et suggestion de doublon.
- Aucune fusion irréversible automatique.
- Favoris et étiquettes sans modification du score.
- Notes internes séparées des informations visibles au candidat.
- Archivage et suppression contrôlée selon le rôle et les règles de conservation.

Un même candidat peut répondre à plusieurs offres. Le profil candidat est séparé de ses candidatures.


## 16. Importation des CV et parsing

Le parsing avancé est une fonction utile mais non obligatoire pour le premier prototype. **L'upload du CV et la saisie manuelle vérifiée sont prioritaires.**

### Parcours cible

1. **Dépôt :** accepter les formats autorisés, afficher le nom et la taille.
2. **Contrôle :** vérifier extension, type réel/MIME, taille, nom interne sûr ; stocker dans un espace non public.
3. **Extraction :** extraire le texte et détecter, si possible, coordonnées, formations, dates et compétences.
4. **Préremplissage :** proposer des champs avec provenance et niveau de confiance si disponible.
5. **Vérification :** RH corrige ou confirme chaque donnée avant tout scoring sensible.
6. **Historique :** conserver le fichier original et l'horodatage de traitement ; supprimer les fichiers temporaires selon la politique.

Gérer les erreurs : format non autorisé, fichier trop volumineux, nom invalide, fichier suspect, échec d'analyse, accès refusé, PDF scanné, langue non prise en charge, mise en page complexe, champ incertain ou contradiction.

Ne jamais enregistrer comme certaine une extraction erronée. Ne jamais inventer des informations absentes du CV.

### Import massif

Si l'import de masse est développé :

- Prévisualiser le nombre de lignes/fichiers avant import.
- Afficher un rapport : créés, ignorés, doublons possibles et erreurs.
- Permettre le téléchargement d'un fichier d'erreurs sans exposer les données à des utilisateurs non autorisés.
- Ne rejeter silencieusement aucune ligne incorrecte ; expliquer la raison.
- Limiter la taille des lots et ne pas bloquer toute l'interface.


## 17. Candidatures

Une candidature (`application`) relie un candidat (`candidate`) à une offre (`job`). Elle conserve ses propres informations : source, date, statut, documents liés, affectation, notes, score et historique.

Fonctionnalités :

- Liste filtrable par offre, statut et date.
- Détail d'une candidature.
- Timeline des changements.
- Affectation à un recruteur.
- Scoring détaillé.
- Shortlist, décision et motif documentés.
- Commentaires et notes internes contrôlés par permissions.

Les informations du profil candidat restent séparées des informations propres à chaque candidature.


## Extrait du plan de réalisation d’origine

### Phase 4 - Candidats, documents et candidatures

- Fiches candidats.
- Formation, expériences, compétences et langues.
- Upload CV et documents en stockage local privé.
- Détection des doublons.
- Recherche, filtres, pagination et favoris.
- Liaison candidat/offre et historique de candidature.

Livrable : consulter et suivre les dossiers et candidatures avec droits corrects.


## Livrables obligatoires

- [ ] Gestion des candidats
- [ ] Gestion des candidatures
- [ ] Stockage local privé
- [ ] Recherche et filtres
- [ ] Historique et détection doublons
- [ ] Tests documents et autorisations

## Critère de sortie et règle d’arrêt

Les candidats et candidatures sont correctement séparés, les documents ne sont pas exposés publiquement, les doublons sont signalés et les droits sont respectés.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_04.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Spécification détaillée candidats, documents et candidatures

### Profil candidat
Identité, coordonnées, ville, liens professionnels facultatifs, formations (diplôme, spécialité, établissement, année, niveau), expériences (poste, employeur, dates, missions), compétences normalisées et provenance, langues/niveaux documentés, certifications/portfolio si autorisés, documents, source, dates et historique.

### Candidature distincte du candidat
Une candidature relie `candidate_id` et `job_offer_id`, avec source, date, statut, recruteur affecté, CV/version utilisé, score, notes internes, historique et décisions. Un même candidat peut postuler à plusieurs offres. Ne duplique pas sa fiche à chaque candidature.

### Recherche et gestion
Recherche par nom, email, référence, compétence, offre ; filtres combinables (offre, statut, date, ville, formation, expérience, recruteur, score) ; tri ; pagination ; favoris ; tags ; vues sauvegardées si préférence prévue ; notes internes restreintes ; détection de doublon par email ou signaux proches. Signaler les doublons sans fusion automatique irréversible.

### Documents
Stocker les CV en dehors du webroot. Générer un nom interne aléatoire ; conserver le nom original comme métadonnée ; vérifier extension ET MIME/type réel ; taille limite configurable ; bloquer les extensions à risque ; ne jamais exécuter un fichier ; servir via contrôleur qui contrôle l'accès ; protéger suppression/téléchargement par permission ; enregistrer audit lorsqu'approprié.

### Parsing
MVP : upload et saisie manuelle corrigée. Parsing automatique avancé PDF/DOCX est Bonus selon compatibilité des bibliothèques PHP locales. Toute extraction est une suggestion ; montrer provenance et incertitudes ; ne pas inventer les données ; validation humaine obligatoire avant utilisation dans le scoring.

### Import massif
Bonus. Prévisualisation ; rapport créés/ignorés/doublons/erreurs ; traitement par lots ; aucune ligne rejetée silencieusement ; téléchargement du rapport d'erreurs autorisé uniquement aux rôles appropriés.

### Critères de sortie additionnels
Candidate et Application séparés ; recherche et pagination ; doublon signalé ; document privé non accessible directement ; formulaire associé à l'offre correcte ; corrections manuelles traçables.


## Prompt exécutable — Phase 04

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_04_CANDIDATS_DOCUMENTS_CANDIDATURES.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 04 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
