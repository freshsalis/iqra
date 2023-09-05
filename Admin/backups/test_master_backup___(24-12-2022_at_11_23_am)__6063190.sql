

CREATE TABLE `admin` (
  `adid` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(70) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `pre` varchar(40) NOT NULL,
  PRIMARY KEY (`adid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


INSERT INTO admin VALUES
("5","Fresh salis bako","salis","u14cs2094","1"),
("6","Administrator ","admin","fedutse@123","2"),
("7","Fresh Admin","fresh","1234","3");




CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `stdid` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time_in` datetime NOT NULL DEFAULT current_timestamp(),
  `time_out` datetime DEFAULT NULL,
  `session_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`attendance_id`),
  KEY `stdid` (`stdid`,`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;






CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(70) NOT NULL DEFAULT '',
  `classteacher` varchar(70) NOT NULL DEFAULT 'NAN',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;


INSERT INTO class VALUES
("95","200 LEVEL","Idris"),
("98","100 Level","Salis Fresh"),
("103","300 LEVEL","NA"),
("104","400 LEVEL","NA"),
("108","500 LEVEL","NAN");




CREATE TABLE `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` text COLLATE utf8_unicode_ci NOT NULL,
  `question_type` int(11) NOT NULL DEFAULT 1,
  `diagram` blob DEFAULT NULL,
  `test_id` int(225) NOT NULL,
  `answer1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `section` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`question_id`),
  KEY `test_id` (`test_id`,`section`)
) ENGINE=InnoDB AUTO_INCREMENT=972 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE `question_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE `schedule_student` (
  `stdid` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(25) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `othername` varchar(75) NOT NULL,
  `test_id` int(11) NOT NULL,
  `dept` varchar(75) NOT NULL,
  `batch` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`stdid`),
  KEY `reg_no` (`reg_no`,`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7244 DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `sub_question` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  PRIMARY KEY (`sub_id`),
  KEY `question_id` (`question_id`,`stud_id`,`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=583 DEFAULT CHARSET=latin1;






CREATE TABLE `test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `class_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `question_per_stud` int(11) NOT NULL DEFAULT 30,
  `start_time` varchar(75) NOT NULL,
  `stop_time` varchar(75) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;






CREATE TABLE `test_attempt` (
  `atid` int(11) NOT NULL AUTO_INCREMENT,
  `stdid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `ans` varchar(30) NOT NULL,
  PRIMARY KEY (`atid`),
  KEY `stdid` (`stdid`),
  KEY `quid` (`quid`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=latin1;






CREATE TABLE `testscore` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `stdid` int(11) NOT NULL,
  `testid` int(11) NOT NULL,
  `right_answered` int(11) NOT NULL,
  `wrong_answer` int(11) NOT NULL,
  `unanswered` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  KEY `stdid` (`stdid`,`testid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;






CREATE TABLE `track_timer` (
  `rowId` int(11) NOT NULL AUTO_INCREMENT,
  `stdId` int(10) NOT NULL,
  `test_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`rowId`),
  KEY `stdId` (`stdId`,`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;




