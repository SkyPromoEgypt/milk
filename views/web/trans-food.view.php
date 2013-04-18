<?php
$item = new AnimalFoodForm("AnimalFoodTransaction", "animalfoodtransactions", 
        array(
                "supplier_id",
                "cat_id",
                "quantity",
                'lost'
        ), array(
                "supplier_id" => "The Supplier's name",
                "cat_id" => "The Food type",
                "quantity" => "The Quantity",
                'lost' => "The lost quantity if exists"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>توريد العلف من الموردين</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Animal Food Form</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>المورد</label>
					<div class="mws-form-item large">
					    <?php if($task == 'edit') { ?>
					    <?php echo Supplier::getById($object->supplier_id, 'suppliers', 'Supplier')->name; ?>
					    <input type="hidden" name="supplier_id" value="<?php echo $object->supplier_id; ?>">
					    <?php } else { ?>
						<select name="supplier_id">
						<?php 
						    $types = Supplier::getAll("suppliers");
						    foreach ($types as $type) {
						        echo '<option value="' . $type->id . '"';
						        if($object->supplier_id == $type->id) echo ' selected';
						        echo '>' . $type->name . '</option>';
						    }
						?>
						</select>
						<?php } ?>
					</div>
				</div>
				<div class="mws-form-row">
					<label>نوع العلف</label>
					<div class="mws-form-item large">
					    <?php if($task == 'edit') { ?>
					    <?php echo AnimalFood::getById($object->cat_id, 'animalfood', 'AnimalFood')->name; ?>
					    <input type="hidden" name="cat_id" value="<?php echo $object->cat_id; ?>">
					    <?php } else { ?>
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
						<?php } ?>
					</div>
				</div>
				<div class="mws-form-row">
					<label>الكمية المطلوبة</label>
					<div class="mws-form-item large small">
						<input type="text" name="quantity" class="mws-textinput"
							value="<?php Form::_e('quantity', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>الكمية المستلمة</label>
					<div class="mws-form-item large small">
						<input type="text" name="lost" class="mws-textinput"
							value="<?php Form::_e('lost', $object) ?>">
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