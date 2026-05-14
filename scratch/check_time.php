<?php

// Load CI4
require_once __DIR__ . '/public/index.php';

$db = \Config\Database::connect();
$query = $db->query("SELECT NOW() as db_time");
$row = $query->getRow();
echo "DB Time: " . $row->db_time . PHP_EOL;
echo "PHP Time: " . date('Y-m-d H:i:s') . PHP_EOL;

$otpModel = new \App\Models\OtpModel();
$lastOtp = $otpModel->orderBy('id', 'DESC')->first();
if ($lastOtp) {
    echo "Last OTP Expira Em: " . $lastOtp['expira_em'] . PHP_EOL;
    echo "Last OTP Usado: " . $lastOtp['usado'] . PHP_EOL;
} else {
    echo "No OTPs found." . PHP_EOL;
}
