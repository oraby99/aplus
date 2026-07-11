<?php
$file = __DIR__ . '/storage/projects/01KX6FAGJAWV4QHFBQSJKVRJ4N.jpeg';
if (file_exists($file)) {
    echo "File exists.<br>";
    echo "Is readable: " . (is_readable($file) ? 'Yes' : 'No') . "<br>";
    echo "File size: " . filesize($file) . " bytes<br>";
    $perms = fileperms($file);
    echo "Permissions: " . substr(sprintf('%o', $perms), -4) . "<br>";
} else {
    echo "File does not exist at: " . $file . "<br>";
}
