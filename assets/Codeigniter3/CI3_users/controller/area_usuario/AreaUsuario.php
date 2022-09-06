<?php

class AreaUsuario extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('sistema/Usuario_model', 'usuario');
    }
}
