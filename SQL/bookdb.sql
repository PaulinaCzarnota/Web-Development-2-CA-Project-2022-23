-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 03:57 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookstable`
--

CREATE TABLE `bookstable` (
  `ISBN` varchar(20) NOT NULL,
  `BookTitle` varchar(50) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Edition` int(2) NOT NULL,
  `Year` int(4) NOT NULL,
  `CategoryID` int(3) NOT NULL,
  `Reserved` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookstable`
--

INSERT INTO `bookstable` (`ISBN`, `BookTitle`, `Author`, `Edition`, `Year`, `CategoryID`, `Reserved`) VALUES
('093-403992', 'Computers in Business', 'Alicia O\'neill', 3, 1997, 3, 'Y'),
('23472-8729', 'Exploring Peru', 'Stephanie Birchi', 4, 2005, 5, 'N'),
('237-34823', 'Business Strategy', 'Joe Peppard', 2, 2002, 2, 'N'),
('23u8-923849', 'A Guide to Nutrition', 'John Thorpe', 2, 1997, 1, 'N'),
('2983-3494', 'Cooking for Children', 'Anabelle Sharpe', 1, 2003, 7, 'N'),
('82n8-308', 'Computers for Idiots', 'Susan O\'Neill', 5, 1998, 4, 'N'),
('9823-23984', 'My Life in Picture', 'Kevin Graham', 8, 2004, 1, 'N'),
('9823-2403-0', 'DaVinci Code', 'Dan Brown', 1, 2003, 8, 'N'),
('9823-98345', 'How to Cook Italian Food', 'Jamie Oliver', 2, 2005, 7, 'Y'),
('9823-98487', 'Optimising Your Business', 'Cleo Blair', 1, 2001, 2, 'N'),
('98234-029384', 'My Ranch in Texas', 'George Bush', 1, 2005, 1, 'Y'),
('988745-234', 'Tara Road', 'Maeve Binchy', 4, 2002, 8, 'N'),
('993-004-00', 'My Life in Bits', 'John Smith', 1, 2001, 1, 'N'),
('9987-0039882', 'Shooting History', 'Jon Snow', 1, 2003, 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `categorytable`
--

CREATE TABLE `categorytable` (
  `CategoryID` int(3) NOT NULL,
  `CategoryDescription` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categorytable`
--

INSERT INTO `categorytable` (`CategoryID`, `CategoryDescription`) VALUES
(1, 'Health'),
(2, 'Business'),
(3, 'Biography'),
(4, 'Technology'),
(5, 'Travel'),
(6, 'Self-Help'),
(7, 'Cookery'),
(8, 'Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `reservedbooktable`
--

CREATE TABLE `reservedbooktable` (
  `ISBN` varchar(20) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `ReservedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservedbooktable`
--

INSERT INTO `reservedbooktable` (`ISBN`, `Username`, `ReservedDate`) VALUES
('093-403992', 'tommy100', '2022-11-22'),
('98234-029384', 'joecrotty', '2008-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `userstable`
--

CREATE TABLE `userstable` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(6) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `AddressLine1` varchar(40) NOT NULL,
  `AddressLine2` varchar(40) NOT NULL,
  `City` varchar(30) NOT NULL,
  `Telephone` int(10) NOT NULL,
  `Mobile` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userstable`
--

INSERT INTO `userstable` (`Username`, `Password`, `FirstName`, `Surname`, `AddressLine1`, `AddressLine2`, `City`, `Telephone`, `Mobile`) VALUES
('alanjmckenna', 't1234s', 'Alan', 'McKenna', '38 Cranley Road', 'Fairview', 'Dublin', 9998377, 856625567),
('joetcrotty', 'kj7899', 'Joseph', 'Crotty', 'Apt 5 Clyde Road', 'Donnybrook', 'Dublin', 8887889, 876654456),
('tommy100', '123456', 'Tom', 'Behan', '14 Hyde Road', 'Dalkey', 'Dublin', 9983747, 876738782);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookstable`
--
ALTER TABLE `bookstable`
  ADD UNIQUE KEY `ISBN` (`ISBN`),
  ADD KEY `CatID_FK` (`CategoryID`);

--
-- Indexes for table `categorytable`
--
ALTER TABLE `categorytable`
  ADD UNIQUE KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `reservedbooktable`
--
ALTER TABLE `reservedbooktable`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `User_FK` (`Username`) USING BTREE;

--
-- Indexes for table `userstable`
--
ALTER TABLE `userstable`
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookstable`
--
ALTER TABLE `bookstable`
  ADD CONSTRAINT `CatID_FK` FOREIGN KEY (`CategoryID`) REFERENCES `categorytable` (`CategoryID`);

--
-- Constraints for table `reservedbooktable`
--
ALTER TABLE `reservedbooktable`
  ADD CONSTRAINT `ISBN_FK` FOREIGN KEY (`ISBN`) REFERENCES `bookstable` (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
