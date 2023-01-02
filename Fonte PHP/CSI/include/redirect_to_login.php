<?php

require_once 'comum.php';

if (!isLoggedIn()) {
    header("Location: view_login.php");
}