<?php
namespace ui;

require_once(__DIR__ . "/BootstrapPagination.class.php");
/*
Script for demoing table class
*/
?>
<!DOCTYPE html>
<html>
<head>
<title>BootstrapPagination Demo</title>
    <link rel='stylesheet' href='/fwk/JavaScript/gnu/bootstrap-3.3.2/css/bootstrap.min.css' />
</head>
<body>

<div class='container-fluid'>
<h1>Bootstrap 3 Pagination PHP Wrapper Demo</h1>

<?php
$pagination = new BootstrapPagination();
$pagination->createDefaultNav();    // Create default navigation buttons
// Or customize it
$pagination->navPrevSet('Prev', '/prev');

// Create some items
for($i = 1; $i <= 6; $i++){
    $isActive = ($i == 3);
    $isDisabled = ($i % 2 == 0);
    $pagination->itemPush($i, '#', $isActive, $isDisabled);
}

print '<p>Add items using BootstrapPagination->itemPush()</p>';
print $pagination->view();

// Can use itemObjPush() to add item
for($i = 7; $i <= 12; $i++){
    $isDisabled = ($i % 3 == 0);
    
    $itemObj = new BootstrapPaginationItem($i);
    $itemObj->urlSet('#');
    if( $isDisabled ){
        $itemObj->disable();
    }
    $pagination->itemObjPush($itemObj);
}

print '<p>Add items using BootstrapPagination->itemObjPush()</p>';
print $pagination->view();

print '<p>Change active item using label</p>';
$pagination->itemActivateByLabel(10);
print $pagination->view();

print "<p>Limit visible items to 5</p>";
$pagination->numVisibleSet(5);
print $pagination->view();
$pagination->itemActivateByLabel(3);
print $pagination->view();

print "<p>Visible items edge cases: even number, setting a number more than total num of items</p>";
$pagination->numVisibleSet(4);
print $pagination->view();
$pagination->numVisibleSet(15);
print $pagination->view();

print "<p>View as Pager</p>";
$pagination->typeSet( BootstrapPagination::TYPE_PAGER);
print $pagination->view();

print "<p>Pager button alignment</p>";
$pagination->navPrevSetAlign( BootstrapPaginationItemNav::PAGER_ALIGN_PREV );
$pagination->navNextSetAlign( BootstrapPaginationItemNav::PAGER_ALIGN_NEXT );
print $pagination->view();
?>

</div>
</body>
</html>