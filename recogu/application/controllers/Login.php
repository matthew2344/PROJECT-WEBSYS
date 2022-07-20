<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'string'));
		$this->load->library(array('form_validation', 'session',));
	}

	public function index()
	{
		$data['title'] = "Login";
		$data['navlink'] = base_url('Welcome/auth');
		$data['navtitle'] = 'Admin';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('login');
		$this->load->view('includes/footer_nav');
		$this->load->view('includes/footer');
	}

    public function auth()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if(!$this->form_validation->run())
		{
			$this->auth();
		}
        else
        {
            $data = array(
				'email' => $this->input->post('email'),
				'password' => sha1($this->input->post('password')),
			);


            $this->load->model('User');
            if($results = $this->User->login($data))
            {
                // VALID LOGIN
                foreach($results as $result)
                {
                    $newdata = array(
                        'uid' => $result->id,
                        'fname' => $result->fname,
                        'mname' => $result->mname,
                        'lname' => $result->lname,
                        'email' => $result->email,
                        'type' => $result->type,
                        'avatar' => $result->avatar,
                        'status' => $result->status,
                    );
                }
                $this->session->set_userdata($newdata);
                $this->redirect_user($this->session->userdata['type'],$this->session->userdata['status']);
            }
            else
            {
                // INVALID LOGIN
                $this->session->set_flashdata('error', 'Invalid Login Credentials');
                $this->index();
            }
        }
    }

    public function redirect_user($usertype,$status)
    {
        if($usertype == 'Admin')
        {
            if($status == 0)
            {
                $this->session->set_flashdata('error', 'User not activated');
                $this->index();
            }
            else
            {
                $this->session->set_userdata('admin_logged_in', TRUE);
                redirect('Admin');
            }
        }
        elseif($usertype == 'Teacher')
        {
            
            $this->session->set_userdata('teacher_logged_in', TRUE);
            redirect('Teacher');
        }
        elseif($usertype == 'Staff')
        {
            redirect('Staff');
        }
        elseif($usertype == 'Student')
        {

            $this->session->set_userdata('student_logged_in', TRUE);
            redirect('Student');

        }
        else
        {
            $this->index();
        }
    }


}