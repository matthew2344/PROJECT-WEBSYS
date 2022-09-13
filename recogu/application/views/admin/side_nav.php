<div class="wrapper">
         <div class="body-overlay"></div>
         <!-- Sidebar  -->
         <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header bg-dark">
               <h3><i class="fa-solid fa-user"></i> <span>RecogU</span></h3>
            </div>
            <ul class="list-unstyled components">
               <li  class="<?php if($this->uri->segment(1)=="Admin_profile"){echo "active";}?>">
                  <a href="<?=base_url('Admin_profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(1)=="Admin_dashboard"){echo "active";}?>">
                  <a href="<?=base_url('Admin_dashboard')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(1)=="Admin_student"){echo "active";}?>">
                  <a href="<?=base_url('Admin_student')?>" class="dashboard"><i class="material-icons">face</i><span>Students</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(1)=="Admin_teacher"){echo "active";}?>">
                  <a href="<?=base_url('Admin_teacher')?>" class="dashboard"><i class="material-icons">manage_accounts</i><span>Teaching Staff</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(1)=="Admin_staff"){echo "active";}?>">
                  <a href="<?=base_url('Admin_staff')?>" class="dashboard"><i class="material-icons">badge</i><span>Non-Teaching Staff</span></a>
               </li>

               <li class="">
                  <a href="<?=base_url('Admin/manage_class')?>"><i class="material-icons">menu_book</i><span>Manage Class</span></a>
               </li>
               
               <li class="">
                  <a href="#"><i class="material-icons">date_range</i><span>School Calendar</span></a>
               </li>
               <li  class="">
                  <a href="<?=base_url('Admin/gate_logs')?>"><i class="material-icons">library_books</i><span>Gate Logs</span></a>
               </li>
               <li  class="">
                  <a href="<?=base_url('Admin/test')?>"><i class="material-icons">photo_camera</i><span>Gate Camera</span></a>
               </li>
               <li  class="">
                  <a href="<?=base_url('Logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
               </li>
            </ul>
         </nav>