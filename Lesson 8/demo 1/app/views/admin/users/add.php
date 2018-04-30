<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/errors.php');
?>

<h1>Add User</h1>

<form method="post">

    <div class="row">

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="username"> Username</label>
                <input class="form-control" id="username" type="text" name="username" value="<?=(isset($_POST['username']) ? $_POST['username'] : '');?>" required  />
            </div>

            <div class="control-group">
                <label class="control-label" for="email"> Email</label>
                <input class="form-control" id="email" type="email" name="email" value="<?=(isset($_POST['email']) ? $_POST['email'] : '');?>" required  />
            </div>

        </div>

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="password"> Password</label>
                <input class="form-control" id="password" type="password" name="password" required/>
            </div>

            <div class="control-group">
                <label class="control-label" for="password_confirm"> Confirm Password</label>
                <input class="form-control" id="password_confirm" type="password" name="password_confirm" required/>
            </div>

        </div>

    </div>

    <br>

    <p><button type="submit" class="btn btn-success" name="submit"><i class="fa fa-check"></i> Submit</button></p>

</form>

<?php include(APPDIR.'views/layouts/footer.php');?>
