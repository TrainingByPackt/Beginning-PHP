//Topic A: CRUD, the Contact Application
//Exercise: Insert CRUD functionality in contacts application
//Step 5

<nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Project name</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li><a href="/">Admin</a></li>
          <li><a href="/contacts">Contacts</a></li>
          <li><a href="/users">Users</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/admin/logout">Logout</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>


//Topic A: CRUD, the Contact Application
//Exercise: Insert CRUD functionality in contacts application
//after Step 9

The full model looks like this:

<?php
namespace App\Models;

use System\BaseModel;

class Contact extends BaseModel
{
    public function get_contacts()
    {
        return $this->db->select('* from contacts order by name');
    }

    public function get_contact($id)
    {
        $data = $this->db->select('* from contacts where id = :id', [':id' => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }

    public function insert($data)
    {
        $this->db->insert('contacts', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('contacts', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('contacts', $where);
    }
}


//Topic A: CRUD, the Contact Application
//Exercise: Insert CRUD functionality in contacts application
//Step 13

public function add()
{
    $errors = [];

    if (isset($_POST['submit'])) {
        $name  = (isset($_POST['name']) ? $_POST['name'] : null);
        $email = (isset($_POST['email']) ? $_POST['email'] : null);
        $tel   = (isset($_POST['tel']) ? $_POST['tel'] : null);

        if (strlen($name) < 3) {
            $errors[] = 'Name is too short';
        }

        if (count($errors) == 0) {

            $data = [
                'name' => $name,
                'email' => $email,
                'tel' => $tel
            ];

            $this->contact->insert($data);

            Session::set('success', 'Contact created');

            Url::redirect('/contacts');

        }

    }

    $this->view->render('admin/contacts/add', compact('errors'));
}

public function edit($id)
{
    if (! is_numeric($id)) {
        Url::redirect('/contacts');
    }

    $contact = $this->contact->get_contact($id);

    if ($contact == null) {
        Url::redirect('/404');
    }

    $errors = [];

    if (isset($_POST['submit'])) {
        $name  = (isset($_POST['name']) ? $_POST['name'] : null);
        $email = (isset($_POST['email']) ? $_POST['email'] : null);
        $tel   = (isset($_POST['tel']) ? $_POST['tel'] : null);

        if (strlen($name) < 3) {
            $errors[] = 'Name is too short';
        }

        if (count($errors) == 0) {

            $data = [
                'name' => $name,
                'email' => $email,
                'tel' => $tel
            ];

            $where = ['id' => $id];

            $this->contact->update($data, $where);

            Session::set('success', 'Contact updated');

            Url::redirect('/contacts');

        }

    }

    $title = 'Edit Contact';
    $this->view->render('admin/contacts/edit', compact('contact', 'errors', 'title'));
}

public function delete($id)
{
    if (! is_numeric($id)) {
        Url::redirect('/contacts');
    }

    $contact = $this->contact->get_contact($id);

    if ($contact == null) {
        Url::redirect('/404');
    }

    $where = ['id' => $contact->id];

    $this->contact->delete($where);

    Session::set('success', 'Contact deleted');

    Url::redirect('/contacts');
}



//Topic A: CRUD, the Contact Application
//Exercise: Insert CRUD functionality in contacts application
//Step 14

index.php

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

add.php

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

edit.php

<?php
include(APPDIR.'views/layouts/header.php');
include(APPDIR.'views/layouts/nav.php');
include(APPDIR.'views/layouts/errors.php');
?>

<h1>Edit Contact</h1>

<form method="post">

    <div class="row">

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="name"> Name</label>
                <input class="form-control" id="name" type="text" name="name" value="<?=$contact->name;?>" required />
            </div>

            <div class="control-group">
                <label class="control-label" for="email"> Email</label>
                <input class="form-control" id="email" type="email" name="email" value="<?=$contact->email;?>" />
            </div>

        </div>

        <div class="col-md-6">

            <div class="control-group">
                <label class="control-label" for="tel"> Telephone</label>
                <input class="form-control" id="tel" type="number" name="tel" value="<?=$contact->tel;?>" />
            </div>

        </div>

    </div>

    <p><button type="submit" class="btn btn-success" name="submit"><i class="fa fa-check"></i> Submit</button></p>

</form>

<?php include(APPDIR.'views/layouts/footer.php');?>


//Topic B: Comments, Joins, and Date Formatting 
//Exercise: Creating a view page and building the comments system
//Step 5

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

<?php include(APPDIR.'views/layouts/footer.php');?>


//Topic A: CRUD, the Contact Application
//Activity: Loading the Application
//After Step 13

The full method looks like this: 
public function view($id)
{
    if (! is_numeric($id)) {
        Url::redirect('/contacts');
    }

    $contact = $this->contact->get_contact($id);

    if ($contact == null) {
        Url::redirect('/404');
    }

    $comment = new Comment();

    if (isset($_POST['submit'])) {
        $body  = (isset($_POST['body']) ? $_POST['body'] : null);

        if ($comment !='') {

            $data = [
                'body' => $body,
                'contact_id' => $id,
                'user_id' => Session::get('user_id')
            ];

            $comment->insert($data);

            Session::set('success', 'Comment created');

            Url::redirect("/contacts/view/$id");

        }

    }

    $comments = $comment->get_comments($id);

    $title = 'View Contact';
    $this->view->render('admin/contacts/view', compact('contact', 'comments', 'title'));
}


