<?php
//~ pr($data);
?>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Create load & assign vin to load'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Vin').'</span>', array('controller' => 'loads','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('Load',array('noValidate'=>true));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
                    <td align="left"><strong class="upper">Truck #</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('truck_number',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
						?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Shipping address</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('ship_address',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
						?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Shipping date</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('ship_date',array('type'=>'text','class' => 'input required datepicker', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;','readonly'=>true));
						?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Vin List</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('vin_list',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false,'options'=>$vins,'multiple'=>true,'style'=>'width: 400px'));
						?>
                    </td>
                </tr>
                <!-- <tr>
                    <td align="left"><strong class="upper">Drivers</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('user_id',array('class' => 'u_select required', 'empty' => 'Select Driver', 'label' => false, 'error' => false, 'div' => false,'options'=>$users));
						?>
                    </td>
                </tr> -->
				<tr>
                    <td align="left"></td>
                    <td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->end(__('Submit'));?></span></div></td>
                </tr>
    </table>
    
</div>
<script language="javascript">
    $(document).ready(function() {
        $("#LoadAdminCreateForm").validate();
    });
</script>
