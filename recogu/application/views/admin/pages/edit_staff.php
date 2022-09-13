<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">Edit User Profile</h4>
         <?php if(validation_errors()): ?>
         <div class="alert alert-danger">
            <?= validation_errors(); ?>
         </div>
         <?php endif; ?>
         <?php if(isset($_SESSION['incorrect'])):?>
         <div class="alert alert-danger">
            <?= $_SESSION['incorrect']; ?>
         </div>
         <?php endif; ?>
      </div>
      <div class="card-body">
         <div class="card bg-light py-3 px-3 mb-5">
            <div class="row">
               <div class="card-title d-flex flex-wrap justify-content-between">
                  User Profile
                  <br>
                  <a href="<?= base_url('Admin_staff')?>">Go back</a>
               </div>
               <div class="card-body">
                <?php foreach($staff as $i):?>
                  <?= form_open('Update_staff/'.$i->userID, array('class' => 'form')) ?>
                  <div class="row mb-5">
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="Firstname">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?=$i->fname?>">
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="Middlename">Middle Name</label>
                        <input type="text" name="mname" class="form-control" value="<?=$i->mname?>">
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="Lastname">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?=$i->lname?>">
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                  <?= form_close(); ?>
                <?php endforeach; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
