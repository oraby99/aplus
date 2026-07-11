<?php
// Compile assets
echo "Compiling assets...<br>";
exec('npm run build 2>&1', $output, $return_var);
echo "<pre>" . implode("\n", $output) . "</pre>";
echo "Done. Return code: $return_var";
