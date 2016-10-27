CREATE TABLE IF NOT EXISTS `instagram_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `user_id` varchar(50) NOT NULL DEFAULT '',
  `extra_id` int(11) NOT NULL,
  `locked` enum('N','Y') NOT NULL DEFAULT 'N',
  `hidden` enum('N','Y') NOT NULL DEFAULT 'N',
  `created_on` datetime DEFAULT NULL,
  `edited_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
