-- == COMPATIBILITY COMMANDS ==
-- This is a set of SQL commands that make your TCSMS install compatible either
-- with this software or with more modern servers

-- Running this fixes the sessions table so that it works with more secure
-- sessions TCSMS logins didn't work on my localhost because the field was too
-- short
ALTER TABLE `tsms_sessions`
  CHANGE `sessid` `sessid` varchar(191) COLLATE 'utf8mb4_unicode_ci' NOT NULL FIRST;

-- Running this fixes the users table to that it can fit securely-hashed
-- passwords
ALTER TABLE `tsms_users`
  CHANGE `password` `password` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `username`;