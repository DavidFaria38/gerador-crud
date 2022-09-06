<?php

class AreaGestor extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!is_logged_gestor()) return redirect(base_url_usuario('selecionar_modulo'));

        $this->load->model('sistema/Usuario_model', 'gestor');
    }

    public function index()
    {
        render_template_gestor('index');
    }

    // public function selecionar_projeto()
    // {
    //     $gestor_id = session_codigo_gestor();

    //     $data_view = array(
    //         'projetos' => $this->gestor->listar_projetos_gestor($gestor_id)
    //     );

    //     render_template_gestor('selecionar_projeto', $data_view);
    // }
}
