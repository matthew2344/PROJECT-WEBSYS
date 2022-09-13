-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2022 at 11:29 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recogu`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_level` varchar(255) NOT NULL,
  `max_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classID`, `name`, `year_level`, `max_capacity`) VALUES
(6, 'TW35', 'PRESCHOOL', 30),
(7, 'TW36', 'KINDERGARTEN', 30),
(8, 'TW37', 'GRADE-1', 30),
(9, 'TW38', 'GRADE-2', 30),
(10, 'TW39', 'GRADE-3', 30),
(11, 'TW40', 'GRADE-4', 30),
(12, 'TW41', 'GRADE-5', 30),
(13, 'TW42', 'GRADE-6', 30),
(14, 'TW43', 'GRADE-7', 30),
(15, 'TW44', 'GRADE-8', 30),
(16, 'TW45', 'GRADE-9', 30),
(17, 'TW46', 'GRADE-10', 30);

-- --------------------------------------------------------

--
-- Table structure for table `dataset`
--

CREATE TABLE `dataset` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `upload_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gate_logs`
--

CREATE TABLE `gate_logs` (
  `gatelogsID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `userID`) VALUES
(1, 202200003),
(2, 202200004),
(3, 202200027),
(4, 202200028);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `yearlvl` varchar(250) NOT NULL,
  `section` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `userID`, `yearlvl`, `section`) VALUES
(1, 202200005, 'GRADE-2', '9'),
(2, 202200006, 'PRESCHOOL', '6'),
(3, 202200007, 'PRESCHOOL', '6'),
(4, 202200008, 'GRADE-8', '15'),
(5, 202200009, 'PRESCHOOL', '6'),
(6, 202200010, 'GRADE-10', '17'),
(7, 202200011, 'GRADE-10', '17'),
(8, 202200012, 'GRADE-2', '9'),
(9, 202200013, 'KINDERGARTEN', '7'),
(10, 202200014, 'GRADE-9', '16');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `title` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacherID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `masterclass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacherID`, `userID`, `masterclass`) VALUES
(1, 202200015, 12),
(2, 202200016, 13),
(3, 202200017, 6),
(4, 202200018, 14),
(5, 202200019, 7),
(6, 202200020, 11),
(7, 202200021, 17),
(8, 202200022, 16),
(9, 202200023, 15),
(10, 202200024, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `mname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `avatar` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `datecreated` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `activation_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `mname`, `lname`, `type`, `avatar`, `email`, `password`, `datecreated`, `status`, `activation_code`) VALUES
(202200001, 'ADMIN', 'ADMIN', 'ADMIN', 'Admin', 'profile_pic.jpg', 'admin@email.com', '35273b471f0b1eac7846c3c38e8de563fd95d66f', '2022-08-04', 1, 'asd'),
(202200002, 'Matthew Andre', 'Macoco', 'Butalid', 'Admin', 'profile_pic.jpg', 'matthewandrebutalid@gmail.com', '35273b471f0b1eac7846c3c38e8de563fd95d66f', '2022-08-04', 1, 'trTLcFReVibzgf8Q'),
(202200003, 'El', 'Chibuike', 'Risteard', 'Staff', 'staff1.jpg', '202200003@email.com', '87d394c95ac08abe11d913d18cd94c356eb9c807', '2022-08-09', 0, ''),
(202200004, 'Eli', 'Neha', 'Edita', 'Staff', 'staff2.jpg', '202200004@email.com', '648062f7b7c632a8503cf9a78fc819cb708bb820', '2022-08-09', 0, ''),
(202200005, 'Asena', 'Anni', 'Chanda', 'Student', 'kid2.jpg', '202200005@email.com', 'e6f13ff93cc80c8b48021ff62176da22da706584', '2022-08-17', 0, ''),
(202200006, 'Crocetta', 'Nguyen', 'Lin', 'Student', 'kid1.jpg', '202200006@email.com', '816c9623dbfc2a134aabd6d60e98385d3e20b693', '2022-08-17', 0, ''),
(202200007, 'Fredrik', 'Suleyman', 'Costin', 'Student', 'kid3.jpg', '202200007@email.com', '50f24ca7bd3a3aedb82a484a6fe6d78b4b3a38d0', '2022-08-17', 0, ''),
(202200008, 'Alissa', 'Lilija', 'Magda', 'Student', 'kid4.jpg', '202200008@email.com', 'ab06d4a2060a2052c634014a8dabd74dab20f8b1', '2022-08-17', 0, ''),
(202200009, 'Abiel', 'Kanidas', 'Anik', 'Student', 'kid5.jpg', '202200009@email.com', '6767c72b1acac9e5d60f4ee0153f9f586fa4f16f', '2022-08-17', 0, ''),
(202200010, 'Annette', 'Doris', 'Stefania', 'Student', 'kid6.jpg', '202200010@email.com', 'ecb748bfb758d1cf9462f75b8f6a375d6bea1cef', '2022-08-17', 0, ''),
(202200011, 'Sophie', 'Monta ', 'Racheal', 'Student', 'kid7.jpg', '202200011@email.com', 'c79c7673418d4886c79b50b03df84377d1d5a5b2', '2022-08-17', 0, ''),
(202200012, 'Iside', 'Selah', 'Ryley', 'Student', 'kid8.jpg', '202200012@email.com', '609202216c6f80b9094a22b43ec6c69ec2c2ba55', '2022-08-17', 0, ''),
(202200013, 'Ema', 'Sasithorn', 'Marlena', 'Student', 'kid9.jpg', '202200013@email.com', '638c9363952c7f1e0bdb1682a1602b6d6e7ec17c', '2022-08-17', 0, ''),
(202200014, 'Julia', 'Serena', 'Manon', 'Student', 'kid10.jpg', '202200014@email.com', 'afd08fbd73c5f8fa62ac6845a5ef0b11880923f0', '2022-08-17', 0, ''),
(202200015, 'Albert', 'Archelaos', 'Vilmar', 'Teacher', 'teacher1.jpg', '202200015@email.com', 'f661e33be5ea4862c60959d6e165b8f78c1c7b6e', '2022-08-25', 0, ''),
(202200016, 'Felix', 'Nurlan', 'Pridon', 'Teacher', 'teacher2.jpg', '202200016@email.com', 'f954d4b32d7a7dacfb0190938a1a57ade6e4adf3', '2022-08-25', 0, ''),
(202200017, 'Carolina', 'Marjana', 'Areti', 'Teacher', 'teacher3.jpg', '202200017@email.com', '1180afc291203bf6264af38982157b41d1be8d66', '2022-08-25', 0, ''),
(202200018, 'Alexis', 'Walhberct', 'Burkhard', 'Teacher', 'teacher4.jpg', '202200018@email.com', '016bb4ead889b4e5cbebc0219a7c56416ea318ca', '2022-08-25', 0, ''),
(202200019, 'Starla', 'Vyara', 'Sandra', 'Teacher', 'teacher5.jpg', '202200019@email.com', 'c40889e8ceb4f2c9cd6c604bbdab3d2fcd29470c', '2022-08-25', 0, ''),
(202200020, 'Daichi', 'Yann', 'Ouranos', 'Teacher', 'teacher6.jpg', '202200020@email.com', '1d052acdb04abaa92bab3b2f18da8847d70a4a9a', '2022-08-25', 0, ''),
(202200021, 'Marianne', '', 'Stina', 'Teacher', 'teacher7.jpg', '202200021@email.com', '0dfdd5cc4bd3e2fd539b64496c9d988911524b07', '2022-08-25', 0, ''),
(202200022, 'Lebanah', 'Mukesha', 'Shemuel', 'Teacher', 'teacher8.jpg', '202200022@email.com', '7555b2ac5460d2ded955e3d44080b01fa3669225', '2022-08-25', 0, ''),
(202200023, 'Hanako', 'Sachie', 'Akiko', 'Teacher', 'teacher9.jpg', '202200023@email.com', '6339a10a5988c2dfa6a7e217eff7ea1f84148b5d', '2022-08-25', 0, ''),
(202200024, 'Ron', 'Jarod', 'Theobold', 'Teacher', 'teacher10.jpg', '202200024@email.com', '8fbef6a5d1baa3c3a247bf00ed08194a6d40430a', '2022-08-25', 0, ''),
(202200027, 'Lara', 'Cluadina', 'Blodwen', 'Janitor', 'staff31.jpg', '202200027@email.com', '8736ea7b9967d7bca55826aaa0f5d56b61b17f65', '2022-08-26', 0, ''),
(202200028, 'Elma', 'Dela cruz', 'Santos', 'Cook', 'staff4.jpg', '202200028@email.com', 'd2fbdf7e703cb1d4ca79c3a83808bafdcc954169', '2022-08-26', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classID`);

--
-- Indexes for table `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dataset_fk` (`uid`);

--
-- Indexes for table `gate_logs`
--
ALTER TABLE `gate_logs`
  ADD PRIMARY KEY (`gatelogsID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `staff_fk` (`userID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `student_fk` (`userID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherID`),
  ADD KEY `teacher_fk` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gate_logs`
--
ALTER TABLE `gate_logs`
  MODIFY `gatelogsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202200029;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dataset`
--
ALTER TABLE `dataset`
  ADD CONSTRAINT `dataset_fk` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_fk` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_fk` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_fk` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
