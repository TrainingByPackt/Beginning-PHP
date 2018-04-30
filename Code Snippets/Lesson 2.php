Topic A: Arrays
// Subtopic: Multidimensional Array

<?php
	
	$students = array(
	“Jill” => array(
   “age” => 20,
   “gender” => “female”,
   “favorite_color” => “blue”
),
“John” => array(
   “age” => 23,
   “gender” => “male”,
   “favorite_color” => “red”
),
“Amy” => array(
   “age” => 25,
   “gender” => “female”,
   “favorite_color” => “green”
),


);
?>


//Topic A: Arrays
//Exercise: Including a hobbies array in our existing project.
// Step 4:


<?php	

      $user = array(
		“info” => array(
			“name” => “john”,
			“age” => 27,
			“location” => “USA”,
			“education_level” => “college”
		),
		“hobbies” => array(
			“fishing”,
			“gaming”,
			“painting”
		)
	);

?>




//Topic A: Arrays
//Exercise: Including a hobbies array in our existing project.
// Step 5:

<?php
    $user = array(
		“info” => array(
			“name” => “john”,
			“age” => 27,
			“location” => “USA”,
			“education_level” => “college”
		),
		“hobbies” => array(
			“fishing”,
			“gaming”,
			“painting”
		)
		);
         
   echo “My name is “. $user[“info”][“name”] . “.\n”;
   echo “I am “ . $user[“info”][“age”] . “ years old. \n”;
   echo “I live in “ . $user[“info”][‘location’] . “.\n”;
   echo “My latest education level is “ .   
   $user[‘info’][‘educaton_level’]. “.\n”;
	
echo “I enjoy “ . $user[“hobbies”][0] . “, “  . $user[“hobbies”][1] . “, “ . $user[“hobbies”][2].”.\n”;

?>


// Topic B
// Subtopic: Foreach loops

<?php
	
	$students = array(
	“Jill” => array(
   “age” => 20,
   “favorite_color” => “blue”
),
“John” => array(
   “age” => 23,
   “favorite_color” => “red”
),
“Amy” => array(
   “age” => 25,
   “favorite_color” => “green”
),


);
	

	foreach($students as $name => $info){
	  echo $name . “‘s is “ . $info[‘age’] . “ years old\n”;
}
?>


//Exercise: Working with Foreach loop
// Step 2:

<?php

$employees = array(
    array( 
        “name” => “John Doe”,
        “title” => “Programmer”,
        “salary” => 60000
    ),
    array( 
        “name” => “Tim Doe”,
        “title” => “Programmer”,
        “salary” => 72000
    ),
    array( 
        “name” => “Sarah Apple”,
        “title” => “Designer”,
        “salary” => 120000
    ),
    array( 
        “name” => “Amy Twin”,
        “title” => “Manager”,
        “salary” => 132000
    )
);
?>


