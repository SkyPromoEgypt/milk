<?php
$item = new Form("Milk", "milk", 
        array(
                "name",
                "price"
        ), 
        array(
               	"name" => "The Items's name",
                "price" => "The Items's price"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>أنواع اللبن</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">حقول بيانات انواع اللبن</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>نوع اللبن</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
			</div>
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>سعر اللبن</label>
					<div class="mws-form-item small">
						<input type="text" name="price" class="mws-textinput"
							value="<?php Form::_e('price', $object) ?>">
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
<?php if(!$task) echo Milk::renderForControl("SELECT * FROM milk", "Milk"); ?>