<?php

class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count()
    {
        $this->db->from('user');
        $this->db->where('type','Admin');

        return $this->db->count_all_results();
    }

    public function select($limit, $start)
    {
        $this->db->from('user');
        $this->db->where('type','Admin');

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert('User', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_where($id)
    {
        $this->db->from('user');
        $this->db->where('id', $id);
        $result = $this->db->get();
        return $result->result();
    }

    public function get()
    {
        $this->db->from('user');
        $this->db->where('type !=', 'Admin');
        $query = $this->db->get();
        return $query->result();
    }

    public function login($data)
    {
        $result = $this->db->get_where('user', array('email' => $data['email'], 'password' => $data['password']));
        return $result->result();
    }

    public function update($data,$id)
    {
        $this->db->update('user', $data, array('id' => $id));
    }

    public function activate($data,$id,$activation_code)
    {
        $this->db->update('user', $data, array('id' => $id, 'activation_code' => $activation_code));
    }

    public function validate_user($data)
    {
        $query = $this->db->get_where('user', array('id' => $data['id'], 'password' => $data['password']));
        return $query->result();
    }

    public function get_activation_code($id,$activation_code)
    {
        $query = $this->db->get_where('user', array('id' => $id, 'activation_code' => $activation_code));
        $result = $query->row();
        return $result;
    }

    public function delete($uid)
    {
        $this->db->delete('user', array('id' => $uid));
    }

    

}