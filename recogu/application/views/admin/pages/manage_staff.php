<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <?php if(isset($_SESSION['Success'])):?>
            <div class="alert alert-success">
               <?= $this->session->flashdata('Success')?>
            </div>
         <?php endif;?>
         <h4 class="fw-bold">Manage <span class="fst-italic text-primary">Non-Teaching Staff</span></h4>
         <hr>
      </div>
      <div class="card-body">
         <div class="card py-3 px-3">
            <div class="row">
               <div class="card-title">
                  <?php if(isset($_SESSION['error'])):?>
                  <div class="alert alert-danger">
                     <?= $_SESSION['error']; ?>
                  </div>
                  <?php endif; ?>
                  <h5 class="fw-bold text-primary">Create Staff</h5>
               </div>
               <div class="card-body">
                  <?= form_open_multipart('Create_staff')?>
                  <div class="row">
                     <div class="col-12 col-xl-8 col-md-12 col-sm-12">
                        <div class="d-flex flex-wrap align-content-center">
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Firstname">Firstname<span class="text-danger">*</span></label>
                              <br>
                              <input type="text" name="fname" id="" class="form-control <?php if(form_error('fname')) echo 'is-invalid';?>">
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('fname');
                                    ?>
                              </div>
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Middlename">Middlename<span class="text-danger">*</span></label>
                              <br>
                              <input type="text" name="mname" id="" class="form-control <?php if(form_error('mname')) echo 'is-invalid';?>">
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('mname');
                                    ?>
                              </div>
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Lastname">Lastname<span class="text-danger">*</span></label>
                              <br>
                              <input type="text" name="lname" id="" class="form-control <?php if(form_error('lname')) echo 'is-invalid';?>">
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('lname');
                                    ?>
                              </div>
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Type">Type<span class="text-danger">*</span></label>
                              <select name="type" id="" class="form-select <?php if(form_error('type')) echo 'is-invalid';?>">
                                 <option value="">None</option>
                                 <option value="Admin">Admin</option>
                                 <option value="Janitor">Janitor</option>
                                 <option value="Librarian">Librarian</option>
                                 <option value="Cook">Cook</option>
                                 <option value="Security">Security</option>
                              </select>
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('type');
                                    ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-xl-4 col-md-12 col-sm-12">
                        <div class="row">
                           <div class="card text-center p-5 mb-3 shadow">
                              <h1>
                                 <i class="fa-solid fa-upload"></i>
                              </h1>
                              <br>
                              <label for="Upload Profile Picture" class="mb-2">Upload Profile Picture</label>
                              <input type="file" name="avatar" id="">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col">
                        <button type="submit" class="btn btn-primary">Save</button>
                     </div>
                  </div>
                  <?= form_close(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">User <span class="fst-italic text-primary">List</span></h4>
         <hr>
      </div>
      <div class="card-body">
         <div class="row mb-4">
            <div class="col-lg-4 col-sm-6 d-flex">
               <?= form_open('Search_staff', array('class' => 'd-flex'))?>
               <input class="form-control me-2" type="search" name="search_staff" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
               <button class="btn btn-primary" type="submit" >Search</button>
               <?= form_close();?>
            </div>
         </div>
         <div class="row">
            <?php foreach($staffs as $staff):?>
            <div class="card mb-2 p-2">
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <div class="img" style="width: 100%;">
                        <img class="rounded" src="<?=base_url($this->config->item('Upload_img'))?><?=$staff->avatar?>" alt="" height="200" style="width:inherit;">
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <div class="text-center fw-bold text-primary">USER INFORMATION</div>
                     <ul class="text-secondary">
                        <li>SCHOOL ID: <?= $staff->userID ?></li>
                        <li>First name: <?= $staff->fname ?></li>
                        <li>Middle name: <?= $staff->mname ?></li>
                        <li>Last name: <?= $staff->lname ?> </li>
                     </ul>
                     <div class="p-3">
                        <a href="<?=base_url('View_staff/'.$staff->userID)?>" class="btn btn-primary">View</a>
                        <a href="<?=base_url('Edit_staff/'.$staff->userID)?>" class="btn btn-success">Edit</a>
                        <a href="<?=base_url('Delete_staff/'.$staff->userID)?>" class="btn btn-danger">Delete</a>
                     </div>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
         </div>
         <p><?php echo $pagination; ?></p>
      </div>
   </div>
</div>
