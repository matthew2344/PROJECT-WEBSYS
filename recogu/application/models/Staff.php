<?php

class Staff extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count($search = "")
    {
        $this->db->from('user');
        $this->db->join('staff','staff.userID = user.id', 'inner');

        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
        }

        return $this->db->count_all_results();
    }

    public function select($limit, $start, $search="")
    {
        $this->db->from('user');
        $this->db->join('staff','staff.userID = user.id', 'inner');

        if($search != '')
        {
            $this->db->like('fname',$search);
            $this->db->or_like('mname',$search);
            $this->db->or_like('lname',$search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($udata)
    {
        // Insert New User
        $this->db->insert('user', $udata);

        // Create Password
        $data['password'] = sha1($this->db->insert_id());
        $last_id = $this->db->insert_id();
        $data['email'] = $last_id.'@email.com';
        $this->db->update('user', $data, array('id' => $last_id));

        return $last_id;
    }

    public function get_staff($id)
    {
        $this->db->from('user');
        $this->db->join('staff', 'staff.userID = user.id');
        $this->db->where('user.id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_staff($data)
    {
        $this->db->insert('staff', $data);
    }

    public function update($data,$id)
    {
        $this->db->update('user',$data, array('id' => $id));
    }

}