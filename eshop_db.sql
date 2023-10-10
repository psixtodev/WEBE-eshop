-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-01-2023 a las 15:14:06
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eshop_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(13, 'Audio'),
(14, 'Video'),
(15, 'Programming'),
(16, 'Photo'),
(17, '3D Animation');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_amount` float NOT NULL,
  `order_transaction` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`order_id`, `order_amount`, `order_transaction`, `order_status`, `order_currency`) VALUES
(78, 345, '34534534', 'Completed', 'EUR'),
(79, 345, '34534534', 'Completed', 'EUR'),
(80, 345, '34534534', 'Completed', 'EUR'),
(81, 345, '34534534', 'Completed', 'EUR'),
(82, 345, '34534534', 'Completed', 'EUR'),
(83, 345, '34534534', 'Completed', 'EUR'),
(84, 345, '34534534', 'Completed', 'EUR'),
(85, 345, '34534534', 'Completed', 'EUR'),
(86, 345, '34534534', 'Completed', 'EUR'),
(87, 345, '34534534', 'Completed', 'EUR'),
(88, 345, '34534534', 'Completed', 'EUR'),
(89, 345, '34534534', 'Completed', 'EUR'),
(90, 345, '34534534', 'Completed', 'EUR'),
(91, 345, '34534534', 'Completed', 'EUR'),
(92, 345, '34534534', 'Completed', 'EUR'),
(93, 345, '34534534', 'Completed', 'EUR'),
(94, 345, '34534534', 'Completed', 'EUR'),
(95, 345, '34534534', 'Completed', 'EUR'),
(96, 345, '34534534', 'Completed', 'EUR'),
(97, 345, '34534534', 'Completed', 'EUR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `short_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_category_id`, `product_price`, `product_quantity`, `product_description`, `short_desc`, `product_image`) VALUES
(10, 'Adobe Premier', 14, 200, 29, 'Adobe Premiere Pro is a timeline-based and non-linear video editing software application (NLE) developed by Adobe Inc. and published as part of the Adobe Creative Cloud licensing program. First launched in 2003, Adobe Premiere Pro is a successor of Adobe Premiere (first launched in 1991). It is geared towards professional video editing, while its sibling, Adobe Premiere Elements, targets the consumer market.', 'Professional video editing software', 'premier.jpeg'),
(11, 'Davinci Resolve', 14, 50, 1, 'DaVinci Resolve (originally known as da Vinci Resolve) is a color grading, color correction, visual effects, and audio post-production video editing application for macOS, Windows, and Linux, originally developed by da Vinci Systems, and now developed by Blackmagic Design following its acquisition in 2009.[2][3] In addition to the commercial version of the software (known as DaVinci Resolve Studio), Blackmagic Design also distributes a free edition, with reduced functionality, simply named DaVinci Resolve (formerly known as DaVinci Resolve Lite).', 'Video editing application ', 'davinci.jpeg'),
(12, 'Pycharm', 15, 20, 1, 'PyCharm is an integrated development environment (IDE) used for programming in Python. It provides code analysis, a graphical debugger, an integrated unit tester, integration with version control systems, and supports web development with Django. PyCharm is developed by the Czech company JetBrains.', 'Python IDE', 'pychar.jpeg'),
(13, 'Clion', 15, 20, 1, 'CLion (pronounced \\\"sea lion\\\") is a C and C++ IDE for Linux, macOS, and Windows integrated with the CMake build system.[24][25] The initial version supports GNU Compiler Collection (GCC) and Clang compilers and GDB debugger, LLDB and Google Test.', 'C and C++ IDE', 'clion.jpeg'),
(14, 'Intellij', 15, 20, 20, 'IntelliJ IDEA is an integrated development environment (IDE) written in Java for developing computer software written in Java, Kotlin, Groovy, and other JVM-based languages. It is developed by JetBrains (formerly known as IntelliJ) and is available as an Apache 2 Licensed community edition,[2] and in a proprietary commercial edition. Both can be used for commercial development', 'IDE written in Java', 'intellij.jpeg'),
(15, 'Cubase', 13, 30, 0, 'A world leader in sound technology, Steinberg has been creating powerful, flexible and easy to use audio software for several decades. From starting out as a musician, producer or sound designer, through to being the most experienced professional, Steinberg is there to support you with the very best apps, sounds, software, hardware and tutorials.', 'Music prodution software', 'cubase.jpeg'),
(16, 'Adobe audition', 13, 75, 12, 'Syntrillium Software was founded in the early 1990s by Robert Ellison and David Johnston, both former Microsoft employees. Originally developed by Syntrillium as Cool Edit, the program was distributed as crippleware for Windows computers. The full version was useful and flexible, particularly for its time.[according to whom?] Syntrillium later released Cool Edit Pro, which added the capability to work with multiple tracks as well as other features. Audio processing, however, was done in a destructive manner (at the time, most computers were not powerful enough in terms of processor performance and memory capacity to perform non-destructive operations in real-time). Cool Edit Pro v2 added support for real-time non-destructive processing, and v2.1 added support for surround sound mixing and unlimited simultaneous tracks (up to the limit imposed by the computer hardware)', 'A professional audio workstation', 'adobeAudition.jpeg'),
(17, 'AVID', 13, 40, 29, 'Pro Tools is a digital audio workstation developed and released by Avid Technology for Microsoft Windows and macOS. It is used for music creation and production, sound for picture and, more generally, sound recording, editing, and mastering processes. Pro Tools operates both as standalone software and in conjunction with a range of external analog-to-digital converters and PCIe cards with on-board digital signal processors. The DSP is used to provide additional processing power to the host computer for processing real-time effects, such as reverb, equalization, and compression and to obtain lower latency audio performance.', 'Sound mixing software', 'avid3.jpeg'),
(18, 'Adobe Lightroom', 16, 70, 16, 'Adobe Lightroom is a piece of image organization and image manipulation software developed by Adobe Inc. as part of the Creative Cloud subscription family. It is supported on Windows, macOS, iOS, Android, and tvOS. Its primary uses include importing, saving, viewing, organizing, tagging, editing, and sharing large numbers of digital images', 'Photo editor', 'lr.jpeg'),
(19, 'Maya Software', 17, 10, 1, 'What is Maya?\r\nMaya is professional 3D software for creating realistic characters and blockbuster-worthy effects.\r\nBring believable characters to life with engaging animation tools. Shape 3D objects and scenes with intuitive modeling tools. Create realistic effects from explosions to cloth simulation.\r\n\r\n', '3D software', 'maya.jpeg'),
(20, 'Sony Vegas Pro', 14, 15, 2, 'Vegas Pro (stylized as VEGAS Pro, colloquially called Sony Vegas) is a video editing software package for non-linear editing (NLE). The first release of Vegas Beta was on June 11, 1999.[4] The software runs on Windows operating systems.\r\n\r\nOriginally developed as audio editing software, it became an NLE for video and audio, starting from version 2.0. Vegas Pro features real-time multitrack video and audio editing on unlimited tracks, resolution-independent video sequencing, complex effects, compositing tools, 24-bit/192 kHz audio support, VST and DirectX plug-in effect support, and Dolby Digital surround sound mixing.\r\n\r\nThe software was originally published by Sonic Foundry until May 2003, when Sony purchased Sonic Foundry and formed Sony Creative Software.[5] On May 24, 2016, Sony announced that Vegas was sold to MAGIX, which formed VEGAS Creative Software, to continue support and development of the software', 'Video editing software', 'sony-vegas.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reports`
--

INSERT INTO `reports` (`report_id`, `user_id`, `product_id`, `order_id`, `product_price`, `product_title`, `product_quantity`) VALUES
(2, 0, 1, 0, 24.99, '', 2),
(3, 0, 2, 0, 14.99, '', 1),
(4, 0, 1, 0, 24.99, '', 2),
(5, 0, 1, 0, 24.99, '', 3),
(6, 0, 1, 72, 24.99, '', 2),
(7, 0, 1, 73, 24.99, '', 2),
(8, 0, 1, 74, 24.99, '', 2),
(9, 0, 1, 75, 24.99, '', 2),
(10, 0, 1, 76, 24.99, '', 2),
(14, 0, 10, 80, 200, 'Adobe Premier', 2),
(15, 1, 11, 81, 50, 'Davinci Resolve', 1),
(16, 3, 12, 82, 20, 'Pycharm', 2),
(17, 0, 12, 83, 20, 'Pycharm', 2),
(18, 1, 12, 84, 20, 'Pycharm', 2),
(19, 1, 12, 85, 20, 'Pycharm', 2),
(20, 1, 12, 86, 20, 'Pycharm', 2),
(21, 1, 12, 87, 20, 'Pycharm', 2),
(22, 1, 12, 88, 20, 'Pycharm', 1),
(23, 1, 12, 89, 20, 'Pycharm', 1),
(24, 1, 12, 90, 20, 'Pycharm', 1),
(25, 1, 12, 91, 20, 'Pycharm', 1),
(26, 1, 12, 92, 20, 'Pycharm', 1),
(27, 1, 12, 93, 20, 'Pycharm', 1),
(28, 1, 12, 94, 20, 'Pycharm', 1),
(29, 3, 10, 95, 200, 'Adobe Premier', 2),
(30, 3, 12, 96, 20, 'Pycharm', 1),
(31, 0, 11, 97, 50, 'Davinci Resolve', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `admin_user`) VALUES
(1, 'rico', 'rico@hotmail.com', '123', 1),
(3, 'rico2', 'pablosixtog9@gmail.com', '123', 0),
(7, 'rico', 'pablosixtog9@gm1ail.com', '123', 0),
(8, 'rico9', 'rico99@mail.com', '123', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
