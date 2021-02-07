<?php

require_once ('db/ConnectDB.php');

class Student {

    private string $ID;
    private PDO $pdo;

    public function __construct(string $studentID) {
        $this->ID = $studentID;
        $connectDB = new ConnectDB();
        $this->pdo = $connectDB->getConnection();
    }

    public function getResult() : array
    {
        $studentRows = $this->getStudents();
        $result = [];
        foreach ($studentRows as $studentRow) {
            if($studentRow['id'] === $this->ID) {
                if($studentRow['boardName'] === 'CSM') {
                    $result = $this->getCSMResults($studentRow);
                } else {
                    $result = $this->getCSMBResults($studentRow);
                }
            } else {
                continue;
            }
        }
        return $result;
    }

    private function getStudents() : array
    {
        $query = <<<SQL
SELECT * FROM students S 
INNER JOIN schoolBoards SB 
ON S.schoolBoardID=SB.board_id
SQL;
        $preparedStatement = $this->pdo->prepare($query);
        $preparedStatement->execute();
        return $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCSMResults(array $row) : array
    {
        $gradesTotal = 0;
        $gradeCount = 0;
        foreach ([1, 2, 3, 4] as $gradeNum) {
            if($row['grade' . $gradeNum]) {
                $gradesTotal += $row['grade' . $gradeNum];
                $gradeCount++;
            } else {
                $gradesTotal += 0;
            }
        }
        if($gradesTotal > 0 && $gradeCount > 0) {
            $pass = !!(($gradesTotal / $gradeCount) >= 7);
        } else {
            $pass = false;
        }

        return [
            'Name' => $row['name'],
            'School board' => '',
            'Passed' => $pass
        ];
    }

    private function getCSMBResults(array $row) : string
    {
        return '';
    }
}