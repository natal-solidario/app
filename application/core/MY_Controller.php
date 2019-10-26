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
			$this->session->set_userdata('usuario_logado', $this->user->email);
		}
	}
}