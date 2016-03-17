CREATE TABLE `instagram_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `extra_id` int(11) DEFAULT NULL,
  `locked` enum('N','Y') NOT NULL DEFAULT 'N',
  `hidden` enum('N','Y') NOT NULL DEFAULT 'N',
  `created_on` datetime DEFAULT NULL,
  `edited_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;