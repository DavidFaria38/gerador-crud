<?php

class Database
{

  private string $servername;
  private string $username;
  private string $password;
  private string $dbname;
  function __construct()
  {
    $this->servername = DB_SERVERNAME;
    $this->username = DB_USERNAME;
    $this->password = DB_PASSWORD;
    $this->dbname = DB_NAME;
  }

  function query(string $query)
  {
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection with Database failed: " . $conn->connect_error);
    }

    $result_mysql = $conn->query($query);
    $arr_result = array();
    
    if ($result_mysql && $result_mysql->num_rows > 0) {
      // output data of each row
      while ($row = $result_mysql->fetch_assoc()) {
        array_push($arr_result, $row);
      }
    } else {
      // var_dump('Nenhum dado encontrado:<br><pre>', $conn->error_list ,'</pre>');
      // var_dump('<br><pre>', $result_mysql ,'</pre>');
    }

    $conn->close();
    
    return $arr_result;
  }
  
  function createDB()
  {
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password);

    // Check connection
    if ($conn->connect_error) {
      die("Connection with Database failed: " . $conn->connect_error);
    }

    
    $nome_db = DB_NAME;
    
    $query = "
    CREATE DATABASE {$nome_db};
    ";

    $result_mysql = $conn->query($query);

    $result = $result_mysql;

    $conn->close();
    
    
    return $result;
  }

  function createTable()
  {
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection with Database failed: " . $conn->connect_error);
    }

    
    $nome_tabela = GERADOR_DB_TABLE;
    $codigo = GERADOR_COL_ID;
    $nomeTabelaDB = GERADOR_COL_NAMETABLE;
    $CampoNomeDB = GERADOR_COL_NAMEFIELD_DB;
    $campoLabelHTML = GERADOR_COL_NAMEFIELD_HTML;
    $campoPrimaryKey = GERADOR_COL_PK;
    $campoRequired = GERADOR_COL_REQUIRED;
    $campoHidden = GERADOR_COL_HIDDEN;
    $campoOrdem = GERADOR_COL_ORDER;
    $tamanhoMin = GERADOR_COL_MIN_LENGTH;
    $tamanhoMax = GERADOR_COL_MAX_LENGTH;
    $tipoConsistencia = GERADOR_COL_TYPE_VALIDATION;
    $tipoMascara = GERADOR_COL_TYPE_MASK;
    $tipoCampoHTML = GERADOR_COL_TYPEFIELD_HTML;
    $TabelaRelacionada = GERADOR_COL_NAMETABLE_FOREIGN;
    $TabelaRelacionada_CodigoCampo = GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE;
    $TabelaRelacionada_valorCampo = GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE;
    
    $campoValorDefault = GERADOR_COL_DEFAULT_VALUE;
    $FuncaoCampo  = GERADOR_COL_FUNCTION_FIELD;
    $FuncaoCampoDestino = GERADOR_COL_FUNCTION_FIELD_TYPE;
  
    
    $query = "
    CREATE TABLE {$nome_tabela} (
      {$codigo} int,
      {$nomeTabelaDB} varchar(200),
      {$CampoNomeDB} varchar(200),
      {$campoLabelHTML} varchar(200),
      {$campoPrimaryKey} boolean,
      {$campoRequired} boolean,
      {$campoHidden} boolean,
      {$campoOrdem} int,
      {$tamanhoMin} int,
      {$tamanhoMax} int,
      {$tipoConsistencia} varchar(200),
      {$tipoMascara} varchar(200),
      {$tipoCampoHTML} varchar(200),
      {$campoValorDefault} varchar(200),
      {$TabelaRelacionada} varchar(200),
      {$TabelaRelacionada_CodigoCampo} varchar(200),
      {$TabelaRelacionada_valorCampo} varchar(200),
      {$FuncaoCampo} varchar(200),
      {$FuncaoCampoDestino} varchar(20),
      PRIMARY KEY ({$codigo})
    );
    ";

    $result_mysql = $conn->query($query);

    $result = $result_mysql;

    $conn->close();
    
    
    return $result;
  }
}