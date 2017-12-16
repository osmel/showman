<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row-fluid">
	
	<div class="container" style="position: relative">
	
	<div class="logoderecha">
		<img src="<?php echo base_url()?>img/logo.png">
	</div>

	<div class="login_out">
		<ul>
			<?php if ($this->session->userdata('session_participante') == true) { ?>

					<li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile"> <?php echo "@".$this->session->userdata('nick_participante') ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                        	<li>
                                <a href="<?php echo base_url(); ?>record/<?php echo $this->session->userdata('id_participante'); ?>" >
                                    <i class="icon-user"></i> Mi marcador
                                </a>
                            </li>
                          
                            
                
                            
                            <li>
                                <a href="<?php echo base_url(); ?>desconectar">
                                    <i class="icon-key"></i> Salir </a>
                            </li>
                        </ul>
                    </li>
             <?php	} ?> 

		</ul>
	</div>

	<div class="navbar navbar-default" role="navigation">
		<div class="">			
	 
				<!-- <div class="navbar-brand">
					<a href="<?php echo base_url(); ?>" style="color: #ffffff;"></a>
				</div> -->

				<div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			    </div>

					<?php 
						  $perfil= $this->session->userdata('id_perfil'); 
						  $especial= $this->session->userdata('especial'); 

					 ?>	
					
			
				<div class="collapse navbar-collapse text-center" id="main-navbar">
					<ul class="nav navbar-nav navbar-left" id="menu_opciones">
							

								<li>
									<a href="<?php echo base_url(); ?>" class="">Inicio</a> 
								</li>

								<li >								
									<a disabled href="<?php echo base_url(); ?>registro_usuario" class="">registro usuarios</a>
								
								</li>

								<li>
									<a href="<?php echo base_url(); ?>mecanica" class="">mecánica</a> 
								</li>

								<li>
									<a href="<?php echo base_url(); ?>registro_ticket" class="">registrar tickets</a> 
								</li>

								<!-- <li class="logo_pepsi">
									<img src="<?php echo base_url().$this->session->userdata('c9'); ?>">
								</li> -->

								

								<?php if ($this->session->userdata('session_participante') == true) { ?>

								<!-- <li>
									<a href="<?php echo base_url(); ?>tabla_general" class="">tabla <br>general</a> 
								</li> -->

								<?php } ?>





								<li>
									<a href="<?php echo base_url(); ?>legales" class="">LEGALES</a> 
								</li>




					</ul>
				</div>
	 
		</div>
	</div>
	</div>
</div>