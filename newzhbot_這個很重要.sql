-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2019-10-05 10:01:57
-- 伺服器版本: 10.1.37-MariaDB
-- PHP 版本： 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `newzhbot`
--

-- --------------------------------------------------------

--
-- 資料表結構 `beta`
--

CREATE TABLE `beta` (
  `ID` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  `ProductName` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Company` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Material1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Electric1` float DEFAULT NULL,
  `Process1_1` float DEFAULT NULL,
  `Process1_2` float DEFAULT NULL,
  `Mileage1` float DEFAULT NULL,
  `Gasoline1` float DEFAULT NULL,
  `Material2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Electric2` float DEFAULT NULL,
  `Process2_1` float DEFAULT NULL,
  `Process2_2` float DEFAULT NULL,
  `Mileage2` float DEFAULT NULL,
  `Gasoline2` float DEFAULT NULL,
  `Mweight1` float DEFAULT NULL,
  `Mweight2` float DEFAULT NULL,
  `MElec` float DEFAULT NULL,
  `MWeight` float DEFAULT NULL,
  `Expiration` int(11) DEFAULT NULL,
  `Bamboo` float DEFAULT NULL,
  `value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `beta`
--

INSERT INTO `beta` (`ID`, `PID`, `ProductName`, `Company`, `Material1`, `Electric1`, `Process1_1`, `Process1_2`, `Mileage1`, `Gasoline1`, `Material2`, `Electric2`, `Process2_1`, `Process2_2`, `Mileage2`, `Gasoline2`, `Mweight1`, `Mweight2`, `MElec`, `MWeight`, `Expiration`, `Bamboo`, `value`) VALUES
(1, 1, 'ç«¹ç‚­æ¯\n', 'leaflu', 'ç«¹å­\n', 3, 5, 7, 20, 18, 'æœ¨é ­\n', 4, 6, 8, 30, 18, 2, 1, 5, 3, 6, 2, 29.82),
(2, 2, 'ç«¹ç‚­æ‰‹å·¥çš‚\n', 'leaflu', 'ç«¹å­\n', 3, 5, 7, 20, 18, 'æ²¹\n', 5, 10, 12, 5, 18, 3, 1, 10, 4, 3, 3, 213.2),
(3, 3, 'ç«¹ç‚­èŒ¶å…·çµ„\n', 'leaflu', 'ç«¹å­\n', 3, 5, 7, 20, 18, 'æœ¨é ­\n', 4, 6, 8, 50, 18, 5, 4, 20, 10, 20, 5, -2596.6),
(4, 4, 'ç«¹æ‰‡å­\n', 'leaflu', 'ç«¹å­\n', 3, 5, 7, 20, 18, 'ç´™\n', 3, 5, 7, 10, 18, 2, 1, 10, 2, 10, 2, -64.2),
(5, 5, 'ä¿é’ç«¹é¤å…·çµ„\n', 'leaflu', 'ç«¹å­\n', 3, 5, 7, 20, 18, 'æœ¨é ­\n', 4, 6, 8, 20, 18, 2, 1, 20, 3, 10, 2, -49.92),
(6, 6, 'ç«¹ç‚­ç‰‡\n', 'leaflu', 'ç«¹å­\n', 3, 5, 7, 20, 18, 'æœ¨é ­\n', 4, 6, 8, 20, 18, 5, 1, 20, 5, 5, 5, 88.3),
(7, 2, 'ç«¹ç‚­æ‰‹å·¥çš‚\n', 'leaflu', '1\n', 5, 5, 5, 10, 18, '23\n', 2, 2, 2, 22, 22, 1, 1, 10, 12, 5, 1, 166.32),
(8, 7, 'ç«¹ç‚­æ‰‹å·¥çš‚2\n', 'leaflu', '1\n', 1, 1, 1, 1, 1, '1\n', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2.62),
(9, 7, 'ç«¹ç‚­æ‰‹å·¥çš‚2\n', 'leaflu', '1\n', 1, 1, 1, 1, 1, '1\n', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2.62),
(10, 8, 'ZAP\n', 'ZAP', 'ZAP\n', 0, 0, 0, 0, 0, 'ZAP\n', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 9, 'å°ç«¹åŒå­¸\n', 'leaflu', 'ç«¹\n', 1, 5, 10, 30, 5, 'æœ¨\n', 6, 4, 5, 26, 10, 5, 6, 12, 30, 5, 21, -8035.2);

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CardID` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ether` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HDC` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `member`
--

INSERT INTO `member` (`ID`, `name`, `CardID`, `Ether`, `HDC`) VALUES
(1, 'zhbot', '111', '0xf4d80E82C4E3f44B71099e9C087a0Cd8Cd746B8f', 0),
(2, 'hedai', '123', '0xAcF639524F8DaC9e4D90F430C0baeBAa936fBD76', 0),
(3, 'leaflu', '124', '0x99B28A8ecb85eb6DEA3692F4601Bfb84F1506db1', 0),
(4, 'samuel', '135', '0x282BA262A8d9452F55c8c7373486920Aa9ff90f2', 0),
(5, 'desmond', '136', '0x47d0fbDB0BE519A540556060195AfC9092031F1e', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `preprocess`
--

CREATE TABLE `preprocess` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Information` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `Tag` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PictureName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ReduceC` float DEFAULT NULL,
  `FolderName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tx` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `checks` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `preprocess`
--

INSERT INTO `preprocess` (`ID`, `Name`, `Price`, `Quantity`, `Information`, `Weight`, `Tag`, `PictureName`, `ReduceC`, `FolderName`, `Company`, `tx`, `checks`) VALUES
(1, 'ç«¹ç‚­æ¯\n', 400, 87, 'é’ç«¹ç«¹ç‚­æ¯ï¼Œ åš´é¸å°ç£é«˜å±±å­Ÿå®—ç«¹ï¼Œ ç¶“é«˜ç§‘æŠ€çª¯ç‡’æ·¬éŠï¼Œ å…¶è‰²é»‘è³½çƒæ¼†ï¼Œå…§å¤–å¹³æ»‘å…‰äº®ä¼¼é¡ï¼Œ ç”¨å…¶æ–Ÿé…’ï¼Œé…’å‘³èŠ³é†‡ï¼Œ ä»¥å…¶å“èŒ¶ï¼ŒèŒ¶é¦™ç”˜ç¾Žï¼Œ ä½¿å…¶é£²æ°', 400, 'ç«¹ ç‚­ æ¯\n', 'bamboo_charcoal_cup.png\n', 17600, '2019-01-20-20-47-25\r\n', 'leaflu', '0x9377cb55d18885b8dcaadbb114f17f95ef6cc541a7a07878efa09270e4072eb1', 1),
(2, 'ç«¹ç‚­æ‰‹å·¥çš‚\n', 200, 98, 'ç«¹ç‚­æ‰‹å·¥çš‚ï¼Œæ˜¯æ‰‹å·¥çš‚çš„ä¸€å€‹åˆ†é¡žç”¢å“ï¼Œæ˜¯â€‹â€‹åŸºæ–¼æ‰‹å·¥çš‚é‡€é€ åŸºç¤Žåšå‡ºçš„é…æ–¹æ”¹â€‹â€‹é©ï¼Œä¸»è¦æˆåˆ†ç«¹ç‚­ç²‰ï¼Œç”˜æ²¹ï¼Œæ©„æ¬–æ²¹ï¼Œç”œæä»æ²¹ï¼Œæ£•æ«šæ²¹ï¼Œå¤©ç„¶æ¤', 150, 'ç«¹ ç‚­ æ‰‹ å·¥ çš‚\n', 'bamboo_charcoal_handmade_soap.png\n', 6600, '2019-01-20-20-50-11\r\n', 'leaflu', '0xdd802d5d7c1d3b3c1bbb5e856c8898522b061d9accf56b89e00aadab5f03600d', 1),
(3, 'ç«¹ç‚­èŒ¶å…·çµ„\n', 600, 49, 'ä¸€å£ºäºŒæ¯èŒ¶å…·çµ„é™„ç«¹èŒ¶ç›¤ æ±æ–¹ç¦ªé¢¨èŒ¶å…·ï¼Œæ­é…ç«¹è£½èŒ¶ç›¤ æ–¹ä¾¿åˆå¯¦ç”¨ è®“äº«å—æ³¡èŒ¶çš„å¿ƒæƒ…æ›´ç¾Žéº—\n', 1000, 'ç«¹ ç‚­ èŒ¶ å…· çµ„\n', 'tea_bowl_group.png', 22000, '2019-01-20-20-53-11\r\n', 'leaflu', '0x8d0b9a75d9121a72a4eccf7b8dcf4d879cb8778fbfa76f6ffbff8d6aec332823', 1),
(4, 'ç«¹æ‰‡å­\n', 400, 99, 'ä¸­åœ‹é¢¨é¤ç©ºé›•åˆ»æ‰‹å·¥å¥³å£«æŠ˜æ‰‡æ—¥ç”¨å¤é¢¨å·¥è—å°æ‰‡å­å…¨ç«¹æ‰‡å¤å…¸ç¦®å“æ‰‡\n', 100, 'ç«¹ æ‰‡ å­\n', 'bamboo_fan.png\n', 4400, '2019-01-20-20-55-01\r\n', 'leaflu', '0xf580d0f33f2b79b77040684794c70acd0428581d4ac3cd4c098fc453d8d2aa66', 1),
(5, 'ä¿é’ç«¹é¤å…·çµ„\n', 300, 96, 'ç«¹å­æœ¬èº«å…·æœ‰ç’°ä¿å†ç”Ÿçš„æ¦‚å¿µã€‚ã€Œä¿é’ç«¹é¤å…·çµ„ã€é‹ç”¨ç«¹çš„åž‹æ…‹èˆ‡ç‰¹æ€§ï¼Œä¿ç•™ç«¹çš®æœ¬èº«çš„é’ç¶ ï¼Œè³¦äºˆä¸è¤ªè‰²çš„åŠ å·¥ï¼Œè¡¨ç¾å‡ºè‡ªç„¶åŽŸç”Ÿçš„æƒ³æ³•ã€‚\n', 300, 'ä¿ é’ ç«¹ é¤ å…· çµ„\n', 'chopsticks.png\n', 13200, '2019-01-20-20-56-23\r\n', 'leaflu', '0x11f2e275865c2186c7b54956a8d298f4ff6a447b700286ab37463e7045e6d891', 1),
(6, 'ç«¹ç‚­ç‰‡\n', 200, 92, 'æ·¨åŒ–ç©ºæ°£ã€æ·¨åŒ–æ°´è³ªã€é‡‹æ”¾é ç´…å¤–ç·šã€è² é›¢å­ã€é˜»æ–·é›»ç£æ³¢ã€æ”¹å–„åœŸå£¤ã€é™¤æ¿•å¸è‡­ã€å¯æ”¾é€²ç±³ç¼¸é˜²èŸ²ä¿é®®ï¼ŒåŽ»é™¤ç”²è‹¯ã€é¦™è•‰æ°´ç­‰å·¥æ¥­ç”¨æº¶åŠ‘æ°£å‘³ï¼Œå›žå¾©æ¸', 500, 'ç«¹ ç‚­ ç‰‡\n', 'pieceofbamboo.png\n', 22000, '2019-01-20-20-57-35\r\n', 'leaflu', '0x320c0a1bc15a7bb705e8e86809df86f6b82385fdb619aca16af74da7095600f8', 1),
(7, 'ç«¹ç‚­æ‰‹å·¥çš‚2\n', 100, 1, '1\n', 10, '1\n', 'bamboo_charcoal_handmade_soap.png\n', 4.4, '2019-06-11-11-01-40\n', 'leaflu', '0x44e65a3ea74f539e35c0460aa6c6a9a1da4081525c7f378187380a4018131b8e', 1),
(8, 'ZAP\n', 0, 1, 'ZAP\n', 0, 'ZAP\n', '\n', 0, '2019-06-14-10-52-20\n', 'ZAP', NULL, 0),
(9, 'å°ç«¹åŒå­¸\n', 81000, 1, 'å°ç«¹åŒå­¸ è³‡ç®¡ç³»å°ˆé¡Œ\n', 1000, 'å°ˆé¡Œ ç«¹ è³‡ç®¡\n', '~æŠ€è¡“è«®è©¢ä¸­å¿ƒ.png\n', 440, '2019-06-27-12-27-14\n', 'leaflu', NULL, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Information` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `Tag` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PictureName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ReduceC` float DEFAULT NULL,
  `FolderName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tx` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `profile`
--

CREATE TABLE `profile` (
  `ID` int(11) NOT NULL,
  `Company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Material` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `Contract` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `profile`
--

INSERT INTO `profile` (`ID`, `Company`, `ProductName`, `Quantity`, `Material`, `Weight`, `Contract`, `Image`, `Date`) VALUES
(1, 'samuel', 'å¡‘è† æ¯', 100, 'pvc', 100, '0x0e9b5279046448c55f88193c338cf3d9b98848ed5f76d6d2be1d5134511c428e', 'product3.jpg', '2019-05-14 08:29:02'),
(2, 'samuel', 'æœ¨å¸ç®¡', 1, 'wood', 50, '0xb29dddf9ffe76f3f041c1f457c99b0f00f47e291f339d726b8986cb408de88ca', '', '2019-06-10 16:32:35'),
(3, '', 'ZAP', 1, 'bamboo', 0, '', '', '2019-06-15 07:20:08'),
(4, '', 'ZAP', 1, 'bamboo', 0, '', '', '2019-06-15 07:20:08'),
(5, '', 'ZAP', 1, 'bamboo', 0, '', '', '2019-06-15 07:20:08'),
(6, '', 'ZAP', 1, 'bamboo', 0, '', '', '2019-06-15 07:20:11'),
(7, '', 'ZAP', 1, 'bamboo', 0, '', '', '2019-06-15 07:20:11'),
(8, '', 'ZAP', 1, 'bamboo', 0, '', '', '2019-06-15 07:20:11');

-- --------------------------------------------------------

--
-- 資料表結構 `profile_backup`
--

CREATE TABLE `profile_backup` (
  `ID` int(11) NOT NULL,
  `Company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Material` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `Contract` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `profile_backup`
--

INSERT INTO `profile_backup` (`ID`, `Company`, `ProductName`, `Quantity`, `Material`, `Weight`, `Contract`, `Image`, `Date`) VALUES
(2, 'leaflu', 'leaflu', 1, 'bamboo', 123, '0x282BA262A8d9452F55c8c7373486920Aa9ff90f2', '1010152_913705305313905_769581291051537142_n.jpg', '2019-05-13 20:35:56'),
(3, 'samuel', 'samuel-p-name-3', 100, 'bamboo', 10, '0x9667e9e2c523c29896aa1baadbde5d29de35ce1ca0f7052a188205a0b970c5d1', 'product2.jpg', '2019-05-13 21:46:02'),
(4, 'samuel', 'samuel-p-name-66666', 100, 'steel', 20, '0x9ff343304166ff687a610564399457070113c5e310e95097c41dfc9be73f19e8', 'product2.jpg', '2019-05-13 21:48:33'),
(5, 'samuel', 'samuel-p-name-66666', 100, 'steel', 20, '', 'product2.jpg', '2019-05-13 23:04:30'),
(6, 'samuel', 'samuel-p-name-66666', 100, 'steel', 20, '', 'product2.jpg', '2019-05-13 23:06:09');

-- --------------------------------------------------------

--
-- 資料表結構 `record`
--

CREATE TABLE `record` (
  `ID` int(11) NOT NULL,
  `CardID` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `Company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tx` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `record`
--

INSERT INTO `record` (`ID`, `CardID`, `ProductID`, `Price`, `Quantity`, `Time`, `Company`, `tx`, `Status`) VALUES
(1, '135', 1, 400, 1, '2019-01-23 12:34:56', 'leaflu', '0xb700d164dd10686b770cdaff94a1f15d053ff5bf92930b6d2e2cfd14e7bd36db', 1),
(2, '135', 2, 200, 2, '2019-02-12 14:02:27', 'leaflu', '0xa4d6d2897da4fa7f9ad63b52afd9960dcac2d51aefcd7a937fc21404e75e2745', 1),
(3, '135', 3, 600, 1, '2019-03-10 10:33:12', 'leaflu', '0x14199c3bc879e9536f727d61ae8ddfa31fc23c760847749936ea4ac833b5b755', 1),
(4, '135', 4, 400, 1, '2019-03-10 10:42:56', 'leaflu', '0xd7857ce1a84d70c8a2a551706886ffeb8b4a6629dea2043dda0c2266c67a5722', 1),
(5, '135', 5, 300, 4, '2019-04-03 16:03:10', 'leaflu', '0x639d6862ce7069ee82b4c8fa76a3926c76dc5afd392f93bf5a8dd0921efaffe5', 1),
(6, '135', 6, 200, 4, '2019-05-09 10:26:00', 'leaflu', '0xdc30256b0088759328c55adbeb47d7f16eab66d0dc31d838d63ae3c061484744', 1),
(7, '135', 1, 400, 1, '2019-05-29 12:03:16', 'leaflu', '0x9cad88b9d48eca50ef811576a3e9774413428966ece586e6386c208cc2159897', 1),
(8, '135', 6, 200, 4, '2019-06-01 17:13:58', 'leaflu', '0xdde9d529495e80fac0f1bbb80243af1400987490ef35b7c377d9cd4b2ec9a94c', 1),
(9, '135', 1, 400, 10, '2019-06-11 11:04:29', 'leaflu', '0x5a7ec5200b4ff81890f21f2859b10c5d1fba8c5cdf47cb89c0ea469e1acfeb41', 1),
(10, '135', 1, 400, 1, '2019-06-20 14:36:05', 'leaflu', '0x57d5e80fbf8e67d632db9cbfd271e8387d947f5a1c0a51f6b18d1f967302d1bc', 1);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `beta`
--
ALTER TABLE `beta`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `preprocess`
--
ALTER TABLE `preprocess`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `profile_backup`
--
ALTER TABLE `profile_backup`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`ID`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `beta`
--
ALTER TABLE `beta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表 AUTO_INCREMENT `preprocess`
--
ALTER TABLE `preprocess`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表 AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表 AUTO_INCREMENT `profile`
--
ALTER TABLE `profile`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表 AUTO_INCREMENT `profile_backup`
--
ALTER TABLE `profile_backup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表 AUTO_INCREMENT `record`
--
ALTER TABLE `record`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
