<?php
namespace App\Models;

use System\BaseModel;

class Comment extends BaseModel
{
    public function get_comments($id)
    {
        return $this->db->select('
            comments.body,
            comments.created_at,
            users.username
        from
            comments,
            users
        where
            comments.user_id = users.id
            and contact_id = :id'
        , [':id' => $id]);
    }

    public function insert($data)
    {
        $this->db->insert('comments', $data);
    }
}
