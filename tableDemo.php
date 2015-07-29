<?php
namespace ui;
require_once(__DIR__ . "/Table.class.php");
/*
Script for demoing table class
*/
?>
<!DOCTYPE html>
<html>
<head>
<title>BootstrapForm sample</title>

<link rel='stylesheet' href='/fwk/JavaScript/gnu/bootstrap-3.3.2/css/bootstrap.min.css' />

<link rel='stylesheet' href='/fwk/css/gnu/animate/animate.min.css' />

<style>
table, th, td{
	border: 1px solid black;
}

th, td{
	padding: 5px;
}
</style>
</head>
<body>
<?php
// table ID and class. New row automatically started.
$table = new Table('tblDemo', 'demoClass');
// Add another class
$table->classAdd('demo2');

// First, add some header cell
$table->newHeaderCell('Header 1');
$table->newHeaderCell('Header 2');
$table->newHeaderCell('Header 3');
$table->newHeaderCell('Header 4');
// Save the above cells into table header and start new row.
$table->saveHeaderRow();


// Some data cell
// row 1
$table->newCell('data 1 1', 'cell1', 'class1');
$table->newCell('data 1 2');
$table->newCell('data 1 3');
$table->newCell('data 1 4', 'cell4', 'class2');
$table->saveRow();

// row 2
$table->newCell('data 2 1');
$table->newCell('data 2 2');
$table->newCell('data 2 3');
$table->newCell('data 2 4');
$table->saveRow();

// row 3 to demo rowspan and colspan
$cell = new TableCell('data rowspan 2');
$cell->rowSpan = 2;
$cell->classAdd('class3');
$table->newCellObj($cell);

$cell = new TableCell('data colspan 2');
$cell->colSpan = 2;
$table->newCellObj($cell);

$table->newCell('data 3 4');
$table->saveRow();

// row 4
$table->newCell('data 4 2');
$table->newCell('data 4 3');
$table->newCell('data 4 4');
$table->saveRow();

print $table->view();
?>
</body>
</html>