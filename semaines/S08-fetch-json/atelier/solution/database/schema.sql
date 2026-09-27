-- ClubHub : structure de la base de données
-- Usage : mysql -u clubhub -p clubhub < database/schema.sql
-- (ou phpMyAdmin → base clubhub → onglet Importer)
-- ATTENTION : ce script supprime les tables existantes.

SET NAMES utf8mb4;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('student', 'organizer') NOT NULL DEFAULT 'student',
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_users_email UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE events (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(150) NOT NULL,
    club         VARCHAR(100) NOT NULL,
    club_slug    VARCHAR(50)  NOT NULL,          -- pour le filtre JS : 'robotique', 'photo'...
    description  TEXT         NOT NULL,
    program      TEXT         NOT NULL,          -- une étape par ligne
    bring        TEXT         NOT NULL,          -- un objet par ligne
    location     VARCHAR(150) NOT NULL,
    starts_at    DATETIME     NOT NULL,
    ends_at      DATETIME     NOT NULL,
    capacity     INT UNSIGNED NOT NULL,
    organizer_id INT UNSIGNED NOT NULL,
    created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_events_organizer FOREIGN KEY (organizer_id) REFERENCES users (id),
    CONSTRAINT ck_events_dates CHECK (ends_at > starts_at),
    CONSTRAINT ck_events_capacity CHECK (capacity > 0),
    INDEX idx_events_starts_at (starts_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE registrations (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NOT NULL,
    event_id   INT UNSIGNED NOT NULL,
    motivation VARCHAR(300) NOT NULL DEFAULT '',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    -- un utilisateur ne peut s'inscrire qu'une fois au même événement
    CONSTRAINT uq_registrations_user_event UNIQUE (user_id, event_id),
    CONSTRAINT fk_registrations_user  FOREIGN KEY (user_id)  REFERENCES users (id)  ON DELETE CASCADE,
    CONSTRAINT fk_registrations_event FOREIGN KEY (event_id) REFERENCES events (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
