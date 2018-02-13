--
-- CrimeTrack Database. Seeded from City of Chicago Crimes 2001 to Present
--
CREATE DATABASE `crime_s18`;
USE crime_s18;

# Import dataset into temporary table to seed real tables
CREATE TABLE temp_import_dataset (
	ID VARCHAR(255) NOT NULL,
	CASE_NUMBER VARCHAR(255) NOT NULL,
	DATE VARCHAR(255) NOT NULL,
	BLOCK VARCHAR(255) NOT NULL,
	IUCR VARCHAR(255) NOT NULL,
	PRIMARY_TYPE VARCHAR(255) NOT NULL,
	DESCRIPTION VARCHAR(255) NOT NULL,
	LOCATION_DESCRIPTION VARCHAR(255) NOT NULL,
	ARREST VARCHAR(255) NOT NULL,
	DOMESTIC VARCHAR(255) NOT NULL,
	BEAT VARCHAR(255) NOT NULL,
	DISTRICT VARCHAR(255) NOT NULL,
	WARD VARCHAR(255) NOT NULL,
	COMMUNITY_AREA VARCHAR(255) NOT NULL,
	FBI_CODE VARCHAR(255) NOT NULL,
	X_COORDINATE VARCHAR(255) NOT NULL,
	Y_COORDINATE VARCHAR(255) NOT NULL,
	YEAR VARCHAR(255) NOT NULL,
	UPDATED_ON VARCHAR(255) NOT NULL,
	LATITUDE VARCHAR(255) NOT NULL,
	LONGITUDE VARCHAR(255) NOT NULL,
	LOCATION VARCHAR(255) NOT NULL );

# chicago crimes dataset available from data.gov, not included in repo
LOAD DATA INFILE '/docker-entrypoint.d/Crimes_-_2001_to_present.csv' INTO TABLE temp_import_dataset IGNORE 1 LINES;

CREATE TABLE crimetrack_location_types (
	location_ID INT(11) AUTO_INCREMENT NOT NULL,
	location_desc VARCHAR(255)  NOT NULL,
	PRIMARY KEY(location_ID)
);

# seed locations from imported dataset
INSERT INTO crimetrack_location_types (location_desc) 
	SELECT DISTINCT LOCATION_DESCRIPTION FROM temp_import_dataset;

UPDATE temp_import_dataset 
JOIN crimetrack_location_types 
ON LOCATION_DESCRIPTION = location_desc SET LOCATION_DESCRIPTION = location_ID;

CREATE TABLE crimetrack_crime_type (
	IUCR_PK SMALLINT(3) NOT NULL,
	crime_type VARCHAR(255) NOT NULL,
	crime_description VARCHAR(255) NOT NULL,
	PRIMARY KEY(IUCR_PK)
);

INSERT INTO crimetrack_crime_type (IUCR_PK, crime_type, crime_description)
	SELECT DISTINCT IUCR, PRIMARY_TYPE, DESCRIPTION FROM temp_import_dataset;

CREATE TABLE crimetrack_chicago_community_areas (
	area_id SMALLINT(3) NOT NULL,
	community_name VARCHAR(255),
	population VARCHAR(255),
	income VARCHAR(255)
);

LOAD DATA INFILE '/docker-entrypoint.d/chicago-community-areas.csv' INTO TABLE crimetrack_chicago_community_areas IGNORE 1 LINES;

CREATE TABLE crimetrack_users (
	user_id INT(11) AUTO_INCREMENT NOT NULL,
	username VARCHAR(255) NOT NULL,
	password_hash VARCHAR(255) NOT NULL,
	userType ENUM("common", "admin") NOT NULL,
	PRIMARY KEY(user_id)
);

CREATE TABLE crimetrack_user_saved_areas (
	user_id INT(11) NOT NULL,
	area_id SMALLINT(3) NOT NULL,
	PRIMARY KEY(user_id, area_id)
);

CREATE TABLE crimetrack_user_saved_crime_types (
	user_id INT(11) NOT NULL,
	IUCR_PK SMALLINT(3) NOT NULL,
	PRIMARY KEY(user_id, IUCR_PK)
);
