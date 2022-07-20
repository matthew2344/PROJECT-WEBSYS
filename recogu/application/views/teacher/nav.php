<!-- Page Content  -->
<div id="content">
<div class="top-navbar bg-primary">
   <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
         <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
         <span class="material-icons">arrow_back_ios</span>
         </button>
         <a class="navbar-brand text-light" href="#"> Dashboard </a>
         <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="material-icons">more_vert</span>
         </button>
         <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none" id="navbarSupportedContent">
            <ul class="nav navbar-nav me-auto">
            </ul>
            <ul class="nav navbar-nav">
               <li class="dropdown nav-item active">
                  <a href="#" class="nav-link" data-toggle="dropdown">
                  <span class="material-icons">menu</span>
                  </a>
                  <ul class="dropdown-menu ">
                     <li>
                        <a href="<?=base_url('Teacher/profile')?>" class="list-group-item">Profile</a>
                     </li>
                     <li>
                        <a href="<?=base_url('Teacher/edit_profile')?>" class="list-group-item">Settings</a>
                     </li>
                     <li>
                        <a href="<?=base_url('Teacher')?>" class="list-group-item">Dashboard</a>
                     </li>
                     <li>
                        <a href="<?=base_url('Logout')?>" class="list-group-item">Logout</a>
                     </li>
                  </ul>
               </li>
            </ul>
         </div>
      </div>
   </nav>
</div>
