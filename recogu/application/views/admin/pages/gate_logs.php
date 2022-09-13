<div class="main-content">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">View <span class="fst-italic text-primary">Logs</span> <span class="text-muted">(<?=$date_value?>)</span></h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="row d-flex mb-4">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-12 mb-3">
                        <a href="<?=base_url('Admin/student_logs')?>">Student Gate logs</a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-12 mb-3">
                        <a href="">Employee Gate logs</a>
                    </div>
                </div>
                <div class="row mb-4">
                  <div class="col-lg-4 col-sm-6 d-flex">
                     <?= form_open('Admin/search_date', array('class' => 'd-flex'))?>
                     <input class="form-control me-2" type="date" name="search_date" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
                     <button class="btn btn-primary" type="submit" >Search</button>
                     <?= form_close();?>
                  </div>
               </div>
                <div class="card-content table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Date</td>
                                <td>Time</td>
                                <td>Status</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($attendance as $i):?>
                            <tr>
                                <td><?=$i->fname?> <?=$i->lname?></td>
                                <td><?=$i->date?></td>
                                <td><?=$i->time_in?></td>
                                <td><?=$i->remarks?></td>
                                <td>
                                    <!-- <a href="" class="btn btn-success"><i class="material-icons">edit</i></a>
                                    <a href="" class="btn btn-danger"><i class="material-icons">delete</i></a> -->
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
