USE radiology;

INSERT INTO persons (person_id, first_name, last_name, address, email, phone)
VALUES (1, "blaine", "lewis", "a place", "someemail@place.com", "7801111111");


INSERT INTO users (user_name, password, class, person_id, date_registered)
VALUES ("blaine", "test", "a", 1, CURDATE());

INSERT INTO users (user_name, password, class, person_id, date_registered)
VALUES ("blainepatient", "test", "p", 1, CURDATE());

INSERT INTO users (user_name, password, class, person_id, date_registered)
VALUES ("blaineradiologist", "test", "r", 1, CURDATE());

INSERT INTO users (user_name, password, class, person_id, date_registered)
VALUES ("blainedoctor", "test", "d", 1, CURDATE());