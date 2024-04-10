-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2024 at 06:51 AM
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
(1, '2024-2025', 'active', '2024-04-09 09:27:01', '2024-04-09 09:28:19');

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
(3, NULL, 1, NULL, 1, '12:10:46', '12:12:28', '2024-04-10 04:10:46', '2024-04-10 04:12:28'),
(4, 7, NULL, NULL, 1, '12:11:48', NULL, '2024-04-10 04:11:48', '2024-04-10 04:11:48'),
(5, 27, NULL, NULL, 1, '12:12:01', NULL, '2024-04-10 04:12:01', '2024-04-10 04:12:01');

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
(1, '2000012345', 'Juan', 'Santos', 'juan.santos123@gmail.com', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(2, '2000023456', 'Maria', 'Garcia', 'maria.garcia456@yahoo.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(3, '2000034567', 'Jose', 'Cruz', 'jose.cruz789@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(4, '2000045678', 'Ana', 'Reyes', 'ana.reyes234@outlook.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(5, '2000056789', 'Pedro', 'Torres', 'pedro.torres567@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(6, '2000067890', 'Sofia', 'Perez', 'sofia.perez890@icloud.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(7, '2000078901', 'Diego', 'Lopez', 'diego.lopez123@aol.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(8, '2000089012', 'Carmen', 'Dela Cruz', 'carmen.delacruz456@gmail.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(9, '2000090123', 'Joaquin', 'Rodriguez', 'joaquin.rodriguez789@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(10, '2000101234', 'Luz', 'Martinez', 'luz.martinez012@outlook.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(11, '2000112345', 'Miguel', 'Gonzalez', 'miguel.gonzalez345@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(12, '2000123456', 'Rosa', 'Fernandez', 'rosa.fernandez678@yahoo.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(13, '2000134567', 'Carlos', 'Gomez', 'carlos.gomez890@gmail.com', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(14, '2000145678', 'Isabella', 'Diaz', 'isabella.diaz123@yahoo.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(15, '2000156789', 'Manuel', 'Hernandez', 'manuel.hernandez456@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(16, '2000167890', 'Aurora', 'Lopez', 'aurora.lopez789@outlook.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(17, '2000178901', 'Ricardo', 'Martinez', 'ricardo.martinez012@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(18, '2000189012', 'Elena', 'Torres', 'elena.torres345@icloud.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(19, '2000190123', 'Felipe', 'Garcia', 'felipe.garcia678@aol.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(20, '2000201234', 'Julia', 'Reyes', 'julia.reyes901@gmail.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(21, '2000212345', 'Alejandro', 'Perez', 'alejandro.perez234@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(22, '2000223456', 'Camila', 'Rivera', 'camila.rivera567@outlook.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(23, '2000234567', 'Diego', 'Sanchez', 'diego.sanchez890@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(24, '2000245678', 'Valentina', 'Dominguez', 'valentina.dominguez123@yahoo.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(25, '2000256789', 'Mateo', 'Castillo', 'mateo.castillo456@gmail.com', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(26, '2000267890', 'Adriana', 'Ortega', 'adriana.ortega789@yahoo.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(27, '2000278901', 'Javier', 'Vargas', 'javier.vargas012@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(28, '2000289012', 'Lucia', 'Jimenez', 'lucia.jimenez345@outlook.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(29, '2000290123', 'Carlos', 'Moreno', 'carlos.moreno678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(30, '2000301234', 'Elena', 'Gutierrez', 'elena.gutierrez901@icloud.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(31, '2000312345', 'Santiago', 'Ruiz', 'santiago.ruiz234@aol.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(32, '2000323456', 'Isabel', 'Mendoza', 'isabel.mendoza567@gmail.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(33, '2000334567', 'Gustavo', 'Navarro', 'gustavo.navarro890@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(34, '2000345678', 'Valeria', 'Alvarez', 'valeria.alvarez123@outlook.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(35, '2000356789', 'Marcelo', 'Herrera', 'marcelo.herrera456@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(36, '2000367890', 'Ana', 'Castro', 'ana.castro789@yahoo.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(37, '2000378901', 'Juliana', 'Flores', 'juliana.flores012@gmail.com', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(38, '2000389012', 'Mariano', 'Vasquez', 'mariano.vasquez345@yahoo.com.ph', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(39, '2000390123', 'Antonia', 'Ramos', 'antonia.ramos678@icloud.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(40, '2000401234', 'Maximiliano', 'Fuentes', 'maximiliano.fuentes901@aol.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(41, '2000412345', 'Ines', 'Reyes', 'ines.reyes234@hotmail.com', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(42, '2000423456', 'Agustin', 'Gomez', 'agustin.gomez567@yahoo.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(43, '2000434567', 'Fernanda', 'Diaz', 'fernanda.diaz890@outlook.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(44, '2000445678', 'Hector', 'Hernandez', 'hector.hernandez123@yahoo.com.ph', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(45, '2000456789', 'Marta', 'Lopez', 'marta.lopez456@gmail.com', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(46, '2000467890', 'Salvador', 'Martinez', 'salvador.martinez789@yahoo.com', 2, 4, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(47, '2000478901', 'Gabriela', 'Sanchez', 'gabriela.sanchez012@hotmail.com', 3, 1, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(48, '2000489012', 'Esteban', 'Perez', 'esteban.perez345@outlook.com', 4, 3, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(49, '2000490123', 'Catalina', 'Gonzalez', 'catalina.gonzalez678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:42', '2024-04-09 15:45:42'),
(50, '2000501234', 'Jorge', 'Torres', 'jorge.torres901@icloud.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(51, '2000512345', 'Lorena', 'Rivera', 'lorena.rivera234@aol.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(52, '2000523456', 'Raul', 'Dominguez', 'raul.dominguez567@yahoo.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(53, '2000534567', 'Martina', 'Reyes', 'martina.reyes890@hotmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(54, '2000545678', 'Arturo', 'Alvarez', 'arturo.alvarez123@yahoo.com.ph', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(55, '2000556789', 'Clara', 'Herrera', 'clara.herrera456@outlook.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(56, '2000567890', 'Leonardo', 'Castro', 'leonardo.castro789@gmail.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(57, '2000578901', 'Camila', 'Flores', 'camila.flores012@yahoo.com.ph', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(58, '2000589012', 'Emilio', 'Vasquez', 'emilio.vasquez345@icloud.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(59, '2000590123', 'Alicia', 'Ramos', 'alicia.ramos678@aol.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(60, '2000601234', 'Sergio', 'Fuentes', 'sergio.fuentes901@hotmail.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(61, '2000612345', 'Laura', 'Reyes', 'laura.reyes234@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(62, '2000623456', 'Roberto', 'Gomez', 'roberto.gomez567@yahoo.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(63, '2000634567', 'Clara', 'Diaz', 'clara.diaz890@outlook.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(64, '2000645678', 'Javier', 'Hernandez', 'javier.hernandez123@yahoo.com.ph', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(65, '2000656789', 'Ana', 'Lopez', 'ana.lopez456@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(66, '2000667890', 'Diego', 'Martinez', 'diego.martinez789@yahoo.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(67, '2000678901', 'Valentina', 'Sanchez', 'valentina.sanchez012@hotmail.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(68, '2000689012', 'Carlos', 'Perez', 'carlos.perez345@outlook.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(69, '2000690123', 'Isabella', 'Gonzalez', 'isabella.gonzalez678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(70, '2000701234', 'Gabriel', 'Torres', 'gabriel.torres901@icloud.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(71, '2000712345', 'Aurora', 'Rivera', 'aurora.rivera234@aol.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(72, '2000723456', 'Martin', 'Dominguez', 'martin.dominguez567@yahoo.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(73, '2000734567', 'Luis', 'Reyes', 'luis.reyes890@hotmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(74, '2000745678', 'Ana', 'Alvarez', 'ana.alvarez123@yahoo.com.ph', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(75, '2000756789', 'Diego', 'Herrera', 'diego.herrera456@outlook.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(76, '2000767890', 'Sofia', 'Castro', 'sofia.castro789@yahoo.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(77, '2000778901', 'Joaquin', 'Flores', 'joaquin.flores012@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(78, '2000789012', 'Maria', 'Vasquez', 'maria.vasquez345@yahoo.com.ph', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(79, '2000790123', 'Juan', 'Ramos', 'juan.ramos678@icloud.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(80, '2000801234', 'Valeria', 'Fuentes', 'valeria.fuentes901@aol.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(81, '2000812345', 'Mateo', 'Reyes', 'mateo.reyes234@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(82, '2000823456', 'Adriana', 'Gomez', 'adriana.gomez567@yahoo.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(83, '2000834567', 'Javier', 'Diaz', 'javier.diaz890@hotmail.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(84, '2000845678', 'Lucia', 'Hernandez', 'lucia.hernandez123@outlook.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(85, '2000856789', 'Carlos', 'Martinez', 'carlos.martinez456@yahoo.com.ph', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(86, '2000867890', 'Elena', 'Torres', 'elena.torres789@icloud.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(87, '2000878901', 'Felipe', 'Sanchez', 'felipe.sanchez012@aol.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(88, '2000889012', 'Julia', 'Gonzalez', 'julia.gonzalez345@yahoo.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(89, '2000890123', 'Alejandro', 'Lopez', 'alejandro.lopez678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(90, '2000901234', 'Camila', 'Castro', 'camila.castro901@outlook.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(91, '2000912345', 'Diego', 'Flores', 'diego.flores234@gmail.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(92, '2000923456', 'Valentina', 'Dominguez', 'valentina.dominguez567@yahoo.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(93, '2000934567', 'Marta', 'Reyes', 'marta.reyes890@hotmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(94, '2000945678', 'Salvador', 'Gomez', 'salvador.gomez123@yahoo.com.ph', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(95, '2000956789', 'Gabriela', 'Diaz', 'gabriela.diaz456@icloud.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(96, '2000967890', 'Esteban', 'Hernandez', 'esteban.hernandez789@aol.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(97, '2000978901', 'Catalina', 'Martinez', 'catalina.martinez012@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(98, '2000989012', 'Jorge', 'Torres', 'jorge.torres345@yahoo.com.ph', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(99, '2000990123', 'Lorena', 'Gonzalez', 'lorena.gonzalez678@outlook.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(100, '2001001234', 'Diego', 'Herrera', 'diego.herrera901@gmail.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(101, '2001002345', 'Emilio', 'Santos', 'emilio.santos234@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(102, '2001003456', 'Carmela', 'Garcia', 'carmela.garcia567@yahoo.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(103, '2001004567', 'Ramon', 'Cruz', 'ramon.cruz890@hotmail.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(104, '2001005678', 'Rosario', 'Reyes', 'rosario.reyes123@outlook.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(105, '2001006789', 'Leon', 'Torres', 'leon.torres456@yahoo.com.ph', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(106, '2001007890', 'Anita', 'Perez', 'anita.perez789@icloud.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(107, '2001008901', 'Pablo', 'Lopez', 'pablo.lopez012@aol.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(108, '2001009012', 'Flor', 'Dela Cruz', 'flor.delacruz345@gmail.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(109, '2001010123', 'Romeo', 'Rodriguez', 'romeo.rodriguez678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(110, '2001011234', 'Lucinda', 'Martinez', 'lucinda.martinez901@outlook.com', 2, 4, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(111, '2001012345', 'Leopoldo', 'Gonzalez', 'leopoldo.gonzalez234@hotmail.com', 3, 1, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(112, '2001013456', 'Concepcion', 'Fernandez', 'concepcion.fernandez567@yahoo.com', 4, 3, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(113, '2001014567', 'Hermogenes', 'Santos', 'hermogenes.santos890@gmail.com', 1, 2, '2024-04-09 15:45:43', '2024-04-09 15:45:43'),
(114, '2001015678', 'Socorro', 'Garcia', 'socorro.garcia123@yahoo.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(115, '2001016789', 'Feliciano', 'Cruz', 'feliciano.cruz456@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(116, '2001017890', 'Trinidad', 'Reyes', 'trinidad.reyes789@outlook.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(117, '2001018901', 'Federico', 'Torres', 'federico.torres012@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(118, '2001019012', 'Epifania', 'Perez', 'epifania.perez345@icloud.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(119, '2001020123', 'Perla', 'Lopez', 'perla.lopez678@aol.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(120, '2001021234', 'Rufino', 'Dela Cruz', 'rufino.delacruz901@gmail.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(121, '2001022345', 'Milagros', 'Rodriguez', 'milagros.rodriguez234@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(122, '2001023456', 'Eleuterio', 'Martinez', 'eleuterio.martinez567@outlook.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(123, '2001024567', 'Eufemia', 'Gonzalez', 'eufemia.gonzalez890@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(124, '2001025678', 'Amado', 'Fernandez', 'amado.fernandez123@yahoo.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(125, '2001026789', 'Severino', 'Santos', 'severino.santos456@gmail.com', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(126, '2001027890', 'Natividad', 'Garcia', 'natividad.garcia789@yahoo.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(127, '2001028901', 'Estanislao', 'Cruz', 'estanislao.cruz012@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(128, '2001029012', 'Magdalena', 'Reyes', 'magdalena.reyes345@outlook.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(129, '2001030123', 'Cresencio', 'Torres', 'cresencio.torres678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(130, '2001031234', 'Luningning', 'Perez', 'luningning.perez901@icloud.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(131, '2001032345', 'Efren', 'Lopez', 'efren.lopez234@aol.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(132, '2001033456', 'Aurora', 'Dela Cruz', 'aurora.delacruz567@gmail.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(133, '2001034567', 'Luisito', 'Rodriguez', 'luisito.rodriguez890@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(134, '2001035678', 'Rosita', 'Martinez', 'rosita.martinez123@outlook.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(135, '2001036789', 'Carmelo', 'Gonzalez', 'carmelo.gonzalez456@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(136, '2001037890', 'Eustaquia', 'Fernandez', 'eustaquia.fernandez789@yahoo.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(137, '2001038901', 'Balbino', 'Santos', 'balbino.santos012@gmail.com', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(138, '2001039012', 'Luningning', 'Garcia', 'luningning.garcia345@yahoo.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(139, '2001040123', 'Roberto', 'Cruz', 'roberto.cruz678@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(140, '2001041234', 'Corazon', 'Reyes', 'corazon.reyes901@outlook.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(141, '2001042345', 'Dante', 'Torres', 'dante.torres234@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(142, '2001043456', 'Inocencia', 'Perez', 'inocencia.perez567@icloud.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(143, '2001044567', 'Loreto', 'Lopez', 'loreto.lopez890@aol.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(144, '2001045678', 'Clotilde', 'Dela Cruz', 'clotilde.delacruz123@gmail.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(145, '2001046789', 'Justo', 'Rodriguez', 'justo.rodriguez456@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(146, '2001047890', 'Clarita', 'Martinez', 'clarita.martinez789@outlook.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(147, '2001048901', 'Domingo', 'Gonzalez', 'domingo.gonzalez012@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(148, '2001049012', 'Petra', 'Fernandez', 'petra.fernandez345@yahoo.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(149, '2001050123', 'Arsenio', 'Santos', 'arsenio.santos678@gmail.com', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(150, '2001051234', 'Gertrudes', 'Garcia', 'gertrudes.garcia901@yahoo.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(151, '2001052345', 'Hermogenes', 'Cruz', 'hermogenes.cruz234@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(152, '2001053456', 'Benilda', 'Reyes', 'benilda.reyes567@outlook.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(153, '2001054567', 'Pedrito', 'Torres', 'pedrito.torres890@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(154, '2001055678', 'Salome', 'Perez', 'salome.perez123@icloud.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(155, '2001056789', 'Nestor', 'Lopez', 'nestor.lopez456@aol.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(156, '2001057890', 'Isidro', 'Dela Cruz', 'isidro.delacruz789@gmail.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(157, '2001058901', 'Elisa', 'Rodriguez', 'elisa.rodriguez012@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(158, '2001059012', 'Celestino', 'Martinez', 'celestino.martinez345@outlook.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(159, '2001060123', 'Amelia', 'Gonzalez', 'amelia.gonzalez678@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(160, '2001061234', 'Conrado', 'Fernandez', 'conrado.fernandez901@yahoo.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(161, '2001062345', 'Carlo', 'Santos', 'carlo.santos234@gmail.com', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(162, '2001063456', 'Eloisa', 'Garcia', 'eloisa.garcia567@yahoo.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(163, '2001064567', 'Arcadio', 'Cruz', 'arcadio.cruz890@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(164, '2001065678', 'Adela', 'Reyes', 'adela.reyes123@outlook.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(165, '2001066789', 'Armando', 'Torres', 'armando.torres456@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(166, '2001067890', 'Trinidad', 'Perez', 'trinidad.perez789@icloud.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(167, '2001068901', 'Lamberto', 'Lopez', 'lamberto.lopez012@aol.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(168, '2001069012', 'Ernestina', 'Dela Cruz', 'ernestina.delacruz345@gmail.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(169, '2001070123', 'Elpidio', 'Rodriguez', 'elpidio.rodriguez678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(170, '2001071234', 'Encarnacion', 'Martinez', 'encarnacion.martinez901@outlook.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(171, '2001072345', 'Bienvenido', 'Gonzalez', 'bienvenido.gonzalez234@hotmail.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(172, '2001073456', 'Rosalia', 'Fernandez', 'rosalia.fernandez567@yahoo.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(173, '2001074567', 'Faustino', 'Santos', 'faustino.santos890@hotmail.com', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(174, '2001075678', 'Benjamin', 'Garcia', 'benjamin.garcia123@yahoo.com.ph', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(175, '2001076789', 'Adelaida', 'Cruz', 'adelaida.cruz456@outlook.com', 3, 1, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(176, '2001077890', 'Ismael', 'Reyes', 'ismael.reyes789@aol.com', 4, 3, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(177, '2001078901', 'Constancio', 'Torres', 'constancio.torres012@gmail.com', 1, 2, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(178, '2001079012', 'Angelita', 'Perez', 'angelita.perez345@yahoo.com', 2, 4, '2024-04-09 15:45:44', '2024-04-09 15:45:44'),
(179, '2001080123', 'Marcial', 'Lopez', 'marcial.lopez678@yahoo.com.ph', 3, 1, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(180, '2001081234', 'Filomena', 'Dela Cruz', 'filomena.delacruz901@hotmail.com', 4, 3, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(181, '2001082345', 'Rogelio', 'Rodriguez', 'rogelio.rodriguez234@outlook.com', 1, 2, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(182, '2001083456', 'Casimira', 'Martinez', 'casimira.martinez567@icloud.com', 2, 4, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(183, '2001084567', 'Jacinto', 'Gonzalez', 'jacinto.gonzalez890@aol.com', 3, 1, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(184, '2001085678', 'Clemente', 'Fernandez', 'clemente.fernandez123@yahoo.com', 4, 3, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(185, '2001086789', 'Elpidia', 'Santos', 'elpidia.santos456@gmail.com', 1, 2, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(186, '2001087890', 'Virgilio', 'Garcia', 'virgilio.garcia789@yahoo.com', 2, 4, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(187, '2001088901', 'Salvacion', 'Cruz', 'salvacion.cruz012@hotmail.com', 3, 1, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(188, '2001089012', 'Apolinario', 'Reyes', 'apolinario.reyes345@outlook.com', 4, 3, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(189, '2001090123', 'Aurelia', 'Torres', 'aurelia.torres678@yahoo.com.ph', 1, 2, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(190, '2001091234', 'Ariston', 'Perez', 'ariston.perez901@icloud.com', 2, 4, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(191, '2001092345', 'Epifanio', 'Lopez', 'epifanio.lopez234@aol.com', 3, 1, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(192, '2001093456', 'Filipina', 'Dela Cruz', 'filipina.delacruz567@gmail.com', 4, 3, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(193, '2001094567', 'Lamberto', 'Rodriguez', 'lamberto.rodriguez890@yahoo.com.ph', 1, 2, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(194, '2001095678', 'Asuncion', 'Martinez', 'asuncion.martinez123@outlook.com', 2, 4, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(195, '2001096789', 'Eduardo', 'Gonzalez', 'eduardo.gonzalez456@hotmail.com', 3, 1, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(196, '2001097890', 'Estrella', 'Fernandez', 'estrella.fernandez789@yahoo.com', 4, 3, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(197, '2001098901', 'Isidoro', 'Santos', 'isidoro.santos012@hotmail.com', 1, 2, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(198, '2001099012', 'Socorro', 'Garcia', 'socorro.garcia345@yahoo.com', 2, 4, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(199, '2001100123', 'Vicente', 'Cruz', 'vicente.cruz678@outlook.com', 3, 1, '2024-04-09 15:45:45', '2024-04-09 15:45:45'),
(200, '2001101234', 'Primitivo', 'Reyes', 'primitivo.reyes901@gmail.com', 4, 3, '2024-04-09 15:45:45', '2024-04-09 15:45:45');

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
(3, 'BSENTREP'),
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
(1, 'Academic Department', '2024-04-10 02:51:14', '2024-04-10 03:02:37'),
(2, 'Administrative Department', '2024-04-10 02:51:31', '2024-04-10 03:14:09'),
(3, 'Operations and Facilities', '2024-04-10 03:01:46', '2024-04-10 03:01:46'),
(4, 'Technology Department', '2024-04-10 03:03:23', '2024-04-10 03:03:23');

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
(1, 1, 'First Aid and Safety Seminar', 'ACLC College Main Room #5', '\"Safety First: A Comprehensive First Aid and Safety Workshop\"', '2024-04-10', '09:30:00', '14:00:00', 2, '2024-04-09 13:30:55', '2024-04-10 04:40:14'),
(2, 1, 'SportsFest 2024', 'University of Northeastern Philippines (UNEP)', '\"Ignite the Spirit: SportsFest 2024\"', '2024-04-11', '07:00:00', '17:00:00', 2, '2024-04-10 04:25:58', '2024-04-10 04:25:58'),
(3, 1, 'Year End Party', 'Macagang Business Center Hotel & Resort - Nabua', '\"Cheers to Success: Year End Party 2024\"', '2024-04-10', '07:30:00', '17:30:00', 2, '2024-04-10 04:30:10', '2024-04-10 04:32:09'),
(4, 1, 'Acquaintance Party', 'Macagang Business Center Hotel & Resort - Nabua', '\"Welcome to the Family: Acquaintance Party 2024\"', '2024-04-11', '06:30:00', '18:30:00', 2, '2024-04-10 04:31:52', '2024-04-10 04:31:52'),
(5, 1, 'Financial Literacy Workshop', 'ACLC College Main Room #7', '\"Mastering Your Money: A Financial Literacy Workshop\"', '2024-04-12', '09:00:00', '12:00:00', 2, '2024-04-10 04:38:35', '2024-04-10 04:38:35'),
(6, 1, 'Technology Skills Workshop', 'ACLC College Main - Computer Laboratory', '\"Tech Savvy: Empowering Students with Essential Digital Skills\"', '2024-04-13', '08:00:00', '11:30:00', 2, '2024-04-10 04:43:41', '2024-04-10 04:43:41'),
(7, 1, 'Public Speaking Workshop', 'ACLC College Main Room #5', '\"Speak with Confidence: Mastering the Art of Public Speaking\"', '2024-04-09', '13:30:00', '16:30:00', 2, '2024-04-10 04:46:27', '2024-04-10 04:46:48');

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
(1, '42564890123', 'Sophia', 'Smith', 's.smith@example.com', 2, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(2, '10567213489', 'Liam', 'Johnson', 'l.johnson@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(3, '21793458612', 'Olivia', 'Williams', 'o.williams@example.com', 2, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(4, '31487592063', 'Noah', 'Brown', 'n.brown@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(5, '53724180986', 'Emma', 'Jones', 'e.jones@example.com', 2, 2, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(6, '22659837014', 'William', 'Garcia', 'w.garcia@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(7, '91234675820', 'Ava', 'Martinez', 'a.martinez@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(8, '71054329876', 'Isabella', 'Robinson', 'i.robinson@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(9, '84620973152', 'James', 'Clark', 'j.clark@example.com', 2, 2, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(10, '20359841675', 'Sophia', 'Rodriguez', 's.rodriguez@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(11, '62039587142', 'Benjamin', 'Lewis', 'b.lewis@example.com', 3, 5, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(12, '73519628407', 'Olivia', 'Lee', 'o.lee@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(13, '48917326502', 'Mia', 'Walker', 'm.walker@example.com', 2, 3, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(14, '95187263408', 'Ethan', 'Hall', 'e.hall@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(15, '32098476512', 'Charlotte', 'Allen', 'c.allen@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(16, '75420961385', 'William', 'Young', 'w.young@example.com', 3, 8, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(17, '12498573602', 'Amelia', 'Hernandez', 'a.hernandez@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(18, '63047281954', 'Daniel', 'King', 'd.king@example.com', 4, 4, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(19, '97205318624', 'Sophia', 'Wright', 's.wright@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(20, '24608391572', 'Harper', 'Lopez', 'h.lopez@example.com', 2, 7, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(21, '18745203698', 'Matthew', 'Hill', 'm.hill@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(22, '53041728965', 'Mia', 'Scott', 'm.scott@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(23, '39201468725', 'Alexander', 'Green', 'a.green@example.com', 3, 8, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(24, '81954762301', 'Evelyn', 'Adams', 'e.adams@example.com', 2, 6, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(25, '64093185742', 'Mason', 'Baker', 'm.baker@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(26, '75306248129', 'Charlotte', 'Gonzalez', 'c.gonzalez@example.com', 2, 2, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(27, '62547831906', 'Jacob', 'Nelson', 'j.nelson@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(28, '39821750642', 'Olivia', 'Carter', 'o.carter@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(29, '53091742658', 'William', 'Mitchell', 'w.mitchell@example.com', 1, 1, '2024-04-10 03:47:08', '2024-04-10 03:47:08'),
(30, '17369428502', 'Ava', 'Perez', 'a.perez@example.com', 2, 6, '2024-04-10 03:47:08', '2024-04-10 03:47:08');

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
(1, 'Instructor', '2024-04-10 02:54:39', '2024-04-10 02:54:39'),
(2, 'Registrar', '2024-04-10 02:54:47', '2024-04-10 02:54:47'),
(3, 'Librarian', '2024-04-10 02:55:11', '2024-04-10 02:55:11'),
(4, 'IT Administrator', '2024-04-10 02:55:37', '2024-04-10 03:10:01'),
(5, 'Security Personnel', '2024-04-10 03:09:06', '2024-04-10 03:09:06'),
(6, 'Accountant', '2024-04-10 03:12:08', '2024-04-10 03:15:56'),
(7, 'Dean', '2024-04-10 03:14:42', '2024-04-10 03:14:42'),
(8, 'Facility Staff', '2024-04-10 03:17:31', '2024-04-10 03:17:31');

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
(1, '3001002345', 'James', 'Smith', 'james.smith123@gmail.com', 1, 1, 1, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(2, '3002003456', 'Emma', 'Johnson', 'emma.johnson456@yahoo.com', 3, 2, 2, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(3, '3003004567', 'Michael', 'Williams', 'michael.williams789@hotmail.com', 4, 1, 3, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(4, '3004005678', 'Olivia', 'Jones', 'olivia.jones234@outlook.com', 2, 2, 4, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(5, '3005006789', 'William', 'Brown', 'william.brown567@yahoo.com.ph', 5, 1, 1, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(6, '3006007890', 'Sophia', 'Davis', 'sophia.davis890@icloud.com', 1, 2, 2, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(7, '3007008901', 'Alexander', 'Miller', 'alexander.miller123@aol.com', 3, 1, 3, '2024-04-10 00:47:15', '2024-04-10 00:47:15'),
(8, '3008009012', 'Isabella', 'Wilson', 'isabella.wilson456@gmail.com', 4, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(9, '3009010123', 'Ethan', 'Moore', 'ethan.moore789@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(10, '3010011234', 'Charlotte', 'Taylor', 'charlotte.taylor012@outlook.com', 5, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(11, '3011012345', 'Liam', 'Anderson', 'liam.anderson345@hotmail.com', 1, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(12, '3012013456', 'Amelia', 'Thomas', 'amelia.thomas678@yahoo.com', 3, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(13, '3013014567', 'Benjamin', 'Jackson', 'benjamin.jackson901@yahoo.com.ph', 4, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(14, '3014015678', 'Mia', 'White', 'mia.white234@icloud.com', 2, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(15, '3015016789', 'Henry', 'Harris', 'henry.harris567@aol.com', 5, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(16, '3016017890', 'Ella', 'Martin', 'ella.martin890@gmail.com', 1, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(17, '3017018901', 'Jack', 'Thompson', 'jack.thompson123@yahoo.com', 3, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(18, '3018019012', 'Sophia', 'Garcia', 'sophia.garcia456@hotmail.com', 4, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(19, '3019010123', 'Jacob', 'Martinez', 'jacob.martinez789@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(20, '3020011234', 'Ava', 'Robinson', 'ava.robinson012@outlook.com', 5, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(21, '3021012345', 'Noah', 'Clark', 'noah.clark567@gmail.com', 1, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(22, '3022013456', 'Lily', 'Lewis', 'lily.lewis890@yahoo.com', 3, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(23, '3023014567', 'Lucas', 'Lee', 'lucas.lee234@icloud.com', 4, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(24, '3024015678', 'Grace', 'Walker', 'grace.walker901@hotmail.com', 2, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(25, '3025016789', 'Logan', 'Hall', 'logan.hall456@yahoo.com.ph', 5, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(26, '3026017890', 'Emma', 'Allen', 'emma.allen789@outlook.com', 1, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(27, '3027018901', 'Carter', 'Young', 'carter.young012@aol.com', 3, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(28, '3028019012', 'Madison', 'Wright', 'madison.wright345@gmail.com', 4, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(29, '3029010123', 'Aiden', 'Hill', 'aiden.hill678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(30, '3030011234', 'Avery', 'Adams', 'avery.adams901@icloud.com', 5, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(31, '3031012345', 'Scarlett', 'Baker', 'scarlett.baker234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(32, '3032013456', 'Wyatt', 'King', 'wyatt.king567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(33, '3033014567', 'Hannah', 'Scott', 'hannah.scott890@yahoo.com.ph', 4, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(34, '3034015678', 'Evelyn', 'Wright', 'evelyn.wright123@gmail.com', 2, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(35, '3035016789', 'Jack', 'Allen', 'jack.allen456@yahoo.com', 5, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(36, '3036017890', 'William', 'Scott', 'william.scott789@outlook.com', 1, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(37, '3037018901', 'Victoria', 'Green', 'victoria.green012@aol.com', 3, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(38, '3038019012', 'Luke', 'Baker', 'luke.baker345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(39, '3039010123', 'Zoey', 'Carter', 'zoey.carter678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(40, '3040011234', 'Nathan', 'Morris', 'nathan.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(41, '3041012345', 'Audrey', 'Roberts', 'audrey.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(42, '3042013456', 'Ryan', 'Hill', 'ryan.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(43, '3043014567', 'Sarah', 'King', 'sarah.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:16', '2024-04-10 00:47:16'),
(44, '3044015678', 'Jackson', 'Young', 'jackson.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(45, '3045016789', 'Madelyn', 'Wright', 'madelyn.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(46, '3046017890', 'Christopher', 'Lee', 'christopher.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(47, '3047018901', 'Levi', 'Wright', 'levi.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(48, '3048019012', 'Hazel', 'Lewis', 'hazel.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(49, '3049010123', 'Brooklyn', 'Baker', 'brooklyn.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(50, '3050011234', 'Henry', 'Morris', 'henry.morris901@yahoo.com', 5, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(51, '3051012345', 'Elizabeth', 'Roberts', 'elizabeth.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(52, '3052013456', 'Eli', 'Hill', 'eli.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(53, '3053014567', 'Paisley', 'King', 'paisley.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(54, '3054015678', 'Aaron', 'Young', 'aaron.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(55, '3055016789', 'Lydia', 'Wright', 'lydia.wright456@gmail.com', 5, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(56, '3056017890', 'Landon', 'Lee', 'landon.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(57, '3057018901', 'Nora', 'Wright', 'nora.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(58, '3058019012', 'Eleanor', 'Lewis', 'eleanor.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(59, '3059010123', 'Eli', 'Baker', 'eli.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(60, '3060011234', 'Caroline', 'Morris', 'caroline.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(61, '3061012345', 'Joseph', 'Roberts', 'joseph.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(62, '3062013456', 'Emilia', 'Hill', 'emilia.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(63, '3063014567', 'Bentley', 'King', 'bentley.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(64, '3064015678', 'Luna', 'Young', 'luna.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(65, '3065016789', 'Everly', 'Wright', 'everly.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(66, '3066017890', 'Max', 'Lee', 'max.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(67, '3067018901', 'Axel', 'Wright', 'axel.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(68, '3068019012', 'Violet', 'Lewis', 'violet.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(69, '3069010123', 'Adeline', 'Baker', 'adeline.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(70, '3070011234', 'Jayden', 'Morris', 'jayden.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(71, '3071012345', 'Mila', 'Roberts', 'mila.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(72, '3072013456', 'Silas', 'Hill', 'silas.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(73, '3073014567', 'Ellie', 'King', 'ellie.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(74, '3074015678', 'Rhett', 'Young', 'rhett.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(75, '3075016789', 'Molly', 'Wright', 'molly.wright456@gmail.com', 5, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(76, '3076017890', 'Zane', 'Lee', 'zane.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(77, '3077018901', 'Alexis', 'Wright', 'alexis.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(78, '3078019012', 'Daniel', 'Lewis', 'daniel.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(79, '3079010123', 'Camila', 'Baker', 'camila.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:17', '2024-04-10 00:47:17'),
(80, '3080011234', 'Cole', 'Morris', 'cole.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(81, '3081012345', 'Willow', 'Roberts', 'willow.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(82, '3082013456', 'Liam', 'Hill', 'liam.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(83, '3083014567', 'Aubrey', 'King', 'aubrey.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(84, '3084015678', 'Brayden', 'Young', 'brayden.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(85, '3085016789', 'Hudson', 'Wright', 'hudson.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(86, '3086017890', 'Piper', 'Lee', 'piper.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(87, '3087018901', 'Adrian', 'Wright', 'adrian.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(88, '3088019012', 'Lily', 'Lewis', 'lily.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(89, '3089010123', 'Max', 'Baker', 'max.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(90, '3090011234', 'Eliana', 'Morris', 'eliana.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(91, '3091012345', 'Zachary', 'Roberts', 'zachary.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(92, '3092013456', 'Annabelle', 'Hill', 'annabelle.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(93, '3093014567', 'Easton', 'King', 'easton.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(94, '3094015678', 'Ariana', 'Young', 'ariana.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(95, '3095016789', 'Elias', 'Wright', 'elias.wright456@gmail.com', 5, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(96, '3096017890', 'Makayla', 'Lee', 'makayla.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(97, '3097018901', 'Brody', 'Wright', 'brody.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(98, '3098019012', 'Natalie', 'Lewis', 'natalie.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(99, '3099010123', 'Levi', 'Baker', 'levi.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(100, '3100011234', 'Athena', 'Morris', 'athena.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(101, '3101012345', 'Dominic', 'Roberts', 'dominic.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(102, '3102013456', 'Ariel', 'Hill', 'ariel.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(103, '3103014567', 'Alexa', 'King', 'alexa.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(104, '3104015678', 'Gavin', 'Young', 'gavin.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(105, '3105016789', 'Melanie', 'Wright', 'melanie.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(106, '3106017890', 'Maxwell', 'Lee', 'maxwell.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(107, '3107018901', 'Lydia', 'Wright', 'lydia.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(108, '3108019012', 'Elijah', 'Lewis', 'elijah.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(109, '3109010123', 'Elise', 'Baker', 'elise.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(110, '3110011234', 'Carter', 'Morris', 'carter.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(111, '3111012345', 'Liliana', 'Roberts', 'liliana.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(112, '3112013456', 'Josiah', 'Hill', 'josiah.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(113, '3113014567', 'Violet', 'King', 'violet.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(114, '3114015678', 'Tristan', 'Young', 'tristan.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(115, '3115016789', 'Alexis', 'Wright', 'alexis.wright456@gmail.com', 5, 1, 3, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(116, '3116017890', 'Bryce', 'Lee', 'bryce.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:18', '2024-04-10 00:47:18'),
(117, '3117018901', 'Eva', 'Wright', 'eva.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(118, '3118019012', 'Xavier', 'Lewis', 'xavier.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(119, '3119010123', 'Giselle', 'Baker', 'giselle.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(120, '3120011234', 'Ezra', 'Morris', 'ezra.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(121, '3121012345', 'Elena', 'Roberts', 'elena.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(122, '3122013456', 'Leah', 'Hill', 'leah.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(123, '3123014567', 'Parker', 'King', 'parker.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(124, '3124015678', 'Skylar', 'Young', 'skylar.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(125, '3125016789', 'Adalyn', 'Wright', 'adalyn.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(126, '3126017890', 'Colton', 'Lee', 'colton.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(127, '3127018901', 'Penelope', 'Wright', 'penelope.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(128, '3128019012', 'Kingston', 'Lewis', 'kingston.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(129, '3129010123', 'Savannah', 'Baker', 'savannah.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(130, '3130011234', 'Roman', 'Morris', 'roman.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(131, '3131012345', 'Nova', 'Roberts', 'nova.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(132, '3132013456', 'Ruby', 'Hill', 'ruby.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(133, '3133014567', 'Everett', 'King', 'everett.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(134, '3134015678', 'Ivy', 'Young', 'ivy.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(135, '3135016789', 'Harrison', 'Wright', 'harrison.wright456@icloud.com', 5, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(136, '3136017890', 'Emery', 'Lee', 'emery.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(137, '3137018901', 'Clara', 'Wright', 'clara.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(138, '3138019012', 'Bentley', 'Lewis', 'bentley.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(139, '3139010123', 'Charlie', 'Baker', 'charlie.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(140, '3140011234', 'Jaxon', 'Morris', 'jaxon.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(141, '3141012345', 'Fiona', 'Roberts', 'fiona.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(142, '3142013456', 'Maverick', 'Hill', 'maverick.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(143, '3143014567', 'Sienna', 'King', 'sienna.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(144, '3144015678', 'Connor', 'Young', 'connor.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(145, '3145016789', 'Lucy', 'Wright', 'lucy.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(146, '3146017890', 'Axel', 'Lee', 'axel.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(147, '3147018901', 'Gabriel', 'Wright', 'gabriel.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(148, '3148019012', 'Hailey', 'Lewis', 'hailey.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(149, '3149010123', 'Ezekiel', 'Baker', 'ezekiel.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(150, '3150011234', 'Luna', 'Morris', 'luna.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(151, '3151012345', 'Miles', 'Roberts', 'miles.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(152, '3152013456', 'Harper', 'Hill', 'harper.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:19', '2024-04-10 00:47:19'),
(153, '3153014567', 'Daniel', 'King', 'daniel.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(154, '3154015678', 'Sarah', 'Young', 'sarah.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(155, '3155016789', 'Austin', 'Wright', 'austin.wright456@gmail.com', 5, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(156, '3156017890', 'Aria', 'Lee', 'aria.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(157, '3157018901', 'John', 'Wright', 'john.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(158, '3158019012', 'Sadie', 'Lewis', 'sadie.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(159, '3159010123', 'Nolan', 'Baker', 'nolan.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(160, '3160011234', 'Hazel', 'Morris', 'hazel.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(161, '3161012345', 'Anna', 'Roberts', 'anna.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(162, '3162013456', 'Evan', 'Hill', 'evan.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(163, '3163014567', 'Kylie', 'King', 'kylie.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(164, '3164015678', 'Owen', 'Young', 'owen.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(165, '3165016789', 'Stella', 'Wright', 'stella.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(166, '3166017890', 'David', 'Lee', 'david.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(167, '3167018901', 'Leah', 'Wright', 'leah.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(168, '3168019012', 'Tyler', 'Lewis', 'tyler.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(169, '3169010123', 'Juliana', 'Baker', 'juliana.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(170, '3170011234', 'Zander', 'Morris', 'zander.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(171, '3171012345', 'Liam', 'Roberts', 'liam.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(172, '3172013456', 'Isabella', 'Hill', 'isabella.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(173, '3173014567', 'Zoe', 'King', 'zoe.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(174, '3174015678', 'Xavier', 'Young', 'xavier.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(175, '3175016789', 'Aurora', 'Wright', 'aurora.wright456@icloud.com', 5, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(176, '3176017890', 'Christian', 'Lee', 'christian.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(177, '3177018901', 'Delilah', 'Wright', 'delilah.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(178, '3178019012', 'Cole', 'Lewis', 'cole.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(179, '3179010123', 'Adalynn', 'Baker', 'adalynn.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(180, '3180011234', 'Luke', 'Morris', 'luke.morris901@icloud.com', 5, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(181, '3181012345', 'Vivian', 'Roberts', 'vivian.roberts234@gmail.com', 1, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(182, '3182013456', 'Caleb', 'Hill', 'caleb.hill567@yahoo.com', 3, 2, 2, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(183, '3183014567', 'Lucas', 'King', 'lucas.king890@hotmail.com', 4, 1, 3, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(184, '3184015678', 'Layla', 'Young', 'layla.young123@yahoo.com.ph', 2, 2, 4, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(185, '3185016789', 'Gabriel', 'Wright', 'gabriel.wright456@icloud.com', 5, 1, 1, '2024-04-10 00:47:20', '2024-04-10 00:47:20'),
(186, '3186017890', 'Maya', 'Lee', 'maya.lee789@outlook.com', 1, 2, 2, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(187, '3187018901', 'Bryson', 'Wright', 'bryson.wright012@aol.com', 3, 1, 3, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(188, '3188019012', 'Madeline', 'Lewis', 'madeline.lewis345@gmail.com', 4, 2, 4, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(189, '3189010123', 'Jaxon', 'Baker', 'jaxon.baker678@yahoo.com.ph', 2, 1, 1, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(190, '3190011234', 'Mila', 'Morris', 'mila.morris901@icloud.com', 5, 2, 2, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(191, '3191012345', 'Nathan', 'Roberts', 'nathan.roberts234@hotmail.com', 1, 1, 3, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(192, '3192013456', 'Levi', 'Hill', 'levi.hill567@yahoo.com', 3, 2, 4, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(193, '3193014567', 'Kinsley', 'King', 'kinsley.king890@icloud.com', 4, 1, 1, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(194, '3194015678', 'Sawyer', 'Young', 'sawyer.young123@yahoo.com.ph', 2, 2, 2, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(195, '3195016789', 'Mackenzie', 'Wright', 'mackenzie.wright456@icloud.com', 5, 1, 3, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(196, '3196017890', 'Aaron', 'Lee', 'aaron.lee789@outlook.com', 1, 2, 4, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(197, '3197018901', 'Charlie', 'Wright', 'charlie.wright012@aol.com', 3, 1, 1, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(198, '3198019012', 'Hannah', 'Lewis', 'hannah.lewis345@hotmail.com', 4, 2, 2, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(199, '3199010123', 'Raelynn', 'Baker', 'raelynn.baker678@yahoo.com.ph', 2, 1, 3, '2024-04-10 00:47:21', '2024-04-10 00:47:21'),
(200, '3199023456', 'Liam', 'Cooper', 'liam.cooper123@gmail.com', 5, 2, 1, '2024-04-10 00:47:21', '2024-04-10 00:47:21');

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
(1, 'Jetro', 'Bagasala', 'jethgen.26@gmail.com', 'Admin', 'Admin1234', 'active', 1, '2024-02-14 06:53:14', '2024-04-09 09:10:55'),
(2, 'Cedrick', 'Embestro', 'ced@gmail.com', 'Cedrick', 'Cedrick123', 'active', 2, '2024-04-09 09:19:27', '2024-04-09 09:23:52'),
(3, 'Cynel', 'Taduran', 'cynel@gmail.com', 'Cynel', 'Cynel123', 'active', 2, '2024-04-10 04:02:50', '2024-04-10 04:02:50'),
(4, 'Carlos', 'Tanay', 'carlos@gmail.com', 'Carlos', 'Carlos123', 'active', 2, '2024-04-10 04:03:53', '2024-04-10 04:03:53'),
(5, 'Manuel', 'Monge', 'manuel@gmail.com', 'Manuel', 'Manuel123', 'active', 2, '2024-04-10 04:04:26', '2024-04-10 04:04:26');

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
  ADD KEY `event_id` (`event_id`),
  ADD KEY `attendance_ibfk_1` (`college_student_id`),
  ADD KEY `attendance_ibfk_2` (`senior_high_student_id`),
  ADD KEY `attendance_ibfk_3` (`faculty_id`);

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
  ADD UNIQUE KEY `IdentificationNumber` (`IdentificationNumber`),
  ADD UNIQUE KEY `Email` (`Email`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `collegestudents`
--
ALTER TABLE `collegestudents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `strands`
--
ALTER TABLE `strands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`college_student_id`) REFERENCES `collegestudents` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`senior_high_student_id`) REFERENCES `seniorhighstudents` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `events_ibfk_5` FOREIGN KEY (`registrar_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `faculties_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`ID`),
  ADD CONSTRAINT `faculties_ibfk_2` FOREIGN KEY (`PositionID`) REFERENCES `positions` (`ID`);

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
