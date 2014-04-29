<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Edit Vin'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Vin').'</span>', array('controller' => 'vins','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('Vin');?>
    <?php echo $this->Form->input('id',array('type' => 'hidden'));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">
		<tr>
			<td align="left"><strong class="upper">Load</strong></td>
			<td align="left">	
				<?php
					//~ echo $this->Form->input('load_id',array('type'=>'select','options'=>$loads,'class' => 'u_select required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;','empty'=>'Select'));
					echo $this->request->data['Load']['load'];
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Dealers</strong></td>
            <td align="left">	
				<?php
					echo $this->Form->input('dealer_id',array('class' => 'u_select required', 'empty' => 'Select Dealer', 'label' => false, 'error' => false, 'div' => false,'options'=>$dealers));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Vin number</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('vin_number',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Ldnbr</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('ldnbr',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Ldseq</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('ldseq',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Pro</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('pro',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Ldpos</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('ldpos',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Backdrv</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('backdrv',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Callback</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('callback',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Rldspickup</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('rldspickup',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Bckhlnbr</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('bckhlnbr',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">lot</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('lot',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Rowbay</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('rowbay',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Rte1</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('rte1',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Rte2</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('rte2',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Von</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('von',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Body</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('body',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Weight</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('weight',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Color</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('color',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Colordes</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('colordes',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Type</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('type',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Fillers</strong></td>
			<td align="left">	
				<?php
					echo $this->Form->input('fillers',array('type'=>'text','class' => 'input required', 'label' => false, 'legend' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
				?>
			</td>
		</tr>
		<tr>
			<td align="left"></td>
			<td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->submit(__('Submit'));?></span></div></td>
		</tr>
	</table>
    <?php echo $this->Form->end();?>
    
    
    <?php 
    $vinImages	=	$this->request->data['VinImages'];
    foreach($vinImages	as	$images)
    {
		echo '<img height="100" width="100" style="padding:12px;" src="'.WEBURL.VIN_IMAGES.'/'.$this->request->data['Vin']['load_id'].'/'.$images['image'].'">';
    }
    ?>
    
</div>
<script language="javascript">
    $(document).ready(function() {
        $("#VinAdminEditForm").validate();
    });
</script>
