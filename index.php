<?php

$rootDir = $_ENV['ROOT_DIR'] ?? __DIR__;

if (isset($_GET['download'])) {
    $parts = explode('/', $_GET['download']);
    $filename = end($parts);

    $file = $rootDir.$_GET['download'];

    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"$filename\"");
    readfile($file);

    exit;
}

function printdir(string $dir, string $webPath, string $rootPath = null, int $maxDepth = 2): void {
    $ignoredFiles = [
        '.',
        '..',
        'index.php',
        'style.css',
        'main.js',
    ];

    $fullPath = null !== $rootPath ? $rootPath.'/'.$dir : $dir;

    $files = scandir($fullPath);
    if (null === $rootPath) {
        echo "<ul>";
    } else {
        echo "<ul id=\"$dir\">";
    }
    foreach ($files as $file) {
        if (in_array($file, $ignoredFiles)) {
            continue;
        }

        $isDir = is_dir($fullPath.'/'.$file);
        $isExpendableDir = $isDir && 0 < $maxDepth;

        if ($isExpendableDir) {
            echo '<li class="folder">';
        } elseif ($isDir) {
            echo '<li class="folder out-of-depth-folder">';
        } else {
            echo '<li>';
        }

        if ($isExpendableDir) {
            echo "<a href=\"#\" data-toggle=\"$file\">$file</a>";
            printdir($file, $webPath.$file.'/', $fullPath, $maxDepth - 1);
        } elseif ($isDir) {
            echo $file;
        } else {
            echo "<a href=\"?download=$webPath$file\" target=\"_blank\">$file</a>";
        }

        echo '</li>';
    }
    echo '</ul>';
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Directory listing</title>

    <link href="style.css" rel="stylesheet" type="text/css">
    <script src="main.js"></script>
  </head>
  <body>
    <h1>Directory listing</h1>

    <div class="box">
        <div class="links">
            <a href="#" id="toggle-all">Toggle all</a>
        </div>

        <div class="tree">
            <?php printdir($rootDir, '/'); ?>
        </div>
    </div>
  </body>
</html>
