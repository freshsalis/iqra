-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 06, 2023 at 10:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iqra`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_token`
--

CREATE TABLE `access_token` (
  `token_id` int(11) NOT NULL,
  `token` varchar(75) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adid` int(11) NOT NULL,
  `staff_name` varchar(70) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `pre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adid`, `staff_name`, `username`, `password`, `pre`) VALUES
(5, 'Fresh salis bako', 'salis', 'u14cs2094', '1'),
(6, 'Administrator ', 'admin', '1234', '2'),
(7, 'Fresh Admin', 'fresh', '1234', '3');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `stdid` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time_in` datetime NOT NULL DEFAULT current_timestamp(),
  `time_out` datetime DEFAULT NULL,
  `session_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `classname` varchar(70) NOT NULL DEFAULT '',
  `classteacher` varchar(70) NOT NULL DEFAULT 'NAN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `classname`, `classteacher`) VALUES
(95, '200 LEVEL', 'Idris'),
(98, '100 Level', 'Salis Fresh'),
(103, '300 LEVEL', 'NA'),
(104, '400 LEVEL', 'NA'),
(108, '500 LEVEL', 'NAN');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Disabled',
  `session` varchar(15) NOT NULL,
  `instruction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examiners`
--

CREATE TABLE `examiners` (
  `examiner_id` int(11) NOT NULL,
  `username` varchar(75) NOT NULL,
  `name` varchar(155) NOT NULL,
  `password` varchar(75) NOT NULL,
  `paper_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_question`
--

CREATE TABLE `other_question` (
  `question_id` int(11) NOT NULL,
  `question_name` text NOT NULL,
  `paper_id` int(225) NOT NULL,
  `mark1` double NOT NULL,
  `mark2` double NOT NULL,
  `mark3` double NOT NULL,
  `mark4` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE `papers` (
  `paper_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `paper_type_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `question_per_stud` int(11) NOT NULL DEFAULT 30,
  `status` varchar(15) NOT NULL DEFAULT 'Disabled',
  `instant_result` int(11) NOT NULL DEFAULT 0,
  `earnable_score` int(11) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 1,
  `batches` int(11) NOT NULL DEFAULT 1,
  `instruction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paper_type`
--

CREATE TABLE `paper_type` (
  `paper_type_id` int(11) NOT NULL,
  `type_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paper_type`
--

INSERT INTO `paper_type` (`paper_type_id`, `type_name`) VALUES
(1, 'Objectives'),
(2, 'CAOSCE');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `question_name` text NOT NULL,
  `question_type` int(11) NOT NULL DEFAULT 1,
  `diagram` blob DEFAULT NULL,
  `paper_id` int(225) NOT NULL,
  `answer1` text NOT NULL,
  `answer2` text NOT NULL,
  `answer3` text NOT NULL,
  `answer4` text NOT NULL,
  `answer` varchar(100) NOT NULL,
  `section` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE `question_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_student`
--

CREATE TABLE `schedule_student` (
  `stdid` int(11) NOT NULL,
  `reg_no` varchar(25) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `othername` varchar(75) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `dept` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stdid` int(11) NOT NULL,
  `fullname` varchar(225) NOT NULL,
  `username` varchar(70) NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_question`
--

CREATE TABLE `sub_question` (
  `sub_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `time` int(11) NOT NULL,
  `question_per_stud` int(11) NOT NULL DEFAULT 30,
  `status` varchar(15) NOT NULL DEFAULT 'Disabled',
  `instant_result` int(11) NOT NULL DEFAULT 0,
  `earnable_score` int(11) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 1,
  `components` int(11) NOT NULL,
  `question_per_component` varchar(15) NOT NULL,
  `session` varchar(15) NOT NULL,
  `batches` int(11) NOT NULL DEFAULT 1,
  `instruction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testscore`
--

CREATE TABLE `testscore` (
  `ID` int(11) NOT NULL,
  `stdid` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `right_answered` float NOT NULL,
  `wrong_answer` int(11) NOT NULL,
  `unanswered` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_attempt`
--

CREATE TABLE `test_attempt` (
  `atid` int(11) NOT NULL,
  `stdid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `ans` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `track_timer`
--

CREATE TABLE `track_timer` (
  `rowId` int(11) NOT NULL,
  `stdId` int(10) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_token`
--
ALTER TABLE `access_token`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `token_2` (`token`),
  ADD KEY `token` (`token`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adid`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `stdid` (`stdid`,`paper_id`),
  ADD KEY `exam_id` (`paper_id`),
  ADD KEY `paper_id` (`paper_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `examiners`
--
ALTER TABLE `examiners`
  ADD PRIMARY KEY (`examiner_id`),
  ADD KEY `reg_no` (`username`,`paper_id`),
  ADD KEY `paper_id` (`paper_id`),
  ADD KEY `exam_id` (`paper_id`);

--
-- Indexes for table `other_question`
--
ALTER TABLE `other_question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `test_id` (`paper_id`);

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`paper_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `paper_type_id` (`paper_type_id`);

--
-- Indexes for table `paper_type`
--
ALTER TABLE `paper_type`
  ADD PRIMARY KEY (`paper_type_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `test_id` (`paper_id`,`section`);

--
-- Indexes for table `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `schedule_student`
--
ALTER TABLE `schedule_student`
  ADD PRIMARY KEY (`stdid`),
  ADD KEY `reg_no` (`reg_no`,`exam_id`),
  ADD KEY `paper_id` (`exam_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stdid`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `sub_question`
--
ALTER TABLE `sub_question`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `question_id` (`question_id`,`stud_id`,`paper_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `testscore`
--
ALTER TABLE `testscore`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `stdid` (`stdid`,`paper_id`),
  ADD KEY `exam_id` (`paper_id`);

--
-- Indexes for table `test_attempt`
--
ALTER TABLE `test_attempt`
  ADD PRIMARY KEY (`atid`),
  ADD KEY `stdid` (`stdid`),
  ADD KEY `quid` (`quid`);

--
-- Indexes for table `track_timer`
--
ALTER TABLE `track_timer`
  ADD PRIMARY KEY (`rowId`),
  ADD KEY `stdId` (`stdId`,`paper_id`),
  ADD KEY `paper_id` (`paper_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_token`
--
ALTER TABLE `access_token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examiners`
--
ALTER TABLE `examiners`
  MODIFY `examiner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_question`
--
ALTER TABLE `other_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `paper_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paper_type`
--
ALTER TABLE `paper_type`
  MODIFY `paper_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_type`
--
ALTER TABLE `question_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_student`
--
ALTER TABLE `schedule_student`
  MODIFY `stdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `stdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_question`
--
ALTER TABLE `sub_question`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testscore`
--
ALTER TABLE `testscore`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_attempt`
--
ALTER TABLE `test_attempt`
  MODIFY `atid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `track_timer`
--
ALTER TABLE `track_timer`
  MODIFY `rowId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
