-- Phase 02 / Lot 0007 : Données de référence (seed) — référentiels, rôles système, permissions, étapes pipeline.
-- Aucune donnée personnelle ; aucun mot de passe en dur (le compte admin initial sera créé par un script dédié Phase 03 avec mot de passe saisi/généré).

INSERT INTO roles (code, name, description, is_system) VALUES
('super_admin','Super administrateur','Accès complet à l''administration',1),
('admin_rh','Administrateur RH','Gestion courante RH et recrutement',1),
('recruiter','Recruteur','Gestion des offres, candidatures et scoring',1),
('hiring_manager','Manager recrutant','Avis, entretiens et décisions sur ses offres',1),
('interviewer','Intervieweur','Entretiens et évaluations',1),
('candidate_portal','Portail candidat','Accès limité au dépôt de candidature local',1),
('demo','Démonstration','Lecture + actions limitées, données de démonstration',1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO permissions (code, module, action, description) VALUES
('dashboard.view','dashboard','view','Voir le tableau de bord'),
('job.view','jobs','view','Consulter les offres'),
('job.create','jobs','create','Créer une offre'),
('job.update','jobs','update','Modifier une offre'),
('job.validate','jobs','validate','Valider/publier une offre'),
('job.archive','jobs','archive','Archiver une offre'),
('candidate.view','candidates','view','Consulter les candidats'),
('candidate.create','candidates','create','Créer un candidat'),
('candidate.update','candidates','update','Modifier un candidat'),
('candidate.delete','candidates','delete','Supprimer anonymiser un candidat (loi 09-08)'),
('cv.download','documents','download','Télécharger un CV (journalisé)'),
('cv.upload','documents','upload','Déposer un CV/pièce'),
('application.view','applications','view','Consulter les candidatures'),
('application.stage.move','applications','move_stage','Changer une étape du pipeline'),
('note.create','applications','note','Ajouter une note interne'),
('favorite.manage','applications','favorite','Gérer les favoris'),
('scoring.run','scoring','run','Lancer un calcul de score'),
('scoring.template.manage','scoring','manage_template','Gérer les grilles de scoring'),
('scoring.adjust','scoring','adjust','Ajustement manuel motivé'),
('interview.view','interviews','view','Consulter les entretiens'),
('interview.schedule','interviews','schedule','Planifier un entretien'),
('interview.evaluate','interviews','evaluate','Évaluer un entretien'),
('message.send','communications','send','Émettre un message (simulé ou réel)'),
('notification.view','communications','view_notifications','Consulter ses notifications'),
('report.view','reporting','view','Tableaux de bord et rapports'),
('report.export','reporting','export','Exporter PDF/Excel (journalisé)'),
('user.manage','administration','users','Gérer les utilisateurs'),
('role.manage','administration','roles','Gérer rôles et permissions'),
('settings.manage','administration','settings','Paramètres globaux'),
('references.manage','administration','references','Référentiels'),
('audit.view','administration','audit','Consulter les journaux d''audit'),
('backup.manage','administration','backups','Sauvegardes/restaurations'),
('demo.reset','administration','demo','Réinitialisation mode démonstration'),
('privacy.execute','administration','privacy','Actions de conformité conservation/droits')
ON DUPLICATE KEY UPDATE description=VALUES(description);

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id FROM roles r JOIN permissions p
WHERE r.code='super_admin'
ON DUPLICATE KEY UPDATE role_id=VALUES(role_id);

INSERT INTO pipeline_stages (code, label, sort_order, is_final, confirmation_required) VALUES
('received','Reçue',10,0,0),
('screening','Présélection',20,0,0),
('shortlist','Shortlist',30,0,0),
('interview_hr','Entretien RH',40,0,0),
('interview_tech','Entretien technique/manager',50,0,0),
('offer','Offre proposée',60,0,1),
('hired','Recruté',70,1,1),
('rejected','Refusée',80,1,1),
('withdrawn','Retirée',90,1,0)
ON DUPLICATE KEY UPDATE label=VALUES(label);

INSERT INTO contract_types (code,label) VALUES ('CDI','CDI'),('CDD','CDD'),('stage','Stage'),('freelance','Freelance'),('alternance','Alternance')
ON DUPLICATE KEY UPDATE label=VALUES(label);
INSERT INTO work_time_types (code,label,weekly_hours) VALUES ('temps_plein','Temps plein',44),('temps_partiel','Temps partiel',NULL)
ON DUPLICATE KEY UPDATE label=VALUES(label);
INSERT INTO sources (code,label) VALUES ('site_carriere','Site carrière'),('cabinet','Cabinet'),('cooptation','Cooptation'),('linkedin','LinkedIn'),('portail_etudiant','Portail étudiant'),('autre','Autre')
ON DUPLICATE KEY UPDATE label=VALUES(label);
INSERT INTO languages (code,label) VALUES ('fr','Français'),('ar','Arabe'),('en','Anglais'),('es','Espagnol')
ON DUPLICATE KEY UPDATE label=VALUES(label);
INSERT INTO levels (scale,code,label,rank_value) VALUES
('education','bac','Baccalauréat',1),
('education','bac_plus_2','Bac+2',2),
('education','bac_plus_3','Licence (Bac+3)',3),
('education','bac_plus_5','Master/Ingénieur (Bac+5)',4),
('education','doctorat','Doctorat',5),
('skill','debutant','Débutant',1),
('skill','intermediaire','Intermédiaire',2),
('skill','avance','Avancé',3),
('skill','expert','Expert',4),
('language','a1','A1',1),('language','a2','A2',2),('language','b1','B1',3),('language','b2','B2',4),('language','c1','C1',5),('language','c2','C2',6),('language','native','Langue maternelle',7)
ON DUPLICATE KEY UPDATE label=VALUES(label);
INSERT INTO refusal_reasons (code,label) VALUES
('skills_gap','Compétences insuffisantes'),
('experience_gap','Expérience insuffisante'),
('salary_expectations','Prétentions salariales hors fourchette'),
('availability','Indisponibilité'),
('culture_fit','Adéquation équipe'),
('other','Autre (motif obligatoire)')
ON DUPLICATE KEY UPDATE label=VALUES(label);

INSERT INTO settings (setting_key, value_type, value_text, is_sensitive, description) VALUES
('app.name','string','SIRH',0,'Nom affiché de l''application'),
('app.locale_default','string','fr',0,'Langue par défaut'),
('app.timezone','string','Africa/Casablanca',0,'Fuseau d''affichage'),
('security.session_idle_minutes','int','60',0,'Inactivité session'),
('security.password_min_length','int','10',0,'Longueur minimale des mots de passe'),
('security.login_max_attempts','int','5',0,'Tentatives avant verrouillage'),
('security.lockout_minutes','int','15',0,'Durée de verrouillage'),
('uploads.max_size_mb','int','10',0,'Taille max fichier'),
('uploads.allowed_mime','json','["application/pdf"]',0,'MIME types autorisés pour CV'),
('duplicates.email_alert','bool','1',0,'Alerte doublon candidat par email'),
('scoring.default_template_name','string','Grille standard v1',0,'Grille appliquée par défaut'),
('demo.enabled','bool','0',0,'Activation du jeu de démonstration (feature flag lié)'),
('ai.external_enabled','bool','0',0,'IA externe/cloud — désactivée par défaut (D-07/D-18/D-10)'),
('email.real_sending_enabled','bool','0',0,'Envoi réel d''e-mails — désactivé (simulation honnête, T-27)')
ON DUPLICATE KEY UPDATE description=VALUES(description);

INSERT INTO feature_flags (code, enabled, context, description) VALUES
('bonus.import_mass',0,'production','Import massif (Bonus, D-10)'),
('bonus.candidate_portal_auth',0,'production','Portail candidat authentifié (Bonus, D-14b)'),
('bonus.video_real',0,'production','Vidéo asynchrone réelle (Bonus, D-12)'),
('bonus.lang_en',0,'production','Interface anglaise (Bonus, D-14)'),
('ai.nlp_local',1,'production','Parsing/extraction NLP local déterministe'),
('ai.llm_optional',0,'production','LLM externe optionnel (D-18)'),
('demo.mode',0,'demo','Jeu de démonstration (réinitialisable sans toucher la production, T-25)')
ON DUPLICATE KEY UPDATE description=VALUES(description);

INSERT INTO retention_policies (category, retention_months, legal_basis) VALUES
('candidature_non_retenu',24,'loi 09-08 : durée proportionnée à la finalité'),
('cv_depose_sans_candidature',12,'consentement / information préalable'),
('donnees_entretien',24,'finalité recrutement'),
('journal_audit',36,'obligation de traçabilité')
ON DUPLICATE KEY UPDATE legal_basis=VALUES(legal_basis);
