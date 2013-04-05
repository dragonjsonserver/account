CREATE TABLE `accounts` (
	`account_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sessions` (
  `session_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` BIGINT(20) UNSIGNED NOT NULL,
  `sessionhash` CHAR(32) NOT NULL,
  `data` TEXT NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `sessionhash` (`sessionhash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
