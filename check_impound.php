<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check specific tables
$tables = ['impound_records', 'impounds'];
foreach ($tables as $table) {
    $exists = DB::select("SHOW TABLES LIKE '$table'");
    echo "$table: " . (count($exists) > 0 ? "EXISTS" : "NOT FOUND") . PHP_EOL;
}

// Show impound_records columns
$cols = DB::select("SHOW COLUMNS FROM impound_records");
echo "\nimpound_records columns:\n";
foreach ($cols as $c) {
    echo "- {$c->Field}: {$c->Type}\n";
}
