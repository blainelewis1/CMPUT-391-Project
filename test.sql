


SELECT record_id, 
6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2) myrank,
LISTAGG(image_id, ',') WITHIN GROUP (ORDER BY image_id) images
FROM radiology_record JOIN 
persons ON radiology_record.patient_id = persons.person_id JOIN
pacs_images ON pacs_images.record_id = radiology_record.record_id
WHERE CONTAINS(diagnosis, ':diagnosis', 1) > 0 OR
CONTAINS(description, ':description', 2) > 0 OR
CONTAINS(first_name, ':first_name', 3) > 0 OR
CONTAINS(last_name, ':last_name', 4) > 0
GROUP BY record_id
ORDER BY myrank;


SELECT radiology_record.record_id, 
	AVG(6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2)) myrank, 
	LISTAGG(pacs_images.image_id, ',') WITHIN GROUP (ORDER BY pacs_images.image_id) images 
FROM radiology_record JOIN 
	persons ON radiology_record.patient_id = persons.person_id JOIN 
	pacs_images ON pacs_images.record_id = radiology_record.record_id 
WHERE CONTAINS(radiology_record.diagnosis, 'cancer', 1) > 0 OR 
	CONTAINS(radiology_record.description, 'cancer', 2) > 0 OR 
	CONTAINS(persons.first_name, 'blaine', 3) > 0 OR 
	CONTAINS(persons.last_name, 'lewis', 4) > 0 
GROUP BY radiology_record.record_id 
ORDER BY myrank, record_id;




SELECT radiology_record.record_id, 
	AVG(6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2)) myrank, 
	images 
FROM radiology_record JOIN 
	persons ON radiology_record.patient_id = persons.person_id JOIN 
	(SELECT LISTAGG(pacs_images.image_id, ','), pacs_images.record_id WITHIN GROUP (ORDER BY pacs_images.image_id) images 
		FROM pacs_images 
		WHERE pacs_images.record_id = radiology_record.record_id 
		GROUP BY pacs_images.record_id
	) ON pacs_images.record_id = radiology_record.record_id
WHERE CONTAINS(radiology_record.diagnosis, 'cancer', 1) > 0 OR 
	CONTAINS(radiology_record.description, 'cancer', 2) > 0 OR 
	CONTAINS(persons.first_name, 'blaine', 3) > 0 OR 
	CONTAINS(persons.last_name, 'lewis', 4) > 0 
GROUP BY radiology_record.record_id 
ORDER BY myrank, record_id;



SELECT radiology_record.record_id, 6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2) myrank, image_agg.images FROM radiology_record JOIN persons ON radiology_record.patient_id = persons.person_id JOIN 	(SELECT LISTAGG(pacs_images.image_id, ',') WITHIN GROUP (ORDER BY pacs_images.image_id) images, pacs_images.record_id  FROM pacs_images GROUP BY pacs_images.record_id) image_agg ON image_agg.record_id = radiology_record.record_id WHERE CONTAINS(radiology_record.diagnosis, 'cancer', 1) > 0 OR CONTAINS(radiology_record.description, 'cancer', 2) > 0 OR CONTAINS(persons.first_name, 'blaine', 3) > 0 OR CONTAINS(persons.last_name, 'lewis', 4) > 0 ORDER BY myrank;


SELECT radiology_record.record_id, 
	6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2) myrank, 
	image_agg.images,
	radiologist.first_name, radiologist.last_name, radiologist.person_id,
	doctor.first_name, doctor.last_name, doctor.person_id,
	patient.first_name, patient.last_name, patient.person_id
	radiology_record.test_type,
	radiology_record.test_date,
	radiology_record.prescribing_date,
	radiology_record.diagnosis,
	radiology_record.description
FROM radiology_record JOIN 
persons doctor ON radiology_record.doctor_id = doctor.person_id JOIN
persons radiologist ON radiology_record.doctor_id = radiologist.person_id JOIN
persons patient ON radiology_record.patient_id = patient.person_id JOIN 
	(SELECT LISTAGG(pacs_images.image_id, ',') WITHIN GROUP (ORDER BY pacs_images.image_id) images, 
			pacs_images.record_id  
		FROM pacs_images 
		GROUP BY pacs_images.record_id
	) image_agg ON image_agg.record_id = radiology_record.record_id 
WHERE CONTAINS(radiology_record.diagnosis, ':diagnosis', 1) > 0 OR 
	CONTAINS(radiology_record.description, ':description', 2) > 0 OR 
	CONTAINS(patient.first_name, ':first_name', 3) > 0 OR 
	CONTAINS(patient.last_name, ':last_name', 4) > 0 
ORDER BY myrank;


IF patient THEN 
radiology_record.patient_id = :patient_id

IF DOCTOR THEN 
SELECT record_id FROM radiology_record WHERE :doctor_id IN (SELECT doctor_id FROM family_doctor WHERE family_doctor.patient_id = radiology_record.patient_id);


IF radiologist THEN 
radiology_record.radiologist_id = :radiologist_id


SELECT record_id FROM radiology_record WHERE 1 IN (SELECT doctor_id FROM family_doctor WHERE family_doctor.patient_id = radiology_record.patient_id);


GROUP BY radiology_record.record_id

SELECT record_id, diagnosis, description, first_name || ' ' || last_name FROM radiology_record JOIN persons ON radiology_record.patient_id = persons.person_id;

SELECT record_id, 6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2) myrank FROM radiology_record JOIN persons ON radiology_record.patient_id = persons.person_id WHERE CONTAINS(diagnosis, 'cancer', 1) > 0 OR CONTAINS(description, 'cancer', 2) > 0 OR CONTAINS(first_name, 'blaine', 3) > 0 OR CONTAINS(last_name, 'lewis', 4) > 0 ORDER BY myrank;


DROP INDEX diagnosis_index;
DROP INDEX description_index;
DROP INDEX first_index;
DROP INDEX last_index;

CREATE INDEX diagnosis_index ON radiology_record (diagnosis) indextype is ctxsys.context;
CREATE INDEX description_index ON radiology_record (description) indextype is ctxsys.context;
CREATE INDEX first_index ON persons (first_name) indextype is ctxsys.context;
CREATE INDEX last_index ON persons (last_name) indextype is ctxsys.context;
