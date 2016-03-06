<?php

class User extends BaseModel {

    public $id, $name, $password, $is_admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password', 'validate_is_admin');
    }

    public static function getMembers($id) {
        $query = DB::connection()->prepare('SELECT kayttaja.name FROM Ryhma, Kayttaja, Kayt_ryhma WHERE ryhma.id = :id AND ryhma.id = kayt_ryhma.ryhma_id AND kayttaja.id = kayt_ryhma.kayt_id;
');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $users = array();
        foreach ($rows as $row) {
            $users[] = new Ryhma(array(
                'name' => $row['name']
            ));
        }
        return $users;
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

    public static function isAdmin($id) {
        $query = DB::connection()->prepare('SELECT Kayttaja.is_admin FROM Kayttaja WHERE id = :id AND is_admin = TRUE LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            return new User(array('is_admin' => $row['is_admin']));
        } else {
            return null;
        }
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (name, password, is_admin) VALUES (:name, :password, :is_admin) RETURNING id');
        $query->execute(array('name' => $this->name, 'password' => $this->password, 'is_admin' => $this->is_admin));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $done;
        if (isset($_POST['done'])) {
            $done = $_POST['done'];
        } else {
            $done = 0;
        }
        $query = DB::connection()->prepare('UPDATE Kayttaja SET '
                . 'Name = \'' . $this->name . '\', '
                . 'Password =\'' . $this->password . '\', '
                . 'is_admin =\'' . $this->is_admin . '\' WHERE id =' . $this->id);
        $query->execute();
        //$row = $query->fetch();
//          Kint::trace();
        //Kint::dump($row);
        //$this->id = $row['id'];
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id =' . $this->id . ' RETURNING id');
        $query->execute();
        //$row = $query->fetch();
//          Kint::trace();
//  Kint::dump($row);
        //$this->id = $row['id'];
    }

    public function validate_name() {
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->name, 'Nimen'));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->name, 'Nimen'));
        $errors = array_merge($errors, BaseModel::validate_not_whitespace($this->name, 'Nimen'));
        return $errors;
    }

    public function validate_password() {
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->password, 'Salasanan'));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->password, 'Salasanan'));
        $errors = array_merge($errors, BaseModel::validate_not_whitespace($this->password, 'Salasanan'));
        return $errors;
    }

    public function validate_is_admin() {
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_boolean($this->is_admin, 'Admin arvon'));
        return $errors;
    }

}
