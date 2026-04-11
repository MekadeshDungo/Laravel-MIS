<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$rows = DB::select("SELECT * FROM impounds LIMIT 5");
echo "impounds data: " . count($rows) . " rows\n";

if (count($rows) > 0) {
    $first = (array) $rows[0];
    echo "\nSample columns:\n";
    foreach ($first as $k => $v) {
        echo "$k = $v\n";
    }
}
