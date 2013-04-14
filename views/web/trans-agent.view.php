<?php
$item = new AgentTransactionForm("AgentTransaction", "agenttransactions", 
        array(
                "agent_id",
                "quantity",
                "lost",
                "price"
        ), array(
                "agent_id" => "The Agent's name",
                "lost" => "The lost if exists",
                "quantity" => "The Quantity",
                "price" => "The price per kilo"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>التوريد للعملاء</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
		<span class="mws-i-24 i-list">حقول بيانات التوريدات</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>العميل</label>
					<div class="mws-form-item large">
						<select name="agent_id">
						<?php 
						    $types = Agent::getAll("agents");
						    foreach ($types as $type) {
						        echo '<option value="' . $type->id . '"';
						        if($object->agent_id == $type->id) echo ' selected';
						        echo '>' . $type->name . '</option>';
						    }
						?>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label>الكمية المطلوبة</label>
					<div class="mws-form-item large small">
						<input type="text" name="quantity" class="mws-textinput"
							value="<?php Form::_e('quantity', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>الكمية التي وصلت</label>
					<div class="mws-form-item large small">
						<input type="text" name="lost" class="mws-textinput"
							value="<?php Form::_e('lost', $object) ?>">
					</div>
				</div>
				<div class="mws-form-row">
					<label>سعر الكيلو</label>
					<div class="mws-form-item large small">
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
<?php if(!$task) echo AgentTransaction::renderForControl("SELECT * FROM agenttransactions", "AgentTransaction"); ?>