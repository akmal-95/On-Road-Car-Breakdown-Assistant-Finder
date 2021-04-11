-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2020 at 11:08 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multi_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `shopname` varchar(100) NOT NULL,
  `feederback` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `username`, `shopname`, `feederback`) VALUES
(61, 'alirankaam', 'star rating', 'please insert the star rating so that users can give review toward workshop'),
(65, 'alibaba', 'star ratin', 'there are no star rating');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `location_status` tinyint(1) DEFAULT 0,
  `towing` tinyint(1) NOT NULL DEFAULT 0,
  `tyres` tinyint(1) NOT NULL DEFAULT 0,
  `battery` tinyint(1) NOT NULL DEFAULT 0,
  `mechanic` tinyint(1) NOT NULL DEFAULT 0,
  `workshopusername` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `workshopname` varchar(255) NOT NULL,
  `wphonenumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `lat`, `lng`, `description`, `location_status`, `towing`, `tyres`, `battery`, `mechanic`, `workshopusername`, `firstname`, `lastname`, `phonenumber`, `workshopname`, `wphonenumber`) VALUES
(47, 1.854260, 103.093613, 'KM20, LORONG USAHASAMA, 86400 Parit Raja, Johor', 1, 1, 1, 1, 1, 'alirankaam', 'hisham', 'sham', '12345789', 'aliran kaam', '0123456789'),
(49, 1.843997, 103.075905, '86400 Parit Raja, Johor', 1, 1, 0, 1, 1, 'arulworkshop', 'arul', 'ali', '123456789', 'arul workshop', '0123456789'),
(51, 1.853970, 103.092484, 'No. 13 A, Lorong Sri Hakim 1, Kampung Parit Haji Abdul Kadir,, Parit Raja,, 86400 Batu Pahat, Johor', 1, 1, 1, 1, 1, 'aliranbiru', 'ali', 'abu', '123456789', 'aliran biru', '012345789'),
(53, 1.851567, 103.088554, 'no 2 lorong mewah 14', 1, 1, 1, 0, 0, 'aliranbiru', 'aliran', 'biru', '12345789', 'aliran biru', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `vote` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requested`
--

CREATE TABLE `requested` (
  `id` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `location_status` tinyint(1) DEFAULT 0,
  `workshopusername` varchar(255) NOT NULL,
  `servicetype` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requested`
--

INSERT INTO `requested` (`id`, `lat`, `lng`, `description`, `location_status`, `workshopusername`, `servicetype`, `username`, `firstname`, `lastname`, `phonenumber`) VALUES
(165, 1.849310, 103.085220, 'asap', 0, 'aliranbiru', 'towing', 'hamja', 'ham', 'ja', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `workshopname` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `workplace` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `accountstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `workshopname`, `firstname`, `lastname`, `user_type`, `phonenumber`, `password`, `workplace`, `address`, `accountstatus`) VALUES
(70, 'admin', 'admin@gmail.com', '', 'admin', 'administrator', 'admin', '0123456789', 'admin123', '', 'admin', 'allow'),
(113, 'alirankaam', 'alirankaam@gmail.com', 'aliran kaam', 'hisham', 'sham', 'workshop', '12345789', 'aliran123', '', 'KM20, LORONG USAHASAMA, 86400 Parit Raja, Johor', 'allow'),
(117, 'sham12', 'sham12@gmail.com', '', 'sham', 'sham', 'mechanic', '1234789', 'sham123', 'alirankaam', '', 'allow'),
(118, 'admin2', 'admin2@gmail.com', '', 'admin2', 'admin2', 'admin', '0123456789', 'admin123', '', '', 'allow'),
(119, 'iricas', 'iricas@gmail.com', 'iricas tyres', 'iricas', 'bakar', 'workshop', '123456789', 'iri123', '', '2.2A Jalan Universiti 3, Taman Universiti Parit Raja, 86400 Batu Pahat, Johor', 'allow'),
(120, 'arulworkshop', 'arulworkshop@gmail.com', 'arul workshop', 'arul', 'ali', 'workshop', '123456789', 'arul123', '', '86400 Parit Raja, Johor', 'allow'),
(123, 'aliranbiru', 'aliranbiru12@gmail.com', 'aliran biru', 'ali', 'abu', 'workshop', '123456789', 'aliran123', '', 'No. 13 A, Lorong Sri Hakim 1, Kampung Parit Haji Abdul Kadir,, Parit Raja,, 86400 Batu Pahat, Johor', 'allow'),
(124, 'nazhim', 'nazhim1234@gmail.com', '', 'alibaba', 'tohid', 'mechanic', '123456789', 'nazhim123', 'aliranbiru', '', 'allow'),
(125, 'alibaba', 'alibaba@gmail.com', '', 'alis', 'bab', 'driver', '123456789s', 'ali123', '', '', 'block'),
(126, 'zainodin', 'zai@gmail.com', 'zai workshop', 'zai', 'pin', 'workshop', '123456789', 'zai123', '', 'no2', 'block'),
(128, 'hamka', 'hamka@gmail.com', '', 'hamka', 'lamka', 'driver', '123456789', 'ham123', '', '', 'allow'),
(129, 'hamja', 'hamja@gmail.com', '', 'ham', 'ja', 'driver', '123456789', 'ham123', '', '', 'block'),
(130, 'hamka', 'hamka@gmail.com', '', 'ham', 'lam', 'driver', '123456789', 'ham123', '', '', 'allow'),
(131, 'aliranbiru', 'aliranbiru@gmail.com', 'aliran biru', 'aliran', 'biru', 'workshop', '12345789', 'aliran123', '', 'no2 lorong mewah 14 taman mewah', 'allow');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requested`
--
ALTER TABLE `requested`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requested`
--
ALTER TABLE `requested`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
