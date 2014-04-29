<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Per Diem</title>
</head>

<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #dad1b4;">
   <tr>
    <td style="background:#2a2a2a; font-family:Arial, Helvetica, sans-serif; padding:10px 20px; font-weight:bold; color:#FFF; font-size:14px; text-transform:uppercase; text-align:center;">PER DIEM NEW PASSWORD</td>
  </tr>
  <tr>
    <td style="background:#333333; padding:10px 20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; line-height:18px;">
    <p>You  have initiated a password reset for your Per Diem Account <a href="mailto:<?php echo $user['User']['email'] ?>" style="color:#00afef; word-wrap:break-word;"><?php echo $user['User']['email'] ?></a>. 
      Simply copy and paste the following password when logging into your  account: <?php echo $new_password; ?></p>

      <p><strong style="font-size:14px; text-transform:uppercase; color:#FFF;">Sincerely,</strong><br />
      Per-Diem Team</p>
      </td>
  </tr>
</table>
</body>
</html>
