<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PimWimy</title>
<style type="text/css">
body{ margin:0px;}
</style>
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid #eaeaea; margin-top:20px;">
   <tr>
    <td>
        <div style="padding:15px; font-family:Arial, Helvetica, sans-serif; display:inline-block; font-size:12px; color:#555555;">
         <strong style="color:#333333; font-size:15px;">Hello Admin,</strong><br /><br />
         <?php 
		if( $data['Contact']['name'] != '' ) :
			echo "Name : ". $data['Contact']['name'] . '<br>';
		endif;
		?>

		<?php
		if( $data['Contact']['email'] != '' ) :
			echo "Email : ". $data['Contact']['email']. '<br>';
		endif;
		?>

		<?php
		if( $data['Contact']['organization'] != '' ) :
			echo "Organization : ". $data['Contact']['organization']. '<br>';
		endif;
		?>
		
		<?php
		if( $data['Contact']['phone'] != '' ) :
			echo "Phone : ". $data['Contact']['phone']. '<br>';
		endif;
		?>

		<?php
		if( $data['Contact']['country'] != '' ) :
			echo "Country : ". $data['Contact']['country']. '<br>';
		endif;
		?>

		<?php
		if( $data['Contact']['details'] != '' ) :
			echo "Details : ". $data['Contact']['details'];
		endif;
		?>
	<br><br>
		<strong>Thanks</strong><br>
		<?php echo $data['Contact']['name'] ?>
        </div>
    </td>
  </tr>
</table>
</body>
</html>
