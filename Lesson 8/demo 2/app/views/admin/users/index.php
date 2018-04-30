<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
?>

<h1>Users</h1>

<?php include(APPDIR.'views/layouts/errors.php');?>

<p><a href="/users/add" class="btn btn-xs btn-info">Add User</a></p>

<div class='table-responsive'>
    <table class='table table-striped table-hover table-bordered'>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php foreach($users as $row) { ?>
    <tr>
        <td><?=htmlentities($row->username);?></td>
        <td><?=htmlentities($row->email);?></td>
        <td>
            <a href="/users/edit/<?=$row->id;?>" class="btn btn-xs btn-warning">Edit</a>
            <a href="javascript:del('<?=$row->id;?>','<?=$row->username;?>')" class="btn btn-xs btn-danger">Delete</a>
        </td>
    </tr>
    <?php } ?>
    </table>
</div>

<script language="JavaScript" type="text/javascript">
function del(id, title) {
    if (confirm("Are you sure you want to delete '" + title + "'?")) {
        window.location.href = '/users/delete/' + id;
    }
}
</script>

<?php include(APPDIR.'views/layouts/footer.php');?>
