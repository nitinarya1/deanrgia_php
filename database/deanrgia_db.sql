-- ============================================================
-- Dean RGIA - MNNIT Allahabad
-- Database: deanrgia_db
-- Import this file in phpMyAdmin
-- ============================================================

CREATE DATABASE IF NOT EXISTS `deanrgia_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `deanrgia_db`;

-- ============================================================
-- TABLE: admins
-- ============================================================
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: announcements
-- ============================================================
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `content` TEXT DEFAULT NULL,
  `link` VARCHAR(1000) DEFAULT '',
  `date` DATE DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `is_new` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: contacts
-- ============================================================
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(500) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: deans
-- ============================================================
CREATE TABLE IF NOT EXISTS `deans` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `designation` VARCHAR(255) DEFAULT 'Dean (R G & IA)',
  `department` VARCHAR(255) DEFAULT '',
  `tenure` VARCHAR(255) NOT NULL,
  `image` VARCHAR(1000) DEFAULT '',
  `bio` TEXT DEFAULT NULL,
  `profile_link` VARCHAR(1000) DEFAULT '',
  `email` VARCHAR(255) DEFAULT '',
  `display_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: mous
-- ============================================================
CREATE TABLE IF NOT EXISTS `mous` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `institution` VARCHAR(500) NOT NULL,
  `country` VARCHAR(255) NOT NULL,
  `date` VARCHAR(50) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: publications
-- ============================================================
CREATE TABLE IF NOT EXISTS `publications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(1000) DEFAULT '',
  `link` VARCHAR(1000) DEFAULT '',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: slideshows
-- ============================================================
CREATE TABLE IF NOT EXISTS `slideshows` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `image_url` VARCHAR(1000) NOT NULL,
  `caption` VARCHAR(500) DEFAULT '',
  `display_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: souvenirs
-- ============================================================
CREATE TABLE IF NOT EXISTS `souvenirs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(500) NOT NULL,
  `year` INT NOT NULL,
  `description` TEXT DEFAULT NULL,
  `pdf_link` VARCHAR(1000) DEFAULT '#',
  `category` ENUM('Convocation','Alumni') DEFAULT 'Convocation',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: team
-- ============================================================
CREATE TABLE IF NOT EXISTS `team` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  `department` VARCHAR(255) DEFAULT '',
  `image` VARCHAR(1000) DEFAULT '',
  `profile_link` VARCHAR(1000) DEFAULT '',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================================
-- SEED DATA
-- ============================================================

-- Admin user: Admin / drgia123
-- Password hash generated with PHP password_hash('drgia123', PASSWORD_DEFAULT)
INSERT INTO `admins` (`username`, `password`) VALUES
('Admin', '$2y$10$TJkLA7gKcWEYn20TJ5bkk.xnsSFOYRHq3CEOUf/WY.ni37/CgZMe.');

-- Deans
INSERT INTO `deans` (`name`, `designation`, `department`, `tenure`, `image`, `bio`, `display_order`) VALUES
('Prof. Sudarshan Tiwari', 'Dean (R G & IA)', 'MNNIT Allahabad', '11.08.2011 to 31.07.2012', 'public/placeholder-professor.svg', 'Served as the first Dean of Resource Generation and International Affairs at MNNIT Allahabad.', 1),
('Prof. Dinesh Chandra', 'Dean (R G & IA)', 'MNNIT Allahabad', '01.08.2012 to 31.07.2014', 'public/placeholder-professor.svg', 'Contributed significantly to strengthening international academic partnerships during his tenure.', 2),
('Prof. N. D. Pandey', 'Dean (R G & IA)', 'MNNIT Allahabad', '01.08.2014 to 31.07.2016', 'public/placeholder-professor.svg', 'Focused on resource mobilization and establishing new MoU agreements with international institutions.', 3),
('Prof. M. M. Gore', 'Dean (R G & IA)', 'Computer Science & Engineering, MNNIT Allahabad', '01.08.2016 to 31.07.2018', 'public/placeholder-professor.svg', 'Expanded the scope of international affairs and facilitated several faculty exchange programs.', 4),
('Prof. A. K. Singh', 'Dean (R G & IA)', 'MNNIT Allahabad', '01.08.2018 to 31.07.2020', 'public/placeholder-professor.svg', 'Strengthened alumni relations and initiated new resource generation programs during his tenure.', 5),
('Prof. Geetika', 'Dean (R G & IA) Ex-Officio', 'S.M.S Department, MNNIT Allahabad', '01.08.2020 to 11.03.2021', 'public/placeholder-professor.svg', 'Professor, S.M.S Deptt. MNNIT Allahabad. Served as Dean RGIA in additional charge capacity.', 6),
('Prof. Geetika', 'Dean (R G & IA)', 'S.M.S Department, MNNIT Allahabad', '12.03.2021 to 11.09.2023', 'public/placeholder-professor.svg', 'Continued her dedicated service as full Dean RGIA, overseeing major international collaborations.', 7),
('Prof. Mukul Shukla', 'Dean (R G & IA)', 'MNNIT Allahabad', '12.09.2023 to 30.12.2023', 'public/placeholder-professor.svg', 'Contributed to ongoing institutional development and international partnership initiatives.', 8),
('Prof. Shubhi Purwar', 'Dean (R G & IA)', 'MNNIT Allahabad', '31.12.2023 to 30.12.2025', 'public/placeholder-professor.svg', 'Led various resource generation initiatives and fostered new international academic connections.', 9),
('Prof. M. M. Gore', 'Dean (R G & IA)', 'Computer Science & Engineering, MNNIT Allahabad', '31.12.2025 - Present', 'public/placeholder-professor.svg', 'Currently serving as Dean RGIA, bringing extensive experience from his previous tenure to drive new initiatives.', 10);

-- Announcements
INSERT INTO `announcements` (`title`, `content`, `link`, `date`, `is_active`, `is_new`) VALUES
('Applications open for International Student Exchange Program 2026', 'MNNIT Allahabad invites applications for the International Student Exchange Program with partner universities in Japan, Germany, and Singapore.', '', '2026-03-20', 1, 1),
('MNNIT signs MoU with University of Cambridge for Joint Research', 'A new MoU has been signed with the University of Cambridge for collaborative research in AI and ML.', '', '2026-03-15', 1, 1),
('Annual Alumni Meet 2026 - Registration Open', 'Alumni from all batches are cordially invited to the Annual Alumni Meet scheduled for April 2026.', '', '2026-03-10', 1, 1),
('19th Annual Convocation - Date Announced', 'The 19th Annual Convocation of MNNIT Allahabad will be held on May 15, 2026.', '', '2026-03-05', 1, 0),
('Faculty Development Program on Emerging Technologies', 'A week-long FDP on Emerging Technologies in collaboration with IIT Delhi is scheduled for June 2026.', '', '2026-02-28', 1, 0);

-- Slideshow
INSERT INTO `slideshows` (`image_url`, `caption`, `display_order`, `is_active`) VALUES
('public/mnnit-campus.png', 'MNNIT Allahabad - Main Campus', 1, 1),
('public/mnnit-campus.png', 'Fostering Global Partnerships', 2, 1),
('public/mnnit-campus.png', 'Excellence in Education & Research', 3, 1);

-- Publications
INSERT INTO `publications` (`title`, `author`, `description`, `image`) VALUES
('Fundamental of Mechanical Sciences', 'Dr. Paul Ranjan', 'Gives a complete step by step knowledge of mechanical sciences to strengthen your basics.', ''),
('Data Structures', 'Dr. Dharmender Singh Kushwaha', 'A Programming Approach with C, Prentice Hall of India Second Edition - 2014', ''),
('Investigations on Electroacoustic Transducers', 'Dr. S. J. Pawar', 'This work attempts to decorate the exploding field of Electroacoustic Transducers.', ''),
('Advanced Engineering Mathematics', 'Dr. R. K. Sharma', 'Comprehensive textbook covering differential equations, linear algebra, complex analysis.', '');

-- MoUs
INSERT INTO `mous` (`institution`, `country`, `date`, `description`, `status`) VALUES
('University of Tokyo', 'Japan', '2023-06-15', 'Academic exchange and joint research collaboration in the fields of Computer Science and Mechanical Engineering.', 'Active'),
('Technical University of Munich', 'Germany', '2022-11-20', 'Student and faculty exchange program with collaborative research in Renewable Energy Technologies.', 'Active'),
('National University of Singapore', 'Singapore', '2023-01-10', 'Joint PhD program and research collaboration in Artificial Intelligence and Data Science.', 'Active'),
('University of Melbourne', 'Australia', '2021-08-05', 'Research collaboration in Civil Engineering and Sustainable Infrastructure Development.', 'Active'),
('MIT', 'USA', '2024-02-14', 'Faculty development program and joint workshops in Emerging Technologies.', 'Active');

-- Team
INSERT INTO `team` (`name`, `role`, `department`, `image`) VALUES
('Prof. Geetika', 'Dean (R G & IA) Ex-Officio', 'S.M.S Department, MNNIT Allahabad', 'public/placeholder-professor.svg'),
('Manisha Yadav', 'Asst. Registrar (R G & IA) Ex-Officio', 'MNNIT Allahabad', 'public/placeholder-professor.svg'),
('Dr. Rajesh Kumar', 'Associate Dean', 'International Affairs', 'public/placeholder-professor.svg'),
('Dr. Priya Sharma', 'Faculty Coordinator', 'Resource Generation', 'public/placeholder-professor.svg');

-- Souvenirs
INSERT INTO `souvenirs` (`title`, `year`, `description`, `pdf_link`, `category`) VALUES
('Annual Convocation Souvenir 2024', 2024, 'Souvenir released during the 18th Annual Convocation of MNNIT Allahabad.', '#', 'Convocation'),
('Annual Convocation Souvenir 2023', 2023, 'Souvenir released during the 17th Annual Convocation of MNNIT Allahabad.', '#', 'Convocation'),
('Annual Convocation Souvenir 2022', 2022, 'Souvenir released during the 16th Annual Convocation of MNNIT Allahabad.', '#', 'Convocation'),
('Alumni Meet Souvenir 2024', 2024, 'Special souvenir from the Global Alumni Meet 2024.', '#', 'Alumni'),
('Alumni Meet Souvenir 2023', 2023, 'Commemorative souvenir from the Annual Alumni Reunion.', '#', 'Alumni');
