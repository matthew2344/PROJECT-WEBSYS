
<div class="register-section py-5">

    <div class="container">

        <div class="signup-content d-flex justify-content-center">

            <div class="signup-form card p-5 col-8">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>
                <h2 class="form-title mb-5">Register 
                    <span class="text-muted">(Admin)</span>
                </h2>
                <?= form_open('Register/new_user', array('class' => 'register-form')) ?>

                    <div class="form-group row">
                        <label for="Fullname" class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-12 col-form-label">Full name</label>
                        <div class="col-xl col-lg col-md-12 col-sm-12 col-12 mb-sm-3 mb-3">
                            <input type="text" class="form-control" name="fname" placeholder="First name">
                        </div>
                        <div class="col-xl col-lg col-md-12 col-sm-12 col-12 mb-sm-3 mb-3">
                            <input type="text" class="form-control" name="mname" placeholder="Middle name">
                        </div>
                        <div class="col-xl col-lg col-md-12 col-sm-12 col-12 mb-sm-3 mb-3">
                            <input type="text" class="form-control" name="lname" placeholder="Last name">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Email" class="col-lg-2 col-sm-12 col-md-12 col-form-label">Email</label>
                        <div class="col-lg-10 col-sm-12">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="Password" class="col-lg-2 col-sm-12 col-md-12 col-form-label">Password</label>
                        <div class="col-xl col-lg col-md-12 col-sm-12 col-12 mb-sm-3 mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="col-xl col-lg col-md-12 col-sm-12 col-12 mb-sm-3 mb-3">
                            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                <?= form_close() ?>

            </div>

        </div>

    </div>

</div>