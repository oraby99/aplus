<?php
$file = __DIR__ . '/../storage/app/public/projects/01KX6FAGJAWV4QHFBQSJKVRJ4N.jpeg';
if (file_exists($file)) {
    echo "File exists in storage/app/public.<br>";
} else {
    echo "File does not exist in storage/app/public either!<br>";
}
