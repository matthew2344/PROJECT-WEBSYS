<div class="wrapper">
<div class="body-overlay"></div>
<!-- Sidebar  -->
<nav id="sidebar" class="bg-dark">
   <div class="sidebar-header bg-dark">
      <h3><i class="fa-solid fa-user"></i> <span>RecogU</span></h3>
   </div>
   <ul class="list-unstyled components">
      <li  class="<?php if($this->uri->segment(1)=="Teacher_profile"){echo "active";}?>">
         <a href="<?=base_url('Teacher_profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
      </li>
      <li  class="<?php if($this->uri->segment(1)=="Teacher_dashboard"){echo "active";}?>">
         <a href="<?=base_url('Teacher_dashboard')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
      </li>
      <div class="small-screen navbar-display">

      </div>
      <li class="">
         <a href="#"><i class="material-icons">date_range</i><span>My Attendance</span></a>
      </li>
      <li  class="">
         <a href="#"><i class="material-icons">library_books</i><span>Calender</span></a>
      </li>
      <li  class="">
         <a href="<?=base_url('Logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
      </li>
   </ul>
</nav>
