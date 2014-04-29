<div class="users row">
    <div class="floatleft mtop10"><h1><?php  echo __('Vin Info');?></h1></div>
    <div class="floatright">
        <?php
		echo $this->Html->link('<span>'.__('Back To Manage Vin').'</span>', array('controller' => 'vins','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>    </div>
</div>

<div align="center" class="whitebox mtop15 viewMode">

    <table cellspacing="2" cellpadding="7" border="0" align="center">
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Id'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['id']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Vin #'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['vin_number']); ?></td>
			</tr>

			 <tr>
				<td align="left"><strong class="upper"><?php echo __('Location'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['location']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Vin So'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['vin_so']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Type'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['type']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Color'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['color']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Created'); ?></strong></td>
				<td align="left"><?php echo h($data['Vin']['created']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Modified'); ?></strong></td>
				<td align="left"> <?php echo h($data['Vin']['modified']); ?> </td>
			</tr>
    </table>

</div>
