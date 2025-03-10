-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 04:34 AM
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
-- Database: `facsched`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_fname` varchar(60) NOT NULL,
  `admin_mname` varchar(60) NOT NULL,
  `admin_lname` varchar(60) NOT NULL,
  `admin_email` varchar(60) NOT NULL,
  `admin_password` varchar(60) NOT NULL,
  `admin_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=disable,1=enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_fname`, `admin_mname`, `admin_lname`, `admin_email`, `admin_password`, `admin_status`) VALUES
(1, 'joshua', '', 'padilla', 'admin@gmail.com', 'admin@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designation_id`, `designation_name`) VALUES
(1, 'Dean'),
(2, 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `tblcurriculum`
--

CREATE TABLE `tblcurriculum` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(60) NOT NULL,
  `subject_name` varchar(60) NOT NULL,
  `lab_num` int(11) NOT NULL,
  `lec_num` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `designated_year_level` int(11) NOT NULL,
  `subject_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archive,1=exist',
  `subject_sy` varchar(60) NOT NULL,
  `subject_date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcurriculum`
--

INSERT INTO `tblcurriculum` (`subject_id`, `subject_code`, `subject_name`, `lab_num`, `lec_num`, `hours`, `semester`, `designated_year_level`, `subject_status`, `subject_sy`, `subject_date_added`) VALUES
(12, 'cap1', 'capstone 1', 1, 0, 4, 2, 3, 0, '2025-2026', '2025-02-12 13:27:04'),
(13, 'cap 2', 'capstone 2', 0, 2, 4, 2, 4, 0, '2025-2026', '2025-02-12 13:27:09'),
(14, 'PE', 'physical education', 0, 3, 2, 1, 1, 0, '2025-2026', '2025-02-12 13:27:12'),
(417, 'm1', 'math1', 1, 0, 3, 1, 1, 1, '2022-2023', '2025-02-12 13:26:19'),
(418, 'm2', 'math2', 1, 1, 3, 1, 1, 1, '2022-2023', '2025-02-12 13:26:19'),
(419, 'm3', 'math3', 1, 1, 3, 1, 2, 1, '2022-2023', '2025-02-12 13:26:19'),
(420, 'm4', 'math4', 1, 1, 3, 1, 3, 1, '2022-2023', '2025-02-12 13:26:19'),
(421, 'm5', 'math5', 0, 1, 2, 1, 4, 0, '2025-2026', '2025-02-12 13:27:15'),
(422, 'm6', 'math6', 1, 0, 2, 2, 1, 1, '2025-2026', '2025-03-07 08:12:43'),
(423, 'm7', 'math7', 0, 1, 2, 2, 2, 1, '2024-2025', '2025-02-12 13:26:19'),
(424, 'm8', 'math8', 0, 0, 1, 2, 3, 1, '2024-2025', '2025-02-12 13:26:19'),
(425, 'm9', 'math9', 0, 1, 1, 1, 4, 1, '2024-2025', '2025-02-12 13:26:19'),
(426, 'm10', 'math10', 1, 0, 1, 1, 3, 1, '2024-2025', '2025-02-12 13:26:19'),
(427, 'm11', 'math11', 0, 1, 1, 1, 4, 1, '2021-2022', '2025-02-12 13:26:19'),
(428, 'm12', 'math12', 1, 0, 1, 1, 3, 1, '2015-2020', '2025-02-12 13:26:19'),
(429, 'm14', 'math14', 1, 0, 1, 1, 3, 1, '2024-2025', '2025-02-12 13:28:09'),
(430, 'm6', 'm6', 1, 0, 2, 1, 1, 0, '2025-2026', '2025-02-12 13:29:51'),
(476, 'm1', 'math1', 1, 0, 3, 1, 2, 1, '2022-2023', '2025-02-25 03:04:10'),
(477, 'm2', 'math2', 1, 1, 3, 1, 1, 1, '2022-2023', '2025-02-19 22:51:29'),
(478, 'm3', 'math3', 1, 1, 3, 1, 2, 1, '2022-2023', '2025-02-19 22:51:29'),
(479, 'm4', 'math4', 1, 1, 3, 1, 3, 1, '2022-2023', '2025-02-19 22:51:29'),
(480, 'm5', 'math5', 0, 1, 2, 1, 4, 1, '2025-2026', '2025-02-25 03:05:02'),
(481, 'm6', 'math6', 1, 0, 2, 2, 1, 1, '2024-2025', '2025-02-19 22:51:29'),
(482, 'm7', 'math7', 0, 1, 2, 2, 2, 1, '2024-2025', '2025-02-19 22:51:29'),
(483, 'm8', 'math8', 0, 0, 1, 2, 3, 1, '2024-2025', '2025-02-19 22:51:29'),
(484, 'm9', 'math9', 0, 1, 1, 1, 4, 1, '2024-2025', '2025-02-19 22:51:29'),
(485, 'm10', 'math10', 1, 0, 1, 1, 3, 1, '2024-2025', '2025-02-19 22:51:29'),
(486, 'm11', 'math11', 0, 1, 1, 1, 4, 1, '2021-2022', '2025-02-19 22:51:29'),
(487, 'm12', 'math12', 1, 0, 1, 1, 3, 1, '2015-2020', '2025-02-19 22:51:29'),
(488, 'm14', 'math14', 1, 0, 1, 1, 3, 0, '2008-2009', '2025-03-09 09:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `tblfacultymember`
--

CREATE TABLE `tblfacultymember` (
  `teacher_id` int(11) NOT NULL,
  `ID_code` varchar(60) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `mname` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `designation` varchar(60) NOT NULL,
  `totalweekly_hrs` varchar(60) DEFAULT NULL,
  `Password` varchar(60) DEFAULT NULL,
  `teacher_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archive,1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfacultymember`
--

INSERT INTO `tblfacultymember` (`teacher_id`, `ID_code`, `fname`, `mname`, `lname`, `designation`, `totalweekly_hrs`, `Password`, `teacher_status`) VALUES
(1, '0002', 'gerald', '', 'anderson', 'Instructor II', '40', '0002', 1),
(2, '0003', 'Juan', '', 'Dela cruz', 'Part Time', NULL, 'Dela cruz', 0),
(3, '0004', 'robin', '', 'padilla', 'Instructor II', '40', 'padilla', 1),
(4, '0005', 'Joan', '', 'Panimbangon', 'Part Time', '12', 'Panimbangon', 1),
(5, '0006', 'Mary Loi', '', 'Ricalde', 'Instructor I', '40', 'Ricalde', 0),
(6, '0007', 'April', '', 'De Leon', 'Asst. Prof I', '30', 'De Leon', 1),
(7, '00010', 'james', '', 'bungay', 'Instructor I', '30', 'bungay', 1),
(8, '0008', 'juan ', '', 'delacruz', 'Dean', '40', 'delacruz', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblotherworkschedule`
--

CREATE TABLE `tblotherworkschedule` (
  `ows_id` int(11) NOT NULL,
  `ows_schedule_id` int(11) NOT NULL,
  `ows_location` text NOT NULL,
  `ows_work_description` text NOT NULL,
  `ows_subtStartTimeAssign` time NOT NULL,
  `ows_subtEndTimeAssign` time NOT NULL,
  `ows_typeOfWork` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblotherworkschedule`
--

INSERT INTO `tblotherworkschedule` (`ows_id`, `ows_schedule_id`, `ows_location`, `ows_work_description`, `ows_subtStartTimeAssign`, `ows_subtEndTimeAssign`, `ows_typeOfWork`) VALUES
(26, 38, 'faculty', 'paper works', '12:00:00', '14:00:00', 'admin work'),
(34, 47, 'faculty', 'paper works', '16:00:00', '18:00:00', 'admin work'),
(35, 39, 'office', 'paper works', '07:00:00', '12:00:00', 'admin work');

-- --------------------------------------------------------

--
-- Table structure for table `tblschedule`
--

CREATE TABLE `tblschedule` (
  `sched_id` int(11) NOT NULL,
  `sched_teacher_id` int(11) NOT NULL,
  `sched_day` varchar(60) NOT NULL,
  `sched_start_Hrs` time NOT NULL,
  `sched_end_Hrs` time NOT NULL,
  `sched_status` varchar(60) NOT NULL DEFAULT 'normal',
  `sched_date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblschedule`
--

INSERT INTO `tblschedule` (`sched_id`, `sched_teacher_id`, `sched_day`, `sched_start_Hrs`, `sched_end_Hrs`, `sched_status`, `sched_date_added`) VALUES
(22, 3, 'monday', '07:00:00', '17:00:00', 'normal', '2025-01-15 03:56:22'),
(23, 3, 'tuesday', '07:00:00', '16:00:00', 'normal', '2025-01-15 03:56:22'),
(24, 3, 'friday', '11:00:00', '19:00:00', 'normal', '2025-01-15 03:56:22'),
(25, 3, 'saturday', '07:00:00', '13:00:00', 'normal', '2025-01-15 03:56:22'),
(28, 3, 'wednesday', '07:00:00', '14:00:00', 'normal', '2025-01-15 03:56:22'),
(30, 1, 'tuesday', '08:00:00', '18:00:00', 'normal', '2024-01-15 03:56:22'),
(31, 1, 'wednesday', '07:00:00', '18:00:00', 'normal', '2025-03-07 07:27:51'),
(33, 6, 'monday', '08:30:00', '12:00:00', 'normal', '2025-02-19 22:38:33'),
(34, 6, 'tuesday', '09:30:00', '12:00:00', 'normal', '2025-02-19 22:38:49'),
(35, 6, 'friday', '13:00:00', '16:30:00', 'normal', '2025-02-19 22:40:20'),
(38, 1, 'monday', '07:00:00', '17:00:00', 'normal', '2024-01-15 05:22:34'),
(39, 1, 'tuesday', '07:00:00', '18:00:00', 'normal', '2025-03-07 07:12:26'),
(42, 1, 'thursday', '07:00:00', '18:00:00', 'normal', '2025-03-07 07:28:47'),
(47, 1, 'monday', '07:00:00', '18:00:00', 'normal', '2025-03-07 08:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblsection`
--

CREATE TABLE `tblsection` (
  `sectionId` int(11) NOT NULL,
  `course` varchar(60) NOT NULL,
  `year_level` varchar(60) NOT NULL,
  `section` varchar(60) NOT NULL,
  `section_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archive, 1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsection`
--

INSERT INTO `tblsection` (`sectionId`, `course`, `year_level`, `section`, `section_status`) VALUES
(1, 'BSCS', '1st year', 'B', 0),
(2, 'BSIT', '1st year', 'B', 0),
(3, 'BSIT', '2nd year', 'A', 1),
(4, 'BSIT', '1st year', 'K', 0),
(5, 'BSIT', '4th Year', 'A', 1),
(6, 'BSIT', '2nd Year', 'B', 1),
(7, 'BSCS', '1st Year', 'A', 1),
(8, 'BSIT', '3rd Year', 'C', 1),
(10, 'BSIT', '2nd Year', 'Z', 1),
(11, 'BSBA', '1st Year', '12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblworkschedule`
--

CREATE TABLE `tblworkschedule` (
  `ws_id` int(11) NOT NULL,
  `ws_schedule_id` int(11) NOT NULL,
  `ws_sectionId` int(11) NOT NULL,
  `ws_roomCode` varchar(60) NOT NULL,
  `ws_CurriculumID` int(11) NOT NULL,
  `ws_subtStartTimeAssign` time NOT NULL,
  `ws_subtEndTimeAssign` time NOT NULL,
  `ws_typeOfWork` varchar(60) NOT NULL,
  `ws_ol_request_status` varchar(60) DEFAULT NULL,
  `ws_status` varchar(60) NOT NULL DEFAULT 'regular_work'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblworkschedule`
--

INSERT INTO `tblworkschedule` (`ws_id`, `ws_schedule_id`, `ws_sectionId`, `ws_roomCode`, `ws_CurriculumID`, `ws_subtStartTimeAssign`, `ws_subtEndTimeAssign`, `ws_typeOfWork`, `ws_ol_request_status`, `ws_status`) VALUES
(113, 30, 8, 'ROOM 1', 12, '08:30:00', '10:00:00', 'Teaching Work', NULL, 'regular_work'),
(115, 22, 7, 'ROOM 2', 14, '07:00:00', '10:00:00', 'Teaching Work', NULL, 'regular_work'),
(127, 47, 7, 'ROOM 101', 422, '07:00:00', '15:00:00', 'Teaching Work', NULL, 'regular_work'),
(131, 39, 11, 'ROOM 101', 422, '13:00:00', '16:00:00', 'Teaching Work', NULL, 'regular_work');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `tblcurriculum`
--
ALTER TABLE `tblcurriculum`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `tblfacultymember`
--
ALTER TABLE `tblfacultymember`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `tblotherworkschedule`
--
ALTER TABLE `tblotherworkschedule`
  ADD PRIMARY KEY (`ows_id`),
  ADD KEY `ows_schedule_id` (`ows_schedule_id`);

--
-- Indexes for table `tblschedule`
--
ALTER TABLE `tblschedule`
  ADD PRIMARY KEY (`sched_id`),
  ADD KEY `sched_teacher_id` (`sched_teacher_id`);

--
-- Indexes for table `tblsection`
--
ALTER TABLE `tblsection`
  ADD PRIMARY KEY (`sectionId`);

--
-- Indexes for table `tblworkschedule`
--
ALTER TABLE `tblworkschedule`
  ADD PRIMARY KEY (`ws_id`),
  ADD KEY `ws_schedule_id` (`ws_schedule_id`),
  ADD KEY `ws_CurriculumID` (`ws_CurriculumID`),
  ADD KEY `ws_sectionId` (`ws_sectionId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcurriculum`
--
ALTER TABLE `tblcurriculum`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT for table `tblfacultymember`
--
ALTER TABLE `tblfacultymember`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblotherworkschedule`
--
ALTER TABLE `tblotherworkschedule`
  MODIFY `ows_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblschedule`
--
ALTER TABLE `tblschedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tblsection`
--
ALTER TABLE `tblsection`
  MODIFY `sectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblworkschedule`
--
ALTER TABLE `tblworkschedule`
  MODIFY `ws_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblotherworkschedule`
--
ALTER TABLE `tblotherworkschedule`
  ADD CONSTRAINT `tblotherworkschedule_ibfk_1` FOREIGN KEY (`ows_schedule_id`) REFERENCES `tblschedule` (`sched_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblschedule`
--
ALTER TABLE `tblschedule`
  ADD CONSTRAINT `tblschedule_ibfk_1` FOREIGN KEY (`sched_teacher_id`) REFERENCES `tblfacultymember` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblworkschedule`
--
ALTER TABLE `tblworkschedule`
  ADD CONSTRAINT `tblworkschedule_ibfk_1` FOREIGN KEY (`ws_schedule_id`) REFERENCES `tblschedule` (`sched_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblworkschedule_ibfk_2` FOREIGN KEY (`ws_CurriculumID`) REFERENCES `tblcurriculum` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblworkschedule_ibfk_3` FOREIGN KEY (`ws_sectionId`) REFERENCES `tblsection` (`sectionId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
