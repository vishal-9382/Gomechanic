-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 12:05 PM
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
-- Database: `onlinemachanicfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_username` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `commission_percent` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_username`, `admin_password`, `commission_percent`) VALUES
(1, 'Admin', 'admin', 'admin', 10);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(100) NOT NULL,
  `city_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
(1, 'Karad'),
(2, 'Sangli'),
(3, 'Kolhapur'),
(4, 'Nagpur'),
(5, 'Miraj'),
(6, 'Pune'),
(7, 'Nashik'),
(8, 'Sambhaji Nagar'),
(10, 'Satara');

-- --------------------------------------------------------

--
-- Table structure for table `city_area`
--

CREATE TABLE `city_area` (
  `area_id` int(100) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `area_city` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `city_area`
--

INSERT INTO `city_area` (`area_id`, `area_name`, `area_city`) VALUES
(1, 'Bus stand', 1),
(2, 'Vs chowk', 2),
(3, 'Wakad', 2),
(4, 'market yard', 5),
(5, 'swargate', 6),
(6, 'Ghat road', 4),
(7, 'Rajarampuri', 3),
(8, 'Bali bazar road', 1),
(9, 'Shiroli', 3),
(10, 'Cotton market road', 4),
(11, 'Mahatma gandhi road', 5),
(12, 'Wakad', 6),
(13, 'Indira nagar', 7),
(14, 'Dwarka', 7),
(15, 'GP road', 8),
(16, 'Bus stand', 8),
(17, 'Jule', 9),
(18, 'Rangraj nagar', 9),
(19, 'MIDC', 10),
(20, 'Bus stand', 10);

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `id` int(11) NOT NULL,
  `user_type` enum('Mechanic','User') NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_queries`
--

INSERT INTO `contact_queries` (`id`, `user_type`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'User', 'abc', 'abc@gmail.com', '', 'rud', '2025-02-05 06:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(100) NOT NULL,
  `feedback_job` int(100) NOT NULL,
  `feedback_proffessional` int(100) NOT NULL,
  `feedback_user` int(100) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `feedback_comments` text NOT NULL,
  `feedback_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `feedback_job`, `feedback_proffessional`, `feedback_user`, `rating`, `feedback_comments`, `feedback_date`) VALUES
(3, 3, 12, 1, '4', '	feedback				', '2020-04-03 11:26:45'),
(4, 10, 12, 1, '5', '		nice work			', '2020-04-07 20:43:11'),
(5, 0, 0, 0, '3', '		jhgjkhghkgjhk			', '2020-04-23 14:28:44'),
(6, 0, 0, 0, '5', 'Nice work!!!			', '2020-05-12 20:33:35'),
(7, 0, 0, 0, '5', 'Nice work!!!				', '2020-05-12 20:35:16'),
(8, 0, 0, 0, '5', 'Nice work!!!					', '2020-05-12 20:38:09'),
(9, 0, 0, 0, '', 'Nice work					', '2020-05-12 20:38:28'),
(10, 0, 0, 0, '5', 'Great work.					', '2020-05-12 20:43:22'),
(11, 0, 0, 0, '5', 'Great work				', '2020-05-12 20:48:24'),
(12, 0, 0, 0, '', 'Thanks for working				', '2020-05-12 20:52:03'),
(13, 0, 0, 0, '', 'Thanks for working				', '2020-05-12 20:53:05'),
(14, 0, 0, 0, '5', '			kjdnvfnkvf		', '2020-05-12 20:54:50'),
(15, 0, 0, 0, '5', '			kjdnvfnkvf		', '2020-05-12 20:56:40'),
(16, 0, 13, 2, '4', 'Service is very good \r\n				', '2025-02-04 05:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(50) NOT NULL,
  `user_id` int(100) NOT NULL,
  `job_machanic` int(100) NOT NULL,
  `job_date` datetime NOT NULL,
  `job_status` varchar(50) NOT NULL,
  `work_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `fixed_issue` varchar(255) NOT NULL,
  `bill_amount` int(11) NOT NULL DEFAULT 0,
  `issue_related` text NOT NULL,
  `mechanic_type` varchar(255) NOT NULL,
  `qr_code_image_path` varchar(255) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `upi_id` varchar(255) DEFAULT NULL,
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `admin_commission` int(11) NOT NULL DEFAULT 0,
  `mechanic_earnings` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `user_id`, `job_machanic`, `job_date`, `job_status`, `work_status`, `fixed_issue`, `bill_amount`, `issue_related`, `mechanic_type`, `qr_code_image_path`, `qr_code`, `upi_id`, `payment_status`) VALUES
(47, 2, 13, '2025-02-11 11:51:22', 'Accepted', 'Completed', 'engine work', 750, '', '', '', NULL, 'M@ybl', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `professional`
--

CREATE TABLE `professional` (
  `mechanic_id` int(200) NOT NULL,
  `mechanic_Fullname` varchar(200) NOT NULL,
  `mechanic_cnic` bigint(200) NOT NULL,
  `mechanic_address` varchar(200) NOT NULL,
  `mechanic_city` varchar(200) NOT NULL,
  `machanic_city_area` int(50) NOT NULL,
  `mechanic_contact` bigint(200) NOT NULL,
  `mechanic_email` varchar(200) NOT NULL,
  `experience` varchar(100) NOT NULL,
  `rate_per_hour` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `mechanic_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `professional`
--

INSERT INTO `professional` (`mechanic_id`, `mechanic_Fullname`, `mechanic_cnic`, `mechanic_address`, `mechanic_city`, `machanic_city_area`, `mechanic_contact`, `mechanic_email`, `experience`, `rate_per_hour`, `password`, `status`, `mechanic_type`) VALUES
(12, 'Sanket Shinde', 22222, 'Tasgoan', '1', 1, 2234455, 'sanket@gmail.com', '5', 5, '12345678', 'Active', ''),
(13, 'vinod pawar', 2345345234, 'market yard sangli', '1', 1, 987654321, 'vinod45@gmail.com', '4 year', 250, '12345678', 'Active', ''),
(14, 'Om khadtare', 334422225566, ' Rajarampuri, Kolhapur', '2', 7, 9234567890, 'om@gmail.com', '9', 400, '12345678', 'Active', ''),
(16, 'Rajesh Sharma', 123456789101, '12, MG Road, Delhi.', '2', 3, 9876543210, 'rajesh.sharma@email.com', '10', 500, '12345678', 'Active', ''),
(17, 'Amit Verma', 234567891012, '45, Sector 15, Noida', '3', 9, 8765432109, 'amit.verma@email.com', '8', 450, '12345678', 'Active', ''),
(18, 'Suresh Yadav', 345678901123, '78, Park Street, Mumbai', '4', 6, 7654321098, 'suresh.yadav@email.com', '12', 600, '12345678', 'Active', ''),
(19, 'Pankaj Singh', 4567, '23, Anna Nagar, Chennai', '4', 10, 6543210987, 'pankaj.singh@email.com', '7', 400, '12345678', 'Active', ''),
(20, 'Manoj Kumar', 5678, '89, Baner Road, Pune', '6', 5, 5432109876, 'manoj.kumar@email.com', '15', 700, '12345678', 'Active', ''),
(21, 'Vijay Patil', 678901233456, '34, MG Road, Bangalore', '6', 12, 4321098765, 'vijay.patil@email.com', '9', 100, '12345678', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(200) NOT NULL,
  `user_Fullname` varchar(200) NOT NULL,
  `user_cnic` bigint(200) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `user_city` varchar(200) NOT NULL,
  `user_contact` bigint(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_Fullname`, `user_cnic`, `user_address`, `user_city`, `user_contact`, `user_email`, `user_password`) VALUES
(1, 'Vishal', 9934567890, ' Cantt ', 'kota', 98765432167, 'vishal@gmail.com', '12345678'),
(2, 'Mandar lad', 2345345234, 'Boltan market karad ', 'karad', 3139615234, 'abc@gmail.com', '1234'),
(4, 'mayur', 787878787878, 'ashta ', 'ashta', 8667645699, 'mayur@gmail.com', '12345678'),
(5, 'Anil Mehta', 890123455678, '90, Garia, Kolkata ', ' Kolkata', 2109876543, 'anil.mehta@email.com', '12345678'),
(6, 'Sunil Joshi', 901234566789, '12, Andheri West, Mumbai ', 'Mumbai', 1987654321, 'sunil.joshi@email.com', '12345678'),
(7, 'Prakash Rao', 112345677890, '44, Jubilee Hills, Hyderabad ', ' Hyderabad', 2876543210, 'prakash.rao@email.com', '12345678'),
(8, 'Deepak Sharma', 223456788901, '67, Powai, Mumbai ', 'Mumbai', 3765432109, 'deepak.sharma@email.com', '12345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `city_area`
--
ALTER TABLE `city_area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `professional`
--
ALTER TABLE `professional`
  ADD PRIMARY KEY (`mechanic_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `city_area`
--
ALTER TABLE `city_area`
  MODIFY `area_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `professional`
--
ALTER TABLE `professional`
  MODIFY `mechanic_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
