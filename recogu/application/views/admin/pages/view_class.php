<div class="main-content">
    <?php foreach($class_data as $i):?>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="fw-bold">Class <span class="fst-italic text-primary"><?=$i->name?></span></h4>
                    <a href="<?=base_url('Admin/manage_class')?>">Go back</a>
                </div>
                <hr>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-2 col-md-2 col-12">
                        <h5><?=$i->name?></h5>
                    </div>
                    <div class="col table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Class ID</td>
                                    <td>Year/Level</td>
                                    <td>Max Capacity</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$i->name?></td>
                                    <td><?=$i->year_level?></td>
                                    <td><?=$i->max_capacity?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">

                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>
