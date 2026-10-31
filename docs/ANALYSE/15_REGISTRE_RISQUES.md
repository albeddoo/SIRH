# Registre des risques

Probabilité/Impact : Faible/Moyen/Élevé. Les risques sont suivis par un responsable d'animation (M1) ; les mitigations techniques renvoient aux livrables d'analyse.

## A. Risques techniques

| ID | Risque | P | I | Mitigation | Signe d'alerte |
|---|---|---|---|---|---|
| R-01 | Environnements hétérogènes WampServer (versions PHP/MySQL divergentes entre 5 PC) | Élevé | Élevé | Diagnostic `13_...` avant Phase 01 ; versions figées D-05 ; page de test commune bloquante | « ça marche sur ma machine » |
| R-02 | Bibliothèque PDF incapable (accents FR, RTL, tableaux multipages) | Moyen | Moyen | Test comparatif Dompdf/mPDF avant choix D-04b ; alternative CSV+impression navigateur documentée d'honnêteté | carrés à la place des accents (T-19) |
| R-03 | Parsing CV non fiable (formats variés, PDF scannés) | Élevé | Moyen | MVP = upload + saisie vérifiée (choix source explicite) ; parsing en Bonus seulement si bibliothèque validée | extraction partielle présentée comme fiable |
| R-04 | Kanban JS complexe dans contrainte « JS natif » | Moyen | Moyen | drag&drop simple + fallback vue tableau (exigence source) ; endpoints AJAX protégés RBAC | glisser-déposer décoratif |
| R-05 | Migrations désynchronisées entre postes | Moyen | Élevé | forward-only + table `migrations` + pull obligatoire + checklist tag (MP §30) | erreurs SQL locales non reproductibles |
| R-06 | Fuites par stockage mal configuré (uploads sous DocumentRoot, dossiers listables) | Moyen | Élevé | structure imposée `storage/` hors public + T-35/T-26 systématiques | fichier accessible par URL directe |
| R-07 | Limites upload Apache/PHP insuffisantes pour CV | Faible | Moyen | relevé php.ini par poste + alignement (MP §31) | rejets silencieux |
| R-08 | Dépendances Composer incompatibles version PHP finale | Moyen | Moyen | verrouillage `composer.lock` après validation D-05 ; audit libs avant adoption | échecs d'installation chez un membre |

## B. Risques produit / conformité

| ID | Risque | P | I | Mitigation |
|---|---|---|---|---|
| R-09 | Scoring perçu comme automatique/injuste (biais, faux négatifs « non documenté ») | Moyen | Élevé | statuts Oui/non observé/à vérifier ; détail par critère ; revue humaine obligatoire ; démonstration honnête des biais (PDF §12) |
| R-10 | Départage Amine/Youssef décidé implicitement par le code (**D-08 ouverte**) | Élevé si ignoré | Élevé | `tie_break_rule=NULL` ⇒ égalité affichée + décision humaine motivée ; aucune règle choisie par l'agent |
| R-11 | Non-conformité loi 09-08 en cas d'usage réel (conservation, droits, transferts) | Faible (données fictives) | Élevé | mécanismes prévus (consent_records, retention_policies, registre) ; durées à valider D-19 ; aucun envoi externe sans accord |
| R-12 | Simulation trompeuse (faux e-mails « envoyés », faux exports, pages décoratives) | Moyen | Élevé | interdiction règle MP 22 + T-27 ; états explicites simulé/prévu/envoyé/échec |
| R-13 | Périmètre qui dérive vers un SIRH complet | Moyen | Moyen | hors-périmètre écrit `07_...` ; validations utilisateur par phase |
| R-14 | Exigences méconnues des diapositives du cours (jamais consultées) | Moyen | Moyen | question posée à l'enseignante (`02_...` §10) ; marge de planification |

## C. Risques équipe / pédagogiques

| ID | Risque | P | I | Mitigation |
|---|---|---|---|---|
| R-15 | Membres bloqués par conflits Git / modifications croisées | Moyen | Moyen | branches protégées, PR obligatoires, périmètres M1–M5, pas de force-push |
| R-16 | Temps insuffisant → features inachevées présentées comme finies | Élevé | Élevé | tranches fonctionnelles complètes par étape (principe PDF §19) ; MVP d'abord, bonus ensuite ; statut honnête par exigence |
| R-17 | Comptes GitHub réels non fournis / accès inégaux | Moyen | Faible | D-22 (information attendue) ; invitations dès Phase 01 |
| R-18 | Soutenance : démonstration qui échoue le jour J | Moyen | Élevé | données fictives réinitialisables + mode démo + scénario préparé 10 étapes + sauvegarde testée (T-28/T-34) |
| R-19 | Un seul membre concentre le code (évaluation individuelle faussée) | Moyen | Moyen | commits attribués, revues croisées, responsabilité de domaine par membre |

## D. Suivi

Revue du registre à chaque fin de phase (rituel M1) ; nouveau risque = nouvelle ligne datée ; risque devenu incident → documenté dans `docs/HISTORIQUE/`. Aucun risque fermé sans preuve de mitigation.
