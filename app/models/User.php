<?php

class User extends BaseModel {

    public $id, $name, $password, $is_admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            return new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));
        } else {
            return null;
        }
    }
          public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
          $user = new User(array(
            'id' => $row['id'],
            'name' => $row['name'],
            'password' => $row['password'],
            'is_admin' => $row['is_admin']
            ));
        }
        return $user;
      }
          public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();
        $users = array();
        foreach ($rows as $row) {
          $users[] = new User(array(
            'id' => $row['id'],
            'name' => $row['name'],
            'password' => $row['password'],
            'is_admin' => $row['is_admin']
            ));
        }
        return $users;
      }
      public static function isAdmin($id){
        $query = DB::connection()->prepare('SELECT Kayttaja.is_admin FROM Kayttaja WHERE id = :id AND is_admin = TRUE LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            return new User(array('is_admin' => $row['is_admin']));
        } else {
            return NULL;
        }
      }
}
