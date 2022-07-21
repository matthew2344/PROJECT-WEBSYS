<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">Manage Teachers</h4>
      </div>
      <div class="card-body">
         <div class="card py-3 px-3">
            <div class="row">
               <div class="card-title">
                  <?php if(validation_errors()): ?>
                  <div class="alert alert-danger">
                     <?= validation_errors(); ?>
                  </div>
                  <?php endif; ?>
                  <?php if(isset($_SESSION['error'])):?>
                  <div class="alert alert-danger">
                     <?= $_SESSION['error']; ?>
                  </div>
                  <?php endif; ?>
                  <h5 class="fw-bold text-primary">Create Teachers</h5>
               </div>
               <div class="card-body">
                  <?= form_open_multipart('Create_teacher')?>
                  <div class="row">
                     <div class="col-12 col-xl-8 col-md-12 col-sm-12">
                        <div class="d-flex flex-wrap align-content-center">
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Firstname">Firstname<span class="text-danger">*</span></label>
                              <br>
                              <input type="text" name="fname" id="" class="form-control">
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Middlename">Middlename<span class="text-danger">*</span></label>
                              <br>
                              <input type="text" name="mname" id="" class="form-control">
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Lastname">Lastname<span class="text-danger">*</span></label>
                              <br>
                              <input type="text" name="lname" id="" class="form-control">
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Type">year level<span class="text-danger">*</span></label>
                              <select name="yearlvl" id="">
                                 <option value="">None</option>
                                 <option value="PRE-SCHOOL">PRE-SCHOOL</option>
                                 <option value="KINDERGARTEN">KINDERGARTEN</option>
                                 <option value="GRADE-01">GRADE-01</option>
                                 <option value="GRADE-02">GRADE-02</option>
                                 <option value="GRADE-03">GRADE-03</option>
                                 <option value="GRADE-04">GRADE-04</option>
                                 <option value="GRADE-05">GRADE-05</option>
                                 <option value="GRADE-06">GRADE-06</option>
                                 <option value="GRADE-07">GRADE-07</option>
                                 <option value="GRADE-08">GRADE-08</option>
                                 <option value="GRADE-09">GRADE-09</option>
                                 <option value="GRADE-10">GRADE-10</option>
                              </select>
                           </div>
                           <div class="flex-sm-fill flex-fill mx-1 mb-3" style="width: 180px;">
                              <label for="Type">Masterclass<span class="text-danger">*</span></label>
                              <select name="masterclass" id="">
                                 <option value="">none</option>
                                 <option value="A">A</option>
                                 <option value="B">B</option>
                                 <option value="C">C</option>
                              </select>
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
         <h4 class="fw-bold">User List</h4>
      </div>
      <div class="card-body">
         <div class="card py-3 px-3">
            <div class="row">
               <div class="card-title">
                  <h5 class="fw-bold text-primary">Item Lists</h5>
               </div>
            </div>
            <div class="card-body">
               <div class="row mb-4">
                  <div class="col-lg-4 col-sm-6 d-flex">
                     <?= form_open('Search_teacher', array('class' => 'd-flex'))?>
                     <input class="form-control me-2" type="search" name="search_teacher" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
                     <button class="btn btn-primary" type="submit" >Search</button>
                     <?= form_close();?>
                  </div>
               </div>
               <div class="row">
                  <?php foreach($teachers as $teacher):?>
                  <div class="card mb-2 p-2">
                     <div class="row">
                        <div class="col-lg-3 col-sm-6">
                           <div class="img" style="width: 100%;">
                              <img class="rounded" src="<?=base_url($this->config->item('Upload_img'))?><?=$teacher->avatar?>" alt="" height="200" style="width:inherit;">
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                           <div class="text-center fw-bold text-primary">USER INFORMATION</div>
                           <ul class="text-secondary">
                              <li>SCHOOL ID: <?= $teacher->tid ?></li>
                              <li>First name: <?=$teacher->fname?></li>
                              <li>Middle name: <?=$teacher->mname?></li>
                              <li>Last name: <?=$teacher->lname?></li>
                           </ul>
                           <div class="p-3">
                              <a href="<?=base_url('View_teacher/'.$teacher->tid)?>" class="btn btn-primary">View</a>
                              <a href="<?=base_url('Edit_teacher/'.$teacher->tid)?>" class="btn btn-success">Edit</a>
                              <a href="<?=base_url('Delete_teacher/'.$teacher->tid)?>" class="btn btn-danger">Delete</a>
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
   </div>
</div>
