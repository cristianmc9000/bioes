-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2021 a las 23:12:53
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `CA` int(11) NOT NULL,
  `CI` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `lugar` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `correo` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nivel` varchar(10) CHARACTER SET latin1 NOT NULL,
  `fecha_alta` date NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `CA`, `CI`, `nombre`, `apellidos`, `telefono`, `lugar`, `correo`, `nivel`, `fecha_alta`, `estado`) VALUES
(1, 12223, '8827712', 'EMILY', 'SANTOS', 1239789, 'YACUIBA', 'emily@gmail.com', 'experta', '2021-04-16', 0),
(2, 63896, '7216903', 'LITZI NATALI', 'LEON HERRERA', 71192771, 'Santa Cruz', 'litzileoncarmina@gmail.com', 'experta', '2021-04-16', 1),
(3, 70882, '7541125', 'MARIA EUGENIA', 'AGUILAR', 65322127, 'Tarija', 'mariaaguilarcarmina@gmail.com', 'experta', '2021-04-16', 1),
(4, 74522, '7852258', 'MARIELA', 'FLORES', 76198552, 'YACUIBA', 'marielaflorescarmina@gmail.com', 'experta', '2021-04-17', 1),
(5, 81743, '7452258', 'WILMA', 'AGRADA TORREZ DE ICHAZO', 71891837, 'YACUIBA', 'wilmaagradacarmina@gmail.com', 'experta', '2021-04-16', 1),
(6, 82698, '7548525', 'JHONATHAN PAUL', 'IRIARTE AVILES', 76185441, 'Santa Cruz', 'jhonathanavilescarmina@gmail.com', 'experta', '2021-04-16', 1),
(8, 81252, '1063837', 'CARLA ANGELICA', 'SAAVEDRA', 75174954, 'YACUIBA B/La Playa C/Final Sucre E/Av/Gaseoducto', 'carlaangelicasaavedracarmina@gmail.com', 'experta', '2021-05-05', 1),
(9, 47862, '8916594', 'CECILIA CLAUDIA', 'HUALLPA MIRANDA', 69346540, 'YACUIBA', 'ceciliaclauidiahuallpamiranda@gmail.com', 'experta', '2021-05-05', 1),
(10, 59976, '7156001', 'MARINA MAYERLIN', 'AGUIRRE IÑIGUEZ', 77890588, 'VILLAMONTES', 'mayerlinaguirrecarmina@gmail.com', 'lider', '2021-03-24', 1),
(11, 74758, '7210086', 'SHEILA MARIA LUZ', 'AGUILERA VEGA', 70215360, 'YACUIBA', 'sheilamarialuzaguirrevega@gmail.com', 'experta', '2021-05-05', 1),
(12, 478622, '', 'VIVIANA', 'CALDERON BEJARANO', 76802190, 'YACUIBA', 'vivianacalderonbejarano@gmail.com', 'experta', '2020-01-14', 1),
(13, 74427, '5028722', 'JANICE', 'BRIZOLA GARECA', 76832109, 'VILLA MONTES', 'janicebrizolagarecacarmina@gmail.com', 'experta', '2020-12-07', 1),
(14, 46782, '5000372', 'JANE BRITT', 'CORONADO RODAS', 76808356, 'YACUIBA', 'janebrittcoronadorodas@gmail.com', 'experta', '2021-05-05', 1),
(15, 86223, '7230787', 'LORENA ARACELLI', 'GARECA VILCA', 75174439, 'YACUIBA', 'lorenaaracelligarecavilca@gmail.com', 'experta', '2021-05-05', 1),
(16, 70544, '5669462', 'MELISSA TIFANNY', 'COSSIO VIERA', 73417621, 'SUCRE', 'melissatifannycarmina@gmail.com', 'experta', '2021-05-05', 1),
(17, 84721, '3190645', 'SILVIA', 'MONTENEGRO ORTIZ', 75174806, 'YACUIBA', 'silviamonteroortiz@gmail.com', 'experta', '2021-04-14', 1),
(18, 63830, '1792983', 'ALEJANDRINA', 'URZAGASTE CARDOZO', 75180362, 'YACUIBA', 'alejandrinaurzagastecardozocarmina@gmail.com', 'experta', '2020-08-12', 1),
(19, 44374, '5050345', 'MARIA ANGELICA', 'BEJARANO BARRERA', 77875400, 'YACUIBA', 'mariaangelicabaejaranobarreracarmina@gmail.com', 'experta', '2019-11-09', 1),
(20, 67216, '10639613', 'LILIANA ', 'ZAPATA TORREZ', 75184675, 'YACUIBA', 'lilianazapatatorrezcarmina@gmail.com', 'experta', '2021-05-05', 1),
(21, 49740, '2949436', 'ADALGIZA', 'ANZOATEGUI', 62035027, 'YACUIBA', 'adalgizaanzoateguicacerescarmina@gmail.com', 'experta', '2020-02-11', 1),
(22, 44817, '5050060', 'JODIE BRIGITTE', 'CORONADO RODA', 76802589, 'YACUIBA', 'jodiebrigittecoronadorodacarmina@gmail.com', 'experta', '2021-05-05', 1),
(23, 49308, '', 'CLAUDIA EVELIN', 'VACAFLOR JIJENA', 70218636, 'YACUIBA', 'claudiavacaflorcarmina@gmail.com', 'experta', '2020-02-04', 1),
(24, 81283, '3865651', 'ANA GUEHIZA', 'VARGAS CUELLAR', 73616911, 'SANTA CRUZ``', 'anaguehizavargascuellar@gmail.com', 'experta', '2021-03-23', 1),
(25, 48933, '5780488', 'BRENDA', 'SILEZ AZURDUY', 77195944, 'YACUIBA', 'brendasilezazurduycarmina@gmail.com', 'experta', '2020-01-30', 1),
(26, 61012, '5780276', 'MARINA', 'BARRIGA GUZMAN', 7451394, 'YACUIBA', 'marinabarrigaguzmancarmina@gmail.com', 'experta', '2020-07-19', 1),
(27, 64928, '5787861', 'MARINA', 'CLAROS ZAPATA', 76831114, 'VILLAMONTES', 'marinaclaroszapatacarmina@gmail.com', 'experta', '2020-08-25', 1),
(28, 81281, '10622409', 'MARCIA VALERIA', 'ARENA TORREZ', 65800463, 'POTOSI', 'marciatorrezcarmina@gmail.com', '1', '2021-03-09', 0),
(29, 60291, '7210044', 'ROXANA', 'VEGA ALVAREZ', 73488384, 'VILLA MONTES', 'roxanavegaalvarezcarmina@gmail.com', 'experta', '2020-07-14', 1),
(30, 62930, '7010045', 'EULOGIA', 'RODRIGUEZ', 76807209, 'YACUIBA', 'eulogiarodriguezcarmina@gmail.com', 'experta', '2020-08-03', 1),
(31, 46130, '1987091', 'FRANZ REYNALDO', 'PLATA CALDERON', 76824564, 'YACUIBA', 'franzreynaldoplatacalderoncarmina@gmail.com', 'experta', '2019-12-05', 1),
(32, 47542, '', 'MARINA', 'BEJARANO', 75609979, 'YACUIBA', 'marinabejarano@gmail.com', 'experta', '2020-01-06', 1),
(33, 70918, '3745750', 'ALEJANDRINA', 'PEREZ RIOS', 68750036, 'YACUIBA', 'alejandrinaperezcarmina@gmail.com', 'experta', '2020-10-24', 1),
(34, 48788, '95404592', 'CELIA ', 'CAUCOTA TOLABA', 77196996, 'YACUIBA', 'celiacaucotatolaba@gmail.com', 'experta', '2021-05-05', 1),
(35, 65696, '5800224', 'CELESTE', 'SOSA ALARCON', 77191215, 'SANTA CRUZ', 'celestesosacarmina@gmail.com', 'experta', '2020-09-02', 1),
(36, 50049, '7210040', 'NATALIA ANDREA', 'BEJARANO VACAFLOR', 77894488, 'TARIJA', 'natalianadracarmina@gmail.com', 'experta', '2020-02-20', 1),
(37, 48977, '', 'YHIRANA BEATRIZ', 'LINO MIRANDA', 69305632, 'VILLA MONTES', 'yhiranabeatrizcarminia@gmail.com', 'experta', '2020-01-20', 1),
(82702, 91635, '3239235', 'JUANA BLANCA', 'MARISCAL PEÑARANDA', 69038348, 'VILLAMONTES', '.juanamariscalcarmina@gmail.com', 'experta', '2021-06-25', 1),
(82704, 91859, '8916595', 'PAOLA ANDREA', 'HUALLPA MIRANDA', 61667737, 'YACUIBA', 'paolamirandacarmina@gmail.com', 'experta', '2021-06-28', 1),
(82705, 89062, '1807614', 'VALENTINA JACQUELINE', 'FLORES ESTRADA', 69313856, 'TARIJA', 'valentinaflorescarmina@gmmail.com', 'experta', '2021-05-28', 1),
(82706, 83585, '1871490', 'MARIA LUZ ', ' MENDOZA ROMERO', 78247956, 'TARIJA', 'mariamendozacarmina@gmail.com', 'lider', '2021-03-31', 1),
(82707, 76126, '5800223', 'CLAUDIA ANDREA', 'SOSA ALARCON', 76803955, 'SANTA CRUZ', 'claudiasosacarmina@gmail.com', 'lider', '2021-01-11', 1),
(82708, 84773, '5040179', 'FABIANA', 'ARELLANO DURAN', 78247956, 'TARIJA', 'fabianaarellanocarmina@gmail.com', 'experta', '2021-04-13', 1),
(82709, 90474, '5794343', 'CARMEN', 'ALBORNOS ARAMAYO', 77193410, 'tarija', 'carmenaramayocarmina@gmail.com', 'experta', '2021-06-10', 1),
(82710, 464141, '05400051', 'MADELEINE', 'MENDEZ MORALES', 79057013, 'SANTA CRUZ', 'madeleinecarmina@gmail.com', 'lider', '2019-12-11', 1),
(82711, 88038, '01066265', 'LOURDES', 'LENIS ESTEFANIA', 60260521, 'TARIJA', 'estefanialeniscarmina@gmail.com', 'experta', '2021-05-19', 1),
(82712, 68844, '07104594', 'JESICA YSABEL', 'ZAMBRANA PEREZ', 67674692, 'VILLAMONTES', 'jesicazambranacarmina@gmail.com', 'experta', '2020-09-30', 1),
(82713, 89057, '05029746', 'DINA ', 'MARTINEZ GARCIA', 72982484, 'TARIJA', 'dinamartinezcarmina@gmail.com', 'experta', '2021-05-28', 1),
(82714, 47786, '04132631', 'MARISOL YAQUELIN ', 'BENITEZ SORUCO', 73453627, 'VILLAMONTES', 'marisolyaquelincarminia@gmail.com', 'experta', '2020-01-13', 1),
(82715, 44260, '05045551', 'LIZETH PAOLA', 'HURTADO BEJARANO', 76807415, 'YACUIBA', 'paolalizethcarmina@gmail.com', 'experta', '2019-11-07', 1),
(82716, 44254, '07210320', 'ISABEL TERESA', 'HURTADO BEJARANO', 67393818, 'YACUIBA', 'isabelteresacarmina@gmail.com', 'experta', '2019-11-07', 1),
(82717, 91687, '01066425', 'ERLIN GABRIELA ', 'CORONADO JURADO', 78226414, 'TARIJA', 'erlincoronadocarmina@gmail.com', 'experta', '2021-06-25', 1),
(82718, 60744, '01066868', 'SILVIA GARY', 'COCA ARTEAGA', 75152983, 'VILLAMONTES', 'silviaarteagacarmina@gmail.com', 'experta', '2020-07-17', 1),
(82719, 71347, '14574267', 'CAMILA ALEJANDRA', 'CASTILLO ZAPATA', 75184675, 'YACUIBA', 'camilazapatacarmina@gmail.com', 'experta', '2020-10-30', 1),
(82720, 74562, '04135894', 'NELSI', 'VILLARROEL QUINTEROS', 77195958, 'YACUIBA', 'nelsivillarroelcarmina@gmail.com', 'experta', '2020-12-09', 1),
(82721, 59950, '07186902', 'GABRIEL SANTOS', 'HURTADO BEJARANO', 69349115, 'VILLAMONTES', 'gabrielhurtadocarmina@gmail.com', 'experta', '2021-07-21', 1),
(82722, 92670, '7149147', 'ANA EVITA', 'MARTINEZ GARCIA', 74500346, 'YACUIBA', 'anamartinezcarmina@gmail.com', 'experta', '2021-07-09', 1),
(82723, 93244, '03534045', 'SILVIA ', 'CUELLAR GUERRERO', 68689696, 'VILLAMONTES', 'silviacuellarcarmina@gmail.com', 'experta', '2021-07-16', 1),
(82724, 72169, '7542258', 'GRACIELA', 'ZEBALLOS', 78220038, 'Tarija', 'lunita@gmail.com', 'experta', '1993-11-20', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `codc` int(11) NOT NULL,
  `ci_usu` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `totalsd` float NOT NULL,
  `totalcd` float NOT NULL,
  `valor_pesos` float NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`codc`, `ci_usu`, `fecha`, `totalsd`, `totalcd`, `valor_pesos`, `estado`) VALUES
(265, 1000000, '2021-11-12 10:26:41', 350, 192.5, 0.07, 1),
(266, 1000000, '2021-11-12 11:25:39', 350, 192.5, 0.07, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` tinyint(4) NOT NULL,
  `nombre` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `porcentaje` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id`, `nombre`, `porcentaje`) VALUES
(1, 'OFERTAS-PLATA', 30),
(2, 'OFERTAS-ORO', 30),
(3, 'PLATA', 35),
(4, 'ORO', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `codc` int(11) NOT NULL,
  `codp` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` tinyint(4) NOT NULL,
  `pupesos` float NOT NULL,
  `pubs` float NOT NULL,
  `pupesos_cd` float NOT NULL,
  `pubs_cd` float NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`codc`, `codp`, `cantidad`, `descuento`, `pupesos`, `pubs`, `pupesos_cd`, `pubs_cd`, `estado`) VALUES
(265, 'AAM007-PLATA', 10, 4, 500, 35, 275, 19.25, 1),
(266, 'IPH401-PLATA/OF', 10, 4, 500, 35, 275, 19.25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `codv` int(11) NOT NULL,
  `codp` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descuento` tinyint(4) NOT NULL,
  `pubs` float NOT NULL,
  `pubs_cd` float NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invcant`
--

CREATE TABLE `invcant` (
  `codp` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `invcant`
--

INSERT INTO `invcant` (`codp`, `cantidad`, `estado`) VALUES
('IPH401-PLATA/OF', 10, 1),
('IPH401/P-PLATA/OF', 0, 1),
('IPH402-PLATA/OF', 0, 1),
('IPH402/P-PLATA/OF', 0, 1),
('IPH403-PLATA/OF', 0, 1),
('IPH404-PLATA/OF', 0, 1),
('IPH405-PLATA/OF', 0, 1),
('IPH406-PLATA/OF', 0, 1),
('IPH408-PLATA/OF', 0, 1),
('IPH410-PLATA/OF', 0, 1),
('IPH411-PLATA/OF', 0, 1),
('IPH412-PLATA/OF', 0, 1),
('IPH414-PLATA/OF', 0, 1),
('IPH419-PLATA/OF', 0, 1),
('IPH420-PLATA/OF', 0, 1),
('IPH422-PLATA/OF', 0, 1),
('IPH423-PLATA/OF', 0, 1),
('IPH424-PLATA/OF', 0, 1),
('IPH425-PLATA/OF', 0, 1),
('IPH426-PLATA/OF', 0, 1),
('IPH426/P-PLATA/OF', 0, 1),
('IPM301-PLATA/OF', 0, 1),
('IPM302', 0, 1),
('IPM303', 0, 1),
('IPM304', 0, 1),
('IPM305-PLATA/OF', 0, 1),
('IPM306', 0, 1),
('IPM307', 0, 1),
('IPM308-PLATA/OF', 0, 1),
('IPM309-PLATA/OF', 0, 1),
('IPM310', 0, 1),
('IPM312', 0, 1),
('IPM314-PLATA/OF', 0, 1),
('IPM318', 0, 1),
('IPM319-PLATA/OF', 0, 1),
('IPM327', 0, 1),
('IPM329-PLATA/OF', 0, 1),
('IPM332-PLATA/OF', 0, 1),
('IPM338-PLATA/OF', 0, 1),
('IPM339', 0, 1),
('IPM341', 0, 1),
('IPM342-PLATA/OF', 0, 1),
('IPM343', 0, 1),
('ORS526-PLATA/OF', 0, 1),
('ROS001-ORO', 0, 1),
('ORB525-PLATA', 0, 1),
('ORC523-PLATA', 0, 1),
('ORC524-PLATA', 0, 1),
('VFC510-PLATA/OF', 0, 1),
('VFC511-PLATA', 0, 1),
('VFC511-PLATA $ 379', 0, 1),
('VFC512-PLATA', 0, 1),
('VFG513-PLATA', 0, 1),
('AAM007-PLATA', 10, 1),
('AEU006-PLATA', 0, 1),
('ALA001-PLATA', 0, 1),
('ARO002-PLATA', 0, 1),
('ARO004-PLATA', 0, 1),
('ASA005-PLATA', 0, 1),
('AVE003-PLATA', 0, 1),
('BAC055-ORO', 0, 1),
('BAE514-ORO', 0, 1),
('BAG710-ORO', 0, 1),
('BDC289-ORO', 0, 1),
('BDC307-ORO', 0, 1),
('BDC308-ORO/OF', 0, 1),
('BFC545-ORO', 0, 1),
('BFC547-ORO', 0, 1),
('BFD548-ORO', 0, 1),
('BFU546-ORO', 0, 1),
('BLC004-PLATA/OF', 0, 1),
('BLF003-PLATA/OF', 0, 1),
('BLR002-PLATA/OF', 0, 1),
('BLT001-PLATA', 0, 1),
('BOA283-ORO', 0, 1),
('BOA285-ORO', 0, 1),
('BOC374-ORO', 0, 1),
('BOP463-ORO', 0, 1),
('BOT064-ORO/OF', 0, 1),
('BOV906-ORO/OF', 0, 1),
('BRA161-ORO', 0, 1),
('BRC087-ORO', 0, 1),
('BRG079-ORO', 0, 1),
('BTC549-ORO/OF', 0, 1),
('BTT179-ORO/OF', 0, 1),
('BTU355-ORO', 0, 1),
('CAC394-ORO', 0, 1),
('CAU396-ORO', 0, 1),
('CBC056-ORO/OF', 0, 1),
('CLC530-PLATA/OF', 0, 1),
('CLE440-ORO', 0, 1),
('COC186-ORO/OF', 0, 1),
('COC187-ORO', 0, 1),
('COC188-ORO/OF', 0, 1),
('CPC280-ORO', 0, 1),
('CPC281-ORO', 0, 1),
('CPC282-ORO/OF', 0, 1),
('CPG283-ORO', 0, 1),
('CRC201-ORO', 0, 1),
('CRC202-ORO/OF', 0, 1),
('CRC203-ORO', 0, 1),
('GEL1373-PLATA', 0, 1),
('GEL1701-PLATA', 0, 1),
('GEL1808-PLATA', 0, 1),
('GEL216-PLATA', 0, 1),
('GEL217-PLATA', 0, 1),
('GEL540-PLATA', 0, 1),
('GEL541-PLATA', 0, 1),
('GEL542-PLATA', 0, 1),
('LCC256-ORO', 0, 1),
('LCC257-ORO', 0, 1),
('LCC258-ORO', 0, 1),
('LCC259-ORO', 0, 1),
('MFA503-ORO', 0, 1),
('MFC501-ORO', 0, 1),
('MFV502-ORO/OF', 0, 1),
('MKC260-ORO', 0, 1),
('MKC261-ORO/OF', 0, 1),
('MKC262-ORO', 0, 1),
('SLC506-PLATA/OF', 0, 1),
('XBM11301-PLATA', 0, 1),
('XBM11302-PLATA', 0, 1),
('XBM11303-PLATA', 0, 1),
('XCO138-PLATA', 0, 1),
('XCO139-PLATA', 0, 1),
('XDO080-PLATA', 0, 1),
('XDO181-PLATA', 0, 1),
('XLC10109-PLATA', 0, 1),
('XLC10121-PLATA', 0, 1),
('XLC10131-PLATA', 0, 1),
('XLC135-PLATA', 0, 1),
('XLC137-PLATA', 0, 1),
('XLC508-PLATA/OF', 0, 1),
('XLC509-PLATA', 0, 1),
('XLM6012-PLATA/OF', 0, 1),
('XLM6013-PLATA/OF', 0, 1),
('XLM6014-PLATA', 0, 1),
('XLM6022-PLATA/OF', 0, 1),
('GEL1374-PLATA', 0, 1),
('GEL1704-PLATA', 0, 1),
('GEL1919-PLATA', 0, 1),
('GEL202-PLATA', 0, 1),
('GEL203-PLATA', 0, 1),
('GEL205-PLATA', 0, 1),
('GEL215-PLATA', 0, 1),
('GEL218-PLATA', 0, 1),
('GEL219-PLATA', 0, 1),
('FMP529-ORO', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `codp` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pupesos` float NOT NULL,
  `pubs` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_reg` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_venc` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `codp`, `pupesos`, `pubs`, `cantidad`, `fecha_reg`, `fecha_venc`, `estado`) VALUES
(1780, 'AAM007-PLATA', 500, 35, 10, '2021-11-12 10:26:41', NULL, 1),
(1781, 'IPH401-PLATA/OF', 500, 35, 10, '2021-11-12 11:25:39', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `codli` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `lineas`
--

INSERT INTO `lineas` (`codli`, `nombre`, `estado`) VALUES
(1, 'SIMIL', 1),
(2, 'ORIGENES', 1),
(3, 'CUIDADOS FACIALES', 1),
(4, 'LINEA COLOR', 1),
(5, 'BABY VEGAN', 1),
(6, 'CUIDADOS CAPILARES', 1),
(7, 'FRAG. AMBIENTALES', 1),
(8, 'HIGIENE BUCAL', 1),
(9, 'CUIDADOS COVID', 1),
(10, 'SUPLEMENTOS DIETEROS', 1),
(11, 'AUXILIARES DE VENTA', 1),
(12, 'CARRERA COMERCIAL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `codv` int(11) NOT NULL,
  `monto` float NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `linea` int(11) NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `foto`, `linea`, `descripcion`, `estado`) VALUES
('AAM007-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE BASE BLEND 125 ML', 1),
('AEU006-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIAL EUCALIPTO 10 ML', 1),
('ALA001-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIAL LAVANDA 10 ML', 1),
('ARO002-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIAL ROMERO 10 ML', 1),
('ARO004-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIAL ROSAS 10 ML', 1),
('ASA005-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIAL SANDALO 10 ML', 1),
('AVE003-PLATA', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIA VERBENA 10 ML', 1),
('BAC055-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA ULTRA REGENERADORA CON PROP?LEOS, ALOE VERA,...', 1),
('BAE514-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA ULTRA HIDRATANTE CON PROP?LEOS, ALOE VERA Y ...', 1),
('BAG710-ORO', 'images/fotos_prod/defecto.png', 3, 'GEL DE MANOS MIEL + VITAMINA A 70 ML', 1),
('BDC289-ORO', 'images/fotos_prod/defecto.png', 3, 'CONTORNO DE OJOS ANTI-AGE CON ?CIDO HIALUR?NICO 10...', 1),
('BDC307-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA D?A ANTI-AGE CON RETINOL 55 ML', 1),
('BDC308-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA NOCHE ANTI-AGE CON ?CIDO HIALUR?NICO', 1),
('BFC545-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA EXFOLIANTE PARA PIES 125 ML', 1),
('BFC547-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA SUAVIZANTE PARA PIES 125 ML', 1),
('BFD548-ORO', 'images/fotos_prod/defecto.png', 3, 'DESODORANTE PARA PIES Y CALZADO 125 ML', 1),
('BFU546-ORO', 'images/fotos_prod/defecto.png', 3, 'UNG?ENTO P?DICO PARA CALLOS Y DUREZAS 50 ML', 1),
('BLC004-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'BRILLO LABIAL CORAL 3G', 1),
('BLF003-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'BRILLO LABIAL FUCSIA 3G', 1),
('BLR002-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'BRILLO LABIAL ROJO 3G', 1),
('BLT001-PLATA', 'images/fotos_prod/defecto.png', 3, 'BRILLO LABIAL TRANSPARENTE', 1),
('BOA283-ORO', 'images/fotos_prod/defecto.png', 3, 'OLEO PARA MASAJES 125 ML', 1),
('BOA285-ORO', 'images/fotos_prod/defecto.png', 3, 'ACEITE BALS?MICO ROSA MOSQUETA 20 ML', 1),
('BOC374-ORO', 'images/fotos_prod/defecto.png', 3, 'UNG?ENTO PARA MASAJES 50 ML', 1),
('BOP463-ORO', 'images/fotos_prod/defecto.png', 3, 'ROCIADOR BUCAL 30 ML', 1),
('BOT064-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'EUCABIO SPRAY AMBIENTAL 30 ML', 1),
('BOV906-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'UNG?ENTO DESCONGESTIVO 50 ML', 1),
('BRA161-ORO', 'images/fotos_prod/defecto.png', 3, 'AGUA MICELAR 200 ml', 1),
('BRC087-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA C?LULAS MADRE 50 ML', 1),
('BRG079-ORO', 'images/fotos_prod/defecto.png', 3, 'GEL ACTIVO CON ?CIDO HIALUR?NICO 10 ML', 1),
('BTC549-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA FACIAL CON BABA DE CARACOL 50 ML', 1),
('BTT179-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'ACEITE ESENCIAL 31 20 ML', 1),
('BTU355-ORO', 'images/fotos_prod/defecto.png', 3, 'UNG?ENTO PARA LABIOS CON KARIT? 5 ML', 1),
('CAC394-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA ACN? CERO CON TEA TREE 50 g', 1),
('CAU396-ORO', 'images/fotos_prod/defecto.png', 3, 'L?PIZ SECATIVO ACN? CERO 4 g', 1),
('CBC056-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA ORDE?E CON PROP?LEOS, ALOE VERA Y ALANTO?NA ...', 1),
('CLC530-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA CORPORAL CON EXFOLIANTE NATURAL DE ARROZ Y K...', 1),
('CLE440-ORO', 'images/fotos_prod/defecto.png', 3, 'BLANQUEADORA CORPORAL. PEPINOS + LIM?N 200 ML', 1),
('COC186-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA FACIAL D?A Con Aceite de Coco y Vitaminas A...', 1),
('COC187-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA FACIAL NOCHE Con Aceite de Coco y Vitaminas...', 1),
('COC188-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA PARA CONTORNO DE OJOS Con Aceite de Coco. 50...', 1),
('CPC280-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA PARA PIERNAS ACTIVAS 200 ML', 1),
('CPC281-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA PARA PIERNAS CANSADAS 200 ML', 1),
('CPC282-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA CORPORAL ANTI-CELULITIS y ANTI-ESTR?AS', 1),
('CPG283-ORO', 'images/fotos_prod/defecto.png', 3, 'GEL CRI?GENO REDUCTOR y REAFIRMANTE 250 ML', 1),
('CRC201-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA EXFOLIANTE CRISTAL DE ROCA 50 ML', 1),
('CRC202-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA DE LIMPIEZA CREMA DE ROCA 50 ML', 1),
('CRC203-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA FACIAL DIA & NOCHE CREMA DE ROCA 50 ML', 1),
('FMP529-ORO', 'images/fotos_prod/defecto.png', 1, 'PIMIENTA NEGRA EAU DE PARFUM 55 ML', 1),
('GEL1373-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTES EN GEL FUCSIA FUN 13 ml', 1),
('GEL1374-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL ROJO GLAMOUR 13 ml', 1),
('GEL1701-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTES EN GEL NUDE 13 ml', 1),
('GEL1704-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL CORAL REEF', 1),
('GEL1808-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTES EN GEL LAVANDA 13 ml', 1),
('GEL1919-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL BORDEAUX 13 ml', 1),
('GEL202-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL CORAL ROSADO 13ml', 1),
('GEL203-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL TURQUESA 13 ml', 1),
('GEL205-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL LILA VIOLETA 13 ml', 1),
('GEL215-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL AMARILLO FLUO 13 ml', 1),
('GEL216-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTES EN GEL ROSA MORADO ?13 ml', 1),
('GEL217-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTES EN GEL GRIS 13 ml', 1),
('GEL218-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL ROSA CLARO 13 ml', 1),
('GEL219-PLATA', 'images/fotos_prod/defecto.png', 4, 'ESMALTES EN GEL VIOLETA 13 ml', 1),
('GEL540-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTE VIOLETA REFLEX PERLADO 13 ml', 1),
('GEL541-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTE AZUL REFLEX PERLADO 13 ml', 1),
('GEL542-PLATA', 'images/fotos_prod/defecto.png', 3, 'ESMALTE DORADO REFLEX PERLADO 13 ml', 1),
('IPH401-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil INVICTUS de P. Rabanne. Amaderada Acu?tica', 1),
('IPH401/P-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'INVICTUS DE 30 ML', 1),
('IPH402-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil ONE MILLION de Paco Rabanne. Oriental Especi...', 1),
('IPH402/P-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'ONE MILLION DE 30 ML', 1),
('IPH403-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil POLO RED INTENSE. Amaderada Especiada', 1),
('IPH404-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil 212 FOR MEN de C.H. Oriental Amaderada', 1),
('IPH405-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil ACQUA DI GIO de Armani. Arom?tica Acu?tica', 1),
('IPH406-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil 212 VIP de C. Herrera. Oriental Amaderada', 1),
('IPH408-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil POLO RED. Amaderada Especiada', 1),
('IPH410-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil FAHRENHEIT de C. Dior. Almizcle Amaderada', 1),
('IPH411-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil C.H MEN de C. Herrera. Amaderada Especiada', 1),
('IPH412-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil ONE de Calvin Klein. C?trica Arom?tica', 1),
('IPH414-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil KING OF SEDUCTION de A. Banderas. Almizcle A...', 1),
('IPH419-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil SAUVAGE de C. Dior. Arom?tica Fougere', 1),
('IPH420-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil PACO RABANNE. Arom?tica Fougere', 1),
('IPH422-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil POLO DOUBLE BLACK. Amaderada Arom?tica', 1),
('IPH423-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil HUGO BOSS MEN. Arom?tica Verde', 1),
('IPH424-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil POLO SPORT. Arom?tica Verde', 1),
('IPH425-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil BAD BOY de C. Herrera. Oriental Especiada', 1),
('IPH426-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil STRONGER WITH YOU FREEZE de G. Armani. Amad...', 1),
('IPH426/P-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'STRONGER DE 30 ML', 1),
('IPM301-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil LA VIE EST BELLE de Lancome. Floral Frutal G...', 1),
('IPM302', 'images/fotos_prod/defecto.png', 1, 'S?mil OLYMPEA de Paco Rabanne. Oriental Floral', 1),
('IPM303', 'images/fotos_prod/defecto.png', 1, 'S?mil GOOD GIRL de Carolina Herrera. Oriental Flor...', 1),
('IPM304', 'images/fotos_prod/defecto.png', 1, 'S?mil 212 SEXY de Carolina Herrera. Oriental Flora...', 1),
('IPM305-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil LADY MILLION de Paco Rabanne. Floral Frutal', 1),
('IPM306', 'images/fotos_prod/defecto.png', 1, 'S?mil ANGE OU DEMON de Givenchy. Oriental Floral', 1),
('IPM307', 'images/fotos_prod/defecto.png', 1, 'S?mil SIde Armani. Chipre Frutal', 1),
('IPM308-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil CHANEL N?5. Floral Aldeh?dica', 1),
('IPM309-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil NINA de Nina Ricci. Floral Frutal', 1),
('IPM310', 'images/fotos_prod/defecto.png', 1, 'S?mil FLOWER de Kenzo. Oriental Floral', 1),
('IPM312', 'images/fotos_prod/defecto.png', 1, 'S?mil 212 VIP FEM de Carolina Herrera. Oriental Ma...', 1),
('IPM314-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil AMOR AMOR de Cacharel. Floral Frutal', 1),
('IPM318', 'images/fotos_prod/defecto.png', 1, 'S?mil AMOUR de Kenzo. Oriental Madera', 1),
('IPM319-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil FLOWER IN THE AIR de Kenzo. Floral Frutal', 1),
('IPM327', 'images/fotos_prod/defecto.png', 1, 'S?mil MISS DIOR de Christian Dior. Chipre Floral', 1),
('IPM329-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil ACQUA DI GIOIA de Armani. Floral Acu?tica', 1),
('IPM332-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil ABSOLUTELY IRRESISTIBLE de Givenchy. Floral ...', 1),
('IPM338-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil J?ADORE de Christian Dior. Floral Frutal', 1),
('IPM339', 'images/fotos_prod/defecto.png', 1, 'S?mil SHAKIRA. Oriental Floral', 1),
('IPM341', 'images/fotos_prod/defecto.png', 1, 'S?mil ARMANI CODE de Armani. Floral', 1),
('IPM342-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'S?mil SCANDAL de Jean Paul Gaultier. Floral', 1),
('IPM343', 'images/fotos_prod/defecto.png', 1, 'S?mil GOOD GIRL SUPREME de Carolina Herrera. Flora...', 1),
('LCC256-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA DE ENEBRO 100 ML', 1),
('LCC257-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA DE TOMILLO', 1),
('LCC258-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA DE LAVANDA 100 ML', 1),
('LCC259-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA DE TEA TREE 100 ML', 1),
('MFA503-ORO', 'images/fotos_prod/defecto.png', 3, 'ARCILLA blanca 70 ML', 1),
('MFC501-ORO', 'images/fotos_prod/defecto.png', 3, 'CARB?N detox 70 ML', 1),
('MFV502-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'FANGO verde 70 ML', 1),
('MKC260-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA DE MANOS KARIT? LIM?N & JENGIBRE', 1),
('MKC261-ORO/OF', 'images/fotos_prod/defecto.png', 3, 'CREMA DE MANOS KARIT? ROSAS & ORQU?DEAS', 1),
('MKC262-ORO', 'images/fotos_prod/defecto.png', 3, 'CREMA DE MANOS KARIT? ALMENDRAS & CASTA?AS 70 ML', 1),
('ORB525-PLATA', 'images/fotos_prod/defecto.png', 2, 'BRUMA FACIAL OR?GENES 125 ML', 1),
('ORC523-PLATA', 'images/fotos_prod/defecto.png', 2, 'CREMA FACIAL NOCHE OR?GENES 50 ML', 1),
('ORC524-PLATA', 'images/fotos_prod/defecto.png', 2, 'CREMA FACIAL D?A OR?GENES 50 ML', 1),
('ORS526-PLATA/OF', 'images/fotos_prod/defecto.png', 1, 'SERUM FACIAL OR?GENES 30 ML', 1),
('ROS001-ORO', 'images/fotos_prod/defecto.png', 1, 'ROS? PARFUM 50 ML', 1),
('SLC506-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'BB CREAM PROTECTOR 50 CON ROSA MOSQUETA 70 ML', 1),
('VFC510-PLATA/OF', 'images/fotos_prod/defecto.png', 2, 'CREMA FACIAL HIDRATANTE CON ACEITE DE AVANDA, JOJO...', 1),
('VFC511-PLATA', 'images/fotos_prod/defecto.png', 2, 'T?NICO FACIAL HUMECTANTE CON HAMAMELIS Y T? VERDE ...', 1),
('VFC511-PLATA $ 379', 'images/fotos_prod/defecto.png', 2, 'T?NICO FACIAL HUMECTANTE CON HAMAMELIS Y T? VERDE ...', 1),
('VFC512-PLATA', 'images/fotos_prod/defecto.png', 2, 'LECHE DESMAQUILLANTE CON CAL?NDULA Y MANZANILLA 12...', 1),
('VFG513-PLATA', 'images/fotos_prod/defecto.png', 2, 'GEL DE LIMPIEZA FACIAL CON ALOE VERA, LIM?N Y ORQU...', 1),
('XBM11301-PLATA', 'images/fotos_prod/defecto.png', 3, 'BASE DE MAQUILLAJE L?QUIDA ESENCIALDERM TONO 1', 1),
('XBM11302-PLATA', 'images/fotos_prod/defecto.png', 3, 'BASE DE MAQUILLAJE L?QUIDA ESENCIALDERM TONO 2', 1),
('XBM11303-PLATA', 'images/fotos_prod/defecto.png', 3, 'BASE DE MAQUILLAJE L?QUIDA ESENCIALDERM TONO 3', 1),
('XCO138-PLATA', 'images/fotos_prod/defecto.png', 3, 'CORRECTOR EN BARRA TONO CLARO 4G', 1),
('XCO139-PLATA', 'images/fotos_prod/defecto.png', 3, 'CORRECTOR EN BARRA TONO MEDIO 4G', 1),
('XDO080-PLATA', 'images/fotos_prod/defecto.png', 3, 'DELINEADOR L?QUIDO CON PUNTA DE FIBRA 3ml', 1),
('XDO181-PLATA', 'images/fotos_prod/defecto.png', 3, 'DELINEADOR RETR?CTIL NEGRO', 1),
('XLC10109-PLATA', 'images/fotos_prod/defecto.png', 3, 'BORRAVINO 3,5G', 1),
('XLC10121-PLATA', 'images/fotos_prod/defecto.png', 3, 'ROJO PASI?N 3,5G', 1),
('XLC10131-PLATA', 'images/fotos_prod/defecto.png', 3, 'NUDE 3,5G', 1),
('XLC135-PLATA', 'images/fotos_prod/defecto.png', 3, 'NATURAL 4G', 1),
('XLC137-PLATA', 'images/fotos_prod/defecto.png', 3, 'FRUTILLA 4G', 1),
('XLC508-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'LABIAL CREMOSO CORAL 3G', 1),
('XLC509-PLATA', 'images/fotos_prod/defecto.png', 3, 'FUCSIA 3,5G', 1),
('XLM6012-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'ROJO APASIONADO 3,5G', 1),
('XLM6013-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'FUCSIA CABERNET 3,5G', 1),
('XLM6014-PLATA', 'images/fotos_prod/defecto.png', 3, 'TOSTADO ROJIZO 3,5G', 1),
('XLM6022-PLATA/OF', 'images/fotos_prod/defecto.png', 3, 'BEIGE OSCURO 3,5G', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo_compra`
--

CREATE TABLE `recibo_compra` (
  `cod` int(11) NOT NULL,
  `codc` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`, `descripcion`) VALUES
(1, 'Administrador', 'Tiene acceso a todos los modulos del sistema'),
(2, 'Vendedor', 'Tiene acceso a los modulos de ventas y reportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(40) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `rol` tinyint(4) NOT NULL DEFAULT 2,
  `password` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`CI`, `nombre`, `apellidos`, `telefono`, `rol`, `password`, `estado`) VALUES
(1000000, 'Carmen', '', 75183804, 1, '1111', 1),
(7210040, 'Rodrigo', 'Gonzales Dolz', 77894488, 2, '1234', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `codv` int(11) NOT NULL,
  `ci_usu` int(11) NOT NULL,
  `ca` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL,
  `valor_peso` float NOT NULL,
  `credito` tinyint(4) NOT NULL DEFAULT 0,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `CA` (`CA`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`codc`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD KEY `codc` (`codc`),
  ADD KEY `codp` (`codp`),
  ADD KEY `descuento` (`descuento`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD KEY `codv` (`codv`),
  ADD KEY `codp` (`codp`),
  ADD KEY `descuento` (`descuento`);

--
-- Indices de la tabla `invcant`
--
ALTER TABLE `invcant`
  ADD KEY `codp` (`codp`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codp` (`codp`);

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`codli`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codv` (`codv`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `linea` (`linea`);

--
-- Indices de la tabla `recibo_compra`
--
ALTER TABLE `recibo_compra`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `codc` (`codc`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CI`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`codv`),
  ADD KEY `ci_usu` (`ci_usu`),
  ADD KEY `ca` (`ca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82726;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `codc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1782;

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `codli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT de la tabla `recibo_compra`
--
ALTER TABLE `recibo_compra`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `codv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`codc`) REFERENCES `compras` (`codc`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`codp`) REFERENCES `productos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compra_ibfk_3` FOREIGN KEY (`descuento`) REFERENCES `descuentos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`codv`) REFERENCES `ventas` (`codv`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`codp`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_3` FOREIGN KEY (`descuento`) REFERENCES `descuentos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `invcant`
--
ALTER TABLE `invcant`
  ADD CONSTRAINT `invcant_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`codv`) REFERENCES `ventas` (`codv`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`linea`) REFERENCES `lineas` (`codli`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recibo_compra`
--
ALTER TABLE `recibo_compra`
  ADD CONSTRAINT `recibo_compra_ibfk_1` FOREIGN KEY (`codc`) REFERENCES `compras` (`codc`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`ci_usu`) REFERENCES `usuarios` (`CI`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`ca`) REFERENCES `clientes` (`CA`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
