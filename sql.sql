-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 年 03 月 04 日 10:23
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wenchuan`
--

-- --------------------------------------------------------

--
-- 表的结构 `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qiniu_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `is_del` varchar(1) NOT NULL DEFAULT '0',
  `del_time` datetime NOT NULL,
  `file_size` varchar(22) NOT NULL,
  `t_pwd` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=134 ;

--
-- 转存表中的数据 `file`
--

INSERT INTO `file` (`id`, `qiniu_name`, `file_name`, `is_del`, `del_time`, `file_size`, `t_pwd`) VALUES
(116, 'egut6s-1551688719000.txt', 'php中文网免费下载站.txt', '0', '2019-03-04 16:38:40', '219', 'egut6s'),
(117, 'yssqn-1551688746000.txt', 'php中文网免费下载站.txt', '0', '2019-03-04 16:39:06', '219', 'yssqn-'),
(124, '6zirhp-1551689230000.txt', 'php中文网免费下载站.txt', '0', '2019-03-04 16:47:10', '219', '6zirhp'),
(130, 'mojrxq-1551691690000.txt', 'php中文网免费下载站.txt', '0', '2019-03-04 17:28:10', '219', 'mojrxq');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
