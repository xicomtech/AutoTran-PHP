<?php
$this->Paginator->options(array (
    'update' => '#main-container',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array ('buffer' => true)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array ('buffer' => true)),
));
?>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Load Vins Detail'); ?></h1></div>
    <div class="floatright">        
        <?php echo $this->Html->link('<span>' . __('Back To Loads') . '</span>', array('controller' => 'loads', 'action' => 'index', 'admin' => true), array('class' => 'black_btn', 'escape' => false)); ?>
    </div>
</div>
<div class="users index">
	<p class="top15 gray12"><?php echo $this->Session->flash(); ?></p>
    <div class="row mtop30">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		<tr>			
			<th align="left">Vin Number</th>
			<th align="left">Status</th>
		</tr>
	    <?php
	    
		if ( $vins )
		{
			foreach ($vins as $vin)
			{
		?>
    	    <tr>				
				<td align="left" valign="middle"><?php echo h($vin['Vin']['vin_number']); ?>&nbsp;</td>
				<td align="left" valign="middle">
					<?php 
						if ($vin['Vin']['status'] == 0)
						{
							echo '<strong style = "color:Brown;">Not Loaded</strong>';	
						}
						else if ($vin['Vin']['status'] == 1)
						{
							echo '<strong style = "color:green;">Loaded</strong>';
						}
						else if ($vin['Vin']['status'] == 2)
						{
							echo $this->Html->link('<strong style = "color:red;">Rejected</strong>', array('controller' => 'vins', 'action' => 'confirm_vin', $load_id, $vin['Vin']['id']), array('title' => 'Click to loaded Vin', 'escape' => false), __('Are you sure you want to confirm the vin# %s?', $vin['Vin']['vin_number'] ));
						}
						else
						{
							echo '<strong style = "color:blue;">Delivered</strong>';	
						}	
					?>
				</td>				
			 </tr>
	    <?php	
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
