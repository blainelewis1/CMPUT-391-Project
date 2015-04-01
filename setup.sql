/*
 *  File name:  setup.sql
 *  Function:   to create the initial database schema for the CMPUT 391 project,
 *              Winter Term, 2015
 *  Author:     Prof. Li-Yan Yuan
 */
DROP TABLE family_doctor;
DROP TABLE pacs_images;
DROP TABLE radiology_record;
DROP TABLE users;
DROP TABLE persons;
DROP TABLE classes;

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
);

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
);

/*
 *  to indicate who is whose family doctor.
 */
CREATE TABLE family_doctor (
   doctor_id    int,
   patient_id   int,
   FOREIGN KEY(doctor_id) REFERENCES persons(person_id),
   FOREIGN KEY(patient_id) REFERENCES persons(person_id),
   PRIMARY KEY(doctor_id,patient_id)
);

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
);

/*
 *  to store the pacs images
 */
CREATE TABLE pacs_images (
   record_id   int,
   image_id    int,
   thumbnail   blob,
   regular_size blob,
   full_size    blob,
   PRIMARY KEY(image_id),
   FOREIGN KEY(record_id) REFERENCES radiology_record(record_id)
);


/*
 * Maps classes to readable strings
 */

CREATE TABLE classes (
   class_name varchar(24),
   class_id char(1),
   PRIMARY KEY(class_id, class_name)
);


INSERT INTO classes (class_name, class_id) VALUES ('admin', 'a');
INSERT INTO classes (class_name, class_id) VALUES ('patient', 'p');
INSERT INTO classes (class_name, class_id) VALUES ('doctor', 'd');
INSERT INTO classes (class_name, class_id) VALUES ('radiologist', 'r');

/* auto increment
   http://stackoverflow.com/questions/11296361/how-to-create-id-with-auto-increment-on-oracle [blaine1 march 28 2015]
 */


DROP SEQUENCE record_seq;
CREATE SEQUENCE record_seq;

DROP TRIGGER record_incr;

CREATE TRIGGER record_incr 
BEFORE INSERT ON radiology_record
FOR EACH ROW

BEGIN
	SELECT record_seq.NEXTVAL
	INTO :new.record_id
	FROM dual;

END;
/


DROP SEQUENCE image_seq;
CREATE SEQUENCE image_seq;

DROP TRIGGER image_incr;

CREATE TRIGGER image_incr 
BEFORE INSERT ON pacs_images
FOR EACH ROW
BEGIN
	SELECT image_seq.NEXTVAL
	INTO :new.image_id
	FROM dual;

END;
/

/* Admin account */

INSERT INTO persons (person_id, first_name, last_name, address, email, phone)
VALUES (1, 'admin', 'admin', '', '', '');

INSERT INTO users (user_name, password, class, person_id, date_registered)
VALUES ('admin', 'admin', 'a', 1, SYSDATE);

/*
   added indices for text searching
*/

DROP INDEX diagnosis_index;
DROP INDEX description_index;
DROP INDEX first_index;
DROP INDEX last_index;

CREATE INDEX diagnosis_index ON radiology_record (diagnosis) indextype is ctxsys.context;
CREATE INDEX description_index ON radiology_record (description) indextype is ctxsys.context;
CREATE INDEX first_index ON persons (first_name) indextype is ctxsys.context;
CREATE INDEX last_index ON persons (last_name) indextype is ctxsys.context;

