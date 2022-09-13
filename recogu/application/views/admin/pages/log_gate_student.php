<div class="main-content">
    <div class="row">

        <div class="card">

            <div class="card-header">
                <h4 class="fw-bold">Student <span class="fst-italic text-primary">Logs</span></h4>
                <hr>
            </div>

            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-lg-4 col-sm-6 d-flex">
                        <?= form_open('Search_student', array('class' => 'd-flex'))?>
                        <input class="form-control me-2" type="search" name="search_student" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
                        <button class="btn btn-primary" type="submit" >Search</button>
                        <?= form_close();?>
                    </div>
                </div>

                <div class="card-content table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>

        </div>

    </div>