

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