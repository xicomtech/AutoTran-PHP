<?php
$this->Paginator->options(array (
    'update' => '#main-container',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array ('buffer' => true)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array ('buffer' => true)),
));
?>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Manage Load'); ?></h1></div>
    <div class="floatright">
        <?php echo $this->Html->link('<span>' . __('Create & assign load') . '</span>', array('controller' => 'loads', 'action' => 'create', 'admin' => true), array('class' => 'black_btn', 'escape' => false)); ?>            </div>
</div>
<div class="users index">
	<p class="top15 gray12"><?php echo $this->Session->flash(); ?></p>
	<div class="row mtop15">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tr valign="top">
			  <td align="left" class="searchbox">
				<div class="floatleft">
				<?php
				echo $this->Form->create(
					null, array(
						'url' => array(
							'controller' => 'loads', 
							'action' => 'admin_index'),
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
							<strong><?php echo __('Load # :'); ?></strong>
								<?php
								if ( !empty($this->request->query['keyword']) )
								{
									$value = $this->request->query['keyword'];
								}
								else
								{
									$value = '';
								}
								echo $this->Form->input(null, array(
										'type'=>'text',
										'name'=>'keyword',
										'class' => 'input',
										'id' => 'userEmail',
										'style' => 'width: 300px;',
										'value' => $value
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
	
    <div class="row mtop30">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('load_number','Load Number'); ?></th>
			<!-- <th align="left"><?php echo $this->Paginator->sort('dealer_id', 'Dealer'); ?></th> -->
			<th align="center">View Vins</th>
			<th align="left"><?php echo $this->Paginator->sort('user_id', 'Driver'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('ship_date', 'Ship Date'); ?></th>
			<th align="left" class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	    <?php
		if ( $loads )
		{
			foreach ($loads as $load):
		?>
    	    <tr>
				<td align="center" valign="middle"><?php echo h($load['Load']['id']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo h($load['Load']['load']); ?>&nbsp;</td>
				<!-- <td align="left" valign="middle"><?php echo h($load['Dealer']['customer_name']); ?></td>  -->
				<td align = "center"><?php echo $this->Html->link('View Vins', array('controller' => 'vins', 'action' => 'view_vin', $load['Load']['id']));?></td>
				<td align="left" valign="middle"><?php echo h($load['User']['full_name']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo date('Y-m-d', strtotime($load['Load']['ship_date'])); ?>&nbsp;</td>
				<td align="left">
				<?php echo $this->Html->link($this->Html->image('view.gif'), array ('action' => 'view', $load['Load']['id']), array ('escape' => false, 'title' => 'View User Detail')); ?>&nbsp;
				<?php echo $this->Html->link($this->Html->image('edit.gif'), array ('action' => 'edit', $load['Load']['id']), array ('escape' => false, 'title' => 'Edit User Detail')); ?>&nbsp;
				<?php echo $this->Html->link($this->Html->image('trash.gif'), array ('action' => 'delete', $load['Load']['id']), array ('escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete vin# %s?', $load['Load']['load'] ));  ?>&nbsp;
			 </tr>
	    <?php
			endforeach;
		}
		else
		{
		?>
			<tr align='center'>
				<td colspan="10" align="center" class="bordernone">
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
