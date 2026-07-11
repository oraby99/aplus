<?php
$methodCode = "

    protected function getRedirectUrl(): string
    {
        return \$this->getResource()::getUrl('index');
    }
";

$count = 0;
$files = glob('c:/Users/DELL/Documents/FREELANCE/A+Academy/app/Filament/Resources/*/Pages/*.php');
echo "Found " . count($files) . " files.<br>";

foreach ($files as $path) {
    $content = file_get_contents($path);
    if (!str_contains($content, 'function getRedirectUrl') && (str_contains($content, 'class Create') || str_contains($content, 'class Edit'))) {
        $pos = strrpos($content, '}');
        if ($pos !== false) {
            $newContent = substr_replace($content, $methodCode . "}\n", $pos, strlen($content) - $pos);
            file_put_contents($path, $newContent);
            $count++;
            echo "Fixed: " . basename($path) . "<br>";
        }
    }
}
echo "Total fixed: $count";
