# Décisions en attente de validation humaine

Aucune de ces décisions n'est tranchée par l'agent. Chacune est présentée avec options, conséquences et décision attendue. À reporter ensuite dans `docs/DECISIONS_A_VALIDER.md` après arbitrage utilisateur (validation explicite requise).

## D-08 — Départage entre Amine et Youssef (70/70) : **NON TRANCHÉE** ⚠️ DÉCISION CENTRALE

Contexte : le cahier des charges PDF propose « priorité au score des compétences clés si la règle est annoncée avant le scoring » ⇒ avantage Amine (40/40 vs 20/40). Une note antérieure de l'utilisateur suggérait un départage par expérience/atouts ⇒ avantage Youssef. La divergence est réelle ; l'agent ne choisit pas.

| Option | Règle | Conséquence sur le cas pédagogique | Conséquences techniques | Conséquences pédagogiques/éthiques |
|---|---|---|---|---|
| A | Compétences clés (source PDF) | Shortlist : Nadia, Salma, **Amine** | `tie_break_rule = 'skills_key_score'` versionné ; scénario démo étape 5 applique cette règle | Cohérent avec le PDF ; « la règle annoncée avant s'applique » |
| B | Expérience / atouts (note antérieure) | Shortlist : Nadia, Salma, **Youssef** | `tie_break_rule = 'experience_or_assets'` ; même mécanisme versionné | Fidèle à une préférence exprimée ailleurs ; doit être annoncée avant notation pour rester juste |
| C | Durée d'expérience seule | Départage à l'ancienneté maximale | moteur de critère supplémentaire ; cas limites (égalité persistante → ordre alphabétique ou revue humaine à définir) | Réducteur ; risque de biais « plus ancien = meilleur » explicitement critiqué par le PDF §12 |
| D | Âge / ancienneté diplôme | — | NON RECOMMANDÉ et signalé comme sensible | Critère discriminatoire potentiel ; contraire à l'esprit équité du PDF (photo/genre/origine interdits ; l'âge est une donnée personnelle délicate au sens 09-08) |
| E | Aucune règle automatique | **Égalité affichée + décision humaine motivée tracée** (défaut technique retenu tant que non tranché) | `tie_break_rule = NULL` ; UI bloque le classement ex æquo et exige motif+auteur | Le plus prudent ; compatible T-11 reformulé ; montre que « un score seul ne règle pas toutes les décisions » |

Décision attendue de l'utilisateur : choisir A/B/C/E (ou une autre règle explicite), ou valider provisoirement E. Impact direct sur T-11, le scénario de démonstration et la shortlist officielle du projet.

## Autres décisions ouvertes

| ID | Sujet | Options | Conséquences si non tranché | Recommandation documentée (non contraignante) |
|---|---|---|---|---|
| D-05/D-01b | Versions PHP & MySQL communes aux 5 postes | Fixées après relevé réel (`13_...`) | Phase 01 bloquée (règle MP §27) | Aucune valeur inventée ; attendre le PV diagnostic |
| D-04b | Bibliothèque PDF | Dompdf vs mPDF (test accents/RTL/multipages/perf) | Exports PDF non développables en Phase 08 | Test comparatif écrit avant choix |
| D-17 | Graphiques | Chart.js auto-hébergé (cité PDF) vs rendu serveur vs abstrait | Dashboard M2 partiellement bloqué | Auto-hébergement local obligatoire (T-31 hors Internet) |
| D-06 | Périmètre réseau | localhost seul vs LAN temporaire ponctuel | Démos multi-postes impossibles si LAN requis sans décision | localhost par défaut ; LAN = accord explicite, temporaire, contrôlé |
| D-10 | Parsing CV | MVP (risque R-03) vs Bonus (position des sources) | Seeders/saisie manuelle seuls au démarrage | Bonus ; upload + saisie vérifiée d'abord (choix source) |
| D-11 | E-mails réels | SMTP local/test autorisé vs simulation | Notifications limitées à l'aperçu simulé (conforme T-27) | Simulation honnête tant que non validé |
| D-12 | Vidéo différée | Simulation (sources) vs enregistrement réel | Fonction livrée en simulation marquée | Simulation d'abord ; réel = extension encadrée |
| D-13 | Multidiffusion offres | API officielle validée vs texte exportable manuel | Publication externe indisponible | Manuel documenté |
| D-14b | Portail candidat avec compte | Sans compte (MVP) vs authentifié (Bonus) | Suivi candidature limité au numéro de dépôt | Sans compte au MVP |
| D-15 | Langues | FR seul vs +EN/+AR(RTL) | T-20 non applicable | FR d'abord ; autres langues seulement testées |
| D-18 | IA externe/cloud | Désactivée (défaut source) vs activée avec autorisation + conformité | Fonctions N3 indisponibles | Désactivée ; aucune donnée envoyée sans accord écrit |
| D-19 | Durées de conservation / suppression | Barèmes à fixer avec l'encadrement (loi 09-08) | retention_policies en valeurs provisoires signalées | À valider explicitement ; rien d'implicite |
| D-20 | Collation MySQL uniforme | utf8mb4_unicode_ci vs 0900_ai_ci selon versions réelles | Migrations non verrouillables | Après relevé D-05 |
| D-21 | Outil de migration | Script maison minimal vs Phinx/outil Composer | Lot 0001 non écrit | Script simple conforme « MVC personnalisé » |
| D-22 | Handles GitHub des 5 membres | Information humaine manquante (signalée dès le PDF) | CODEOWNERS/invitations incomplets | Fournir les usernames en kickoff |
| D-23 | CI GitHub Actions (lint/tests sans base) | Oui limitée vs tout local | Qualité dépend des revues manuelles | Décision équipe à acter |
| D-16 | Statut officiel du MP V3 comme référence textuelle complète (le PDF étant image-only ; ajouts listés dans `01_...`) | Valider / limiter aux sections confirmées PDF | Toute la partie Administration/T-21→35/150 candidatures reste contractuelle « sur parole du MP » | Comparaison substantielle faite ; certifier ou restreindre |
| Q-01 | Diapositives Google Slides du cours jamais consultées (aveu du PDF lui-même) | Obtenir le contenu ou confirmation qu'il ne porte pas d'exigences supplémentaires | Risque R-14 : exigences inconnues possibles | Question à poser à l'enseignante avant gel du périmètre |
| Q-02 | Validation de la stack par l'enseignante (« technologie imposée par le cours », formulation PDF) | Confirmation écrite | Conformité pédagogique incertaine | À demander formellement |

## Règles de conduite appliquées pendant cette phase

1. Aucun résultat de test n'a été modifié ni prédit : les tests T-01→T-35 sont uniquement tracés (`12_...`), leurs verdicts seront produits en Phase 09 avec preuves.
2. D-08 maintenue NON TRANCHÉE ; le comportement système proposé par défaut (Option E) n'impose aucune règle de classement.
3. Toutes les autres décisions humaines restent ci-dessus avec leurs conséquences ; rien n'a été arbitré silencieusement.
4. Aucun code PHP/JS/SQL, aucune migration, aucun fichier de référence modifié — uniquement des documents dans `docs/ANALYSE/`.
