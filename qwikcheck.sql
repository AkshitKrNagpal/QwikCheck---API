-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2016 at 08:50 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qwikcheck`
--

-- --------------------------------------------------------

--
-- Table structure for table `insurancedetails`
--

CREATE TABLE `insurancedetails` (
  `InsuranceID` varchar(255) NOT NULL,
  `RegNo` varchar(255) NOT NULL,
  `InsType` varchar(255) NOT NULL,
  `InsCompanyID` varchar(255) NOT NULL,
  `InsCheckerID` varchar(255) NOT NULL,
  `InsuredOn` date NOT NULL,
  `InsuredUpto` date NOT NULL,
  `Valuation` int(11) NOT NULL,
  `Coverage` varchar(255) NOT NULL,
  `InsuredToID` varchar(255) NOT NULL,
  `InsCost` int(11) NOT NULL,
  `LastInsID` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Vehicle Insurance Details (updated frequently)';

--
-- Dumping data for table `insurancedetails`
--

INSERT INTO `insurancedetails` (`InsuranceID`, `RegNo`, `InsType`, `InsCompanyID`, `InsCheckerID`, `InsuredOn`, `InsuredUpto`, `Valuation`, `Coverage`, `InsuredToID`, `InsCost`, `LastInsID`) VALUES
('IN001', 'DL13SG5035', 'First', '100', '100', '2016-08-20', '2017-03-21', 100000, 'Accidental', '001', 2000, 'IN000');

-- --------------------------------------------------------

--
-- Table structure for table `pollutiondetails`
--

CREATE TABLE `pollutiondetails` (
  `PUCCNo` varchar(255) NOT NULL,
  `RegNo` varchar(255) NOT NULL,
  `EngineStroke` varchar(255) NOT NULL,
  `FuelType` varchar(255) NOT NULL,
  `CheckedOn` date NOT NULL,
  `ValidUpto` date NOT NULL,
  `CentreCode` varchar(255) NOT NULL,
  `pCheckerID` varchar(255) NOT NULL,
  `CostPUCC` int(11) NOT NULL,
  `LastPUCCNo` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Pollution Certificate Details (Updated frequently)';

--
-- Dumping data for table `pollutiondetails`
--

INSERT INTO `pollutiondetails` (`PUCCNo`, `RegNo`, `EngineStroke`, `FuelType`, `CheckedOn`, `ValidUpto`, `CentreCode`, `pCheckerID`, `CostPUCC`, `LastPUCCNo`) VALUES
('PUCC001', 'DL13SG5035', '4', 'Petrol', '2016-10-14', '2017-01-01', 'CENTRE001', 'Checker001', 70, 'PUCC000');

-- --------------------------------------------------------

--
-- Table structure for table `session_api`
--

CREATE TABLE `session_api` (
  `api_id` int(11) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_api`
--

INSERT INTO `session_api` (`api_id`, `api_key`, `user_id`) VALUES
(7, 'R7q8MBr+GPwNN2Q22TFUgZ7rTDKNqtTi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `password` text NOT NULL,
  `full_name` text NOT NULL,
  `address` mediumtext,
  `contact_no` text,
  `type` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `full_name`, `address`, `contact_no`, `type`) VALUES
(1, 'akshit', 'R7q8MBr+GPwNN2Q22TFUgeX0Z+ei8g82rXFPFjtI4O8=', 'Akshit Kr Nagpal', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicledetails`
--

CREATE TABLE `vehicledetails` (
  `RegNo` varchar(255) NOT NULL,
  `EngineNo` varchar(255) NOT NULL,
  `ChassisNo` varchar(255) NOT NULL,
  `Manufacturer` varchar(255) NOT NULL,
  `Model` varchar(255) NOT NULL,
  `YearOfManufacturing` year(4) NOT NULL,
  `RegDate` date NOT NULL,
  `RegUpto` date NOT NULL,
  `FuelType` varchar(255) NOT NULL,
  `FuelCapacity` int(11) NOT NULL,
  `SeatingCapacity` int(11) NOT NULL,
  `VehicleCategory` varchar(255) NOT NULL,
  `WeightCategory` varchar(255) NOT NULL,
  `UsageCategory` varchar(255) NOT NULL,
  `Color` varchar(255) NOT NULL,
  `NoOfCyl` int(11) NOT NULL,
  `CC` int(11) NOT NULL,
  `BodyType` varchar(255) NOT NULL,
  `OwnerName` varchar(255) NOT NULL,
  `OwnerID` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Vehicle Permanent Details (That do not change frequently)';

--
-- Dumping data for table `vehicledetails`
--

INSERT INTO `vehicledetails` (`RegNo`, `EngineNo`, `ChassisNo`, `Manufacturer`, `Model`, `YearOfManufacturing`, `RegDate`, `RegUpto`, `FuelType`, `FuelCapacity`, `SeatingCapacity`, `VehicleCategory`, `WeightCategory`, `UsageCategory`, `Color`, `NoOfCyl`, `CC`, `BodyType`, `OwnerName`, `OwnerID`) VALUES
('DL13SG5035', '1234567890', '0987654321', 'HERO HONDA', 'SPLENDOR-NXG', 2009, '2009-10-10', '2038-10-09', 'Petrol', 10, 4, 'M.CYL', '500', 'PRSNL', 'Black', 1, 99, 'mine', 'Vishesh', '001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `insurancedetails`
--
ALTER TABLE `insurancedetails`
  ADD PRIMARY KEY (`InsuranceID`);

--
-- Indexes for table `pollutiondetails`
--
ALTER TABLE `pollutiondetails`
  ADD PRIMARY KEY (`PUCCNo`),
  ADD UNIQUE KEY `UNIQUE` (`RegNo`,`ValidUpto`);

--
-- Indexes for table `session_api`
--
ALTER TABLE `session_api`
  ADD PRIMARY KEY (`api_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicledetails`
--
ALTER TABLE `vehicledetails`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `UNIQUE` (`EngineNo`,`ChassisNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `session_api`
--
ALTER TABLE `session_api`
  MODIFY `api_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
