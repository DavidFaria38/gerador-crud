<?php

class AutenticacaoGestor extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('sistema/Usuario_model', 'usuario');
  }

  public function autenticar()
  {
    if (!is_logged_usuario()) return redirect(base_url_usuario('selecionar_modulo'));

    $data_usuario = $this->usuario->buscar_por_codigo(session_codigo_usuario());

    init_session_gestor(
      $data_usuario->cadusuges_codigo,
      $data_usuario->cadusuges_nome,
      $data_usuario->cadusuges_email,
      $data_usuario->cadusuges_cpf,
      $data_usuario->cadusuges_login
    );
    return redirect(base_url_gestor());
  }

  public function logout()
  {
    if (is_logged_gestor()) {
      destroy_session_gestor();
    }

    if (is_logged_usuario()) {
      return redirect(base_url_usuario('selecionar_modulo'));
    }

    return redirect(base_url());
  }
}
