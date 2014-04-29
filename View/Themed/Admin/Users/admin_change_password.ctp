
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Change Password'); ?></h1></div>
    <div class="floatright">
        <?php echo $this->Html->link('<span>' . __('Back To Dashboard') . '</span>', array('controller' => 'users', 'action' => 'index', 'admin' => true), array('class' => 'black_btn', 'escape' => false)); ?>            </div>
</div>

<div align="center" class="whitebox mtop15">
<p class="top15 gray12"><?php echo $this->Session->flash(); ?></p>
    <?php
    //echo $this->Form->create('User');
    echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'change_password', 'admin' => true), 'type' => 'post'));
    ?>

    <table cellspacing="0" cellpadding="7" border="0" align="center">

        <?php
        echo $this->Form->input('id', array('type' => 'hidden'));
        ?>

        <tr>
            <td align="left"><strong class="upper">New Password</strong></td>
            <td align="left">	<?php
        echo $this->Form->input('password', array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
        ?>
            </td>
        </tr>
        <tr>
            <td align="left"><strong class="upper">Confirm New Password</strong></td>
            <td align="left">	<?php
        echo $this->Form->input('confirm_password', array('class' => 'input required', 'type' => 'password', 'label' => false, 'equalTo' => '#UserPassword', 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
        ?>
            </td>
        </tr>
		<tr>
            <td align="left"></td>
            <td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->end('Change Password'); ?></span></div></td>
        </tr>
    </table>

</div>
