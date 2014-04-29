<?php

if (isset($invalidfields)) {
    //~ echo " <p class='top15 gray12'><table align='center'>
        //~ <tr><th width='20%' align='left'>Fields</th><th width='40%' align='left'>Error</th><tr>";
	echo " <p class='top15 gray12'><table align='center'>
        <tr><th width='40%' align='left'>Error</th><tr>";
    foreach ($invalidfields as $key => $field) {
        //echo "<tr><td>" . $key . "</td><td>";
        echo "<td>";
        echo "<ul>";
        foreach ($field as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul></td></tr>";
    }
    echo "</table>  </p>";
}
?>
