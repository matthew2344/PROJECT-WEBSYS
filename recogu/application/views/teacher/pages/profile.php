<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">My Profile</h4>
         <?php if(isset($_SESSION['error'])):?>
         <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
         </div>
         <?php endif; ?>
      </div>
      <div class="card-body">
         <div class="card bg-light py-3 px-3">
            <div class="row">
               <div class="card-title d-flex flex-wrap justify-content-between">
                  Admin Profile
                  <br>
                  <a href="<?= base_url('Teacher/edit_profile')?>">Edit Profile</a>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-xl-3 col-lg-4 col-md-12">
                        <button class="btn" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <?php if(isset($_SESSION['avatar'])):?>
                        <img src="<?=base_url()?>uploads/<?=$_SESSION['avatar']?>" alt="" height="200" style="width: inherit; object-fit: contain; display: block;">
                        <?php else:?>     
                        <img src="<?=base_url()?>uploads/asdasdas.jpg" alt="" height="200" style="width: inherit; object-fit: contain; display: block;">
                        <?php endif;?>
                        </button>
                     </div>
                     <div class="col-xl-9 col-lg-8 col-md-12">
                        <h5>STUDENT ID: <?=$_SESSION['uid']?></h5>
                        <h5>Full name: <?=$_SESSION['fname'].' '.$_SESSION['mname'].' '.$_SESSION['lname'];?></h5>
                        <h5>User Type: <?=$_SESSION['type']?></h5>
                        <h5>Password: ******</h5>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Avatar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <?= form_open_multipart('Teacher/update_avatar/'.$_SESSION['uid']) ?>
            <div class="text-center">
               <h1>
                  <i class="fa-solid fa-upload"></i>
               </h1>
               <br>
               <label for="Upload Profile Picture" class="mb-2">Upload Profile Picture</label>
               <br>
               <input type="file" name="avatar" id="">     
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Save changes</button>
            <?= form_close() ?>
         </div>
      </div>
   </div>
</div>
