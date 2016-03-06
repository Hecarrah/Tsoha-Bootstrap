INSERT INTO Kayttaja (name, password) VALUES ('Nönnönnöö', 'asd');
INSERT INTO Kayttaja (name, password, is_admin) VALUES ('Guru', 'leet', TRUE);
INSERT INTO Kayttaja (name, password, is_admin) VALUES ('Kalle', 'Erkki', TRUE);

INSERT INTO Ryhma (name) VALUES ('Test');

INSERT INTO Kayt_Ryhma (kayt_id, ryhma_id) VALUES (1,1);
INSERT INTO Kayt_Ryhma (kayt_id, ryhma_id) VALUES (2,1);

INSERT INTO Muistiinpano (name, description, added, priority, kayt_id) VALUES ('Osta Kaljaa', 'kännit' ,NOW(), 10, 1);
INSERT INTO Muistiinpano (name, description, added, kayt_id) VALUES ('Osta mehua', 'mehu loppu' ,NOW(), 2);
INSERT INTO RyhmaMuistiinpano (name, description, added, priority, kayt_id, ryh_id) VALUES ('Osta Ryhmälle mehua', 'mehu loppu' ,NOW(),10, 2, 1);