<?php
$this->Paginator->options(array (
    'update' => '#main-container',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array ('buffer' => true)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array ('buffer' => true)),
));
?>

<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Block Users'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To User List').'</span>', array('controller' => 'users','action' => 'manage','admin' => true),array('class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>
<div class="users index">
    <h2><?php echo __('Manage Users'); ?></h2>
	<p class="top15 gray12"><?php echo $this->Session->flash(); ?></p>
	<?php /* <div class="row mtop15">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tr valign="top">
			  <td align="left" class="searchbox">
				<div class="floatleft">
				<?php
				echo $this->Form->create(
					null, array(
						'url' => array(
							'controller' => 'users', 
							'action' => 'admin_manage'),
							'inputDefaults' => array(
									'label' => false,
									'div' => false
								),
						'type' => 'get'
					)
				);
				?>
					<table cellspacing="0" cellpadding="4" border="0">
						<tr valign="top">
							<td valign="middle" align="left" >
							<strong><?php echo __('Email id / Name :'); ?></strong>
								<?php
								if ( !empty($this->request->query['email']) )
								{
									$valueEmail = $this->request->query['email'];
								}
								else
								{
									$valueEmail = '';
								}
								echo $this->Form->input(null, array(
										'type'=>'text',
										'name'=>'email',
										'class' => 'input',
										'id' => 'userEmail',
										'style' => 'width: 300px;',
										'value' => $valueEmail
								));
								?>
							</td>
							<td valign="middle" align="left">
								<div class="black_btn2 mtop15">
									<span class="upper">
										<input type="submit" value="Search" name="">
									</span>
								</div>
							</td>
						</tr>
					</table>
				<?php
				echo $this->Form->end();
				?>
				</div>
			</td>
		  </tr>
		</table>
	</div>
	*/ ?>
    <div class="row mtop30">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('email'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('first_name', 'First Name'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('last_name', 'Last Name'); ?></th>
			<th><?php echo $this->Paginator->sort('Message'); ?></th>
			<th><?php echo $this->Paginator->sort('Status'); ?></th>
			<th align="left" class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	    <?php
		if ( $users )
		{
			foreach ($users as $user):
		?>
    	    <tr>
				<td align="center" valign="middle"><?php echo h($user['User']['id']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo h($user['User']['email']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo h($user['BlockUser']['message']); ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo ($user['BlockUser']['status'] == 1) ? 'Blocked' : 'UnBlocked' ?>&nbsp;</td>
				<td align="left">				
				<?php echo $this->Html->link($this->Html->image('edit.gif'), array ('action' => 'edit_block_user', $user['BlockUser']['id'],$id), array ('escape' => false, 'title' => 'Edit User Detail')); ?>&nbsp;
				</td>
			 </tr>
	    <?php
			endforeach;
		}
		else
		{
		?>
			<tr align='center'>
				<td colspan="7" align="center" class="bordernone">
					<strong>No Record Found</strong>
				</td>
			</tr>
		<?php
		}
		?>
	    <tr align='right'>
		<td colspan="11" align="left" class="bordernone">
		    <div class="floatleft mtop7">
				<div class="pagination">
					<?php
					echo $this->Paginator->prev('< ' . __('previous'), array (), null, array ('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array ('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array (), null, array ('class' => 'next disabled'));
					?>
				</div>
			</div>
		</td>
	    </tr>
        </table>
	</div>


</div>
<?php
echo $this->Js->writeBuffer();
?>
