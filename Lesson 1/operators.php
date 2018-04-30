<?php

    $name = "John Doe";
    $age = 25;
    $hourlyRate = 10.50;
    $hours = 40;

    echo $name . " is " . $age . " years old.\n";
    echo $name . " makes $" . $hourlyRate . " an hour. \n";
    echo $name . " worked " . $hours . " this week.\n";
    
    $weeks = 52;

    $weeklyPay = $hourlyRate * $hours;

    $salary = $weeks * $weeklyPay;

    echo $name . " will make $" . $salary . " this year.\n"; 

?>