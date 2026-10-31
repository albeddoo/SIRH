# PHASE 05 — MATCHING, SCORING, PRÉSÉLECTION ET IA

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Construire un moteur de scoring paramétrable et explicable. Le calcul de référence doit fonctionner localement sans API externe. L’IA ne prend jamais la décision finale.

## Tâches à réaliser dans l’ordre

1. Créer les modèles de scoring, critères, poids, règles, synonymes, seuils et versions en base.

2. Implémenter le barème pédagogique sur 100 points et vérifier que la somme des poids est cohérente.

3. Afficher Oui, Non observé, À vérifier et Non applicable lorsque la règle le prévoit.

4. Implémenter le matching explicable local et documenter séparément NLP et éventuel LLM.

5. Afficher le détail de chaque score, les éléments manquants et la version de grille utilisée.

6. Développer shortlist, comparaison et exception manuelle avec motif et audit.

7. Traiter explicitement l’égalité Amine/Youssef : règle active annoncée avant calcul ou maintien de l’égalité et revue humaine.

8. Tester exactement Nadia, Salma, Amine, Youssef et Imane.

## Références fonctionnelles et techniques à respecter

## 18. Matching et scoring explicable

### Principe

Le score rapproche les informations documentées d'un candidat des exigences d'une offre. Les critères, poids, règles et seuils doivent être visibles, configurables et versionnés. Le score aide au tri ; il ne prédit pas avec certitude la réussite future.

### Grille pédagogique sur 100 points

| Critère | Maximum | Règle du cas |
|---|---:|---|
| Formation liée au poste | 20 | Domaine pertinent : 20 ; autre domaine : 0. |
| Expérience | 20 | 1 an ou plus : 20 ; 6 à 11 mois : 10 ; moins de 6 mois : 0. |
| SEO | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Réseaux sociaux | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Google Analytics | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Excel | 10 | Compétence documentée : 10 ; sinon 0 dans cet exercice. |
| Français professionnel | 10 | Mentionné : 10 ; non documenté : 0 pour le cas pédagogique. |
| Canva et CRM | 10 | 5 points par outil maîtrisé. |

La somme des poids doit être égale à 100, ou une autre échelle doit être explicitement configurée et affichée. Les règles, poids, synonymes, seuils et priorités de départage ne doivent pas être codés en dur.

### Traitement des données manquantes

Dans l'exercice pédagogique, le français non documenté vaut 0 conformément au tableau fourni. Dans une candidature réelle, l'interface doit afficher distinctement :

- Oui / documenté.
- Non observé.
- À vérifier.
- Non applicable, si la règle le prévoit.

Une information absente ne doit pas automatiquement être interprétée comme une compétence absente. Afficher les champs manquants et leur impact sur le score.

### Résultats de référence

| Candidat | Formation /20 | Exp. /20 | Compétences /40 | Français /10 | Atouts /10 | Total /100 |
|---|---:|---:|---:|---:|---:|---:|
| Nadia | 20 | 20 | 40 | 0 | 10 | **90** |
| Salma | 20 | 20 | 40 | 0 | 5 | **85** |
| Amine | 20 | 10 | 40 | 0 | 0 | **70** |
| Youssef | 20 | 20 | 20 | 0 | 10 | **70** |
| Imane | 0 | 20 | 10 | 0 | 5 | **35** |

Hypothèses de calcul : la formation en finance d'Imane n'est pas considérée comme directement liée au poste ; les quatre compétences clés valent 10 points chacune ; le français professionnel n'est pas documenté dans les cinq profils et vaut donc 0 pour ce cas ; Canva et CRM valent 5 points chacun.

### Égalité Amine / Youssef - décision à conserver visible

Le PDF propose de départager Amine et Youssef par la priorité accordée aux compétences clés : Amine obtient 40/40 contre 20/40 pour Youssef. La shortlist pédagogique proposée dans le PDF est donc **Nadia, Salma et Amine** si cette règle est annoncée avant le scoring.

Une note fournie auparavant par l'utilisateur proposait au contraire de placer Youssef avant Amine en privilégiant l'expérience puis les atouts. Il existe donc une divergence entre les deux versions. Ne la masque pas et ne change pas la règle silencieusement :

- rendre la priorité de départage configurable ;
- afficher la règle active avant le calcul ;
- présenter la règle « compétences clés » comme proposition par défaut du PDF ;
- demander une validation en Phase 0 si l'enseignant impose l'autre règle ;
- si aucune règle n'est validée, afficher l'égalité et demander une revue humaine au lieu d'inventer un classement.

### Paramètres du moteur de scoring

- Nom et version du modèle/grille.
- Offre ou famille de postes concernée.
- Liste des critères, description, poids et type : obligatoire, souhaité ou informatif.
- Règles de calcul et éventuelles équivalences contrôlées de termes.
- Règle de départage annoncée avant le calcul.
- Traitement des données manquantes.
- Seuil indicatif de revue manuelle, jamais un rejet final automatique.
- Détail du score, date, version de grille et utilisateur déclencheur.
- Possibilité de recalculer après changement des données, en conservant l'historique.

Toute correction manuelle d'un score ou d'un statut nécessite un motif, un auteur, une date et une ancienne/nouvelle valeur. Un résultat historique doit rester associé à la version de grille utilisée.

### Équité et limites

Démontrer au minimum les risques suivants :

- Mot-clé absent ou synonyme inconnu.
- CV incomplet ou format atypique.
- Biais de données historiques.
- Surpondération du diplôme ou du nombre d'années.
- Fausse précision : un score de 82/100 ne signifie pas 82 % de probabilité de réussite.
- Effet de seuil : un candidat juste sous le seuil n'est pas nécessairement dépourvu de potentiel.
- Données non comparables entre profils.

Mesures :

- Séparer « oui », « non observé » et « à vérifier ».
- Autoriser les synonymes et compétences équivalentes contrôlées.
- Afficher notes, champs utilisés et informations manquantes.
- Tester des profils fictifs variés.
- Tracer toute modification manuelle et demander son motif.
- Interdire les critères non pertinents comme photo, genre ou origine.
- Garder la décision finale humaine.

Phrase de démonstration à pouvoir expliquer : « Notre ATS automatise les tâches répétitives et rend les critères visibles, mais il ne remplace pas le jugement professionnel. Chaque score est explicable, contestable et soumis à une validation humaine. »


## 19. Shortlist et comparateur de profils

- Produire une liste de profils proposés selon la grille active.
- Afficher le score total, le détail par critère, les points forts et les informations à vérifier.
- Comparer plusieurs candidats dans une vue commune.
- Afficher la règle de départage appliquée.
- Permettre au Responsable RH de retenir, écarter ou revoir un profil avec motif documenté.
- Conserver l'historique des décisions et des exceptions.

Aucun candidat ne doit être rejeté définitivement par un filtre ou un seuil sans revue humaine prévue par les règles du projet.


## Extrait du plan de réalisation d’origine

### Phase 5 - Scoring, présélection et IA

- Modèles de scoring et versions.
- Critères configurables et poids.
- Synonymes contrôlés.
- Données manquantes et score détaillé.
- Shortlist et comparateur.
- Matching explicable local.
- CV Parsing avancé et assistant IA en Bonus selon faisabilité.

Livrable : reproduction correcte du barème pédagogique et justification de chaque score.


## Livrables obligatoires

- [ ] Moteur scoring versionné
- [ ] Matching local explicable
- [ ] Détail de score
- [ ] Configuration et synonymes
- [ ] Shortlist et comparateur
- [ ] Tests exacts des cinq profils

## Critère de sortie et règle d’arrêt

Les cinq scores de référence sont reproduits exactement. Aucun rejet ou recrutement automatique n’est effectué. La règle de départage est validée et visible.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_05.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## IA locale : limites et architecture exigées

### Niveaux à distinguer
1. **Règles déterministes :** calcul du score pédagogique, règles de seuil et départage.
2. **NLP local simple :** extraction de texte, normalisation, dictionnaire de synonymes approuvés, correspondance mots-clés.
3. **Modèle génératif local avancé (Bonus) :** seulement après validation de la faisabilité sur le matériel des PC. Ne pas télécharger/installer un modèle lourd sans accord.
4. **API cloud :** désactivée et hors fonctionnement normal ; aucun CV réel envoyé par défaut.

### Règles de matching
- L'offre possède ses exigences et son modèle de scoring versionné.
- Montrer pour chaque critère : valeur du candidat, source de l'information, règle appliquée, points attribués, maximum, manque/incertitude.
- Les synonymes sont un dictionnaire modifiable par un rôle autorisé, avec validation et audit.
- Analytics / Google Analytics est une équivalence à cadrer, non une supposition illimitée.
- Distinguer absence confirmée, non observé, non documenté et à vérifier.
- Un score n'est jamais une probabilité de réussite.

### Barème de référence
Formation 20 ; expérience 20 ; SEO 10 ; réseaux sociaux 10 ; Analytics/Google Analytics 10 ; Excel 10 ; français professionnel 10 ; Canva 5 ; CRM 5. Total = 100.

### Versioning
Chaque scoring model possède version, statut brouillon/validé/actif/archivé, critères, poids, règles, synonymes, départage et date d'effet. Les anciens résultats conservent la version calculée ; pas de recalcul silencieux.

### Cas de test exacts
Nadia 90 ; Salma 85 ; Amine 70 ; Youssef 70 ; Imane 35. Ne pas arranger l'ordre d'égalité sans règle approuvée. Le PDF propose priorité compétences clés (Amine avant Youssef) ; un texte utilisateur antérieur suggère priorité expérience (Youssef avant Amine). Le système doit rendre visible la règle active et autoriser revue humaine.

### Garde-fous
Pas de rejet/décision automatique ; pas de critères sensibles (photo, âge, genre, origine, handicap, émotions) ; exception humaine avec motif, auteur et date ; afficher limites, données manquantes et risque de mots-clés ; garder l'historique.

### Critères de sortie additionnels
Les scores exacts sont reproductibles depuis la version active ; détail affiché ; règle d'égalité visible ; aucune décision automatique ; tests de synonymes, champs manquants, score égal et modification versionnée exécutés.


## Prompt exécutable — Phase 05

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_05_IA_MATCHING_SCORING.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 05 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
