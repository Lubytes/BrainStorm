-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Host: db.cs.dal.ca
-- Generation Time: Mar 13, 2016 at 11:30 PM
-- Server version: 5.7.10
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `brainstorm`
--

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE IF NOT EXISTS `follows` (
  `username` char(60) NOT NULL,
  `follower` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `creator` char(60) DEFAULT NULL,
  `groupID` int(11) NOT NULL,
  `groupname` char(60) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`creator`, `groupID`, `groupname`, `description`) VALUES
('admin', 1, 'EVERYONE', NULL),
('admin', 2, 'PERSONAL', NULL),
('admin', 5, 'Fake Group', 'This is a fake group. This is the description of Fake Group. Get added!'),
('admin', 6, 'Another Fake Group', 'Here''s another fake group for testing.\r\n\r\nHave fun.');

-- --------------------------------------------------------

--
-- Table structure for table `in_group`
--

CREATE TABLE IF NOT EXISTS `in_group` (
  `username` char(60) NOT NULL,
  `groupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `in_group`
--

INSERT INTO `in_group` (`username`, `groupID`) VALUES
('admin', 5),
('admin', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pending_group`
--

CREATE TABLE IF NOT EXISTS `pending_group` (
  `username` char(60) NOT NULL,
  `groupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_ID` int(11) NOT NULL,
  `head` int(11) DEFAULT NULL,
  `type` char(20) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `username` char(60) DEFAULT NULL,
  `groupID` int(11) DEFAULT NULL,
  `title` char(80) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_ID`, `head`, `type`, `date_time`, `content`, `image`, `rating`, `username`, `groupID`, `title`) VALUES
(1, 1, 'empty', '2016-02-26 16:53:38', NULL, NULL, 0, 'admin', 1, NULL),
(2, 1, 'idea', '2016-02-26 16:55:14', 'This is a head idea post because it''s head ID is 1.', NULL, 0, 'admin', 1, 'Post Title'),
(3, 1, 'idea', '2016-02-26 16:56:02', 'This is a head idea post because it''s head ID is 1.', NULL, 0, 'admin', 1, 'Another Post title'),
(4, 1, 'idea', '2016-02-26 16:56:02', 'This is a head idea post because it''s head ID is 1.', NULL, 0, 'admin', NULL, 'More Post titles'),
(5, 3, 'branch', '2016-02-26 16:58:51', 'This is a sub-idea connected to postID 3.', NULL, 0, 'admin', NULL, NULL),
(6, 3, 'branch', '2016-02-26 17:06:53', 'This is a sub-idea connected to postID 3.', NULL, 0, 'admin', NULL, NULL),
(7, 2, 'branch', '2016-02-26 17:06:53', 'This is a sub-idea connected to postID 2.', NULL, 0, 'admin', NULL, NULL),
(8, 6, 'branch', '2016-02-26 17:06:53', 'This is a sub-idea connected to postID 6.', NULL, 0, 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `username` char(60) NOT NULL,
  `post_ID` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` char(60) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `displayName` char(60) DEFAULT NULL,
  `gender` char(30) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `displayName`, `gender`, `picture`, `description`, `status`, `admin`) VALUES
('admin', '$6$rounds=5000$4Ds0.2.A.F*pPi(8$N6e1Efq/tuX7BXCy4d6VW4UOkZDUah7pRTUBjDKfUO6eq15IipMZWx.hmm12S1BuvZUQ.OFZZhbT98vuRJPfz/', '', 'Administrator', 'female', '', 'Here''s a new bio.', 0, 1),
('bpoole', '$6$rounds=5000$4Ds0.2.A.F*pPi(8$c7Mu09w6awm9K30.rbtX9ODhv2akgLaTyBX938Qw1sILRN70PfGOuefQFm6nMZm15qHB8OOZKYTM3XN4ykf3O/', '', 'Brandon', 'male', '', '', 0, 0),
('ranran', '$6$rounds=5000$4Ds0.2.A.F*pPi(8$EhM4.anP6OiDX8pwP62m/L.W/4.Z8FJh9wUVKcCdrjtl0n.sVhjXkPCiYZJKreFEFf35ZwrBBvDEsqd.Tl1D3.', '', 'ranranrun', 'female', '', '', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`username`,`follower`), ADD KEY `follower` (`follower`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupID`), ADD KEY `creator` (`creator`);

--
-- Indexes for table `in_group`
--
ALTER TABLE `in_group`
  ADD PRIMARY KEY (`groupID`,`username`), ADD KEY `username` (`username`);

--
-- Indexes for table `pending_group`
--
ALTER TABLE `pending_group`
  ADD PRIMARY KEY (`username`,`groupID`), ADD KEY `groupID` (`groupID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_ID`), ADD KEY `username` (`username`), ADD KEY `head` (`head`), ADD KEY `groupID` (`groupID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`post_ID`,`username`), ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`follower`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `in_group`
--
ALTER TABLE `in_group`
ADD CONSTRAINT `in_group_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `in_group_ibfk_2` FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pending_group`
--
ALTER TABLE `pending_group`
ADD CONSTRAINT `pending_group_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pending_group_ibfk_2` FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`head`) REFERENCES `posts` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
