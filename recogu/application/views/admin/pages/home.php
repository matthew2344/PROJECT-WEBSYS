<div class="main-content">
<div class="row">
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-header">
            <div class="icon icon-warning">
               <span class="material-icons">equalizer</span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>School Visits</strong></p>
            <h3 class="card-title">70,340</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See visit logs</a>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-header">
            <div class="icon icon-rose">
               <span class="material-icons">equalizer</span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Attended Teacher</strong></p>
            <h3 class="card-title">102</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See Entry logs</a>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-header">
            <div class="icon icon-success">
               <span class="material-icons">
               equalizer
               </span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Attended Students</strong></p>
            <h3 class="card-title">102</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See Entry logs</a>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-header">
            <div class="icon icon-info">
               <span class="material-icons">
               equalizer
               </span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Attended Staff</strong></p>
            <h3 class="card-title">102</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See Entry logs</a>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row ">
   <div class="col-lg-7 col-md-12">
      <div class="card" style="min-height: 485px">
         <div class="card-header card-header-text">
            <h4 class="card-title">Admin View</h4>
            <p class="category">Ordered by ID</p>
         </div>
         <div class="card-content table-responsive">
            <table class="table table-hover">
               <thead class="text-primary">
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Type</th>
                     <th>Email</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($admin as $i): ?>
                  <tr>
                     <td><?=$i->id?></td>
                     <td><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></td>
                     <td><?=$i->type?></td>
                     <td><?=$i->email?></td>
                  </tr>
                  <?php endforeach; ?>
                  <tr>
                  </tr>
               </tbody>
            </table>
            <?=$pagination?>
         </div>
      </div>
   </div>
   <div class="col-lg-5 col-md-12">
      <div class="card" style="min-height: 485px">
         <div class="card-header card-header-text">
            <h4 class="card-title">Activities</h4>
         </div>
         <div class="card-content">
            <div class="streamline">
               <div class="sl-item sl-primary">
                  <div class="sl-content">
                     <small class="text-muted">5 mins ago</small>
                     <p>Williams joined as Admin</p>
                  </div>
               </div>
               <div class="sl-item sl-danger">
                  <div class="sl-content">
                     <small class="text-muted">25 mins ago</small>
                     <p>Jane Edited Student Information</p>
                  </div>
               </div>
               <div class="sl-item sl-success">
                  <div class="sl-content">
                     <small class="text-muted">40 mins ago</small>
                     <p>You added you a new User</p>
                  </div>
               </div>
               <div class="sl-item">
                  <div class="sl-content">
                     <small class="text-muted">45 minutes ago</small>
                     <p>John Deleted a User</p>
                  </div>
               </div>
               <div class="sl-item sl-warning">
                  <div class="sl-content">
                     <small class="text-muted">55 mins ago</small>
                     <p>Jim changed school calendar</p>
                  </div>
               </div>
               <div class="sl-item">
                  <div class="sl-content">
                     <small class="text-muted">60 minutes ago</small>
                     <p>John added a new staff</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
