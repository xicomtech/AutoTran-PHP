<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Add area code'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Area Codes').'</span>', array('controller' => 'area_codes','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('AreaCode',array('type'=>'file'));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
                <tr>
                    <td align="left"><strong class="upper">Upload csv</strong></td>
                    <td align="left">	
						<?php
							echo $this->Form->input('file',array('type'=>'file','class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
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
