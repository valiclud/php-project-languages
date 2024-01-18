DROP TABLE IF EXISTS `original_text`;
CREATE TABLE `original_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `text_img` longblob  NULL,
  `century` int NOT NULL,
  `insert_date` date NOT NULL,
  `hits` int NOT NULL,
  `place_id` int(11) NOT NULL,
  `old_language_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `translated_text`;
CREATE TABLE `translated_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255),
  `title` varchar(255),
  `text` longtext,
  `language` varchar(255),
  `insert_date` date,
  `revision` int,
  `original_text_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `place`;
CREATE TABLE `place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `old_language`;
CREATE TABLE `old_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_language` varchar(255) NOT NULL,
  `period` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pagination`;
CREATE TABLE `pagination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(255) NOT NULL,
  `results` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

alter table `translated_text`
    add foreign key (original_text_id) references original_text(id);
alter table `original_text`
    add foreign key (old_language_id) references old_language(id);
alter table `original_text`
    add foreign key (place_id) references place(id);


