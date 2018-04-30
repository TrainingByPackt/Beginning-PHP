<?php

    if($_POST){
        if(!$_POST['firstname'] || !$_POST['lastname'] || !$_POST['email']){
            exit("All fields are required.");
        }

        $host = "DATABASE_HOST";
        $username = "DATABASE_USERNAME";
        $password = "DATABASE_PASSWORD";
        $database = "packt_database";
    
        try {
            $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)";
    
            $statement = $conn->prepare($sql);
    
            $statement->execute([
                "firstname" => $_POST["firstname"],
                "lastname" => $_POST["lastname"],
                "email" => $_POST["email"]
            ]);
    
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }
?>
<html>
    <body>
        <form action="index.php" method="post">
            <label>First Name</label>
            <input type="text" name="firstname" id="firstname"/>
            <br>
            <label>Last Name</label>
            <input type="text" name="lastname" id="lastname"/>
            <br>
            <label>Email</label>
            <input type="text" name="email" id="email"/>
            <br>
            <button type="submit">Save</button>
        </form>
    </body>
</html>