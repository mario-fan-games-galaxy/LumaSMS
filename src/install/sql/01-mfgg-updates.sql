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

-- Other table updates
ALTER TABLE `tsms_admin_msg`
CHANGE `mid` `mid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `sender` `sender` int(11) unsigned DEFAULT NULL AFTER `mid`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `sender`,
CHANGE `title` `title` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `date`,
CHANGE `message` `message` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `title`,
CHANGE `handled_by` `handled_by` int(11) unsigned DEFAULT NULL AFTER `message`,
CHANGE `handle_date` `handle_date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `handled_by`,
CHANGE `type` `type` int(11) unsigned NOT NULL DEFAULT '0' AFTER `handle_date`,
CHANGE `aux` `aux` int(11) unsigned NOT NULL DEFAULT '0' AFTER `type`,
CHANGE `admin_comment` `admin_comment` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `aux`,
CHANGE `user_inform` `user_inform` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `admin_comment`,
CHANGE `conversation` `conversation` int(11) unsigned DEFAULT NULL AFTER `user_inform`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_comments`
CHANGE `cid` `cid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `rid` `rid` int(11) unsigned DEFAULT NULL AFTER `cid`,
CHANGE `uid` `uid` int(11) unsigned DEFAULT NULL AFTER `rid`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `uid`,
CHANGE `message` `message` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `date`,
CHANGE `ip` `ip` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `type`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_filter_group`
CHANGE `gid` `gid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `name` `name` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `gid`,
CHANGE `keyword` `keyword` varchar(16) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `name`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_filter_list`
CHANGE `fid` `fid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `gid` `gid` int(11) unsigned DEFAULT NULL AFTER `fid`,
CHANGE `name` `name` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `gid`,
CHANGE `short_name` `short_name` varchar(16) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `name`,
CHANGE `search_tags` `search_tags` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `short_name`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_filter_multi`
CHANGE `fid` `fid` int(11) unsigned DEFAULT NULL FIRST,
CHANGE `rid` `rid` int(11) unsigned DEFAULT NULL AFTER `fid`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_filter_use`
CHANGE `mid` `mid` int(11) unsigned DEFAULT NULL FIRST,
CHANGE `gid` `gid` int(11) unsigned DEFAULT NULL AFTER `mid`,
CHANGE `store_keywords` `store_keywords` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `gid`,
CHANGE `precedence` `precedence` smallint(6) unsigned NOT NULL DEFAULT '0' AFTER `store_keywords`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_groups`
CHANGE `gid` `gid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `group_name` `group_name` varchar(32) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `gid`,
CHANGE `group_title` `group_title` varchar(32) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `group_name`,
CHANGE `moderator` `moderator` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `group_title`,
CHANGE `acp_access` `acp_access` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `moderator`,
CHANGE `acp_modq` `acp_modq` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `acp_access`,
CHANGE `acp_users` `acp_users` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `acp_modq`,
CHANGE `acp_news` `acp_news` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `acp_users`,
CHANGE `acp_msg` `acp_msg` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `acp_news`,
CHANGE `can_msg_users` `can_msg_users` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `acp_msg`,
CHANGE `acp_super` `acp_super` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_msg_users`,
CHANGE `can_submit` `can_submit` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `acp_super`,
CHANGE `can_comment` `can_comment` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_submit`,
CHANGE `can_report` `can_report` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_comment`,
CHANGE `can_modify` `can_modify` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_report`,
CHANGE `can_msg` `can_msg` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_modify`,
CHANGE `use_bbcode` `use_bbcode` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_msg`,
CHANGE `edit_comment` `edit_comment` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `use_bbcode`,
CHANGE `delete_comment` `delete_comment` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `edit_comment`,
CHANGE `name_prefix` `name_prefix` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `msg_capacity`,
CHANGE `name_suffix` `name_suffix` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `name_prefix`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_mail_log`
CHANGE `lid` `lid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `uid` `uid` int(11) unsigned NULL AFTER `lid`,
CHANGE `type` `type` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `uid`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `type`,
CHANGE `ip` `ip` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `date`,
CHANGE `recipient` `recipient` int(11) unsigned NULL AFTER `ip`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_messages`
CHANGE `mid` `mid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `sender` `sender` int(11) unsigned NULL AFTER `mid`,
CHANGE `receiver` `receiver` int(11) unsigned NULL AFTER `sender`,
CHANGE `owner` `owner` int(11) unsigned NULL AFTER `receiver`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `owner`,
CHANGE `title` `title` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `date`,
CHANGE `message` `message` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `title`,
CHANGE `msg_read` `msg_read` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `message`,
CHANGE `read_date` `read_date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `msg_read`,
CHANGE `folder` `folder` smallint(6) unsigned NOT NULL DEFAULT '0' AFTER `read_date`,
CHANGE `conversation` `conversation` int(11) unsigned NULL AFTER `folder`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_modules`
CHANGE `mid` `mid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `module_name` `module_name` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `mid`,
CHANGE `class_name` `class_name` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `module_name`,
CHANGE `full_name` `full_name` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `class_name`,
CHANGE `table_name` `table_name` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `full_name`,
CHANGE `module_file` `module_file` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `table_name`,
CHANGE `template` `template` varchar(16) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `module_file`,
CHANGE `num_decisions` `num_decisions` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `template`,
CHANGE `proc_order` `proc_order` int(11) unsigned NOT NULL DEFAULT '0' AFTER `num_decisions`,
CHANGE `custom_update` `custom_update` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `proc_order`,
CHANGE `hidden` `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `custom_update`,
CHANGE `children` `children` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `hidden`,
CHANGE `ext_files` `ext_files` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `children`,
CHANGE `news_show` `news_show` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `ext_files`,
CHANGE `news_show_collapsed` `news_show_collapsed` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `news_show`,
CHANGE `news_upd` `news_upd` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `news_show_collapsed`,
CHANGE `news_upd_collapsed` `news_upd_collapsed` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `news_upd`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_news`
CHANGE `nid` `nid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `uid` `uid` int(11) unsigned DEFAULT NULL AFTER `nid`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `uid`,
CHANGE `title` `title` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `date`,
CHANGE `message` `message` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `title`,
CHANGE `update_tag` `update_tag` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `comments`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_panels`
CHANGE `pid` `pid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `eid` `eid` mediumint(8) unsigned NULL AFTER `pid`,
CHANGE `panel_type` `panel_type` varchar(16) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `eid`,
CHANGE `panel_name` `panel_name` varchar(45) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `panel_type`,
CHANGE `restricted` `restricted` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `panel_name`,
CHANGE `restrict_future` `restrict_future` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `restricted`,
CHANGE `restricted_hide` `restricted_hide` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `restrict_future`,
CHANGE `hide_header` `hide_header` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `restricted_hide`,
CHANGE `justify` `justify` char(1) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `hide_header`,
CHANGE `column` `column` char(2) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `justify`,
CHANGE `row` `row` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `column`,
CHANGE `strip_order` `strip_order` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `row`,
CHANGE `visible` `visible` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `strip_order`,
CHANGE `can_delete` `can_delete` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `visible`,
CHANGE `can_hide` `can_hide` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_delete`,
CHANGE `can_strip` `can_strip` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_hide`,
CHANGE `can_column_c` `can_column_c` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_strip`,
CHANGE `can_column_lr` `can_column_lr` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_column_c`,
CHANGE `can_fuse` `can_fuse` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_column_lr`,
CHANGE `strip_promote` `strip_promote` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `can_fuse`,
CHANGE `fuse_up` `fuse_up` int(11) unsigned NOT NULL DEFAULT '0' AFTER `strip_promote`,
CHANGE `fuse_down` `fuse_down` int(11) unsigned NOT NULL DEFAULT '0' AFTER `fuse_up`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_resources`
CHANGE `rid` `rid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `type` `type` int(11) unsigned NOT NULL DEFAULT '0' AFTER `rid`,
CHANGE `eid` `eid` int(11) unsigned NULL AFTER `type`,
CHANGE `uid` `uid` int(11) unsigned NULL AFTER `eid`,
CHANGE `title` `title` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `uid`,
CHANGE `description` `description` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `title`,
CHANGE `author_override` `author_override` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `description`,
CHANGE `website_override` `website_override` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `author_override`,
CHANGE `weburl_override` `weburl_override` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `website_override`,
CHANGE `created` `created` int(11) unsigned NOT NULL DEFAULT '0' AFTER `weburl_override`,
CHANGE `updated` `updated` int(11) unsigned NOT NULL DEFAULT '0' AFTER `created`,
CHANGE `queue_code` `queue_code` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `updated`,
CHANGE `ghost` `ghost` int(11) unsigned NOT NULL DEFAULT '0' AFTER `queue_code`,
CHANGE `update_reason` `update_reason` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `ghost`,
CHANGE `accept_date` `accept_date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `update_reason`,
CHANGE `update_accept_date` `update_accept_date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `accept_date`,
CHANGE `decision` `decision` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `update_accept_date`,
CHANGE `catwords` `catwords` mediumtext COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `decision`,
CHANGE `comments` `comments` int(11) unsigned NOT NULL DEFAULT '0' AFTER `catwords`,
CHANGE `comment_date` `comment_date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `comments`,
COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_res_games`
CHANGE `eid` `eid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `file` `file` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `eid`,
CHANGE `preview` `preview` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `file`,
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `preview`,
CHANGE `downloads` `downloads` int(11) unsigned NOT NULL DEFAULT '0' AFTER `views`,
CHANGE `file_mime` `file_mime` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `downloads`,
CHANGE `thumbnail` `thumbnail` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `file_mime`,
CHANGE `num_revs` `num_revs` int(11) unsigned NOT NULL DEFAULT '0' AFTER `thumbnail`,
CHANGE `rev_score` `rev_score` int(11) unsigned NOT NULL DEFAULT '0' AFTER `num_revs`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_res_gfx`
CHANGE `eid` `eid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `file` `file` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `eid`,
CHANGE `thumbnail` `thumbnail` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `file`,
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `thumbnail`,
CHANGE `downloads` `downloads` int(11) unsigned NOT NULL DEFAULT '0' AFTER `views`,
CHANGE `file_mime` `file_mime` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `downloads`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_res_howtos`
CHANGE `eid` `eid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `file` `file` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `eid`,
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `file`,
CHANGE `downloads` `downloads` int(11) unsigned NOT NULL DEFAULT '0' AFTER `views`,
CHANGE `file_mime` `file_mime` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `downloads`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_res_misc`
CHANGE `eid` `eid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `file` `file` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `eid`,
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `file`,
CHANGE `downloads` `downloads` int(11) unsigned NOT NULL DEFAULT '0' AFTER `views`,
CHANGE `file_mime` `file_mime` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `downloads`,
CHANGE `type1` `type1` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `file_mime`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_res_reviews`
CHANGE `eid` `eid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `gid` `gid` int(11) unsigned NULL AFTER `eid`,
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `gid`,
CHANGE `commentary` `commentary` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `views`,
CHANGE `pros` `pros` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `commentary`,
CHANGE `cons` `cons` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `pros`,
CHANGE `gameplay` `gameplay` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `cons`,
CHANGE `graphics` `graphics` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `gameplay`,
CHANGE `sound` `sound` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `graphics`,
CHANGE `replay` `replay` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `sound`,
CHANGE `gameplay_score` `gameplay_score` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `replay`,
CHANGE `graphics_score` `graphics_score` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `gameplay_score`,
CHANGE `sound_score` `sound_score` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `graphics_score`,
CHANGE `replay_score` `replay_score` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `sound_score`,
CHANGE `score` `score` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `replay_score`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_res_sounds`
CHANGE `eid` `eid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `file` `file` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `eid`,
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `file`,
CHANGE `downloads` `downloads` int(11) unsigned NOT NULL DEFAULT '0' AFTER `views`,
CHANGE `file_mime` `file_mime` varchar(64) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `downloads`,
CHANGE `type1` `type1` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `file_mime`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_sec_images`
CHANGE `sessid` `sessid` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' FIRST,
CHANGE `time` `time` int(11) unsigned NOT NULL DEFAULT '0' AFTER `sessid`,
CHANGE `regcode` `regcode` varchar(6) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `time`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_sessions`
CHANGE `uid` `uid` int(10) unsigned NULL AFTER `sessid`,
CHANGE `cookie` `cookie` char(32) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `time`,
CHANGE `ip` `ip` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `cookie`,
CHANGE `user_agent` `user_agent` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `ip`,
CHANGE `location` `location` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `user_agent`,
CHANGE `sessdata` `sessdata` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `location`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_skins`
CHANGE `sid` `sid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `name` `name` varchar(128) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `sid`,
CHANGE `author` `author` varchar(128) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `name`,
CHANGE `hidden` `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `author`,
CHANGE `default` `default` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `hidden`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_staffchat`
CHANGE `id` `id` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `uid` `uid` int(11) unsigned NULL AFTER `id`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `uid`,
CHANGE `message` `message` text COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `date`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_users`
CHANGE `uid` `uid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `gid` `gid` int(11) unsigned NULL AFTER `uid`,
CHANGE `username` `username` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `gid`,
CHANGE `email` `email` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `password`,
CHANGE `website` `website` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `email`,
CHANGE `weburl` `weburl` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `website`,
CHANGE `icon` `icon` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `weburl`,
CHANGE `aim` `aim` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `icon`,
CHANGE `icq` `icq` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `aim`,
CHANGE `msn` `msn` varchar(128) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `icq`,
CHANGE `yim` `yim` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `msn`,
CHANGE `def_order_by` `def_order_by` varchar(18) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `yim`,
CHANGE `def_order` `def_order` varchar(4) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `def_order_by`,
CHANGE `skin` `skin` smallint(6) unsigned NULL AFTER `def_order`,
CHANGE `registered_ip` `registered_ip` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `skin`,
CHANGE `show_email` `show_email` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `items_per_page`,
CHANGE `first_submit` `first_submit` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `show_email`,
CHANGE `cookie` `cookie` varchar(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `first_submit`,
CHANGE `comments` `comments` int(11) unsigned NOT NULL DEFAULT '0' AFTER `cookie`,
CHANGE `new_msgs` `new_msgs` int(11) unsigned NOT NULL DEFAULT '0' AFTER `comments`,
CHANGE `join_date` `join_date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `new_msgs`,
CHANGE `timezone` `timezone` smallint(6) NOT NULL DEFAULT '0' AFTER `join_date`,
CHANGE `dst` `dst` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `timezone`,
CHANGE `disp_msg` `disp_msg` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `dst`,
CHANGE `icon_dims` `icon_dims` varchar(9) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `disp_msg`,
CHANGE `cur_msgs` `cur_msgs` int(11) unsigned NOT NULL DEFAULT '0' AFTER `icon_dims`,
CHANGE `show_thumbs` `show_thumbs` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `cur_msgs`,
CHANGE `use_comment_msg` `use_comment_msg` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `show_thumbs`,
CHANGE `use_comment_digest` `use_comment_digest` tinyint(4) unsigned NOT NULL DEFAULT '0' AFTER `use_comment_msg`,
CHANGE `last_visit` `last_visit` int(11) unsigned NOT NULL DEFAULT '0' AFTER `use_comment_digest`,
CHANGE `last_activity` `last_activity` int(11) unsigned NOT NULL DEFAULT '0' AFTER `last_visit`,
CHANGE `last_ip` `last_ip` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '' AFTER `last_activity`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `tsms_version`
CHANGE `vid` `vid` int(11) unsigned NOT NULL AUTO_INCREMENT FIRST,
CHANGE `rid` `rid` int(11) unsigned NULL AFTER `vid`,
CHANGE `version` `version` varchar(12) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `rid`,
CHANGE `change` `change` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `version`,
CHANGE `date` `date` int(11) unsigned NOT NULL DEFAULT '0' AFTER `change`,
ENGINE='InnoDB' COLLATE 'utf8mb4_unicode_ci';
