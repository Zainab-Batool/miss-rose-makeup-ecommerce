<?php
$admin_password = 'admin123';
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
echo $hashed_password; 