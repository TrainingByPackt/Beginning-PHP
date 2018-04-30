<?php
    $host = "DATABASE_HOST";
    $username = "DATABASE_USERNAME";
    $password = "DATABASE_PASSWORD";
    $database = "DATABASE_NAME";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(30) NOT NULL
        )";

        $conn->execute($sql);

    }
    catch(PDOException $e)
    {

        echo "Connection failed: " . $e->getMessage();

    }
?>