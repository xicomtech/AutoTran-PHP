<div class="users row">
    <div class="floatleft mtop10"><h1><?php  echo __('User Info');?></h1></div>
    <div class="floatright">
        <?php
		echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'manage','admin' => true),array('class'=>'black_btn','escape'=>false));?>    </div>
</div>

<div align="center" class="whitebox mtop15 viewMode">

    <table cellspacing="2" cellpadding="7" border="0" align="center">
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Id'); ?></strong></td>
				<td align="left"><?php echo h($user['User']['id']); ?></td>
			</tr>
			<?php
				if ( $user['User']['id'] != $this->Session->read('Auth.User.id') ) 
				{
			?>
				<tr>
					<td align="left"><strong class="upper"><?php echo __('User type'); ?></strong></td>
					<td align="left"><?php echo h(ucfirst($user['User']['user_type'])); ?></td>
				</tr>
				<tr>
					<td align="left"><strong class="upper"><?php echo __('User id'); ?></strong></td>
					<td align="left"><?php echo h($user['User']['user_id']); ?></td>
				</tr>
			<?php
				}
			?>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Email'); ?></strong></td>
				<td align="left"><?php echo h($user['User']['email']); ?></td>
			</tr>

			 <tr>
				<td align="left"><strong class="upper"><?php echo __('First Name'); ?></strong></td>
				<td align="left"><?php echo h($user['User']['first_name']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Last Name'); ?></strong></td>
				<td align="left"><?php echo h($user['User']['last_name']); ?></td>
			</tr>
			
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Created'); ?></strong></td>
				<td align="left"><?php echo h($user['User']['created']); ?></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Modified'); ?></strong></td>
				<td align="left"> <?php echo h($user['User']['modified']); ?> </td>
			</tr>
			<tr>
				<td align="left"><strong class="upper"><?php echo __('Active'); ?></strong></td>
				<td align="left"><?php echo ($user['User']['status'] == 1) ? 'Active' : 'Inactive' ?></td>
			</tr>
    </table>

</div>
