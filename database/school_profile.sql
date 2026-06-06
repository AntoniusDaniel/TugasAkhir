-- Profil sekolah default untuk PPDB SD Negeri Semayu.
-- Jalankan setelah database `ppdb_semayu` dibuat/import.

USE `ppdb_semayu`;

CREATE TABLE IF NOT EXISTS `school_profiles` (
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

INSERT INTO `school_profiles`
(`id`, `school_name`, `tagline`, `headmaster`, `accreditation`, `description`, `vision`, `mission`, `address`, `phone`, `whatsapp`, `email`, `website`, `map_url`, `faq`, `photo_path`, `created_at`, `updated_at`)
VALUES
(1, 'SD Negeri Semayu', 'Sekolah dasar yang ramah, tertib, dan dekat dengan masyarakat.', 'Kepala SD Negeri Semayu', 'Terakreditasi', 'SD Negeri Semayu merupakan lembaga pendidikan dasar yang melayani pembelajaran dan administrasi peserta didik di wilayah Semayu. Portal PPDB ini disiapkan untuk mempermudah orang tua dalam melakukan pendaftaran peserta didik baru secara online.', 'Terwujudnya peserta didik yang berkarakter, berprestasi, mandiri, dan peduli lingkungan.', 'Menyelenggarakan pembelajaran yang aktif, tertib, dan menyenangkan.\nMenguatkan karakter peserta didik melalui pembiasaan positif.\nMeningkatkan kualitas layanan administrasi sekolah berbasis teknologi.\nMembangun komunikasi yang baik antara sekolah, peserta didik, dan orang tua.', 'Semayu, Gunungkidul, Daerah Istimewa Yogyakarta', '0274-000000', '081234567890', 'ppdb@sdnsemayu.sch.id', NULL, NULL, 'Apa saja berkas yang perlu disiapkan?|Akta kelahiran, kartu keluarga, foto calon peserta didik, dan data asal sekolah/TK.\nBagaimana cara mengecek status pendaftaran?|Gunakan nomor pendaftaran dan tanggal lahir pada halaman Cek Status.\nKapan hasil seleksi diumumkan?|Hasil seleksi ditampilkan pada halaman Pengumuman setelah panitia mempublikasikannya.', NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `school_name` = VALUES(`school_name`),
    `tagline` = VALUES(`tagline`),
    `headmaster` = VALUES(`headmaster`),
    `accreditation` = VALUES(`accreditation`),
    `description` = VALUES(`description`),
    `vision` = VALUES(`vision`),
    `mission` = VALUES(`mission`),
    `address` = VALUES(`address`),
    `phone` = VALUES(`phone`),
    `whatsapp` = VALUES(`whatsapp`),
    `email` = VALUES(`email`),
    `faq` = VALUES(`faq`),
    `updated_at` = NOW();
