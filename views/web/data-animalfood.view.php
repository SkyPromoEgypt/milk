<?php
$item = new Form("AnimalFood", "animalfood", 
        array(
                "name",
                "quantity"
        ), 
        array(
               	"name" => "The Items's name",
                "quantity" => "The Items's quantity"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>Animal Food Store</h1>
<p>Manage your animal food store. Add, edit or delete files and search through
	them.</p>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Animal Food Form</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>Item's Name</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Item's Quantity</label>
					<div class="mws-form-item large">
						<input type="text" name="quantity" class="mws-textinput"
							value="<?php Form::_e('quantity', $object) ?>">
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
<?php if(!$task) echo AnimalFood::renderForControl("SELECT * FROM animalfood", "AnimalFood"); ?>
