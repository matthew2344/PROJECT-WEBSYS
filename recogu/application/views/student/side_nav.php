<div class="wrapper">
<div class="body-overlay"></div>
<!-- Sidebar  -->
<nav id="sidebar" class="bg-dark">
   <div class="sidebar-header bg-dark">
      <h3><i class="fa-solid fa-user"></i> <span>RecogU</span></h3>
   </div>
   <ul class="list-unstyled components">
      <li  class="<?php if($this->uri->segment(2)=="profile"){echo "active";}?>">
         <a href="<?=base_url('Student/profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
      </li>
      <li  class="<?php if($this->uri->segment(2)==""){echo "active";}?>">
         <a href="<?=base_url('Student')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
      </li>

      <li class="">
         <a href="#"><i class="material-icons">date_range</i><span>Attendance View</span></a>
      </li>
      <li  class="">
         <a href="#"><i class="material-icons">library_books</i><span>View Gate Logs</span></a>
      </li>
      <li  class="">
         <a href="<?=base_url('Logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
      </li>
   </ul>
</nav>
