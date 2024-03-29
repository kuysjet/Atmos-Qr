-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 04:18 PM
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
-- Database: `atmos_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `academic_year` varchar(20) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `academic_year`, `status`, `created_at`, `updated_at`) VALUES
(86, '2024-2025', 'active', '2024-02-25 17:57:48', '2024-03-29 12:46:13'),
(106, '2025-2026', 'active', '2024-03-15 06:42:28', '2024-03-16 10:52:48'),
(110, '2026-2027', 'active', '2024-03-17 13:53:17', '2024-03-29 12:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `college_student_id` int(11) DEFAULT NULL,
  `senior_high_student_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `college_student_id`, `senior_high_student_id`, `faculty_id`, `event_id`, `time_in`, `time_out`, `created_at`, `updated_at`) VALUES
(3, NULL, 360, NULL, 19, '08:00:00', '05:00:00', '2024-03-15 12:48:38', '2024-03-15 12:48:38'),
(4, NULL, NULL, 81, 19, '08:00:00', '05:00:00', '2024-03-15 12:49:12', '2024-03-15 12:49:12'),
(5, 24, NULL, NULL, 19, '08:00:00', '05:00:00', '2024-03-17 12:37:21', '2024-03-17 12:37:21'),
(9, NULL, 372, NULL, 19, '08:00:00', '05:00:00', '2024-03-17 12:39:13', '2024-03-17 12:39:13'),
(11, NULL, NULL, 82, 19, '08:00:00', '05:00:00', '2024-03-17 12:47:24', '2024-03-17 12:47:24'),
(13, NULL, 357, NULL, 19, '08:00:00', '05:00:00', '2024-03-19 02:42:59', '2024-03-19 02:42:59'),
(233, NULL, 344, NULL, 19, '07:12:10', '08:57:09', '2024-03-27 11:12:10', '2024-03-27 12:57:09'),
(253, NULL, 399, NULL, 19, '09:19:39', '10:31:42', '2024-03-27 13:19:40', '2024-03-29 02:31:42'),
(257, NULL, 399, NULL, 29, '10:15:48', '11:18:09', '2024-03-27 14:15:48', '2024-03-29 03:18:09'),
(258, NULL, 381, NULL, 29, '10:16:16', '11:17:55', '2024-03-27 14:16:16', '2024-03-29 03:17:55'),
(259, 25, NULL, NULL, 29, '10:21:16', '11:17:43', '2024-03-27 14:21:16', '2024-03-29 03:17:43'),
(264, NULL, 381, NULL, 30, '10:45:18', '10:46:35', '2024-03-27 14:45:18', '2024-03-27 14:46:35'),
(265, NULL, 347, NULL, 30, '10:45:34', '10:47:02', '2024-03-27 14:45:34', '2024-03-27 14:47:02'),
(266, 25, NULL, NULL, 30, '10:46:04', '10:46:44', '2024-03-27 14:46:05', '2024-03-27 14:46:44'),
(267, NULL, 339, NULL, 19, '10:56:04', '10:31:35', '2024-03-27 14:56:04', '2024-03-29 02:31:35'),
(268, NULL, 393, NULL, 19, '10:56:28', '10:31:26', '2024-03-27 14:56:28', '2024-03-29 02:31:26'),
(269, NULL, 381, NULL, 19, '10:56:39', '10:31:17', '2024-03-27 14:56:39', '2024-03-29 02:31:17'),
(270, NULL, 347, NULL, 19, '09:26:03', '09:41:13', '2024-03-28 01:26:03', '2024-03-29 01:41:13'),
(271, NULL, 396, NULL, 19, '09:26:38', '09:29:37', '2024-03-28 01:26:38', '2024-03-29 01:29:37'),
(275, NULL, 402, NULL, 19, '11:55:33', '11:55:45', '2024-03-29 03:55:33', '2024-03-29 03:55:45'),
(278, NULL, 378, NULL, 19, '05:32:42', '20:10:38', '2024-03-29 09:32:42', '2024-03-29 12:10:38'),
(281, 25, NULL, NULL, 19, '08:18:09', '08:18:23', '2024-03-29 12:18:09', '2024-03-29 12:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `collegestudents`
--

CREATE TABLE `collegestudents` (
  `ID` int(11) NOT NULL,
  `IdentificationNumber` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collegestudents`
--

INSERT INTO `collegestudents` (`ID`, `IdentificationNumber`, `FirstName`, `LastName`, `Email`, `CourseID`, `LevelID`, `created_at`, `updated_at`) VALUES
(23, '7789678', 'Jetrsdfo', 'Bagassdfala', 'aqua@gmsdail.com', 2, 2, '2024-03-08 02:53:04', '2024-03-09 01:21:31'),
(24, '2223232434343', 'Maria Cristina sakhfd', 'dfsdfasdasddasfsd', 'maria@gmsdrrail.com', 1, 2, '2024-03-08 02:53:04', '2024-03-09 01:17:57'),
(25, '111111111', 'Vhong', 'Navarro', 'vhong@gmail.com', 3, 3, '2024-03-08 07:43:17', '2024-03-08 07:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`) VALUES
(1, 'ACT'),
(2, 'BSCS'),
(3, 'ENTREP'),
(4, 'BSAIS');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `ID` int(11) NOT NULL,
  `DepartmentName` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`ID`, `DepartmentName`, `created_at`, `updated_at`) VALUES
(14, 'College Department', '2024-02-22 00:16:36', '2024-02-22 00:19:50'),
(15, 'Senior High Department', '2024-02-22 00:16:47', '2024-02-22 00:20:02'),
(16, 'Technical Department', '2024-02-22 00:20:28', '2024-02-29 15:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_venue` varchar(100) NOT NULL,
  `description` varchar(120) NOT NULL,
  `event_date` date NOT NULL,
  `log_in` time NOT NULL,
  `log_out` time NOT NULL,
  `registrar_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `academic_year_id`, `event_name`, `event_venue`, `description`, `event_date`, `log_in`, `log_out`, `registrar_id`, `created_at`, `updated_at`) VALUES
(19, 86, 'SportsFest', 'UNEP', 'Sports And Competitions', '2024-03-30', '10:16:00', '22:16:00', 28, '2024-03-06 04:30:35', '2024-03-29 14:16:32'),
(29, 86, 'First aid', 'ACLC', 'Seminar', '2024-03-29', '01:01:00', '22:05:00', 28, '2024-03-07 16:05:28', '2024-03-29 03:03:55'),
(30, 86, 'Foundation', 'ACLC', 'Foundation Day ACLC', '2024-03-29', '03:32:00', '23:54:00', 28, '2024-03-08 05:32:13', '2024-03-29 03:04:02'),
(32, 86, 'Sunday Class', 'ACLC ', 'Discussion', '2024-03-21', '05:06:00', '18:17:00', 28, '2024-03-09 06:46:14', '2024-03-22 13:52:35'),
(33, 106, 'Blood Letting', 'ACLC', 'Donate', '2024-03-27', '02:42:00', '23:55:00', 28, '2024-03-15 06:43:05', '2024-03-26 23:51:15'),
(34, 86, 'sdasdafsd', 'gdfgdfgd', 'jghjgh', '2024-03-26', '08:05:00', '17:20:00', 35, '2024-03-20 12:14:12', '2024-03-29 04:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `ID` int(11) NOT NULL,
  `IdentificationNumber` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `PositionID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`ID`, `IdentificationNumber`, `FirstName`, `LastName`, `Email`, `DepartmentID`, `PositionID`, `created_at`, `updated_at`) VALUES
(81, '30000001', 'Jetro', 'Bagasala', 'ggs@gmail.com', 14, 1, '2024-03-07 16:40:52', '2024-03-09 01:20:53'),
(82, '2000003', 'amma', 'adada', 'anan@anann', 15, 5, '2024-03-07 16:40:52', '2024-03-09 12:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade_name` enum('11','12') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade_name`) VALUES
(1, '11'),
(2, '12');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `level_name` enum('1','2','3','4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `level_name`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `ID` int(11) NOT NULL,
  `PositionName` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`ID`, `PositionName`, `created_at`, `updated_at`) VALUES
(1, 'Teacher', '2024-02-17 02:37:12', '2024-02-17 02:51:06'),
(5, 'Registrar', '2024-02-18 18:24:42', '2024-02-19 01:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_name` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `seniorhighstudents`
--

CREATE TABLE `seniorhighstudents` (
  `ID` int(11) NOT NULL,
  `IdentificationNumber` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `StrandID` int(11) NOT NULL,
  `GradeID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seniorhighstudents`
--

INSERT INTO `seniorhighstudents` (`ID`, `IdentificationNumber`, `FirstName`, `LastName`, `Email`, `StrandID`, `GradeID`, `SectionID`, `created_at`, `updated_at`) VALUES
(337, '3333333333', 'Anne ', 'Curtis', 'anne@gmail.com', 1, 1, 4, '2024-03-08 03:08:58', '2024-03-08 03:59:59'),
(338, '80949148268', 'Lila', 'Schmidt', 'lila.schmidt@example.com', 1, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(339, '39020698951', 'James', 'King', 'james.king@example.com', 3, 1, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(340, '19538975680', 'Riley', 'Gonzalez', 'riley.gonzalez@example.com', 4, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(341, '30605492748', 'Leo', 'Hawkins', 'leo.hawkins@example.com', 1, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(342, '91706850734', 'Ella', 'Rivera', 'ella.rivera@example.com', 1, 1, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(343, '98157324089', 'Eva', 'Watkins', 'eva.watkins@example.com', 2, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(344, '25307964851', 'Carter', 'Lee', 'carter.lee@example.com', 2, 1, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(345, '90534810726', 'Ethan', 'Franklin', 'ethan.franklin@example.com', 3, 2, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(346, '86492705318', 'Sofia', 'Bryant', 'sofia.bryant@example.com', 4, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(347, '63847105982', 'Hudson', 'Chavez', 'hudson.chavez@example.com', 1, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(348, '72509481637', 'Scarlett', 'Wagner', 'scarlett.wagner@example.com', 2, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(349, '39218657409', 'Liam', 'Anderson', 'liam.anderson@example.com', 3, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(350, '80719564328', 'Emma', 'Hernandez', 'emma.hernandez@example.com', 4, 1, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(351, '29186530748', 'Zoe', 'Knight', 'zoe.knight@example.com', 2, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(352, '65847309152', 'Ava', 'Hansen', 'ava.hansen@example.com', 3, 1, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(353, '42931507826', 'Mila', 'Ramirez', 'mila.ramirez@example.com', 1, 2, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(354, '19623857094', 'Aiden', 'West', 'aiden.west@example.com', 4, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(355, '36504879213', 'Elijah', 'Fowler', 'elijah.fowler@example.com', 1, 1, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(356, '50497321856', 'Harper', 'Daniels', 'harper.daniels@example.com', 2, 2, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(357, '27519863401', 'Luna', 'Mills', 'luna.mills@example.com', 3, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(358, '76298134057', 'Benjamin', 'Ross', 'benjamin.ross@example.com', 4, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(359, '61837405928', 'Lucas', 'Fletcher', 'lucas.fletcher@example.com', 1, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(360, '10478395267', 'Avery', 'Owens', 'avery.owens@example.com', 2, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(361, '73809154628', 'Layla', 'Porter', 'layla.porter@example.com', 3, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(362, '42968713502', 'Mateo', 'Gardner', 'mateo.gardner@example.com', 4, 1, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(363, '73962105483', 'Lincoln', 'Stevens', 'lincoln.stevens@example.com', 1, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(364, '48036271589', 'Mia', 'Holt', 'mia.holt@example.com', 2, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(365, '57139028416', 'Axel', 'Barnes', 'axel.barnes@example.com', 3, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(366, '62379105482', 'Liam', 'Page', 'liam.page@example.com', 4, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(367, '29405718632', 'Jackson', 'Kennedy', 'jackson.kennedy@example.com', 1, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(368, '70821395476', 'Aria', 'Crawford', 'aria.crawford@example.com', 2, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(369, '84097531628', 'Elena', 'Adams', 'elena.adams@example.com', 3, 2, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(370, '50293781645', 'Aria', 'Pierce', 'aria.pierce@example.com', 4, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(371, '42971638025', 'Scarlett', 'Fuller', 'scarlett.fuller@example.com', 1, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(372, '13928750468', 'Lucas', 'Black', 'lucas.black@example.com', 2, 2, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(373, '83174609235', 'Sophia', 'Holmes', 'sophia.holmes@example.com', 3, 1, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(374, '50936187425', 'Chloe', 'Guzman', 'chloe.guzman@example.com', 4, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(375, '71409582376', 'Grace', 'Stone', 'grace.stone@example.com', 1, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(376, '62489057312', 'Olivia', 'Nichols', 'olivia.nichols@example.com', 2, 1, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(377, '95036182745', 'Zachary', 'Meyer', 'zachary.meyer@example.com', 3, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(378, '21790583624', 'Natalie', 'Ford', 'natalie.ford@example.com', 4, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(379, '58103976245', 'Jayden', 'Gilbert', 'jayden.gilbert@example.com', 1, 1, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(380, '62584907316', 'Amelia', 'Reynolds', 'amelia.reynolds@example.com', 2, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(381, '49067251893', 'Aiden', 'Watson', 'aiden.watson@example.com', 3, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(382, '61703948256', 'Aurora', 'Fernandez', 'aurora.fernandez@example.com', 1, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(383, '39261580749', 'Eleanor', 'Mccoy', 'eleanor.mccoy@example.com', 2, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(384, '90547218639', 'Levi', 'Ellis', 'levi.ellis@example.com', 3, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(385, '47382195640', 'Leah', 'Gordon', 'leah.gordon@example.com', 4, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(386, '73985204617', 'Liam', 'Richardson', 'liam.richardson@example.com', 1, 1, 2, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(387, '61598472063', 'Mila', 'Curtis', 'mila.curtis@example.com', 2, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(388, '37054921863', 'Scarlett', 'Patterson', 'scarlett.patterson@example.com', 3, 1, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(389, '64872093516', 'Emily', 'Mcdonald', 'emily.mcdonald@example.com', 4, 2, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(390, '49025731864', 'Luna', 'Jackson', 'luna.jackson@example.com', 1, 2, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(391, '73961058243', 'Mateo', 'Gomez', 'mateo.gomez@example.com', 2, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(392, '83249716503', 'Avery', 'Perry', 'avery.perry@example.com', 3, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(393, '50793284619', 'Mia', 'Richardson', 'mia.richardson@example.com', 4, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(394, '42918567302', 'Lucas', 'Morris', 'lucas.morris@example.com', 1, 1, 3, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(395, '72694053812', 'Layla', 'Harvey', 'layla.harvey@example.com', 2, 2, 4, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(396, '51293708465', 'Jackson', 'Palmer', 'jackson.palmer@example.com', 3, 1, 1, '2024-03-08 05:25:06', '2024-03-08 05:25:06'),
(397, '74931025864', 'Charlotte', 'Hart', 'charlotte.hart@example.com', 4, 2, 2, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(398, '43190728564', 'Levi', 'Garza', 'levi.garza@example.com', 1, 2, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(399, '68309517642', 'Ella', 'Arnold', 'ella.arnold@example.com', 2, 1, 1, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(400, '51930784625', 'Wyatt', 'Oliver', 'wyatt.oliver@example.com', 3, 2, 3, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(401, '74908263150', 'Aurora', 'Kim', 'aurora.kim@example.com', 4, 1, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(402, '69417853029', 'Evelyn', 'Brooks', 'evelyn.brooks@example.com', 1, 1, 2, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(403, '50321968745', 'Sophia', 'Rogers', 'sophia.rogers@example.com', 2, 2, 3, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(404, '31298540726', 'Zachary', 'Weaver', 'zachary.weaver@example.com', 3, 1, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(405, '64873209154', 'Chloe', 'Warren', 'chloe.warren@example.com', 4, 2, 1, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(406, '51976420835', 'Harper', 'Henry', 'harper.henry@example.com', 2, 1, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(407, '69243057189', 'Ethan', 'Sullivan', 'ethan.sullivan@example.com', 3, 2, 1, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(408, '43792650389', 'Avery', 'Vargas', 'avery.vargas@example.com', 2, 1, 2, '2024-03-08 05:25:07', '2024-03-17 12:51:19'),
(409, '42876509321', 'Liam', 'Fisher', 'liam.fisher@example.com', 1, 1, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(410, '59628730124', 'Emma', 'Mcdonald', 'emma.mcdonald@example.com', 2, 2, 1, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(411, '31098725469', 'Oliver', 'Carpenter', 'oliver.carpenter@example.com', 3, 1, 3, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(412, '79246105834', 'Aria', 'Bowman', 'aria.bowman@example.com', 4, 2, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(413, '40892763541', 'Levi', 'Ruiz', 'levi.ruiz@example.com', 1, 2, 2, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(414, '68703154289', 'Sophia', 'Hansen', 'sophia.hansen@example.com', 2, 1, 3, '2024-03-08 05:25:07', '2024-03-08 05:25:07'),
(415, '64297503148', 'Jackson', 'Wagner', 'jackson.wagner@example.com', 3, 2, 4, '2024-03-08 05:25:07', '2024-03-08 05:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `strands`
--

CREATE TABLE `strands` (
  `id` int(11) NOT NULL,
  `strand_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strands`
--

INSERT INTO `strands` (`id`, `strand_name`) VALUES
(1, 'ABM'),
(2, 'GAS'),
(3, 'STEM'),
(4, 'HUMMS'),
(5, 'TVL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `status`, `user_type_id`, `created_at`, `updated_at`) VALUES
(1, 'Jetro', 'Bagasala', 'jet@gmail.com', 'Admin', 'Admin123', 'active', 1, '2024-02-14 06:53:14', '2024-03-24 04:13:55'),
(28, 'Ced', 'Embestro', 'ced@gmail.com', 'Cedrick', 'Cedrick123', 'active', 2, '2024-02-29 03:43:08', '2024-03-22 13:51:04'),
(35, 'Cynel ', 'Taduran', 'cynel@gmail.com', 'Cynel', 'Cynel123', 'active', 2, '2024-03-06 06:23:55', '2024-03-20 10:08:35'),
(36, 'Anica', 'Ross', 'anic@gmail.com', 'Anica', 'Anica1234', 'active', 1, '2024-03-08 10:04:04', '2024-03-08 11:46:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '2024-02-14 06:49:34', NULL),
(2, 'Registrar', '2024-02-14 06:49:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academic_year` (`academic_year`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `college_student_id` (`college_student_id`),
  ADD KEY `senior_high_student_id` (`senior_high_student_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `collegestudents`
--
ALTER TABLE `collegestudents`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_course_id` (`CourseID`),
  ADD KEY `fk_level_id` (`LevelID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `DepartmentName` (`DepartmentName`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `registrar_id` (`registrar_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `IdentificationNumber` (`IdentificationNumber`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `faculties_ibfk_1` (`DepartmentID`),
  ADD KEY `faculties_ibfk_2` (`PositionID`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PositionName` (`PositionName`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seniorhighstudents`
--
ALTER TABLE `seniorhighstudents`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_grade_id` (`GradeID`),
  ADD KEY `fk_section_id` (`SectionID`),
  ADD KEY `fk_strand_id` (`StrandID`);

--
-- Indexes for table `strands`
--
ALTER TABLE `strands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `collegestudents`
--
ALTER TABLE `collegestudents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seniorhighstudents`
--
ALTER TABLE `seniorhighstudents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `strands`
--
ALTER TABLE `strands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`college_student_id`) REFERENCES `collegestudents` (`ID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`senior_high_student_id`) REFERENCES `seniorhighstudents` (`ID`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`ID`),
  ADD CONSTRAINT `attendance_ibfk_4` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `collegestudents`
--
ALTER TABLE `collegestudents`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_level_id` FOREIGN KEY (`LevelID`) REFERENCES `levels` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_5` FOREIGN KEY (`registrar_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `faculties_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `faculties_ibfk_2` FOREIGN KEY (`PositionID`) REFERENCES `positions` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seniorhighstudents`
--
ALTER TABLE `seniorhighstudents`
  ADD CONSTRAINT `fk_grade_id` FOREIGN KEY (`GradeID`) REFERENCES `grades` (`id`),
  ADD CONSTRAINT `fk_section_id` FOREIGN KEY (`SectionID`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `fk_strand_id` FOREIGN KEY (`StrandID`) REFERENCES `strands` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
