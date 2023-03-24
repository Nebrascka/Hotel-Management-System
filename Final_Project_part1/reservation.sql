-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2023 at 11:33 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@reserve.com', 'Pass123_');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `suite` int(11) NOT NULL,
  `roomSelected` int(11) DEFAULT NULL,
  `totalPrice` int(11) NOT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT 0,
  `paymentStatus` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `created_by`, `checkin`, `checkout`, `adults`, `children`, `created_on`, `suite`, `roomSelected`, `totalPrice`, `isApproved`, `paymentStatus`) VALUES
(39, 2, '2023-03-25', '2023-03-26', 1, 0, '2023-03-24', 5, 16, 25000, 0, 0);

--
-- Triggers `applications`
--
DELIMITER $$
CREATE TRIGGER `insert_booking` AFTER UPDATE ON `applications` FOR EACH ROW BEGIN
  IF NEW.paymentStatus = true AND OLD.paymentStatus = false THEN
    INSERT INTO bookings (application_id, room_id) VALUES (NEW.id, NEW.roomSelected);
    UPDATE rooms SET isBooked = true WHERE id = NEW.roomSelected;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_rooms_isReserved` AFTER INSERT ON `applications` FOR EACH ROW BEGIN
  UPDATE rooms SET isReserved = true WHERE id = NEW.roomSelected;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `description` varchar(55) NOT NULL,
  `label` char(5) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `description`, `label`, `capacity`, `price`) VALUES
(5, 'Luxury Suite', 'LS', 12, 25000),
(6, 'Family Suite', 'FS', 18, 20000),
(7, 'Premium Suite', 'PS', 8, 29000);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomid` int(11) NOT NULL,
  `name` varchar(55) DEFAULT NULL,
  `number` varchar(55) NOT NULL,
  `category` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `isReserved` tinyint(1) NOT NULL DEFAULT 0,
  `isBooked` tinyint(1) NOT NULL DEFAULT 0,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomid`, `name`, `number`, `category`, `capacity`, `image`, `isReserved`, `isBooked`, `created_on`) VALUES
(18, 'Boasty shark', '11', 5, 1, '/img/6401fbe49f4951.00713921.jpg', 0, 0, '2023-03-03'),
(19, 'Green Leaf', '12', 5, 5, '/img/6401fbfd2b4961.73389606.jpg', 0, 0, '2023-03-03'),
(20, 'Eighty sites', '13', 7, 4, '/img/6401fc18636269.77488336.jpg', 0, 0, '2023-03-03'),
(21, 'Reef village', '14', 5, 7, '/img/6401fe19e3ea46.16076036.jpg', 0, 0, '2023-03-03'),
(22, 'Tropical villa', '15', 6, 9, '/img/6401fe30363ba6.49775317.jpg', 0, 0, '2023-03-03'),
(23, 'Light view', '17', 7, 3, '/img/6401fe45d4c405.47542184.jpg', 0, 0, '2023-03-03'),
(26, 'Beach front', '19', 7, 5, '/img/641d7c07941960.94938233.jpg', 0, 0, '2023-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `idNumber` varchar(55) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `idNumber`, `email`, `mobile`, `password`) VALUES
(1, 'John ', 'Doe', '87899878', 'joedan@gmail.com', '0788909878', '$2y$10$/e2aP2psM58ngunhF7W9MOMIOJetKjdGvhq895lK1DVrnUHvMMBFu'),
(2, 'Jane', 'Dean', '43434567', 'jane@doe.com', '0765456543', '$2y$10$P00BXk/G9sQLWQbSd1pkuuKDqnZlxMW5Hb5i/f8fhmY26wC9Hp1cS'),
(3, 'Miza', 'Nee', '23432345', 'miza@nee.com', '0787654567', '$2y$10$/vJJBLT.Uw.QoFXDAWhwGO6rkhM5CWlknNsUyV5UFnZc8aGSewCgy'),
(4, 'Jane', 'nm', '0000000', '0@e.com', '07888888888', '$2y$10$8fkUjJ5hMoFz.hYRsSv.IeuaojB1T9mvS/z0B/uHSM3bfb4a2tlC.'),
(5, 'John', 'Doe', '234567', 'email@test.com', '0789898767', '$2y$10$zO0ZvKzlZDouunSMWBdXc.ZH8lgK6cH4w6WGzsr0Fj2yojVicNlG2'),
(6, 'Hem', 'Swath', '12342536', 'email1@test.com', '0789878767', '$2y$10$z2NhQY73vHozyy49TClZ5eyu5cVywyABz8Ohtkxw7Ki/zZx8n0CFK'),
(7, 'Luigi', 'Rio', '243537', 'email2@test.com', '0789876578', '$2y$10$3/BSUOf8J15F2IkccuyosuHsYPTxspFNVzX8QW9KLQfui5NaUMwkO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `suite` (`suite`),
  ADD KEY `roomSelected` (`roomSelected`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `application_id` (`application_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomid`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_3` FOREIGN KEY (`suite`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`roomid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
