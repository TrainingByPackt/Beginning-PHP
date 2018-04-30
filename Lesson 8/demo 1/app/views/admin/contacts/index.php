<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
?>

<h1>Contacts</h1>

<?php include(APPDIR.'views/layouts/errors.php');?>

<p><a href="/contacts/add" class="btn btn-xs btn-info">Add Contact</a></p>

<div class='table-responsive'>
    <table class='table table-striped table-hover table-bordered'>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Telephone</th>
        <th>Action</th>
    </tr>
    <?php foreach($contacts as $row) { ?>
    <tr>
        <td><?=htmlentities($row->name);?></td>
        <td><?=htmlentities($row->email);?></td>
        <td><?=htmlentities($row->tel);?></td>
        <td>
            <a href="/contacts/edit/<?=$row->id;?>" class="btn btn-xs btn-warning">Edit</a>
            <a href="javascript:del('<?=$row->id;?>','<?=$row->name;?>')" class="btn btn-xs btn-danger">Delete</a>
        </td>
    </tr>
    <?php } ?>
    </table>
</div>

<script language="JavaScript" type="text/javascript">
function del(id, title) {
    if (confirm("Are you sure you want to delete '" + title + "'?")) {
        window.location.href = '/contacts/delete/' + id;
    }
}
</script>

<?php include(APPDIR.'views/layouts/footer.php');?>
