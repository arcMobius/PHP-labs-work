CREATE DATABASE IF NOT EXISTS `task_manager`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `task_manager`;

DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nickname` VARCHAR(128) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nickname_unique` (`nickname`),
    UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tasks` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `author_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `status` ENUM('new', 'in_progress', 'done') NOT NULL DEFAULT 'new',
    `priority` ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'medium',
    `deadline` DATE DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `author_id_index` (`author_id`),
    CONSTRAINT `tasks_author_fk`
        FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `comments` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `author_id` INT NOT NULL,
    `task_id` INT NOT NULL,
    `text` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `author_id_index` (`author_id`),
    KEY `task_id_index` (`task_id`),
    CONSTRAINT `comments_author_fk`
        FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `comments_task_fk`
        FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`nickname`, `email`, `password_hash`, `role`)
VALUES
    ('admin', 'admin@example.com', 'hash1', 'admin'),
    ('student', 'student@example.com', 'hash2', 'user');

INSERT INTO `tasks` (`author_id`, `title`, `description`, `status`, `priority`, `deadline`)
VALUES
    (1, 'Подготовить пояснительную записку', 'Описать цель проекта, структуру базы данных, маршруты и основные возможности приложения.', 'in_progress', 'high', '2026-06-01'),
    (1, 'Реализовать комментарии к задачам', 'Добавить таблицу comments, форму добавления комментария и страницу редактирования комментария.', 'new', 'high', '2026-06-03'),
    (2, 'Проверить работу маршрутизации', 'Убедиться, что страницы списка задач, просмотра задачи и редактирования открываются корректно.', 'new', 'medium', NULL);

INSERT INTO `comments` (`author_id`, `task_id`, `text`)
VALUES
    (1, 1, 'Нужно добавить описание предметной области.'),
    (2, 1, 'Также стоит приложить скриншоты интерфейса.'),
    (1, 2, 'Комментарии должны добавляться через POST-запрос.');