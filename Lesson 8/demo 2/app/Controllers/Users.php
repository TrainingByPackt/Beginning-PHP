<?php namespace App\Controllers;

use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\User;

class Users extends BaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        if (! Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        $this->user = new User();
    }

    public function index()
    {
        $users = $this->user->get_users();
        $title = 'Users';

        $this->view->render('admin/users/index', compact('users', 'title'));
    }

    public function add()
    {
        $errors = [];

        if (isset($_POST['submit'])) {
            $username            = (isset($_POST['username']) ? $_POST['username'] : null);
            $email               = (isset($_POST['email']) ? $_POST['email'] : null);
            $password            = (isset($_POST['password']) ? $_POST['password'] : null);
            $password_confirm    = (isset($_POST['password_confirm']) ? $_POST['password_confirm'] : null);

            if (strlen($username) < 3) {
                $errors[] = 'Username is too short';
            } else {
                if ($username == $this->user->get_user_username($username)){
                    $errors[] = 'Username address is already in use';
                }
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            } else {
                if ($email == $this->user->get_user_email($email)){
                    $errors[] = 'Email address is already in use';
                }
            }

            if ($password != $password_confirm) {
                $errors[] = 'Passwords do not match';
            } elseif (strlen($password) < 3) {
                $errors[] = 'Password is too short';
            }

            if (count($errors) == 0) {

                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT)
                ];

                $this->user->insert($data);

                Session::set('success', 'User created');

                Url::redirect('/users');

            }

        }

        $title = 'Add User';
        $this->view->render('admin/users/add', compact('errors', 'title'));
    }

    public function edit($id)
    {
        if (! is_numeric($id)) {
            Url::redirect('/users');
        }

        $user = $this->user->get_user($id);

        if ($user == null) {
            Url::redirect('/404');
        }

        $errors = [];

        if (isset($_POST['submit'])) {
            $username            = (isset($_POST['username']) ? $_POST['username'] : null);
            $email               = (isset($_POST['email']) ? $_POST['email'] : null);
            $password            = (isset($_POST['password']) ? $_POST['password'] : null);
            $password_confirm    = (isset($_POST['password_confirm']) ? $_POST['password_confirm'] : null);

            if (strlen($username) < 3) {
                $errors[] = 'Username is too short';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }

            if ($password != null) {
                if ($password != $password_confirm) {
                    $errors[] = 'Passwords do not match';
                } elseif (strlen($password) < 3) {
                    $errors[] = 'Password is too short';
                }
            }

            if (count($errors) == 0) {

                $data = [
                    'username' => $username,
                    'email' => $email
                ];

                if ($password != null) {
                    $data['password'] = password_hash($password, PASSWORD_BCRYPT);
                }

                $where = ['id' => $id];

                $this->user->update($data, $where);

                Session::set('success', 'User updated');

                Url::redirect('/users');

            }

        }

        $title = 'Edit User';
        $this->view->render('admin/users/edit', compact('user', 'errors', 'title'));
    }

    public function delete($id)
    {
        if (! is_numeric($id)) {
            Url::redirect('/users');
        }

        if (Session::get('user_id') == $id) {
            die('You cannot delete yourself.');
        }

        $user = $this->user->get_user($id);

        if ($user == null) {
            Url::redirect('/404');
        }

        $where = ['id' => $user->id];

        //$this->user->delete($where);

        Session::set('success', 'User deleted');

        Url::redirect('/users');
    }
}
