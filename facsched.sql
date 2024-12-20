-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 10:00 AM
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
(1, 'joshua', '', 'padilla', 'andersonandy046@gmail.com', 'andersonandy046@gmail.com', 1);

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
(3, 'CP2', 'Capstone ', 1, 0, 3, 2, 4, 1);

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
  `Password` varchar(60) DEFAULT NULL,
  `teacher_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archive,1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfacultymember`
--

INSERT INTO `tblfacultymember` (`teacher_id`, `ID_code`, `fname`, `mname`, `lname`, `designation`, `Password`, `teacher_status`) VALUES
(1, '0002', 'Joshua', 'Raymundo', 'Padilla', 'Instructor II', '0002', 1),
(2, '0003', 'Juan', '', 'Dela cruz', 'Part Time', 'Dela cruz', 0),
(3, '0004', 'andy', '', 'padilla', 'Instructor II', 'padilla', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsection`
--

CREATE TABLE `tblsection` (
  `sectionId` int(11) NOT NULL,
  `course` varchar(60) NOT NULL,
  `year_level` varchar(60) NOT NULL,
  `section` varchar(60) NOT NULL,
  `section_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=disable, 1=enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsection`
--

INSERT INTO `tblsection` (`sectionId`, `course`, `year_level`, `section`, `section_status`) VALUES
(1, 'course 10', '1st year', 'B', 1),
(2, 'BSIT', '1st year', 'B', 0),
(3, 'BSIT', '2nd year', 'A', 1),
(4, 'BSIT', '1st year', 'K', 0);

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
-- Indexes for table `tblsection`
--
ALTER TABLE `tblsection`
  ADD PRIMARY KEY (`sectionId`);

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
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblfacultymember`
--
ALTER TABLE `tblfacultymember`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblsection`
--
ALTER TABLE `tblsection`
  MODIFY `sectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
