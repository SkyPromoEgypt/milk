<?php
$item = new Form("Agent", "agents", 
        array(
                "name",
                "address",
                "phone",
                "notes",
                "status"
        ), 
        array(
               	  "name" => "The agent's name",
                "address" => "The agent's address",
                "phone" => "The agent's phone",
                "notes" => "The agent's notes"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>العملاء</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">حقول بينات العملاء</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>اسم العميل</label>
					<div class="mws-form-item large">
						<input type="text" name="name" class="mws-textinput"
							value="<?php Form::_e('name', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>عنوان العميل</label>
					<div class="mws-form-item large">
						<input type="text" name="address" class="mws-textinput"
							value="<?php Form::_e('address', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>رقم هاتف العميل</label>
					<div class="mws-form-item large">
						<input type="text" name="phone" class="mws-textinput"
							value="<?php Form::_e('phone', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>ملاحظات</label>
					<div class="mws-form-item large">
						<textarea cols="100%" rows="100%" name="notes"><?php Form::_e('notes', $object) ?></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label>العميل يتعامل مع المركز</label>
					<div class="mws-form-item clearfix">
						<ul class="mws-form-list inline">
							<li><input type="radio" name="status" value="1"
								<?php if($object->status == 1) echo 'checked' ?>> <label>نعم</label></li>
							<li><input type="radio" name="status" value="0"
								<?php if($object->status == 0) echo 'checked' ?>> <label>لا</label></li>
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
<?php if(!$task) echo Agent::renderForControl("SELECT * FROM agents", "Agent"); ?>
