<div id="header">
    <div id="head_lt">
        <!--Logo Start from Here-->
        <span class="floatleft">
	    <?php
	    echo $this->Html->link($this->Html->image('logo.png',array('width'=>'137px','height'=>'27px','border'=>0)), array ('controller' => 'users', 'action' => 'index', 'admin' => true), array ('escape' => false));
	    ?>
        </span><span class="slogan">administration suite</span>
        <!--Logo end  Here-->
    </div>
    <?php if (!empty($params['userInfo']))
    { ?>
        <div id="head_rt">
    	Welcome <span><?php echo $params['userInfo']['first_name'] . '&nbsp;' . $params['userInfo']['last_name']; ?></span>
	<?php echo date('d M, Y h:i A'); ?>
        </div>
<?php } ?>
    <!--15 Apr, 2011 12:46 PM -->
</div>
