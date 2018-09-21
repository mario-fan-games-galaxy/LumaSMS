CREATE TABLE `tsms_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip` varbinary(16) NOT NULL DEFAULT '',
  `success` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;