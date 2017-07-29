-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2017 at 10:38 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `we@ss`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batches`
--

CREATE TABLE `tbl_batches` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Compartment',
  `sub_sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Sub Compartment',
  `shelf` int(11) NOT NULL COMMENT 'Shelf',
  `drawer` int(11) DEFAULT NULL COMMENT 'Drawer',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_batches`
--

INSERT INTO `tbl_batches` (`id`, `store`, `compartment`, `sub_compartment`, `sub_sub_compartment`, `shelf`, `drawer`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 3, 1, 1, 2, 'Batch Name', '00001', 'Batch Location', 'Batch Described', 1, '2017-06-28 23:39:07', 1, '2017-07-24 10:31:08'),
(2, 1, 1, 3, 1, 1, 1, 'Batch Two', '00002', 'Location 2', '', 1, '2017-07-03 19:39:48', 1, '2017-07-24 10:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_compartments`
--

CREATE TABLE `tbl_compartments` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_compartments`
--

INSERT INTO `tbl_compartments` (`id`, `store`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Compartment One', '00001', 'Compartment One', 'Description One', 1, '2017-06-28 00:24:10', NULL, NULL),
(2, 1, 'Compartment Two', '00002', 'Location II', 'Described Now', 1, '2017-06-29 23:01:04', NULL, NULL),
(3, 2, 'Compartment III', '00003', 'Location 3', 'Description III', 1, '2017-06-29 23:55:28', NULL, NULL),
(4, 2, 'Compartment 4', '00004', 'Compartment 4', 'Compartment 4', 1, '2017-07-01 22:41:22', NULL, NULL),
(5, 1, 'Compartment Three', '00005', 'Compartment Three', 'Compartment Three Description', 1, '2017-07-02 14:49:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE `tbl_documents` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `directory` int(11) DEFAULT NULL COMMENT 'Parent Folder',
  `name` varchar(40) NOT NULL COMMENT 'Document Name',
  `filename` varchar(255) NOT NULL COMMENT 'Document Location',
  `file_level` int(11) NOT NULL DEFAULT '2' COMMENT 'File Level',
  `dir_or_file` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Directory Of File',
  `description` text COMMENT 'Document Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `status` enum('1','0','-1') NOT NULL DEFAULT '1' COMMENT 'Document Status',
  `status_by` int(11) DEFAULT NULL COMMENT 'Status Updated By',
  `status_at` datetime DEFAULT NULL COMMENT 'Status Updated At',
  `permissions` text COMMENT 'Document Permissions',
  `forwarded_for_update_by` int(11) DEFAULT NULL COMMENT 'Forwarded For Update By',
  `opened_for_update` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Opened For Update',
  `opened_for_update_by` int(11) DEFAULT NULL COMMENT 'Opened For Update By',
  `opened_for_update_at` datetime DEFAULT NULL COMMENT 'Opened For Update At',
  `visible_to_others_during_update` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Visible To Others During Update',
  `can_be_updated` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Can Be Updated',
  `can_be_moved` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Can Be Moved',
  `can_be_deleted` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Can Be Deleted',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Last Updated At',
  `archived_in` varchar(255) DEFAULT NULL COMMENT 'Archived In',
  `archived_by` int(11) DEFAULT NULL COMMENT 'Archived by',
  `archived_at` datetime DEFAULT NULL COMMENT 'Archived At',
  `deleted_to` varchar(255) DEFAULT NULL COMMENT 'Deleted To',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'Deleted By',
  `deleted_at` datetime DEFAULT NULL COMMENT 'Deleted At',
  `restored_by` int(11) DEFAULT NULL COMMENT 'Restored By',
  `restored_at` datetime DEFAULT NULL COMMENT 'Restored At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_documents`
--

INSERT INTO `tbl_documents` (`id`, `directory`, `name`, `filename`, `file_level`, `dir_or_file`, `description`, `created_by`, `created_at`, `status`, `status_by`, `status_at`, `permissions`, `forwarded_for_update_by`, `opened_for_update`, `opened_for_update_by`, `opened_for_update_at`, `visible_to_others_during_update`, `can_be_updated`, `can_be_moved`, `can_be_deleted`, `updated_by`, `updated_at`, `archived_in`, `archived_by`, `archived_at`, `deleted_to`, `deleted_by`, `deleted_at`, `restored_by`, `restored_at`) VALUES
(28, NULL, 'New Folder', '20170607000639414772', 2, '0', '', 1, '2017-06-07 00:06:39', '1', 1, '2017-06-07 00:06:39', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, NULL, 'New Folder', '20170607064224556564', 2, '0', NULL, 1, '2017-06-07 06:42:24', '1', 1, '2017-06-07 06:42:24', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 28, 'New Folder', '20170607000639414772/20170607064253706157', 3, '0', NULL, 1, '2017-06-07 06:42:53', '1', 1, '2017-06-07 06:42:53', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 28, 'New Folder 20170612225913014659', '20170607000639414772/20170607064401495098', 3, '0', NULL, 1, '2017-06-07 06:44:01', '1', 1, '2017-06-12 22:59:13', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 28, 'New Folder 20170607064418634545', '20170607000639414772/20170607064418632981', 3, '0', NULL, 1, '2017-06-07 06:44:18', '1', 1, '2017-06-07 06:44:18', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 28, 'Love You', '20170607000639414772/20170607230403271722.jpg', 3, '1', NULL, 1, '2017-06-07 23:04:03', '1', 1, '2017-06-07 23:04:03', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 28, 'New Folder 20170608204049856848', '20170607000639414772/20170608204049855283', 3, '0', NULL, 1, '2017-06-08 20:40:49', '1', 1, '2017-06-08 20:40:49', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 31, 'love you', '20170607000639414772/20170607064401495098/20170611015309375153.jpg', 4, '1', NULL, 1, '2017-06-11 01:53:09', '1', 1, '2017-06-12 22:59:13', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 34, 'pass', '20170607000639414772/20170608204049855283/20170612214310514583.png', 4, '1', NULL, 1, '2017-06-12 21:43:10', '1', 1, '2017-06-12 21:43:10', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 34, 'love you', '20170607000639414772/20170608204049855283/20170612214337802144.jpg', 4, '1', NULL, 1, '2017-06-12 21:43:37', '1', 1, '2017-06-12 21:43:37', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, NULL, 'New Folder', '20170703221850973001', 2, '0', NULL, 1, '2017-07-03 22:18:50', '1', 1, '2017-07-03 22:18:50', NULL, NULL, '0', NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents_mailings`
--

CREATE TABLE `tbl_documents_mailings` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `sender` int(11) NOT NULL COMMENT 'Sender ID',
  `from` varchar(60) NOT NULL COMMENT 'Sender Email',
  `to` text NOT NULL COMMENT 'Main Recipients',
  `cc` text COMMENT 'Carbon Copy',
  `bcc` text COMMENT 'Blind Copy',
  `subject` text NOT NULL COMMENT 'Subject',
  `documents` text NOT NULL COMMENT 'Documents - id~name',
  `body` text NOT NULL COMMENT 'Body',
  `footer` text COMMENT 'Footer',
  `zip_folder` varchar(200) NOT NULL COMMENT 'Folder with attached documents',
  `sent` enum('sent','failed') NOT NULL DEFAULT 'failed' COMMENT 'Sent or Failed',
  `narration` text COMMENT 'Narration',
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Sent At',
  `expiry` datetime NOT NULL COMMENT 'Expiry Date'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_documents_mailings`
--

INSERT INTO `tbl_documents_mailings` (`id`, `sender`, `from`, `to`, `cc`, `bcc`, `subject`, `documents`, `body`, `footer`, `zip_folder`, `sent`, `narration`, `sent_at`, `expiry`) VALUES
(1, 1, 'wmukhandia@gmail.com', 'Shadrack Wabomba~wsiati@live.com', '', '', 'Love You', '35~love you.jpg', 'Love You Girl', '', '20170612225139373965.zip', 'failed', 'Swift_TransportException: Connection could not be established with host smtp.gmail.com [php_network_', '2017-06-12 22:51:40', '2017-06-26 22:51:40'),
(2, 1, 'wmukhandia@gmail.com', 'Wabomba Shadrack~wmukhandia@gmail.com', '', '', 'My Documents', '33~Love You.jpg', 'Attached please find', 'Regards', '20170717102318531173.zip', 'sent', NULL, '2017-07-17 10:20:29', '2017-07-31 10:20:29'),
(3, 1, 'wmukhandia@gmail.com', 'Shadrack Wabomba~wsiati@live.com', '', '', 'My Docs', '33~Love You.jpg,35~love you.jpg,36~pass.png,37~love you 1.jpg', 'Attached Please Find', 'Regards', '20170717104504457859.zip', 'failed', 'Swift_TransportException: Connection could not be established with host smtp.gmail.com [php_network_', '2017-07-17 10:45:06', '2017-07-31 10:45:06'),
(4, 1, 'wmukhandia@gmail.com', 'Wabomba Shadrack~wmukhandia@gmail.com', 'Shadrack Wabomba~wsiati@live.com', '', 'Doc Hizi', '33~Love You.jpg', 'Docs Hizi', 'Sawa Tu', '20170717115436042052.zip', 'sent', NULL, '2017-07-17 11:55:03', '2017-07-31 11:55:03'),
(5, 1, 'wmukhandia@gmail.com', 'Shadrack Wabomba~wsiati@live.com', '', '', 'Docs Za Mwisho', '33~Love You.jpg', 'Docs Za Mwisho', 'Docs Za Mwisho', '20170717115829073532.zip', 'sent', NULL, '2017-07-17 11:58:45', '2017-07-31 11:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents_mailings_contacts`
--

CREATE TABLE `tbl_documents_mailings_contacts` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `names` varchar(70) NOT NULL COMMENT 'Names',
  `email` varchar(70) NOT NULL COMMENT 'Email',
  `description` text COMMENT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_documents_mailings_contacts`
--

INSERT INTO `tbl_documents_mailings_contacts` (`id`, `names`, `email`, `description`) VALUES
(1, 'Shadrack Wabomba', 'wsiati@live.com', 'HELB Contact'),
(2, 'Wabomba Shadrack', 'wmukhandia@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents_permissions`
--

CREATE TABLE `tbl_documents_permissions` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `document` int(11) NOT NULL COMMENT 'Document',
  `section` int(11) NOT NULL COMMENT 'Section',
  `permission` enum('deny','read','write','alter') NOT NULL DEFAULT 'deny' COMMENT 'Permission',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_documents_permissions`
--

INSERT INTO `tbl_documents_permissions` (`id`, `document`, `section`, `permission`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(11, 28, 1, 'alter', 1, '2017-06-07 00:06:39', 1, '2017-06-07 00:06:59'),
(12, 29, 1, 'deny', 1, '2017-06-07 06:42:24', 1, '2017-06-07 22:53:14'),
(13, 30, 1, 'write', 1, '2017-06-07 06:42:53', 1, '2017-06-07 10:10:00'),
(14, 31, 1, 'write', 1, '2017-06-07 06:44:01', 1, '2017-06-07 10:10:49'),
(15, 32, 1, 'alter', 1, '2017-06-07 06:44:18', NULL, NULL),
(16, 28, 2, 'read', 1, '2017-06-07 22:39:21', 1, '2017-06-07 22:44:40'),
(17, 29, 2, 'read', 1, '2017-06-07 22:39:21', 1, '2017-06-07 22:53:17'),
(18, 30, 2, 'read', 1, '2017-06-07 22:39:21', 1, '2017-06-07 22:40:44'),
(19, 31, 2, 'deny', 1, '2017-06-07 22:39:21', NULL, NULL),
(20, 32, 2, 'deny', 1, '2017-06-07 22:39:21', NULL, NULL),
(21, 34, 1, 'alter', 1, '2017-06-08 20:40:49', NULL, NULL),
(22, 34, 2, 'read', 1, '2017-06-08 20:40:49', NULL, NULL),
(23, 38, 1, 'deny', 1, '2017-07-03 22:18:51', NULL, NULL),
(24, 38, 2, 'deny', 1, '2017-07-03 22:18:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_downloads`
--

CREATE TABLE `tbl_downloads` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user` int(11) NOT NULL COMMENT 'User',
  `filename` varchar(128) NOT NULL COMMENT 'Name Of File'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drawers`
--

CREATE TABLE `tbl_drawers` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Compartment',
  `sub_sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Sub Compartment',
  `shelf` int(11) NOT NULL COMMENT 'Shelf',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_drawers`
--

INSERT INTO `tbl_drawers` (`id`, `store`, `compartment`, `sub_compartment`, `sub_sub_compartment`, `shelf`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 3, 1, 1, 'Drawer Name', '00001', 'Drawer Location', 'Described Here', 1, '2017-06-28 23:24:32', 1, '2017-07-24 10:31:08'),
(2, 1, 1, 3, 1, 1, 'Drawer 2', '00002', 'Location 2', '', 1, '2017-07-03 19:39:26', 1, '2017-07-24 10:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_files`
--

CREATE TABLE `tbl_files` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Compartment',
  `sub_sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Sub Compartment',
  `shelf` int(11) NOT NULL COMMENT 'Shelf',
  `drawer` int(11) DEFAULT NULL COMMENT 'Drawer',
  `batch` int(11) DEFAULT NULL COMMENT 'Batch',
  `folder` int(11) DEFAULT NULL COMMENT 'Folder',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_files`
--

INSERT INTO `tbl_files` (`id`, `store`, `compartment`, `sub_compartment`, `sub_sub_compartment`, `shelf`, `drawer`, `batch`, `folder`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 3, 1, 1, 2, 1, 1, 'File One', '00001', 'Location One', 'Description File One', 1, '2017-07-01 23:39:00', 1, '2017-07-24 10:31:08'),
(2, 1, 1, 3, 1, 1, 2, 1, 2, 'File Two', '00002', 'Location of File Two', 'Description of File Two', 1, '2017-07-08 23:31:53', 1, '2017-07-24 10:31:08'),
(4, 1, 1, 3, 1, 1, 2, 1, 1, 'File Three', '00003', 'File 3', '', 1, '2017-07-18 22:29:53', 1, '2017-07-24 12:00:32'),
(5, 1, 1, 3, 1, 1, 2, 1, 1, 'File 5', '00005', 'Location 5', 'Description 5', 1, '2017-07-24 08:41:32', 1, '2017-07-26 22:06:19'),
(6, 1, 1, 3, 1, 1, 2, 1, 1, 'File 6', '00006', 'Location 6', 'Location 6', 1, '2017-07-25 13:29:23', NULL, NULL),
(7, 1, 1, 3, 1, 1, 2, 1, 1, 'File 7', '00007', 'Location 7', 'Description 7', 1, '2017-07-25 22:11:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file_permissions`
--

CREATE TABLE `tbl_file_permissions` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store_level` int(11) NOT NULL COMMENT 'Store Level',
  `store_id` int(11) NOT NULL COMMENT 'Store ID',
  `read_rights` text COMMENT 'Users With Read Rights',
  `write_rights` text COMMENT 'Users With Write Rights',
  `deny_rights` text COMMENT 'Users Denied Rights',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_file_permissions`
--

INSERT INTO `tbl_file_permissions` (`id`, `store_level`, `store_id`, `read_rights`, `write_rights`, `deny_rights`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 7, 1, NULL, ',3', NULL, 1, '2017-07-06 23:33:28', 1, '2017-07-08 17:32:03'),
(2, 6, 2, ',3', NULL, NULL, 1, '2017-07-08 17:36:47', 1, '2017-07-08 17:37:05'),
(3, 8, 1, NULL, ',3,1', NULL, 1, '2017-07-08 20:38:31', 1, '2017-07-24 09:25:52'),
(4, 9, 1, NULL, ',3,1', NULL, 1, '2017-07-18 20:25:02', 1, '2017-07-24 06:00:39'),
(5, 9, 4, NULL, ',1', NULL, 1, '2017-07-23 20:57:56', 1, '2017-07-24 21:54:57'),
(6, 9, 5, ',1', NULL, NULL, 1, '2017-07-26 21:16:27', 1, '2017-07-26 21:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file_tracking_notes`
--

CREATE TABLE `tbl_file_tracking_notes` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store_level` int(11) NOT NULL COMMENT 'Store Level',
  `store_id` int(11) NOT NULL COMMENT 'Store ID',
  `notes` text NOT NULL COMMENT 'Notes',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_file_tracking_notes`
--

INSERT INTO `tbl_file_tracking_notes` (`id`, `store_level`, `store_id`, `notes`, `created_by`, `created_at`) VALUES
(1, 9, 5, 'terttert tertert erterterte terteter trtretet ertr', 1, '2017-07-28 06:40:13'),
(2, 9, 5, 'ytryyrtyryrt rtyr rtyrty ryrty  rtytyrt', 1, '2017-07-28 06:54:22'),
(3, 9, 5, 'This is the latest', 1, '2017-07-28 07:52:00'),
(4, 9, 5, 'Latest Latest case to work', 1, '2017-07-28 07:53:23'),
(5, 9, 5, 'Ya mwis dfdgfgfgfgfgfd dfgfdg', 1, '2017-07-28 07:55:31'),
(6, 9, 5, 'rrtrytry eryre yrey tryrt ytryt yrtyr tyrt ytry tyty', 1, '2017-07-28 07:57:58'),
(7, 9, 5, 'ter rttrytryrt yrty rtyrty eryery eryeryer yeryrey reyer', 1, '2017-07-28 07:59:26'),
(8, 9, 5, 'ktitytu rturturtu yyyyyyyyyyyyyyyyyyyy yyyyyyyyyyyyyyyyyyyyyyyyy', 1, '2017-07-28 07:59:57'),
(9, 9, 5, 'This is proof that you\'re working', 1, '2017-07-28 20:50:50'),
(10, 9, 5, 'yutyueet terterter tretreter tertert ertertertr ertertert reterte tertertrt ertertertre tretertret retertert retertreter tretertre tretrtr ertretert retretetert ertretret retertrter terterterter tertertert ertertertert ertretrt retretret ertretret retretre tretreter terterter tertertert ertretrete ', 1, '2017-07-28 21:13:34'),
(11, 9, 6, 'Submitted to AEO\'s office for perusal', 1, '2017-07-28 22:47:48'),
(12, 9, 6, 'sddf fsdf dfdd fdsff ff sdfwerf wff ffdsfwef efsdf sfsfef wef dsfdsfwef fdfewf ewfdsfdf dfdsfe fsdff efdsfef efds fdsfew fewfeww fwefwef wefwefw fewfwe ewf ewfwe fwefffwe ewweew ', 1, '2017-07-28 23:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_folders`
--

CREATE TABLE `tbl_folders` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Compartment',
  `sub_sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Sub Compartment',
  `shelf` int(11) NOT NULL COMMENT 'Shelf',
  `drawer` int(11) DEFAULT NULL COMMENT 'Drawer',
  `batch` int(11) DEFAULT NULL COMMENT 'Batch',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_folders`
--

INSERT INTO `tbl_folders` (`id`, `store`, `compartment`, `sub_compartment`, `sub_sub_compartment`, `shelf`, `drawer`, `batch`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 3, 1, 1, 2, 1, 'Folder One', '00001', 'Folder Location', 'Folder Described', 1, '2017-06-28 23:47:03', 1, '2017-07-24 10:31:08'),
(2, 1, 1, 3, 1, 1, 2, 1, 'Folder Two', '00002', 'Location 2', '', 1, '2017-07-03 19:40:16', 1, '2017-07-24 10:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `type` varchar(128) NOT NULL COMMENT 'Log Type',
  `description` text NOT NULL COMMENT 'Log Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `author_name` varchar(128) NOT NULL COMMENT 'Author Name',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `session_id` varchar(128) DEFAULT NULL COMMENT 'Session ID',
  `session_ip` varchar(30) DEFAULT NULL COMMENT 'Session IP',
  `origin_id` varchar(15) DEFAULT NULL COMMENT 'Origin ID',
  `origin_value` text COMMENT 'Original Value',
  `destination_id` varchar(15) DEFAULT NULL COMMENT 'Destination ID',
  `destination_value` text COMMENT 'Final Value',
  `further_narration` text COMMENT 'Further Narration',
  `status` enum('success','failed') NOT NULL DEFAULT 'success' COMMENT 'Status',
  `available` enum('yes','no') NOT NULL DEFAULT 'yes' COMMENT 'Extra Attributes Available',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`id`, `type`, `description`, `created_by`, `author_name`, `created_at`, `session_id`, `session_ip`, `origin_id`, `origin_value`, `destination_id`, `destination_value`, `further_narration`, `status`, `available`, `updated_by`, `updated_at`) VALUES
(1, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-04 02:16:32', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', NULL, '', '1', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(2, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-04 02:20:42', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', NULL, '', '1', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(3, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-04 02:24:14', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', 'deny', '1', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(4, 'Update Document Description', 'Updated description for document New Folder in {{%documents}}', 1, 'wsiati', '2017-06-04 02:32:25', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', NULL, '1', '', NULL, 'success', 'yes', NULL, NULL),
(5, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-04 02:33:18', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', NULL, '1', '1', NULL, 'success', 'yes', NULL, NULL),
(6, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-04 02:33:51', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', 'alter', '1', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(7, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-04 02:33:55', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(8, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-04 02:35:11', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(9, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-04 02:36:08', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', 'alter', '1', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(10, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-04 02:36:18', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', 'alter', '1', 'read', 'Update', 'success', 'yes', NULL, NULL),
(11, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-04 02:36:21', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(12, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-05 06:04:21', 'bpjnum2s4a17qq1b3hm0vf6fiv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(13, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-05 06:35:48', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(14, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-05 20:21:54', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(15, 'Archive Document', 'Archived document New Folder from 20170604021503557602 to 20170604021503557602 in {{%documents}}', 1, 'wsiati', '2017-06-05 20:33:25', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '1', 'documents', '1', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(16, 'Recycle Document', 'Recycled document New Folder from 20170604021503557602 to 20170604021503557602 in {{%documents}}', 1, 'wsiati', '2017-06-05 20:33:33', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '1', 'archive', '1', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(17, 'Drop Document', 'Drop document New Folder from {{%documents}}', 1, 'wsiati', '2017-06-05 20:33:39', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '1', 'recycle', '0', NULL, '20170604021503557602 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(18, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:46:46', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', NULL, '', '1', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(19, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 2 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:49:27', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', NULL, '', '2', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(20, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 3 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:52:32', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', NULL, '', '3', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(21, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:54:15', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '1', 'deny', '1', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(22, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 2 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:54:20', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '2', 'deny', '2', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(23, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 3 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:54:24', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '3', 'deny', '3', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(24, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 4 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:58:18', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', NULL, '', '4', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(25, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 5 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:58:39', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', NULL, '', '5', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(26, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 6 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:58:56', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', NULL, '', '6', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(27, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 4 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:59:30', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '4', 'deny', '4', 'read', 'Update', 'success', 'yes', NULL, NULL),
(28, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 5 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 20:59:37', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '5', 'deny', '5', 'read', 'Update', 'success', 'yes', NULL, NULL),
(29, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 6 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:01:12', 'bvr9jmj4s5udtu1oo10r7ft90r', '::1', '6', 'deny', '6', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(30, 'Download Document', 'Dowloaded document Watch full military farewell to Preside, id 9 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:13:06', NULL, NULL, '9', '20170605204646679990/20170605211236964008.mp4', '9', 'first/20170605204646679990/20170605211236964008.mp4', 'downloads/20170605211236964008.mp4', 'success', 'yes', NULL, NULL),
(31, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 10 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:17:15', NULL, NULL, NULL, '', '7', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(32, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 21:17:15', NULL, NULL, '0', NULL, '10', '20170605211715518929', NULL, 'success', 'yes', NULL, NULL),
(33, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 12 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:20:27', NULL, NULL, NULL, '', '8', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(34, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 21:20:27', NULL, NULL, '0', NULL, '12', '20170605204646679990/20170605212027134463', NULL, 'success', 'yes', NULL, NULL),
(35, 'New Document', 'New file Adventist Songs 2017 uploaded into {{%documents}}', 1, 'wsiati', '2017-06-05 21:21:05', NULL, NULL, '0', NULL, '13', '20170605204646679990/20170605212105403242.mp4', NULL, 'success', 'yes', NULL, NULL),
(36, 'Document Update', 'Update of document Adventist Songs 2017 in {{%documents}}', 1, 'wsiati', '2017-06-05 21:21:09', NULL, NULL, '13', '20170605204646679990/20170605212105403242.mp4', '13', '20170605204646679990/20170605212105403242.mp4', '20170605212105403242.mp4', 'success', 'no', 1, '2017-06-06 23:57:38'),
(37, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 14 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:24:08', NULL, NULL, NULL, '', '9', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(38, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 21:24:08', NULL, NULL, '0', NULL, '14', '20170605212408835539', NULL, 'success', 'yes', NULL, NULL),
(39, 'New Document', 'New file 3 idiots is a hindi bollywood movie by  uploaded into {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:01', NULL, NULL, '0', NULL, '15', '20170605204646679990/20170605212501091393.mp4', NULL, 'success', 'yes', NULL, NULL),
(40, 'Document Update', 'Update of document 3 idiots is a hindi bollywood movie by  in {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:05', NULL, NULL, '15', '20170605204646679990/20170605212501091393.mp4', '15', '20170605204646679990/20170605212501091393.mp4', '20170605212501091393.mp4', 'success', 'no', 1, '2017-06-06 23:57:38'),
(41, 'New Document', 'New file Abeddy Ngosso Kimbilio Langu uploaded into {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:07', NULL, NULL, '0', NULL, '16', '20170605204646679990/20170605212507914665.mp4', NULL, 'success', 'yes', NULL, NULL),
(42, 'Document Update', 'Update of document Abeddy Ngosso Kimbilio Langu in {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:08', NULL, NULL, '16', '20170605204646679990/20170605212507914665.mp4', '16', '20170605204646679990/20170605212507914665.mp4', '20170605212507914665.mp4', 'success', 'no', 1, '2017-06-06 23:57:38'),
(43, 'New Document', 'New file Ambassadors Of Christ Choir - Amani (Of uploaded into {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:08', NULL, NULL, '0', NULL, '17', '20170605204646679990/20170605212508523355.mp4', NULL, 'success', 'yes', NULL, NULL),
(44, 'Document Update', 'Update of document Ambassadors Of Christ Choir - Amani (Of in {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:08', NULL, NULL, '17', '20170605204646679990/20170605212508523355.mp4', '17', '20170605204646679990/20170605212508523355.mp4', '20170605212508523355.mp4', 'success', 'no', 1, '2017-06-06 23:57:38'),
(45, 'New Document', 'New file Ambassadors Of Christ Choir - Jamani Tu uploaded into {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:08', NULL, NULL, '0', NULL, '18', '20170605204646679990/20170605212508925879.mp4', NULL, 'success', 'yes', NULL, NULL),
(46, 'Document Update', 'Update of document Ambassadors Of Christ Choir - Jamani Tu in {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:08', NULL, NULL, '18', '20170605204646679990/20170605212508925879.mp4', '18', '20170605204646679990/20170605212508925879.mp4', '20170605212508925879.mp4', 'success', 'no', 1, '2017-06-06 23:57:38'),
(47, 'New Document', 'New file As for Me and My House - John Waller uploaded into {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:10', NULL, NULL, '0', NULL, '19', '20170605204646679990/20170605212510337886.mp4', NULL, 'success', 'yes', NULL, NULL),
(48, 'Document Update', 'Update of document As for Me and My House - John Waller in {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:10', NULL, NULL, '19', '20170605204646679990/20170605212510337886.mp4', '19', '20170605204646679990/20170605212510337886.mp4', '20170605212510337886.mp4', 'success', 'no', 1, '2017-06-06 23:57:38'),
(49, 'Download Document', 'Dowloaded document 3 idiots is a hindi bollywood movie by , id 15 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:29', NULL, NULL, '15', '20170605204646679990/20170605212501091393.mp4', '15', 'first/20170605204646679990/20170605212501091393.mp4', 'downloads/20170605212501091393.mp4', 'success', 'yes', NULL, NULL),
(50, 'Download Document', 'Dowloaded document 3 idiots is a hindi bollywood movie by , id 15 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:25:43', NULL, NULL, '15', '20170605204646679990/20170605212501091393.mp4', '15', 'first/20170605204646679990/20170605212501091393.mp4', 'downloads/20170605212501091393.mp4', 'success', 'yes', NULL, NULL),
(51, 'Download Document', 'Dowloaded document justin, id 7 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:31:53', NULL, NULL, '7', '20170605204646679990/20170605210444459706.docx', '7', 'first/20170605204646679990/20170605210444459706.docx', 'downloads/20170605210444459706.docx', 'success', 'yes', NULL, NULL),
(52, 'Download Document', 'Dowloaded document justin, id 7 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:32:11', NULL, NULL, '7', '20170605204646679990/20170605210444459706.docx', '7', 'first/20170605204646679990/20170605210444459706.docx', 'downloads/20170605210444459706.docx', 'success', 'yes', NULL, NULL),
(53, 'Download Document', 'Dowloaded document justin, id 7 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:32:36', NULL, NULL, '7', '20170605204646679990/20170605210444459706.docx', '7', 'first/20170605204646679990/20170605210444459706.docx', 'downloads/20170605210444459706.docx', 'success', 'yes', NULL, NULL),
(54, 'Download Document', 'Dowloaded document lucy, id 8 from {{%documents}}', 1, 'wsiati', '2017-06-05 21:37:06', NULL, NULL, '8', '20170605204646679990/20170605211026501694.pdf', '8', 'first/20170605204646679990/20170605211026501694.pdf', 'downloads/20170605211026501694.pdf', 'success', 'yes', NULL, NULL),
(55, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-05 21:55:10', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(56, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-05 21:58:02', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(57, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 20 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:58:22', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', NULL, '', '10', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(58, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 21:58:22', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '0', NULL, '20', '20170605215822256571', NULL, 'success', 'yes', NULL, NULL),
(59, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 20 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:58:57', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '10', 'deny', '10', 'read', 'Update', 'success', 'yes', NULL, NULL),
(60, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 14 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:59:04', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '9', 'deny', '9', 'write', 'Update', 'success', 'yes', NULL, NULL),
(61, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 10 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:59:10', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '7', 'deny', '7', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(62, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 21 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 21:59:21', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', NULL, '', '11', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(63, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 21:59:21', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '0', NULL, '21', '20170605215921882288', NULL, 'success', 'yes', NULL, NULL),
(64, 'Rename Document', 'Rename document from New Folder to New Folder 1 in {{%documents}}', 1, 'wsiati', '2017-06-05 21:59:40', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '1', 'New Folder', '1', 'New Folder 1', '20170605204646679990', 'success', 'yes', NULL, NULL),
(65, 'Rename Document', 'Rename document from New Folder to New Folder 2 in {{%documents}}', 1, 'wsiati', '2017-06-05 21:59:46', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '2', 'New Folder', '2', 'New Folder 2', '20170605204927697662', 'success', 'yes', NULL, NULL),
(66, 'Rename Document', 'Rename document from New Folder to New Folder 3 in {{%documents}}', 1, 'wsiati', '2017-06-05 21:59:54', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '3', 'New Folder', '3', 'New Folder 3', '20170605205232112042', 'success', 'yes', NULL, NULL),
(67, 'Rename Document', 'Rename document from New Folder to New Folder 4 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:00:00', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '4', 'New Folder', '4', 'New Folder 4', '20170605205818829685', 'success', 'yes', NULL, NULL),
(68, 'Rename Document', 'Rename document from New Folder to New Folder 5 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:00:07', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '5', 'New Folder', '5', 'New Folder 5', '20170605205839518738', 'success', 'yes', NULL, NULL),
(69, 'Rename Document', 'Rename document from New Folder to New Folder 6 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:00:13', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '10', 'New Folder', '10', 'New Folder 6', '20170605211715518929', 'success', 'yes', NULL, NULL),
(70, 'Rename Document', 'Rename document from New Folder to New Folder 7 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:00:19', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '14', 'New Folder', '14', 'New Folder 7', '20170605212408835539', 'success', 'yes', NULL, NULL),
(71, 'Rename Document', 'Rename document from New Folder to New Folder 8 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:00:29', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '20', 'New Folder', '20', 'New Folder 8', '20170605215822256571', 'success', 'yes', NULL, NULL),
(72, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 21 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 22:00:49', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '11', 'deny', '11', 'read', 'Update', 'success', 'yes', NULL, NULL),
(73, 'Rename Document', 'Rename document from New Folder to New Folder 9 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:01:06', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '21', 'New Folder', '21', 'New Folder 9', '20170605215921882288', 'success', 'yes', NULL, NULL),
(74, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 22 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 22:01:15', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', NULL, '', '12', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(75, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 22:01:15', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '0', NULL, '22', '20170605220115098706', NULL, 'success', 'yes', NULL, NULL),
(76, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 22 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 22:01:31', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '12', 'deny', '12', 'read', 'Update', 'success', 'yes', NULL, NULL),
(77, 'Rename Document', 'Rename document from New Folder to New Folder 10 in {{%documents}}', 1, 'wsiati', '2017-06-05 22:01:48', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '22', 'New Folder', '22', 'New Folder 10', '20170605220115098706', 'success', 'yes', NULL, NULL),
(78, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 22:13:47', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', NULL, '', '13', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(79, 'New Document', 'New folder New Folder 20170605221347537281 created in {{%documents}}', 1, 'wsiati', '2017-06-05 22:13:47', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '0', NULL, '23', '20170605204646679990/20170605221347535790', NULL, 'success', 'yes', NULL, NULL),
(80, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 24 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 22:13:57', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', NULL, '', '14', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(81, 'New Document', 'New folder New Folder 20170605221357807451 created in {{%documents}}', 1, 'wsiati', '2017-06-05 22:13:57', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '0', NULL, '24', '20170605205818829685/20170605221357805929', NULL, 'success', 'yes', NULL, NULL),
(82, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 25 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-05 22:14:54', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', NULL, '', '15', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(83, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-05 22:14:54', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '0', NULL, '25', '20170605204927697662/20170605221454746515', NULL, 'success', 'yes', NULL, NULL),
(84, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-05 22:32:56', 'vjddhd33jftu4ctorvqm6qcc8g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(85, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-06 06:06:39', 'ts6jr3pthlmap86ndosierabkq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(86, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 22 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 06:08:55', 'ts6jr3pthlmap86ndosierabkq', '::1', '12', 'read', '12', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(87, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 22 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 06:09:08', 'ts6jr3pthlmap86ndosierabkq', '::1', '12', 'alter', '12', 'write', 'Update', 'success', 'yes', NULL, NULL),
(88, 'Update Group Access To Folder', 'Updated group 1 accedd to folder 22 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 06:09:16', 'ts6jr3pthlmap86ndosierabkq', '::1', '12', 'write', '12', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(89, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-06 06:09:42', 'ts6jr3pthlmap86ndosierabkq', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(90, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-06 06:09:49', 'ts6jr3pthlmap86ndosierabkq', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(91, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-06 06:10:04', 'ts6jr3pthlmap86ndosierabkq', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(92, 'Add User To Group', 'Updated privileges for user 1 in user group Ict Department in {{%sections}}', 1, 'wsiati', '2017-06-06 06:10:08', 'ts6jr3pthlmap86ndosierabkq', '::1', '1', '1', '1', '1', NULL, 'success', 'yes', NULL, NULL),
(93, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-06 06:21:39', 'ts6jr3pthlmap86ndosierabkq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(94, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-06 06:42:26', '97ocg54ate7o2a4bisrnpmcm3c', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(95, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-06 07:00:45', '97ocg54ate7o2a4bisrnpmcm3c', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(96, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-06 07:03:13', 'nbjc1sbe45kgpihfjaivvj0bik', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(97, 'Archive Document', 'Archived document New Folder 10 from 20170605220115098706 to 20170605220115098706 in {{%documents}}', 1, 'wsiati', '2017-06-06 07:03:44', 'nbjc1sbe45kgpihfjaivvj0bik', '::1', '22', 'documents', '22', 'archive', 'New Folder 10', 'success', 'yes', NULL, NULL),
(98, 'Recycle Document', 'Recycled document New Folder 10 from 20170605220115098706 to 20170605220115098706 in {{%documents}}', 1, 'wsiati', '2017-06-06 07:04:25', 'nbjc1sbe45kgpihfjaivvj0bik', '::1', '22', 'archive', '22', 'recycle', 'New Folder 10', 'success', 'yes', NULL, NULL),
(99, 'Delete Document Permission', 'Deleted document permission 12 for document 22, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 07:04:56', 'nbjc1sbe45kgpihfjaivvj0bik', '::1', '12', 'alter', NULL, NULL, 'Deleted along with document 22', 'success', 'yes', NULL, NULL),
(100, 'Drop Document', 'Drop document New Folder 10 from {{%documents}}', 1, 'wsiati', '2017-06-06 07:04:56', 'nbjc1sbe45kgpihfjaivvj0bik', '::1', '22', 'recycle', '0', NULL, '20170605220115098706 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(101, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-06 07:42:31', 'nbjc1sbe45kgpihfjaivvj0bik', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(102, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-06 19:51:30', '6egqli9pdk33u6ogocngpkbpq6', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(103, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-06 20:01:39', '6egqli9pdk33u6ogocngpkbpq6', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(104, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-06 20:50:45', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(105, 'Update Group Access To Folder', 'Updated group 1 access to folder 12 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 20:55:30', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '8', 'deny', '8', 'read', 'Update', 'success', 'yes', NULL, NULL),
(106, 'Update Group Access To Folder', 'Updated group 1 access to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 20:55:36', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '13', 'deny', '13', 'write', 'Update', 'success', 'yes', NULL, NULL),
(107, 'Update Group Access To Folder', 'Updated group 1 access to folder 26 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 20:57:07', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '16', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(108, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-06 20:57:07', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '0', NULL, '26', '20170605204646679990/20170605221347535790/20170606205707788345', NULL, 'success', 'yes', NULL, NULL),
(109, 'Update Group Access To Folder', 'Updated group 1 access to folder 26 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 20:57:28', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '16', 'deny', '16', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(110, 'New Document', 'New file love you uploaded into {{%documents}}', 1, 'wsiati', '2017-06-06 21:05:04', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '0', NULL, '27', '20170605204646679990/20170605221347535790/20170606210504517646.jpg', NULL, 'success', 'yes', NULL, NULL),
(111, 'Document Update', 'Update of document love you in {{%documents}}', 1, 'wsiati', '2017-06-06 21:05:04', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '27', '20170605204646679990/20170605221347535790/20170606210504517646.jpg', '27', '20170605204646679990/20170605221347535790/20170606210504517646.jpg', '20170606210504517646.jpg', 'success', 'no', 1, '2017-06-06 23:57:38'),
(112, 'Update Group Access To Folder', 'Updated group 1 access to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:06:51', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '13', 'write', '13', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(113, 'Update Group Access To Folder', 'Updated group 1 access to folder 26 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:07:02', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '16', 'alter', '16', 'write', 'Update', 'success', 'yes', NULL, NULL),
(114, 'Move Document', 'Moved love you from 20170605204646679990/20170605221347535790/20170606210504517646.jpg to 20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg in {{%documents}}', 1, 'wsiati', '2017-06-06 21:08:45', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '27', '20170605204646679990/20170605221347535790/20170606210504517646.jpg', '27', '20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg', 'love you', 'success', 'yes', NULL, NULL),
(115, 'Update Group Access To Folder', 'Updated group 2 access to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '17', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(116, 'Update Group Access To Folder', 'Updated group 2 access to folder 2 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '18', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(117, 'Update Group Access To Folder', 'Updated group 2 access to folder 3 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '19', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(118, 'Update Group Access To Folder', 'Updated group 2 access to folder 4 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '20', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(119, 'Update Group Access To Folder', 'Updated group 2 access to folder 5 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '21', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(120, 'Update Group Access To Folder', 'Updated group 2 access to folder 6 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '22', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(121, 'Update Group Access To Folder', 'Updated group 2 access to folder 10 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '23', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(122, 'Update Group Access To Folder', 'Updated group 2 access to folder 12 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '24', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(123, 'Update Group Access To Folder', 'Updated group 2 access to folder 14 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '25', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(124, 'Update Group Access To Folder', 'Updated group 2 access to folder 20 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '26', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(125, 'Update Group Access To Folder', 'Updated group 2 access to folder 21 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '27', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(126, 'Update Group Access To Folder', 'Updated group 2 access to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '28', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(127, 'Update Group Access To Folder', 'Updated group 2 access to folder 24 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '29', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(128, 'Update Group Access To Folder', 'Updated group 2 access to folder 25 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '30', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(129, 'Update Group Access To Folder', 'Updated group 2 access to folder 26 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, '', '31', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(130, 'Create Group', 'Created new user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-06 21:38:19', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', NULL, NULL, '2', 'Lending Group,Lending Department Staff,1', NULL, 'success', 'yes', NULL, NULL),
(131, 'Add User To Group', 'Updated privileges for user 1 in user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-06 21:38:38', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '2', NULL, '2', '1', NULL, 'success', 'yes', NULL, NULL),
(132, 'Update Group Access To Folder', 'Updated group 2 access to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:38:48', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '28', 'deny', '28', 'write', 'Update', 'success', 'yes', NULL, NULL),
(133, 'Update Group Access To Folder', 'Updated group 1 access to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:40:06', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '13', 'alter', '13', 'write', 'Update', 'success', 'yes', NULL, NULL),
(134, 'Update Group Access To Folder', 'Updated group 2 access to folder 23 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 21:40:58', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '28', 'write', '28', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(135, 'Add User To Group', 'Updated privileges for user 1 in user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-06 21:41:01', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '2', '1', '2', '1', NULL, 'success', 'yes', NULL, NULL),
(136, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-06 22:36:46', 'ko88k76q94ed2mmo3u8ciqvi5h', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(137, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-06 22:45:43', 'f0860qn07m4m09itng87vao40l', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(138, 'Update Group Access To Folder', 'Updated group 1 access to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:19:24', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '32', 'read', 'Insert', 'success', 'yes', NULL, NULL),
(139, 'Update Group Access To Folder', 'Updated group 1 access to folder 12 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:22:34', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '1', 'read', 'Insert', 'success', 'yes', NULL, NULL),
(140, 'Group Active Status', 'Changed active status of user group Ict Department to 0 in {{%sections}}', 1, 'wsiati', '2017-06-06 23:26:55', 'f0860qn07m4m09itng87vao40l', '::1', '1', 'Ict Department,For Ict Department,1', '1', 'Ict Department,For Ict Department,0', NULL, 'success', 'yes', NULL, NULL),
(141, 'Group Active Status', 'Changed active status of user group Ict Department to 1 in {{%sections}}', 1, 'wsiati', '2017-06-06 23:26:57', 'f0860qn07m4m09itng87vao40l', '::1', '1', 'Ict Department,For Ict Department,0', '1', 'Ict Department,For Ict Department,1', NULL, 'success', 'yes', NULL, NULL),
(142, 'Update Group Access To Folder', 'Updated group 1 access to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:27:11', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '2', 'read', 'Insert', 'success', 'yes', NULL, NULL),
(143, 'Remove User From Group', 'Removed user 1 from user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-06 23:27:52', 'f0860qn07m4m09itng87vao40l', '::1', '2', '1', '2', NULL, NULL, 'success', 'yes', NULL, NULL),
(144, 'Update Group Access To Folder', 'Updated group 1 access to folder 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:31:41', 'f0860qn07m4m09itng87vao40l', '::1', '2', 'read', '2', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(145, 'Update Group Access To Folder', 'Updated group 1 access to folder 2 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:33:55', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '3', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(146, 'Update Group Access To Folder', 'Updated group 1 access to folder 3 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:00', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '4', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(147, 'Update Group Access To Folder', 'Updated group 1 access to folder 4 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:04', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '5', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(148, 'Update Group Access To Folder', 'Updated group 1 access to folder 5 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:08', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '6', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(149, 'Update Group Access To Folder', 'Updated group 1 access to folder 10 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:12', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '7', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(150, 'Update Group Access To Folder', 'Updated group 1 access to folder 14 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:16', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '8', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(151, 'Update Group Access To Folder', 'Updated group 1 access to folder 20 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:24', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '9', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(152, 'Update Group Access To Folder', 'Updated group 1 access to folder 21 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:34:29', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '10', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(153, 'Delete Group', 'Deleted user group Lending Group from {{%sections}}', 1, 'wsiati', '2017-06-06 23:34:42', 'f0860qn07m4m09itng87vao40l', '::1', '2', 'Lending Group, Lending Department Staff, 1', NULL, NULL, NULL, 'success', 'yes', NULL, NULL),
(154, 'Update Group Access To Folder', 'Updated group 1 access to folder 10 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:35:23', 'f0860qn07m4m09itng87vao40l', '::1', '7', 'alter', '7', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(155, 'Archive Document', 'Archived document New Folder 1 from 20170605204646679990 to 20170605204646679990 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '1', 'documents', '1', 'archive', 'New Folder 1', 'success', 'yes', NULL, NULL),
(156, 'Archive Document', 'Archived document justin from 20170605204646679990/20170605210444459706.docx to 20170605204646679990/20170605210444459706.docx in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '7', 'documents', '7', 'archive', 'justin', 'success', 'yes', NULL, NULL),
(157, 'Archive Document', 'Archived document lucy from 20170605204646679990/20170605211026501694.pdf to 20170605204646679990/20170605211026501694.pdf in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '8', 'documents', '8', 'archive', 'lucy', 'success', 'yes', NULL, NULL),
(158, 'Archive Document', 'Archived document Watch full military farewell to Preside from 20170605204646679990/20170605211236964008.mp4 to 20170605204646679990/20170605211236964008.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '9', 'documents', '9', 'archive', 'Watch full military farewell to Preside', 'success', 'yes', NULL, NULL),
(159, 'Archive Document', 'Archived document Chris Tomlin - Lord I Need You from 20170605204646679990/20170605211807201555.mp4 to 20170605204646679990/20170605211807201555.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '11', 'documents', '11', 'archive', 'Chris Tomlin - Lord I Need You', 'success', 'yes', NULL, NULL),
(160, 'Archive Document', 'Archived document New Folder from 20170605204646679990/20170605212027134463 to 20170605204646679990/20170605212027134463 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '12', 'documents', '12', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(161, 'Archive Document', 'Archived document Adventist Songs 2017 from 20170605204646679990/20170605212105403242.mp4 to 20170605204646679990/20170605212105403242.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '13', 'documents', '13', 'archive', 'Adventist Songs 2017', 'success', 'yes', NULL, NULL),
(162, 'Archive Document', 'Archived document 3 idiots is a hindi bollywood movie by  from 20170605204646679990/20170605212501091393.mp4 to 20170605204646679990/20170605212501091393.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '15', 'documents', '15', 'archive', '3 idiots is a hindi bollywood movie by ', 'success', 'yes', NULL, NULL),
(163, 'Archive Document', 'Archived document Abeddy Ngosso Kimbilio Langu from 20170605204646679990/20170605212507914665.mp4 to 20170605204646679990/20170605212507914665.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '16', 'documents', '16', 'archive', 'Abeddy Ngosso Kimbilio Langu', 'success', 'yes', NULL, NULL),
(164, 'Archive Document', 'Archived document Ambassadors Of Christ Choir - Amani (Of from 20170605204646679990/20170605212508523355.mp4 to 20170605204646679990/20170605212508523355.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '17', 'documents', '17', 'archive', 'Ambassadors Of Christ Choir - Amani (Of', 'success', 'yes', NULL, NULL),
(165, 'Archive Document', 'Archived document Ambassadors Of Christ Choir - Jamani Tu from 20170605204646679990/20170605212508925879.mp4 to 20170605204646679990/20170605212508925879.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '18', 'documents', '18', 'archive', 'Ambassadors Of Christ Choir - Jamani Tu', 'success', 'yes', NULL, NULL),
(166, 'Archive Document', 'Archived document As for Me and My House - John Waller from 20170605204646679990/20170605212510337886.mp4 to 20170605204646679990/20170605212510337886.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '19', 'documents', '19', 'archive', 'As for Me and My House - John Waller', 'success', 'yes', NULL, NULL),
(167, 'Archive Document', 'Archived document New Folder 20170605221347537281 from 20170605204646679990/20170605221347535790 to 20170605204646679990/20170605221347535790 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '23', 'documents', '23', 'archive', 'New Folder 20170605221347537281', 'success', 'yes', NULL, NULL),
(168, 'Archive Document', 'Archived document New Folder from 20170605204646679990/20170605221347535790/20170606205707788345 to 20170605204646679990/20170605221347535790/20170606205707788345 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '26', 'documents', '26', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(169, 'Archive Document', 'Archived document love you from 20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg to 20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '27', 'documents', '27', 'archive', 'love you', 'success', 'yes', NULL, NULL),
(170, 'Archive Document', 'Archived document New Folder 6 from 20170605211715518929 to 20170605211715518929 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '10', 'documents', '10', 'archive', 'New Folder 6', 'success', 'yes', NULL, NULL),
(171, 'Archive Document', 'Archived document New Folder 2 from 20170605204927697662 to 20170605204927697662 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '2', 'documents', '2', 'archive', 'New Folder 2', 'success', 'yes', NULL, NULL),
(172, 'Archive Document', 'Archived document New Folder from 20170605204927697662/20170605221454746515 to 20170605204927697662/20170605221454746515 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '25', 'documents', '25', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(173, 'Archive Document', 'Archived document New Folder 3 from 20170605205232112042 to 20170605205232112042 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '3', 'documents', '3', 'archive', 'New Folder 3', 'success', 'yes', NULL, NULL),
(174, 'Archive Document', 'Archived document New Folder 4 from 20170605205818829685 to 20170605205818829685 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '4', 'documents', '4', 'archive', 'New Folder 4', 'success', 'yes', NULL, NULL),
(175, 'Archive Document', 'Archived document New Folder from 20170605205818829685/20170605205855993231 to 20170605205818829685/20170605205855993231 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '6', 'documents', '6', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(176, 'Archive Document', 'Archived document New Folder 20170605221357807451 from 20170605205818829685/20170605221357805929 to 20170605205818829685/20170605221357805929 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '24', 'documents', '24', 'archive', 'New Folder 20170605221357807451', 'success', 'yes', NULL, NULL),
(177, 'Archive Document', 'Archived document New Folder 5 from 20170605205839518738 to 20170605205839518738 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '5', 'documents', '5', 'archive', 'New Folder 5', 'success', 'yes', NULL, NULL),
(178, 'Archive Document', 'Archived document New Folder 7 from 20170605212408835539 to 20170605212408835539 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '14', 'documents', '14', 'archive', 'New Folder 7', 'success', 'yes', NULL, NULL),
(179, 'Archive Document', 'Archived document New Folder 8 from 20170605215822256571 to 20170605215822256571 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '20', 'documents', '20', 'archive', 'New Folder 8', 'success', 'yes', NULL, NULL),
(180, 'Archive Document', 'Archived document New Folder 9 from 20170605215921882288 to 20170605215921882288 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:56:50', 'f0860qn07m4m09itng87vao40l', '::1', '21', 'documents', '21', 'archive', 'New Folder 9', 'success', 'yes', NULL, NULL),
(181, 'Recycle Document', 'Recycled document New Folder 3 from 20170605205232112042 to 20170605205232112042 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '3', 'archive', '3', 'recycle', 'New Folder 3', 'success', 'yes', NULL, NULL),
(182, 'Recycle Document', 'Recycled document New Folder 1 from 20170605204646679990 to 20170605204646679990 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '1', 'archive', '1', 'recycle', 'New Folder 1', 'success', 'yes', NULL, NULL),
(183, 'Recycle Document', 'Recycled document justin from 20170605204646679990/20170605210444459706.docx to 20170605204646679990/20170605210444459706.docx in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '7', 'archive', '7', 'recycle', 'justin', 'success', 'yes', NULL, NULL),
(184, 'Recycle Document', 'Recycled document lucy from 20170605204646679990/20170605211026501694.pdf to 20170605204646679990/20170605211026501694.pdf in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '8', 'archive', '8', 'recycle', 'lucy', 'success', 'yes', NULL, NULL),
(185, 'Recycle Document', 'Recycled document Watch full military farewell to Preside from 20170605204646679990/20170605211236964008.mp4 to 20170605204646679990/20170605211236964008.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '9', 'archive', '9', 'recycle', 'Watch full military farewell to Preside', 'success', 'yes', NULL, NULL),
(186, 'Recycle Document', 'Recycled document Chris Tomlin - Lord I Need You from 20170605204646679990/20170605211807201555.mp4 to 20170605204646679990/20170605211807201555.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '11', 'archive', '11', 'recycle', 'Chris Tomlin - Lord I Need You', 'success', 'yes', NULL, NULL),
(187, 'Recycle Document', 'Recycled document New Folder from 20170605204646679990/20170605212027134463 to 20170605204646679990/20170605212027134463 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '12', 'archive', '12', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(188, 'Recycle Document', 'Recycled document Adventist Songs 2017 from 20170605204646679990/20170605212105403242.mp4 to 20170605204646679990/20170605212105403242.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '13', 'archive', '13', 'recycle', 'Adventist Songs 2017', 'success', 'yes', NULL, NULL);
INSERT INTO `tbl_logs` (`id`, `type`, `description`, `created_by`, `author_name`, `created_at`, `session_id`, `session_ip`, `origin_id`, `origin_value`, `destination_id`, `destination_value`, `further_narration`, `status`, `available`, `updated_by`, `updated_at`) VALUES
(189, 'Recycle Document', 'Recycled document 3 idiots is a hindi bollywood movie by  from 20170605204646679990/20170605212501091393.mp4 to 20170605204646679990/20170605212501091393.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '15', 'archive', '15', 'recycle', '3 idiots is a hindi bollywood movie by ', 'success', 'yes', NULL, NULL),
(190, 'Recycle Document', 'Recycled document Abeddy Ngosso Kimbilio Langu from 20170605204646679990/20170605212507914665.mp4 to 20170605204646679990/20170605212507914665.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '16', 'archive', '16', 'recycle', 'Abeddy Ngosso Kimbilio Langu', 'success', 'yes', NULL, NULL),
(191, 'Recycle Document', 'Recycled document Ambassadors Of Christ Choir - Amani (Of from 20170605204646679990/20170605212508523355.mp4 to 20170605204646679990/20170605212508523355.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '17', 'archive', '17', 'recycle', 'Ambassadors Of Christ Choir - Amani (Of', 'success', 'yes', NULL, NULL),
(192, 'Recycle Document', 'Recycled document Ambassadors Of Christ Choir - Jamani Tu from 20170605204646679990/20170605212508925879.mp4 to 20170605204646679990/20170605212508925879.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '18', 'archive', '18', 'recycle', 'Ambassadors Of Christ Choir - Jamani Tu', 'success', 'yes', NULL, NULL),
(193, 'Recycle Document', 'Recycled document As for Me and My House - John Waller from 20170605204646679990/20170605212510337886.mp4 to 20170605204646679990/20170605212510337886.mp4 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '19', 'archive', '19', 'recycle', 'As for Me and My House - John Waller', 'success', 'yes', NULL, NULL),
(194, 'Recycle Document', 'Recycled document New Folder 20170605221347537281 from 20170605204646679990/20170605221347535790 to 20170605204646679990/20170605221347535790 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '23', 'archive', '23', 'recycle', 'New Folder 20170605221347537281', 'success', 'yes', NULL, NULL),
(195, 'Recycle Document', 'Recycled document New Folder from 20170605204646679990/20170605221347535790/20170606205707788345 to 20170605204646679990/20170605221347535790/20170606205707788345 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '26', 'archive', '26', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(196, 'Recycle Document', 'Recycled document love you from 20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg to 20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '27', 'archive', '27', 'recycle', 'love you', 'success', 'yes', NULL, NULL),
(197, 'Recycle Document', 'Recycled document New Folder 9 from 20170605215921882288 to 20170605215921882288 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:15', 'f0860qn07m4m09itng87vao40l', '::1', '21', 'archive', '21', 'recycle', 'New Folder 9', 'success', 'yes', NULL, NULL),
(198, 'Recycle Document', 'Recycled document New Folder 4 from 20170605205818829685 to 20170605205818829685 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '4', 'archive', '4', 'recycle', 'New Folder 4', 'success', 'yes', NULL, NULL),
(199, 'Recycle Document', 'Recycled document New Folder from 20170605205818829685/20170605205855993231 to 20170605205818829685/20170605205855993231 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '6', 'archive', '6', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(200, 'Recycle Document', 'Recycled document New Folder 20170605221357807451 from 20170605205818829685/20170605221357805929 to 20170605205818829685/20170605221357805929 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '24', 'archive', '24', 'recycle', 'New Folder 20170605221357807451', 'success', 'yes', NULL, NULL),
(201, 'Recycle Document', 'Recycled document New Folder 2 from 20170605204927697662 to 20170605204927697662 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '2', 'archive', '2', 'recycle', 'New Folder 2', 'success', 'yes', NULL, NULL),
(202, 'Recycle Document', 'Recycled document New Folder from 20170605204927697662/20170605221454746515 to 20170605204927697662/20170605221454746515 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '25', 'archive', '25', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(203, 'Recycle Document', 'Recycled document New Folder 5 from 20170605205839518738 to 20170605205839518738 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '5', 'archive', '5', 'recycle', 'New Folder 5', 'success', 'yes', NULL, NULL),
(204, 'Recycle Document', 'Recycled document New Folder 6 from 20170605211715518929 to 20170605211715518929 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '10', 'archive', '10', 'recycle', 'New Folder 6', 'success', 'yes', NULL, NULL),
(205, 'Recycle Document', 'Recycled document New Folder 7 from 20170605212408835539 to 20170605212408835539 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '14', 'archive', '14', 'recycle', 'New Folder 7', 'success', 'yes', NULL, NULL),
(206, 'Recycle Document', 'Recycled document New Folder 8 from 20170605215822256571 to 20170605215822256571 in {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:16', 'f0860qn07m4m09itng87vao40l', '::1', '20', 'archive', '20', 'recycle', 'New Folder 8', 'success', 'yes', NULL, NULL),
(207, 'Drop Document', 'Drop document justin from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '7', 'recycle', '0', NULL, '20170605204646679990/20170605210444459706.docx dropped from both database and folder', 'success', 'yes', NULL, NULL),
(208, 'Drop Document', 'Drop document lucy from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '8', 'recycle', '0', NULL, '20170605204646679990/20170605211026501694.pdf dropped from both database and folder', 'success', 'yes', NULL, NULL),
(209, 'Drop Document', 'Drop document Watch full military farewell to Preside from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '9', 'recycle', '0', NULL, '20170605204646679990/20170605211236964008.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(210, 'Drop Document', 'Drop document Chris Tomlin - Lord I Need You from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '11', 'recycle', '0', NULL, '20170605204646679990/20170605211807201555.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(211, 'Delete Document Permission', 'Deleted document permission 1 for document 12, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '1', 'read', NULL, NULL, 'Deleted along with document 12', 'success', 'yes', NULL, NULL),
(212, 'Drop Document', 'Drop document New Folder from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '12', 'recycle', '0', NULL, '20170605204646679990/20170605212027134463 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(213, 'Drop Document', 'Drop document Adventist Songs 2017 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '13', 'recycle', '0', NULL, '20170605204646679990/20170605212105403242.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(214, 'Delete Version Of Document', 'Deleted a version of document 20170605212105403242.mp4, id 13 in {{%documents}}from {{%logs}} dated 2017-06-05 21:21:09', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '36', '20170605212105403242.mp4', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(215, 'Drop Document', 'Drop document 3 idiots is a hindi bollywood movie by  from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '15', 'recycle', '0', NULL, '20170605204646679990/20170605212501091393.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(216, 'Delete Version Of Document', 'Deleted a version of document 20170605212501091393.mp4, id 15 in {{%documents}}from {{%logs}} dated 2017-06-05 21:25:05', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '40', '20170605212501091393.mp4', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(217, 'Drop Document', 'Drop document Abeddy Ngosso Kimbilio Langu from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '16', 'recycle', '0', NULL, '20170605204646679990/20170605212507914665.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(218, 'Delete Version Of Document', 'Deleted a version of document 20170605212507914665.mp4, id 16 in {{%documents}}from {{%logs}} dated 2017-06-05 21:25:08', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '42', '20170605212507914665.mp4', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(219, 'Drop Document', 'Drop document Ambassadors Of Christ Choir - Amani (Of from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '17', 'recycle', '0', NULL, '20170605204646679990/20170605212508523355.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(220, 'Delete Version Of Document', 'Deleted a version of document 20170605212508523355.mp4, id 17 in {{%documents}}from {{%logs}} dated 2017-06-05 21:25:08', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '44', '20170605212508523355.mp4', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(221, 'Drop Document', 'Drop document Ambassadors Of Christ Choir - Jamani Tu from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '18', 'recycle', '0', NULL, '20170605204646679990/20170605212508925879.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(222, 'Delete Version Of Document', 'Deleted a version of document 20170605212508925879.mp4, id 18 in {{%documents}}from {{%logs}} dated 2017-06-05 21:25:08', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '46', '20170605212508925879.mp4', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(223, 'Drop Document', 'Drop document As for Me and My House - John Waller from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '19', 'recycle', '0', NULL, '20170605204646679990/20170605212510337886.mp4 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(224, 'Delete Version Of Document', 'Deleted a version of document 20170605212510337886.mp4, id 19 in {{%documents}}from {{%logs}} dated 2017-06-05 21:25:10', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '48', '20170605212510337886.mp4', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(225, 'Drop Document', 'Drop document love you from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '27', 'recycle', '0', NULL, '20170605204646679990/20170605221347535790/20170606205707788345/20170606210504517646.jpg dropped from both database and folder', 'success', 'yes', NULL, NULL),
(226, 'Delete Version Of Document', 'Deleted a version of document 20170606210504517646.jpg, id 27 in {{%documents}}from {{%logs}} dated 2017-06-06 21:05:04', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '111', '20170606210504517646.jpg', NULL, NULL, NULL, 'success', 'no', NULL, NULL),
(227, 'Drop Document', 'Drop document New Folder from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '26', 'recycle', '0', NULL, '20170605204646679990/20170605221347535790/20170606205707788345 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(228, 'Drop Document', 'Drop document New Folder 20170605221347537281 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '23', 'recycle', '0', NULL, '20170605204646679990/20170605221347535790 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(229, 'Delete Document Permission', 'Deleted document permission 2 for document 1, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '2', 'alter', NULL, NULL, 'Deleted along with document 1', 'success', 'yes', NULL, NULL),
(230, 'Drop Document', 'Drop document New Folder 1 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '1', 'recycle', '0', NULL, '20170605204646679990 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(231, 'Drop Document', 'Drop document New Folder from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '25', 'recycle', '0', NULL, '20170605204927697662/20170605221454746515 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(232, 'Delete Document Permission', 'Deleted document permission 3 for document 2, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '3', 'alter', NULL, NULL, 'Deleted along with document 2', 'success', 'yes', NULL, NULL),
(233, 'Drop Document', 'Drop document New Folder 2 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '2', 'recycle', '0', NULL, '20170605204927697662 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(234, 'Delete Document Permission', 'Deleted document permission 10 for document 21, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '10', 'alter', NULL, NULL, 'Deleted along with document 21', 'success', 'yes', NULL, NULL),
(235, 'Drop Document', 'Drop document New Folder 9 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:38', 'f0860qn07m4m09itng87vao40l', '::1', '21', 'recycle', '0', NULL, '20170605215921882288 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(236, 'Delete Document Permission', 'Deleted document permission 4 for document 3, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '4', 'alter', NULL, NULL, 'Deleted along with document 3', 'success', 'yes', NULL, NULL),
(237, 'Drop Document', 'Drop document New Folder 3 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '3', 'recycle', '0', NULL, '20170605205232112042 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(238, 'Delete Document Permission', 'Deleted document permission 6 for document 5, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '6', 'alter', NULL, NULL, 'Deleted along with document 5', 'success', 'yes', NULL, NULL),
(239, 'Drop Document', 'Drop document New Folder 5 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '5', 'recycle', '0', NULL, '20170605205839518738 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(240, 'Drop Document', 'Drop document New Folder from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '6', 'recycle', '0', NULL, '20170605205818829685/20170605205855993231 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(241, 'Drop Document', 'Drop document New Folder 20170605221357807451 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '24', 'recycle', '0', NULL, '20170605205818829685/20170605221357805929 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(242, 'Delete Document Permission', 'Deleted document permission 5 for document 4, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '5', 'alter', NULL, NULL, 'Deleted along with document 4', 'success', 'yes', NULL, NULL),
(243, 'Drop Document', 'Drop document New Folder 4 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '4', 'recycle', '0', NULL, '20170605205818829685 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(244, 'Delete Document Permission', 'Deleted document permission 7 for document 10, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '7', 'alter', NULL, NULL, 'Deleted along with document 10', 'success', 'yes', NULL, NULL),
(245, 'Drop Document', 'Drop document New Folder 6 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '10', 'recycle', '0', NULL, '20170605211715518929 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(246, 'Delete Document Permission', 'Deleted document permission 8 for document 14, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '8', 'alter', NULL, NULL, 'Deleted along with document 14', 'success', 'yes', NULL, NULL),
(247, 'Drop Document', 'Drop document New Folder 7 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '14', 'recycle', '0', NULL, '20170605212408835539 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(248, 'Delete Document Permission', 'Deleted document permission 9 for document 20, section 1 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '9', 'alter', NULL, NULL, 'Deleted along with document 20', 'success', 'yes', NULL, NULL),
(249, 'Drop Document', 'Drop document New Folder 8 from {{%documents}}', 1, 'wsiati', '2017-06-06 23:57:39', 'f0860qn07m4m09itng87vao40l', '::1', '20', 'recycle', '0', NULL, '20170605215822256571 dropped from both database and folder', 'success', 'yes', NULL, NULL),
(250, 'Update Group Access To Folder', 'Updated group 1 access to folder 28 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 00:06:39', 'f0860qn07m4m09itng87vao40l', '::1', NULL, '', '11', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(251, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-07 00:06:39', 'f0860qn07m4m09itng87vao40l', '::1', '0', NULL, '28', '20170607000639414772', NULL, 'success', 'yes', NULL, NULL),
(252, 'Update Group Access To Folder', 'Updated group 1 access to folder 28 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 00:06:59', 'f0860qn07m4m09itng87vao40l', '::1', '11', 'deny', '11', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(253, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-07 05:58:03', 'f0860qn07m4m09itng87vao40l', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(254, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-07 06:41:41', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(255, 'Update Group Access To Folder', 'Updated group 1 access to folder 29 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 06:42:24', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', NULL, '', '12', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(256, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-07 06:42:24', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '0', NULL, '29', '20170607064224556564', NULL, 'success', 'yes', NULL, NULL),
(257, 'Update Group Access To Folder', 'Updated group 1 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 06:42:53', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', NULL, '', '13', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(258, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-07 06:42:53', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '0', NULL, '30', '20170607000639414772/20170607064253706157', NULL, 'success', 'yes', NULL, NULL),
(259, 'Update Group Access To Folder', 'Updated group 1 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 06:43:30', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '13', 'alter', '13', 'read', 'Update', 'success', 'yes', NULL, NULL),
(260, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 06:44:01', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', NULL, '', '14', 'read', 'Insert', 'success', 'yes', NULL, NULL),
(261, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-06-07 06:44:01', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '0', NULL, '31', '20170607000639414772/20170607064253706157/20170607064401495098', NULL, 'success', 'yes', NULL, NULL),
(262, 'Update Group Access To Folder', 'Updated group 1 access to folder 32 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 06:44:18', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', NULL, '', '15', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(263, 'New Document', 'New folder New Folder 20170607064418634545 created in {{%documents}}', 1, 'wsiati', '2017-06-07 06:44:18', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '0', NULL, '32', '20170607000639414772/20170607064418632981', NULL, 'success', 'yes', NULL, NULL),
(264, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-07 07:00:17', 'ifm8s6bu06fc2p6h0nr0edh87r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(265, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-07 09:50:36', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(266, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 09:59:41', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '14', 'read', '14', 'read', 'Update', 'success', 'yes', NULL, NULL),
(267, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:00:15', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '14', 'read', '14', 'read', 'Update', 'success', 'yes', NULL, NULL),
(268, 'Update Group Access To Folder', 'Updated group 1 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:01:02', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '13', 'read', '13', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(269, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:01:20', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '14', 'read', '14', 'alter', 'Update', 'success', 'yes', NULL, NULL),
(270, 'Update Group Access To Folder', 'Updated group 1 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:01:38', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '13', 'alter', '13', 'write', 'Update', 'success', 'yes', NULL, NULL),
(271, 'Update Group Access To Folder', 'Updated group 1 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:10:00', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '13', 'write', '13', 'write', 'Update', 'success', 'yes', NULL, NULL),
(272, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:10:00', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '14', 'alter', '14', 'write', 'Update', 'success', 'yes', NULL, NULL),
(273, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:10:37', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '14', 'write', '14', 'read', 'Update', 'success', 'yes', NULL, NULL),
(274, 'Update Group Access To Folder', 'Updated group 1 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 10:10:49', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '14', 'read', '14', 'write', 'Update', 'success', 'yes', NULL, NULL),
(275, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-07 10:20:51', 'no3g9rj202bgrs0q850q5gcuf7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(276, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-07 22:24:47', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(277, 'Update Group Access To Folder', 'Updated group 2 access to folder 28 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:21', 'n3sk8pgfk132jru67n4rfdaknb', '::1', NULL, '', '16', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(278, 'Update Group Access To Folder', 'Updated group 2 access to folder 29 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:21', 'n3sk8pgfk132jru67n4rfdaknb', '::1', NULL, '', '17', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(279, 'Update Group Access To Folder', 'Updated group 2 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:21', 'n3sk8pgfk132jru67n4rfdaknb', '::1', NULL, '', '18', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(280, 'Update Group Access To Folder', 'Updated group 2 access to folder 31 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:21', 'n3sk8pgfk132jru67n4rfdaknb', '::1', NULL, '', '19', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(281, 'Update Group Access To Folder', 'Updated group 2 access to folder 32 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:21', 'n3sk8pgfk132jru67n4rfdaknb', '::1', NULL, '', '20', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(282, 'Create Group', 'Created new user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-07 22:39:21', 'n3sk8pgfk132jru67n4rfdaknb', '::1', NULL, NULL, '2', 'Lending Group,Lending Department,1', NULL, 'success', 'yes', NULL, NULL),
(283, 'Add User To Group', 'Updated privileges for user 1 in user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-07 22:39:33', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '2', NULL, '2', '1', NULL, 'success', 'yes', NULL, NULL),
(284, 'Update Group Access To Folder', 'Updated group 2 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:40', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '18', 'deny', '18', 'deny', 'Update', 'success', 'yes', NULL, NULL),
(285, 'Update Group Access To Folder', 'Updated group 2 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:39:45', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '18', 'deny', '18', 'deny', 'Update', 'success', 'yes', NULL, NULL),
(286, 'Update Group Access To Folder', 'Updated group 2 access to folder 28 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:40:30', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '16', 'deny', '16', 'write', 'Update', 'success', 'yes', NULL, NULL),
(287, 'Update Group Access To Folder', 'Updated group 2 access to folder 30 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:40:44', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '18', 'deny', '18', 'read', 'Update', 'success', 'yes', NULL, NULL),
(288, 'Update Group Access To Folder', 'Updated group 2 access to folder 28 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:44:40', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '16', 'write', '16', 'read', 'Update', 'success', 'yes', NULL, NULL),
(289, 'Update Group Access To Folder', 'Updated group 1 access to folder 29 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:52:07', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '12', 'deny', '12', 'read', 'Update', 'success', 'yes', NULL, NULL),
(290, 'Update Group Access To Folder', 'Updated group 1 access to folder 29 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:53:14', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '12', 'read', '12', 'deny', 'Update', 'success', 'yes', NULL, NULL),
(291, 'Update Group Access To Folder', 'Updated group 2 access to folder 29 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-07 22:53:17', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '17', 'deny', '17', 'read', 'Update', 'success', 'yes', NULL, NULL),
(292, 'New Document', 'New file love you uploaded into {{%documents}}', 1, 'wsiati', '2017-06-07 23:04:03', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '0', NULL, '33', '20170607000639414772/20170607230403271722.jpg', NULL, 'success', 'yes', NULL, NULL),
(293, 'Document Update', 'Update of document love you in {{%documents}}', 1, 'wsiati', '2017-06-07 23:04:03', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '33', '20170607000639414772/20170607230403271722.jpg', '33', '20170607000639414772/20170607230403271722.jpg', '20170607230403271722.jpg', 'success', 'yes', NULL, NULL),
(294, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-07 23:19:37', 'n3sk8pgfk132jru67n4rfdaknb', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(295, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-08 20:40:24', 'bobi8sko1av70l3iv4nv600ffd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(296, 'Update Group Access To Folder', 'Updated group 1 access to folder 34 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-08 20:40:49', 'bobi8sko1av70l3iv4nv600ffd', '::1', NULL, '', '21', 'alter', 'Insert', 'success', 'yes', NULL, NULL),
(297, 'Update Group Access To Folder', 'Updated group 2 access to folder 34 in {{%documents_permissions}}', 1, 'wsiati', '2017-06-08 20:40:49', 'bobi8sko1av70l3iv4nv600ffd', '::1', NULL, '', '22', 'read', 'Insert', 'success', 'yes', NULL, NULL),
(298, 'New Document', 'New folder New Folder 20170608204049856848 created in {{%documents}}', 1, 'wsiati', '2017-06-08 20:40:49', 'bobi8sko1av70l3iv4nv600ffd', '::1', '0', NULL, '34', '20170607000639414772/20170608204049855283', NULL, 'success', 'yes', NULL, NULL),
(299, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-08 21:21:53', 'bobi8sko1av70l3iv4nv600ffd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(300, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-08 22:41:19', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(301, 'Group Active Status', 'Changed active status of user group Lending Group to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:17', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,1', '2', 'Lending Group,Lending Department,0', NULL, 'success', 'yes', NULL, NULL),
(302, 'Group Active Status', 'Changed active status of user group Lending Group to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:20', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,0', '2', 'Lending Group,Lending Department,1', NULL, 'success', 'yes', NULL, NULL),
(303, 'Group Active Status', 'Changed active status of user group Lending Group to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:24', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,1', '2', 'Lending Group,Lending Department,0', NULL, 'success', 'yes', NULL, NULL),
(304, 'Group Active Status', 'Changed active status of user group Lending Group to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:27', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,0', '2', 'Lending Group,Lending Department,1', NULL, 'success', 'yes', NULL, NULL),
(305, 'Group Active Status', 'Changed active status of user group Ict Department to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:31', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', 'Ict Department,For Ict Department,1', '1', 'Ict Department,For Ict Department,0', NULL, 'success', 'yes', NULL, NULL),
(306, 'Group Active Status', 'Changed active status of user group Ict Department to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:34', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', 'Ict Department,For Ict Department,0', '1', 'Ict Department,For Ict Department,1', NULL, 'success', 'yes', NULL, NULL),
(307, 'Group Active Status', 'Changed active status of user group Ict Department to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:37', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', 'Ict Department,For Ict Department,1', '1', 'Ict Department,For Ict Department,0', NULL, 'success', 'yes', NULL, NULL),
(308, 'Group Active Status', 'Changed active status of user group Ict Department to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:38', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', 'Ict Department,For Ict Department,0', '1', 'Ict Department,For Ict Department,1', NULL, 'success', 'yes', NULL, NULL),
(309, 'Group Active Status', 'Changed active status of user group Ict Department to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:39', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', 'Ict Department,For Ict Department,1', '1', 'Ict Department,For Ict Department,0', NULL, 'success', 'yes', NULL, NULL),
(310, 'Group Active Status', 'Changed active status of user group Ict Department to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:40', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', 'Ict Department,For Ict Department,0', '1', 'Ict Department,For Ict Department,1', NULL, 'success', 'yes', NULL, NULL),
(311, 'Group Active Status', 'Changed active status of user group Lending Group to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:43', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,1', '2', 'Lending Group,Lending Department,0', NULL, 'success', 'yes', NULL, NULL),
(312, 'Group Active Status', 'Changed active status of user group Lending Group to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:44', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,0', '2', 'Lending Group,Lending Department,1', NULL, 'success', 'yes', NULL, NULL),
(313, 'Group Active Status', 'Changed active status of user group Lending Group to 0 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:45', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,1', '2', 'Lending Group,Lending Department,0', NULL, 'success', 'yes', NULL, NULL),
(314, 'Group Active Status', 'Changed active status of user group Lending Group to 1 in {{%sections}}', 1, 'wsiati', '2017-06-08 22:46:46', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', 'Lending Group,Lending Department,0', '2', 'Lending Group,Lending Department,1', NULL, 'success', 'yes', NULL, NULL),
(315, 'Add User To Group', 'Updated privileges for user 1 in user group Lending Group in {{%sections}}', 1, 'wsiati', '2017-06-08 22:48:33', '4kb79ov0osn75ic9ugfrko61cr', '::1', '2', '1', '2', '1', NULL, 'success', 'yes', NULL, NULL),
(316, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-08 23:35:41', '4kb79ov0osn75ic9ugfrko61cr', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(317, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-09 09:19:09', '6edjekt5vkah3us80bsk6f0pj5', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(318, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-09 09:29:17', '6edjekt5vkah3us80bsk6f0pj5', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(319, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-11 01:45:48', 'frfv920qch04u59a5rcvskbm5q', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(320, 'New Document', 'New file love you uploaded into {{%documents}}', 1, 'wsiati', '2017-06-11 01:53:09', 'frfv920qch04u59a5rcvskbm5q', '::1', '0', NULL, '35', '20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg', NULL, 'success', 'yes', NULL, NULL),
(321, 'Document Update', 'Update of document love you in {{%documents}}', 1, 'wsiati', '2017-06-11 01:53:09', 'frfv920qch04u59a5rcvskbm5q', '::1', '35', '20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg', '35', '20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg', '20170611015309375153.jpg', 'success', 'yes', NULL, NULL),
(322, 'Move Document', 'Moved New Folder from 20170607000639414772/20170607064253706157/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-11 01:53:50', 'frfv920qch04u59a5rcvskbm5q', '::1', '31', '20170607000639414772/20170607064253706157/20170607064401495098', '31', '20170607000639414772/20170607064418632981/20170607064401495098', 'New Folder', 'success', 'yes', NULL, NULL),
(323, 'Move Document', 'Moved love you from 20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-11 01:53:50', 'frfv920qch04u59a5rcvskbm5q', '::1', '35', '20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg', '35', '20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg', 'love you', 'success', 'yes', NULL, NULL),
(324, 'Archive Document', 'Archived document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-11 01:54:14', 'frfv920qch04u59a5rcvskbm5q', '::1', '31', 'documents', '31', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(325, 'Archive Document', 'Archived document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-11 01:54:14', 'frfv920qch04u59a5rcvskbm5q', '::1', '35', 'documents', '35', 'archive', 'love you', 'success', 'yes', NULL, NULL),
(326, 'Restore Document From Archive', 'Restored document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-11 02:03:36', 'frfv920qch04u59a5rcvskbm5q', '::1', '31', 'archive', '31', 'documents', 'New Folder', 'success', 'yes', NULL, NULL),
(327, 'Restore Document From Archive', 'Restored document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-11 02:03:36', 'frfv920qch04u59a5rcvskbm5q', '::1', '35', 'archive', '35', 'documents', 'love you', 'success', 'yes', NULL, NULL),
(328, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-11 02:28:12', 'frfv920qch04u59a5rcvskbm5q', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(329, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-12 20:38:34', '5qohb1kdrtsh6pgu3t6hi6cmrb', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(330, 'Zip And Download Documents', 'Zipped and downloaded documents from {{%documents}}', 1, 'wsiati', '2017-06-12 20:38:52', '5qohb1kdrtsh6pgu3t6hi6cmrb', '::1', NULL, NULL, NULL, '33~love you.jpg', 'downloads/20170612203852515860.zip', 'success', 'yes', NULL, NULL),
(331, 'Archive Document', 'Archived document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 20:41:22', '5qohb1kdrtsh6pgu3t6hi6cmrb', '::1', '31', 'documents', '31', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(332, 'Archive Document', 'Archived document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 20:41:22', '5qohb1kdrtsh6pgu3t6hi6cmrb', '::1', '35', 'documents', '35', 'archive', 'love you', 'success', 'yes', NULL, NULL),
(333, 'Zip And Download Documents', 'Zipped and downloaded documents from {{%documents}}', 1, 'wsiati', '2017-06-12 20:41:33', '5qohb1kdrtsh6pgu3t6hi6cmrb', '::1', NULL, NULL, NULL, '35~love you.jpg', 'downloads/20170612204133243900.zip', 'success', 'yes', NULL, NULL),
(334, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-12 21:22:31', '5qohb1kdrtsh6pgu3t6hi6cmrb', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(335, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-12 21:25:17', '43v8hmooaf8nf5a1n2td31otoa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(336, 'Restore Document From Archive', 'Restored document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 21:25:37', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'archive', '31', 'documents', 'New Folder', 'success', 'yes', NULL, NULL),
(337, 'Restore Document From Archive', 'Restored document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 21:25:37', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'archive', '35', 'documents', 'love you', 'success', 'yes', NULL, NULL),
(338, 'Archive Document', 'Archived document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 21:31:45', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'documents', '31', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(339, 'Archive Document', 'Archived document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 21:31:45', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'documents', '35', 'archive', 'love you', 'success', 'yes', NULL, NULL),
(340, 'Recycle Document', 'Recycled document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 21:31:58', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'archive', '31', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(341, 'Recycle Document', 'Recycled document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 21:31:58', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'archive', '35', 'recycle', 'love you', 'success', 'yes', NULL, NULL),
(342, 'Restore Document From Recycle To Documents', 'Restored document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 21:32:12', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'recycle', '31', 'documents', 'New Folder', 'success', 'yes', NULL, NULL),
(343, 'Restore Document From Recycle To Documents', 'Restored document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 21:32:12', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'recycle', '35', 'documents', 'love you', 'success', 'yes', NULL, NULL),
(344, 'Rename Document', 'Rename document from New Folder to New Folder in {{%documents}}', 1, 'wsiati', '2017-06-12 21:39:40', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'New Folder', '31', 'New Folder', '20170607000639414772/20170607064418632981/20170607064401495098', 'success', 'yes', NULL, NULL),
(345, 'New Document', 'New file pass uploaded into {{%documents}}', 1, 'wsiati', '2017-06-12 21:43:10', '43v8hmooaf8nf5a1n2td31otoa', '::1', '0', NULL, '36', '20170607000639414772/20170608204049855283/20170612214310514583.png', NULL, 'success', 'yes', NULL, NULL),
(346, 'Document Update', 'Update of document pass in {{%documents}}', 1, 'wsiati', '2017-06-12 21:43:10', '43v8hmooaf8nf5a1n2td31otoa', '::1', '36', '20170607000639414772/20170608204049855283/20170612214310514583.png', '36', '20170607000639414772/20170608204049855283/20170612214310514583.png', '20170612214310514583.png', 'success', 'yes', NULL, NULL),
(347, 'Download Document', 'Dowloaded document pass, id 36 from {{%documents}}', 1, 'wsiati', '2017-06-12 21:43:20', '43v8hmooaf8nf5a1n2td31otoa', '::1', '36', '20170607000639414772/20170608204049855283/20170612214310514583.png', '36', 'first/20170607000639414772/20170608204049855283/20170612214310514583.png', 'downloads/20170612214310514583.png', 'success', 'yes', NULL, NULL),
(348, 'New Document', 'New file love you uploaded into {{%documents}}', 1, 'wsiati', '2017-06-12 21:43:37', '43v8hmooaf8nf5a1n2td31otoa', '::1', '0', NULL, '37', '20170607000639414772/20170608204049855283/20170612214337802144.jpg', NULL, 'success', 'yes', NULL, NULL),
(349, 'Document Update', 'Update of document love you in {{%documents}}', 1, 'wsiati', '2017-06-12 21:43:37', '43v8hmooaf8nf5a1n2td31otoa', '::1', '37', '20170607000639414772/20170608204049855283/20170612214337802144.jpg', '37', '20170607000639414772/20170608204049855283/20170612214337802144.jpg', '20170612214337802144.jpg', 'success', 'yes', NULL, NULL),
(350, 'Archive Document', 'Archived document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 21:51:03', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'documents', '31', 'archive', 'New Folder', 'success', 'yes', NULL, NULL),
(351, 'Archive Document', 'Archived document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 21:51:03', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'documents', '35', 'archive', 'love you', 'success', 'yes', NULL, NULL),
(352, 'Create New Mail Contact', 'Created mail contact Shadrack Wabomba in {{%documents_mailings_contacts}}', 1, 'wsiati', '2017-06-12 22:24:48', '43v8hmooaf8nf5a1n2td31otoa', '::1', NULL, '', '1', 'Shadrack Wabomba, wsiati@live.com', NULL, 'success', 'yes', NULL, NULL),
(353, 'Update Mail Contact', 'Updated mail contact Shadrack Wabomba in {{%documents_mailings_contacts}}', 1, 'wsiati', '2017-06-12 22:25:21', '43v8hmooaf8nf5a1n2td31otoa', '::1', '1', 'Shadrack Wabomba, wsiati@live.com', '1', 'Shadrack Wabomba, wsiati@live.com', NULL, 'success', 'yes', NULL, NULL),
(354, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-06-12 22:51:41', '43v8hmooaf8nf5a1n2td31otoa', '::1', '1', 'Love You', '1', 'mailzips/20170612225139373965.zip', '35~love you.jpg', 'failed', 'yes', NULL, NULL),
(355, 'Recycle Document', 'Recycled document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 22:57:33', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'archive', '31', 'recycle', 'New Folder', 'success', 'yes', NULL, NULL),
(356, 'Recycle Document', 'Recycled document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 22:57:33', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'archive', '35', 'recycle', 'love you', 'success', 'yes', NULL, NULL),
(357, 'Restore Document From Recycle To Documents', 'Restored document New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064418632981/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 22:57:39', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', 'recycle', '31', 'documents', 'New Folder', 'success', 'yes', NULL, NULL),
(358, 'Restore Document From Recycle To Documents', 'Restored document love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 22:57:39', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', 'recycle', '35', 'documents', 'love you', 'success', 'yes', NULL, NULL);
INSERT INTO `tbl_logs` (`id`, `type`, `description`, `created_by`, `author_name`, `created_at`, `session_id`, `session_ip`, `origin_id`, `origin_value`, `destination_id`, `destination_value`, `further_narration`, `status`, `available`, `updated_by`, `updated_at`) VALUES
(359, 'Move Document', 'Moved New Folder from 20170607000639414772/20170607064418632981/20170607064401495098 to 20170607000639414772/20170607064253706157/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 22:58:37', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', '20170607000639414772/20170607064418632981/20170607064401495098', '31', '20170607000639414772/20170607064253706157/20170607064401495098', 'New Folder', 'success', 'yes', NULL, NULL),
(360, 'Move Document', 'Moved love you from 20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 22:58:37', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', '20170607000639414772/20170607064418632981/20170607064401495098/20170611015309375153.jpg', '35', '20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg', 'love you', 'success', 'yes', NULL, NULL),
(361, 'Move Document', 'Moved New Folder 20170612225913014659 from 20170607000639414772/20170607064253706157/20170607064401495098 to 20170607000639414772/20170607064401495098 in {{%documents}}', 1, 'wsiati', '2017-06-12 22:59:13', '43v8hmooaf8nf5a1n2td31otoa', '::1', '31', '20170607000639414772/20170607064253706157/20170607064401495098', '31', '20170607000639414772/20170607064401495098', 'New Folder 20170612225913014659', 'success', 'yes', NULL, NULL),
(362, 'Move Document', 'Moved love you from 20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg to 20170607000639414772/20170607064401495098/20170611015309375153.jpg in {{%documents}}', 1, 'wsiati', '2017-06-12 22:59:13', '43v8hmooaf8nf5a1n2td31otoa', '::1', '35', '20170607000639414772/20170607064253706157/20170607064401495098/20170611015309375153.jpg', '35', '20170607000639414772/20170607064401495098/20170611015309375153.jpg', 'love you', 'success', 'yes', NULL, NULL),
(363, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-13 05:53:28', '43v8hmooaf8nf5a1n2td31otoa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(364, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-16 23:28:01', 'o23u7rm9hmqhig747fptm3qo1j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(365, 'Download Document', 'Dowloaded document love you, id 33 from {{%documents}}', 1, 'wsiati', '2017-06-16 23:36:38', 'o23u7rm9hmqhig747fptm3qo1j', '::1', '33', '20170607000639414772/20170607230403271722.jpg', '33', 'first/20170607000639414772/20170607230403271722.jpg', 'downloads/20170607230403271722.jpg', 'success', 'yes', NULL, NULL),
(366, 'Download Document', 'Dowloaded document pass, id 36 from {{%documents}}', 1, 'wsiati', '2017-06-16 23:36:59', 'o23u7rm9hmqhig747fptm3qo1j', '::1', '36', '20170607000639414772/20170608204049855283/20170612214310514583.png', '36', 'first/20170607000639414772/20170608204049855283/20170612214310514583.png', 'downloads/20170612214310514583.png', 'success', 'yes', NULL, NULL),
(367, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-16 23:47:19', 'o23u7rm9hmqhig747fptm3qo1j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(368, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-16 23:52:12', 'c1t1obtbc1gq1a4it09sctcjrc', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(369, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 00:17:40', 'c1t1obtbc1gq1a4it09sctcjrc', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(370, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 00:20:53', '4vvce4ca94g59pfr9n8hciue58', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(371, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 00:40:53', '4vvce4ca94g59pfr9n8hciue58', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(372, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 00:43:47', '4cp7d8kg3usnv2gs2nvg171hc3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(373, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 01:05:09', '4cp7d8kg3usnv2gs2nvg171hc3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(374, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 01:23:52', 'a8rc3668777m7viepea59mgmts', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(375, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 01:42:50', 'a8rc3668777m7viepea59mgmts', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(376, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 01:43:46', '36t7rnrdctm9ifl3clkm67qojh', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(377, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 02:09:45', '36t7rnrdctm9ifl3clkm67qojh', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(378, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 03:27:08', '2er4ddo3oebs6ms6jkpfmj7u1s', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(379, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 04:06:21', '2er4ddo3oebs6ms6jkpfmj7u1s', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(380, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 04:15:39', 'l719shdtuphvfstpiq3t3uo1ap', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(381, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 20:25:32', 'l719shdtuphvfstpiq3t3uo1ap', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(382, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 21:04:02', 'o64p9f0ba04s2gkn4gtn1ksaen', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(383, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 21:34:06', 'o64p9f0ba04s2gkn4gtn1ksaen', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(384, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-17 22:13:22', 'bkkdb1ann53u33eot3bfs3dic3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(385, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-17 22:27:14', 'bkkdb1ann53u33eot3bfs3dic3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(386, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-18 23:51:35', 'a77ih68ul6k453ifuer5b4h9au', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(387, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-19 08:44:58', 'a77ih68ul6k453ifuer5b4h9au', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(388, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-19 12:49:54', 'mcimjsui454knc4sqrr947l7oo', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(389, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-19 13:11:11', 'mcimjsui454knc4sqrr947l7oo', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(390, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-19 22:32:44', 'rff30he5p6ii7260t60liev04g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(391, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-19 22:42:59', 'rff30he5p6ii7260t60liev04g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(392, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-19 22:43:24', 'n5077ae2272m6vsmthm5vbpmnp', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(393, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-19 23:27:55', 'n5077ae2272m6vsmthm5vbpmnp', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(394, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-19 23:51:57', '0u0vb6uabsi8ump3hbrk33fsei', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(395, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-20 08:33:02', '0u0vb6uabsi8ump3hbrk33fsei', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(396, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-20 08:45:34', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(397, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-20 10:47:38', '6hhn94kdskma6sogroot8909pp', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(398, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-20 11:05:03', '6hhn94kdskma6sogroot8909pp', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(399, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-20 19:11:13', '0oisspeq24du5ijqaspsluhflg', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(400, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-20 20:30:27', '0oisspeq24du5ijqaspsluhflg', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(401, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-20 22:07:28', '49a0ofekkl8t758je472bf1385', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(402, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-20 23:07:27', '49a0ofekkl8t758je472bf1385', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(403, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-21 00:37:35', '6r49mpgtqggnh6lhgbketmc624', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(404, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-21 00:49:14', '6r49mpgtqggnh6lhgbketmc624', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(405, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-21 00:59:15', '1ktl72s2c1bi5t5p4jcm33gssn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(406, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-21 08:29:10', '1ktl72s2c1bi5t5p4jcm33gssn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(407, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-21 21:51:51', '4ksrrf46o4cok6arjbna3mj18e', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(408, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-21 22:11:09', '4ksrrf46o4cok6arjbna3mj18e', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(409, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-21 22:41:19', '3el3h45itki4gr5al99l0vh6ia', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(410, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-21 23:46:16', '3el3h45itki4gr5al99l0vh6ia', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(411, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-21 23:50:35', 'siagqs8466v800jpp6coh7flea', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(412, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-22 08:22:03', 'siagqs8466v800jpp6coh7flea', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(413, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-22 08:52:39', 'iqcc4916m7v7h10buq4385gc24', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(414, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-22 09:10:50', 'iqcc4916m7v7h10buq4385gc24', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(415, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-22 21:49:03', '2d67oan21scjv7o3fvpf1ref3k', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(416, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-22 21:59:24', '2d67oan21scjv7o3fvpf1ref3k', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(417, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-23 09:11:10', 'fkn53imnndpbotpom7e2l72ep8', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(418, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-23 09:30:19', 'fkn53imnndpbotpom7e2l72ep8', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(419, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-23 10:25:27', '67b3lmeuqm8hi9br3hdime7pt3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(420, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-23 10:58:56', '67b3lmeuqm8hi9br3hdime7pt3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(421, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-23 12:36:46', 'vm030a0f703nk3c0n5i6pinisa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(422, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-23 12:49:17', 'vm030a0f703nk3c0n5i6pinisa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(423, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 07:38:25', 'fs0oj6uni2iu06b9ondcu5oeaf', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(424, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 09:02:12', 'fs0oj6uni2iu06b9ondcu5oeaf', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(425, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 09:21:50', '5blhthtqbf83tgreufn7e7ilrr', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(426, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 10:34:43', '5blhthtqbf83tgreufn7e7ilrr', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(427, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 10:38:57', 'h050lkojlp9uea3vvpmurcu853', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(428, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 10:56:02', 'h050lkojlp9uea3vvpmurcu853', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(429, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 10:58:38', 'lqbsutfuilgmvthtmcg56ejmg2', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(430, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 11:15:04', 'lqbsutfuilgmvthtmcg56ejmg2', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(431, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 13:01:36', 'qv719vma4ctpdjg2koa2an36dn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(432, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 13:11:43', 'qv719vma4ctpdjg2koa2an36dn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(433, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 13:32:06', '0innb9vf69dftgr5d57lf7o48s', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(434, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 14:09:16', '0innb9vf69dftgr5d57lf7o48s', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(435, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 14:10:45', 'e72qk2u96noq8t83n3tn4478ik', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(436, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 15:02:42', 'e72qk2u96noq8t83n3tn4478ik', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(437, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 16:50:35', '8ac0shb995dtc7ks7qg791146b', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(438, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 17:06:40', '8ac0shb995dtc7ks7qg791146b', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(439, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 17:12:24', 'e23hpmaun28hpps8glp35haejd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(440, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 19:03:55', 'e23hpmaun28hpps8glp35haejd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(441, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 19:04:48', 'pj33e8805shqe6ogl0pqfqobnp', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(442, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 19:20:24', 'pj33e8805shqe6ogl0pqfqobnp', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(443, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 19:59:41', 'eekubmco8fdrhi5s86mm7l065i', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(444, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 22:03:52', 'eekubmco8fdrhi5s86mm7l065i', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(445, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 22:06:19', 'dp2uairdsvqcif39qf4bpevrf7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(446, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 22:17:39', 'dp2uairdsvqcif39qf4bpevrf7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(447, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-27 22:23:29', 'qgpo00l6ooc5c9tgfjnpl9eade', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(448, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-27 23:40:37', 'qgpo00l6ooc5c9tgfjnpl9eade', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(449, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-28 00:06:20', '20j70mv39lh6p9fqcq1skuvglf', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(450, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-28 08:17:46', '20j70mv39lh6p9fqcq1skuvglf', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(451, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-28 09:08:27', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(452, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-28 21:00:35', 'bar5nkb7ubc3h7nn0fgujrjnhh', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(453, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-28 21:30:51', 'bar5nkb7ubc3h7nn0fgujrjnhh', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(454, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-28 21:57:20', '5oq3p39hb8fd8hd6mh25f0topo', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(455, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-29 07:54:05', '5oq3p39hb8fd8hd6mh25f0topo', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(456, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-29 21:47:39', 'rtt34adttirurcu7hgv12875do', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(457, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-29 21:58:57', 'rtt34adttirurcu7hgv12875do', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(458, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-29 22:31:13', 'baq68gkckgatv8q06lqsk8bm3c', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(459, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-29 23:18:21', 'baq68gkckgatv8q06lqsk8bm3c', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(460, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-29 23:47:40', '2rqfl6v4ggpqb13b7hasl5264u', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(461, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-30 00:24:25', '2rqfl6v4ggpqb13b7hasl5264u', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(462, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-30 00:38:28', 'mt3spsf7f7lords3d19afkfkrm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(463, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-30 08:04:11', 'mt3spsf7f7lords3d19afkfkrm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(464, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-30 19:18:32', '4prcgb54vfgsdenodn7raq0m3o', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(465, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-30 19:30:13', '4prcgb54vfgsdenodn7raq0m3o', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(466, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-30 21:10:44', 'v71p5unb32s4ngbop780vj4nmq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(467, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-30 22:31:44', 'v71p5unb32s4ngbop780vj4nmq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(468, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-30 22:32:25', '747lebibmlii5gv8l77nffvgdm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(469, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-06-30 22:42:55', '747lebibmlii5gv8l77nffvgdm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(470, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-06-30 22:47:37', 'b1ipc5o31fm1a6ol3pn39s0cp0', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(471, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-01 09:12:05', 'b1ipc5o31fm1a6ol3pn39s0cp0', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(472, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-01 19:09:18', 'pjdbmgbp82fvlaok5pimg2abiu', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(473, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-01 19:20:19', 'pjdbmgbp82fvlaok5pimg2abiu', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(474, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-01 19:49:35', 'cqr1stkol2il63gd6evj91ta3b', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(475, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-01 20:37:52', 'cqr1stkol2il63gd6evj91ta3b', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(476, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-01 20:41:46', '9vt7dstg27srq9fcb1tmr5feul', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(477, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-01 22:01:27', '9vt7dstg27srq9fcb1tmr5feul', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(478, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-01 22:05:50', '5f3hh46orl7trodj37o355qf29', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(479, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-02 14:41:07', '5f3hh46orl7trodj37o355qf29', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(480, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-02 14:44:41', '8jnl2roslhlctns7mkh37mcg1g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(481, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-02 17:44:37', '8jnl2roslhlctns7mkh37mcg1g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(482, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-02 17:56:25', 'rp57tlhsqlmkgbpbnjsdi8kovd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(483, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-02 20:34:59', 'rp57tlhsqlmkgbpbnjsdi8kovd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(484, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-02 20:51:23', 'iohs8rt9bpm6lin7qg97jmifms', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(485, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-02 21:07:14', 'iohs8rt9bpm6lin7qg97jmifms', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(486, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-03 19:36:18', 'j3sclckv994gll8ni43od51eoq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(487, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-03 20:11:31', 'j3sclckv994gll8ni43od51eoq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(488, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-03 20:21:30', '15kntp4j27jaksj6ve0dgvqqn5', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(489, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-03 21:37:14', '15kntp4j27jaksj6ve0dgvqqn5', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(490, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-03 22:03:15', 'n6qbsrog44md7ck3sdfdnvd6vq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(491, 'Update Group Access To Folder', 'Updated group 1 access to folder 38 in {{%documents_permissions}}', 1, 'wsiati', '2017-07-03 22:18:51', 'n6qbsrog44md7ck3sdfdnvd6vq', '::1', NULL, '', '23', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(492, 'Update Group Access To Folder', 'Updated group 2 access to folder 38 in {{%documents_permissions}}', 1, 'wsiati', '2017-07-03 22:18:51', 'n6qbsrog44md7ck3sdfdnvd6vq', '::1', NULL, '', '24', 'deny', 'Insert', 'success', 'yes', NULL, NULL),
(493, 'New Document', 'New folder New Folder created in {{%documents}}', 1, 'wsiati', '2017-07-03 22:18:51', 'n6qbsrog44md7ck3sdfdnvd6vq', '::1', '0', NULL, '38', '20170703221850973001', NULL, 'success', 'yes', NULL, NULL),
(494, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-03 22:29:13', 'n6qbsrog44md7ck3sdfdnvd6vq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(495, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-03 23:10:00', 'pbtlmvv1sllss9l1gg84l6g94j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(496, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 05:47:48', 'pbtlmvv1sllss9l1gg84l6g94j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(497, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-04 05:51:53', '3vepd69k4bfn4c18qifou8igrc', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(498, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 07:17:31', '3vepd69k4bfn4c18qifou8igrc', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(499, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-04 07:20:58', '2j8mq1ciggp47ptsfn5kkka1d4', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(500, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 07:31:08', '2j8mq1ciggp47ptsfn5kkka1d4', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(501, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-04 08:41:07', 's4qu48p3jo52fhb7ffo29dov34', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(502, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 08:54:33', 's4qu48p3jo52fhb7ffo29dov34', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(503, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-04 14:21:25', '3hv51fm5i9ke6osa6g9ol64its', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(504, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 14:44:00', '3hv51fm5i9ke6osa6g9ol64its', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(505, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-04 14:54:30', 'bct01lj7q3tuhsc2q6avdu6mvm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(506, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 15:10:17', 'bct01lj7q3tuhsc2q6avdu6mvm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(507, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-04 19:46:39', 'rhlc419r6bccjjesr9eeiegi1e', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(508, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-04 22:28:36', 'rhlc419r6bccjjesr9eeiegi1e', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(509, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-05 06:05:04', 'kf2reb7qk312ai5n63ca8at6sv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(510, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-05 06:16:15', 'kf2reb7qk312ai5n63ca8at6sv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(511, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-05 21:06:23', 'elj4emskt1cihdrlj74la9f56a', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(512, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-05 22:23:09', 'elj4emskt1cihdrlj74la9f56a', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(513, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-06 06:17:30', 'ivrs2rnc258hp23662ui7r931h', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(514, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-06 07:23:51', 'ivrs2rnc258hp23662ui7r931h', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(515, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-06 18:59:53', 'hfa3lrslovcscgk86o1m7m1kol', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(516, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-06 19:22:15', 'hfa3lrslovcscgk86o1m7m1kol', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(517, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-06 23:03:28', 'pkg72slg2rq5gbc2h76bf7f5kj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(518, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-07 05:46:51', 'pkg72slg2rq5gbc2h76bf7f5kj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(519, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-07 07:21:35', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(520, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-07 21:06:57', 'ou4gdbmm923ej2hhq554s0fse9', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(521, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-07 21:58:58', 'ou4gdbmm923ej2hhq554s0fse9', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(522, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-07 22:20:59', 'o8eai4r7gt2gu0do62ovsdig2c', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(523, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-07 23:37:12', 'o8eai4r7gt2gu0do62ovsdig2c', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(524, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-08 13:58:12', 'gth1j3om2531hi9blua0nq0qbs', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(525, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-08 17:14:43', 'gth1j3om2531hi9blua0nq0qbs', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(526, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-08 20:37:02', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(527, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-08 20:37:41', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(528, 'Document Movable Updatable Deletable', 'Updated document, New Folder, property can_be_updated from 1 to 0 in {{%documents}}', 1, 'wsiati', '2017-07-08 21:34:10', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '28', '1', '28', '0', '20170607000639414772', 'success', 'yes', NULL, NULL),
(529, 'Document Movable Updatable Deletable', 'Updated document, New Folder, property can_be_updated from 0 to 1 in {{%documents}}', 1, 'wsiati', '2017-07-08 21:34:11', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '28', '0', '28', '1', '20170607000639414772', 'success', 'yes', NULL, NULL),
(530, 'Document Movable Updatable Deletable', 'Updated document, New Folder, property can_be_updated from 1 to 0 in {{%documents}}', 1, 'wsiati', '2017-07-08 21:34:12', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '28', '1', '28', '0', '20170607000639414772', 'success', 'yes', NULL, NULL),
(531, 'Document Movable Updatable Deletable', 'Updated document, New Folder, property can_be_updated from 0 to 1 in {{%documents}}', 1, 'wsiati', '2017-07-08 21:34:12', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '28', '0', '28', '1', '20170607000639414772', 'success', 'yes', NULL, NULL),
(532, 'Update Document Description', 'Updated description for document New Folder in {{%documents}}', 1, 'wsiati', '2017-07-08 21:34:27', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '28', NULL, '28', '', NULL, 'success', 'yes', NULL, NULL),
(533, 'Rename Document', 'Rename document from love you to Love You in {{%documents}}', 1, 'wsiati', '2017-07-08 21:36:09', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '33', 'love you', '33', 'Love You', '20170607000639414772/20170607230403271722.jpg', 'success', 'yes', NULL, NULL),
(534, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-09 12:41:44', '5qi6jei5fl4cj41e9g1e8h2vjl', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(535, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-09 14:15:58', 'f044f43o8r1q1bf8ro3aafbk6u', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(536, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-09 14:40:44', 'f044f43o8r1q1bf8ro3aafbk6u', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(537, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-09 17:58:13', '71ern8s5mgtv9tp9q3jd52uor1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(538, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-09 18:10:17', '71ern8s5mgtv9tp9q3jd52uor1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(539, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-09 19:35:32', 'uljrhabssdgtn314tvau1qul6e', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(540, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-09 19:55:30', 'uljrhabssdgtn314tvau1qul6e', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(541, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-09 21:10:45', '18ls1e782u20logrgerii0nne0', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(542, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-09 21:35:49', '18ls1e782u20logrgerii0nne0', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(543, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-10 06:27:22', '97ec51cdl33src6e0v7tv3obj1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(544, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-10 06:44:59', '97ec51cdl33src6e0v7tv3obj1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(545, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-10 06:51:48', 'lod79tihpqi5ei3n54qq5rqj0r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(546, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-10 07:56:42', 'lod79tihpqi5ei3n54qq5rqj0r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(547, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-10 20:03:17', '35a94of9qc4p51pp1ms3um2iej', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(548, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-10 20:27:01', '35a94of9qc4p51pp1ms3um2iej', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(549, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-10 20:33:11', 'gp8cr0omm37ape72mtlacrk5uj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(550, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-10 20:43:26', 'gp8cr0omm37ape72mtlacrk5uj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(551, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-11 21:19:50', 'gad6g7ju3s17102l2hj6oih84i', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(552, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-12 05:52:01', 'gad6g7ju3s17102l2hj6oih84i', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(553, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-12 05:52:57', 'or9sap24jthghmbkls7fm1nlmi', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(554, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-12 06:15:41', 'or9sap24jthghmbkls7fm1nlmi', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(555, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-12 21:22:45', '7lfgeco0247c93p514rcnucuuk', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(556, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-13 05:43:26', '7lfgeco0247c93p514rcnucuuk', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(557, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-13 06:07:58', 'huqcqjrobe4pe23iluaj68alhd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(558, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-13 07:20:08', 'huqcqjrobe4pe23iluaj68alhd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(559, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-13 19:45:20', '84gg78t77q663bvuljgv4737vj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(560, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-14 05:54:24', '84gg78t77q663bvuljgv4737vj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(561, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-14 05:55:11', 'phqsa43gldse0truf7hnrif4a4', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(562, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-14 06:56:45', 'phqsa43gldse0truf7hnrif4a4', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(563, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-17 10:19:19', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(564, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 10:20:29', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', '2', 'My Documents', '2', 'mailzips/20170717102020753447.zip', '33~Love You.jpg', 'success', 'yes', NULL, NULL),
(565, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 10:20:54', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', '2', 'My Documents', '2', 'mailzips/20170717102050188544.zip', '33~Love You.jpg', 'success', 'yes', NULL, NULL),
(566, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 10:22:14', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', '2', 'My Documents', '2', 'mailzips/20170717102201476632.zip', '33~Love You.jpg', 'success', 'yes', NULL, NULL),
(567, 'Create New Mail Contact', 'Created mail contact Wabomba Shadrack in {{%documents_mailings_contacts}}', 1, 'wsiati', '2017-07-17 10:23:03', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', NULL, '', '2', 'Wabomba Shadrack, wmukhandia@gmail.com', NULL, 'success', 'yes', NULL, NULL),
(568, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 10:23:27', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', '2', 'My Documents', '2', 'mailzips/20170717102318531173.zip', '33~Love You.jpg', 'success', 'yes', NULL, NULL),
(569, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-17 10:34:03', '47c71v6vi2ie8f9afl4bb0kjr9', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(570, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-17 10:44:01', '5lkss31hnf5t6m13mcbmqt4g4i', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(571, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 10:45:06', '5lkss31hnf5t6m13mcbmqt4g4i', '::1', '3', 'My Docs', '3', 'mailzips/20170717104504457859.zip', '33~Love You.jpg,35~love you.jpg,36~pass.png,37~love you 1.jpg', 'failed', 'yes', NULL, NULL),
(572, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 11:55:03', '5lkss31hnf5t6m13mcbmqt4g4i', '::1', '4', 'Doc Hizi', '4', 'mailzips/20170717115436042052.zip', '33~Love You.jpg', 'success', 'yes', NULL, NULL),
(573, 'Send Documents By Mail', 'Sent documents via mail captured in {{%documents_mailings}}', 1, 'wsiati', '2017-07-17 11:58:45', '5lkss31hnf5t6m13mcbmqt4g4i', '::1', '5', 'Docs Za Mwisho', '5', 'mailzips/20170717115829073532.zip', '33~Love You.jpg', 'success', 'yes', NULL, NULL),
(574, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-17 13:31:34', '5lkss31hnf5t6m13mcbmqt4g4i', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(575, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-18 05:46:50', 'gcvpf6vah8n564kbflhmpl6ug3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(576, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-18 06:19:04', 'gcvpf6vah8n564kbflhmpl6ug3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(577, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-18 06:28:03', 'h7par4460a3j5i8jegi712tgl1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(578, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-18 07:13:19', 'h7par4460a3j5i8jegi712tgl1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(579, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-18 07:30:44', 'rdck6ijikrtusou1uku5vabmrf', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(580, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-18 07:54:39', 'rdck6ijikrtusou1uku5vabmrf', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(581, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-18 16:50:48', 'd9oqonqg2nmh73uehgimr06mkd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(582, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-18 17:11:20', 'd9oqonqg2nmh73uehgimr06mkd', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(583, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-18 19:40:54', 'kv8bra118idac8eleb5nrr9o31', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(584, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-19 06:03:15', 'kv8bra118idac8eleb5nrr9o31', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(585, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-19 06:09:37', '2olu1jbq98931gjmadta8sp3qa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(586, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-19 07:01:39', '2olu1jbq98931gjmadta8sp3qa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(587, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-19 07:52:56', 'cqpk900ecusreqrue12ilokpg6', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(588, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-19 08:13:39', 'cqpk900ecusreqrue12ilokpg6', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(589, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-19 20:31:51', 'mm9snpcmara8h0j0r6kp7857tk', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(590, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-19 20:48:30', 'mm9snpcmara8h0j0r6kp7857tk', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(591, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-19 20:57:30', 'daskajtts813tl4rnb5k2kttql', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL);
INSERT INTO `tbl_logs` (`id`, `type`, `description`, `created_by`, `author_name`, `created_at`, `session_id`, `session_ip`, `origin_id`, `origin_value`, `destination_id`, `destination_value`, `further_narration`, `status`, `available`, `updated_by`, `updated_at`) VALUES
(592, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-19 21:24:05', 'daskajtts813tl4rnb5k2kttql', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(593, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 07:16:55', '98c0ekj72r0hstkfot2oluns92', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(594, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 07:53:55', '98c0ekj72r0hstkfot2oluns92', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(595, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 08:20:19', 'aijrjiiq8tt5cqd0h8ov72kqaa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(596, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 08:30:34', 'aijrjiiq8tt5cqd0h8ov72kqaa', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(597, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 08:32:23', 'pbj2mg0qcv0l4pkaa79so9gq0q', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(598, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 09:10:36', 'pbj2mg0qcv0l4pkaa79so9gq0q', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(599, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 09:29:51', 'df85fk8f7mfoqn10b54jvhhhbk', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(600, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 09:39:58', 'df85fk8f7mfoqn10b54jvhhhbk', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(601, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 09:44:47', 'ffj9mp8at9m4965atscjvnm1jn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(602, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 10:00:30', 'ffj9mp8at9m4965atscjvnm1jn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(603, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 11:39:56', 'vin1b8iksip33no7g5qspvf5vj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(604, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 11:55:05', 'vin1b8iksip33no7g5qspvf5vj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(605, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 12:01:29', 'enkuse1ioqhgrce0258fng8n1a', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(606, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 13:19:44', 'enkuse1ioqhgrce0258fng8n1a', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(607, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 13:22:24', 'c10rstuenvvjjl4r9eengmha1a', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(608, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 13:33:24', 'c10rstuenvvjjl4r9eengmha1a', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(609, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 13:50:17', '6b2q480nl4vlm8o48d6on2teek', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(610, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 14:11:46', '6b2q480nl4vlm8o48d6on2teek', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(611, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 15:24:20', 'l2dsv524sp4gnkfpt6kqjv2id7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(612, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 15:46:51', 'l2dsv524sp4gnkfpt6kqjv2id7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(613, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 19:12:42', 'auds2bg25k02vr2obktnuisq89', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(614, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 19:25:28', 'auds2bg25k02vr2obktnuisq89', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(615, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 19:43:55', 'gfkhg3arhro0tuj4l1t8r8s90q', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(616, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 21:06:18', 'gfkhg3arhro0tuj4l1t8r8s90q', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(617, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-20 22:15:47', '3sv2c7a1n8is2ooouoook15e7j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(618, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-20 22:40:05', '3sv2c7a1n8is2ooouoook15e7j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(619, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 06:26:37', '9gjme3und013m5iuv4eh3tnv4b', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(620, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 06:42:23', '9gjme3und013m5iuv4eh3tnv4b', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(621, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 06:55:50', 'pfdgbslj0u4re9sofboog0fnt5', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(622, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 07:07:22', 'pfdgbslj0u4re9sofboog0fnt5', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(623, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 07:31:15', 'cicd9eibio0q3v411gfm48gb1j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(624, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 07:43:46', 'cicd9eibio0q3v411gfm48gb1j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(625, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 07:46:24', '4rsiv496jgj9v0oteshnuq2f33', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(626, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 08:04:01', '4rsiv496jgj9v0oteshnuq2f33', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(627, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 09:22:17', 'tn5rl72tmebjtq4ek2oe1v54f7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(628, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 10:05:56', 'tn5rl72tmebjtq4ek2oe1v54f7', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(629, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 11:04:40', 'm7qtjgoq20m5q8lphkst54i58r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(630, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 11:43:21', 'm7qtjgoq20m5q8lphkst54i58r', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(631, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 12:10:59', 'ngef3bsfb3o9dc5r89skre3u4g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(632, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 13:02:01', 'ngef3bsfb3o9dc5r89skre3u4g', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(633, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 16:04:12', '1dr26k1b3qot2ti5gslpniikvm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(634, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-21 16:14:18', '1dr26k1b3qot2ti5gslpniikvm', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(635, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-21 22:41:41', 'rupq6at9q04q0mer9vjbl0pj8p', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(636, 'Zip And Download Documents', 'Zipped and downloaded documents from {{%documents}}', 1, 'wsiati', '2017-07-21 22:43:41', 'rupq6at9q04q0mer9vjbl0pj8p', '::1', NULL, NULL, NULL, '33~Love You.jpg', 'downloads/20170721224341289541.zip', 'success', 'yes', NULL, NULL),
(637, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-22 12:07:01', 'rupq6at9q04q0mer9vjbl0pj8p', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(638, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-22 16:23:43', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(639, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-22 21:39:11', 'k4nhkb575tig05l2nsqi5p19a4', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(640, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-22 23:24:53', 'k4nhkb575tig05l2nsqi5p19a4', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(641, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-22 23:31:40', '368sqm1gs8voo4cibn0j35pqh2', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(642, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-23 18:54:34', '368sqm1gs8voo4cibn0j35pqh2', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(643, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-23 20:52:25', '17i3g6ngdlb40hkhe70pvo1og0', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(644, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-23 21:46:37', '17i3g6ngdlb40hkhe70pvo1og0', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(645, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-23 22:27:05', '605us0ek7odoombhs49ur3ahqv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(646, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-23 23:06:22', '605us0ek7odoombhs49ur3ahqv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(647, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-23 23:31:15', 'o8l8epmo9u2lhp672upgqah9gs', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(648, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 05:55:11', 'o8l8epmo9u2lhp672upgqah9gs', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(649, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 05:56:16', 'p247sg7b1lkl7kocci9bjo3j11', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(650, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 06:30:51', 'p247sg7b1lkl7kocci9bjo3j11', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(651, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 07:29:38', 'd0mresg8c5i0432cnj4ekeheh3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(652, 'Update Storage Level', 'Updated storage level 1 in {{%store_levels}}', 1, 'wsiati', '2017-07-24 07:30:19', 'd0mresg8c5i0432cnj4ekeheh3', '::1', '1', 'Stores', '1', 'Store', NULL, 'success', 'yes', NULL, NULL),
(653, 'Update Storage Level', 'Updated storage level 1 in {{%store_levels}}', 1, 'wsiati', '2017-07-24 07:34:27', 'd0mresg8c5i0432cnj4ekeheh3', '::1', '1', 'Store', '1', 'Stores', NULL, 'success', 'yes', NULL, NULL),
(654, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 07:44:30', 'd0mresg8c5i0432cnj4ekeheh3', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(655, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 08:40:02', 's7oupssg9humou8glq8tj4mvkq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(656, 'Create Store', 'Created store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 08:41:32', 's7oupssg9humou8glq8tj4mvkq', '::1', NULL, '', '9,5', 'File 5', NULL, 'success', 'yes', NULL, NULL),
(657, 'Create Store', 'Created store 6 in {{%files}}', 1, 'wsiati', '2017-07-24 08:46:03', 's7oupssg9humou8glq8tj4mvkq', '::1', '', '', '9,6', 'File 6', NULL, 'success', 'yes', NULL, NULL),
(658, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 08:56:05', 's7oupssg9humou8glq8tj4mvkq', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(659, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 09:11:07', '5qn5ceofl3amacv5ooinb52u3m', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(660, 'Create Store', 'Created store 3 in {{%sub_compartments}}', 1, 'wsiati', '2017-07-24 09:12:26', '5qn5ceofl3amacv5ooinb52u3m', '::1', '', '', '3,3', 'Section 3', NULL, 'success', 'yes', NULL, NULL),
(661, 'Move Store', 'Moved store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 09:34:59', '5qn5ceofl3amacv5ooinb52u3m', '::1', '9,5', '1,1,1,1,1,2,1,1', '9,5', '1,1,1,1,1,2,1,2', NULL, 'success', 'yes', NULL, NULL),
(662, 'Move Store', 'Moved store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 09:45:34', '5qn5ceofl3amacv5ooinb52u3m', '::1', '9,5', '1,1,1,1,1,2,1,2', '9,5', '1,1,1,1,1,2,1,1', NULL, 'success', 'yes', NULL, NULL),
(663, 'Move Store', 'Moved store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 09:46:20', '5qn5ceofl3amacv5ooinb52u3m', '::1', '9,5', '1,1,1,1,1,2,1,1', '9,5', '1,1,1,1,1,2,1,2', NULL, 'success', 'yes', NULL, NULL),
(664, 'Move Store', 'Moved store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 09:46:23', '5qn5ceofl3amacv5ooinb52u3m', '::1', '9,5', '1,1,1,1,1,2,1,2', '9,5', '1,1,1,1,1,2,1,1', NULL, 'success', 'yes', NULL, NULL),
(665, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 09:56:29', '5qn5ceofl3amacv5ooinb52u3m', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(666, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 10:15:18', 'r28otpofkitcgkk6cga0u33rap', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(667, 'Move Store', 'Moved store 4 in {{%files}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '9,4', '1,1,1,1,1,2,1,1', '9,4', '1,1,3,1,1,2,1,1', NULL, 'success', 'yes', NULL, NULL),
(668, 'Move Store', 'Moved store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '9,5', '1,1,1,1,1,2,1,1', '9,5', '1,1,3,1,1,2,1,1', NULL, 'success', 'yes', NULL, NULL),
(669, 'Move Store', 'Moved store 6 in {{%files}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '9,6', '1,1,1,1,1,2,1,1', '9,6', '1,1,3,1,1,2,1,1', NULL, 'success', 'yes', NULL, NULL),
(670, 'Move Store', 'Moved store 1 in {{%files}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '9,1', '1,1,1,1,1,2,1,1', '9,1', '1,1,3,1,1,2,1,1', NULL, 'success', 'yes', NULL, NULL),
(671, 'Move Store', 'Moved store 1 in {{%folders}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '8,1', '1,1,1,1,1,2,1', '8,1', '1,1,3,1,1,2,1', NULL, 'success', 'yes', NULL, NULL),
(672, 'Move Store', 'Moved store 2 in {{%files}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '9,2', '1,1,1,1,1,2,1,2', '9,2', '1,1,3,1,1,2,1,2', NULL, 'success', 'yes', NULL, NULL),
(673, 'Move Store', 'Moved store 2 in {{%folders}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '8,2', '1,1,1,1,1,2,1', '8,2', '1,1,3,1,1,2,1', NULL, 'success', 'yes', NULL, NULL),
(674, 'Move Store', 'Moved store 1 in {{%batches}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '7,1', '1,1,1,1,1,2', '7,1', '1,1,3,1,1,2', NULL, 'success', 'yes', NULL, NULL),
(675, 'Move Store', 'Moved store 2 in {{%drawers}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '6,2', '1,1,1,1,1', '6,2', '1,1,3,1,1', NULL, 'success', 'yes', NULL, NULL),
(676, 'Move Store', 'Moved store 2 in {{%batches}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '7,2', '1,1,1,1,1,1', '7,2', '1,1,3,1,1,1', NULL, 'success', 'yes', NULL, NULL),
(677, 'Move Store', 'Moved store 1 in {{%drawers}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '6,1', '1,1,1,1,1', '6,1', '1,1,3,1,1', NULL, 'success', 'yes', NULL, NULL),
(678, 'Move Store', 'Moved store 1 in {{%shelves}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '5,1', '1,1,1,1', '5,1', '1,1,3,1', NULL, 'success', 'yes', NULL, NULL),
(679, 'Move Store', 'Moved store 1 in {{%sub_sub_compartments}}', 1, 'wsiati', '2017-07-24 10:31:08', 'r28otpofkitcgkk6cga0u33rap', '::1', '4,1', '1,1,1', '4,1', '1,1,3', NULL, 'success', 'yes', NULL, NULL),
(680, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 11:03:34', 'r28otpofkitcgkk6cga0u33rap', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(681, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 11:08:46', 'pd3msl14o2h8870um0f2270eq1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(682, 'Delete Store', 'Deleted store 6 in {{%files}}', 1, 'wsiati', '2017-07-24 11:09:22', 'pd3msl14o2h8870um0f2270eq1', '::1', '9,6', 'File 6', NULL, NULL, NULL, 'success', 'yes', NULL, NULL),
(683, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 12:37:47', 'pd3msl14o2h8870um0f2270eq1', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(684, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 20:40:39', '9rhif23hqqo7nliq30emhlfuv2', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(685, 'Update Store', 'Updated store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 21:12:06', '9rhif23hqqo7nliq30emhlfuv2', '::1', '9,5', '00005,File 5,Location Five,Description Five', '9,5', '00005,File Five,Location Five,Description Five', NULL, 'success', 'yes', NULL, NULL),
(686, 'Update Store', 'Updated store 5 in {{%files}}', 1, 'wsiati', '2017-07-24 21:13:27', '9rhif23hqqo7nliq30emhlfuv2', '::1', '9,5', '00005,File Five,Location Five,Description Five', '9,5', '00005,File 5,Location 5,Description 5', NULL, 'success', 'yes', NULL, NULL),
(687, 'Update Store', 'Updated store 1 in {{%sub_compartments}}', 1, 'wsiati', '2017-07-24 21:21:58', '9rhif23hqqo7nliq30emhlfuv2', '::1', '3,1', '00001,Section Name,Kilimani,Described', '3,1', '00001,Section Names,Kilimani,Described', NULL, 'success', 'yes', NULL, NULL),
(688, 'Update Store', 'Updated store 1 in {{%sub_compartments}}', 1, 'wsiati', '2017-07-24 21:22:51', '9rhif23hqqo7nliq30emhlfuv2', '::1', '3,1', '00001,Section Names,Kilimani,Described', '3,1', '00001,Section Name,Kilimani,Described', NULL, 'success', 'yes', NULL, NULL),
(689, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-24 21:43:13', '9rhif23hqqo7nliq30emhlfuv2', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(690, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-24 21:52:57', 'gh2j9hg1qsqomdmr2sirc894th', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(691, 'Update Store Rights', 'Updated store privilege 5 in {{%file_permissions}}', 1, 'wsiati', '2017-07-24 21:53:51', 'gh2j9hg1qsqomdmr2sirc894th', '::1', '9,4', '-,1-', '9,4', ',1--', NULL, 'success', 'yes', NULL, NULL),
(692, 'Update Store Rights', 'Updated store privilege 5 in {{%file_permissions}}', 1, 'wsiati', '2017-07-24 21:54:56', 'gh2j9hg1qsqomdmr2sirc894th', '::1', '9,4', ',1--', '9,4', '--,1', NULL, 'success', 'yes', NULL, NULL),
(693, 'Update Store Rights', 'Updated store privilege 5 in {{%file_permissions}}', 1, 'wsiati', '2017-07-24 21:54:57', 'gh2j9hg1qsqomdmr2sirc894th', '::1', '9,4', '--,1', '9,4', '-,1-', NULL, 'success', 'yes', NULL, NULL),
(694, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-25 05:49:35', 'gh2j9hg1qsqomdmr2sirc894th', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(695, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-25 13:28:20', '1pf4v8726kt5hr5m3uj36k4g4s', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(696, 'Create Store', 'Created store 6 in {{%files}}', 1, 'wsiati', '2017-07-25 13:29:23', '1pf4v8726kt5hr5m3uj36k4g4s', '::1', '', '', '9,6', 'File 6', NULL, 'success', 'yes', NULL, NULL),
(697, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-25 13:41:03', '1pf4v8726kt5hr5m3uj36k4g4s', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(698, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-25 22:10:06', 'hn2d8ccjdqtmekk910b62iuorn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(699, 'Create Store', 'Created store 7 in {{%files}}', 1, 'wsiati', '2017-07-25 22:11:25', 'hn2d8ccjdqtmekk910b62iuorn', '::1', '', '', '9,7', 'File 7', NULL, 'success', 'yes', NULL, NULL),
(700, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-26 05:49:32', 'hn2d8ccjdqtmekk910b62iuorn', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(701, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-26 20:47:18', '0pgtqtuvgev3tip7ig8j77d8qv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(702, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-26 20:59:14', '0pgtqtuvgev3tip7ig8j77d8qv', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(703, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-26 21:04:36', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(704, 'Update Store Rights', 'Updated store privilege 6 in {{%file_permissions}}', 1, 'wsiati', '2017-07-26 21:16:27', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '', '', '9,5', '-,1-', NULL, 'success', 'yes', NULL, NULL),
(705, 'Update Store Rights', 'Updated store privilege 6 in {{%file_permissions}}', 1, 'wsiati', '2017-07-26 21:16:28', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '9,5', '-,1-', '9,5', ',1--', NULL, 'success', 'yes', NULL, NULL),
(706, 'Update Store Rights', 'Updated store privilege 6 in {{%file_permissions}}', 1, 'wsiati', '2017-07-26 21:16:30', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '9,5', ',1--', '9,5', '--,1', NULL, 'success', 'yes', NULL, NULL),
(707, 'Update Store Rights', 'Updated store privilege 6 in {{%file_permissions}}', 1, 'wsiati', '2017-07-26 21:17:38', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '9,5', '--,1', '9,5', '-,1-', NULL, 'success', 'yes', NULL, NULL),
(708, 'Update Store Rights', 'Updated store privilege 6 in {{%file_permissions}}', 1, 'wsiati', '2017-07-26 21:17:55', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '9,5', '-,1-', '9,5', ',1--', NULL, 'success', 'yes', NULL, NULL),
(709, 'Update Store', 'Updated store 5 in {{%files}}', 1, 'wsiati', '2017-07-26 22:04:05', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '9,5', '00005,File 5,Location 5,Description 5', '9,5', '00005,File Five,Location 5,Description 5', NULL, 'success', 'yes', NULL, NULL),
(710, 'Update Store', 'Updated store 5 in {{%files}}', 1, 'wsiati', '2017-07-26 22:05:52', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '9,5', '00005,File Five,Location 5,Description 5', '9,5', '00005,File 5,Location 5,Description 5', NULL, 'success', 'yes', NULL, NULL),
(711, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-27 05:48:48', 'ab0ot7usm6psac11pjr7gp8o16', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(712, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-27 15:19:25', 'asktukksppfhd1qjcjg1ai5u9j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(713, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-27 15:37:48', 'asktukksppfhd1qjcjg1ai5u9j', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(714, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-27 20:11:09', '2ppqp3k4ovsl2m6f13j55m7lir', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(715, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-27 20:22:54', '2ppqp3k4ovsl2m6f13j55m7lir', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(716, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-27 21:38:43', 'cbf6ovas1jb09kbnun1g0h6mvi', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(717, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-27 22:05:41', 'cbf6ovas1jb09kbnun1g0h6mvi', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(718, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-27 22:15:59', 'jftet4v23ips66lbetias3a9rh', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(719, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-28 05:47:50', 'jftet4v23ips66lbetias3a9rh', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(720, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-28 06:13:10', NULL, NULL, '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(721, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-28 06:32:21', 'inrdoo8m3ipaj6fh53p553balj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(722, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-28 08:15:40', 'inrdoo8m3ipaj6fh53p553balj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(723, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-28 16:27:54', 'l1t085348i7hod0spotmim3m3m', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(724, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-28 16:39:19', 'l1t085348i7hod0spotmim3m3m', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(725, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-28 20:49:29', '9odmg2nlm5pqei96rdf7frrahj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(726, 'Tracking Note', 'Made note 12 in {{%file_tracking_notes}}', 1, 'wsiati', '2017-07-28 23:34:58', '9odmg2nlm5pqei96rdf7frrahj', '::1', NULL, NULL, '9,6', 'sddf fsdf dfdd fdsff ff sdfwerf wff ffdsfwef efsdf sfsfef wef dsfdsfwef fdfewf ewfdsfdf dfdsfe fsdff efdsfef efds fdsfew fewfeww fwefwef wefwefw fewfwe ewf ewfwe fwefffwe ewweew ', NULL, 'success', 'yes', NULL, NULL),
(727, 'User Logout', 'wsiati successfully logged out through {{%user}}', 1, 'wsiati', '2017-07-28 23:47:45', '9odmg2nlm5pqei96rdf7frrahj', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL),
(728, 'User Login', 'wsiati successfully logged in through {{%user}}', 1, 'wsiati', '2017-07-29 11:37:33', '7potk8k58g5c544a572edbch9d', '::1', '1', NULL, '1', NULL, NULL, 'success', 'yes', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1483422074),
('m130524_201442_init', 1483422085);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE `tbl_profiles` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `profile` varchar(15) NOT NULL COMMENT 'Profile / Role',
  `name` varchar(30) NOT NULL COMMENT 'Name Of Role',
  `description` text COMMENT 'Description Of Role',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Profile Status'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`id`, `profile`, `name`, `description`, `status`) VALUES
(1, 'admin', 'System Administrator', 'This one\r\nNow here', '1'),
(2, 'super_admin', 'Vendor Administrator', 'User related to product vendor', '0'),
(3, 'pending', 'Pending Approval', 'User just signed up awaiting approval by system administrator', '0'),
(4, 'recovery', 'Recovery Department', 'Recovery Department', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sections`
--

CREATE TABLE `tbl_sections` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Name Of Section',
  `active` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Active',
  `description` text COMMENT 'Description Of Section',
  `admin_one` int(11) DEFAULT NULL COMMENT 'Head Of Section',
  `admin_two` int(11) DEFAULT NULL COMMENT 'Assistant Head Of Section',
  `sub_admin_one` int(11) DEFAULT NULL COMMENT 'Assistant Admin 1',
  `sub_admin_two` int(11) DEFAULT NULL COMMENT 'Assistant Admin 2',
  `other_users` text COMMENT 'Other Users',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_sections`
--

INSERT INTO `tbl_sections` (`id`, `name`, `active`, `description`, `admin_one`, `admin_two`, `sub_admin_one`, `sub_admin_two`, `other_users`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Ict Department', '1', 'For Ict Department', 1, NULL, NULL, NULL, NULL, 1, '2017-06-04 02:20:42', 1, '2017-06-08 22:46:40'),
(2, 'Lending Group', '1', 'Lending Department', NULL, NULL, 1, NULL, NULL, 1, '2017-06-07 22:39:21', 1, '2017-06-08 22:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shelves`
--

CREATE TABLE `tbl_shelves` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Compartment',
  `sub_sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Sub Compartment',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shelves`
--

INSERT INTO `tbl_shelves` (`id`, `store`, `compartment`, `sub_compartment`, `sub_sub_compartment`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 3, 1, 'Shelf Name', '00001', 'Shelf Location', 'Described Here', 1, '2017-06-28 23:10:44', 1, '2017-07-24 10:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slide_images`
--

CREATE TABLE `tbl_slide_images` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(30) NOT NULL COMMENT 'Name',
  `caption` text COMMENT 'Caption',
  `location` varchar(128) NOT NULL COMMENT 'Location',
  `url_to` varchar(200) DEFAULT NULL COMMENT 'Associated Link Location',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `active` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Active',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At',
  `name_visible` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Name Is Visible',
  `caption_visible` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Caption Is Visible'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_slide_images`
--

INSERT INTO `tbl_slide_images` (`id`, `name`, `caption`, `location`, `url_to`, `created_by`, `created_at`, `active`, `updated_by`, `updated_at`, `name_visible`, `caption_visible`) VALUES
(1, 'Jenga 4', 'Helb New Portal', '20170425060835942802.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 06:08:35', '1', 1, '2017-06-05 20:24:25', '1', '1'),
(2, 'Jenga 1', 'Helb New Portal', '20170425062155647722.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 06:21:55', '1', 1, '2017-05-11 21:59:45', '1', '1'),
(3, 'Jenga 2', 'Helb New Portal', '20170425062309029733.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 06:23:09', '1', 1, '2017-04-25 18:48:01', '0', '0'),
(4, 'Jenga 3', 'Helb New Portal', '20170425065643167254.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 06:56:43', '1', 1, '2017-06-05 20:24:29', '1', '1'),
(5, 'Jenga', 'Helb New Portal', '20170425070104107151.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 07:01:04', '1', NULL, NULL, '1', '1'),
(7, 'Jenga', 'Helb New Portal', '20170425070912918910.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 07:09:12', '1', 1, '2017-04-25 07:11:39', '0', '0'),
(8, 'Loading', 'Helb New Portal', '20170425075428683058.gif', 'https://clientservices.helb.co.ke', 1, '2017-04-25 07:54:28', '1', 1, '2017-04-25 16:52:19', '1', '1'),
(9, 'John Rays', 'John Rays', '20170425081513178457.png', 'https://johnrays.com', 1, '2017-04-25 08:15:13', '1', 1, '2017-04-25 08:15:22', '1', '1'),
(14, 'Pull Out', 'Helb New Portal', '20170425215414640578.jpg', 'https://clientservices.helb.co.ke', 1, '2017-04-25 21:54:14', '1', NULL, NULL, '1', '1'),
(15, 'Search Files', 'Helb New Portal', '20170425220104769670.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 22:01:04', '1', 1, '2017-04-26 15:08:21', '1', '1'),
(16, 'Folder Search', 'Helb New Portal', '20170425220144934314.jpg', 'https://clientservices.helb.co.ke', 1, '2017-04-25 22:01:44', '1', 1, '2017-04-26 15:07:31', '1', '1'),
(17, 'Ana-Digital', 'New Helb Portal', '20170425220227656528.jpg', 'https://clientservices.helb.co.ke', 1, '2017-04-25 22:02:27', '1', 1, '2017-04-26 15:06:42', '1', '1'),
(18, 'Doc Scanner', 'Helb New Portal', '20170425220305203279.png', 'https://clientservices.helb.co.ke', 1, '2017-04-25 22:03:05', '1', NULL, NULL, '1', '1'),
(20, 'I Love You', 'My Lovely Wife, Sarah', '20170619231211325108.jpg', 'https://clientservices.helb.co.ke', 1, '2017-06-19 23:12:11', '0', 1, '2017-06-19 23:15:29', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stores`
--

CREATE TABLE `tbl_stores` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stores`
--

INSERT INTO `tbl_stores` (`id`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'First Store', '00001', 'Upper Hill', 'Saving books here', 1, '2017-06-22 00:45:25', NULL, NULL),
(2, 'Name Of Store II', '00002', 'Location2', 'Description II', 1, '2017-06-29 23:50:05', NULL, NULL),
(3, 'This is Store 3', '00003', 'Location 3', 'Description 3', 1, '2017-07-01 22:32:22', NULL, NULL),
(4, 'Store 4', '00004', 'Store 4', 'Store 4', 1, '2017-07-01 22:35:42', NULL, NULL),
(5, 'Store Five', '00005', 'Store Five', 'Store Five', 1, '2017-07-01 22:39:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store_levels`
--

CREATE TABLE `tbl_store_levels` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `level` int(11) NOT NULL COMMENT 'Store Level',
  `name` varchar(45) NOT NULL COMMENT 'Level Name',
  `associated_table` varchar(128) NOT NULL COMMENT 'Associated Table',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_store_levels`
--

INSERT INTO `tbl_store_levels` (`id`, `level`, `name`, `associated_table`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Stores', '{{%stores}}', 1, '2017-07-24 07:34:27'),
(2, 2, 'Compartments', '{{%compartments}}', 1, '2017-07-01 22:55:03'),
(3, 3, 'Sections', '{{%sub_compartments}}', 1, '2017-06-28 22:30:11'),
(4, 4, 'Sub Sections', '{{%sub_sub_compartments}}', 1, '2017-07-02 16:08:03'),
(5, 5, 'Shelves', '{{%shelves}}', 1, '2017-06-27 20:21:14'),
(6, 6, 'Drawers', '{{%drawers}}', 1, '2017-06-27 20:21:13'),
(7, 7, 'Batches', '{{%batches}}', 1, '2017-06-27 20:21:11'),
(8, 8, 'Folders', '{{%folders}}', 1, '2017-07-08 23:27:11'),
(9, 9, 'Files', '{{%files}}', 1, '2017-06-27 20:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_compartments`
--

CREATE TABLE `tbl_sub_compartments` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sub_compartments`
--

INSERT INTO `tbl_sub_compartments` (`id`, `store`, `compartment`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 'Section Name', '00001', 'Kilimani', 'Described', 1, '2017-06-28 22:35:17', 1, '2017-07-24 21:22:51'),
(2, 2, 4, 'Section Two', '00002', 'Location 2', '', 1, '2017-07-03 19:37:23', NULL, NULL),
(3, 1, 1, 'Section 3', '00003', 'Location 3', '', 1, '2017-07-24 09:12:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_sub_compartments`
--

CREATE TABLE `tbl_sub_sub_compartments` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `store` int(11) DEFAULT NULL COMMENT 'Store',
  `compartment` int(11) DEFAULT NULL COMMENT 'Compartment',
  `sub_compartment` int(11) DEFAULT NULL COMMENT 'Sub Compartment',
  `name` varchar(40) NOT NULL COMMENT 'Store Name',
  `reference_no` varchar(15) NOT NULL COMMENT 'Store No.',
  `location` varchar(128) NOT NULL COMMENT 'Store Location',
  `description` text COMMENT 'Strore Description',
  `created_by` int(11) NOT NULL COMMENT 'Created By',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'Updated By',
  `updated_at` datetime DEFAULT NULL COMMENT 'Updated At'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sub_sub_compartments`
--

INSERT INTO `tbl_sub_sub_compartments` (`id`, `store`, `compartment`, `sub_compartment`, `name`, `reference_no`, `location`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 3, 'Sub Sections', '00001', 'Location It', 'Described', 1, '2017-06-28 22:57:48', 1, '2017-07-24 10:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name Of User',
  `phone` varchar(13) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Phone Number',
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `profile` int(3) NOT NULL DEFAULT '0' COMMENT 'Profile Of User',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_status` int(11) NOT NULL COMMENT 'Profile Status',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `pass_okayed` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Password Ok',
  `signed_in` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Currently Signed In',
  `signed_in_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User IP',
  `session_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Session ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `phone`, `email`, `username`, `profile`, `auth_key`, `password_hash`, `password_reset_token`, `profile_status`, `status`, `created_at`, `updated_at`, `pass_okayed`, `signed_in`, `signed_in_ip`, `session_id`) VALUES
(1, 'Shadrack Wabomba', '+254712356782', 'wsiati@live.com', 'wsiati', 1, 'vbCMp2sw8XMhJqJ2yEpXULIp0tn9s55q', '$2y$13$gj28e7a2v6rD2e9Lc0jb6Ot/nJ3sOtgPn7ddwLgmXbMQBtLRYPNB.', NULL, 1, 10, 1483523209, 1494925388, '1', '1', '::1', '7potk8k58g5c544a572edbch9d'),
(2, 'Sarah Khatete Nendela', '+254727171565', 'snendela@gmail.com', 'sarah', 2, 'pYm-dmRecB1N0lYxfQMAkEhtlio5KSUx', '$2y$13$glOQtNI9uohZWEIczcDAVe0M4Idt94FUfJhauG6XBfTuH/bYqRfUq', '6cKYi__sADqPZF5_pm5GkBhbyk0KsnOA_1483862241', 0, 0, 1483818534, 1483862241, '2', '0', NULL, NULL),
(3, 'Daniel Wekesa Wanyonyi', '+254720833623', 'datawai@outlook.com', 'dawta', 1, '-0VVvOMHAi0f13t7jSouB-_RPE3uLsmQ', '$2y$13$1SqiV1QMQm95sXDGFUE8Ver5vumDiDHfqK0H.vSkjQo/ZIlGOxH5a', NULL, 0, 10, 1483830477, 1494927020, '2', '0', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_batches`
--
ALTER TABLE `tbl_batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `sub_compartment` (`sub_compartment`),
  ADD KEY `sub_sub_compartment` (`sub_sub_compartment`),
  ADD KEY `shelf` (`shelf`),
  ADD KEY `drawer` (`drawer`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_compartments`
--
ALTER TABLE `tbl_compartments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filename` (`filename`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_documents_mailings`
--
ALTER TABLE `tbl_documents_mailings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `tbl_documents_mailings_contacts`
--
ALTER TABLE `tbl_documents_mailings_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `names` (`names`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_documents_permissions`
--
ALTER TABLE `tbl_documents_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document` (`document`),
  ADD KEY `user` (`section`),
  ADD KEY `document_2` (`document`),
  ADD KEY `user_2` (`section`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_downloads`
--
ALTER TABLE `tbl_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `tbl_drawers`
--
ALTER TABLE `tbl_drawers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `sub_compartment` (`sub_compartment`),
  ADD KEY `sub_sub_compartment` (`sub_sub_compartment`),
  ADD KEY `shelf` (`shelf`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_files`
--
ALTER TABLE `tbl_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `sub_compartment` (`sub_compartment`),
  ADD KEY `sub_sub_compartment` (`sub_sub_compartment`),
  ADD KEY `shelf` (`shelf`),
  ADD KEY `drawer` (`drawer`),
  ADD KEY `batch` (`batch`),
  ADD KEY `folder` (`folder`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_file_permissions`
--
ALTER TABLE `tbl_file_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_level` (`store_level`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_file_tracking_notes`
--
ALTER TABLE `tbl_file_tracking_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_folders`
--
ALTER TABLE `tbl_folders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `sub_compartment` (`sub_compartment`),
  ADD KEY `sub_sub_compartment` (`sub_sub_compartment`),
  ADD KEY `shelf` (`shelf`),
  ADD KEY `drawer` (`drawer`),
  ADD KEY `batch` (`batch`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tbl_migration`
--
ALTER TABLE `tbl_migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profile` (`profile`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `admin_one` (`admin_one`),
  ADD KEY `admin_two` (`admin_two`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `sub_admin_one` (`sub_admin_one`),
  ADD KEY `sub_admin_two` (`sub_admin_two`);

--
-- Indexes for table `tbl_shelves`
--
ALTER TABLE `tbl_shelves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `sub_compartment` (`sub_compartment`),
  ADD KEY `sub_sub_compartment` (`sub_sub_compartment`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_slide_images`
--
ALTER TABLE `tbl_slide_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_stores`
--
ALTER TABLE `tbl_stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_store_levels`
--
ALTER TABLE `tbl_store_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `level` (`level`),
  ADD UNIQUE KEY `table` (`associated_table`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_sub_compartments`
--
ALTER TABLE `tbl_sub_compartments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_sub_sub_compartments`
--
ALTER TABLE `tbl_sub_sub_compartments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `store` (`store`),
  ADD KEY `compartment` (`compartment`),
  ADD KEY `sub_compartment` (`sub_compartment`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `profile_status` (`profile_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_batches`
--
ALTER TABLE `tbl_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_compartments`
--
ALTER TABLE `tbl_compartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `tbl_documents_mailings`
--
ALTER TABLE `tbl_documents_mailings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_documents_mailings_contacts`
--
ALTER TABLE `tbl_documents_mailings_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_documents_permissions`
--
ALTER TABLE `tbl_documents_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `tbl_downloads`
--
ALTER TABLE `tbl_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `tbl_drawers`
--
ALTER TABLE `tbl_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_files`
--
ALTER TABLE `tbl_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_file_permissions`
--
ALTER TABLE `tbl_file_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_file_tracking_notes`
--
ALTER TABLE `tbl_file_tracking_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_folders`
--
ALTER TABLE `tbl_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=729;
--
-- AUTO_INCREMENT for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_shelves`
--
ALTER TABLE `tbl_shelves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_slide_images`
--
ALTER TABLE `tbl_slide_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tbl_stores`
--
ALTER TABLE `tbl_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_store_levels`
--
ALTER TABLE `tbl_store_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_sub_compartments`
--
ALTER TABLE `tbl_sub_compartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_sub_sub_compartments`
--
ALTER TABLE `tbl_sub_sub_compartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
