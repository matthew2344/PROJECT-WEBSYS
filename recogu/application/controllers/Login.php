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
        $this->form_validation->set_rules('enum', 'User number', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if(!$this->form_validation->run())
		{
			$this->auth();
		}
        else
        {
            $data = array(
				'id' => $this->input->post('enum'),
				'password' => sha1($this->input->post('password')),
			);


            $this->load->model('User');
            if($results = $this->User->validate_user($data))
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

    public function new_login()
    {
        $data['title'] = "New User Login";
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('first_login');
		$this->load->view('includes/footer');
    }

    public function validate_new()
    {
        $this->load->model('User');
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('oldpassword','Old Password','required');
        $this->form_validation->set_rules('password','New Password','required');
        $this->form_validation->set_rules('cpassword','Confirm Password','required|matches[password]');

        if(!$this->form_validation->run())
        {
            $this->new_login();
        }
        else
        {
            $data = array(
                'email' => $this->input->post('email'),
                'activation_code' => random_string('alnum', 16),
                'password' => sha1($this->input->post('password')),
            );
            $id = $this->session->userdata['uid'];
            $results = $this->User->get_where($this->session->userdata['uid']);
            if($results)
            {
                foreach($results as $i)
                {
                    $oldpass = $i->password;
                }
            
            }


            if($oldpass != sha1($this->input->post('oldpassword')))
            {
                $this->new_login();
                $this->session->set_flashdata('incorrect', 'Old password is incorrect');
            }
            else
            {
                $this->User->update($data,$id);
                $flash_data = array(
                    'temp_id' => $id,
                    'temp_email' => $data['email'],
                    'temp_activation_code' => $data['activation_code'],
                );
                $this->session->set_flashdata($flash_data);
                redirect('Verification');
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
            if($status == 0)
            {
                redirect('Login/new_login');
            }
            else
            {              
                $this->session->set_userdata('teacher_logged_in', TRUE);
                redirect('Teacher');
            }
        }
        elseif($usertype == 'Staff')
        {
            if($status == 0)
            {
                redirect('Login/new_login');
            }
            else
            {
                redirect('Staff');
            }
        }
        elseif($usertype == 'Student')
        {
            if($status == 0)
            {
                redirect('Login/new_login');
            }
            else
            {
                $this->session->set_userdata('student_logged_in', TRUE);
                redirect('Student');
            }
        }
        else
        {
            $this->index();
        }
    }


}