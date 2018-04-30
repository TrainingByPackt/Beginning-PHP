<?php

	$user = array(
		"info" => array(
			"name" => "john",
			"age" => 27,
			"location" => "USA",
			"education_level" => "college"
		),
		"hobbies" => array(
			"fishing",
			"gaming",
			"painting"
		)
	);

	echo "My name is ". $user["info"]["name"] . ".\n";
    echo "I am " . $user["info"]["age"] . " years old. \n";
    echo "I live in " . $user["info"]['location'] . ".\n";
	echo "My latest education level is " . $user['info']['educaton_level']. ".\n";
	
	echo "I enjoy " . $user["hobbies"][0] . ", "  . $user["hobbies"][1] . ", " . $user["hobbies"][2].".\n";

?>