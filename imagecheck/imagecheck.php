<html>
<body>
<pre>
<?php

/* Filename: imagecheck.php
 * Feature: Find/Remove unused/unavailable product- and category images
 *
 */

// Load OXID Configuration 

class OXID_Config
{
    public function __construct()
    {
        include '../config.inc.php';
    }
}

// Get Config for Database-Connection
$src_shop = new OXID_Config();

// Connect to Database
$mysqli = new mysqli($src_shop->dbHost, $src_shop->dbUser, $src_shop->dbPwd, $src_shop->dbName);
$mysqli->select_db($src_shop->dbName);
$mysqli->set_charset("utf8");

for ($i = 1; $i <= 12; $i++) {

    $aImgFilesArticles = Array();
    $sql_select = 'SELECT DISTINCT OXPIC' . $i . ' FROM oxarticles WHERE OXPIC' . $i . ' != "";';
    $result = $mysqli->query($sql_select);
    while ($row = $result->fetch_assoc()) {
        $aImgFilesArticles[] = $row['OXPIC' . $i];
    }

    // Generated Pictures

    $imgdir = '../out/pictures/generated/product/' . $i . '/';
    $sub_dirs = glob($imgdir . '*', GLOB_ONLYDIR);
    $aFoundGenerated = Array();
    foreach ($sub_dirs as $sub_dir) {
        $files = array_filter(glob($sub_dir . '/*'), 'is_file');
        foreach ($files as $file) {
            if (!in_array(basename($file), $aImgFilesArticles) && basename($file) != 'nopic.jpg') {
                echo 'Obsolete File found: ' . $file . "\n";
                if ($_GET['autodelete'] == 'true') {
                    unlink($file);
                }
            }
        }
    }

    //Master Pictures

    $imgdir = '../out/pictures/master/product/' . $i . '/';
    $files = array_filter(glob($imgdir . '*'), 'is_file');
    $aFoundMaster = Array();
    foreach ($files as $file) {
        if (!in_array(basename($file),
                $aImgFilesArticles) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
        ) {
            echo 'Obsolete File found: ' . $file . "\n";
            if ($_GET['autodelete'] == 'true') {
                unlink($file);
            }
        } else {
            $aFoundMaster[] = basename($file);
        }
    }
    $aNotFound = array_diff($aImgFilesArticles, $aFoundMaster);
    if (count($aNotFound) > 0) {
        echo "Not found Article-Master in $imgdir :\n";
        var_dump($aNotFound);
    }
}

//Category Thumbnails

$imgdir = '../out/pictures/master/category/thumb/';
$aImgFilesCatThumbs = Array();
$aFoundCatThumb = Array();
$sqlQuery4Thumbs = "SELECT OXTHUMB, OXTHUMB_1, OXTHUMB_2, OXTHUMB_3 FROM oxcategories WHERE OXTHUMB!='' OR OXTHUMB_1 !='' OR OXTHUMB_2 !='' OR OXTHUMB_3 !='';";
$result = $mysqli->query($sqlQuery4Thumbs);
while ($row = $result->fetch_assoc()) {
    if ($row['OXTHUMB'] != '') {
        $aImgFilesCatThumbs[] = $row['OXTHUMB'];
    }
    if ($row['OXTHUMB_1'] != '') {
        $aImgFilesCatThumbs[] = $row['OXTHUMB_1'];
    }
    if ($row['OXTHUMB_2'] != '') {
        $aImgFilesCatThumbs[] = $row['OXTHUMB_2'];
    }
    if ($row['OXTHUMB_3'] != '') {
        $aImgFilesCatThumbs[] = $row['OXTHUMB_3'];
    }
}
$aImgFilesCatThumbs = array_unique($aImgFilesCatThumbs);
$files = array_filter(glob($imgdir . '*'), 'is_file');
foreach ($files as $file) {
    if (!in_array(basename($file),
            $aImgFilesCatThumbs) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
    ) {
        echo 'Obsolete File found: ' . $file . "\n";
        if ($_GET['autodelete'] == 'true') {
            unlink($file);
        }
    } else {
        $aFoundCatThumb[] = basename($file);
    }
}
$aNotFound = array_diff($aImgFilesCatThumbs, $aFoundCatThumb);
if (count($aNotFound) > 0) {
    echo "\nNot found Thumbnail in $imgdir :\n";
    var_dump($aNotFound);
}

//Category Icons

$imgdir = '../out/pictures/master/category/icon/';
$aImgFilesCatIcons = Array();
$aFoundCatIcon = Array();
$sqlQuery4Icons = "SELECT DISTINCT OXICON FROM oxcategories where OXICON!='';";
$result = $mysqli->query($sqlQuery4Icons);
while ($row = $result->fetch_assoc()) {
    $aImgFilesCatIcons[] = $row['OXICON'];
}

$files = array_filter(glob($imgdir . '*'), 'is_file');
foreach ($files as $file) {
    if (!in_array(basename($file),
            $aImgFilesCatIcons) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
    ) {
        echo 'Obsolete File found: ' . $file . "\n";
        if ($_GET['autodelete'] == 'true') {
            unlink($file);
        }
    } else {
        $aFoundCatIcon[] = basename($file);
    }
}
$aNotFound = array_diff($aImgFilesCatIcons, $aFoundCatIcon);
if (count($aNotFound) > 0) {
    echo "\nNot found Icon in $imgdir :\n";
    var_dump($aNotFound);
}

//Category Promo Icons

$imgdir = '../out/pictures/master/category/promo_icon/';
$aImgFilesCatPromo = Array();
$aFoundCatPromo = Array();
$sqlQuery4PromoIcons = "SELECT DISTINCT OXPROMOICON FROM oxcategories where OXPROMOICON!='';";
$result = $mysqli->query($sqlQuery4PromoIcons);
while ($row = $result->fetch_assoc()) {
    $aImgFilesCatPromo[] = $row['OXPROMOICON'];
}

$files = array_filter(glob($imgdir . '*'), 'is_file');
foreach ($files as $file) {
    if (!in_array(basename($file),
            $aImgFilesCatPromo) && basename($file) != 'nopic.jpg' && basename($file) != 'dir.txt'
    ) {
        echo 'Obsolete File found: ' . $file . "\n";
        if ($_GET['autodelete'] == 'true') {
            unlink($file);
        }
    } else {
        $aFoundCatPromo[] = basename($file);
    }
}
$aNotFound = array_diff($aImgFilesCatPromo, $aFoundCatPromo);
if (count($aNotFound) > 0) {
    echo "\nNot found Promo-Icon in $imgdir :\n";
    var_dump($aNotFound);
}

// Disconnect from Database
mysqli_close($mysqli);
?>
    --- DONE ---
</pre>
</body>
</html>
