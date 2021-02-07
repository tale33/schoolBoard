<?php

require_once ('db/ConnectDB.php');

class Student {

    private int $ID;
    private PDO $pdo;

    public function __construct(int $studentID) {
        $this->ID = $studentID;
        $connectDB = new ConnectDB();
        $this->pdo = $connectDB->getConnection();
    }

    public function getResults() : string
    {
        $studentRow = $this->getStudent();

        return $studentRow['schoolBoard'] === 'CSM' ? $this->getCSMResults($studentRow) : $this->getCSMBResults($studentRow);
    }

    private function getStudent() : array
    {
        $query = <<<SQL
SELECT * FROM students WHERE ID=:ID
SQL;
        $preparedStatement = $this->pdo->prepare($query);
        $preparedStatement->execute(array(':ID' => $this->ID));
        return $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCSMResults(array $row) : string
    {
        return '';
    }

    private function getCSMBResults(array $row) : string
    {
        return '';
    }
}