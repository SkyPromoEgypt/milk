<?php
$food = AnimalFood::getAll('animalfood');
$item = new DistributorForm("Distribution", "distribution", 
        array(
                "theid",
                "quantity",
                "paymentType",
                "payment",
                "notes",
                "thetime"
        ), 
        array(
                "quantity" => "The milk quantity",
                "paymentType" => "The payment type",
                "payment" => "The payment",
                "notes" => "The farmer's notes",
                "thetime" => "The delivery time"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>The Distribution Center</h1>
<p>Manage Milk quantities in the distribution center.</p>
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
						<input type="text" name="name" class="mws-textinput nameautocomplete"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<input type="hidden" id="theid" name="theid">
				<div class="mws-form-row">
					<label>Milk quantity</label>
					<div class="mws-form-item small">
						<input type="text" name="quantity" class="mws-textinput"
							value="<?php Form::_e('quantity', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Payment Type</label>
					<div class="mws-form-item small">
						<select name="paymentType">
							<option value="1000000">Money</option>
							<?php
								foreach ($food as $object) {
									echo '<option value="' . $object->id . '">' . $object->name . '</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>Payment</label>
					<div class="mws-form-item small">
						<input type="text" name="payment" class="mws-textinput"
							value="<?php Form::_e('payment', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>Notes</label>
					<div class="mws-form-item large">
						<textarea cols="100%" rows="100%" name="notes"><?php Form::_e('notes', $object) ?></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label>Delivery Time</label>
					<div class="mws-form-item clearfix">
						<ul class="mws-form-list inline">
							<li><input type="radio" name="thetime" value="1"
								<?php if($object->status == 1) echo 'checked' ?>> <label>Day time.</label></li>
							<li><input type="radio" name="thetime" value="2"
								<?php if($object->status == 2) echo 'checked' ?>> <label>Night time.</label></li>
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
<?php if(!$task) echo Distribution::renderForControl("SELECT * FROM distribution", "Distribution"); ?>
