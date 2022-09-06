<?php

class SelecionarModulo extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('usuario/Usuario_model', 'usuario');

  }

  public function index()
  {
    $this->load->view('area_usuario/selecionar_tipo');
  }

  public function selecionar_modulo()
  {
    if (!is_logged_usuario()) return redirect(base_url_usuario('login'));

    $usuario = $this->usuario->buscar_modulos(session_codigo_usuario());

    $modulos_permitidos = array();
    $modulos = explode(";", $usuario->cadusuges_modulos_acesso);
    foreach ($modulos as $key => $modulo) {
      array_push($modulos_permitidos, trim($modulo));
    }

    $modulos = array();
    foreach (MODULOS as $key => $modulo) {
      if (in_array($modulo['key'], $modulos_permitidos)) {
        $modulos[] = $modulo;
      }
    }

    $data_view = array(
      'modulos' => $modulos
    );

    $this->load->view('area_usuario/selecionar_modulo', $data_view);
  }
}
