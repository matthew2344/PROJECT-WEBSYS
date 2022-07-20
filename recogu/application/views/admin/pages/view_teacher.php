<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">User Profile</h4>
      </div>
      <div class="card-body">
         <div class="card bg-light py-3 px-3">
            <div class="row">
               <div class="card-title d-flex flex-wrap justify-content-between">
                  User Profile
                  <br>
                  <a href="<?= base_url('Admin/teacher')?>">Go back</a>
               </div>
               <div class="card-body">
                  <div class="row">
                     <?php foreach($teacher as $i):?>
                     <div class="col-xl-3 col-lg-4 col-md-12">
                        <div class="img" style="width: 100%;">
                           <img src="<?=base_url()?>uploads/<?=$i->avatar?> " alt="" height="200" style="width: inherit; object-fit: contain; display: block;">
                        </div>
                     </div>
                     <div class="col-xl-9 col-lg-8 col-md-12">
                        <h5>
                           School ID: <?= $i->tid?>
                        </h5>
                        <h5>
                           Full name: <?= $i->fname?> <?= $i->mname;?> <?= $i->lname?>
                        </h5>
                        <h5>
                           Year-level: <?= $i->yearlvl?>
                        </h5>
                        <h5>
                           Section Masterclass: <?= $i->masterclass?>
                        </h5>
                     </div>
                     <?php endforeach; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
