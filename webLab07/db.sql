EX1)

CREATE DATABASE college;
 
CREATE TABLE student(
   student_id int not null primary key,
   name varchar(10) not null,
   year tinyint default 1 not null,
   dept_no integer not null,
   major varchar(20)
);
CREATE TABLE department(
   dept_no integer not null primary key auto_increment,
   dept_name varchar(20) unique,
   office varchar(20),
   office_tel varchar(13) not null
);
ALTER TABLE student CHANGE COLUMN major major varchar(40);
ALTER TABLE student ADD COLUMN gender varchar(1) NOT NULL;
ALTER TABLE department CHANGE COLUMN dept_name dept_name varchar(40);
ALTER TABLE department CHANGE COLUMN office office varchar(30);

EX2)

ALTER TABLE student DROP COLUMN gender;
INSERT INTO student VALUES(20070002, 'James Bond', 3, 4, 'Business Administration');
INSERT INTO student VALUES(20060001, 'Queenie', 4, 4, 'Business Administration');
INSERT INTO student VALUES(20030001, 'Reonardo', 4, 2, 'Electronic Engineering');
INSERT INTO student VALUES(20040003, 'Julia', 3, 2, 'Electronic Engineering');
INSERT INTO student VALUES(20060002, 'Roosevelt', 3, 1, 'Computer Science');
INSERT INTO student VALUES(20100002, 'Fearne', 3, 4, 'Business Administration');
INSERT INTO student VALUES(20110001, 'Chloe', 2, 1, 'Computer Science');
INSERT INTO student VALUES(20080003, 'Amy', 4, 3, 'Law');
INSERT INTO student VALUES(20040002, 'Selina', 4, 5, 'English Literature');
INSERT INTO student VALUES(20070001, 'Ellen', 4, 4, 'Business Administration');
INSERT INTO student VALUES(20100001, 'Kathy', 3, 4, 'Business Administration');
INSERT INTO student VALUES(20110002, 'Lucy', 2, 2, 'Electronic Engineering');
INSERT INTO student VALUES(20030002, 'Michelle', 5, 1, 'Computer Science');
INSERT INTO student VALUES(20070003, 'April', 4, 3, 'Law'); 
INSERT INTO student VALUES(20070005, 'Alicia', 2, 5, 'English Literature');
INSERT INTO student VALUES(20100003, 'Yullia', 3, 1, 'Computer Science'); 
INSERT INTO student VALUES(20070007, 'Ashlee', 2, 4, 'Business Administration');
INSERT INTO department(dept_name, office, office_tel) VALUES('Computer Science', 'Engineering building', '02-3290-0123');
INSERT INTO department(dept_name, office, office_tel) VALUES('Electronic Engineering', 'Engineering building', '02-3290-2345');
INSERT INTO department(dept_name, office, office_tel) VALUES('Law', 'Law building', '02-3290-7896');
INSERT INTO department(dept_name, office, office_tel) VALUES( 'Business Administration', 'Administration building', '02-3290-1112');
INSERT INTO department(dept_name, office, office_tel) VALUES ('English Literature', 'Literature building', '02-3290-4412');
 
EX3)

UPDATE department SET dept_name="Electronic and Electrical Engineering" WHERE dept_name="Electronic engineering";
INSERT INTO department(dept_name, office, office_tel) VALUES('Education','Education','02-3290-2347');
UPDATE student SET dept_no=6 WHERE name='Chloe';
DELETE FROM student WHERE name='Michelle';
DELETE FROM student WHERE name='Fearne';

EX4)

SELECT name FROM student WHERE major='Computer Science';
SELECT student_id,year,major FROM student;
SELECT name FROM student WHERE year=3;
SELECT name FROM student WHERE year=1 OR year=2;
SELECT name,dept_no,dept_name FROM student join department d using(dept_no) WHERE d.dept_name='Business Administration';

EX5)

1)
SELECT name FROM student WHERE student_id LIKE '2007%';
2)
SELECT name FROM student ORDER BY student_id ASC;
3) 
SELECT major FROM student GROUP BY major HAVING avg(year)>3;
4)
SELECT name FROM student WHERE student_id LIKE '2007%' LIMIT 2;
 
EX6)

SELECT r.role role FROM roles r JOIN movies m ON r.movie_id = m.id WHERE m.name = 'Pi';

SELECT a.first_name, a.last_name, r.role role FROM actors a JOIN roles r ON r.actor_id = a.id JOIN movies m ON r.movie_id = m.id WHERE m.name = 'Pi';


SELECT a.first_name, a.last_name FROM actors a JOIN roles r1 ON r1.actor_id = a.id JOIN roles r2 ON r2.actor_id = a.id JOIN movies m1 ON m1.id = r1.movie_id JOIN movies m2 ON m2.id = r2.movie_id WHERE m1.name = 'Kill Bill: Vol. 1' AND m2.name = 'Kill Bill: Vol. 2';


SELECT a.first_name, a.last_name, count(a.id) howmany FROM actors a JOIN roles r ON a.id=r.actor_id GROUP BY a.id ORDER BY count(a.id) DESC LIMIT 7;

SELECT mg.genre genre, count(mg.genre) howmany FROM movies_genres mg GROUP BY mg.genre ORDER BY count(mg.genre) DESC LIMIT 3;

SELECT d.first_name, d.last_name, count(d.id) howmany FROM directors d JOIN movies_directors md ON d.id=md.director_id JOIN movies_genres mg ON md.movie_id=mg.movie_id WHERE mg.genre = "Thriller" GROUP BY d.id ORDER BY count(d.id) DESC LIMIT 1;

EX7)

SELECT g.grade grade
FROM grades g
JOIN courses c ON course_id=c.id
WHERE c.name = 'Computer Science 143';
   
SELECT s.name name, g.grade grade
FROM grades g
JOIN students s ON g.student_id = s.id
JOIN courses c ON g.course_id = c.id
WHERE c.name = 'Computer Science 143' AND g.grade <= 'B-';

SELECT s.name student, c.name course, g.grade grade
FROM grades g
JOIN students s ON g.student_id = s.id
JOIN courses c ON g.course_id = c.id
WHERE g.grade <= 'B-';

SELECT c.name course, count(*) howmany
FROM grades g
JOIN students s ON g.student_id = s.id
JOIN courses c ON g.course_id = c.id
GROUP BY c.name
HAVING count(*) >= 2;

EX8)

1. receives a DB name and an SQL query from user inputs through form.
   
2. connects to the specified DB.
   
3. queries data with the given SQL query (can use queries constructed from previous exercises).
   
4. displays each row of the query results in unordered list.

EXTRA)
1)
SELECT name FROM movies WHERE year > 1995;
2)
SELECT count(*) FROM movies m join roles r ON r.movie_id=m.id WHERE name='Lost in Translation'
3)
SELECT a.first_name,a.last_name FROM movies m join roles r ON r.movie_id=m.id join actors a ON a.id=r.actor_id  WHERE name='Lost in Translation';
4)
SELECT d.first_name,d.last_name FROM directors d join movies_directors md ON d.id=md.director_id join movies m ON m.id=md.movie_id WHERE m.name='Fight Club'
5)
SELECT count(*) FROM directors d join movies_directors md ON d.id=md.director_id join movies m ON m.id=md.movie_id WHERE d.first_name='Clint' AND d.last_name='Eastwood';
6)
SELECT d.first_name,d.last_name FROMFROM directors d join movies_directors md ON d.id=md.director_id join movies_genres mg ON mg.movie_id = md.movie_id WHERE mg.genre='horror' GROUP BY md.director_id HAVING count(md.director_id)>=1; 
7)
SELECT DISTINCT a.first_name,a.last_name FROM directors d join movies_directors md ON d.id=md.director_id natural join roles r join actors a ON a.id=r.actor_id WHERE d.first_name='Christopher' AND d.last_name='Nolan';