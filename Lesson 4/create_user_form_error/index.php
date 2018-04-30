<?php

    if(!$_POST['firstname'] || !$_POST['lastname'] || !$_POST['email']){
        exit("All fields are required.");
    }

    echo "First Name: " . $_POST['firstname'] . "\n";
    echo "Last Name: " . $_POST['lastname'] . "\n";
    echo "Email: " . $_POST['email'] . "\n";
    exit();

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