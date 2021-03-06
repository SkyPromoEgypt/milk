<?php
$item = new Form("Driver", "drivers", 
        array(
                "name",
                "age",
                "address",
                "phone",
                "licenseNumber",
                "notes",
                "status"
        ), 
        array(
                "name" => "The driver's name",
                "age" => "The driver's age",
                "address" => "The driver's address",
                "phone" => "The driver's phone",
                "licenseNumber" => "The driver's license number",
                "notes" => "The driver's notes"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>Drivers Files</h1>
<p>Manage Drivers files. Add, edit or delete files and search through
	them.</p>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Drivers Form</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>Driver's Name</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Driver's Age</label>
					<div class="mws-form-item small">
						<input type="text" name="age" class="mws-textinput"
							value="<?php Form::_e('age', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Driver's Address</label>
					<div class="mws-form-item large">
						<input type="text" name="address" class="mws-textinput"
							value="<?php Form::_e('address', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Driver's Phone</label>
					<div class="mws-form-item large">
						<input type="text" name="phone" class="mws-textinput"
							value="<?php Form::_e('phone', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Driver's License</label>
					<div class="mws-form-item large">
						<input type="text" name="licenseNumber" class="mws-textinput"
							value="<?php Form::_e('licenseNumber', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Notes</label>
					<div class="mws-form-item large">
						<textarea cols="100%" rows="100%" name="notes"><?php Form::_e('notes', $object) ?></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label>Active</label>
					<div class="mws-form-item clearfix">
						<ul class="mws-form-list inline">
							<li><input type="radio" name="status" value="1"
								<?php if($object->status == 1) echo 'checked' ?>> <label>The
									Driver is active.</label></li>
							<li><input type="radio" name="status" value="0"
								<?php if($object->status == 0) echo 'checked' ?>> <label>The
									Driver is currently idle.</label></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="mws-button-row">
				<input type="submit" name="submit" class="mws-button green"
					value="Save">
			</div>
		</form>
	</div>
</div>
<?php endif; ?>
<?php if(!$task) echo Driver::renderForControl("SELECT * FROM drivers", "Driver"); ?>
