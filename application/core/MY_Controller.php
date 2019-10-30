<?php
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('message', 'Você não tem permissão para acessar essa página!');
			redirect('login');
		}
		else
		{
			$this->user = $this->ion_auth->user()->row();
			$this->user_permissions = $this->ion_auth_acl->build_acl($this->user->id);

            $this->session->set_userdata('usuario_logado_id', $this->user->id);
			$this->session->set_userdata('usuario_logado', $this->user->email);
			$this->session->set_userdata('permissoes_usuario', $this->user_permissions);
		}
	}
}