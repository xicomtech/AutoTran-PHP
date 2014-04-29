<div class="menubg">
    <div class="nav">
        <ul id="navigation">
            <li onmouseout="this.className=''" onmouseover="this.className='hov'">
		<?php echo $this->Html->link('Dashboard', array ('controller' => 'users', 'action' => 'index', 'admin' => true)); ?>
            </li>
            <li onmouseout="this.className=''" onmouseover="this.className='hov'">
				<?php echo $this->Html->link('User Manager', array ('controller' => 'users', 'action' => 'manage', 'admin' => true)); ?>
			</li>
			 <li onmouseout="this.className=''" onmouseover="this.className='hov'"><a href="#">Admin</a>				
                <div class="sub">
                    <ul>
                        <li>
						<?php echo $this->Html->link(__('Change Password'), array ('controller' => 'users', 'action' => 'change_password', 'admin' => true)); ?>
                        </li>
					</ul>
                </div>
            </li>
            <li onmouseout="this.className=''" onmouseover="this.className='hov'">	
            <?php echo $this->Html->link(__('Manage Vin'), array ('controller' => 'vins', 'action' => 'index', 'admin' => true)); ?>			
                <div class="sub">
                    <ul>
<!--
                        <li>
						<?php echo $this->Html->link(__('Add Vin'), array ('controller' => 'vins', 'action' => 'add', 'admin' => true)); ?>
                        </li>
-->
                       
					</ul>
                </div>
            </li>
            <li onmouseout="this.className=''" onmouseover="this.className='hov'">	
            <?php echo $this->Html->link(__('Manage Loads'), array ('controller' => 'loads', 'action' => 'index', 'admin' => true)); ?>			
<!--
                <div class="sub">
                    <ul>
                        <li>
						<?php echo $this->Html->link(__('Create & Assign load'), array ('controller' => 'loads', 'action' => 'create', 'admin' => true)); ?>
                        </li>
					</ul>
                </div>
-->
            </li>
            <li onmouseout="this.className=''" onmouseover="this.className='hov'">	
            <?php echo $this->Html->link(__('Manage codes'), 'javascript:void(0);'); ?>			
                <div class="sub">
                    <ul>
                        <li>
						<?php echo $this->Html->link(__('Area Code'), array ('controller' => 'area_codes', 'action' => 'index', 'admin' => true)); ?>
                        </li>
                        <li>
						<?php echo $this->Html->link(__('Type Code'), array ('controller' => 'type_codes', 'action' => 'index', 'admin' => true)); ?>
                        </li>
                        <li>
						<?php echo $this->Html->link(__('Severity Code'), array ('controller' => 'severity_codes', 'action' => 'index', 'admin' => true)); ?>
                        </li>
                        <li>
						<?php echo $this->Html->link(__('Special Code'), array ('controller' => 'special_codes', 'action' => 'index', 'admin' => true)); ?>
                        </li>
					</ul>
                </div>
            </li>
            <li onmouseout="this.className=''" onmouseover="this.className='hov'">	
            <?php echo $this->Html->link(__('Manage dealers'), 'javascript:void(0);'); ?>			
                <div class="sub">
                    <ul>
                        <li>
						<?php echo $this->Html->link(__('Dealers'), array ('controller' => 'dealers', 'action' => 'index', 'admin' => true)); ?>
                        </li>
					</ul>
                </div>
            </li>
            
            <li>	
            <?php echo $this->Html->link(__('User Notes'), array ('controller' => 'vin_messages', 'action' => 'index', 'admin' => true)); ?>			
               
            </li>
            
            
        </ul>
    </div>
    <div class="logout">
		<?php echo $this->Html->link($this->Html->image('logout.gif'), array ('controller' => 'users', 'action' => 'logout', 'admin' => true), array ('escape' => false)); ?>
    </div>
</div>
