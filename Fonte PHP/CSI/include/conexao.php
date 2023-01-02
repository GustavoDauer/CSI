<?php

function connect() {
    $dbConfig = parse_ini_file('/var/www/csi.ini');
    $servername = $dbConfig['servername'];
    $username = $dbConfig['username'];
    $password = $dbConfig['password'];
    $database = $dbConfig['dbname'];
    $object = mysqli_connect($servername, $username, $password, $database);
    if (!$object) { // Falha na conexão com o banco
        header("Location: View/view_error.php?error=database");
        return false;
    }
    return $object;
}

?>