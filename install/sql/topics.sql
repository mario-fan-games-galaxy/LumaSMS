CREATE TABLE `tsms_topics` (
  `tid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `stickied` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `views` int(11) unsigned NOT NULL DEFAULT 0,
  `replies` int(11) unsigned NOT NULL DEFAULT 0,
  `poster_uid` int(11) unsigned DEFAULT NULL,
  `poster_nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `last_post_date` datetime DEFAULT NULL,
  `last_post_id` int(11) unsigned DEFAULT NULL,
  `last_poster_uid` int(11) unsigned DEFAULT NULL,
  `last_poster_nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;