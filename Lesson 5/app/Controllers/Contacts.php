<?php namespace App\Controllers;

use System\BaseController;
use App\Models\Contact;

class Contacts extends BaseController
{
    public function index()
    {
        //instantiate Contact model
        $contact = new Contact();

        //call the getContacts method and store to a local variable
        $contacts = $contact->getContacts();

        //load a view and pass in the contacts using a compact()
        echo $this->view->render('contacts/index', compact('contacts'));
    }
}
