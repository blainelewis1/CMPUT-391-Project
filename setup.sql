CREATE DATABASE IF NOT EXISTS radiology;
USE radiology;


/*
 *  File name:  setup.sql
 *  Function:   to create the initial database schema for the CMPUT 391 project,
 *              Winter Term, 2015
 *  Author:     Prof. Li-Yan Yuan
 */
DROP TABLE if exists family_doctor;
DROP TABLE if exists pacs_images;
DROP TABLE if exists radiology_record;
DROP TABLE if exists users;
DROP TABLE if exists persons;
DROP TABLE if exists classes;

/*
 *  To store the personal information
 */
CREATE TABLE persons (
   person_id int,
   first_name varchar(24),
   last_name  varchar(24),
   address    varchar(128),
   email      varchar(128),
   phone      char(10),
   PRIMARY KEY(person_id),
   UNIQUE (email)
) ENGINE=INNODB;

/*
 *  To store the log-in information
 *  Note that a person may have been assigned different user_name(s), depending
 *  on his/her role in the log-in  
 */
CREATE TABLE users (
   user_name varchar(24),
   password  varchar(24),
   class     char(1),
   person_id int,
   date_registered date,
   CHECK (class in ('a','p','d','r')),
   PRIMARY KEY(user_name),
   FOREIGN KEY (person_id) REFERENCES persons(person_id)
) ENGINE=INNODB;

/*
 *  to indicate who is whose family doctor.
 */
CREATE TABLE family_doctor (
   doctor_id    int,
   patient_id   int,
   FOREIGN KEY(doctor_id) REFERENCES persons(person_id),
   FOREIGN KEY(patient_id) REFERENCES persons(person_id),
   PRIMARY KEY(doctor_id,patient_id)
) ENGINE=INNODB;

/*
 *  to store the radiology records
 */
CREATE TABLE radiology_record (
   record_id   int,
   patient_id  int,
   doctor_id   int,
   radiologist_id int,
   test_type   varchar(24),
   prescribing_date date,
   test_date    date,
   diagnosis    varchar(128),
   description   varchar(1024),
   PRIMARY KEY(record_id),
   FOREIGN KEY(patient_id) REFERENCES persons(person_id),
   FOREIGN KEY(doctor_id) REFERENCES  persons(person_id),
   FOREIGN KEY(radiologist_id) REFERENCES  persons(person_id)
) ENGINE=INNODB;

/*
 *  to store the pacs images
 */
CREATE TABLE pacs_images (
   record_id   int,
   image_id    int,
   thumbnail   blob,
   regular_size blob,
   full_size    blob,
   PRIMARY KEY(record_id,image_id),
   FOREIGN KEY(record_id) REFERENCES radiology_record(record_id)
) ENGINE=INNODB;


/*
 * Maps classes to readable strings
 * TODO: remove if not needed
 */

CREATE TABLE classes (
   class_name varchar(24),
   class_id char(1),
   PRIMARY KEY(class_id, class_name)
) ENGINE=INNODB;

INSERT INTO classes (class_name, class_id) VALUES 
('admin', 'a'), 
('patient', 'p'), 
('doctor', 'd'), 
('radiologist', 'r');
