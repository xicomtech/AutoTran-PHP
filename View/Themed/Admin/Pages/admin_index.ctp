<?php
$this->Paginator->options(array (
    'update' => '#main-container',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array ('buffer' => true)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array ('buffer' => true)),
));
?><div class="pages index">
    <h2><?php echo __('Manage Pages'); ?></h2>
    <p>
	<?php
//	echo $this->Paginator->counter(array(
//	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
//	));
	?>    </p>
    <p class="top15 gray12"><?php echo $this->Session->flash(); ?></p>
    <div class="row mtop30">
	<?php echo $this->Form->create('Page'); ?>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
            <tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th align="left"><?php echo $this->Paginator->sort('title'); ?></th>
		<th align="left"><?php echo $this->Paginator->sort('slug'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		<th><?php echo $this->Paginator->sort('active'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
		<!--	<th align="center" width="5%">
				<input id="check_all" type="checkbox" name="check_all" value="check_all">
			</th>-->
		</tr>
	    <?php foreach ($pages as $page): ?>
    	    <tr>
				<td align="center" valign="middle"><?php echo h($page['Page']['id']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo ($page['Page']['title']); ?>&nbsp;</td>
				<td align="left" valign="middle"><?php echo ($page['Page']['slug']); ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo h($page['Page']['created']); ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo h($page['Page']['modified']); ?>&nbsp;</td>
				<td align="center" valign="middle"><?php echo $this->Common->status_label($page['Page']['active']); ?>&nbsp;</td>
				<td align="center">
				<?php echo $this->Html->link($this->Html->image('view.gif'), array ('action' => 'view', $page['Page']['id']), array ('escape' => false, 'title' => 'View')); ?>&nbsp;
				<?php echo $this->Html->link($this->Html->image('edit.gif'), array ('action' => 'edit', $page['Page']['id']), array ('escape' => false, 'title' => 'Edit')); ?>&nbsp;
				<?php 
				if( ($page['Page']['id'] != 1) && ($page['Page']['id'] != 2) )
				{
					echo $this->Form->postLink($this->Html->image('trash.gif'), array ('action' => 'delete', $page['Page']['id']), array ('escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $page['Page']['id'])); 
				}
				?>
				</td>
    		</tr>
	    <?php endforeach; ?>
	    <tr align='right'>
		<td colspan="9" align="left" class="bordernone">
		    <div class="floatleft mtop7">            <div class="pagination">
			    <?php
			    echo $this->Paginator->prev('< ' . __('previous'), array (), null, array ('class' => 'prev disabled'));
			    echo $this->Paginator->numbers(array ('separator' => ''));
			    echo $this->Paginator->next(__('next') . ' >', array (), null, array ('class' => 'next disabled'));
			    ?>
			</div>			</div>
		   <!-- <div class="floatright">
			<div class="floatleft">
			    <select name=""  class="select">
				<option value="">Select Option</option>
				<option value="">Delete</option>
			    </select>
			</div>
			<div class="floatleft mleft10">
			    <div class="black_btn2">
				<span class="upper">
				    <input type="submit" value="SUBMIT" name="">
				</span>
			    </div>
			</div>
		    </div>-->
		</td>
	    </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php
echo $this->Js->writeBuffer();
?>
