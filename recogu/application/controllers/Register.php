<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form','string'));
		$this->load->library(array('form_validation', 'session',));
	}

    public function index()
	{
		$data['title'] = "Register";
		$data['navlink'] = base_url('Welcome/auth');
		$data['navtitle'] = 'Admin';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('register');
		$this->load->view('includes/footer');
	}

    public function new_user()
    {
        $this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

        if(!$this->form_validation->run())
        {
            $this->index();
        }
        else
        {
            $data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'type' => 'Admin',
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'activation_code' => random_string('alnum', 16),
                'password' => sha1($this->input->post('password')),
            );

            $last_id = $this->User->insert($data);

			$flash_data = array(
				'temp_email' => $data['email'],
				'temp_activation_code' => $data['activation_code'],
				'temp_id' => $last_id,
			);
			$this->session->set_flashdata($flash_data);
			redirect('Verification');
        }
    }
}