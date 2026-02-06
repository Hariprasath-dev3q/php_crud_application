<?php

namespace App\Models;

use CodeIgniter\Model;


class StudentDetailsModel extends Model
{
    protected $table = 'studentdetails';
    protected $allowedFields = ['rollNo', 'fname', 'lname', 'father_name', 'dob', 'mobile', 'email', 'password', 'gender', 'department', 'course', 'city', 'address'];

    public function findAllItems()
    {
        return $this->db
            ->table('studentdetails')
            ->get()
            ->getResultArray();
    }
    public function countAllItems()
    {
        $result = $this->db->query("Select COUNT(*) as count from studentdetails");
        $result = $result->getRowArray();
        return $result['count'];
    }

    public function getItemsPaginated($page)
    {
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $items = $this->db->query("Select * from studentdetails ORDER BY id ASC LIMIT $perPage OFFSET $offset");
        $items = $items->getResultArray();

        $totalItems = $this->countAllItems();
        $totalPages = ceil($totalItems / $perPage);

        return [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }

    public function getAllItems()
    {

        return [
            'items' => $this->orderBy('id', 'ASC')
                ->paginate(50),
            'pager' => $this->pager,
        ];
    }

    public function deleteByIds(array $ids)
    {
        if (empty($ids)) {
            return false;
        }
        $this->db->table('studentdetails')
            ->whereIn('id', $ids)
            ->delete();
    }


    /**
     * Helper method for INSERT-SELECT queries
     */
    // public function customInsertBatch($set = null, ?bool $escape = null, int $batchSize = 100)
    // {

    //     if (isset($this->QBOptions['setQueryAsData'])) {
    //         $sql = $this->_insertBatch($this->QBFrom[0], $this->QBKeys, []);

    //         if (!$sql) return false;

    //         if (!$this->testMode) {
    //             $this->db->query($sql);
    //         }

    //         $this->resetWrite();

    //         return $this->testMode ? $sql : $this->db->affectedRows();
    //     }


    //     if (!empty($set)) {
    //         $this->setData($set, $escape);
    //     }

    //     return $this->batchExecute('_insertBatch', $batchSize);
    // }
    public function insertItem($data)
    {

        if(empty($data)){
            return false;
        }
        return $this->insertBatch($data);
    }
}
