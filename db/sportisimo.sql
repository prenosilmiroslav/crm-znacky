SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `sportisimo` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `sportisimo`;

DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_user_id` int(11) unsigned DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `update_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `brand_ibfk_1` (`create_user_id`) USING BTREE,
  KEY `brand_ibfk_2` (`update_user_id`) USING BTREE,
  CONSTRAINT `brand_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `brand_ibfk_2` FOREIGN KEY (`update_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

INSERT INTO `brand` (`id`, `name`, `create_date`, `create_user_id`, `last_update_date`, `update_user_id`) VALUES
(1,	'Adidas',	'2023-10-10 15:57:52',	1,	NULL,	NULL),
(2,	'Arena',	'2023-10-10 15:58:02',	1,	NULL,	NULL),
(3,	'Atomic',	'2023-10-10 15:58:09',	1,	NULL,	NULL),
(4,	'Axis',	'2023-10-10 15:58:13',	1,	NULL,	NULL),
(5,	'Axa',	'2023-10-10 15:58:19',	1,	NULL,	NULL),
(6,	'Babolat',	'2023-10-10 15:58:32',	1,	NULL,	NULL),
(7,	'BCA',	'2023-10-10 15:58:38',	1,	NULL,	NULL),
(8,	'BEAL',	'2023-10-10 15:58:45',	1,	NULL,	NULL),
(9,	'Bestway',	'2023-10-10 15:58:50',	1,	NULL,	NULL),
(10,	'BOODY',	'2023-10-10 15:58:58',	1,	'2023-10-10 15:59:03',	1),
(11,	'Cebe',	'2023-10-10 15:59:08',	1,	NULL,	NULL),
(12,	'Cool',	'2023-10-10 15:59:11',	1,	NULL,	NULL),
(13,	'Cressi',	'2023-10-10 15:59:15',	1,	NULL,	NULL),
(14,	'Craft',	'2023-10-10 15:59:19',	1,	NULL,	NULL),
(15,	'Dakine',	'2023-10-10 15:59:29',	1,	NULL,	NULL),
(16,	'Diesel',	'2023-10-10 15:59:33',	1,	NULL,	NULL),
(17,	'DOLU',	'2023-10-10 15:59:36',	1,	NULL,	NULL),
(18,	'DC',	'2023-10-10 15:59:39',	1,	NULL,	NULL),
(19,	'EG',	'2023-10-10 15:59:44',	1,	NULL,	NULL),
(20,	'Elan',	'2023-10-10 15:59:49',	1,	NULL,	NULL),
(21,	'Fila',	'2023-10-10 15:59:53',	1,	NULL,	NULL),
(22,	'Fabric',	'2023-10-10 15:59:58',	1,	NULL,	NULL),
(23,	'Fisher',	'2023-10-10 16:00:03',	1,	NULL,	NULL),
(24,	'Fox',	'2023-10-10 16:00:08',	1,	NULL,	NULL),
(25,	'Gabel',	'2023-10-10 16:00:13',	1,	NULL,	NULL),
(26,	'GAP',	'2023-10-10 16:00:16',	1,	NULL,	NULL),
(27,	'Garmin',	'2023-10-10 16:00:22',	1,	NULL,	NULL),
(28,	'Halti',	'2023-10-10 16:00:26',	1,	NULL,	NULL),
(29,	'HAMMER',	'2023-10-10 16:00:31',	1,	NULL,	NULL),
(30,	'Hi-Tec',	'2023-10-10 16:00:35',	1,	'2023-10-10 16:00:38',	1),
(31,	'Husky',	'2023-10-10 16:00:43',	1,	NULL,	NULL),
(32,	'Isostar',	'2023-10-10 16:00:49',	1,	NULL,	NULL),
(33,	'Joma',	'2023-10-10 16:00:55',	1,	NULL,	NULL),
(34,	'Keen',	'2023-10-10 16:00:58',	1,	NULL,	NULL),
(35,	'Kona',	'2023-10-10 16:01:01',	1,	NULL,	NULL),
(36,	'Kross',	'2023-10-10 16:01:04',	1,	NULL,	NULL),
(37,	'LAMAX',	'2023-10-10 16:01:09',	1,	'2023-10-10 16:01:14',	1),
(38,	'LYNX',	'2023-10-10 16:01:19',	1,	NULL,	NULL),
(39,	'Mango',	'2023-10-10 16:01:25',	1,	NULL,	NULL),
(40,	'Met',	'2023-10-10 16:01:30',	1,	NULL,	NULL),
(41,	'Mitas',	'2023-10-10 16:02:53',	1,	NULL,	NULL),
(42,	'Neon',	'2023-10-10 16:02:58',	1,	NULL,	NULL),
(43,	'Nike',	'2023-10-10 16:03:02',	1,	NULL,	NULL),
(44,	'One',	'2023-10-10 16:03:06',	1,	NULL,	NULL),
(45,	'Puma',	'2023-10-10 16:03:14',	1,	NULL,	NULL),
(46,	'REX',	'2023-10-10 16:03:20',	1,	NULL,	NULL),
(47,	'Skivo',	'2023-10-10 16:03:27',	1,	NULL,	NULL),
(48,	'Sensor',	'2023-10-10 16:03:32',	1,	NULL,	NULL),
(49,	'Tendon',	'2023-10-10 16:03:39',	1,	NULL,	NULL),
(50,	'Toko',	'2023-10-10 16:03:42',	1,	NULL,	NULL),
(51,	'Umbro',	'2023-10-10 16:03:46',	1,	NULL,	NULL),
(52,	'Vans',	'2023-10-10 16:03:49',	1,	NULL,	NULL),
(53,	'Venum',	'2023-10-10 16:03:53',	1,	NULL,	NULL),
(54,	'Wish',	'2023-10-10 16:03:57',	1,	NULL,	NULL),
(55,	'WALKER',	'2023-10-10 16:04:02',	1,	NULL,	NULL),
(56,	'XISS',	'2023-10-10 16:04:05',	1,	NULL,	NULL),
(57,	'Yonex',	'2023-10-10 16:04:13',	1,	NULL,	NULL),
(58,	'Zaxy',	'2023-10-10 16:04:16',	1,	NULL,	NULL),
(59,	'Zray',	'2023-10-10 16:04:20',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `last_login_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `last_login_date`) VALUES
(1,	'admin',	'$2y$10$on0qZ2G12eVjPUOiHPQdoOMX6jAV4mhD0w2YU2p4.BwLcpDxJr8j6',	'$2y$10$WlZSjhsW.hP2x4YN25czeOCazoXdze7uWl7lwfmZr9HIzRvkU4gMi',	'2023-10-10 20:42:15'),
(2,	'test',	'$2y$10$Xc01s2e9tA516EfuvoEJX.yYq9aYrwGJEQVLJ557LuNmx/h5pJvFe',	'$2y$10$C8gSA.OKxuyqHZoKcdi1euOe5tMUPi26vEdOSCcnOWV1SlSe2xaCK',	NULL);

-- 2023-10-10 18:44:27
