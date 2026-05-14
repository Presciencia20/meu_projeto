<?php

// Load CodeIgniter Bootstrap
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
require $pathsPath;
$paths = new Config\Paths();
require realpath($paths->systemDirectory . '/Config/DotEnv.php');
(new CodeIgniter\Config\DotEnv(realpath(FCPATH . '..')))->load();
require realpath($paths->systemDirectory . '/bootstrap.php');

$db = \Config\Database::connect();
$password = 'CasaSegura@Admin2024';
$hashed = password_hash($password, PASSWORD_DEFAULT);

$db->table('users')
   ->where('id', 1)
   ->update(['password' => $hashed, 'login_attempts' => 0, 'locked_until' => null]);

echo "Admin Reset Details:\n";
echo "Phone: +244944013345\n";
echo "Password: {$password}\n";
