<?php

// Load CodeIgniter Bootstrap (manual way for scratch script)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
require $pathsPath;
$paths = new Config\Paths();
require realpath($paths->systemDirectory . '/Config/DotEnv.php');
(new CodeIgniter\Config\DotEnv(realpath(FCPATH . '..')))->load();
require realpath($paths->systemDirectory . '/bootstrap.php');

$db = \Config\Database::connect();
$query = $db->query("SELECT id, full_name, email, user_type FROM users WHERE user_type = 'Admin'");
$results = $query->getResultArray();

if (empty($results)) {
    echo "Nenhum administrador encontrado.\n";
} else {
    foreach ($results as $row) {
        echo "ID: {$row['id']} | Nome: {$row['full_name']} | Email: {$row['email']} | Tipo: {$row['user_type']}\n";
    }
}
