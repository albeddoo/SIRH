-- Phase 02 / Lot 0006 : Entretiens, évaluations, communications, reporting (catalogue §5.1/§5.5)
-- vidéo différée = simulation sans média réel (D-12) ; messages.statut interdit "sent" sans acquittement réel (T-27).

CREATE TABLE IF NOT EXISTS interviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NOT NULL,
    stage_id INT UNSIGNED NULL,
    scheduled_at_utc DATETIME NOT NULL,
    duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 45,
    interview_type ENUM('onsite','video_call','deferred_video') NOT NULL DEFAULT 'onsite',
    location VARCHAR(255) NULL,
    meeting_link VARCHAR(255) NULL,
    status ENUM('to_schedule','scheduled','in_progress','completed','cancelled','no_show') NOT NULL DEFAULT 'to_schedule',
    responsible_user_id INT UNSIGNED NULL,
    notes TEXT NULL,
    created_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_iv_application (application_id),
    KEY idx_iv_status (status),
    CONSTRAINT fk_iv_application FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_iv_stage FOREIGN KEY (stage_id) REFERENCES pipeline_stages (id),
    CONSTRAINT fk_iv_responsible FOREIGN KEY (responsible_user_id) REFERENCES users (id),
    CONSTRAINT fk_iv_created_by FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS interviewers (
    interview_id BIGINT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    participant_role VARCHAR(60) NOT NULL DEFAULT 'interviewer',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (interview_id, user_id),
    CONSTRAINT fk_ivr_interview FOREIGN KEY (interview_id) REFERENCES interviews (id) ON DELETE CASCADE,
    CONSTRAINT fk_ivr_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS interview_questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_text VARCHAR(500) NOT NULL,
    category VARCHAR(100) NULL,
    version SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    author_user_id INT UNSIGNED NULL,
    archived_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_iq_author FOREIGN KEY (author_user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS evaluation_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(190) NOT NULL,
    version SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    scale_min SMALLINT NOT NULL DEFAULT 1,
    scale_max SMALLINT NOT NULL DEFAULT 5,
    author_user_id INT UNSIGNED NULL,
    published_at DATETIME NULL,
    archived_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_evaltpl_name_version (name, version),
    CONSTRAINT fk_et_author FOREIGN KEY (author_user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS evaluation_criteria (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id BIGINT UNSIGNED NOT NULL,
    label VARCHAR(190) NOT NULL,
    description VARCHAR(500) NULL,
    weight DECIMAL(6,3) NOT NULL DEFAULT 1,
    sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_ec_template (template_id),
    CONSTRAINT fk_ec_template FOREIGN KEY (template_id) REFERENCES evaluation_templates (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS interview_evaluations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    interview_id BIGINT UNSIGNED NOT NULL,
    evaluator_user_id INT UNSIGNED NOT NULL,
    template_id BIGINT UNSIGNED NULL,
    recommendation ENUM('favorable','to_deepen','unfavorable') NULL,
    global_comment TEXT NULL,
    submitted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_eval_interview_evaluator (interview_id, evaluator_user_id),
    CONSTRAINT fk_ie_interview FOREIGN KEY (interview_id) REFERENCES interviews (id) ON DELETE CASCADE,
    CONSTRAINT fk_ie_evaluator FOREIGN KEY (evaluator_user_id) REFERENCES users (id),
    CONSTRAINT fk_ie_template FOREIGN KEY (template_id) REFERENCES evaluation_templates (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS evaluation_scores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evaluation_id BIGINT UNSIGNED NOT NULL,
    criterion_id BIGINT UNSIGNED NOT NULL,
    score_value SMALLINT NULL COMMENT 'NULL = non renseigné (distinct de 0)',
    linked_question_id BIGINT UNSIGNED NULL,
    evidence_note VARCHAR(500) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_evalscore (evaluation_id, criterion_id),
    CONSTRAINT fk_es_evaluation FOREIGN KEY (evaluation_id) REFERENCES interview_evaluations (id) ON DELETE CASCADE,
    CONSTRAINT fk_es_criterion FOREIGN KEY (criterion_id) REFERENCES evaluation_criteria (id),
    CONSTRAINT fk_es_question FOREIGN KEY (linked_question_id) REFERENCES interview_questions (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS video_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    interview_id BIGINT UNSIGNED NOT NULL,
    questions_json JSON NOT NULL,
    prep_seconds SMALLINT UNSIGNED NOT NULL DEFAULT 120,
    answer_seconds SMALLINT UNSIGNED NOT NULL DEFAULT 180,
    status ENUM('prepared','awaiting_candidate','observed','cancelled') NOT NULL DEFAULT 'prepared',
    observations TEXT NULL,
    created_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_vs_interview (interview_id),
    CONSTRAINT fk_vs_interview FOREIGN KEY (interview_id) REFERENCES interviews (id) ON DELETE CASCADE,
    CONSTRAINT fk_vs_user FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS notification_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(80) NOT NULL,
    event_key VARCHAR(120) NOT NULL,
    locale VARCHAR(10) NOT NULL DEFAULT 'fr',
    subject VARCHAR(255) NOT NULL,
    body_text TEXT NOT NULL,
    allowed_variables_json JSON NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_notpltpl_code_locale (code, locale)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NULL,
    candidate_id INT UNSIGNED NULL,
    template_id BIGINT UNSIGNED NULL,
    channel ENUM('email_simulated','sms_simulated','in_app','letter') NOT NULL DEFAULT 'email_simulated',
    subject VARCHAR(255) NULL,
    body_text TEXT NOT NULL,
    send_status ENUM('simulated','scheduled','sent','failed') NOT NULL DEFAULT 'simulated'
        COMMENT '"sent" uniquement sur confirmation réelle du service (T-27)',
    sent_at DATETIME NULL,
    failure_reason VARCHAR(500) NULL,
    created_by INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_msg_application (application_id),
    KEY idx_msg_candidate (candidate_id),
    CONSTRAINT fk_msg_application FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_msg_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id),
    CONSTRAINT fk_msg_template FOREIGN KEY (template_id) REFERENCES notification_templates (id),
    CONSTRAINT fk_msg_user FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS internal_notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    body VARCHAR(1000) NULL,
    link_url VARCHAR(500) NULL,
    read_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_in_user_read (user_id, read_at),
    CONSTRAINT fk_in_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS exports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    export_type VARCHAR(80) NOT NULL,
    format ENUM('pdf','xlsx','csv') NOT NULL,
    filters_json JSON NULL,
    columns_json JSON NULL,
    storage_object_id BIGINT UNSIGNED NULL,
    requested_by INT UNSIGNED NOT NULL,
    contains_personal_data TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_exports_type (export_type),
    CONSTRAINT fk_exports_storage FOREIGN KEY (storage_object_id) REFERENCES storage_objects (id),
    CONSTRAINT fk_exports_user FOREIGN KEY (requested_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS saved_report_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner_user_id INT UNSIGNED NOT NULL,
    name VARCHAR(190) NOT NULL,
    config_json JSON NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_srt_owner_name (owner_user_id, name),
    CONSTRAINT fk_srt_owner FOREIGN KEY (owner_user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
