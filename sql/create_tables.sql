CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL,
    password varchar(50) NOT NULL
);

CREATE TABLE Muistiinpano(
    id SERIAL PRIMARY KEY,
    kayt_id INTEGER REFERENCES Kayttaja(id),
    name varchar(50) NOT NULL,
    description varchar(500),
    added DATE,
    done boolean DEFAULT FALSE,
);