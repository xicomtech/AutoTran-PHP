<?php $this->Html->script(array('ckeditor/ckeditor'), array('inline'=>false));?>
<div class="pages row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Add Page'); ?></h1></div>
    <div class="floatright">
	<?php
	echo $this->Html->link('<span>' . __('Back To Manage Page') . '</span>', array ('controller' => 'pages', 'action' => 'index', 'admin' => true), array ('class' => 'black_btn', 'escape' => false));
	?>
	</div>
	<div class="errorMsg"><?php echo $this->element('validations'); ?></div>
</div>

<div align="center" class="whitebox mtop15">
    <?php echo $this->Form->create('Page'); ?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">

	<tr>
	    <td align="left"><strong class="upper">Title</strong></td>
	    <td align="left">	<?php
    echo $this->Form->input('title', array ('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
    ?>
	    </td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper">Slug</strong></td>
	    <td align="left">	<?php
		echo $this->Form->input('slug', array ('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
    ?>
	    </td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper">Body</strong></td>
	    <td align="left">	<?php
		echo $this->Form->input('body', array ('class' => 'input required','type'=>'textarea' , 'style' => "width: 600px; height: 200px;", 'label' => false, 'error' => false, 'div' => false));
    ?>
	    </td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper">Meta Title</strong></td>
	    <td align="left">	<?php
		echo $this->Form->input('meta_title', array ('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
    ?>
	    </td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper">Meta Description</strong></td>
	    <td align="left">	<?php
		echo $this->Form->input('meta_description', array ('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
    ?>
	    </td>
	</tr>
	<tr>
	    <td align="left"><strong class="upper">Meta Keywords</strong></td>
	    <td align="left">	<?php
		echo $this->Form->input('meta_keywords', array ('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
    ?>
	    </td>
	</tr>
       <tr>
            <td align="left"><strong class="upper">Active</strong></td>
            <td align="left">	<?php
		echo $this->Form->input('active', array ('class' => 'input required', 'options' => $this->Common->statusTypes(), 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 463px;'));
    ?>
            </td>
        </tr>
		<tr>
            <td align="left"></td>
            <td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->end(__('Submit')); ?></span></div></td>
        </tr>
            
    </table>
    
    
</div>
<script>

	CKEDITOR.replace( 'PageBody' ,
	{
		 filebrowserBrowseUrl :'<?php echo WEBURL?>js/ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo WEBURL?>js/ckeditor/filemanager/connectors/php/connector.php',
		filebrowserImageBrowseUrl : '<?php echo WEBURL?>js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo WEBURL?>js/ckeditor/filemanager/connectors/php/connector.php',
		filebrowserFlashBrowseUrl :'<?php echo WEBURL?>js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo WEBURL?>js/ckeditor/filemanager/connectors/php/connector.php',
		filebrowserUploadUrl  :'<?php echo WEBURL?>js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
		filebrowserImageUploadUrl : '<?php echo WEBURL?>js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
		filebrowserFlashUploadUrl : '<?php echo WEBURL?>js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
	});
	
</script>
