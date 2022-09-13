<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <?php if(isset($_SESSION['Success'])):?>
            <div class="alert alert-success">
               <?= $this->session->flashdata('Success')?>
            </div>
         <?php endif;?>
         <h4 class="fw-bold">
            Manage <span class="fst-italic text-primary">Students</span>
            <hr>
         </h4>
      </div>
      <div class="card-body">
         <div class="card py-3 px-3 shadow-lg">
            <div class="row">
               <div class="card-title">
                  <?php if(isset($_SESSION['error'])):?>
                  <div class="alert alert-danger">
                     <?= $_SESSION['error']; ?>
                  </div>
                  <?php endif; ?>
                  <h5 class="fw-bold text-primary">Create Student</h5>
               </div>
               <div class="card-body">
                  <?= form_open_multipart('Create_student')?>
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
                              <input type="text" name="lname" id="" class="form-control <?php if(form_error('mname')) echo 'is-invalid';?>">
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('lname');
                                    ?>
                              </div>
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3">
                              <label for="Year/Level">Year/Level<span class="text-danger">*</span></label>
                              <select name="yearlvl" id="year_level" class="form-select <?php if(form_error('yearlvl')) echo 'is-invalid';?>">
                                 <option value=""></option>
                                 <option value="PRESCHOOL" class="PRESCHOOL">PRESCHOOL</option>
                                 <option value="KINDERGARTEN" class="KINDERGARTEN">KINDERGARTEN</option>
                                 <?php for($i = 1; $i <=10; $i++):?>
                                 <option value="GRADE-<?=$i?>" class="GRADE-<?=$i?>">GRADE-<?=$i?></option>
                                 <?php endfor;?>
                              </select>
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('yearlvl');
                                    ?>
                              </div>
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3">
                              <label for="Section">Section<span class="text-danger">*</span></label>
                              <select name="section" id="class_section" class="form-select <?php if(form_error('section')) echo 'is-invalid';?>">
                                 <option value=""></option>
                                 <?php foreach($section as $i):?>
                                    <option value="<?=$i->classID?>" class="<?=$i->year_level?>" ><?=$i->name?> (<?=$i->year_level?>)</option>
                                 <?php endforeach;?>
                              </select>
                              <div class="invalid-feedback">
                                 <?php 
                                    echo form_error('section');
                                    ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-xl-4 col-md-12 col-sm-12">
                        <div class="row">
                           <div class="card text-center p-5 mb-3">
                              <h1>
                                 <i class="fa-solid fa-upload"></i>
                              </h1>
                              <br>
                              <label for="Upload Profile Picture" class="mb-2">Upload Profile Picture</label>
                              <input type="file" name="avatar" id="" class="form-control">
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
         <h4 class="fw-bold">Student <span class="fst-italic text-primary">List</span></h4>
         <hr>
      </div>
      <div class="card-body">
         <div class="row mb-4">
            <div class="col-lg-4 col-sm-6 d-flex">
               <?= form_open('Admin/search_student', array('class' => 'd-flex'))?>
               <input class="form-control me-2" type="search" name="search_student" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
               <button class="btn btn-primary" type="submit" >Search</button>
               <?= form_close();?>
            </div>
         </div>
         <div class="row">
            <?php foreach($students as $student):?>
            <div class="card mb-2 p-2">
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <div class="img" style="width: 100%;">
                        <img class="rounded" src="<?=base_url($this->config->item('Upload_img'))?><?=$student->avatar?>" alt="" height="200" style="width:inherit;">
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <div class="text-center fw-bold text-primary">USER INFORMATION</div>
                     <ul class="text-secondary">
                        <li>SCHOOL ID: <?= $student->userID ?></li>
                        <li>First name: <?= $student->fname?></li>
                        <li>Middle name: <?= $student->mname?></li>
                        <li>Last name: <?= $student->lname?></li>
                     </ul>
                     <div class="p-3">
                        <a href="<?=base_url('View_student/'.$student->userID)?>" class="btn btn-primary">View</a>
                        <a href="<?=base_url('Edit_student/'.$student->userID)?>" class="btn btn-success">Edit</a>
                        <a href="<?=base_url('Delete_student/'.$student->userID)?>" class="btn btn-danger">Delete</a>
                     </div>
                  </div>
                  <div class="col-2">
                     <a href="<?=base_url('Admin/manage_dataset/'.$student->userID)?>" class="btn btn-primary">Face Dataset &raquo</a>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
         </div>
         <p><?php echo $pagination; ?></p>
      </div>
   </div>
</div>


<script Src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function () {    
    var allOptions = $('#class_section option')
    $('#year_level').change(function () {
        $('#class_section option').remove()
        var classN = $('#year_level option:selected').prop('class');
        var opts = allOptions.filter('.' + classN);
        $.each(opts, function (i, j) {
            $(j).appendTo('#class_section');
        });
    });
});
</script>
