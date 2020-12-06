DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `privilege`
--

INSERT INTO `privilege` (`id`, `name`, `is_active`, `description`) VALUES
(1, 'read', 1, 'permission to read post'),
(2, 'write', 1, 'Permission to write post'),
(3, 'moderate', 1, 'permission to moderate post'),
(4, 'admin', 1, 'admin role'),
(17, 'whispering', 1, 'new description');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`, `is_active`) VALUES
(1, 'role.admin', 1),
(2, 'role.master', 1);

-- --------------------------------------------------------

--
-- Structure de la table `role_hierarchy`
--

DROP TABLE IF EXISTS `role_hierarchy`;
CREATE TABLE IF NOT EXISTS `role_hierarchy` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) UNSIGNED NOT NULL,
  `id_child` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent` (`id_parent`),
  UNIQUE KEY `child` (`id_child`),
  KEY `role_hierarchy` (`id_parent`,`id_child`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `role_hierarchy`
--

INSERT INTO `role_hierarchy` (`id`, `id_parent`, `id_child`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `role_privilege`
--

DROP TABLE IF EXISTS `role_privilege`;
CREATE TABLE IF NOT EXISTS `role_privilege` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_role` int(10) UNSIGNED NOT NULL,
  `id_privilege` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_privilege` (`id_role`,`id_privilege`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `role_privilege`
--

INSERT INTO `role_privilege` (`id`, `id_role`, `id_privilege`) VALUES
(1, 1, 17),
(3, 2, 1),
(5, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `firstname`, `email`, `password`, `date_create`) VALUES
(1, 'POUZET', 'Samuel', 'samuel.pouzet@yahoo.fr', '$2y$10$IScSkCaagS2NYr6pqpETIOM/iNP6ytLzWhhO8ZspF04PKPhwKvPWW', '2020-11-06 19:21:33');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_role` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_idx` (`id_user`,`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`id`, `id_user`, `id_role`) VALUES
(1, 1, 1);