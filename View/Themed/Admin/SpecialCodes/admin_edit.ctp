<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Edit Special code'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Special code').'</span>', array('controller' => 'special_codes','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('SpecialCode');?>
    <?php echo $this->Form->input('id',array('type' => 'hidden'));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
		<tr>
			<td align="left"><strong class="upper">Description</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('description',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Area code</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('area_code',array('type'=>'select', 'options'=>$areacodes,'class' => 'u_select', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;','empty'=>'Select'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Type code</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('type_code',array('type'=>'select', 'options'=>$typecodes,'class' => 'u_select', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;','empty'=>'Select'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Severity code</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('severity_code',array('type'=>'select', 'options'=>$severitycodes,'class' => 'u_select', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;','empty'=>'Select'));
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
