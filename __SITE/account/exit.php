<?php
$cookieoptions = array (
                'expires' => time(),
                'path' => '/',
                'domain' => '', // leading dot for compatibility or use subdomain
                'secure' => false,     // or false
                'httponly' => false,    // or false
                'samesite' => 'Strict' // None || Lax  || Strict
                );
setcookie("inputpass", "", $cookieoptions);
setcookie("inputlogin", "", $cookieoptions);
header("Location: ../account");
exit();
?>