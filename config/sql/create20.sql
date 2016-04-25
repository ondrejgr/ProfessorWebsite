IF NOT EXISTS(SELECT TOP 1 1 FROM DbInfo WHERE InfoKey = 'DbVersion')
BEGIN
    INSERT INTO DbInfo (InfoKey, InfoValue) VALUES ('DbVersion', 'GRATZ-AAA');
END