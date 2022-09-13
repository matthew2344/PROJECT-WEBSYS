<?php

class Attendance extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function attendance_count($search = "")
    {
        $this->db->from('attendance');
        $this->db->join('user', 'user.id = attendance.uid', 'inner');

        if($search != '')
        {
            $this->db->like('date', $search);
        }

        return $this->db->count_all_results();
    }

    public function select($limit, $start, $search = "")
    {
        $this->db->from('attendance');
        $this->db->join('user', 'user.id = attendance.uid', 'inner');

        if($search != '')
        {
            $this->db->like('date', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function attendance_stud_count($search)
    {
        $this->db->from('user');
        $this->db->join('attendance','attendance.uid = user.id', 'inner');
        $this->db->where('user.type','Student');

        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->like('mname', $search);
            $this->db->like('lname', $search);
        }

        return $this->db->count_all_results();
    }

    public function get_attendance_stud($limit, $start, $search)
    {
        $this->db->from('user');
        $this->db->join('attendance','attendance.uid = user.id', 'inner');
        $this->db->where('user.type','Student');

        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->like('mname', $search);
            $this->db->like('lname', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert('attendance',$data);
    }

    public function get_where($data)
    {
        $query = $this->db->get_where('attendance', array('uid' => $data['uid'],'date' => $data['date']));
        return $query->result();
    }

    
}