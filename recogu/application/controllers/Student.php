<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Student extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('session','form_validation'));
	}

    public function index()
	{
		$this->check_session();
		$data['title'] = "Student Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}



	public function profile()
	{
		$this->check_session();
		$data['title'] = "Student Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_profile()
	{
		$this->check_session();
		$data['title'] = "Student Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/edit_profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_profile($uid)
    {
        $this->check_session();
        $this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if(!$this->form_validation->run())
        {
            $this->edit_profile();
        }
        else
        {
            $data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
            );

            $this->session->set_userdata(
                array(
                    'fname' => $this->input->post('fname'),
                    'mname' => $this->input->post('mname'),
                    'lname' => $this->input->post('lname'),
                    'email' => $this->input->post('email'),
                )
            );

            $this->User->update($data,$uid);
            redirect('Student/profile');
        }
    }

	public function update_password($uid)
    {
        $this->check_session();
        $this->load->model('User');
        $this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
        if(!$this->form_validation->run())
        {
            $this->edit_profile();
        }
        else
        {
			$data['id'] = $uid;
            $results = $this->User->get_where($data);
            foreach($results as $result)
            {
                $oldpass = $result->password;
            }

            if($oldpass != sha1($this->input->post('oldpassword')))
            {
                $this->edit_profile();
                $this->session->set_flashdata('incorrect', 'Old password is incorrect');
            }
            else
            {
                $data = array('password' => sha1($this->input->post('password')));
    
                
                $this->User->update($data,$uid);
                redirect('Logout');
            }
        }
    }

	public function update_avatar($uid)
    {
        $this->check_session();
        $config = array(
            'upload_path' =>  './uploads/',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 2048
        );

        $this->load->library('upload');
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('avatar'))
        {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            $this->profile();
        }
        else
        {
            $upload_data = $this->upload->data();

            $data['avatar'] = $upload_data['file_name'];

            $this->load->model('User');
            $this->User->update($data,$uid);

            $this->session->set_userdata(array ('avatar' => $upload_data['file_name']));
            redirect('Student/profile');
        }
    }
	

	public function check_session()
	{
		if($this->session->userdata['student_logged_in'] == FALSE)
		{
            redirect('Login');
		}
	}


	


}
