<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class registros extends CI_Model{
		
		private $key_hash;
		private $timezone;

		function __construct(){
			parent::__construct();
			$this->load->database("default");
			$this->key_hash    = $_SERVER['HASH_ENCRYPT'];
			$this->timezone    = 'UM1';

				//usuarios
		      $this->usuarios             = $this->db->dbprefix('usuarios');
          $this->perfiles             = $this->db->dbprefix('perfiles');

          $this->configuraciones      = $this->db->dbprefix('catalogo_configuraciones');
          
          $this->proveedores          = $this->db->dbprefix('catalogo_empresas');
          $this->historico_acceso     = $this->db->dbprefix('historico_acceso');

          $this->catalogo_estados      = $this->db->dbprefix('catalogo_estados');
          $this->catalogo_litraje      = $this->db->dbprefix('catalogo_litraje');

          $this->participantes      = $this->db->dbprefix('participantes');
          $this->bitacora_participante     = $this->db->dbprefix('bitacora_participante');
          $this->catalogo_imagenes         = $this->db->dbprefix('catalogo_imagenes');
          
          $this->registro_participantes         = $this->db->dbprefix('registro_participantes');
          

          $this->catalogo_tipos         = $this->db->dbprefix('catalogo_tipos');


          
          

		}

    /*
SELECT  convert(AES_DECRYPT(p.total, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5'),decimal) AS total, AES_DECRYPT(p.nick, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS nick FROM (`pepsi_participantes` as p) ORDER BY `total` DESC LIMIT 20

 SELECT AES_DECRYPT(p.total, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS total, AES_DECRYPT(p.nick, 'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS nick FROM (`pepsi_participantes` as p) ORDER BY `total` DESC LIMIT 20

*/

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  //registro de usuario
////////////////////////////////////////////////////////////////////////////////

      public function listado_estados(){
            $this->db->select( 'id, nombre' );
            $estados = $this->db->get($this->catalogo_estados );
            if ($estados->num_rows() > 0 )
               return $estados->result();
            else
               return FALSE;
            $estados->free_result();
        }   
       


     //checar si el correo ya fue registrado
    public function check_correo_existente($data){
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->participantes);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }

     //checar el login del participante
    public function check_login($data){
      $this->db->select("id", FALSE);           
      $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
      $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
      $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
      $this->db->select("AES_DECRYPT(p.telefono,'{$this->key_hash}') AS telefono", FALSE);      
      $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);

      $this->db->select("p.premiado,p.id_premio");
      
      $this->db->from($this->participantes.' as p');
      
      $this->db->where('p.contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
      $this->db->where('p.nick',"AES_ENCRYPT('{$data['nick']}','{$this->key_hash}')",FALSE);

      $login = $this->db->get();

      if ($login->num_rows() > 0)
        return $login->result();
      else 
        return FALSE;
      $login->free_result();
    }


  //checar el login del participante
    public function check_loginconemail($data){
      $this->db->select("id", FALSE);           
      $this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);      
      $this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);      
      $this->db->select("AES_DECRYPT(p.celular,'{$this->key_hash}') AS celular", FALSE);      
      $this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
      $this->db->select("p.premiado,p.id_premio");
      
      $this->db->from($this->participantes.' as p');
      
      $this->db->where('p.contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
      $this->db->where('p.email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);

      $login = $this->db->get();

      if ($login->num_rows() > 0)
        return $login->result();
      else 
        return FALSE;
      $login->free_result();
    }

//agregar participante
    public function anadir_registro( $data ){
            $timestamp = time();

            
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'id', "UUID()", FALSE); //id
            $this->db->set( 'creacion',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'total', "AES_ENCRYPT(0,'{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);


            $this->db->set( 'nombre', "AES_ENCRYPT('{$data['nombre']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'apellidos', "AES_ENCRYPT('{$data['apellidos']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'fecha_nac', strtotime(date( "d-m-Y", strtotime($data['fecha_nac']) )) ,false);
            $this->db->set( 'ciudad', "AES_ENCRYPT('{$data['ciudad']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'celular', "AES_ENCRYPT('{$data['celular']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            //$this->db->set( 'id_estado', $data['id_estado']);
            $this->db->set( 'id_premio', $data['id_premio']);


            $this->db->insert($this->participantes );

            if ($this->db->affected_rows() > 0){
                return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }






      //agregar a la bitacora de participante sus accesos  
   public function anadir_historico_acceso($data){

            $timestamp = time();
            $ip_address = $this->input->ip_address();
            $user_agent= $this->input->user_agent();

            $this->db->set( 'id_usuario', $data->id); // luego esta se compara con la tabla participante
            $this->db->set( 'email', "AES_ENCRYPT('{$data->email}','{$this->key_hash}')", FALSE );
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            $this->db->set( 'ip_address',  $ip_address, TRUE );
            $this->db->set( 'user_agent',  $user_agent, TRUE );

            $this->db->insert($this->bitacora_participante );

            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();

        }


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  //registro de ticket
////////////////////////////////////////////////////////////////////////////////



 public function listado_tipos(){

            $this->db->select('c.id, c.nombre');
            $this->db->from($this->catalogo_tipos.' as c');
            
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }   


        //checar si el tickets ya fue registrado
        public function check_tickets_existente($data){
            $this->db->from($this->registro_participantes);
            $this->db->where('ticket',"AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')",FALSE);
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return FALSE;
            else
                return TRUE;
            $login->free_result();
        }        




        //agregar participante
        public function anadir_tickets( $data ){
            $timestamp = time();

            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            
            $id_participante = $this->session->userdata('id_participante');
            $this->db->set( 'id_participante', '"'.$id_participante.'"',false); // id del usuario que se registro
            
            $this->db->set( 'ticket', "AES_ENCRYPT('{$data['ticket']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'compra', strtotime(date( "d-m-Y", strtotime($data['compra']) )) ,false);
            $this->db->set( 'complejo', "AES_ENCRYPT('{$data['complejo']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_tipo', $data['id_tipo'], FALSE );
            
            //esto es el aleatorio ejemplo: "131" 
            $this->db->set( 'puntos', "AES_ENCRYPT('{$data['puntos']}','{$this->key_hash}')", FALSE );

            
            $this->db->insert($this->registro_participantes );


            if ($this->db->affected_rows() > 0){
                    //self::registro_total_tickets($data); //para ir poniendo la suma completa
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }        


        //OJO POR EL MOMENTO NO LO VOY A UTILIZAR
        public function registro_total_tickets( $data ){
            $id_participante = $this->session->userdata('id_participante');
            $this->db->set( 'total', "AES_ENCRYPT( (CASE WHEN ( ISNULL (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) =1 )  THEN 0 else (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) END ) +".$data['total']." , '{$this->key_hash}')", false);


              $this->db->where('id', $id_participante);   
            //$this->db->where('id', '"'.$id_participante.'"',false); // id del usuario que se registro

            $this->db->update($this->participantes );
            

        }    

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  //registro de usuario
////////////////////////////////////////////////////////////////////////////////

       public function record_general(){

          $largo = 20;
          $inicio =0; 
          $this->db->select("CONVERT(AES_DECRYPT(p.total,'{$this->key_hash}'),decimal) AS total", FALSE);
          $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
          $this->db->from($this->participantes.' as p');
          $this->db->order_by("total", "DESC");

          $this->db->limit($largo,$inicio); 

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();


      }  

      public function record_personal($data){

       

          /////



          $this->db->select(" ((SUBSTR(AES_DECRYPT(r.ticket,'{$this->key_hash}'),1,4 ) = 'fac-')*1)*100 AS total_facebook", FALSE);         

          

$this->db->select("
 
sum(
 ((
              ( SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,1,1) = SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,2,1) ) AND

              ( SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,1,1) = SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,3,1) )
              AND
              (SUBSTR(AES_DECRYPT(r.ticket,'{$this->key_hash}'),1,4 ) <> 'fac-')
               AND
              (CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) <> '000')


  )*1 ) * (AES_DECRYPT(r.transaccion,'{$this->key_hash}') )
 ) AS total_iguales

",false );


$this->db->select("
 
sum(
 ((
              NOT(( SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,1,1) = SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,2,1) ) AND

              ( SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,1,1) = SUBSTR(CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) ,3,1) ) )
              AND
              (SUBSTR(AES_DECRYPT(r.ticket,'{$this->key_hash}'),1,4 ) <> 'fac-')
               AND
              (CAST(BASE64_DECODE(AES_DECRYPT(r.puntos,'{$this->key_hash}')) AS CHAR) <> '000')


  )*1 ) * 25
 ) AS total_desiguales

",false );




          $this->db->select("( CASE WHEN SUBSTR(AES_DECRYPT(r.ticket,'{$this->key_hash}'),1,4 ) = 'fac-' THEN 100 ELSE 0 END ) AS ptoface", FALSE);
          
          $this->db->select("sum(AES_DECRYPT(r.transaccion,'{$this->key_hash}') ) AS transaccion", FALSE);

          $this->db->select("COUNT(r.id_participante) as 'cantidad'");
          
          $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      

          $this->db->from($this->participantes.' as p');
          $this->db->join($this->registro_participantes.' as r', 'p.id = r.id_participante','left');
          $where = "( (p.id='".$data['id_participante']."') ) ";      
          $this->db->where($where);
          $this->db->group_by("p.id");

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->row();
            else
               return False;
            $result->free_result();


      }  



        //agregar participante
        public function actualizar_tickets( $data ){
            $timestamp = time();

            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );  //fecha cdo se registro
            
            $id_participante         = $this->session->userdata('id_participante');
            $num_ticket_participante = $this->session->userdata('num_ticket_participante');
            

            $this->db->set( 'redes', 1, FALSE );
            $this->db->where('id_participante', $id_participante);  
            $this->db->where("AES_DECRYPT(ticket,'{$this->key_hash}')", '"'.$num_ticket_participante.'"',false);  
            $this->db->update($this->registro_participantes );


            if ($this->db->affected_rows() > 0){
                    self::registro_total_tickets2($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }  


        public function registro_total_tickets2( $data ){


            $id_participante = $this->session->userdata('id_participante');

            
            
            $this->db->set( 'total', "AES_ENCRYPT( (CASE WHEN ( ISNULL (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) =1 )  THEN 0 else (CONVERT(AES_DECRYPT(total,'{$this->key_hash}') , decimal) ) END ) +".$data['total']." , '{$this->key_hash}')", false);


              $this->db->where('id', $id_participante);   
            $this->db->update($this->participantes );
            

        }           




      

        








        public function listado_imagenes(){

            $this->db->select('c.id, c.nombre, c.valor, c.activo, c.puntos');
            $this->db->from($this->catalogo_imagenes.' as c');
            $this->db->where('c.activo',0);
            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }  		

 //----------------**************catalogos-------------------************------------------
      


		//Recuperar contraseña	del participante
	    public function recuperar_contrasena($data){
	    	$this->db->select("id", FALSE);						
			$this->db->select("AES_DECRYPT(p.email,'{$this->key_hash}') AS email", FALSE);						
			$this->db->select("AES_DECRYPT(p.nombre,'{$this->key_hash}') AS nombre", FALSE);			
			$this->db->select("AES_DECRYPT(p.apellidos,'{$this->key_hash}') AS apellidos", FALSE);			
      $this->db->select("AES_DECRYPT(p.nick,'{$this->key_hash}') AS nick", FALSE);      
			$this->db->select("AES_DECRYPT(p.telefono,'{$this->key_hash}') AS telefono", FALSE);			
			$this->db->select("AES_DECRYPT(p.contrasena,'{$this->key_hash}') AS contrasena", FALSE);
			$this->db->from($this->participantes.' as p');
			$this->db->where('p.email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
			$login = $this->db->get();
			if ($login->num_rows() > 0)
				return $login->result();
			else 
				return FALSE;
			$login->free_result();		
	    }	




	

   
    
		















	} 
?>