-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 02:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `Username` varchar(4) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Province` varchar(20) NOT NULL,
  `Postal` varchar(10) NOT NULL,
  `AddressID` varchar(10) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`Username`, `Country`, `Province`, `Postal`, `AddressID`, `Name`) VALUES
('C001', 'USA', 'California', '90001', 'A1', 'Roy'),
('GUES', '1111', '1111', '1111', 'A10', '1111'),
('GUES', '2222', '2222', '2222', 'A11', '2222'),
('007', 'asdas', 'sadad', 'asdas', 'A12', 'asd'),
('007', 'aaa', 'aaa', 'aaa', 'A13', 'aaa'),
('GUES', 'asd', 'asd', 'asd', 'A15', 'sad'),
('GUES', 'asd', 'asd', 'asd', 'A16', 'sad'),
('C002', 'UK', 'England', 'SW1A 1AA', 'A2', 'John'),
('C003', 'Canada', 'Ontario', 'M5B 2H1', 'A3', 'John'),
('C004', 'Australia', 'New South Wales', '2000', 'A4', 'Messi'),
('C005', 'Japan', 'Tokyo', '100-0001', 'A5', 'Ronaldo'),
('C001', 'USA', 'New York', '10001', 'A6', 'Jame'),
('C002', 'UK', 'Scotland', 'EH1 1AA', 'A7', 'Steve'),
('C003', 'Canada', 'British Columbia', 'V6C 3E1', 'A8', 'Kane'),
('GUES', '11111', '11111', '11111', 'A9', '11111');

-- --------------------------------------------------------

--
-- Table structure for table `addresslist`
--

CREATE TABLE `addresslist` (
  `AddressID` varchar(4) NOT NULL,
  `OrderID` varchar(4) NOT NULL,
  `Type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresslist`
--

INSERT INTO `addresslist` (`AddressID`, `OrderID`, `Type`) VALUES
('A13', 'OR14', 'Buy'),
('A13', 'OR14', 'Bill'),
('A13', 'OR14', 'Ship'),
('A15', 'OR15', 'Buy'),
('A15', 'OR15', 'Bill'),
('A15', 'OR15', 'Ship'),
('A16', 'OR16', 'Buy'),
('A16', 'OR16', 'Bill'),
('A16', 'OR16', 'Ship'),
('A13', 'OR17', 'Buy'),
('A12', 'OR17', 'Bill'),
('A12', 'OR17', 'Ship'),
('A12', 'OR18', 'Buy'),
('A12', 'OR18', 'Bill'),
('A12', 'OR18', 'Ship'),
('A12', 'OR19', 'Buy'),
('A12', 'OR19', 'Bill'),
('A12', 'OR19', 'Ship'),
('A13', 'OR20', 'Buy'),
('A12', 'OR20', 'Bill'),
('A12', 'OR20', 'Ship'),
('A13', 'OR21', 'Buy'),
('A13', 'OR21', 'Bill'),
('A13', 'OR21', 'Ship');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Username` varchar(4) NOT NULL,
  `ProductID` varchar(4) NOT NULL,
  `Qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`FName`, `LName`, `Password`, `Username`, `Email`) VALUES
('Emily', 'Brown', '$2y$10$ED5g9kHzRUEe1/JKQZfHQ.aLOpy/VolVQKg7zyratrikvZlxXMKhC', '007', ''),
('John', 'Doe', '$2y$10$HiETyBSz524J64r0MZXb0uYfHVnLmk2yxmlh7/eLZZvJhi6v2Ue/q', '1111', ''),
('Jane', 'Smith', '$2y$10$sGmoJXfmq1sEk1a9/eixjOJDo7ojKyZrIM.OhL16wD/U8yiL7eV1.', '2222', ''),
('David', 'Wilson', '$2y$10$oV6iUzz08M5XZca1qzXRaOIVd9UMgEhkBblqoHeCUR4ZnfyfwnDG6', '7777', ''),
('Michael', 'Johnson', '$2y$10$ZT0calowJOV/tvfV4UMlVeXXjrLxRe1O6u4wa7gk79qFq1rLpJspW', 'as12', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `EmployeeID` varchar(10) NOT NULL,
  `Role` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`FName`, `LName`, `EmployeeID`, `Role`, `Password`) VALUES
('FFFF', 'LLLL', 'admin', 'admin', '$2y$10$svhCJwUIwo5Z9acKx9Q4meRgdMHsCY6AwKHtz1i.xooGmuLnXVetG');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `Date` datetime NOT NULL,
  `Username` varchar(10) NOT NULL,
  `Action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`Date`, `Username`, `Action`) VALUES
('2024-03-27 18:50:17', '007', 'Login'),
('2024-03-28 00:34:00', '007', 'Logout'),
('2024-03-28 00:38:37', '007', 'Login'),
('2024-03-29 01:29:08', '007', 'Login'),
('2024-03-29 20:02:11', '007', 'Login');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Username` varchar(10) NOT NULL,
  `Date` datetime NOT NULL,
  `Status` varchar(30) NOT NULL,
  `OrderID` varchar(10) NOT NULL,
  `Payment` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`Username`, `Date`, `Status`, `OrderID`, `Payment`) VALUES
('007', '2024-03-26 20:21:39', 'Shipping', 'OR14', 'CashOnDelivery'),
('GUEST', '2024-03-27 15:30:59', 'Waiting For Payment', 'OR15', 'CashOnDelivery'),
('GUEST', '2024-03-27 15:35:48', 'Waiting For Payment', 'OR16', 'CashOnDelivery'),
('007', '2024-03-27 19:12:23', 'Waiting For Verification', 'OR17', 'QRCode'),
('007', '2024-03-27 23:52:43', 'Waiting For Payment', 'OR18', 'CashOnDelivery'),
('007', '2024-03-27 23:58:09', 'Waiting For Payment', 'OR19', 'CashOnDelivery'),
('007', '2024-03-28 00:13:21', 'Waiting For Payment', 'OR20', 'CashOnDelivery'),
('007', '2024-03-28 00:29:11', 'Waiting For Payment', 'OR21', 'QRCode');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` varchar(10) NOT NULL,
  `PaymentType` varchar(15) NOT NULL,
  `Username` varchar(4) NOT NULL,
  `CardNumber` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `PaymentType`, `Username`, `CardNumber`) VALUES
('PMT1', 'Debit', 'C001', '1234567812345678'),
('PMT11', 'asdas', '007', 'dasdas'),
('PMT2', 'Debit', 'C002', '9876543298765432'),
('PMT3', 'PayPal', 'C003', '5432167854321678'),
('PMT4', 'PayPal', 'C004', '4567891045678910'),
('PMT5', 'Bank', 'C005', '8765432187654321'),
('PMT6', 'Credit', 'C001', '2345678923456789'),
('PMT7', 'Debit', 'C002', '7654321076543210'),
('PMT8', 'PayPal', 'C003', '6789105678910567'),
('PMT9', 'Bank', 'C002', '2134524545454');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(4) NOT NULL,
  `ProductName` varchar(20) NOT NULL,
  `QtyStock` int(10) NOT NULL,
  `PricePerUnit` float NOT NULL,
  `Detail` varchar(40) NOT NULL,
  `Cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `QtyStock`, `PricePerUnit`, `Detail`, `Cost`) VALUES
('P001', 'Laptop', -1, 1000, 'Intel Core i7, 16GB RAM, 512GB SSD', 850),
('P002', 'Smartphone', 0, 800, '6.5\" 64GB', 700),
('P003', 'Tablet', 73, 500, '10.1\" IPS Display, 64GB Storage, Android', 400),
('P004', 'Headphones', 195, 100, 'Over-ear, Noise Cancelling, Bluetooth', 90),
('P005', 'Keyboard', 0, 50, 'Mechanical, RGB Backlit, Wired', 40),
('P006', 'Mouse', 174, 25, 'Wireless, Optical Sensor, 6 Programmable', 20),
('P007', 'Monitor', -1, 300, '27\" IPS, 1440p Resolution, HDMI, Display', 280),
('P008', 'Printer', 89, 150, 'Color Laser, Duplex Printing, WiFi Conne', 100),
('P009', 'Hard Drive', 120, 80, '2TB Capacity, USB 3.0, Portable', 75),
('P010', 'USB Flash Drive', 236, 10, '64GB Capacity, USB 3.0, Keychain Design', 5);

-- --------------------------------------------------------

--
-- Table structure for table `productlist`
--

CREATE TABLE `productlist` (
  `ProductID` varchar(4) NOT NULL,
  `OrderID` varchar(4) NOT NULL,
  `Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productlist`
--

INSERT INTO `productlist` (`ProductID`, `OrderID`, `Qty`) VALUES
('P001', 'OR14', 1),
('P007', 'OR14', 1),
('P001', 'OR17', 0),
('P001', 'OR19', 1),
('P007', 'OR20', 1),
('P005', 'OR21', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
