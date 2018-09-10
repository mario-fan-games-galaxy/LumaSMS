CREATE TABLE IF NOT EXISTS tsms_login_attempts (
	id int unsigned not null primary key auto_increment,
	uid int unsigned,
	date int unsigned,
	user_agent text,
	ip varchar(255),
	success tinyint
);