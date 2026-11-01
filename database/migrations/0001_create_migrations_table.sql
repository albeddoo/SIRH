-- Phase 01 socle technique - table technique des migrations (catalogue 04_MODELE_DONNEES.md, classée technique)
-- Forward-only, reproductible sur base vierge (T-33, adaptée poste unique via D-26).

CREATE TABLE IF NOT EXISTS migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL UNIQUE,
    checksum CHAR(64) NOT NULL,
    applied_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
