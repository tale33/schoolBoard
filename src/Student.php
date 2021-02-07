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

    public function getResult() : string
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

    private function getCSMResults(array $row) : string
    {
        $gradeValues = $this->getGradeValues($row);
        $gradesTotal = $gradeValues['gradesTotal'];
        $gradeCount = $gradeValues['gradeCount'];

        if($gradesTotal > 0 && $gradeCount > 0) {
            $average = $gradesTotal / $gradeCount;
            $pass = !!($average >= 7);
        } else {
            $average = 0;
            $pass = false;
        }

        return json_encode([
            'ID' => $row['id'],
            'Name' => $row['name'],
            'Grades' => $gradeValues['allGrades'],
            'Average' => $average,
            'Passed' => $pass
        ]);
    }

    private function getCSMBResults(array $row) : string
    {
        $gradeValues = $this->getGradeValues($row);
        if($gradeValues['gradeCount'] > 2) {
            rsort($gradeValues['allGrades']);
            $grades = $gradeValues['allGrades'];
            array_pop($grades);
        }

        $average = 0;
        if($gradeValues['gradesTotal'] > 0 && $gradeValues['gradeCount'] > 0) {
            $average = $gradeValues['gradesTotal'] / $gradeValues['gradeCount'];
        }

        $pass = $gradeValues['allGrades'][0] > 8;

        $results = [
            'ID' => $row['id'],
            'Name' => $row['name'],
            'Average' => $average,
            'Passed' => $pass
        ];
        $gradesXML = '';
        foreach ($gradeValues['allGrades'] as $grade) {
            $gradesXML .= "<Grade>$grade</Grade>";
        }

        return <<<XML
<?xml version='1.0' standalone='yes'?>
<student>
 <ID>{$results['ID']}</ID>
 <Name>{$results['Name']}</Name>
 <Grades>$gradesXML</Grades>
 <Average>{$results['Average']}</Average>
 <Passed>{$results['Passed']}</Passed>
</student>
XML;
    }

    private function getGradeValues(array $row) : array
    {
        $gradesTotal = 0;
        $gradeCount = 0;

        foreach ([1, 2, 3, 4] as $gradeNum) {
            $grades[] = $row['grade' . $gradeNum];
            if($row['grade' . $gradeNum]) {
                $gradesTotal += $row['grade' . $gradeNum];
                $gradeCount++;
            }
        }

        return [
            'gradesTotal' => $gradesTotal,
            'gradeCount' => $gradeCount,
            'allGrades' => $grades
        ];
    }
}