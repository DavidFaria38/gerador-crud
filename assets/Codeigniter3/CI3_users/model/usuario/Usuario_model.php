<?php

class Usuario_model extends CI_Model
{

  public function autenticar($data = array())
  {
    $login = clear_cpf($data['usu_cpf']);
    // $senha = sha1($data['usu_senha']);
    $senha = 0;

    $usuario = $this->db->select('*')
      ->from('t_cadastro_usuario')
      ->where('cadusu_login', $login)
      ->where('cadusu_senha', $senha)
      ->get()
      ->row();
    return $usuario;
  }

  public function define_token_redefinir_senha($cpf = '')
  {
    $cpf = clear_cpf($cpf);
    $token = sha1($cpf . date('YmdHis'));

    $this->db->where('usu_cpf', $cpf);
    $this->db->update('t_cadastro_usuario', array('usu_token' => $token, 'usu_senha_redefinida' => FALSE));
    $usuarios_afetados = $this->db->affected_rows();

    if ($usuarios_afetados === 0) return NULL;

    $usuario = $this->db->select('usu_codigo, usu_nome, usu_email, usu_cpf, usu_token')
      ->from('t_cadastro_usuario')
      ->where('usu_cpf', $cpf)
      ->get()
      ->row();
    return $usuario;
  }

  public function check_token_redefinir_senha_valido($token = '')
  {
    $token_stored = $this->db->select('usu_token')
      ->from('t_cadastro_usuario')
      ->where('usu_token', $token)
      ->get()
      ->row();
    return !is_null($token_stored);
  }

  public function define_nova_senha($token = '', $nova_senha = '')
  {
    $nova_senha = sha1(trim($nova_senha));

    $this->db->where('usu_token', $token);
    $this->db->update('t_cadastro_usuario', array(
      'usu_senha' => $nova_senha,
      'usu_token' => NULL,
      'usu_atualizado_em' => current_datetime()
    ));

    $usuarios_afetados = $this->db->affected_rows();
    return $usuarios_afetados;
  }

  public function listar_todos($search_by = '', $order_by = '', $order_dir = '', $offset = 0, $limit = 10)
  {
    $query = $this->db->select('usu_nome, usu_login, usu_email, usu_ativo, usu_codigo')
      ->from('t_cadastro_usuario');
    if (trim($search_by) !== '') {
      $query->group_start();
      $query->like('usu_nome', $search_by);
      $query->or_like('usu_login', $search_by);
      $query->or_like('usu_email', $search_by);
      $query->or_like('usu_codigo', $search_by);
      $query->group_end();
    }

    if (trim($order_by) !== '' && trim($order_dir) !== '') {
      $query->order_by($order_by, $order_dir);
    }

    $query->limit($limit, $offset);

    return $query->get()->result_array();
  }

  public function count_cadastro_usuario()
  {
    return $this->db->count_all_results('t_cadastro_usuario');
  }

  public function inserir($data_usuario = array())
  {
    if (!array_key_exists('usu_nome', $data_usuario) || !array_key_exists('usu_cpf', $data_usuario) || !array_key_exists('usu_senha', $data_usuario) || !array_key_exists('usu_email', $data_usuario)) return -1;

    $cpf = clear_cpf($data_usuario['usu_cpf']);
    $usuario = array(
      'usu_nome' => $data_usuario['usu_nome'],
      'usu_email' => $data_usuario['usu_email'],
      'usu_cpf' => $cpf,
      'usu_senha' => sha1(trim($data_usuario['usu_senha'])),
      'usu_login' => $cpf,
      'usu_ativo' => ($data_usuario['usu_ativo'] === 'on'),
      'usu_criado_em' => current_datetime(),
      'usu_criado_por' => session_sistema_codigo()
    );

    $this->db->insert('t_cadastro_usuario', $usuario);

    return $this->db->insert_id();
  }

  public function excluir($usuario_id = 0)
  {
    $this->db->where('usu_codigo', $usuario_id);
    $this->db->delete('t_cadastro_usuario');
  }

  public function buscar_por_codigo($usuario_id = 0)
  {
    $usuario = $this->db->select('t.usu_codigo, t.usu_nome, t.usu_email, t.usu_cpf, t.usu_ativo, t.usu_criado_em, t1.usu_nome as usu_criado_nome, t.usu_atualizado_em, t2.usu_nome as usu_atualizado_nome')
      ->from('t_cadastro_usuario as t')
      ->join('t_cadastro_usuario as t1', 't1.usu_codigo = t.usu_criado_por', 'left')
      ->join('t_cadastro_usuario as t2', 't2.usu_codigo = t.usu_atualizado_por', 'left')
      ->where('t.usu_codigo', $usuario_id)
      ->get()
      ->row();

    return $usuario;
  }

  public function atualizar($usuario_id = 0, $data = array())
  {
    if (array_key_exists('usu_senha', $data)) $data['usu_senha'] = sha1(trim($data['usu_senha']));

    $data['usu_ativo'] = ($data['usu_ativo'] === 'on');
    $data['usu_atualizado_em'] = current_datetime();
    $data['usu_atualizado_por'] = session_sistema_codigo();

    $this->db->where('usu_codigo', $usuario_id);
    $this->db->update('t_cadastro_usuario', $data);

    if ($this->db->affected_rows() >= 0) return $data;
    return NULL;
  }
}
