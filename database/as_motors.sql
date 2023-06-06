-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2023 at 02:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `as_motors`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountsgroup`
--

CREATE TABLE `accountsgroup` (
  `Id` int(11) NOT NULL,
  `AccountsName` longtext DEFAULT NULL,
  `ParentId` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appreciation_depreciation`
--

CREATE TABLE `appreciation_depreciation` (
  `appreciation_depreciation_id` int(11) NOT NULL,
  `review` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `overall_performance` varchar(255) DEFAULT NULL,
  `not_done` varchar(255) DEFAULT NULL,
  `carry_forward` varchar(255) DEFAULT NULL,
  `strength` varchar(255) NOT NULL,
  `weakness` varchar(255) NOT NULL,
  `need_for_improvement` varchar(255) NOT NULL,
  `overall_rating` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appreciation_depreciation_ref`
--

CREATE TABLE `appreciation_depreciation_ref` (
  `appreciation_depreciation_ref_id` int(11) NOT NULL,
  `review` varchar(50) DEFAULT NULL,
  `appreciation_depreciation_id` int(11) DEFAULT NULL,
  `daily_performance_ref_id` int(11) DEFAULT NULL,
  `assertion` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `achievement` varchar(255) DEFAULT NULL,
  `employee_rating` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approval_line`
--

CREATE TABLE `approval_line` (
  `approval_line_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `approval_staff_id` varchar(255) DEFAULT NULL,
  `agree_par_staff_id` varchar(255) DEFAULT NULL,
  `after_notified_staff_id` varchar(255) DEFAULT NULL,
  `receiving_dept_id` varchar(255) DEFAULT NULL,
  `checker_approval` varchar(255) NOT NULL DEFAULT '0',
  `reviewer_approval` varchar(255) NOT NULL DEFAULT '0',
  `final_approval` varchar(255) NOT NULL DEFAULT '0',
  `checker_approval_date` varchar(255) DEFAULT NULL,
  `reviewer_approval_date` varchar(255) DEFAULT NULL,
  `final_approval_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approval_requisition`
--

CREATE TABLE `approval_requisition` (
  `approval_requisition_id` int(11) NOT NULL,
  `approval_line_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `auto_generation_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approval_requisition_parallel_agree_disagree`
--

CREATE TABLE `approval_requisition_parallel_agree_disagree` (
  `approval_requisition_agree_disagree_id` int(11) NOT NULL,
  `approval_line_id` varchar(255) DEFAULT NULL,
  `agree_disagree_staff_id` varchar(255) DEFAULT NULL,
  `agree_disagree` int(11) NOT NULL DEFAULT 0,
  `agree_disagree_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details`
--

CREATE TABLE `asset_details` (
  `asset_details_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `dou` date DEFAULT NULL,
  `depreciation` varchar(255) DEFAULT NULL,
  `as_on` varchar(255) DEFAULT NULL,
  `spare_names` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_details`
--

INSERT INTO `asset_details` (`asset_details_id`, `company_id`, `branch_id`, `classification`, `asset_name`, `asset_value`, `dou`, `depreciation`, `as_on`, `spare_names`, `status`, `created_id`, `updated_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '3', '1', '30000', '2021-06-03', '2023-06-03', '15000', '2,3,1', 0, NULL, NULL, '2023-06-03 17:02:41', '2023-06-03 17:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `asset_details_ref`
--

CREATE TABLE `asset_details_ref` (
  `ref_id` int(11) NOT NULL,
  `asset_details_reff_id` int(11) DEFAULT NULL,
  `modal_no` int(11) DEFAULT NULL,
  `warranty_upto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_details_ref`
--

INSERT INTO `asset_details_ref` (`ref_id`, `asset_details_reff_id`, `modal_no`, `warranty_upto`) VALUES
(1, 1, 101225151, '2024-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `asset_register`
--

CREATE TABLE `asset_register` (
  `asset_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `asset_classification` varchar(250) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `dop` date DEFAULT NULL,
  `asset_nature` int(11) DEFAULT NULL,
  `asset_value` int(11) DEFAULT NULL,
  `maintenance` varchar(255) DEFAULT NULL,
  `rgp_status` varchar(255) NOT NULL DEFAULT 'inword',
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_register`
--

INSERT INTO `asset_register` (`asset_id`, `company_id`, `asset_classification`, `asset_name`, `dop`, `asset_nature`, `asset_value`, `maintenance`, `rgp_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '3', 'Acer', '2021-01-01', 1, 30000, '1', 'inword', 0, 1, 1, NULL, '2023-06-03 16:43:54', '2023-06-03 16:44:16'),
(2, '1', '4', 'Canon', '2021-01-01', 2, 50000, '1', 'inward', 0, 1, NULL, NULL, '2023-06-03 16:46:45', '2023-06-03 16:46:45'),
(3, '1', '5', 'Chair,Table', '2021-02-01', 2, 200000, '1', 'inword', 0, 1, NULL, NULL, '2023-06-03 16:48:35', '2023-06-03 16:48:35'),
(4, '4', '1', 'Dell System', '2023-06-09', 2, 20000, '1', 'inword', 0, 1, NULL, NULL, '2023-06-05 15:28:49', '2023-06-05 15:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `assign_work`
--

CREATE TABLE `assign_work` (
  `work_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assign_work_ref`
--

CREATE TABLE `assign_work_ref` (
  `ref_id` int(11) NOT NULL,
  `assign_work_reff_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `work_des` varchar(255) DEFAULT NULL,
  `work_des_text` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_area_creation`
--

CREATE TABLE `audit_area_creation` (
  `audit_area_id` int(11) NOT NULL,
  `audit_area` varchar(250) DEFAULT NULL,
  `department_id` varchar(250) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(100) DEFAULT NULL,
  `calendar` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `role1` varchar(250) DEFAULT NULL,
  `role2` varchar(250) DEFAULT NULL,
  `check_list` varchar(250) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_area_creation_ref`
--

CREATE TABLE `audit_area_creation_ref` (
  `audit_area_creation_ref_id` int(11) NOT NULL,
  `audit_area_id` varchar(50) DEFAULT NULL,
  `from_date` varchar(100) DEFAULT NULL,
  `to_date` varchar(100) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_assign`
--

CREATE TABLE `audit_assign` (
  `audit_assign_id` int(11) NOT NULL,
  `date_of_audit` date DEFAULT NULL,
  `department_id` varchar(100) DEFAULT NULL,
  `role1` varchar(100) DEFAULT NULL,
  `role2` varchar(100) DEFAULT NULL,
  `audit_area_id` varchar(100) DEFAULT NULL,
  `auditee_response_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_assign_ref`
--

CREATE TABLE `audit_assign_ref` (
  `audit_assign_ref_id` int(11) NOT NULL,
  `audit_assign_id` varchar(100) DEFAULT NULL,
  `major_area` varchar(200) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `audit_status` varchar(50) DEFAULT NULL,
  `recommendation` varchar(250) DEFAULT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `audit_remarks` text DEFAULT NULL,
  `auditee_response` varchar(100) DEFAULT NULL,
  `action_plan` varchar(100) DEFAULT NULL,
  `target_date` varchar(100) DEFAULT NULL,
  `auditee_response_status` int(11) NOT NULL DEFAULT 0,
  `auditee_followup_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_checklist`
--

CREATE TABLE `audit_checklist` (
  `audit_checklist_id` int(11) NOT NULL,
  `audit_area_id` int(11) DEFAULT NULL,
  `department` varchar(200) DEFAULT NULL,
  `auditor` varchar(200) DEFAULT NULL,
  `auditee` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_checklist_ref`
--

CREATE TABLE `audit_checklist_ref` (
  `audit_checklist_ref_id` int(11) NOT NULL,
  `audit_area_id` int(11) DEFAULT NULL,
  `major_area` varchar(200) DEFAULT NULL,
  `sub_area` varchar(200) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `weightage` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `audit_followup`
--

CREATE TABLE `audit_followup` (
  `audit_followup_id` int(11) NOT NULL,
  `audit_assign_id` int(11) DEFAULT NULL,
  `audit_assign_ref_id` int(11) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `completed_date` varchar(255) DEFAULT NULL,
  `files` varchar(200) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bankmaster`
--

CREATE TABLE `bankmaster` (
  `bankid` int(11) NOT NULL,
  `bankcode` varchar(255) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `accountno` varchar(255) DEFAULT NULL,
  `branchname` varchar(255) DEFAULT NULL,
  `shortform` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `mailid` varchar(255) DEFAULT NULL,
  `ifsccode` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `contactno` varchar(255) DEFAULT NULL,
  `micrcode` varchar(255) DEFAULT NULL,
  `typeofaccount` varchar(255) DEFAULT NULL,
  `undersubgroup` varchar(255) DEFAULT NULL,
  `fgroup` varchar(255) DEFAULT NULL,
  `bankgrouprefid` varchar(20) DEFAULT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `costcenter` varchar(255) DEFAULT NULL,
  `fromperiod` varchar(50) DEFAULT NULL,
  `toperiod` varchar(50) DEFAULT NULL,
  `duedate` varchar(50) DEFAULT NULL,
  `loanamount` int(11) DEFAULT NULL,
  `emi` int(11) DEFAULT NULL,
  `restofinterest` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `createddate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `basic_creation`
--

CREATE TABLE `basic_creation` (
  `basic_creation_id` int(11) NOT NULL,
  `type` varchar(11) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_code` varchar(250) DEFAULT NULL,
  `designation_code` varchar(255) DEFAULT NULL,
  `department` varchar(250) DEFAULT NULL,
  `designation` varchar(250) DEFAULT NULL,
  `report_to` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basic_creation`
--

INSERT INTO `basic_creation` (`basic_creation_id`, `type`, `company_id`, `department_code`, `designation_code`, `department`, `designation`, `report_to`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, NULL, '1', 'Dev-1/LittleProdapt', 'DESIG-1/LittleProdapt', '1', '1,2', '', 0, 1, 1, NULL, '2023-06-03 15:08:13', '2023-06-03 15:08:13'),
(2, NULL, '1', 'Mar-2/LittleProdapt', 'DESIG-2/LittleProdapt', '2', '3', '', 0, 1, NULL, NULL, '2023-06-03 15:20:33', '2023-06-03 15:20:33'),
(3, NULL, '2', 'Fin-3/olympia', 'DESIG-3/olympia', '4', '5,4', '', 0, 1, 1, NULL, '2023-06-05 11:31:53', '2023-06-05 11:31:53'),
(4, NULL, '2', 'Fin-4/olympia', 'DESIG-4/olympia', '4', '5,4', '', 0, 1, NULL, NULL, '2023-06-05 12:07:54', '2023-06-05 12:07:54'),
(5, NULL, '5', 'Dev-5/Pondicherry', 'DESIG-5/Pondicherry', '6', '6', '', 0, 1, NULL, NULL, '2023-06-05 12:36:25', '2023-06-05 12:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `bm_checklist`
--

CREATE TABLE `bm_checklist` (
  `bm_checklist_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `branch_creation`
--

CREATE TABLE `branch_creation` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `key_personal` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pf_number` varchar(250) DEFAULT NULL,
  `fax_number` varchar(250) DEFAULT NULL,
  `office_number` varchar(250) DEFAULT NULL,
  `esi_number` varchar(250) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch_creation`
--

INSERT INTO `branch_creation` (`branch_id`, `branch_name`, `company_id`, `address1`, `address2`, `key_personal`, `city`, `state`, `email_id`, `website`, `pan_number`, `pf_number`, `fax_number`, `office_number`, `esi_number`, `tan_number`, `company_logo`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Little Prodapt', 1, 'No.4 , OMR road,', 'Kandhanchavadi', 'IT', 'Chennai', 'TamilNadu', 'abc@little.in', 'www.prodapt.com', 'PEFFD9239F', 'KN/KRP/7654321/783/2343233', '5466464462346', '2344364654', '31/00/123456/030/2333', 'HASF78237H', NULL, 0, 1, NULL, NULL, '2023-06-03 15:00:21', '2023-06-03 15:00:21'),
(2, 'olympia', 1, 'No.23 , Ashok nagar road,', 'ekkatuthangal', 'IT', 'Chennai', 'TamilNadu', 'olympia@abc.in', 'www.prodapt.com', 'PEFFD9239F', 'KN/KRP/7654321/783/2343233', '3252343523523', '3232535223', '31/00/123456/030/2333', 'HASF78237H', NULL, 0, 1, 1, NULL, '2023-06-03 15:04:08', '2023-06-03 15:04:08'),
(4, 'Hibi Conde', 2, 'No.3/7, 14th Trust cross Street,', ' Mandhaveli, Chennai.', 'IT', 'Chennai', 'TamilNadu', 'hibi@hibis.in', 'www.hibis.com', 'DSSFD9239F', 'PP/FSD/8923234/834/8348934', '2454422332323', '5534431231', '78/78/983493/893/9439', 'HASF78237H', NULL, 0, 1, NULL, NULL, '2023-06-05 12:03:48', '2023-06-05 12:03:48'),
(5, 'Pondicherry', 6, 'Car Street', 'Chinnakadai', 'Ram', 'Tiruchirappalli', 'TamilNadu', 'feathertechnology@gmail.com', 'www.feathertechnology.com', 'ABCTY1234D', 'MH/BAN/0000064/000/0000123', '', '', '31/00/123456/000/0001', 'PDES03028F', NULL, 0, 1, NULL, NULL, '2023-06-05 12:35:38', '2023-06-05 12:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `business_com_line`
--

CREATE TABLE `business_com_line` (
  `business_com_line_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(250) DEFAULT NULL,
  `approval_staff_id` varchar(255) DEFAULT NULL,
  `agree_par_staff_id` varchar(255) DEFAULT NULL,
  `after_notified_staff_id` varchar(255) DEFAULT NULL,
  `recipient_id` varchar(255) DEFAULT NULL,
  `receiving_branch_id` varchar(255) DEFAULT NULL,
  `checker_approval` varchar(255) NOT NULL DEFAULT '0',
  `reviewer_approval` varchar(250) NOT NULL DEFAULT '0',
  `final_approval` varchar(250) NOT NULL DEFAULT '0',
  `checker_approval_date` varchar(250) DEFAULT NULL,
  `reviewer_approval_date` varchar(255) DEFAULT NULL,
  `final_approval_date` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `business_com_out`
--

CREATE TABLE `business_com_out` (
  `business_com_out_id` int(11) NOT NULL,
  `business_com_line_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `auto_generation_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `business_com_parallel_agree_disagree`
--

CREATE TABLE `business_com_parallel_agree_disagree` (
  `business_com_parallel_agree_disagree_id` int(11) NOT NULL,
  `business_com_line_id` varchar(255) DEFAULT NULL,
  `agree_disagree_staff_id` varchar(255) DEFAULT NULL,
  `agree_disagree` int(11) NOT NULL DEFAULT 0,
  `agree_disagree_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int(11) NOT NULL,
  `promotional_activities_id` varchar(50) DEFAULT NULL,
  `actual_start_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_ref`
--

CREATE TABLE `campaign_ref` (
  `campaign_ref_id` int(11) NOT NULL,
  `campaign_id` varchar(50) DEFAULT NULL,
  `promotional_activities_ref_id` varchar(50) DEFAULT NULL,
  `activity_involved` varchar(255) DEFAULT NULL,
  `time_frame_start` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category_creation`
--

CREATE TABLE `category_creation` (
  `category_creation_id` int(11) NOT NULL,
  `category_creation_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_creation`
--

INSERT INTO `category_creation` (`category_creation_id`, `category_creation_name`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'test', 0, NULL, NULL, NULL, '2023-06-05 15:43:47', '2023-06-05 15:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `company_creation`
--

CREATE TABLE `company_creation` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_status` varchar(255) DEFAULT NULL,
  `cin` varchar(255) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `key_personal` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pf_number` varchar(250) DEFAULT NULL,
  `fax_number` varchar(250) DEFAULT NULL,
  `office_number` varchar(250) DEFAULT NULL,
  `esi_number` varchar(250) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_creation`
--

INSERT INTO `company_creation` (`company_id`, `company_name`, `company_status`, `cin`, `address1`, `address2`, `key_personal`, `city`, `state`, `email_id`, `website`, `pan_number`, `pf_number`, `fax_number`, `office_number`, `esi_number`, `tan_number`, `company_logo`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Prodapt', 'Private Limited', '1711019730', 'No.69/96, Velacherry Road,', 'Thoraipakkam', 'IT', 'Chennai', 'TamilNadu', 'sample@gmail.com', 'www.prodapt.com', 'PEFFD9239F', 'KN/KRP/7654321/783/2343233', '1234235134611', '3435533252', '31/00/123456/030/2333', 'DADS39023G', 'pexels-photo-5641889.jpeg', 0, 1, 1, NULL, '2023-06-03 14:43:06', '2023-06-03 14:43:06'),
(2, 'Hibis', 'Private Limited', '2332323232', 'No.3/7, 14th Trust cross Street, ', 'Mandhaveli', 'IT', 'Chennai', 'TamilNadu', 'hibis@yahoo.in', 'www.hibis.com', 'FSSFD9239F', 'PP/FSD/8923234/834/8348934', '8583948934846', '8943894378', '78/78/983493/893/9439', 'HASF78237H', '', 0, 1, NULL, NULL, '2023-06-03 14:50:24', '2023-06-03 14:50:24'),
(3, 'MRF', 'Private Limited', '2387932489', 'No.3/7, 14th cross Street, ', 'Lawspet', 'Manufacturing', 'Villianur', 'Puducherry', 'mrf@mrfhost.in', 'www.mrf.com', 'GTRFS2309G', 'PP/FRD/7823878/789/8777878', '4336436463343', '4565643523', '67/43/894434/898/9000', 'RFAS23322F', 'mrf-logo.png', 0, 1, NULL, NULL, '2023-06-03 14:55:38', '2023-06-03 14:55:38'),
(4, 'twes', 'Partnership', '', 'No.3/7, 14th Trust cross Street, Mandhaveli, Chennai.', 'Thoraipakkam', 'IT', 'Chennai', 'TamilNadu', 'abc@abc.com', 'www.mrf.com', 'PEFFD9239F', 'KN/KRP/7654321/783/2343233', '3433553535353', '5356435222', '31/00/123456/030/2333', 'HASF78237H', '', 1, 1, NULL, 1, '2023-06-03 14:56:34', '2023-06-03 14:56:34'),
(5, 'twinkle', 'Private Limited', '7444848888', 'dfadfa', 'dfadfa', 'jkdjkgjka', 'Ozhukarai', 'Puducherry', 'abc@abc.com', 'www.hibis.com', 'ASFFD9239F', 'FF/RGH/8923234/545/8348934', '4554646546564', '0414222473', '87/75/983493/455/2324', 'DFSS39023G', '', 1, 1, 1, 1, '2023-06-05 10:20:37', '2023-06-05 10:20:37'),
(6, 'Feather Technology', 'Partnership', '', 'Car Street', 'Chinnakadai', 'Prabakaran', 'Tiruchirappalli', 'TamilNadu', 'feathertechnology@gmail.com', 'www.feathertechnology.com', 'ABCTY1234D', 'MH/BAN/0000064/000/0000123', '', '', '31/00/123456/000/0001', 'PDES03028F', '', 0, 1, NULL, NULL, '2023-06-05 12:34:47', '2023-06-05 12:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `costcentre`
--

CREATE TABLE `costcentre` (
  `costcentreid` int(11) NOT NULL,
  `costcentrename` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_km`
--

CREATE TABLE `daily_km` (
  `daily_km_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_km_ref`
--

CREATE TABLE `daily_km_ref` (
  `daily_km_ref_id` int(11) NOT NULL,
  `vehicle_details_id` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `start_km` varchar(255) DEFAULT NULL,
  `end_km` varchar(255) DEFAULT NULL,
  `daily_km_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance`
--

CREATE TABLE `daily_performance` (
  `daily_performance_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance_ref`
--

CREATE TABLE `daily_performance_ref` (
  `daily_performance_ref_id` int(11) NOT NULL,
  `daily_performance_id` int(11) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `system_date` date DEFAULT NULL,
  `old_target` varchar(200) DEFAULT NULL,
  `target_fixing_id` int(11) DEFAULT NULL,
  `target_fixing_ref_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `department_creation`
--

CREATE TABLE `department_creation` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department_creation`
--

INSERT INTO `department_creation` (`department_id`, `department_name`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Development', 1, 0, '2023-06-03 15:06:23', '2023-06-03 15:06:23'),
(2, 'Marketing', 1, 0, '2023-06-03 15:06:49', '2023-06-03 15:06:49'),
(3, 'Website Development', 1, 0, '2023-06-03 15:07:04', '2023-06-03 15:07:04'),
(4, 'Finance', 2, 0, '2023-06-05 11:28:56', '2023-06-05 11:28:56'),
(5, 'Accounts', 2, 0, '2023-06-05 11:29:03', '2023-06-05 11:29:03'),
(6, 'Development', 5, 0, '2023-06-05 12:36:05', '2023-06-05 12:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `designation_creation`
--

CREATE TABLE `designation_creation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designation_creation`
--

INSERT INTO `designation_creation` (`designation_id`, `designation_name`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Senior PHP Developer', 1, 0, '2023-06-03 15:08:05', '2023-06-03 15:08:05'),
(2, 'Junior PHP Developer', 1, 0, '2023-06-03 15:08:59', '2023-06-03 15:08:59'),
(3, 'Sales', 1, 0, '2023-06-03 15:19:03', '2023-06-03 15:19:03'),
(4, 'Financial Accountant', 2, 0, '2023-06-05 11:30:27', '2023-06-05 11:30:27'),
(5, 'Chief Financial Officer', 2, 0, '2023-06-05 11:30:54', '2023-06-05 11:30:54'),
(6, 'PHP Dev', 5, 0, '2023-06-05 12:36:15', '2023-06-05 12:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `diesel_slip`
--

CREATE TABLE `diesel_slip` (
  `diesel_slip_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `previous_km` int(11) DEFAULT NULL,
  `previous_km_date` varchar(255) DEFAULT NULL,
  `present_km` int(11) DEFAULT NULL,
  `present_km_date` varchar(255) DEFAULT NULL,
  `total_km_run` int(11) DEFAULT NULL,
  `diesel_amount` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting`
--

CREATE TABLE `goal_setting` (
  `goal_setting_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL,
  `year` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting_ref`
--

CREATE TABLE `goal_setting_ref` (
  `goal_setting_ref_id` int(11) NOT NULL,
  `goal_setting_id` int(11) DEFAULT NULL,
  `assertion` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy_creation`
--

CREATE TABLE `hierarchy_creation` (
  `hierarchy_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `top_hierarchy` varchar(255) DEFAULT NULL,
  `sub_ordinate` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_creation`
--

CREATE TABLE `holiday_creation` (
  `holiday_id` int(11) NOT NULL,
  `calendar_year` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday_creation`
--

INSERT INTO `holiday_creation` (`holiday_id`, `calendar_year`, `company_id`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2023-2024', '1,3', 0, 1, NULL, NULL, '2023-06-03 15:05:36', '2023-06-03 15:05:36'),
(2, '2023-2024', '2', 1, 1, NULL, 1, '2023-06-05 10:57:46', '2023-06-05 10:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_creation_ref`
--

CREATE TABLE `holiday_creation_ref` (
  `holiday_ref_id` int(11) NOT NULL,
  `holiday_reff_id` int(11) DEFAULT NULL,
  `holiday_date` date DEFAULT NULL,
  `holiday_description` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday_creation_ref`
--

INSERT INTO `holiday_creation_ref` (`holiday_ref_id`, `holiday_reff_id`, `holiday_date`, `holiday_description`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 1, '2023-06-29', 'Eid al-Adha', 0, 1, NULL, NULL, '2023-06-03 15:05:36', '2023-06-03 15:05:36'),
(3, 2, '2023-06-29', 'Eid al-Adha', 0, 1, NULL, NULL, '2023-06-05 10:58:24', '2023-06-05 10:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_creation`
--

CREATE TABLE `insurance_creation` (
  `insurance_id` int(11) NOT NULL,
  `insurance_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_creation`
--

INSERT INTO `insurance_creation` (`insurance_id`, `insurance_name`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Life Insurance', 1, 0, '2023-06-03 16:49:05', '2023-06-03 16:49:05'),
(2, 'Home Insurance', 1, 0, '2023-06-03 16:49:16', '2023-06-03 16:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register`
--

CREATE TABLE `insurance_register` (
  `ins_reg_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `freq_id` int(11) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `calendar` varchar(50) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(100) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_register`
--

INSERT INTO `insurance_register` (`ins_reg_id`, `company_id`, `insurance_id`, `dept_id`, `freq_id`, `department_id`, `designation_id`, `staff_id`, `calendar`, `from_date`, `to_date`, `frequency_applicable`, `work_status`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 1, 1, '1', '1', '1', 'Yes', '2023-06-03 16:51:06', '2023-06-30 16:51:06', 'frequency_applicable', 0, 0, '2023-06-03 16:51:06', '2023-06-03 16:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register_ref`
--

CREATE TABLE `insurance_register_ref` (
  `ins_reg_ref_id` int(11) NOT NULL,
  `ins_reg_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `freq_id` int(11) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `calendar` varchar(50) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_register_ref`
--

INSERT INTO `insurance_register_ref` (`ins_reg_ref_id`, `ins_reg_id`, `company_id`, `insurance_id`, `dept_id`, `freq_id`, `department_id`, `designation_id`, `staff_id`, `calendar`, `from_date`, `to_date`, `work_status`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 1, 1, 1, '1', '1', '1', 'Yes', '2023-06-03 16:51:06', '2023-06-30 16:51:06', 0, 0, '2023-06-03 16:51:06', '2023-06-03 16:51:06'),
(2, 1, 1, 1, 1, 1, '1', '1', '1', 'Yes', '2023-12-04 16:51:06', '2023-12-30 16:51:06', 0, 0, '2023-06-03 16:51:06', '2023-06-03 16:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `krakpi_calendar_map`
--

CREATE TABLE `krakpi_calendar_map` (
  `krakpi_calendar_map_id` int(11) NOT NULL,
  `krakpi_id` varchar(50) DEFAULT NULL,
  `krakpi_ref_id` varchar(50) DEFAULT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `calendar` varchar(50) DEFAULT NULL,
  `from_date` varchar(50) DEFAULT NULL,
  `to_date` varchar(50) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `krakpi_calendar_map`
--

INSERT INTO `krakpi_calendar_map` (`krakpi_calendar_map_id`, `krakpi_id`, `krakpi_ref_id`, `kra_category`, `calendar`, `from_date`, `to_date`, `work_status`) VALUES
(1, '1', '1', '1', 'Yes', '2023-06-20 16:34:48', '2023-06-26 16:34:48', 0),
(2, '1', '1', '1', 'Yes', '2023-07-20 16:34:48', '2023-07-26 16:34:48', 0),
(3, '1', '1', '1', 'Yes', '2023-08-21 16:34:48', '2023-08-26 16:34:48', 0),
(4, '1', '1', '1', 'Yes', '2023-09-21 16:34:48', '2023-09-26 16:34:48', 0),
(5, '1', '1', '1', 'Yes', '2023-10-21 16:34:48', '2023-10-26 16:34:48', 0),
(6, '1', '1', '1', 'Yes', '2023-11-21 16:34:48', '2023-11-27 16:34:48', 0),
(7, '1', '1', '1', 'Yes', '2023-12-21 16:34:48', '2023-12-27 16:34:48', 0),
(8, '1', '2', '2', 'Yes', '2023-06-15 16:34:48', '2023-06-19 16:34:48', 0),
(9, '1', '2', '2', 'Yes', '2023-07-15 16:34:48', '2023-07-19 16:34:48', 0),
(10, '1', '2', '2', 'Yes', '2023-08-15 16:34:48', '2023-08-19 16:34:48', 0),
(11, '1', '2', '2', 'Yes', '2023-09-15 16:34:48', '2023-09-19 16:34:48', 0),
(12, '1', '2', '2', 'Yes', '2023-10-16 16:34:48', '2023-10-19 16:34:48', 0),
(13, '1', '2', '2', 'Yes', '2023-11-16 16:34:48', '2023-11-20 16:34:48', 0),
(14, '1', '2', '2', 'Yes', '2023-12-16 16:34:48', '2023-12-20 16:34:48', 0),
(15, '1', '3', '3', 'Yes', '2023-06-26 16:34:48', '2023-06-30 16:34:48', 0),
(16, '1', '3', '3', 'Yes', '2023-07-26 16:34:48', '2023-07-31 16:34:48', 0),
(17, '1', '3', '3', 'Yes', '2023-08-26 16:34:48', '2023-08-31 16:34:48', 0),
(18, '1', '3', '3', 'Yes', '2023-09-26 16:34:48', '2023-10-02 16:34:48', 0),
(19, '1', '3', '3', 'Yes', '2023-10-26 16:34:48', '2023-11-02 16:34:48', 0),
(20, '1', '3', '3', 'Yes', '2023-11-27 16:34:48', '2023-12-02 16:34:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `krakpi_creation`
--

CREATE TABLE `krakpi_creation` (
  `krakpi_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `krakpi_creation`
--

INSERT INTO `krakpi_creation` (`krakpi_id`, `company_name`, `department`, `designation`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '1', 0, 1, NULL, NULL, '2023-06-03 16:34:48', '2023-06-03 16:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `krakpi_creation_ref`
--

CREATE TABLE `krakpi_creation_ref` (
  `krakpi_ref_id` int(11) NOT NULL,
  `krakpi_reff_id` int(11) DEFAULT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `rr` varchar(255) DEFAULT NULL,
  `kpi` varchar(255) DEFAULT NULL,
  `frequency` varchar(250) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `calendar` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `criteria` varchar(250) DEFAULT NULL,
  `project_id` varchar(250) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `krakpi_creation_ref`
--

INSERT INTO `krakpi_creation_ref` (`krakpi_ref_id`, `krakpi_reff_id`, `kra_category`, `rr`, `kpi`, `frequency`, `frequency_applicable`, `calendar`, `from_date`, `to_date`, `criteria`, `project_id`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 1, '1', '4', '', 'Monthly', 'frequency_applicable', 'Yes', '2023-06-20 16:34:48', '2023-06-25 16:34:48', 'Project', '1', 0, 0, 1, NULL, NULL, '2023-06-03 16:34:48', '2023-06-03 16:34:48'),
(2, 1, '2', '4', '', 'Monthly', 'frequency_applicable', 'Yes', '2023-06-15 16:34:48', '2023-06-19 16:34:48', 'Project', '2', 0, 0, 1, NULL, NULL, '2023-06-03 16:34:48', '2023-06-03 16:34:48'),
(3, 1, '3', '4', '', 'Monthly', 'frequency_applicable', 'Yes', '2023-06-26 16:34:48', '2023-06-30 16:34:48', 'Project', '3', 0, 0, 1, NULL, NULL, '2023-06-03 16:34:48', '2023-06-03 16:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `kra_creation`
--

CREATE TABLE `kra_creation` (
  `kra_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kra_creation`
--

INSERT INTO `kra_creation` (`kra_id`, `company_id`, `department_id`, `designation_id`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '1', 0, 1, NULL, NULL, '2023-06-03 16:32:14', '2023-06-03 16:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `kra_creation_ref`
--

CREATE TABLE `kra_creation_ref` (
  `kra_creation_ref_id` int(11) NOT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `weightage` varchar(255) DEFAULT NULL,
  `kra_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kra_creation_ref`
--

INSERT INTO `kra_creation_ref` (`kra_creation_ref_id`, `kra_category`, `weightage`, `kra_id`) VALUES
(1, 'Develop Work', '50', '1'),
(2, 'Task complete timing', '40', '1'),
(3, 'communication', '10', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledgerid` int(11) NOT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `subgroupname` varchar(255) DEFAULT NULL,
  `inventory` varchar(255) DEFAULT NULL,
  `costcentre` varchar(255) DEFAULT NULL,
  `openingbalancedr` varchar(200) DEFAULT NULL,
  `opening_credit` varchar(255) DEFAULT NULL,
  `opening_debit` varchar(255) DEFAULT NULL,
  `openingbalance` int(11) DEFAULT 0,
  `status` varchar(255) DEFAULT '0',
  `exciseduty` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `servicetax` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `address3` varchar(255) DEFAULT NULL,
  `address4` varchar(255) DEFAULT NULL,
  `contactnumber` varchar(255) DEFAULT NULL,
  `AccountRefId` int(11) DEFAULT NULL,
  `ServiceTaxNumber` varchar(255) DEFAULT NULL,
  `ExciseDutyReg` varchar(255) DEFAULT NULL,
  `DebitCredit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_checklist`
--

CREATE TABLE `maintenance_checklist` (
  `maintenance_checklist_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date_of_inspection` varchar(255) DEFAULT NULL,
  `asset_details` varchar(255) DEFAULT NULL,
  `checklist` varchar(255) DEFAULT NULL,
  `calendar` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `role1` varchar(255) DEFAULT NULL,
  `role2` varchar(255) DEFAULT NULL,
  `responder_status` int(11) NOT NULL DEFAULT 0,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance_checklist`
--

INSERT INTO `maintenance_checklist` (`maintenance_checklist_id`, `company_id`, `date_of_inspection`, `asset_details`, `checklist`, `calendar`, `from_date`, `to_date`, `role1`, `role2`, `responder_status`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '4', '2023-06-05', '4', 'pm_checklist', 'Yes', '2023-06-05 15:44:34', '2023-06-08 15:44:34', '', '', 0, 0, 0, NULL, NULL, NULL, '2023-06-05 15:44:34', '2023-06-05 15:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_checklist_ref`
--

CREATE TABLE `maintenance_checklist_ref` (
  `maintenance_checklist_ref_id` int(11) NOT NULL,
  `maintenance_checklist_id` varchar(255) DEFAULT NULL,
  `pm_checklist_id` varchar(255) DEFAULT NULL,
  `bm_checklist_id` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `responder_reason` text DEFAULT NULL,
  `responder_status_ref` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance_checklist_ref`
--

INSERT INTO `maintenance_checklist_ref` (`maintenance_checklist_ref_id`, `maintenance_checklist_id`, `pm_checklist_id`, `bm_checklist_id`, `remarks`, `file`, `responder_reason`, `responder_status_ref`) VALUES
(1, '1', '1', NULL, 'test', '', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `media_creation`
--

CREATE TABLE `media_creation` (
  `media_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `media_name` varchar(200) DEFAULT NULL,
  `media_file` varchar(200) DEFAULT NULL,
  `from_period` varchar(255) DEFAULT NULL,
  `to_period` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media_creation`
--

INSERT INTO `media_creation` (`media_id`, `company_id`, `media_name`, `media_file`, `from_period`, `to_period`, `platform`, `status`) VALUES
(1, 1, 'DrumStick', 'sample.gif', '2023-06-05', '2023-06-10', 'YouTube', 0),
(2, 4, 'testwqeqeqwe', '', '2023-06-05', '2023-06-10', 'Facebook', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meeting_minutes`
--

CREATE TABLE `meeting_minutes` (
  `meeting_minutes_id` int(11) NOT NULL,
  `meeting_minutes_approval_line_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `auto_generation_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_minutes_approval_line`
--

CREATE TABLE `meeting_minutes_approval_line` (
  `meeting_minutes_approval_line_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `approval_staff_id` varchar(255) DEFAULT NULL,
  `agree_par_staff_id` varchar(255) DEFAULT NULL,
  `after_notified_staff_id` varchar(255) DEFAULT NULL,
  `receiving_dept_id` varchar(255) DEFAULT NULL,
  `checker_approval` varchar(255) NOT NULL DEFAULT '0',
  `reviewer_approval` varchar(255) NOT NULL DEFAULT '0',
  `final_approval` varchar(255) NOT NULL DEFAULT '0',
  `checker_approval_date` varchar(255) DEFAULT NULL,
  `reviewer_approval_date` varchar(255) DEFAULT NULL,
  `final_approval_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_minutes_parallel_agree_disagree`
--

CREATE TABLE `meeting_minutes_parallel_agree_disagree` (
  `meeting_minutes_agree_disagree_id` int(11) NOT NULL,
  `meeting_minutes_approval_line_id` varchar(255) DEFAULT NULL,
  `agree_disagree_staff_id` varchar(255) DEFAULT NULL,
  `agree_disagree` int(11) NOT NULL DEFAULT 0,
  `agree_disagree_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `from_department` varchar(255) DEFAULT NULL,
  `to_department` varchar(255) DEFAULT NULL,
  `assign_employee` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `inquiry` text DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `completion_target_date` varchar(255) DEFAULT NULL,
  `initial_phase` varchar(255) DEFAULT NULL,
  `final_phase` varchar(255) DEFAULT NULL,
  `date_of_completion` varchar(255) DEFAULT NULL,
  `update_attachment` varchar(255) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `memo_status`
--

CREATE TABLE `memo_status` (
  `memo_status_id` int(11) NOT NULL,
  `date_of_completion` date DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `highlighted` varchar(250) DEFAULT NULL,
  `work_update` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `periodic_level`
--

CREATE TABLE `periodic_level` (
  `periodic_level_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `periodic_date` varchar(255) DEFAULT NULL,
  `asset_details` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permission_or_on_duty`
--

CREATE TABLE `permission_or_on_duty` (
  `permission_on_duty_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `staff_code` varchar(255) DEFAULT NULL,
  `reporting` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `permission_from_time` varchar(255) DEFAULT NULL,
  `permission_to_time` varchar(255) DEFAULT NULL,
  `permission_date` varchar(255) DEFAULT NULL,
  `on_duty_place` varchar(255) DEFAULT NULL,
  `leave_date` varchar(255) DEFAULT NULL,
  `leave_reason` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pm_checklist`
--

CREATE TABLE `pm_checklist` (
  `pm_checklist_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `type_of_checklist` varchar(255) DEFAULT NULL,
  `yes_no_na` varchar(255) DEFAULT NULL,
  `no_of_option` varchar(255) DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm_checklist`
--

INSERT INTO `pm_checklist` (`pm_checklist_id`, `company_id`, `category_id`, `checklist`, `type_of_checklist`, `yes_no_na`, `no_of_option`, `option1`, `option2`, `option3`, `option4`, `frequency`, `frequency_applicable`, `rating`, `maintenance_checklist`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '4', '1', 'test', 'Yes/No/NA', 'Yes', '', '', '', '', '', 'Monthly', 'frequency_applicable', 'High', 1, 0, 1, NULL, NULL, '2023-06-05 15:44:10', '2023-06-05 15:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `pm_checklist_ref`
--

CREATE TABLE `pm_checklist_ref` (
  `pm_checklist_ref_id` int(11) NOT NULL,
  `pm_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_ref_id` varchar(200) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `from_date` varchar(50) DEFAULT NULL,
  `to_date` varchar(50) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `role1` varchar(200) DEFAULT NULL,
  `role2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm_checklist_ref`
--

INSERT INTO `pm_checklist_ref` (`pm_checklist_ref_id`, `pm_checklist_id`, `maintenance_checklist_id`, `maintenance_checklist_ref_id`, `checklist`, `from_date`, `to_date`, `work_status`, `role1`, `role2`) VALUES
(1, '1', '1', '1', 'test', '2023-06-05 15:44:34', '2023-06-08 15:44:34', 0, '', ''),
(2, '1', '1', '1', 'test', '2023-07-05 15:44:34', '2023-07-08 15:44:34', 0, '', ''),
(3, '1', '1', '1', 'test', '2023-08-05 15:44:34', '2023-08-08 15:44:34', 0, '', ''),
(4, '1', '1', '1', 'test', '2023-09-05 15:44:34', '2023-09-08 15:44:34', 0, '', ''),
(5, '1', '1', '1', 'test', '2023-10-05 15:44:34', '2023-10-09 15:44:34', 0, '', ''),
(6, '1', '1', '1', 'test', '2023-11-06 15:44:34', '2023-11-09 15:44:34', 0, '', ''),
(7, '1', '1', '1', 'test', '2023-12-06 15:44:34', '2023-12-09 15:44:34', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `project_creation`
--

CREATE TABLE `project_creation` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_creation`
--

INSERT INTO `project_creation` (`project_id`, `project_name`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Project 1', 0, NULL, NULL, NULL, '2023-06-03 16:32:59', '2023-06-03 16:32:59'),
(2, 'Project 2', 0, NULL, NULL, NULL, '2023-06-03 16:33:05', '2023-06-03 16:33:05'),
(3, 'Project 3', 0, NULL, NULL, NULL, '2023-06-03 16:34:28', '2023-06-03 16:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `promotional_activities`
--

CREATE TABLE `promotional_activities` (
  `promotional_activities_id` int(11) NOT NULL,
  `project` varchar(100) DEFAULT NULL,
  `campaign_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotional_activities`
--

INSERT INTO `promotional_activities` (`promotional_activities_id`, `project`, `campaign_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Promotion Project ', 0, 0, 1, NULL, NULL, '2023-06-03 17:10:36', '2023-06-03 17:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `promotional_activities_ref`
--

CREATE TABLE `promotional_activities_ref` (
  `promotional_activities_ref_id` int(11) NOT NULL,
  `promotional_activities_id` int(11) DEFAULT NULL,
  `activity_involved` varchar(200) DEFAULT NULL,
  `time_frame_start` int(50) DEFAULT NULL,
  `duration` int(50) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `employee_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotional_activities_ref`
--

INSERT INTO `promotional_activities_ref` (`promotional_activities_ref_id`, `promotional_activities_id`, `activity_involved`, `time_frame_start`, `duration`, `start_date`, `end_date`, `employee_name`) VALUES
(1, 1, 'devlopment Post ', 12, 30, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_creation`
--

CREATE TABLE `report_creation` (
  `report_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `report_name` varchar(200) DEFAULT NULL,
  `report_file` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_creation`
--

INSERT INTO `report_creation` (`report_id`, `company_id`, `report_name`, `report_file`, `status`) VALUES
(1, 1, 'Regular Report', 'herbs-flavoring-seasoning-cooking.jpg', 0),
(2, 4, 'testsdfasdf', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rgp_creation`
--

CREATE TABLE `rgp_creation` (
  `rgp_id` int(11) NOT NULL,
  `rgp_date` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `asset_class` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `branch_from` varchar(255) DEFAULT NULL,
  `branch_to` varchar(255) DEFAULT NULL,
  `from_comm_line1` varchar(255) DEFAULT NULL,
  `from_comm_line2` varchar(255) DEFAULT NULL,
  `to_comm_line1` varchar(255) DEFAULT NULL,
  `to_comm_line2` varchar(255) DEFAULT NULL,
  `asset_name_id` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `reason_rgp` varchar(255) DEFAULT NULL,
  `extended_date` varchar(255) DEFAULT NULL,
  `extend_reason` varchar(255) DEFAULT NULL,
  `extend_status` varchar(255) DEFAULT NULL,
  `rgp_status` varchar(255) NOT NULL DEFAULT 'outward',
  `status` int(11) NOT NULL DEFAULT 0,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rgp_creation`
--

INSERT INTO `rgp_creation` (`rgp_id`, `rgp_date`, `return_date`, `asset_class`, `company_id`, `branch_from`, `branch_to`, `from_comm_line1`, `from_comm_line2`, `to_comm_line1`, `to_comm_line2`, `asset_name_id`, `asset_value`, `reason_rgp`, `extended_date`, `extend_reason`, `extend_status`, `rgp_status`, `status`, `created_id`, `updated_id`, `created_date`, `updated_date`) VALUES
(1, '2023-06-04', '2023-06-07', '4', '1', '1', '2', 'No.4 , OMR road,', 'Kandhanchavadi', 'No.23 , Ashok nagar road,', 'ekkatuthangal', '2', '50000', 'There is a need for the printer', '2023-06-10', 'They need it', NULL, 'outward', 0, NULL, NULL, '2023-06-03 17:05:01', '2023-06-03 17:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `rr_creation`
--

CREATE TABLE `rr_creation` (
  `rr_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rr_creation`
--

INSERT INTO `rr_creation` (`rr_id`, `company_name`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', 0, 1, NULL, NULL, '2023-06-03 16:12:07', '2023-06-03 16:12:07'),
(2, '2', 0, 1, NULL, NULL, '2023-06-05 11:59:30', '2023-06-05 11:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `rr_creation_ref`
--

CREATE TABLE `rr_creation_ref` (
  `rr_ref_id` int(11) NOT NULL,
  `rr_reff_id` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(250) DEFAULT NULL,
  `rr` varchar(255) DEFAULT NULL,
  `frequency` varchar(250) DEFAULT NULL,
  `code_ref` varchar(250) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rr_creation_ref`
--

INSERT INTO `rr_creation_ref` (`rr_ref_id`, `rr_reff_id`, `department`, `designation`, `rr`, `frequency`, `code_ref`, `applicability`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(3, '1', '2', '3', 'Daily Routine is Client visit', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-03 16:20:11', '2023-06-03 16:20:11'),
(4, '1', '1', '1', 'Web App Develop', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-03 16:20:11', '2023-06-03 16:20:11'),
(7, '2', '4', '4', 'Clear Monthly Finance Files', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-05 11:59:49', '2023-06-05 11:59:49'),
(8, '2', '4', '5', 'Check Monthly Files are clear', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-05 11:59:49', '2023-06-05 11:59:49');

-- --------------------------------------------------------

--
-- Table structure for table `service_indent`
--

CREATE TABLE `service_indent` (
  `service_indent_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date_of_indent` date DEFAULT NULL,
  `asset_class` varchar(255) DEFAULT NULL,
  `asset_name1` varchar(250) DEFAULT NULL,
  `asset_value` varchar(250) DEFAULT NULL,
  `vendor_address` varchar(250) DEFAULT NULL,
  `vendor_address1` varchar(250) DEFAULT NULL,
  `vendor_address2` varchar(250) DEFAULT NULL,
  `company_address` varchar(250) DEFAULT NULL,
  `company_address1` varchar(250) DEFAULT NULL,
  `company_address2` varchar(250) DEFAULT NULL,
  `reason_for_indent` varchar(250) DEFAULT NULL,
  `expected_to_arrive` varchar(250) DEFAULT NULL,
  `stock_in_out` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_indent`
--

INSERT INTO `service_indent` (`service_indent_id`, `company_id`, `date_of_indent`, `asset_class`, `asset_name1`, `asset_value`, `vendor_address`, `vendor_address1`, `vendor_address2`, `company_address`, `company_address1`, `company_address2`, `reason_for_indent`, `expected_to_arrive`, `stock_in_out`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '2023-06-03', '5', '3', '200000', 'No.69, Anna Salai,', 'Little Mount', 'Chennai.', 'No.4 , OMR road,, Kandhanchavadi', 'Chennai', 'TamilNadu', 'Extra Noice , Some not working Properly, Damage', '2023-06-10', 1, 0, 1, 1, NULL, '2023-06-03 16:58:24', '2023-06-03 16:58:24'),
(2, '4', '2023-06-09', '1', '', '', 'test1', 'test2', 'tes3', 'No.3/7, 14th Trust cross Street,,  Mandhaveli, Chennai.', 'Chennai', 'TamilNadu', 'test', '2023-06-23', 1, 0, 1, NULL, NULL, '2023-06-05 15:30:15', '2023-06-05 15:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `spare_creation`
--

CREATE TABLE `spare_creation` (
  `spare_id` int(11) NOT NULL,
  `spare_name` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spare_creation`
--

INSERT INTO `spare_creation` (`spare_id`, `spare_name`, `branch_id`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Monitor IC', 1, 1, 0, '2023-06-03 17:02:03', '2023-06-03 17:02:03'),
(2, 'Display', 1, 1, 0, '2023-06-03 17:02:12', '2023-06-03 17:02:12'),
(3, 'Menu Buttons', 1, 1, 0, '2023-06-03 17:02:21', '2023-06-03 17:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `staff_creation`
--

CREATE TABLE `staff_creation` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `designation` int(11) DEFAULT NULL,
  `emp_code` text DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `doj` varchar(255) DEFAULT NULL,
  `krikpi` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `key_skills` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email_id` varchar(250) NOT NULL,
  `reporting` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_creation`
--

INSERT INTO `staff_creation` (`staff_id`, `staff_name`, `company_id`, `designation`, `emp_code`, `department`, `doj`, `krikpi`, `dob`, `key_skills`, `contact_number`, `email_id`, `reporting`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Revan', 1, 1, '101', 1, '2021-12-09', '1', '1997-12-06', 'Speaker', '9499494948', 'abc@abc.in', '', 0, 1, NULL, NULL, '2023-06-03 16:35:58', '2023-06-03 16:35:58'),
(2, 'Ram', 1, 1, '102', 1, '2022-02-02', '1', '1998-06-29', 'Js', '8745454542', 'abc@little.in', '', 0, 1, NULL, NULL, '2023-06-03 16:37:59', '2023-06-03 16:37:59'),
(3, 'Nuaim', 1, 1, '103', 1, '2022-01-12', '1', '1997-05-16', 'Js', '7875774545', 'xyz@little.in', '', 0, 1, NULL, NULL, '2023-06-03 16:40:07', '2023-06-03 16:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `tag_creation`
--

CREATE TABLE `tag_creation` (
  `tag_id` int(11) NOT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `tag_classification` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag_creation`
--

INSERT INTO `tag_creation` (`tag_id`, `department_id`, `company_id`, `tag_classification`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', 'Development Tag', 0, 1, NULL, NULL, '2023-06-03 15:27:10', '2023-06-03 15:27:10'),
(2, '2', '1', 'Marketing Tag', 0, 1, NULL, NULL, '2023-06-03 15:27:28', '2023-06-03 15:27:28'),
(3, '4', '2', 'Finance Achievement Tag', 0, 1, 1, 1, '2023-06-05 11:33:30', '2023-06-05 11:33:30'),
(4, '2', '1', 'Testing Tag', 1, 1, NULL, 1, '2023-06-05 11:37:17', '2023-06-05 11:37:17'),
(5, '4', '2', 'eeee', 0, 1, 1, NULL, '2023-06-05 11:48:41', '2023-06-05 11:48:41'),
(6, '6', '5', 'test', 0, 1, NULL, NULL, '2023-06-05 12:36:48', '2023-06-05 12:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `target_fixing`
--

CREATE TABLE `target_fixing` (
  `target_fixing_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `no_of_months` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `target_fixing_ref`
--

CREATE TABLE `target_fixing_ref` (
  `target_fixing_ref_id` int(11) NOT NULL,
  `target_fixing_id` int(11) NOT NULL,
  `goal_setting_and_kra_id` varchar(50) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `new_assertion` varchar(200) DEFAULT NULL,
  `new_target` varchar(100) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `deleted_date` varchar(100) DEFAULT NULL,
  `deleted_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `todo_creation`
--

CREATE TABLE `todo_creation` (
  `todo_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `work_des` varchar(255) DEFAULT NULL,
  `tag_id` varchar(255) DEFAULT NULL,
  `priority` varchar(200) DEFAULT NULL,
  `assign_to` varchar(255) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `criteria` varchar(255) DEFAULT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_location`
--

CREATE TABLE `transfer_location` (
  `transfer_location_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `staff_code` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `dot` varchar(255) DEFAULT NULL,
  `transfer_location` varchar(255) DEFAULT NULL,
  `transfer_effective_from` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `Createddate` datetime NOT NULL DEFAULT current_timestamp(),
  `administration_module` varchar(11) DEFAULT NULL,
  `dashboard` varchar(11) DEFAULT NULL,
  `company_creation` varchar(11) DEFAULT NULL,
  `branch_creation` varchar(11) DEFAULT NULL,
  `holiday_creation` varchar(11) DEFAULT NULL,
  `manage_users` varchar(11) DEFAULT NULL,
  `master_module` varchar(11) DEFAULT NULL,
  `basic_sub_module` varchar(11) DEFAULT NULL,
  `responsibility_sub_module` varchar(11) DEFAULT NULL,
  `audit_sub_module` varchar(11) DEFAULT NULL,
  `others_sub_module` varchar(11) DEFAULT NULL,
  `basic_creation` varchar(11) DEFAULT NULL,
  `tag_creation` varchar(11) DEFAULT NULL,
  `rr_creation` varchar(11) DEFAULT NULL,
  `kra_category` varchar(11) DEFAULT NULL,
  `krakpi_creation` varchar(11) DEFAULT NULL,
  `staff_creation` varchar(11) DEFAULT NULL,
  `audit_area_creation` varchar(11) DEFAULT NULL,
  `audit_area_checklist` varchar(11) DEFAULT NULL,
  `audit_assign` varchar(11) DEFAULT NULL,
  `audit_follow_up` varchar(11) DEFAULT NULL,
  `report_template` varchar(11) DEFAULT NULL,
  `media_master` varchar(11) DEFAULT NULL,
  `asset_creation` varchar(11) DEFAULT NULL,
  `insurance_register` varchar(11) DEFAULT NULL,
  `service_indent` varchar(11) DEFAULT NULL,
  `asset_details` varchar(11) DEFAULT NULL,
  `rgp_creation` varchar(11) DEFAULT NULL,
  `promotional_activities` varchar(11) DEFAULT NULL,
  `work_force_module` varchar(11) DEFAULT NULL,
  `schedule_task_sub_module` varchar(11) DEFAULT NULL,
  `memo_sub_module` varchar(11) DEFAULT NULL,
  `campaign` varchar(11) DEFAULT NULL,
  `assign_work` varchar(11) DEFAULT NULL,
  `todo` varchar(11) DEFAULT NULL,
  `assigned_work` varchar(11) DEFAULT NULL,
  `memo_initiate` varchar(11) DEFAULT NULL,
  `memo_assigned` varchar(11) DEFAULT NULL,
  `memo_update` varchar(11) DEFAULT NULL,
  `maintenance_module` varchar(11) DEFAULT NULL,
  `pm_checklist` varchar(11) DEFAULT NULL,
  `bm_checklist` varchar(11) DEFAULT NULL,
  `maintenance_checklist` varchar(11) DEFAULT NULL,
  `manpower_in_out_module` varchar(11) DEFAULT NULL,
  `permission_or_onduty` varchar(11) DEFAULT NULL,
  `transfer_location` varchar(11) DEFAULT NULL,
  `target_fixing_module` varchar(11) DEFAULT NULL,
  `goal_setting` varchar(11) DEFAULT NULL,
  `target_fixing` varchar(11) DEFAULT NULL,
  `daily_performance` varchar(11) DEFAULT NULL,
  `appreciation_depreciation` varchar(11) DEFAULT NULL,
  `vehicle_management_module` varchar(11) DEFAULT NULL,
  `vehicle_details` varchar(11) DEFAULT NULL,
  `daily_km` varchar(11) DEFAULT NULL,
  `diesel_slip` varchar(11) DEFAULT NULL,
  `approval_mechanism_module` varchar(11) DEFAULT NULL,
  `approval_requisition` varchar(11) DEFAULT NULL,
  `business_communication_outgoing` varchar(11) DEFAULT NULL,
  `minutes_of_meeting` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `fullname`, `title`, `emailid`, `user_name`, `user_password`, `role`, `staff_id`, `branch_id`, `designation_id`, `mobile_number`, `status`, `Createddate`, `administration_module`, `dashboard`, `company_creation`, `branch_creation`, `holiday_creation`, `manage_users`, `master_module`, `basic_sub_module`, `responsibility_sub_module`, `audit_sub_module`, `others_sub_module`, `basic_creation`, `tag_creation`, `rr_creation`, `kra_category`, `krakpi_creation`, `staff_creation`, `audit_area_creation`, `audit_area_checklist`, `audit_assign`, `audit_follow_up`, `report_template`, `media_master`, `asset_creation`, `insurance_register`, `service_indent`, `asset_details`, `rgp_creation`, `promotional_activities`, `work_force_module`, `schedule_task_sub_module`, `memo_sub_module`, `campaign`, `assign_work`, `todo`, `assigned_work`, `memo_initiate`, `memo_assigned`, `memo_update`, `maintenance_module`, `pm_checklist`, `bm_checklist`, `maintenance_checklist`, `manpower_in_out_module`, `permission_or_onduty`, `transfer_location`, `target_fixing_module`, `goal_setting`, `target_fixing`, `daily_performance`, `appreciation_depreciation`, `vehicle_management_module`, `vehicle_details`, `daily_km`, `diesel_slip`, `approval_mechanism_module`, `approval_requisition`, `business_communication_outgoing`, `minutes_of_meeting`) VALUES
(1, 'Super', 'Admin', 'Super Admin', 'Super Admin', 'support@feathertechnology.in', 'support@feathertechnology.in', 'admin@123', '1', 'Overall', 'Overall', NULL, NULL, '0', '2021-04-17 17:08:00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(19, 'Manager', 'Manager', 'Manager', 'Manager', 'manager@feathertechnology.in', 'manager@feathertechnology.in', 'admin@123', '3', NULL, '1', NULL, NULL, '0', '2023-01-31 16:52:54', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(20, 'Employee', 'Employee', 'Employee', 'Employee', 'employee@feathertechnology.in', 'employee@feathertechnology.in', 'admin@123', '4', '1', '1', NULL, NULL, '0', '2023-03-10 16:33:04', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(21, 'Employee1', 'Employee1', 'Employee1', 'Employee1', 'employee1@feathertechnology.in', 'employee1@feathertechnology.in', 'admin@123', '4', '2', '1', NULL, NULL, '0', '2023-03-14 13:09:26', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(22, 'Employee2', 'Employee2', 'Employee2', 'Employee2', 'employee2@feathertechnology.in', 'employee2@feathertechnology.in', 'admin@123', '4', '3', '1', NULL, NULL, '0', '2023-03-15 10:48:41', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(23, 'Employee3', 'Employee3', 'Employee3', 'Employee3', 'employee3@feathertechnology.in', 'employee3@feathertechnology.in', 'admin@123', '4', '4', '1', NULL, NULL, '0', '2023-03-16 16:34:10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(24, 'Employee4', 'Employee4', 'Employee4', 'Employee4', 'employee4@feathertechnology.in', 'employee4@feathertechnology.in', 'admin@123', '4', '5', '2', NULL, NULL, '0', '2023-03-22 09:40:51', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(26, 'Test firstname', 'Test Lastname', 'Test firstname Test Lastname', 'Test', 'test@testmail.com', 'test@testmail.com', '123', '3', NULL, NULL, NULL, NULL, '0', '2023-06-05 11:00:32', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'),
(27, 'Revan', 'S', 'Revan S', 'Testing', 'revan@test.com', 'revan@test.com', '123', '3', NULL, NULL, NULL, NULL, '0', '2023-06-05 11:06:57', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `vehicle_details_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vehicle_code` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `date_of_purchase` varchar(255) DEFAULT NULL,
  `fitment_upto` varchar(255) DEFAULT NULL,
  `insurance_upto` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `book_value_as_on` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `work_status`
--

CREATE TABLE `work_status` (
  `status_id` int(11) NOT NULL,
  `work_id` varchar(255) DEFAULT NULL,
  `work_des` varchar(255) DEFAULT NULL,
  `work_status` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `completed_file` varchar(255) DEFAULT NULL,
  `outdated_completed_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `year_creation`
--

CREATE TABLE `year_creation` (
  `year_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `appreciation_depreciation`
--
ALTER TABLE `appreciation_depreciation`
  ADD PRIMARY KEY (`appreciation_depreciation_id`);

--
-- Indexes for table `appreciation_depreciation_ref`
--
ALTER TABLE `appreciation_depreciation_ref`
  ADD PRIMARY KEY (`appreciation_depreciation_ref_id`);

--
-- Indexes for table `approval_line`
--
ALTER TABLE `approval_line`
  ADD PRIMARY KEY (`approval_line_id`);

--
-- Indexes for table `approval_requisition`
--
ALTER TABLE `approval_requisition`
  ADD PRIMARY KEY (`approval_requisition_id`);

--
-- Indexes for table `approval_requisition_parallel_agree_disagree`
--
ALTER TABLE `approval_requisition_parallel_agree_disagree`
  ADD PRIMARY KEY (`approval_requisition_agree_disagree_id`);

--
-- Indexes for table `asset_details`
--
ALTER TABLE `asset_details`
  ADD PRIMARY KEY (`asset_details_id`);

--
-- Indexes for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `asset_register`
--
ALTER TABLE `asset_register`
  ADD PRIMARY KEY (`asset_id`);

--
-- Indexes for table `assign_work`
--
ALTER TABLE `assign_work`
  ADD PRIMARY KEY (`work_id`);

--
-- Indexes for table `assign_work_ref`
--
ALTER TABLE `assign_work_ref`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `audit_area_creation`
--
ALTER TABLE `audit_area_creation`
  ADD PRIMARY KEY (`audit_area_id`);

--
-- Indexes for table `audit_area_creation_ref`
--
ALTER TABLE `audit_area_creation_ref`
  ADD PRIMARY KEY (`audit_area_creation_ref_id`);

--
-- Indexes for table `audit_assign`
--
ALTER TABLE `audit_assign`
  ADD PRIMARY KEY (`audit_assign_id`);

--
-- Indexes for table `audit_assign_ref`
--
ALTER TABLE `audit_assign_ref`
  ADD PRIMARY KEY (`audit_assign_ref_id`);

--
-- Indexes for table `audit_checklist`
--
ALTER TABLE `audit_checklist`
  ADD PRIMARY KEY (`audit_checklist_id`);

--
-- Indexes for table `audit_checklist_ref`
--
ALTER TABLE `audit_checklist_ref`
  ADD PRIMARY KEY (`audit_checklist_ref_id`);

--
-- Indexes for table `audit_followup`
--
ALTER TABLE `audit_followup`
  ADD PRIMARY KEY (`audit_followup_id`);

--
-- Indexes for table `bankmaster`
--
ALTER TABLE `bankmaster`
  ADD PRIMARY KEY (`bankid`);

--
-- Indexes for table `basic_creation`
--
ALTER TABLE `basic_creation`
  ADD PRIMARY KEY (`basic_creation_id`);

--
-- Indexes for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  ADD PRIMARY KEY (`bm_checklist_id`);

--
-- Indexes for table `branch_creation`
--
ALTER TABLE `branch_creation`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `business_com_line`
--
ALTER TABLE `business_com_line`
  ADD PRIMARY KEY (`business_com_line_id`);

--
-- Indexes for table `business_com_out`
--
ALTER TABLE `business_com_out`
  ADD PRIMARY KEY (`business_com_out_id`);

--
-- Indexes for table `business_com_parallel_agree_disagree`
--
ALTER TABLE `business_com_parallel_agree_disagree`
  ADD PRIMARY KEY (`business_com_parallel_agree_disagree_id`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `campaign_ref`
--
ALTER TABLE `campaign_ref`
  ADD PRIMARY KEY (`campaign_ref_id`);

--
-- Indexes for table `category_creation`
--
ALTER TABLE `category_creation`
  ADD PRIMARY KEY (`category_creation_id`);

--
-- Indexes for table `company_creation`
--
ALTER TABLE `company_creation`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `costcentre`
--
ALTER TABLE `costcentre`
  ADD PRIMARY KEY (`costcentreid`);

--
-- Indexes for table `daily_km`
--
ALTER TABLE `daily_km`
  ADD PRIMARY KEY (`daily_km_id`);

--
-- Indexes for table `daily_km_ref`
--
ALTER TABLE `daily_km_ref`
  ADD PRIMARY KEY (`daily_km_ref_id`);

--
-- Indexes for table `daily_performance`
--
ALTER TABLE `daily_performance`
  ADD PRIMARY KEY (`daily_performance_id`);

--
-- Indexes for table `daily_performance_ref`
--
ALTER TABLE `daily_performance_ref`
  ADD PRIMARY KEY (`daily_performance_ref_id`);

--
-- Indexes for table `department_creation`
--
ALTER TABLE `department_creation`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `designation_creation`
--
ALTER TABLE `designation_creation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  ADD PRIMARY KEY (`diesel_slip_id`);

--
-- Indexes for table `goal_setting`
--
ALTER TABLE `goal_setting`
  ADD PRIMARY KEY (`goal_setting_id`);

--
-- Indexes for table `goal_setting_ref`
--
ALTER TABLE `goal_setting_ref`
  ADD PRIMARY KEY (`goal_setting_ref_id`);

--
-- Indexes for table `hierarchy_creation`
--
ALTER TABLE `hierarchy_creation`
  ADD PRIMARY KEY (`hierarchy_id`);

--
-- Indexes for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `holiday_creation_ref`
--
ALTER TABLE `holiday_creation_ref`
  ADD PRIMARY KEY (`holiday_ref_id`);

--
-- Indexes for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  ADD PRIMARY KEY (`insurance_id`);

--
-- Indexes for table `insurance_register`
--
ALTER TABLE `insurance_register`
  ADD PRIMARY KEY (`ins_reg_id`);

--
-- Indexes for table `insurance_register_ref`
--
ALTER TABLE `insurance_register_ref`
  ADD PRIMARY KEY (`ins_reg_ref_id`);

--
-- Indexes for table `krakpi_calendar_map`
--
ALTER TABLE `krakpi_calendar_map`
  ADD PRIMARY KEY (`krakpi_calendar_map_id`);

--
-- Indexes for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  ADD PRIMARY KEY (`krakpi_id`);

--
-- Indexes for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  ADD PRIMARY KEY (`krakpi_ref_id`);

--
-- Indexes for table `kra_creation`
--
ALTER TABLE `kra_creation`
  ADD PRIMARY KEY (`kra_id`);

--
-- Indexes for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  ADD PRIMARY KEY (`kra_creation_ref_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledgerid`);

--
-- Indexes for table `maintenance_checklist`
--
ALTER TABLE `maintenance_checklist`
  ADD PRIMARY KEY (`maintenance_checklist_id`);

--
-- Indexes for table `maintenance_checklist_ref`
--
ALTER TABLE `maintenance_checklist_ref`
  ADD PRIMARY KEY (`maintenance_checklist_ref_id`);

--
-- Indexes for table `media_creation`
--
ALTER TABLE `media_creation`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `meeting_minutes`
--
ALTER TABLE `meeting_minutes`
  ADD PRIMARY KEY (`meeting_minutes_id`);

--
-- Indexes for table `meeting_minutes_approval_line`
--
ALTER TABLE `meeting_minutes_approval_line`
  ADD PRIMARY KEY (`meeting_minutes_approval_line_id`);

--
-- Indexes for table `meeting_minutes_parallel_agree_disagree`
--
ALTER TABLE `meeting_minutes_parallel_agree_disagree`
  ADD PRIMARY KEY (`meeting_minutes_agree_disagree_id`);

--
-- Indexes for table `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`memo_id`);

--
-- Indexes for table `memo_status`
--
ALTER TABLE `memo_status`
  ADD PRIMARY KEY (`memo_status_id`);

--
-- Indexes for table `periodic_level`
--
ALTER TABLE `periodic_level`
  ADD PRIMARY KEY (`periodic_level_id`);

--
-- Indexes for table `permission_or_on_duty`
--
ALTER TABLE `permission_or_on_duty`
  ADD PRIMARY KEY (`permission_on_duty_id`);

--
-- Indexes for table `pm_checklist`
--
ALTER TABLE `pm_checklist`
  ADD PRIMARY KEY (`pm_checklist_id`);

--
-- Indexes for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  ADD PRIMARY KEY (`pm_checklist_ref_id`);

--
-- Indexes for table `project_creation`
--
ALTER TABLE `project_creation`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  ADD PRIMARY KEY (`promotional_activities_id`);

--
-- Indexes for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  ADD PRIMARY KEY (`promotional_activities_ref_id`);

--
-- Indexes for table `report_creation`
--
ALTER TABLE `report_creation`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  ADD PRIMARY KEY (`rgp_id`);

--
-- Indexes for table `rr_creation`
--
ALTER TABLE `rr_creation`
  ADD PRIMARY KEY (`rr_id`);

--
-- Indexes for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  ADD PRIMARY KEY (`rr_ref_id`);

--
-- Indexes for table `service_indent`
--
ALTER TABLE `service_indent`
  ADD PRIMARY KEY (`service_indent_id`);

--
-- Indexes for table `spare_creation`
--
ALTER TABLE `spare_creation`
  ADD PRIMARY KEY (`spare_id`);

--
-- Indexes for table `staff_creation`
--
ALTER TABLE `staff_creation`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `tag_creation`
--
ALTER TABLE `tag_creation`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `target_fixing`
--
ALTER TABLE `target_fixing`
  ADD PRIMARY KEY (`target_fixing_id`);

--
-- Indexes for table `target_fixing_ref`
--
ALTER TABLE `target_fixing_ref`
  ADD PRIMARY KEY (`target_fixing_ref_id`);

--
-- Indexes for table `todo_creation`
--
ALTER TABLE `todo_creation`
  ADD PRIMARY KEY (`todo_id`);

--
-- Indexes for table `transfer_location`
--
ALTER TABLE `transfer_location`
  ADD PRIMARY KEY (`transfer_location_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`vehicle_details_id`);

--
-- Indexes for table `work_status`
--
ALTER TABLE `work_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `year_creation`
--
ALTER TABLE `year_creation`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appreciation_depreciation`
--
ALTER TABLE `appreciation_depreciation`
  MODIFY `appreciation_depreciation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appreciation_depreciation_ref`
--
ALTER TABLE `appreciation_depreciation_ref`
  MODIFY `appreciation_depreciation_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_line`
--
ALTER TABLE `approval_line`
  MODIFY `approval_line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_requisition`
--
ALTER TABLE `approval_requisition`
  MODIFY `approval_requisition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_requisition_parallel_agree_disagree`
--
ALTER TABLE `approval_requisition_parallel_agree_disagree`
  MODIFY `approval_requisition_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_details`
--
ALTER TABLE `asset_details`
  MODIFY `asset_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_register`
--
ALTER TABLE `asset_register`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assign_work`
--
ALTER TABLE `assign_work`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_work_ref`
--
ALTER TABLE `assign_work_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_area_creation`
--
ALTER TABLE `audit_area_creation`
  MODIFY `audit_area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_area_creation_ref`
--
ALTER TABLE `audit_area_creation_ref`
  MODIFY `audit_area_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_assign`
--
ALTER TABLE `audit_assign`
  MODIFY `audit_assign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_assign_ref`
--
ALTER TABLE `audit_assign_ref`
  MODIFY `audit_assign_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_checklist`
--
ALTER TABLE `audit_checklist`
  MODIFY `audit_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_checklist_ref`
--
ALTER TABLE `audit_checklist_ref`
  MODIFY `audit_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_followup`
--
ALTER TABLE `audit_followup`
  MODIFY `audit_followup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bankmaster`
--
ALTER TABLE `bankmaster`
  MODIFY `bankid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_creation`
--
ALTER TABLE `basic_creation`
  MODIFY `basic_creation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  MODIFY `bm_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_creation`
--
ALTER TABLE `branch_creation`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `business_com_line`
--
ALTER TABLE `business_com_line`
  MODIFY `business_com_line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_com_out`
--
ALTER TABLE `business_com_out`
  MODIFY `business_com_out_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_com_parallel_agree_disagree`
--
ALTER TABLE `business_com_parallel_agree_disagree`
  MODIFY `business_com_parallel_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_ref`
--
ALTER TABLE `campaign_ref`
  MODIFY `campaign_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_creation`
--
ALTER TABLE `category_creation`
  MODIFY `category_creation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_creation`
--
ALTER TABLE `company_creation`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `costcentre`
--
ALTER TABLE `costcentre`
  MODIFY `costcentreid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_km`
--
ALTER TABLE `daily_km`
  MODIFY `daily_km_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_km_ref`
--
ALTER TABLE `daily_km_ref`
  MODIFY `daily_km_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_performance`
--
ALTER TABLE `daily_performance`
  MODIFY `daily_performance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_performance_ref`
--
ALTER TABLE `daily_performance_ref`
  MODIFY `daily_performance_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_creation`
--
ALTER TABLE `department_creation`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designation_creation`
--
ALTER TABLE `designation_creation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  MODIFY `diesel_slip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goal_setting`
--
ALTER TABLE `goal_setting`
  MODIFY `goal_setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goal_setting_ref`
--
ALTER TABLE `goal_setting_ref`
  MODIFY `goal_setting_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hierarchy_creation`
--
ALTER TABLE `hierarchy_creation`
  MODIFY `hierarchy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `holiday_creation_ref`
--
ALTER TABLE `holiday_creation_ref`
  MODIFY `holiday_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_register`
--
ALTER TABLE `insurance_register`
  MODIFY `ins_reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_register_ref`
--
ALTER TABLE `insurance_register_ref`
  MODIFY `ins_reg_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `krakpi_calendar_map`
--
ALTER TABLE `krakpi_calendar_map`
  MODIFY `krakpi_calendar_map_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  MODIFY `krakpi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  MODIFY `krakpi_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kra_creation`
--
ALTER TABLE `kra_creation`
  MODIFY `kra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  MODIFY `kra_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledgerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_checklist`
--
ALTER TABLE `maintenance_checklist`
  MODIFY `maintenance_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_checklist_ref`
--
ALTER TABLE `maintenance_checklist_ref`
  MODIFY `maintenance_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media_creation`
--
ALTER TABLE `media_creation`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meeting_minutes`
--
ALTER TABLE `meeting_minutes`
  MODIFY `meeting_minutes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_minutes_approval_line`
--
ALTER TABLE `meeting_minutes_approval_line`
  MODIFY `meeting_minutes_approval_line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_minutes_parallel_agree_disagree`
--
ALTER TABLE `meeting_minutes_parallel_agree_disagree`
  MODIFY `meeting_minutes_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memo_status`
--
ALTER TABLE `memo_status`
  MODIFY `memo_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periodic_level`
--
ALTER TABLE `periodic_level`
  MODIFY `periodic_level_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_or_on_duty`
--
ALTER TABLE `permission_or_on_duty`
  MODIFY `permission_on_duty_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_checklist`
--
ALTER TABLE `pm_checklist`
  MODIFY `pm_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  MODIFY `pm_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project_creation`
--
ALTER TABLE `project_creation`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  MODIFY `promotional_activities_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  MODIFY `promotional_activities_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_creation`
--
ALTER TABLE `report_creation`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  MODIFY `rgp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rr_creation`
--
ALTER TABLE `rr_creation`
  MODIFY `rr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  MODIFY `rr_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_indent`
--
ALTER TABLE `service_indent`
  MODIFY `service_indent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spare_creation`
--
ALTER TABLE `spare_creation`
  MODIFY `spare_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tag_creation`
--
ALTER TABLE `tag_creation`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `target_fixing`
--
ALTER TABLE `target_fixing`
  MODIFY `target_fixing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `target_fixing_ref`
--
ALTER TABLE `target_fixing_ref`
  MODIFY `target_fixing_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todo_creation`
--
ALTER TABLE `todo_creation`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_location`
--
ALTER TABLE `transfer_location`
  MODIFY `transfer_location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  MODIFY `vehicle_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_status`
--
ALTER TABLE `work_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `year_creation`
--
ALTER TABLE `year_creation`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
