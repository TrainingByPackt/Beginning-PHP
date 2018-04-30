<?php
namespace App\Models;

use System\BaseModel;

class Contact extends BaseModel
{
    public function getContacts()
    {
        return $this->db->select('* FROM contacts');
    }
}
