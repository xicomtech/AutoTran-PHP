<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Edit Dealer'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Dealer').'</span>', array('controller' => 'dealers','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('Dealer');?>
    <?php echo $this->Form->input('id',array('type' => 'hidden'));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
		<tr>
			<td align="left"><strong class="upper">MFG</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('mfg',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Shop to customer</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('shptocust',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Customer name</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('customer_name',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">City</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('city',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">State</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('state',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Address</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('address',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Zip</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('zip',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Monday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('monam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Tuesday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('tueam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Wednesday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('wedam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Thursday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('thuam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Friday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('friam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Saturday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('satam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Sunday AM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('sunam',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Monday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('monpm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Tuesday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('tuepm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Wednesday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('wedpm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Thursday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('thupm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Friday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('fripm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Saturday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('satpm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Sunday PM</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('sunpm',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">After hour</strong></td>
			<td align="left">	
				<?php
					$options = array('N'=>'No','Y'=>'Yes');
					echo $this->Form->input('afthr',array('type'=>'radio','options'=>$options,'class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Comments</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('comments',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
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
        $("#DealerAdminEditForm").validate();
    });
</script>
