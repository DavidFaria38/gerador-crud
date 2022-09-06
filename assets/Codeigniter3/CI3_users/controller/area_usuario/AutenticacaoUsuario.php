<?php

class AutenticacaoUsuario extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('usuario/Usuario_model', 'usuario_model');
  }

  public function login()
  {
    $this->load->view('area_usuario/login');
  }

  public function autenticar()
  {
    $this->form_validation->set_rules('usu_cpf', 'CPF', 'required|trim|min_length[13]');
    $this->form_validation->set_rules('usu_senha', 'Senha', 'required|trim|min_length[6]');
    
    if (!$this->form_validation->run()) {
      $this->login();
    } else {
      $data_login = array(
        'usu_cpf' => trim($this->input->post('usu_cpf')),
        'usu_senha' => trim($this->input->post('usu_senha'))
      );

      $data_usuario = $this->usuario_model->autenticar($data_login);
      // var_dump($data_usuario); die;
      if (!is_null($data_usuario)) {
        if (!$data_usuario->cadusu_ativo) {
          set_flash_message_warning('login_usuario', 'Seu acesso está desativado no momento.');
          return redirect(base_url_usuario('login'));
        }
        
        init_session_usuario($data_usuario->cadusu_codigo, $data_usuario->cadusu_nome, $data_usuario->cadusu_email, $data_usuario->cadusu_cpf, $data_usuario->cadusu_login);
        return redirect(base_url_usuario()); // redirecionar para pagina desejada
      } else {
        set_flash_message_danger('login_usuario', 'CPF ou senha incorreto.');
        return redirect(base_url_usuario('login'));
      }
    }
  }

  public function logout()
  {
    if (is_logged_usuario()) {
      destroy_session_usuario();
    }

    redirect(base_url_usuario('login'));
  }

  public function send_token_redefinir_senha()
  {
    if (is_logged_usuario()) return redirect(base_url_usuario());

    $this->load->view("area_usuario/recuperar_senha");
  }

  public function send_token_redefinir_senha_salvar()
  {
    $this->form_validation->set_rules('usu_cpf', 'CPF', 'required|trim|min_length[14]|callback_cpf_check', array('cpf_check' => 'O CPF é inválido.'));
    if (!$this->form_validation->run()) {
      $this->send_token_redefinir_senha();
    } else {
      $cpf = $this->input->post('usu_cpf');

      $data_token = $this->usuario_model->define_token_redefinir_senha($cpf);
      if (!is_null($data_token)) {
        $token = $data_token->usu_token_redefinir_senha;
        $email = $data_token->usu_email;
        $nome = $data_token->usu_nome;

        $view_data = array(
          'nome' => $nome,
          'link' => base_url_usuario("redefinir_senha/{$token}")
        );

        $email_message = $this->load->view('template_email/recuperar_senha', $view_data, TRUE);

        $email_enviado = send_email(SYSTEM_EMAIL_FROM, $email, 'Recuperar senha', $email_message);

        set_flash_message_success('usuario_recuperar_senha', 'Enviamos um e-mail com instruções para criar uma nova senha.');
        redirect(base_url_usuario('recuperar_senha'));
      } else {
        set_flash_message_danger('usuario_recuperar_senha', 'Este CPF não tem usuário cadastrado.');
        return redirect(base_url_usuario('recuperar_senha'));
      }
    }
  }

  public function redefinir_senha($token = '')
  {
    $token_valid = $this->usuario_model->check_token_redefinir_senha_valido($token);

    $data_view = array(
      'token' => $token,
      'token_valid' => $token_valid
    );
    $this->load->view("area_usuario/redefinir_senha", $data_view);
  }

  public function redefinir_senha_salvar($token = '')
  {
    $this->form_validation->set_rules('usu_senha', 'Senha', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('usu_senha_confirmada', 'Confirme a senha', 'required|trim|min_length[6]|matches[usu_senha]');

    if (!$this->form_validation->run()) {
      $this->redefinir_senha($token);
    } else {
      $nova_senha = $this->input->post('usu_senha');

      $senha_redefinida = $this->usuario_model->define_nova_senha($token, $nova_senha);
      if ($senha_redefinida) {
        set_flash_message_success('login_usuario', 'Senha redefinida com sucesso.');
        redirect(base_url_usuario('login'));
      } else {
        set_flash_message_danger('usuario_redefinir_senha', 'Erro ao salvar a nova senha.');
        redirect(base_url_usuario("redefinir_senha/{$token}"));
      }
    }
  }
}
