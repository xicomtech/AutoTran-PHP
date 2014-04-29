<!-- For Login -->
 <?php echo '<br><br>Login<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/login.json" method="post">
 <?php echo $this->Form->input('driver_id', array('name' => 'driver_id', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
 <!-- For Dispatch -->
 <?php echo '<br><br>Dispatch<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/dispatch.json" method="post">
 <?php echo $this->Form->input('driver_id', array('name' => 'driver_id', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
 <!-- Pick load -->
 <?php echo '<br><br>Pick load<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/pick_load.json" method="post">
 <?php echo $this->Form->input('driver_id', array('name' => 'driver_id', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>

<!-- Vin List of a load -->
 <?php echo '<br><br>Vin List<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/vin_list.json" method="post">
 <?php echo $this->Form->input('load_id', array('name' => 'load_id', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
 <!-- Vin Detail -->
 <?php echo '<br><br>Vin Detail<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/vin_detail.json" method="post">
 <?php echo $this->Form->input('vin_id', array('name' => 'vin_id', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
 <!-- Area code -->
 <?php echo '<br><br>Area code<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/area_code.json" method="post">
 <?php echo $this->Form->input('area_code', array('name' => 'area_code', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
  <!-- Type code -->
 <?php echo '<br><br>type code<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/type_code.json" method="post">
 <?php echo $this->Form->input('type_code', array('name' => 'type_code', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
  <!-- Severity code -->
 <?php echo '<br><br>severity code<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/severity_code.json" method="post">
 <?php echo $this->Form->input('severity_code', array('name' => 'severity_code', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
 <!-- Special code -->
 <?php echo '<br><br>Special code<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/special_code.json" method="post">
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
  <!-- Vin message list -->
 <?php echo '<br><br>Vin message list<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/vin_message.json" method="post">
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>

<!-- Dashboard -->
 <?php echo '<br><br>Dashboard<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/dashboard.json" method="post">
 <?php echo $this->Form->input('driver_id', array('name' => 'driver_id', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
 
  <!-- Position -->
 <?php echo '<br><br>Position<br>';?>
 <form action="<?php echo Router::url('/',true);?>api/position.json" method="post">
 <?php echo $this->Form->input('position', array('name' => 'position', 'type' => 'text')); ?>
 <?php echo $this->Form->submit(); ?>
 <?php echo $this->Form->end(); ?>
