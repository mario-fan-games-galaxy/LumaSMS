CREATE TABLE IF NOT EXISTS tsms_forums (
	fid int unsigned not null primary key auto_increment,
	pid int unsigned,
	order_place int unsigned,
	title varchar(255),
	description text,
	can_post text,
	can_see text,
	last_post_date int unsigned,
	last_post_id int unsigned,
	last_poster_uid int unsigned,
	last_poster_nickname varchar(255)
);