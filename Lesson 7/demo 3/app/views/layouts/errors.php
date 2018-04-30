<?php
use App\Helpers\Session;

if (isset($errors)) {
    foreach($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}

if (Session::get('success')) {
    echo "<div class='alert alert-success'>".Session::pull('success')."</div>";
}
