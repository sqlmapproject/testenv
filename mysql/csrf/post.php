<?php
    session_start();

    function fool() {
       print uniqid(time());
       return;	 
    }


    function extract_token_from_session() { 
       $token = $_SESSION['anticsrf_token'];
       unset ($_SESSION['anticsrf_token']);
       return $token;
    }


    if (! isset($_SESSION['anticsrf_token'])) {
       fool();
       return;
    }

    $secret_token = extract_token_from_session();

    if ($secret_token != $_POST['secret_token']) {
       fool();
       return;
    }

    require_once('../../libs/mysql.inc.php');

    $query = "SELECT * FROM users WHERE id=" . $_POST['id'] . " LIMIT 0, 1";
    dbQuery($query);
?>
