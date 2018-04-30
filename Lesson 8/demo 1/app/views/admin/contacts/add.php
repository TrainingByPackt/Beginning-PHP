<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/errors.php');
?>

<h1>Add Contact</h1>

<form method="post">

    <div class="row">

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="name"> Name</label>
                <input class="form-control" id="name" type="text" name="name" value="<?=(isset($_POST['name']) ? $_POST['name'] : '');?>" required  />
            </div>

            <div class="control-group">
                <label class="control-label" for="email"> Email</label>
                <input class="form-control" id="email" type="email" name="email" value="<?=(isset($_POST['email']) ? $_POST['email'] : '');?>"  />
            </div>

        </div>

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="tel"> Telephone</label>
                <input class="form-control" id="tel" type="number" name="tel" value="<?=(isset($_POST['tel']) ? $_POST['tel'] : '');?>"  />
            </div>

        </div>

    </div>

    <br>

    <p><button type="submit" class="btn btn-success" name="submit"><i class="fa fa-check"></i> Submit</button></p>

</form>

<?php include(APPDIR.'views/layouts/footer.php');?>
