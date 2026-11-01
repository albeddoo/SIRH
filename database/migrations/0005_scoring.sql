-- Phase 02 / Lot 0005 : Scoring versionné et explicable (catalogue §5.1)
-- Règle D-08 : tie_break_rule NULL = Option E provisoire (égalité conservée, revue humaine). Aucun départage automatique.

CREATE TABLE IF NOT EXISTS scoring_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(190) NOT NULL,
    version SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    description TEXT NULL,
    weights_must_sum_100 TINYINT(1) NOT NULL DEFAULT 1,
    tie_break_rule VARCHAR(60) NULL COMMENT 'NULL = Option E provisoire D-08 : égalité + revue humaine ; décision définitive ouverte',
    status ENUM('draft','validated','published','archived') NOT NULL DEFAULT 'draft',
    validated_by INT UNSIGNED NULL,
    validated_at DATETIME NULL,
    published_at DATETIME NULL,
    archived_at DATETIME NULL,
    created_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_template_name_version (name, version),
    CONSTRAINT fk_st_validated_by FOREIGN KEY (validated_by) REFERENCES users (id),
    CONSTRAINT fk_st_created_by FOREIGN KEY (created_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE jobs
    ADD CONSTRAINT fk_jobs_scoring_template FOREIGN KEY (scoring_template_id) REFERENCES scoring_templates (id);

CREATE TABLE IF NOT EXISTS scoring_criteria (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id BIGINT UNSIGNED NOT NULL,
    label VARCHAR(190) NOT NULL,
    criterion_type ENUM('mandatory','preferred','informative') NOT NULL DEFAULT 'mandatory',
    weight DECIMAL(6,3) NOT NULL DEFAULT 0,
    logic_json JSON NOT NULL COMMENT 'règle déclarative (champ_source, opérateur, paramètres)',
    indicative_threshold VARCHAR(190) NULL,
    tie_break_priority SMALLINT UNSIGNED NULL,
    sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_sc_template (template_id),
    CONSTRAINT fk_sc_template FOREIGN KEY (template_id) REFERENCES scoring_templates (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS application_scores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    application_id BIGINT UNSIGNED NOT NULL,
    template_id BIGINT UNSIGNED NOT NULL,
    total DECIMAL(6,2) NOT NULL,
    max_total DECIMAL(6,2) NOT NULL DEFAULT 100,
    mode ENUM('auto','manual') NOT NULL DEFAULT 'auto',
    triggered_by INT UNSIGNED NULL,
    triggered_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_current TINYINT(1) NOT NULL DEFAULT 1,
    engine_version VARCHAR(40) NOT NULL DEFAULT 'deterministic-v1',
    explanation_json JSON NULL COMMENT 'résumé explicable du calcul (honnêteté algorithmique)',
    KEY idx_as_application (application_id),
    KEY idx_as_current (is_current),
    CONSTRAINT fk_as_application FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_as_template FOREIGN KEY (template_id) REFERENCES scoring_templates (id),
    CONSTRAINT fk_as_user FOREIGN KEY (triggered_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS score_details (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    score_id BIGINT UNSIGNED NOT NULL,
    criterion_id BIGINT UNSIGNED NOT NULL,
    points DECIMAL(6,2) NOT NULL DEFAULT 0,
    max_points DECIMAL(6,2) NOT NULL DEFAULT 0,
    data_status ENUM('yes','not_observed','to_verify','confirmed_absence','not_applicable') NOT NULL DEFAULT 'not_observed'
        COMMENT 'non documenté != 0 définitif (04_MODELE_DONNEES §4)',
    justification VARCHAR(500) NULL,
    evidence_ref VARCHAR(255) NULL,
    source_field VARCHAR(120) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_sd_score (score_id),
    CONSTRAINT fk_sd_score FOREIGN KEY (score_id) REFERENCES application_scores (id) ON DELETE CASCADE,
    CONSTRAINT fk_sd_criterion FOREIGN KEY (criterion_id) REFERENCES scoring_criteria (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS score_adjustments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    score_id BIGINT UNSIGNED NOT NULL,
    old_total DECIMAL(6,2) NOT NULL,
    new_total DECIMAL(6,2) NOT NULL,
    reason VARCHAR(500) NOT NULL,
    adjusted_by INT UNSIGNED NOT NULL,
    adjusted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_sadj_score (score_id),
    CONSTRAINT fk_sadj_score FOREIGN KEY (score_id) REFERENCES application_scores (id) ON DELETE CASCADE,
    CONSTRAINT fk_sadj_user FOREIGN KEY (adjusted_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
