<div class="main-content">
    <div class="row">
        <div class="card shadow">
            <div class="card-header">
                <?php if(isset($_SESSION['Success'])):?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('Success')?>
                    </div>
                <?php endif;?>
                <h4 class="fw-bold">Create <span class="fst-italic text-primary">Class</span></h4>
                <hr>
                <span class="text-danger mb-5">*</span> - Entry input with asterisk is required
            </div>
            <div class="card-body">
                <?=form_open('Admin/create_class', array('class' => 'form'))?>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <label for="">Class name <span class="text-danger">*</span></label>
                            <input type="text" name="class_name" class="form-control mt-2 <?php if(form_error('class_name')) echo 'is-invalid';?>">
                            <div class="invalid-feedback">
                                <?php 
                                    echo form_error('class_name');
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <label for="">Year/Level <span class="text-danger">*</span></label>
                            <select name="year/level" id="" class="form-select mt-2 <?php if(form_error('year/level')) echo 'is-invalid';?>">
                                <option value=""></option>
                                <option value="PRESCHOOL">PRESCHOOL</option>
                                <option value="KINDERGARTEN">KINDERGARTEN</option>
                                <?php for($i = 1; $i <=10; $i++):?>
                                    <option value="GRADE-<?=$i?>">GRADE-<?=$i?></option>
                                <?php endfor;?>
                            </select>
                            <div class="invalid-feedback">
                                <?php 
                                    echo form_error('year/level');
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <label for="">Max Capacity<span class="text-danger">*</span></label>
                            <input type="number" placeholder="Min 15-30 Max" name="max_capacity" min="15" max="30" id="" class="form-control mt-2 <?php if(form_error('max_capacity')) echo 'is-invalid';?>">
                            <div class="invalid-feedback">
                                <?php 
                                    echo form_error('max_capacity');
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <label for="">Class Adviser</label>
                            <select name="adviser" id="" class="form-select mt-2">
                                <option value=""></option>
                                <?php foreach($teachers as $i): ?>
                                    <option value="<?=$i->id?>"><?=$i->fname?> <?=$i->lname?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="Save" class="btn btn-primary">
                <?=form_close();?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card shadow-lg">
            <div class="card-header">
                <h4 class="fw-bold">Manage <span class="fst-italic text-primary">Class</span></h4>
                <hr>
            </div>
            <div class="card-body">
                <h5 class="fw-bold">Class list</h5>

                <div class="row mb-4">
                  <div class="col-lg-4 col-sm-6 d-flex">
                     <?= form_open('Admin/search_class', array('class' => 'd-flex'))?>
                     <input class="form-control me-2" type="search" name="search_class" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
                     <button class="btn btn-primary" type="submit" >Search</button>
                     <?= form_close();?>
                  </div>
               </div>
               <div class="row">
                    <div class="card-content table-responsive">
                        <table class="table">
                        <thead>
                            <tr class="bg-primary text-light">
                                <td>Class</td>
                                <td>Year/Level</td>
                                <td>Room Capacity</td>
                                <td>#</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($classes as $i):?>
                                <tr>
                                    <td><?=$i->name?></td>
                                    <td><?=$i->year_level?> </td>
                                    <td><?=$i->max_capacity?> </td>
                                    <td>
                                        <a href="<?=base_url('Admin/view_class/'.$i->classID)?>" class="btn"><i class="material-icons">search</i></a> 
                                        <a href="<?=base_url('Admin/edit_class/'.$i->classID)?>" class="btn"><i class="material-icons">edit</i></a> 
                                        <button class="btn text-danger"><i class="material-icons">delete</i></button> 
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?=$pagination;?>
               </div>
            </div>
        </div>
    </div>

