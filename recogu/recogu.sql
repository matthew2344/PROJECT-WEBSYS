-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2022 at 10:33 AM
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
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `sid`, `type`) VALUES
(1, 202200023, 'Janitor'),
(2, 202200024, 'Janitor'),
(4, 202200026, 'Janitor'),
(7, 202200039, 'Security');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `yearlvl` varchar(250) NOT NULL,
  `section` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `sid`, `yearlvl`, `section`) VALUES
(1, 202200003, 'PRE-SCHOOL', 'A'),
(2, 202200004, 'GRADE-02', 'A'),
(3, 202200005, 'PRE-SCHOOL', 'A'),
(4, 202200006, 'GRADE-08', 'A'),
(5, 202200007, 'PRE-SCHOOL', 'A'),
(6, 202200008, 'GRADE-10', 'A'),
(7, 202200009, 'GRADE-10', 'A'),
(8, 202200010, 'GRADE-02', 'A'),
(9, 202200011, 'KINDERGARTEN', 'A'),
(10, 202200012, 'GRADE-09', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `yearlvl` varchar(250) NOT NULL,
  `masterclass` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `tid`, `yearlvl`, `masterclass`) VALUES
(1, 202200013, 'GRADE-05', 'A'),
(2, 202200014, 'GRADE-06', 'A'),
(3, 202200015, 'PRE-SCHOOL', 'A'),
(4, 202200016, 'GRADE-07', 'A'),
(5, 202200017, 'KINDERGARTEN', 'A'),
(6, 202200018, 'GRADE-04', 'A'),
(7, 202200019, 'GRADE-10', 'A'),
(8, 202200020, 'GRADE-09', 'A'),
(9, 202200021, 'GRADE-08', 'A'),
(10, 202200022, 'GRADE-03', 'A');

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
(202200002, 'Jim', 'Halpert', 'Krasinski', 'Admin', 'profile_pic.jpg', 'jim@gmail.com', '35273b471f0b1eac7846c3c38e8de563fd95d66f', '2022-07-15', 0, ''),
(202200003, 'Crocetta', 'Nguyen', 'Lin', 'Student', 'kid1.jpg', '202200003@email.com', '87d394c95ac08abe11d913d18cd94c356eb9c807', '2022-07-15', 0, ''),
(202200004, 'Asena', 'Anni', 'Chanda', 'Student', 'kid2.jpg', '202200004@email.com', '648062f7b7c632a8503cf9a78fc819cb708bb820', '2022-07-15', 0, ''),
(202200005, 'Fredrik', 'Suleyman', 'Costin', 'Student', 'kid3.jpg', '202200005@email.com', 'e6f13ff93cc80c8b48021ff62176da22da706584', '2022-07-15', 0, ''),
(202200006, 'Alissa', 'Lilija', 'Magda', 'Student', 'kid4.jpg', '202200006@email.com', '816c9623dbfc2a134aabd6d60e98385d3e20b693', '2022-07-15', 0, ''),
(202200007, 'Abiel', 'Kanidas', 'Anik', 'Student', 'kid5.jpg', '202200007@email.com', '50f24ca7bd3a3aedb82a484a6fe6d78b4b3a38d0', '2022-07-15', 0, ''),
(202200008, 'Annette', 'Doris', 'Stefania', 'Student', 'kid6.jpg', '202200008@email.com', 'ab06d4a2060a2052c634014a8dabd74dab20f8b1', '2022-07-15', 0, ''),
(202200009, 'Sophie', 'Monta', 'Racheal', 'Student', 'kid7.jpg', '202200009@email.com', '35273b471f0b1eac7846c3c38e8de563fd95d66f', '2022-07-16', 0, ''),
(202200010, 'Iside', 'Selah', 'Ryley', 'Student', 'kid8.jpg', '202200010@email.com', 'ecb748bfb758d1cf9462f75b8f6a375d6bea1cef', '2022-07-16', 0, ''),
(202200011, 'Ema', 'Sasithorn', 'Marlena', 'Student', 'kid9.jpg', '202200011@email.com', 'c79c7673418d4886c79b50b03df84377d1d5a5b2', '2022-07-16', 0, ''),
(202200012, 'Julia', 'Serena', 'Manon', 'Student', 'kid10.jpg', '202200012@email.com', '609202216c6f80b9094a22b43ec6c69ec2c2ba55', '2022-07-16', 0, ''),
(202200013, 'Albert', 'Archelaos', 'Vilmar', 'Teacher', 'teacher1.jpg', '202200013@email.com', '638c9363952c7f1e0bdb1682a1602b6d6e7ec17c', '2022-07-16', 0, ''),
(202200014, 'Felix', 'Nurlan', 'Pridon', 'Teacher', 'teacher2.jpg', '202200014@email.com', 'afd08fbd73c5f8fa62ac6845a5ef0b11880923f0', '2022-07-16', 0, ''),
(202200015, 'Carolina', 'Marjana', 'Areti', 'Teacher', 'teacher3.jpg', '202200015@email.com', 'f661e33be5ea4862c60959d6e165b8f78c1c7b6e', '2022-07-16', 0, ''),
(202200016, 'Alexis', 'Walhberct', 'Burkhard', 'Teacher', 'teacher4.jpg', '202200016@email.com', 'f954d4b32d7a7dacfb0190938a1a57ade6e4adf3', '2022-07-16', 0, ''),
(202200017, 'Starla', 'Vyara', 'Sandra', 'Teacher', 'teacher5.jpg', '202200017@email.com', '1180afc291203bf6264af38982157b41d1be8d66', '2022-07-16', 0, ''),
(202200018, 'Daichi', 'Yann', 'Ouranos', 'Teacher', 'teacher6.jpg', '202200018@email.com', '016bb4ead889b4e5cbebc0219a7c56416ea318ca', '2022-07-16', 0, ''),
(202200019, 'Marianne', '', 'Stina', 'Teacher', 'teacher7.jpg', '202200019@email.com', 'c40889e8ceb4f2c9cd6c604bbdab3d2fcd29470c', '2022-07-16', 0, ''),
(202200020, 'Lebanah', 'Mukesha', 'Shemuel', 'Teacher', 'teacher8.jpg', '202200020@email.com', '1d052acdb04abaa92bab3b2f18da8847d70a4a9a', '2022-07-16', 0, ''),
(202200021, 'Hanako', 'Sachie', 'Akiko', 'Teacher', 'teacher9.jpg', '202200021@email.com', '0dfdd5cc4bd3e2fd539b64496c9d988911524b07', '2022-07-16', 0, ''),
(202200022, 'Ron', 'Jarod', 'Theobold', 'Teacher', 'teacher10.jpg', '202200022@email.com', '7555b2ac5460d2ded955e3d44080b01fa3669225', '2022-07-16', 0, ''),
(202200023, 'El', 'Chibuike', 'Risteard', 'Staff', 'staff1.jpg', '202200023@email.com', '6339a10a5988c2dfa6a7e217eff7ea1f84148b5d', '2022-07-16', 0, ''),
(202200024, 'Eli', 'Neha', 'Edita', 'Staff', 'staff2.jpg', '202200024@email.com', '8fbef6a5d1baa3c3a247bf00ed08194a6d40430a', '2022-07-16', 0, ''),
(202200026, 'Elma', 'Dela cruz', 'Santos', 'Staff', 'staff4.jpg', '202200026@email.com', '44bb70d6aee4e8839b2c287b889b2e730c1f7e42', '2022-07-16', 0, ''),
(202200039, 'Arturo', 'Mantemayen', 'Gari', 'Staff', 'staff6.jpg', '202200039@email.com', '88a69fe15182c45513937d9cc31a50b0f320a9d6', '2022-07-20', 0, ''),
(202200041, 'Matthew', 'Andre', 'Butalid', 'Admin', 'profile_pic.jpg', 'matthewandrebutalid@gmail.com', '35273b471f0b1eac7846c3c38e8de563fd95d66f', '2022-07-21', 1, 'dx0wuoS2WiCqRpQV');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_fk` (`sid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_fk` (`sid`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_fk` (`tid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202200042;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_fk` FOREIGN KEY (`sid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_fk` FOREIGN KEY (`sid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_fk` FOREIGN KEY (`tid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
