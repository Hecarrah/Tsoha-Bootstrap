<?php
 class Muistiinpano extends BaseModel{
     public $id, $kayt_id, $name, $description, $added, $priority, $done;
     
     public function __construct($attributes) {
         parent::__construct($attributes);
     }
     public static function all(){
         $query = DB::connection()->prepare('SELECT * FROM Muistiinpano');
         $query->execute();
         $rows = $query->fetchAll();
         $memos = array();
         
         foreach ($rows as $row) {
             $memos[] = new Muistiinpano(array(
                 'id' => $row['id'],
                 'kayt_id' => $row['kayt_id'],
                 'name' => $row['name'],
                 'description' => $row['description'],
                 'added' => $row['added'],
                 'priority' => $row['priority'],
                 'done' => $row['done'],
             ));
         }
         return $memos;
     }
     
     public static function find($id){
         $query = DB::connection()->prepare('SELECT * FROM Muistiinpano WHERE id = :id LIMIT 1');
         $query ->execute(array('id' => $id));
         $row = $query->fetch();
         
         if($row){
            $memo = new Muistiinpano(array(
                 'id' => $row['id'],
                 'kayt_id' => $row['kayt_id'],
                 'name' => $row['name'],
                 'description' => $row['description'],
                 'added' => $row['added'],
                 'priority' => $row['priority'],
                 'done' => $row['done'],
             ));
            return $memo;
         }
         return null;
     }
         
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Muistiinpano (name, description, priority, added) VALUES (:name, :description, :priority, :added) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'priority' => $this->priority, 'added' => date("Y-m-d")));
        $row = $query->fetch();
//          Kint::trace();
//  Kint::dump($row);
        $this->id = $row['id'];
    }
 }
