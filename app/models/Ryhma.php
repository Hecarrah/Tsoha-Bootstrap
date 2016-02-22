<?php

class Ryhma extends BaseModel {

    public $id, $name, $kayt_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
              public static function ryhmat($id) {
        $query = DB::connection()->prepare('SELECT name FROM ryhma WHERE kayt_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $ryhmat = array();
        foreach ($rows as $row) {
          $ryhmat[] = new Ryhma(array(
            'name' => $row['name']
            ));
        }
        return $ryhmat;
      }
}
