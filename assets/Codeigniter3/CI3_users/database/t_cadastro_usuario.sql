/* TABELA USUARIO PADRÃO */

CREATE TABLE t_cadastro_usuario (
	cadusu_codigo int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  cadusu_login VARCHAR(14) NOT NULL,
  cadusu_cpf VARCHAR(14) NOT NULL,
  cadusu_email VARCHAR(255) NOT NULL,
  cadusu_nome VARCHAR(80) NOT NULL,
  cadusu_modulos_acesso VARCHAR(255) NOT NULL COMMENT "modulos em que o usuario tem acesso", 
  cadusu_pode_cadastrar_usuario TINYINT(1) DEFAULT 0 COMMENT "Se usuario tem permissão de cadastrar outro usuario.", 
  cadusu_senha VARCHAR(255) NOT NULL,
  cadusu_token VARCHAR(255) DEFAULT NULL COMMENT "Token para recuperação de senha.",
  cadusu_ativo TINYINT(1) DEFAULT 1,
  cadusu_criado_por int(11) NOT NULL,
  cadusu_criado_em DATETIME NOT NULL,
  cadusu_atualizado_por int(11),
  cadusu_atualizado_em DATETIME,
) ENGINE=innodb;