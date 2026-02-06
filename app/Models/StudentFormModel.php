<?php

namespace App\Models;

use CodeIgniter\Model;


class StudentFormModel extends Model
{
    protected $table = 'studentregisterationform';
    protected $allowedFields = ['rollNo', 'fname', 'lname', 'father_name', 'dob', 'mobile', 'email', 'password', 'gender', 'department', 'course', 'file', 'city', 'address'];

    public function deleteItemById($id)
    {
        $result = $this->db->query("Delete from studentregisterationform where id = $id");
        return $result;
    }

    public function getAllItems()
    {   
       
        return [
            'items' => $this->orderBy('id', 'ASC')
                ->paginate(50),
            'pager' => $this->pager,
        ];
    }

    public function getItemById($id)
    {
        $result = $this->db->query("Select * from studentregisterationform where id = $id");
        $result = $result->getRowArray();
        return $result;
    }

    public function updateItemById($id, $data)
    {
        $result = $this->db->table('studentregisterationform')
            ->where('id', $id)
            ->update($data);
    }

    public function insertItem($data)
    {

        $result = $this->db->table('studentregisterationform')
            ->insert($data);
        return $result;
    }

}
