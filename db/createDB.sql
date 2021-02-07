DROP TABLE IF EXISTS schoolBoards;
CREATE TABLE schoolBoards (
    board_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    boardName VARCHAR(30) NOT NULL
);
INSERT INTO schoolBoards (boardName) VALUES ("CSM");
INSERT INTO schoolBoards (boardName) VALUES ("CSMB");

DROP TABLE IF EXISTS students;
CREATE TABLE students (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    schoolBoardID INT(6) UNSIGNED,
    name VARCHAR(30) NOT NULL,
    grade1 INT(6) UNSIGNED,
    grade2 INT(6) UNSIGNED,
    grade3 INT(6) UNSIGNED,
    grade4 INT(6) UNSIGNED
);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (1, "Milos", 5, 6, 7, 8);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (1, "Jovana", 7, 7, 8, 9);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (1, "Bogdan", 5, 6, 5, NULL);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (1, "Jelena", NULL, NULL, 7, 8);

INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (2, "Luka", 7, 9, 7, 8);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (2, "Natasa", 5, 6, 6, 5);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (2, "Uros", NULL, 6, 7, 8);
INSERT INTO students (schoolBoardID, name, grade1, grade2, grade3, grade4) VALUES (2, "Janja", NULL, NULL, 7, 8);

