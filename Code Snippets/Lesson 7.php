//Topic A: Setting Up Paths and Inclusion of Bootstrap
// Exercise: Inclusion of Bootstrap and HTML markup.
// Step 7

<nav class=“navbar navbar-default”>
    <div class=“container-fluid”>
      <div class=“navbar-header”>
        <button type=“button” class=“navbar-toggle collapsed” data-toggle=“collapse” data-target=“#navbar” aria-expanded=“false” aria-controls=“navbar”>
          <span class=“sr-only”>Toggle navigation</span>
          <span class=“icon-bar”></span>
          <span class=“icon-bar”></span>
          <span class=“icon-bar”></span>
        </button>
        <a class=“navbar-brand” href=“#”>Project name</a>
      </div>
      <div id=“navbar” class=“navbar-collapse collapse”>
        <ul class=“nav navbar-nav”>
          <li><a href=“/”>Admin</a></li>
          <li><a href=“/users”>Users</a></li>
        </ul>
        <ul class=“nav navbar-nav navbar-right”>
          <li><a href=“/admin/logout”>Logout</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>


//Topic A: Setting Up Paths and Inclusion of Bootstrap
// Exercise: Inclusion of Bootstrap and HTML markup.
// Step 10

<!doctype html>
<html lang=“en”>
<head>
<meta charset=“utf-8”>
<title> Demo</title>
<link rel=“stylesheet” href=“https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css”> 
<link rel=“stylesheet” href=“/css/style.css”> 

<script src=“https://code.jquery.com/jquery-2.2.4.min.js”></script> 
<script src=“https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js”></script> 
</head>
<body>

<div class=“container”>

404!
</div>
</body>
</html>



//Topic B: Adding Security to the Project
//Exercise: Implementing validation in PHP.
// After Step 7

The full class looks like this:
<?php namespace App\Helpers;

class Session
{
    private static $sessionStarted = false;

    /**
     * if session has not started, start sessions
     */
    public static function init()
    {
        if (self::$sessionStarted == false) {
            session_start();
            self::$sessionStarted = true;
        }
    }

    public static function set($key, $value = false)
    {
        /**
         * Check whether session is set in array or not
         * If array then set all session key-values in foreach loop
         */
        if (is_array($key) && $value === false) {
            foreach ($key as $name => $value) {
                $_SESSION[$name] = $value;
            }
        } else {
            $_SESSION[$key] = $value;
        }
    }

    public static function pull($key)
    {
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }


    public static function display()
    {
        return $_SESSION;
    }

    public static function destroy($key = ‘‘)
    {
        if (self::$sessionStarted == true) {
            if (empty($key)) {
                session_unset();
                session_destroy();
            } else {
                unset($_SESSION[$key]);
            }
        }
    }

}


//Topic B: Adding Security to the Project
//Exercise: Implementing validation in PHP.
// Step 8


<?php namespace App;

use App\Helpers\Session;

class Config {

    public static function get()
    {
        //turn on output buffering
        ob_start();

        //turn on sessions
        Session::init();
      
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



//Topic B: Adding Security to the Project
//Exercise: Implementing validation in PHP.
// Step 12

<?php namespace App\Models;

use System\BaseModel;

class User extends BaseModel
{
    public function insert($data)
    {
        $this->db->insert(‘users’, $data);
    }

    public function update($data, $where)
    {
        $this->db->update(‘users’, $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete(‘users’, $where);
    }
}


//Topic B: Adding Security to the Project
//Exercise: Implementing validation in PHP.
// Step 16

<?php namespace App\Controllers;

use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\User;

class Admin extends BaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new User();
    }

    public function index()
    {
        if (! Session::get(‘logged_in’)) {
            Url::redirect(‘/admin/login’);
        }

        $title = ‘Dashboard’;

        $this->view->render(‘admin/index’, compact(‘title’));
    }

}


//Topic B: Adding Security to the Project
//Exercise: Implementing validation in PHP.
// Step 23

<?php include(APPDIR.’views/layouts/header.php’);?>

<div class=“wrapper well”>

    <?php include(APPDIR.’views/layouts/errors.php’);?>

    <form action=“/admin/login” method=“post”>

    <h1>Login</h1>

    <div class=“control-group”>
        <label class=“control-label” for=“username”> Username</label>
        <input class=“form-control” id=“username” type=“text” name=“username” />
    </div>

    <div class=“control-group”>
        <label class=“control-label” for=“password”> Password</label>
        <input class=“form-control” id=“password” type=“password” name=“password” />
    </div>

    <br>

    <p class=“pull-left”><button type=“submit” class=“btn btn-sm btn-success” name=“submit”>Login</button></p>
    <p class=“pull-right”><a href=“/admin/reset”>Forgot Password</a></p>

    <div class=“clearfix”></div>

    </form>

</div>

<?php include(APPDIR.’views/layouts/footer.php’);?>

Inside webroot/css/style.css add enter:

.wrapper {
    max-width: 420px;
    margin: auto;
}

.wrapper h1 {
    margin-top: 0px;
    font-size: 25px;
}



//Topic B: Adding Security to the Project
//Exercise: Implementing validation in PHP.
// After Step 30

The full method looks like this:

public function login()
{
    if (Session::get(‘logged_in’)) {
        Url::redirect(‘/admin’);
    }

    $errors = [];

    if (isset($_POST[‘submit’])) {
        $username = htmlspecialchars($_POST[‘username’]);
        $password = htmlspecialchars($_POST[‘password’]);

        if (password_verify($password, $this->user->get_hash($username)) == false) {
            $errors[] = ‘Wrong username or password’;
        }

        if (count($errors) == 0) {

            //logged in
            $data = $this->user->get_data($username);

            Session::set(‘logged_in’, true);
            Session::set(‘user_id’, $data->id);

            Url::redirect(‘/admin’);
        }
    }

    $title = ‘Login’;

    $this->view->render(‘admin/auth/login’, compact(‘title’, ‘errors’));
}


//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// Step 3:


public function reset()
{
    if (Session::get(‘logged_in’)) {
        Url::redirect(‘/admin’);
    }

    $errors = [];

    if (isset($_POST[‘submit’])) {

       $email = (isset($_POST[‘email’]) ? $_POST[‘email’] : null);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ‘Please enter a valid email address’;
        } else {
            if ($email != $this->user->get_user_email($email)){
                $errors[] = ‘Email address not found’;
            }
        }

        if (count($errors) == 0) {

          

        }

    }

     $title = ‘Reset Account’;

    $this->view->render(‘admin/auth/reset’, compact(‘title’, ‘errors’));
}


//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// Step 4

<?php include(APPDIR.’views/layouts/header.php’);?>

<div class=“wrapper well”>

    <?php include(APPDIR.’views/layouts/errors.php’);?>

    <h1>Reset Account</h1>

    <form method=“post”>

    <div class=“control-group”>
        <label class=“control-label” for=“email”> Email</label>
        <input class=“form-control” id=“email” type=“text” name=“email” />
    </div>

    <br>

    <p class=“pull-left”><button type=“submit” class=“btn btn-sm btn-success” name=“submit”>Send reset email</button></p>
    <p class=“pull-right”><a href=“/admin/login”>Login</a></p>

    <div class=“clearfix”></div>

    </form>

    </div>

<?php include(APPDIR.’views/layouts/footer.php’);?>




//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// After Step 22

The completed method looks like this:
public function reset()
{
    if (Session::get(‘logged_in’)) {
        Url::redirect(‘/admin’);
    }

    $errors = [];

    if (isset($_POST[‘submit’])) {

       $email = (isset($_POST[‘email’]) ? $_POST[‘email’] : null);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ‘Please enter a valid email address’;
        } else {
            if ($email != $this->user->get_user_email($email)){
                $errors[] = ‘Email address not found’;
            }
        }

        if (count($errors) == 0) {

            $token = md5(uniqid(rand(),true));
            $data  = [‘reset_token’ => $token];
            $where = [‘email’ => $email];
            $this->user->update($data, $where);

            $mail = new PHPMailer(true);
            $mail->setFrom(‘noreply@domain.com‘);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = ‘Reset you account’;
            $mail->Body    = “<p>To change your password please click <a href=‘http://localhost:8000/admin/change_password/$token’>this link</a></p>“;
            $mail->AltBody = “To change your password please go to this address: http://localhost:8000/admin/change_password/$token“;
            $mail->send();

            Session::set(‘success’, “Email sent to “.htmlentities($email));

            Url::redirect(‘/admin/reset’);

        }

    }

     $title = ‘Reset Account’;

    $this->view->render(‘admin/auth/reset’, compact(‘title’, ‘errors’));
}


//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// After Step 23

The method looks like this:

public function change_password($token)
{
    if (Session::get(‘logged_in’)) {
        Url::redirect(‘/admin’);
    }

    $errors = [];

    $user = $this->user->get_user_reset_token($token);

    if ($user == null) {
        $errors[] = ‘user not found.’;
    }

    $title = ‘Change Password’;

    $this->view->render(‘admin/auth/change_password’, compact(‘title’, ‘token’, ‘errors’));
}


//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// Step 24

<?php include(APPDIR.’views/layouts/header.php’);?>

<div class=“wrapper well”>

    <?php include(APPDIR.’views/layouts/errors.php’);?>

    <h1>Change Password</h1>

    <form method=“post”>
    <input type=‘hidden’ name=“token” value=‘<?=$token;?>‘>

    <div class=“control-group”>
        <label class=“control-label” for=“password”> Password</label>
        <input class=“form-control” id=“password” type=“password” name=“password” required />
    </div>

    <div class=“control-group”>
        <label class=“control-label” for=“password_confirm”>Confirm Password</label>
        <input class=“form-control” id=“password_confirm” type=“password” name=“password_confirm” required />
    </div>

    <br>

    <p class=“pull-left”><button type=“submit” class=“btn btn-sm btn-success” name=“submit”>Change Password</button></p>
    <p class=“pull-right”><a href=“/admin/login”>Login</a></p>

    <div class=“clearfix”></div>

    </form>

    </div>

<?php include(APPDIR.’views/layouts/footer.php’);?>


//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// Step 25

if (isset($_POST[‘submit’])) {

    $token = htmlspecialchars($_POST[‘token’]);
    $password  = htmlspecialchars($_POST[‘password’]);
    $password_confirm = htmlspecialchars($_POST[‘password_confirm’]);

    $user = $this->user->get_user_reset_token($token);

    if ($user == null) {
        $errors[] = ‘user not found.’;
    }

    if ($password != $password_confirm) {
        $errors[] = ‘Passwords to not match’;
    } elseif (strlen($password) < 3) {
        $errors[] = ‘Password is too short’;
    }

    if (count($errors) == 0) {

        $data  = [
                ‘reset_token’ => null,
                ‘password’ => password_hash($password, PASSWORD_BCRYPT)
        ];

         $where = [
                ‘id’ => $user->id,
                ‘reset_token’ => $token
        ];

        $this->user->update($data, $where);

        Session::set(‘logged_in’, true);
        Session::set(‘user_id’, $user->id);
        Session::set(‘success’, “Password updated”);

        Url::redirect(‘/admin’);

    }

}


//Topic C: Password Recovery
// Exercise: Building a password reset mechanism for our application.
// After Step 26

The full method looks like this:

public function change_password($token)
{
    if (Session::get(‘logged_in’)) {
        Url::redirect(‘/admin’);
    }

    $errors = [];

    $user = $this->user->get_user_reset_token($token);

    if ($user == null) {
        $errors[] = ‘user not found.’;
    }

    if (isset($_POST[‘submit’])) {

        $token            = htmlspecialchars($_POST[‘token’]);
        $password         = htmlspecialchars($_POST[‘password’]);
        $password_confirm = htmlspecialchars($_POST[‘password_confirm’]);

        $user = $this->user->get_user_reset_token($token);

        if ($user == null) {
            $errors[] = ‘user not found.’;
        }

        if ($password != $password_confirm) {
            $errors[] = ‘Passwords to not match’;
        } elseif (strlen($password) < 3) {
            $errors[] = ‘Password is too short’;
        }

        if (count($errors) == 0) {

            $data  = [
                ‘reset_token’ => null,
                ‘password’ => password_hash($password, PASSWORD_BCRYPT)
            ];

            $where = [
                ‘id’ => $user->id,
                ‘reset_token’ => $token
            ];

            $this->user->update($data, $where);

            Session::set(‘logged_in’, true);
            Session::set(‘user_id’, $user->id);
            Session::set(‘success’, “Password updated”);

            Url::redirect(‘/admin’);

        }

    }

    $title = ‘Change Password’;

    $this->view->render(‘admin/auth/change_password’, compact(‘title’, ‘token’, ‘errors’));
}




//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//Step 2

get_users() – returns all users ordered by username
get_user_username($username) – get the username from the database
get_user_user($id)  - get a single user record

public function get_users()
{
    return $this->db->select(‘* from users order by username’);
}

public function get_user($id)
{
    $data = $this->db->select(‘* from users where id = :id’, [‘:id’ => $id]);
    return (isset($data[0]) ? $data[0] : null);
}

public function get_user_username($username)
{
    $data = $this->db->select(‘username from users where username = :username’, [‘:username’ => $username]);
    return (isset($data[0]->username) ? $data[0]->username : null);
}



//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//Step 10

<?php
include(APPDIR.’views/layouts/header.php’);
include(APPDIR.’views/layouts/nav.php’);
?>

<h1>Users</h1>

<?php include(APPDIR.’views/layouts/errors.php’);?>

<p><a href=“/users/add” class=“btn btn-xs btn-info”>Add User</a></p>

<div class=‘table-responsive’>
    <table class=‘table table-striped table-hover table-bordered’>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php foreach($users as $row) { ?>
    <tr>
        <td><?=htmlentities($row->username);?></td>
        <td><?=htmlentities($row->email);?></td>
        <td>
            <a href=“/users/edit/<?=$row->id;?>“ class=“btn btn-xs btn-warning”>Edit</a>
            <a href=“/users/delete/<?=$row->id;?>“ class=“btn btn-xs btn-danger”>Delete</a>
        </td>
    </tr>
    <?php } ?>
    </table>
</div>

<?php include(APPDIR.’views/layouts/footer.php’);?>


//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//Step 16


<?php
include(APPDIR.’views/layouts/header.php’);
include(APPDIR.’views/layouts/nav.php’);
include(APPDIR.’views/layouts/errors.php’);
?>

<h1>Add User</h1>

<form method=“post”>

    <div class=“row”>

        <div class=“col-md-6”>

            <div class=“control-group”>
                <label class=“control-label” for=“username”> Username</label>
                <input class=“form-control” id=“username” type=“text” name=“username” value=“<?=(isset($_POST[‘username’]) ? $_POST[‘username’] : ‘‘);?>“ required  />
            </div>

            <div class=“control-group”>
                <label class=“control-label” for=“email”> Email</label>
                <input class=“form-control” id=“email” type=“email” name=“email” value=“<?=(isset($_POST[‘email’]) ? $_POST[‘email’] : ‘‘);?>“ required  />
            </div>

        </div>

        <div class=“col-md-6”>

            <div class=“control-group”>
                <label class=“control-label” for=“password”> Password</label>
                <input class=“form-control” id=“password” type=“password” name=“password” required/>
            </div>

            <div class=“control-group”>
                <label class=“control-label” for=“password_confirm”> Confirm Password</label>
                <input class=“form-control” id=“password_confirm” type=“password” name=“password_confirm” required/>
            </div>

        </div>

    </div>

    <br>

    <p><button type=“submit” class=“btn btn-success” name=“submit”><i class=“fa fa-check”></i> Submit</button></p>

</form>

<?php include(APPDIR.’views/layouts/footer.php’);?>


//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//After Step 27

The full method looks like this:
public function add()
    {
        $errors = [];

        if (isset($_POST[‘submit’])) {
            $username            = (isset($_POST[‘username’]) ? $_POST[‘username’] : null);
            $email               = (isset($_POST[‘email’]) ? $_POST[‘email’] : null);
            $password            = (isset($_POST[‘password’]) ? $_POST[‘password’] : null);
            $password_confirm    = (isset($_POST[‘password_confirm’]) ? $_POST[‘password_confirm’] : null);

            if (strlen($username) < 3) {
                $errors[] = ‘Username is too short’;
            } else {
                if ($username == $this->user->get_user_username($username)){
                    $errors[] = ‘Username address is already in use’;
                }
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = ‘Please enter a valid email address’;
            } else {
                if ($email == $this->user->get_user_email($email)){
                    $errors[] = ‘Email address is already in use’;
                }
            }

            if ($password != $password_confirm) {
                $errors[] = ‘Passwords do not match’;
            } elseif (strlen($password) < 3) {
                $errors[] = ‘Password is too short’;
            }

            if (count($errors) == 0) {

                $data = [
                    ‘username’ => $username,
                    ‘email’ => $email,
                    ‘password’ => password_hash($password, PASSWORD_BCRYPT)
                ];

                $this->user->insert($data);

                Session::set(‘success’, ‘User created’);

                Url::redirect(‘/users’);

            }

        }

        $title = ‘Add User’;
        $this->view->render(‘admin/users/add’, compact(‘errors’, ‘title’));
    }


//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//Step 33

<?php
include(APPDIR.’views/layouts/header.php’);
include(APPDIR.’views/layouts/nav.php’);
include(APPDIR.’views/layouts/errors.php’);
?>

<h1>Edit User</h1>

<form method=“post”>

    <div class=“row”>

        <div class=“col-md-6”>

            <div class=“control-group”>
                <label class=“control-label” for=“username”> Username</label>
                <input class=“form-control” id=“username” type=“text” name=“username” value=“<?=$user->username;?>“ required />
            </div>

            <div class=“control-group”>
                <label class=“control-label” for=“email”> Email</label>
                <input class=“form-control” id=“email” type=“email” name=“email” value=“<?=$user->email;?>“ required />
            </div>

        </div>

        <div class=“col-md-6”>

            <div class=“panel panel-primary”>
                <div class=“panel-heading”>Password, only enter to change the existing password.</div>
                <div class=“panel-body”>

                    <div class=“control-group”>
                        <label class=“control-label” for=“password”> Password</label>
                        <input class=“form-control” id=“password” type=“password” name=“password” />
                    </div>

                    <div class=“control-group”>
                        <label class=“control-label” for=“password_confirm”> Password</label>
                        <input class=“form-control” id=“password_confirm” type=“password” name=“password_confirm” />
                    </div>

                </div>
            </div>

        </div>

    </div>

    <p><button type=“submit” class=“btn btn-success” name=“submit”><i class=“fa fa-check”></i> Submit</button></p>

</form>

<?php include(APPDIR.’views/layouts/footer.php’);?>


//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//Step 35

if (isset($_POST[‘submit’])) {
    $username            = (isset($_POST[‘username’]) ? $_POST[‘username’] : null);
    $email               = (isset($_POST[‘email’]) ? $_POST[‘email’] : null);
    $password            = (isset($_POST[‘password’]) ? $_POST[‘password’] : null);
    $password_confirm    = (isset($_POST[‘password_confirm’]) ? $_POST[‘password_confirm’] : null);

    if (strlen($username) < 3) {
        $errors[] = ‘Username is too short’;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = ‘Please enter a valid email address’;
    }

    if ($password != null) {
        if ($password != $password_confirm) {
            $errors[] = ‘Passwords do not match’;
        } elseif (strlen($password) < 3) {
            $errors[] = ‘Password is too short’;
        }
    }


//Topic D: Building CRUD for User Management
//Exercise: Building CRUD for user management
//After Step 39

The full update method looks like this:
public function edit($id)
{
    if (! is_numeric($id)) {
        Url::redirect(‘/users’);
    }

    $user = $this->user->get_user($id);

    if ($user == null) {
        Url::redirect(‘/404’);
    }

    $errors = [];

    if (isset($_POST[‘submit’])) {
        $username            = (isset($_POST[‘username’]) ? $_POST[‘username’] : null);
        $email               = (isset($_POST[‘email’]) ? $_POST[‘email’] : null);
        $password            = (isset($_POST[‘password’]) ? $_POST[‘password’] : null);
        $password_confirm    = (isset($_POST[‘password_confirm’]) ? $_POST[‘password_confirm’] : null);

        if (strlen($username) < 3) {
            $errors[] = ‘Username is too short’;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ‘Please enter a valid email address’;
        }

        if ($password != null) {
            if ($password != $password_confirm) {
                $errors[] = ‘Passwords do not match’;
            } elseif (strlen($password) < 3) {
                $errors[] = ‘Password is too short’;
            }
        }

        if (count($errors) == 0) {

            $data = [
                ‘username’ => $username,
                ‘email’ => $email
            ];

            if ($password != null) {
                $data[‘password’] = password_hash($password, PASSWORD_BCRYPT);
            }

            $where = [‘id’ => $id];

            $this->user->update($data, $where);

            Session::set(‘success’, ‘User updated’);

            Url::redirect(‘/users’);

        }

    }

    $title = ‘Edit User’;
    $this->view->render(‘admin/users/edit’, compact(‘user’, ‘errors’, ‘title’));
}

