--
-- Structure de la table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `author` VARCHAR(255) NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB, CHARSET=utf8;

--
-- Structure de la table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pseudo` VARCHAR(255) NOT NULL,
  `mailAdress` VARCHAR(255) NOT NULL,
  `gHash` VARCHAR(255) NOT NULL,
  `comment` TEXT NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
