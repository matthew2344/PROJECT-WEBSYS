<div class="main-content">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">In-Gate/Out-Gate Logs (<span class="fst-italic text-primary">Employees</span>)</h4>
                <hr>
            </div>

            <div class="card-body">
                <?=form_open('Admin/s_logs_go'); ?>
                <div class="row mb-4">

                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <label for="">Employee Type</label>
                        <select name="year_level" id="year_level" class="form-select <?php if(form_error('year_level')) echo 'is-invalid';?>">
                            <option value=""></option>
                            <?php foreach($type as $i):?>
                                <option value=""></option>
                            <?php endforeach;?>
                        </select>
                        <div class="invalid-feedback">
                            <?php 
                                echo form_error('year_level');
                            ?>
                        </div>
                    </div>

                </div>
                <input type="submit" value="Go" class="btn btn-primary">
                <?=form_close(); ?>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="card">

            <div class="card-header">
                <h4 class="fw-bold">Logs <span class="fst-italic text-primary">Lists</span></h4>
                <hr>
            </div>

            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-lg-4 col-sm-6 d-flex">
                    <?= form_open('Admin/s_logs_search/'.$this->uri->segment(3), array('class' => 'd-flex'))?>
                    <input class="form-control me-2" type="search" name="search_student" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}?>">
                    <button class="btn btn-primary" type="submit" >Search</button>
                    <?= form_close();?>
                    </div>
                </div>

                <div class="card-content table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="bg-primary text-light">
                                <td>First Name</td>
                                <td>Middle Name</td>
                                <td>Last Name</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($logs)):
                            foreach($logs as $i):?>
                            <tr>
                                <td><?=$i->fname?></td>
                                <td><?=$i->mname?></td>
                                <td><?=$i->lname?></td>
                                <td><a href="" class="btn"><i class="material-icons">search</i></a></td>
                            </tr>
                            <?php 
                            endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <?php if(isset($pagination)){echo $pagination;}?>
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

