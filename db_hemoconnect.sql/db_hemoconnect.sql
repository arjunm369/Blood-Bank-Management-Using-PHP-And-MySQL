-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2023 at 04:55 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_hemoconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) NOT NULL auto_increment,
  `admin_name` varchar(25) NOT NULL,
  `admin_email` varchar(30) NOT NULL,
  `admin_password` varchar(25) NOT NULL,
  PRIMARY KEY  (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'Admin Hemo', 'admin@hemo.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ambulance`
--

CREATE TABLE `tbl_ambulance` (
  `ambulance_id` int(10) NOT NULL auto_increment,
  `ambulance_name` varchar(30) NOT NULL,
  `ambulance_type` varchar(10) NOT NULL,
  `ambulance_contact` varchar(12) NOT NULL,
  `ambulance_regno` varchar(15) NOT NULL,
  `ambulance_photo` varchar(30) NOT NULL,
  PRIMARY KEY  (`ambulance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_ambulance`
--

INSERT INTO `tbl_ambulance` (`ambulance_id`, `ambulance_name`, `ambulance_type`, `ambulance_contact`, `ambulance_regno`, `ambulance_photo`) VALUES
(2, 'Kanivu', '', '95633558012', 'KL-40-S-60', 'ambulance.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donation`
--

CREATE TABLE `tbl_donation` (
  `donation_id` int(10) NOT NULL auto_increment,
  `user_id` varchar(10) NOT NULL,
  `donation_date` varchar(15) NOT NULL,
  `donation_status` varchar(10) NOT NULL,
  PRIMARY KEY  (`donation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_donation`
--

INSERT INTO `tbl_donation` (`donation_id`, `user_id`, `donation_date`, `donation_status`) VALUES
(1, '1', '2023-10-01', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `faq_id` mediumint(10) NOT NULL auto_increment,
  `user_id` varchar(10) NOT NULL,
  `faq_date` varchar(30) NOT NULL,
  `faq_question` varchar(80) NOT NULL,
  `faq_reply` varchar(80) default NULL,
  PRIMARY KEY  (`faq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`faq_id`, `user_id`, `faq_date`, `faq_question`, `faq_reply`) VALUES
(1, '1', '2023-09-28', 'Test question1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_id` int(10) NOT NULL auto_increment,
  `user_id` varchar(10) NOT NULL,
  `feedback_date` varchar(15) NOT NULL,
  `feedback_content` varchar(30) NOT NULL,
  `feedback_reply` varchar(30) default NULL,
  PRIMARY KEY  (`feedback_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`feedback_id`, `user_id`, `feedback_date`, `feedback_content`, `feedback_reply`) VALUES
(1, '1', '2023-09-28', '', 'reply test'),
(2, '1', '2023-09-28', 'test2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history`
--

CREATE TABLE `tbl_history` (
  `history_id` int(10) NOT NULL auto_increment,
  `doctor_id` varchar(10) NOT NULL,
  `appointment_id` varchar(10) NOT NULL,
  `history_details` varchar(80) NOT NULL,
  PRIMARY KEY  (`history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_history`
--

INSERT INTO `tbl_history` (`history_id`, `doctor_id`, `appointment_id`, `history_details`) VALUES
(1, '2', '2', 'Mild Fever\r\n'),
(2, '2', '2', 'entering test 1 findings 2\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hospital`
--

CREATE TABLE `tbl_hospital` (
  `hospital_id` int(10) NOT NULL auto_increment,
  `hospital_name` varchar(25) NOT NULL,
  `hospital_phone` varchar(25) NOT NULL,
  `hospital_email` varchar(30) NOT NULL,
  `hospital_address` varchar(80) NOT NULL,
  PRIMARY KEY  (`hospital_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_hospital`
--

INSERT INTO `tbl_hospital` (`hospital_id`, `hospital_name`, `hospital_phone`, `hospital_email`, `hospital_address`) VALUES
(2, 'Caritas Hospital', '048722557', 'caritas@fdpp.com', 'Caritas Jn., Kottayam');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE `tbl_request` (
  `request_id` int(10) NOT NULL auto_increment,
  `donation_id` varchar(10) NOT NULL,
  `user_id` varchar(10) default NULL,
  `request_date` varchar(30) NOT NULL,
  `request_status` varchar(10) NOT NULL,
  PRIMARY KEY  (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_request`
--

INSERT INTO `tbl_request` (`request_id`, `donation_id`, `user_id`, `request_date`, `request_status`) VALUES
(10, '1', '2', '2023-10-02', 'Confirmed'),
(12, '', '2', '2023-10-05', 'Added'),
(13, '', '2', '2023-10-05', 'Added'),
(14, '1', '2', '2023-10-05', 'Added'),
(15, '1', '2', '2023-10-05', 'Added'),
(16, '1', '2', '2023-10-05', 'Added'),
(17, '1', '2', '2023-10-05', 'Added'),
(18, '', '2', '2023-10-05', 'Added'),
(19, '', '1', '2023-10-05', 'Added');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(10) NOT NULL auto_increment,
  `user_name` varchar(25) NOT NULL,
  `user_phone` varchar(12) NOT NULL,
  `user_dob` varchar(10) NOT NULL,
  `user_email` varchar(25) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `user_bgroup` varchar(12) NOT NULL,
  `user_address` varchar(80) NOT NULL,
  `user_photo` varchar(30) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_phone`, `user_dob`, `user_email`, `user_password`, `user_bgroup`, `user_address`, `user_photo`) VALUES
(1, 'a', '9988', '', 'a@hemo.com', 'a', 'A+', 'sdmndm', 'DFD-Page-1.jpg'),
(2, 'John Doe', '9539922088', '1997-01-04', 'john@hemo.com', 'john', 'B+', 'Address of John Doe', 'signature1-min-min.png');
