<?php
$item = new Form("Car", "cars", 
        array(
                "model",
                "licenseNumber",
                "notes",
                "status"
        ), 
        array(
               	"model" => "The car's model",
                "licenseNumber" => "The car's License Number",
                "status" => "The car's status",
                "notes" => "The car's notes"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>Cars Files</h1>
<p>Manage your cars files. Add, edit or delete files and search through
	them.</p>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Agents / Factories Form</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>Car's Model</label>
					<div class="mws-form-item large">
						<input type="text" name="model" class="mws-textinput"
							value="<?php Form::_e('model', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Car's License Number</label>
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
									Car is active.</label></li>
							<li><input type="radio" name="status" value="0"
								<?php if($object->status == 0) echo 'checked' ?>> <label>The
									Car is currently idle.</label></li>
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
<?php if(!$task) echo Car::renderForControl("SELECT * FROM cars", "Car"); ?>
