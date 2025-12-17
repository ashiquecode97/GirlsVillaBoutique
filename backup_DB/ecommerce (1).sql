-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 10:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@app.com', '$2y$12$Psb/Wn0mo245vB7qV4MeFOsYUlDk46wDHXHkARsxjclUEi.J/qkMi', '2025-12-03 12:00:54', '2025-12-03 12:00:54');

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
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `size`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, 1, '2025-12-03 12:52:16', '2025-12-03 12:52:16'),
(55, 1, 2, 'S', 1, '2025-12-09 15:15:43', '2025-12-09 15:15:43');

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

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '90bc4b17-b3cc-47b1-9268-03e2b9b37032', 'database', 'default', '{\"uuid\":\"90bc4b17-b3cc-47b1-9268-03e2b9b37032\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderConfirmedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"ashkmostafa23@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1764961170,\"delay\":null}', 'Illuminate\\Queue\\MaxAttemptsExceededException: App\\Mail\\OrderConfirmedMail has been attempted too many times. in C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\MaxAttemptsExceededException.php:24\nStack trace:\n#0 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(835): Illuminate\\Queue\\MaxAttemptsExceededException::forJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob))\n#1 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(555): Illuminate\\Queue\\Worker->maxAttemptsExceededException(Object(Illuminate\\Queue\\Jobs\\DatabaseJob))\n#2 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(458): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), 1)\n#3 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(419): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#4 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(187): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#5 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#6 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#7 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#8 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#10 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#11 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#12 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#13 C:\\xampp\\htdocs\\ecommerce\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#14 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#15 C:\\xampp\\htdocs\\ecommerce\\vendor\\symfony\\console\\Application.php(1073): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 C:\\xampp\\htdocs\\ecommerce\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 C:\\xampp\\htdocs\\ecommerce\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 C:\\xampp\\htdocs\\ecommerce\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 C:\\xampp\\htdocs\\ecommerce\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#21 {main}', '2025-12-05 13:50:59');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(2, 'default', '{\"uuid\":\"caf85021-af2d-487c-abdd-aa747bbc6ebb\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderConfirmedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"ashkmostafa23@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1764961900,\"delay\":null}', 1, 1764962459, 1764961900, 1764961900),
(3, 'default', '{\"uuid\":\"b04b996f-fc44-413f-97a3-1fb3e27b7b87\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderConfirmedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"ashkmostafa23@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1764963505,\"delay\":null}', 0, NULL, 1764963505, 1764963505),
(4, 'default', '{\"uuid\":\"afa5e219-a818-435a-be5c-d6d0865a31ca\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderConfirmedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"ashkmostafa23@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1764964054,\"delay\":null}', 0, NULL, 1764964054, 1764964054),
(5, 'default', '{\"uuid\":\"b45e7c3e-07a8-464f-88b0-11e37c8c1fbc\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderConfirmedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"ashkmostafa23@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1764964850,\"delay\":null}', 0, NULL, 1764964850, 1764964850),
(6, 'default', '{\"uuid\":\"ceb88a67-cce1-4cd1-9344-347e9a61c6e6\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderConfirmedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:23:\\\"ashkmostafa23@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1764964991,\"delay\":null}', 0, NULL, 1764964991, 1764964991);

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
(4, '2025_12_03_155959_create_admins_table', 2),
(5, '2025_12_03_160153_create_products_table', 2),
(6, '2025_12_03_160241_create_cart_items_table', 2),
(7, '2025_12_03_160249_create_orders_table', 2),
(8, '2025_12_03_160257_create_order_items_table', 2),
(9, '2025_12_04_184520_create_orders_table', 3),
(10, '2025_12_04_184633_create_order_items_table', 4),
(11, '2025_12_09_161041_add_size_and_product_code_to_products_table', 5),
(12, '2025_12_09_172535_add_size_to_cart_items_table', 6),
(13, '2025_12_09_184808_add_size_to_order_items_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `address`, `city`, `pincode`, `phone`, `payment_method`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(19, 1, 'kambulaaaaaaaaaaaaaaaaa', 'ashkmostafa23@gmail.com', 'aaaaaasdddddddddddddddddddd', 'dhubri', '783324', '7002233886', 'cod', 4866, 'Pending', '2025-12-09 13:09:34', '2025-12-09 13:09:34'),
(20, 1, 'kambul', 'ashkmostafa23@gmail.com', 'aaaaaaaaaaaaaaaaaa', 'dhubri', '783324', '7002233886', 'cod', 10954, 'processing', '2025-12-09 13:16:16', '2025-12-09 14:31:22'),
(21, 1, 'kambul', 'ashkmostafa23@gmail.com', 'aaaaaaaaaaaaaaaaaa', 'dhubri', '783324', '7002233886', 'cod', 10954, 'success', '2025-12-09 13:16:39', '2025-12-09 14:31:02'),
(27, 1, 'Ashique Mostafa', 'ashkmostafa23@gmail.com', 'fwhhgg', 'nkknk', '783324', '7002233886', 'cod', 3199, 'Pending', '2025-12-09 15:11:51', '2025-12-09 15:11:51'),
(28, 1, 'sarmin', 'ashkmostafa23@gmail.com', 'fegae', 'ge', '783324', '8723948341', 'cod', 1222, 'Pending', '2025-12-09 15:14:10', '2025-12-09 15:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `size`, `price`, `created_at`, `updated_at`) VALUES
(32, 27, 5, 1, 'XL', 1999, '2025-12-09 15:11:51', '2025-12-09 15:11:51'),
(33, 27, 2, 1, 'S', 1200, '2025-12-09 15:11:52', '2025-12-09 15:11:52'),
(34, 28, 7, 1, 'M', 1222, '2025-12-09 15:14:10', '2025-12-09 15:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ashkmostafa23@gmail.com', '$2y$12$KDqjr2JqqvH1z6hl.IbGOe32Jv2j8b92tA3nVUstomsB5dWgD1KQa', '2025-12-04 11:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `size` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `name`, `description`, `price`, `stock`, `size`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'PRD-0001', 'Salawar suit', 'newly added', 1200, 7, NULL, 'products/Lf7VP4RzqUIlgiKZAUZubunF82DWddZQDTsUUv8T.jpg', 1, '2025-12-03 12:02:11', '2025-12-05 13:29:30'),
(2, 'PRD-0002', 'kurti 200', 'new', 1200, 0, 'S', 'products/hVgFKSp93lGVMcbKpwH3GseHIbSnWpGWTgwp8gRi.jpg', 1, '2025-12-03 12:39:43', '2025-12-09 12:46:17'),
(3, 'PRD-0003', 'orange kurti', 'nice kurti . sale in eid', 2000, 7, NULL, 'products/NW1MylOHM3j0TLw5prYvW7GWfXEBrzDH5ihV9qR6.jpg', 1, '2025-12-04 11:51:15', '2025-12-05 14:32:46'),
(4, 'PRD-0004', 'blue kurti set', 'newle added on winter', 1499, 9, NULL, 'products/KNJkW3MEq1sBZ8nNReLdMQWskl0n3PauhgAIugLR.jpg', 1, '2025-12-05 05:30:40', '2025-12-05 14:16:52'),
(5, 'PRD-0005', 'black pakistani suits', 'here some premium collection', 1999, 8, 'M,XL', 'products/8CkOAdVutTwtpxxapXGqOP76GCzCXs97ldBYqTZt.jpg', 1, '2025-12-05 05:31:32', '2025-12-09 15:11:51'),
(7, 'GV-0006', 'Russian Plazo', 'vs', 1222, 0, 'S,M,L', 'products/HR7dFaZG0DYBCNR9X2lZfwEvxCSlA281lzYvhY5J.jpg', 1, '2025-12-09 11:14:46', '2025-12-09 12:46:17');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kws2KGmIwq0id6UUI3n5w6ahlutLuprwoFgrxfXf', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2VzWVRUbUlGdUp4OWk3S21vRlptamFPU0NxcEtTYjhJY2sxeEE2VyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0IjtzOjU6InJvdXRlIjtzOjEwOiJjYXJ0LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1765313147),
('TVFaJsZLHEl9ZhglvYTvsMeOPGCnR63Xxf7rYRBF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWXpncXFXZnJnN3ppUHhnZ1kyZnRYaTg0d1BFR25DRXlJTE82NUczMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9vcmRlcnMvMjgiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLm9yZGVycy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNToiYWRtaW5fbG9nZ2VkX2luIjtiOjE7czo4OiJhZG1pbl9pZCI7aToxO30=', 1765313086);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ashique Mostafa', 'ashkmostafa23@gmail.com', NULL, '$2y$12$m8lTqrKQlbk2cHDNsfU8hOGzlcf2hGfnsCPHaHuKUcyCfT80pGadC', NULL, '2025-11-26 11:14:30', '2025-11-26 11:14:30'),
(2, 'Ashique Mostafa', 'admin@app.com', NULL, '$2y$12$JD/4yduXN8h/iHp0CJpNCOttFVFrY75udB5uftyr.cg7C8tDxUDF2', 'nNp1NRjGiaoPh5nHKjRqMFF4ufuUlYe78oxJ8bbIhupQhdwlxINRlqjxzmMe', '2025-12-03 10:22:24', '2025-12-03 10:22:24'),
(3, 'user', 'ashk@gmail.com', NULL, '$2y$12$nNluOfyZbcBW3HT5VmjLmOsnaICywa3g9iPwWP9Oy0S15nEpeY7a.', NULL, '2025-12-04 11:16:37', '2025-12-04 11:16:37'),
(4, 'moromi', 'studyneed12@gmail.com', NULL, '$2y$12$YacDz2sYr/VG/S6NpbIl0uInKkY1KJXzSgdgaf/kHipASq0jMjVCW', NULL, '2025-12-04 14:17:01', '2025-12-04 14:17:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `products_product_code_unique` (`product_code`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
