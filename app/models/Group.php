<?php

class Group extends BaseModel {

    public $id, $name, $members;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function ryhmat($id) {
        $query = DB::connection()->prepare('SELECT ryhma.name, ryhma.id FROM Ryhma, Kayttaja, Kayt_ryhma WHERE kayttaja.id = :id AND ryhma.id = kayt_ryhma.ryhma_id AND kayttaja.id = kayt_ryhma.kayt_id;');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $ryhmat = array();
        foreach ($rows as $row) {
            $ryhmat[] = new Ryhma(array(
                'name' => $row['name'],
                'id' => $row['id']
            ));
        }
        return $ryhmat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Ryhma WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $group = new Group(array(
                'id' => $row['id'],
                'name' => $row['name'],
            ));
        }
        return $group;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Ryhma');
        $query->execute();
        $rows = $query->fetchAll();
        $groups = array();
        foreach ($rows as $row) {
            $groups[] = new Group(array(
                'id' => $row['id'],
                'name' => $row['name'],
            ));
        }
        return $groups;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Ryhma (name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
        $members = $_POST['members'];
        foreach ($members as $member) {
            $query = DB::connection()->prepare('INSERT INTO kayt_ryhma (kayt_id, ryhma_id) VALUES (' . $member . ',' . $this->id . ')');
            $query->execute();
        }
    }

    public function update() {
        $done;
        if (isset($_POST['done'])) {
            $done = $_POST['done'];
        } else {
            $done = 0;
        }
        $query = DB::connection()->prepare('UPDATE Ryhma SET '
                . 'Name = \'' . $this->name . '\' ' .
                ' WHERE id =' . $this->id);
        $query->execute();
        $query = DB::connection()->prepare('DELETE FROM kayt_ryhma WHERE ryhma_id = ' . $this->id);
        $query->execute();

        $members = $_POST['members'];
        foreach ($members as $member) {
            $query = DB::connection()->prepare('INSERT INTO kayt_ryhma (kayt_id, ryhma_id) VALUES (' . $member . ',' . $this->id . ')');
            $query->execute();
        }
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Ryhma WHERE id =' . $this->id . ' RETURNING id');
        $query->execute();
    }

    public function validate_name() {
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->name, 'Nimen'));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->name, 'Nimen'));
        $errors = array_merge($errors, BaseModel::validate_not_whitespace($this->name, 'Nimen'));
        return $errors;
    }

}
