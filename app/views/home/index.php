<?php
if (!isset($_SESSION)) {
    session_start();
}

include __DIR__ . '/../header.php';


echo "<h1>Homepage!</h1>";


include __DIR__ . '/../footer.php';
