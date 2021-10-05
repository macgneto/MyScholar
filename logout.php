<?php

// require 'classes/Url.php';
require 'includes/init.php';
// session_start();

// $_SESSION['is_logged_in'] = false;
// Unset all of the session variables.
Auth::logout();

Url::redirect('/main/index.php');
