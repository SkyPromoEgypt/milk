<?php
$item = new Form("Farmer", "farmers", 
        array(
                "name",
                "specialprice",
                "notes",
                "status"
        ), 
        array(
                "name" => "The farmer's name",
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>المزارعين</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">حقول بيانات المزارعين</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>اسم المزارع</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>سعر خاص</label>
					<div class="mws-form-item small">
						<input type="text" name="specialprice" class="mws-textinput"
							value="<?php Form::_e('specialprice', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>ملاحظات</label>
					<div class="mws-form-item large">
						<textarea cols="100%" rows="100%" name="notes"><?php Form::_e('notes', $object) ?></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label>الملف مفعل ؟</label>
					<div class="mws-form-item clearfix">
						<ul class="mws-form-list inline">
							<li><input type="radio" name="status" value="1"
								<?php if($object->status == 1) echo 'checked' ?>> <label>
									المزارع يتعامل مع المركز</label></li>
							<li><input type="radio" name="status" value="0"
								<?php if($object->status == 0) echo 'checked' ?>> <label>
									المزارع لا يتعامل مع المركز حاليا</label></li>
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
<?php if(!$task) echo Farmer::renderForControl("SELECT * FROM farmers", "Farmer"); ?>