<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$tables = DB::select('SHOW TABLES');
foreach($tables as $t) {
    foreach($t as $k) {
        if(preg_match('/impound|owner|rabies|bite|exposure/i', $k)) {
            echo $k.PHP_EOL;
        }
    }
}
