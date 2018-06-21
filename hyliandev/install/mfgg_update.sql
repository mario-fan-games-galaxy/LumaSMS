# == COMPATIBILITY COMMANDS ==
# This is a set of SQL commands that make your TCSMS install compatible either
# with this software or with more modern servers



# Running this fixes the sessions table so that it works with more secure
# sessions TCSMS logins didn't work on my localhost because the field was too
# short
ALTER TABLE tsms_sessions
MODIFY COLUMN sessid varchar(255);



# Running this fixes the users table to that it can fit securely-hashed
# passwords
ALTER TABLE tsms_users
MODIFY COLUMN password varchar(64);