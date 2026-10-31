# Architecture IA : règles déterministes, NLP et LLM optionnel

Sources : PDF §9/§12 + MP V3 §18/§41 (`CONFIRMÉ PAR SOURCE`). Principe : le score est une **aide au tri explicable**, jamais une prédiction ni une décision autonome.

## 1. Trois niveaux (correspondance MVP/Bonus)

| Niveau | Technologie | Périmètre | Statut |
|---|---|---|---|
| N1 — Automatisation explicable | Règles déterministes paramétrées en base | Scoring, filtres, synonymes exacts contrôlés, statuts de données | **MVP recommandé** (PDF : « plus simple à tester et expliquer qu'un score magique ») |
| N2 — NLP léger local | Normalisation textuelle, dictionnaires de synonymes/équivalences, extraction heuristique (regex/masques dates-emails-téléphones), tokenization simple FR | Parsing assisté, matching sémantique basique, recherche par mots-clés enrichis | Bonus (D-10/D-07) ; déterministe et rejouable |
| N3 — LLM optionnel | Modèle local si matériel validé OU fournisseur externe **désactivé par défaut** | Résumés CV, suggestions de questions, brouillons d'offres/e-mails, recherche en langage naturel | Bonus conditionnel ; sortie = proposition relue humainement, liée à sa source, jamais présentée comme fait garanti ; aucune donnée envoyée sans autorisation explicite |

## 2. Moteur de scoring N1 (cœur du MVP)

### 2.1 Entrées
- `application` + profil candidat structuré (skills validées/provenance, expériences avec durées calculées, formation, langues).
- `scoring_template` versionné + `scoring_criteria` (poids, type, règle typée, paramètres).

### 2.2 Types de règles (moteurs extensibles, tous auditables)
| Type moteur | Exemple | Sortie |
|---|---|---|
| `skill_documented` | SEO documenté ? | points si compétence présente avec statut Oui/vérifié |
| `experience_range` | ≥1 an → 20 ; 6–11 mois → 10 ; <6 mois → 0 | paliers sur durée calculée |
| `education_category` | domaine pertinent → 20 ; autre → 0 | catégorie formation vs famille poste |
| `tools_count` | Canva/CRM maîtrisés → 5 chacun | comptage borné |
| `language_professionnel` | documenté → 10 ; non documenté → statut | **avec statut de donnée, pas un aveugle 0 hors cas pédagogique** |
| `manual_override` | correction RH | motif+auteur+date obligatoires |

Chaque exécution produit pour chaque critère : points obtenus, **statut de la donnée** (`oui`, `non_observe`, `a_verifier`, `absence_confirmee`, `sans_objet`), preuve/champ source, version de grille, horodatage, déclencheur. Déterminisme : mêmes données + même version de grille = même résultat (exigence de reproductibilité MVP).

### 2.3 Grille pédagogique de référence (cas DMS)
Formation 20 / Expérience 20 / SEO 10 / Réseaux sociaux 10 / Google Analytics 10 / Excel 10 / Français professionnel 10 / Canva 5 / CRM 5 = 100.
Hypothèses figées par la source : finance Imane ≠ domaine lié ; 4 compétences clés ×10 ; français non documenté dans les 5 profils → 0 selon barème de l'exercice (signalé « non documenté », T-10) ; résultats attendus **Nadia 90, Salma 85, Amine 70, Youssef 70, Imane 35** (T-08).

### 2.4 Égalités et départage — **D-08 : Option E validée provisoirement (2026-10-31), décision définitive ouverte**
**Option E validée provisoirement par le propriétaire (2026-10-31)** — règle opérationnelle pour les tests ; décision définitive ouverte. Comportement retenu : `tie_break_rule = NULL` ⇒ le moteur affiche l'égalité (Amine 70 = Youssef 70) et exige une décision humaine motivée. Si une règle est validée, elle est stockée en paramètre versionné de la grille, **affichée avant tout calcul** et appliquée de façon démontrable. Options complètes et conséquences : `16_DECISIONS_EN_ATTENTE.md`.

### 2.5 Recalculs et historique
Recalcul = action explicite auditable créant une nouvelle ligne `application_scores` liée à sa version de grille ; l'historique n'est jamais écrasé (T-24) ; modification de poids ⇒ nouvelle version de grille (T-09) ; seuils = **indicateurs de revue manuelle**, jamais de rejet automatique (règle non négociable MP).

## 3. NLP local (N2) — conception

- Pipeline : extraction texte (selon format ; PDF scanné = échec documenté, pas devinette) → normalisation (minuscules, accents-insensibles pour la comparaison, ponctuation) → détection d'entités simples (e-mail, téléphone, dates, diplômes via dictionnaire, compétences via `skill_aliases`) → préremplissage **avec provenance et niveau de confiance** → vérification humaine obligatoire avant scoring sensible (PDF §8).
- Matching sémantique « léger » : dictionnaire d'équivalences administré (GA4 ≡ Google Analytics 4), correspondances affichées et corrigeables ; jamais de similarité opaque non expliquée.
- Contraintes locales : bibliothèques PHP compatibles WampServer/PHP retenu, sans service cloud ; sinon fonction reportée en Bonus documenté.

## 4. LLM (N3) — conditions strictes

- Désactivé par défaut ; activation seulement si accord explicite + confidentialité validée (MP §40 : aucune donnée personnelle envoyée sans autorisation).
- Si activé : prompts journalisés sans secrets, sorties marquées « proposition IA à vérifier », lien vers la source dans le CV, interdiction d'alimenter automatiquement le score ou une décision ; test matériel local avant toute promesse (D-07).
- Pédagogie : démontrer honnêtement les limites (hallucination possible, biais).

## 5. Équité, biais et mesures correctives (exigence source)

Risques à démontrer : mot-clé absent/synonyme non reconnu ; CV incomplet ou atypique ; biais de données historiques ; surpondération diplôme/années ; fausse précision (« 82/100 ≠ 82 % de probabilité ») ; effet de seuil ; données non comparables.
Mesures implémentées : séparation oui/non observé/à vérifier ; synonymes contrôlés ; détail des notes + champs utilisés + manquants visibles ; tests de profils variés ; traçabilité de toute modification manuelle avec motif ; **interdiction photo/genre/origine comme critères** ; décision finale humaine réservée ; phrase à défendre à l'oral reprise dans l'aide contextuelle de l'appli.

## 6. Ce que l'IA ne fera jamais ici (limites contractuelles)

Rejet/embauche automatiques ; notation depuis photo/émotions/biométrie ; envoi de données personnelles vers un service externe sans autorisation explicite ; présentation d'une sortie générative comme un fait ; score « magique » non explicable.
