-- phpMyAdmin SQL Dump
-- version 4.6.6deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Mar 26, 2017 alle 15:29
-- Versione del server: 10.1.21-MariaDB-5+b1
-- Versione PHP: 7.0.16-3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kata`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ability`
--

CREATE TABLE `ability` (
  `katatype` int(10) UNSIGNED NOT NULL,
  `judge` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `country_t`
--

CREATE TABLE `country_t` (
  `country_id` int(5) NOT NULL,
  `iso2` char(2) DEFAULT NULL,
  `ioc` varchar(3) DEFAULT NULL,
  `short_name` varchar(80) NOT NULL DEFAULT '',
  `long_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` varchar(6) DEFAULT NULL,
  `un_member` varchar(12) DEFAULT NULL,
  `calling_code` varchar(8) DEFAULT NULL,
  `cctld` varchar(5) DEFAULT NULL,
  `anthem` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `country_t`
--

INSERT INTO `country_t` (`country_id`, `iso2`, `ioc`, `short_name`, `long_name`, `iso3`, `numcode`, `un_member`, `calling_code`, `cctld`, `anthem`) VALUES
(1, 'AF', NULL, 'Afghanistan', 'Islamic Republic of Afghanistan', 'AFG', '004', 'yes', '93', '.af', 'National_anthem_of_Afghanistan.ogg'),
(2, 'AX', NULL, 'Aland Islands', '&Aring;land Islands', 'ALA', '248', 'no', '358', '.ax', ''),
(3, 'AL', 'ALB', 'Albania', 'Republic of Albania', 'ALB', '008', 'yes', '355', '.al', 'Hymni_i_Flamurit_instrumental.ogg'),
(4, 'DZ', 'ALG', 'Algeria', 'People\'s Democratic Republic of Algeria', 'DZA', '012', 'yes', '213', '.dz', 'Kassaman_instrumental.ogg'),
(5, 'AS', 'ASA', 'American Samoa', 'American Samoa', 'ASM', '016', 'no', '1+684', '.as', ''),
(6, 'AD', 'AND', 'Andorra', 'Principality of Andorra', 'AND', '020', 'yes', '376', '.ad', ''),
(7, 'AO', 'ANG', 'Angola', 'Republic of Angola', 'AGO', '024', 'yes', '244', '.ao', 'Angola_Avante_instrumental.ogg'),
(8, 'AI', NULL, 'Anguilla', 'Anguilla', 'AIA', '660', 'no', '1+264', '.ai', ''),
(9, 'AQ', NULL, 'Antarctica', 'Antarctica', 'ATA', '010', 'no', '672', '.aq', ''),
(10, 'AG', 'ANT', 'Antigua and Barbuda', 'Antigua and Barbuda', 'ATG', '028', 'yes', '1+268', '.ag', 'Fair_Antigua_instrumental.ogg'),
(11, 'AR', 'ARG', 'Argentina', 'Argentine Republic', 'ARG', '032', 'yes', '54', '.ar', 'United_States_Navy_Band_-_Himno_Nacional_Argentino.ogg'),
(12, 'AM', 'ARM', 'Armenia', 'Republic of Armenia', 'ARM', '051', 'yes', '374', '.am', 'Mer_Hayrenik_instrumental.ogg'),
(13, 'AW', 'ARU', 'Aruba', 'Aruba', 'ABW', '533', 'no', '297', '.aw', ''),
(14, 'AU', 'AUS', 'Australia', 'Commonwealth of Australia', 'AUS', '036', 'yes', '61', '.au', 'U.S._Navy_Band,_Advance_Australia_Fair_(instrumental).ogg'),
(15, 'AT', 'AUT', 'Austria', 'Republic of Austria', 'AUT', '040', 'yes', '43', '.at', 'Land_der_Berge_Land_am_Strome_instrumental.ogg'),
(16, 'AZ', 'AZE', 'Azerbaijan', 'Republic of Azerbaijan', 'AZE', '031', 'yes', '994', '.az', 'National_Anthem_of_the_Republic_of_Azerbaijan_instrumental.ogg'),
(17, 'BS', 'BAH', 'Bahamas', 'Commonwealth of The Bahamas', 'BHS', '044', 'yes', '1+242', '.bs', 'March_On_Bahamaland_instrumental.ogg'),
(18, 'BH', 'BRN', 'Bahrain', 'Kingdom of Bahrain', 'BHR', '048', 'yes', '973', '.bh', 'Bahraini_Anthem.ogg'),
(19, 'BD', 'BAN', 'Bangladesh', 'People\'s Republic of Bangladesh', 'BGD', '050', 'yes', '880', '.bd', 'Amar_Shonar_Bangla_instrumental.ogg'),
(20, 'BB', 'BAR', 'Barbados', 'Barbados', 'BRB', '052', 'yes', '1+246', '.bb', 'In_Plenty_and_In_Time_of_Need_instrumental.ogg'),
(21, 'BY', 'BLR', 'Belarus', 'Republic of Belarus', 'BLR', '112', 'yes', '375', '.by', 'My_Belarusy.ogg'),
(22, 'BE', 'BEL', 'Belgium', 'Kingdom of Belgium', 'BEL', '056', 'yes', '32', '.be', 'The_Brabanconne.ogg'),
(23, 'BZ', 'BIZ', 'Belize', 'Belize', 'BLZ', '084', 'yes', '501', '.bz', 'Land_of_the_Free_instrumental.ogg'),
(24, 'BJ', 'BEN', 'Benin', 'Republic of Benin', 'BEN', '204', 'yes', '229', '.bj', 'L\'Aube_Nouvelle.ogg'),
(25, 'BM', 'BER', 'Bermuda', 'Bermuda Islands', 'BMU', '060', 'no', '1+441', '.bm', ''),
(26, 'BT', 'BHU', 'Bhutan', 'Kingdom of Bhutan', 'BTN', '064', 'yes', '975', '.bt', ''),
(27, 'BO', 'BOL', 'Bolivia', 'Plurinational State of Bolivia', 'BOL', '068', 'yes', '591', '.bo', 'Himno_Nacional_de_Bolivia_instrumental.ogg'),
(28, 'BQ', NULL, 'Bonaire, Sint Eustatius and Saba', 'Bonaire, Sint Eustatius and Saba', 'BES', '535', 'no', '599', '.bq', ''),
(29, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'BIH', '070', 'yes', '387', '.ba', 'National_Anthem_of_Bosnia_and_Herzegovina.ogg'),
(30, 'BW', 'BOT', 'Botswana', 'Republic of Botswana', 'BWA', '072', 'yes', '267', '.bw', ''),
(31, 'BV', NULL, 'Bouvet Island', 'Bouvet Island', 'BVT', '074', 'no', 'NONE', '.bv', ''),
(32, 'BR', 'BRA', 'Brazil', 'Federative Republic of Brazil', 'BRA', '076', 'yes', '55', '.br', 'Hino_Nacional_Brasileiro_instrumental.ogg'),
(33, 'IO', NULL, 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IOT', '086', 'no', '246', '.io', ''),
(34, 'BN', 'BRU', 'Brunei', 'Brunei Darussalam', 'BRN', '096', 'yes', '673', '.bn', ''),
(35, 'BG', 'BUL', 'Bulgaria', 'Republic of Bulgaria', 'BGR', '100', 'yes', '359', '.bg', 'Mila_Rodino_instrumental.ogg'),
(36, 'BF', 'BUR', 'Burkina Faso', 'Burkina Faso', 'BFA', '854', 'yes', '226', '.bf', 'United_States_Navy_Band_-_Une_Seule_Nuit.ogg'),
(37, 'BI', 'BDI', 'Burundi', 'Republic of Burundi', 'BDI', '108', 'yes', '257', '.bi', ''),
(38, 'KH', 'CAM', 'Cambodia', 'Kingdom of Cambodia', 'KHM', '116', 'yes', '855', '.kh', 'United_States_Navy_Band_-_Nokoreach.ogg'),
(39, 'CM', 'CMR', 'Cameroon', 'Republic of Cameroon', 'CMR', '120', 'yes', '237', '.cm', 'United_States_Navy_Band_-_Chant_de_Ralliement.ogg'),
(40, 'CA', 'CAN', 'Canada', 'Canada', 'CAN', '124', 'yes', '1', '.ca', 'United_States_Navy_Band_-_O_Canada.ogg'),
(41, 'CV', 'CPV', 'Cape Verde', 'Republic of Cape Verde', 'CPV', '132', 'yes', '238', '.cv', ''),
(42, 'KY', 'CAY', 'Cayman Islands', 'The Cayman Islands', 'CYM', '136', 'no', '1+345', '.ky', ''),
(43, 'CF', 'CAF', 'Central African Republic', 'Central African Republic', 'CAF', '140', 'yes', '236', '.cf', ''),
(44, 'TD', 'CHA', 'Chad', 'Republic of Chad', 'TCD', '148', 'yes', '235', '.td', ''),
(45, 'CL', 'CHI', 'Chile', 'Republic of Chile', 'CHL', '152', 'yes', '56', '.cl', 'National_Anthem_of_Chile.ogg'),
(46, 'CN', 'CHN', 'China', 'People\'s Republic of China', 'CHN', '156', 'yes', '86', '.cn', 'March_of_the_Volunteers_instrumental.ogg'),
(47, 'CX', NULL, 'Christmas Island', 'Christmas Island', 'CXR', '162', 'no', '61', '.cx', ''),
(48, 'CC', NULL, 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CCK', '166', 'no', '61', '.cc', ''),
(49, 'CO', 'COL', 'Colombia', 'Republic of Colombia', 'COL', '170', 'yes', '57', '.co', 'United_States_Navy_Band_-_¡Oh,_gloria_inmarcesible!.ogg'),
(50, 'KM', 'COM', 'Comoros', 'Union of the Comoros', 'COM', '174', 'yes', '269', '.km', ''),
(51, 'CG', 'CGO', 'Congo', 'Republic of the Congo', 'COG', '178', 'yes', '242', '.cg', ''),
(52, 'CK', NULL, 'Cook Islands', 'Cook Islands', 'COK', '184', 'some', '682', '.ck', ''),
(53, 'CR', 'CRC', 'Costa Rica', 'Republic of Costa Rica', 'CRI', '188', 'yes', '506', '.cr', 'Costa_Rica_National_Anthem.ogg'),
(54, 'CI', 'CIV', 'Cote d\'ivoire', 'Republic of C&ocirc;te D\'Ivoire (Ivory Coast)', 'CIV', '384', 'yes', '225', '.ci', ''),
(55, 'HR', 'CRO', 'Croatia', 'Republic of Croatia', 'HRV', '191', 'yes', '385', '.hr', 'Lijepa_nasa_domovino_instrumental.ogg'),
(56, 'CU', 'CUB', 'Cuba', 'Republic of Cuba', 'CUB', '192', 'yes', '53', '.cu', 'United_States_Navy_Band_-_La_Bayamesa.ogg'),
(57, 'CW', NULL, 'Curacao', 'Cura&ccedil;ao', 'CUW', '531', 'no', '599', '.cw', ''),
(58, 'CY', 'CYP', 'Cyprus', 'Republic of Cyprus', 'CYP', '196', 'yes', '357', '.cy', 'Greece_national_anthem.ogg'),
(59, 'CZ', 'CZE', 'Czech Republic', 'Czech Republic', 'CZE', '203', 'yes', '420', '.cz', 'Czech_anthem.ogg'),
(60, 'CD', 'COD', 'Democratic Republic of the Congo', 'Democratic Republic of the Congo', 'COD', '180', 'yes', '243', '.cd', ''),
(61, 'DK', 'DEN', 'Denmark', 'Kingdom of Denmark', 'DNK', '208', 'yes', '45', '.dk', 'Der_er_et_yndigt_land.ogg'),
(62, 'DJ', 'DJI', 'Djibouti', 'Republic of Djibouti', 'DJI', '262', 'yes', '253', '.dj', ''),
(63, 'DM', 'DMA', 'Dominica', 'Commonwealth of Dominica', 'DMA', '212', 'yes', '1+767', '.dm', ''),
(64, 'DO', 'DOM', 'Dominican Republic', 'Dominican Republic', 'DOM', '214', 'yes', '1+809, 8', '.do', 'Dominican_Republic_National_Anthem.ogg'),
(65, 'EC', 'ECU', 'Ecuador', 'Republic of Ecuador', 'ECU', '218', 'yes', '593', '.ec', 'Ecuador.ogg'),
(66, 'EG', 'EGY', 'Egypt', 'Arab Republic of Egypt', 'EGY', '818', 'yes', '20', '.eg', 'Bilady,_Bilady,_Bilady.ogg'),
(67, 'SV', 'ESA', 'El Salvador', 'Republic of El Salvador', 'SLV', '222', 'yes', '503', '.sv', 'El_Salvador_National_Anthem.ogg'),
(68, 'GQ', 'GEQ', 'Equatorial Guinea', 'Republic of Equatorial Guinea', 'GNQ', '226', 'yes', '240', '.gq', ''),
(69, 'ER', 'ERI', 'Eritrea', 'State of Eritrea', 'ERI', '232', 'yes', '291', '.er', ''),
(70, 'EE', 'EST', 'Estonia', 'Republic of Estonia', 'EST', '233', 'yes', '372', '.ee', 'US_Navy_band_-_National_anthem_of_Estonia.ogg'),
(71, 'ET', 'ETH', 'Ethiopia', 'Federal Democratic Republic of Ethiopia', 'ETH', '231', 'yes', '251', '.et', 'Wedefit_Gesgeshi_Widd_Innat_Ittyoppya.ogg'),
(72, 'FK', NULL, 'Falkland Islands (Malvinas)', 'The Falkland Islands (Malvinas)', 'FLK', '238', 'no', '500', '.fk', ''),
(73, 'FO', NULL, 'Faroe Islands', 'The Faroe Islands', 'FRO', '234', 'no', '298', '.fo', ''),
(74, 'FJ', 'FIJ', 'Fiji', 'Republic of Fiji', 'FJI', '242', 'yes', '679', '.fj', 'Fiji_National_Anthem.ogg'),
(75, 'FI', 'FIN', 'Finland', 'Republic of Finland', 'FIN', '246', 'yes', '358', '.fi', 'United_States_Navy_Band_-_Maamme.ogg'),
(76, 'FR', 'FRA', 'France', 'French Republic', 'FRA', '250', 'yes', '33', '.fr', 'La_Marseillaise.ogg'),
(77, 'GF', NULL, 'French Guiana', 'French Guiana', 'GUF', '254', 'no', '594', '.gf', ''),
(78, 'PF', NULL, 'French Polynesia', 'French Polynesia', 'PYF', '258', 'no', '689', '.pf', ''),
(79, 'TF', NULL, 'French Southern Territories', 'French Southern Territories', 'ATF', '260', 'no', NULL, '.tf', ''),
(80, 'GA', 'GAB', 'Gabon', 'Gabonese Republic', 'GAB', '266', 'yes', '241', '.ga', ''),
(81, 'GM', 'GAM', 'Gambia', 'Republic of The Gambia', 'GMB', '270', 'yes', '220', '.gm', ''),
(82, 'GE', 'GEO', 'Georgia', 'Georgia', 'GEO', '268', 'yes', '995', '.ge', 'Tavisupleba_instrumental.ogg'),
(83, 'DE', 'GER', 'Germany', 'Federal Republic of Germany', 'DEU', '276', 'yes', '49', '.de', 'Deutschlandlied_played_by_USAREUR_Band.ogg'),
(84, 'GH', 'GHA', 'Ghana', 'Republic of Ghana', 'GHA', '288', 'yes', '233', '.gh', ''),
(85, 'GI', NULL, 'Gibraltar', 'Gibraltar', 'GIB', '292', 'no', '350', '.gi', ''),
(86, 'GR', 'GRE', 'Greece', 'Hellenic Republic', 'GRC', '300', 'yes', '30', '.gr', 'Greece_national_anthem.ogg'),
(87, 'GL', NULL, 'Greenland', 'Greenland', 'GRL', '304', 'no', '299', '.gl', ''),
(88, 'GD', 'GRN', 'Grenada', 'Grenada', 'GRD', '308', 'yes', '1+473', '.gd', ''),
(89, 'GP', NULL, 'Guadaloupe', 'Guadeloupe', 'GLP', '312', 'no', '590', '.gp', ''),
(90, 'GU', 'GUM', 'Guam', 'Guam', 'GUM', '316', 'no', '1+671', '.gu', ''),
(91, 'GT', 'GUA', 'Guatemala', 'Republic of Guatemala', 'GTM', '320', 'yes', '502', '.gt', ''),
(92, 'GG', NULL, 'Guernsey', 'Guernsey', 'GGY', '831', 'no', '44', '.gg', ''),
(93, 'GN', 'GUI', 'Guinea', 'Republic of Guinea', 'GIN', '324', 'yes', '224', '.gn', ''),
(94, 'GW', 'GBS', 'Guinea-Bissau', 'Republic of Guinea-Bissau', 'GNB', '624', 'yes', '245', '.gw', ''),
(95, 'GY', 'GUY', 'Guyana', 'Co-operative Republic of Guyana', 'GUY', '328', 'yes', '592', '.gy', ''),
(96, 'HT', 'HAI', 'Haiti', 'Republic of Haiti', 'HTI', '332', 'yes', '509', '.ht', 'Haiti_National_Anthem.ogg'),
(97, 'HM', NULL, 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HMD', '334', 'no', 'NONE', '.hm', ''),
(98, 'HN', 'HON', 'Honduras', 'Republic of Honduras', 'HND', '340', 'yes', '504', '.hn', 'Honduras_National_Anthem.ogg'),
(99, 'HK', 'HKG', 'Hong Kong', 'Hong Kong', 'HKG', '344', 'no', '852', '.hk', ''),
(100, 'HU', 'HUN', 'Hungary', 'Hungary', 'HUN', '348', 'yes', '36', '.hu', 'Hu-magyarhimnusz.ogg'),
(101, 'IS', 'ISL', 'Iceland', 'Republic of Iceland', 'ISL', '352', 'yes', '354', '.is', 'Lofsöngur.ogg'),
(102, 'IN', 'IND', 'India', 'Republic of India', 'IND', '356', 'yes', '91', '.in', 'Jana_Gana_Mana_instrumental.ogg'),
(103, 'ID', 'INA', 'Indonesia', 'Republic of Indonesia', 'IDN', '360', 'yes', '62', '.id', 'Indonesiaraya.ogg'),
(104, 'IR', 'IRI', 'Iran', 'Islamic Republic of Iran', 'IRN', '364', 'yes', '98', '.ir', ''),
(105, 'IQ', 'IRQ', 'Iraq', 'Republic of Iraq', 'IRQ', '368', 'yes', '964', '.iq', ''),
(106, 'IE', 'IRL', 'Ireland', 'Ireland', 'IRL', '372', 'yes', '353', '.ie', 'United_States_Navy_Band_-_Amhrán_na_bhFiann.ogg'),
(107, 'IM', NULL, 'Isle of Man', 'Isle of Man', 'IMN', '833', 'no', '44', '.im', ''),
(108, 'IL', 'ISR', 'Israel', 'State of Israel', 'ISR', '376', 'yes', '972', '.il', 'Hatikvah_instrumental.ogg'),
(109, 'IT', 'ITA', 'Italy', 'Italian Republic', 'ITA', '380', 'yes', '39', '.jm', 'Inno_di_Mameli_instrumental.ogg'),
(110, 'JM', 'JAM', 'Jamaica', 'Jamaica', 'JAM', '388', 'yes', '1+876', '.jm', ''),
(111, 'JP', 'JPN', 'Japan', 'Japan', 'JPN', '392', 'yes', '81', '.jp', 'Kimi_ga_Yo_instrumental.ogg'),
(112, 'JE', NULL, 'Jersey', 'The Bailiwick of Jersey', 'JEY', '832', 'no', '44', '.je', ''),
(113, 'JO', 'JOR', 'Jordan', 'Hashemite Kingdom of Jordan', 'JOR', '400', 'yes', '962', '.jo', 'National_anthem_of_Jordan_instrumental.ogg'),
(114, 'KZ', 'KAZ', 'Kazakhstan', 'Republic of Kazakhstan', 'KAZ', '398', 'yes', '7', '.kz', 'Kazakhstan_2006.ogg'),
(115, 'KE', 'KEN', 'Kenya', 'Republic of Kenya', 'KEN', '404', 'yes', '254', '.ke', 'National_Anthem_of_Kenya.ogg'),
(116, 'KI', 'KIR', 'Kiribati', 'Republic of Kiribati', 'KIR', '296', 'yes', '686', '.ki', ''),
(117, 'XK', NULL, 'Kosovo', 'Republic of Kosovo', '---', '---', 'some', '381', '', ''),
(118, 'KW', 'KUW', 'Kuwait', 'State of Kuwait', 'KWT', '414', 'yes', '965', '.kw', ''),
(119, 'KG', 'KGZ', 'Kyrgyzstan', 'Kyrgyz Republic', 'KGZ', '417', 'yes', '996', '.kg', 'National_Anthem_of_Kyrgyzstan.ogg'),
(120, 'LA', 'LAO', 'Laos', 'Lao People\'s Democratic Republic', 'LAO', '418', 'yes', '856', '.la', 'National_Anthem_of_Laos.ogg'),
(121, 'LV', 'LAT', 'Latvia', 'Republic of Latvia', 'LVA', '428', 'yes', '371', '.lv', 'Latvian_National_Anthem_(instrumental).ogg'),
(122, 'LB', 'LIB', 'Lebanon', 'Republic of Lebanon', 'LBN', '422', 'yes', '961', '.lb', 'Lebanese_national_anthem.ogg'),
(123, 'LS', 'LES', 'Lesotho', 'Kingdom of Lesotho', 'LSO', '426', 'yes', '266', '.ls', ''),
(124, 'LR', 'LBR', 'Liberia', 'Republic of Liberia', 'LBR', '430', 'yes', '231', '.lr', 'Liberia_National_Anthem.ogg'),
(125, 'LY', 'LBA', 'Libya', 'Libya', 'LBY', '434', 'yes', '218', '.ly', ''),
(126, 'LI', 'LIE', 'Liechtenstein', 'Principality of Liechtenstein', 'LIE', '438', 'yes', '423', '.li', 'United_States_Navy_Band_-_God_Save_the_Queen.ogg'),
(127, 'LT', 'LTU', 'Lithuania', 'Republic of Lithuania', 'LTU', '440', 'yes', '370', '.lt', 'Tautiška_giesme_instumental.ogg'),
(128, 'LU', 'LUX', 'Luxembourg', 'Grand Duchy of Luxembourg', 'LUX', '442', 'yes', '352', '.lu', 'Luxembourg_National_Anthem.ogg'),
(129, 'MO', NULL, 'Macao', 'The Macao Special Administrative Region', 'MAC', '446', 'no', '853', '.mo', ''),
(130, 'MK', 'MKD', 'Macedonia', 'The Former Yugoslav Republic of Macedonia', 'MKD', '807', 'yes', '389', '.mk', 'Anthem_of_the_Republic_of_Macedonia_(Instrumental).ogg'),
(131, 'MG', 'MAD', 'Madagascar', 'Republic of Madagascar', 'MDG', '450', 'yes', '261', '.mg', ''),
(132, 'MW', 'MAW', 'Malawi', 'Republic of Malawi', 'MWI', '454', 'yes', '265', '.mw', ''),
(133, 'MY', 'MAS', 'Malaysia', 'Malaysia', 'MYS', '458', 'yes', '60', '.my', 'Negaraku_instrumental.ogg'),
(134, 'MV', 'MDV', 'Maldives', 'Republic of Maldives', 'MDV', '462', 'yes', '960', '.mv', ''),
(135, 'ML', 'MLI', 'Mali', 'Republic of Mali', 'MLI', '466', 'yes', '223', '.ml', ''),
(136, 'MT', 'MLT', 'Malta', 'Republic of Malta', 'MLT', '470', 'yes', '356', '.mt', 'Malta_National_Anthem.ogg'),
(137, 'MH', 'MHL', 'Marshall Islands', 'Republic of the Marshall Islands', 'MHL', '584', 'yes', '692', '.mh', ''),
(138, 'MQ', NULL, 'Martinique', 'Martinique', 'MTQ', '474', 'no', '596', '.mq', ''),
(139, 'MR', 'MTN', 'Mauritania', 'Islamic Republic of Mauritania', 'MRT', '478', 'yes', '222', '.mr', ''),
(140, 'MU', 'MRI', 'Mauritius', 'Republic of Mauritius', 'MUS', '480', 'yes', '230', '.mu', 'Mauritius_National_Anthem.ogg'),
(141, 'YT', NULL, 'Mayotte', 'Mayotte', 'MYT', '175', 'no', '262', '.yt', ''),
(142, 'MX', 'MEX', 'Mexico', 'United Mexican States', 'MEX', '484', 'yes', '52', '.mx', 'Himno_Nacional_Mexicano_instrumental.ogg'),
(143, 'FM', NULL, 'Micronesia', 'Federated States of Micronesia', 'FSM', '583', 'yes', '691', '.fm', 'Micronesia_National_Anthem.ogg'),
(144, 'MD', 'MDA', 'Moldova', 'Republic of Moldova', 'MDA', '498', 'yes', '373', '.md', ''),
(145, 'MC', 'MON', 'Monaco', 'Principality of Monaco', 'MCO', '492', 'yes', '377', '.mc', 'Monaco_National_Anthem.ogg'),
(146, 'MN', 'MGL', 'Mongolia', 'Mongolia', 'MNG', '496', 'yes', '976', '.mn', ''),
(147, 'ME', 'MNE', 'Montenegro', 'Montenegro', 'MNE', '499', 'yes', '382', '.me', ''),
(148, 'MS', NULL, 'Montserrat', 'Montserrat', 'MSR', '500', 'no', '1+664', '.ms', ''),
(149, 'MA', 'MAR', 'Morocco', 'Kingdom of Morocco', 'MAR', '504', 'yes', '212', '.ma', 'Anthem_of_Morocco.ogg'),
(150, 'MZ', 'MOZ', 'Mozambique', 'Republic of Mozambique', 'MOZ', '508', 'yes', '258', '.mz', ''),
(151, 'MM', 'MYA', 'Myanmar (Burma)', 'Republic of the Union of Myanmar', 'MMR', '104', 'yes', '95', '.mm', ''),
(152, 'NA', 'NAM', 'Namibia', 'Republic of Namibia', 'NAM', '516', 'yes', '264', '.na', 'National_Anthem_of_Namibia.ogg'),
(153, 'NR', 'NRU', 'Nauru', 'Republic of Nauru', 'NRU', '520', 'yes', '674', '.nr', ''),
(154, 'NP', 'NEP', 'Nepal', 'Federal Democratic Republic of Nepal', 'NPL', '524', 'yes', '977', '.np', ''),
(155, 'NL', 'NED', 'Netherlands', 'Kingdom of the Netherlands', 'NLD', '528', 'yes', '31', '.nl', 'United_States_Navy_Band_-_Het_Wilhelmus.ogg'),
(156, 'NC', NULL, 'New Caledonia', 'New Caledonia', 'NCL', '540', 'no', '687', '.nc', ''),
(157, 'NZ', 'NZL', 'New Zealand', 'New Zealand', 'NZL', '554', 'yes', '64', '.nz', 'God_Defend_New_Zealand_instrumental.ogg'),
(158, 'NI', 'NCA', 'Nicaragua', 'Republic of Nicaragua', 'NIC', '558', 'yes', '505', '.ni', ''),
(159, 'NE', 'NIG', 'Niger', 'Republic of Niger', 'NER', '562', 'yes', '227', '.ne', ''),
(160, 'NG', 'NGR', 'Nigeria', 'Federal Republic of Nigeria', 'NGA', '566', 'yes', '234', '.ng', 'United_States_Navy_Band_-_Arise_O_Compatriots.ogg'),
(161, 'NU', NULL, 'Niue', 'Niue', 'NIU', '570', 'some', '683', '.nu', ''),
(162, 'NF', NULL, 'Norfolk Island', 'Norfolk Island', 'NFK', '574', 'no', '672', '.nf', ''),
(163, 'KP', 'PRK', 'North Korea', 'Democratic People\'s Republic of Korea', 'PRK', '408', 'yes', '850', '.kp', ''),
(164, 'MP', NULL, 'Northern Mariana Islands', 'Northern Mariana Islands', 'MNP', '580', 'no', '1+670', '.mp', ''),
(165, 'NO', 'NOR', 'Norway', 'Kingdom of Norway', 'NOR', '578', 'yes', '47', '.no', 'Norway_(National_Anthem).ogg'),
(166, 'OM', 'OMA', 'Oman', 'Sultanate of Oman', 'OMN', '512', 'yes', '968', '.om', ''),
(167, 'PK', 'PAK', 'Pakistan', 'Islamic Republic of Pakistan', 'PAK', '586', 'yes', '92', '.pk', 'Qaumi_Tarana_Instrumental.ogg'),
(168, 'PW', 'PLW', 'Palau', 'Republic of Palau', 'PLW', '585', 'yes', '680', '.pw', ''),
(169, 'PS', 'PLE', 'Palestine', 'State of Palestine (or Occupied Palestinian Territory)', 'PSE', '275', 'some', '970', '.ps', ''),
(170, 'PA', 'PAN', 'Panama', 'Republic of Panama', 'PAN', '591', 'yes', '507', '.pa', 'Panama_National_Anthem.ogg'),
(171, 'PG', 'PNG', 'Papua New Guinea', 'Independent State of Papua New Guinea', 'PNG', '598', 'yes', '675', '.pg', ''),
(172, 'PY', 'PAR', 'Paraguay', 'Republic of Paraguay', 'PRY', '600', 'yes', '595', '.py', 'Paraguay_National_Anthem.ogg'),
(173, 'PE', 'PER', 'Peru', 'Republic of Peru', 'PER', '604', 'yes', '51', '.pe', 'United_States_Navy_Band_-_Marcha_Nacional_del_Perú.ogg'),
(174, 'PH', 'PHI', 'Phillipines', 'Republic of the Philippines', 'PHL', '608', 'yes', '63', '.ph', 'Lupang_Hinirang_instrumental.ogg'),
(175, 'PN', NULL, 'Pitcairn', 'Pitcairn', 'PCN', '612', 'no', 'NONE', '.pn', ''),
(176, 'PL', 'POL', 'Poland', 'Republic of Poland', 'POL', '616', 'yes', '48', '.pl', 'Mazurek_Dabrowskiego.ogg'),
(177, 'PT', 'POR', 'Portugal', 'Portuguese Republic', 'PRT', '620', 'yes', '351', '.pt', 'A_Portuguesa.ogg'),
(178, 'PR', 'PUR', 'Puerto Rico', 'Commonwealth of Puerto Rico', 'PRI', '630', 'no', '1+939', '.pr', ''),
(179, 'QA', 'QAT', 'Qatar', 'State of Qatar', 'QAT', '634', 'yes', '974', '.qa', ''),
(180, 'RE', NULL, 'Reunion', 'R&eacute;union', 'REU', '638', 'no', '262', '.re', ''),
(181, 'RO', 'ROU', 'Romania', 'Romania', 'ROU', '642', 'yes', '40', '.ro', 'Desteapta-te,_romane!.ogg'),
(182, 'RU', 'RUS', 'Russia', 'Russian Federation', 'RUS', '643', 'yes', '7', '.ru', 'Russian_Anthem_instrumental.ogg'),
(183, 'RW', 'RWA', 'Rwanda', 'Republic of Rwanda', 'RWA', '646', 'yes', '250', '.rw', ''),
(184, 'BL', NULL, 'Saint Barthelemy', 'Saint Barth&eacute;lemy', 'BLM', '652', 'no', '590', '.bl', ''),
(185, 'SH', NULL, 'Saint Helena', 'Saint Helena, Ascension and Tristan da Cunha', 'SHN', '654', 'no', '290', '.sh', ''),
(186, 'KN', 'SKN', 'Saint Kitts and Nevis', 'Federation of Saint Christopher and Nevis', 'KNA', '659', 'yes', '1+869', '.kn', ''),
(187, 'LC', 'LCA', 'Saint Lucia', 'Saint Lucia', 'LCA', '662', 'yes', '1+758', '.lc', ''),
(188, 'MF', NULL, 'Saint Martin', 'Saint Martin', 'MAF', '663', 'no', '590', '.mf', ''),
(189, 'PM', NULL, 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'SPM', '666', 'no', '508', '.pm', ''),
(190, 'VC', 'VIN', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VCT', '670', 'yes', '1+784', '.vc', ''),
(191, 'WS', 'SAM', 'Samoa', 'Independent State of Samoa', 'WSM', '882', 'yes', '685', '.ws', ''),
(192, 'SM', 'SMR', 'San Marino', 'Republic of San Marino', 'SMR', '674', 'yes', '378', '.sm', ''),
(193, 'ST', 'STP', 'Sao Tome and Principe', 'Democratic Republic of S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'STP', '678', 'yes', '239', '.st', ''),
(194, 'SA', 'KSA', 'Saudi Arabia', 'Kingdom of Saudi Arabia', 'SAU', '682', 'yes', '966', '.sa', 'Aash_Al_Maleek_instrumental.ogg'),
(195, 'SN', 'SEN', 'Senegal', 'Republic of Senegal', 'SEN', '686', 'yes', '221', '.sn', ''),
(196, 'RS', 'SRB', 'Serbia', 'Republic of Serbia', 'SRB', '688', 'yes', '381', '.rs', 'Serbian_National_Anthem_instrumental.ogg'),
(197, 'SC', 'SEY', 'Seychelles', 'Republic of Seychelles', 'SYC', '690', 'yes', '248', '.sc', ''),
(198, 'SL', 'SLE', 'Sierra Leone', 'Republic of Sierra Leone', 'SLE', '694', 'yes', '232', '.sl', ''),
(199, 'SG', 'SIN', 'Singapore', 'Republic of Singapore', 'SGP', '702', 'yes', '65', '.sg', ''),
(200, 'SX', NULL, 'Sint Maarten', 'Sint Maarten', 'SXM', '534', 'no', '1+721', '.sx', ''),
(201, 'SK', 'SVK', 'Slovakia', 'Slovak Republic', 'SVK', '703', 'yes', '421', '.sk', 'Slovak_anthem1.ogg'),
(202, 'SI', 'SLO', 'Slovenia', 'Republic of Slovenia', 'SVN', '705', 'yes', '386', '.si', 'Zdravljica.ogg'),
(203, 'SB', 'SOL', 'Solomon Islands', 'Solomon Islands', 'SLB', '090', 'yes', '677', '.sb', ''),
(204, 'SO', 'SOM', 'Somalia', 'Somali Republic', 'SOM', '706', 'yes', '252', '.so', ''),
(205, 'ZA', 'RSA', 'South Africa', 'Republic of South Africa', 'ZAF', '710', 'yes', '27', '.za', 'South_Africa_National_Anthem.ogg'),
(206, 'GS', NULL, 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'SGS', '239', 'no', '500', '.gs', ''),
(207, 'KR', 'KOR', 'South Korea', 'Republic of Korea', 'KOR', '410', 'yes', '82', '.kr', ''),
(208, 'SS', NULL, 'South Sudan', 'Republic of South Sudan', 'SSD', '728', 'yes', '211', '.ss', ''),
(209, 'ES', 'ESP', 'Spain', 'Kingdom of Spain', 'ESP', '724', 'yes', '34', '.es', 'Marcha_Real.ogg'),
(210, 'LK', 'SRI', 'Sri Lanka', 'Democratic Socialist Republic of Sri Lanka', 'LKA', '144', 'yes', '94', '.lk', 'Sri_Lanka_Matha.ogg'),
(211, 'SD', 'SUD', 'Sudan', 'Republic of the Sudan', 'SDN', '729', 'yes', '249', '.sd', ''),
(212, 'SR', 'SUR', 'Suriname', 'Republic of Suriname', 'SUR', '740', 'yes', '597', '.sr', ''),
(213, 'SJ', NULL, 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'SJM', '744', 'no', '47', '.sj', ''),
(214, 'SZ', 'SWZ', 'Swaziland', 'Kingdom of Swaziland', 'SWZ', '748', 'yes', '268', '.sz', ''),
(215, 'SE', 'SWE', 'Sweden', 'Kingdom of Sweden', 'SWE', '752', 'yes', '46', '.se', 'United_States_Navy_Band_-_Sweden.ogg'),
(216, 'CH', 'SUI', 'Switzerland', 'Swiss Confederation', 'CHE', '756', 'yes', '41', '.ch', 'Swiss_Psalm.ogg'),
(217, 'SY', 'SYR', 'Syria', 'Syrian Arab Republic', 'SYR', '760', 'yes', '963', '.sy', ''),
(218, 'TW', 'TPE', 'Taiwan', 'Republic of China (Taiwan)', 'TWN', '158', 'former', '886', '.tw', ''),
(219, 'TJ', 'TJK', 'Tajikistan', 'Republic of Tajikistan', 'TJK', '762', 'yes', '992', '.tj', ''),
(220, 'TZ', 'TAN', 'Tanzania', 'United Republic of Tanzania', 'TZA', '834', 'yes', '255', '.tz', ''),
(221, 'TH', 'THA', 'Thailand', 'Kingdom of Thailand', 'THA', '764', 'yes', '66', '.th', 'Thai_National_Anthem_-_US_Navy_Band.ogg'),
(222, 'TL', 'TLS', 'Timor-Leste (East Timor)', 'Democratic Republic of Timor-Leste', 'TLS', '626', 'yes', '670', '.tl', ''),
(223, 'TG', 'TOG', 'Togo', 'Togolese Republic', 'TGO', '768', 'yes', '228', '.tg', ''),
(224, 'TK', NULL, 'Tokelau', 'Tokelau', 'TKL', '772', 'no', '690', '.tk', ''),
(225, 'TO', 'TGA', 'Tonga', 'Kingdom of Tonga', 'TON', '776', 'yes', '676', '.to', ''),
(226, 'TT', 'TRI', 'Trinidad and Tobago', 'Republic of Trinidad and Tobago', 'TTO', '780', 'yes', '1+868', '.tt', ''),
(227, 'TN', 'TUN', 'Tunisia', 'Republic of Tunisia', 'TUN', '788', 'yes', '216', '.tn', 'United_States_Navy_Band_-_Himat_Al_Hima.ogg'),
(228, 'TR', 'TUR', 'Turkey', 'Republic of Turkey', 'TUR', '792', 'yes', '90', '.tr', 'Istiklâl_Marsi_instrumetal.ogg'),
(229, 'TM', 'TKM', 'Turkmenistan', 'Turkmenistan', 'TKM', '795', 'yes', '993', '.tm', 'US_Navy_Band_-_National_Anthem_of_Turkmenistan.ogg'),
(230, 'TC', NULL, 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TCA', '796', 'no', '1+649', '.tc', ''),
(231, 'TV', 'TUV', 'Tuvalu', 'Tuvalu', 'TUV', '798', 'yes', '688', '.tv', ''),
(232, 'UG', 'UGA', 'Uganda', 'Republic of Uganda', 'UGA', '800', 'yes', '256', '.ug', ''),
(233, 'UA', 'UKR', 'Ukraine', 'Ukraine', 'UKR', '804', 'yes', '380', '.ua', 'Anthem_of_Ukraine_instrumental.ogg'),
(234, 'AE', 'UAE', 'United Arab Emirates', 'United Arab Emirates', 'ARE', '784', 'yes', '971', '.ae', 'National_anthem_of_the_United_Arab_Emirates.ogg'),
(235, 'GB', 'GBR', 'United Kingdom', 'United Kingdom of Great Britain and Nothern Ireland', 'GBR', '826', 'yes', '44', '.uk', 'United_States_Navy_Band_-_God_Save_the_Queen.ogg'),
(236, 'US', 'USA', 'United States', 'United States of America', 'USA', '840', 'yes', '1', '.us', 'Star_Spangled_Banner_instrumental.ogg'),
(237, 'UM', NULL, 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UMI', '581', 'no', 'NONE', 'NONE', ''),
(238, 'UY', 'URU', 'Uruguay', 'Eastern Republic of Uruguay', 'URY', '858', 'yes', '598', '.uy', 'United_States_Navy_Band_-_National_Anthem_of_Uruguay_(complete).ogg'),
(239, 'UZ', 'UZB', 'Uzbekistan', 'Republic of Uzbekistan', 'UZB', '860', 'yes', '998', '.uz', ''),
(240, 'VU', 'VAN', 'Vanuatu', 'Republic of Vanuatu', 'VUT', '548', 'yes', '678', '.vu', 'United_States_Navy_Band_-_Yumi,_Yumi,_Yumi.ogg'),
(241, 'VA', NULL, 'Vatican City', 'State of the Vatican City', 'VAT', '336', 'no', '39', '.va', ''),
(242, 'VE', 'VEN', 'Venezuela', 'Bolivarian Republic of Venezuela', 'VEN', '862', 'yes', '58', '.ve', 'United_States_Navy_Band_-_Gloria_al_Bravo_Pueblo.ogg'),
(243, 'VN', 'VIE', 'Vietnam', 'Socialist Republic of Vietnam', 'VNM', '704', 'yes', '84', '.vn', 'Vietnam.ogg'),
(244, 'VG', 'IVB', 'Virgin Islands, British', 'British Virgin Islands', 'VGB', '092', 'no', '1+284', '.vg', ''),
(245, 'VI', 'ISV', 'Virgin Islands, US', 'Virgin Islands of the United States', 'VIR', '850', 'no', '1+340', '.vi', ''),
(246, 'WF', NULL, 'Wallis and Futuna', 'Wallis and Futuna', 'WLF', '876', 'no', '681', '.wf', ''),
(247, 'EH', NULL, 'Western Sahara', 'Western Sahara', 'ESH', '732', 'no', '212', '.eh', ''),
(248, 'YE', 'YEM', 'Yemen', 'Republic of Yemen', 'YEM', '887', 'yes', '967', '.ye', 'United_States_Navy_Band_-_United_Republic.ogg'),
(249, 'ZM', 'ZAM', 'Zambia', 'Republic of Zambia', 'ZMB', '894', 'yes', '260', '.zm', ''),
(250, 'ZW', 'ZIM', 'Zimbabwe', 'Republic of Zimbabwe', 'ZWE', '716', 'yes', '263', '.zw', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `form`
--

CREATE TABLE `form` (
  `idForm` int(11) UNSIGNED NOT NULL,
  `pair` int(10) UNSIGNED NOT NULL,
  `num` int(11) NOT NULL,
  `p1` char(5) DEFAULT NULL,
  `p2` char(5) DEFAULT NULL,
  `p3` char(5) DEFAULT NULL,
  `p4` char(5) DEFAULT NULL,
  `p5` char(5) DEFAULT NULL,
  `p6` char(5) DEFAULT NULL,
  `p7` char(5) DEFAULT NULL,
  `p8` char(5) DEFAULT NULL,
  `p9` char(5) DEFAULT NULL,
  `p10` char(5) DEFAULT NULL,
  `p11` char(5) DEFAULT NULL,
  `p12` char(5) DEFAULT NULL,
  `p13` char(5) DEFAULT NULL,
  `p14` char(5) DEFAULT NULL,
  `p15` char(5) DEFAULT NULL,
  `p16` char(5) DEFAULT NULL,
  `p17` char(5) DEFAULT NULL,
  `p18` char(5) DEFAULT NULL,
  `p19` char(5) DEFAULT NULL,
  `p20` char(5) DEFAULT NULL,
  `p21` char(5) DEFAULT NULL,
  `p22` char(5) DEFAULT NULL,
  `p23` char(5) DEFAULT NULL,
  `fcr` int(11) DEFAULT NULL,
  `totSmall` int(11) DEFAULT NULL,
  `totMedium` int(11) DEFAULT NULL,
  `totWrong` int(11) DEFAULT NULL,
  `totForgotten` int(11) DEFAULT NULL,
  `tot` int(11) DEFAULT NULL,
  `judge` int(10) UNSIGNED DEFAULT NULL,
  `tablet` int(10) UNSIGNED DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `judge`
--

CREATE TABLE `judge` (
  `idJudge` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `country` varchar(5) DEFAULT NULL,
  `tournament` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `judoka`
--

CREATE TABLE `judoka` (
  `idJudoka` int(10) UNSIGNED NOT NULL,
  `seed` int(11) DEFAULT NULL,
  `namesurname` varchar(128) NOT NULL,
  `country` varchar(5) NOT NULL,
  `enableFlag` int(1) NOT NULL DEFAULT '1',
  `tournament` int(10) UNSIGNED NOT NULL,
  `katatype` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `katatype`
--

CREATE TABLE `katatype` (
  `idKatatype` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `numTechniques` int(11) NOT NULL,
  `t1` varchar(64) NOT NULL,
  `t2` varchar(64) NOT NULL,
  `t3` varchar(64) NOT NULL,
  `t4` varchar(64) NOT NULL,
  `t5` varchar(64) NOT NULL,
  `t6` varchar(64) NOT NULL,
  `t7` varchar(64) NOT NULL,
  `t8` varchar(64) NOT NULL,
  `t9` varchar(64) NOT NULL,
  `t10` varchar(64) NOT NULL,
  `t11` varchar(64) NOT NULL,
  `t12` varchar(64) NOT NULL,
  `t13` varchar(64) NOT NULL,
  `t14` varchar(64) NOT NULL,
  `t15` varchar(64) NOT NULL,
  `t16` varchar(64) NOT NULL,
  `t17` varchar(64) NOT NULL,
  `t18` varchar(64) NOT NULL,
  `t19` varchar(64) NOT NULL,
  `t20` varchar(64) NOT NULL,
  `t21` varchar(64) NOT NULL,
  `t22` varchar(64) NOT NULL,
  `t23` varchar(64) NOT NULL,
  `fcr` varchar(64) NOT NULL,
  `s1` varchar(64) NOT NULL,
  `s2` varchar(64) NOT NULL,
  `s3` varchar(64) NOT NULL,
  `s4` varchar(64) NOT NULL,
  `s5` varchar(64) NOT NULL,
  `s6` varchar(64) NOT NULL,
  `s7` varchar(64) NOT NULL,
  `s8` varchar(64) NOT NULL,
  `s9` varchar(64) NOT NULL,
  `s10` varchar(64) NOT NULL,
  `s11` varchar(64) NOT NULL,
  `s12` varchar(64) NOT NULL,
  `s13` varchar(64) NOT NULL,
  `s14` varchar(64) NOT NULL,
  `s15` varchar(64) NOT NULL,
  `s16` varchar(64) NOT NULL,
  `s17` varchar(64) NOT NULL,
  `s18` varchar(64) NOT NULL,
  `s19` varchar(64) NOT NULL,
  `s20` varchar(64) NOT NULL,
  `s21` varchar(64) NOT NULL,
  `s22` varchar(64) NOT NULL,
  `s23` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `katatype`
--

INSERT INTO `katatype` (`idKatatype`, `name`, `numTechniques`, `t1`, `t2`, `t3`, `t4`, `t5`, `t6`, `t7`, `t8`, `t9`, `t10`, `t11`, `t12`, `t13`, `t14`, `t15`, `t16`, `t17`, `t18`, `t19`, `t20`, `t21`, `t22`, `t23`, `fcr`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `s9`, `s10`, `s11`, `s12`, `s13`, `s14`, `s15`, `s16`, `s17`, `s18`, `s19`, `s20`, `s21`, `s22`, `s23`) VALUES
(1, 'Nage No Kata', 17, 'OPENING CEREMONY', 'UKI OTOSHI', 'SEOI NAGE', 'KATA GURUMA', 'UKI GOSHI', 'HARAI GOSHI', 'TSURIKOMI GOSHI', 'OKURI ASHI HARAI', 'SASAE TSURIKOMI ASHI', 'UCHIMATA', 'TOMOE NAGE', 'URA NAGE', 'SUMI GAESHI', 'YOKOGAKE', 'YOKO GURUMA', 'UKI WAZA', 'CLOSING CEREMONY', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Te-waza', 'Te-waza', 'Te-waza', 'Koshi-waza', 'Koshi-waza', 'Koshi-waza', 'Ashi-waza', 'Ashi-waza', 'Ashi-waza', 'Masutemi-waza', 'Masutemi-waza', 'Masutemi-waza', 'Yokosutemi-waza', 'Yokosutemi-waza', 'Yokosutemi-waza', '', '', '', '', '', '', ''),
(2, 'Katame No Kata', 17, 'OPENING CEREMONY', 'KESA GATAME', 'KATA GATAME', 'KAMI SHIO GATAME', 'YOKO SHIO GATAME', 'KUZURE KAMI SHIO GATAME', 'KATA JUJI JIME', 'HADAKA JIME', 'OKURI ERI JIME', 'KATA HA JIME', 'GYAKU JUJI JIME', 'UDE GARAMI', 'UDEHISHIGI JUJI GATAME', 'UDEHISHIGI UDE GATAME', 'UDEHISHIGI HIZA GATAME', 'ASHI GARAMI', 'CLOSING CEREMONY', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Shime-waza', 'Shime-waza', 'Shime-waza', 'Shime-waza', 'Shime-waza', 'Kansetzu-waza', 'Kansetzu-waza', 'Kansetzu-waza', 'Kansetzu-waza', 'Kansetzu-waza', '', '', '', '', '', '', ''),
(3, 'Kime No Kata', 22, 'OPENING CEREMONY', 'RYOTE DORI', 'TSUKKAKE', 'SURI AGE', 'YOKO UCHI', 'USHIRO DORI', 'TSUKKOMI', 'KIRI KOMI', 'YOKO TSUKI', 'RYOTE DORI_', 'SODE DORI', 'TSUKKAKE_', 'TSUKI AGE', 'SURI AGE_', 'YOKO UCHI_', 'KE AGE', 'USHIRO DORI_', 'TSUKKOMI_', 'KIRI KOMI_', 'NUKI GAKE', 'KIRI OROSHI', 'CLOSING CEREMONY', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Idori - Unarmed', 'Idori - Unarmed', 'Idori - Unarmed', 'Idori - Unarmed', 'Idori - Unarmed', 'Idori - Armed', 'Idori - Armed', 'Idori - Armed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Unarmed', 'Tachiai - Armed', 'Tachiai - Armed', 'Tachiai - Armed', 'Tachiai - Armed', '', ''),
(4, 'Ju No Kata', 17, 'OPENING CEREMONY', 'TSUKI DASHI', 'KATA OSHI', 'RYOTE DORI', 'KATA MAWASHI', 'AGO OSHI', 'KIRI OROSHI', 'RYOKATA OSHI', 'NANAME UCHI', 'KATATE DORI', 'KATATE AGE', 'OBI TORI', 'MUNE OSHI', 'TSUKI AGE', 'UCHI OROSHI', 'RYOGAN TSUKI', 'CLOSING CEREMONY', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Nikyo', 'Nikyo', 'Nikyo', 'Nikyo', 'Nikyo', 'Sankyo', 'Sankyo', 'Sankyo', 'Sankyo', 'Sankyo', '', '', '', '', '', '', ''),
(5, 'Koshiki No Kata', 23, 'OPENING CEREMONY', 'TAI', 'YUME NO UCHI', 'RYOKU HI', 'MIZU GURUMA', 'MIZU NAGARE', 'HIKI OTOSHI', 'KO DAORE', 'UCHI KUDAKI', 'TANI OTOSHI', 'KURUMA DAORE', 'SHIKORO DORI', 'SHIKORO GAESHI', 'YU DASHI', 'TAKI OTOSHI', 'MI KUDAKI', 'KURUMA GAESHI', 'MIZU IRI', 'RYU SETSU', 'SAKA OTOSHI', 'YUKI ORE', 'IWA NAMI', 'CLOSING CEREMONY', 'FLUIDITY, COURSE, RHYTHM', '', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'OMOTE', 'URA', 'URA', 'URA', 'URA', 'URA', 'URA', 'URA', ''),
(6, 'Kodokan Goshin Jutsu', 23, 'OPENING CEREMONY', 'RYOTE DORI', 'HIDARI ERI DORI', 'MIGI ERI DORI', 'KATA UDE DORI', 'USHIRO ERI DORI', 'USHIRO JIME', 'KAKAE DORI', 'NANAME UCHI', 'AGO TSUKI', 'GANMEN TSUKI', 'MAE GERI', 'YOKO GERI', 'TSUKKAKE', 'CHOKU TSUKI', 'NANAME TSUKI', 'FURIAGE', 'FURI OROSHI', 'MOROTE TSUKI', 'SHOMEN TSUKE', 'KOSHI KAMAE', 'HAIMEN TSUKE', 'CLOSING CEREMONY', 'FLUIDITY, COURSE, RHYTHM', '', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Attack Knife', 'Attack Knife', 'Attack Knife', 'Attack Stick', 'Attack Stick', 'Attack Stick', 'Attack Gun', 'Attack Gun', 'Attack Gun', ''),
(7, 'Itsuzu No Kata', 7, 'OPENING CEREMONY', 'IPPONME', 'NIHONME', 'SANBONME', 'YOHONME', 'GOHONME', 'CLOSING CEREMONY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '3Nage No Kata', 11, 'OPENING CEREMONY', 'UKI OTOSHI', 'SEOI NAGE', 'KATA GURUMA', 'UKI GOSHI', 'HARAI GOSHI', 'TSURIKOMI GOSHI', 'OKURI ASHI HARAI', 'SASAE TSURIKOMI ASHI', 'UCHIMATA', 'CLOSING CEREMONY', '', '', '', '', '', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Te-waza', 'Te-waza', 'Te-waza', 'Koshi-waza', 'Koshi-waza', 'Koshi-waza', 'Ashi-waza', 'Ashi-waza', 'Ashi-waza', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '3Katame No Kata', 7, 'OPENING CEREMONY', 'KESA GATAME', 'KATA GATAME', 'KAMI SHIO GATAME', 'YOKO SHIO GATAME', 'KUZURE KAMI SHIO GATAME', 'CLOSING CEREMONY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, '3Kodokan Goshin Jutsu', 14, 'OPENING CEREMONY', 'RYOTE DORI', 'HIDARI ERI DORI', 'MIGI ERI DORI', 'KATA UDE DORI', 'USHIRO ERI DORI', 'USHIRO JIME', 'KAKAE DORI', 'NANAME UCHI', 'AGO TSUKI', 'GANMEN TSUKI', 'MAE GERI', 'YOKO GERI', 'CLOSING CEREMONY', '', '', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed closein attacks by holding', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Unarmed attack at a distance', 'Unarmed attack at a distance', '', '', '', '', '', '', '', '', '', ''),
(11, '3Nage+1Katame', 16, 'OPENING CEREMONY', 'UKI OTOSHI', 'SEOI NAGE', 'KATA GURUMA', 'UKI GOSHI', 'HARAI GOSHI', 'TSURIKOMI GOSHI', 'OKURI ASHI HARAI', 'SASAE TSURIKOMI ASHI', 'UCHIMATA', 'KESA GATAME', 'KATA GATAME', 'KAMI SHIO GATAME', 'YOKO SHIO GATAME', 'KUZURE KAMI SHIO GATAME', 'CLOSING CEREMONY', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Te-waza', 'Te-waza', 'Te-waza', 'Koshi-waza', 'Koshi-waza', 'Koshi-waza', 'Ashi-waza', 'Ashi-waza', 'Ashi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', 'Osae-komi-waza', '', '', '', '', '', '', '', ''),
(12, '3Nage+1Ju', 16, 'OPENING CEREMONY', 'UKI OTOSHI', 'SEOI NAGE', 'KATA GURUMA', 'UKI GOSHI', 'HARAI GOSHI', 'TSURIKOMI GOSHI', 'OKURI ASHI HARAI', 'SASAE TSURIKOMI ASHI', 'UCHIMATA', 'TSUKI DASHI', 'KATA OSHI', 'RYOTE DORI', 'KATA MAWASHI', 'AGO OSHI', 'CLOSING CEREMONY', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Te-waza', 'Te-waza', 'Te-waza', 'Koshi-waza', 'Koshi-waza', 'Koshi-waza', 'Ashi-waza', 'Ashi-waza', 'Ashi-waza', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Ikkyo', '', '', '', '', '', '', '', ''),
(13, '1Ju', 7, 'OPENING CEREMONY', 'TSUKI DASHI', 'KATA OSHI', 'RYOTE DORI', 'KATA MAWASHI', 'AGO OSHI', 'CLOSING CEREMONY', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'FLUIDITY, COURSE, RHYTHM', '', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Ikkyo', 'Ikkyo', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `log`
--

CREATE TABLE `log` (
  `idLog` int(10) UNSIGNED NOT NULL,
  `score` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `technique` int(11) NOT NULL,
  `mac` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `form` int(10) UNSIGNED NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `position` varchar(2) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `pair`
--

CREATE TABLE `pair` (
  `idPair` int(10) UNSIGNED NOT NULL,
  `judoka` int(10) UNSIGNED NOT NULL,
  `numOrder` int(11) NOT NULL,
  `score1` int(11) DEFAULT NULL,
  `score2` int(11) DEFAULT NULL,
  `score3` int(11) DEFAULT NULL,
  `score4` int(11) DEFAULT NULL,
  `score5` int(11) DEFAULT NULL,
  `scoreTot` int(11) DEFAULT NULL,
  `place` int(11) DEFAULT '99',
  `poule` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `poule`
--

CREATE TABLE `poule` (
  `idPoule` int(10) UNSIGNED NOT NULL,
  `type` char(1) NOT NULL,
  `katatype` int(10) UNSIGNED NOT NULL,
  `tournament` int(10) UNSIGNED NOT NULL,
  `mode` varchar(3) NOT NULL,
  `numJudges` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tablet`
--

CREATE TABLE `tablet` (
  `idTablet` int(11) UNSIGNED NOT NULL,
  `mac` varchar(17) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(256) NOT NULL,
  `judge` int(11) UNSIGNED DEFAULT NULL,
  `tgroup` varchar(16) DEFAULT NULL,
  `grouporder` int(11) DEFAULT NULL,
  `battery` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tgroup`
--

CREATE TABLE `tgroup` (
  `idTgroup` varchar(16) NOT NULL,
  `poule` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tgroup`
--

INSERT INTO `tgroup` (`idTgroup`, `poule`) VALUES
('A', NULL),
('B', NULL),
('C', NULL),
('D', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `tournament`
--

CREATE TABLE `tournament` (
  `idTournament` int(10) UNSIGNED NOT NULL,
  `name` varchar(512) NOT NULL,
  `place` varchar(512) NOT NULL,
  `date` date NOT NULL,
  `numTatami` int(11) NOT NULL,
  `classPoint1` int(11) NOT NULL DEFAULT '10',
  `classPoint2` int(11) NOT NULL DEFAULT '8',
  `classPoint3` int(11) NOT NULL DEFAULT '6',
  `classPoint4` int(11) NOT NULL DEFAULT '4',
  `classPoint5` int(11) NOT NULL DEFAULT '2',
  `classPoint6` int(11) NOT NULL DEFAULT '1',
  `numCalculateClassPoint` int(11) NOT NULL DEFAULT '6',
  `indexLiveResult` int(11) NOT NULL,
  `liveResult` text NOT NULL,
  `fluidity` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `userid` int(25) NOT NULL,
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `user_level` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Membership Information';

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `user_level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ability`
--
ALTER TABLE `ability`
  ADD PRIMARY KEY (`katatype`,`judge`),
  ADD KEY `ability_ibfk_4` (`judge`);

--
-- Indici per le tabelle `country_t`
--
ALTER TABLE `country_t`
  ADD PRIMARY KEY (`country_id`);

--
-- Indici per le tabelle `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`idForm`),
  ADD UNIQUE KEY `tablet` (`tablet`),
  ADD KEY `pair` (`pair`),
  ADD KEY `judge` (`judge`);

--
-- Indici per le tabelle `judge`
--
ALTER TABLE `judge`
  ADD PRIMARY KEY (`idJudge`),
  ADD KEY `tournament` (`tournament`);

--
-- Indici per le tabelle `judoka`
--
ALTER TABLE `judoka`
  ADD PRIMARY KEY (`idJudoka`),
  ADD KEY `tournament` (`tournament`);

--
-- Indici per le tabelle `katatype`
--
ALTER TABLE `katatype`
  ADD PRIMARY KEY (`idKatatype`);

--
-- Indici per le tabelle `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`idLog`),
  ADD KEY `form` (`form`);

--
-- Indici per le tabelle `pair`
--
ALTER TABLE `pair`
  ADD PRIMARY KEY (`idPair`),
  ADD KEY `poule` (`poule`),
  ADD KEY `judoka` (`judoka`);

--
-- Indici per le tabelle `poule`
--
ALTER TABLE `poule`
  ADD PRIMARY KEY (`idPoule`),
  ADD KEY `tournament` (`tournament`),
  ADD KEY `katatype` (`katatype`),
  ADD KEY `type` (`type`);

--
-- Indici per le tabelle `tablet`
--
ALTER TABLE `tablet`
  ADD PRIMARY KEY (`idTablet`),
  ADD KEY `tgroup` (`tgroup`),
  ADD KEY `mac` (`mac`),
  ADD KEY `judge` (`judge`);

--
-- Indici per le tabelle `tgroup`
--
ALTER TABLE `tgroup`
  ADD PRIMARY KEY (`idTgroup`);

--
-- Indici per le tabelle `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`idTournament`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `country_t`
--
ALTER TABLE `country_t`
  MODIFY `country_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT per la tabella `form`
--
ALTER TABLE `form`
  MODIFY `idForm` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `judge`
--
ALTER TABLE `judge`
  MODIFY `idJudge` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `judoka`
--
ALTER TABLE `judoka`
  MODIFY `idJudoka` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `katatype`
--
ALTER TABLE `katatype`
  MODIFY `idKatatype` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT per la tabella `log`
--
ALTER TABLE `log`
  MODIFY `idLog` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `pair`
--
ALTER TABLE `pair`
  MODIFY `idPair` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `poule`
--
ALTER TABLE `poule`
  MODIFY `idPoule` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `tablet`
--
ALTER TABLE `tablet`
  MODIFY `idTablet` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `tournament`
--
ALTER TABLE `tournament`
  MODIFY `idTournament` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ability`
--
ALTER TABLE `ability`
  ADD CONSTRAINT `ability_ibfk_3` FOREIGN KEY (`katatype`) REFERENCES `katatype` (`idKatatype`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ability_ibfk_4` FOREIGN KEY (`judge`) REFERENCES `judge` (`idJudge`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `form_ibfk_7` FOREIGN KEY (`pair`) REFERENCES `pair` (`idPair`),
  ADD CONSTRAINT `form_ibfk_8` FOREIGN KEY (`judge`) REFERENCES `judge` (`idJudge`),
  ADD CONSTRAINT `form_ibfk_9` FOREIGN KEY (`tablet`) REFERENCES `tablet` (`idTablet`);

--
-- Limiti per la tabella `judge`
--
ALTER TABLE `judge`
  ADD CONSTRAINT `judge_ibfk_1` FOREIGN KEY (`tournament`) REFERENCES `tournament` (`idTournament`);

--
-- Limiti per la tabella `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`form`) REFERENCES `form` (`idForm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `pair`
--
ALTER TABLE `pair`
  ADD CONSTRAINT `pair_ibfk_1` FOREIGN KEY (`poule`) REFERENCES `poule` (`idPoule`),
  ADD CONSTRAINT `pair_ibfk_2` FOREIGN KEY (`judoka`) REFERENCES `judoka` (`idJudoka`);

--
-- Limiti per la tabella `poule`
--
ALTER TABLE `poule`
  ADD CONSTRAINT `poule_ibfk_1` FOREIGN KEY (`tournament`) REFERENCES `tournament` (`idTournament`),
  ADD CONSTRAINT `poule_ibfk_2` FOREIGN KEY (`katatype`) REFERENCES `katatype` (`idKatatype`);

--
-- Limiti per la tabella `tablet`
--
ALTER TABLE `tablet`
  ADD CONSTRAINT `tablet_ibfk_2` FOREIGN KEY (`judge`) REFERENCES `judge` (`idJudge`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tablet_ibfk_3` FOREIGN KEY (`tgroup`) REFERENCES `tgroup` (`idTgroup`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
