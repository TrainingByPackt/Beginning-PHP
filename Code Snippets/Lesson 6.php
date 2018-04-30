// Topic A: Setting up a project development environment
//Exercise: Setting up composer
//After Step 13

The complete file should look like this:

# Disable directory snooping
Options -Indexes

<IfModule mod_rewrite.c>

	RewriteEngine On
	RewriteBase /

	# Uncomment the rule below to force HTTPS (SSL)
	RewriteCond %{HTTPS} !on
	#RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

	# Force to exclude the trailing slash
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_URI} (.*)/$
	RewriteRule ^(.+)/$ $1 [R=307,L]

	# Allow any files or directories that exist to be displayed directly
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d

	RewriteRule ^(.*)$ index.php?$1 [QSA,L]

</IfModule>


//Exercise
//Setting up composer
//After Step 19

The complete file looks like this:

<?php
if(file_exists(‘../vendor/autoload.php’)){
	require ‘../vendor/autoload.php’;
} else {
	echo “<h1>Please install via composer.json</h1>“;
	echo “<p>Install Composer instructions: <a href=‘https://getcomposer.org/doc/00-intro.md#globally’>https://getcomposer.org/doc/00-intro.md#globally</a></p>“;
	echo “<p>Once composer is installed navigate to the working directory in your terminal/command prompt and enter ‘composer install’</p>“;
	exit;
}

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
	define(‘ENVIRONMENT’, ‘development’);
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but production will hide them.
 */

if (defined(‘ENVIRONMENT’)){

	switch (ENVIRONMENT){
		case ‘development’:
			error_reporting(E_ALL);
		break;

		case ‘production’:
			error_reporting(0);
		break;

		default:
			exit(‘The application environment is not set correctly.’);
	}

}






// Topic B: Configuration Class, Default Classes, and Routing
//Exercise: Loading a view file
// Step 2

<?php namespace App;

class Config {

    public static function get()
    {
        return [
            //set the namespace for routing
            ‘namespace’ => ‘App\Controllers\\’,

            //set default controller
            ‘default_controller’ => ‘Home’,

            //set default method
            ‘default_method’ => ‘index’,

            //database
            ‘db_type’     => ‘mysql’,
            ‘db_host’     => ‘localhost’,
            ‘db_name’     => ‘mini’,
            ‘db_username’ => ‘root’,
            ‘db_password’ => ‘‘,
        ];
    }
}



// Topic B: Configuration Class, Default Classes, and Routing
//Exercise: Loading a view file
// Step 11

<?php
namespace System;

/*
 * View - load template pages
 *
 */
class View {

	/**
	 * include template file
	 * @param  string  $path  path to file from views folder
	 * @param  array $data  array of data
	 * @param  array $error array of errors
	 */
	public function render($path, $data = false)
    {
        if ($data) {
            // Extract the rendering variables.
            foreach ($data as $key => $value) {
                ${$key} = $value;
            }
        }

        $filepath = “../app/views/$path.php”;

        if (file_exists($filepath)) {
            require $filepath;
        } else {
            die(“View: $path not found!”);
        }

	}
}



// Topic B: Configuration Class, Default Classes, and Routing
//Exercise: Loading a view file
// After Step 19


The full class looks like this:

<?php namespace System;

use System\View;

class Route
{
    public function __construct($config)
    {
        $url        = explode(‘/’, trim($_SERVER[‘REQUEST_URI’], ‘/’));
        $controller = !empty($url[0]) ? $url[0] : $config[‘default_controller’];
        $method     = !empty($url[1]) ? $url[1] : $config[‘default_method’];
        $args       = !empty($url[2]) ? array_slice($url, 2) : array();
        $class      = $config[‘namespace’].$controller;

        //check the class exists
        if (! class_exists($class)) {
            return $this->not_found();
        }

        //check the method exists
        if (! method_exists($class, $method)) {
            return $this->not_found();
        }

        //create an instance of the controller
        $classInstance = new $class;

        //call the controller and it’s method and pass in any arguments
        call_user_func_array(array($classInstance, $method), $args);
    }

    //class or method not found return a 404 view
    public function not_found()
    {
        $view = new View();
        return $view->render(‘404’);
    }
}



//Topic C: The Base Controller
//Exercise: Setting up base controller, default states, and routing
// Step 7


<?php namespace System;

use System\View;

class BaseController
{

  public $view;
  public $url;

  public function __construct()
  {
    //initialise the views object
    $this->view = new View();

    //get the current relative url
    $this->url = $this->getUrl();

    if(ENVIRONMENT == ‘development’) {
      $whoops = new \Whoops\Run;
      $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
      $whoops->register();
    }
  }

  protected function getUrl()
  {
    $url = isset($_SERVER[‘REQUEST_URI’]) ? rtrim($_SERVER[‘REQUEST_URI’], ‘/’) : NULL;
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return $this->url = $url;
  }

}



// Topic D: Working with PDO
// Exercise: Creating a contact controller and viewing the records.
// Step 11

GET method

public static function get($config)
{
  // Group information
  $type = $config[‘db_type’];
  $host = $config[‘db_host’];
  $name = $config[‘db_name’];
  $user = $config[‘db_username’];
  $pass = $config[‘db_password’];

  // ID for database based on the config information
  $id = “$type.$host.$name.$user.$pass”;

  // Checking if the same
  if (isset(self::$instances[$id])) {
    return self::$instances[$id];
  }

  $instance = new Database(“$type:host=$host;dbname=$name;charset=utf8”, $user, $pass);
  $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Setting Database into $instances to avoid duplication
  self::$instances[$id] = $instance;

  //return the pdo instance
  return $instance;

}



// Topic D: Working with PDO
// Exercise: Creating a contact controller and viewing the records.
// Step 16

public function select($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ, $class = ‘‘)
{
   // Append select if it isn’t appended.
  if (strtolower(substr($sql, 0, 7)) !== ‘select ‘) {
    $sql = “SELECT “ . $sql;
  }

  $stmt = $this->prepare($sql);
  foreach ($array as $key => $value) {
    if (is_int($value)) {
      $stmt->bindValue(“$key”, $value, PDO::PARAM_INT);
    } else {
      $stmt->bindValue(“$key”, $value);
    }
  }

  $stmt->execute();

  if ($fetchMode === PDO::FETCH_CLASS) {
    return $stmt->fetchAll($fetchMode, $class);
  } else {
    return $stmt->fetchAll($fetchMode);
  }
}



// Topic D: Working with PDO
// Exercise: Creating a contact controller and viewing the records.
// Step 29

public function update($table, $data, $where)

{

  ksort($data);



  $fieldDetails = null;

  foreach ($data as $key => $value) {
    $fieldDetails .= “$key = :$key,”;
  }

  $fieldDetails = rtrim($fieldDetails, ‘,’);



  $whereDetails = null;

  $i = 0;

  foreach ($where as $key => $value) {

    if ($i == 0) {

      $whereDetails .= “$key = :$key”;

    } else {

      $whereDetails .= “ AND $key = :$key”;

    }

    $i++;

  }

  $whereDetails = ltrim($whereDetails, ‘ AND ‘);


  $stmt = $this->prepare(“UPDATE $table SET $fieldDetails WHERE $whereDetails”);

  foreach ($data as $key => $value) {
    $stmt->bindValue(“:$key”, $value);
  }

  foreach ($where as $key => $value) {
    $stmt->bindValue(“:$key”, $value);
  }

  $stmt->execute();
  return $stmt->rowCount();
}



// Topic D: Working with PDO
// Exercise: Creating a contact controller and viewing the records.
// Step 33

public function delete($table, $where, $limit = 1)
{
  ksort($where);

  $whereDetails = null;
  $i = 0;
  foreach ($where as $key => $value) {
    if ($i == 0) {
      $whereDetails .= “$key = :$key”;
    } else {
      $whereDetails .= “ AND $key = :$key”;
    }
    $i++;
  }
  $whereDetails = ltrim($whereDetails, ‘ AND ‘);

  //if limit is a number use a limit on the query
  if (is_numeric($limit)) {
    $uselimit = “LIMIT $limit”;
  }

  $stmt = $this->prepare(“DELETE FROM $table WHERE $whereDetails $uselimit”);

  foreach ($where as $key => $value) {
    $stmt->bindValue(“:$key”, $value);
  }

  $stmt->execute();
  return $stmt->rowCount();
}






// Topic D: Working with PDO
// Exercise: Creating a contact controller and viewing the records.
// After Step 35

The full class looks like this:
<?php namespace App\Helpers;

use PDO;

class Database extends PDO
{
  /**
   * @var array Array of saved databases for reusing
   */
  protected static $instances = array();

  /**
   * Static method get
   *
   * @param  array $group
   * @return \helpers\database
   */
  public static function get($config)
  {
    // Group information
    $type = $config[‘db_type’];
    $host = $config[‘db_host’];
    $name = $config[‘db_name’];
    $user = $config[‘db_username’];
    $pass = $config[‘db_password’];

    // ID for database based on the config information
    $id = “$type.$host.$name.$user.$pass”;

    // Checking if the same
    if (isset(self::$instances[$id])) {
      return self::$instances[$id];
    }

    $instance = new Database(“$type:host=$host;dbname=$name;charset=utf8”, $user, $pass);
    $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Setting Database into $instances to avoid duplication
    self::$instances[$id] = $instance;

    //return the pdo instance
    return $instance;

  }

  /**
   * run raw sql queries
   * @param  string $sql sql command
   * @return none
   */
  public function raw($sql)
  {
    return $this->query($sql);
  }

  /**
   * method for selecting records from a database
   * @param  string $sql   sql query
   * @param  array  $array   named params
   * @param  object $fetchMode
   * @param  string $class  class name
   * @return array      returns an array of records
   */
  public function select($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ, $class = ‘‘)
  {
     // Append select if it isn’t appended.
    if (strtolower(substr($sql, 0, 7)) !== ‘select ‘) {
      $sql = “SELECT “ . $sql;
    }

    $stmt = $this->prepare($sql);
    foreach ($array as $key => $value) {
      if (is_int($value)) {
        $stmt->bindValue(“$key”, $value, PDO::PARAM_INT);
      } else {
        $stmt->bindValue(“$key”, $value);
      }
    }

    $stmt->execute();

    if ($fetchMode === PDO::FETCH_CLASS) {
      return $stmt->fetchAll($fetchMode, $class);
    } else {
      return $stmt->fetchAll($fetchMode);
    }
  }

  /**
   * insert method
   * @param  string $table table name
   * @param  array $data  array of columns and values
   */
  public function insert($table, $data)
  {
    ksort($data);

    $fieldNames = implode(‘,’, array_keys($data));
    $fieldValues = ‘:’.implode(‘, :’, array_keys($data));

    $stmt = $this->prepare(“INSERT INTO $table ($fieldNames) VALUES ($fieldValues)”);

    foreach ($data as $key => $value) {
      $stmt->bindValue(“:$key”, $value);
    }

    $stmt->execute();
    return $this->lastInsertId();
  }

  /**
   * update method
   * @param  string $table table name
   * @param  array $data  array of columns and values
   * @param  array $where array of columns and values
   */
  public function update($table, $data, $where)
  {
    ksort($data);

    $fieldDetails = null;
    foreach ($data as $key => $value) {
      $fieldDetails .= “$key = :$key,”;
    }
    $fieldDetails = rtrim($fieldDetails, ‘,’);

    $whereDetails = null;
    $i = 0;
    foreach ($where as $key => $value) {
      if ($i == 0) {
        $whereDetails .= “$key = :$key”;
      } else {
        $whereDetails .= “ AND $key = :$key”;
      }
      $i++;
    }
    $whereDetails = ltrim($whereDetails, ‘ AND ‘);

    $stmt = $this->prepare(“UPDATE $table SET $fieldDetails WHERE $whereDetails”);

    foreach ($data as $key => $value) {
      $stmt->bindValue(“:$key”, $value);
    }

    foreach ($where as $key => $value) {
      $stmt->bindValue(“:$key”, $value);
    }

    $stmt->execute();
    return $stmt->rowCount();
  }

  /**
   * Delete method
   * @param  string $table table name
   * @param  array $data  array of columns and values
   * @param  array $where array of columns and values
   * @param  integer $limit limit number of records
   */
  public function delete($table, $where, $limit = 1)
  {
    ksort($where);

    $whereDetails = null;
    $i = 0;
    foreach ($where as $key => $value) {
      if ($i == 0) {
        $whereDetails .= “$key = :$key”;
      } else {
        $whereDetails .= “ AND $key = :$key”;
      }
      $i++;
    }
    $whereDetails = ltrim($whereDetails, ‘ AND ‘);

    //if limit is a number use a limit on the query
    if (is_numeric($limit)) {
      $uselimit = “LIMIT $limit”;
    }

    $stmt = $this->prepare(“DELETE FROM $table WHERE $whereDetails $uselimit”);

    foreach ($where as $key => $value) {
      $stmt->bindValue(“:$key”, $value);
    }

    $stmt->execute();
    return $stmt->rowCount();
  }

  /**
   * truncate table
   * @param  string $table table name
   */
  public function truncate($table)
  {
    return $this->exec(“TRUNCATE TABLE $table”);
  }
}




// Topic D: Working with PDO
// Exercise: Creating a contact controller and viewing the records.
// After Step 43


The class looks like this:

<?php namespace System;
/*
 * model - the base model
 *
 */

use App\Config;
use App\Helpers\Database;

class BaseModel
{
/**
 * hold the database connection
 * @var object
 */
protected $db;

/**
 * create a new instance of the database helper
 */
public function __construct() {

//initiate config
$config = Config::get();

//connect to PDO here.
$this->db = Database::get($config);
}
}





