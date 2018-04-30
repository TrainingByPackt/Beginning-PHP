<?php namespace App\Controllers;

use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Contact;
use App\Models\Comment;

class Contacts extends BaseController
{
    protected $contact;

    public function __construct()
    {
        parent::__construct();

        if (! Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        $this->contact = new Contact();
    }

    public function index()
    {
        $contacts = $this->contact->get_contacts();

        $title = 'Contacts';
        return $this->view->render('admin/contacts/index', compact('contacts', 'title'));
    }

    public function add()
    {
        $errors = [];

        if (isset($_POST['submit'])) {
            $name  = (isset($_POST['name']) ? $_POST['name'] : null);
            $email = (isset($_POST['email']) ? $_POST['email'] : null);
            $tel   = (isset($_POST['tel']) ? $_POST['tel'] : null);

            if (strlen($name) < 3) {
                $errors[] = 'Name is too short';
            }

            if (count($errors) == 0) {

                $data = [
                    'name' => $name,
                    'email' => $email,
                    'tel' => $tel
                ];

                $this->contact->insert($data);

                Session::set('success', 'Contact created');

                Url::redirect('/contacts');

            }

        }

        $this->view->render('admin/contacts/add', compact('errors'));
    }

    public function edit($id)
    {
        if (! is_numeric($id)) {
            Url::redirect('/contacts');
        }

        $contact = $this->contact->get_contact($id);

        if ($contact == null) {
            Url::redirect('/404');
        }

        $errors = [];

        if (isset($_POST['submit'])) {
            $name  = (isset($_POST['name']) ? $_POST['name'] : null);
            $email = (isset($_POST['email']) ? $_POST['email'] : null);
            $tel   = (isset($_POST['tel']) ? $_POST['tel'] : null);

            if (strlen($name) < 3) {
                $errors[] = 'Name is too short';
            }

            if (count($errors) == 0) {

                $data = [
                    'name' => $name,
                    'email' => $email,
                    'tel' => $tel
                ];

                $where = ['id' => $id];

                $this->contact->update($data, $where);

                Session::set('success', 'Contact updated');

                Url::redirect('/contacts');

            }

        }

        $title = 'Edit Contact';
        $this->view->render('admin/contacts/edit', compact('contact', 'errors', 'title'));
    }

    public function delete($id)
    {
        if (! is_numeric($id)) {
            Url::redirect('/contacts');
        }

        $contact = $this->contact->get_contact($id);

        if ($contact == null) {
            Url::redirect('/404');
        }

        $where = ['id' => $contact->id];

        $this->contact->delete($where);

        Session::set('success', 'Contact deleted');

        Url::redirect('/contacts');
    }
}
