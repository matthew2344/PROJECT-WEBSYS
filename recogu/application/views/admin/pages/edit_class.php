<div class="main-content">
    <?php foreach($class_data as $i):?>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="fw-bold">Edit <span class="fst-italic text-primary">Class</span></h4>
                <a href="<?=base_url('Admin/manage_class')?>">Go back</a>
            </div>
            <hr>
            <div class="card-body">
                <?= form_open();?>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 mb-2">
                        <label for="">Class Name</label>
                        <input type="text" name="name" class="form-control mt-2 <?php if(form_error('name')) echo 'is-invalid';?>">
                        <div class="invalid-feedback">
                            <?php 
                                echo form_error('name');
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <label for="">Max capacity</label>
                        <input type="number" placeholder="Min 15-30 Max" name="max_capacity" min="15" max="30" id="" class="form-control mt-2 <?php if(form_error('max_capacity')) echo 'is-invalid';?>">
                        <div class="invalid-feedback">
                            <?php 
                                echo form_error('max_capacity');
                            ?>
                        </div>
                    </div>
                </div>
                <?= form_close();?>
            </div>
        </div>
    </div>
    <?php endforeach;?>

    