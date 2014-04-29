<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<?php echo $this->Html->charset(); ?>
        <title>
	    <?php echo $title_for_layout; ?>
        </title>
        <script language="javascript">
            var webURL = '<?php echo $params['webURL']; ?>';
            var imgURL = '<?php echo $params['imgURL']; ?>';
        </script>
	<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css('style');
	echo $this->Html->script(array ('jquery.min', 'jquery.validate'));
	if (!empty($params['userInfo']) && $params['userInfo']['id'] == 1)
	{
	    echo $this->Html->css(array ('jqueryui/jquery-ui.custom'));
	    echo $this->Html->script(array ('jquery-ui.custom.min', 'jquery.blockUI','jquery.form','jquery.metadata','jquery.livequery', 'nicedit/nicEdit', 'admin-common'));
	}

	echo $scripts_for_layout;
	?>
<script>
	$(function() {
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
    </head>
    <body>
		<!--Wrapper Start from Here-->
		<div id="wrapper">
			<!--Header Start from Here-->
			<?php 
				echo $this->element('header'); 
				
				if (!empty($params['userInfo']) && $params['userInfo']['id'] == 1)
				{
					echo $this->element('admin-navigation');
				}
			?>

			<!--Header End  Here-->
			<!--Container Start from Here-->
			<div id="container">
				<div id="main-container"><?php echo $content_for_layout; ?> </div>
				<?php echo $this->Html->image('loading.gif', array ('id' => 'busy-indicator', 'style' => 'display:none;')); ?>

				<!--Footer Start from Here-->
				<?php echo $this->element('footer'); ?>

				<!--Footer End  Here-->				
			</div>
			<!--Container end Here-->
			<?php //echo $this->element('sql_dump');  ?>
		</div>
		<!--Wrapper End from Here-->

    </body>
</html>
