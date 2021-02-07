<?php

require_once ('src/Student.php');

if($_GET) {
    $keys = array_keys($_GET);
    switch ($keys[0]) {
        case 'student':
            $studentID = intval($_GET['student'], 10);
            if($studentID) {
                $student = new Student($studentID);
                echo json_encode($student->getResults());
            } else {
                echo json_encode([ 'error' => "Please provide valid ID." ]);
            }
            break;
        default:
            echo 'Welcome to school board app!';
            break;
    }
} else {
    echo 'Welcome to school board app!';
}
