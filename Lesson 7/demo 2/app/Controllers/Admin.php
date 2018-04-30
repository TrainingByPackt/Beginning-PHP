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
        if (! Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        $title = 'Dashboard';

        $this->view->render('admin/index', compact('title'));
    }

    public function login()
    {
        //echo password_hash('demo', PASSWORD_BCRYPT);

        if (Session::get('logged_in')) {
            Url::redirect('/admin');
        }

        $errors = [];

        if (isset($_POST['submit'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            if (password_verify($password, $this->user->get_hash($username)) == false) {
                $errors[] = 'Wrong username or password';
            }

            if (count($errors) == 0) {

                //logged in
                $data = $this->user->get_data($username);

                Session::set('logged_in', true);
                Session::set('user_id', $data->id);

                Url::redirect('/admin');
            }
        }

        $title = 'Login';

        $this->view->render('admin/auth/login', compact('title', 'errors'));
    }

    public function logout()
    {
        Session::destroy();
        Url::redirect('/admin/login');
    }

}
