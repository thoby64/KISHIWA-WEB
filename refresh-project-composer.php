<?php
// fix-server.php
$commands = [
    'php artisan config:clear',
    'php artisan cache:clear',
    'php artisan view:clear',
    'php artisan route:clear',
    'php artisan optimize:clear',
    'php artisan package:discover',
];

echo "<pre>";
foreach ($commands as $cmd) {
    echo "Running: $cmd\n";
    echo shell_exec($cmd);
    echo "\n---\n";
}
echo "</pre>";
?>