CREATE TABLE `tsms_posts` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `blacklisted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `poster_uid` int(11) unsigned DEFAULT NULL,
  `poster_nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
