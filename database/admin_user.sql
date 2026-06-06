-- Reset akun admin PPDB SD Negeri Semayu.
-- Jalankan file ini setelah database `ppdb_semayu` dibuat/import.

USE `ppdb_semayu`;

INSERT INTO `users`
(`name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`)
VALUES
('Admin PPDB', 'admin@sdnsemayu.sch.id', NULL, '$2y$12$EnZnuL2K4GKxG6TCCOgIceIGVzCOLzy/kG.mvf16DY7tKU/5adaom', 1, NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `is_admin` = 1,
    `updated_at` = NOW();
