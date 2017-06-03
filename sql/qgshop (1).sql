-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-06 18:10:05
-- 服务器版本： 10.1.9-MariaDB
-- PHP Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qgshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `qgs_addons`
--

CREATE TABLE IF NOT EXISTS `qgs_addons` (
  `id` int(10) unsigned NOT NULL COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='插件表';

-- --------------------------------------------------------

--
-- 表的结构 `qgs_admin`
--

CREATE TABLE IF NOT EXISTS `qgs_admin` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `tel` varchar(13) NOT NULL COMMENT '账号(手机号)',
  `pwd` varchar(80) NOT NULL COMMENT '密码',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `email` varchar(100) NOT NULL COMMENT '邮箱',
  `headimg` varchar(50) NOT NULL COMMENT '头像',
  `type` int(1) NOT NULL DEFAULT '2' COMMENT '类型,1-超级管理员,2-普通管理员',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

--
-- 转存表中的数据 `qgs_admin`
--

INSERT INTO `qgs_admin` (`id`, `tel`, `pwd`, `name`, `email`, `headimg`, `type`, `status`, `createtime`) VALUES
(1, '13047069417', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 'admin@admin.com', '/images/aheads/9.png', 1, 1, 1469160977),
(2, '13431660933', 'e10adc3949ba59abbe56e057f20f883e', 'samhong', '739992036@qq.com', '/images/aheads/6.png', 2, 1, 1469169058),
(3, '13048069564', 'd41d8cd98f00b204e9800998ecf8427e', 'admin', 'hahah@163.com', '/images/aheads/5.png', 2, 0, 1469170092),
(4, '13431660289', 'e10adc3949ba59abbe56e057f20f883e', 'test', 'haha@test.com', '/images/aheads/13.png', 2, 0, 1469255265),
(5, '13048596782', 'd41d8cd98f00b204e9800998ecf8427e', '测试账号', 'haha@163.com', '/images/aheads/7.png', 2, 1, 1469606743),
(6, '13048025689', '56fafa8964024efa410773781a5f9e93', '测试', 'haha@123.com', '/images/aheads/13.png', 2, 0, 1481700973),
(7, '13045678925', '46f94c8de14fb36680850768ff1b7f2a', 'testzc', 'hungbhas@123.com', '/images/aheads/12.png', 2, 0, 1481701634);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_attachment`
--

CREATE TABLE IF NOT EXISTS `qgs_attachment` (
  `id` int(10) unsigned NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '附件名',
  `type` varchar(20) DEFAULT NULL COMMENT '附件类型',
  `size` bigint(20) NOT NULL DEFAULT '0' COMMENT '附件大小',
  `url` varchar(300) NOT NULL COMMENT '又拍云地址',
  `channel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '上传渠道,@0:后台,@1:前台',
  `action` varchar(30) DEFAULT NULL COMMENT '操作类型',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '使用状态,@0:未使用,@1:已使用',
  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COMMENT='附件表';

--
-- 转存表中的数据 `qgs_attachment`
--

INSERT INTO `qgs_attachment` (`id`, `uid`, `title`, `type`, `size`, `url`, `channel`, `action`, `status`, `createtime`) VALUES
(1, 6, 'himg201612131028175048', 'JPEG', 95357, '/2016/12/13/02/28/17/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'himg', 1, 1481596097),
(8, 6, 'himg201612131130449422', 'JPEG', 120252, '/2016/12/13/03/30/44/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'himg', 1, 1481599844),
(9, 6, 'himg201612131136391863', 'JPEG', 120252, '/2016/12/13/03/36/38/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'himg', 1, 1481600199),
(4, 0, 'admin201612131053046860', 'JPEG', 120252, '/2016/12/13/02/53/04/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 0, 'admin', 1, 1481597584),
(11, 6, 'himg201612131137343776', 'JPEG', 95357, '/2016/12/13/03/37/34/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'himg', 1, 1481600254),
(10, 6, 'himg201612131137251325', 'JPEG', 120252, '/2016/12/13/03/37/25/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'himg', 1, 1481600245),
(7, 0, 'admin201612131059342979', 'file', 928, '/2016/12/13/02/59/34/upload_b6dda110b106106b7d042a603c636bcb.txt', 0, 'admin', 1, 1481597974),
(12, 6, 'comimg201612131622273722', 'JPEG', 361945, '/2016/12/13/08/22/27/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481617347),
(13, 6, 'comimg201612131626032430', 'JPEG', 94031, '/2016/12/13/08/26/03/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481617563),
(14, 6, 'comimg201612131649501286', 'JPEG', 361945, '/2016/12/13/08/49/47/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481618990),
(15, 6, 'comimg201612131650022243', 'JPEG', 94031, '/2016/12/13/08/50/02/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481619002),
(16, 6, 'comimg201612131650207252', 'JPEG', 94031, '/2016/12/13/08/50/20/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481619020),
(17, 6, 'comimg201612131705173673', 'JPEG', 94031, '/2016/12/13/09/05/17/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481619917),
(18, 6, 'comimg201612131705213202', 'JPEG', 70373, '/2016/12/13/09/05/21/upload_8a269889b97e3d63f0f27dd2c4c20abf.jpg', 1, 'comimg', 1, 1481619921),
(19, 6, 'comimg201612131705356587', 'JPEG', 148748, '/2016/12/13/09/05/35/upload_556cbcd05b37fd409efe770d51b2c0f5.jpg', 1, 'comimg', 1, 1481619935),
(20, 6, 'comimg201612131705439408', 'JPEG', 235699, '/2016/12/13/09/05/43/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg', 1, 'comimg', 1, 1481619943),
(21, 6, 'comimg201612131705497152', 'JPEG', 75229, '/2016/12/13/09/05/49/upload_7880598f5577ad4ee72760ff0fd53b18.jpg', 1, 'comimg', 1, 1481619949),
(22, 6, 'comimg201612131705595106', 'JPEG', 113570, '/2016/12/13/09/05/59/upload_0e862eb18d284d9edabbc590ceee4c07.jpg', 1, 'comimg', 1, 1481619959),
(23, 6, 'comimg201612131707441720', 'JPEG', 94031, '/2016/12/13/09/07/43/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481620064),
(24, 6, 'comimg201612131707483062', 'JPEG', 70373, '/2016/12/13/09/07/48/upload_8a269889b97e3d63f0f27dd2c4c20abf.jpg', 1, 'comimg', 1, 1481620068),
(25, 6, 'comimg201612131707517435', 'JPEG', 120252, '/2016/12/13/09/07/51/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481620071),
(26, 6, 'comimg201612131707548530', 'JPEG', 107684, '/2016/12/13/09/07/54/upload_2c3d5175e76a19ffe7dc2608ecab26bb.jpg', 1, 'comimg', 1, 1481620074),
(27, 6, 'comimg201612131707588924', 'JPEG', 95357, '/2016/12/13/09/07/57/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'comimg', 1, 1481620078),
(28, 6, 'comimg201612131707592303', 'JPEG', 235699, '/2016/12/13/09/07/59/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg', 1, 'comimg', 1, 1481620079),
(29, 6, 'comimg201612131708033805', 'JPEG', 75229, '/2016/12/13/09/08/03/upload_7880598f5577ad4ee72760ff0fd53b18.jpg', 1, 'comimg', 1, 1481620083),
(30, 6, 'comimg201612131708114202', 'JPEG', 66317, '/2016/12/13/09/08/11/upload_8071f4965f495d497dc63ddcfb428e1e.jpg', 1, 'comimg', 1, 1481620091),
(31, 6, 'comimg201612131713302479', 'JPEG', 361945, '/2016/12/13/09/13/30/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481620410),
(32, 6, 'comimg201612131713392745', 'JPEG', 95357, '/2016/12/13/09/13/38/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'comimg', 1, 1481620419),
(33, 6, 'comimg201612131713431006', 'JPEG', 120252, '/2016/12/13/09/13/43/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481620423),
(34, 6, 'comimg201612131713509613', 'JPEG', 85464, '/2016/12/13/09/13/50/upload_e48c0d7918931e75fb71fbec24d77829.jpg', 1, 'comimg', 1, 1481620430),
(35, 6, 'comimg201612131713594280', 'JPEG', 66317, '/2016/12/13/09/13/57/upload_8071f4965f495d497dc63ddcfb428e1e.jpg', 1, 'comimg', 1, 1481620439),
(36, 6, 'comimg201612131714035505', 'JPEG', 148748, '/2016/12/13/09/14/03/upload_556cbcd05b37fd409efe770d51b2c0f5.jpg', 1, 'comimg', 1, 1481620443),
(37, 6, 'comimg201612131731256696', 'JPEG', 370843, '/2016/12/13/09/31/25/upload_bb0b53cef0031ef670f9b1ae7f72efc0.jpg', 1, 'comimg', 1, 1481621485),
(38, 6, 'comimg201612131731446485', 'JPEG', 120252, '/2016/12/13/09/31/44/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481621504),
(39, 6, 'comimg201612131731475783', 'JPEG', 95357, '/2016/12/13/09/31/47/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'comimg', 1, 1481621507),
(40, 6, 'comimg201612131731576528', 'JPEG', 107684, '/2016/12/13/09/31/57/upload_2c3d5175e76a19ffe7dc2608ecab26bb.jpg', 1, 'comimg', 1, 1481621517),
(41, 6, 'comimg201612131732131411', 'JPEG', 235699, '/2016/12/13/09/32/13/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg', 1, 'comimg', 1, 1481621533),
(42, 6, 'comimg201612131732196560', 'JPEG', 164928, '/2016/12/13/09/32/18/upload_a6a91803f612005e2d22a33027b3dd30.jpg', 1, 'comimg', 1, 1481621539),
(43, 6, 'comimg201612140925399528', 'JPEG', 94031, '/2016/12/14/01/25/39/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481678739),
(44, 6, 'comimg201612140925458132', 'JPEG', 113570, '/2016/12/14/01/25/45/upload_0e862eb18d284d9edabbc590ceee4c07.jpg', 1, 'comimg', 1, 1481678745),
(45, 6, 'comimg201612140925486767', 'JPEG', 95357, '/2016/12/14/01/25/48/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'comimg', 1, 1481678748),
(46, 6, 'comimg201612140925529825', 'JPEG', 120252, '/2016/12/14/01/25/52/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481678752),
(47, 6, 'comimg201612140925559419', 'JPEG', 107684, '/2016/12/14/01/25/55/upload_2c3d5175e76a19ffe7dc2608ecab26bb.jpg', 1, 'comimg', 1, 1481678755),
(48, 6, 'comimg201612140925589661', 'JPEG', 70373, '/2016/12/14/01/25/58/upload_8a269889b97e3d63f0f27dd2c4c20abf.jpg', 1, 'comimg', 1, 1481678758),
(49, 6, 'comimg201612140926027005', 'JPEG', 148748, '/2016/12/14/01/26/02/upload_556cbcd05b37fd409efe770d51b2c0f5.jpg', 1, 'comimg', 1, 1481678762),
(50, 6, 'comimg201612140926066828', 'JPEG', 164928, '/2016/12/14/01/26/06/upload_a6a91803f612005e2d22a33027b3dd30.jpg', 1, 'comimg', 1, 1481678766),
(51, 6, 'comimg201612140952186944', 'JPEG', 361945, '/2016/12/14/01/52/18/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481680338),
(52, 6, 'comimg201612140952287583', 'JPEG', 95357, '/2016/12/14/01/52/28/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'comimg', 1, 1481680348),
(53, 6, 'comimg201612140952313252', 'JPEG', 120252, '/2016/12/14/01/52/31/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481680351),
(54, 6, 'comimg201612140952426950', 'JPEG', 85464, '/2016/12/14/01/52/42/upload_e48c0d7918931e75fb71fbec24d77829.jpg', 1, 'comimg', 1, 1481680362),
(55, 6, 'comimg201612140952549609', 'JPEG', 148748, '/2016/12/14/01/52/54/upload_556cbcd05b37fd409efe770d51b2c0f5.jpg', 1, 'comimg', 1, 1481680374),
(56, 6, 'comimg201612140952585656', 'JPEG', 113570, '/2016/12/14/01/52/58/upload_0e862eb18d284d9edabbc590ceee4c07.jpg', 1, 'comimg', 1, 1481680378),
(57, 6, 'comimg201612140953034132', 'JPEG', 120252, '/2016/12/14/01/53/03/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481680383),
(58, 6, 'comimg201612141137345916', 'JPEG', 361945, '/2016/12/14/03/37/33/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481686654),
(59, 6, 'comimg201612141138356766', 'JPEG', 361945, '/2016/12/14/03/38/35/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481686715),
(60, 6, 'comimg201612141139086209', 'JPEG', 94031, '/2016/12/14/03/39/07/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481686748),
(61, 6, 'comimg201612141140079295', 'JPEG', 361945, '/2016/12/14/03/40/06/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481686807),
(62, 6, 'comimg201612141142312434', 'JPEG', 361945, '/2016/12/14/03/42/31/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481686951),
(63, 6, 'comimg201612141143163185', 'JPEG', 361945, '/2016/12/14/03/43/16/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'comimg', 1, 1481686996),
(64, 6, 'comimg201612141145507787', 'JPEG', 94031, '/2016/12/14/03/45/50/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'comimg', 1, 1481687150),
(65, 6, 'comimg201612141145532956', 'JPEG', 95357, '/2016/12/14/03/45/53/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'comimg', 1, 1481687153),
(66, 6, 'comimg201612141145594357', 'JPEG', 120252, '/2016/12/14/03/45/58/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1481687159),
(67, 6, 'comimg201612141146061345', 'JPEG', 85464, '/2016/12/14/03/46/06/upload_e48c0d7918931e75fb71fbec24d77829.jpg', 1, 'comimg', 1, 1481687166),
(68, 6, 'comimg201612141146087745', 'JPEG', 235699, '/2016/12/14/03/46/08/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg', 1, 'comimg', 1, 1481687168),
(69, 6, 'comimg201612141146114274', 'JPEG', 107684, '/2016/12/14/03/46/10/upload_2c3d5175e76a19ffe7dc2608ecab26bb.jpg', 1, 'comimg', 1, 1481687171),
(70, 6, 'comimg201612141146138438', 'JPEG', 161640, '/2016/12/14/03/46/13/upload_3fff051a20861480152c70f360b5e808.jpg', 1, 'comimg', 1, 1481687173),
(71, 6, 'comimg201612141146232445', 'JPEG', 70373, '/2016/12/14/03/46/23/upload_8a269889b97e3d63f0f27dd2c4c20abf.jpg', 1, 'comimg', 1, 1481687183),
(72, 6, 'file201612141516451905', 'JPEG', 120252, '/2016/12/14/07/16/44/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'file', 1, 1481699805),
(73, 6, 'file201612141516474004', 'JPEG', 95357, '/2016/12/14/07/16/42/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'file', 1, 1481699807),
(74, 6, 'file201612141516473338', 'JPEG', 75229, '/2016/12/14/07/16/47/upload_7880598f5577ad4ee72760ff0fd53b18.jpg', 1, 'file', 1, 1481699807),
(75, 6, 'file201612141516505501', 'JPEG', 235699, '/2016/12/14/07/16/50/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg', 1, 'file', 1, 1481699810),
(76, 6, 'file201612141520257511', 'JPEG', 85464, '/2016/12/14/07/20/24/upload_e48c0d7918931e75fb71fbec24d77829.jpg', 1, 'file', 1, 1481700025),
(77, 6, 'file201612141520279732', 'JPEG', 164928, '/2016/12/14/07/20/27/upload_a6a91803f612005e2d22a33027b3dd30.jpg', 1, 'file', 1, 1481700027),
(78, 6, 'file201612141520303301', 'JPEG', 235699, '/2016/12/14/07/20/30/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg', 1, 'file', 1, 1481700030),
(79, 6, 'file201612141520333693', 'JPEG', 94031, '/2016/12/14/07/20/33/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 1, 'file', 1, 1481700033),
(80, 0, 'admin201612141559297925', 'JPEG', 164928, '/2016/12/14/07/59/29/upload_a6a91803f612005e2d22a33027b3dd30.jpg', 0, 'admin', 1, 1481702369),
(81, 6, 'comimg201612171112485078', 'JPEG', 90612, '/2016/12/17/03/12/48/upload_7a621fd852c5ac93324a40bf4ed609e9.JPG', 1, 'comimg', 1, 1481944368),
(82, 6, 'comimg201612171113049920', 'JPEG', 96014, '/2016/12/17/03/13/04/upload_b62e562b453057b076dad1919bb414e4.JPG', 1, 'comimg', 1, 1481944384),
(83, 6, 'comimg201612171943096688', 'JPEG', 90612, '/2016/12/17/11/43/08/upload_7a621fd852c5ac93324a40bf4ed609e9.JPG', 1, 'comimg', 1, 1481974989),
(84, 6, 'comimg201612171944017030', 'JPEG', 96014, '/2016/12/17/11/44/00/upload_b62e562b453057b076dad1919bb414e4.JPG', 1, 'comimg', 1, 1481975041),
(85, 0, 'admin201612181600587969', 'JPEG', 457801, '/2016/12/18/08/00/57/upload_ee9e6252bc9ffefa1652d0075d6834bc.JPG', 0, 'admin', 1, 1482048058),
(86, 0, 'admin201612190940413251', 'JPEG', 221720, '/2016/12/19/01/40/40/upload_53672fdd3911ac84376e302939509f14.jpg', 0, 'admin', 1, 1482111641),
(87, 0, 'admin201612191117288371', 'JPEG', 94031, '/2016/12/19/03/17/27/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg', 0, 'admin', 1, 1482117448),
(88, 0, 'admin201612191128519954', 'JPEG', 361945, '/2016/12/19/03/28/50/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 0, 'admin', 1, 1482118131),
(89, 0, 'admin201612191129297357', 'JPEG', 361945, '/2016/12/19/03/29/29/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 0, 'admin', 1, 1482118169),
(90, 0, 'admin201612191143516178', 'JPEG', 361945, '/2016/12/19/03/43/51/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 0, 'admin', 1, 1482119031),
(91, 0, 'admin201612191153055142', 'JPEG', 120252, '/2016/12/19/03/53/05/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 0, 'admin', 0, 1482119585),
(92, 6, 'himg201612191201011070', 'JPEG', 120252, '/2016/12/19/04/01/00/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'himg', 1, 1482120061),
(93, 6, 'himg201612191203464951', 'JPEG', 95357, '/2016/12/19/04/03/46/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'himg', 1, 1482120226),
(94, 0, 'admin201612191204285282', 'JPEG', 66317, '/2016/12/19/04/04/28/upload_8071f4965f495d497dc63ddcfb428e1e.jpg', 0, 'admin', 1, 1482120268),
(95, 0, 'admin201612191318078129', 'JPEG', 73283, '/2016/12/19/05/18/07/upload_acbebe351fd27f055172e3f52d3229bd.jpg', 0, 'admin', 0, 1482124687),
(96, 0, 'admin201612191318378770', 'JPEG', 165731, '/2016/12/19/05/18/37/upload_5c9462e857fe02a61f646f4780982d2f.jpg', 0, 'admin', 1, 1482124717),
(97, 0, 'admin201612191318389172', 'JPEG', 183355, '/2016/12/19/05/18/38/upload_9410a7ed11a3bb4df232940e4a70d909.jpg', 0, 'admin', 1, 1482124718),
(98, 0, 'admin201612191410196674', 'JPEG', 73283, '/2016/12/19/06/10/19/upload_acbebe351fd27f055172e3f52d3229bd.jpg', 0, 'admin', 1, 1482127819),
(99, 6, 'comimg201612200915377320', 'JPEG', 3939796, '/2016/12/20/01/15/36/upload_b9d51ce3685b28c9dfe7df49746e7488.JPG', 1, 'comimg', 1, 1482196537),
(100, 0, 'admin201612201006216743', 'JPEG', 361945, '/2016/12/20/02/06/21/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 0, 'admin', 1, 1482199581),
(101, 6, 'file201612201141505073', 'PNG', 303129, '/2016/12/20/03/41/49/upload_3b5910b435eef322182304026f8ef190.PNG', 1, 'file', 1, 1482205310),
(102, 6, 'file201612201146565327', 'JPEG', 361945, '/2016/12/20/03/46/56/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg', 1, 'file', 1, 1482205616),
(103, 6, 'file201612201150142603', 'JPEG', 95357, '/2016/12/20/03/50/14/upload_42b15ff091851a7182acafa51db39b88.jpg', 1, 'file', 1, 1482205814),
(104, 13, 'comimg201612201430513777', 'JPEG', 175701, '/2016/12/20/06/30/51/upload_f9a88d2a6c4a84a1ec30fd7e9e8bcc68.jpeg', 1, 'comimg', 1, 1482215451),
(105, 15, 'himg201612201431115224', 'JPEG', 327419, '/2016/12/20/06/31/10/upload_1bf0ed6c2b044535b3bc30ef365fa22e.JPG', 1, 'himg', 0, 1482215471),
(106, 14, 'himg201612201433349436', 'JPEG', 1139512, '/2016/12/20/06/33/33/upload_49f8006c983edff99e2d5e89e0b6953f.JPG', 1, 'himg', 1, 1482215614),
(107, 13, 'file201612201433362252', 'JPEG', 175701, '/2016/12/20/06/33/36/upload_f9a88d2a6c4a84a1ec30fd7e9e8bcc68.jpeg', 1, 'file', 1, 1482215616),
(108, 13, 'himg201612201439261336', 'JPEG', 175701, '/2016/12/20/06/39/26/upload_f9a88d2a6c4a84a1ec30fd7e9e8bcc68.jpeg', 1, 'himg', 1, 1482215966),
(109, 12, 'himg201612201440277061', 'JPEG', 2469281, '/2016/12/20/06/40/25/upload_85ba343772addef37a36324b2f74608d.jpg', 1, 'himg', 1, 1482216027),
(110, 6, 'comimg201612201446568604', 'JPEG', 120252, '/2016/12/20/06/46/56/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 1, 'comimg', 1, 1482216416),
(111, 14, 'himg201612201502048586', 'JPEG', 1442201, '/2016/12/20/07/02/03/upload_594073a9eda7acee81dfed0cee7c8407.JPG', 1, 'himg', 1, 1482217324),
(112, 14, 'himg201612201502146473', 'JPEG', 1139512, '/2016/12/20/07/02/13/upload_49f8006c983edff99e2d5e89e0b6953f.JPG', 1, 'himg', 1, 1482217334),
(113, 14, 'himg201612201503181162', 'JPEG', 1163402, '/2016/12/20/07/03/18/upload_e62a33bf50ddeeae896a26060ca3979d.JPG', 1, 'himg', 1, 1482217398),
(114, 14, 'himg201612201503309624', 'JPEG', 1645612, '/2016/12/20/07/03/30/upload_c45b35a8163811b717f6fba59639ecb6.JPG', 1, 'himg', 1, 1482217410),
(115, 14, 'himg201612201504049562', 'JPEG', 1823795, '/2016/12/20/07/04/04/upload_1611512fc8c159b39ce717758891a504.JPG', 1, 'himg', 1, 1482217444),
(116, 8, 'himg201612201512431382', 'JPEG', 105596, '/2016/12/20/07/12/43/upload_dff43a3c96f738c4ed846d2c58c8afe7.JPG', 1, 'himg', 1, 1482217963),
(117, 13, 'himg201612201523205764', 'JPEG', 298204, '/2016/12/20/07/23/19/upload_e4aa67acc510a08cba4e8f26306b75e4.jpeg', 1, 'himg', 1, 1482218600),
(118, 13, 'himg201612201523333767', 'PNG', 2612595, '/2016/12/20/07/23/32/upload_71a150b1b7f88df5dc252a56b689f51a.png', 1, 'himg', 1, 1482218613),
(119, 13, 'himg201612201523473219', 'JPEG', 1074907, '/2016/12/20/07/23/47/upload_8cfcbe89d33d2ab0d00be184903241f0.jpeg', 1, 'himg', 1, 1482218627),
(120, 6, 'himg201612211039147799', 'JPEG', 1826636, '/2016/12/21/02/39/13/upload_3df7c74e0a124424b6b3638971795ec5.jpg', 1, 'himg', 1, 1482287954),
(121, 6, 'himg201612211048037771', 'JPEG', 1798165, '/2016/12/21/02/48/02/upload_9299d955a21ab2f068a5c09aa0a67a1a.jpg', 1, 'himg', 1, 1482288483),
(122, 6, 'comimg201612211053519194', 'JPEG', 2214378, '/2016/12/21/02/53/51/upload_7d8cabad5c2b8e12490e769671412cdc.jpg', 1, 'comimg', 1, 1482288831),
(123, 6, 'comimg201612211054128177', 'JPEG', 1844987, '/2016/12/21/02/54/11/upload_a5d33e9d10bd01aef362b957fbe13787.jpg', 1, 'comimg', 1, 1482288852),
(124, 6, 'comimg201612211054359046', 'JPEG', 2154763, '/2016/12/21/02/54/34/upload_ef3fafeb6d3eeac79e8be949da9feeb2.jpg', 1, 'comimg', 1, 1482288875),
(125, 0, 'admin201612211058553218', 'JPEG', 95292, '/2016/12/21/02/58/55/upload_42b15ff091851a7182acafa51db39b88.jpg', 0, 'admin', 1, 1482289135),
(126, 6, 'comimg201612231723407150', 'PNG', 260828, '/2016/12/23/09/23/39/upload_38ff7e91e6b2b782c696b3bc2cf27aab.png', 1, 'comimg', 1, 1482485020);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_auth_group`
--

CREATE TABLE IF NOT EXISTS `qgs_auth_group` (
  `id` mediumint(8) unsigned NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `rules` char(80) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_auth_group`
--

INSERT INTO `qgs_auth_group` (`id`, `title`, `rules`) VALUES
(1, '高级管理员', '1,2,3,4,5,7,8,9,11,12,14,15,16,18'),
(2, '普通管理员', '1,2,3,14,18,19');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `qgs_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_auth_group_access`
--

INSERT INTO `qgs_auth_group_access` (`uid`, `group_id`) VALUES
(2, 2),
(3, 1),
(4, 2),
(5, 2);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_auth_rule`
--

CREATE TABLE IF NOT EXISTS `qgs_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` char(100) NOT NULL DEFAULT '',
  `title` char(200) NOT NULL DEFAULT '',
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `condition` char(100) NOT NULL DEFAULT '',
  `params` varchar(500) DEFAULT NULL COMMENT '验证参数'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_auth_rule`
--

INSERT INTO `qgs_auth_rule` (`id`, `name`, `title`, `cid`, `type`, `condition`, `params`) VALUES
(1, 'admin/system/column', '栏目管理', 1, 0, '', NULL),
(2, 'admin/system/account', '账号管理', 1, 0, '', NULL),
(3, 'admin/system/power', '权限管理', 1, 0, '', ''),
(4, 'admin/system/addcolumn', '添加栏目', 1, 0, '', NULL),
(5, 'admin/system/editcolumn', '编辑栏目', 1, 0, '', NULL),
(6, 'admin/system/delcolumn', '删除栏目', 1, 0, '', NULL),
(7, 'admin/system/addaccount', '添加账号', 1, 0, '', NULL),
(8, 'admin/system/editaccount', '编辑账号', 1, 0, '', NULL),
(9, 'admin/system/changeaccount', '快捷设置账号', 1, 0, '', NULL),
(10, 'admin/system/delaccount', '删除账号', 1, 0, '', NULL),
(11, 'admin/system/addrule', '添加规则', 1, 0, '', NULL),
(12, 'admin/system/editrule', '编辑规则', 1, 0, '', NULL),
(13, 'admin/system/delrule', '删除规则', 1, 0, '', NULL),
(14, 'admin/system/admingroup', '查看分组', 1, 0, '', NULL),
(15, 'admin/system/addgroup', '添加分组', 1, 0, '', NULL),
(16, 'admin/system/editgroup', '编辑分组', 1, 0, '', NULL),
(17, 'admin/system/delgroup', '删除分组', 1, 0, '', NULL),
(18, 'admin/system/editmyself', '账号修改', 1, 0, '', NULL),
(19, 'admin/system/info', '通知公告', 1, 0, '', NULL),
(20, 'admin/system/addinfo', '添加消息', 1, 0, '', NULL),
(21, 'admin/system/editinfo', '编辑消息', 1, 0, '', NULL),
(22, 'admin/system/delinfo', '删除消息', 1, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_buyer`
--

CREATE TABLE IF NOT EXISTS `qgs_buyer` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `class` int(11) NOT NULL COMMENT '<0>为分拣组<1>为采购员<2>为供应商',
  `is_del` int(11) NOT NULL COMMENT '<0>未删除<1>已删除'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='采购员';

--
-- 转存表中的数据 `qgs_buyer`
--

INSERT INTO `qgs_buyer` (`id`, `name`, `class`, `is_del`) VALUES
(1, '趣果', 1, 0),
(2, '趣果勇', 1, 0),
(3, '罗梓超', 0, 0),
(4, 'XX哈哈哈', 0, 0),
(5, '趣果公司', 2, 0),
(6, '趣果集团', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_column`
--

CREATE TABLE IF NOT EXISTS `qgs_column` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `name` varchar(60) NOT NULL COMMENT '名称标识',
  `module` varchar(50) DEFAULT NULL COMMENT '模块',
  `controller` varchar(50) DEFAULT NULL COMMENT '控制器',
  `action` varchar(50) DEFAULT NULL COMMENT '方法',
  `pid` int(3) NOT NULL DEFAULT '0' COMMENT '父栏目id',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `level` int(3) NOT NULL DEFAULT '1' COMMENT '显示级数',
  `icon` varchar(60) NOT NULL DEFAULT 'glyphicon glyphicon-th-list' COMMENT '栏目图标样式'
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='后台栏目表';

--
-- 转存表中的数据 `qgs_column`
--

INSERT INTO `qgs_column` (`id`, `name`, `module`, `controller`, `action`, `pid`, `status`, `level`, `icon`) VALUES
(1, '系统模块', '', 'system', '', 0, 1, 1, 'glyphicon glyphicon-cog'),
(2, '栏目管理', 'admin', 'system', 'column', 1, 1, 1, ''),
(3, '账号管理', 'admin', 'system', 'account', 1, 1, 1, ''),
(4, '权限管理', 'admin', 'system', 'power', 1, 1, 1, ''),
(5, '账号修改', 'admin', 'system', 'editmyself', 1, 1, 1, ''),
(6, '登录日志', 'admin', 'system', 'lglog', 1, 1, 1, ''),
(7, '通知公告', 'admin', 'system', 'info', 1, 1, 1, ''),
(8, '商家模块', '', 'shoper', '', 0, 1, 1, 'glyphicon glyphicon-shopping-cart'),
(9, '基本配置', 'admin', 'shoper', 'config', 8, 1, 1, ''),
(10, '商品管理', 'admin', 'shoper', 'product', 0, 1, 1, 'fa fa-tag'),
(11, '自提点管理', 'admin', 'shoper', 'handtakeplace', 8, 1, 1, ''),
(12, '插件模块', '', 'addons', '', 0, 1, 1, 'fa fa-plug'),
(13, '插件管理', 'admin', 'addons', 'index', 12, 1, 1, ''),
(14, '钩子管理', 'admin', 'addons', 'hooks', 12, 1, 1, ''),
(15, '后台列表', 'admin', 'addons', 'adminlist', 12, 1, 1, ''),
(16, '系统信息', 'admin', 'system', 'systeminfo', 1, 1, 2, ''),
(17, '分类管理', 'admin', 'shoper', 'classify', 8, 1, 1, ''),
(18, 'banner管理', 'admin', 'shoper', 'banner', 8, 1, 1, ''),
(19, '文章管理', 'admin', 'shoper', 'article', 8, 1, 1, ''),
(20, '规格管理', 'admin', 'shoper', 'format', 8, 1, 1, ''),
(21, '公告管理', 'admin', 'shoper', 'notice', 8, 1, 1, ''),
(22, '推荐组合', 'admin', 'shoper', 'commend', 8, 1, 1, ''),
(23, '地区管理', 'admin', 'shoper', 'area', 8, 1, 1, ''),
(24, '优惠券管理', 'admin', 'shoper', 'coupon', 8, 1, 1, ''),
(25, '订单管理', 'admin', 'shoper', 'orders', 8, 1, 1, ''),
(26, '附件管理', 'admin', 'system', 'attachment', 1, 1, 1, ''),
(27, '评价管理', 'admin', 'shoper', 'comment', 8, 1, 1, ''),
(28, '售后管理', 'admin', 'shoper', 'service', 8, 1, 1, ''),
(29, '会员管理', 'admin', 'shoper', 'member', 0, 1, 1, 'fa fa-users'),
(30, '首页模版', 'admin', 'Diyindex', 'list', 0, 1, 1, 'fa fa-align-justify'),
(31, '首页列表', 'admin', 'diyindex', 'list', 30, 1, 1, ''),
(32, '积分管理', 'admin', 'shoper', 'jifenconfig', 8, 1, 1, ''),
(33, '订单模块', 'admin', 'shop', 'orderlist', 0, 1, 1, 'fa fa-list-ol'),
(34, '赠品管理', 'admin', 'Gift', 'giftlist', 0, 1, 1, 'fa fa-gift');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_coupon`
--

CREATE TABLE IF NOT EXISTS `qgs_coupon` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `shotcut` varchar(500) DEFAULT NULL COMMENT '缩略图',
  `title` varchar(100) NOT NULL COMMENT '优惠券标题',
  `description` varchar(200) DEFAULT NULL COMMENT '优惠券描述',
  `stime` int(11) NOT NULL COMMENT '开始时间',
  `etime` int(11) NOT NULL COMMENT '结束时间',
  `sid` int(11) NOT NULL COMMENT '所属商家',
  `collect_money` float(8,2) NOT NULL COMMENT '使用限定金额',
  `minus_money` float(8,2) NOT NULL COMMENT '抵扣金额',
  `discount` float(3,2) NOT NULL COMMENT '折扣',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '类型,1-无门槛现金券,2-无门槛折扣券,3-满就减,4-满就折',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='优惠券表';

--
-- 转存表中的数据 `qgs_coupon`
--

INSERT INTO `qgs_coupon` (`id`, `shotcut`, `title`, `description`, `stime`, `etime`, `sid`, `collect_money`, `minus_money`, `discount`, `type`, `status`, `createtime`) VALUES
(2, '', '测试优惠券', '啊撒旦法撒旦法撒', 1480435200, 1482940799, 1, 0.00, 123.00, 0.00, 1, 1, 1480308809),
(3, '', '测试优惠券二', '撒打发斯蒂芬发发', 1479225600, 1480348799, 1, 0.00, 0.00, 0.95, 2, 1, 1480320719),
(4, '', '优惠券测试三', '撒旦法撒旦法撒旦法', 1480521600, 1481212799, 1, 10.00, 2.00, 0.00, 3, 1, 1480309128),
(5, '', '优惠券测试四', '啊撒旦法撒旦法撒', 1480435200, 1480780799, 1, 20.00, 0.00, 0.80, 4, 1, 1480388993),
(6, '', '优惠券测试五', '撒的发送到发送到发送到分', 1480262400, 1480521599, 1, 15.00, 3.00, 0.00, 3, 1, 1480309372),
(7, 'http://qgshop.b0.upaiyun.com/2016/11/28/05/21/35/upload_7880598f5577ad4ee72760ff0fd53b18.jpg', '优惠券测试六', '', 1480176000, 1480521599, 1, 0.00, 8.50, 0.00, 1, 1, 1480310495),
(8, 'http://qgshop.b0.upaiyun.com/2016/12/14/07/59/29/upload_a6a91803f612005e2d22a33027b3dd30.jpg', '哈哈哈哈', '撒旦法和我看见发生了对方', 1481990400, 1482767999, 1, 0.00, 5.00, 0.00, 1, 1, 1481702381);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_coupon_list`
--

CREATE TABLE IF NOT EXISTS `qgs_coupon_list` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `cid` int(11) NOT NULL COMMENT '优惠券id',
  `usetime` int(11) NOT NULL COMMENT '使用时间'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='优惠券使用表';

--
-- 转存表中的数据 `qgs_coupon_list`
--

INSERT INTO `qgs_coupon_list` (`id`, `uid`, `cid`, `usetime`) VALUES
(1, 6, 4, 1480648600),
(10, 6, 5, 1480650748),
(11, 3, 2, 1480665599),
(14, 8, 2, 1482111479),
(16, 6, 2, 1482204864),
(17, 12, 8, 1482215112),
(18, 13, 8, 1482215212),
(19, 14, 2, 1482215292),
(20, 12, 2, 1482215529),
(22, 15, 2, 1482219377),
(23, 6, 8, 1482306869);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_handtake_place`
--

CREATE TABLE IF NOT EXISTS `qgs_handtake_place` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `name` varchar(100) NOT NULL COMMENT '地区/站点名称',
  `address` varchar(150) DEFAULT NULL COMMENT '地址',
  `tel` char(15) DEFAULT NULL COMMENT '电话号码',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父区域id',
  `sort` int(5) NOT NULL DEFAULT '0' COMMENT '排序,越大越后',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `shoudan` varchar(20) NOT NULL COMMENT '首单赠品',
  `max` varchar(20) NOT NULL COMMENT '满就送赠品'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='自提点地区站点表';

--
-- 转存表中的数据 `qgs_handtake_place`
--

INSERT INTO `qgs_handtake_place` (`id`, `name`, `address`, `tel`, `pid`, `sort`, `status`, `shoudan`, `max`) VALUES
(1, '大良街道', NULL, NULL, 0, 0, 1, '', ''),
(2, '容桂镇', NULL, NULL, 0, 1, 1, '', ''),
(3, '乐从镇', NULL, NULL, 0, 2, 1, '', ''),
(4, '南区', NULL, NULL, 3, 0, 1, '', ''),
(5, '北区', NULL, NULL, 3, 2, 1, '', ''),
(6, '北区站点', NULL, NULL, 5, 1, 1, '', ''),
(7, '南区站点', NULL, NULL, 4, 0, 1, '', ''),
(8, '南区站点测试', '挥洒飞机刷卡缴费的卡是伐啦圣诞节发送卡佛哦啊另外', '13047069417', 4, 1, 1, '', ''),
(9, '哈哈哈', '打飞机阿道夫拉克丝答复我跑酷发快递费', '0757-28836589', 5, 1, 1, '', ''),
(10, '发撒打发斯蒂芬', '撒的发送到发送到发送到分@#', '0757-28839587', 5, 1, 1, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_hooks`
--

CREATE TABLE IF NOT EXISTS `qgs_hooks` (
  `id` int(10) unsigned NOT NULL COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(2) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='钩子表';

--
-- 转存表中的数据 `qgs_hooks`
--

INSERT INTO `qgs_hooks` (`id`, `name`, `description`, `type`, `update_time`, `addons`, `status`) VALUES
(2, 'app_begin', '程序初始化标签位.', 2, 1471655804, 'TestRun', 1),
(3, 'test_hooks', '哈哈啊啊叫234', 2, 1470991369, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_jifen`
--

CREATE TABLE IF NOT EXISTS `qgs_jifen` (
  `id` int(11) NOT NULL,
  `off` int(11) NOT NULL COMMENT '积分功能开关<0>为开<1>为关',
  `qiandao` varchar(20) NOT NULL COMMENT '签到积分额度',
  `xiaofei` varchar(20) NOT NULL COMMENT '消费积分额度',
  `duihuan` varchar(20) NOT NULL COMMENT '积分抵扣额度'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_jifen`
--

INSERT INTO `qgs_jifen` (`id`, `off`, `qiandao`, `xiaofei`, `duihuan`) VALUES
(1, 0, '1', '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_login_log`
--

CREATE TABLE IF NOT EXISTS `qgs_login_log` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `aid` int(11) NOT NULL COMMENT '管理员id',
  `ip` char(15) NOT NULL COMMENT 'ip地址',
  `lgtime` int(11) NOT NULL COMMENT '登录时间'
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_login_log`
--

INSERT INTO `qgs_login_log` (`id`, `aid`, `ip`, `lgtime`) VALUES
(115, 1, '127.0.0.1', 1489202366),
(116, 1, '127.0.0.1', 1490145576),
(117, 1, '127.0.0.1', 1490318232),
(118, 1, '127.0.0.1', 1490577147),
(119, 1, '127.0.0.1', 1490671917),
(120, 1, '127.0.0.1', 1491354884);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member`
--

CREATE TABLE IF NOT EXISTS `qgs_member` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uname` varchar(60) NOT NULL COMMENT '用户名',
  `utel` varchar(13) NOT NULL COMMENT '电话号码',
  `upwd` char(32) NOT NULL COMMENT '密码',
  `sex` int(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL COMMENT '生日',
  `score` int(8) NOT NULL DEFAULT '0' COMMENT '商城积分',
  `shotcut` varchar(300) DEFAULT NULL COMMENT '用户头像',
  `handtake` int(11) NOT NULL DEFAULT '0' COMMENT '自提点id',
  `openid` varchar(70) DEFAULT NULL COMMENT '微信openid',
  `createtime` int(11) NOT NULL COMMENT '注册时间',
  `money` float(10,2) NOT NULL COMMENT '累计金额',
  `is_del` int(1) NOT NULL DEFAULT '0' COMMENT '逻辑删除'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='商城用户表';

--
-- 转存表中的数据 `qgs_member`
--

INSERT INTO `qgs_member` (`id`, `uname`, `utel`, `upwd`, `sex`, `birthday`, `score`, `shotcut`, `handtake`, `openid`, `createtime`, `money`, `is_del`) VALUES
(3, '用户13106589782', '13106589782', 'e10adc3949ba59abbe56e057f20f883e', 1, '2016-12-19', 0, NULL, 0, '', 1478599740, 0.00, 0),
(6, 'SamHong', '13047069417', 'e10adc3949ba59abbe56e057f20f883e', 0, '1993-07-22', 0, 'http://qgshop.b0.upaiyun.com/2016/12/21/02/48/02/upload_9299d955a21ab2f068a5c09aa0a67a1a.jpg', 0, 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 1478667362, 0.00, 0),
(7, '用户15627225976', '15627225976', 'e10adc3949ba59abbe56e057f20f883e', 0, '0000-00-00', 0, NULL, 0, 'o5tACvwh1siw7sGqQy3vkxIk6EFY', 1481971210, 0.00, 0),
(8, '用户13380509065', '13380509065', 'e10adc3949ba59abbe56e057f20f883e', 0, '0000-00-00', 0, 'http://qgshop.b0.upaiyun.com/2016/12/20/07/12/43/upload_dff43a3c96f738c4ed846d2c58c8afe7.JPG', 0, 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 1481973539, 0.00, 0),
(9, '用户13924809542', '13924809542', '5ec3d0246895853ed4161cd5091e04d6', 0, '0000-00-00', 0, NULL, 0, NULL, 1481976552, 0.00, 0),
(10, '哈哈', '13431660933', 'a906449d5769fa7361d7ecc6aa3f6d28', 0, '2016-12-19', 20, 'http://qgshop.b0.upaiyun.com/2016/12/19/04/04/28/upload_8071f4965f495d497dc63ddcfb428e1e.jpg', 0, NULL, 1481978089, 0.00, 0),
(11, '嘻嘻', '1386589782', '15739a476d418d685735b7afd48c2a8b', 1, '2016-12-19', 10, 'http://qgshop.b0.upaiyun.com/2016/12/19/03/53/05/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 0, NULL, 1482118150, 0.00, 0),
(12, '用户18688482061', '18688482061', 'e10adc3949ba59abbe56e057f20f883e', 0, '0000-00-00', 0, 'http://qgshop.b0.upaiyun.com/2016/12/20/06/40/25/upload_85ba343772addef37a36324b2f74608d.jpg', 0, 'o5tACv6l4ZqdOWzmqWG_2qQfE-GU', 1482214290, 0.00, 0),
(13, '用户13690282256', '13690282256', 'e10adc3949ba59abbe56e057f20f883e', 0, '2016-12-20', 100, 'http://qgshop.b0.upaiyun.com/2016/12/20/07/23/47/upload_8cfcbe89d33d2ab0d00be184903241f0.jpeg', 0, 'o5tACv7RK8HshEWsmOthU3Lc3bvk', 1482214302, 0.00, 0),
(14, '大性星', '18316551451', '25d55ad283aa400af464c76d713c07ad', 0, '2012-12-13', 0, 'http://qgshop.b0.upaiyun.com/2016/12/20/07/04/04/upload_1611512fc8c159b39ce717758891a504.JPG', 0, 'o5tACvxALPgPCjZpBW2m21jIxJxY', 1482214418, 0.00, 0),
(15, '大哥', '13434812345', '3a9e114ab88a861196b795ad11e0f75c', 0, '2016-12-20', 0, 'http://qgshop.b0.upaiyun.com/2016/12/20/06/31/10/upload_1bf0ed6c2b044535b3bc30ef365fa22e.JPG', 0, 'o5tACv06l_SOQhC_8ZNCq-Xnl3j8', 1482214714, 0.00, 0),
(16, '用户15818073783', '15818073783', '9bc77e89a5f1bd980695cbec0fbfd229', 0, '0000-00-00', 0, NULL, 0, 'o5tACv9lt-uo704sKVG-fly312JI', 1482219075, 0.00, 0),
(17, '用户13106589785', '13106589785', '96e79218965eb72c92a549dd5a330112', 0, '0000-00-00', 0, NULL, 0, NULL, 1482303361, 0.00, 0),
(18, '用户13106589788', '13106589788', '1a100d2c0dab19c4430e7d73762b3423', 0, '0000-00-00', 0, NULL, 0, NULL, 1482303565, 0.00, 0),
(19, '用户13702830048', '13702830048', '09dd8eab4003873944589657128d7377', 0, '0000-00-00', 0, NULL, 0, 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 1482501789, 0.00, 0),
(20, '用户15015800574', '15015800574', 'd75c12f4e18ef1681032361955abc96c', 0, '0000-00-00', 0, NULL, 0, 'o5tACv8fwjsHspckag1lMRLQF_U8', 1482570642, 0.00, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member_address`
--

CREATE TABLE IF NOT EXISTS `qgs_member_address` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `person` varchar(60) NOT NULL COMMENT '收货人姓名',
  `code` varchar(10) NOT NULL COMMENT '邮政编码',
  `area` varchar(30) NOT NULL COMMENT '收货地区',
  `address` varchar(300) NOT NULL COMMENT '收货地址',
  `tel` varchar(13) NOT NULL COMMENT '收货人联系电话',
  `is_default` int(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_member_address`
--

INSERT INTO `qgs_member_address` (`id`, `uid`, `person`, `code`, `area`, `address`, `tel`, `is_default`) VALUES
(3, 3, '鸿鸿鸿', '528315', '北京市 北京市市辖区 东城区', '同学问我我咯啦咯诺拉吉姆多种', '13047069417', 0),
(4, 3, '哈哈哈', '528315', '贵州省 贵阳市 白云区', '哦哦哦计算机没有啦咯自己咯哦我', '13431660933', 1),
(8, 14, '大性星', '528300', '广东省 佛山市 顺德区', '趣果网络', '18316551451', 1),
(10, 13, '刘国涛', '528300', '广东省 佛山市 顺德区', '看来', '13690282256', 1),
(11, 15, '冯铭斌', '528300', '广东省 佛山市 顺德区', '大良街道新宁路43号家电城二座41号铺', '13434812345', 1),
(12, 14, '小宾究', '271997', '新疆维吾尔自治区 和田地区 洛浦县', '生物技术标准', '1234567890123', 0),
(14, 8, '李勇', '528300', '广东省 佛山市 顺德区', '大良', '13380509065', 1),
(15, 6, '张盛鸿', '528315', '内蒙古自治区 通辽市 开鲁县', '覆盖规划和 v 韩国和骨骼还叫你回家', '13106589783', 1);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member_code`
--

CREATE TABLE IF NOT EXISTS `qgs_member_code` (
  `id` int(11) NOT NULL COMMENT 'id',
  `tel` char(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号码',
  `code` int(6) NOT NULL COMMENT '验证码',
  `action` tinyint(3) NOT NULL DEFAULT '1' COMMENT '触发场景,@1:注册,@2:找回密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '使用状态,@-1:发送失败,@0:未使用,@1:已使用',
  `time` int(11) NOT NULL,
  `error` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '错误信息'
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='会员资料预填';

--
-- 转存表中的数据 `qgs_member_code`
--

INSERT INTO `qgs_member_code` (`id`, `tel`, `code`, `action`, `status`, `time`, `error`) VALUES
(1, '13106589782', 45288, 1, -1, 1478662743, NULL),
(2, '13106589782', 17454, 1, 1, 1478663470, NULL),
(3, '13106589782', 23820, 1, 1, 1478663536, NULL),
(4, '13106589782', 54123, 1, 1, 1478663539, NULL),
(5, '13106589782', 48248, 1, 1, 1478663662, NULL),
(6, '13047069417', 87099, 1, 2, 1478666838, NULL),
(7, '13047069417', 13496, 1, 2, 1478667285, NULL),
(8, '13047069417', 84967, 2, 1, 1478668087, NULL),
(9, '13047069417', 37138, 2, 2, 1478671902, NULL),
(10, '13106589782', 15528, 1, 1, 1481772666, NULL),
(11, '13106589782', 70928, 1, 1, 1481774115, NULL),
(12, '13106589782', 94669, 1, -1, 1481774256, 'HTTP请求错误'),
(13, '13106589782', 90233, 1, -1, 1481774325, 'HTTP请求错误'),
(14, '13106589782', 12197, 1, -1, 1481774428, 'HTTP请求错误'),
(15, '13106589782', 14385, 1, -1, 1481774902, '请求参数缺失'),
(16, '13106589782', 48512, 1, -1, 1481775265, '请求参数缺失'),
(17, '13106589782', 44109, 1, -1, 1481775383, 'IP没有权限'),
(18, '13106589782', 39056, 1, 1, 1481775545, NULL),
(19, '13106589782', 72902, 2, 1, 1481775732, NULL),
(20, '15627225976', 57506, 1, 2, 1481971190, NULL),
(21, '13380509065', 16681, 1, 2, 1481973517, NULL),
(22, '13924809542', 12353, 1, 2, 1481976528, NULL),
(23, '18688482061', 70649, 1, 2, 1482214263, NULL),
(24, '13690282256', 24879, 1, 2, 1482214277, NULL),
(25, '18316551451', 61396, 1, 2, 1482214386, NULL),
(26, '13434812345', 45573, 1, 2, 1482214686, NULL),
(27, '15818073783', 37937, 1, 2, 1482219042, NULL),
(28, '13106589782', 73825, 1, 1, 1482303260, NULL),
(29, '13106589785', 83619, 1, 2, 1482303331, NULL),
(30, '13106589788', 24698, 1, 2, 1482303547, NULL),
(31, '13702830048', 77356, 1, 2, 1482501762, NULL),
(32, '15015800574', 59172, 1, 2, 1482570612, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member_collect`
--

CREATE TABLE IF NOT EXISTS `qgs_member_collect` (
  `id` int(11) NOT NULL COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户id,from:qgs_member',
  `pid` int(11) NOT NULL COMMENT '商品id,from:qgs_product',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户模块|商品收藏表|张盛鸿|2016-11-11';

--
-- 转存表中的数据 `qgs_member_collect`
--

INSERT INTO `qgs_member_collect` (`id`, `uid`, `pid`, `createtime`) VALUES
(2, 6, 6, 1480564205),
(3, 6, 7, 1480564211),
(4, 8, 4, 1482048226);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member_orderlist`
--

CREATE TABLE IF NOT EXISTS `qgs_member_orderlist` (
  `id` int(11) NOT NULL COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户id,from:qgs_member',
  `oid` varchar(22) NOT NULL COMMENT '订单id,from:qgs_member_orders',
  `pid` int(11) NOT NULL COMMENT '产品id,from:qgs_product',
  `price` float(10,2) NOT NULL COMMENT '价格',
  `amount` int(6) NOT NULL COMMENT '数量',
  `format` varchar(100) NOT NULL COMMENT '规格型号',
  `fname` varchar(100) NOT NULL COMMENT '规格名称'
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COMMENT='用户模块|订单商品列表|张盛鸿|2016-11-11';

--
-- 转存表中的数据 `qgs_member_orderlist`
--

INSERT INTO `qgs_member_orderlist` (`id`, `uid`, `oid`, `pid`, `price`, `amount`, `format`, `fname`) VALUES
(1, 6, '20020161202111640636', 7, 20.57, 1, '129', 'haha'),
(2, 6, '20020161202111951128', 7, 20.57, 1, '129', 'haha'),
(3, 6, '20020161202112005496', 7, 20.57, 1, '129', 'haha'),
(4, 6, '20020161202112147585', 7, 20.57, 1, '129', 'haha'),
(5, 6, '20020161202113322988', 7, 20.57, 1, '129', 'haha'),
(6, 6, '20020161202113324372', 7, 20.57, 1, '129', 'haha'),
(7, 6, '20020161202113347322', 7, 20.57, 1, '129', 'haha'),
(8, 6, '20020161202113458215', 7, 20.57, 1, '129', 'haha'),
(9, 6, '20020161202113630982', 7, 20.57, 1, '129', 'haha'),
(10, 6, '20020161202115228613', 7, 20.57, 1, '129', 'haha'),
(11, 6, '20020161202115424909', 7, 20.57, 1, '129', 'haha'),
(12, 6, '20020161202115701945', 7, 20.57, 1, '129', 'haha'),
(13, 6, '20020161202152536175', 7, 20.57, 1, '129', 'haha'),
(14, 6, '20020161202155959676', 6, 32.00, 2, '119,122,125', '1L-32cm-生锈铁'),
(15, 6, '20020161202155959676', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(16, 6, '20020161202155959676', 5, 20.00, 2, '', ''),
(17, 6, '20020161202155959676', 4, 120.00, 1, '', ''),
(18, 6, '20020161202155959676', 7, 20.57, 1, '129', 'haha'),
(21, 6, '20020161205102713141', 7, 12.00, 1, '130', 'xixi'),
(22, 6, '20020161205110305567', 7, 12.00, 1, '130', 'xixi'),
(23, 6, '20020161206101922529', 6, 48.00, 3, '119,122,125', '1L-32cm-生锈铁'),
(24, 6, '20020161206101922529', 5, 10.00, 1, '', ''),
(26, 6, '20020161206102024324', 6, 48.00, 3, '119,122,125', '1L-32cm-生锈铁'),
(27, 6, '20020161206102024324', 5, 10.00, 1, '', ''),
(29, 6, '20020161206102751802', 6, 48.00, 3, '119,122,125', '1L-32cm-生锈铁'),
(30, 6, '20020161206102751802', 5, 10.00, 1, '', ''),
(32, 6, '20020161206103743894', 2, 10.00, 1, '127,114', '25mm-塑料'),
(33, 6, '20020161206103743894', 4, 240.00, 2, '', ''),
(35, 6, '20020161206104007507', 4, 240.00, 2, '', ''),
(36, 6, '20020161206104007507', 2, 10.00, 1, '126,113', '10mm-纸质'),
(38, 6, '20020161206104730204', 6, 32.00, 2, '119,122,125', '1L-32cm-生锈铁'),
(39, 6, '20020161206104730204', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(40, 6, '20020161206104730204', 5, 10.00, 1, '', ''),
(41, 6, '20020161206104730204', 4, 120.00, 1, '', ''),
(42, 6, '20020161206104730204', 7, 20.57, 1, '129', 'haha'),
(45, 6, '20020161206105115507', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(46, 6, '20020161206105115507', 4, 120.00, 1, '', ''),
(48, 6, '20020161206105342412', 4, 120.00, 1, '', ''),
(49, 6, '20020161206105342412', 7, 20.57, 1, '129', 'haha'),
(51, 6, '20020161206105522805', 7, 20.57, 1, '129', 'haha'),
(52, 6, '20020161206105906239', 4, 240.00, 2, '', ''),
(53, 6, '20020161206105906239', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(54, 6, '20020161206105906239', 2, 10.00, 1, '126,114', '10mm-塑料'),
(55, 6, '20020161206105906239', 3, 240.00, 2, '', ''),
(59, 6, '20020161206110103332', 4, 240.00, 2, '', ''),
(60, 6, '20020161206110103332', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(61, 6, '20020161206110103332', 2, 10.00, 1, '126,114', '10mm-塑料'),
(62, 6, '20020161206110103332', 3, 240.00, 2, '', ''),
(66, 6, '20020161206110230190', 4, 240.00, 2, '', ''),
(67, 6, '20020161206110230190', 6, 28.00, 1, '120,122,124', '2L-32cm-不锈钢'),
(69, 6, '20020161206110606293', 4, 120.00, 1, '', ''),
(70, 6, '20020161206110606293', 6, 13.00, 1, '119,121,125', '1L-16cm-生锈铁'),
(72, 6, '20020161206111001253', 4, 240.00, 2, '', ''),
(73, 6, '20020161206111001253', 6, 13.00, 1, '119,121,125', '1L-16cm-生锈铁'),
(75, 6, '20020161206112102955', 4, 240.00, 2, '', ''),
(76, 6, '20020161206112102955', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(78, 6, '20020161206112228907', 4, 240.00, 2, '', ''),
(79, 6, '20020161206112228907', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(81, 6, '20020161206112405177', 4, 240.00, 2, '', ''),
(82, 6, '20020161206112405177', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(84, 6, '20020161206142802913', 4, 240.00, 2, '', ''),
(85, 6, '20020161206144104660', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(86, 6, '20020161206144104660', 4, 240.00, 2, '', ''),
(88, 6, '20020161206144639691', 4, 240.00, 2, '', ''),
(89, 6, '20020161206144639691', 6, 16.00, 1, '119,122,125', '1L-32cm-生锈铁'),
(91, 6, '20020161208150622446', 4, 120.00, 1, '', ''),
(92, 6, '20020161208152602954', 6, 32.00, 2, '119,122,125', '1L-32cm-生锈铁'),
(93, 6, '20020161208152602954', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(94, 6, '20020161208152602954', 5, 20.00, 2, '', ''),
(95, 6, '20020161208152602954', 4, 120.00, 1, '', ''),
(96, 6, '20020161208152602954', 7, 20.57, 1, '129', 'haha'),
(99, 6, '20020161208153816979', 7, 12.00, 1, '130', 'xixi'),
(100, 6, '20020161208162611195', 4, 120.00, 1, '', ''),
(101, 6, '20020161208165248685', 4, 120.00, 1, '', ''),
(102, 6, '20020161208165708528', 4, 120.00, 1, '', ''),
(103, 6, '20020161208165822729', 4, 120.00, 1, '', ''),
(104, 6, '20020161208170715628', 4, 120.00, 1, '', ''),
(105, 6, '20020161208171323619', 4, 120.00, 1, '', ''),
(106, 6, '20020161208171843526', 4, 120.00, 1, '', ''),
(107, 6, '20020161208173342140', 4, 240.00, 2, '', ''),
(108, 6, '20020161208180416411', 4, 120.00, 1, '', ''),
(109, 6, '20020161208181057845', 4, 240.00, 2, '', ''),
(110, 6, '20020161208181239652', 4, 120.00, 1, '', ''),
(111, 6, '20020161208181704210', 4, 120.00, 1, '', ''),
(112, 6, '20020161208182114977', 4, 120.00, 1, '', ''),
(113, 6, '20020161208182311103', 4, 120.00, 1, '', ''),
(114, 6, '20020161209105531168', 4, 120.00, 1, '', ''),
(115, 6, '20020161209110250306', 4, 120.00, 1, '', ''),
(116, 6, '20020161209110250306', 6, 16.00, 1, '119,122,125', '1L-32cm-生锈铁'),
(118, 6, '20020161209110948472', 6, 16.00, 1, '119,122,125', '1L-32cm-生锈铁'),
(119, 6, '20020161209111735585', 7, 20.57, 1, '129', 'haha'),
(120, 6, '20020161209112237925', 7, 12.00, 1, '130', 'xixi'),
(121, 6, '20020161209113247756', 4, 240.00, 2, '', ''),
(122, 6, '20020161209131557869', 4, 120.00, 1, '', ''),
(123, 6, '20020161209131557869', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(125, 6, '20020161209132055765', 6, 13.00, 1, '119,121,125', '1L-16cm-生锈铁'),
(126, 6, '20020161209143123497', 4, 120.00, 1, '', ''),
(127, 6, '20020161209171845500', 7, 20.57, 1, '129', 'haha'),
(128, 6, '20020161209171845500', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(130, 6, '20020161209171950112', 4, 240.00, 2, '', ''),
(131, 6, '20020161212161302200', 4, 240.00, 2, '', ''),
(132, 6, '20020161216172112776', 4, 240.00, 2, '', ''),
(133, 6, '20020161217110108189', 4, 120.00, 1, '', ''),
(134, 8, '20020161218155539708', 6, 16.00, 1, '119,122,125', '1L-32cm-生锈铁'),
(135, 8, '20020161219093537656', 4, 120.00, 1, '', ''),
(136, 8, '20020161219093537656', 6, 2200.00, 1, '120,121,124', '2L-16cm-不锈钢'),
(138, 8, '20020161219093759600', 4, 120.00, 1, '', ''),
(139, 6, '20020161219101813909', 2, 20.00, 2, '126,114', '10mm-塑料'),
(140, 6, '20020161219154444668', 4, 120.00, 1, '', ''),
(141, 6, '20020161220113424847', 4, 120.00, 1, '', ''),
(142, 6, '20020161220113424847', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(143, 6, '20020161220113424847', 7, 20.57, 1, '129', 'haha'),
(144, 6, '20020161220113952713', 4, 120.00, 1, '', ''),
(145, 6, '20020161220120303101', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(146, 6, '20020161220141130344', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(147, 14, '20020161220142241330', 6, 64.95, 5, '120,123,125', '2L-50cm-生锈铁'),
(148, 12, '20020161220142512638', 6, 15.00, 1, '119,122,124', '1L-32cm-不锈钢'),
(149, 13, '20020161220142652525', 2, 10.00, 1, '126,114', '10mm-塑料'),
(150, 15, '20020161220142712459', 6, 2200.00, 1, '120,121,124', '2L-16cm-不锈钢'),
(151, 14, '20020161220142812246', 7, 72.00, 6, '130', 'xixi'),
(152, 12, '20020161220143209273', 4, 120.00, 1, '', ''),
(153, 12, '20020161220143409337', 4, 120.00, 1, '', ''),
(154, 6, '20020161220144145296', 7, 20.57, 1, '129', 'haha'),
(155, 6, '20020161220144145296', 4, 240.00, 2, '', ''),
(157, 13, '20020161220145235385', 4, 120.00, 1, '', ''),
(158, 13, '20020161220145235385', 4, 120.00, 1, '', ''),
(159, 13, '20020161220145235385', 4, 120.00, 1, '', ''),
(160, 13, '20020161220145235385', 4, 120.00, 1, '', ''),
(164, 6, '20020161220150754168', 4, 240.00, 2, '', ''),
(165, 8, '20020161220151027438', 4, 120.00, 1, '', ''),
(166, 6, '20020161220151131955', 4, 120.00, 1, '', ''),
(167, 15, '20020161220153617130', 4, 120.00, 1, '', ''),
(168, 14, '20020161220153834507', 6, 12.50, 1, '120,122,125', '2L-32cm-生锈铁'),
(169, 6, '20020161220161514559', 7, 20.57, 1, '129', 'haha'),
(170, 6, '20020161220161514559', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(171, 6, '20020161220161514559', 4, 120.00, 1, '', ''),
(172, 6, '20020161220163159679', 4, 360.00, 3, '', ''),
(173, 6, '20020161220170751820', 4, 240.00, 2, '', ''),
(174, 8, '20020161220211542556', 6, 39.00, 3, '119,121,125', '1L-16cm-生锈铁'),
(175, 6, '20020161221155429686', 4, 120.00, 1, '', ''),
(176, 6, '20020161221155429686', 6, 30.00, 2, '119,122,124', '1L-32cm-不锈钢'),
(178, 6, '20020161222094837931', 4, 360.00, 3, '', ''),
(179, 19, '20020161223220348741', 4, 240.00, 2, '', ''),
(180, 6, '20020161229160912492', 6, 16.00, 1, '119,122,125', '1L-32cm-生锈铁');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member_orders`
--

CREATE TABLE IF NOT EXISTS `qgs_member_orders` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `person` varchar(60) NOT NULL COMMENT '收货人',
  `address` varchar(350) NOT NULL COMMENT '收货地址',
  `postcode` varchar(10) NOT NULL COMMENT '邮政编码',
  `tel` varchar(13) NOT NULL COMMENT '联系电话',
  `pay` int(1) NOT NULL DEFAULT '0' COMMENT '是否支付',
  `paytype` int(1) NOT NULL DEFAULT '0' COMMENT '支付方式,1-微信,2-支付宝',
  `tips` varchar(200) DEFAULT NULL COMMENT '备注信息',
  `sum` float(10,2) NOT NULL COMMENT '订单总额',
  `money` float(10,2) NOT NULL COMMENT '实际支付金额',
  `orderid` varchar(22) NOT NULL COMMENT '订单号',
  `wxoid` char(32) DEFAULT NULL COMMENT '微信订单号',
  `openid` varchar(128) DEFAULT NULL COMMENT '支付微信用户标识',
  `score` float(8,2) NOT NULL COMMENT '积分抵扣金额',
  `coupon` float(8,2) NOT NULL COMMENT '优惠券抵扣金额',
  `freight` float(8,2) NOT NULL COMMENT '运费',
  `paytime` int(11) NOT NULL COMMENT '成功支付时间/用户取消时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `send` int(1) NOT NULL DEFAULT '0' COMMENT '是否发货',
  `stype` varchar(10) NOT NULL COMMENT '发货类型,express-快递,parcel-自提',
  `receive` int(1) NOT NULL DEFAULT '0' COMMENT '是否收货',
  `gtime` int(11) NOT NULL DEFAULT '0' COMMENT '收货时间',
  `comment` int(1) NOT NULL DEFAULT '0' COMMENT '是否评价',
  `reject` int(1) NOT NULL DEFAULT '0' COMMENT '是否退货',
  `rtime` int(11) DEFAULT '0' COMMENT '退货时间',
  `sinfo` int(11) DEFAULT '0' COMMENT '收货信息id',
  `snum` varchar(30) DEFAULT NULL COMMENT '快递单号',
  `scid` varchar(60) DEFAULT NULL COMMENT '快递公司编码',
  `scom` varchar(60) DEFAULT NULL COMMENT '快递公司',
  `stime` int(11) DEFAULT '0' COMMENT '发货时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态,@-3:已关闭,@-2:申请售后,@-1:用户取消,@0:进行中,@1:完成',
  `is_del` int(1) NOT NULL DEFAULT '0' COMMENT '逻辑删除'
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COMMENT='用户订单表';

--
-- 转存表中的数据 `qgs_member_orders`
--

INSERT INTO `qgs_member_orders` (`id`, `uid`, `person`, `address`, `postcode`, `tel`, `pay`, `paytype`, `tips`, `sum`, `money`, `orderid`, `wxoid`, `openid`, `score`, `coupon`, `freight`, `paytime`, `createtime`, `send`, `stype`, `receive`, `gtime`, `comment`, `reject`, `rtime`, `sinfo`, `snum`, `scid`, `scom`, `stime`, `status`, `is_del`) VALUES
(1, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 23.57, '20020161202111640636', NULL, NULL, 0.00, 2.00, 5.00, 0, 1480648600, 0, 'parcel', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1),
(2, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202111951128', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480648790, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(3, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202112005496', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480648805, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(4, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202112147585', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480648907, 0, 'express', 0, 0, 0, 0, 0, 0, '', NULL, '', 0, 0, 0),
(5, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202113322988', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480649602, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(6, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202113324372', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480649604, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(7, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202113347322', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480649626, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(8, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202113458215', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480649698, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(9, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202113630982', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480649790, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(10, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 21.46, '20020161202115228613', NULL, NULL, 0.00, 4.11, 5.00, 0, 1480650748, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(11, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 2, '', 20.57, 25.57, '20020161202115424909', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480650864, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(12, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 2, '', 20.57, 25.57, '20020161202115701945', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480651021, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(13, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161202152536175', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480663536, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(14, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 0.00, 0.00, '20020161202153134863', NULL, NULL, 0.00, 0.00, 0.00, 0, 1480663894, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1),
(15, 6, '哈哈哈', '贵州省贵阳市白云区哦哦哦计算机没有啦咯自己咯哦我', '528315', '13431660933', 1, 1, '', 207.57, 102.07, '20020161202155959676', '4002742001201612092240506568', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 123.00, 17.50, 1481270315, 1480665599, 1, 'express', 1, 1481272984, 1, 0, 0, 0, '12316556556', NULL, 'safsadfasff', 1481272235, 1, 0),
(16, 6, '张盛鸿', '广东省佛山市顺德区大良街道新宁路家电城41号撒地方', '528315', '13047069417', 0, 1, '', 12.00, 17.00, '20020161205102713141', NULL, NULL, 0.00, 0.00, 5.00, 1481260626, 1480904833, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(17, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 12.00, -106.00, '20020161205110305567', NULL, NULL, 0.00, 123.00, 5.00, 0, 1480906985, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(18, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 58.00, 70.50, '20020161206101922529', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480990762, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(19, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 58.00, 70.50, '20020161206102024324', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480990824, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(20, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 58.00, 70.50, '20020161206102751802', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480991271, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(21, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 250.00, 250.00, '20020161206103743894', NULL, NULL, 0.00, 0.00, 0.00, 0, 1480991863, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(22, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 250.00, 250.00, '20020161206104007507', NULL, NULL, 0.00, 0.00, 0.00, 0, 1480992007, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(23, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 197.57, 215.07, '20020161206104730204', NULL, NULL, 0.00, 0.00, 17.50, 0, 1480992450, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(24, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 135.00, 147.50, '20020161206105115507', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480992675, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(25, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 140.57, 145.57, '20020161206105342412', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480992822, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(26, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.57, 25.57, '20020161206105522805', NULL, NULL, 0.00, 0.00, 5.00, 0, 1480992922, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(27, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 520.00, 532.50, '20020161206105906239', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480993146, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(28, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 520.00, 532.50, '20020161206110103332', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480993263, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(29, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 268.00, 280.50, '20020161206110230190', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480993350, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(30, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 133.00, 145.50, '20020161206110606293', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480993566, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(31, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 253.00, 265.50, '20020161206111001253', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480993801, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(32, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 255.00, 267.50, '20020161206112102955', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480994462, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(33, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 255.00, 267.50, '20020161206112228907', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480994548, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(34, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 255.00, 267.50, '20020161206112405177', NULL, NULL, 0.00, 0.00, 12.50, 0, 1480994645, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(35, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 240.00, 240.00, '20020161206142802913', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481005682, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(36, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 255.00, 267.50, '20020161206144104660', NULL, NULL, 0.00, 0.00, 12.50, 0, 1481006464, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(37, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '覆盖规划', 256.00, 268.50, '20020161206144639691', NULL, NULL, 0.00, 0.00, 12.50, 0, 1481006799, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(38, 6, '张盛鸿', '广东省佛山市顺德区大良街道新宁路家电城41号撒地方', '528315', '13047069417', 0, 1, '', 120.00, 120.00, '20020161208150622446', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481180782, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(39, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 207.57, 225.07, '20020161208152602954', NULL, NULL, 0.00, 0.00, 17.50, 0, 1481181962, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(40, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 12.00, 17.00, '20020161208153816979', NULL, NULL, 0.00, 0.00, 5.00, 0, 1481182696, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(41, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208162611195', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481185571, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(42, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208165248685', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481187168, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(43, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208165708528', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481187428, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(44, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208165822729', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481187502, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(45, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208170715628', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481188035, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(46, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208171323619', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481188403, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(47, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 120.00, 120.00, '20020161208171843526', NULL, NULL, 0.00, 0.00, 0.00, 1481189203, 1481188723, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(48, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 240.00, 240.00, '20020161208173342140', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481189622, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(49, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 120.00, 120.00, '20020161208180416411', NULL, NULL, 0.00, 0.00, 0.00, 1481191479, 1481191456, 1, 'express', 1, 1482484717, 1, 0, 0, 0, '46561121', 'shentong', '申通', 1482484709, 1, 0),
(50, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 240.00, 240.00, '20020161208181057845', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481191857, 1, 'express', 0, 0, 0, 0, 0, 0, '21313123', 'huitongkuaidi', '百世汇通', 0, 0, 0),
(51, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208181239652', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481191959, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(52, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208181704210', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481192224, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(53, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161208182114977', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481192474, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(54, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 120.00, 120.00, '20020161208182311103', NULL, NULL, 0.00, 0.00, 0.00, 1481192614, 1481192591, 1, 'express', 1, 1482216309, 1, 0, 0, 0, '123123123123', 'rufengda', '如风达快递', 0, 1, 0),
(55, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 120.00, 120.00, '20020161209105531168', '4002742001201612092236691860', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 0.00, 1481252168, 1481252131, 1, 'express', 1, 1482205773, 0, 0, 0, 0, '56579779461', NULL, '撒地方萨芬托管人符合', 1481695689, -2, 0),
(56, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 136.00, 148.50, '20020161209110250306', '4002742001201612092236933977', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 12.50, 1481252587, 1481252570, 1, 'express', 1, 1481697367, 0, 0, 0, 0, '89679889879', 'huitongkuaidi', '百世汇通', 1481697568, -2, 0),
(57, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 16.00, 28.50, '20020161209110948472', '4002742001201612092235952723', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 12.50, 1481252999, 1481252988, 1, 'express', 1, 1481698310, 0, 0, 0, 0, '883672699301106368', 'yuantong', '圆通速递', 1481697250, -2, 0),
(58, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 20.57, 25.57, '20020161209111735585', '4002742001201612092237787808', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 5.00, 1481253474, 1481253455, 1, 'express', 1, 1482205766, 1, 0, 0, 0, '16556465', NULL, '阿萨德法师法士大夫人', 1481697200, 1, 0),
(59, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 12.00, 17.00, '20020161209112237925', '4002742001201612092238042617', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 5.00, 1481253796, 1481253757, 1, 'express', 1, 1482205598, 0, 0, 0, 0, '121212121456', 'huitongkuaidi', '百世汇通', 1481697179, -2, 0),
(60, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 240.00, 240.00, '20020161209113247756', '4002742001201612092240506070', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 0.00, 1481254393, 1481254367, 1, 'express', 1, 1481874659, 0, 1, 1481944586, 0, '58541122332', 'yuantong', '圆通速递', 0, 1, 0),
(61, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 150.00, 162.50, '20020161209131557869', NULL, NULL, 0.00, 0.00, 12.50, 1481260564, 1481260557, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(62, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 13.00, 25.50, '20020161209132055765', NULL, NULL, 0.00, 0.00, 12.50, 1481260859, 1481260855, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(63, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161209143123497', NULL, NULL, 0.00, 0.00, 0.00, 1481265429, 1481265083, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(64, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 35.57, 53.07, '20020161209171845500', NULL, NULL, 0.00, 0.00, 17.50, 1481275132, 1481275125, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(65, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 240.00, 240.00, '20020161209171950112', NULL, NULL, 0.00, 0.00, 0.00, 1481275199, 1481275190, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(66, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 240.00, 240.00, '20020161212161302200', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481530382, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(67, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 240.00, 240.00, '20020161216172112776', NULL, NULL, 0.00, 0.00, 0.00, 0, 1481880072, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(68, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 120.00, 120.00, '20020161217110108189', '4002742001201612173045568001', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 0.00, 1481943848, 1481943668, 1, 'express', 1, 1481944292, 1, 0, 0, 0, '883672699301106368', 'yuantong', '圆通速递', 0, 1, 1),
(69, 8, '李勇', '广东省佛山市顺德区积极囧公民', '528300', '13380509065', 0, 1, '', 16.00, -94.50, '20020161218155539708', NULL, NULL, 0.00, 123.00, 12.50, 0, 1482047739, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(70, 8, '李勇', '广东省佛山市顺德区积极囧公民', '528300', '13380509065', 0, 1, '', 2320.00, 2332.50, '20020161219093537656', NULL, NULL, 0.00, 0.00, 12.50, 0, 1482111337, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(71, 8, '李勇', '广东省佛山市顺德区积极囧公民', '528300', '13380509065', 1, 1, '', 120.00, -3.00, '20020161219093759600', '4002362001201612203388305450', 'o5tACv2yImgjr3RBbcJRQfTvj7zc', 0.00, 123.00, 0.00, 1482217116, 1482111479, 1, 'express', 0, 0, 0, 0, 0, 0, '1235665432', 'huitongkuaidi', '百世汇通', 0, 0, 0),
(72, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 20.00, 0.01, '20020161219101813909', NULL, NULL, 0.00, 123.00, 0.00, 0, 1482113893, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(73, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '会根据法国', 120.00, 120.00, '20020161219154444668', '4002742001201612203350218432', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 0.00, 1482196294, 1482133484, 1, 'express', 1, 1482196498, 1, 0, 0, 0, '3903900644589', 'yunda', '韵达快运', 0, 1, 0),
(74, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '挥洒和答复', 170.57, 65.07, '20020161220113424847', '213123123412434123', 'sdafsadfasdf', 0.00, 123.00, 17.50, 1482205000, 1482204864, 1, 'express', 1, 1482483988, 0, 0, 0, 0, '12121212', 'huitongkuaidi', '百世汇通', 1482208932, 1, 0),
(75, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 120.00, 120.00, '20020161220113952713', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482205192, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(76, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 1, 1, '', 15.00, 27.50, '20020161220120303101', '4002742001201612203368927713', 'o5tACv_LvmLuV-LRCafw1G6ZIsQY', 0.00, 0.00, 12.50, 1482206609, 1482206583, 1, 'express', 1, 1482206644, 0, 0, 0, 0, '12312312', 'huitongkuaidi', '百世汇通', 0, -2, 0),
(77, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 30.00, 40.50, '20020161220141130344', NULL, NULL, 2.00, 0.00, 12.50, 0, 1482214290, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(78, 14, '大性星', '广东省佛山市顺德区趣果网络', '528300', '18316551451', 0, 1, '我要铝合金', 64.95, 77.45, '20020161220142241330', NULL, NULL, 0.00, 0.00, 12.50, 1482215012, 1482214961, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(79, 12, '苏', '黑龙江省双鸭山市尖山区查查', '123456', '18688482061', 0, 1, '叼你啊', 15.00, 22.50, '20020161220142512638', NULL, NULL, 0.00, 5.00, 12.50, 0, 1482215112, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(80, 13, '刘国涛', '广东省佛山市顺德区看来', '528300', '13690282256', 1, 1, '啦啦啦', 10.00, 5.00, '20020161220142652525', '4001192001201612203383286234', 'o5tACv7RK8HshEWsmOthU3Lc3bvk', 0.00, 5.00, 0.00, 1482215233, 1482215212, 1, 'express', 1, 1482215422, 1, 0, 0, 0, '123', 'shunfeng', '顺丰', 0, -2, 0),
(81, 15, '冯铭斌', '广东省佛山市顺德区大良街道新宁路43号家电城二座41号铺', '528300', '13434812345', 1, 1, '', 2200.00, 2212.50, '20020161220142712459', '4009842001201612203384724965', 'o5tACv06l_SOQhC_8ZNCq-Xnl3j8', 0.00, 0.00, 12.50, 1482215290, 1482215232, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(82, 14, '大性星', '广东省佛山市顺德区趣果网络', '528300', '18316551451', 1, 1, '', 72.00, 0.01, '20020161220142812246', '4007082001201612203384771977', 'o5tACvxALPgPCjZpBW2m21jIxJxY', 0.00, 123.00, 5.00, 1482216000, 1482215292, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(83, 12, '苏', '黑龙江省双鸭山市尖山区查查', '123456', '18688482061', 0, 1, '叼你阿拉', 120.00, 0.01, '20020161220143209273', NULL, NULL, 0.00, 123.00, 0.00, 1482215586, 1482215529, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(84, 12, '苏', '黑龙江省双鸭山市尖山区查查', '123456', '18688482061', 0, 1, '叼你阿拉', 120.00, 120.00, '20020161220143409337', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482215649, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(85, 6, '张盛鸿', '广东省佛山市顺德区乐从镇道教村丰乐坊社兴横街6号', '528315', '13106589782', 0, 1, '', 260.57, 265.57, '20020161220144145296', NULL, NULL, 0.00, 0.00, 5.00, 0, 1482216105, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(86, 13, '刘国涛', '广东省佛山市顺德区看来', '528300', '13690282256', 1, 1, '', 480.00, 480.00, '20020161220145235385', '4001192001201612203385893846', 'o5tACv7RK8HshEWsmOthU3Lc3bvk', 0.00, 0.00, 0.00, 1482216776, 1482216755, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(87, 6, '东方方法', '河北省石家庄市长安区不久就看见后即可', '528315', '13047069417', 0, 1, '', 240.00, 240.00, '20020161220150754168', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482217674, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(88, 8, '李勇', '广东省佛山市顺德区大良', '528300', '13380509065', 0, 1, '', 120.00, 120.00, '20020161220151027438', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482217827, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(89, 6, '东方方法', '河北省石家庄市长安区不久就看见后即可', '528315', '13047069417', 0, 1, 'gvhhhh', 120.00, 115.00, '20020161220151131955', NULL, NULL, 0.00, 5.00, 0.00, 1482217909, 1482217891, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, -1, 0),
(90, 15, '冯铭斌', '广东省佛山市顺德区大良街道新宁路43号家电城二座41号铺', '528300', '13434812345', 0, 1, '', 120.00, 0.01, '20020161220153617130', NULL, NULL, 0.00, 123.00, 0.00, 0, 1482219377, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1),
(91, 14, '大性星', '广东省佛山市顺德区趣果网络', '528300', '18316551451', 0, 1, '', 12.50, 25.00, '20020161220153834507', NULL, NULL, 0.00, 0.00, 12.50, 0, 1482219514, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(92, 6, '东方方法', '河北省石家庄市长安区不久就看见后即可', '528315', '13047069417', 0, 1, '', 170.57, 191.07, '20020161220161514559', NULL, NULL, 0.00, 0.00, 20.50, 0, 1482221714, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(93, 6, '东方方法', '河北省石家庄市长安区不久就看见后即可', '528315', '13047069417', 0, 1, '', 360.00, 360.00, '20020161220163159679', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482222719, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(94, 6, '南区站点测试', '挥洒飞机刷卡缴费的卡是伐啦圣诞节发送卡佛哦啊另外', '', '13047069417', 0, 1, '', 240.00, 240.00, '20020161220170751820', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482224871, 0, 'parcel', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(95, 8, '李勇', '广东省佛山市顺德区大良', '528300', '13380509065', 0, 1, '', 39.00, 51.50, '20020161220211542556', NULL, NULL, 0.00, 0.00, 12.50, 0, 1482239742, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(96, 6, '张盛鸿', '内蒙古自治区通辽市开鲁县覆盖规划和v韩国和骨骼还叫你回家', '528315', '13106589783', 0, 1, '规划局好机会', 150.00, 157.50, '20020161221155429686', NULL, NULL, 0.00, 5.00, 12.50, 0, 1482306869, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(97, 6, '张盛鸿', '内蒙古自治区通辽市开鲁县覆盖规划和v韩国和骨骼还叫你回家', '528315', '13106589783', 0, 1, '', 360.00, 360.00, '20020161222094837931', NULL, NULL, 0.00, 0.00, 0.00, 0, 1482371317, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0),
(98, 19, '南区站点测试', '挥洒飞机刷卡缴费的卡是伐啦圣诞节发送卡佛哦啊另外', '', '13047069417', 0, 1, '', 240.00, 240.00, '20020161223220348741', NULL, NULL, 0.00, 0.00, 0.00, 1482501834, 1482501828, 0, 'parcel', 0, 0, 0, 0, 0, 0, '', '', '', 0, -2, 0),
(99, 6, '张盛鸿', '内蒙古自治区通辽市开鲁县覆盖规划和v韩国和骨骼还叫你回家', '528315', '13106589783', 0, 1, '', 16.00, 28.50, '20020161229160912492', NULL, NULL, 0.00, 0.00, 12.50, 0, 1482998952, 0, 'express', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_member_score`
--

CREATE TABLE IF NOT EXISTS `qgs_member_score` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `class` int(11) NOT NULL COMMENT '<0>加积分<1>减积分',
  `order` varchar(20) NOT NULL COMMENT '订单号',
  `mark` int(11) NOT NULL COMMENT '分数'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_member_score`
--

INSERT INTO `qgs_member_score` (`id`, `uid`, `class`, `order`, `mark`) VALUES
(1, 14, 0, '10101', 14),
(2, 14, 1, '101010', 10);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_notice`
--

CREATE TABLE IF NOT EXISTS `qgs_notice` (
  `id` int(11) NOT NULL COMMENT '主键编号',
  `level` int(1) NOT NULL DEFAULT '1' COMMENT '信息等级',
  `title` varchar(100) NOT NULL COMMENT '消息标题',
  `content` text NOT NULL COMMENT '信息内容',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '信息状态',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='后台通知信息表';

--
-- 转存表中的数据 `qgs_notice`
--

INSERT INTO `qgs_notice` (`id`, `level`, `title`, `content`, `status`, `createtime`) VALUES
(1, 1, '消息测试一', '哈哈大姐夫萨克豆腐拉屎地方是的发生的范德萨发斯蒂芬', 0, 1470045319),
(2, 2, '消息测试二', '哈市的解放水电费水电费', 0, 1470045342),
(3, 3, '消息测试三', '是的发送到发士大夫撒旦法撒打发士大夫撒旦法师的qewqw', 1, 1470045362),
(4, 3, '不要删除', '不要删除', 1, 1482048385);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_orders`
--

CREATE TABLE IF NOT EXISTS `qgs_orders` (
  `id` int(11) NOT NULL,
  `pay` int(11) NOT NULL COMMENT '<0>为未支付<1>为支付',
  `paytype` int(11) NOT NULL COMMENT '<0>为微信支付<1>为其他方式',
  `tips` varchar(100) NOT NULL COMMENT '备注信息',
  `sum` float(10,2) NOT NULL COMMENT '商品总额',
  `money` float(10,2) NOT NULL COMMENT '实际支付',
  `orderid` varchar(30) NOT NULL COMMENT '订单号码',
  `wxoid` varchar(50) NOT NULL COMMENT '微信订单号',
  `dikou` varchar(20) NOT NULL COMMENT '抵扣',
  `paytime` int(11) NOT NULL COMMENT '支付时间/取消时间',
  `createtime` int(11) NOT NULL COMMENT '创建订单时间',
  `send` int(11) NOT NULL COMMENT '<0>未发货<1>已发货<2>已收货<3>已退货 ',
  `addressid` int(11) NOT NULL COMMENT '选择地址id',
  `stype` int(11) NOT NULL COMMENT '<0>为自提<1>为快递',
  `gtime` int(11) NOT NULL COMMENT '收货时间',
  `stime` int(11) NOT NULL COMMENT '发货时间',
  `rtime` int(11) NOT NULL COMMENT '退货时间',
  `stu` int(11) NOT NULL COMMENT '<0>等待支付<1>等待发货<2>等待收货<3>等待评价<4>申请售后',
  `del` int(11) NOT NULL COMMENT '<0>为未删除<1>为已删除',
  `userid` varchar(30) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='订单表';

--
-- 转存表中的数据 `qgs_orders`
--

INSERT INTO `qgs_orders` (`id`, `pay`, `paytype`, `tips`, `sum`, `money`, `orderid`, `wxoid`, `dikou`, `paytime`, `createtime`, `send`, `addressid`, `stype`, `gtime`, `stime`, `rtime`, `stu`, `del`, `userid`) VALUES
(1, 0, 0, '不要猪肉', 15.00, 15.00, '20161212', '20161313', '1.00#2.00', 1490686851, 1490686851, 1, 8, 0, 0, 0, 0, 0, 0, '14'),
(13, 0, 0, '不要猪肉', 15.00, 15.00, '2016121211', '20161313', '1.00#2.00', 1490686851, 1490686851, 1, 8, 0, 0, 0, 0, 0, 0, '14');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_pay_config`
--

CREATE TABLE IF NOT EXISTS `qgs_pay_config` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `facepay` int(1) NOT NULL DEFAULT '0' COMMENT '货到付款,0-禁用,1-启用',
  `handtake` int(1) NOT NULL DEFAULT '0' COMMENT '自提点,0-禁用,1-启用',
  `express` int(1) NOT NULL DEFAULT '0' COMMENT '快递配送,0-关闭,1-开启',
  `alipay` int(1) NOT NULL DEFAULT '0' COMMENT '支付宝,0-禁用,1-启用',
  `partner` varchar(100) NOT NULL COMMENT '支付宝账号',
  `pid` char(20) NOT NULL COMMENT '合作者身份ID',
  `ali_key` varchar(100) NOT NULL COMMENT '商户key',
  `rsa` varchar(300) DEFAULT NULL COMMENT '商户私钥',
  `wxpay` int(1) NOT NULL DEFAULT '0' COMMENT '微信支付,0-禁用,1-启用',
  `pay_sign_key` varchar(100) NOT NULL COMMENT '支付签名key',
  `partner_id` varchar(100) NOT NULL COMMENT '合作者id',
  `partner_key` varchar(100) NOT NULL COMMENT '商户key'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商家支付配置表';

--
-- 转存表中的数据 `qgs_pay_config`
--

INSERT INTO `qgs_pay_config` (`id`, `facepay`, `handtake`, `express`, `alipay`, `partner`, `pid`, `ali_key`, `rsa`, `wxpay`, `pay_sign_key`, `partner_id`, `partner_key`) VALUES
(1, 1, 1, 1, 1, 'wesdfsafsdf ', 'sadfsdf2232313', 'dfhashfjsdfj231', 'http://qgshop.b0.upaiyun.com/2016/12/13/02/59/34/upload_b6dda110b106106b7d042a603c636bcb.txt', 1, '6A4B0FC47CF6997A29256E1929DF882D', '1405293802', '483617');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product`
--

CREATE TABLE IF NOT EXISTS `qgs_product` (
  `id` int(11) NOT NULL COMMENT '商品id',
  `cid` int(11) NOT NULL COMMENT '分类id|,#取自qgs_product_classify',
  `sn_code` varchar(50) DEFAULT NULL COMMENT '商品编码',
  `name` varchar(100) NOT NULL COMMENT '产品名称',
  `description` varchar(150) DEFAULT NULL COMMENT '商品描述',
  `price` float(10,2) NOT NULL COMMENT '商品价格',
  `starprice` varchar(20) NOT NULL COMMENT '产品原价',
  `is_promote` int(1) NOT NULL DEFAULT '0' COMMENT '优惠,@1:开启,@0:关闭',
  `promote_price` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠价格',
  `promote_start` int(11) NOT NULL DEFAULT '0' COMMENT '优惠开启时间',
  `promote_end` int(11) NOT NULL DEFAULT '0' COMMENT '优惠结束时间',
  `format` text COMMENT '产品规格',
  `sale` int(10) NOT NULL DEFAULT '0' COMMENT '真实销量',
  `virtual_sale` int(10) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `supplier` varchar(30) DEFAULT NULL COMMENT '供应商',
  `store` int(10) NOT NULL DEFAULT '0' COMMENT '总库存量',
  `sold_out` int(1) NOT NULL DEFAULT '0' COMMENT '售罄功能,@0:关闭,@1:开启',
  `warn_num` int(6) NOT NULL DEFAULT '0' COMMENT '库存警告',
  `shotcut` varchar(300) NOT NULL COMMENT '缩略图',
  `gallery` text NOT NULL COMMENT '轮播图',
  `is_top` int(1) NOT NULL DEFAULT '0' COMMENT '置顶,@0:正常,@1:置顶',
  `is_hot` int(1) NOT NULL DEFAULT '0' COMMENT '热卖',
  `is_new` int(1) NOT NULL DEFAULT '0' COMMENT '新品',
  `sort` int(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_sell` int(1) NOT NULL DEFAULT '0' COMMENT '上下架情况,@0:下架,@1:上架',
  `is_del` int(1) NOT NULL DEFAULT '0' COMMENT '逻辑删除,@0:未删除,@1:已删除',
  `updatetime` int(11) NOT NULL COMMENT '更新时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `deliverytime` int(11) NOT NULL COMMENT '配送时间<0>为次日<1>为当日',
  `caigouyuan` int(11) NOT NULL COMMENT '采购员id',
  `fenjianzu` int(11) NOT NULL COMMENT '分拣组id',
  `taocan` varchar(20) NOT NULL COMMENT '套餐配合',
  `gift` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品表|张盛鸿|2016-11-02';

--
-- 转存表中的数据 `qgs_product`
--

INSERT INTO `qgs_product` (`id`, `cid`, `sn_code`, `name`, `description`, `price`, `starprice`, `is_promote`, `promote_price`, `promote_start`, `promote_end`, `format`, `sale`, `virtual_sale`, `supplier`, `store`, `sold_out`, `warn_num`, `shotcut`, `gallery`, `is_top`, `is_hot`, `is_new`, `sort`, `is_sell`, `is_del`, `updatetime`, `createtime`, `deliverytime`, `caigouyuan`, `fenjianzu`, `taocan`, `gift`) VALUES
(1, 9, 'XS1203', '产品测试', '撒大姐夫卡萨丁都放假了答复考了多少', 120.00, '', 0, 0.00, 0, 0, '[{"id":"6","name":"\\u5305\\u88c5","value":[{"id":"113","name":"\\u7eb8\\u8d28"},{"id":"114","name":"\\u5851\\u6599"},{"id":"115","name":"\\u539f\\u6728"}]},{"id":"5","name":"\\u91cd\\u91cf","value":[{"id":"108","name":"1kg"},{"id":"109","name":"2kg"},{"id":"110","name":"3kg"}]}]', 0, 1000, '', 100, 1, 10, 'http://qgshop.b0.upaiyun.com/2016/11/16/06/50/47/upload_458d05af68ff2c930834d02f3441e612.jpg', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/55\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/55\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/56\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/56\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/56\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg"]', 0, 1, 1, 1, 1, 0, 1481006416, 1479266184, 0, 0, 0, '0', 1),
(2, 9, 'XS1205', '商品测试二', '撒地方撒打算大法师打发发', 25.00, '', 1, 23.00, 1479398400, 1480089540, '[{"id":"2","name":"\\u5c3a\\u5bf8","value":[{"id":"126","name":"10mm"},{"id":"127","name":"25mm"}]},{"id":"6","name":"\\u5305\\u88c5","value":[{"id":"113","name":"\\u7eb8\\u8d28"},{"id":"114","name":"\\u5851\\u6599"}]}]', 7, 10, '嘻嘻嘻', 100, 1, 5, 'http://qgshop.b0.upaiyun.com/2016/11/16/06/50/47/upload_458d05af68ff2c930834d02f3441e612.jpg', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/55\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/55\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/56\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/56\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/16\\/03\\/24\\/56\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg"]', 1, 1, 0, 1, 1, 0, 1481006394, 1479267099, 0, 0, 0, '0', 1),
(3, 8, 'XS1256', '测试商品三', '撒旦法撒旦法撒旦法发', 120.00, '', 0, 0.00, 0, 0, NULL, 4, 10, '啥都看', 10011, 1, 1, 'http://qgshop.b0.upaiyun.com/2016/11/17/10/11/01/upload_1b13b92c47f59267ebe029d681ec56fd.jpg', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/11\\/09\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/11\\/22\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"]', 1, 1, 1, 2, 1, 0, 1481006365, 1479377505, 0, 0, 0, '0', 1),
(4, 8, 'XS12580', '测试商品三', '撒旦法撒旦法撒旦法发', 120.00, '', 0, 0.00, 0, 0, NULL, 81, 10, '啥都看', 11, 1, 1, 'http://qgshop.b0.upaiyun.com/2016/11/17/10/11/01/upload_1b13b92c47f59267ebe029d681ec56fd.jpg', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/11\\/09\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/11\\/22\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"]', 1, 1, 1, 2, 1, 0, 1481006354, 1479377570, 0, 0, 0, '0', 1),
(5, 8, 'XS1289', '撒地方就萨芬', '撒旦飞洒地方', 10.00, '', 0, 0.00, 0, 0, NULL, 3, 0, '0', 100, 0, 25, 'http://qgshop.b0.upaiyun.com/2016/11/17/10/15/56/upload_68cff0cceae9b39aa53d583f6ff61b63.jpg', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/16\\/07\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/16\\/21\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/21\\/08\\/upload_68cff0cceae9b39aa53d583f6ff61b63.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/21\\/08\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/17\\/10\\/21\\/09\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"]', 1, 0, 1, 2, 1, 0, 1491014050, 1479377796, 0, 0, 0, '0', 1),
(6, 6, 'XS1765', '哈哈哈', '是的发生快点发斯蒂芬水电费静安寺两地分居阿斯兰的反馈了瓦尔基里危机任务品啥都放假了卡索撒地方加拉斯!!!', 1.00, '', 1, 888.00, 1479571200, 1480175940, '[{"id":"4","name":"\\u5bb9\\u91cf","value":[{"id":"119","name":"1L"},{"id":"120","name":"2L"}]},{"id":"2","name":"\\u5c3a\\u5bf8","value":[{"id":"121","name":"16cm"},{"id":"122","name":"32cm"},{"id":"123","name":"50cm"}]},{"id":"3","name":"\\u6750\\u8d28","value":[{"id":"124","name":"\\u4e0d\\u9508\\u94a2"},{"id":"125","name":"\\u751f\\u9508\\u94c1"}]}]', 41, 100, '0', 209, 0, 20, 'http://qgshop.b0.upaiyun.com/2017/04/01/02/32/22/upload_a504b21c2e0c6ac623a89edb917bba7a.png', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/19\\/08\\/51\\/08\\/upload_5c9462e857fe02a61f646f4780982d2f.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/19\\/08\\/51\\/09\\/upload_9410a7ed11a3bb4df232940e4a70d909.jpg","http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/11\\/19\\/09\\/50\\/54\\/upload_0ecb4b46d3b998be77536bc012ade862.jpg"]', 1, 1, 1, 1, 1, 0, 1491013957, 1479545576, 0, 0, 0, '0', 1),
(7, 8, 'XS8976', '超级厉害的尼', '啥地方撒地方撒打发斯蒂芬我发顺丰', 10.00, '', 0, 0.00, 0, 0, '[{"id":"6","name":"\\u5305\\u88c5","value":[{"id":"129","name":"haha"},{"id":"130","name":"xixi"}]}]', 15, 20, '哈哈哈', 88, 1, 100, '', '[]', 1, 1, 0, 2, 0, 1, 1481006301, 1480180351, 0, 0, 0, '0', 1),
(8, 3, 'XS123qw', '哈哈健健康康', '撒飞洒的', 10.00, '', 0, 0.00, 0, 0, NULL, 0, 5, 'kkk', 411, 0, 5, 'http://qgshop.b0.upaiyun.com/2016/12/19/06/10/19/upload_acbebe351fd27f055172e3f52d3229bd.jpg', '["http://qgshop.b0.upaiyun.com/2016/12/19/05/18/38/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"]', 0, 1, 0, 1, 0, 1, 1482127821, 1482124723, 0, 0, 0, '0', 1),
(9, 9, '123123', '1231231', '123', 123.00, '', 0, 0.00, 0, 0, NULL, 0, 123, '0', 2147483647, 0, 324, 'http://qgshop.b0.upaiyun.com/2017/03/23/09/42/42/upload_4c5630d8cd7c3897eb118ad8f13c5791.jpg', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2017\\/03\\/23\\/09\\/43\\/02\\/upload_dd13144ed153e49155ce6713b48295be.jpg"]', 0, 0, 0, 324, 1, 0, 1491010162, 1490262197, 0, 0, 0, '0', 1),
(10, 9, '123', '123', '123', 123.00, '123', 0, 0.00, 0, 0, NULL, 0, 123, '6', 100, 0, 213, '', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2017\\/03\\/25\\/08\\/35\\/55\\/upload_46472382dbe0981119338b7168b20ef4.jpg"]', 0, 0, 0, 1, 1, 0, 1490432542, 1490432542, 0, 2, 4, '3#11,4#22', 1),
(11, 9, '123', '123', '123', 123.00, '123', 0, 0.00, 0, 0, NULL, 0, 123, '6', 100, 0, 213, '', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2017\\/03\\/25\\/08\\/35\\/55\\/upload_46472382dbe0981119338b7168b20ef4.jpg"]', 0, 0, 0, 1, 1, 0, 1490432542, 1490432542, 0, 2, 4, '3#11,4#22', 1),
(12, 9, '123', '123', '123', 123.00, '123', 0, 0.00, 0, 0, NULL, 0, 123, '6', 100, 0, 213, '', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2017\\/03\\/25\\/08\\/35\\/55\\/upload_46472382dbe0981119338b7168b20ef4.jpg"]', 0, 0, 0, 1, 1, 0, 1490432542, 1490432542, 0, 2, 4, '3#11,4#22', 1),
(13, 9, '123', '123', '123', 123.00, '123', 0, 0.00, 0, 0, NULL, 0, 123, '6', 100, 0, 213, '', '["http:\\/\\/qgshop.b0.upaiyun.com\\/2017\\/03\\/25\\/08\\/35\\/55\\/upload_46472382dbe0981119338b7168b20ef4.jpg"]', 0, 0, 0, 1, 1, 0, 1490432542, 1490432542, 0, 2, 4, '3#11,4#22', 1);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_addition`
--

CREATE TABLE IF NOT EXISTS `qgs_product_addition` (
  `id` int(11) NOT NULL COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '产品id,from:qgs_product',
  `notice` varchar(100) DEFAULT NULL COMMENT '公告id,from:qgs_product_notice',
  `commend` varchar(100) DEFAULT NULL COMMENT '推荐组合'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品附加表|张盛鸿|2016-11-17';

--
-- 转存表中的数据 `qgs_product_addition`
--

INSERT INTO `qgs_product_addition` (`id`, `pid`, `notice`, `commend`) VALUES
(1, 5, '3,2,1', '1,3,2,4'),
(2, 1, '3,1', '3,2'),
(3, 2, NULL, '1,3,2,4'),
(4, 6, '3,2,1', NULL),
(5, 7, '3,2,1', NULL),
(6, 4, NULL, NULL),
(7, 3, NULL, NULL),
(8, 8, NULL, NULL),
(9, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_area`
--

CREATE TABLE IF NOT EXISTS `qgs_product_area` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '地区名称'
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='商家模块|地区表|张盛鸿|2016-11-26';

--
-- 转存表中的数据 `qgs_product_area`
--

INSERT INTO `qgs_product_area` (`id`, `name`) VALUES
(1, '北京市'),
(2, '天津市'),
(3, '河北省'),
(4, '山西省'),
(5, '内蒙古自治区'),
(6, '辽宁省'),
(7, '吉林省'),
(8, '黑龙江省'),
(9, '上海市'),
(10, '江苏省'),
(11, '浙江省'),
(12, '安徽省'),
(13, '福建省'),
(14, '江西省'),
(15, '山东省'),
(16, '河南省'),
(17, '湖北省'),
(18, '湖南省'),
(19, '广东省'),
(20, '广西壮族自治区'),
(21, '海南省'),
(22, '重庆市'),
(23, '四川省'),
(24, '贵州省'),
(25, '云南省'),
(26, '西藏自治区'),
(27, '陕西省'),
(28, '甘肃省'),
(29, '青海省'),
(30, '宁夏回族自治区'),
(31, '新疆维吾尔自治区');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_article`
--

CREATE TABLE IF NOT EXISTS `qgs_product_article` (
  `id` int(11) NOT NULL COMMENT 'id',
  `title` varchar(100) NOT NULL COMMENT '文章标题',
  `short_desc` varchar(150) NOT NULL COMMENT '文章短描述|口号',
  `shotcut` varchar(300) NOT NULL COMMENT '文章缩略图',
  `product` varchar(100) NOT NULL COMMENT '产品名称',
  `price` float(8,2) NOT NULL COMMENT '产品价格',
  `visitor` int(11) NOT NULL COMMENT '阅读量',
  `content` text NOT NULL COMMENT '文章内容',
  `top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶,@0:否,@1:是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,@0:草稿,@1:发布',
  `updatetime` int(11) NOT NULL COMMENT '更新时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_product_article`
--

INSERT INTO `qgs_product_article` (`id`, `title`, `short_desc`, `shotcut`, `product`, `price`, `visitor`, `content`, `top`, `status`, `updatetime`, `createtime`) VALUES
(1, '测试文章一', '是的发送到发送到', 'http://qgshop.b0.upaiyun.com/2016/11/10/04/05/13/upload_5c9462e857fe02a61f646f4780982d2f.jpg', '产品产地萨芬奇偶', 123.50, 120, '&lt;p&gt;\\r\\n	发放的撒旦法\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	asdf松岛枫松岛枫\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	sdfsdfsadf 撒旦法第三方\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦法士大夫撒地方大幅是的发生\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	啥地方地方撒旦法撒旦\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/11/10/04/05/13/upload_5c9462e857fe02a61f646f4780982d2f.jpg&quot; alt=&quot;&quot; /&gt;\\r\\n&lt;/p&gt;', 1, 1, 1478754847, 1478754847),
(2, '测试文章二', '撒旦法撒旦法撒', 'http://qgshop.b0.upaiyun.com/2016/11/10/05/15/50/upload_9410a7ed11a3bb4df232940e4a70d909.jpg', '地方干啥撒旦法第三方', 125.62, 1230, '&lt;p&gt;\\r\\n	士大夫撒士大夫撒\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	asdfsdf撒旦法撒旦法撒旦法\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦法撒旦法撒旦法撒的发生的非法\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒打发斯蒂芬\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/11/10/05/15/50/upload_9410a7ed11a3bb4df232940e4a70d909.jpg&quot; alt=&quot;&quot; /&gt;\\r\\n&lt;/p&gt;', 1, 1, 1478755024, 1478755024),
(5, '是对方的说法是', '撒旦法撒旦法撒旦法', 'http://qgshop.b0.upaiyun.com/2016/11/10/06/37/36/upload_9410a7ed11a3bb4df232940e4a70d909.jpg', '士大夫撒旦', 125.30, 1268, '&lt;p&gt;\\r\\n	撒旦飞洒地方 是的发撒的发生生\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦飞洒地方\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒地方撒地方\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	123231沙发士大夫撒旦爱上付电费\\r\\n&lt;/p&gt;', 1, 1, 1478759857, 1478759462),
(6, '撒地方', '士大夫撒旦', 'http://qgshop.b0.upaiyun.com/2016/11/10/06/38/55/upload_5c9462e857fe02a61f646f4780982d2f.jpg', '飒飒发', 125.00, 1212, '&lt;p&gt;\\r\\n	撒旦飞洒地方 撒地方沙发\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	sadfsadf 阿萨德发的\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦飞洒地方\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒的发的撒发送到发送到\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦法撒旦法撒\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦法撒旦法撒旦法\\r\\n&lt;/p&gt;', 1, 1, 1478759937, 1478759937),
(7, '全球新疆农村建设农村不是检测技术不错就是不对劲', '就不会吧', 'http://qgshop.b0.upaiyun.com/2016/12/18/08/00/57/upload_ee9e6252bc9ffefa1652d0075d6834bc.JPG', '结局就是今生今世', 100.00, 100, '开始的衄衄都君快说都衄款死', 0, 1, 1482048087, 1482048087);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_banner`
--

CREATE TABLE IF NOT EXISTS `qgs_product_banner` (
  `id` int(11) NOT NULL COMMENT 'banner id',
  `title` varchar(100) NOT NULL COMMENT 'banner标题',
  `img` varchar(300) NOT NULL COMMENT 'banner地址',
  `url` varchar(300) DEFAULT NULL COMMENT '链接地址',
  `sort` int(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='商家模块|首页banner表|张盛鸿|2016-11-03';

--
-- 转存表中的数据 `qgs_product_banner`
--

INSERT INTO `qgs_product_banner` (`id`, `title`, `img`, `url`, `sort`, `status`, `createtime`) VALUES
(1, '金秋美食不用挑', 'http://qgshop.b0.upaiyun.com/2016/11/03/09/59/39/upload_7942fcb8a3d8f2c06fa8aafb7e09098d.jpg', 'http://www.baidu.com', 0, 1, 1478165416),
(2, '新品集结，“食”在划算', 'http://qgshop.b0.upaiyun.com/2016/11/03/09/59/39/upload_7942fcb8a3d8f2c06fa8aafb7e09098d.jpg', '', 0, 1, 1478165925),
(3, '精选劲爆美食，食力全开', 'http://qgshop.b0.upaiyun.com/2016/11/03/09/59/39/upload_7942fcb8a3d8f2c06fa8aafb7e09098d.jpg', NULL, 0, 1, 1478165930),
(4, '量贩专享放肆购', 'http://qgshop.b0.upaiyun.com/2016/11/03/09/59/39/upload_7942fcb8a3d8f2c06fa8aafb7e09098d.jpg', NULL, 0, 1, 1478165955),
(6, '微微一笑，味蕾high爆', 'http://qgshop.b0.upaiyun.com/2016/11/03/09/59/39/upload_7942fcb8a3d8f2c06fa8aafb7e09098d.jpg', '', 1, 1, 1478165980);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_classify`
--

CREATE TABLE IF NOT EXISTS `qgs_product_classify` (
  `id` int(11) NOT NULL COMMENT '分类id',
  `title` varchar(60) NOT NULL COMMENT '分类名称',
  `shotcut` varchar(300) NOT NULL COMMENT '分类图片',
  `tag` varchar(10) DEFAULT NULL COMMENT '分类标签',
  `top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页推荐',
  `sort` int(6) NOT NULL DEFAULT '0' COMMENT '排序,越大越靠前',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,@0:停用,@1:启用',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `class` int(11) NOT NULL COMMENT '上级id'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品分类管理|张盛鸿|2016-11-02';

--
-- 转存表中的数据 `qgs_product_classify`
--

INSERT INTO `qgs_product_classify` (`id`, `title`, `shotcut`, `tag`, `top`, `sort`, `status`, `createtime`, `class`) VALUES
(1, '夏日冰饮', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/45/45/upload_93cedaa8c78b4145f1a3659b3d281bcf.jpg', 'hot', 1, 0, 1, 1478069157, 0),
(2, '水果干类', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/47/07/upload_0ecb4b46d3b998be77536bc012ade862.jpg', 'new', 1, 0, 1, 1478069231, 0),
(3, '进口果酱', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/47/52/upload_323073051247984d5d3f95a3c0d9bb01.jpg', '', 1, 0, 1, 1478069275, 1),
(4, '零食饼干', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/48/13/upload_93cedaa8c78b4145f1a3659b3d281bcf.jpg', '', 1, 0, 1, 1478069295, 0),
(5, '口袋零食', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/45/45/upload_93cedaa8c78b4145f1a3659b3d281bcf.jpg', 'new', 1, 0, 1, 1478069444, 0),
(6, '野生蜜糖', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/45/45/upload_93cedaa8c78b4145f1a3659b3d281bcf.jpg', '', 1, 0, 1, 1478069482, 0),
(7, '精装礼盒', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/47/52/upload_323073051247984d5d3f95a3c0d9bb01.jpg', '', 0, 0, 1, 1478069497, 0),
(8, '工艺茶包', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/45/45/upload_93cedaa8c78b4145f1a3659b3d281bcf.jpg', '', 0, 0, 1, 1478069511, 0),
(9, '周边小物', 'http://qgshop.b0.upaiyun.com/2016/11/02/06/48/13/upload_93cedaa8c78b4145f1a3659b3d281bcf.jpg', '', 1, 0, 1, 1478069525, 1),
(11, '零食二级', 'http://qgshop.b0.upaiyun.com/2017/03/27/02/21/15/upload_4fed34c68b5173e2baaeca9998a89a23.png', '', 0, 0, 1, 1490581290, 4);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_comments`
--

CREATE TABLE IF NOT EXISTS `qgs_product_comments` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id,from:qgs_member',
  `oid` int(11) NOT NULL COMMENT '订单id',
  `pid` int(11) NOT NULL COMMENT '产品id,from:qgs_product',
  `format` varchar(50) DEFAULT NULL COMMENT '规格',
  `fname` varchar(50) DEFAULT NULL COMMENT '规格名称',
  `top` int(11) NOT NULL DEFAULT '0' COMMENT '顶层id',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `stars` int(1) NOT NULL DEFAULT '0' COMMENT '星级评分',
  `content` varchar(500) NOT NULL COMMENT '评论内容',
  `imgs` text COMMENT '晒图',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '显示状态',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商家模块|商品评价表|张盛鸿|2016-12-13';

--
-- 转存表中的数据 `qgs_product_comments`
--

INSERT INTO `qgs_product_comments` (`id`, `uid`, `oid`, `pid`, `format`, `fname`, `top`, `parent`, `stars`, `content`, `imgs`, `status`, `createtime`) VALUES
(1, 6, 15, 7, '129', 'haha', 0, 0, 4, '格式的风格地方噶啥', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/43\\/16\\/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg","w":800,"h":800}]', 1, 1481687188),
(2, 6, 15, 4, '', '', 0, 0, 5, '撒旦飞洒地方', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/45\\/50\\/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/45\\/53\\/upload_42b15ff091851a7182acafa51db39b88.jpg","w":800,"h":800}]', 1, 1481687188),
(3, 6, 15, 5, '', '', 0, 0, 5, '是撒打发斯蒂芬', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/45\\/58\\/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg","w":800,"h":800}]', 1, 1481687188),
(4, 6, 15, 6, '119,122,124', '1L-32cm-不锈钢', 0, 0, 5, '撒旦飞洒地方', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/46\\/06\\/upload_e48c0d7918931e75fb71fbec24d77829.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/46\\/08\\/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/46\\/10\\/upload_2c3d5175e76a19ffe7dc2608ecab26bb.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/46\\/13\\/upload_3fff051a20861480152c70f360b5e808.jpg","w":800,"h":800}]', 1, 1481687188),
(5, 6, 15, 6, '119,122,125', '1L-32cm-生锈铁', 0, 0, 2, '撒的发生', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/03\\/46\\/23\\/upload_8a269889b97e3d63f0f27dd2c4c20abf.jpg","w":800,"h":800}]', 1, 1481687188),
(8, 1, 15, 7, NULL, NULL, 1, 0, 0, '感谢您的评价', NULL, 1, 1481853693),
(9, 1, 15, 7, NULL, NULL, 1, 8, 0, '哈哈哈', NULL, 1, 1481853703),
(10, 1, 15, 4, NULL, NULL, 2, 0, 0, '谢谢惠顾', NULL, 1, 1481854154),
(11, 1, 15, 4, NULL, NULL, 2, 10, 0, 'haode', NULL, 1, 1481854295),
(12, 6, 68, 4, '', '', 0, 0, 4, '还好吧', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/17\\/03\\/12\\/48\\/upload_7a621fd852c5ac93324a40bf4ed609e9.JPG","w":520,"h":640},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/17\\/03\\/13\\/04\\/upload_b62e562b453057b076dad1919bb414e4.JPG","w":690,"h":690}]', 1, 1481944387),
(13, 1, 68, 4, NULL, NULL, 12, 0, 0, '感谢您的评价!!!', NULL, 1, 1481944430),
(14, 6, 73, 4, '', '', 0, 0, 4, '规划局规划过', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/01\\/15\\/36\\/upload_b9d51ce3685b28c9dfe7df49746e7488.JPG","w":4032,"h":3024}]', 1, 1482196548),
(15, 1, 73, 4, NULL, NULL, 14, 0, 0, '您的支持就是我们的动力!', NULL, 1, 1482196611),
(16, 13, 80, 2, '126,114', '10mm-塑料', 0, 0, 5, '看来', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/06\\/30\\/51\\/upload_f9a88d2a6c4a84a1ec30fd7e9e8bcc68.jpeg","w":720,"h":1280}]', 1, 1482215454),
(17, 1, 80, 2, NULL, NULL, 16, 0, 0, '日你妈', NULL, 1, 1482215799),
(18, 6, 54, 4, '', '', 0, 0, 5, '放假啊算了开发商', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/06\\/46\\/56\\/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg","w":800,"h":800}]', 1, 1482216418),
(19, 6, 58, 7, '129', 'haha', 0, 0, 5, '尽快回家看看看', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/21\\/02\\/53\\/51\\/upload_7d8cabad5c2b8e12490e769671412cdc.jpg","w":3024,"h":4032},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/21\\/02\\/54\\/11\\/upload_a5d33e9d10bd01aef362b957fbe13787.jpg","w":4032,"h":3024},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/21\\/02\\/54\\/34\\/upload_ef3fafeb6d3eeac79e8be949da9feeb2.jpg","w":4032,"h":3024}]', 1, 1482288884),
(20, 6, 49, 4, '', '', 0, 0, 5, '非常好，非常喜欢', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/23\\/09\\/23\\/39\\/upload_38ff7e91e6b2b782c696b3bc2cf27aab.png","w":480,"h":480}]', 1, 1482485022),
(21, 1, 49, 4, NULL, NULL, 20, 0, 0, '谢谢您的支持哦!', NULL, 1, 1482485061),
(22, 1, 15, 4, NULL, NULL, 2, 11, 0, '213123', NULL, 1, 1489225895),
(23, 1, 15, 4, NULL, NULL, 2, 22, 0, '1231231', NULL, 1, 1489225899),
(24, 1, 15, 4, NULL, NULL, 2, 23, 0, '123333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333', NULL, 1, 1489225905);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_content`
--

CREATE TABLE IF NOT EXISTS `qgs_product_content` (
  `id` int(11) NOT NULL COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '商品id,from:qgs_product',
  `content` text NOT NULL COMMENT '图文详情'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品详情表|张盛鸿|2016-11-11';

--
-- 转存表中的数据 `qgs_product_content`
--

INSERT INTO `qgs_product_content` (`id`, `pid`, `content`) VALUES
(1, 1, '&lt;p&gt;\\r\\n	阿斯顿发斯蒂芬喀什\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒的发生敬爱的\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	阿萨德佛科asdf\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	打飞机奥士大夫卡洛斯\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	啊啥都放假了撒旦\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/11/16/02/58/33/upload_5c9462e857fe02a61f646f4780982d2f.jpg&quot; alt=&quot;&quot; /&gt; \\r\\n&lt;/p&gt;'),
(2, 2, '&lt;p&gt;\\r\\n	豆腐干达福萨福三\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	范德萨发斯蒂芬\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;br /&gt;\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	士大夫撒旦\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	士大夫撒旦\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;br /&gt;\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦飞洒地方\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/11/16/02/56/48/upload_60544dc6f43afdcafac76f8eeb5296df.png&quot; alt=&quot;&quot; /&gt; \\r\\n&lt;/p&gt;'),
(3, 3, '&lt;p&gt;\\r\\n	士大夫撒发生的\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒打发斯蒂芬\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦法撒旦法撒旦法三发送\\r\\n&lt;/p&gt;'),
(4, 4, '&lt;p&gt;\\r\\n	士大夫撒发生的\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒打发斯蒂芬\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	撒旦法撒旦法撒旦法三发送\\r\\n&lt;/p&gt;'),
(5, 5, '&lt;p&gt;\r\n	\\r\\n	啥地方萨多啥地方萨多\\r\\n\r\n&lt;/p&gt;\r\n\\r\\n\r\n&lt;p&gt;\r\n	\\r\\n	的点点滴滴\\r\\n\r\n&lt;/p&gt;'),
(6, 6, '&lt;p&gt;\r\n	\\r\\n	对方是否撒的发生杀敌发所多法\\r\\n\r\n&lt;/p&gt;\r\n\\r\\n\r\n&lt;p&gt;\r\n	\\r\\n	撒打发斯蒂芬asdfsadf\\r\\n\r\n&lt;/p&gt;\r\n\\r\\n\r\n&lt;p&gt;\r\n	\\r\\n	撒旦法撒旦法撒的撒旦法\\r\\n\r\n&lt;/p&gt;\r\n\\r\\n\r\n&lt;p&gt;\r\n	\\r\\n &lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/12/20/02/06/21/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg&quot; alt=&quot;&quot; /&gt;\\r\\n\r\n&lt;/p&gt;'),
(7, 7, '&lt;p&gt;\\r\\n	fdsfasfasdfasddfasdf\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	sdfasdf\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;br /&gt;\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	sadfasdfasdfsdf\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;br /&gt;\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	sadfasdfasdf\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;br /&gt;\\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	sdafasdfasdfasdffdsad\\r\\n&lt;/p&gt;'),
(8, 8, '1323'),
(9, 9, '');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_formkey`
--

CREATE TABLE IF NOT EXISTS `qgs_product_formkey` (
  `id` int(11) NOT NULL COMMENT 'id',
  `key` varchar(100) NOT NULL COMMENT '规格名称'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品规格表|张盛鸿|2016-11-11';

--
-- 转存表中的数据 `qgs_product_formkey`
--

INSERT INTO `qgs_product_formkey` (`id`, `key`) VALUES
(1, '颜色'),
(2, '尺寸'),
(3, '材质'),
(4, '容量'),
(5, '重量'),
(6, '包装');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_formlist`
--

CREATE TABLE IF NOT EXISTS `qgs_product_formlist` (
  `id` int(11) NOT NULL COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '商品id,from:qgs_product',
  `format` varchar(100) NOT NULL COMMENT '规格组合,以逗号分隔,如:1,2,3',
  `price` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '组合价格',
  `store` int(11) NOT NULL DEFAULT '0' COMMENT '库存'
) ENGINE=InnoDB AUTO_INCREMENT=377 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品库存表|张盛鸿|2016-11-11';

--
-- 转存表中的数据 `qgs_product_formlist`
--

INSERT INTO `qgs_product_formlist` (`id`, `pid`, `format`, `price`, `store`) VALUES
(313, 7, '129', 20.57, 46),
(314, 7, '130', 12.00, 42),
(331, 2, '126,113', 10.00, 25),
(332, 2, '126,114', 10.00, 22),
(333, 2, '127,113', 10.00, 25),
(334, 2, '127,114', 10.00, 25),
(338, 1, '113,108', 10.00, 20),
(339, 1, '113,109', 10.00, 20),
(340, 1, '113,110', 10.00, 20),
(341, 1, '114,108', 10.00, 20),
(342, 1, '114,109', 10.00, 20),
(343, 1, '114,110', 10.00, 20),
(344, 1, '115,108', 10.00, 20),
(345, 1, '115,109', 10.00, 20),
(346, 1, '115,110', 10.00, 20),
(365, 6, '119,121,124', 12.00, 20),
(366, 6, '119,121,125', 13.00, 16),
(367, 6, '119,122,124', 15.00, 8),
(368, 6, '119,122,125', 16.00, 13),
(369, 6, '119,123,124', 18.00, 20),
(370, 6, '119,123,125', 20.00, 20),
(371, 6, '120,121,124', 2200.00, 18),
(372, 6, '120,121,125', 26.00, 20),
(373, 6, '120,122,124', 28.00, 20),
(374, 6, '120,122,125', 12.50, 19),
(375, 6, '120,123,124', 12.88, 20),
(376, 6, '120,123,125', 12.99, 15);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_formvalue`
--

CREATE TABLE IF NOT EXISTS `qgs_product_formvalue` (
  `id` int(11) NOT NULL COMMENT 'id',
  `value` varchar(100) NOT NULL COMMENT '规格属性名'
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品规格属性表|张盛鸿|2016-11-11';

--
-- 转存表中的数据 `qgs_product_formvalue`
--

INSERT INTO `qgs_product_formvalue` (`id`, `value`) VALUES
(1, '安抚'),
(2, '法萨芬'),
(3, '撒的发的撒'),
(4, '发的'),
(5, '沙发'),
(6, '萨芬的'),
(7, '哀声'),
(8, '撒地方'),
(9, '啥的'),
(10, '地方'),
(11, '你猜'),
(12, '锡锡'),
(13, '哈哈'),
(14, '阿斯蒂芬'),
(15, '暗室逢灯'),
(16, '交接'),
(17, '答复'),
(18, '啊啊'),
(19, '爱的'),
(20, '阿萨德'),
(21, '规范'),
(22, '订单'),
(23, '成功'),
(24, '发个'),
(25, '分享'),
(26, '该规格'),
(27, '发送'),
(28, '大'),
(29, '需'),
(30, '12'),
(31, '33'),
(32, '66'),
(33, '77'),
(34, '99'),
(35, 'fd'),
(36, 'af'),
(37, 'df'),
(38, 'ff'),
(39, 'asdf'),
(40, 'de'),
(41, 'ds'),
(42, 'saf'),
(43, 'dd'),
(44, 'xc'),
(45, 'dfd'),
(46, 'sdf'),
(47, 'ggg'),
(48, '放到'),
(49, 'd方法'),
(50, '电放费'),
(51, '对方答复'),
(52, '发发发'),
(53, '方法非常差'),
(54, '交付给'),
(55, '答复个'),
(56, '你麻痹'),
(57, '发'),
(58, '从v'),
(59, '个人'),
(60, '个个规范'),
(61, '不能'),
(62, '回家'),
(63, '考虑'),
(64, '几个'),
(65, '更好'),
(66, '多个'),
(67, '接口'),
(68, '方法'),
(69, '老婆婆'),
(70, '咯欧赔'),
(71, '能不能'),
(72, '二'),
(73, '回家家'),
(74, '的高收入'),
(75, '健康快乐'),
(76, '看看'),
(77, '卡卡'),
(78, '规格'),
(79, '看破'),
(80, '欧赔'),
(81, '递归'),
(82, 'fg'),
(83, 'gh'),
(84, '嘻嘻'),
(85, '哈哈系'),
(86, '邪恶邪恶'),
(87, 'dfas'),
(88, 'hgh'),
(89, 'gggg'),
(90, 'gf'),
(91, 'ghhj'),
(92, 'hhh'),
(93, 'dfdf'),
(94, 'gg'),
(95, 'jj'),
(96, 'jjj'),
(97, 'fdd'),
(98, 'bbb'),
(99, 'fgg'),
(100, 'ghg'),
(101, 'fgfgfg'),
(102, '的'),
(103, 'fgh'),
(104, '记录'),
(105, '发生的'),
(106, '结婚后'),
(107, '存储'),
(108, '1kg'),
(109, '2kg'),
(110, '3kg'),
(111, '涤纶'),
(112, '纯棉'),
(113, '纸质'),
(114, '塑料'),
(115, '原木'),
(116, '访问'),
(117, '1*1'),
(118, '1*2'),
(119, '1L'),
(120, '2L'),
(121, '16cm'),
(122, '32cm'),
(123, '50cm'),
(124, '不锈钢'),
(125, '生锈铁'),
(126, '10mm'),
(127, '25mm'),
(128, '哈哈哈'),
(129, 'haha'),
(130, 'xixi'),
(131, '22'),
(132, '+664'),
(133, '46464'),
(134, '111');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_freight`
--

CREATE TABLE IF NOT EXISTS `qgs_product_freight` (
  `id` int(11) NOT NULL COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '产品id',
  `aid` int(11) NOT NULL COMMENT '地区id',
  `freight` float(10,2) NOT NULL COMMENT '运费'
) ENGINE=InnoDB AUTO_INCREMENT=621 DEFAULT CHARSET=utf8 COMMENT='商家模块|地区运费表|张盛鸿||2016-11-26';

--
-- 转存表中的数据 `qgs_product_freight`
--

INSERT INTO `qgs_product_freight` (`id`, `pid`, `aid`, `freight`) VALUES
(187, 7, 1, 5.00),
(188, 7, 2, 5.00),
(189, 7, 3, 5.00),
(190, 7, 4, 5.00),
(191, 7, 5, 5.00),
(192, 7, 6, 5.00),
(193, 7, 7, 5.00),
(194, 7, 8, 5.00),
(195, 7, 9, 5.00),
(196, 7, 10, 5.00),
(197, 7, 11, 5.00),
(198, 7, 12, 5.00),
(199, 7, 13, 5.00),
(200, 7, 14, 5.00),
(201, 7, 15, 5.00),
(202, 7, 16, 5.00),
(203, 7, 17, 5.00),
(204, 7, 18, 5.00),
(205, 7, 19, 5.00),
(206, 7, 20, 5.00),
(207, 7, 21, 5.00),
(208, 7, 22, 5.00),
(209, 7, 23, 5.00),
(210, 7, 24, 5.00),
(211, 7, 25, 5.00),
(212, 7, 26, 5.00),
(213, 7, 27, 5.00),
(214, 7, 28, 5.00),
(215, 7, 29, 5.00),
(216, 7, 30, 5.00),
(217, 7, 31, 5.00),
(280, 4, 1, 0.00),
(281, 4, 2, 0.00),
(282, 4, 3, 0.00),
(283, 4, 4, 0.00),
(284, 4, 5, 0.00),
(285, 4, 6, 0.00),
(286, 4, 7, 0.00),
(287, 4, 8, 0.00),
(288, 4, 9, 0.00),
(289, 4, 10, 0.00),
(290, 4, 11, 0.00),
(291, 4, 12, 0.00),
(292, 4, 13, 0.00),
(293, 4, 14, 0.00),
(294, 4, 15, 0.00),
(295, 4, 16, 0.00),
(296, 4, 17, 0.00),
(297, 4, 18, 0.00),
(298, 4, 19, 0.00),
(299, 4, 20, 0.00),
(300, 4, 21, 0.00),
(301, 4, 22, 0.00),
(302, 4, 23, 0.00),
(303, 4, 24, 0.00),
(304, 4, 25, 0.00),
(305, 4, 26, 0.00),
(306, 4, 27, 0.00),
(307, 4, 28, 0.00),
(308, 4, 29, 0.00),
(309, 4, 30, 0.00),
(310, 4, 31, 0.00),
(311, 3, 1, 0.00),
(312, 3, 2, 0.00),
(313, 3, 3, 0.00),
(314, 3, 4, 0.00),
(315, 3, 5, 0.00),
(316, 3, 6, 0.00),
(317, 3, 7, 0.00),
(318, 3, 8, 0.00),
(319, 3, 9, 0.00),
(320, 3, 10, 0.00),
(321, 3, 11, 0.00),
(322, 3, 12, 0.00),
(323, 3, 13, 0.00),
(324, 3, 14, 0.00),
(325, 3, 15, 0.00),
(326, 3, 16, 0.00),
(327, 3, 17, 0.00),
(328, 3, 18, 0.00),
(329, 3, 19, 0.00),
(330, 3, 20, 0.00),
(331, 3, 21, 0.00),
(332, 3, 22, 0.00),
(333, 3, 23, 0.00),
(334, 3, 24, 0.00),
(335, 3, 25, 0.00),
(336, 3, 26, 0.00),
(337, 3, 27, 0.00),
(338, 3, 28, 0.00),
(339, 3, 29, 0.00),
(340, 3, 30, 0.00),
(341, 3, 31, 0.00),
(342, 2, 1, 0.00),
(343, 2, 2, 0.00),
(344, 2, 3, 0.00),
(345, 2, 4, 0.00),
(346, 2, 5, 0.00),
(347, 2, 6, 0.00),
(348, 2, 7, 0.00),
(349, 2, 8, 0.00),
(350, 2, 9, 0.00),
(351, 2, 10, 0.00),
(352, 2, 11, 0.00),
(353, 2, 12, 0.00),
(354, 2, 13, 0.00),
(355, 2, 14, 0.00),
(356, 2, 15, 0.00),
(357, 2, 16, 0.00),
(358, 2, 17, 0.00),
(359, 2, 18, 0.00),
(360, 2, 19, 0.00),
(361, 2, 20, 0.00),
(362, 2, 21, 0.00),
(363, 2, 22, 0.00),
(364, 2, 23, 0.00),
(365, 2, 24, 0.00),
(366, 2, 25, 0.00),
(367, 2, 26, 0.00),
(368, 2, 27, 0.00),
(369, 2, 28, 0.00),
(370, 2, 29, 0.00),
(371, 2, 30, 0.00),
(372, 2, 31, 0.00),
(373, 1, 1, 0.00),
(374, 1, 2, 0.00),
(375, 1, 3, 0.00),
(376, 1, 4, 0.00),
(377, 1, 5, 0.00),
(378, 1, 6, 0.00),
(379, 1, 7, 0.00),
(380, 1, 8, 0.00),
(381, 1, 9, 0.00),
(382, 1, 10, 0.00),
(383, 1, 11, 0.00),
(384, 1, 12, 0.00),
(385, 1, 13, 0.00),
(386, 1, 14, 0.00),
(387, 1, 15, 0.00),
(388, 1, 16, 0.00),
(389, 1, 17, 0.00),
(390, 1, 18, 0.00),
(391, 1, 19, 0.00),
(392, 1, 20, 0.00),
(393, 1, 21, 0.00),
(394, 1, 22, 0.00),
(395, 1, 23, 0.00),
(396, 1, 24, 0.00),
(397, 1, 25, 0.00),
(398, 1, 26, 0.00),
(399, 1, 27, 0.00),
(400, 1, 28, 0.00),
(401, 1, 29, 0.00),
(402, 1, 30, 0.00),
(403, 1, 31, 0.00),
(435, 8, 1, 0.00),
(436, 8, 2, 0.00),
(437, 8, 3, 0.00),
(438, 8, 4, 0.00),
(439, 8, 5, 0.00),
(440, 8, 6, 0.00),
(441, 8, 7, 0.00),
(442, 8, 8, 0.00),
(443, 8, 9, 0.00),
(444, 8, 10, 0.00),
(445, 8, 11, 0.00),
(446, 8, 12, 0.00),
(447, 8, 13, 0.00),
(448, 8, 14, 0.00),
(449, 8, 15, 0.00),
(450, 8, 16, 0.00),
(451, 8, 17, 0.00),
(452, 8, 18, 0.00),
(453, 8, 19, 0.00),
(454, 8, 20, 0.00),
(455, 8, 21, 0.00),
(456, 8, 22, 0.00),
(457, 8, 23, 0.00),
(458, 8, 24, 0.00),
(459, 8, 25, 0.00),
(460, 8, 26, 0.00),
(461, 8, 27, 0.00),
(462, 8, 28, 0.00),
(463, 8, 29, 0.00),
(464, 8, 30, 0.00),
(465, 8, 31, 0.00),
(528, 9, 1, 0.00),
(529, 9, 2, 0.00),
(530, 9, 3, 0.00),
(531, 9, 4, 0.00),
(532, 9, 5, 0.00),
(533, 9, 6, 0.00),
(534, 9, 7, 0.00),
(535, 9, 8, 0.00),
(536, 9, 9, 0.00),
(537, 9, 10, 0.00),
(538, 9, 11, 0.00),
(539, 9, 12, 0.00),
(540, 9, 13, 0.00),
(541, 9, 14, 0.00),
(542, 9, 15, 0.00),
(543, 9, 16, 0.00),
(544, 9, 17, 0.00),
(545, 9, 18, 0.00),
(546, 9, 19, 0.00),
(547, 9, 20, 0.00),
(548, 9, 21, 0.00),
(549, 9, 22, 0.00),
(550, 9, 23, 0.00),
(551, 9, 24, 0.00),
(552, 9, 25, 0.00),
(553, 9, 26, 0.00),
(554, 9, 27, 0.00),
(555, 9, 28, 0.00),
(556, 9, 29, 0.00),
(557, 9, 30, 0.00),
(558, 9, 31, 0.00),
(559, 6, 1, 12.50),
(560, 6, 2, 13.50),
(561, 6, 3, 15.50),
(562, 6, 4, 12.50),
(563, 6, 5, 12.50),
(564, 6, 6, 12.50),
(565, 6, 7, 16.50),
(566, 6, 8, 12.50),
(567, 6, 9, 12.50),
(568, 6, 10, 12.50),
(569, 6, 11, 12.50),
(570, 6, 12, 12.50),
(571, 6, 13, 12.50),
(572, 6, 14, 12.50),
(573, 6, 15, 12.50),
(574, 6, 16, 12.50),
(575, 6, 17, 12.50),
(576, 6, 18, 12.50),
(577, 6, 19, 12.50),
(578, 6, 20, 12.50),
(579, 6, 21, 12.50),
(580, 6, 22, 12.50),
(581, 6, 23, 12.50),
(582, 6, 24, 12.50),
(583, 6, 25, 12.50),
(584, 6, 26, 12.50),
(585, 6, 27, 12.50),
(586, 6, 28, 12.50),
(587, 6, 29, 18.50),
(588, 6, 30, 19.50),
(589, 6, 31, 20.50),
(590, 5, 1, 0.00),
(591, 5, 2, 0.00),
(592, 5, 3, 0.00),
(593, 5, 4, 0.00),
(594, 5, 5, 0.00),
(595, 5, 6, 0.00),
(596, 5, 7, 0.00),
(597, 5, 8, 0.00),
(598, 5, 9, 0.00),
(599, 5, 10, 0.00),
(600, 5, 11, 0.00),
(601, 5, 12, 0.00),
(602, 5, 13, 0.00),
(603, 5, 14, 0.00),
(604, 5, 15, 0.00),
(605, 5, 16, 0.00),
(606, 5, 17, 0.00),
(607, 5, 18, 0.00),
(608, 5, 19, 0.00),
(609, 5, 20, 0.00),
(610, 5, 21, 0.00),
(611, 5, 22, 0.00),
(612, 5, 23, 0.00),
(613, 5, 24, 0.00),
(614, 5, 25, 0.00),
(615, 5, 26, 0.00),
(616, 5, 27, 0.00),
(617, 5, 28, 0.00),
(618, 5, 29, 0.00),
(619, 5, 30, 0.00),
(620, 5, 31, 0.00);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_notice`
--

CREATE TABLE IF NOT EXISTS `qgs_product_notice` (
  `id` int(11) NOT NULL COMMENT 'id',
  `title` varchar(50) NOT NULL COMMENT '公告标题',
  `sdesc` varchar(150) DEFAULT NULL COMMENT '公告描述'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品memo表|张盛鸿|2016-11-17';

--
-- 转存表中的数据 `qgs_product_notice`
--

INSERT INTO `qgs_product_notice` (`id`, `title`, `sdesc`) VALUES
(1, '满¥100包邮', '凡在本店购物满100元即可包邮'),
(2, '卖家承诺24小时内发货', ''),
(3, '可到店铺自提', '店铺地址：广东省 佛山市 大良街道 新宁路41号铺趣果网络科技有限公司');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_product_service`
--

CREATE TABLE IF NOT EXISTS `qgs_product_service` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `oid` int(11) NOT NULL COMMENT '订单id,from:qgs_member_orders',
  `uid` int(11) NOT NULL COMMENT '用户id,from:qgs_member',
  `top` int(11) NOT NULL DEFAULT '0' COMMENT '顶层id',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT '父层id',
  `content` varchar(500) NOT NULL COMMENT '内容',
  `imgs` text COMMENT '图片',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态,@0-未处理,@1-处理中,@2-处理完毕',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='商家模块|商品售后表|张盛鸿|2016-12-13';

--
-- 转存表中的数据 `qgs_product_service`
--

INSERT INTO `qgs_product_service` (`id`, `oid`, `uid`, `top`, `parent`, `content`, `imgs`, `status`, `createtime`) VALUES
(1, 56, 6, 0, 0, '华盛顿附近私房大师傅口水发电江南新城v看过的发卡机发金额无扣分撒开房间爱思考法士大夫', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/07\\/20\\/24\\/upload_e48c0d7918931e75fb71fbec24d77829.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/07\\/20\\/27\\/upload_a6a91803f612005e2d22a33027b3dd30.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/07\\/20\\/30\\/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg","w":800,"h":800},{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/14\\/07\\/20\\/33\\/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg","w":800,"h":800}]', 2, 1481700036),
(2, 56, 1, 1, 0, '您好，这边正在处理您的申请，请稍候...', NULL, 0, 1481870557),
(3, 56, 1, 1, 2, 'hello,在吗?', NULL, 0, 1481870590),
(4, 56, 1, 1, 3, '亲，在吗?', NULL, 0, 1481870742),
(7, 57, 6, 0, 0, '感觉很烦很好', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/03\\/41\\/49\\/upload_3b5910b435eef322182304026f8ef190.PNG","w":750,"h":1334}]', 0, 1482205313),
(8, 56, 6, 0, 0, '感觉好好伺候', '', 0, 1482205509),
(9, 59, 6, 0, 0, '公交卡里后来', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/03\\/46\\/56\\/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg","w":800,"h":800}]', 0, 1482205619),
(10, 55, 6, 0, 0, '撒谎的发家史的法律', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/03\\/50\\/14\\/upload_42b15ff091851a7182acafa51db39b88.jpg","w":800,"h":800}]', 0, 1482205815),
(13, 76, 6, 0, 0, '姐姐就回家', '', 1, 1482206841),
(14, 80, 13, 0, 0, '看来', '[{"src":"http:\\/\\/qgshop.b0.upaiyun.com\\/2016\\/12\\/20\\/06\\/33\\/36\\/upload_f9a88d2a6c4a84a1ec30fd7e9e8bcc68.jpeg","w":720,"h":1280}]', 1, 1482215617),
(15, 80, 1, 14, 0, '日你妈', NULL, 0, 1482215695),
(16, 80, 1, 14, 15, '水电费水电费', NULL, 0, 1482215742),
(17, 76, 1, 13, 0, '哈哈哈哈', NULL, 0, 1482465286),
(21, 76, 0, 13, 17, 'sdfsa', NULL, 0, 1482477563),
(22, 76, 0, 13, 21, '还继续', NULL, 0, 1482478164),
(23, 76, 1, 13, 22, '哈哈看', NULL, 0, 1482479457),
(24, 76, 0, 13, 23, '滚你妈逼', NULL, 0, 1482479467),
(25, 76, 1, 13, 24, '哈哈哈哈', NULL, 0, 1482479474),
(26, 76, 0, 13, 25, '还是说', NULL, 0, 1482479499),
(27, 76, 0, 13, 26, '小喇叭', NULL, 0, 1482480362),
(28, 76, 0, 13, 27, '哈哈哈', NULL, 0, 1482480382),
(29, 76, 1, 13, 28, '滚', NULL, 0, 1482480394),
(30, 76, 1, 13, 29, '哈哈哈', NULL, 0, 1482480660),
(31, 76, 0, 13, 30, '好的', NULL, 0, 1482481309),
(32, 74, 6, 0, 0, '我要退货！！！！！', '', 2, 1482484613);

-- --------------------------------------------------------

--
-- 表的结构 `qgs_profile`
--

CREATE TABLE IF NOT EXISTS `qgs_profile` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `name` varchar(200) NOT NULL COMMENT '店铺全称',
  `description` varchar(500) NOT NULL COMMENT '店铺描述',
  `commend` varchar(100) DEFAULT NULL COMMENT '商城推荐商品',
  `share_word` varchar(500) DEFAULT NULL COMMENT '分享文字',
  `share_desc` varchar(200) DEFAULT NULL COMMENT '分享描述',
  `share_image` varchar(300) DEFAULT NULL COMMENT '分享图片',
  `appid` char(18) NOT NULL COMMENT 'appid',
  `appsecret` char(32) NOT NULL COMMENT 'appsecret',
  `detail` text NOT NULL COMMENT '图文详情页内容'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qgs_profile`
--

INSERT INTO `qgs_profile` (`id`, `name`, `description`, `commend`, `share_word`, `share_desc`, `share_image`, `appid`, `appsecret`, `detail`) VALUES
(1, '暗示法还是觉得烦fgdsg', '哈舒服就暗示的', '2,4', '爱上对方就三块', '分享分享分享的积分撒娇地方', 'http://qgshop.b0.upaiyun.com/2016/12/13/02/53/04/upload_d65eadcabb2eabba47c6ab634dfc5012.jpg', 'wx0768a1d834a6b7e8', 'b2f3142e16694d10d69e7f1fab81d1c8', '&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/10/31/08/33/54/upload_e48c0d7918931e75fb71fbec24d77829.jpg&quot; alt=&quot;&quot; /&gt; \\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/10/26/09/33/02/upload_f2d574344ac0c6c2dcfc6f29f4338924.jpg&quot; alt=&quot;&quot; /&gt;&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/10/26/09/33/03/upload_04d3993b6dbbf86b265489684cf0a0b6.jpg&quot; alt=&quot;&quot; /&gt;&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/10/26/09/33/03/upload_bb0b53cef0031ef670f9b1ae7f72efc0.jpg&quot; alt=&quot;&quot; /&gt; \\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/10/26/09/48/14/upload_4c8ed56a91b084a1d3f34734561e2eae.jpg&quot; alt=&quot;&quot; /&gt; \\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/10/27/08/22/21/upload_8071f4965f495d497dc63ddcfb428e1e.jpg&quot; alt=&quot;&quot; /&gt; \\r\\n&lt;/p&gt;\\r\\n&lt;p&gt;\\r\\n	&lt;img src=&quot;http://qgshop.b0.upaiyun.com/2016/12/21/02/58/55/upload_42b15ff091851a7182acafa51db39b88.jpg&quot; alt=&quot;&quot; /&gt;\\r\\n&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `qgs_score_lists`
--

CREATE TABLE IF NOT EXISTS `qgs_score_lists` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id,from:qgs_member',
  `type` varchar(15) NOT NULL COMMENT '积分来源',
  `amount` varchar(20) NOT NULL COMMENT '收入/支出数量',
  `createtime` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户积分变动情况表';

--
-- 转存表中的数据 `qgs_score_lists`
--

INSERT INTO `qgs_score_lists` (`id`, `uid`, `type`, `amount`, `createtime`) VALUES
(1, 6, 'orders', '-25', 1480646835),
(2, 6, 'orders', '-100', 1480647049),
(3, 6, 'orders', '-200', 1482214290);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qgs_addons`
--
ALTER TABLE `qgs_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_admin`
--
ALTER TABLE `qgs_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_attachment`
--
ALTER TABLE `qgs_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_auth_group`
--
ALTER TABLE `qgs_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_auth_group_access`
--
ALTER TABLE `qgs_auth_group_access`
  ADD UNIQUE KEY `uid_2` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `qgs_auth_rule`
--
ALTER TABLE `qgs_auth_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_buyer`
--
ALTER TABLE `qgs_buyer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_column`
--
ALTER TABLE `qgs_column`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_coupon`
--
ALTER TABLE `qgs_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_coupon_list`
--
ALTER TABLE `qgs_coupon_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_handtake_place`
--
ALTER TABLE `qgs_handtake_place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_hooks`
--
ALTER TABLE `qgs_hooks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `qgs_jifen`
--
ALTER TABLE `qgs_jifen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_login_log`
--
ALTER TABLE `qgs_login_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member`
--
ALTER TABLE `qgs_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member_address`
--
ALTER TABLE `qgs_member_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member_code`
--
ALTER TABLE `qgs_member_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member_collect`
--
ALTER TABLE `qgs_member_collect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member_orderlist`
--
ALTER TABLE `qgs_member_orderlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member_orders`
--
ALTER TABLE `qgs_member_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_member_score`
--
ALTER TABLE `qgs_member_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_notice`
--
ALTER TABLE `qgs_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_orders`
--
ALTER TABLE `qgs_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_pay_config`
--
ALTER TABLE `qgs_pay_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product`
--
ALTER TABLE `qgs_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_addition`
--
ALTER TABLE `qgs_product_addition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_area`
--
ALTER TABLE `qgs_product_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_article`
--
ALTER TABLE `qgs_product_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_banner`
--
ALTER TABLE `qgs_product_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_classify`
--
ALTER TABLE `qgs_product_classify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_comments`
--
ALTER TABLE `qgs_product_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_content`
--
ALTER TABLE `qgs_product_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_formkey`
--
ALTER TABLE `qgs_product_formkey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_formlist`
--
ALTER TABLE `qgs_product_formlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_formvalue`
--
ALTER TABLE `qgs_product_formvalue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_freight`
--
ALTER TABLE `qgs_product_freight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_notice`
--
ALTER TABLE `qgs_product_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_product_service`
--
ALTER TABLE `qgs_product_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_profile`
--
ALTER TABLE `qgs_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qgs_score_lists`
--
ALTER TABLE `qgs_score_lists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qgs_addons`
--
ALTER TABLE `qgs_addons`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键';
--
-- AUTO_INCREMENT for table `qgs_admin`
--
ALTER TABLE `qgs_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `qgs_attachment`
--
ALTER TABLE `qgs_attachment`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `qgs_auth_group`
--
ALTER TABLE `qgs_auth_group`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `qgs_auth_rule`
--
ALTER TABLE `qgs_auth_rule`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `qgs_buyer`
--
ALTER TABLE `qgs_buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `qgs_column`
--
ALTER TABLE `qgs_column`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `qgs_coupon`
--
ALTER TABLE `qgs_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `qgs_coupon_list`
--
ALTER TABLE `qgs_coupon_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `qgs_handtake_place`
--
ALTER TABLE `qgs_handtake_place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `qgs_hooks`
--
ALTER TABLE `qgs_hooks`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `qgs_jifen`
--
ALTER TABLE `qgs_jifen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `qgs_login_log`
--
ALTER TABLE `qgs_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT for table `qgs_member`
--
ALTER TABLE `qgs_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `qgs_member_address`
--
ALTER TABLE `qgs_member_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `qgs_member_code`
--
ALTER TABLE `qgs_member_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `qgs_member_collect`
--
ALTER TABLE `qgs_member_collect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `qgs_member_orderlist`
--
ALTER TABLE `qgs_member_orderlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT for table `qgs_member_orders`
--
ALTER TABLE `qgs_member_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `qgs_member_score`
--
ALTER TABLE `qgs_member_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `qgs_notice`
--
ALTER TABLE `qgs_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键编号',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `qgs_orders`
--
ALTER TABLE `qgs_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `qgs_pay_config`
--
ALTER TABLE `qgs_pay_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `qgs_product`
--
ALTER TABLE `qgs_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `qgs_product_addition`
--
ALTER TABLE `qgs_product_addition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `qgs_product_area`
--
ALTER TABLE `qgs_product_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `qgs_product_article`
--
ALTER TABLE `qgs_product_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `qgs_product_banner`
--
ALTER TABLE `qgs_product_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'banner id',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `qgs_product_classify`
--
ALTER TABLE `qgs_product_classify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `qgs_product_comments`
--
ALTER TABLE `qgs_product_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `qgs_product_content`
--
ALTER TABLE `qgs_product_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `qgs_product_formkey`
--
ALTER TABLE `qgs_product_formkey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `qgs_product_formlist`
--
ALTER TABLE `qgs_product_formlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=377;
--
-- AUTO_INCREMENT for table `qgs_product_formvalue`
--
ALTER TABLE `qgs_product_formvalue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `qgs_product_freight`
--
ALTER TABLE `qgs_product_freight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=621;
--
-- AUTO_INCREMENT for table `qgs_product_notice`
--
ALTER TABLE `qgs_product_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `qgs_product_service`
--
ALTER TABLE `qgs_product_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `qgs_profile`
--
ALTER TABLE `qgs_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `qgs_score_lists`
--
ALTER TABLE `qgs_score_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
