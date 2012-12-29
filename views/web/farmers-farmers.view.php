<?php
$item = new Form("Farmer", "farmers", 
        array(
                "name",
                "age",
                "address",
                "phone",
                "notes",
                "status"
        ), 
        array(
                "name" => "The farmer's name",
                "age" => "The farmer's age",
                "address" => "The farmer's address",
                "phone" => "The farmer's phone",
                "notes" => "The farmer's notes",
                "status" => "The farmer's status"
        ), "/farmers-farmers");

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>Farmers Files</h1>
<p>Manage Farmers files. Add, edit or delete files and search through
	them.</p>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Farmers Form</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>Farmer's Name</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput" value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Farmer's Age</label>
					<div class="mws-form-item small">
						<input type="text" name="age" class="mws-textinput" value="<?php Form::_e('age', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Farmer's Address</label>
					<div class="mws-form-item large">
						<input type="text" name="address" class="mws-textinput" value="<?php Form::_e('address', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Farmer's Phone</label>
					<div class="mws-form-item large">
						<input type="text" name="phone" class="mws-textinput" value="<?php Form::_e('phone', $object) ?>">
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
							<li><input type="radio" name="status" value="1" <?php if($object->status == 1) echo 'checked' ?>> <label>The Farmer is active.</label></li>
							<li><input type="radio" name="status" value="0" <?php if($object->status == 0) echo 'checked' ?>> <label>The Farmer is currently idle.</label></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="mws-button-row">
				<input type="submit" name="submit" class="mws-button green" value="Save">
			</div>
		</form>
	</div>
</div>
<?php endif; ?>
<?php if(!$task) echo Farmer::renderForControl(); ?>