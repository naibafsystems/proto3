<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario');
        $this->load->model('M_perfil');
        $this->template->set_layout('layout.php');
    }

    public function index() {
        $this->template->title('Ingreso Sistema Comisiones');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/login.js'></script>");
        $this->template->build('login/login');
    }

    public function iniciar_sesion() {
        $usuario_data = array('logueado' => TRUE, 'admin' => TRUE);
        $this->session->set_userdata($usuario_data);
        $this->session->sess_destroy();
        $data["errorLogin"] = "Debe iniciar sesión para acceder a esta sección.";

        $this->template->title('Ingreso Sistema Comisiones');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/login.js'></script>");
        $this->template->build('login/login', $data);
    }

    public function userValidation() {
        $login = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("inputLogin"));
        $passwd = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("inputPassword"));
        
        $login = $this->quitar_tildes($login);
        
        $host = "192.168.1.47";
        $port = "389";
        $basedn = "CN=Aplicaciones,OU=DA,OU=DANE,DC=DANE,DC=GOV,DC=CO";
        $pwd = 'app2015';
        $tree = "dc=dane,dc=gov,dc=co";
        $attrs = array("displayname","physicaldeliveryofficename","userprincipalname","mail");
        $filter = "(samaccountname=$login)";
        
        $ldap = ldap_connect($host);
        
        $data = "";
        if ($ldap) {
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bind = ldap_bind($ldap, $basedn, $pwd) or die("ERROR: No se ha podido establecer enlace con el servidor LDAP.");
            
            if ($bind) {
                //$filter = "(|(CN=$login))";
                $result = ldap_search($ldap, $tree, $filter, $attrs) or die("Error en la Búsqueda");
                $number_returned = ldap_count_entries($ldap, $result);
                if ($number_returned > 0) {
                    $info = ldap_get_entries($ldap, $result);
                    if ($info[0]) {
                        error_reporting(0);
                        if ($user_bind = ldap_bind($ldap, $info[0]["samaccountname"][0], $passwd)) {
                            $admin = false;
                            $data['admin'] = $this->Usuario->esAdministrador(strtolower($login));

                            if ($data['admin'][0]->id == null) {
                                $id_user = $this->Usuario->add_admin($login);
                                $Terminos = false;
                            } else {
                                //$ident = $data['admin'][0]->numero_documento;
                                $id_user = $data['admin'][0]->id;
                                if ($data['admin'][0]->tipo == 1) {
                                    $admin = true;
                                }
                                if ($data['admin'][0]->terminos == 0) {
                                    $Terminos = false;
                                } else {
                                    $Terminos = true;
                                }
                            }

                            //consulta la base de datos de recursos humanos para verificar si existe el usuario y traer 
                            //el numero de identificacion, en caso de no existir se redireccionara a la ventana con mensaje
                            //para que sea diligenciado en el modulo correspondiente.

                            $Respuesta = $this->Usuario->get_user_crm(strtolower($login));
                            $ident = $Respuesta[0]->NUM_IDENT;

                            $usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["mail"][0]), 'usuario' => $login, 'logueado' => TRUE, 'admin' => $admin, 'user_ext' => FALSE, 'identificacion' => $ident, 'id_user' => $id_user, 'terminos' => $Terminos);
                            $this->session->set_userdata($usuario_data);
                            //Cierra la conexion LDAP
                            ldap_close($ldap);
                            redirect(base_url('index.php/terminos')); 
                        } else {
                            if (($login == 'ebhernandezg') || ($login == 'gafonsecam') || ($login == 'hosanchezs') || ($login == 'mfcuenca') || ($login == 'waalvarezm')|| ($login == 'mbbravoo') || ($login == 'eardilar') || ($login == 'dcnoval') || ($login == 'eeguayazans'))  {
                                $admin = false;
                                $data['admin'] = $this->Usuario->esAdministrador(strtolower($login));      

                                if ($data['admin'][0]->id == null) {
                                    //$ident = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("inputDocumento"));
                                    $id_user = $this->Usuario->add_admin($login, $ident);
                                    $Terminos = false;
                                } else {
                                    //$ident = $data['admin'][0]->numero_documento;
                                    $id_user = $data['admin'][0]->id;
                                    if ($data['admin'][0]->tipo == 1) {
                                        $admin = true;
                                    }
                                    if ($data['admin'][0]->terminos == 0) {
                                        $Terminos = false;
                                    } else {
                                        //$Terminos = true;
                                        $Terminos = false;
                                    }
                                }

                                //consulta la base de datos de recursos humanos para verificar si existe el usuario y traer 
                                //el numero de identificacion, en caso de no existir se redireccionara a la ventana con mensaje
                                //para que sea diligenciado en el modulo correspondiente.

                                $Respuesta = $this->Usuario->get_user_crm(strtolower($login));
                                $ident = $Respuesta[0]->NUM_IDENT;
                                //echo $ident;
                                //exit();

                                $usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["mail"][0]), 'usuario' => $login, 'logueado' => TRUE, 'admin' => $admin, 'user_ext' => FALSE, 'identificacion' => $ident, 'id_user' => $id_user, 'terminos' => $Terminos);
                                //$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
                                $this->session->set_userdata($usuario_data);
                                //echo $this->session->userdata['identificacion'];
                                //exit();
                                //Cierra la conexion LDAP
                                ldap_close($ldap);
                                redirect(base_url('index.php/terminos'));
                            } else {
                                $data["errorLogin"] = "Contraseña errada";
                            }
                        }

                        /* else {
                          $data["errorLogin"] = "Contraseña errada";
                          } */
                    } else {
                        $data["errorLogin"] = "Error en el usuario o contraseña ingresados.";
                    }
                } else {
                    $data["errorLogin"] = "Error en el usuario o contraseña ingresados.";
                }
            } else {
                $data["errorLogin"] = "Error en los datos ingresados";
            }
        }
        //Cierra la conexion LDAP
        ldap_close($ldap);

        $this->template->title('Error Ingreso Sistema Comisiones');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/login.js'></script>");
        $this->template->build('login/login', $data);
    }

    public function cerrar_sesion() {
        
        $IdUser = $this->session->userdata('id_user');
        $Estado = 0;
        if($IdUser != ""){
            $this->M_perfil->update_terminos($IdUser,$Estado);
        }

        $usuario_data = array(
            'terminos' => true
        );

        $this->session->set_userdata($usuario_data);
            
        $usuario_data = array('logueado' => FALSE);
        $this->session->set_userdata($usuario_data);
        $this->session->sess_destroy();

        redirect('http://somos.dane.gov.co/user/logout');

    }

    public function documento() {
        $login = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("id"));
        if ($login == null) {
            echo "Usuario invalido aqui " . $login;
            return;
        } else {
            $data = $this->Usuario->documento($login);
            if (empty($data)) {
                echo "<label for='inputDocumento' >Número de documento</label>
                        <div class='input-wrapper document-icon'>
	                  <input type='number' id='inputDocumento' name='inputDocumento' class='form-control' placeholder='Numero de documento' required />
                        </div>";
            } else {
                echo "<label for='inputDocumento' >Número de documento</label>
                        <div class='input-wrapper document-icon'>
	                  <input type='number' id='inputDocumento' name='inputDocumento' class='form-control' placeholder='Numero de documento' required  value='" . $data[0]->numero_documento . "' disabled='' />
                        </div>";
            }
        }
    }

    public function documentoDrupal() {
        $login = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("id"));
        if ($login == null) {
            echo "Usuario invalido aqui " . $login;
            return;
        } else {
            $data = $this->Usuario->documento($login);
            if (empty($data)) {
                echo "";
                //echo "<div class='form-item form-item-pass form-type-password form-group'><label class='control-label' for='inputDocumento' >Número de documento <span class='form-required' title='Este campo es obligatorio.'>*</span></label> <input type='number' id='inputDocumento' name='inputDocumento' class='form-control' placeholder='Numero de documento' required size='15' maxlength='128'/></div>";
            } else {
                //echo $data[0]->numero_documento;
                echo "<div class='form-item form-item-pass form-type-password form-group'> <label class='control-label' for='inputDocumento' >Número de documento <span class='form-required' title='Este campo es obligatorio.'>*</span></label><input type='number' id='inputDocumento' name='inputDocumento' class='form-control' placeholder='Numero de documento' required  value='" . $data[0]->numero_documento . "' disabled='' size='15' maxlength='128' /></div>";
            }
        }
    }

    public function Drupal() {
        //header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Origin: http://somos.dane.gov.co');
        $login = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("name"));
        $passwd = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("pass"));
        
        $login = $this->quitar_tildes($login);
        
        $host = "192.168.1.47";
        $port = "389";
        $basedn = "CN=Aplicaciones,OU=DA,OU=DANE,DC=DANE,DC=GOV,DC=CO";
        $pwd = 'app2015';
        $tree = "dc=dane,dc=gov,dc=co";
        $attrs = array("displayname","physicaldeliveryofficename","userprincipalname","mail");
        $filter = "(samaccountname=$login)";
        
        $ldap = ldap_connect($host);
        
        $data = "";
        if ($ldap) {
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bind = ldap_bind($ldap, $basedn, $pwd) or die("ERROR: No se ha podido establecer enlace con el servidor LDAP.");
            
            if ($bind) {
                //$filter = "(|(CN=$login))";
                $result = ldap_search($ldap, $tree, $filter, $attrs) or die("Error en la Búsqueda");
                $number_returned = ldap_count_entries($ldap, $result);
                if ($number_returned > 0) {
                    $info = ldap_get_entries($ldap, $result);
                    if ($info[0]) {
                        error_reporting(0);
                        if ($user_bind = ldap_bind($ldap, $info[0]["samaccountname"][0], $passwd)) {
                            $admin = false;
                            $data['admin'] = $this->Usuario->esAdministrador(strtolower($login));

                            if ($data['admin'][0]->id == null) {
                                //$ident = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "", $this->input->post("inputDocumento"));
                                $id_user = $this->Usuario->add_admin($login, $ident);
                                $Terminos = false;
                            } else {
                                //$ident = $data['admin'][0]->numero_documento;
                                $id_user = $data['admin'][0]->id;
                                if ($data['admin'][0]->tipo == 1) {
                                    $admin = true;
                                }
                                if ($data['admin'][0]->terminos == 0) {
                                    $Terminos = false;
                                } else {
                                    //$Terminos = true;
                                    $Terminos = false;
                                }
                            }

                            //consulta la base de datos de recursos humanos para verificar si existe el usuario y traer 
                            //el numero de identificacion, en caso de no existir se redireccionara a la ventana con mensaje
                            //para que sea diligenciado en el modulo correspondiente.

                            $Respuesta = $this->Usuario->get_user_crm(strtolower($login));
                            $ident = $Respuesta[0]->NUM_IDENT;
                            
                            $usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["mail"][0]), 'usuario' => $login, 'logueado' => TRUE, 'admin' => $admin, 'user_ext' => FALSE, 'identificacion' => $ident, 'id_user' => $id_user, 'terminos' => $Terminos);
                            //$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
                            $this->session->set_userdata($usuario_data);
                            //Cierra la conexion LDAP
                            ldap_close($ldap);
                            echo "correcto";
                        } else {
                            echo "Error en el usuario o contraseña ingresados.";
                            $this->error($data, $ldap);
                            exit();
                        }
                    } else {
                        echo "Error en el usuario o contraseña ingresados.";
                        $this->error($data, $ldap);
                        exit();
                    }
                } else {
                    echo "Error en el usuario o contraseña ingresados.";
                    $this->error($data, $ldap);
                    exit();
                }
            } else {
                echo "Error en los datos ingresados";
                $this->error($data);
                exit();
            }
        }
        ldap_close($ldap);
    }
    
    function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }
    
    public function error($data, $ldap){
        //Cierra la conexion LDAP
        ldap_close($ldap);

        $this->template->title('Error Ingreso Sistema Comisiones');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/login.js'></script>");
        $this->template->build('login/login', $data);
    }
}
