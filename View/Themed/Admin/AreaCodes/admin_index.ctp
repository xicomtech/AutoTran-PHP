<?php
$this->Paginator->options(array (
    'update' => '#main-container',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array ('buffer' => true)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array ('buffer' => true)),
));
?>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Manage Area Code'); ?></h1></div>
    <div class="floatright">
        <?php echo $this->Html->link('<span>' . __('Upload area code csv') . '</span>', array('controller' => 'area_codes', 'action' => 'csv_upload', 'admin' => true), array('class' => 'black_btn', 'escape' => false)); ?>
    </div>
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
							'controller' => 'area_codes', 
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
							<strong><?php echo __('Code :'); ?></strong>
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
			<th align="left"><?php echo $this->Paginator->sort('group', 'Group'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('code', 'Code'); ?></th>
			<th align="left"><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th align="left" class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	    <?php
		if ( $data )
		{
			foreach ($data as $result)
			{
		?>
    	    <tr>
				<td align="center" valign="middle"><?php echo h($result['AreaCode']['id']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo h($result['AreaCode']['group']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo h($result['AreaCode']['code']); ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo ($result['AreaCode']['status'] == 1)? 'Active':'Inactive'; ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo h($result['AreaCode']['created']); ?>&nbsp;</td>
				<td align="left">
				<?php echo $this->Html->link($this->Html->image('edit.gif'), array ('action' => 'edit', $result['AreaCode']['id']), array ('escape' => false, 'title' => 'Edit User Detail')); ?>&nbsp;
				<?php echo $this->Html->link($this->Html->image('trash.gif'), array ('action' => 'delete', $result['AreaCode']['id']), array ('escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete top level area %s with child codes?', $result['AreaCode']['group'] ));  ?>&nbsp;
			 </tr>
			 <?php
			 
				 if ( count($result['child']) > 0)
				 {
					 foreach ($result['child'] as $child_result)
					 {
			 ?>
					<tr>
						<td align="center" valign="middle"><?php echo h($child_result['id']); ?>&nbsp;</td>
						<td align="left" valign="middle"> - <?php echo h($child_result['description']); ?>&nbsp;</td>
						<td align="left" valign="middle"><?php echo h($child_result['code']); ?>&nbsp;</td>
						<td align="center" valign="middle"><?php echo ($child_result['status'] == 1)? 'Active':'Inactive'; ?>&nbsp;</td>
						<td align="center" valign="middle"><?php echo h($child_result['created']); ?>&nbsp;</td>
						<td align="left">
						<?php echo $this->Html->link($this->Html->image('edit.gif'), array ('action' => 'edit', $child_result['id']), array ('escape' => false, 'title' => 'Edit User Detail')); ?>&nbsp;
						<?php echo $this->Html->link($this->Html->image('trash.gif'), array ('action' => 'delete', $child_result['id']), array ('escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete code# %s?', $child_result['code'] ));  ?>&nbsp;
					</tr>
	    <?php
					}
				}
			}
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
