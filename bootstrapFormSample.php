<?php
require_once(__DIR__ . "/../../global.php");
require_once(__DIR__ . "/BootstrapForm.class.php");
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
<title>BootstrapForm sample</title>

<link rel='stylesheet' href='/fwk/JavaScript/gnu/bootstrap-3.3.2/css/bootstrap.min.css' />
<link rel='stylesheet' href='/fwk/JavaScript/gnu/bootstrap-3.3.2/css/bootstrap-custom.css' />
<link rel='stylesheet' href='/fwk/css/gnu/animate/animate.min.css' />


</head>
<body>
	<div class="container-fluid">
	<div class="row">
		<!-- main div -->
		<div class="col-sm-12" id='divMain'>
			<div class='page-header'>
				<h1>BootstrapForm Sample</h1>
			</div>
			
			<?php
			$form = new \ui\BootstrapForm();
			$form->labelHide();		// Globally hide labels
			
			// id
			$form->addField( new \ui\BootstrapFormFieldHidden('txtItemId', '', 123) );
			
			// str
			$strField = new \ui\BootstrapFormFieldText('txtItemStr', 'Name', 'Asthma Resource');
			$strField->validationStateSet(\ui\BootstrapFormField::VALIDATION_STATE_WARNING, true);
			$strField->labelShow();		// Override form setting to show label for this field particularly
			$strField->helpText = "A block of help text that breaks onto a new line and may extend beyond one line.";
			$form->addField( $strField );
			
			// strLong
			$form->addField( new \ui\BootstrapFormFieldTextArea('taItemStrLong', 'Description') );
			
			// itemTypeStrId
			$itemTypeField = new \ui\BootstrapFormField(null, 'Type', null);
			$itemTypeField->useSrcCode = true;
			// srcCode for select box can be produced using our FWK code
			$itemTypeField->srcCode = "<select class='form-control'>
				<option value='1' selected>Printed Materials</option>
				<option value='2'>RESPTREC Course</option>
				<option value='3'>Raffle Tickets</option>
			</select>";
			$form->addField( $itemTypeField);
			
			// Print weight, width, height and length into same line, each occupy 3 grid unit.
			$gridConfig = new \ui\BootstrapGridConfig('sm', 3);
			
			$form->rowStart();
			
			// weight
			$weightField = new \ui\BootstrapFormFieldText('txtWeight', 'Weight');
			$weightField->addonPost = 'g';
			$weightField->validationStateSet(\ui\BootstrapFormField::VALIDATION_STATE_SUCCESS);
			$weightField->isShowFeedback = true;
			$form->addField($weightField , $gridConfig );
			
			// width
			$widthField = new \ui\BootstrapFormFieldText('txtWidth', 'Width');
			$widthField->addonPost = 'cm';
			$widthField->validationStateSet(\ui\BootstrapFormField::VALIDATION_STATE_WARNING);
			$form->addField( $widthField, $gridConfig );
			
			// height
			$heightField = new \ui\BootstrapFormFieldText('txtHeight', 'Height');
			$heightField->addonPost = 'cm';
			$heightField->validationStateSet(\ui\BootstrapFormField::VALIDATION_STATE_ERROR, true);
			$form->addField( $heightField, $gridConfig );
			
			// length
			$lengthField = new \ui\BootstrapFormFieldText('txtLength', 'Length');
			$lengthField->addonPost = 'cm';
			$form->addField( $lengthField, $gridConfig);
			
			$form->rowEnd();
			
			// isActive
			$form->addField( new \ui\BootstrapFormFieldCheckbox('chkIsActive', 'Is Active') );
			
			// Form buttons
			$btnSave = new \ui\BootstrapFormFieldButton('btnSave', 'Save');
			$btnSave->addClass('btn btn-primary');
			$form->addButton( $btnSave );
			$btnCancel = new \ui\BootstrapFormFieldButton('btnCancel', 'Cancel');
			$btnCancel->addClass('btn btn-default');
			$form->addButton( $btnCancel );
			?>
			
			<h3>Basic Form</h3>
			<?php print $form->view();?>
			<hr />
			<br /><br />
			
			
			<h3>Inline Form</h3>
			<?php
			$form->typeSet('inline');
			print $form->view();
			?>
			<hr />
			<br /><br />
			
			
			<h3>Horizontal Form</h3>
			<?php
			$form->typeSet('horizontal');
			print $form->view();
			?>
		</div>
	</div>
</div>
<script type='text/javascript' src='/fwk/JavaScript/gnu/jQuery/jquery-1.11.2.min.js'></script>

<script type='text/javascript' src='/fwk/JavaScript/gnu/bootstrap-3.3.2/js/bootstrap.min.js'></script>


</body>
</html>