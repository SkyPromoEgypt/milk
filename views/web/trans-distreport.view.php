<?php
$task = $_GET['task'];
$id = $_GET['id'];
if ($id) {
    $sql = "SELECT * FROM distribution WHERE id = $id LIMIT 1";
    $record = Distribution::read($sql, PDO::FETCH_CLASS, 'Distribution');
    if ($record) {
        // Set references for the old details
        $oldQuantity = $record->quantity;
        $oldPrice = $record->price;
        if ($_POST['edit']) {
            
            // Get the new entries if found
            $newQuantity = $_POST['quantity'];
            $newPrice = $_POST['price'];
            
            // set the object's attributes
            $record->quantity = $newQuantity;
            $record->price = $newPrice;
            
            // Get an instance of the store
            $store = Store::getStore();
            
            // Get an instance of the farmer
            $farmer = Farmer::read(
                    "SELECT * FROM farmers WHERE id = $record->farmer_id", 
                    PDO::FETCH_CLASS, 'Farmer');
            
            // Check if the price had changed
            $price = ($oldPrice != $newPrice) ? $newPrice : $oldPrice;
            
            // Modify the price and quantity in the store
            if ($oldQuantity >= $newQuantity) {
                // modify quantity
                $store->milk -= ($oldQuantity - $newQuantity);
                // check the value on the store
                $addedOnUs = $oldQuantity * $oldPrice;
                $previousStoreOnUs = $store->onus - $addedOnUs;
                $store->onus = $previousStoreOnUs;
                $store->onus += $newQuantity * $price;
                $farmer->tohim = $previousStoreOnUs;
                $farmer->tohim += $newQuantity * $price;
                $farmer->save();
                $store->save();
                $record->save();
                Helper::go('/' . Helper::getView());
            } elseif ($oldQuantity <= $newQuantity) {
                // modify quantity
                $store->milk += ($newQuantity - $oldQuantity);
                // check the value on the store
                $addedOnUs = $oldQuantity * $oldPrice;
                $previousStoreOnUs = $store->onus - $addedOnUs;
                $store->onus = $previousStoreOnUs;
                $store->onus += $newQuantity * $price;
                $farmer->tohim = $previousStoreOnUs;
                $farmer->tohim += $newQuantity * $price;
                $farmer->save();
                $store->save();
                $record->save();
                Helper::go('/' . Helper::getView());
            }
        }
    }
}
?>
<?php if($task && $task == "edit") { ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">تعديل بيانات</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>الكمية</label>
					<div class="mws-form-item large small">
						<input type="text" name="quantity" class="mws-textinput"
							value="<?php echo $record->quantity; ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>السعر</label>
					<div class="mws-form-item large small">
						<input type="text" name="price" class="mws-textinput"
							value="<?php echo $record->price; ?>">
					</div>
				</div>
			</div>
			<div class="mws-button-row">
				<input type="submit" name="edit" class="mws-button green"
					value="حفظ">
			</div>
		</form>
	</div>
</div>
<?php
} else {
    $morning = Distribution::getMilkQuantities();
    $night = Distribution::getMilkQuantities(false);
    ?>
<div class="mws-report-container clearfix">
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">تاريخ اليوم</span>
			<span class="mws-report-value"
			style="margin-top: 7px;"><?php echo date("Y/m/d"); ?></span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				صباحا</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;">ك <?php echo !$morning ? 0 : round($morning, 2); ?></span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				مساءا</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;">ك <?php echo !$night ? 0 : round($night,2); ?></span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				الخاص باليوم</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;">ك <?php $total = $morning + $night; echo round($total, 2); ?></span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الموجود
				فعليا بالمخرن</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;">ك <?php $instore = Store::getStore()->milk; echo round($instore, 2) ?></span>
	</span>
	</a>
</div>
<?php
    echo Distribution::renderForEdit("SELECT * FROM farmers", "Farmer");
} ?>