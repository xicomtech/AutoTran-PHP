<div class="pages row">
    <div class="floatleft mtop10"><h1><?php echo __('Page'); ?></h1></div>
    <div class="floatright">
	<?php echo $this->Html->link('<span>' . __('Back To Manage Page') . '</span>', array ('controller' => 'pages', 'action' => 'index', 'admin' => true), array ('class' => 'black_btn', 'escape' => false)); ?>    </div>
</div>

<div align="center" class="whitebox mtop15 viewMode">

    <table cellspacing="2" cellpadding="7" border="0" align="center">
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Id'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['id']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Title'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['title']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Slug'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['slug']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Body'); ?></strong></td>
	    <td align="left"><?php echo $page['Page']['body']; ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Meta Title'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['meta_title']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Meta Description'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['meta_description']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Meta Keywords'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['meta_keywords']); ?></td>
	</tr>
<tr>
	    <td align="left"><strong class="upper"><?php echo __('Created'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['created']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Modified'); ?></strong></td>
	    <td align="left"><?php echo h($page['Page']['modified']); ?></td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper"><?php echo __('Active'); ?></strong></td>
	    <td align="left"><?php echo $this->Common->status_label($page['Page']['active']); ?></td>
	</tr>

    </table>

</div>







