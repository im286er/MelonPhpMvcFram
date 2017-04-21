-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-02-14 10:10:38
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imooc`
--

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE `news` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `fdate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `author`, `url`, `fdate`) VALUES
(1, '测试第一篇', '是的发射点发射斯蒂芬斯蒂芬斯蒂芬', '', '', '2017-02-14 13:39:58'),
(4, '测试第二篇', '第二篇第二篇', '斯蒂芬斯蒂芬', 'www.baidu.com', '2017-02-14 15:49:13');

-- --------------------------------------------------------

--
-- 表的结构 `sliderimg`
--

CREATE TABLE `sliderimg` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `text` varchar(200) NOT NULL,
  `classId` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sliderimg`
--

INSERT INTO `sliderimg` (`id`, `name`, `text`, `classId`) VALUES
(1, '1.png', '1111', 1),
(2, '2.png', '2222', 1);

-- --------------------------------------------------------

--
-- 表的结构 `slider_class`
--

CREATE TABLE `slider_class` (
  `id` int(10) NOT NULL,
  `class_name` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `slider_class`
--

INSERT INTO `slider_class` (`id`, `class_name`) VALUES
(1, '首页轮播图');

-- --------------------------------------------------------

--
-- 表的结构 `testjm`
--

CREATE TABLE `testjm` (
  `id` int(11) NOT NULL,
  `pass` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `testjm`
--

INSERT INTO `testjm` (`id`, `pass`) VALUES
(1, 'aaaaa'),
(2, '--'),
(3, '\\aa'),
(4, 'a'),
(5, 'aaaa'),
(6, '55643d17b3988d35d2b7c8a42ace180f'),
(7, 'e25500e1bb16846bc2c679455db78c99'),
(8, '65c94593b88237160dfd7305112eeed0'),
(31, 'e25500e1bb16846bc2c679455db78c99'),
(32, 'e25500e1bb16846bc2c679455db78c99');

-- --------------------------------------------------------

--
-- 表的结构 `testjoin`
--

CREATE TABLE `testjoin` (
  `id` int(11) NOT NULL,
  `pName` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `testjoin`
--

INSERT INTO `testjoin` (`id`, `pName`) VALUES
(1, 14354),
(2, 1244),
(3, 25145);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(30) NOT NULL COMMENT '邮箱',
  `token` varchar(50) NOT NULL COMMENT '帐号激活码',
  `token_exptime` int(10) NOT NULL COMMENT '激活码有效期',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,0-未激活,1-已激活',
  `regtime` int(10) NOT NULL COMMENT '注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `token`, `token_exptime`, `status`, `regtime`) VALUES
(4, 'imooc111', 'imooc222', 'imooc333@imooc.com', '4444', 1234444, 0, 12345678);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliderimg`
--
ALTER TABLE `sliderimg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_class`
--
ALTER TABLE `slider_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testjm`
--
ALTER TABLE `testjm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testjoin`
--
ALTER TABLE `testjoin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `sliderimg`
--
ALTER TABLE `sliderimg`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `slider_class`
--
ALTER TABLE `slider_class`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `testjm`
--
ALTER TABLE `testjm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- 使用表AUTO_INCREMENT `testjoin`
--
ALTER TABLE `testjoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
