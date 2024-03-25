<?php

require_once('db.php');

if (isset($_POST['submit'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();

    if (empty($firstName) || empty($lastName) || empty($email) || empty($pass)) {
        array_push($errors, 'All fields are requared');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,'Email is not valid' );
    }

    if (strlen($pass)<8) {
        array_push($errors,'Password must be at least 8 characters long');
    }

    if (count($errors)>0) {
        foreach($errors as $error){
            echo $error;}}
    else {
        $sql = "INSERT INTO user (name, surname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bindParam(1, $firstName);
            $stmt->bindParam(2, $lastName);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $passHash);

            if ($stmt->execute()) {
                echo 'You registered successfully';
            } else {
                die('Error executing the statement');
            }
        } else {
            die('Error preparing the statement');
        }
    }


}
