<?php include(APPDIR.'views/layouts/header.php');?>

<div class="wrapper well">

    <?php include(APPDIR.'views/layouts/errors.php');?>

    <h1>Reset Account</h1>

    <form method="post">

    <div class="control-group">
        <label class="control-label" for="email"> Email</label>
        <input class="form-control" id="email" type="text" name="email" />
    </div>

    <br>

    <p class="pull-left"><button type="submit" class="btn btn-sm btn-success" name="submit">Send reset email</button></p>
    <p class="pull-right"><a href="/admin/login">Login</a></p>

    <div class="clearfix"></div>

    </form>

    </div>

<?php include(APPDIR.'views/layouts/footer.php');?>
