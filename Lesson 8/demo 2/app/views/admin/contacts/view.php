<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/errors.php');
?>

<h1>View Contact</h1>

<div class='table-responsive'>
    <table class='table table-striped table-hover table-bordered'>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Telephone</th>
    </tr>
    <tr>
        <td><?=htmlentities($contact->name);?></td>
        <td><?=htmlentities($contact->email);?></td>
        <td><?=htmlentities($contact->tel);?></td>
    </tr>
    </table>
</div>

<h1>Comments</h1>

<form method="post">

    <div class="control-group">
        <textarea class="form-control" name="body"></textarea>
    </div>

    <p><button type="submit" class="btn btn-success" name="submit"><i class="fa fa-check"></i> Add Comment</button></p>

</form>

<?php foreach($comments as $row) { ?>
    <div class="well">
        <p><?=htmlentities($row->body);?></p>
        <p>By <?=$row->username;?> at <?=date('jS M Y H:i:s', strtotime($row->created_at));?></p>
    </div>
<?php } ?>

<?php include(APPDIR.'views/layouts/footer.php');?>
