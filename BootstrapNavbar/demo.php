<?php
namespace ui;

use ui\BootstrapNavbarItemGroup;

require_once(__DIR__ . "/BootstrapNavbar.class.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>BootstrapPagination Demo</title>
    <link rel='stylesheet' href='/fwk/JavaScript/gnu/bootstrap-3.3.2/css/bootstrap.min.css' />
    <style>
        .navbar-brand img{
            width: auto;
            height: 1.5em;
        }
    </style>
</head>
<body>

<div class='container-fluid'>
<h1>Bootstrap 3 Pagination PHP Wrapper Demo</h1>

<?php

$navbar = new BootstrapNavbar();
$navbar->brandStrSet('<img src="/fwk/media/images/logos/logoLAEn.png" />');
$navbar->brandUrlSet('/fwk/PHP/ui/BootstrapNavbar/demo.php');

$navbar->itemAddLink('Link 1', '/link1');
$navbar->itemAddLink('Link 2', '/link2');
$navbar->itemAddLink('Link 3', '/link3', BootstrapNavbarItemGroup::ALIGN_RIGHT);
$navbar->itemAddButton('Button 4', BootstrapNavbarItemGroup::ALIGN_RIGHT);

print $navbar->view();
?>

</div>
</body>
</html>