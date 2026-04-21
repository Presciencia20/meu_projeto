<?php
require_once '/home/presciencia/work/meu_projeto/app/Libraries/SmsService.php';

use App\Libraries\SmsService;

function test($num) {
    echo "$num -> " . SmsService::normalizeAngolan($num) . "\n";
}

test('923456789');
test('0923456789');
test('244923456789');
test('+244923456789');
test('923-456-789');
