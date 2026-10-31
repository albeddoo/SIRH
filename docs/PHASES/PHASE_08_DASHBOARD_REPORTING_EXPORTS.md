# PHASE 08 — DASHBOARD, REPORTING, EXPORTS ET UX

> Projet SIRH local — PHP MVC / MySQL / WampServer. Fichier de travail autonome pour cette phase.

## Instruction de lecture

Lire `../00_LIRE_EN_PREMIER.md`, `../01_REGLES_ET_SOURCE_DE_VERITE.md`, puis ce fichier uniquement. Ne pas charger toutes les autres phases ni l’archive complète. Ne pas exécuter les phases suivantes. Respecter les règles communes du guide et les exigences détaillées ci-dessous. Si nécessaire, demander seulement le rapport de la phase précédente et les fichiers précis du projet utiles à la tâche.

## Objectif de la phase

Finaliser les indicateurs calculés depuis MySQL, les rapports filtrables, les exports configurables et la cohérence UX. Ne pas afficher de fausses statistiques en dehors de données de démonstration identifiées.

## Tâches à réaliser dans l’ordre

1. Développer les KPI du Dashboard RH avec définitions documentées.

2. Développer les rapports de volume, délais, sources, conversion, abandon et recrutements.

3. Ajouter filtres par période, offre, département, source et statut.

4. Développer PDF, Excel et CSV avec colonnes actives, filtres et modèles d’export.

5. Sécuriser les fichiers exportés, les formules Excel et les permissions.

6. Traiter les états vides, erreurs, chargement, succès et absence de données.

7. Vérifier l’accessibilité, la navigation clavier, les contrastes et le responsive.

## Références fonctionnelles et techniques à respecter

## 13. Dashboard RH

Afficher des KPI calculés à partir des données persistées :

- Candidatures reçues sur une période.
- Nombre de candidats à chaque étape du pipeline.
- Taux de passage à l'entretien.
- Délai de recrutement.
- Entretiens à venir.
- Sources de candidature.
- Offres actives.
- Offres converties en embauche.
- Activité récente et raccourcis.

### Définitions à rendre configurables/documentées

- **Candidatures reçues :** nombre de candidatures créées sur la période.
- **Candidats par étape :** nombre de candidatures actuellement dans chaque statut.
- **Taux de passage à l'entretien :** nombre ayant atteint une étape d'entretien / nombre de candidatures éligibles selon la règle choisie.
- **Délai de recrutement :** nombre de jours entre l'ouverture/publication du besoin et la décision ; la date de départ doit être définie clairement.
- **Entretiens à venir :** entretiens planifiés dans la période sélectionnée.
- **Sources :** répartition selon la source enregistrée.
- **Offres converties en embauche :** embauches finalisées selon une définition documentée.

Les graphiques doivent inclure les états vides. Une période sans données doit afficher zéro ou « aucune donnée », sans erreur serveur.


## 23. Rapports, tableaux de bord et exports PDF/Excel

### Rapports à fournir

- Tableau de bord analytique.
- Rapport par offre, période et recruteur.
- Rapport shortlist et scores.
- Rapport des entretiens.
- Rapport d'audit.
- Fiche candidat autorisée.

### Formats

PDF et XLSX prioritaires ; CSV en option.

### Paramètres dynamiques d'export

- Période, offre, département, recruteur, étape, statut, source et score minimal si autorisé.
- Sélecteur de colonnes et ordre des colonnes.
- Tri et regroupements.
- Titre du rapport, logo, nom de société, date de génération, auteur et filtres appliqués.
- Couleurs et style d'en-tête.
- Numéros de page, pied de page et commentaires de confidentialité.
- Inclusion/exclusion des notes, graphiques, totaux et résumés.
- Nom de fichier personnalisable avec variables telles que nom du rapport et date.
- Modèles d'export sauvegardés.
- Vérification des permissions avant génération et journalisation des exports sensibles.

### Exigences Excel

- Fichier XLSX avec en-têtes clairs et formats adaptés aux dates/nombres.
- Ne pas insérer de formules à partir de données utilisateur non fiables.
- Neutraliser les chaînes pouvant être interprétées comme formules.
- Feuille « Données » et, si utile, feuille « Résumé ».
- Respecter colonnes sélectionnées, filtres et tri.

### Exigences PDF

- Mise en page lisible, logo si configuré, date et filtres.
- Tableaux répétés proprement sur plusieurs pages.
- Aucune colonne coupée.
- Orientation portrait/paysage selon le rapport.
- Accents français correctement rendus ; RTL testé si l'arabe est activé.

---

# PARTIE V - ADMINISTRATION CENTRALE, PARAMÈTRES ET PRÉFÉRENCES


## 47. Expérience utilisateur

- Design cohérent : même emplacement pour recherche, filtres, actions principales et messages.
- Formulaires avec étiquettes explicites, champs obligatoires et erreurs localisées.
- États visibles : chargement, aucun résultat, erreur, succès et opération en attente.
- Confirmation avant suppression, clôture d'offre ou action difficile à annuler.
- Couleurs de statut accompagnées d'un libellé texte.
- Navigation clavier et contraste suffisants.
- Responsive de base.
- Français comme langue initiale ; autres langues seulement si réellement testées.


## 48. Direction visuelle

Créer une interface professionnelle de gestion RH locale :

- Sidebar claire et organisée.
- Barre supérieure avec compte, notifications et préférences.
- Dashboard avec KPI et graphiques lisibles.
- Tables filtrables et paginées.
- Kanban et calendrier réellement interactifs.
- Pages de détail avec sections cohérentes.
- Formulaires accessibles et messages explicites.
- Pas d'animations inutiles ni de widgets décoratifs sans fonction.

L'application doit rester agréable sur écran d'ordinateur, tablette et téléphone.

---

# PARTIE XIII - LIVRABLES ATTENDUS


## Extrait du plan de réalisation d’origine

### Phase 8 - Dashboard, reporting, exports et durcissement

- KPI calculés depuis MySQL.
- Rapports filtrables.
- Export PDF/XLSX/CSV.
- Options d'export et modèles.
- Tests de sécurité, validation, confidentialité, sauvegarde et restauration.
- Administration avancée et configuration finale.

Livrable : rapport PDF/Excel cohérent, tests réussis et sauvegarde restaurée en environnement de test.


## Livrables obligatoires

- [ ] Dashboard RH dynamique
- [ ] Rapports filtrables
- [ ] Exports PDF/Excel/CSV
- [ ] Configuration d’export
- [ ] Vérifications UX et responsive

## Critère de sortie et règle d’arrêt

Les indicateurs correspondent aux données réelles, les exports reflètent les filtres choisis, et les états vides ou erreurs sont gérés proprement.

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
Créer/mettre à jour le rapport `docs/RAPPORTS_PHASES/PHASE_08.md` selon le modèle `docs/TEMPLATES/RAPPORT_FIN_PHASE.md`. Inclure uniquement les tests réellement exécutés et leurs résultats. Lister les tests non exécutés.

**ARRÊT OBLIGATOIRE :** ne commencer aucune phase suivante, ne committer/pousser aucune branche, ne fusionner aucune Pull Request et ne réinitialiser aucune donnée sans instruction explicite de l'utilisateur.

## Spécification Dashboard, rapports et exports

### KPI RH
Candidatures reçues par période ; nombre actuellement dans chaque étape ; taux de passage entretien ; délai moyen de recrutement ; entretiens à venir ; répartition sources ; offres actives ; offres converties en embauche ; activité récente et raccourcis. Définir formules, numérateur/dénominateur, date de départ et période.

### Rapports
Analytique globale ; rapport par offre/période/recruteur ; shortlist et scores ; entretiens ; audit si autorisé ; fiche candidat autorisée. Filtres période, offre, département, recruteur, étape, statut, source, score minimal.

### Exports configurables
Sélection des colonnes, ordre, tri, regroupement, logo, titre, organisation, date, auteur, filtres utilisés, style, orientation, pagination, pied de page, mentions de confidentialité, inclusion des notes/graphiques/totaux, nom de fichier et modèles enregistrés. Contrôle permission avant génération et journaliser les exports sensibles.

### Excel
XLSX prioritaire via bibliothèque PHP compatible. Dates/nombres typés ; protéger contre formula injection : les textes fournis par les utilisateurs débutant par `=`, `+`, `-`, `@` ou tabulation doivent être neutralisés comme texte selon bibliothèque ; ne pas construire de formules depuis l'entrée utilisateur.

### PDF
Tableaux lisibles multipages, répétition des en-têtes, colonnes non coupées, orientation adaptée, logo si configuré, date et filtres. Accents français corrects ; RTL arabe seulement s'il est effectivement implémenté et testé.

### États UX
Loading, absence de résultats, période vide, erreur serveur, permission refusée, export en cours et confirmation de succès. Aucun KPI inventé hors seed de démonstration clairement identifiée.

### Critères de sortie additionnels
KPI vérifiés par calcul SQL indépendant ; filtres appliqués au PDF/XLSX ; injection neutralisée ; exports uniquement selon rôles ; PDF contrôlé visuellement.


## Prompt exécutable — Phase 08

> À copier-coller dans Qwen après avoir ouvert le dossier racine du dépôt.

```text
Lis QWEN.md et AGENTS.md, puis docs/00_LIRE_EN_PREMIER.md et docs/01_REGLES_ET_SOURCE_DE_VERITE.md. Lis ensuite uniquement docs/PHASES/PHASE_08_DASHBOARD_REPORTING_EXPORTS.md. Si le numéro de phase est supérieur à 00, lis aussi le rapport validé de la phase précédente et les fichiers techniques nécessaires.

Je te demande d'exécuter exclusivement la Phase 08 du projet SIRH. Commence par vérifier git status, la branche et les changements existants. Préserve tout travail préexistant. Présente ton plan avant les changements importants. Respecte toutes les exigences, tâches, livrables, tests et critères de sortie du fichier de phase. Ne lance pas la phase suivante. Ne fais aucun commit, push, merge, reset ou suppression destructive sans mon autorisation explicite. À la fin, rédige le rapport de fin de phase, indique les tests réellement exécutés et arrête-toi en attendant ma validation.
```
