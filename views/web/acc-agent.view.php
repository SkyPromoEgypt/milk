<?php
$item = new AccountingAgentForm("AccountingAgent", "accountingagent", 
        array(
                "agent_id",
                "paid"
        ), array(
                "paid" => "المبلغ المدفوع"
        ), "/" . Helper::getView());

$task = $item->getTask();
$object = $item->getElement();
$item->process();
Messenger::appMessenger();
?>
<h1>حساب عميل</h1>
<?php if($task && $task != "delete"): ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">محاسبة عميل</span>
	</div>
	<div class="mws-panel-body">
		<form class="mws-form" method="post">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label>العميل</label>
					<div class="mws-form-item large">
						<select name="agent_id">
						<?php 
						    $agents = Agent::getAll("agents");
						    foreach ($agents as $agent) {
						        echo '<option value="' . $agent->id . '"';
						        if($object->agent_id == $agent->id) echo ' selected';
						        echo '>' . $agent->name . '</option>';
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
<?php if(!$task) echo AccountingAgent::renderForControl("SELECT * FROM accountingagent", "AccountingAgent"); ?>