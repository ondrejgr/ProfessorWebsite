DROP TABLE IF EXISTS DbInfo;
CREATE TABLE IF NOT EXISTS DbInfo (
    InfoKey NVARCHAR(30) PRIMARY KEY NOT NULL,
    InfoValue NVARCHAR(100) NULL) COLLATE 'utf8_czech_ci';

CREATE OR REPLACE VIEW DbInfoView AS
(SELECT 
	(SELECT InfoValue FROM DbInfo WHERE InfoKey = 'FirstName') FirstName,
    (SELECT InfoValue FROM DbInfo WHERE InfoKey = 'LastName') LastName,
    CONCAT((SELECT InfoValue FROM DbInfo WHERE InfoKey = 'FirstName'), ' ', (SELECT InfoValue FROM DbInfo WHERE InfoKey = 'LastName')) FullName,
    (SELECT InfoValue FROM DbInfo WHERE InfoKey = 'UniversityName') UniversityName,
    (SELECT InfoValue FROM DbInfo WHERE InfoKey = 'FacultyName') FacultyName,
    (SELECT InfoValue FROM DbInfo WHERE InfoKey = 'Email') Email);

DROP TABLE IF EXISTS Pages;
CREATE TABLE IF NOT EXISTS Pages (
    Name NVARCHAR(30) PRIMARY KEY NOT NULL,
    Title NVARCHAR(100) NOT NULL,
    NavIndex INT NOT NULL DEFAULT 0,
    IsAdmin BIT NOT NULL DEFAULT 0
) COLLATE 'utf8_czech_ci';

DROP TABLE IF EXISTS ContentPages;
CREATE TABLE IF NOT EXISTS ContentPages (
    Name NVARCHAR(30) PRIMARY KEY NOT NULL,
    Content TEXT NULL
) COLLATE 'utf8_czech_ci';

DROP TABLE IF EXISTS AcademicPositions;
CREATE TABLE IF NOT EXISTS AcademicPositions (
    ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Period NVARCHAR(30) NOT NULL,
    Position NVARCHAR(50) NULL,
    Place NVARCHAR(100) NULL
) COLLATE 'utf8_czech_ci';
