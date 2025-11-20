<?php
$plaintext_password = "123456";
$hashed_password = password_hash($plaintext_password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashed_password;
?>