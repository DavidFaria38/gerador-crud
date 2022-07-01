<?php

require_once 'app/config/Database.php';

class GetDataTable
{

  function getDataTable()
  {

    $arr_table_name = $this->getTablesNameFromDB();
    $arr_gerador_table_data = $this->getAllDataFromDB();

    $arr_result = array();

    foreach ($arr_table_name as $key => $table_name) {
      $key_table = $table_name;
      $arr_result[$key_table] = array();

      foreach ($arr_gerador_table_data as $inner_key => $table_item) {
        if ($table_item[GERADOR_COL_NAMETABLE] == $key_table) {
          array_push($arr_result[$key_table], $table_item);
          unset($arr_gerador_table_data[$inner_key]);
        }
      }
    }

    return $arr_result;
  }

  function getTablesNameFromDB()
  {
    $sql_distinct = GERADOR_COL_NAMETABLE;
    $sql_table = GERADOR_DB_TABLE;
    $sql_orderby = GERADOR_COL_NAMETABLE;


    $sql_query = "
    SELECT DISTINCT {$sql_distinct} 
    FROM {$sql_table}
    ORDER BY {$sql_orderby} ASC;";

    $db = new Database();
    $arr_query_result = $db->query($sql_query);

    $arr_result = array();
    foreach ($arr_query_result as $key => $value) {
      array_push($arr_result, array_values($value)[0]);
    }


    return $arr_result;
  }

  function getAllDataFromDB()
  {
    $sql_table = GERADOR_DB_TABLE;
    $sql_orderby = GERADOR_COL_NAMETABLE;


    $sql_query = "
    SELECT * 
    FROM {$sql_table}
    ORDER BY {$sql_orderby} ASC;";

    $db = new Database();
    $arr_result = $db->query($sql_query);

    return $arr_result;
  }
}
