CREATE TABLE `tsms_forums` (
  `fid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned DEFAULT NULL,
  `order_place` int(11) unsigned NOT NULL DEFAULT 4294967295,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `can_post` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `can_see` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `last_post_date` datetime DEFAULT NULL,
  `last_post_id` int(11) unsigned DEFAULT NULL,
  `last_poster_uid` int(11) unsigned DEFAULT NULL,
  `last_poster_nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;