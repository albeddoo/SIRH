# Analyse fonctionnelle complète — SIRH (ATS)

Statuts : `CONFIRMÉ PAR SOURCE` = PDF+MP V3 ; `CONFIRMÉ MP` = MP V3/docs pack ; `PROPOSITION` = choix d'architecture à valider.

## 1. Définition du produit

- **SIRH** : application web locale de gestion du recrutement (ATS spécialisé) pour la PME fictive **Digital Maroc Solutions** (Casablanca). Périmètre première version = recrutement uniquement ; **pas** de paie, congés, pointage, LMS (`CONFIRMÉ PAR SOURCE`).
- Exécution : WampServer/Apache/PHP/MySQL sur `localhost` ; aucun hébergement Internet (`CONFIRMÉ MP`).
- Principe directeur : le logiciel assiste le recrutement, **la décision finale reste humaine**, traçable et justifiée (`CONFIRMÉ PAR SOURCE`).

## 2. Objectifs métier (`CONFIRMÉ PAR SOURCE`)

Centraliser offres/candidatures ; décrire le parcours numérique d'une candidature ; réduire les tâches répétitives ; grille de présélection pertinente, configurable, explicable ; shortlist vérifiable ; planifier entretiens et évaluations ; communiquer et historiser ; tableaux de bord et exports PDF/Excel ; protéger données personnelles et accès ; garder décision humaine justifiée et traçable.

## 3. Objectifs pédagogiques e-GRH (`CONFIRMÉ PAR SOURCE`)

Démontrer : définition/utilité d'un ATS ; digitalisation du parcours recrutement ; suivi dispersé vs pipeline centralisé ; rôles des acteurs ; grille explicable ; limites des filtres/mots-clés/données manquantes/algorithmes ; sécurité, rôles, confidentialité, traçabilité, KPI.

## 4. Acteurs et cas d'utilisation principaux

| Acteur | Cas d'utilisation clés |
|---|---|
| Administrateur technique | Gérer comptes/rôles/permissions, paramètres globaux, référentiels, grilles/pipeline/modèles, fichiers/conservation, audit, sauvegardes, connecteurs IA/e-mail, réinitialiser la démo (permission dédiée) |
| Responsable RH | Créer/gérer offres, consulter dossiers, configurer grilles autorisées, valider shortlist, organiser entretiens, prendre/enregistrer décisions finales, suivre KPI |
| Recruteur | Traiter CV, compléter fiches, calculer/consulter scores, déplacer dans le pipeline (transitions permises), préparer entretiens, notes internes |
| Manager recruteur | Valider fiche de poste, consulter shortlist de son équipe, avis et évaluations d'entretiens auxquels il participe |
| Intervieweur | Consulter infos/questions attribuées, saisir évaluation + commentaires |
| Direction / Observateur | Consulter indicateurs et rapports agrégés non sensibles |
| Candidat externe | Déposer une candidature (portail local, sans compte au MVP), consulter ses candidatures si portail authentifié activé (Bonus), modifier ses données autorisées |

## 5. Parcours de référence (`CONFIRMÉ PAR SOURCE`)

Offre → Candidature → Profil candidat → Vérification → Scoring → Shortlist → Entretien RH → Entretien technique → Offre envoyée → Décision finale → Communication → Reporting.

## 6. Sitemap complet (`CONFIRMÉ PAR SOURCE`, pages Admin détaillées = `CONFIRMÉ MP`)

0. **Portail local (sans connexion RH)** : accueil ; liste offres ouvertes ; détail offre ; formulaire de candidature ; confirmation + numéro de candidature ; politique de confidentialité et contact.
1. **Authentification** : connexion ; mot de passe oublié/réinitialisation ; profil et préférences ; déconnexion.
2. **Dashboard RH** : KPI ; graphiques pipeline/volumes ; entretiens à venir ; candidatures à traiter ; activité récente et raccourcis.
3. **Offres** : liste+recherche+filtres ; créer/modifier ; fiche de poste et compétences ; aperçu public ; publier/suspendre/clôturer/archiver ; candidatures associées.
4. **Candidats** : répertoire ; créer/modifier fiche ; CV et pièces jointes ; formation/expérience/compétences/langues ; historique et notes autorisées ; doublons ; favoris/étiquettes/archivage.
5. **Candidatures** : liste filtrable ; détail ; timeline ; affectation recruteur ; scoring détaillé ; shortlist/décision/motif.
6. **Matching & scoring** : modèles de grille ; critères/poids/règles/seuils ; calcul et classement ; explication par critère ; données manquantes ; comparateur ; historique des versions.
7. **Pipeline Kanban** : colonnes Nouvelle candidature → À vérifier/Présélection → Entretien RH → Entretien technique → Offre envoyée → Embauché/Refusé/Retiré/En attente (+ vue tableau).
8. **Entretiens** : calendrier ; créer/déplacer/annuler ; participants et créneaux ; questions et grille d'évaluation ; simulation vidéo différée ; compte rendu et recommandations.
9. **Communications** : modèles d'e-mails ; invitations et rappels ; messages refus/offre ; historique ; centre de notifications internes.
10. **Rapports & exports** : dashboard analytique ; rapports offre/période/recruteur ; shortlist et scores ; entretiens ; audit ; aperçu PDF ; export Excel.
11. **Étude de cas** : cas DMS ; fiche de poste et barème ; cinq profils ; calcul et égalité ; justification des trois entretiens ; biais et corrections.
12. **Administration** (sous-modules 24.1→24.19, voir `06_MODULES.md`) : tableau de bord admin, utilisateurs/invitations, rôles/permissions, entreprise/marque, langue/date/fuseau, référentiels, offres/contrats, pipeline, scoring, modèles d'entretiens, notifications, fichiers/conservation, confidentialité, sécurité/sessions, IA/intégrations, exports/modèles, audit, sauvegardes/état, mode démo.
+ **Mon profil / Mes préférences** (§25) pour tout utilisateur connecté.

Règle de navigation : menu adapté au rôle ; **chaque route/fichier/export vérifie la permission côté serveur** (`CONFIRMÉ PAR SOURCE`).

## 7. Fonctions par module (résumé des règles métier clés)

### Offres (`CONFIRMÉ PAR SOURCE`)
- Champs : identification (référence unique auto ou saisie), présentation, exigences (impératives vs souhaitées séparées), conditions (ville, contrat, temps, dates, nombre de postes), scoring (modèle de grille associé), publication.
- Statuts : brouillon, à valider, publiée, suspendue, clôturée, archivée ; transitions autorisées selon rôle et enregistrées.
- Actions : créer (formulaire/modèle), prévisualiser, dupliquer (nouvelle référence), publier/suspendre/reprendre/clôturer/archiver, voir candidatures rattachées et volumes par étape, exporter.
- Diffusion externe : architecture connecteurs prévue ; **aucune publication simulée** ; sans API autorisée → texte exportable + procédure manuelle (`CONFIRMÉ MP`).

### Candidats & CV
- Fiche : identité/contact validés ; formation (ne jamais déduire un diplôme absent) ; expérience (durée calculée si dates, pas de double comptage de périodes qui se chevauchent) ; compétences normalisées + provenance ; langues (distinguer non renseigné/niveau insuffisant) ; pièces jointes contrôlées ; traçabilité (création, origine, information/consentement, historique).
- Qualité : recherche nom/e-mail/référence/compétence/offre ; filtres combinables ; tri + pagination ; alerte doublon e-mail **sans fusion automatique** ; favoris/étiquettes sans effet sur le score ; notes internes séparées ; archivage/suppression contrôlés par rôle et conservation.
- Un candidat = plusieurs candidatures ; profil séparé des candidatures.

### Candidatures
- Relient candidat↔offre ; portent source, date, statut, documents, affectation recruteur, notes, score, historique/timeline, shortlist/décision/motif documentés.

### Scoring / présélection (voir `10_ARCHITECTURE_IA.md`)
- Grille pédagogique 100 pts, résultats de référence Nadia 90 / Salma 85 / Amine 70 / Youssef 70 / Imane 35 (`CONFIRMÉ PAR SOURCE`).
- Toute correction manuelle : motif + auteur + date + ancienne/nouvelle valeur ; scores historiques liés à leur version de grille.
- Départage Amine/Youssef : **divergence ouverte D-08**, règle active affichée avant calcul ; sans règle validée → égalité + revue humaine.

### Pipeline/Kanban
- 8 étapes avec objectifs et transitions définies (détail §20 MP) ; glisser-déposer soumis à permission de transition ; confirmation pour transitions importantes ; historique ancien→nouveau statut/auteur/date/motif ; compteurs par colonne ; filtres offre/recruteur ; vue tableau complémentaire ; aucune disparition sans motif ni historique.

### Entretiens & évaluations
- Attributs : candidature/offpe/étape, date-heure-durée, responsable+participants, type (présentiel/visio/vidéo différée), lieu/lien visible uniquement aux concernés, statuts (à planifier→absent), rappels, résultat.
- Détection de conflits d'horaire avec proposition d'autre créneau (T-13).
- Grille 1–5 : compétences techniques, communication, résolution de problèmes, compréhension des missions, motivation ; note reliée à une question/preuve quand possible ; recommandation favorable/à approfondir/défavorable distincte du score CV ; une fiche par évaluateur/entretien.
- Vidéo différée : **simulation au MVP** (questions, temps, statut, observations) ; enregistrement réel = extension soumise à consentement, accès limité, conservation, suppression planifiée ; jamais d'analyse d'émotions/faciale/personnalité (`CONFIRMÉ PAR SOURCE`).

### Communications & notifications
- Modèles : accusé de réception, invitation, rappel, refus, offre ; événements déclencheurs ; variables autorisées ; prévisualisation ; historique ; centre de notifications internes.
- Garde-fous : pas d'envoi multiple si candidature modifiée ; fuseau correct ; fréquence rappels configurable ; **jamais « envoyé » si échec** ; sans SMTP configuré → aperçu + journal de simulation clairement identifiés.

### Dashboard & reporting
- KPI avec définitions configurables/documentées : candidatures reçues, candidats par étape, taux de passage à l'entretien, délai de recrutement (date de départ définie clairement), entretiens à venir, sources, offres actives, offres converties en embauche, activité récente.
- États vides : zéro/« aucune donnée » sans erreur serveur (T-18).
- Rapports : dashboard analytique, par offre/période/recruteur, shortlist+scores, entretiens, audit, fiche candidat autorisée. Formats XLSX/PDF prioritaires, CSV option ; paramètres dynamiques (colonnes, ordre, tri, regroupements, logo, pied de page, nom de fichier avec variables, modèles sauvegardés) ; permissions vérifiées avant génération ; exports sensibles journalisés ; neutralisation des formules Excel.

### Administration & préférences
- Voir `06_MODULES.md` §12 et §13 (sous-modules 24.1→24.19, préférences §25, règles communes §26).

## 8. Cas pédagogique Digital Maroc Solutions (`CONFIRMÉ PAR SOURCE`)

- Offre de référence : **Chargé(e) de Marketing Digital Junior**.
- ~150 candidatures fictives pour tester volumes/filtres/rapports (`CONFIRMÉ MP`) + 5 profils de référence exacts : Nadia, Salma, Amine, Youssef, Imane.
- Données 100 % fictives ; aucun vrai candidat ; réinitialisation contrôlée de l'environnement démo.
- Scénario de démonstration en 10 étapes (dashboard, création offre, ajout 5 candidats, scoring, traitement de l'égalité **avec règle préalablement validée**, entretiens, démonstration d'un biais, exports, démonstration des rôles, conclusion) et réponses préparées aux questions du cours (`CONFIRMÉ PAR SOURCE`).

## 9. Contraintes non fonctionnelles

- Responsive ordinateur/tablette/téléphone (T-32) ; UX cohérente (états chargement/vide/erreur/succès, confirmations, libellés texte + couleur, navigation clavier, contraste) ; français initial, anglais/arabe seulement si testés (RTL = T-20) ; performances locales sur 150+ candidatures ; disponibilité = poste allumé (aucune exigence de service distant) ; maintenance par migration versionnée.

## 10. Exigences à clarifier avec l'enseignante (héritées du PDF p1/p23)

1. Les diapositives Google Slides (inaccessibles à la rédaction du PDF) contiennent-elles des exigences supplémentaires ?
2. La stack PHP MVC/MySQL est-elle bien « maîtrisée et autorisée par l'enseignante » (formulation du PDF) ?
3. Durée de conservation des données à fixer avec l'encadrement.
