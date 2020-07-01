-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2020 at 04:42 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keybank_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountmaster`
--

CREATE TABLE `accountmaster` (
  `id` int(11) NOT NULL,
  `accounttype` varchar(25) NOT NULL,
  `prefix` varchar(11) NOT NULL,
  `minbalance` double(12,2) NOT NULL,
  `interest` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accountmaster`
--

INSERT INTO `accountmaster` (`id`, `accounttype`, `prefix`, `minbalance`, `interest`) VALUES
(2, 'Current', 'Cu', 2000.00, 10.00),
(6, 'Dsaved', 'Dd', 1000.00, 10.00),
(11, 'Saving', 'Sa', 1000.00, 15.50);

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customerid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accstatus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountbalance` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank`, `code`) VALUES
(1, 'Access Bank', '044'),
(2, 'Aso Savinhgs and Loan', '401'),
(3, 'Citi Bank', '023'),
(4, 'Covenant Microfinance Bank', '551'),
(5, 'Diamond Bank', '063'),
(6, 'Eco Bank', '050'),
(7, 'Eco Mobile', '307'),
(8, 'Ekondo Microfinance Bank', '562'),
(9, 'Enterprice Bank', '084'),
(10, 'Equitorial Trust Bank', '040'),
(11, 'Fidelity Bank', '070'),
(12, 'Fidelity Mobile', '318'),
(13, 'Finatrust Microfinance Bank', '608'),
(14, 'First City Monument Bank', '214'),
(15, 'First Inland Bank', '085'),
(16, 'Guarantee Trust Bank', '058'),
(17, 'Heritage Bank', '030'),
(18, 'Jaiz Bank', '301'),
(19, 'Keystone Bank', '082'),
(20, 'Main Street Bank', '014'),
(21, 'PAGA', '327'),
(22, 'Polaris Bank (Skye Bank)', '076'),
(23, 'Stanbic IBTC BAnk', '221'),
(24, 'Stanbic Mobile', '304'),
(25, 'Standard Chartered Bank', '068'),
(26, 'Sterline Bank', '232'),
(27, 'Sterline Mobile', '326'),
(28, 'Sun Trust Bank', '100'),
(29, 'Union Bank of Nigeria', '032'),
(30, 'United Bank For Africa', '033'),
(31, 'Unity Bank', '215'),
(32, 'Wema Bank', '035'),
(33, 'Zenith Bank', '057'),
(34, 'Zenith Mobile', '322'),
(35, 'First Bank of Nigeria Plc', '011'),
(36, 'Access Bank Plc (Diamond)', '063');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customerid` bigint(20) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` bigint(20) DEFAULT NULL,
  `expiry` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cvv` bigint(20) DEFAULT NULL,
  `cardType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `customerid`, `name`, `number`, `expiry`, `cvv`, `cardType`, `status`, `created_at`, `updated_at`) VALUES
(1, 4696, 'Kenneth C. Akpan', 1234567890123, '01/20', 123, 'MasterCard', 'Inactive', '2020-05-23 05:45:24', '2020-05-23 06:20:27'),
(2, 4696, 'Kenneth C. Akpan', 187545667890123, '08/21', 485, 'Visa', 'active', '2020-05-23 05:45:58', '2020-05-23 06:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `code`, `comment`) VALUES
(1, 'US Dollar', 'USD', ''),
(2, 'Australian Dollar', 'AUD', ''),
(3, 'Brazilian Real', 'BRL', ''),
(4, 'Canadian Dollar', 'CAD', ''),
(5, 'Czech Koruna', 'CZK', ''),
(6, 'Danish Krone', 'DKK', ''),
(7, 'Euro', 'EUR', ''),
(8, 'Thai Baht', 'THB', ''),
(9, 'Hong Kong Dollar', 'HKD', ''),
(10, 'Hungarian Forint', 'HUF', ''),
(11, 'Israeli New Sheqel', 'ILS', ''),
(12, 'Japanese Yen', 'JPY', ''),
(13, 'Malaysian Ringgit', 'MYR', ''),
(14, 'Mexican Peso', 'MXN', ''),
(15, 'Nigeria Naira', 'NGN', ''),
(16, 'New Zealand Dollar', 'NZD', ''),
(17, 'Philippine Peso', 'PHP', ''),
(18, 'Polish Zloty ', 'PLN', ''),
(19, 'Pound Sterling', 'GBP', ''),
(20, 'Russian Ruble', 'RUB', ''),
(21, 'Singapore Dollar', 'SGD', ''),
(22, 'Swedish Krona', 'SEK', ''),
(23, 'Swiss Franc', 'CHF', ''),
(24, 'Taiwan New Dollar', 'TWD', ''),
(26, 'Turkish Lira', 'TRY', '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customerid` bigint(20) NOT NULL,
  `accountno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middleName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bvn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionPIN` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `accstatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customerid`, `accountno`, `firstname`, `lastname`, `middleName`, `email`, `phone`, `dob`, `bvn`, `avatar`, `bankName`, `password`, `transactionPIN`, `accstatus`, `created_at`, `updated_at`) VALUES
(1, 7965, '1234567890', 'Kenneth', 'Akpan', NULL, 'kennyg50@email.com', '08034829112', NULL, NULL, NULL, NULL, 'eyJpdiI6Ik45R05pTHJzYlBjbmJvN0E4UWhoQ3c9PSIsInZhbHVlIjoiVExGVDZ6d3VjTitLTEJhOUlZUHd5dz09IiwibWFjIjoiZGI1MmUzNjY2OWZmZTgwNDQ5OGVkZjI3ODliNmIxMzFmYjMyMzI4ZWEyMmY4NWU1NTJhMDA5MzgzNTE3NzhkZSJ9', 'eyJpdiI6IjB0TUQ0V3dobTRIZlNoQVwvZ08rQnpBPT0iLCJ2YWx1ZSI6IlVNRjdMQUZIWk14OUoxcHpmM3k5Q0xhd3QxekZGWkpoZ212Y1JHRjF5UzA9IiwibWFjIjoiMTFiZmI4MjQxMzY5OTI1MWE3ZDcxNTI5NGM3MjcwZjRlNzkxOGQ1YzU4YjY0ZDA5NWY3N2Q5NmJlZjZmMTg4YSJ9', 'InActive', '2020-05-23 04:36:43', '2020-05-23 04:36:43'),
(2, 4696, '1234567890', 'Mary', 'Akpan', 'Francis', 'kennygendowed@email.com', '08032123445', NULL, NULL, NULL, NULL, 'eyJpdiI6IkNGcHl1QUU2Vlhxb09OMjA4SFUrUFE9PSIsInZhbHVlIjoibzFxZWlGVFwvbUx0NzFZM2FQeXBLSGc9PSIsIm1hYyI6IjljYjgxODE5ODAyNGU2NzY4YjdkYWIzMzViMTNiYmYxNDVlN2ZhYmQ1ZTI5MDI4ODMwZDc5MzdiMGQxODAyZDYifQ==', 'eyJpdiI6Imk4TUU4YkpIOHpqdjdrQis4UnRMV2c9PSIsInZhbHVlIjoiSExWY0hOYUx2eGNlNU80Rlwvdk5FbERVdko4eDgzcXJsYVdxZldOS2lOeTQ9IiwibWFjIjoiNTJlMGVhZmI1NTA1MGU4Y2Q3OGQ5NGFjNzc0OWZlODNhYTBiMTE4MDZjNTAyOTMzMDNiZjVhMjA3OTI5ZWViYSJ9', 'InActive', '2020-05-23 04:37:27', '2020-05-23 09:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(6) NOT NULL,
  `customerid` varchar(33) NOT NULL,
  `amount` int(55) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE `duration` (
  `id` int(22) NOT NULL,
  `name` varchar(33) NOT NULL,
  `value` int(33) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `duration`
--

INSERT INTO `duration` (`id`, `name`, `value`, `status`) VALUES
(1, 'One Month', 30, 1),
(2, 'Two Months', 60, 1),
(3, 'Three Months', 90, 1),
(4, 'Four Months', 120, 1),
(5, 'Five Months', 150, 1),
(6, 'Six Months', 180, 1),
(7, 'Seven Months', 210, 1),
(8, 'Eight Months', 230, 1),
(9, 'Nine Months', 260, 1),
(10, 'Ten Months', 290, 1),
(11, 'Eleven Months', 320, 1),
(12, 'Twelve Months', 365, 1),
(13, 'Two Years', 730, 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(10) NOT NULL,
  `loanid` int(10) NOT NULL,
  `loantype` varchar(25) NOT NULL,
  `loanamt` float(10,2) NOT NULL,
  `loannumber` varchar(255) NOT NULL,
  `customerid` int(12) NOT NULL,
  `acctno` varchar(200) NOT NULL,
  `interest` float(10,2) NOT NULL,
  `balance` int(200) DEFAULT 0,
  `total` float(10,2) DEFAULT 0.00,
  `paid` float(10,2) DEFAULT 0.00,
  `startdate` date DEFAULT NULL,
  `status` int(2) DEFAULT 0,
  `signed` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loanpayment`
--

CREATE TABLE `loanpayment` (
  `id` int(11) NOT NULL,
  `customerid` int(33) NOT NULL,
  `loanid` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `paidamt` int(10) NOT NULL,
  `principleamt` float(10,2) NOT NULL DEFAULT 0.00,
  `interestamt` float(10,2) NOT NULL DEFAULT 0.00,
  `balance` float(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loantype`
--

CREATE TABLE `loantype` (
  `id` int(10) NOT NULL,
  `loantype` varchar(25) NOT NULL,
  `prefix` varchar(25) NOT NULL,
  `maximumamt` float(10,2) NOT NULL,
  `minimumamt` float(10,2) NOT NULL,
  `interest` float(10,2) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loantype`
--

INSERT INTO `loantype` (`id`, `loantype`, `prefix`, `maximumamt`, `minimumamt`, `interest`, `status`) VALUES
(1, 'Car Loan', 'CL', 5000.00, 500.00, 15.00, 'active'),
(2, 'Home Loan', 'HL', 50000.00, 500.00, 15.00, 'active'),
(3, 'Land Loan', 'LL', 100000.00, 300.00, 15.00, 'active'),
(4, 'Other Loan', 'OL', 7000.00, 5000.00, 15.00, 'active'),
(5, 'Student Loan', 'SL', 75000.00, 1000.00, 15.00, 'active'),
(6, 'Travel Loan', 'TL', 70000.00, 1000.00, 15.00, 'active'),
(7, 'Family Loan', 'FL', 5000.00, 200.00, 15.00, 'active'),
(8, 'Family Loan', '0845', 5000.00, 200.00, 15.00, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(47, '2014_10_12_000000_create_users_table', 1),
(48, '2014_10_12_100000_create_password_resets_table', 1),
(49, '2019_08_19_000000_create_failed_jobs_table', 1),
(50, '2019_10_13_050324_create_customers_table', 1),
(51, '2019_10_13_051252_create_accounts_table', 1),
(52, '2020_05_21_023445_create_wallets_table', 1),
(53, '2020_05_21_164222_create_cards_table', 1),
(54, '2020_05_23_092956_create_transactions_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway`
--

CREATE TABLE `payment_gateway` (
  `id` int(6) NOT NULL,
  `name` varchar(33) NOT NULL,
  `gateway_name` varchar(22) NOT NULL,
  `public_key` text NOT NULL,
  `secret_key` text NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_gateway`
--

INSERT INTO `payment_gateway` (`id`, `name`, `gateway_name`, `public_key`, `secret_key`, `status`) VALUES
(1, 'Paystack', 'Paystack', 'pk_test_3d7d68b858226fd9cbb224aedf329ae559e9ce7c', 'sk_test_097063091bda81d95d02b647e0a3d325e2d62278', 0),
(2, 'Rave', 'Rave', 'FLWPUBK_TEST-a796bd59a7dff674a77e1a033e83d608-X', 'FLWSECK_TEST-8d90633c741abb8ddbbfd8a22c23d498-X', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(10) NOT NULL,
  `bank_name` varchar(22) NOT NULL,
  `currency` varchar(22) NOT NULL,
  `email` varchar(22) NOT NULL,
  `phone` varchar(22) NOT NULL,
  `theme_color` varchar(55) NOT NULL,
  `status` int(22) NOT NULL,
  `bank_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `bank_name`, `currency`, `email`, `phone`, `theme_color`, `status`, `bank_id`) VALUES
(1, 'Settings Banking', 'NGN', 'khaytech@khaytech.com', '+2348120960876', 'light-style-navyblue.min.css', 1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `color` varchar(33) NOT NULL,
  `code` varchar(44) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `color`, `code`) VALUES
(1, 'Purple', 'light-style-1.min.css'),
(2, 'Light blue', 'light-style-blue.min.css'),
(3, 'Navy Blue', 'light-style-navyblue.min.css'),
(4, 'Pink', 'light-style-pink.min.css'),
(5, 'Green', 'light-style-green.min.css'),
(6, 'Red', 'light-style-red.min.css');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customerid` bigint(20) NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `accountNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customerid`, `type`, `amount`, `accountNumber`, `bank`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 7965, 'debit', 3.00, '9734', 'Indiana', 'Magnam ut iure vero laudantium amet quibusdam voluptatem tempora.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(2, 4696, 'debit', 6.00, '8751', 'South Carolina', 'Magni impedit consequuntur asperiores minima est.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(3, 4696, 'debit', 6.00, '6686', 'Tennessee', 'Doloribus et architecto ipsa in.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(4, 7965, 'credit', 3.00, '1468', 'Michigan', 'Fuga quibusdam sit aut vel.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(5, 4696, 'debit', 7.00, '3023', 'Illinois', 'Perferendis recusandae corporis laboriosam consequatur.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(6, 7965, 'debit', 5.00, '6233', 'New Hampshire', 'In debitis consequatur natus libero et reprehenderit ipsam.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(7, 8, 'debit', 2.00, '8096', 'Idaho', 'Quia voluptas et facilis illo accusantium qui itaque.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(8, 7965, 'credit', 2.00, '7827', 'Arkansas', 'Dolor necessitatibus amet sint delectus.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(9, 4, 'debit', 9.00, '3360', 'Florida', 'Molestias sed voluptatem consectetur aut.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(10, 4696, 'credit', 2.00, '4313', 'District of Columbia', 'At suscipit vero distinctio.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(11, 7965, 'credit', 5.00, '7997', 'North Dakota', 'Consectetur tenetur accusamus placeat commodi molestias voluptatibus dolorem qui.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(12, 4696, 'credit', 7.00, '769', 'Michigan', 'Quas adipisci est ratione ad.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(13, 7, 'debit', 7.00, '7395', 'North Carolina', 'In sed pariatur qui deleniti.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(14, 6, 'debit', 9.00, '6775', 'West Virginia', 'Est esse earum natus excepturi et.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(15, 4696, 'crdit', 2.00, '4137', 'Maine', 'Nihil quo aspernatur mollitia et molestiae esse harum.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(16, 6, 'debit', 3.00, '9432', 'Pennsylvania', 'Atque neque dolores occaecati facere suscipit voluptatem molestiae molestiae.', '2020-05-23 09:37:01', '2020-05-23 09:37:01'),
(17, 6, 'debit', 4.00, '9985', 'Ohio', 'Quos dignissimos est omnis veniam.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(18, 8, 'debit', 1.00, '2253', 'Michigan', 'Repellendus sint minima molestias iure.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(19, 5, 'debit', 3.00, '4103', 'Alaska', 'Non suscipit hic possimus itaque.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(20, 1, 'debit', 5.00, '4496', 'Tennessee', 'A delectus facilis quo voluptas.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(21, 6, 'debit', 4.00, '5279', 'Kentucky', 'Quo rerum quo quas consectetur distinctio quis.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(22, 1, 'debit', 7.00, '4729', 'Florida', 'Repudiandae in sed quia officiis voluptas.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(23, 4696, 'debit', 8.00, '7248', 'Ohio', 'Nemo voluptates explicabo cum.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(24, 6, 'debit', 7.00, '5398', 'Delaware', 'Rerum dicta aperiam est.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(25, 4696, 'debit', 2.00, '9586', 'Nebraska', 'Et voluptas illum facilis et necessitatibus beatae.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(26, 3, 'debit', 5.00, '7039', 'Illinois', 'Voluptate voluptatibus nam consequatur labore.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(27, 2, 'debit', 6.00, '9248', 'Georgia', 'Consequuntur est voluptas rerum.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(28, 6, 'debit', 2.00, '6334', 'Virginia', 'Similique blanditiis et sunt inventore voluptatem ut.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(29, 8, 'debit', 1.00, '4017', 'North Dakota', 'Nostrum odit voluptatem omnis in.', '2020-05-23 09:37:02', '2020-05-23 09:37:02'),
(30, 1, 'debit', 9.00, '4256', 'Louisiana', 'Quia similique inventore et incidunt magni molestiae.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(31, 1, 'debit', 6.00, '7535', 'Connecticut', 'Aliquam veritatis atque nostrum quo explicabo in sequi modi.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(32, 4, 'debit', 9.00, '824', 'California', 'Est asperiores sunt dolor eos quia ducimus voluptatem voluptatem.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(33, 1, 'debit', 5.00, '2108', 'Arkansas', 'Sint a aut quis labore in.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(34, 2, 'debit', 9.00, '8783', 'Kansas', 'Delectus rerum omnis perferendis laboriosam.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(35, 6, 'debit', 4.00, '9480', 'Hawaii', 'Et deleniti repellendus perferendis.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(36, 3, 'debit', 6.00, '893', 'Wisconsin', 'Non in est perferendis.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(37, 8, 'debit', 8.00, '4065', 'Montana', 'Quo architecto odio veritatis ipsum dolor saepe.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(38, 2, 'debit', 5.00, '2330', 'Maryland', 'Odit debitis magni eaque cupiditate quaerat.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(39, 3, 'debit', 5.00, '2758', 'Kansas', 'Voluptas qui quaerat sit quis optio quibusdam sed.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(40, 7, 'debit', 6.00, '8246', 'Alaska', 'Veritatis esse aut est ratione rem.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(41, 1, 'debit', 7.00, '1264', 'Maine', 'Quo voluptatem magnam distinctio dolorem facilis ex veritatis.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(42, 3, 'debit', 2.00, '6767', 'Pennsylvania', 'Earum et neque est in voluptatem voluptas magnam.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(43, 2, 'debit', 2.00, '5647', 'Indiana', 'Corporis dolorem et labore eos aut.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(44, 2, 'debit', 1.00, '9718', 'Colorado', 'Neque praesentium voluptatem quia voluptatem.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(45, 9, 'debit', 5.00, '146', 'South Carolina', 'Odit quidem id maxime tenetur quisquam voluptatem.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(46, 7, 'debit', 6.00, '7583', 'Colorado', 'Rerum omnis explicabo porro quo quaerat quia perferendis aut.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(47, 8, 'debit', 9.00, '8321', 'Alaska', 'Consequatur labore inventore veritatis et harum labore quia.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(48, 1, 'debit', 9.00, '4939', 'Washington', 'Architecto occaecati et quaerat optio tenetur quas hic.', '2020-05-23 09:37:03', '2020-05-23 09:37:03'),
(49, 1, 'debit', 1.00, '6515', 'Colorado', 'Autem qui harum in.', '2020-05-23 09:37:04', '2020-05-23 09:37:04'),
(50, 3, 'debit', 2.00, '6870', 'Alaska', 'Perferendis inventore consectetur beatae.', '2020-05-23 09:37:04', '2020-05-23 09:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `usdaccounts`
--

CREATE TABLE `usdaccounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accstatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountbalance` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usdaccounts`
--

INSERT INTO `usdaccounts` (`id`, `accno`, `customerid`, `accstatus`, `accountbalance`, `created_at`, `updated_at`) VALUES
(1, '1234567890', '8760', 'InActive', 0.00, NULL, NULL),
(2, '1234567890', '8228', 'InActive', 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customerid` bigint(20) NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionPIN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_permission` tinyint(4) DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `customerid`, `username`, `name`, `avatar`, `email`, `email_verified_at`, `password`, `transactionPIN`, `is_permission`, `ip_address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 7965, NULL, 'Kenneth Akpan', NULL, 'kennyg50@email.com', NULL, '$2y$10$emeuXI0s2v6NjtmvoaA7m.hUYwNlcBjbwyvJ4eOzFMK.POstVa4fC', '$2y$10$fzlY5IVXvRTFyTOMYipAQeig2fYonekcX.mQS5amslMFFDh5QsHOS', 3, '127.0.0.1', NULL, '2020-05-23 04:36:43', '2020-05-23 04:36:43'),
(2, 4696, NULL, 'Mary Akpan', NULL, 'kennygendowed@email.com', '2020-05-23 09:49:11', '$2y$10$TdmL8VTYxkK3lJ16gISV7.Qz.sVAlfXnb4aCfjEGkl6.ReU/hfqy2', '$2y$10$8URl0OiQ6raF2GwonzjiROAmFqfJhkx19XXh0SN6yg0OmkCx7IGy6', 3, '127.0.0.1', NULL, '2020-05-23 04:37:27', '2020-05-23 09:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customerid` bigint(20) NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inflow` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outflow` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `customerid`, `type`, `balance`, `inflow`, `outflow`, `created_at`, `updated_at`) VALUES
(1, 7965, 'naira', '0', '0', '0', '2020-05-23 04:36:43', '2020-05-23 04:36:43'),
(2, 7965, 'usd', '0', '0', '0', '2020-05-23 04:36:43', '2020-05-23 04:36:43'),
(3, 7965, 'loan', '0', '0', '0', '2020-05-23 04:36:43', '2020-05-23 04:36:43'),
(4, 4696, 'naira', '0', '0', '0', '2020-05-23 04:37:27', '2020-05-23 04:37:27'),
(5, 4696, 'usd', '0', '0', '0', '2020-05-23 04:37:27', '2020-05-23 04:37:27'),
(6, 4696, 'loan', '0', '0', '0', '2020-05-23 04:37:27', '2020-05-23 04:37:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountmaster`
--
ALTER TABLE `accountmaster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cards_number_unique` (`number`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanpayment`
--
ALTER TABLE `loanpayment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loantype`
--
ALTER TABLE `loantype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_gateway`
--
ALTER TABLE `payment_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usdaccounts`
--
ALTER TABLE `usdaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountmaster`
--
ALTER TABLE `accountmaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `duration`
--
ALTER TABLE `duration`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loanpayment`
--
ALTER TABLE `loanpayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loantype`
--
ALTER TABLE `loantype`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `payment_gateway`
--
ALTER TABLE `payment_gateway`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `usdaccounts`
--
ALTER TABLE `usdaccounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
