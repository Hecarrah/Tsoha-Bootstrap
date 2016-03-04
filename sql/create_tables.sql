CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL,
    password varchar(50) NOT NULL,
    is_admin boolean DEFAULT FALSE
);

CREATE TABLE Ryhma(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL
);

CREATE TABLE Kayt_ryhma(
    kayt_id SERIAL REFERENCES Kayttaja(id),
    ryhma_id SERIAL REFERENCES Ryhma(id),
    CONSTRAINT kayt_id_pkey PRIMARY KEY (kayt_id, ryhma_id)
);

CREATE TABLE Muistiinpano(
    id SERIAL PRIMARY KEY,
    kayt_id SERIAL REFERENCES Kayttaja(id),
    name varchar(50) NOT NULL,
    description varchar(500),
    added DATE,
    priority varchar(50) default 'Normaali'
);
CREATE TABLE RyhmaMuistiinpano(
    id SERIAL PRIMARY KEY,
    kayt_id SERIAL REFERENCES Kayttaja(id),
    ryh_id SERIAL REFERENCES Ryhma(id),
    name varchar(50) NOT NULL,
    description varchar(500),
    added DATE,
    priority varchar(50) default 'Normaali'
);