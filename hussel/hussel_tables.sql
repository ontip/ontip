-- phpMyAdmin SQL Dump
-- version 4.4.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Gegenereerd op: 26 mei 2015 om 07:35
-- Serverversie: 5.5.27
-- PHP-versie: 5.4.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `boulamis_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hussel_config`
--

CREATE TABLE IF NOT EXISTS `hussel_config` (
  `Id` int(6) unsigned NOT NULL,
  `Vereniging` char(80) NOT NULL,
  `Vereniging_id` int(3) NOT NULL DEFAULT '0',
  `Variabele` char(80) NOT NULL,
  `Waarde` char(10) NOT NULL,
  `Parameters` char(80) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `hussel_config`
--

INSERT INTO `hussel_config` (`Id`, `Vereniging`, `Vereniging_id`, `Variabele`, `Waarde`, `Parameters`) VALUES
(1, 'Boulamis', 4, 'controle_13', 'Auto', ''),
(2, 'Boulamis', 4, 'aantal_rondes', '5', ''),
(3, 'Boulamis', 4, 'datum_lock', 'Off', '2015-05-25'),
(4, 'Boulamis', 4, 'voorgeloot', 'Off', ''),
(11, 'Boulamis', 4, 'blokkeer_invoer', 'On', ''),
(5, 'JBV De Gemshoorn', 14, 'controle_13', 'Auto', ''),
(6, 'JBV De Gemshoorn', 14, 'aantal_rondes', '3', ''),
(7, 'JBV De Gemshoorn', 14, 'datum_lock', 'Off', '2015-05-24'),
(8, 'JBV De Gemshoorn', 14, 'voorgeloot', 'Off', ''),
(9, 'Boulamis', 4, 'blokkeer_invoer', 'Off', ''),
(10, 'JBV De Gemshoorn\r\n', 14, 'blokkeer_invoer', 'On', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `hussel_config`
--
ALTER TABLE `hussel_config`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `hussel_config`
--
ALTER TABLE `hussel_config`
  MODIFY `Id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




CREATE TABLE IF NOT EXISTS `hussel_serie` (
  `Id` int(6) unsigned NOT NULL,
  `Vereniging` char(80) NOT NULL,
  `Vereniging_id` int(3) NOT NULL DEFAULT '0',
  `Naam_serie` char(40) NOT NULL DEFAULT '',
  `Datum` date DEFAULT NULL,
  `Laatst` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=741 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `hussel_serie_scores` (
  `Id` int(6) unsigned NOT NULL,
  `Vereniging` char(80) NOT NULL,
  `Vereniging_id` int(3) NOT NULL DEFAULT '0',
  `Naam_serie` char(80) NOT NULL,
  `Datum` date NOT NULL,
  `Naam` char(80) NOT NULL DEFAULT '',
  `Score` int(3) NOT NULL DEFAULT '0',
  `Saldo` int(3) NOT NULL DEFAULT '0',
  `Laatst` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `hussel_score` (
  `Id` int(6) unsigned NOT NULL,
  `Vereniging` char(80) NOT NULL,
  `Vereniging_id` int(3) NOT NULL DEFAULT '0',
  `Datum` date DEFAULT NULL,
  `Naam` char(40) NOT NULL DEFAULT '',
  `Lot_nummer` int(3) DEFAULT NULL,
  `Voor1` int(2) unsigned NOT NULL DEFAULT '0',
  `Tegen1` int(2) unsigned NOT NULL DEFAULT '0',
  `Score1` int(2) NOT NULL DEFAULT '0',
  `Voor2` int(2) unsigned NOT NULL DEFAULT '0',
  `Tegen2` int(2) unsigned NOT NULL DEFAULT '0',
  `Score2` int(2) NOT NULL DEFAULT '0',
  `Voor3` int(2) unsigned NOT NULL DEFAULT '0',
  `Tegen3` int(2) unsigned NOT NULL DEFAULT '0',
  `Score3` int(2) NOT NULL DEFAULT '0',
  `Voor4` int(2) unsigned NOT NULL DEFAULT '0',
  `Tegen4` int(2) unsigned NOT NULL DEFAULT '0',
  `Score4` int(2) NOT NULL DEFAULT '0',
  `Voor5` int(2) unsigned NOT NULL DEFAULT '0',
  `Tegen5` int(2) unsigned NOT NULL DEFAULT '0',
  `Score5` int(2) NOT NULL DEFAULT '0',
  `Winst` int(2) unsigned NOT NULL DEFAULT '0',
  `Saldo` int(3) NOT NULL DEFAULT '0',
  `Laatst` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1225 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `hussel_serie_stand` (
  `Id` int(6) unsigned NOT NULL,
  `Vereniging` char(80) NOT NULL,
  `Vereniging_id` int(3) NOT NULL DEFAULT '0',
  `Naam_serie` char(80) NOT NULL,
  `Naam` char(80) NOT NULL DEFAULT '',
  `Score1` int(3) NOT NULL DEFAULT '0',
  `Score2` int(3) NOT NULL DEFAULT '0',
  `Score3` int(3) NOT NULL DEFAULT '0',
  `Score4` int(3) NOT NULL DEFAULT '0',
  `Score5` int(3) NOT NULL DEFAULT '0',
  `Score6` int(3) NOT NULL DEFAULT '0',
  `Score7` int(3) NOT NULL DEFAULT '0',
  `Score8` int(3) NOT NULL DEFAULT '0',
  `Score9` int(3) NOT NULL DEFAULT '0',
  `Score10` int(3) NOT NULL DEFAULT '0',
  `Score11` int(3) NOT NULL DEFAULT '0',
  `Score12` int(3) NOT NULL DEFAULT '0',
  `Score13` int(3) NOT NULL DEFAULT '0',
  `Score14` int(3) NOT NULL DEFAULT '0',
  `Score15` int(3) NOT NULL DEFAULT '0',
  `Score16` int(3) NOT NULL DEFAULT '0',
  `Score17` int(3) NOT NULL DEFAULT '0',
  `Score18` int(3) NOT NULL DEFAULT '0',
  `Score19` int(3) NOT NULL DEFAULT '0',
  `Score20` int(3) NOT NULL DEFAULT '0',
  `Gespeeld` int(3) NOT NULL DEFAULT '0',
  `Totaal` int(3) NOT NULL DEFAULT '0',
  `Laagste` int(3) NOT NULL DEFAULT '0',
  `Gemiddelde` decimal(4,1) NOT NULL DEFAULT '0.0',
  `Hoogste` int(3) NOT NULL DEFAULT '0',
  `Eind` int(3) NOT NULL DEFAULT '0',
  `Laatst` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3033 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `hussel_spelers` (
  `Id` int(6) unsigned NOT NULL,
  `Vereniging` char(80) NOT NULL,
  `Vereniging_id` int(3) NOT NULL DEFAULT '0',
  `Naam` char(120) NOT NULL,
  `Soort` char(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;
