-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2024 at 05:45 AM
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
-- Database: `asmotors_empty`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `DeleteTeamMember` (IN `p_team_id` INT, IN `p_user_id` INT)   BEGIN
    DECLARE rows_affected INT;

    DELETE FROM team_members WHERE team_id = p_team_id AND user_id = p_user_id;

    SET rows_affected = ROW_COUNT();

    IF rows_affected > 0 THEN
        SELECT 'Team member deleted successfully.' AS message;
    ELSE
        SELECT 'Team member not found or deletion failed.' AS message;
    END IF;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `DeleteTeamMessage` (IN `p_message_id` INT)   BEGIN
    DECLARE rows_affected INT;

    DELETE FROM team_messages WHERE message_id = p_message_id;

    SET rows_affected = ROW_COUNT();

    IF rows_affected > 0 THEN
        SELECT 'Team message deleted successfully.' AS message;
    ELSE
        SELECT 'Team message not found or deletion failed.' AS message;
    END IF;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetAssignWorkRefList` (IN `designation_id` INT)   BEGIN
    SELECT *
    FROM assign_work_ref
    WHERE status = 0
      AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date))
           OR work_status IN (0, 1, 2))
      AND designation_id = designation_id
    ORDER BY priority DESC;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetAuditAreaData` (IN `designation` VARCHAR(255))   BEGIN
    SELECT audit_area_creation_ref.audit_area_creation_ref_id,
           audit_area_creation_ref.audit_area_id,
           audit_area_creation_ref.from_date,
           audit_area_creation_ref.to_date,
           audit_area_creation_ref.work_status,
           audit_area_creation.audit_area
    FROM audit_area_creation_ref
    LEFT JOIN audit_area_creation ON audit_area_creation_ref.audit_area_id = audit_area_creation.audit_area_id
    WHERE audit_area_creation.status = 0
      AND audit_area_creation.frequency != 'Daily Task'
      AND ((audit_area_creation_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(audit_area_creation_ref.from_date) AND MONTH(audit_area_creation_ref.to_date))
           OR audit_area_creation_ref.work_status IN (0, 1, 2))
      AND audit_area_creation.calendar = 'Yes'
      AND (audit_area_creation.role1 = designation OR audit_area_creation.role2 = designation);
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetBMChecklistData` (IN `designation` VARCHAR(255))   BEGIN
    SELECT bcr.bm_checklist_ref_id,
           bcr.maintenance_checklist_id,
           bcr.bm_checklist_id,
           bcr.checklist,
           bcr.from_date,
           bcr.to_date,
           bcr.work_status
    FROM bm_checklist_ref bcr
    LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id
    LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id
    LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id
    WHERE mc.status = 0
      AND bc.frequency != 'Daily Task'
      AND ((bcr.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(bcr.from_date) AND MONTH(bcr.to_date))
           OR bcr.work_status IN (0, 1, 2))
      AND mc.calendar = 'Yes'
      AND (mc.role1 = designation OR mc.role2 = designation);
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetCampaignData` (IN `staff_id` VARCHAR(255))   BEGIN
    SELECT campaign_ref.campaign_ref_id,
           campaign_ref.campaign_id,
           campaign_ref.promotional_activities_ref_id,
           campaign_ref.activity_involved,
           campaign_ref.start_date,
           campaign_ref.end_date,
           campaign_ref.work_status
    FROM campaign_ref
    LEFT JOIN campaign ON campaign_ref.campaign_id = campaign.campaign_id
    WHERE campaign.status = 0
      AND ((campaign_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(campaign_ref.start_date) AND MONTH(campaign_ref.end_date))
           OR campaign_ref.work_status IN (0, 1, 2))
      AND FIND_IN_SET(staff_id, employee_name) > 0;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetDailyPerformanceData` (IN `p_date` VARCHAR(100), IN `p_staff_id` INT)   BEGIN
    DECLARE data_exists INT;
    DECLARE dp_count INT;
    DECLARE gs_count INT;


SELECT 1 INTO data_exists
    FROM daily_performance_ref
    WHERE system_date = p_date AND staff_id = p_staff_id
    LIMIT 1;


SELECT COUNT(*) INTO dp_count
    FROM daily_performance_ref
    WHERE system_date = p_date AND staff_id = p_staff_id;


SELECT COUNT(*) INTO gs_count
    FROM goal_setting_ref
    WHERE goal_month = p_date AND FIND_IN_SET(p_staff_id, staffname) > 0;




IF data_exists IS NOT NULL THEN

IF dp_count <> gs_count THEN

SELECT
                dpr.goal_setting_ref_id,
                dpr.goal_setting_id,
                dpr.daily_performance_ref_id,
                dpr.assertion,
                dpr.target,
                dpr.actual_achieve,
                dpr.status,
                dpr.system_date,
                dpr.manager_updated_status
            FROM
                daily_performance_ref dpr
            WHERE
                dpr.system_date = p_date
                AND dpr.staff_id = p_staff_id
            UNION
            SELECT DISTINCT
                gpr.goal_setting_ref_id,
                gpr.goal_setting_id,
                0 as daily_performance_ref_id,
                gpr.assertion,
                Cast( gpr.target / (LENGTH(gpr.staffname) - LENGTH(REPLACE(gpr.staffname, ',', '')) + 1) -(SELECT
                COALESCE(SUM(actual_achieve), 0)
                FROM
                daily_performance_ref dpr
                WHERE staff_id=p_staff_id
                AND dpr.goal_setting_id=gpr.goal_setting_id )as SIGNED) as target,
                0 as actual_achieve,
                gpr.status,
                gpr.goal_month as system_date,
                0 as manager_updated_status
            FROM
                goal_setting_ref gpr
            LEFT JOIN
                daily_performance_ref dpr ON gpr.goal_setting_ref_id = dpr.goal_setting_ref_id
            WHERE
                FIND_IN_SET(p_staff_id, gpr.staffname) > 0
                AND ((gpr.entry_date_type = '0' AND gpr.goal_month = p_date)
    	        OR (gpr.entry_date_type = '1' AND gpr.goal_month = DATE_SUB(p_date, INTERVAL 1 DAY)))

                AND dpr.goal_setting_ref_id IS NULL;
        ELSE

SELECT
                dpr.*
            FROM
                daily_performance_ref dpr
            JOIN
                daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id
            JOIN
                goal_setting_ref gpr ON dpr.goal_setting_ref_id = gpr.goal_setting_ref_id
            JOIN
                goal_setting gs ON dpr.goal_setting_id = gs.goal_setting_id
            WHERE
                dpr.system_date = p_date
                AND dpr.staff_id = p_staff_id;
        END IF;
    ELSE

SELECT DISTINCT
            gpr.goal_setting_ref_id,
            gpr.goal_setting_id,
            0 as daily_performance_ref_id,
            gpr.assertion,
           Cast( gpr.target / (LENGTH(gpr.staffname) - LENGTH(REPLACE(gpr.staffname, ',', '')) + 1) -(SELECT
            COALESCE(SUM(actual_achieve), 0)
            FROM
            daily_performance_ref dpr
            WHERE staff_id=p_staff_id
            AND dpr.goal_setting_id=gpr.goal_setting_id )as SIGNED) as target,
            0 as actual_achieve,
            gpr.status,
            0 as manager_updated_status,
            gpr.goal_month as system_date
        FROM
            goal_setting_ref gpr
        WHERE
             FIND_IN_SET(p_staff_id,gpr.staffname) > 0
            AND ((gpr.entry_date_type = '0' AND gpr.goal_month = p_date)
    	    OR (gpr.entry_date_type = '1' AND gpr.goal_month = DATE_SUB(p_date, INTERVAL 1 DAY)));

    END IF;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetFCMToken` (IN `senderid` VARCHAR(50), IN `receiverid` VARCHAR(50))   BEGIN
    Declare d_sender_fcm VARCHAR(255);
    Declare d_receiver_fcm VARCHAR(255);


    Select FCM_Token into d_sender_fcm
    from user
    Where staff_id=senderid
    limit 1;


    Select FCM_Token into d_receiver_fcm
    from user
    Where staff_id=receiverid
    limit 1;

    Select d_sender_fcm as senderfcm , d_receiver_fcm as recieverfcm;

END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetInsuranceData` (IN `designation` VARCHAR(255))   BEGIN
    SELECT insurance_register_ref.ins_reg_ref_id,
           insurance_register_ref.ins_reg_id,
           insurance_register.insurance_id,
           insurance_register_ref.from_date,
           insurance_register_ref.to_date,
           insurance_register_ref.work_status
    FROM insurance_register_ref
    LEFT JOIN insurance_register ON insurance_register_ref.ins_reg_id = insurance_register.ins_reg_id
    WHERE insurance_register.status = 0
      AND ((insurance_register_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(insurance_register_ref.from_date) AND MONTH(insurance_register_ref.to_date))
           OR insurance_register_ref.work_status IN (0, 1, 2))
      AND insurance_register_ref.to_date >= CURDATE()
      AND insurance_register_ref.to_date <= CURDATE() + INTERVAL 30 DAY
      AND insurance_register.designation_id = designation;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetInsuranceRenewData` (IN `staff_id` VARCHAR(255))   BEGIN
    SELECT *
    FROM fc_insurance_renew
    WHERE status = 0
      AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date))
           OR work_status IN (0, 1, 2))
      AND FIND_IN_SET(staff_id, assign_staff_name) > 0;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetKRAData` (IN `p_designation_id` VARCHAR(255), IN `p_staff_id` INT)   BEGIN
    SELECT
        krakpi_calendar_map.krakpi_calendar_map_id as workid,
        CASE (SELECT rr FROM rr_creation_ref WHERE status = 0 AND rr_ref_id = krakpi_creation_ref.rr limit 1)
            WHEN 'New' THEN krakpi_calendar_map.kra_category
            ELSE (SELECT rr FROM rr_creation_ref WHERE status = 0 AND rr_ref_id = krakpi_creation_ref.rr limit 1)
        END AS worktitle,
        krakpi_calendar_map.from_date AS fromdate,
        krakpi_calendar_map.to_date AS todate,
        krakpi_calendar_map.work_status AS workstatus,
        'krakpi_ref' as tableidentifier

        FROM
        krakpi_calendar_map
        LEFT JOIN krakpi_creation ON krakpi_calendar_map.krakpi_id = krakpi_creation.krakpi_id
        LEFT JOIN krakpi_creation_ref ON krakpi_calendar_map.krakpi_ref_id = krakpi_creation_ref.krakpi_ref_id


        WHERE
        krakpi_creation.status = 0
        AND krakpi_creation_ref.frequency != 'Daily Task'
        AND krakpi_creation.designation = p_designation_id
        AND krakpi_calendar_map.calendar = 'Yes'
        AND (
            (krakpi_calendar_map.work_status = 3 AND MONTH(CURRENT_DATE()) BETWEEN MONTH(krakpi_calendar_map.from_date) AND MONTH(krakpi_calendar_map.to_date))
            OR krakpi_calendar_map.work_status IN (0, 1, 2)
        )

    UNION

        SELECT todo_id as workid,work_des as worktitle,from_date as fromdate,to_date as todate,work_status as workstatus,
        'todo_creation' as tableidentifier
        FROM todo_creation
        WHERE status = 0
            AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date))
           OR work_status IN (0, 1, 2))
            AND FIND_IN_SET(p_staff_id, assign_to) > 0


    UNION

        SELECT ref_id as workid,work_des_text as worktitle,from_date as fromdate,to_date as todate,work_status as workstatus,

        'assign_work_ref' as tableidentifier
        FROM assign_work_ref
        WHERE status = 0
        AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date))
           OR work_status IN (0, 1, 2))
        AND designation_id = p_designation_id

    UNION

        SELECT audit_area_creation_ref.audit_area_creation_ref_id as workid,
            audit_area_creation.audit_area as worktitle,
           audit_area_creation_ref.from_date as fromdate,
           audit_area_creation_ref.to_date as todate,
           audit_area_creation_ref.work_status as workstatus,
        'audit_area_creation_ref' as tableidentifier

        FROM audit_area_creation_ref
         LEFT JOIN audit_area_creation ON audit_area_creation_ref.audit_area_id = audit_area_creation.audit_area_id
        WHERE audit_area_creation.status = 0
      AND audit_area_creation.frequency != 'Daily Task'
      AND ((audit_area_creation_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(audit_area_creation_ref.from_date) AND MONTH(audit_area_creation_ref.to_date))
           OR audit_area_creation_ref.work_status IN (0, 1, 2))
      AND audit_area_creation.calendar = 'Yes'
      AND (audit_area_creation.role1 = p_designation_id OR audit_area_creation.role2 = p_designation_id)

    UNION

      SELECT pm_checklist_ref.pm_checklist_ref_id as workid,
            pm_checklist_ref.checklist as worktitle,
           pm_checklist_ref.from_date as fromdate,
           pm_checklist_ref.to_date as todate,
           pm_checklist_ref.work_status as workstatus,
        'pm_checklist_ref' as tableidentifier
        FROM pm_checklist_ref
        LEFT JOIN maintenance_checklist ON pm_checklist_ref.maintenance_checklist_id = maintenance_checklist.maintenance_checklist_id
        LEFT JOIN pm_checklist_multiple ON pm_checklist_ref.pm_checklist_id = pm_checklist_multiple.id
        LEFT JOIN pm_checklist ON pm_checklist_multiple.pm_checklist_id = pm_checklist.pm_checklist_id
        WHERE maintenance_checklist.status = 0
      AND pm_checklist.frequency != 'Daily Task'
      AND ((pm_checklist_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(pm_checklist_ref.from_date) AND MONTH(pm_checklist_ref.to_date))
           OR pm_checklist_ref.work_status IN (0, 1, 2))
      AND maintenance_checklist.calendar = 'Yes'
      AND (maintenance_checklist.role1 = p_designation_id OR maintenance_checklist.role2 = p_designation_id)

      UNION

      SELECT bcr.bm_checklist_ref_id as workid,
           bcr.checklist as worktitle,
           bcr.from_date as fromdate,
           bcr.to_date as todate,
           bcr.work_status as workstatus,
        'bm_checklist_ref' as tableidentifier
    FROM bm_checklist_ref bcr
    LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id
    LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id
    LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id
    WHERE mc.status = 0
      AND bc.frequency != 'Daily Task'
      AND ((bcr.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(bcr.from_date) AND MONTH(bcr.to_date))
           OR bcr.work_status IN (0, 1, 2))
      AND mc.calendar = 'Yes'
      AND (mc.role1 = p_designation_id OR mc.role2 = p_designation_id)

      Union
      SELECT campaign_ref.campaign_ref_id as workid,
           campaign_ref.activity_involved as worktitle,
           campaign_ref.start_date as fromdate,
           campaign_ref.end_date as todate,
           campaign_ref.work_status as workstatus,
        'campaign_ref' as tableidentifier
    FROM campaign_ref
    LEFT JOIN campaign ON campaign_ref.campaign_id = campaign.campaign_id
    WHERE campaign.status = 0
      AND ((campaign_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(campaign_ref.start_date) AND MONTH(campaign_ref.end_date))
           OR campaign_ref.work_status IN (0, 1, 2))
      AND FIND_IN_SET(p_staff_id, employee_name) > 0

      UNION
      SELECT insurance_register_ref.ins_reg_ref_id as workid,
           insurance_register.insurance_id as worktitle,
           insurance_register_ref.from_date as fromdate,
           insurance_register_ref.to_date as todate,
           insurance_register_ref.work_status as workstatus,
        'insurance_register_ref' as tableidentifier
    FROM insurance_register_ref
    LEFT JOIN insurance_register ON insurance_register_ref.ins_reg_id = insurance_register.ins_reg_id
    WHERE insurance_register.status = 0
      AND ((insurance_register_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(insurance_register_ref.from_date) AND MONTH(insurance_register_ref.to_date))
           OR insurance_register_ref.work_status IN (0, 1, 2))
      AND insurance_register_ref.to_date >= CURDATE()
      AND insurance_register_ref.to_date <= CURDATE() + INTERVAL 30 DAY
      AND insurance_register.designation_id = p_designation_id

      UNION
      SELECT fc_insurance_renew_id as workid,assign_remark as worktitle,from_date as fromdate,to_date as todate,work_status as workstatus,
        'fc_insurance_renew' as tableidentifier
    FROM fc_insurance_renew
    WHERE status = 0
      AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date))
           OR work_status IN (0, 1, 2))
      AND FIND_IN_SET(p_staff_id, assign_staff_name) > 0;


END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetManagerCounts` (IN `userId` INT)   BEGIN

SELECT
        COUNT(*) AS count, COALESCE(D.reason, '') AS reason
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId AND D.reason = 'on duty'
    GROUP BY D.reason

    UNION ALL


SELECT
        COUNT(*), D.reason
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId AND D.reason = 'Permission'
    GROUP BY D.reason

    UNION ALL


SELECT
        COUNT(*), D.reason
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId AND D.reason = 'Leave'
    GROUP BY D.reason;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetManagerCounts_V1` (IN `userId` INT)   BEGIN

SELECT
        COUNT(*) AS count, COALESCE(D.reason, '') AS reason
    FROM permission_or_on_duty D

WHERE D.reporting = userId AND D.reason = 'On Duty'
    and leave_status=0
    GROUP BY D.reason

    UNION ALL


SELECT
        COUNT(*), D.reason
    FROM permission_or_on_duty D

WHERE d.reporting = userId AND D.reason = 'Permission' and
    leave_status=0
    GROUP BY D.reason

    UNION ALL


SELECT
        COUNT(*), D.reason
    FROM permission_or_on_duty D

WHERE D.reporting = userId AND D.reason = 'Leave' and
    leave_status=0
    GROUP BY D.reason;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetPMChecklistData` (IN `designation` VARCHAR(255))   BEGIN
    SELECT pm_checklist_ref.pm_checklist_ref_id,
           pm_checklist_ref.maintenance_checklist_id,
           pm_checklist_ref.pm_checklist_id,
           pm_checklist_ref.checklist,
           pm_checklist_ref.from_date,
           pm_checklist_ref.to_date,
           pm_checklist_ref.work_status
    FROM pm_checklist_ref
    LEFT JOIN maintenance_checklist ON pm_checklist_ref.maintenance_checklist_id = maintenance_checklist.maintenance_checklist_id
    LEFT JOIN pm_checklist_multiple ON pm_checklist_ref.pm_checklist_id = pm_checklist_multiple.id
    LEFT JOIN pm_checklist ON pm_checklist_multiple.pm_checklist_id = pm_checklist.pm_checklist_id
    WHERE maintenance_checklist.status = 0
      AND pm_checklist.frequency != 'Daily Task'
      AND ((pm_checklist_ref.work_status = 3
            AND MONTH(CURDATE()) BETWEEN MONTH(pm_checklist_ref.from_date) AND MONTH(pm_checklist_ref.to_date))
           OR pm_checklist_ref.work_status IN (0, 1, 2))
      AND maintenance_checklist.calendar = 'Yes'
      AND (maintenance_checklist.role1 = designation OR maintenance_checklist.role2 = designation);
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetTeamMembersByTeamId` (IN `p_team_id` INT)   BEGIN
    SELECT u.*, tm.team_id, t.team_name
    FROM user u
    INNER JOIN team_members tm ON u.user_id = tm.user_id
    INNER JOIN teams t ON tm.team_id = t.team_id
    WHERE tm.team_id = p_team_id;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetTeamMessagesByUserId` (IN `p_user_id` INT, IN `p_team_id` INT)   BEGIN
    IF EXISTS (SELECT * FROM team_members WHERE user_id = p_user_id AND team_id = p_team_id) THEN
        SELECT t.*,u.fullname
        FROM team_messages t
        inner join user u on t.user_id=u.user_id
        WHERE team_id = p_team_id and t.content!=''
        ORDER BY timestamp;
    END IF;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetTeamsByUserId` (IN `p_user_id` INT)   BEGIN
    SELECT t.*
    FROM teams t
    INNER JOIN team_members tm ON t.team_id = tm.team_id
    WHERE tm.user_id = p_user_id;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetTodoList` (IN `p_staff_id` INT)   BEGIN
    SELECT *
    FROM todo_creation
    WHERE status = 0
      AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date))
           OR work_status IN (0, 1, 2))
      AND FIND_IN_SET(p_staff_id, assign_to) > 0
    ORDER BY priority DESC;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetUserLoginDetails` (IN `userName` VARCHAR(50), IN `userPassword` VARCHAR(50), IN `FcmToken` VARCHAR(255))   BEGIN

Update user set FCM_Token=FcmToken where user_name=userName;


IF userName = 'support@feathertechnology.in' THEN
        SELECT * FROM user WHERE user_name = userName AND user_password = userPassword;
    ELSE
        SELECT
            U.user_id, U.firstname, U.lastname, U.fullname,U.role,
            S.company_id, D.department_id, S.staff_name, S.staff_id, S.emp_code AS staffcode, S.reporting,
            B.branch_name,B.branch_id, D.department_name,S.designation,
            (SELECT designation_name from designation_creation where designation_id=S.designation limit 1) as designation_name,
            (SELECT staff_name FROM staff_creation WHERE staff_id = (SELECT reporting FROM staff_creation WHERE staff_id = u.staff_id LIMIT 1) LIMIT 1) AS managername
        FROM user U
        INNER JOIN staff_creation S ON S.staff_id = U.staff_id
        INNER JOIN branch_creation B ON U.branch_id = B.branch_id
        INNER JOIN department_creation D ON D.department_id = S.Department
        WHERE U.user_name = userName AND U.user_password = userPassword;
    END IF;


END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetUserPermissionDetails` (IN `userId` INT)   BEGIN

SELECT
        u.user_id, u.firstname, u.lastname, u.fullname,
        D.company_id, D.department_id, D.staff_id, D.staff_code, D.reporting,
        d.reason, d.permission_on_duty_id, d.permission_from_time, d.permission_to_time,
        d.permission_date, d.on_duty_place, d.leave_date, d.leave_reason, d.status,
        d.leave_status, d.reject_reason, d.responsible_staff, d.insert_login_id,
        D.update_login_id, D.delete_login_id, D.created_date, d.updated_date
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId;


SELECT
        COUNT(*) AS count, COALESCE(D.reason, '') AS reason
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId AND D.reason = 'on duty'
    GROUP BY D.reason

    UNION ALL


SELECT
        COUNT(*), D.reason
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId AND D.reason = 'Permission'
    GROUP BY D.reason

    UNION ALL


SELECT
        COUNT(*), D.reason
    FROM permission_or_on_duty D
    INNER JOIN user u ON u.user_id = D.reporting
    WHERE u.user_id = userId AND D.reason = 'Leave'
    GROUP BY D.reason;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `GetUserPermissionDetails_V1` (IN `userId` INT)   BEGIN

SELECT
        u.user_id, u.firstname, u.lastname, (select fullname from user where user_id=D.insert_login_id limit 1) fullname,
        D.company_id, D.department_id, D.staff_id, D.staff_code, D.reporting,
        d.reason, d.permission_on_duty_id, d.permission_from_time, d.permission_to_time,
        d.permission_date, d.on_duty_place, d.leave_date, d.leave_reason, d.status,
        d.leave_status, d.reject_reason, d.responsible_staff, d.insert_login_id,
        D.update_login_id, D.delete_login_id, D.created_date, d.updated_date
    FROM permission_or_on_duty D
    INNER JOIN staff_creation S ON S.staff_id = D.staff_id
    Inner Join user u on u.staff_id=S.staff_id
    WHERE u.user_id = userId and leave_status=0
    order by created_date desc;



END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `Get_MessageConvoCount` (IN `p_receiverid` VARCHAR(500))   BEGIN

CREATE TEMPORARY TABLE IF NOT EXISTS TempLatestTimestamps AS
    SELECT
        SenderId,
        ReceiverId,
        MAX(ConvClosedTimestamp) AS lastTimestamp
    FROM messages
    WHERE Senderid = p_receiverid
    GROUP BY SenderId, ReceiverId;


CREATE TEMPORARY TABLE IF NOT EXISTS TempReceivedLatestTimestamps AS
    SELECT
    M.SenderId,
    M.ReceiverId,
    COUNT(*) AS unreadcount,
    MAX(CASE WHEN Timestamp = (SELECT MAX(Timestamp) FROM messages WHERE SenderId = M.SenderId AND ReceiverId = M.ReceiverId) THEN SenderMessage END) AS lastmessage
    FROM messages M
    LEFT JOIN TempLatestTimestamps LT ON LT.SenderId = M.ReceiverId AND LT.ReceiverId = M.SenderId
    WHERE M.ReceiverId = p_receiverid
    AND LT.SenderId IS NULL
GROUP BY M.SenderId, M.ReceiverId;


SELECT
        LT.SenderId,
        LT.ReceiverId,
        COUNT(*) AS unreadcount,
        MAX(CASE WHEN Timestamp = (SELECT MAX(Timestamp) FROM messages WHERE SenderId = M.SenderId AND ReceiverId = M.ReceiverId) THEN SenderMessage END) AS lastmessage
    FROM TempLatestTimestamps LT
    JOIN messages M ON LT.SenderId = M.ReceiverId
                    AND LT.ReceiverId = M.SenderId
                    AND M.Timestamp > LT.lastTimestamp
    GROUP BY LT.SenderId, LT.ReceiverId

     UNION

    SELECT
        RL.SenderId,
        RL.ReceiverId,
        RL.unreadcount,
        RL.lastmessage
    FROM TempReceivedLatestTimestamps RL;


DROP TEMPORARY TABLE IF EXISTS TempLatestTimestamps;
    DROP TEMPORARY TABLE IF EXISTS TempReceivedLatestTimestamps;

END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `Get_Team_MessageConvoCount` (IN `p_user_id` VARCHAR(500))   BEGIN

    Create TEMPORARY TABLE IF NOT EXISTS TeamsTempTable AS
    SELECT t.*,tm.user_id
    FROM teams t
    INNER JOIN team_members tm ON t.team_id = tm.team_id
    WHERE tm.user_id = p_user_id;


CREATE TEMPORARY TABLE IF NOT EXISTS TempLatestTimestamps AS
    SELECT
        team_id,
        user_id,
        MAX(ConvClosedTimestamp) AS lastTimestamp
    FROM team_messages
    WHERE user_id = p_user_id
    GROUP BY team_id;



SELECT
        LT.team_id,
        COUNT(*) AS unreadcount,
        MAX(CASE WHEN Timestamp = (SELECT MAX(Timestamp) FROM team_messages WHERE  team_id = M.team_id) THEN content END) AS lastmessage
    FROM TempLatestTimestamps LT
    JOIN team_messages M ON  LT.team_id = M.team_id
                    AND M.Timestamp > LT.lastTimestamp and M.content!=''
    GROUP BY LT.team_id ;


DROP TEMPORARY TABLE IF EXISTS TeamsTempTable;
    DROP TEMPORARY TABLE IF EXISTS TempLatestTimestamps;
    DROP TEMPORARY TABLE IF EXISTS TempReceivedLatestTimestamps;

END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `InsertPermissionOrOnDuty` (IN `company_id` INT, IN `department_id` INT, IN `p_staff_id` INT, IN `staff_code` VARCHAR(255), IN `reporting` VARCHAR(255), IN `reason` VARCHAR(255), IN `permission_from_time` VARCHAR(255), IN `permission_to_time` VARCHAR(255), IN `permission_date` VARCHAR(255), IN `on_duty_place` VARCHAR(255), IN `leave_date` VARCHAR(255), IN `leave_todate` VARCHAR(255), IN `leave_reason` VARCHAR(255), IN `insert_login_id` INT, IN `responsible_staff` VARCHAR(255))   BEGIN

    DECLARE d_staff_name VARCHAR(255);
    DECLARE d_manager_name VARCHAR(255);
    DECLARE new_regularisation_id VARCHAR(255);
    Declare d_fcm_token VARCHAR(255);
    Declare d_responsible_staff_id INT;




    SELECT CONCAT('R-', COALESCE(MAX(CAST(SUBSTRING(regularisation_id, 3) AS SIGNED)), 0) + 1) INTO new_regularisation_id
FROM permission_or_on_duty;




SELECT staff_name INTO d_staff_name
    FROM staff_creation
    WHERE staff_id = p_staff_id
    Limit 1;

    SELECT staff_name INTO d_manager_name
    FROM staff_creation
    WHERE staff_id = reporting
    Limit 1;

    Select FCM_Token into d_fcm_token
    from user
    Where staff_id=reporting
    limit 1;

    Select staff_id into d_responsible_staff_id
    from staff_creation where staff_name=responsible_staff
    limit 1;





INSERT INTO permission_or_on_duty (
        regularisation_id,
        company_id,
        department_id,
        staff_id,
        staff_code,
        reporting,
        reason,
        permission_from_time,
        permission_to_time,
        permission_date,
        on_duty_place,
        leave_date,
        leave_to_date,
        leave_reason,
        staff_name,
        manager_name,
        insert_login_id,
        responsible_staff_name,
        responsible_staff
    )
    VALUES (
        new_regularisation_id,
        company_id,
        department_id,
        p_staff_id,
        staff_code,
        reporting,
        reason,
        permission_from_time,
        permission_to_time,
        permission_date,
        on_duty_place,
        leave_date,
        leave_todate,
        leave_reason,
        d_staff_name,
        d_manager_name,
        insert_login_id,responsible_staff,d_responsible_staff_id
    );

    Select d_staff_name as staff_name,d_manager_name as manager_name,new_regularisation_id as requestid,d_fcm_token as fcmtoken;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `InsertTeamAndMembers` (IN `p_team_name` VARCHAR(255), IN `p_user_id` INT)   BEGIN
    DECLARE teamIdExists INT;
    Declare userIdExists INT;


SELECT team_id INTO teamIdExists FROM teams WHERE team_name = p_team_name LIMIT 1;

    IF teamIdExists IS NULL THEN

INSERT INTO teams (team_name) VALUES (p_team_name);

SET @team_id := LAST_INSERT_ID();
    ELSE

SET @team_id := teamIdExists;
    END IF;

Select user_id into userIdExists from team_members where team_id=@team_id and user_id =p_user_id limit 1;
    If userIdExists is Null THEN

    INSERT INTO team_members (team_id, user_id)
     VALUES (@team_id, p_user_id);
    End If;

    Insert into team_messages(team_id,user_id,content)
    values (@team_id,p_user_id,'');
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `InsertTeamMembersMultiple` (IN `p_team_name` VARCHAR(255), IN `p_user_ids` VARCHAR(255))   BEGIN
    DECLARE teamIdExists INT;
    DECLARE userIdExists INT;
    DECLARE currentUserID INT;
    DECLARE usersInserted INT DEFAULT 0;

    SELECT team_id INTO teamIdExists FROM teams WHERE team_name = p_team_name LIMIT 1;

    IF teamIdExists IS NULL THEN
        INSERT INTO teams (team_name) VALUES (p_team_name);
        SET @team_id := LAST_INSERT_ID();
    ELSE
        SET @team_id := teamIdExists;
    END IF;


WHILE LENGTH(p_user_ids) > 0 DO
        SET @commaIndex := LOCATE(',', p_user_ids);
        IF @commaIndex > 0 THEN
            SET currentUserID := SUBSTRING(p_user_ids, 1, @commaIndex - 1);
            SET p_user_ids := SUBSTRING(p_user_ids, @commaIndex + 1);
        ELSE
            SET currentUserID := p_user_ids;
            SET p_user_ids := '';
        END IF;


SELECT user_id INTO userIdExists FROM team_members WHERE team_id = @team_id AND user_id = currentUserID LIMIT 1;

        IF userIdExists IS NULL THEN

INSERT INTO team_members (team_id, user_id) VALUES (@team_id, currentUserID);
            SET usersInserted = usersInserted + 1;
        END IF;


INSERT INTO team_messages (team_id, user_id, content) VALUES (@team_id, currentUserID, '');
    END WHILE;

    IF usersInserted > 0 THEN
        SELECT CONCAT(usersInserted, ' user(s) added to the team.') AS message;
    ELSE
        SELECT 'No new users added. Team or users may already exist.' AS message;
    END IF;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `InsertTeamMessage` (IN `p_team_id` INT, IN `p_user_id` INT, IN `p_content` TEXT)   BEGIN
    INSERT INTO team_messages (team_id, user_id, content)
    VALUES (p_team_id, p_user_id, p_content);
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `SP_GetUserNotifications_V1` (IN `staffid` INT)   BEGIN


CREATE TEMPORARY TABLE IF NOT EXISTS temp_table1 AS
    SELECT
        S.user_id, S.staff_name,
        D.company_id, D.department_id, D.staff_id, D.staff_code, D.reporting,
        D.reason, D.permission_on_duty_id, D.leave_date, D.leave_reason, D.status,
        D.leave_status, D.reject_reason, D.responsible_staff, D.insert_login_id
    FROM permission_or_on_duty D
    INNER JOIN staff_creation S ON S.staff_id = D.staff_id
    WHERE D.staff_id != '' AND
    CONVERT(D.staff_id, SIGNED INTEGER) = staffid
    ORDER BY D.created_date DESC;

    CREATE TEMPORARY TABLE IF NOT EXISTS temp_table2 AS
    SELECT
        S.user_id, S.staff_name,
        D.company_id, D.department_id, D.staff_id, D.staff_code, D.reporting,
        D.reason, D.permission_on_duty_id, D.leave_date, D.leave_reason, D.status,
        D.leave_status, D.reject_reason, D.responsible_staff, D.insert_login_id
    FROM permission_or_on_duty D
    INNER JOIN staff_creation S ON S.staff_id = D.reporting
    WHERE D.reporting != '' AND
    CONVERT(D.reporting, SIGNED INTEGER) = staffid

    ORDER BY D.created_date DESC;


SELECT * FROM temp_table1;
    SELECT * FROM temp_table2;


DROP TEMPORARY TABLE IF EXISTS temp_table1;
    DROP TEMPORARY TABLE IF EXISTS temp_table2;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `Sp_Put_UpdateWorkStatus` (IN `p_description` VARCHAR(500), IN `p_status` VARCHAR(50), IN `p_workid` VARCHAR(50), IN `p_work_title` VARCHAR(50), IN `p_file_name` VARCHAR(500), IN `p_table_identifier` VARCHAR(255))   BEGIN
    DECLARE result VARCHAR(50);

    IF p_table_identifier = 'krakpi_ref' THEN
        UPDATE krakpi_calendar_map SET work_status = p_status WHERE krakpi_calendar_map_id = p_workid;
    ELSEIF p_table_identifier = 'todo_creation' THEN
        UPDATE todo_creation SET work_status = p_status WHERE todo_id = p_workid;
    ELSEIF p_table_identifier = 'assign_work_ref' THEN
        UPDATE assign_work_ref SET work_status = p_status WHERE ref_id = p_workid;
    ELSEIF p_table_identifier = 'audit_area_creation_ref' THEN
        UPDATE audit_area_creation_ref SET work_status = p_status WHERE audit_area_creation_ref_id = p_workid;
    ELSEIF p_table_identifier = 'pm_checklist_ref' THEN
        UPDATE pm_checklist_ref SET work_status = p_status WHERE pm_checklist_ref_id = p_workid;
    ELSEIF p_table_identifier = 'bm_checklist_ref' THEN
        UPDATE bm_checklist_ref SET work_status = p_status WHERE bm_checklist_ref_id = p_workid;
    ELSEIF p_table_identifier = 'campaign_ref' THEN
        UPDATE campaign_ref SET work_status = p_status WHERE campaign_ref_id = p_workid;
    ELSEIF p_table_identifier = 'insurance_register_ref' THEN
        UPDATE insurance_register_ref SET work_status = p_status WHERE ins_reg_ref_id = p_workid;
    ELSEIF p_table_identifier = 'fc_insurance_renew' THEN
        UPDATE fc_insurance_renew SET work_status = p_status WHERE fc_insurance_renew_id = p_workid;
    END IF;

    IF ROW_COUNT() > 0 THEN
        INSERT INTO work_status (work_id, work_status, work_des, remarks, completed_file)
        VALUES (CONCAT(p_table_identifier, ' ', p_workid), p_status, p_work_title, p_description, p_file_name);
        SET result = 'Inserted Work Status';
    ELSE
        SET result = 'No Record Found';
    END IF;

    SELECT result AS result;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `UpdateLasteSeenTime` (IN `p_receiverid` VARCHAR(50), IN `p_senderid` VARCHAR(50))   BEGIN
    Update messages set ConvClosedTimestamp=NOW() where SenderId=p_senderid and ReceiverId=p_receiverid;

END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `UpdatePerformaceData` (IN `p_daily_performance_ref_id` INT, IN `p_achieved` INT, IN `p_work_status` INT, IN `p_staffid` INT, IN `p_goal_setting_id` INT, IN `p_goal_setting_refid` INT, IN `p_date` VARCHAR(255))   BEGIN
    DECLARE status VARCHAR(255);
    Declare success_status VARCHAR(255);

    Declare d_targetremaining INT;
    Declare d_targetachieved INT;

    SELECT
    COALESCE(SUM(actual_achieve), 0) into d_targetachieved
    FROM
    daily_performance_ref
    WHERE staff_id=p_staffid
    AND goal_setting_id= p_goal_setting_id;

SELECT
        CAST((gpr.target / (LENGTH(gpr.staffname) - LENGTH(REPLACE(gpr.staffname, ',', '')) + 1)) - d_targetachieved AS SIGNED) into d_targetremaining
        FROM
        goal_setting_ref gpr
        WHERE
        gpr.goal_setting_ref_id=p_goal_setting_refid AND
        gpr.goal_month = p_date
        AND FIND_IN_SET(p_staffid, gpr.staffname) > 0;

IF EXISTS (SELECT * FROM daily_performance_ref WHERE daily_performance_ref_id = p_daily_performance_ref_id) THEN
        UPDATE daily_performance_ref
        SET
            status = p_work_status,
            actual_achieve = p_achieved
        WHERE daily_performance_ref_id = p_daily_performance_ref_id;
        SET success_status = 'Updated Successfully';
    ELSE
        INSERT INTO daily_performance (company_id, branch_id, department_id, role_id, emp_id, month, insert_login_id, status)
        SELECT company_name, branch_id, department, role, p_staffid,DATE_FORMAT(CURDATE(), '%Y-%m-01') , insert_login_id, p_work_status
        FROM goal_setting
        WHERE goal_setting_id = p_goal_setting_id
        LIMIT 1;

        SET @daily_performance_id := LAST_INSERT_ID();

        INSERT INTO daily_performance_ref (
            daily_performance_id,
            assertion,
            target,
            actual_achieve,
            system_date,
            staff_id,
            goal_setting_id,
            goal_setting_ref_id,
            assertion_table_sno,
            status
        )
        SELECT
            @daily_performance_id,
            assertion,
            d_targetremaining,
            p_achieved,
            goal_month,
            p_staffid,
            goal_setting_id,
            goal_setting_ref_id,
            assertion_table_sno,
            p_work_status
        FROM goal_setting_ref
         WHERE
            goal_setting_ref_id=p_goal_setting_refid ;

        SET success_status = 'Inserted Successfullly';
    END IF;
    SELECT success_status AS status;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `UpdatePermissionOnDuty` (IN `Id` VARCHAR(255), IN `LeaveStatus` VARCHAR(255), IN `RejectReason` VARCHAR(255), IN `Responsible_staff` VARCHAR(255))   BEGIN
    DECLARE d_responsible_staff_id VARCHAR(255);
    DECLARE d_staff_name VARCHAR(255);
    Declare d_fcm_token VARCHAR(255);
    Declare d_responsible_fcm_token varchar(255);
    Declare d_staff_id VARCHAR(255);


    SELECT staff_name, staff_id
    INTO d_staff_name, d_staff_id
    FROM permission_or_on_duty
    WHERE permission_on_duty_id = Id
    LIMIT 1;


    Select FCM_Token into d_responsible_fcm_token
    from user
    Where staff_id=(Select staff_id from staff_creation where staff_name=Responsible_staff limit 1)
    limit 1;


    Select FCM_Token into d_fcm_token
    from user
    Where staff_id=d_staff_id
    limit 1;

    Select staff_id into d_responsible_staff_id
     from staff_creation where staff_name=Responsible_staff
     limit 1;

    UPDATE permission_or_on_duty
    SET
    leave_status = LeaveStatus,
    reject_reason = RejectReason,
    responsible_staff=d_responsible_staff_id,
    responsible_staff_name = Responsible_staff
    WHERE
    permission_on_duty_id = Id;





    Select d_staff_name as staff_name,Responsible_staff as resp_name,d_responsible_fcm_token as resp_fcmtoken,d_fcm_token as fcmtoken;
END$$

CREATE DEFINER=`a6466e_asmotor`@`%` PROCEDURE `UpdateTeamLasteSeenTime` (IN `p_user_id` VARCHAR(50), IN `p_team_id` VARCHAR(50))   BEGIN
    Update team_messages set ConvClosedTimestamp=NOW() where user_id=p_user_id and team_id=p_team_id;

END$$

DELIMITER ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assertion_creation`
--

CREATE TABLE `assertion_creation` (
  `assertion_id` int(11) NOT NULL,
  `assertion` varchar(255) NOT NULL,
  `branch_id` int(255) NOT NULL,
  `dept_id` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL,
  `updated_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details`
--

CREATE TABLE `asset_details` (
  `asset_details_id` int(11) NOT NULL,
  `asset_register_id` int(11) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `dou` date DEFAULT NULL,
  `depreciation` varchar(255) DEFAULT NULL,
  `as_on` varchar(255) DEFAULT NULL,
  `asset_location` varchar(100) DEFAULT NULL,
  `asset_count` varchar(50) DEFAULT NULL,
  `spare_names` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details_ref`
--

CREATE TABLE `asset_details_ref` (
  `ref_id` int(11) NOT NULL,
  `asset_details_reff_id` int(11) DEFAULT NULL,
  `modal_no` varchar(100) DEFAULT NULL,
  `warranty_upto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_name_creation`
--

CREATE TABLE `asset_name_creation` (
  `asset_name_id` int(11) NOT NULL,
  `asset_name` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_register`
--

CREATE TABLE `asset_register` (
  `asset_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `asset_classification` varchar(250) DEFAULT NULL,
  `asset_autoGen_id` varchar(50) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `vendor_id` varchar(50) DEFAULT NULL,
  `dop` date DEFAULT NULL,
  `asset_nature` int(11) DEFAULT NULL,
  `depreciation_rate` varchar(50) DEFAULT NULL,
  `asset_value` int(11) DEFAULT NULL,
  `maintenance` varchar(255) DEFAULT NULL,
  `rgp_status` varchar(255) NOT NULL DEFAULT 'inword',
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `frequency` varchar(50) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `responsibility` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `frequency` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bm_checklist_multiple`
--

CREATE TABLE `bm_checklist_multiple` (
  `id` int(11) NOT NULL,
  `bm_checklist_id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bm_checklist_ref`
--

CREATE TABLE `bm_checklist_ref` (
  `bm_checklist_ref_id` int(11) NOT NULL,
  `bm_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_ref_id` varchar(200) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `from_date` varchar(50) DEFAULT NULL,
  `to_date` varchar(50) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `role1` varchar(200) DEFAULT NULL,
  `role2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `in_active_remark` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int(11) NOT NULL,
  `promotional_activities_id` varchar(50) DEFAULT NULL,
  `actual_start_date` varchar(255) DEFAULT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `department_id` varchar(50) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `in_active_remark` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `costcentre`
--

CREATE TABLE `costcentre` (
  `costcentreid` int(11) NOT NULL,
  `costcentrename` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `daily_km_id` varchar(255) DEFAULT NULL,
  `employee_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance`
--

CREATE TABLE `daily_performance` (
  `daily_performance_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `month` date DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance_ref`
--

CREATE TABLE `daily_performance_ref` (
  `daily_performance_ref_id` int(11) NOT NULL,
  `daily_performance_id` int(11) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `actual_achieve` varchar(50) DEFAULT NULL,
  `system_date` date DEFAULT NULL,
  `staff_id` varchar(200) DEFAULT NULL,
  `goal_setting_id` int(11) DEFAULT NULL,
  `goal_setting_ref_id` int(11) DEFAULT NULL,
  `assertion_table_sno` varchar(50) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `manager_comment` varchar(250) DEFAULT NULL,
  `manager_updated_status` int(11) DEFAULT 0,
  `manager_id` varchar(50) DEFAULT NULL,
  `manager_updated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `staff_id` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_insurance_renew`
--

CREATE TABLE `fc_insurance_renew` (
  `fc_insurance_renew_id` int(11) NOT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `vehicle_details_id` varchar(50) DEFAULT NULL,
  `assign_staff_name` varchar(50) DEFAULT NULL,
  `assign_remark` varchar(250) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` varchar(50) DEFAULT NULL,
  `insert_login_id` varchar(50) DEFAULT NULL,
  `update_login_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting`
--

CREATE TABLE `goal_setting` (
  `goal_setting_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL,
  `dept_strength` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting_ref`
--

CREATE TABLE `goal_setting_ref` (
  `goal_setting_ref_id` int(11) NOT NULL,
  `goal_setting_id` int(11) DEFAULT NULL,
  `assertion_table_sno` varchar(50) DEFAULT NULL,
  `assertion` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `per_day_target` varchar(150) DEFAULT NULL,
  `goal_month` varchar(50) DEFAULT NULL,
  `monthly_conversion_required` int(11) DEFAULT NULL,
  `entry_date_type` int(11) NOT NULL DEFAULT 0,
  `staffname` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register`
--

CREATE TABLE `insurance_register` (
  `ins_reg_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `policy_company` varchar(250) DEFAULT NULL,
  `policy_number` varchar(250) DEFAULT NULL,
  `policy_upload` varchar(250) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register_ref`
--

CREATE TABLE `insurance_register_ref` (
  `ins_reg_ref_id` int(11) NOT NULL,
  `ins_reg_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `policy_company` varchar(250) DEFAULT NULL,
  `policy_number` varchar(250) DEFAULT NULL,
  `policy_upload` varchar(250) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kra_creation_ref`
--

CREATE TABLE `kra_creation_ref` (
  `kra_creation_ref_id` int(11) NOT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `weightage` varchar(255) DEFAULT NULL,
  `kra_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageId` int(11) NOT NULL,
  `SenderId` int(11) NOT NULL,
  `ReceiverId` int(11) NOT NULL,
  `SenderMessage` text DEFAULT NULL,
  `ReceiverMessage` text DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT current_timestamp(),
  `ConvClosedTimestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_task_notification`
--

CREATE TABLE `pending_task_notification` (
  `notification_id` int(11) NOT NULL,
  `task_name` varchar(50) DEFAULT NULL,
  `task_id` varchar(50) DEFAULT NULL,
  `work_des` varchar(100) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT 0,
  `updated_login_id` int(11) NOT NULL DEFAULT 0,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_or_on_duty`
--

CREATE TABLE `permission_or_on_duty` (
  `permission_on_duty_id` int(11) NOT NULL,
  `regularisation_id` varchar(250) DEFAULT NULL,
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
  `leave_to_date` varchar(150) DEFAULT NULL,
  `leave_reason` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `leave_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=request 1=accepted 2=rejected',
  `reject_reason` varchar(255) DEFAULT NULL,
  `responsible_staff` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `staff_name` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `responsible_staff_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pm_checklist_multiple`
--

CREATE TABLE `pm_checklist_multiple` (
  `id` int(11) NOT NULL,
  `pm_checklist_id` int(11) NOT NULL,
  `checklist` text DEFAULT NULL,
  `type_of_checklist` varchar(255) DEFAULT NULL,
  `yes_no_na` varchar(255) DEFAULT NULL,
  `no_of_option` varchar(255) DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_company_creation`
--

CREATE TABLE `policy_company_creation` (
  `policy_company_id` int(11) NOT NULL,
  `policy_company` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotional_activities_ref`
--

CREATE TABLE `promotional_activities_ref` (
  `promotional_activities_ref_id` int(11) NOT NULL,
  `promotional_activities_id` int(11) DEFAULT NULL,
  `activity_involved` varchar(200) DEFAULT NULL,
  `time_frame_start` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `employee_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responsibility_creation`
--

CREATE TABLE `responsibility_creation` (
  `responsibility_id` int(11) NOT NULL,
  `responsibility_name` varchar(150) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_date` date DEFAULT NULL,
  `updated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `company_to` int(11) DEFAULT NULL,
  `branch_to` varchar(255) DEFAULT NULL,
  `from_comm_line1` varchar(255) DEFAULT NULL,
  `from_comm_line2` varchar(255) DEFAULT NULL,
  `to_comm_line1` varchar(255) DEFAULT NULL,
  `to_comm_line2` varchar(255) DEFAULT NULL,
  `rgp_staff_id` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_creation_history`
--

CREATE TABLE `staff_creation_history` (
  `staff_history_id` int(11) NOT NULL,
  `transfer_location_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `monthly_conversion_required` int(11) DEFAULT NULL,
  `new_assertion` varchar(200) DEFAULT NULL,
  `new_target` varchar(100) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `deleted_date` varchar(100) DEFAULT NULL,
  `deleted_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `team_member_id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_messages`
--

CREATE TABLE `team_messages` (
  `message_id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `ConvClosedTimestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `to_company` varchar(100) DEFAULT NULL,
  `transfer_location` varchar(255) DEFAULT NULL,
  `to_department` varchar(100) DEFAULT NULL,
  `to_designation` varchar(100) DEFAULT NULL,
  `transfer_effective_from` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `daily_task_update` int(11) DEFAULT 1,
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
  `regularisation_approval` int(11) DEFAULT NULL,
  `transfer_location` varchar(11) DEFAULT NULL,
  `target_fixing_module` varchar(11) DEFAULT NULL,
  `goal_setting` varchar(11) DEFAULT NULL,
  `target_fixing` varchar(11) DEFAULT NULL,
  `daily_performance` varchar(11) DEFAULT NULL,
  `daily_performance_review` int(11) NOT NULL DEFAULT 1,
  `appreciation_depreciation` varchar(11) DEFAULT NULL,
  `vehicle_management_module` varchar(11) DEFAULT NULL,
  `vehicle_details` varchar(11) DEFAULT NULL,
  `daily_km` varchar(11) DEFAULT NULL,
  `diesel_slip` varchar(11) DEFAULT NULL,
  `approval_mechanism_module` varchar(11) DEFAULT NULL,
  `approval_requisition` varchar(11) DEFAULT NULL,
  `business_communication_outgoing` varchar(11) DEFAULT NULL,
  `minutes_of_meeting` varchar(11) DEFAULT NULL,
  `report_module` int(11) DEFAULT 1,
  `reports` int(11) DEFAULT 1,
  `daily_performance_report` int(11) NOT NULL DEFAULT 1,
  `vehicle_management_report_module` int(11) NOT NULL DEFAULT 1,
  `vehicle_report` int(11) NOT NULL DEFAULT 1,
  `daily_km_report` int(11) NOT NULL DEFAULT 1,
  `diesel_slip_report` int(11) NOT NULL DEFAULT 1,
  `memo_report` int(11) NOT NULL DEFAULT 1,
  `krakpi_report` int(11) NOT NULL DEFAULT 1,
  `staff_task_details` int(11) NOT NULL DEFAULT 1,
  `FCM_Token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `fullname`, `title`, `emailid`, `user_name`, `user_password`, `role`, `staff_id`, `branch_id`, `designation_id`, `mobile_number`, `status`, `Createddate`, `administration_module`, `dashboard`, `company_creation`, `branch_creation`, `holiday_creation`, `manage_users`, `master_module`, `basic_sub_module`, `responsibility_sub_module`, `audit_sub_module`, `others_sub_module`, `basic_creation`, `tag_creation`, `rr_creation`, `kra_category`, `krakpi_creation`, `staff_creation`, `audit_area_creation`, `audit_area_checklist`, `audit_assign`, `audit_follow_up`, `report_template`, `media_master`, `asset_creation`, `insurance_register`, `service_indent`, `asset_details`, `rgp_creation`, `promotional_activities`, `work_force_module`, `schedule_task_sub_module`, `memo_sub_module`, `campaign`, `assign_work`, `daily_task_update`, `todo`, `assigned_work`, `memo_initiate`, `memo_assigned`, `memo_update`, `maintenance_module`, `pm_checklist`, `bm_checklist`, `maintenance_checklist`, `manpower_in_out_module`, `permission_or_onduty`, `regularisation_approval`, `transfer_location`, `target_fixing_module`, `goal_setting`, `target_fixing`, `daily_performance`, `daily_performance_review`, `appreciation_depreciation`, `vehicle_management_module`, `vehicle_details`, `daily_km`, `diesel_slip`, `approval_mechanism_module`, `approval_requisition`, `business_communication_outgoing`, `minutes_of_meeting`, `report_module`, `reports`, `daily_performance_report`, `vehicle_management_report_module`, `vehicle_report`, `daily_km_report`, `diesel_slip_report`, `memo_report`, `krakpi_report`, `staff_task_details`, `FCM_Token`) VALUES
(1, 'Super', 'Admin', 'Super Admin', 'Super Admin', 'support@feathertechnology.in', 'support@feathertechnology.in', 'admin@123', '1', 'Overall', 'Overall', NULL, NULL, '0', '2021-04-17 17:08:00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, '0', '0', '0', '0', '0', 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `vehicle_details_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vehicle_code` varchar(255) DEFAULT NULL,
  `vehicle_type` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_details`
--

INSERT INTO `vehicle_details` (`vehicle_details_id`, `company_id`, `vehicle_code`, `vehicle_type`, `vehicle_name`, `vehicle_number`, `date_of_purchase`, `fitment_upto`, `insurance_upto`, `asset_value`, `book_value_as_on`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', 'VC1', 1, 'Splendor+', 'TN254842', '2004-01-05', '2019-01-04', '2023-11-28', '30000', '30000', 0, 1, NULL, 1, '2024-01-06 20:16:06', '2024-01-06 20:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_name_creation`
--

CREATE TABLE `vendor_name_creation` (
  `vendor_name_id` int(11) NOT NULL,
  `vendor_name` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_status`
--

INSERT INTO `work_status` (`status_id`, `work_id`, `work_des`, `work_status`, `remarks`, `completed_file`, `outdated_completed_date`, `status`, `created_date`, `updated_date`, `created_id`, `updated_id`) VALUES
(3, 'krakpi_ref 7115', 'SALES REPORT', '3', 'testing krakpi', 'Book1 needed.xlsx', NULL, 0, '2024-01-05 05:40:28', '2024-01-05 05:40:28', NULL, NULL),
(4, 'krakpi_ref 10261', 'SALES REPORT', '1', 'testing', 'csv.csv', NULL, 0, '2024-01-06 00:00:00', '2024-01-06 19:46:10', NULL, NULL),
(5, 'krakpi_ref 5775', 'TDS READY', '3', 'Samudi sir Filling', NULL, '2024-01-07', 0, '2024-01-08 04:48:18', '2024-01-08 04:48:18', NULL, NULL),
(6, 'krakpi_ref 5863', 'HMCL Statement', '3', 'statement completed', NULL, '2024-01-03', 0, '2024-01-08 04:48:59', '2024-01-08 04:48:59', NULL, NULL),
(7, 'krakpi_ref 5723', 'HDFC Covid Loan', '3', 'Auto debit', '', NULL, 0, '2024-01-08 04:49:28', '2024-01-08 04:49:28', NULL, NULL),
(8, 'krakpi_ref 5747', 'HDFC Covid Loan-2', '3', 'Completed', '', NULL, 0, '2024-01-08 04:49:48', '2024-01-08 04:49:48', NULL, NULL),
(9, 'krakpi_ref 5735', 'HDFC Term Loan', '3', '', '', NULL, 0, '2024-01-08 04:50:13', '2024-01-08 04:50:13', NULL, NULL),
(10, 'krakpi_ref 5580', 'TDS Payment', '3', 'Filling completed', '', NULL, 0, '2024-01-08 04:50:33', '2024-01-08 04:50:33', NULL, NULL),
(11, 'krakpi_ref 5531', 'RENT AVULURPET', '3', '', NULL, '2024-01-05', 0, '2024-01-08 04:51:28', '2024-01-08 04:51:28', NULL, NULL),
(12, 'krakpi_ref 5507', 'RENT GINGEE', '3', '', NULL, '2024-01-05', 0, '2024-01-08 04:51:38', '2024-01-08 04:51:38', NULL, NULL),
(13, 'krakpi_ref 5555', 'RENT KANCHI', '3', '', NULL, '2024-01-05', 0, '2024-01-08 04:51:49', '2024-01-08 04:51:49', NULL, NULL),
(14, 'krakpi_ref 5519', 'RENT KILPENNATHUR ', '3', '', NULL, '2024-01-05', 0, '2024-01-08 04:51:59', '2024-01-08 04:51:59', NULL, NULL),
(15, 'krakpi_ref 5543', 'RENT VETTAVALAM', '3', '', NULL, '2024-01-05', 0, '2024-01-08 04:53:25', '2024-01-08 04:53:25', NULL, NULL),
(16, 'krakpi_ref 5483', 'Stock Statement Send to Mail to HDFC', '3', '', NULL, '2024-01-05', 0, '2024-01-08 04:53:39', '2024-01-08 04:53:39', NULL, NULL),
(17, 'krakpi_ref 5825', 'Indusind Finance Incentive', '3', '', NULL, '2024-01-22', 0, '2024-01-23 02:27:30', '2024-01-23 02:27:30', NULL, NULL),
(18, 'krakpi_ref 5812', 'Shriram Finance Incentive', '3', '', NULL, '2024-01-22', 0, '2024-01-23 02:27:42', '2024-01-23 02:27:42', NULL, NULL),
(19, 'krakpi_ref 5646', 'EB BILL AVULURPET', '3', '', NULL, '2024-01-14', 0, '2024-01-23 02:27:57', '2024-01-23 02:27:57', NULL, NULL),
(20, 'krakpi_ref 5633', 'EB BILL GINGEE', '3', '', NULL, '2024-01-14', 0, '2024-01-23 02:28:09', '2024-01-23 02:28:09', NULL, NULL),
(21, 'krakpi_ref 5659', 'EB BILL KANCHI', '3', '', NULL, '2024-01-14', 0, '2024-01-23 02:28:20', '2024-01-23 02:28:20', NULL, NULL),
(22, 'krakpi_ref 5799', 'FSC INVOICE e-sign', '3', '', NULL, '2024-01-10', 0, '2024-01-23 02:28:31', '2024-01-23 02:28:31', NULL, NULL),
(23, 'krakpi_ref 5787', 'WARRANTY INVICE e-sign', '3', '', NULL, '2024-01-23', 0, '2024-01-23 02:28:42', '2024-01-23 02:28:42', NULL, NULL),
(24, 'krakpi_ref 5594', 'EPF PAYMENT', '3', '', NULL, '2024-01-12', 0, '2024-01-23 02:28:55', '2024-01-23 02:28:55', NULL, NULL),
(25, 'krakpi_ref 5466', 'GSTR1', '3', '', NULL, '2024-01-11', 0, '2024-01-23 02:29:10', '2024-01-23 02:29:10', NULL, NULL),
(26, 'krakpi_ref 5838', 'Insurance Commission', '3', '', NULL, '2024-01-11', 0, '2024-01-23 02:29:21', '2024-01-23 02:29:21', NULL, NULL),
(27, 'krakpi_ref 5568', 'GSTR3B Payment', '3', '', NULL, '2024-01-20', 0, '2024-01-23 02:29:32', '2024-01-23 02:29:32', NULL, NULL),
(28, 'krakpi_ref 5773', 'AUTO - TN25BF2121', '3', '', NULL, '2024-01-02', 0, '2024-01-23 02:29:47', '2024-01-23 02:29:47', NULL, NULL),
(29, 'krakpi_ref 5711', 'Internet Payment ', '3', '', NULL, '2024-01-01', 0, '2024-01-23 02:29:56', '2024-01-23 02:29:56', NULL, NULL),
(30, 'krakpi_ref 5772', 'TATA ACE - TN25BK3574', '3', '', NULL, '2024-01-01', 0, '2024-01-23 02:30:07', '2024-01-23 02:30:07', NULL, NULL),
(31, 'krakpi_ref 5685', 'EB BILL KILPENNATHUR', '3', '', NULL, '2024-01-15', 0, '2024-01-23 06:28:06', '2024-01-23 06:28:06', NULL, NULL),
(32, 'krakpi_ref 5607', 'EB BILL MAIN', '3', '', NULL, '2024-01-15', 0, '2024-01-23 06:28:21', '2024-01-23 06:28:21', NULL, NULL),
(33, 'krakpi_ref 5620', 'EB BILL NEW SHOWROOM', '3', '', NULL, '2024-01-15', 0, '2024-01-23 06:28:44', '2024-01-23 06:28:44', NULL, NULL),
(34, 'krakpi_ref 5672', 'EB BILL VETTAVALAM', '3', '', NULL, '2024-01-15', 0, '2024-01-23 06:28:57', '2024-01-23 06:28:57', NULL, NULL),
(35, 'krakpi_ref 5698', 'TELEPHONE BILLS', '3', '', NULL, '2024-01-15', 0, '2024-01-23 06:29:11', '2024-01-23 06:29:11', NULL, NULL),
(36, 'krakpi_ref 5495', 'RENT NEW SHOWROOM', '3', '', NULL, '2024-01-04', 0, '2024-01-23 06:29:24', '2024-01-23 06:29:24', NULL, NULL),
(37, 'krakpi_ref 5851', 'GSRTR2B', '3', '', NULL, '2024-01-16', 0, '2024-01-23 06:29:43', '2024-01-23 06:29:43', NULL, NULL),
(38, 'krakpi_ref 16839', 'MARKET SHARE', '3', 'DONE', 'VAHAN MARKET SHARE.xlsx', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 12:49:15', NULL, NULL),
(39, 'krakpi_ref 16839', 'MARKET SHARE', '3', 'DONE', 'VAHAN MARKET SHARE.xlsx', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 12:49:15', NULL, NULL),
(40, 'krakpi_ref 17721', 'MARKET SHARE', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 19:57:55', NULL, NULL),
(41, 'krakpi_ref 18013', 'BIKE WALE', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 19:57:55', NULL, NULL),
(42, 'krakpi_ref 18305', 'PROSPECT ENQUIRY', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 19:58:55', NULL, NULL),
(43, 'krakpi_ref 18597', 'EXCHANGE REPORT', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 19:58:55', NULL, NULL),
(44, 'krakpi_ref 18889', 'FACEBOOK LEAD', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 19:59:30', NULL, NULL),
(45, 'krakpi_ref 19181', 'SALES UPLOAD', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 19:59:30', NULL, NULL),
(46, 'krakpi_ref 19473', 'FIRST SERVICE FOLLOWUP', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 20:00:10', NULL, NULL),
(47, 'krakpi_ref 19765', 'DISPATCH REPORT', '3', '', '', NULL, 0, '2024-01-26 00:00:00', '2024-01-26 20:00:10', NULL, NULL),
(48, 'krakpi_ref 17723', 'MARKET SHARE', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:34:42', NULL, NULL),
(49, 'krakpi_ref 18015', 'BIKE WALE', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:34:42', NULL, NULL),
(50, 'krakpi_ref 18307', 'PROSPECT ENQUIRY', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:35:56', NULL, NULL),
(51, 'krakpi_ref 18599', 'EXCHANGE REPORT', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:35:56', NULL, NULL),
(52, 'krakpi_ref 18891', 'FACEBOOK LEAD', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:36:49', NULL, NULL),
(53, 'krakpi_ref 19183', 'SALES UPLOAD', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:36:49', NULL, NULL),
(54, 'krakpi_ref 19475', 'FIRST SERVICE FOLLOWUP', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:38:05', NULL, NULL),
(55, 'krakpi_ref 19767', 'DISPATCH REPORT', '3', 'DONE', '', NULL, 0, '2024-01-29 00:00:00', '2024-01-29 19:38:05', NULL, NULL),
(56, 'krakpi_ref 27274', 'ORDER VS DISPATCH', '3', 'DONE', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 10:23:54', NULL, NULL),
(57, 'krakpi_ref 27561', 'CORPORATE SALES', '3', 'NILL', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 10:23:54', NULL, NULL),
(58, 'krakpi_ref 27848', 'FOLLOWUP & CONVERSION', '3', 'FOLLOWUP 167 COVERSTION 8', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 10:23:54', NULL, NULL),
(59, 'krakpi_ref 25552', 'PAID STOCK CHECK', '3', 'DONE', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 10:52:08', NULL, NULL),
(60, 'krakpi_ref 25839', 'BIKE WALE', '3', 'NO ENQUIRY', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 10:52:08', NULL, NULL),
(61, 'krakpi_ref 26126', 'FIRST SERVICE FOLLOWUP', '2', 'TODAY FOLLOW', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 10:52:08', NULL, NULL),
(62, 'krakpi_ref 26413', 'GOOGLE REVIEW', '3', '2', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 16:25:23', NULL, NULL),
(63, 'krakpi_ref 26700', 'EXCHANGE REPORT', '3', '1', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 16:25:23', NULL, NULL),
(64, 'krakpi_ref 26987', 'FINANCE FOLLOWUP', '2', 'pending', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 16:25:23', NULL, NULL),
(65, 'krakpi_ref 28996', 'GOOD LIFE', '3', '5', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 16:28:28', NULL, NULL),
(66, 'krakpi_ref 29283', 'MARKET SHARE', '3', 'done', 'VAHAN MARKET SHARE.xlsx', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 16:28:28', NULL, NULL),
(67, 'krakpi_ref 29570', 'ENQUIRY SCORE', '3', '5 unfasifed', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 16:28:28', NULL, NULL),
(68, 'krakpi_ref 29857', 'SALES BOOKING', '3', 'nill', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 18:27:10', NULL, NULL),
(69, 'krakpi_ref 30144', 'GOODLIFE REFERRAL', '3', 'nill', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 18:27:10', NULL, NULL),
(70, 'krakpi_ref 30431', 'SERVICE TOUR', '3', 'no ', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 18:27:10', NULL, NULL),
(71, 'krakpi_ref 20647', 'TELEPHONE ENQUIRY', '3', '2', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 18:28:38', NULL, NULL),
(72, 'krakpi_ref 20939', 'ENQUIRY MANAGEMENT', '3', '16 Enquiry', '', NULL, 0, '2024-02-02 00:00:00', '2024-02-02 18:28:38', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `assertion_creation`
--
ALTER TABLE `assertion_creation`
  ADD PRIMARY KEY (`assertion_id`);

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
-- Indexes for table `asset_name_creation`
--
ALTER TABLE `asset_name_creation`
  ADD PRIMARY KEY (`asset_name_id`);

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
-- Indexes for table `bm_checklist_multiple`
--
ALTER TABLE `bm_checklist_multiple`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_checklist_ref`
--
ALTER TABLE `bm_checklist_ref`
  ADD PRIMARY KEY (`bm_checklist_ref_id`);

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
-- Indexes for table `fc_insurance_renew`
--
ALTER TABLE `fc_insurance_renew`
  ADD PRIMARY KEY (`fc_insurance_renew_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageId`),
  ADD KEY `SenderId` (`SenderId`),
  ADD KEY `ReceiverId` (`ReceiverId`);

--
-- Indexes for table `pending_task_notification`
--
ALTER TABLE `pending_task_notification`
  ADD PRIMARY KEY (`notification_id`);

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
-- Indexes for table `pm_checklist_multiple`
--
ALTER TABLE `pm_checklist_multiple`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  ADD PRIMARY KEY (`pm_checklist_ref_id`);

--
-- Indexes for table `policy_company_creation`
--
ALTER TABLE `policy_company_creation`
  ADD PRIMARY KEY (`policy_company_id`);

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
-- Indexes for table `responsibility_creation`
--
ALTER TABLE `responsibility_creation`
  ADD PRIMARY KEY (`responsibility_id`);

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
-- Indexes for table `staff_creation_history`
--
ALTER TABLE `staff_creation_history`
  ADD PRIMARY KEY (`staff_history_id`);

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
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`team_member_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `team_messages`
--
ALTER TABLE `team_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`vehicle_details_id`);

--
-- Indexes for table `vendor_name_creation`
--
ALTER TABLE `vendor_name_creation`
  ADD PRIMARY KEY (`vendor_name_id`);

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
-- AUTO_INCREMENT for table `assertion_creation`
--
ALTER TABLE `assertion_creation`
  MODIFY `assertion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_details`
--
ALTER TABLE `asset_details`
  MODIFY `asset_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_name_creation`
--
ALTER TABLE `asset_name_creation`
  MODIFY `asset_name_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_register`
--
ALTER TABLE `asset_register`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `basic_creation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  MODIFY `bm_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bm_checklist_multiple`
--
ALTER TABLE `bm_checklist_multiple`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bm_checklist_ref`
--
ALTER TABLE `bm_checklist_ref`
  MODIFY `bm_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_creation`
--
ALTER TABLE `branch_creation`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `category_creation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_creation`
--
ALTER TABLE `company_creation`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designation_creation`
--
ALTER TABLE `designation_creation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  MODIFY `diesel_slip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_insurance_renew`
--
ALTER TABLE `fc_insurance_renew`
  MODIFY `fc_insurance_renew_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_creation_ref`
--
ALTER TABLE `holiday_creation_ref`
  MODIFY `holiday_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_register`
--
ALTER TABLE `insurance_register`
  MODIFY `ins_reg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_register_ref`
--
ALTER TABLE `insurance_register_ref`
  MODIFY `ins_reg_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `krakpi_calendar_map`
--
ALTER TABLE `krakpi_calendar_map`
  MODIFY `krakpi_calendar_map_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  MODIFY `krakpi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  MODIFY `krakpi_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kra_creation`
--
ALTER TABLE `kra_creation`
  MODIFY `kra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  MODIFY `kra_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledgerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_checklist`
--
ALTER TABLE `maintenance_checklist`
  MODIFY `maintenance_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_checklist_ref`
--
ALTER TABLE `maintenance_checklist_ref`
  MODIFY `maintenance_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_creation`
--
ALTER TABLE `media_creation`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_task_notification`
--
ALTER TABLE `pending_task_notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `pm_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_checklist_multiple`
--
ALTER TABLE `pm_checklist_multiple`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  MODIFY `pm_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_company_creation`
--
ALTER TABLE `policy_company_creation`
  MODIFY `policy_company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_creation`
--
ALTER TABLE `project_creation`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  MODIFY `promotional_activities_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  MODIFY `promotional_activities_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_creation`
--
ALTER TABLE `report_creation`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responsibility_creation`
--
ALTER TABLE `responsibility_creation`
  MODIFY `responsibility_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  MODIFY `rgp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rr_creation`
--
ALTER TABLE `rr_creation`
  MODIFY `rr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  MODIFY `rr_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_indent`
--
ALTER TABLE `service_indent`
  MODIFY `service_indent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spare_creation`
--
ALTER TABLE `spare_creation`
  MODIFY `spare_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_creation_history`
--
ALTER TABLE `staff_creation_history`
  MODIFY `staff_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag_creation`
--
ALTER TABLE `tag_creation`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `team_member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_messages`
--
ALTER TABLE `team_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  MODIFY `vehicle_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_name_creation`
--
ALTER TABLE `vendor_name_creation`
  MODIFY `vendor_name_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_status`
--
ALTER TABLE `work_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `year_creation`
--
ALTER TABLE `year_creation`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SenderId`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`ReceiverId`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `team_messages`
--
ALTER TABLE `team_messages`
  ADD CONSTRAINT `team_messages_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `team_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
