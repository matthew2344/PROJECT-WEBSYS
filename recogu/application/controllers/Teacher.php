<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// 
// ---[TEACHER CONTROLLER]---
// --FUNCTIONS--[TOTAL OF 07]
// TEACHER DASHBOARD AND PROFILE -> LINE 18-155
// SESSION CHECKER [TEACHER] -> LINE 157-166
// [OTHER FUNCTIONS ARE WORK IN PROGRESS]
class Teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->library(array('session','upload','form_validation'));
    }

    // ---[TEACHER DASHBOARD AND PROFILE]---
	// 			---[START]---
    public function index()
    {
        $this->check_session();
        $data['title'] = 'Teacher Dashboard';
        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

    public function profile()
    {
        $this->check_session();
        $data['title'] = 'Teacher Dashboard';
        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

    public function edit_profile()
    {
        $this->check_session();
        $data['title'] = 'Teacher Dashboard';
        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/edit_profile');
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
            );

            $this->session->set_userdata(
                array(
                    'fname' => $this->input->post('fname'),
                    'mname' => $this->input->post('mname'),
                    'lname' => $this->input->post('lname'),
                )
            );

            $this->User->update($data,$uid);
            redirect('Teacher/profile');
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
            'upload_path' =>  $this->config->item('Upload_path'),
            'allowed_types' => $this->config->item('Img_types'),
            'max_size' => $this->config->item('Max_img_size'),
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
            redirect('Teacher/profile');
        }
    }

    public function my_class()
    {
        $this->check_session();
        
        $data['title'] = 'My Class';
        $this->load->model('Attendance');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Teacher/my_class";
		$config["total_rows"] = $this->Attendance->count();
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['face_data'] = $this->file->get_data($config["per_page"], $page);

        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/my_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }
    // ---[TEACHER DASHBOARD AND PROFILE]---
	// 			---[END]---

    public function bootstrap_pagination()
	{
		// BOOTSTRAP 
		return array(
			'full_tag_open' => '<ul class="pagination">',        
			'full_tag_close' => '</ul>',        
			'first_link' => 'First',    
			'last_link' => 'Last',        
			'first_tag_open' => '<li class="page-item"><span class="page-link">',        
			'first_tag_close' => '</span></li>',        
			'prev_link' => '&laquo',        
			'prev_tag_open' => '<li class="page-item"><span class="page-link">',        
			'prev_tag_close' => '</span></li>',        
			'next_link' => '&raquo',        
			'next_tag_open' => '<li class="page-item"><span class="page-link">',        
			'next_tag_close' => '</span></li>',        
			'last_tag_open' => '<li class="page-item"><span class="page-link">',        
			'last_tag_close' => '</span></li>',        
			'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',        
			'cur_tag_close' => '</a></li>',       
			'num_tag_open' => '<li class="page-item"><span class="page-link">',        
			'num_tag_close' => '</span></li>',
		);
		// BOOTSTRAP
	}

    public function check_session()
    {
        // ---[FUNCTION DESCRIPTION & USE CASE SCENARIO]---
		// SESSION CHECKER FOR TEACHER LOGINS; LIMITS ACCESS TO OTHER USERTYPES
		// REDIRECTS TO LOGIN PAGE 
        if($this->session->userdata['teacher_logged_in'] == FALSE)
		{
			redirect('Login');
		}
    }
}