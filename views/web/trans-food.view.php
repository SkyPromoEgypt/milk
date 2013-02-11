<?php
$item = new AnimalFoodForm("AnimalFoodTransaction", "animalfoodtransactions", 
        array(
                "name",
                "cat_id",
                "quantity"
        ), array(
                "name" => "The Supplier's name",
                "cat_id" => "The Food type",
                "quantity" => "The Quantity",
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>Animal Food Transactions</h1>
<p>Manage your animal food transactions.</p>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Animal Food Form</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>Supplier's Name</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Food Type</label>
					<div class="mws-form-item large">
						<select name="cat_id">
						<?php 
						    $types = AnimalFood::getAll("animalfood");
						    foreach ($types as $type) {
						        echo '<option value="' . $type->id . '"';
						        if($object->cat_id == $type->id) echo ' selected';
						        echo '>' . $type->name . '</option>';
						    }
						?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>Quantity</label>
					<div class="mws-form-item large small">
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
<?php if(!$task) echo AnimalFoodTransaction::renderForControl("SELECT * FROM " . AnimalFoodTransaction::$table, "AnimalFoodTransaction"); ?>