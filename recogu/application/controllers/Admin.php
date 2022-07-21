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
		$config = array();
		$this->load->model('Student');
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
        $this->load->model('Student');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_student";
		$config["total_rows"] = $this->Student->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
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
		$config = array();
		$this->load->model('Teacher');
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
        $this->load->model('Teacher');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_teacher";
		$config["total_rows"] = $this->Teacher->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
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
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('masterclass', 'Master class', 'required');
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
					'tid' => $tid,
					'yearlvl' => $this->input->post('yearlvl'),
					'masterclass' => $this->input->post('masterclass'),
				);
				$this->Teacher->insert_teacher($teacher_data);
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
        $this->load->model('Staff');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_staff";
		$config["total_rows"] = $this->Staff->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
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
				'type' => 'Staff',
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
					'sid' => $sid,
					'type' => $this->input->post('type'),
				);
				$this->Staff->insert_staff($staff_data);
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
}
