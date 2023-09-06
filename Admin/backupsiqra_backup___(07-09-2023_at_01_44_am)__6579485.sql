

CREATE TABLE `admin` (
  `adid` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(70) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `pre` varchar(40) NOT NULL,
  PRIMARY KEY (`adid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO admin VALUES
("5","Fresh salis bako","salis","u14cs2094","1"),
("6","Administrator ","admin","1234","2"),
("7","Fresh Admin","fresh","1234","3");




CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `stdid` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time_in` datetime NOT NULL DEFAULT current_timestamp(),
  `time_out` datetime DEFAULT NULL,
  `session_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`attendance_id`),
  KEY `stdid` (`stdid`,`paper_id`),
  KEY `exam_id` (`paper_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;






CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(70) NOT NULL DEFAULT '',
  `classteacher` varchar(70) NOT NULL DEFAULT 'NAN',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO class VALUES
("95","200 LEVEL","Idris"),
("98","100 Level","Salis Fresh"),
("103","300 LEVEL","NA"),
("104","400 LEVEL","NA"),
("108","500 LEVEL","NAN");




CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Disabled',
  `session` varchar(15) NOT NULL,
  `instruction` text NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `examiners` (
  `examiner_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(75) NOT NULL,
  `name` varchar(155) NOT NULL,
  `password` varchar(75) NOT NULL,
  `paper_id` int(11) NOT NULL,
  PRIMARY KEY (`examiner_id`),
  KEY `reg_no` (`username`,`paper_id`),
  KEY `paper_id` (`paper_id`),
  KEY `exam_id` (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `papers` (
  `paper_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `instruction` text NOT NULL,
  PRIMARY KEY (`paper_id`),
  KEY `exam_id` (`exam_id`),
  KEY `paper_type_id` (`paper_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` text NOT NULL,
  `question_type` int(11) NOT NULL DEFAULT 1,
  `diagram` blob DEFAULT NULL,
  `paper_id` int(225) NOT NULL,
  `answer1` text NOT NULL,
  `answer2` text NOT NULL,
  `answer3` text NOT NULL,
  `answer4` text NOT NULL,
  `answer` varchar(100) NOT NULL,
  `section` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`question_id`),
  KEY `test_id` (`paper_id`,`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE `question_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(250) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE `schedule_student` (
  `stdid` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(25) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `othername` varchar(75) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `dept` varchar(75) NOT NULL,
  PRIMARY KEY (`stdid`),
  KEY `reg_no` (`reg_no`,`exam_id`),
  KEY `paper_id` (`exam_id`),
  KEY `exam_id` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `student` (
  `stdid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(225) NOT NULL,
  `username` varchar(70) NOT NULL,
  `class_id` int(11) NOT NULL,
  `dept` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `status` varchar(11) NOT NULL,
  PRIMARY KEY (`stdid`),
  UNIQUE KEY `username_2` (`username`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `sub_question` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  PRIMARY KEY (`sub_id`),
  KEY `question_id` (`question_id`,`stud_id`,`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `instruction` text NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `test_attempt` (
  `atid` int(11) NOT NULL AUTO_INCREMENT,
  `stdid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `ans` varchar(30) NOT NULL,
  PRIMARY KEY (`atid`),
  KEY `stdid` (`stdid`),
  KEY `quid` (`quid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `testscore` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `stdid` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `right_answered` float NOT NULL,
  `wrong_answer` int(11) NOT NULL,
  `unanswered` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  KEY `stdid` (`stdid`,`paper_id`),
  KEY `exam_id` (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `track_timer` (
  `rowId` int(11) NOT NULL AUTO_INCREMENT,
  `stdId` int(10) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`rowId`),
  KEY `stdId` (`stdId`,`paper_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;




