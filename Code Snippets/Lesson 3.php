// Topic B: Classes

<?php 
 

class Student { 

private $name; 

private $age; 

private $major; 

 

public function __construct($name, $age, $major){ 

$this->name = $name; 

$this->age = $age; 

$this->major = $major; 

} 

 

public function setName($name){ 

$this->name = $name; 

} 

 

public function setAge($age){ 

$this->age = $age; 

} 

 

public function setMajor($major){ 

$this->major = $major; 

} 

 

public function getName(){ 

return $this->name; 

} 

 

public function getAge(){ 

return $this->age; 

} 

 

public function getMajor(){ 

return $this->major; 

} 

} 


?> 





// Topic B: Classes
// Activity B:Calculate the Monthly Pay of an Employee
// Step 3

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

 

?> 


// Topic B: Classes
// Activity B:Calculate the Monthly Pay of an Employee
// Step 4

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

?> 


// Topic B: Classes
// Activity B:Calculate the Monthly Pay of an Employee
// Step 5

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

  

    $markus = new Employee(“Markus Gray”, “CEO”, 100000); 

 

    echo “Monthly Pay is “ . $markus->calculateMonthlyPay(); 

 

?> 
