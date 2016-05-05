INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('DbVersion', 'GRATZ-AAA');

INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('Title', 'Jennifer Doe Web Page');

INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('FirstName', 'Jennifer');
INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('LastName', 'Doe');
INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('UniversityName', 'Stanford University');
INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('FacultyName', 'Marketing and Ormond Family Faculty');
INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('Password', 'cd2eb0837c9b4c962c22d2ff8b5441b7b45805887f051d39bf133b583baf6860');
INSERT IGNORE INTO DbInfo (InfoKey, InfoValue) VALUES ('Email', 'jennifer.doe@no-me.com');

INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('PageNotFound', 'Page Not Found', 0);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('Login', 'Login', 0);

INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('AboutMe', 'About Me', 1);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('Research', 'Research', 2);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('Publications', 'Publications', 3);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('Teaching', 'Teaching', 4);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('Gallery', 'Gallery', 5);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('Contact', 'Contact', 6);
INSERT IGNORE INTO Pages (Name, Title, NavIndex) VALUES ('DownloadCV', 'Download CV', 7);

INSERT IGNORE INTO Pages (Name, Title, NavIndex, IsAdmin) VALUES ('Logout', 'Logout', 8, 1);

