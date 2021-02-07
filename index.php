<?php

require_once ('src/Student.php');

if($_GET) {
    $keys = array_keys($_GET);
    switch ($keys[0]) {
        case 'student':
            $studentID = $_GET['student'];
            if($studentID) {
                $student = new Student($studentID);
                $result = $student->getResult();
                $message = $result ? $result : 'We do not have records of that student.';
                echo json_encode($message);
            } else {
                echo json_encode('Please provide valid student ID.');
            }
            break;
        default:
            echo 'Welcome to school board app!';
            break;
    }
} else {
    echo 'Welcome to school board app!';
}
