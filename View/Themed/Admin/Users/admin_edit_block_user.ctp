<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Edit Block Users'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'block_user',$user_id,'admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('BlockUser');?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">

        	<?php
				echo $this->Form->input('id',array('type' => 'hidden'));
			?>

                 <tr>
                    <td align="left"><strong class="upper">Message</strong></td>
                    <td align="left">	
                    <?php
						echo $this->Form->input('message',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;','readonly' => 'readonly'));
					?>
                    </td>
                </tr>
                                <tr>
                    <td align="left"><strong class="upper">Admin Message</strong></td>
                    <td align="left">	
                    <?php
						echo $this->Form->input('admin_message',array('class' => 'input', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
					?>
                    </td>
                </tr>
                                <tr>
                    <td align="left"><strong class="upper">Status</strong></td>
                    <td align="left">	<?php
						echo $this->Form->input('status',array('type' => 'select','options'=>array('1'=>'Block','0'=>'Un-Block'), 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
					?>
                    </td>
                </tr>
  
				<tr>
                    <td align="left"></td>
                    <td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->end(__('Submit'));?></span></div></td>
                </tr>
    </table>
    
</div>
