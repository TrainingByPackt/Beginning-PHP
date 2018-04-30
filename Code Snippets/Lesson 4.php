// Topic A: Inputting and Outputting Data

<?php 

    if($_POST){ 

        echo "Name: " . $_POST['name'] . "\n"; 

        echo "Email: " . $_POST['email] . "\n"; 

        echo "Message: " . $_POST['message] . "\n"; 

        exit(); 

    } 

?>   

<html> 

<body> 

    <form action="index.php" method="POST"> 

        <input type="text" name="name" /> 

        <input type="text" name="email" /> 

        <textarea name="message"></textarea> 

        <button type="submit">Send</button> 

    </form> 

</body> 

</html>


// Topic A: Inputting and Outputting Data

<?php 

    if($_GET){ 

        echo "Name: " . $_GET['name'] . "\n"; 

        echo "Email: " . $_GET['email] . "\n"; 

        echo "Message: " . $_GET['message] . "\n"; 

        exit(); 

    } 

?>   

<html> 

<body> 

    <form action="index.php" method="GET"> 

        <input type="text" name="name" /> 

        <input type="text" name="email" /> 

        <textarea name="message"></textarea> 

        <button type="submit">Send</button> 

    </form> 

</body> 

</html> 



// Topic A: Inputting and Outputting Data
// Exercise: Building a form for our users list
// Step 3:

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



// Topic A: Inputting and Outputting Data
// Exercise: Building a form for our users list
// Step 4:

<?php 

    if($_POST){ 

        echo "First Name: " . $_POST['firstname'] . "\n"; 

        echo "Last Name: " . $_POST['lastname'] . "\n"; 

        echo "Email: " . $_POST['email'] . "\n"; 

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




// Topic B: MySQL Basics
// Subtopic: COnnect to a Database

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

$conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

    echo "Connected successfully";  

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 



// Topic B: MySQL Basics
// Subtopic: Create a Database Table

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

     

    $sql = "CREATE TABLE users ( 

    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 

    name VARCHAR(60) NOT NULL, 

    email VARCHAR(30) NOT NULL, 

    )"; 

 

    $conn->exec($sql); 

 

    echo "User table created!"; 

 

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 



// Topic B: MySQL Basics
// Subtopic: Insert a Record into the Database

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

     

    $sql = "INSERT INTO users (name, email) VALUES ('Markus John', 'test@email.com');"; 

 

    $conn->exec($sql); 

 

    echo "User has been added!"; 

 

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 




// Topic B: MySQL Basics
// Subtopic: Fetch a Single Row from a Database Table

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email"); 

 

    $statement->execute(['email' => 'test@email.com']); 

 

    $statement->setFetchModel(PDO::FETCH_ASSOC); 

 

    $user = $statement->fetch(); 

 

    echo "<pre>"; 

    print_r($user); 

    echo "</pre>"; 

 

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 



// Topic B: MySQL Basics
// Subtopic: Fetch Multiple Rows from a Database Table

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

    $users = $conn->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC); 

 

    echo "<pre>"; 

    print_r($users); 

    echo "</pre>"; 

 

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 




// Topic B: MySQL Basics
// Subtopic: Update a Record in a Database Table

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

  $sql = "UPDATE users SET email = :email WHERE id = :id"; 

 

  $statement = $conn->prepare($sql); 

 

  $statement->execute(['email' => 'test123@email.com', 'id' => 1]); 

 

  echo $statement->rowCount() . "(s) rows affected."; 

 

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 



// Topic B: MySQL Basics
// Subtopic: Delete a Record in a Database Table

<?php 

$host = "DATABASE_HOST"; 

$username = "DATABASE_USERNAME"; 

$password = "DATABASE_PASSWORD"; 

$database = "DATABASE_NAME"; 

 

try { 

    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password); 

    

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

     

  $sql = "DELETE FROM users WHERE id = :id"; 

 

  $statement = $conn->prepare($sql); 

 

  $statement->execute(['id' => 1]); 

 

  echo $statement->rowCount() . "(s) rows deleted."; 

 

    } 

catch(PDOException $e) 

    { 

 

    echo "Connection failed: " . $e->getMessage(); 

     

    } 

?> 


// Topic B: MySQL Basics
// Exercise: Adding users to a database
// Step 2

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




// Topic B: MySQL Basics
// Exercise: Adding users to a database
// Step 3

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