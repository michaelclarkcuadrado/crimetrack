--
-- CrimeTrack Database. Seeded from City of Chicago Crimes 2001 to Present
-- Gettysburg College CS Database Course Project
--
CREATE DATABASE `crime_s18`;
USE crime_s18;

# Import dataset into temporary table to seed real tables
CREATE TABLE crimetrack_crimes (
  ID                   VARCHAR(255) NOT NULL,
  CASE_NUMBER          VARCHAR(255) NOT NULL,
  DATE                 VARCHAR(255) NOT NULL,
  STREET               VARCHAR(255) NOT NULL,
  IUCR                 VARCHAR(255) NOT NULL,
  PRIMARY_TYPE         VARCHAR(255) NOT NULL,
  DESCRIPTION          VARCHAR(255) NOT NULL,
  LOCATION_DESCRIPTION VARCHAR(255) NOT NULL,
  ARREST               VARCHAR(255) NOT NULL,
  DOMESTIC             VARCHAR(255) NOT NULL,
  BEAT                 VARCHAR(255) NOT NULL,
  DISTRICT             VARCHAR(255) NOT NULL,
  WARD                 VARCHAR(255) NOT NULL,
  COMMUNITY_AREA       INT(11)      NOT NULL,
  FBI_CODE             VARCHAR(255) NOT NULL,
  X_COORDINATE         VARCHAR(255) NOT NULL,
  Y_COORDINATE         VARCHAR(255) NOT NULL,
  YEAR                 VARCHAR(255) NOT NULL,
  UPDATED_ON           VARCHAR(255) NOT NULL,
  LATITUDE             VARCHAR(255) NOT NULL,
  LONGITUDE            VARCHAR(255) NOT NULL,
  LOCATION             VARCHAR(255) NOT NULL,
  PRIMARY KEY (ID),
  INDEX (LOCATION_DESCRIPTION),
  INDEX (IUCR, PRIMARY_TYPE, DESCRIPTION)
);

CREATE TABLE crimetrack_chicago_community_areas (
  area_id             INT(11)       NOT NULL,
  community_name      VARCHAR(255),
  population          VARCHAR(255),
  income              VARCHAR(255),
  race_percent_latino DECIMAL(3, 3) NOT NULL,
  race_percent_black  DECIMAL(3, 3) NOT NULL,
  race_percent_white  DECIMAL(3, 3) NOT NULL,
  race_percent_asian  DECIMAL(3, 3) NOT NULL,
  race_percent_other  DECIMAL(3, 3) NOT NULL,
  PRIMARY KEY (area_id)
);

LOAD DATA LOCAL INFILE '/docker-entrypoint-initdb.d/chicago-community-areas.csv' INTO TABLE crimetrack_chicago_community_areas
FIELDS TERMINATED BY ',' IGNORE 1 LINES;

ALTER TABLE `crimetrack_crimes`
  ADD CONSTRAINT `community_area_2_community` FOREIGN KEY (`COMMUNITY_AREA`) REFERENCES `crimetrack_chicago_community_areas` (`area_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

# chicago crimes dataset available from data.gov, not included in repo
# https://data.cityofchicago.org/api/views/ijzp-q8t2/rows.csv?accessType=DOWNLOAD
LOAD DATA LOCAL INFILE '/docker-entrypoint-initdb.d/Crimes_-_2001_to_present.csv' INTO TABLE crimetrack_crimes
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' IGNORE 1 LINES;

# delete unneeded columns
ALTER TABLE crimetrack_crimes
  DROP LOCATION,
  DROP BEAT,
  DROP FBI_CODE,
  DROP DISTRICT,
  DROP WARD,
  DROP CASE_NUMBER,
  DROP X_COORDINATE,
  DROP Y_COORDINATE,
  DROP YEAR,
  DROP UPDATED_ON;

#Update streets, strip out cross street info, index
UPDATE crimetrack_crimes SET STREET = SUBSTR(STREET, 7);
ALTER TABLE `crimetrack_crimes` ADD INDEX(`STREET`);

-- CREATE TABLE crimetrack_location_types (
--   location_ID   INT(11) AUTO_INCREMENT NOT NULL,
--   location_desc VARCHAR(255)           NOT NULL,
--   PRIMARY KEY (location_ID),
--   INDEX (location_desc)
-- );

CREATE TABLE crimetrack_crime_type (
  IUCR_PK           VARCHAR(10)  NOT NULL,
  crime_type        VARCHAR(255) NOT NULL,
  crime_description VARCHAR(255) NOT NULL,
  PRIMARY KEY (IUCR_PK)
);

-- # seed locations from imported dataset
-- INSERT INTO crimetrack_location_types (location_desc)
--   SELECT DISTINCT LOCATION_DESCRIPTION
--   FROM crimetrack_crimes;

-- UPDATE crimetrack_crimes
--   JOIN crimetrack_location_types
--     ON LOCATION_DESCRIPTION = location_desc
-- SET LOCATION_DESCRIPTION = location_ID;

-- ALTER TABLE crimetrack_crimes
--   CHANGE `LOCATION_DESCRIPTION` `LOCATION_ID` INT(11) NOT NULL;
-- ALTER TABLE crimetrack_crimes
--   ADD CONSTRAINT `location_2_location_type` FOREIGN KEY (`LOCATION_ID`) REFERENCES `crimetrack_location_types` (`location_ID`)
--   ON DELETE RESTRICT
--   ON UPDATE RESTRICT;

INSERT INTO crimetrack_crime_type (IUCR_PK, crime_type, crime_description)
  SELECT DISTINCT
    IUCR,
    PRIMARY_TYPE,
    DESCRIPTION
  FROM crimetrack_crimes GROUP BY IUCR;

ALTER TABLE crimetrack_crimes
  DROP PRIMARY_TYPE,
  DROP DESCRIPTION;
ALTER TABLE crimetrack_crimes
  ADD CONSTRAINT `iucr_2_crime_type` FOREIGN KEY (`IUCR`) REFERENCES `crimetrack_crime_type` (`IUCR_PK`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

CREATE TABLE crimetrack_users (
  user_id       INT(11) AUTO_INCREMENT   NOT NULL,
  username      VARCHAR(255)             NOT NULL,
  email         VARCHAR(255)             NOT NULL,
  password_hash VARCHAR(255)             NOT NULL,
  userType      ENUM ("common", "admin") NOT NULL,
  PRIMARY KEY (user_id)
);

CREATE TABLE crimetrack_user_saved_areas (
  user_id INT(11)     NOT NULL,
  area_id INT(11) NOT NULL,
  PRIMARY KEY (user_id, area_id)
);
ALTER TABLE `crimetrack_user_saved_areas`
  ADD FOREIGN KEY (`user_id`) REFERENCES `crimetrack_users` (`user_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

ALTER TABLE `crimetrack_user_saved_areas`
  ADD FOREIGN KEY (`area_id`) REFERENCES `crimetrack_chicago_community_areas` (`area_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

CREATE TABLE crimetrack_user_saved_crime_types (
  user_id INT(11)     NOT NULL,
  IUCR_PK VARCHAR(10) NOT NULL,
  PRIMARY KEY (user_id, IUCR_PK)
);

ALTER TABLE `crimetrack_user_saved_crime_types`
  ADD FOREIGN KEY (`IUCR_PK`) REFERENCES `crimetrack_crime_type` (`IUCR_PK`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

ALTER TABLE `crimetrack_user_saved_crime_types`
  ADD FOREIGN KEY (`user_id`) REFERENCES `crimetrack_users` (`user_id`)
  ON DELETE RESTRICT
  ON UPDATE RESTRICT;

