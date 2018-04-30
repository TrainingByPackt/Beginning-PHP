<?php namespace App\Controllers;

use System\BaseController;
use App\Models\Contact;

class Contacts extends BaseController
{
    public function index()
    {
        $contacts = new Contact();
        $records = $contacts->getContacts();

        return $this->view->render('contacts/index', compact('records'));
    }
}
