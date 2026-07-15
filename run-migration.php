<?php
// run-migrations.php
$commands = [
    'php artisan migrate --force 2>&1',
];

echo "<h2>Running Database Migrations</h2>";
echo "<pre style='background: #f4f4f4; padding: 20px; border-radius: 5px;'>";

foreach ($commands as $cmd) {
    echo "Command: " . htmlspecialchars($cmd) . "\n";
    echo str_repeat("-", 50) . "\n";
    $output = shell_exec($cmd);
    echo htmlspecialchars($output);
    echo "\n" . str_repeat("-", 50) . "\n";
}

echo "</pre>";
echo "<p style='color: green; font-weight: bold;'>✅ Migrations completed! Please DELETE this file immediately.</p>";
?>