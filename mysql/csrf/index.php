<?php
    session_start();

    function generate_secret_token() {
	     return uniqid(time());
    }

    $sSecretToken = generate_secret_token();

    $_SESSION['anticsrf_token'] = $sSecretToken;
?>

<html>
<body>
<form method="POST" name="csrfguard_sample" action="post.php">
  <input type="text" name="id">
  <input type="hidden" name="secret_token" value="<?php echo $sSecretToken; ?>">
  <input type="submit" value="Submit">
</form>
</body>
</html>
