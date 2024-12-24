-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 09:28 AM
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
  `subject_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archive,1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcurriculum`
--

INSERT INTO `tblcurriculum` (`subject_id`, `subject_code`, `subject_name`, `lab_num`, `lec_num`, `hours`, `semester`, `designated_year_level`, `subject_status`) VALUES
(3, 'CP2', 'Capstone ', 1, 0, 3, 2, 4, 1),
(4, 'ITH', 'Science', 1, 0, 3, 1, 3, 1);

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
(1, '0002', 'Joshua', 'Raymundo', 'Padilla', 'Instructor II', '40', '0002', 1),
(2, '0003', 'Juan', '', 'Dela cruz', 'Part Time', NULL, 'Dela cruz', 0),
(3, '0004', 'andy', '', 'padilla', 'Instructor II', NULL, 'padilla', 1),
(4, '0005', 'Joan', '', 'Panimbangon', 'Part Time', '12', 'Panimbangon', 1),
(5, '0006', 'Mary Loi', '', 'Ricalde', 'Instructor I', '40', 'Ricalde', 1),
(6, '0007', 'April', '', 'De Leon', 'Asst. Prof I', '30', 'De Leon', 1),
(7, '00010', 'james', '', 'bungay', 'Instructor I', '30', 'bungay', 1),
(8, '0008', 'juan ', '', 'delacruz', 'Dean', '40', 'delacruz', 1);

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
  `sched_status` varchar(60) NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblschedule`
--

INSERT INTO `tblschedule` (`sched_id`, `sched_teacher_id`, `sched_day`, `sched_start_Hrs`, `sched_end_Hrs`, `sched_status`) VALUES
(1, 3, 'monday', '08:34:00', '10:34:00', 'normal'),
(3, 3, 'tuesday', '08:37:00', '22:41:00', 'normal'),
(4, 3, 'friday', '09:52:00', '22:52:00', 'normal'),
(5, 1, 'thursday', '09:00:00', '15:00:00', 'normal'),
(6, 1, 'monday', '08:46:00', '20:46:00', 'normal'),
(7, 1, 'wednesday', '07:47:00', '17:00:00', 'normal'),
(8, 1, 'tuesday', '09:51:00', '21:51:00', 'normal'),
(9, 5, 'wednesday', '08:00:00', '16:00:00', 'normal'),
(10, 5, 'monday', '08:00:00', '16:00:00', 'normal'),
(11, 5, 'tuesday', '08:00:00', '16:00:00', 'normal'),
(12, 5, 'thursday', '08:00:00', '16:00:00', 'normal'),
(13, 5, 'friday', '08:00:00', '16:00:00', 'normal'),
(16, 4, 'monday', '07:00:00', '19:00:00', 'normal'),
(17, 6, 'monday', '06:00:00', '17:48:00', 'normal'),
(18, 7, 'monday', '07:15:00', '16:15:00', 'normal'),
(19, 7, 'friday', '08:00:00', '16:00:00', 'normal'),
(20, 7, 'wednesday', '07:00:00', '19:00:00', 'normal'),
(21, 7, 'thursday', '21:00:00', '22:00:00', 'normal');

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
(5, 'BSIT', '4th Year', 'A', 1);

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
  `ws_typeOfWork` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblworkschedule`
--

INSERT INTO `tblworkschedule` (`ws_id`, `ws_schedule_id`, `ws_sectionId`, `ws_roomCode`, `ws_CurriculumID`, `ws_subtStartTimeAssign`, `ws_subtEndTimeAssign`, `ws_typeOfWork`) VALUES
(15, 5, 3, 'room 1', 3, '22:00:00', '23:30:00', 'Teaching Work'),
(16, 5, 3, 'room 123', 4, '00:30:00', '01:30:00', 'Teaching Work'),
(17, 5, 3, 'room 999', 4, '17:00:00', '17:30:00', 'Teaching Work'),
(18, 16, 3, 'room 999', 4, '07:30:00', '08:30:00', 'Teaching Work');

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
  ADD KEY `ws_schedule_id` (`ws_schedule_id`);

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
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblfacultymember`
--
ALTER TABLE `tblfacultymember`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblschedule`
--
ALTER TABLE `tblschedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblsection`
--
ALTER TABLE `tblsection`
  MODIFY `sectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblworkschedule`
--
ALTER TABLE `tblworkschedule`
  MODIFY `ws_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblschedule`
--
ALTER TABLE `tblschedule`
  ADD CONSTRAINT `tblschedule_ibfk_1` FOREIGN KEY (`sched_teacher_id`) REFERENCES `tblfacultymember` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblworkschedule`
--
ALTER TABLE `tblworkschedule`
  ADD CONSTRAINT `tblworkschedule_ibfk_1` FOREIGN KEY (`ws_schedule_id`) REFERENCES `tblschedule` (`sched_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
