<?php
$item = new AccountingSupplierForm("AccountingSupplier", "accountingsupplier", 
        array(
                "supplier_id",
                "paid"
        ), array(
                "paid" => "المبلغ المدفوع"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>حساب مورد</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">محاسبة مورد</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>المورد</label>
					<div class="mws-form-item large">
						<select name="supplier_id">
						<?php 
						    $suppliers = Supplier::getAll("suppliers");
						    foreach ($suppliers as $supplier) {
						        echo '<option value="' . $supplier->id . '"';
						        if($object->agent_id == $supplier->id) echo ' selected';
						        echo '>' . $supplier->name . '</option>';
						    }
						?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>المبلغ المدفوع</label>
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
<?php if(!$task) echo AccountingSupplier::renderForControl("SELECT * FROM accountingsupplier", "AccountingSupplier"); ?>