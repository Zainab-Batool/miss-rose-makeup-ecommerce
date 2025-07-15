<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Use this SQL:<br><br>";
echo "INSERT INTO users (name, email, password, is_admin)<br>";
echo "VALUES (<br>";
echo "    'Admin User',<br>";
echo "    'admin@missrose.com',<br>";
echo "    '" . $hash . "',<br>";
echo "    1<br>";
echo ");"; 