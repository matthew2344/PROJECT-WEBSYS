<?php

class Classroom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($id)
    {
        $this->db->from('class');
        $this->db->where('classID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_like($data)
    {
        $this->db->from('class');
        $this->db->like('year_level',$data);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert('class',$data);
    }

    public function select()
    {
        $query = $this->db->get('class');
        $result = $query->result();
        return $result;
    }

    public function count($search = '')
    {
        $this->db->from('class');
        if($search != '')
        {

            $this->db->like('name', $search);
            $this->db->or_like('year_level', $search);
        }
        return $this->db->count_all_results();
    }

    public function paginate($limit, $start, $search = '')
    {
        $this->db->from('class');
        if($search != '')
        {
            $this->db->like('name', $search);
            $this->db->or_like('year_level', $search);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function test($id)
    {
        $query = $this->db->get_where('class', array('id' => $id));
        return $query->result();
    }


}