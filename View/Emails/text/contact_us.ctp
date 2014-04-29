Hello Admin

Contact us Email

<?php 
if( $data['Contact']['name'] != '' ) :
	echo "Name : ". $data['Contact']['name'];
endif;
?>

<?php
if( $data['Contact']['email'] != '' ) :
	echo "Email : ". $data['Contact']['email'];
endif;
?>

<?php
if( $data['Contact']['organization'] != '' ) :
	echo "Organization : ". $data['Contact']['organization'];
endif;
?>

<?php
if( $data['Contact']['country'] != '' ) :
	echo "Country : ". $data['Contact']['country'];
endif;
?>

<?php
if( $data['Contact']['details'] != '' ) :
	echo "Details : ". $data['Contact']['details'];
endif;
?>


Thanks

<?php echo $data['Contact']['name'] ?>
