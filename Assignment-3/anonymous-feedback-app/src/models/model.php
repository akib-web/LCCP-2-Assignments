<?php

namespace App\Core\Models;

class Model
{
  public array $values;

  public string $table;

  public object $data;

  public function __get($name)
  {
    if (isset($this->values[$name])) {
      return $this->values[$name];
    } else {
      $this->values[$name] = null;
      return $this->values[$name];
    }
  }
  public function __set($name, $values)
  {
    $this->values[$name] = $values;
  }

  public function save()
  {
    // var_dump(APP_ROOT_PATH . "/storage/users.txt");
    $all_data = $this->all($this->table);
    $all_data = is_array($all_data) ? $all_data : [];
    $current_model = serialize($this);

    array_push($all_data, $current_model);
    // var_dump($all_data);
    file_put_contents($this->getFilePath($this->table), serialize($all_data));
  }
  public function getFilePath(string $filename)
  {
    return APP_ROOT_PATH . "/storage/$filename.txt";
  }
  public function all(string $filename)
  {
    if (file_exists($this->getFilePath($filename))) {
      $data = unserialize(file_get_contents($this->getFilePath($filename)));
    }
    if (!isset($data)) {
      return [];
    }

    return $data;
  }
  public function where(array $conditions)
  {
    $all_data = $this->all($this->table);
    $all_data = is_array($all_data) ? $all_data : [];

    foreach ($all_data as $index => $object) {
      foreach ($conditions as $key => $value) {
        // $this->data = unserialize($object);
        // var_dump(unserialize($object)->id);
        // var_dump(unserialize($object)->{$key} === $value);
        // var_dump($value);
        // return unserialize($object);
        if (unserialize($object)->{$key} === $value) {
          // return unserialize($object);
          $this->data = unserialize($object);
        }
      }
      return $this;
    }
  }
  public function get()
  {
    return $this;
  }
}