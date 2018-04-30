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

    public function get_users()
    {
        return $this->db->select('* from users order by username');
    }

    public function get_user($id)
    {
        $data = $this->db->select('* from users where id = :id', [':id' => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }

    public function get_user_username($username)
    {
        $data = $this->db->select('username from users where username = :username', [':username' => $username]);
        return (isset($data[0]->username) ? $data[0]->username : null);
    }

    public function get_user_email($email)
    {
        $data = $this->db->select('email from users where email = :email', [':email' => $email]);
        return (isset($data[0]->email) ? $data[0]->email : null);
    }

    public function get_user_reset_token($token)
    {
        $data = $this->db->select('id from users where reset_token = :reset_token', [':reset_token' => $token]);
        return (isset($data[0]) ? $data[0] : null);
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
