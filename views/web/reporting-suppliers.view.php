<?php
if (isset($_POST['submit'])) {
    $start = date('Y') . '-' . date('m') . '-1';
    $startDate = ! empty($_POST['from']) ? date('Y-m-d', 
            strtotime($_POST['from'])) : $start;
    $end = date('Y') . '-' . date('m') . '-31';
    $endDate = ! empty($_POST['to']) ? date('Y-m-d', strtotime($_POST['to'])) : $end;
    $monthList = Supplier::renderTransactionsList(
            "SELECT * FROM animalfoodtransactions WHERE supplier_id = " .
                     $_POST['supplier_id'] .
                     " AND created >= '$startDate' AND created <= '$endDate'");
    $allList = Supplier::renderTransactionsList(
            "SELECT * FROM animalfoodtransactions WHERE supplier_id = " .
                     $_POST['supplier_id'] . "");
    $supplier = Supplier::read("SELECT * FROM suppliers WHERE id = " . $_POST['supplier_id'], PDO::FETCH_CLASS, 'Supplier');
    $paid = AccountingSupplier::renderAccounting(
            "SELECT * FROM accountingsupplier WHERE supplier_id = " .
                     $_POST['supplier_id'] .
                     " AND created >= '$startDate' AND created <= '$endDate'");
}
?>
<h1>تقارير الموردين</h1>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">كشف حساب مورد</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>المورد</label>
					<div class="mws-form-item large">
						<select name="supplier_id">
						<?php
                            $types = Supplier::getAll("suppliers");
                            foreach ($types as $type) {
                                echo '<option value="' . $type->id . '"';
                                if (isset($_POST['supplier_id']) && $_POST['supplier_id'] == $type->id)
                                    echo ' selected';
                                echo '>' . $type->name . '</option>';
                            }
                        ?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>من</label>
					<div class="mws-form-item large">
						<div class="mws-form-item">
							<input type="text" name="from"
								class="mws-textinput mws-datepicker"
								value="<?php if(isset($_POST['from'])) echo $_POST['from']; ?>" />
						</div>
					</div>
				</div>
				<div class="mws-form-row">
					<label>الى</label>
					<div class="mws-form-item large">
						<div class="mws-form-item">
							<input type="text" name="to" class="mws-textinput mws-datepicker"
								value="<?php if(isset($_POST['to'])) echo $_POST['to']; ?>" />
						</div>
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
<?php 
if($paid) {
?>
<h2>اجمالي الديون المستحة الدفع  <?php echo $supplier->tohim; ?> ج</h2>
<h2>المدفوعات من يوم <?php echo $startDate; ?> الى يوم <?php echo $endDate; ?></h2>
<?php 
echo $paid;
}
?>
<?php
if ($monthList) {
    ?>
<h2 style="margin-top: 15px;">تعاملات من يوم <?php echo $startDate; ?> الى يوم <?php echo $endDate; ?></h2>
<?php
    echo $monthList;
}
if ($allList) {
    ?>
<h2 style="margin-top: 15px;">كافة التعاملات</h2>
<?php
    echo $allList;
}
?>