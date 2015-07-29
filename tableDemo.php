<?php
namespace ui;
require_once(__DIR__ . "/Table.class.php");
require_once(__DIR__ . "/BootstrapTable.class.php");
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
#tblDemo, #tblDemo th, #tblDemo td{
	border: 1px solid black;
}

#tblDemo th, #tblDemo td{
	padding: 5px;
}
</style>
</head>
<body>
<div class='container-fluid'>
<?php
/*
Standard HTML table.
*/
// table ID and class. New row automatically started.
$table = new Table('tblDemo', 'demoClass');
$table->caption = "Standard HTML Table";
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
print "<hr />";


/*
Bootstrap Table
*/
$bsTable = new BootstrapTable('tblBs1', 'demoClass');
$bsTable->caption = "Bootstrap Table (Normal)";

// First, add some header cell
$bsTable->newHeaderCell('Header 1');
$bsTable->newHeaderCell('Header 2');
$bsTable->newHeaderCell('Header 3');
$bsTable->newHeaderCell('Header 4');
// Save the above cells into table header and start new row.
$bsTable->saveHeaderRow();

// Some data cell
// row 1
$bsTable->newCell('data 1 1', 'cell1', 'class1');
$bsTable->newCell('data 1 2');
$bsTable->newCell('data 1 3');
$bsTable->newCell('data 1 4', 'cell4', 'class2');
$bsTable->saveRow();

// row 2
$bsTable->newCell('data 2 1');
$bsTable->newCell('data 2 2');
$bsTable->newCell('data 2 3');
$bsTable->newCell('data 2 4');
$bsTable->saveRow();

print $bsTable->view();


$bsTable = new BootstrapTable('tblBs2', 'demoClass');
$bsTable->classAdd(BootstrapTable::STRIPED);
$bsTable->caption = "Bootstrap Table (Striped)";

// First, add some header cell
$bsTable->newHeaderCell('Header 1');
$bsTable->newHeaderCell('Header 2');
$bsTable->newHeaderCell('Header 3');
$bsTable->newHeaderCell('Header 4');
// Save the above cells into table header and start new row.
$bsTable->saveHeaderRow();

// Some data cell
// row 1
$bsTable->newCell('data 1 1', 'cell1', 'class1');
$bsTable->newCell('data 1 2');
$bsTable->newCell('data 1 3');
$bsTable->newCell('data 1 4', 'cell4', 'class2');
$bsTable->saveRow();

// row 2
$bsTable->newCell('data 2 1');
$bsTable->newCell('data 2 2');
$bsTable->newCell('data 2 3');
$bsTable->newCell('data 2 4');
$bsTable->saveRow();

print $bsTable->view();


$bsTable = new BootstrapTable('tblBs3', 'demoClass');
$bsTable->classAdd(BootstrapTable::BORDERED);
$bsTable->classAdd(BootstrapTable::HOVER);
$bsTable->classAdd(BootstrapTable::CONDENSED);
$bsTable->caption = "Bootstrap Table (Bordered, Hover, Condensed)";

// First, add some header cell
$bsTable->newHeaderCell('Header 1');
$bsTable->newHeaderCell('Header 2');
$bsTable->newHeaderCell('Header 3');
$bsTable->newHeaderCell('Header 4');
// Save the above cells into table header and start new row.
$bsTable->saveHeaderRow();

// Some data cell
// row 1
$bsTable->newCell('data 1 1', 'cell1', 'class1');
$bsTable->newCell('data 1 2');
$bsTable->newCell('data 1 3');
$bsTable->newCell('data 1 4', 'cell4', 'class2');
$bsTable->saveRow();

// row 2
$bsTable->newCell('data 2 1');
$bsTable->newCell('data 2 2');
$bsTable->newCell('data 2 3');
$bsTable->newCell('data 2 4');
$bsTable->saveRow();

print $bsTable->view();



/*
With contextual rows
*/
$bsTable = new BootstrapTable('tblBs4', 'demoClass');
$bsTable->caption = "Bootstrap Table With Contextual Row";

// First, add some header cell
$bsTable->newHeaderCell('Header 1');
$bsTable->newHeaderCell('Header 2');
$bsTable->newHeaderCell('Header 3');
$bsTable->newHeaderCell('Header 4');
// Save the above cells into table header and start new row.
$bsTable->saveHeaderRow();


$contextValue = array(
	BootstrapTableRow::ACTIVE, 
	BootstrapTableRow::DANGER, 
	BootstrapTableRow::INFO, 
	BootstrapTableRow::NORMAL, 
	BootstrapTableRow::SUCCESS, 
	BootstrapTableRow::WARNING
);

// 6 rows
for($i = 1; $i <= 6; $i++){
	// 4 cells
	for($j = 1; $j <= 4; $j++){
		$bsTable->newCell("data $i $j");
	}
	
	// each row use a different context;
	$bsTable->saveRow( $contextValue[$i-1] );
}

print $bsTable->view();
?>
</div>
</body>
</html>