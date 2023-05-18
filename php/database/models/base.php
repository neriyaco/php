<?php

if (!defined('GUARD')) {
  http_response_code(404);
  exit;
}

require_once 'database/db.php';

class BaseModel
{
  function __construct()
  {
    $this->db = Db::i();
    $this->createTable();
  }

  protected $db;
  protected $table = '';

  protected function createTable()
  {
    if ($this->table === '' && get_class($this) !== 'BaseModel') {
      $this->table = strtolower(get_class($this)) . 's';
    }
  }

  function find($filter = [])
  {
    $query = 'SELECT * FROM ' . $this->table;
    if (count($filter) > 0) {
      $query .= $this->createWhere($filter);
    }
    return $this->db->connection->query($query)->fetch_all(MYSQLI_ASSOC);
  }

  function delete($filter = [])
  {
    $query = 'DELETE FROM ' . $this->table;
    if (count($filter) > 0) {
      $query .= $this->createWhere($filter);
    }
    return $this->db->connection->query($query);
  }

  protected function createWhere($filter = [])
  {
    $query = '';
    if (count($filter) > 0) {
      $query .= ' WHERE ';
      $i = 0;
      foreach ($filter as $key => $value) {
        if ($i > 0) {
          $query .= ' AND ';
        }
        if (is_array($value)) {
          $placeholders = array_map(function ($val) {
            return $this->prepareValue($val);
          }, $value);
          $query .= $key . ' IN (' . implode(', ', $placeholders) . ')';
        } else {
          $query .= $key . ' = ' . $this->prepareValue($value);
        }
        $i++;
      }
    }
    return $query;
  }


  protected function prepareValue($value)
  {
    if (is_string($value)) {
      return "'" . $this->db->connection->real_escape_string($value) . "'";
    } elseif (is_bool($value)) {
      return $value ? '1' : '0';
    } elseif ($value instanceof DateTime) {
      return "'" . $value->format('Y-m-d H:i:s') . "'";
    } else {
      return $value;
    }
  }
}
