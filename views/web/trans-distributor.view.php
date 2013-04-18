<?php
if (isset($_POST['save'])) {
    
    global $dbh;
    
    $today = date("Y-m-d");
    
    $stmt = $dbh->prepare(
            "INSERT INTO distribution SET farmer_id = :farmer, quantity = :quantity, price = :price, created = :today, thetime = :time");
    
    for ($i = 0; $i < count($_POST['farmer']); $i ++) {
        
        // Get The Store
        $store = Store::getStore();
        
        // Get The Farmer
        $farmer = Farmer::read(
                "SELECT * FROM farmers WHERE id = " . $_POST['farmer'][$i], 
                PDO::FETCH_CLASS, "Farmer");
        
        $milk = 0;
        
        // Check the morning entry
        if ($_POST['mquantity'][$i] &&
                 ! Distribution::hasTodayEntry($_POST['farmer'][$i])) {
            $farmerArray = array();
            $farmerArray['farmer'] = $_POST['farmer'][$i];
            $farmerArray['time'] = 1;
            $farmerArray['quantity'] = $_POST['mquantity'][$i];
            $farmerArray['today'] = $today;
            
            // Determine Price
            $price = 0;
            if ($_POST['mprice'][$i]) {
                $price = $_POST['mprice'][$i];
            } elseif ($farmer->specialprice != 0) {
                $price = $farmer->specialprice;
            } else {
                $price = Milk::getBuyPrice();
            }
            $farmerArray['price'] = $price;
            
            if ($stmt->execute($farmerArray)) {
                if ($farmer->tohim <= 0 && $farmer->onhim >= 0) {
                    $farmer->onhim -= $farmerArray['quantity'] * $price;
                    if ($farmer->onhim < 0) {
                        $farmer->tohim += abs($farmer->onhim);
                        $farmer->onhim = 0;
                    }
                } elseif ($farmer->tohim >= 0 && $farmer->onhim <= 0) {
                    $farmer->tohim += $farmerArray['quantity'] * $price;
                }
                $milk += $farmerArray['quantity'];
                $farmer->save();
            }
        }
        
        // Check the night entry
        if ($_POST['equantity'][$i] &&
                 ! Distribution::hasTodayEntry($_POST['farmer'][$i], false)) {
            $farmerArray = array();
            $farmerArray['farmer'] = $_POST['farmer'][$i];
            $farmerArray['time'] = 2;
            $farmerArray['quantity'] = $_POST['equantity'][$i];
            $farmerArray['today'] = $today;
            
            // Determine Price
            $price = 0;
            if ($_POST['eprice'][$i]) {
                $price = $_POST['eprice'][$i];
            } elseif ($farmer->specialprice != 0) {
                $price = $farmer->specialprice;
            } else {
                $price = Milk::getBuyPrice();
            }
            $farmerArray['price'] = $price;
            
            if ($stmt->execute($farmerArray)) {
                if ($farmer->tohim <= 0 && $farmer->onhim >= 0) {
                    $farmer->onhim -= $farmerArray['quantity'] * $price;
                    if ($farmer->onhim < 0) {
                        $farmer->tohim += abs($farmer->onhim);
                        $farmer->onhim = 0;
                    }
                } elseif ($farmer->tohim >= 0 && $farmer->onhim <= 0) {
                    $farmer->tohim += $farmerArray['quantity'] * $price;
                }
                $milk += $farmerArray['quantity'];
                $farmer->save();
            }
        }
        
        if ($milk != 0) {
            $store->milk += $milk;
            $store->save();
        }
    }
}

$morning = Distribution::getMilkQuantities();
$night = Distribution::getMilkQuantities(false);
?>
<div class="mws-report-container clearfix">
	<a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">تاريخ اليوم</span>
			<span class="mws-report-value" style="margin-top: 7px;"><?php echo date("Y/m/d"); ?></span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				صباحا</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;"><?php echo !$morning ? 0 : round($morning, 2); ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				مساءا</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;"><?php echo !$night ? 0 : round($night,2); ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الاجمالي
				الخاص باليوم</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;"><?php $total = $morning + $night; echo round($total, 2); ?> ك</span>
	</span>
	</a> <a class="mws-report" href="#"> <span
		class="mws-report-icon mws-ic ic-building"></span> <span
		class="mws-report-content"> <span class="mws-report-title">الموجود
				فعليا بالمخرن</span> <span class="mws-report-value"
			style="font-size: 1.8em; margin-top: 7px;"><?php $instore = Store::getStore()->milk; echo round($instore, 2) ?> ك</span>
	</span>
	</a>
</div>
<h3>
	<a href="/trans-distreport" style="text-decoration: none;"
		class="mws-tooltip-n mws-button blue">تعديل كميات اليوم</a>
</h3>
<form action="" method="post" autocomplete="off">
    <?php echo Distribution::renderForControl("SELECT * FROM farmers WHERE status = 1", "Farmer"); ?>
    <input type="submit" name="save" value="حفظ">
</form>