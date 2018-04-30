<?php namespace App\Models;

use System\BaseModel;

class User extends BaseModel
{
    public function get_hash($username)
    {
        $data = $this->db->select('password FROM users WHERE username = :username', [':username' => $username]);
        return (isset($data[0]->password) ? $data[0]->password : null);
    }

    public function get_data($username)
    {
        $data = $this->db->select('* FROM users WHERE username = :username', [':username' => $username]);
        return (isset($data[0]) ? $data[0] : null);
    }

    public function get_user_email($email)
    {
        $data = $this->db->select('email from users where email = :email', [':email' => $email]);
        return (isset($data[0]->email) ? $data[0]->email : null);
    }

    public function insert($data)
    {
        $this->db->insert('users', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('users', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('users', $where);
    }
}
