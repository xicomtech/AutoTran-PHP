<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Add User'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'manage','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('User');?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
                 <tr>
                    <td align="left"><strong class="upper">User Type</strong></td>
                    <td align="left">	
                    <?php
						$options = array('driver'=>'Driver', 'dealer'=>'Dealer', 'supervisor'=>'Supervisor');
						echo $this->Form->input('user_type',array('class' => 'u_select required', 'label' => false, 'error' => false, 'empty' => 'Select Type', 'div' => false, 'options'=>$options));
					?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">User Id</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('user_id',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
						?>
                    </td>
                </tr>
                <tr>
                    <td align="left"><strong class="upper">Email</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('email',array('type'=>'text','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
						?>
                    </td>
                </tr>
				<tr>
                    <td align="left"><strong class="upper">First Name</strong></td>
                    <td align="left">	<?php
		echo $this->Form->input('first_name',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
	?>
                    </td>
                </tr>
				<tr>
                    <td align="left"><strong class="upper">Last Name</strong></td>
                    <td align="left">	<?php
		echo $this->Form->input('last_name',array('class' => 'input', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
	?>
                    </td>
                </tr>
                </tr>
				<tr>
                    <td align="left"><strong class="upper">Status</strong></td>
                    <td align="left">	
                    <?php
						$options = array('0'=>'Inactive','1'=>'Active');
						echo $this->Form->input('status',array('class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false, 'options'=>$options,'default'=>1));
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
