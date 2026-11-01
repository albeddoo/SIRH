-- Phase 02 / Lot 0004 : Recrutement — offres, candidats, documents, pipeline (catalogue §5.1/§5.2)
-- MySQL 8.4.7 cible ; InnoDB explicite partout ; utf8mb4_unicode_ci ; dates UTC.

CREATE TABLE IF NOT EXISTS skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NULL,
    job_family_id INT UNSIGNED NULL,
    archived_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_skills_name (name),
    CONSTRAINT fk_skills_family FOREIGN KEY (job_family_id) REFERENCES job_families (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS skill_aliases (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    skill_id INT UNSIGNED NOT NULL,
    alias VARCHAR(150) NOT NULL,
    approved_by INT UNSIGNED NULL,
    approved_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_skill_alias (alias),
    CONSTRAINT fk_aliases_skill FOREIGN KEY (skill_id) REFERENCES skills (id) ON DELETE CASCADE,
    CONSTRAINT fk_aliases_approver FOREIGN KEY (approved_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS jobs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(40) NOT NULL,
    company_id INT UNSIGNED NOT NULL,
    department_id INT UNSIGNED NULL,
    hiring_manager_user_id INT UNSIGNED NULL,
    recruiter_user_id INT UNSIGNED NULL,
    title VARCHAR(190) NOT NULL,
    job_family_id INT UNSIGNED NULL,
    summary TEXT NULL,
    missions TEXT NULL,
    context TEXT NULL,
    benefits TEXT NULL,
    education_min_level_id INT UNSIGNED NULL,
    field_of_study VARCHAR(150) NULL,
    experience_min_months SMALLINT UNSIGNED NULL,
    city_id INT UNSIGNED NULL,
    contract_type_id INT UNSIGNED NULL,
    work_time_type_id INT UNSIGNED NULL,
    nb_positions SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    published_at DATETIME NULL,
    closing_at DATETIME NULL,
    scoring_template_id BIGINT UNSIGNED NULL,
    status ENUM('draft','to_validate','published','suspended','closed','archived') NOT NULL DEFAULT 'draft',
    created_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_jobs_reference (reference),
    KEY idx_jobs_status (status),
    KEY idx_jobs_department (department_id),
    CONSTRAINT fk_jobs_company FOREIGN KEY (company_id) REFERENCES companies (id),
    CONSTRAINT fk_jobs_department FOREIGN KEY (department_id) REFERENCES departments (id),
    CONSTRAINT fk_jobs_manager FOREIGN KEY (hiring_manager_user_id) REFERENCES users (id),
    CONSTRAINT fk_jobs_recruiter FOREIGN KEY (recruiter_user_id) REFERENCES users (id),
    CONSTRAINT fk_jobs_family FOREIGN KEY (job_family_id) REFERENCES job_families (id),
    CONSTRAINT fk_jobs_education FOREIGN KEY (education_min_level_id) REFERENCES levels (id),
    CONSTRAINT fk_jobs_city FOREIGN KEY (city_id) REFERENCES cities (id),
    CONSTRAINT fk_jobs_contract FOREIGN KEY (contract_type_id) REFERENCES contract_types (id),
    CONSTRAINT fk_jobs_worktime FOREIGN KEY (work_time_type_id) REFERENCES work_time_types (id),
    CONSTRAINT fk_jobs_created_by FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS job_requirements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED NOT NULL,
    skill_id INT UNSIGNED NULL,
    requirement_type ENUM('mandatory','preferred','informative') NOT NULL DEFAULT 'mandatory',
    weight DECIMAL(5,2) NULL,
    priority SMALLINT UNSIGNED NULL,
    label VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_jobreq_job (job_id),
    CONSTRAINT fk_jobreq_job FOREIGN KEY (job_id) REFERENCES jobs (id) ON DELETE CASCADE,
    CONSTRAINT fk_jobreq_skill FOREIGN KEY (skill_id) REFERENCES skills (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS candidates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NULL,
    normalized_email VARCHAR(190) GENERATED ALWAYS AS (LOWER(TRIM(email))) STORED,
    phone VARCHAR(40) NULL,
    city_id INT UNSIGNED NULL,
    current_title VARCHAR(150) NULL,
    linkedin_url VARCHAR(255) NULL,
    portfolio_url VARCHAR(255) NULL,
    source_id INT UNSIGNED NULL,
    profile_status ENUM('active','archived','deleted') NOT NULL DEFAULT 'active',
    information_ack_at DATETIME NULL,
    created_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    archived_at DATETIME NULL,
    deleted_at DATETIME NULL,
    KEY idx_candidates_normemail (normalized_email),
    KEY idx_candidates_name (last_name, first_name),
    CONSTRAINT fk_candidates_city FOREIGN KEY (city_id) REFERENCES cities (id),
    CONSTRAINT fk_candidates_source FOREIGN KEY (source_id) REFERENCES sources (id),
    CONSTRAINT fk_candidates_created_by FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS resumes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT UNSIGNED NOT NULL,
    storage_object_id BIGINT UNSIGNED NOT NULL,
    is_current TINYINT(1) NOT NULL DEFAULT 1,
    parse_status ENUM('pending','parsed','failed','skipped') NOT NULL DEFAULT 'pending',
    uploaded_by INT UNSIGNED NULL,
    uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_resumes_candidate (candidate_id),
    CONSTRAINT fk_resumes_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_resumes_storage FOREIGN KEY (storage_object_id) REFERENCES storage_objects (id),
    CONSTRAINT fk_resumes_uploader FOREIGN KEY (uploaded_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS candidate_documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT UNSIGNED NOT NULL,
    storage_object_id BIGINT UNSIGNED NOT NULL,
    document_type VARCHAR(60) NOT NULL,
    label VARCHAR(190) NULL,
    uploaded_by INT UNSIGNED NULL,
    uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,
    KEY idx_candoc_candidate (candidate_id),
    CONSTRAINT fk_candoc_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_candoc_storage FOREIGN KEY (storage_object_id) REFERENCES storage_objects (id),
    CONSTRAINT fk_candoc_uploader FOREIGN KEY (uploaded_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS educations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT UNSIGNED NOT NULL,
    degree VARCHAR(190) NULL,
    specialization VARCHAR(190) NULL,
    institution VARCHAR(190) NULL,
    graduation_year SMALLINT UNSIGNED NULL,
    level_id INT UNSIGNED NULL,
    provenance ENUM('declared','extracted','verified') NOT NULL DEFAULT 'declared',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_educations_candidate (candidate_id),
    CONSTRAINT fk_edu_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_edu_level FOREIGN KEY (level_id) REFERENCES levels (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS experiences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT UNSIGNED NOT NULL,
    job_title VARCHAR(190) NULL,
    employer VARCHAR(190) NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    is_current TINYINT(1) NOT NULL DEFAULT 0,
    missions TEXT NULL,
    provenance ENUM('declared','extracted','verified') NOT NULL DEFAULT 'declared',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_experiences_candidate (candidate_id),
    CONSTRAINT fk_exp_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT chk_exp_dates CHECK (end_date IS NULL OR start_date IS NULL OR end_date >= start_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS candidate_skills (
    candidate_id INT UNSIGNED NOT NULL,
    skill_id INT UNSIGNED NOT NULL,
    level_id INT UNSIGNED NULL,
    provenance ENUM('declared','extracted','verified') NOT NULL DEFAULT 'declared',
    validation_status ENUM('unverified','verified','rejected') NOT NULL DEFAULT 'unverified',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (candidate_id, skill_id),
    CONSTRAINT fk_cs_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_cs_skill FOREIGN KEY (skill_id) REFERENCES skills (id) ON DELETE CASCADE,
    CONSTRAINT fk_cs_level FOREIGN KEY (level_id) REFERENCES levels (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS candidate_languages (
    candidate_id INT UNSIGNED NOT NULL,
    language_id INT UNSIGNED NOT NULL,
    level_id INT UNSIGNED NULL,
    documented TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (candidate_id, language_id),
    CONSTRAINT fk_cl_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_cl_language FOREIGN KEY (language_id) REFERENCES languages (id) ON DELETE CASCADE,
    CONSTRAINT fk_cl_level FOREIGN KEY (level_id) REFERENCES levels (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS applications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT UNSIGNED NOT NULL,
    job_id INT UNSIGNED NOT NULL,
    application_number VARCHAR(30) NULL,
    stage_id INT UNSIGNED NOT NULL,
    source_id INT UNSIGNED NULL,
    assigned_recruiter_user_id INT UNSIGNED NULL,
    consent_record_id BIGINT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    closed_at DATETIME NULL,
    UNIQUE KEY uq_applications_number (application_number),
    KEY idx_applications_job (job_id),
    KEY idx_applications_candidate (candidate_id),
    KEY idx_applications_stage (stage_id),
    CONSTRAINT fk_apps_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id),
    CONSTRAINT fk_apps_job FOREIGN KEY (job_id) REFERENCES jobs (id),
    CONSTRAINT fk_apps_stage FOREIGN KEY (stage_id) REFERENCES pipeline_stages (id),
    CONSTRAINT fk_apps_source FOREIGN KEY (source_id) REFERENCES sources (id),
    CONSTRAINT fk_apps_recruiter FOREIGN KEY (assigned_recruiter_user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pipeline_transitions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    from_stage_id INT UNSIGNED NOT NULL,
    to_stage_id INT UNSIGNED NOT NULL,
    allowed_role_codes VARCHAR(255) NOT NULL DEFAULT '*',
    requires_reason TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_transition (from_stage_id, to_stage_id),
    CONSTRAINT fk_pt_from FOREIGN KEY (from_stage_id) REFERENCES pipeline_stages (id) ON DELETE CASCADE,
    CONSTRAINT fk_pt_to FOREIGN KEY (to_stage_id) REFERENCES pipeline_stages (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pipeline_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NOT NULL,
    from_stage_id INT UNSIGNED NULL,
    to_stage_id INT UNSIGNED NOT NULL,
    changed_by INT UNSIGNED NULL,
    reason VARCHAR(500) NULL,
    refusal_reason_id INT UNSIGNED NULL,
    changed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_ph_application (application_id),
    CONSTRAINT fk_ph_application FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_ph_from FOREIGN KEY (from_stage_id) REFERENCES pipeline_stages (id),
    CONSTRAINT fk_ph_to FOREIGN KEY (to_stage_id) REFERENCES pipeline_stages (id),
    CONSTRAINT fk_ph_user FOREIGN KEY (changed_by) REFERENCES users (id),
    CONSTRAINT fk_ph_refusal FOREIGN KEY (refusal_reason_id) REFERENCES refusal_reasons (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS application_notes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NULL,
    candidate_id INT UNSIGNED NULL,
    author_user_id INT UNSIGNED NOT NULL,
    content TEXT NOT NULL,
    visible_rh_only TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_notes_application (application_id),
    KEY idx_notes_candidate (candidate_id),
    CONSTRAINT fk_notes_application FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_notes_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_notes_author FOREIGN KEY (author_user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS favorites (
    user_id INT UNSIGNED NOT NULL,
    application_id BIGINT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, application_id),
    CONSTRAINT fk_fav_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_fav_app FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS application_tags (
    application_id BIGINT UNSIGNED NOT NULL,
    tag_id INT UNSIGNED NOT NULL,
    created_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (application_id, tag_id),
    CONSTRAINT fk_at_app FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_at_tag FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE,
    CONSTRAINT fk_at_user FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
