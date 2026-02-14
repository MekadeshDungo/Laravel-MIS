@echo off
chdir /d "%~dp0"

echo ========================================
echo VET-MIS - MongoDB Connection Check
echo ========================================
echo.

php -r "
require_once 'vendor/autoload.php';
try {
    \$client = new MongoDB\Client('mongodb://127.0.0.1:27017');
    \$db = \$client->vet_mis;
    \$result = \$db->command(['ping' => 1]);
    echo '[OK] MongoDB is running and accessible!' . PHP_EOL;
    echo 'Database: vet_mis' . PHP_EOL;
} catch (Exception \$e) {
    echo '[ERROR] MongoDB connection failed!' . PHP_EOL;
    echo 'Message: ' . \$e->getMessage() . PHP_EOL;
    echo '' . PHP_EOL;
    echo 'Please start MongoDB:' . PHP_EOL;
    echo '  - Open MongoDB Compass, OR' . PHP_EOL;
    echo '  - Run: mongod --dbpath data\\db' . PHP_EOL;
}
"

echo.
pause
