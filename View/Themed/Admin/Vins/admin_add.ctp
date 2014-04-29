<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Add Vin'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Vin').'</span>', array('controller' => 'vins','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('Vin');?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
                <tr>
                    <td align="left"><strong class="upper">Vin #</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('vin_number',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
						?>
                    </td>
                </tr>
                 <tr>
                    <td align="left"><strong class="upper">Dealers</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('dealer_id',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false,'options'=>$dealers,'style'=>'width: 400px','empty'=>'Select Dealer'));
						?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Location</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('location',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
						?>
                    </td>
                </tr>
				<tr>
                    <td align="left"><strong class="upper">Vin So</strong></td>
                    <td align="left">	<?php
		echo $this->Form->input('vin_so',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
	?>
                    </td>
                </tr>
				<tr>
                    <td align="left"><strong class="upper">Type</strong></td>
                    <td align="left">	<?php
		echo $this->Form->input('type',array('class' => 'input', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
	?>
                    </td>
                </tr>
                </tr>
				<tr>
                    <td align="left"><strong class="upper">Color</strong></td>
                    <td align="left">	
                   <?php
		echo $this->Form->input('color',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
	?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Weight</strong></td>
                    <td align="left">	
                   <?php
		echo $this->Form->input('weight',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
	?>
                    </td>
                </tr>
<!--
                <tr>
                    <td align="left"><strong class="upper">Assigned to driver?</strong></td>
                    <td align="left">	
                   <?php
						$options = array('0'=>'No','1'=>'Yes');
						echo $this->Form->input('is_assigned',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false, 'options'=>$options));
					?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Delivered?</strong></td>
                    <td align="left">	
                   <?php
						$options = array('0'=>'No','1'=>'Yes');
						echo $this->Form->input('is_delivered',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false, 'options'=>$options));
					?>
                    </td>
                </tr>
-->
  
				<tr>
                    <td align="left"></td>
                    <td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->end(__('Submit'));?></span></div></td>
                </tr>
    </table>
    
</div>
<script language="javascript">
    $(document).ready(function() {
        $("#UserAdminAddForm").validate();
    });
</script>
