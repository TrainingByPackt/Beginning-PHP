<?php
namespace App\Models;

use System\BaseModel;

class Contact extends BaseModel
{
    public function get_contacts()
    {
        return $this->db->select('* from contacts order by name');
    }

    public function get_contact($id)
    {
        $data = $this->db->select('* from contacts where id = :id', [':id' => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }

    public function insert($data)
    {
        $this->db->insert('contacts', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('contacts', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('contacts', $where);
    }
}
