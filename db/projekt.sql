-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2022 at 10:24 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ad_date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `lastname`, `email`, `password`, `ad_date_created`) VALUES
(1, 'Projekt', 'Admin', 'projekt@admin.com', '827ccb0eea8a706c4c34a16891f84e7b', '1');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(255) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_code` varchar(255) NOT NULL,
  `cl_date_created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `class_code`, `cl_date_created`) VALUES
(2, 'Class One', 'CL001', '2022-11-21 07:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `class_dates`
--

CREATE TABLE `class_dates` (
  `class_date_id` int(255) NOT NULL,
  `class_id` int(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_dates`
--

INSERT INTO `class_dates` (`class_date_id`, `class_id`, `event_name`, `event_date`) VALUES
(1, 2, 'Final Presentation', '2022-11-30T08:00');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lec_date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `firstname`, `lastname`, `email`, `password`, `lec_date_created`) VALUES
(2, 'Lecturer', 'One', 'lecturerone@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2022-11-21 12:33:27'),
(3, 'Lecturer', 'Two', 'lecturertwo@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2022-11-21 12:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int(255) NOT NULL,
  `progress_name` varchar(255) NOT NULL,
  `progress_desc` text NOT NULL,
  `project_id` int(255) NOT NULL,
  `due_date` varchar(100) NOT NULL,
  `pg_date_created` varchar(100) NOT NULL,
  `progress_comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`progress_id`, `progress_name`, `progress_desc`, `project_id`, `due_date`, `pg_date_created`, `progress_comment`) VALUES
(1, 'Change the literature review', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula.', 1, '2022-11-23T23:58', '2022-11-26T23:58', 'Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.');

-- --------------------------------------------------------

--
-- Table structure for table `progress_files`
--

CREATE TABLE `progress_files` (
  `progress_files_id` int(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `progress_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress_files`
--

INSERT INTO `progress_files` (`progress_files_id`, `file_name`, `progress_id`) VALUES
(1, '2022_11_21_23_00_43Dagim Alemayehu singapore 25-30 Dec 2022.pdf', 1),
(2, '2022_11_21_23_01_07My Simple Skills Map - Skills Map.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `concept` longtext NOT NULL,
  `student_class_id` int(255) NOT NULL,
  `concept_status` varchar(255) NOT NULL DEFAULT 'pending approval',
  `project_status` varchar(255) DEFAULT NULL,
  `pr_date_created` varchar(255) NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `project_comment` text DEFAULT NULL,
  `date_completed` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `concept`, `student_class_id`, `concept_status`, `project_status`, `pr_date_created`, `grade`, `project_comment`, `date_completed`) VALUES
(1, 'DBMS', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.', 2, 'Approved', 'Completed', '', '90', 'Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.', '2022-11-22 01:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `project_messages`
--

CREATE TABLE `project_messages` (
  `proj_msg_id` int(255) NOT NULL,
  `project_id` int(255) NOT NULL,
  `msg_type` int(100) NOT NULL,
  `message` text NOT NULL,
  `ref_id` int(100) DEFAULT 0,
  `msg_status` int(255) NOT NULL DEFAULT 0,
  `date_sent` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_messages`
--

INSERT INTO `project_messages` (`proj_msg_id`, `project_id`, `msg_type`, `message`, `ref_id`, `msg_status`, `date_sent`) VALUES
(1, 1, 0, 'Hello, I am your supervisor for this project. Check the Project Details. Let\'s talk about the project here.', 0, 1, '2022-11-22 09:56:06'),
(2, 1, 0, 'Hello, Did you receive the files I sent via email?', 0, 1, '2022-11-22 10:03:22'),
(3, 1, 1, 'Hello, Yes I did. ', 0, 1, '2022-11-22 10:55:18'),
(4, 1, 1, 'I will go through the examples then let you know if there is any issue.', 0, 1, '2022-11-22 10:56:02'),
(5, 1, 0, 'Okay. Good day.', 0, 1, '2022-11-22 10:56:18'),
(6, 1, 0, 'Bye!', 0, 1, '2022-11-22 10:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `adm_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `st_date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `firstname`, `lastname`, `adm_no`, `password`, `st_date_created`) VALUES
(2, 'Student', 'One', '12345', '827ccb0eea8a706c4c34a16891f84e7b', '2022-11-21 07:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `student_class_id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `class_id` int(255) NOT NULL,
  `sc_date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`student_class_id`, `student_id`, `class_id`, `sc_date_created`) VALUES
(2, 2, 2, 2022);

-- --------------------------------------------------------

--
-- Table structure for table `supervision`
--

CREATE TABLE `supervision` (
  `supervision_id` int(255) NOT NULL,
  `project_id` int(255) NOT NULL,
  `lecturer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supervision`
--

INSERT INTO `supervision` (`supervision_id`, `project_id`, `lecturer_id`) VALUES
(1, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_dates`
--
ALTER TABLE `class_dates`
  ADD PRIMARY KEY (`class_date_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progress_id`);

--
-- Indexes for table `progress_files`
--
ALTER TABLE `progress_files`
  ADD PRIMARY KEY (`progress_files_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_messages`
--
ALTER TABLE `project_messages`
  ADD PRIMARY KEY (`proj_msg_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`student_class_id`);

--
-- Indexes for table `supervision`
--
ALTER TABLE `supervision`
  ADD PRIMARY KEY (`supervision_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class_dates`
--
ALTER TABLE `class_dates`
  MODIFY `class_date_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progress_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `progress_files`
--
ALTER TABLE `progress_files`
  MODIFY `progress_files_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_messages`
--
ALTER TABLE `project_messages`
  MODIFY `proj_msg_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_class`
--
ALTER TABLE `student_class`
  MODIFY `student_class_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supervision`
--
ALTER TABLE `supervision`
  MODIFY `supervision_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
