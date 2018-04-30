<?php

    class BaseEmployee {
        private $name;
        private $title;
        private $salary;

        function __construct($name, $title, $salary){
            $this->name = $name;
            $this->title = $title;
            $this->salary = $salary;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function setTitle($title){
            $this->title = $title;
        }

        public function setSalary($salary){
            $this->salary = $salary;
        }

        public function getName(){
            return $this->name;
        }

        public function getTitle(){
            return $this->title;
        }

        public function getSalary(){
            return $this->salary;
        }
    }

    class Employee extends BaseEmployee{
        public function calculateMonthlyPay(){
            return $this->salary / 12;
        }
    }


    $markus = new Employee("Markus Gray", "CEO", 100000);

    echo "Monthly Pay is " . $markus->calculateMonthlyPay();

?>