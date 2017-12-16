<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="record"."/".$this->session->userdata('id_participante');
      	$id_part =$this->session->userdata('id_participante');
    }
	$hidden = array('tiempo'=>$tiempo,'redes'=>$redes,'ptos'=>$ptos); 
 ?>

	<div class="modal-header felicidadesmodal">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		
	</div>
	<div class="modal-body felicidadessi" style="background-image:url('<?php echo base_url()?>img/felicidades1.png');    background-size: cover;">

				<h1 class="felic">FELICIDADES</h1>
				<?php 
					
				echo '<h4 class="text-center puntos-ganados">';
					echo 'GANASTE '.$total_puntos.' PUNTOS';
				echo '</h4>';
				?>
			
		<div class="alert" id="messagesModal"></div>
	</div>
	<div class="modal-footer">
		
	</div>



	<input type="hidden" id="ptos" name="ptos" value="<?php echo $ptos; ?>">
	<input type="hidden" id="redes" name="redes" value="<?php echo $redes; ?>">
	<input type="hidden" id="tiempo" name="tiempo" value="<?php echo $tiempo; ?>">
	<input type="hidden" id="total_puntos" name="total_puntos" value="<?php echo $total_puntos; ?>">

	


 <script type="text/javascript">

   var  $catalogo;
   var $puntos;
   

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '469450303424001',
      xfbml      : true,
      cookie     : false, 
      status     : true,
      version    : 'v2.10'
    });

	    FB.getLoginStatus(function(response) {
			//alert("1 "+response);
		    if (response.status === 'connected') {
			     var uid = response.authResponse.userID;
			     var accessToken = response.authResponse.accessToken;
		     		
				FB.ui(
				       {
				      method: 'feed',
				      name: 'Vamonos a españa con Calimax',
				      link: 'https://www.vamonosaespanaconcalimax.com',
				      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      description: 'Gana uno de los 3 viajes dobles a Madrid'
				       },
				       function(response) {
					console.log(response);					
					alert("2 "+response);
					if (response !=null) { 	
				        // El usuario publico en el muro
						console.log('El usuario publico en el muro');
						window.location.href = 'publico/'+($puntos);
				      } else {
				        // El usuario cancelo y no publico nada
						console.log('El usuario cancelo y no publico nada');
						window.location.href = 'record/'+$catalogo;
				      }
				       }
				     );

			    FB.api('/me', function(response) {
			       $("#response").html("Bienvenido "+ response.name +", has iniciado sesión en facebook");
			    });

     		} else if (response.status === 'not_authorized') {
			     
			     //$("#response").html("Existe una sesión abierta pero no ha aceptado el APP");
			      //console.log('Existe una sesión abierta pero no ha aceptado el APP');
				 FB.ui(
				       {
				      method: 'feed',
				     name: 'Vamonos a españa con Calimax',
				      link: 'https://www.vamonosaespanaconcalimax.com',
				      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      description: 'Gana uno de los 3 viajes dobles a Madrid'
				       },
				       function(response) {
					//alert("3 "+response);
				      //if (response && response.post_id) {
					if (response !=null) { 	
				        // El usuario publico en el muro
						console.log('El usuario publico en el muro');
						window.location.href = 'publico/'+($puntos);
				      } else {
				        // El usuario cancelo y no publico nada
						console.log('El usuario cancelo y no publico nada');
						window.location.href = 'record/'+$catalogo;
				      }
				       }
				     );



			    

			} else {
     			$("#response").html("No hay sesión iniciada en facebook");

				FB.ui(
				       {
				      method: 'feed',
				      name: 'Vamonos a españa con Calimax',
				      link: 'https://www.vamonosaespanaconcalimax.com',
				      picture: 'https://www.vamonosaespanaconcalimax.com/img/pepsi_fbshare.jpg',
				      caption: 'Vigencia de la promoción: del 1 de Septiembre al 23 de Octubre de 2017',
				      description: 'Gana uno de los 3 viajes dobles a Madrid'
				       },
				       function(response) {
					//alert("4 "+response);
				      //if (response && response.post_id) {
					if (response !=null) { 	
				        // El usuario publico en el muro
						console.log('El usuario publico en el muro');
						window.location.href = 'publico/'+($puntos);
				      } else {
				        // El usuario cancelo y no publico nada
						console.log('El usuario cancelo y no publico nada');
						window.location.href = 'record/'+$catalogo;
				      }
				       }
				     );


    		}

     	}); //fin de FB.getLoginStatus(function(response) {
    }; //fin de window.fbAsyncInit = function() {
 
    	

 	function myFacebookLogin($cat, $ptos) {  

 		$catalogo = $cat;
 		$puntos = $ptos;

	 (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));


	}     





   
  </script>


