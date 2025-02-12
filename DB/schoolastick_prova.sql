-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 12, 2025 alle 12:52
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolastick_prova`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `luoghi`
--

CREATE TABLE `luoghi` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` enum('Laboratorio','Aula','Bagno','Palestra') NOT NULL,
  `piano_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `luoghi`
--

INSERT INTO `luoghi` (`id`, `nome`, `tipo`, `piano_id`) VALUES
(1, 'Aula 1', 'Aula', 1),
(2, 'Aula 5', 'Laboratorio', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `piani`
--

CREATE TABLE `piani` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sede_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `piani`
--

INSERT INTO `piani` (`id`, `nome`, `sede_id`) VALUES
(1, 'Primo Piano', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `sedi`
--

CREATE TABLE `sedi` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `sedi`
--

INSERT INTO `sedi` (`id`, `nome`) VALUES
(1, 'ITT');

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazioni`
--

CREATE TABLE `segnalazioni` (
  `id` int(11) NOT NULL,
  `descrizione` text NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `report` text DEFAULT NULL,
  `stato` enum('Nuova','In corso','Completa','Archiviata') DEFAULT 'Nuova',
  `id_utente_crea` int(11) DEFAULT NULL,
  `id_utente_lavora` int(11) DEFAULT NULL,
  `id_utente_completa` int(11) DEFAULT NULL,
  `luogo_id` int(11) NOT NULL,
  `cateogria` enum('Riparare','Sostituire','Pulire') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `segnalazioni`
--

INSERT INTO `segnalazioni` (`id`, `descrizione`, `data_creazione`, `report`, `stato`, `id_utente_crea`, `id_utente_lavora`, `id_utente_completa`, `luogo_id`, `cateogria`) VALUES
(1, 'NOn funziona', '2025-02-12 11:20:49', NULL, 'Nuova', 14, NULL, NULL, 1, NULL),
(2, 'Ciao TONIN', '2025-02-12 11:23:17', NULL, 'Nuova', 14, NULL, NULL, 1, NULL),
(3, 'ngn', '2025-02-12 11:34:46', NULL, 'Nuova', 14, NULL, NULL, 2, NULL),
(4, 'nero', '2025-02-12 11:49:29', NULL, 'Nuova', 14, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo` enum('Studente','Docente','Tecnico','Amministratore') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `email`, `password`, `tipo`) VALUES
(6, 'Uilian', 'uilian@gmail.com', '1234', 'Studente'),
(10, 'Andrea', 'andrea@gmail.com', '12345', 'Studente'),
(11, 'Mattia', 'mattia@azienda.com', '$2y$10$gQOo9eumM3w5XnfIjHbgruph4bHZ8w/hL3tGTB86MY2iW817d6qGy', 'Studente'),
(12, 'Roberto', 'roberto@azienda.com', '$2y$10$ch3MZyxu3ZgkgqVquH9c9eYAnRU1E51X15kGewhlkZ5uD4vZ5M5ye', 'Studente'),
(13, 'Andrei', 'andrei@azienda.com', '$2y$10$4sq1DrrW0LqHwe8qHHnB5.AFeAtJj6/zPTB.ZFDzngK315xm5V58W', 'Studente'),
(14, 'Uilian', 'uilian@iisvittorioveneto.it', '$2y$10$RfpUfYSrbYYtOXB9nVgkSuEMnlX.a3jODr9PlaGOpEFCr.0u/nxKq', 'Docente');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `luoghi`
--
ALTER TABLE `luoghi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `piano_id` (`piano_id`);

--
-- Indici per le tabelle `piani`
--
ALTER TABLE `piani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sede_id` (`sede_id`);

--
-- Indici per le tabelle `sedi`
--
ALTER TABLE `sedi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `segnalazioni`
--
ALTER TABLE `segnalazioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente_crea` (`id_utente_crea`),
  ADD KEY `id_utente_lavora` (`id_utente_lavora`),
  ADD KEY `id_utente_completa` (`id_utente_completa`),
  ADD KEY `luogo_id` (`luogo_id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `luoghi`
--
ALTER TABLE `luoghi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `piani`
--
ALTER TABLE `piani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `sedi`
--
ALTER TABLE `sedi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `segnalazioni`
--
ALTER TABLE `segnalazioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `luoghi`
--
ALTER TABLE `luoghi`
  ADD CONSTRAINT `luoghi_ibfk_1` FOREIGN KEY (`piano_id`) REFERENCES `piani` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `piani`
--
ALTER TABLE `piani`
  ADD CONSTRAINT `piani_ibfk_1` FOREIGN KEY (`sede_id`) REFERENCES `sedi` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `segnalazioni`
--
ALTER TABLE `segnalazioni`
  ADD CONSTRAINT `segnalazioni_ibfk_1` FOREIGN KEY (`id_utente_crea`) REFERENCES `utenti` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `segnalazioni_ibfk_2` FOREIGN KEY (`id_utente_lavora`) REFERENCES `utenti` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `segnalazioni_ibfk_3` FOREIGN KEY (`id_utente_completa`) REFERENCES `utenti` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `segnalazioni_ibfk_4` FOREIGN KEY (`luogo_id`) REFERENCES `luoghi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
