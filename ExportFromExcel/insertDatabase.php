<?php
    include 'connect.php';
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];  

    $sql = "INSERT INTO users (name1, surname, age, gender)
    VALUES ('$name', '$surname', '$age', '$gender' )";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->$error;
    }

    $conn->close();
?>