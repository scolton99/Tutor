<?php
use tech\scolton\tutor\User;

define("PAGE_NAME", "USER");
define("REL", "../");

spl_autoload_register(function ($class) {
    $tmp = str_replace("\\", DIRECTORY_SEPARATOR, $class);

    /** @noinspection PhpIncludeInspection */
    if (@require_once(REL . "assets/php/classes/$tmp.php")) {
        return;
    }

    $i = new RecursiveDirectoryIterator(REL . "assets/php/classes/", RecursiveDirectoryIterator::SKIP_DOTS);
    $j = new RecursiveIteratorIterator($i, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($j as $item) {
        if (strtolower($item->getExtension()) != "php")
            continue;

        if (strtolower($item->getBasename(".php")) != $class)
            continue;

        /** @noinspection PhpIncludeInspection */
        require_once($item->getPath());
    }
});

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();
if (!isset($_SESSION["id"]) || $_SESSION["id"] == -1)
    header("Location: " . REL . "/login");
if (!isset($_GET["id"])) {
    header("Location: ../account");
}

$user = User::get(intval($_GET["id"]));
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("../assets/parts/head.php"); ?>
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/md5.min.js"></script>
        <link rel="stylesheet" href="../assets/css/main.css"/>
    </head>
    <body onload="$('[data-toggle=\'tooltip\']').tooltip();">
        <?php include("../assets/parts/nav.php"); ?>
        <div class="container-fluid">
            <?php echo $user->render(); ?>
        </div>
    </body>
</html>