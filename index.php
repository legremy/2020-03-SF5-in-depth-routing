<?php

$availablePages =  [
    'list', 'show', 'create'
];

$page = 'list';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

if (!in_array($page, $availablePages)) {
    require 'pages/404.php';
    return;
}

require_once "pages/$page.php";
