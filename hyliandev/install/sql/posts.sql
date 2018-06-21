CREATE TABLE IF NOT EXISTS tsms_posts (
	pid int unsigned not null primary key auto_increment,
	tid int unsigned,
	message text,
	date int unsigned,
	blacklisted tinyint,
	poster_uid int unsigned,
	poster_nickname varchar(255)
);