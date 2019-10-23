<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Usuario_perfil extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_perfil_model');

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('login');
        } else {
            $user = $this->ion_auth->user()->row();
            $this->session->set_userdata('usuario_logado', $user->email);
            
        }
    } 

    /*
     * Listing of usuarios_perfil
     */
    function index()
    {
        $data['usuarios_perfil'] = $this->Usuario_perfil_model->get_all_usuarios_perfil();
        
        $data['_view'] = 'usuario_perfil/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new usuario_perfil
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'nome' => $this->input->post('nome'),
            );
            
            $usuario_perfil_id = $this->Usuario_perfil_model->add_usuario_perfil($params);
            redirect('usuario_perfil/index');
        }
        else
        {            
            $data['_view'] = 'usuario_perfil/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a usuario_perfil
     */
    function edit($id)
    {   
        // check if the usuario_perfil exists before trying to edit it
        $data['usuario_perfil'] = $this->Usuario_perfil_model->get_usuario_perfil($id);
        
        if(isset($data['usuario_perfil']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'nome' => $this->input->post('nome'),
                );

                $this->Usuario_perfil_model->update_usuario_perfil($id,$params);            
                redirect('usuario_perfil/index');
            }
            else
            {
                $data['_view'] = 'usuario_perfil/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The usuario_perfil you are trying to edit does not exist.');
    }
}
