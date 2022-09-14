<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// ---[ADMIN CONTROLLER]---
// --FUNCTIONS--[TOTAL OF 32]
// ADMIN DASHBOARD AND PROFILE -> LINE 21-219
// STUDENT MANAGEMENT FUNCTIONS -> LINE 222-395
// TEACHER MANAGEMENT FUNCTIONS -> LINE 398-565
// STAFF MANAGEMENT FUNCTIONS -> LINE 568-735
// BOOTSTRAP CONFIGURATION/STYLE FOR PAGINATION -> LINE 737-764
// SESSION CHECKER [ADMIN] -> LINE 767-776
// [OTHER FUNCTIONS ARE WORK IN PROGRESS]
class Admin extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','string'));
		$this->load->library(array ('form_validation', 'upload', 'session', 'pagination'));
	}

	// ---[ADMIN DASHBOARD AND PROFILE]---
	// 			---[START]---
    public function index()
    {
		$this->check_session();
		$config = array();
		$config = $this->bootstrap_pagination();
		$this->load->model('User');
		$config["base_url"] =  base_url() . "Admin/";
		$config["total_rows"] = $this->User->count();
		$config["per_page"] = 7;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['admin'] = $this->User->select($config["per_page"], $page);
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

	public function profile()
	{
		$this->check_session();
		$data['title'] = "Admin Profile";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_profile()
	{
		$this->check_session();
		$data['title'] = "Admin Edit Profile";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_profile');
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
            redirect('Admin/profile');
        }
    }

	public function update_email($uid)
	{
		$this->load->model('User');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
		if(!$this->form_validation->run())
        {
            $this->edit_profile();
        }
		else
		{
			$data = array('email' => $this->input->post('email'));
			$this->session->set_userdata(array('email' => $this->input->post('email')));
			$this->User->update($data,$uid);
			redirect('Admin/profile');
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
            $results = $this->User->get_where($uid);
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
            redirect('Admin/profile');
        }
    }

	public function delete_user($id)
	{
		$this->check_session();
		$this->load->model('User');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if(!$this->form_validation->run())
		{
			$this->edit_profile();
		}
		else
		{
			$data = array(
				'id' => $id,
				'password' => sha1($this->input->post('password')),
			);
			if($result = $this->User->validate_user($data))
			{
				foreach($result as $i)
				{
					$file = $i->avatar;
				}
				if($file != 'profile_pic.jpg')
				{
					unlink("./uploads/".$file);
				}
				$this->User->delete($id);
				redirect('Logout');
			}else{
				$this->session->set_flashdata('error', 'Invalid Credentials');
				$this->edit_profile();
			}
		}

	}
	// ---[ADMIN DASHBOARD AND PROFILE]---
	// 			---[END]---

	// ---[STUDENT MANAGEMENT FUNCTION]---
	// 			---[START]---
	public function student()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$config = array();
		$this->load->model('Student');
		$this->load->model('Classroom');
		$data['section'] = $this->Classroom->select();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/student";
		$config["total_rows"] = $this->Student->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['students'] = $this->Student->select($config["per_page"], $page);

		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function search_student()
	{
		$this->check_session();

		$search = ($this->input->post("search_student"))? $this->input->post("search_student"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        $this->load->model('Student');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_student/$search";
		$config["total_rows"] = $this->Student->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['students'] = $this->Student->select($config["per_page"], $page, $search);
        $data['search'] = $search;
		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_student($id)
	{
		$this->check_session();
		$this->load->model('Student');
		$data['student'] = $this->Student->get_student($id);
		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_student($id)
	{
		$this->check_session();
		$this->load->model('Student');
		$data['student'] = $this->Student->get_student($id);
		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_student($id)
	{
		$this->check_session();
		$this->load->model('Student');
		$this->form_validation->set_rules('fname','First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		if(!$this->form_validation->run())
		{
			$this->edit_student($id);
		}
		else
		{
			$data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
			);

			$this->Student->update($data,$id);
			redirect('Admin/student');
		}
	}

	public function create_student()
	{
		$this->check_session();
		$this->load->model('Student');
		$this->form_validation->set_rules('fname', 'First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('yearlvl', 'Year level', 'required');
		$this->form_validation->set_rules('section', 'Section', 'required');
		if(!$this->form_validation->run())
		{
			$this->student();
		}
		else
		{
			// GET INPUTS
			$user_data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
				'type' => 'Student',
				'datecreated' => date('Y-m-d'),
			);
			$this->load->model('Classroom');
			$section = $this->input->post('section');
			$test = $this->Classroom->test($section);
			foreach($test as $i)
			{
				if($i->year_level != $this->input->post('yearlvl'))
				{
					$this->session->set_flashdata('Error', 'Wrong Input');
					$this->student();
				}
			}
			
			// FILE UPLOAD --
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
				$this->student();
			}
			else
			{
				// UPLOAD SUCCESS 
				$upload_data = $this->upload->data();
				// GET UPLOAD FILE NAME
				$user_data['avatar'] = $upload_data['file_name'];	
				// STORE PIC TO DATA DB
				$sid = $this->Student->insert($user_data);
				// GET
				$student_data = array(
					'sid' => $sid,
					'yearlvl' => $this->input->post('yearlvl'),
					'section' => $this->input->post('section'),
				);			
				$this->Student->insert_student($student_data);
				$this->session->set_flashdata('Success', 'Creation Success');
				redirect('Admin/student');
			}
		}

		
	}

	public function delete_student($id)
	{
		$this->check_session();
		$this->load->model(array('User','Student'));
		$result = $this->Student->get_student($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		unlink("./uploads/".$file);
		$this->User->delete($id);
		redirect('Admin/student');
	}
	// ---[STUDENT MANAGEMENT FUNCTION]---
	// 			---[END]---

	// ---[TEACHER MANAGEMENT FUNCTION]---
	// 			---[START]---
	public function teacher()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$config = array();
		$this->load->model('Teacher');
		$this->load->model('Classroom');
		$data['classes'] = $this->Classroom->select();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/teacher";
		$config["total_rows"] = $this->Teacher->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['teachers'] = $this->Teacher->select($config["per_page"], $page);
		$data['title'] = "Admin Manage Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function search_teacher()
	{
		
		$this->check_session();
		$search = ($this->input->post("search_teacher"))? $this->input->post("search_teacher"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        $this->load->model('Teacher');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_teacher/$search";
		$config["total_rows"] = $this->Teacher->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['teachers'] = $this->Teacher->select($config["per_page"], $page, $search);
        $data['search'] = $search;
		$data['title'] = "Admin Manage Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_teacher($id)
	{
		$this->check_session();
		$this->load->model('Teacher');
		$data['teacher'] = $this->Teacher->get_teacher($id);
		$data['title'] = "Admin Manage teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}
	
	public function edit_teacher($id)
	{
		$this->load->model('Teacher');
		$data['teacher'] = $this->Teacher->get_teacher($id);
		$data['title'] = "Admin Manage Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_teacher($id)
	{
		$this->check_session();
		$this->load->model('Teacher');
		$this->form_validation->set_rules('fname','First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		if(!$this->form_validation->run())
		{
			$this->edit_teacher($id);
		}
		else
		{
			$data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
			);
			$this->Teacher->update($data,$id);
			redirect('Admin/teacher');
		}
	}

	public function create_teacher()
	{
		$this->check_session();
		$this->load->model('Teacher');
		$this->form_validation->set_rules('fname', 'First name', 'required');
		// $this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');

		$this->form_validation->set_rules('masterclass', 'Section', 'required');
		if(!$this->form_validation->run())
		{
			$this->teacher();
		}
		else
		{
			// GET INPUTS
			$user_data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
				'type' => 'Teacher',
				'datecreated' => date('Y-m-d'),
			);
			// FILE UPLOAD --
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
				$this->teacher();
			}
			else
			{
				// UPLOAD SUCCESS 
				$upload_data = $this->upload->data();
				// GET UPLOAD FILE NAME
				$user_data['avatar'] = $upload_data['file_name'];
				$tid = $this->Teacher->insert($user_data);
				$teacher_data = array(
					'userID' => $tid,
					'masterclass' => $this->input->post('masterclass'),
				);
				$this->Teacher->insert_teacher($teacher_data);
				$this->session->set_flashdata('Success', 'Creation Success');
				redirect('Admin/teacher');
			}
		}
	}

	public function delete_teacher($id)
	{
		$this->check_session();
		$this->load->model(array('User','Teacher'));
		$result = $this->Teacher->get_teacher($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		unlink("./uploads/".$file);
		$this->User->delete($id);
		redirect('Admin/teacher');
	}
	// ---[TEACHER MANAGEMENT FUNCTION]---
	// 			---[END]---

	// ---[STAFF MANAGEMENT FUNCTION]---
	// 			---[START]---
	public function staff()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$config = array();
		$this->load->model('Staff');
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/staff";
		$config["total_rows"] = $this->Staff->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['staffs'] = $this->Staff->select($config["per_page"], $page);
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_staff');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function search_staff()
	{
		$this->check_session();
		$search = ($this->input->post("search_staff"))? $this->input->post("search_staff"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        $this->load->model('Staff');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_staff/$search";
		$config["total_rows"] = $this->Staff->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['staffs'] = $this->Staff->select($config["per_page"], $page, $search);
        $data['search'] = $search;
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_staff');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_staff($id)
	{
		$this->load->model('Staff');
		$data['staff'] = $this->Staff->get_staff($id);
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_staff');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_staff($id)
	{
		$this->load->model('Staff');
		$data['staff'] = $this->Staff->get_staff($id);
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_staff');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_staff($id)
	{
		$this->check_session();
		$this->load->model('Staff');
		$this->form_validation->set_rules('fname','First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		if(!$this->form_validation->run())
		{
			$this->edit_staff($id);
		}
		else
		{
			$data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
			);
			$this->Staff->update($data,$id);
			redirect('Admin/staff');
		}

		
	}

	public function create_staff()
	{
		$this->check_session();
		$this->load->model('Staff');
		$this->form_validation->set_rules('fname', 'First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('type', 'Staff Type', 'required');	
		if(!$this->form_validation->run())
		{
			$this->staff();
		}
		else
		{
			// GET INPUTS
			$user_data = array(
				'fname' => $this->input->post('fname'),
				'mname' => $this->input->post('mname'),
				'lname' => $this->input->post('lname'),
				'type' =>  $this->input->post('type'),
				'datecreated' => date('Y-m-d'),
			);
			// FILE UPLOAD --
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
				$this->staff();
			}
			else
			{
				// UPLOAD SUCCESS 
				$upload_data = $this->upload->data();
				// GET UPLOAD FILE NAME
				$user_data['avatar'] = $upload_data['file_name'];
				$sid = $this->Staff->insert($user_data);
				$staff_data = array(
					'userID' => $sid,
				);
				$this->Staff->insert_staff($staff_data);
				$this->session->set_flashdata('Success', 'Creation Success');
				redirect('Admin/staff');
			}
		}
	}

	public function delete_staff($id)
	{
		$this->check_session();
		$this->load->model(array('User','Staff'));
		$result = $this->Staff->get_staff($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		unlink("./uploads/".$file);
		$this->User->delete($id);
		redirect('Admin/staff');
	}
	// ---[STAFF MANAGEMENT FUNCTION]---
	// 			---[END]---

	// ---[BOOTSTRAP CONFIGURATION/STYLE FOR PAGINATION]---
	// 					---[START]---
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
	// ---[BOOTSTRAP CONFIGURATION/STYLE FOR PAGINATION]---
	// 					---[END]---


	public function manage_class()
	{
		$this->check_session();
		$this->load->model('Teacher');
		$this->load->model('Classroom');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_class";
		$config["total_rows"] = $this->Classroom->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['classes'] = $this->Classroom->paginate($config["per_page"], $page);



		$data['teachers'] = $this->Teacher->get_all();
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function search_class()
	{
		$this->check_session();
		$this->load->model('Teacher');
		$this->load->model('Classroom');

		$search = ($this->input->post("search_class"))? $this->input->post("search_class"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_class/$search";
		$config["total_rows"] = $this->Classroom->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['classes'] = $this->Classroom->paginate($config["per_page"], $page, $search);
		$data['search'] = $search;


		$data['teachers'] = $this->Teacher->get_all();
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function create_class()
	{
		$this->check_session();
		$this->load->model('Classroom');
		$this->form_validation->set_rules('class_name','Class name','required|is_unique[class.name]');
		$this->form_validation->set_rules('year/level','Year/Level','required');
		$this->form_validation->set_rules('max_capacity','Max Capacity',
		'required|numeric|greater_than_equal_to[15]|less_than_equal_to[30]');
		if(!$this->form_validation->run())
		{
			$this->manage_class();
		}
		else
		{
			$data = array(
				'name' => $this->input->post('class_name'),
				'year_level' => $this->input->post('year/level'),
				'max_capacity' => $this->input->post('max_capacity'),
			);

			if($this->input->post('adviser'))
			{
				$data['adviser'] = $this->input->post('adviser');
			}

			$this->Classroom->insert($data);
			$this->session->set_flashdata('Success', 'Creation Success');
			$this->manage_class();
		}
	}

	public function view_class($id)
	{
		$this->check_session();
		$this->load->model('Classroom');
		$data['class_data'] = $this->Classroom->get($id);

		$data['title'] = 'View Class';
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_class($id)
	{
		$this->check_session();
		$this->load->model('Classroom');
		$data['class_data'] = $this->Classroom->get($id);

		$data['title'] = 'View Class';
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function check_session()
	{
		// ---[FUNCTION DESCRIPTION & USE CASE SCENARIO]---
		// SESSION CHECKER FOR ADMIN LOGINS; LIMITS ACCESS TO OTHER USERTYPES
		// REDIRECTS TO LOGIN PAGE 
		if($this->session->userdata['admin_logged_in'] == FALSE)
		{
			redirect('Login');
		}
	}
	

	public function manage_dataset($uid)
	{
		$this->check_session();
		$this->load->model('User');
		$user = $this->User->get_where($uid);
		foreach($user as $i):
			$data = array(
				'fname' => $i->fname,
				'mname' => $i->mname,
				'lname' => $i->lname,
			);
		endforeach;
		$this->load->model('File_upload','file');

		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_dataset/".$uid;
		$config["total_rows"] = $this->file->count($uid);
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['face_data'] = $this->file->get_data($config["per_page"], $page, $uid);
		
		$data['uid'] = $uid;
		$data['title'] = "Manage Dataset";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_data');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function upload_dataset($uid)
	{
		$this->check_session();
		$this->load->model('User');
		$user = $this->User->get_where($uid);
		foreach($user as $i):
			$person_name = $i->fname.' '.$i->lname;
		endforeach;
		

		$data = [];
		$count_uploaded_files = 0;
		$count_error_files = 0;
		$count = count($_FILES['files']['name']);
		for($i = 0; $i < $count; $i++)
		{
			if(!empty($_FILES['files']['name'][$i]))
			{
				$_FILES['file']['name'] = $_FILES['files']['name'][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
	
				$upload_status = $this->uploaddata('file',$person_name);
				if($upload_status!=false)
				{
					$count_uploaded_files++;
					$this->load->model('File_upload','file');
					$data = array(
						'uid' => $uid,
						'img_path' => $upload_status,
						'upload_time' => date('Y-m-d H:i:s'),
					);
					$this->file->upload_data($data);
				}
				else
				{
					$count_error_files++;
				}
			}
			else
			{
				$this->session->set_flashdata('upload_error', 'NO FILES');
				$this->manage_dataset($uid);
			}

		}
		$this->session->set_flashdata('upload_status', 'Files uploaded. SUCCESS -'.$count_uploaded_files.'; ERROR -'.$count_error_files);
		$this->manage_dataset($uid);
	}


	public function uploaddata($name,$foldername)
	{
		$this->check_session();
		$upload_path = './dataset/'.$foldername;
		if(!is_dir($upload_path))
		{
			mkdir($upload_path,777,TRUE);
		}

		$config = array(
            'upload_path' =>  $upload_path,
            'allowed_types' => $this->config->item('Img_types'),
            'max_size' => $this->config->item('Max_img_size'),
			'encrypt_name' => TRUE,
        );

		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		if($this->upload->do_upload($name))
		{
			$filedata = $this->upload->data();
			return $filedata['file_name'];
		}
		else
		{
			$this->session->set_flashdata('upload_error', $this->upload->display_errors());
		}

	}

	public function delete_file($foldername,$id)
	{
		$this->check_session();
		$this->load->model('File_upload', 'file');

		$query = $this->file->get_where($id);
		foreach($query as $i):
			$path = $i->img_path;
			$uid = $i->uid;
		endforeach;
		$this->file->delete($id);
		unlink("./dataset/".$foldername.'/'.$path);

		$this->manage_dataset($uid);
	}

	public function gate_logs()
	{
		$this->check_session();
		$this->load->model('User');
		$this->load->model('Attendance');

		$date_value = date('Y-m-d');

		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/attendance/";
		$config["total_rows"] = $this->Attendance->attendance_count($date_value);
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['attendance'] = $this->Attendance->select($config["per_page"], $page, $date_value);

		$data['date_value'] = $date_value;
		$data['users'] =  $this->User->get();
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function student_logs()
	{
		$this->check_session();
		$this->load->model('Classroom');
		$data['class'] = $this->Classroom->select();
		$this->load->model('Logs');
		$id = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

		if($id != '')
		{
			$config = array();
			$config = $this->bootstrap_pagination();
			$config["base_url"] =  base_url() . "Admin/student_logs/$id";
			$config["total_rows"] = $this->Logs->inner_count($id);
			$config["per_page"] = 4;
			$config["uri_segment"] = 4;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$data['logs'] = $this->Logs->inner_get($config["per_page"], $page, $id);
		}

		
		$data['title'] = "Manage Logs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/student_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_student_log($id)
	{
		$this->check_session();
		if($id == '')
		{
			$this->student_logs();
		}
		else
		{
			$this->load->model('Logs');
			$this->load->model('Student');
			$data['user'] = $this->Student->get_student($id);
			$config = array();
			$config = $this->bootstrap_pagination();
			$config["base_url"] =  base_url() . "Admin/view_student_log/$id";
			$config["total_rows"] = $this->Logs->student_count();
			$config["per_page"] = 4;
			$config["uri_segment"] = 4;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$data['logs'] = $this->Logs->student_get($config["per_page"], $page);
			$data['title'] = "Manage Logs";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/view_student_log');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
	}

	public function s_logs_go()
	{
		$this->check_session();
		$this->form_validation->set_rules('section','Section', 'required');
		if(!$this->form_validation->run())
		{
			$this->student_logs();
		}
		else
		{
			redirect('Admin/student_logs/'.$this->input->post('section'));
		}
	}

	
	public function s_logs_search()
	{
		$this->check_session();
		$this->load->model('Classroom');
		$data['class'] = $this->Classroom->select();
		$this->load->model('Logs');


		$search = ($this->input->post("search_student"))? $this->input->post("search_student"): '';
		$search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;
		$id = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

		if($id == ''){
			$this->student_logs();
		}
		else
		{
			$config = array();
			$config = $this->bootstrap_pagination();
			$config["base_url"] =  base_url() . "Admin/s_logs_search/$id/$search";
			$config["total_rows"] = $this->Logs->inner_count($id, $search);
			$config["per_page"] = 4;
			$config["uri_segment"] = 5;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$data['logs'] = $this->Logs->inner_get($config["per_page"], $page, $id, $search);
			$data['search'] = $search;
			$data['tests'] = $id;
			$data['title'] = "Manage Logs";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/student_logs');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
	}


	public function log_gate_student()
	{
		$this->check_session();
		$data['title'] = "Manage Logs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/log_gate_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function employee_logs()
	{
		$this->check_session();
		$this->load->model('Classroom');
		$data['class'] = $this->Classroom->select();
		$this->load->model('Logs');
		$type = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

		if($type != '')
		{
			$config = array();
			$config = $this->bootstrap_pagination();
			$config["base_url"] =  base_url() . "Admin/employee_logs/$type";
			$config["total_rows"] = $this->Logs->emp_count($type);
			$config["per_page"] = 4;
			$config["uri_segment"] = 4;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$data['logs'] = $this->Logs->emp_get($config["per_page"], $page, $type);
		}

		$data['type'] = array('Teacher', 'Janitor', 'Cook', 'Security');
		
		$data['title'] = "Manage Logs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/employee_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function e_logs_search()
	{
		$this->check_session();
		$this->load->model('Classroom');
		$data['class'] = $this->Classroom->select();
		$this->load->model('Logs');

		$search = ($this->input->post("search_employee"))? $this->input->post("search_employee"): '';
		$search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;
		$type = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

		if($type != '')
		{
			$this->employee_logs();
		}
		else 
		{
			$config = array();
			$config = $this->bootstrap_pagination();
			$config["base_url"] =  base_url() . "Admin/e_logs_search/$type/$search";
			$config["total_rows"] = $this->Logs->emp_count($type, $search);
			$config["per_page"] = 4;
			$config["uri_segment"] = 5;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$data['logs'] = $this->Logs->emp_get($config["per_page"], $page, $type, $search);
			$data['search'] = $search;
			$data['tests'] = $type;
			$data['type'] = array('Teacher', 'Janitor', 'Cook', 'Security');

			$data['title'] = "Manage Logs";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/employee_logs');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
	}

	public function e_logs_go()
	{
		$this->check_session();
		$this->form_validation->set_rules('type','Type', 'required');
		if(!$this->form_validation->run())
		{
			$this->employee_logs();
		}
		else
		{
			redirect('Admin/employee_logs/'.$this->input->post('type'));
		}
	}

	public function go_back()
	{
		if(!$this->session->userdata('referred_from'))
		{
			redirect('Admin');
		}
		else
		{
			$referred_from = $this->session->userdata('referred_from');
			redirect($referred_from, 'refresh');
		}
	}


	public function test()
	{
		$this->check_session();
		$data['title'] = "Manage Gate";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/test');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');

	}


}
