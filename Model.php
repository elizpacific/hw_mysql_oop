<?php

namespace PrudnikovaStud\Framework\Models;

use PrudnikovaStud\Framework\DB;

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $table2;
    protected $pKey = 'id';

    public function __construct()
    {
        $this->pdo = DB::instance();
    }

    public function findAll()
    {
        $table = htmlspecialchars($this->table);
        $sql = "SELECT * FROM $table";
        return $this->pdo->query($sql);
    }

    public function where($key, $symbol, $search): string
    {
        $table = htmlspecialchars($this->table);

        $key = htmlspecialchars($key);
        $symbol = htmlspecialchars($symbol);
        $search = htmlspecialchars($search);

        $str = $key . $symbol . "'" . $search . "'";

        $sql = "SELECT * FROM $table WHERE $str";
        return $this->pdo->query($sql);
    }

    public function insertOne(array $array): string
    {
        $table = htmlspecialchars($this->table);
        $keys = array_key($array);
        $values = array_values($array);
        $sql = '';
        //$categoryModel->insertOne(['id' => 55,'title' => 'text title', 'description' => 'qwerty']);
        foreach($values as $value){
            foreach ($keys as $key) {
                if ($value != NULL) {
                    $sql = "INSERT INTO $table($key) values ($value)";
                }
            }
        }
        return $this->pdo->query($sql);
    }

    public function deleteOne(string $str): string
    {
        $table = htmlspecialchars($this->table);
        $str = htmlspecialchars($str);

        $sql = "DELETE FROM $table WHERE $str";
        return $this->pdo->query($sql);
    }

    public function update(string $str, string $stmt): string
    {
        $table = htmlspecialchars($this->table);
        $str = htmlspecialchars($str);
        $stmt = htmlspecialchars($stmt);

        $sql = "SELECT * FROM $table WHERE $str LIKE $stmt";
        return $this->pdo->query($sql);
    }

    public function join(string $join,array $array1,array $array2,string $user_value1,string $user_value2): string
    {
        $table = htmlspecialchars($this->table);
        $table2 = htmlspecialchars($this->table2);

        $join = htmlspecialchars($join);
        $values1 = array_values($array1);
        $values2 = array_values($array2);
        foreach ($values1 as $value1){
            if($user_value1 == $values1)
                foreach ($values2 as $value2){
                    if($user_value2 == $value2){
                        $temp = $value1 . '.' . $user_value1 . ' = ' . $value2 . '.' . $user_value2;
                        $sql = "SELECT * FROM $table $join JOIN $table2 ON($temp)";
                    }
                }
        }
        return $this->pdo->query($sql);
    }
}
