-- Database PPDB SD Negeri Semayu
-- Import file ini melalui phpMyAdmin atau MySQL client.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `ppdb_semayu`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `ppdb_semayu`;

DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `applicants`;
DROP TABLE IF EXISTS `school_profiles`;
DROP TABLE IF EXISTS `admission_settings`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch` int NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `is_admin` tinyint(1) NOT NULL DEFAULT 0,
    `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
    `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `user_id` bigint unsigned DEFAULT NULL,
    `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_agent` text COLLATE utf8mb4_unicode_ci,
    `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_activity` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
    `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `expiration` int NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `expiration` int NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `attempts` tinyint unsigned NOT NULL,
    `reserved_at` int unsigned DEFAULT NULL,
    `available_at` int unsigned NOT NULL,
    `created_at` int unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `total_jobs` int NOT NULL,
    `pending_jobs` int NOT NULL,
    `failed_jobs` int NOT NULL,
    `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `options` mediumtext COLLATE utf8mb4_unicode_ci,
    `cancelled_at` int DEFAULT NULL,
    `created_at` int NOT NULL,
    `finished_at` int DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admission_settings` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SD Negeri Semayu',
    `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2026/2027',
    `quota` int unsigned NOT NULL DEFAULT 28,
    `reserve_quota` int unsigned NOT NULL DEFAULT 5,
    `registration_start` date DEFAULT NULL,
    `registration_end` date DEFAULT NULL,
    `is_registration_open` tinyint(1) NOT NULL DEFAULT 1,
    `is_announcement_published` tinyint(1) NOT NULL DEFAULT 0,
    `requirements` text COLLATE utf8mb4_unicode_ci,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `school_profiles` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SD Negeri Semayu',
    `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `headmaster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `accreditation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    `vision` text COLLATE utf8mb4_unicode_ci,
    `mission` text COLLATE utf8mb4_unicode_ci,
    `address` text COLLATE utf8mb4_unicode_ci,
    `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `map_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `faq` text COLLATE utf8mb4_unicode_ci,
    `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `applicants` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint unsigned DEFAULT NULL,
    `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `student_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `birth_date` date NOT NULL,
    `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
    `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `previous_school` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `parent_phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
    `parent_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `birth_certificate_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `family_card_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `verification_status` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
    `selection_status` enum('waiting','accepted','reserve','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
    `selection_note` text COLLATE utf8mb4_unicode_ci,
    `verification_note` text COLLATE utf8mb4_unicode_ci,
    `verified_at` timestamp NULL DEFAULT NULL,
    `decided_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `applicants_registration_number_unique` (`registration_number`),
    KEY `applicants_user_id_foreign` (`user_id`),
    CONSTRAINT `applicants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_30_120000_add_is_admin_to_users_table', 1),
(5, '2026_04_30_120100_create_admission_settings_table', 1),
(6, '2026_04_30_120200_create_applicants_table', 1),
(7, '2026_05_15_000000_create_school_profiles_table', 1),
(8, '2026_05_25_000000_add_user_id_to_applicants_table', 1),
(9, '2026_06_06_000000_add_selection_note_to_applicants_table', 1);

INSERT INTO `users`
(`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`)
VALUES
(1, 'Admin PPDB', 'admin@sdnsemayu.sch.id', NULL, '$2y$12$EnZnuL2K4GKxG6TCCOgIceIGVzCOLzy/kG.mvf16DY7tKU/5adaom', 1, NULL, '2026-05-02 00:00:00', '2026-05-02 00:00:00'),
(2, 'Daniel Prasetyo', 'orangtua@example.com', NULL, '$2y$12$EnZnuL2K4GKxG6TCCOgIceIGVzCOLzy/kG.mvf16DY7tKU/5adaom', 0, NULL, '2026-05-02 00:00:00', '2026-05-02 00:00:00');

INSERT INTO `admission_settings`
(`id`, `school_name`, `academic_year`, `quota`, `reserve_quota`, `registration_start`, `registration_end`, `is_registration_open`, `is_announcement_published`, `requirements`, `created_at`, `updated_at`)
VALUES
(1, 'SD Negeri Semayu', '2026/2027', 28, 5, '2026-06-02', '2026-08-02', 1, 1, 'Akta kelahiran calon peserta didik\nKartu keluarga\nFoto calon peserta didik\nData asal sekolah/TK\nNomor telepon orang tua/wali yang aktif', '2026-05-02 00:00:00', '2026-05-02 00:00:00');

INSERT INTO `school_profiles`
(`id`, `school_name`, `tagline`, `headmaster`, `accreditation`, `description`, `vision`, `mission`, `address`, `phone`, `whatsapp`, `email`, `website`, `map_url`, `faq`, `photo_path`, `created_at`, `updated_at`)
VALUES
(1, 'SD Negeri Semayu', 'Sekolah dasar yang ramah, tertib, dan dekat dengan masyarakat.', 'Kepala SD Negeri Semayu', 'Terakreditasi', 'SD Negeri Semayu merupakan lembaga pendidikan dasar yang melayani pembelajaran dan administrasi peserta didik di wilayah Semayu. Portal PPDB ini disiapkan untuk mempermudah orang tua dalam melakukan pendaftaran peserta didik baru secara online.', 'Terwujudnya peserta didik yang berkarakter, berprestasi, mandiri, dan peduli lingkungan.', 'Menyelenggarakan pembelajaran yang aktif, tertib, dan menyenangkan.\nMenguatkan karakter peserta didik melalui pembiasaan positif.\nMeningkatkan kualitas layanan administrasi sekolah berbasis teknologi.\nMembangun komunikasi yang baik antara sekolah, peserta didik, dan orang tua.', 'Semayu, Gunungkidul, Daerah Istimewa Yogyakarta', '0274-000000', '081234567890', 'ppdb@sdnsemayu.sch.id', NULL, NULL, 'Apa saja berkas yang perlu disiapkan?|Akta kelahiran, kartu keluarga, foto calon peserta didik, dan data asal sekolah/TK.\nBagaimana cara mengecek status pendaftaran?|Gunakan nomor pendaftaran dan tanggal lahir pada halaman Cek Status.\nKapan hasil seleksi diumumkan?|Hasil seleksi ditampilkan pada halaman Pengumuman setelah panitia mempublikasikannya.', NULL, '2026-05-02 00:00:00', '2026-05-02 00:00:00');

INSERT INTO `applicants`
(`id`, `user_id`, `registration_number`, `student_name`, `nisn`, `birth_place`, `birth_date`, `gender`, `religion`, `address`, `previous_school`, `parent_name`, `parent_phone`, `parent_email`, `birth_certificate_path`, `family_card_path`, `photo_path`, `verification_status`, `selection_status`, `selection_note`, `verification_note`, `verified_at`, `decided_at`, `created_at`, `updated_at`)
VALUES
(1, 2, 'PPDB-2026-0001', 'Bima Pratama', '1234567890', 'Gunungkidul', '2019-05-12', 'L', 'Kristen', 'Semayu, Gunungkidul', 'TK Pertiwi Semayu', 'Daniel Prasetyo', '081234567890', 'orangtua@example.com', 'sample/akta.pdf', 'sample/kk.pdf', 'sample/foto.jpg', 'verified', 'accepted', NULL, 'Data contoh untuk demo sistem.', '2026-05-02 00:00:00', '2026-05-02 00:00:00', '2026-05-02 00:00:00', '2026-05-02 00:00:00');
