<?php

    $employees = array(
        array( 
            "name" => "John Doe",
            "title" => "Programmer",
            "salary" => 60000
        ),
        array( 
            "name" => "Tim Doe",
            "title" => "Programmer",
            "salary" => 80000
        ),
        array( 
            "name" => "Sarah Apple",
            "title" => "Designer",
            "salary" => 100000
        ),
        array( 
            "name" => "Amy Twin",
            "title" => "Manager",
            "salary" => 200000
        )
    );

    foreach($employees as $employee){
        echo $employee['name'] . "(" . $employee['title'] . ") annual salary is $" . $employee['salary'] . " and earns $" . ($employee['salary'] / 12) . "/mo. \n";
    }

?>