<?php

class Logs extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function inner_count($id, $search = "")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.id', 'inner');
        $this->db->join('class', 'class.classID = student.section', 'inner');

        $this->db->where('student.section', $id);
        
        if($search != '')
        {
            $this->db->group_start();
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->group_end();
        }


        return $this->db->count_all_results();
    }

    public function inner_get($limit, $start,$id,$search = "")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.id', 'inner');
        $this->db->join('class', 'class.classID = student.section', 'inner');

        $this->db->where('student.section', $id);

        if($search != '')
        {
            $this->db->group_start();
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->group_end();
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }


}