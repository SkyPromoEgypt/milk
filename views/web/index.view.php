<?php
$morning = Distribution::getMilkQuantitiesForThisMonth();
$night = Distribution::getMilkQuantitiesForThisMonth(false);
$supplied = AgentTransaction::getTransactionsOfThisMonth();
$lost = AgentTransaction::getLostTransactionsOfThisMonth();
$animalFoodQuantity = AnimalFood::getAllQuantities();
$animalFood = AnimalFoodTransaction::getAllQuantitiesOfThisMonth();
$animalFoodLost = AnimalFoodTransaction::getLostOfThisMonth();
$milkPrice = Milk::getBuyPrice();
$milkPrice2 = Milk::getBuyPrice2();

// Get onus
$allToHimFarmers = Farmer::read("SELECT SUM(tohim) FROM farmers", PDO::FETCH_ASSOC);
$allToHimFarmers = $allToHimFarmers['SUM(tohim)'];
$allToHimSuppliers = Supplier::read("SELECT SUM(tohim) FROM suppliers", PDO::FETCH_ASSOC);
$allToHimSuppliers = $allToHimSuppliers['SUM(tohim)'];
$onus = $allToHimFarmers + $allToHimSuppliers;

// Get tous
$allOnHimFarmers = Farmer::read("SELECT SUM(onhim) FROM farmers", PDO::FETCH_ASSOC);
$allOnHimFarmers = $allOnHimFarmers['SUM(onhim)'];
$allOnHimSuppliers = Agent::read("SELECT SUM(onhim) FROM agents", PDO::FETCH_ASSOC);
$allOnHimSuppliers = $allOnHimSuppliers['SUM(onhim)'];
$forus = $allOnHimFarmers + $allOnHimSuppliers;
?>
<div class="mws-report-container clearfix">
	<h2>إحصائيات الشهر</h2>
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">تاريخ اليوم</span>
			<span class="mws-report-value"
			style="font-size: 1.2em; margin-top: 7px;"><?php echo date("Y/m/d"); ?></span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				صباحا للشهر</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo !$morning ? 0 : round($morning, 2); ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				مساءا للشهر</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo !$night ? 0 : round($night,2); ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">اجمالي
				الداخل</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php $total = $morning + $night; echo round($total, 2); ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الموجود
				فعليا بالمخرن</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php $instore = Store::getStore()->milk; echo round($instore, 2) ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">مدين</span>
			<span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round($onus, 2) ?> ج</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">دائن</span>
			<span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round($forus, 2) ?> ج</span>
	</span>
	</a>
	<?php 
        $total = abs(round(($forus - $onus), 2));
        $status = ($onus > $forus) ? 'down' : 'up';
	?>
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الحالة العامة</span>
			<span class="mws-report-value <?php echo $status?>"
			style="font-size: 1.8em; margin-top: 7px; display: block;">
			<?php echo $total; ?> ج</span>
	</span>
	</a>
	 <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">اجمالي
				الخارج</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round($supplied, 2) ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">اجمالي
				العلف بالمخرن</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round($animalFoodQuantity, 2) ?> ش</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">اجمالي
				هادر اللبن</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round(($supplied - $lost), 2) ?> ك</span>
	</span>
	</a>
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">اجمالي
				هادر العلف</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round(($animalFood - $animalFoodLost), 2) ?> ش</span>
	</span>
	</a>
</div>
<div class="mws-report-container clearfix">
	<h2>أسعار اللبن اليوم</h2>
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">سعر اللبن
				البقري</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round($milkPrice, 2) ?> ج</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">سعر اللبن
				الجاموسي</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px; display: block;"><?php echo round($milkPrice2, 2) ?> ج</span>
	</span>
	</a>
</div>
<div class="mws-report-container clearfix">
	<h2>أسعار العلف اليوم</h2>
	<?php
$allAnimaFood = AnimalFood::getAll('animalfood');
foreach ($allAnimaFood as $item) {
    ?>
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">سعر علف <?php echo $item->name; ?></span>
			<span class="mws-report-value"
			style="font-size: 1.6em; margin-top: 7px; display: block;"><?php echo round($item->buyprice, 2) ?> ج</span>
	</span>
	</a>
	<?php } ?>
</div>