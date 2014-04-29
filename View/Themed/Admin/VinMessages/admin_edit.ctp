<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Edit Vin Message'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage vin message').'</span>', array('controller' => 'vin_messages','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('VinMessage');?>
    <?php echo $this->Form->input('id',array('type' => 'hidden'));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
		<tr>
			<td align="left"><strong class="upper">Message</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('message',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
				<td align="left"><strong class="upper">Status</strong></td>
				<td align="left">	
					<?php
						$options = array('0'=>'Inctive','1'=>'Active');
						echo $this->Form->input('status',array('type'=>'radio','options'=>$options,'class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
					?>
				</td>
			</tr>
		<tr>
			<td align="left"></td>
			<td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->submit(__('Submit'));?></span></div></td>
		</tr>
	</table>
    <?php echo $this->Form->end();?>
    
</div>
<script language="javascript">
    $(document).ready(function() {
        $("#AreaCodeAdminEditForm").validate();
    });
</script>
