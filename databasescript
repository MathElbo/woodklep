CREATE DATABASE IF NOT EXISTS woodklep;
USE woodklep;

CREATE TABLE IF NOT EXISTS woodklep_users (
userid INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
username VARCHAR (255),
userroleid INT NOT NULL,
salt VARCHAR (255) );

CREATE TABLE IF NOT EXISTS woodklep_personalinfo (
infoid INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR (255),
infix VARCHAR (255),
lastname VARCHAR(255),
birthday DATE,
streetname VARCHAR(255),
housenumber INT(6),
postalcode VARCHAR(6),
city VARCHAR(255),
userid int
);