<?php
//~ pr($data);
?>
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
                    <td align="left"><strong class="upper">Vin List</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('vin_list',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false,'options'=>$vins,'multiple'=>true,'style'=>'width: 100px'));
						?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">User List</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('user_id',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false,'options'=>$users));
						?>
                    </td>
                </tr>
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
