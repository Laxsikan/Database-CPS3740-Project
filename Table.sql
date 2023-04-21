
use CPS3740_2023S;

Create table Staff_manoranl (
staffNo varchar(5) NOT NULL,
fName varchar(15) NOT NULL,
lName varchar(15) NOT NULL,
position varchar(25) DEFAULT NULL,
sex char(1) DEFAULT NULL,
DOB date DEFAULT NULL,
salary decimal(8,2) DEFAULT NULL,
branchNo varchar(8) DEFAULT NULL,
PRIMARY KEY (staffNo));

INSERT INTO Staff_manoranl VALUES ('SG16', 'Alan', 'Brown',
'Assistant', 'M', Date '1957-05-25', 8300, 'B003');

INSERT INTO Staff_manoranl  (staffno, fname, lname)
 VALUES ( 'XYZ1', 'Laxsikan', 'Manoranjan');
 
 INSERT INTO Staff_manoranl  (staffno, fname, lname, position)
 VALUES ( 'XYZ1', 'Laxsikan', 'Manoranjan', NULL);
 
 update Staff_demo02 set sex="F" ,dob-2000-01-01, salary=10000 where staffno='ABC2' ;