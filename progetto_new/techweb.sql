-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2022 at 12:55 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `casa`
--

CREATE TABLE `casa` (
  `id_casa` int(10) NOT NULL,
  `regione` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `citta` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `via` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civico` int(5) NOT NULL,
  `tipologia` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superficie` int(10) UNSIGNED NOT NULL,
  `camere` int(10) UNSIGNED NOT NULL,
  `bagni` int(10) UNSIGNED NOT NULL,
  `parcheggio` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giardino` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piscina` tinyint(1) NOT NULL,
  `patio` tinyint(1) NOT NULL,
  `barbecue` tinyint(1) NOT NULL,
  `angolo_bar` tinyint(1) NOT NULL,
  `idromassaggio` tinyint(1) NOT NULL,
  `terrazzo` tinyint(1) NOT NULL,
  `arredato` tinyint(1) NOT NULL,
  `prezzo` int(10) UNSIGNED NOT NULL,
  `descrizione` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `casa`
--

INSERT INTO `casa` (`id_casa`, `regione`, `provincia`, `citta`, `via`, `civico`, `tipologia`, `superficie`, `camere`, `bagni`, `parcheggio`, `giardino`, `piscina`, `patio`, `barbecue`, `angolo_bar`, `idromassaggio`, `terrazzo`, `arredato`, `prezzo`, `descrizione`) VALUES
(2, 'Veneto', 'Padova', 'Este', 'A. Palladio', 3, 'villa', 315, 5, 3, NULL, 'privato', 0, 0, 0, 0, 0, 1, 1, 0, 'Prestigiosa villa liberty in stile francese, con grande parco privato con fontane e labirinto. Il palazzetto d’epoca si sviluppa su tre livelli. È presente un’ampia soffitta da organizzare in spazi personalizzati. L’immobile è da ristrutturare, presenti pregiati parquet e stucchi. Trattativa riservata.'),
(3, 'Trentino', 'Bolzano', 'Bolzano', 'I. Kostner', 2, 'villa', 250, 5, 3, 'posto_auto', 'privato', 1, 0, 1, 0, 1, 0, 1, 750000, 'Moderna villetta di recente costruzione con mattoni a vista, grandi vetrate e lucernari. L’immobile è completo di posto auto doppio, giardino privato con piscina, vasca idromassaggio esterna, zona barbecue, ampia zona giorno con caminetto. Parquet in tutta la casa, arredi moderni.'),
(4, 'Trentino', 'Trento', 'Tovel', 'Brenta', 38, 'villa', 200, 3, 2, NULL, 'privato', 0, 0, 1, 0, 0, 0, 1, 610000, 'Affascinante baita di montagna ristrutturata con affaccio sul lago, con pedana e posto barca sul pontile. Dispone di moderne vetrate e parquet con riscaldamento a pavimento. '),
(5, 'Trentino', 'Trento', 'Rovereto', 'M. Botta', 87, 'villa', 300, 3, 2, 'posto_auto', 'privato', 1, 0, 1, 1, 1, 0, 1, 620000, 'Moderna villetta di recente costruzione con mattoni a vista, grandi vetrate e lucernari. L’immobile è completo di posto auto doppio, giardino privato con piscina, vasca idromassaggio esterna, zona barbecue, ampia zona giorno con caminetto. Particolare studiolo con affaccio su zona giorno. Parquet in tutta la casa, arredi moderni.'),
(6, 'Trentino', 'Trento', 'Pinzolo', 'Pra Rodont', 52, 'villa', 150, 2, 2, 'posto_auto', 'privato', 1, 0, 1, 0, 0, 1, 1, 700000, 'Piccolo chalet moderno in contesto esclusivo in località sciistica. Completo di abbaini e lucernari. Al primo piano rialzato dispone di studio, bagno, in un unico spazio cucina, zona pranzo e salotto. Al secondo piano mansardato due camere da letto e un bagno. Ottimo come seconda casa.'),
(7, 'Veneto', 'Vicenza', 'Bassano del Grappa', 'Dell\'Asparagina', 20, 'villa', 160, 3, 2, 'posto_auto', 'privato', 1, 1, 1, 0, 0, 1, 1, 460000, 'Si propone villino moderno completo di tutte le comodità. Essendo costruita con componenti prefabbricate, permette costi contenuti e un’alta efficienza energetica. Comoda metratura e spazio esterno attrezzato.'),
(8, 'Veneto', 'Padova', 'Padova', 'Viale Parigi', 105, 'appartamento', 135, 2, 1, NULL, 'comune', 0, 0, 0, 1, 0, 1, 1, 550000, 'Luminoso appartamento dalle ampie metrature situato in una palazzina di recente ristrutturazione e modernizzazione. Quartiere del centro, a pochi passi dai principali servizi, al piano terra dell’edificio sono presenti locali commerciali. Appartamento con ampio terrazzo, balconi, arredamento moderno e minimale. Gradevole e rilassante vialetto d’ingresso alla palazzina e giardino condominiale con fontane, aiuole e tavolini esterni. \r\nPossibilità di acquisto a parte di un garage interrato.'),
(9, 'Veneto', 'Vicenza', 'Asiago', 'Acidino', 1, 'villa', 250, 3, 3, 'posto_auto', 'privato', 1, 0, 1, 0, 1, 1, 1, 610000, 'Villino stile baita di montagna con particolare gioco di sporgenze in facciata. Recente ristrutturazione completa con ampliamento. Comodo posto auto doppio. Giardino privato riparato sul retro, completo di piscina, idromassaggio e zona living esterna con barbecue, divanetti e tavolo.'),
(10, 'Veneto', 'Treviso', 'San Polo di Piave', 'Tudor', 800, 'villa', 600, 4, 5, 'entrambi', 'privato', 1, 1, 1, 1, 1, 1, 1, 0, 'Prestigiosissimo castelletto in stile tudor revival di recente ristrutturazione e restauro. Completa di ogni agio, dispone inoltre di sala musica e concerti. All’esterno ampio giardino con spazi per orto, completa di capanno per ricovero piccoli attrezzi e laboratorio di artigianato. Attualmente identificata come dimora storica, può essere convertita in spazio per eventi e cerimonie. Trattativa riservata. '),
(11, 'Trentino', 'Trento', 'Cavalese', 'Viale Amburgo', 45, 'villa', 450, 5, 5, 'posto_auto', 'privato', 0, 1, 0, 0, 1, 1, 1, 2050000, 'Palazzina storica tirolese riconvertita in villa, recente restauro ed ampliamento. \r\nDotata di moderni sistemi di riscaldamento ed impiantistica, atmosfera accogliente con interni su misura. Comoda zona esterna con pedana solarium e zona pranzo coperta. Interessante posizione centrale a pochi passi dai principali servizi.\r\nPossibilità di divisione in più unità abitative indipendenti.'),
(12, 'Veneto', 'Padova', 'Padova', 'Viale Parigi', 106, 'appartamento', 135, 2, 1, NULL, 'comune', 0, 0, 0, 0, 0, 1, 0, 480000, 'Luminoso appartamento dalle ampie metrature situato in una palazzina di recente ristrutturazione e modernizzazione. Quartiere del centro, a pochi passi dai principali servizi, al piano terra dell’edificio sono presenti locali commerciali. Appartamento con ampio terrazzo, balconi. Gradevole e rilassante vialetto d’ingresso alla palazzina e giardino condominiale con fontane, aiuole e tavolini esterni. Possibilità di acquisto a parte di un garage interrato. Sistemi impiantistici moderni, parquet nuovo già posato, non arredato.'),
(13, 'Veneto', 'Padova', 'Padova', 'Viale Parigi', 107, 'attività_commerciale', 30, 0, 0, NULL, 'comune', 0, 1, 0, 0, 0, 0, 0, 0, 'Negozio piccolo vuoto.'),
(14, 'Veneto', 'Padova', 'Padova', 'Viale Parigi', 108, 'attività_commerciale', 50, 0, 0, NULL, 'comune', 0, 1, 0, 0, 0, 0, 0, 0, 'Negozio grande vuoto.'),
(15, 'Sardegna', 'Cagliari', 'Cagliari', 'Pardulas', 8, 'villa', 180, 1, 2, 'posto_auto', 'privato', 1, 1, 1, 0, 0, 1, 1, 520000, 'Modernissima villetta su due piani. Interessante come casa vacanze per affitto estivo o come prima casa per coppia o per singola persona, comprende ampia zona giorno con bagno di servizio, una camera con bagno e angolo studio. Possibilità di divisione spazi per ricavare più stanze, predisposizione per ampliamento. Particolarissima piscina nel giardino sul retro grazie alla presenza di sabbia bianca fine. Pochissimi chilometri dalle spiagge.'),
(16, 'Friuli', 'Udine', 'Tarvisio', 'A. Vinatzer', 99, 'villa', 220, 3, 2, 'posto_auto', 'privato', 1, 1, 1, 1, 1, 1, 1, 600000, 'Si propone ex fienile ristrutturato e riconvertito in villetta con ampio giardino attrezzato. Interni moderni in stile nordico. Prezzo trattabile.'),
(17, 'Trentino', 'Bolzano', 'Vipiteno', 'Eisack', 11, 'villa', 270, 3, 4, 'posto_auto', NULL, 0, 0, 1, 1, 0, 1, 1, 810000, 'Villetta in stile tipico di recente costruzione. Particolare inserimento in affluente del fiume Isarco. \r\nInterni e finiture di pregio, piano terra ampissima zona living open space.\r\nPosto auto compreso a pochi passi dall’abitazione. \r\nParticolare presenza di bagno con doccia di sabbia e locale sauna finestrato. \r\nOttimo compromesso tra città e montagna.'),
(18, 'Valle d\'Aosta', 'Aosta', 'Aosta', 'Viale Del Genepì', 10, 'villa', 180, 5, 3, 'garage', 'privato', 1, 0, 0, 0, 0, 0, 1, 650000, 'Grazioso villino unifamiliare ristrutturato in zona centralissima, a pochi passi dalle scuole. Divisione planimetrica ottimale, arredi funzionali. Possibilità di personalizzazione, capanno di deposito sul retro con potenziale, possibile conversione in garage coperto, in stanza studio o giardino. \r\nCamere di metratura ridotta ma accoglienti e luminose grazie agli infissi di pregio.'),
(19, 'Valle d\'Aosta', 'Aosta', 'Morgex', 'F. Brignone', 90, 'villa', 470, 5, 5, 'garage', 'privato', 1, 1, 1, 1, 1, 1, 1, 0, 'Modernissima baita di montagna ristrutturata, grandi vetrate, sistema impiantistico ad alta efficienza. Splendido giardino attrezzato, con piscina e vasca idromassaggio riscaldate, pedane solarium, barbecue, zona bar esterna. Interni moderni e raffinati, dispone di stanze studio. Possibilità di divisione in più unità abitative. Garage interrato. Trattativa riservata.'),
(20, 'Abruzzo', 'Teramo', 'Roseto degli Abruzzi', 'del Canneto', 20, 'appartamento', 120, 2, 1, 'garage', 'comune', 1, 1, 0, 1, 1, 1, 1, 450000, 'Si propone appartamento in complesso di nuova costruzione, vicinissimo alle spiagge. Interni moderni e minimali. Al piano terra è presente una zona spa e bar comune a tutte le unità abitative. Garage interrato.'),
(21, 'Abruzzo', 'Teramo', 'Roseto degli Abruzzi', 'del Canneto', 21, 'appartamento', 60, 1, 1, 'garage', 'comune', 1, 1, 0, 1, 1, 1, 1, 380000, 'Si propone appartamento in complesso di nuova costruzione, vicinissimo alle spiagge. Interni moderni e minimali. Al piano terra è presente una zona spa e bar comune a tutte le unità abitative. Garage interrato.'),
(22, 'Abruzzo', 'Teramo', 'Roseto degli Abruzzi', 'del Canneto', 22, 'appartamento', 150, 2, 2, 'garage', 'comune', 1, 1, 0, 1, 1, 1, 1, 500000, 'Si propone attico in complesso di nuova costruzione, vicinissimo alle spiagge. Interni moderni e minimali. Al piano terra è presente una zona spa e bar comune a tutte le unità abitative. Garage interrato.'),
(23, 'Emilia Romagna', 'Rimini', 'Riccione', 'Largo Delfino', 23, 'villa', 200, 3, 2, 'posto_auto', 'privato', 0, 1, 1, 1, 0, 1, 1, 520000, 'Moderna villetta in posizione strategica per le spiagge e i principali servizi. Disposizione planimetrica ottimale, luminosissimo, impiantistica ad alta efficienza. Finiture di qualità, parquet in tutte le zone della casa, pedana solarium esterna in assi di legno.\r\nPosto auto a pochi metri dall’abitazione.'),
(24, 'Emilia Romagna', 'Piacenza', 'Piacenza', 'Farnese', 24, 'attività_commerciale', 20, 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, 55000, 'Si vende locale commerciale con attività avviata di parrucchiere in palazzina da ristrutturare. Locale arredato e con un bagno di servizio.'),
(25, 'Liguria', 'Imperia', 'Sanremo', 'Narciso', 25, 'attività_commerciale', 20, 1, 0, NULL, NULL, 0, 0, 0, 0, 0, 1, 1, 50000, 'Si vende locale commerciale con attività avviata di fioreria in piccolo edificio singolo. Locale arredato con grandi vetrate e spazio esterno per esposizione.'),
(26, 'Campania', 'Salerno', 'Battipaglia', 'Pulcinella', 26, 'attività_commerciale', 20, 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 1, 40000, 'Si vende locale commerciale con attività avviata di pizzeria in piccolo edificio da ristrutturare. Locale arredato e con un bagno di servizio.'),
(27, 'Lombardia', 'Monza-Brianza', 'Monza', 'Cotonificio', 27, 'attività_commerciale', 50, 1, 1, 'posto_auto', NULL, 0, 0, 0, 1, 0, 0, 1, 150000, 'Si vende locale amministrativo con attività avviata di uffici direzionali di noto giornale. Inserito in palazzina storica di ex fabbrica. Locale arredato e con un bagno di servizio.');

-- --------------------------------------------------------

--
-- Table structure for table `casa_immagine`
--

CREATE TABLE `casa_immagine` (
  `id_immagine` int(10) NOT NULL,
  `id_casa` int(10) NOT NULL,
  `nome_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priorita` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_telefono` int(10) UNSIGNED DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `nome`, `cognome`, `mail`, `numero_telefono`, `isAdmin`) VALUES
('aaaaaaaaa', 'Password96-', 'nicola', 'contessa', 'email@email.com', 1234564890, 0),
('admin', 'admin', 'Martina', 'pluto', 'example2708@gmail.com', 3472637812, 1),
('bbbbbbbbb', 'Password96-', 'cacascsa', 'asdasd', 'pasdas@adasd', 123456789, 0),
('ttttttttttt', 'Password96-', 'maicasc', 'casdasd', 'test@email.com', 123456789, 0),
('user', 'user', 'Utente', 'Prova', 'example123@gmail.com', 3248283901, 0);

-- --------------------------------------------------------

--
-- Table structure for table `preferiti`
--

CREATE TABLE `preferiti` (
  `id_casa` int(50) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `preferiti`
--

INSERT INTO `preferiti` (`id_casa`, `username`) VALUES
(2, 'admin'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `richieste`
--

CREATE TABLE `richieste` (
  `id_casa` int(50) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `richiesta` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessioni`
--

CREATE TABLE `sessioni` (
  `id_sessione` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ultima_attivita` datetime NOT NULL,
  `logged` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sopralluoghi`
--

CREATE TABLE `sopralluoghi` (
  `id_casa` int(50) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `casa`
--
ALTER TABLE `casa`
  ADD PRIMARY KEY (`id_casa`);

--
-- Indexes for table `casa_immagine`
--
ALTER TABLE `casa_immagine`
  ADD PRIMARY KEY (`id_immagine`),
  ADD KEY `id_casa` (`id_casa`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `preferiti`
--
ALTER TABLE `preferiti`
  ADD PRIMARY KEY (`id_casa`,`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `richieste`
--
ALTER TABLE `richieste`
  ADD PRIMARY KEY (`id_casa`,`username`),
  ADD KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `sessioni`
--
ALTER TABLE `sessioni`
  ADD PRIMARY KEY (`id_sessione`);

--
-- Indexes for table `sopralluoghi`
--
ALTER TABLE `sopralluoghi`
  ADD PRIMARY KEY (`id_casa`,`username`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `casa_immagine`
--
ALTER TABLE `casa_immagine`
  MODIFY `id_immagine` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `casa_immagine`
--
ALTER TABLE `casa_immagine`
  ADD CONSTRAINT `casa_immagine_ibfk_1` FOREIGN KEY (`id_casa`) REFERENCES `casa` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `preferiti`
--
ALTER TABLE `preferiti`
  ADD CONSTRAINT `preferiti_ibfk_2` FOREIGN KEY (`username`) REFERENCES `login` (`username`),
  ADD CONSTRAINT `preferiti_id_casa` FOREIGN KEY (`id_casa`) REFERENCES `casa` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `richieste`
--
ALTER TABLE `richieste`
  ADD CONSTRAINT `richieste_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`),
  ADD CONSTRAINT `richieste_id_casa` FOREIGN KEY (`id_casa`) REFERENCES `casa` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sopralluoghi`
--
ALTER TABLE `sopralluoghi`
  ADD CONSTRAINT `sopralluoghi_ibfk_4` FOREIGN KEY (`username`) REFERENCES `login` (`username`),
  ADD CONSTRAINT `sopralluoghi_id_casa` FOREIGN KEY (`id_casa`) REFERENCES `casa` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
