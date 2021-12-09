CREATE DATABASE IF NOT EXISTS woodklep;
USE woodklep;


-- drop table woodklep_users;
CREATE TABLE IF NOT EXISTS woodklep_users (
userid INT NOT NULL AUTO_INCREMENT,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
username VARCHAR (255),
userroleid INT NOT NULL,
salt VARCHAR (255),
PRIMARY KEY (userid)
);


-- drop table woodklep_personalinfo;
CREATE TABLE IF NOT EXISTS woodklep_personalinfo (
infoid INT NOT NULL AUTO_INCREMENT,
name VARCHAR (255),
infix VARCHAR (255),
lastname VARCHAR(255),
birthday DATE,
streetname VARCHAR(255),
housenumber INT(6),
postalcode VARCHAR(6),
city VARCHAR(255),
userid int,
PRIMARY KEY (infoid),
FOREIGN KEY (userid) REFERENCES woodklep_users(userid)
);

-- Alle Nieuwe ID's zullen vanaf hier een lage streep/ underscore gebruiken

CREATE TABLE IF NOT EXISTS huiswerk_vraag (
vraag_id INT NOT NULL AUTO_INCREMENT,
vraag VARCHAR (255),
antwoord VARCHAR (255),
PRIMARY KEY (vraag_id)
);

CREATE TABLE IF NOT EXISTS huiswerk_opdrachten (
opdracht_id INT NOT NULL AUTO_INCREMENT,
opdracht_naam VARCHAR (255),
PRIMARY KEY (opdracht_id)
);

CREATE TABLE IF NOT EXISTS opdrachtvraag_koppel (
ov_koppel INT NOT NULL AUTO_INCREMENT,
opdracht_id INT,
vraag_id INT,
PRIMARY KEY (ov_koppel),
FOREIGN KEY (opdracht_id) REFERENCES huiswerk_opdrachten(opdracht_id),
FOREIGN KEY (vraag_id) REFERENCES huiswerk_vraag(vraag_id)
);


CREATE TABLE IF NOT EXISTS klas (
klas_id INT NOT NULL AUTO_INCREMENT,
klasnaam VARCHAR(255),
PRIMARY KEY (klas_id)
);

CREATE TABLE IF NOT EXISTS hw_klas_koppel (
hwklas_id INT NOT NULL AUTO_INCREMENT,
hw_opdracht_id INT,
klas_id INT,
PRIMARY KEY (hwklas_id),
FOREIGN KEY (hw_opdracht_id) REFERENCES huiswerk_opdrachten(opdracht_id),
FOREIGN KEY (klas_id) REFERENCES klas(klas_id)
);

CREATE TABLE IF NOT EXISTS user_klas_koppel (
userid INT,
klas_id INT,
FOREIGN KEY (userid) REFERENCES woodklep_users(userid),
FOREIGN KEY (klas_id) REFERENCES klas(klas_id)
);

CREATE TABLE IF NOT EXISTS ouder_student_koppel (
parentid INT,
studentid INT,
FOREIGN KEY (parentid) REFERENCES woodklep_users(userid),
FOREIGN KEY (studentid) REFERENCES woodklep_users(userid)
);

CREATE TABLE IF NOT EXISTS woodklep (
wk_id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY (wk_id)
);

CREATE TABLE IF NOT EXISTS wk_ouder_koppel (
wk_id INT,
parentid INT,
FOREIGN KEY (wk_id) REFERENCES woodklep(wk_id),
FOREIGN KEY (parentid) REFERENCES woodklep_users(userid)
);

CREATE TABLE IF NOT EXISTS student_antwoord (
studentid INT,
vraag_id INT,
antwoord VARCHAR(255),
FOREIGN KEY (studentid) REFERENCES woodklep_users(userid),
FOREIGN KEY (vraag_id) REFERENCES huiswerk_vraag(vraag_id)
);

CREATE TABLE IF NOT EXISTS student_opdracht_voortgang(
sov_id INT NOT NULL AUTO_INCREMENT,
studentid INT,
opdracht_id INT,
gemaakt BOOLEAN,
PRIMARY KEY (sov_id),
FOREIGN KEY (studentid) REFERENCES woodklep_users(userid),
FOREIGN KEY (opdracht_id) REFERENCES huiswerk_opdrachten(opdracht_id)
);