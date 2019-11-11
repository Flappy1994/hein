CREATE TABLE IF NOT EXISTS `userdomains` (
  `username` varchar(20) NOT NULL,
  `domain` varchar(80) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `lastupdate` datetime NOT NULL,
  PRIMARY KEY (`domain`),
  KEY `username` (`username`)
)
