<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "https://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Calimax</title>
</head>
<body style="background:#e9e9e9">
<?php 
	if (!isset($retorno)) {
      	$retorno ="";
    }
 ?> 

	<table border="0" cellspacing="0" cellpadding="0" style="margin:30px auto; background-color:white; padding:0px; max-width:580px; width:100%">
	  
	  <tr>
	   <img src="https://www.vamonosaespanaconcalimax.com/img/mailh.png" alt="imagenesdemail">
	  </tr>
	  <tr>
	   	 <td scope="row" style="text-align:center">
	   	 	
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; text-transform: uppercase; color:#ef0711">
	    	<p style="color:#ef0711;width:100%;text-align:center;font-size:28px;">Usuario: <b><?php echo $email; ?></b></p></br>
	    	<p style="color:#ef0711;width:100%;text-align:center;font-size:28px;">Contraseña: <b><?php echo $contrasena; ?></b></p></br>
	    	</p>
	   	 </td>
	  </tr>
	  <tr>
	   	<img src="https://www.vamonosaespanaconcalimax.com/img/mailf.png" alt="imagenesdemail">
	  </tr>
	<!--   <tr style="background-color:#122145;">
	    <td scope="row" style="border-top:5px solid #ebbb34; padding: 15px;">
	    	<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">		
			Si requieres ayuda o tienes alguna duda contáctanos:
			</p>
			<p style="font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:14px; color:#5e6d81">			
					Correo electrónico: <b><?php echo $this->session->userdata('c1'); ?> </b><br/>
									
			</p>
			<br/>


			<p>			
			<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" name="boton" style="background:#ebbb34; font-family:'Myriad Pro', 'Myriad Pro Bold', Verdana, Arial; font-size:18px; color:#122145; padding:10px; border:none; text-decoration:none;">
				IR AL JUEGO
			</a>
			</p>
	    </td>
	  </tr>	  --> 
	  
	</table>
	

</body>
</html>




