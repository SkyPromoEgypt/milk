<?php
$item = new AccountingFarmerForm("AccountingFarmer", "accountingfarmer", 
        array(
                "farmer_id",
                "payment",
                "animalfood_id",
                "paid"
        ), array(
                "paid" => "المبلغ المدفوع"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>حساب المزارعين</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">محاسبة مزراع</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>المزارعين</label>
					<div class="mws-form-item large">
						<select name="farmer_id">
						<?php 
						    $farmers = Farmer::getAll("farmers");
						    foreach ($farmers as $farmer) {
						        echo '<option value="' . $farmer->id . '"';
						        if($object->farmer_id == $farmer->id) echo ' selected';
						        echo '>' . $farmer->name . '</option>';
						    }
						?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>طريقة الدفع</label>
					<div class="mws-form-item large">
						<select name="payment">
						    <option value="1" <?php if(isset($object->payment) && $object->payment == 1) echo 'selected'; ?>>نقدي</option>
						    <option value="2" <?php if(isset($object->payment) && $object->payment == 2) echo 'selected'; ?>>علف</option>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>نوع العلف</label>
					<div class="mws-form-item large">
						<select name="animalfood_id">
						<?php 
						    $farmers = AnimalFood::getAll("animalfood");
						    foreach ($farmers as $farmer) {
						        echo '<option value="' . $farmer->id . '"';
						        if($object->animalfood_id == $farmer->id) echo ' selected';
						        echo '>' . $farmer->name . '</option>';
						    }
						?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>كمية النقدي او العلف</label>
					<div class="mws-form-item large small">
						<input type="text" name="paid" class="mws-textinput"
							value="<?php Form::_e('paid', $object) ?>">
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
<?php if(!$task) echo AccountingFarmer::renderForControl("SELECT * FROM accountingfarmer", "AccountingFarmer"); ?>