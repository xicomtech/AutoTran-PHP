<div id="login-box">
    <div class="white-box" style="width:325px; padding-top:60px;">
        <div class="tl">
            <div class="tr">
                <div class="tm">&nbsp;</div>
            </div>
        </div>
        <div class="ml">
            <div class="mr">
                <div class="middle">
                    <div class="lb-data">
                        <h1><?php echo __('User Admin Login'); ?> </h1>
                        <p class="top15 gray12"><?php echo $this->Session->flash(); ?></p>
                        <?php echo $this->Form->create('user', array('action' => 'login', 'name' => 'frmLogin', 'id' => 'login-form', 'class' => '')); ?>
                        <p class="top30"><span class="login_field">
                            <?php echo $this->Form->input('User.email', array('placeholder' => 'Email', 'class' => 'inpt required', 'label' => false, 'error' => false, 'div' => false, 'onblur' => "if(this.value=='')this.value='Username'; this.className='inpt'", 'onfocus' => "if(this.value=='Username')this.value=''; this.className='inpt_f'")); ?> </p>
                        </span></p>
                        <p class="top15"><span class="login_field">
                                <?php echo $this->Form->input('User.password', array('placeholder' => 'Password', 'class' => 'inpt required', 'label' => false, 'error' => false, 'div' => false, 'onblur' => "if(this.value=='')this.value='Password'; this.className='inpt'", 'onfocus' => "if(this.value=='Password')this.value=''; this.className='inpt_f'; this.type='password'")); ?>                            </span></p>

                        <div class="top15">
                            <div class="floatleft top15 gray12"><input type="checkbox" value="checkbox" name="remember" class="checkbox" <?php echo isset($this->data['User']['email']) ? "checked=true" : '';?>>
                                Remember my login details
                            </div>
                            <div class="floatright"><div class="black_btn2"><span class="upper"><?php echo $this->Form->submit('Login', array('class' => 'button', 'value' => 'Login')); ?></span></div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="bl">
            <div class="br">
                <div class="bm">&nbsp;</div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    $(document).ready(function() {
        $("#login-form").validate();
    });
</script>
