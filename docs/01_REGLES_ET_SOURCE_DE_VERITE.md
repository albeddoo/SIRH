# Règles métier, exigences et sources de vérité

## 1. Hiérarchie en cas de divergence
1. Décision explicite la plus récente de l'utilisateur.
2. Cahier des charges source fourni (PDF de 24 pages).
3. Spécification détaillée de la phase demandée.
4. Registre de décisions validées.
5. Bonne pratique technique, sans invention fonctionnelle.

Toute divergence est enregistrée et soumise à validation. Ne jamais résoudre silencieusement un conflit. Le PDF est inclus dans `references/CAHIER_DES_CHARGES_SOURCE_24_PAGES.pdf`; la référence textuelle détaillée est dans `references/MASTER_PROMPT_REFERENCE_COMPLET_V3.md`.

## 2. Objectifs métier
- Centraliser les offres et candidatures.
- Suivre offre → candidature → profil → vérification → scoring → shortlist → entretiens → offre/décision → communication → reporting.
- Réduire les tâches administratives répétitives.
- Utiliser des critères paramétrables, explicables et versionnés.
- Garder une décision finale humaine, justifiée et traçable.
- Protéger les données personnelles et limiter les accès.

## 3. MVP obligatoire
| Code | Fonction | Critère minimal |
|---|---|---|
| MVP-01 | Authentification et rôles | Autorisations vérifiées côté serveur. |
| MVP-02 | Offres d'emploi | Créer, modifier, publier localement, suspendre, clôturer et archiver. |
| MVP-03 | Candidats et CV | Fiche, document privé, recherche et modification autorisée. |
| MVP-04 | Candidatures | Lien candidat-offre et suivi du statut. |
| MVP-05 | Scoring paramétrable | Critères pondérés, calcul et justification par critère. |
| MVP-06 | Shortlist et Kanban | Classement, étapes et historique. |
| MVP-07 | Entretiens | Planification, évaluation et recommandation. |
| MVP-08 | Cas pédagogique | Cinq profils de référence correctement calculés. |
| MVP-09 | Exports | PDF/Excel avec filtres et colonnes sélectionnés. |
| MVP-10 | Dashboard et sécurité | KPI calculés depuis les données et accès protégés. |

## 4. Fonctions Bonus
Parsing PDF/DOCX avancé, import massif, assistant LLM génératif, matching sémantique avancé, SMTP réel, portail de suivi candidat authentifié, vidéo différée réelle, intégrations RH externes, multidiffusion externe via API officielle autorisée. L'architecture peut les préparer, mais le MVP ne doit pas dépendre d'elles.

## 5. Hors périmètre
Paie, congés, bulletins de salaire, LMS complet, rejet/embauche entièrement automatiques, analyse biométrique/émotionnelle, hébergement Internet et publication publique.

## 6. Rôles
- Administrateur technique : comptes, rôles, permissions, réglages système, audit et sauvegardes ; pas de décision RH automatique.
- Responsable RH : processus global et décision finale humaine.
- Recruteur : dossiers affectés, candidatures, notes et transitions autorisées.
- Manager recruteur : offre et shortlist de son équipe.
- Intervieweur : entretiens attribués et évaluations.
- Direction/Observateur : rapports autorisés en lecture seule.
- Candidat externe : formulaire local de candidature dans le MVP ; espace de suivi authentifié en Bonus.

## 7. Cas pédagogique
Entreprise : Digital Maroc Solutions. Poste : Chargé(e) de Marketing Digital Junior. Jeu de démonstration : 150 candidatures fictives, plus cinq profils de référence.

Barème initial sur 100 : formation liée 20 ; expérience 20 (≥ 1 an = 20 ; 6–11 mois = 10 ; < 6 mois = 0) ; SEO 10 ; réseaux sociaux 10 ; Analytics 10 ; Excel 10 ; français professionnel 10 ; Canva 5 ; CRM 5. Tous les poids, seuils, règles, synonymes et priorités sont configurables/versionnés.

Profils de référence :
| Profil | Formation | Expérience | Compétences | Français | Atouts | Total |
|---|---:|---:|---:|---:|---:|---:|
| Nadia | 20 | 20 | 40 | 0 | 10 | 90 |
| Salma | 20 | 20 | 40 | 0 | 5 | 85 |
| Amine | 20 | 10 | 40 | 0 | 0 | 70 |
| Youssef | 20 | 20 | 20 | 0 | 10 | 70 |
| Imane | 0 | 20 | 10 | 0 | 5 | 35 |

Le français non documenté vaut 0 pour ces cinq profils pédagogiques. En usage réel, distinguer « non observé », « non documenté », « à vérifier » et « absence confirmée ».

## 8. Décision non résolue : égalité Amine/Youssef
Le PDF privilégie les compétences clés pour départager (Amine avant Youssef). Une note antérieure fournie par l'utilisateur privilégie l'expérience puis les atouts (Youssef avant Amine). Ne pas trancher silencieusement. En Phase 00, présenter les deux options. Si aucune règle n'est validée, conserver l'égalité et demander une revue humaine.

## 9. Garde-fous IA et recrutement
- Le scoring assiste ; il ne prend jamais la décision finale.
- Aucun rejet automatique définitif.
- Afficher les critères, points, données sources, informations manquantes et limites.
- Ne pas utiliser photo, genre, origine, âge, handicap ou émotions comme critères.
- Une exception ou correction manuelle doit être motivée, datée et attribuée.
- Un score sur 100 n'est pas une probabilité de succès.

## 10. Confidentialité
Prendre en compte la loi marocaine 09-08 et les exigences applicables de la CNDP sans prétendre à une certification juridique. Utiliser des données fictives dans le projet académique. Définir finalités, accès, conservation, suppression/anonymisation et journalisation.
