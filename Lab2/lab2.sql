DROP SCHEMA IF EXISTS lab2 CASCADE;
CREATE SCHEMA lab2;
SET search_path = lab2;

--Creates the building table with an address, name, city,state and zipcode. Primary key = address & zipcode
CREATE TABLE building (
	address varchar(60),
	name varchar(40),
	city varchar(20),
	state char(2),
	zipcode integer,
	PRIMARY KEY (address, zipcode)

);
--Inserts values into the table
INSERT into building values('204 main street','Medical Building', 'Columbia', 'MO', 65201);
INSERT into building values('205 main street','Bone Building', 'Columbia', 'MO', 65211);
INSERT into building values('206 main street','Blood Building', 'Columbia', 'MO', 65231);
--Creates the office table with a waiting room, room number, waiting room capacity. PK = address, zipcode and room number) FK = address and zipcode that reference building
CREATE TABLE office (
	address varchar(60),
	zipcode integer,
    room_number smallint,
    waiting_room_capacity integer,
    PRIMARY KEY (address, zipcode, room_number),
    FOREIGN KEY (address, zipcode) REFERENCES building
);
--Inserts values into office
INSERT into office values('204 main street',65201,8,40);
INSERT into office values('205 main street',65211,9,20);
INSERT into office values('206 main street',65231,5,30);
--Creates the doctor table with a medical license, first and last name and a office number. Office num references room number. PK= medical license
CREATE TABLE doctor (
	medical_license_num serial PRIMARY KEY,	
	first_name varchar(20),
	last_name varchar(20),
	address varchar(40),
	zipcode integer,
	room_number smallint,
	FOREIGN KEY(address,zipcode,room_number) REFERENCES office
);
--Inserts values into doctor
INSERT into doctor values(102,'tim','smith','204 main street', 65201, 8);
INSERT into doctor values(104,'eric','jones','205 main street', 65211, 9);
INSERT into doctor values(106,'john','faulds','206 main street', 65231, 5);
--Creates the patient table with a ssn as the primary key, a first and last name
CREATE TABLE patient(
        ssn integer  PRIMARY KEY,
        first_name varchar(20),
        last_name varchar(20)
);
--Inserts values into patient
INSERT into patient values(867542345, 'tim','mujhlty');
INSERT into patient values(867543415, 'matt','flopiuyt');
INSERT into patient values(867567845, 'frank','desrty');

--Creates the insurance table with a policy num, insurer and a ssn as the primary key that references patient
CREATE TABLE insurance(
	policy_num integer,
	insurer varchar(20),
	ssn integer PRIMARY KEY,
	FOREIGN KEY(ssn) REFERENCES patient
);
--Inserts the values into insurance
INSERT into insurance values(1234587,'anthem',867542345);
INSERT into insurance values(1235637,'BC',867543415);
INSERT into insurance values(1234907,'BS',867567845);
--Creates the condition table with a icd10 and a description
CREATE TABLE condition(
	icd varchar(10) PRIMARY KEY,
	description text
);
--Inserts values into condition
INSERT into condition values('a90865', 'broken arm');
INSERT into condition values('a92365', 'broken leg');
INSERT into condition values('a945b65', 'broken hip');
--Creates the patientcondition table/relationship with a ssn that references patient, a icd10 that references the condition. PK = ssn, icd10
CREATE TABLE patient_condition(
	ssn integer REFERENCES patient,
	icd varchar(10) REFERENCES condition,	
	PRIMARY KEY (ssn, icd)

);
--Inserts values into patient condition
INSERT into patient_condition values(867542345, 'a90865');
INSERT into patient_condition values(867543415, 'a92365');
INSERT into patient_condition values(867567845, 'a945b65');
--Creates the labwork table with a ssn that references patient, a test name, test timestap and test value. PK = ssn, test name and test timestamp
CREATE TABLE labwork(
	ssn integer REFERENCES patient,
	test_name varchar(25),
	test_timestamp time,
	test_value text,
	PRIMARY KEY (ssn, test_name, test_timestamp)
);
--Inserts values into labwork
INSERT into labwork values(867542345,'Alevel','10:43','true');
INSERT into labwork values(867543415,'Eflevel','11:43','true');
INSERT into labwork values(867567845,'DGlevel','12:43','false');
--Creates the appointment table/relationship with a ssn that references patient, a medical license that references doctor, a appt time and appt date
CREATE TABLE appointment(
	ssn integer REFERENCES patient,
	medical_license_num integer REFERENCES doctor,
	appt_time time,
	appt_date date, 
	PRIMARY KEY (ssn,medical_license_num)
);
--Inserts values into appointmnent
INSERT into appointment values(867542345, 102,'11:34','12/31/15');
INSERT into appointment values(867543415, 104,'11:35','12/31/15');
INSERT into appointment values(867567845, 106,'11:36','12/31/15');