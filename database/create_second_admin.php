<?php
$password = 'admin456';  // Different password for second admin
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Use this SQL:<br><br>";
echo "INSERT INTO users (name, email, password, is_admin)<br>";
echo "VALUES (<br>";
echo "    'Second Admin',<br>";
echo "    'admin2@missrose.com',<br>";
echo "    '" . $hash . "',<br>";
echo "    1<br>";
echo ");";

echo "<br><br>Login Credentials:<br>";
echo "Email: admin2@missrose.com<br>";
echo "Password: admin456"; 