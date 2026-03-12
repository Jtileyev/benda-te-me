-- Run this after importing the main dump.
-- Temporary credentials:
--   email: admin@benda-te-me.com
--   password: BendaAdmin#2026!
-- Change password after first login.

INSERT INTO `users`
    (`name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`)
VALUES
    (
        'Admin',
        'admin@benda-te-me.com',
        NOW(),
        '$2y$10$X8WSIDtROvsWFHY/TThyM.4OwPZUSVpXSLnbbDR7Wm1vhWLw.DIoe',
        'admin',
        'active',
        NULL,
        NOW(),
        NOW()
    )
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = 'admin',
    `status` = 'active',
    `updated_at` = NOW();
