<div class="users row">
    <div class="floatleft mtop10"><h1><?php  echo __('Load Info');?></h1></div>
    <div class="floatright">
        <?php
		echo $this->Html->link('<span>'.__('Back To Manage Loads').'</span>', array('controller' => 'loads','action' => 'index','admin' => true),array('class'=>'black_btn','escape'=>false));?>    </div>
</div>

<div align="center" class="whitebox mtop15 viewMode">

    <table cellspacing="2" cellpadding="7" border="0" align="center">
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Id'); ?></strong></td>
				<td align="left"><?php echo h($data['Load']['id']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Load #'); ?></strong></td>
				<td align="left"><?php echo h($data['Load']['load']); ?></td>
			</tr>
			<!-- 
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Dealer'); ?></strong></td>
				<td align="left"><?php echo h($data['Dealer']['customer_name']); ?></td>
			</tr> 
			-->
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Driver'); ?></strong></td>
				<td align="left"><?php echo h($data['User']['first_name'].' '.$data['User']['last_name']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Shipping date'); ?></strong></td>
				<td align="left"><?php echo h($data['Load']['ship_date']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Delivery date'); ?></strong></td>
				<td align="left"><?php echo h($data['Load']['estdeliverdate']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Status'); ?></strong></td>
				<td align="left"><?php echo ($data['Load']['status'] == 0)? 'Unshipped':'Shipped'; ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Vin list'); ?></strong></td>
				<td align="left">
				<?php 
				foreach ($data['Vin'] as $vin)
				{
					echo h($vin['vin_number'])."<br>";
				}
				?>
				</td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Created'); ?></strong></td>
				<td align="left"><?php echo h($data['Load']['created']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Modified'); ?></strong></td>
				<td align="left"> <?php echo h($data['Load']['modified']); ?> </td>
			</tr>
    </table>

</div>
