-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 03:11 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drivehub`
--

-- --------------------------------------------------------

--
-- Table structure for table `accreditation`
--

CREATE TABLE `accreditation` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `validID1` varchar(255) NOT NULL,
  `ID1_type` int(11) DEFAULT NULL COMMENT '1 - Employee, 2 - PhilID , 3 - NBI',
  `validID2` varchar(255) NOT NULL,
  `ID2_type` int(11) DEFAULT NULL COMMENT '1 - Employee, 2 - PhilID , 3 - NBI',
  `DTI` varchar(255) NOT NULL,
  `LTO` varchar(255) NOT NULL,
  `city_permit` varchar(255) NOT NULL,
  `BFP` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accreditation`
--

INSERT INTO `accreditation` (`id`, `school_id`, `validID1`, `ID1_type`, `validID2`, `ID2_type`, `DTI`, `LTO`, `city_permit`, `BFP`, `date_created`, `date_updated`) VALUES
(1, '9ad91c5e-aed1-4b6e-ba4e-cc424b85ff88', '', NULL, '', NULL, '', '', '', '', '2023-12-14 16:52:25', '2023-12-14 16:52:25'),
(2, '9ad97729-9538-4633-beeb-8c472102d051', 'storage/accreditation/NPridOJVW3n69ZMvOSeOSb7xZFVvUEmC9ZCBXJQG.pdf', 3, '', NULL, 'storage/accreditation/zUNDhpjaXdd0ynsD6AceYV6mXXxbrpiv0Vd68NFI.pdf', 'storage/accreditation/xogxHyTYIfomUwqdK3dCU1B6iYpOcp8DKkS7edK9.pdf', 'storage/accreditation/SNCuRXltEtgZKEqqfMzxi6fYz33Y1AcJ8j4JaRMu.pdf', 'storage/accreditation/HCrCdCpT8tH5C0j1Q8lsMb3OBb8r7YjuuBuRHaeq.pdf', '2023-12-14 21:06:17', '2023-12-15 01:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` char(36) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `middlename`, `lastname`, `sex`, `birthdate`, `phone_number`, `address`, `status`, `date_created`, `date_updated`) VALUES
('b9q6IcDrw31Dietf4fnLs096nf8zOOGWxOFE', 'Chrissha Maeeee', 'Espenueva', 'Balbin', 'Male', '2023-11-07', '+639766556689', 'hjhugghgcxsdvffbfbf', 1, '2023-11-27 06:08:22', '2023-11-27 09:07:04'),
('ZPdWGsoiLkbfXMEoIqJSGd4oQE2cXGPb3s4b', 'Chrissha Maee', 'Espenueva', 'Balbin', 'Female', '2023-11-09', '+639766556689', 'scvdvdv', 1, '2023-11-27 12:01:22', '2023-11-27 12:01:22'),
('5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce', 'De la Cruz', 'Hortaleza', 'Male', '2023-12-22', '+639052362566', 'Cayambanan Urdaneta City, Pangasinan', 1, '2023-12-14 23:02:07', '2023-12-14 23:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name` varchar(50) NOT NULL,
  `operation` int(1) NOT NULL COMMENT 'Add - 1, Edit - 2, Delete - 3',
  `description` varchar(255) NOT NULL,
  `management_type` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `user_id`, `name`, `operation`, `description`, `management_type`, `date_created`, `date_updated`) VALUES
(1, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 1, 'Create Privacy Policy: jbevc', 'Privacy Policy Management', '2024-01-14 01:11:01', '2024-01-14 01:11:01'),
(2, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 3, 'Delete Privacy Policy: jbevc', 'Privacy Policy Management', '2024-01-14 01:11:31', '2024-01-14 01:11:31'),
(4, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 1, 'Create Privacy Policy: Hehe', 'Privacy Policy Management', '2024-01-14 01:12:36', '2024-01-14 01:12:36'),
(5, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 2, 'Update Privacy Policy: Policy 1', 'Privacy Policy Management', '2024-01-14 01:12:52', '2024-01-14 01:12:52'),
(6, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 2, 'Update Terms of Services: Additional', 'Terms of Services Management', '2024-01-14 01:17:27', '2024-01-14 01:17:27'),
(7, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 3, 'Delete Terms of Services: Additional', 'Terms of Services Management', '2024-01-14 01:17:58', '2024-01-14 01:17:58'),
(8, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 1, 'Create Terms of Services: term 1', 'Terms of Services Management', '2024-01-14 01:18:21', '2024-01-14 01:18:21'),
(9, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 1, 'Create Identification Card: heheh', 'Identification Card Management', '2024-01-14 01:22:14', '2024-01-14 01:22:14'),
(10, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 2, 'Update Identification Card: yasss', 'Identification Card Management', '2024-01-14 01:22:31', '2024-01-14 01:22:31'),
(11, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Royce De la Cruz Hortaleza', 3, 'Delete Identification Card: yasss', 'Identification Card Management', '2024-01-14 01:22:42', '2024-01-14 01:22:42'),
(12, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Roycee De la Cruz Hortaleza', 2, 'Update Admin Account: Roycee De la Cruz Hortaleza', 'Admin Management', '2024-01-14 01:29:38', '2024-01-14 01:29:38'),
(13, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Roycee De la Cruz Hortaleza', 1, 'Create Admin Account: hehehhe nbhewbfre fwebhvfer', 'Admin Management', '2024-01-14 01:30:39', '2024-01-14 01:30:39'),
(14, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Roycee De la Cruz Hortaleza', 3, 'Delete Admin Account: hehehhe nbhewbfre fwebhvfer', 'Admin Management', '2024-01-14 01:33:30', '2024-01-14 01:33:30'),
(15, '5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'Roycee De la Cruz Hortaleza', 3, 'Delete Admin Account: Chrissha Maeeee Espenueva Balbin', 'Admin Management', '2024-01-14 01:33:49', '2024-01-14 01:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `availed_services`
--

CREATE TABLE `availed_services` (
  `id` varchar(8) NOT NULL,
  `student_id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `school_id` char(36) NOT NULL,
  `created_by` char(36) NOT NULL,
  `price` double NOT NULL,
  `duration` float NOT NULL,
  `payment_type` int(11) NOT NULL DEFAULT 1,
  `session` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cash_payment`
--

CREATE TABLE `cash_payment` (
  `id` varchar(8) NOT NULL,
  `order_id` varchar(17) NOT NULL,
  `school_id` char(36) NOT NULL,
  `amount` float NOT NULL,
  `cash_tendered` float NOT NULL,
  `process_by` char(36) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cash_payment`
--

INSERT INTO `cash_payment` (`id`, `order_id`, `school_id`, `amount`, `cash_tendered`, `process_by`, `date_created`, `date_updated`) VALUES
('4SP5aKQu', 'ckLOR-7PzeE-OmM1T', '9ad97729-9538-4633-beeb-8c472102d051', 3000, 3000, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:43:45', '2023-12-15 09:43:45'),
('6h4DbHA8', 'klb71-cIDRG-cJxkb', '9ad97729-9538-4633-beeb-8c472102d051', 1500, 1500, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:48:07', '2023-12-15 09:48:07'),
('GrgPdpAK', 'klb71-cIDRG-cJxkb', '9ad97729-9538-4633-beeb-8c472102d051', 1500, 1500, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:29', '2023-12-15 09:38:29'),
('oiSIt6bM', 'qftLY-QEBR0-tIGZ8', '9ad97729-9538-4633-beeb-8c472102d051', 1500, 2000, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-15 09:12:51', '2024-01-15 09:12:51');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` char(36) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `date_created`, `date_updated`) VALUES
('fyvEaFYJe2LwBXLTMHgDnSmzlOmrJBRyltQD', '2023-12-17 13:57:24', '2023-12-17 13:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `conversation_users`
--

CREATE TABLE `conversation_users` (
  `id` int(11) NOT NULL,
  `conversation_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversation_users`
--

INSERT INTO `conversation_users` (`id`, `conversation_id`, `user_id`, `date_created`) VALUES
(1, 'fyvEaFYJe2LwBXLTMHgDnSmzlOmrJBRyltQD', '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-17 13:57:24'),
(2, 'fyvEaFYJe2LwBXLTMHgDnSmzlOmrJBRyltQD', '9ad9d017-8611-4b1f-a843-29afac4a847a', '2023-12-17 13:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` varchar(10) NOT NULL,
  `school_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `thumbnail` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `school_id`, `name`, `description`, `type`, `thumbnail`, `status`, `visibility`, `date_created`, `date_updated`) VALUES
('hQse9bp73p', '9ad97729-9538-4633-beeb-8c472102d051', 'Theoritical Course 101', 'Defensive driving techniques are strategies employed by motorists to anticipate and respond proactively to potential hazards on the road, with the primary goal of preventing accidents and promoting overall safety.', 1, 'storage/courseImages/ADPSZ149VfnnegQA16dZhB3eV95vxwiKvOitgCg5.jpg', 1, 1, '2023-12-15 05:33:28', '2023-12-15 05:36:28'),
('UlzRAf0r6w', '9ad97729-9538-4633-beeb-8c472102d051', 'Automatic Practical Course 101', 'The Practical Driving Course 101 is a fundamental program designed to provide essential skills and knowledge for individuals learning to drive.', 1, 'storage/courseImages/S7dIqy5IuECMuafkYI6dAnntSOrsc88hOtH5hbjd.jpg', 1, 1, '2023-12-15 05:50:26', '2023-12-15 05:51:54'),
('v2geIH4UgN', '9ad97729-9538-4633-beeb-8c472102d051', 'Manual Practical Course 102', 'The Driving Session 102 is a continuation of driver education, building upon the foundational skills covered in Session 101. This advanced session delves deeper into various aspects of driving, enhancing the learner\'s proficiency and confidence on the road.', 1, 'storage/courseImages/cPD01t28v1VxIvxAxF1PYvrgIO0pTBstQBwFmPd4.jpg', 1, 1, '2023-12-15 05:52:37', '2023-12-15 05:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `courses_review`
--

CREATE TABLE `courses_review` (
  `id` int(11) NOT NULL,
  `student_id` char(36) NOT NULL,
  `school_id` char(36) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `order_list_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `anonymous` int(11) NOT NULL DEFAULT 1,
  `rating` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses_review`
--

INSERT INTO `courses_review` (`id`, `student_id`, `school_id`, `course_id`, `order_list_id`, `content`, `anonymous`, `rating`, `date_created`, `date_updated`) VALUES
(1, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '9ad97729-9538-4633-beeb-8c472102d051', 'v2geIH4UgN', 4, 'The best ever', 1, 5, '2024-01-15 09:05:16', '2024-01-15 09:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `courses_variant`
--

CREATE TABLE `courses_variant` (
  `id` int(11) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `duration` int(11) NOT NULL,
  `price` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses_variant`
--

INSERT INTO `courses_variant` (`id`, `course_id`, `duration`, `price`, `status`, `date_created`, `date_updated`) VALUES
(1, '5hkQ3eIfVx', 15, 3000, 1, '2023-12-15 05:31:45', '2023-12-15 05:31:45'),
(2, 'hQse9bp73p', 15, 1000, 1, '2023-12-15 05:33:28', '2023-12-15 05:33:28'),
(3, 'v2geIH4UgN', 8, 3000, 1, '2023-12-15 05:54:24', '2023-12-15 05:54:24'),
(4, 'v2geIH4UgN', 16, 5000, 1, '2023-12-15 05:54:32', '2023-12-15 05:54:32'),
(5, 'UlzRAf0r6w', 8, 3000, 1, '2023-12-15 05:55:16', '2023-12-15 05:55:16'),
(6, 'UlzRAf0r6w', 16, 4500, 1, '2023-12-15 05:55:25', '2023-12-15 05:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

CREATE TABLE `course_progress` (
  `id` int(11) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `progress_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_progress`
--

INSERT INTO `course_progress` (`id`, `course_id`, `progress_id`) VALUES
(4, 'UlzRAf0r6w', 1),
(5, 'UlzRAf0r6w', 2),
(6, 'UlzRAf0r6w', 3),
(9, 'v2geIH4UgN', 1),
(10, 'v2geIH4UgN', 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_vehicle`
--

CREATE TABLE `course_vehicle` (
  `id` int(11) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `vehicle_id` varchar(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_upated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_vehicle`
--

INSERT INTO `course_vehicle` (`id`, `course_id`, `vehicle_id`, `date_created`, `date_upated`) VALUES
(4, 'UlzRAf0r6w', 'p8JfehNCBK', '2023-12-15 05:51:54', '2023-12-15 05:51:54'),
(5, 'UlzRAf0r6w', 'qyTTANuxuO', '2023-12-15 05:51:54', '2023-12-15 05:51:54'),
(8, 'v2geIH4UgN', 'gXYglHf6TY', '2023-12-15 05:53:26', '2023-12-15 05:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `email_verify`
--

CREATE TABLE `email_verify` (
  `id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_expired` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_verify`
--

INSERT INTO `email_verify` (`id`, `email`, `code`, `date_created`, `date_expired`) VALUES
('0x71IFB3ZKjqJHau0hGvLLgo6AUoeOE1LMfyPHd99VUtYx1FxOu87wDMWcqy1YHi7F08UlWjGXBliLAZGUs11o6YFJAKoS2hs9GY5QsizNBviDjLKyOqdJwgvnfVht9Osw037EdnLesIWVBJpMNxg8', 'sorianokid771@gmail.com', '3495', '2023-12-15 09:09:48', '2023-12-15 09:24:48'),
('93bjWCoyAFbughbHNED3KjaEy6C3gqEsgDa5F7y3ZpdH7rrKHyFGVKnG1HenBsr0mW9FX1wHn8sMAka2rizBHuzxOcuG34ZjI2B0ipTg8cNOwcFEheF805pWJYbgu50cyGvZilfBgM153EIUVjWJWc', 'emmandomantay@gmail.com', '2175', '2023-12-15 08:08:26', '2023-12-15 08:23:26'),
('ptw96ai6ONj2hYDW83ZjX8w2Wv7K1F48zzrQAAX9vF1HL9EXLz5i7dXzUzdq6l1n5q8ti89gCPTSZVROOP6SV6jYfZ03BhoTrXswFsD6ApnhIv3hdFPbBemmLheDFx58ax69pumrNxCgEssH6OA7dT', 'sorianokid771@gmail.com', '5916', '2024-01-12 09:30:55', '2024-01-12 09:45:55'),
('shvddjuu9al0ldeKLvIsiAca51e4BnH2KLiyH9VXtTopGIxWJBzgaSIDmuhO1HHhK06mtyXrl8aNojsw3pPgLphH7j8YgR5vq5HCml6ZJih0YkSeVkYGVZD0e8YmlHelLo35UEKxlAwiiyvDiVlSEN', 'johnlouiecorong684@gmail.com', '8530', '2023-12-15 09:14:27', '2023-12-15 09:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identification_card`
--

CREATE TABLE `identification_card` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `identification_card`
--

INSERT INTO `identification_card` (`id`, `title`, `date_created`, `date_updated`) VALUES
(1, 'Employee’s ID / Office ID', '2023-12-14 23:02:59', '2023-12-14 23:02:59'),
(3, 'NBI Clerance', '2023-12-14 23:03:35', '2023-12-14 23:03:35'),
(4, 'Registration Form Philippine Identification (PhilID / ePhilID)', '2023-12-14 23:04:11', '2023-12-14 23:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `school_id` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `user_id`, `school_id`, `firstname`, `middlename`, `lastname`, `sex`, `birthdate`, `address`, `valid_id`, `license`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', '9ad97729-9538-4633-beeb-8c472102d051', 'Juan Miguel', 'Villanueva', 'Dela Cruz', 'Male', '1980-06-26', 'Nancalobasaan Urdaneta City, Pangasinan', 'storage/validID/TaImyrVII3hSAq8bolS8QXTWIVOFzimuOSKtkDjD.png', 'storage/license/9kgtKBNhL8M1KCxlEb9HdpwzZvSVXhOLgzNMvI2y.jpg', 1, '2023-12-15 05:16:13', '2023-12-15 05:38:58'),
(2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '9ad97729-9538-4633-beeb-8c472102d051', 'Juan Pedro', 'Garcia', 'Dela Cruz', 'Male', '1987-10-04', 'Antipolo Rizal', 'storage/validID/LdldgjKikxHqYYmRwQcpkOmDoUUtxGMgj8zstf8W.png', 'storage/license/EGMUYWn29aR72R5PwMHxzrBX000Vs8Q8Iftr9t7K.jpg', 1, '2023-12-15 05:21:32', '2023-12-15 05:21:32'),
(90, 'f3yRsa1xKPgwmlGoIEH5wUmq8sORF4VnN3x7', '9ad97729-9538-4633-beeb-8c472102d051', 'Step', 'M', 'Curry', 'Female', '2024-01-11', 'Mangaldan, Pangasinan', NULL, NULL, 1, '2024-01-11 23:40:40', '2024-01-11 23:40:40'),
(91, '9b11b175-8164-4ab6-867e-448c60cad1b2', '9ad97729-9538-4633-beeb-8c472102d051', 'Tifany sssssaaaaa', 'M', 'Soliano', 'Male', '2001-08-27', 'Manila, Philippines', NULL, NULL, 1, '2024-01-12 03:55:40', '2024-01-15 12:11:42'),
(92, '9b11b175-860b-4513-8b18-11db0440fe29', '9ad97729-9538-4633-beeb-8c472102d051', 'Killlmed', 'S', 'Saliwa', 'Female', '2001-08-27', 'Pangasinan, Philippines', NULL, NULL, 1, '2024-01-12 03:55:40', '2024-01-12 03:55:40'),
(93, 'mrgaluZGkNY9k7Qzx1669a3PJLfnpY7loXEB', '9ad97729-9538-4633-beeb-8c472102d051', 'Chrissha', 'Espenueva', 'Balbin', 'Female', '2003-03-15', 'Urdaneta City, Pangasinan', NULL, NULL, 1, '2024-01-15 12:12:16', '2024-01-15 12:12:16'),
(94, '9b186f41-209e-42ef-ac46-bb36fd8329db', '9ad97729-9538-4633-beeb-8c472102d051', 'Rodolfo', 'M', 'Solianos', 'Male', '2020-08-27', 'Manila, Philippines', NULL, NULL, 1, '2024-01-15 12:21:20', '2024-01-15 12:21:20'),
(95, '9b186f41-23fa-4922-9ee5-f0d336b06ec4', '9ad97729-9538-4633-beeb-8c472102d051', 'Emman', 'S', 'Saliwas', 'Female', '2001-08-27', 'Pangasinan, Philippines', NULL, NULL, 1, '2024-01-15 12:21:20', '2024-01-15 12:21:20'),
(96, '9b186fbc-9922-4d7d-a77b-b74060c4fe86', '9ad97729-9538-4633-beeb-8c472102d051', 'Rodolfo', 'M', 'Solianos', 'Male', '2020-08-27', 'Manila, Philippines', NULL, NULL, 1, '2024-01-15 12:22:41', '2024-01-15 12:22:41'),
(97, '9b186fbc-9c92-4dcf-92dd-7afbd89fcd89', '9ad97729-9538-4633-beeb-8c472102d051', 'Emman', 'S', 'Saliwas', 'Female', '2001-08-27', 'Pangasinan, Philippines', NULL, NULL, 1, '2024-01-15 12:22:41', '2024-01-15 12:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_review`
--

CREATE TABLE `instructor_review` (
  `id` int(11) NOT NULL,
  `student_id` char(36) NOT NULL,
  `school_id` char(36) NOT NULL,
  `instructor_id` char(36) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `anonymous` int(11) NOT NULL DEFAULT 1,
  `rating` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor_review`
--

INSERT INTO `instructor_review` (`id`, `student_id`, `school_id`, `instructor_id`, `schedule_id`, `content`, `anonymous`, `rating`, `date_created`, `date_updated`) VALUES
(1, '9ad9d017-8611-4b1f-a843-29afac4a847a', '9ad97729-9538-4633-beeb-8c472102d051', 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', 44, 'okay', 1, 1, '2023-12-15 09:51:07', '2023-12-15 09:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name` varchar(50) NOT NULL,
  `operation` int(1) NOT NULL COMMENT 'Add - 1, Edit - 2, Delete - 3',
  `description` varchar(255) NOT NULL,
  `management_type` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `school_id`, `user_id`, `name`, `operation`, `description`, `management_type`, `date_created`, `date_updated`) VALUES
(1, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Sub-Progress under \'Parking on Level Ground, Downhill and Uphill \': hehehehheheh', 'Progress Management', '2024-01-13 12:34:54', '2024-01-13 12:34:54'),
(2, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 1, 'Create Course: A1 Driving School', 'Course Management', '2024-01-13 12:48:48', '2024-01-13 12:48:48'),
(3, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 2, 'Update Course: A2 Driving School', 'Course Management', '2024-01-13 12:52:16', '2024-01-13 12:52:16'),
(4, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Course: A2 Driving School', 'Course Management', '2024-01-13 12:57:08', '2024-01-13 12:57:08'),
(5, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 1, 'Create Course Variant under \'Manual Practical Course 102\': 6 hrs', 'Course Management', '2024-01-13 13:08:11', '2024-01-13 13:08:11'),
(6, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 2, 'Update Course Variant under \'Manual Practical Course 102\': 88 hrs', 'Course Management', '2024-01-13 13:17:49', '2024-01-13 13:17:49'),
(7, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 2, 'Update Course Variant under \'Manual Practical Course 102\': 88 hrs', 'Course Management', '2024-01-13 13:33:21', '2024-01-13 13:33:21'),
(8, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Course Variant under \'Manual Practical Course 102\': 7 hrs', 'Course Management', '2024-01-13 13:34:54', '2024-01-13 13:34:54'),
(9, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 2, 'Update Instructor Account: Tifany dick lomibao M Soliano', 'Instructor Management', '2024-01-14 14:35:20', '2024-01-14 14:35:20'),
(10, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 2, 'Update Instructor Account: Tifany dick lomibaos M Soliano', 'Instructor Management', '2024-01-14 15:16:37', '2024-01-14 15:16:37'),
(11, '9ad97729-9538-4633-beeb-8c472102d051', 'yvkOaLfNLJ2CzXYvXELyCk96sCr8wtD3BDAd', 'Royce Dela Cruz Hortaleza', 2, 'Update Instructor Account: Tifany M Soliano', 'Instructor Management', '2024-01-14 15:17:42', '2024-01-14 15:17:42'),
(12, '9ad97729-9538-4633-beeb-8c472102d051', 'yvkOaLfNLJ2CzXYvXELyCk96sCr8wtD3BDAd', 'Royce Dela Cruz Hortaleza', 2, 'Update Instructor Account: Tifany sss M Soliano', 'Instructor Management', '2024-01-14 15:18:08', '2024-01-14 15:18:08'),
(13, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 2, 'Update Instructor Account: Tifany sssssaaaaa M Soliano', 'Instructor Management', '2024-01-15 04:11:42', '2024-01-15 04:11:42'),
(14, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Instructor Account: Rodolfo M Solianos', 'Instructor Management', '2024-01-15 04:22:59', '2024-01-15 04:22:59'),
(15, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Instructor Account: Emman S Saliwas', 'Instructor Management', '2024-01-15 04:23:04', '2024-01-15 04:23:04'),
(16, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Instructor Account: Rodolfo M Solianos', 'Instructor Management', '2024-01-15 04:23:09', '2024-01-15 04:23:09'),
(17, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Instructor Account: Emman S Saliwas', 'Instructor Management', '2024-01-15 04:23:15', '2024-01-15 04:23:15'),
(18, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 1, 'Create Student Account: hdusgfuegfe dgfbuhrf fndjfbguf', 'Student Management', '2024-01-15 04:24:50', '2024-01-15 04:24:50'),
(19, '9ad97729-9538-4633-beeb-8c472102d051', '9ad97729-9538-4633-beeb-8c472102d051', 'Driving School Admin', 3, 'Delete Vehicle: Car me - 4442-331-2asd2', 'Vehicle Management', '2024-01-15 04:31:22', '2024-01-15 04:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` char(36) NOT NULL,
  `sender_id` char(36) NOT NULL,
  `body` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mileage`
--

CREATE TABLE `mileage` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `vehicle_id` varchar(10) NOT NULL,
  `code` int(11) NOT NULL DEFAULT 1,
  `mileage` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mileage`
--

INSERT INTO `mileage` (`id`, `schedule_id`, `vehicle_id`, `code`, `mileage`, `date_created`, `date_updated`) VALUES
(8, 51, 'gXYglHf6TY', 1, 5000, '2024-01-15 09:15:44', '2024-01-15 09:15:44'),
(9, 51, 'gXYglHf6TY', 2, 5050, '2024-01-15 09:16:07', '2024-01-15 09:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `mock_student`
--

CREATE TABLE `mock_student` (
  `id` int(11) NOT NULL,
  `order_list_id` int(11) NOT NULL,
  `assigned_by` char(36) NOT NULL,
  `student_id` char(36) NOT NULL,
  `mock_count` int(11) NOT NULL,
  `status` int(11) DEFAULT 1,
  `items` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_started` datetime DEFAULT NULL,
  `date_submitted` datetime DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mock_student_questions`
--

CREATE TABLE `mock_student_questions` (
  `id` int(11) NOT NULL,
  `mock_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `user_answer` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(17) NOT NULL,
  `school_id` char(36) NOT NULL,
  `student_id` char(36) NOT NULL,
  `total_amount` float NOT NULL,
  `payment_type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `promo_id` varchar(10) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `school_id`, `student_id`, `total_amount`, `payment_type`, `status`, `promo_id`, `date_created`, `date_updated`) VALUES
('bJEcS-rfi3e-se8Xh', '9ad97729-9538-4633-beeb-8c472102d051', '9ad9d017-8611-4b1f-a843-29afac4a847a', 1000, 1, 1, NULL, '2023-12-15 09:32:30', '2023-12-15 09:32:30'),
('ckLOR-7PzeE-OmM1T', '9ad97729-9538-4633-beeb-8c472102d051', '9ad9ce73-c97a-4d9a-9753-68792943967f', 3000, 1, 4, NULL, '2023-12-15 09:43:24', '2023-12-15 09:43:50'),
('klb71-cIDRG-cJxkb', '9ad97729-9538-4633-beeb-8c472102d051', '9ad9d017-8611-4b1f-a843-29afac4a847a', 3000, 1, 5, NULL, '2023-12-15 09:33:23', '2023-12-15 09:49:03'),
('mRdpj-gqLVK-oklSx', '9ad97729-9538-4633-beeb-8c472102d051', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 3000, 2, 5, NULL, '2024-01-12 11:39:07', '2024-01-15 09:05:35'),
('oTyoC-JOQZB-WDIb9', '9ad97729-9538-4633-beeb-8c472102d051', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 3000, 2, 5, NULL, '2024-01-12 09:32:08', '2024-01-12 11:23:09'),
('qftLY-QEBR0-tIGZ8', '9ad97729-9538-4633-beeb-8c472102d051', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 3000, 1, 4, NULL, '2024-01-15 09:10:39', '2024-01-15 09:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders_checkout_url`
--

CREATE TABLE `orders_checkout_url` (
  `id` int(11) NOT NULL,
  `order_id` char(17) NOT NULL,
  `pay_id` varchar(255) NOT NULL,
  `payment_id` text DEFAULT NULL,
  `url` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_checkout_url`
--

INSERT INTO `orders_checkout_url` (`id`, `order_id`, `pay_id`, `payment_id`, `url`, `status`, `date_created`, `date_updated`) VALUES
(1, 'oTyoC-JOQZB-WDIb9', 'cs_ebXfAQBWUZmfcZjcsxVioHDY', 'pay_s7GHNKWB9fD9hUDx3AJqTV3Q', 'https://checkout.paymongo.com/cs_ebXfAQBWUZmfcZjcsxVioHDY_client_eQHWpUzBQJfvbManfiBBMSKP#cGtfdGVzdF9qS0xVYlltaUxqTnJSa3RUdmRDdjduRUM=', 2, '2024-01-12 09:32:08', '2024-01-12 09:32:08'),
(2, 'mRdpj-gqLVK-oklSx', 'cs_a6eGH2WiYHrrArCxgxYUbtEH', 'pay_MtkHkaZ6kmee73ZFeRizBeWG', 'https://checkout.paymongo.com/cs_a6eGH2WiYHrrArCxgxYUbtEH_client_1YMBUXWLYoVhzLQyqKGW8zaf#cGtfdGVzdF9qS0xVYlltaUxqTnJSa3RUdmRDdjduRUM=', 2, '2024-01-12 11:39:09', '2024-01-12 11:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `order_lists`
--

CREATE TABLE `order_lists` (
  `id` int(11) NOT NULL,
  `order_id` varchar(17) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `duration` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `session` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(20) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_lists`
--

INSERT INTO `order_lists` (`id`, `order_id`, `course_id`, `variant_id`, `price`, `duration`, `type`, `session`, `status`, `remarks`, `date_created`, `date_updated`) VALUES
(1, 'bJEcS-rfi3e-se8Xh', 'hQse9bp73p', 2, 1000, 15, 1, 0, 1, NULL, '2023-12-15 09:32:30', '2023-12-15 09:32:30'),
(2, 'klb71-cIDRG-cJxkb', 'UlzRAf0r6w', 5, 3000, 8, 1, 1, 3, 'Passed', '2023-12-15 09:33:23', '2023-12-15 09:49:03'),
(3, 'ckLOR-7PzeE-OmM1T', 'UlzRAf0r6w', 5, 3000, 8, 1, 2, 2, NULL, '2023-12-15 09:43:24', '2023-12-15 10:00:55'),
(4, 'oTyoC-JOQZB-WDIb9', 'v2geIH4UgN', 3, 3000, 8, 1, 2, 3, 'Passed', '2024-01-12 09:32:08', '2024-01-12 11:23:09'),
(5, 'mRdpj-gqLVK-oklSx', 'v2geIH4UgN', 3, 3000, 8, 1, 2, 3, 'Passed', '2024-01-12 11:39:07', '2024-01-15 09:05:35'),
(6, 'qftLY-QEBR0-tIGZ8', 'v2geIH4UgN', 3, 3000, 8, 1, 2, 2, NULL, '2024-01-15 09:10:39', '2024-01-15 09:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_reasons`
--

CREATE TABLE `order_reasons` (
  `id` int(11) NOT NULL,
  `order_id` varchar(17) NOT NULL,
  `process_by` char(36) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', '9ad9b90f-1e25-41ea-aa39-6946a1467112', 'Redmi Note 9 Pro', '8672aa4d27b6440609ab2342370cc64969e804eb0407daf9c39f6e4606708b07', '[\"*\"]', '2023-12-15 00:30:49', NULL, '2023-12-15 00:10:33', '2023-12-15 00:30:49'),
(2, 'App\\Models\\User', 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', 'Redmi Note 9 Pro', 'fb834793129937399be265522c3da4a8bdb89d306f3ea2a88e56a33372488877', '[\"*\"]', '2023-12-15 10:55:03', NULL, '2023-12-15 00:43:54', '2023-12-15 10:55:03'),
(3, 'App\\Models\\User', 'mrgaluZGkNY9k7Qzx1669a3PJLfnpY7loXEB', 'RMX3085', '3e0f53fac980a2f686013967d92910140d39c1a7e162b26b67bf0d15e1473d2a', '[\"*\"]', NULL, NULL, '2023-12-15 00:44:35', '2023-12-15 00:44:35'),
(4, 'App\\Models\\User', 'mrgaluZGkNY9k7Qzx1669a3PJLfnpY7loXEB', 'RMX3085', 'a9fc6f4f28bfc4489cd21707738115a247c5678d23e541b49cce94d0d3984ee9', '[\"*\"]', NULL, NULL, '2023-12-15 00:45:30', '2023-12-15 00:45:30'),
(5, 'App\\Models\\User', '9ad9ce73-c97a-4d9a-9753-68792943967f', 'RMX2040', '1b42a7b21ded5f1d0fe6967bc5d5ba81077964a6843b4377ff03c52c1e88a818', '[\"*\"]', '2023-12-15 01:43:27', NULL, '2023-12-15 01:10:22', '2023-12-15 01:43:27'),
(6, 'App\\Models\\User', '9ad9d017-8611-4b1f-a843-29afac4a847a', 'RMX3085', '6c101c6eeebbb878254a72a88c186a351414b71b630ba234aee0921b592e3ec4', '[\"*\"]', '2023-12-15 02:00:29', NULL, '2023-12-15 01:14:57', '2023-12-15 02:00:29'),
(7, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'LYA-L29', '1259e44a530cae2975a1853a5af0cb2e4d71d9fbf08fa5c395fb3b7fbc0fe7be', '[\"*\"]', '2023-12-21 23:52:34', NULL, '2023-12-15 01:42:46', '2023-12-21 23:52:34'),
(8, 'App\\Models\\User', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 'RMX2040', '6a0ce30cb1991fb24f0b0cafcad2f3727efb9f5248d4b1dd6a1b0485c736959a', '[\"*\"]', '2024-01-12 01:35:55', NULL, '2024-01-12 01:31:35', '2024-01-12 01:35:55'),
(9, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'RMX2040', 'fd0e7566278a896c6ac75ea581adc038f0b376197c784e2251799fdfd72691a6', '[\"*\"]', '2024-01-12 03:37:10', NULL, '2024-01-12 01:37:35', '2024-01-12 03:37:10'),
(10, 'App\\Models\\User', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 'RMX2040', '0e56b6b08fa15bcb4d1a6104ccc71350b2d8656fa9c0d67f6cf2fbb1e9b6f92e', '[\"*\"]', '2024-01-12 03:41:27', NULL, '2024-01-12 03:38:38', '2024-01-12 03:41:27'),
(11, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'RMX2040', '8f860d2580fddeb8e7dee6575e448696a47022654448e01a70ef029ad8b821e6', '[\"*\"]', '2024-01-12 03:44:56', NULL, '2024-01-12 03:42:55', '2024-01-12 03:44:56'),
(12, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'RMX2040', 'e0926669e72d2cc53f47a89afaf9faf8a0f6d98558c2a3b7e12ed014f77d4656', '[\"*\"]', '2024-01-14 23:46:15', NULL, '2024-01-12 03:45:39', '2024-01-14 23:46:15'),
(13, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'RMX2040', 'af91fb8e3e33881999890bcdcbbcbd0c0caf48b402b45f76fb1df49ed1f15062', '[\"*\"]', '2024-01-15 01:02:55', NULL, '2024-01-15 01:02:31', '2024-01-15 01:02:55'),
(14, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'RMX2040', '10bada6ba559b999a34b913ee5d52c60df00710ba106ea55e0c4f83503e3a312', '[\"*\"]', '2024-01-15 01:03:59', NULL, '2024-01-15 01:03:57', '2024-01-15 01:03:59'),
(15, 'App\\Models\\User', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 'RMX2040', '27368f1a3d1c5c8369d23cff9c67f20e61a600138b7321507d42ec5b598fe6b6', '[\"*\"]', '2024-01-15 01:10:46', NULL, '2024-01-15 01:04:28', '2024-01-15 01:10:46'),
(16, 'App\\Models\\User', 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'RMX2040', '0d932e3cd21d64ca3a2b797dcb596bdaaa48de701ecdb54ea5c05ab482aab2be', '[\"*\"]', '2024-01-15 01:58:45', NULL, '2024-01-15 01:15:35', '2024-01-15 01:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `practical_schedule`
--

CREATE TABLE `practical_schedule` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `vehicle_id` varchar(10) DEFAULT NULL,
  `instructor_id` char(36) DEFAULT NULL,
  `session_number` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `total_hours` float NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `privacy`
--

CREATE TABLE `privacy` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descriptions` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `school_id`, `title`, `descriptions`, `date_created`, `date_updated`) VALUES
(1, '9ad97729-9538-4633-beeb-8c472102d051', 'Model Test and Track Route', 'A Model Test and Track Route typically refers to a comprehensive evaluation and simulated drive designed to assess the proficiency and readiness of individuals undergoing driver training.', '2023-12-15 05:41:02', '2023-12-15 05:41:02'),
(2, '9ad97729-9538-4633-beeb-8c472102d051', 'Driving on the Road', 'Driving on the road involves the responsible and safe operation of a motor vehicle within the established rules and regulations.', '2023-12-15 05:43:08', '2023-12-15 05:43:08'),
(3, '9ad97729-9538-4633-beeb-8c472102d051', 'Parking on Level Ground, Downhill and Uphill', 'Parking on level ground, downhill, and uphill requires different techniques to ensure the safety of your vehicle and others on the road.', '2023-12-15 05:48:08', '2023-12-15 05:48:08');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id` varchar(10) NOT NULL,
  `school_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`id`, `school_id`, `name`, `price`, `description`, `start_date`, `end_date`, `thumbnail`, `date_created`, `date_updated`) VALUES
('6vfmtAHD2y', '9ad97729-9538-4633-beeb-8c472102d051', 'Year End Big Sale', 3000, 'The Year-End Big Sale is an exciting and highly anticipated event that marks the conclusion of the year with significant discounts and promotions on various products and services.', '2023-12-15 08:00:00', '2024-01-01 08:00:00', 'storage/courseImages/aikwqc4p78OclYI1vtu0JYyapRPDk2dbhInsWn1d.jpg', '2023-12-15 05:57:37', '2023-12-15 05:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `promo_items`
--

CREATE TABLE `promo_items` (
  `id` int(11) NOT NULL,
  `promo_id` varchar(10) NOT NULL,
  `variant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promo_items`
--

INSERT INTO `promo_items` (`id`, `promo_id`, `variant_id`) VALUES
(1, '6vfmtAHD2y', 2),
(2, '6vfmtAHD2y', 5);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `questions` text NOT NULL,
  `tagalog` text NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `school_id`, `questions`, `tagalog`, `images`, `answer`, `status`, `date_created`, `date_updated`) VALUES
(47, '9ad97729-9538-4633-beeb-8c472102d051', 'A driver while on a highway, business or residential areas, shall yield the right-of-way to', 'Ang isang driver habang nasa highway, negosyo o residential na lugar, ay dapat magbigay ng right-of-way sa', '', 2, 1, '2023-12-15 06:06:06', '2023-12-15 06:06:06'),
(48, '9ad97729-9538-4633-beeb-8c472102d051', 'Chances of being hurt or killed while driving/riding are reduced if one is wearing', 'Ang posibilidad na masaktan o mapatay habang nagmamaneho/nakasakay ay nababawasan kung may suot', '', 3, 1, '2023-12-15 06:07:00', '2023-12-15 06:07:00'),
(49, '9ad97729-9538-4633-beeb-8c472102d051', 'Railway crossing are marked with a crossbuck sign and usually with warning lights. These signs and signal mean a driver must stop, slow down and proceed as directed. If full stop is required, stop from the nearest rail at least', 'Ang pagtawid sa riles ay minarkahan ng isang crossbuck sign at kadalasang may mga ilaw ng babala. Ang mga palatandaan at senyas na ito ay nangangahulugan na ang isang driver ay dapat huminto, bumagal at magpatuloy ayon sa itinuro. Kung kailangan ang full stop, huminto man lang mula sa pinakamalapit na riles', 'storage/reference/7xi5ykxytpGgYrtleJbhZDRNWW9ASYq1UsyngMDM.jpg', 1, 1, '2023-12-15 06:08:14', '2023-12-15 06:08:14'),
(50, '9ad97729-9538-4633-beeb-8c472102d051', 'What is the meaning of the green traffic light?', 'Ano ang kahulugan ng berdeng ilaw trapiko?', '', 3, 1, '2023-12-15 06:09:09', '2023-12-15 06:09:09'),
(51, '9ad97729-9538-4633-beeb-8c472102d051', 'When a vehicle starts to skid, what should the driver do?', 'Kapag nagsimulang mag-skid ang sasakyan, ano ang dapat gawin ng driver?', '', 2, 1, '2023-12-15 06:10:01', '2023-12-15 06:10:01'),
(52, '9ad97729-9538-4633-beeb-8c472102d051', 'What does this sign indicate?', 'Ano ang ipinahihiwatig ng tanda na ito?', 'storage/reference/TX4RquMWOAxTdnJ1t5mhL0I7yjoPHBeUUYY15MCB.jpg', 1, 1, '2023-12-15 06:11:19', '2023-12-15 06:11:19'),
(53, '9ad97729-9538-4633-beeb-8c472102d051', 'At an intersection, if two vehicles arrived at the same time, which vehicle has the right of way?', 'Sa isang intersection, kung dalawang sasakyan ang dumating sa parehong oras, aling sasakyan ang may karapatang dumaan?', '', 3, 1, '2023-12-15 06:12:18', '2023-12-15 06:12:18'),
(54, '9ad97729-9538-4633-beeb-8c472102d051', 'If you are driving in a curb lane which ends ahead, what would you do first in order to merge without interfering with other traffic?', 'Kung nagmamaneho ka sa isang curb lane na magtatapos sa unahan, ano ang una mong gagawin upang sumanib nang hindi nakakasagabal sa ibang trapiko?', '', 1, 1, '2023-12-15 06:13:08', '2023-12-15 06:13:08'),
(55, '9ad97729-9538-4633-beeb-8c472102d051', 'Public Service Law prohibits public utility driver to converse with his passengers while the vehicle is', 'Ang Public Service Law ay nagbabawal sa public utility driver na makipag-usap sa kanyang mga pasahero habang nasa sasakyan', '', 3, 1, '2023-12-15 06:13:50', '2023-12-15 06:13:50'),
(56, '9ad97729-9538-4633-beeb-8c472102d051', 'You are preparing to exit an expressway, when should you start reducing speed?', 'Naghahanda kang lumabas sa isang expressway, kailan mo dapat simulan ang pagbabawas ng bilis?', '', 2, 1, '2023-12-15 06:14:57', '2023-12-15 06:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `question_choices`
--

CREATE TABLE `question_choices` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `body` text NOT NULL,
  `body_tagalog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_choices`
--

INSERT INTO `question_choices` (`id`, `question_id`, `code`, `body`, `body_tagalog`) VALUES
(137, 47, 1, 'Motorcycle riders', 'Mga sakay ng motorsiklo'),
(138, 47, 2, 'Pedestrians', 'Mga naglalakad'),
(139, 47, 3, 'Bike Riders', 'Mga Bike Rider'),
(140, 48, 1, 'Helmet', 'helmet'),
(141, 48, 2, 'Alarm Device', 'Alarm Device'),
(142, 48, 3, 'Seat Belts', 'Mga sinturon ng upuan'),
(143, 49, 1, '5 meters', '5 metro'),
(144, 49, 2, '4 meters', '4 na metro'),
(145, 49, 3, '3 meters', '3 metro'),
(146, 50, 1, 'You can go but slow down.', 'Maaari kang pumunta ngunit dahan-dahan.'),
(147, 50, 2, 'Stop at the given line.', 'Huminto sa ibinigay na linya.'),
(148, 50, 3, 'A go signals for the vehicle.', 'Isang go signal para sa sasakyan.'),
(149, 51, 1, 'Immediately step on the brakes', 'Agad na humakbang sa preno'),
(150, 51, 2, 'Hold firmly on the wheel while slowing down the vehicle', 'Mahigpit na humawak sa manibela habang binabagalan ang sasakyan'),
(151, 51, 3, 'Turn the wheels up the opposite direction of the skid', 'I-on ang mga gulong sa kabaligtaran na direksyon ng skid'),
(152, 52, 1, 'No left turn', 'Walang kaliwa'),
(153, 52, 2, 'Exit to the left', 'Lumabas sa kaliwa'),
(154, 52, 3, 'One-way to left', 'One-way papuntang kaliwa'),
(155, 53, 1, 'Vehicle on the left', 'Sa kaliwa ang sasakyan'),
(156, 53, 2, 'First vehicle to arrive', 'Unang sasakyan na dumating'),
(157, 53, 3, 'Vehicle on the right', 'Sasakyan sa kanan'),
(158, 54, 1, 'Change lane to the left', 'Lumipat ng lane sa kaliwa'),
(159, 54, 2, 'Change lane to either left or right', 'Palitan ang lane sa kaliwa o kanan'),
(160, 54, 3, 'Change lane to the right', 'Baguhin ang lane sa kanan'),
(161, 55, 1, 'Parked', 'Nakaparada'),
(162, 55, 2, 'Climbing the mountain', 'Pag-akyat sa bundok'),
(163, 55, 3, 'In motion', 'Kasalukuyang kumikilos'),
(164, 56, 1, 'Immediately before entering the deceleration lane', 'Kaagad bago pumasok sa deceleration lane'),
(165, 56, 2, 'Immediately upon entering the deceleration lane', 'Kaagad pagpasok sa deceleration lane'),
(166, 56, 3, 'Immediately upon spotting the deceleration lane', 'Kaagad nang makita ang deceleration lane');

-- --------------------------------------------------------

--
-- Table structure for table `report_image`
--

CREATE TABLE `report_image` (
  `id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `report_instructor`
--

CREATE TABLE `report_instructor` (
  `id` int(11) NOT NULL,
  `student_id` char(36) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `instructor_id` char(36) NOT NULL,
  `school_id` char(36) NOT NULL,
  `comments` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_instructor`
--

INSERT INTO `report_instructor` (`id`, `student_id`, `schedule_id`, `instructor_id`, `school_id`, `comments`, `date_created`) VALUES
(1, '9ad9d017-8611-4b1f-a843-29afac4a847a', 44, 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', '9ad97729-9538-4633-beeb-8c472102d051', 'hahhhaha', '2023-12-15 09:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `reset_link`
--

CREATE TABLE `reset_link` (
  `id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `total_hours` double NOT NULL,
  `complete_hours` double DEFAULT 0,
  `type` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `school_id`, `start_date`, `end_date`, `total_hours`, `complete_hours`, `type`, `status`, `date_created`, `date_updated`) VALUES
(44, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:40:00', '2023-12-15 18:40:00', 8, 8, 1, 3, '2023-12-15 09:39:49', '2023-12-15 09:46:05'),
(45, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:45:00', '2023-12-15 18:45:00', 8, 1, 1, 3, '2023-12-15 09:44:25', '2023-12-15 09:46:13'),
(46, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 10:02:00', '2023-12-15 18:01:00', 6.9833333333333, 2, 1, 3, '2023-12-15 10:01:59', '2023-12-15 10:03:01'),
(47, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-12 09:36:00', '2024-01-12 14:36:00', 4, 4, 1, 3, '2024-01-12 09:35:35', '2024-01-12 11:04:41'),
(48, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-12 11:09:00', '2024-01-12 16:09:00', 4, 4, 1, 3, '2024-01-12 11:10:33', '2024-01-12 11:11:47'),
(49, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-12 11:42:00', '2024-01-12 16:42:00', 4, 4, 1, 3, '2024-01-12 11:42:30', '2024-01-12 11:43:35'),
(50, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-12 11:44:00', '2024-01-12 16:44:00', 4, 4, 1, 3, '2024-01-12 11:44:47', '2024-01-12 11:47:26'),
(51, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-15 09:13:00', '2024-01-15 13:13:00', 3, 3, 1, 3, '2024-01-15 09:14:11', '2024-01-15 09:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_instructors`
--

CREATE TABLE `schedule_instructors` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `instructor_id` char(36) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_instructors`
--

INSERT INTO `schedule_instructors` (`id`, `schedule_id`, `instructor_id`, `date_created`, `date_updated`) VALUES
(1, 44, 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', '2023-12-15 09:39:49', '2023-12-15 09:39:49'),
(2, 45, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2023-12-15 09:44:25', '2023-12-15 09:44:25'),
(3, 46, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2023-12-15 10:01:59', '2023-12-15 10:01:59'),
(4, 47, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:35:35', '2024-01-12 09:35:35'),
(5, 48, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:10:33', '2024-01-12 11:10:33'),
(6, 49, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:42:30', '2024-01-12 11:42:30'),
(7, 50, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:44:47', '2024-01-12 11:44:47'),
(8, 51, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-15 09:14:11', '2024-01-15 09:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_logs`
--

CREATE TABLE `schedule_logs` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `process_by` char(36) NOT NULL,
  `date_process` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_logs`
--

INSERT INTO `schedule_logs` (`id`, `schedule_id`, `type`, `process_by`, `date_process`) VALUES
(1, 44, 1, 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', '2023-12-15 09:40:07'),
(2, 45, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2023-12-15 09:45:01'),
(3, 44, 2, 'Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', '2023-12-15 09:46:05'),
(4, 45, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2023-12-15 09:46:13'),
(5, 46, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2023-12-15 10:02:16'),
(6, 46, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2023-12-15 10:03:01'),
(7, 47, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 10:14:47'),
(8, 47, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:04:41'),
(9, 48, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:11:02'),
(10, 48, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:11:47'),
(11, 49, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:43:08'),
(12, 49, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:43:35'),
(13, 50, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:46:01'),
(14, 50, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 11:47:26'),
(15, 51, 1, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-15 09:15:44'),
(16, 51, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-15 09:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_report`
--

CREATE TABLE `schedule_report` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_report`
--

INSERT INTO `schedule_report` (`id`, `schedule_id`, `content`, `date_created`, `date_updated`) VALUES
(1, 47, 'cfffffhsjs', '2024-01-12 16:18:17', '2024-01-12 16:18:17'),
(2, 47, 'cfssjssddsjqjwnqjnqqnq', '2024-01-12 16:21:49', '2024-01-12 16:21:49'),
(3, 48, 'hhahahahahaha', '2024-01-12 16:26:38', '2024-01-12 16:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_report_image`
--

CREATE TABLE `schedule_report_image` (
  `id` int(11) NOT NULL,
  `schedule_report_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_report_image`
--

INSERT INTO `schedule_report_image` (`id`, `schedule_report_id`, `path`) VALUES
(1, 1, 'storage/report/RA5zFiDiBf9EzGp00fm0AWlR1xt9pbzQOUwWTl1n.jpg'),
(2, 1, 'storage/report/wDGVBYbltHtftmv1lw7tYHlNHgt4cnNTf2g2uy7n.jpg'),
(3, 2, 'storage/report/4KCVoFEORixDPdRcog0EOPZafS7Ih60pFNeVgNuH.jpg'),
(4, 2, 'storage/report/Uacg5SnPw7hOQiL0TnU2afo4UH356XRB5gUSC2xA.jpg'),
(5, 3, 'storage/report/TFMcSLf9foQ0Tn8dvAN8zpAwgpLTkTKCHLUQTwtK.jpg'),
(6, 3, 'storage/report/MAncgBUyQi0Jts4N9WIO6Viyb53CGwnTlAGhpTXX.jpg'),
(7, 3, 'storage/report/yo5YJCSuGiwG4vES9ehEviPSUZl1K6nEbRxNoee2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_students`
--

CREATE TABLE `schedule_students` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `order_list_id` int(11) NOT NULL,
  `student_id` char(36) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_students`
--

INSERT INTO `schedule_students` (`id`, `schedule_id`, `order_list_id`, `student_id`, `date_created`, `date_updated`) VALUES
(1, 44, 2, '9ad9d017-8611-4b1f-a843-29afac4a847a', '2023-12-15 09:39:49', '2023-12-15 09:39:49'),
(2, 45, 3, '9ad9ce73-c97a-4d9a-9753-68792943967f', '2023-12-15 09:44:25', '2023-12-15 09:44:25'),
(3, 46, 3, '9ad9ce73-c97a-4d9a-9753-68792943967f', '2023-12-15 10:01:59', '2023-12-15 10:01:59'),
(4, 47, 4, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '2024-01-12 09:35:35', '2024-01-12 09:35:35'),
(5, 48, 4, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '2024-01-12 11:10:33', '2024-01-12 11:10:33'),
(6, 49, 5, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '2024-01-12 11:42:30', '2024-01-12 11:42:30'),
(7, 50, 5, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '2024-01-12 11:44:47', '2024-01-12 11:44:47'),
(8, 51, 6, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '2024-01-15 09:14:11', '2024-01-15 09:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_vehicles`
--

CREATE TABLE `schedule_vehicles` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `vehicle_id` varchar(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_vehicles`
--

INSERT INTO `schedule_vehicles` (`id`, `schedule_id`, `vehicle_id`, `date_created`, `date_updated`) VALUES
(1, 44, 'p8JfehNCBK', '2023-12-15 09:39:49', '2023-12-15 09:39:49'),
(2, 45, 'qyTTANuxuO', '2023-12-15 09:44:25', '2023-12-15 09:44:25'),
(3, 46, 'p8JfehNCBK', '2023-12-15 10:01:59', '2023-12-15 10:01:59'),
(4, 47, 'gXYglHf6TY', '2024-01-12 09:35:35', '2024-01-12 09:35:35'),
(5, 48, 'gXYglHf6TY', '2024-01-12 11:10:33', '2024-01-12 11:10:33'),
(6, 49, 'gXYglHf6TY', '2024-01-12 11:42:30', '2024-01-12 11:42:30'),
(7, 50, 'gXYglHf6TY', '2024-01-12 11:44:47', '2024-01-12 11:44:47'),
(8, 51, 'gXYglHf6TY', '2024-01-15 09:14:11', '2024-01-15 09:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `accreditation_status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `user_id`, `name`, `address`, `latitude`, `longitude`, `accreditation_status`, `date_created`, `date_updated`) VALUES
(1, '9ad91c5e-aed1-4b6e-ba4e-cc424b85ff88', 'DrivingSolution', 'XGHQ+G9F, Urdaneta, Pangasinan, Philippines', '15.97892227252146', '120.5386576085414', 1, '2023-12-15 00:52:25', '2023-12-15 00:52:25'),
(2, '9ad97729-9538-4633-beeb-8c472102d051', 'Bluechip', '921 MacArthur Hwy, Urdaneta, Pangasinan, Philippines', '15.982194000926771', '120.57308938874434', 1, '2023-12-15 05:06:17', '2023-12-15 05:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `schools_review`
--

CREATE TABLE `schools_review` (
  `id` int(11) NOT NULL,
  `order_id` varchar(17) NOT NULL,
  `school_id` char(36) NOT NULL,
  `student_id` char(36) NOT NULL,
  `content` text NOT NULL,
  `anonymous` int(11) NOT NULL DEFAULT 1,
  `rating` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools_review`
--

INSERT INTO `schools_review` (`id`, `order_id`, `school_id`, `student_id`, `content`, `anonymous`, `rating`, `date_created`, `date_updated`) VALUES
(1, 'mRdpj-gqLVK-oklSx', '9ad97729-9538-4633-beeb-8c472102d051', '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 'the best driving school', 1, 5, '2024-01-15 09:05:59', '2024-01-15 09:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `school_about`
--

CREATE TABLE `school_about` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_about`
--

INSERT INTO `school_about` (`id`, `school_id`, `content`, `date_created`, `date_updated`) VALUES
(1, '9ad97729-9538-4633-beeb-8c472102d051', 'Welcome to the UPS Driving School, where we mold the future of delivery professionals. Our UPS Driving School is committed to training drivers to uphold the highest standards of safety, efficiency, and customer service. Through a combination of classroom instruction, hands-on driving practice, and real-world simulations, we ensure our drivers are well-prepared for the unique challenges of the delivery industry. Our experienced instructors guide you through the intricacies of UPS\'s advanced delivery techniques, vehicle operation, and customer interactions. Join us at the UPS Driving School and pave the way for a rewarding career as a skilled and reliable UPS driver. Your journey to delivering excellence starts here.', '2023-12-15 08:33:20', '2023-12-15 08:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `school_policy`
--

CREATE TABLE `school_policy` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_policy`
--

INSERT INTO `school_policy` (`id`, `school_id`, `content`, `date_created`, `date_updated`) VALUES
(1, '9ad97729-9538-4633-beeb-8c472102d051', 'In line with Republic Act No. 10173, known as the Data Privacy Act, this law protects all private, personal, and sensitive information of natural and juridical persons involved in processing personal data. Drivehub and its associated Driving Schools adhere to this law, ensuring the protection of data privacy rights in accordance with legal standards.\r\nThe web and mobile application are operated by Drivehub Company, Inc. The Terms and Conditions comply with Republic Act No. 10173, defining specific rules and regulations. \"WE,\" \"US,\" and \"OUR\" refer to Drivehub Company, Inc., offering this website, its information, tools, and services. Driving Schools and Student Drivers must review the Terms and Conditions to understand their rights and obligations upon agreeing to these terms, conditions, policies, and notices.', '2023-12-15 08:32:31', '2023-12-15 08:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `school_students`
--

CREATE TABLE `school_students` (
  `id` int(11) NOT NULL,
  `student_id` char(36) NOT NULL,
  `school_id` char(36) NOT NULL,
  `identity` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_students`
--

INSERT INTO `school_students` (`id`, `student_id`, `school_id`, `identity`, `date_created`, `date_updated`) VALUES
(1, '9ad9d017-8611-4b1f-a843-29afac4a847a', '9ad97729-9538-4633-beeb-8c472102d051', 1, '2023-12-15 09:32:30', '2023-12-15 09:32:30'),
(3, '9ad9ce73-c97a-4d9a-9753-68792943967f', '9ad97729-9538-4633-beeb-8c472102d051', 1, '2023-12-15 09:43:24', '2023-12-15 09:43:24'),
(4, '9b122997-14e0-4b77-bb1f-ba9a4e03dc32', '9ad97729-9538-4633-beeb-8c472102d051', 1, '2024-01-12 09:32:08', '2024-01-12 09:32:08'),
(7, '9b187081-b327-423c-8d5a-27d10e0b5fba', '9ad97729-9538-4633-beeb-8c472102d051', 2, '2024-01-15 12:24:50', '2024-01-15 12:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `order_list_id` int(11) NOT NULL,
  `session_number` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `schedule_id`, `order_list_id`, `session_number`, `date_created`, `date_updated`) VALUES
(1, 44, 2, 1, '2023-12-15 09:38:53', '2023-12-15 09:39:49'),
(2, 45, 3, 1, '2023-12-15 09:44:00', '2023-12-15 09:44:25'),
(3, 46, 3, 2, '2023-12-15 10:00:55', '2023-12-15 10:01:59'),
(4, 47, 4, 1, '2024-01-12 09:34:17', '2024-01-12 09:35:35'),
(5, 48, 4, 2, '2024-01-12 09:34:17', '2024-01-12 11:10:33'),
(6, 49, 5, 1, '2024-01-12 11:41:59', '2024-01-12 11:42:30'),
(7, 50, 5, 2, '2024-01-12 11:41:59', '2024-01-12 11:44:47'),
(8, 51, 6, 1, '2024-01-15 09:13:44', '2024-01-15 09:14:11'),
(9, 0, 6, 2, '2024-01-15 09:13:44', '2024-01-15 09:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` char(36) NOT NULL,
  `school_id` char(36) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `valid_id` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `school_id`, `firstname`, `middlename`, `lastname`, `sex`, `birthdate`, `address`, `role`, `status`, `valid_id`, `date_created`, `date_updated`) VALUES
('f3yRsa1xKPgwmlGoIEH5wUmq8sORF4VnN3x7', '9ad97729-9538-4633-beeb-8c472102d051', 'Step', 'M', 'Curry', 'Female', '2024-01-11', 'Mangaldan, Pangasinan', '1,2,3,4,5,6,7,8,9', 5, 'storage/validID/eQVuAMfHtKnMnYZkEyY3AMwMcTRXsBVInyd3dRRo.png', '2024-01-11 23:31:43', '2024-01-11 23:31:43'),
('mrgaluZGkNY9k7Qzx1669a3PJLfnpY7loXEB', '9ad97729-9538-4633-beeb-8c472102d051', 'Chrissha', 'Espenueva', 'Balbin', 'Female', '2003-03-15', 'Urdaneta City, Pangasinan', '1,2,3,4,7', 5, 'storage/validID/pA7XhtZsUfHeIVpQdV2IZHX8HagZHJOuPXLqw4AX.png', '2023-12-15 06:01:29', '2023-12-15 06:01:29'),
('yvkOaLfNLJ2CzXYvXELyCk96sCr8wtD3BDAd', '9ad97729-9538-4633-beeb-8c472102d051', 'Royce', 'Dela Cruz', 'Hortaleza', 'Male', '2000-06-11', 'alitaya magnladan pagnasinan', '1,3,4,5,6,7,8', 1, 'storage/validID/6pyToYFR37ruW0mxFpqC8lu5MtiDQb4fp5J3XxtE.png', '2023-12-15 06:03:35', '2023-12-15 06:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` char(36) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `firstname`, `middlename`, `lastname`, `sex`, `birthdate`, `address`, `date_created`, `date_updated`) VALUES
('9ad9b90f-1e25-41ea-aa39-6946a1467112', 'Emman', NULL, 'Domantay', NULL, NULL, NULL, '2023-12-15 08:10:33', '2023-12-15 08:10:33'),
('9ad9ce73-c97a-4d9a-9753-68792943967f', 'Dick', 'Soriano', 'Lomibao', 'Male', '2009-01-19', 'alitaya mangaldan pangasinan', '2023-12-15 09:10:22', '2023-12-15 09:10:22'),
('9ad9d017-8611-4b1f-a843-29afac4a847a', 'john Louie', NULL, 'Corong', NULL, NULL, NULL, '2023-12-15 09:14:57', '2023-12-15 09:14:57'),
('9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 'Jake', NULL, 'Vargas', NULL, NULL, NULL, '2024-01-12 09:31:35', '2024-01-12 09:31:35'),
('9b187081-b327-423c-8d5a-27d10e0b5fba', 'hdusgfuegfe', 'dgfbuhrf', 'fndjfbguf', 'Male', '2000-01-12', 'Mangaldan, Pangasinan', '2024-01-15 12:24:50', '2024-01-15 12:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `student_course_progress`
--

CREATE TABLE `student_course_progress` (
  `id` int(11) NOT NULL,
  `order_list_id` int(11) NOT NULL,
  `progress_id` int(11) NOT NULL,
  `sub_progress_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `process_by` char(36) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course_progress`
--

INSERT INTO `student_course_progress` (`id`, `order_list_id`, `progress_id`, `sub_progress_id`, `status`, `process_by`, `date_created`, `date_updated`) VALUES
(1, 2, 1, 1, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(2, 2, 1, 2, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(3, 2, 1, 3, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(4, 2, 2, 4, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(5, 2, 2, 5, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(6, 2, 2, 6, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(7, 2, 2, 7, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(8, 2, 2, 8, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(9, 2, 2, 9, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(10, 2, 2, 10, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(11, 2, 2, 11, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(12, 2, 2, 12, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(13, 2, 2, 13, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(14, 2, 3, 14, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(15, 2, 3, 15, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(16, 2, 3, 16, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:38:53', '2023-12-15 09:46:42'),
(17, 3, 1, 1, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(18, 3, 1, 2, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(19, 3, 1, 3, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(20, 3, 2, 4, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(21, 3, 2, 5, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(22, 3, 2, 6, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(23, 3, 2, 7, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(24, 3, 2, 8, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(25, 3, 2, 9, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(26, 3, 2, 10, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(27, 3, 2, 11, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(28, 3, 2, 12, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(29, 3, 2, 13, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(30, 3, 3, 14, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(31, 3, 3, 15, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(32, 3, 3, 16, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2023-12-15 09:44:00', '2023-12-16 11:17:17'),
(33, 4, 1, 1, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:24'),
(34, 4, 1, 2, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:24'),
(35, 4, 1, 3, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:24'),
(36, 4, 2, 4, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:26'),
(37, 4, 2, 5, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:27'),
(38, 4, 2, 6, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:27'),
(39, 4, 2, 7, 2, '9ad97729-9538-4633-beeb-8c472102d051', '2024-01-12 09:34:17', '2024-01-12 11:17:20'),
(40, 4, 2, 8, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:28'),
(41, 4, 2, 9, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:28'),
(42, 4, 2, 10, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:33'),
(43, 4, 2, 11, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:28'),
(44, 4, 2, 12, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:29'),
(45, 4, 2, 13, 2, 'YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', '2024-01-12 09:34:17', '2024-01-12 11:11:29'),
(46, 5, 1, 1, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(47, 5, 1, 2, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(48, 5, 1, 3, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(49, 5, 2, 4, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(50, 5, 2, 5, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(51, 5, 2, 6, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(52, 5, 2, 7, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(53, 5, 2, 8, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(54, 5, 2, 9, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(55, 5, 2, 10, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(56, 5, 2, 11, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(57, 5, 2, 12, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(58, 5, 2, 13, 1, NULL, '2024-01-12 11:41:59', '2024-01-12 11:41:59'),
(59, 6, 1, 1, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(60, 6, 1, 2, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(61, 6, 1, 3, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(62, 6, 2, 4, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(63, 6, 2, 5, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(64, 6, 2, 6, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(65, 6, 2, 7, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(66, 6, 2, 8, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(67, 6, 2, 9, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(68, 6, 2, 10, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(69, 6, 2, 11, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(70, 6, 2, 12, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44'),
(71, 6, 2, 13, 1, NULL, '2024-01-15 09:13:44', '2024-01-15 09:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `sub_progress`
--

CREATE TABLE `sub_progress` (
  `id` int(11) NOT NULL,
  `progress_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_progress`
--

INSERT INTO `sub_progress` (`id`, `progress_id`, `title`, `date_created`, `date_updated`) VALUES
(1, 1, 'Name parts of the model test track route', '2023-12-15 05:41:28', '2023-12-15 05:41:38'),
(2, 1, 'Explain the direction arrows', '2023-12-15 05:42:03', '2023-12-15 05:42:03'),
(3, 1, 'State the importance of road markings', '2023-12-15 05:42:21', '2023-12-15 05:42:21'),
(4, 2, 'Starting, driving ahead, and stopping', '2023-12-15 05:43:35', '2023-12-15 05:43:35'),
(5, 2, 'Driving in different environments and situations', '2023-12-15 05:43:57', '2023-12-15 05:43:57'),
(6, 2, 'Choice of speed in different situations', '2023-12-15 05:44:17', '2023-12-15 05:44:17'),
(7, 2, 'Driving uphill and downwhill', '2023-12-15 05:44:40', '2023-12-15 05:44:40'),
(8, 2, 'Driving through bends', '2023-12-15 05:44:53', '2023-12-15 05:44:53'),
(9, 2, 'Approaching and crossing a railway', '2023-12-15 05:45:12', '2023-12-15 05:45:12'),
(10, 2, 'Lane shifting and choices of lanes', '2023-12-15 05:45:32', '2023-12-15 05:45:42'),
(11, 2, 'Making U-Turn', '2023-12-15 05:46:04', '2023-12-15 05:46:04'),
(12, 2, 'Meeting oncoming traffic', '2023-12-15 05:46:29', '2023-12-15 05:46:29'),
(13, 2, 'Overtaking and passing', '2023-12-15 05:46:46', '2023-12-15 05:46:46'),
(14, 3, 'Stopping', '2023-12-15 05:48:33', '2023-12-15 05:48:33'),
(15, 3, 'Dealing with Pedestrians motorcyclist truck, buses, jeepneys, and other motor vehicles', '2023-12-15 05:49:17', '2023-12-15 05:49:17'),
(16, 3, 'Rush hour and heavy traffic Techniques', '2023-12-15 05:49:37', '2023-12-15 05:49:37');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `title`, `description`, `date_created`, `date_updated`) VALUES
(1, 'ONLINE PLATFORMS TERMS', 'By agreeing to these Terms of Service, you present that you are at least the age of majority in your City/Municipality, Province of residence and you have given us your consent to allow any of your minor dependents to use this platform. You may consider to not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction. A breach or violation of any of the Terms will result in an immediate termination of your services.', '2023-12-14 23:11:44', '2023-12-14 23:11:44'),
(2, 'GENERAL CONDITIONS', 'We reserve the right to refuse service, transfer content unencrypted, and require written permission to reproduce, duplicate, or exploit the Service. Credit card information is always encrypted.', '2023-12-14 23:12:20', '2023-12-14 23:12:20'),
(3, 'COMPLETENESS AND ACCURACY OF INFORMATION', 'This site provides general information and should not be relied upon for decisions without consulting primary sources. Historical information is not current and is provided for reference only. The platform reserves the right to modify content but has no obligation to update it. It is the user\'s responsibility to monitor changes.', '2023-12-14 23:13:04', '2023-12-14 23:13:04'),
(4, 'PERSONAL INFORMATION', 'Your submission of personal information through the platform is governed by our policies.', '2023-12-14 23:14:12', '2023-12-14 23:14:12'),
(5, 'Rules and Policies', 'In line with Republic Act No. 10173, known as the Data Privacy Act, this law protects all private, personal, and sensitive information of natural and juridical persons involved in processing personal data. Drivehub and its associated Driving Schools adhere to this law, ensuring the protection of data privacy rights in accordance with legal standards.', '2023-12-14 23:15:55', '2023-12-14 23:15:55'),
(6, 'Additional', 'Add more', '2023-12-15 01:32:32', '2023-12-15 01:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `theoritical_schedules`
--

CREATE TABLE `theoritical_schedules` (
  `id` int(11) NOT NULL,
  `school_id` char(36) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slot` int(11) NOT NULL,
  `for_session_number` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT 1,
  `is_verified` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_image`, `phone_number`, `email_verified_at`, `remember_token`, `type`, `is_verified`, `created_at`, `updated_at`) VALUES
('5qOLfLp0JtZ6Cq4HuSOX9JRCq1GpqfnskxlK', 'royceadmin', 'royceadmin@gmail.com', '$2y$10$otVoJKiGTzv/YyjjZgSzMOPzWMuIJKPcCyrGiU/lK8eGbdfWL3rBq', 'storage/profile/Rk1Gi0Lm0DlqAoHuNM1qrQR6C0xZTyUfr10FaUA8.jpg', NULL, NULL, NULL, 5, 1, NULL, NULL),
('9ad91c5e-aed1-4b6e-ba4e-cc424b85ff88', 'DrivingSolution', 'DrivingSolution@gmail.com', '$2y$10$zQ6btxxp45wxh.c7aYyxmuR/Obj7i9YTRZ8ERdGjymUgbNPJleoia', 'storage/profile/hXoh7TTTarNf2wrjvAtNY0ZZThkqLhw08zGyV6zz.jpg', NULL, NULL, NULL, 1, 1, '2023-12-14 16:52:25', '2023-12-14 16:52:25'),
('9ad97729-9538-4633-beeb-8c472102d051', 'bluechip', 'dicksorianolomibao@gmail.com', '$2y$10$otVoJKiGTzv/YyjjZgSzMOPzWMuIJKPcCyrGiU/lK8eGbdfWL3rBq', 'storage/profile/U1d5gRUiCqukhvjpXUf06F2L6slQDdgyawjJnYsj.jpg', NULL, NULL, NULL, 1, 1, '2023-12-14 21:06:17', '2023-12-14 21:06:17'),
('9ad9b90f-1e25-41ea-aa39-6946a1467112', 'Emman123', 'emmandomantay@gmail.com', '$2y$10$hg3mdEhtRo5HBTz4fakVU.PLRRN6FCtO4H4hWsXE2qUcTy7lRVDQC', 'storage/profile/3OV5RWzwVkhmf4jj6CuAOA2Mo0RkMR9V6iS9toPC.jpg', '09464631562', NULL, NULL, 3, 2, '2023-12-15 00:10:33', '2023-12-15 00:17:21'),
('9ad9ce73-c97a-4d9a-9753-68792943967f', 'Dickdick123', 'sorianokid77h1@gmail.com', '$2y$10$OhmeN7SQ1MavaphGLP5ZqeoiUQFgg3ADrX5fKAGIbZYj97k1myhOu', 'storage/profile/6sHqwnUTy50VUb9CvfNqIQhnVY2VSOgHZYBfcdx1.jpg', NULL, NULL, NULL, 3, 2, '2023-12-15 01:10:22', '2023-12-15 01:10:22'),
('9ad9d017-8611-4b1f-a843-29afac4a847a', 'johnlouie', 'johnlouiecorong684@gmail.com', '$2y$10$UerQbD2qxdAV.wM7k4XC2.54sNc4ExdPfueR1nnNHSLUSL9MpZjg.', 'storage/profile/QZVNENot0n2r3eeGeyeGrj6FiS5lSEIKx4UmyWZG.jpg', NULL, NULL, NULL, 3, 2, '2023-12-15 01:14:57', '2023-12-15 01:14:57'),
('9b11b175-8164-4ab6-867e-448c60cad1b2', 'tiffany123', 'tiffany123@gmail.com', 'tiffany123', 'storage/profile/temp.png', '09090909091', NULL, NULL, 2, 1, '2024-01-11 19:55:40', '2024-01-11 19:55:40'),
('9b11b175-860b-4513-8b18-11db0440fe29', 'killme123', 'killme123@gmail.com', 'killme123', 'storage/profile/temp.png', '09090909092', NULL, NULL, 2, 1, '2024-01-11 19:55:40', '2024-01-11 19:55:40'),
('9b122997-14e0-4b77-bb1f-ba9a4e03dc32', 'jake12345', 'sorianokSid771@gmail.com', '$2y$10$HXwsIvtTxnVaO3VeRi1z4O3NTVR6wAip5GFiysD/IrY7bfpDbnMsm', 'storage/profile/D3VtpC8L8VX5QZuHoCiVtvlkTmk4T2qfdXtIs7RQ.jpg', NULL, NULL, NULL, 3, 2, '2024-01-12 01:31:35', '2024-01-12 01:31:35'),
('9b187081-b327-423c-8d5a-27d10e0b5fba', 'fijieigfr', 'fijieigfr@gmail.com', '$2y$10$.mCjou7CemnmDGGPhcMEH.nRz7BFdvG7IGiP8aCS5hTAajELksIpK', 'storage/profile/yXf3RUF1jIcwBipX99Md74LxI5EqFeYkZns47ZvV.png', '09090900902', NULL, NULL, 3, 1, '2024-01-15 04:24:50', '2024-01-15 04:24:50'),
('f3yRsa1xKPgwmlGoIEH5wUmq8sORF4VnN3x7', 'step123123123', 'step123123123@gmail.com', '$2y$10$ZkMAr.rM7nR1jS3weZMFMuIVx/k9cjDq0kHsWL8LMNBKLIvJz826e', 'storage/profile/XzQ8AlGffMwuPz6eMmsqy9cDvDPxfTFDapODXgnp.jpg', '09338090106', NULL, NULL, 2, 1, NULL, '2024-01-11 15:37:26'),
('f7d5a523-90c7-11ee-8a06-0a0027000002', 'maymaymay', 'maymaymay@gmail.com', '$2y$10$dU5i6/eRrkVSTCg1Jkf2MOzCaPJnyH2VuKMSs5SQRg/CJoaiAr/uq', 'storage/profile/hNTvjEFlp9kCbIsRcVtR3N7MIkvxWpMdkmKENAlr.webp', '09334090106', NULL, NULL, 5, 1, NULL, NULL),
('Jk90jxrCR2zTUJusW7uoaml3O3QTpWOGTrrJ', 'juanmiguel', 'juanmiguel@gmail.com', '$2y$10$zL0CoPN3bjPuo7nnzEQY6uor4uBGBXdfOBG3pOW3wxZVr6noBWrti', 'storage/profile/7AkUMfqz0sqXuSB5W5XjBgBXdFblSl7Z1ZDeMauh.jpg', '09334090104', NULL, NULL, 2, 1, NULL, NULL),
('mrgaluZGkNY9k7Qzx1669a3PJLfnpY7loXEB', 'chrisshamae', 'chrisshamae@gmail.com', '$2y$10$kibsWsD91eGZ/G4WjE8vH.nEEaMy4cGE46eA4/8jM061X4tLLdCee', 'storage/profile/dXyWpNVL9hjCD5azqsoTC6gkMmXPSG66HJ7juQeR.jpg', '09183352131', NULL, NULL, 2, 1, NULL, '2024-01-15 04:12:16'),
('yvkOaLfNLJ2CzXYvXELyCk96sCr8wtD3BDAd', 'roycehorta', 'roycehorta@gmail.com', '$2y$10$VNYDUZXnmEaUcp5sYTE2cOoXRM2UEgny19jXFVi5Ki73TNc3chftC', 'storage/profile/jpq1h6lZRwUwolmWUvBiaHlvGfXX5kv6XqodMxaL.jpg', '09168863522', NULL, NULL, 4, 1, NULL, NULL),
('YyJTdAs1W38igJcvu7TmY7ItVEJ3K390p1fv', 'pedrojuan', 'pedrojuan@gmail.com', '$2y$10$otVoJKiGTzv/YyjjZgSzMOPzWMuIJKPcCyrGiU/lK8eGbdfWL3rBq', 'storage/profile/ve751HxDty2fY97nKUZyOyxyPbSZY6num0ptV9g7.jpg', '09161162311', NULL, NULL, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` varchar(10) NOT NULL,
  `school_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(36) NOT NULL,
  `plate_number` varchar(50) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `transmission` varchar(255) NOT NULL,
  `fuel` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `vehicle_img` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `school_id`, `name`, `type`, `plate_number`, `manufacturer`, `model`, `year`, `transmission`, `fuel`, `color`, `vehicle_img`, `status`, `date_created`, `date_updated`) VALUES
('gXYglHf6TY', '9ad97729-9538-4633-beeb-8c472102d051', 'Ford Raptor', 'CARS', 'ABG-1801', 'Ford', 'AYQ-1011', 2023, 'MANUAL', 'DIESEL', 'Black', 'storage/vehicles/c7tvNHn8rHdAMKGWe3FveNtHPcEnTQ0ke31dBSvN.jpg', 1, '2023-12-15 05:26:10', '2023-12-15 05:26:10'),
('p8JfehNCBK', '9ad97729-9538-4633-beeb-8c472102d051', 'Honda Civic', 'CARS', 'NGB-1920', 'Honda', 'ABG-2023', 2023, 'AUTOMATIC', 'GASOLINE', 'Red', 'storage/vehicles/hoaNZQkNoncqIqwtyAXrTT8swGuGutnf9qyXjDWo.jpg', 1, '2023-12-15 05:23:30', '2023-12-15 05:23:30'),
('qyTTANuxuO', '9ad97729-9538-4633-beeb-8c472102d051', 'Fortuner', 'CARS', 'AYS-3024', 'Toyota', 'SYN-2023', 2023, 'AUTOMATIC', 'GASOLINE', 'White', 'storage/vehicles/IY9KbtD5KqQzpjGzcOovmQTGNxLYhDaGoS4Lvs9W.jpg', 1, '2023-12-15 05:29:45', '2023-12-15 05:29:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accreditation`
--
ALTER TABLE `accreditation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_payment`
--
ALTER TABLE `cash_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation_users`
--
ALTER TABLE `conversation_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses_review`
--
ALTER TABLE `courses_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses_variant`
--
ALTER TABLE `courses_variant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_vehicle`
--
ALTER TABLE `course_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verify`
--
ALTER TABLE `email_verify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `identification_card`
--
ALTER TABLE `identification_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor_review`
--
ALTER TABLE `instructor_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mileage`
--
ALTER TABLE `mileage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mock_student`
--
ALTER TABLE `mock_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mock_student_questions`
--
ALTER TABLE `mock_student_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mock_id` (`mock_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_checkout_url`
--
ALTER TABLE `orders_checkout_url`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_lists`
--
ALTER TABLE `order_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_reasons`
--
ALTER TABLE `order_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `privacy`
--
ALTER TABLE `privacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_items`
--
ALTER TABLE `promo_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_choices`
--
ALTER TABLE `question_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `report_image`
--
ALTER TABLE `report_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_instructor`
--
ALTER TABLE `report_instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_instructors`
--
ALTER TABLE `schedule_instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `schedule_logs`
--
ALTER TABLE `schedule_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_report`
--
ALTER TABLE `schedule_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_report_image`
--
ALTER TABLE `schedule_report_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_students`
--
ALTER TABLE `schedule_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `schedule_vehicles`
--
ALTER TABLE `schedule_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `schools_review`
--
ALTER TABLE `schools_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_about`
--
ALTER TABLE `school_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_policy`
--
ALTER TABLE `school_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_students`
--
ALTER TABLE `school_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_course_progress`
--
ALTER TABLE `student_course_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_progress`
--
ALTER TABLE `sub_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theoritical_schedules`
--
ALTER TABLE `theoritical_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accreditation`
--
ALTER TABLE `accreditation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `conversation_users`
--
ALTER TABLE `conversation_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses_review`
--
ALTER TABLE `courses_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses_variant`
--
ALTER TABLE `courses_variant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_progress`
--
ALTER TABLE `course_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_vehicle`
--
ALTER TABLE `course_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `identification_card`
--
ALTER TABLE `identification_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `instructor_review`
--
ALTER TABLE `instructor_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mileage`
--
ALTER TABLE `mileage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mock_student`
--
ALTER TABLE `mock_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mock_student_questions`
--
ALTER TABLE `mock_student_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_checkout_url`
--
ALTER TABLE `orders_checkout_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_lists`
--
ALTER TABLE `order_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_reasons`
--
ALTER TABLE `order_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `privacy`
--
ALTER TABLE `privacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promo_items`
--
ALTER TABLE `promo_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `question_choices`
--
ALTER TABLE `question_choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `report_image`
--
ALTER TABLE `report_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_instructor`
--
ALTER TABLE `report_instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `schedule_instructors`
--
ALTER TABLE `schedule_instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule_logs`
--
ALTER TABLE `schedule_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `schedule_report`
--
ALTER TABLE `schedule_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule_report_image`
--
ALTER TABLE `schedule_report_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule_students`
--
ALTER TABLE `schedule_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule_vehicles`
--
ALTER TABLE `schedule_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schools_review`
--
ALTER TABLE `schools_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_about`
--
ALTER TABLE `school_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_policy`
--
ALTER TABLE `school_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_students`
--
ALTER TABLE `school_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_course_progress`
--
ALTER TABLE `student_course_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `sub_progress`
--
ALTER TABLE `sub_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `theoritical_schedules`
--
ALTER TABLE `theoritical_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `question_choices`
--
ALTER TABLE `question_choices`
  ADD CONSTRAINT `question_choices_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule_instructors`
--
ALTER TABLE `schedule_instructors`
  ADD CONSTRAINT `schedule_instructors_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule_students`
--
ALTER TABLE `schedule_students`
  ADD CONSTRAINT `schedule_students_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule_vehicles`
--
ALTER TABLE `schedule_vehicles`
  ADD CONSTRAINT `schedule_vehicles_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
