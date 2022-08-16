<?php

require_once 'app/config/Database.php';

class DataGerador
{
  private bool $strToLowerCaseData = TRUE;

  function getDataTable()
  {

    $arr_table_name = $this->getTablesNameFromDB();
    $arr_gerador_table_data = $this->getAllDataFromDB();

    $arr_result = array();

    foreach ($arr_table_name as $key => $table_name) {
      $key_table = strtolower($table_name[GERADOR_COL_NAMETABLE]);
      $arr_result[$key_table] = array();

      foreach ($arr_gerador_table_data as $inner_key => $table_item) {
        if (strtolower($table_item[GERADOR_COL_NAMETABLE]) == $key_table) {
          $array_lowercase = array(
            GERADOR_COL_NAMETABLE => strtolower($table_item[GERADOR_COL_NAMETABLE]),
            GERADOR_COL_NAMEFIELD_DB => strtolower($table_item[GERADOR_COL_NAMEFIELD_DB]),
            GERADOR_COL_NAMEFIELD_HTML => strtolower($table_item[GERADOR_COL_NAMEFIELD_HTML]),
            GERADOR_COL_NAMETABLE_FOREIGN => strtolower($table_item[GERADOR_COL_NAMETABLE_FOREIGN]),
            GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE => strtolower($table_item[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE]),
            GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE => strtolower($table_item[GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE]),
            
            GERADOR_COL_TYPEFIELD_HTML => strtolower($table_item[GERADOR_COL_TYPEFIELD_HTML]),
            GERADOR_COL_FUNCTION_FIELD_TYPE => strtolower($table_item[GERADOR_COL_FUNCTION_FIELD_TYPE]),
            GERADOR_COL_TYPE_MASK => strtolower($table_item[GERADOR_COL_TYPE_MASK]),
            GERADOR_COL_TYPE_VALIDATION => strtolower($table_item[GERADOR_COL_TYPE_VALIDATION]),
            
            GERADOR_COL_FUNCTION_FIELD => $table_item[GERADOR_COL_FUNCTION_FIELD],
            GERADOR_COL_DEFAULT_VALUE => $table_item[GERADOR_COL_DEFAULT_VALUE],

            GERADOR_COL_ID => $table_item[GERADOR_COL_ID],
            GERADOR_COL_PK => $table_item[GERADOR_COL_PK],
            GERADOR_COL_ORDER => $table_item[GERADOR_COL_ORDER],
            GERADOR_COL_HIDDEN => $table_item[GERADOR_COL_HIDDEN],
            GERADOR_COL_REPORT => $table_item[GERADOR_COL_REPORT],
            GERADOR_COL_REQUIRED => $table_item[GERADOR_COL_REQUIRED],
            GERADOR_COL_MAX_LENGTH => $table_item[GERADOR_COL_MAX_LENGTH],
            GERADOR_COL_MIN_LENGTH => $table_item[GERADOR_COL_MIN_LENGTH],
          );

          if($this->strToLowerCaseData){
            array_push($arr_result[$key_table], $array_lowercase);
          } else {
            array_push($arr_result[$key_table], $table_item);
          }
          
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
    SELECT {$sql_distinct}, COUNT({$sql_distinct}) as quantidade_elementos 
    FROM {$sql_table}
    GROUP BY {$sql_distinct}
    ORDER BY {$sql_orderby} ASC;";

    $db = new Database();
    $arr_query_result = $db->query($sql_query);

    return $arr_query_result;
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
