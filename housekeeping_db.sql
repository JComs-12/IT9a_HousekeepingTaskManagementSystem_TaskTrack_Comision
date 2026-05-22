-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 05:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `housekeeping_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_tasks_by_staff` (IN `staff_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci)   BEGIN
    SELECT
        t.id            AS task_id,
        t.task_name,
        t.priority,
        t.status,
        t.due_date,
        r.room_number,
        r.room_type,
        s.name          AS staff_name,
        s.email         AS staff_email
    FROM tasks t
    JOIN rooms r
        ON t.room_id = r.id
    JOIN task_staff ts
        ON t.id = ts.task_id
    JOIN staff s
        ON ts.staff_id = s.id
    WHERE
        s.name LIKE CONCAT('%', staff_name, '%')
    ORDER BY t.due_date ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_all_tasks` ()   BEGIN
    SELECT
        t.id            AS task_id,
        t.task_name,
        t.priority,
        t.status,
        t.due_date,
        r.room_number,
        r.room_type,
        GROUP_CONCAT(s.name SEPARATOR ', ') AS assigned_staff
    FROM tasks t
    JOIN rooms r
        ON t.room_id = r.id
    LEFT JOIN task_staff ts
        ON t.id = ts.task_id
    LEFT JOIN staff s
        ON ts.staff_id = s.id
    GROUP BY
        t.id,
        t.task_name,
        t.priority,
        t.status,
        t.due_date,
        r.room_number,
        r.room_type
    ORDER BY t.due_date ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_task_status` (IN `p_task_id` BIGINT, IN `p_status` VARCHAR(20), IN `p_user_id` BIGINT)   BEGIN
    DECLARE v_task_name   VARCHAR(255);
    DECLARE v_user_role   VARCHAR(50);

    SELECT task_name INTO v_task_name
    FROM tasks
    WHERE id = p_task_id;

    SELECT role INTO v_user_role
    FROM users
    WHERE id = p_user_id;

    UPDATE tasks
    SET
        status     = p_status,
        updated_at = NOW()
    WHERE id = p_task_id;

    INSERT INTO activity_logs
        (user_id, role, action, description, subject_type, subject_id, created_at, updated_at)
    VALUES (
        p_user_id,
        IFNULL(v_user_role, 'admin'),
        'Status Updated',
        CONCAT('Task "', v_task_name, '" status changed to "', p_status, '"'),
        'Task',
        p_task_id,
        NOW(),
        NOW()
    );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `action` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_important` tinyint(1) NOT NULL DEFAULT 0,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `role`, `action`, `description`, `is_important`, `subject_type`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'staff', 'Staff Account Created', 'Staff member \'gab sdsdds\' (Email: gab@email.com) registered successfully.', 1, 'Staff', 1, '2026-05-09 07:13:42', '2026-05-09 07:13:42'),
(2, 3, 'staff', 'Staff Account Created', 'Staff member \'Meljim GaPa Lubot\' (Email: jim@email.com) registered successfully.', 1, 'Staff', 2, '2026-05-09 07:24:48', '2026-05-09 07:24:48'),
(3, 1, 'admin', 'Deleted Staff Account', 'Deleted staff member \'Meljim GaPa Lubot\' (Email: jim@email.com) with reason: Resignation', 1, 'Staff', 2, '2026-05-09 07:26:40', '2026-05-09 07:26:40'),
(4, 1, 'admin', 'Task Created', 'Task \"Clean Toilet\" created for Room 103 — assigned to: gab sdsdds', 0, 'Task', 1, '2026-05-09 07:27:22', '2026-05-09 07:27:22'),
(5, 2, 'staff', 'Task Status Updated', 'Staff gab sdsdds updated task \"Clean Toilet\" status to completed.', 0, 'Task', 1, '2026-05-09 07:28:19', '2026-05-09 07:28:19'),
(6, 4, 'staff', 'Staff Account Created', 'Staff member \'Gabriel Gonggong\' (Email: gabriel@email.com) registered successfully.', 1, 'Staff', 3, '2026-05-18 01:41:25', '2026-05-18 01:41:25'),
(7, 1, 'admin', 'Task Created', 'Task \"Clean Toilet\" created for Room 101 — assigned to: Gabriel Gonggong', 0, 'Task', 2, '2026-05-18 01:42:55', '2026-05-18 01:42:55'),
(8, 4, 'staff', 'Task Status Updated', 'Staff Gabriel Gonggong updated task \"Clean Toilet\" status to completed.', 0, 'Task', 2, '2026-05-18 01:46:04', '2026-05-18 01:46:04'),
(9, 1, 'admin', 'Task Deleted', 'Task \"Clean Toilet\" was deleted.', 0, 'Task', NULL, '2026-05-18 01:47:18', '2026-05-18 01:47:18'),
(10, 1, 'admin', 'Task Created', 'Task \"Clean Bedroom\" created for Room 101 — assigned to: Gabriel Gonggong', 0, 'Task', 3, '2026-05-18 02:07:26', '2026-05-18 02:07:26'),
(11, 5, 'staff', 'Staff Account Created', 'Staff member \'Test (Staff) User\' (Email: test@email.com) registered successfully.', 1, 'Staff', 4, '2026-05-21 19:26:54', '2026-05-21 19:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_04_131121_create_products_table', 1),
(5, '2026_04_02_210527_create_rooms_table', 1),
(6, '2026_04_02_210623_create_staff_table', 1),
(7, '2026_04_02_210638_create_tasks_table', 1),
(8, '2026_04_02_210645_create_task_statuses_table', 1),
(9, '2026_04_02_211901_drop_task_statuses_table', 1),
(10, '2026_04_02_212036_add_status_to_tasks_table', 1),
(11, '2026_04_15_213457_add_role_to_users_table', 1),
(12, '2026_04_15_215024_add_staff_id_to_users_table', 1),
(13, '2026_04_16_105148_create_task_staff_table', 1),
(14, '2026_04_16_105318_create_activity_logs_table', 1),
(15, '2026_04_16_120000_create_staff_reports_table', 1),
(16, '2026_04_17_001301_add_avatar_to_users_table', 1),
(17, '2026_04_17_001454_add_unique_index_to_rooms_room_number', 1),
(18, '2026_05_04_151700_create_notifications_table', 1),
(19, '2026_05_07_000000_add_profile_fields_to_staff_table', 1),
(20, '2026_05_07_000002_add_deleted_reason_fields_to_users_table', 1),
(21, '2026_05_07_add_is_important_to_activity_logs', 1),
(22, '2026_05_08_000001_add_gender_to_users_and_staff_table', 1),
(23, '2026_05_08_add_profile_fields_to_users_table', 1),
(24, '2026_05_09_151039_add_columns_to_staff_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1f716ee1-ed67-4431-8304-03bae01ecd30', 'App\\Notifications\\NewTaskAssigned', 'App\\Models\\User', 2, '{\"action\":\"New Task Assigned\",\"task_id\":1,\"message\":\"You have been assigned a new task: \",\"url\":\"http:\\/\\/127.0.0.1:8000\\/staff\\/tasks?highlight_task=1\",\"icon\":\"fa-tasks\",\"color\":\"0dcaf0\"}', '2026-05-09 07:27:59', '2026-05-09 07:27:22', '2026-05-09 07:27:59'),
('3801178f-941a-4133-8f76-92ab4f666270', 'App\\Notifications\\TaskCompleted', 'App\\Models\\User', 1, '{\"action\":\"Task Completed\",\"task_id\":1,\"message\":\"A task was completed: \",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/tasks?highlight_task=1\",\"icon\":\"fa-check-circle\",\"color\":\"198754\"}', '2026-05-09 07:28:52', '2026-05-09 07:28:19', '2026-05-09 07:28:52'),
('3deb6b05-759f-483e-a44d-eedd81920246', 'App\\Notifications\\NewTaskAssigned', 'App\\Models\\User', 4, '{\"action\":\"New Task Assigned\",\"task_id\":2,\"message\":\"You have been assigned a new task: \",\"url\":\"http:\\/\\/127.0.0.1:8000\\/staff\\/tasks?highlight_task=2\",\"icon\":\"fa-tasks\",\"color\":\"0dcaf0\"}', '2026-05-18 01:45:44', '2026-05-18 01:42:55', '2026-05-18 01:45:44'),
('9e1bc011-9df6-485d-abd3-6467b874ea3a', 'App\\Notifications\\ImportantActionNotification', 'App\\Models\\User', 1, '{\"action\":\"Staff Account Created\",\"description\":\"New staff member \'Test (Staff) User\' has registered.\",\"performer\":\"Test (Staff) User\",\"performer_role\":\"staff\",\"icon\":\"fa-user-plus\",\"color\":\"success\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/staff\"}', NULL, '2026-05-21 19:26:59', '2026-05-21 19:26:59'),
('bc323c52-4aa0-441a-a9dd-e485ac829be5', 'App\\Notifications\\ImportantActionNotification', 'App\\Models\\User', 1, '{\"action\":\"Staff Account Created\",\"description\":\"New staff member \'Gabriel Gonggong\' has registered.\",\"performer\":\"Gabriel Gonggong\",\"performer_role\":\"staff\",\"icon\":\"fa-user-plus\",\"color\":\"success\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/staff\"}', NULL, '2026-05-18 01:41:28', '2026-05-18 01:41:28'),
('c1154ece-ca0e-4a06-8701-7677947f946c', 'App\\Notifications\\NewTaskAssigned', 'App\\Models\\User', 4, '{\"action\":\"New Task Assigned\",\"task_id\":3,\"message\":\"You have been assigned a new task: \",\"url\":\"http:\\/\\/127.0.0.1:8000\\/staff\\/tasks?highlight_task=3\",\"icon\":\"fa-tasks\",\"color\":\"0dcaf0\"}', '2026-05-18 02:09:25', '2026-05-18 02:07:26', '2026-05-18 02:09:25'),
('c97a4af2-af77-48d8-a258-965fb64034d2', 'App\\Notifications\\TaskCompleted', 'App\\Models\\User', 1, '{\"action\":\"Task Completed\",\"task_id\":2,\"message\":\"A task was completed: \",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/tasks?highlight_task=2\",\"icon\":\"fa-check-circle\",\"color\":\"198754\"}', '2026-05-18 01:47:03', '2026-05-18 01:46:04', '2026-05-18 01:47:03'),
('d8419b12-b5a9-4537-8683-7fc984a83fe5', 'App\\Notifications\\ImportantActionNotification', 'App\\Models\\User', 1, '{\"action\":\"Deleted Staff Account\",\"description\":\"Staff member \'Meljim GaPa Lubot\' has been deleted. Reason: Resignation\",\"performer\":\"Test User\",\"performer_role\":\"admin\",\"icon\":\"fa-user-slash\",\"color\":\"danger\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/staff\"}', NULL, '2026-05-09 07:26:40', '2026-05-09 07:26:40'),
('dda84071-73e5-4883-b274-77563b4f25bc', 'App\\Notifications\\ImportantActionNotification', 'App\\Models\\User', 1, '{\"action\":\"Staff Account Created\",\"description\":\"New staff member \'Meljim GaPa Lubot\' has registered.\",\"performer\":\"Meljim GaPa Lubot\",\"performer_role\":\"staff\",\"icon\":\"fa-user-plus\",\"color\":\"success\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/staff\"}', NULL, '2026-05-09 07:24:48', '2026-05-09 07:24:48'),
('dec554ea-d33b-4daf-8d2d-1851ad63bd85', 'App\\Notifications\\ImportantActionNotification', 'App\\Models\\User', 1, '{\"action\":\"Staff Account Created\",\"description\":\"New staff member \'gab sdsdds\' has registered.\",\"performer\":\"gab sdsdds\",\"performer_role\":\"staff\",\"icon\":\"fa-user-plus\",\"color\":\"success\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/staff\"}', NULL, '2026-05-09 07:13:50', '2026-05-09 07:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `status`, `created_at`, `updated_at`) VALUES
(1, '101', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(2, '102', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(3, '103', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(4, '104', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(5, '105', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(6, '106', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(7, '107', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(8, '108', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(9, '109', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28'),
(10, '110', 'Single', 'available', '2026-05-08 10:04:28', '2026-05-08 10:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` smallint(5) UNSIGNED DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deletion_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `name`, `email`, `phone`, `address`, `birthdate`, `age`, `gender`, `avatar`, `status`, `created_at`, `updated_at`, `deleted_at`, `deletion_reason`) VALUES
(1, 'gab', 'sdsdds', 'gab sdsdds', 'gab@email.com', '09345678987', 'ddvo', '2008-05-01', 18, 'male', NULL, 'active', '2026-05-09 07:13:40', '2026-05-09 07:13:40', NULL, NULL),
(3, 'Gabriel', 'Gonggong', 'Gabriel Gonggong', 'gabriel@email.com', '09123456789', 'Davao City', '2008-05-06', 18, 'male', NULL, 'active', '2026-05-18 01:41:25', '2026-05-18 01:41:25', NULL, NULL),
(4, 'Test (Staff)', 'User', 'Test (Staff) User', 'test@email.com', '09354627864', 'Davao City', '2005-06-08', 20, 'prefer_not_to_say', NULL, 'active', '2026-05-21 19:26:54', '2026-05-21 19:26:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_reports`
--

CREATE TABLE `staff_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `report_type` enum('damage','discovery','other') NOT NULL DEFAULT 'damage',
  `description` text NOT NULL,
  `status` enum('pending','resolved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `due_date` date NOT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `room_id`, `task_name`, `description`, `priority`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Clean Toilet', NULL, 'medium', '2026-05-09', 'completed', '2026-05-09 07:27:22', '2026-05-09 07:28:19'),
(3, 1, 'Clean Bedroom', NULL, 'high', '2026-05-18', 'pending', '2026-05-18 02:07:26', '2026-05-18 02:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `task_staff`
--

CREATE TABLE `task_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_staff`
--

INSERT INTO `task_staff` (`id`, `task_id`, `staff_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(3, 3, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` smallint(5) UNSIGNED DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deletion_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `email`, `phone`, `address`, `birthdate`, `age`, `gender`, `avatar`, `role`, `staff_id`, `email_verified_at`, `password`, `remember_token`, `deleted_at`, `deletion_reason`, `created_at`, `updated_at`) VALUES
(1, 'John Comision', 'John', 'Comision', 'john@email.com', '09234543212', 'Davao City', '2006-08-12', 19, 'male', NULL, 'admin', NULL, NULL, '$2y$12$9/9O4aevlXwJhdOw3rR1E.xBvwRWLWVKX8RL3829OgTjgIaO.kfZu', NULL, NULL, NULL, '2026-05-08 10:04:28', '2026-05-21 19:25:51'),
(2, 'gab sdsdds', 'gab', 'sdsdds', 'gab@email.com', '09345678987', 'ddvo', '2008-05-01', 18, 'male', NULL, 'staff', 1, NULL, '$2y$12$6OKaIuIz4cSHWSwLWZKQ6eFbilKGCTzdQMLZkGlaVKEh5wlvY.w3G', NULL, NULL, NULL, '2026-05-09 07:13:42', '2026-05-09 07:13:42'),
(3, 'Meljim GaPa Lubot', 'Meljim GaPa', 'Lubot', 'jim@email.com', '09234543212', 'Davao City', '2008-04-30', 18, 'male', NULL, 'staff', NULL, NULL, '$2y$12$IC/Bucj/jJAOyKcfoT9CkutK0ocg2hf34O26ywJn7LDahI8x7Glg2', NULL, '2026-05-09 07:26:40', 'Resignation', '2026-05-09 07:24:48', '2026-05-09 07:26:40'),
(4, 'Gabriel Gonggong', 'Gabriel', 'Gonggong', 'gabriel@email.com', '09123456789', 'Davao City', '2008-05-06', 18, 'male', NULL, 'staff', 3, NULL, '$2y$12$cf/1woEGpeT2xseFLQ2JBuZDLQ6qQFSl76WVuhegsqaumMJndQt9C', NULL, NULL, NULL, '2026-05-18 01:41:25', '2026-05-18 01:41:25'),
(5, 'Staff Nigga', 'Test (Staff)', 'User', 'test@email.com', '09354627864', 'Davao City', '2005-06-08', 20, 'prefer_not_to_say', NULL, 'staff', 4, NULL, '$2y$12$hFw/hQakPijhPNHI.E5jcuWaDfEj9KU9ho.Cx/5EkI7vd6O6UsIc2', NULL, NULL, NULL, '2026-05-21 19:26:54', '2026-05-21 19:27:29');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_overdue_tasks`
-- (See below for the actual view)
--
CREATE TABLE `view_overdue_tasks` (
`task_id` bigint(20) unsigned
,`task_name` varchar(255)
,`priority` enum('low','medium','high')
,`status` enum('pending','in_progress','completed')
,`due_date` date
,`room_number` varchar(255)
,`room_type` varchar(255)
,`days_overdue` int(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_task_summary`
-- (See below for the actual view)
--
CREATE TABLE `view_task_summary` (
`task_id` bigint(20) unsigned
,`task_name` varchar(255)
,`description` text
,`priority` enum('low','medium','high')
,`status` enum('pending','in_progress','completed')
,`due_date` date
,`room_number` varchar(255)
,`room_type` varchar(255)
,`room_status` enum('available','occupied','maintenance')
,`assigned_staff` mediumtext
);

-- --------------------------------------------------------

--
-- Structure for view `view_overdue_tasks`
--
DROP TABLE IF EXISTS `view_overdue_tasks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_overdue_tasks`  AS SELECT `t`.`id` AS `task_id`, `t`.`task_name` AS `task_name`, `t`.`priority` AS `priority`, `t`.`status` AS `status`, `t`.`due_date` AS `due_date`, `r`.`room_number` AS `room_number`, `r`.`room_type` AS `room_type`, to_days(curdate()) - to_days(`t`.`due_date`) AS `days_overdue` FROM (`tasks` `t` join `rooms` `r` on(`t`.`room_id` = `r`.`id`)) WHERE `t`.`status` in ('pending','in_progress') AND `t`.`due_date` < curdate() ORDER BY to_days(curdate()) - to_days(`t`.`due_date`) DESC, `t`.`priority` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `view_task_summary`
--
DROP TABLE IF EXISTS `view_task_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_task_summary`  AS SELECT `t`.`id` AS `task_id`, `t`.`task_name` AS `task_name`, `t`.`description` AS `description`, `t`.`priority` AS `priority`, `t`.`status` AS `status`, `t`.`due_date` AS `due_date`, `r`.`room_number` AS `room_number`, `r`.`room_type` AS `room_type`, `r`.`status` AS `room_status`, group_concat(`s`.`name` separator ', ') AS `assigned_staff` FROM (((`tasks` `t` join `rooms` `r` on(`t`.`room_id` = `r`.`id`)) left join `task_staff` `ts` on(`t`.`id` = `ts`.`task_id`)) left join `staff` `s` on(`ts`.`staff_id` = `s`.`id`)) GROUP BY `t`.`id`, `t`.`task_name`, `t`.`description`, `t`.`priority`, `t`.`status`, `t`.`due_date`, `r`.`room_number`, `r`.`room_type`, `r`.`status` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`);

--
-- Indexes for table `staff_reports`
--
ALTER TABLE `staff_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_reports_staff_id_foreign` (`staff_id`),
  ADD KEY `staff_reports_room_id_foreign` (`room_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_room_id_foreign` (`room_id`);

--
-- Indexes for table `task_staff`
--
ALTER TABLE `task_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_staff_task_id_staff_id_unique` (`task_id`,`staff_id`),
  ADD KEY `task_staff_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_staff_id_foreign` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_reports`
--
ALTER TABLE `staff_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_staff`
--
ALTER TABLE `task_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff_reports`
--
ALTER TABLE `staff_reports`
  ADD CONSTRAINT `staff_reports_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staff_reports_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_staff`
--
ALTER TABLE `task_staff`
  ADD CONSTRAINT `task_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_staff_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
