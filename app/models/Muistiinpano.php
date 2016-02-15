<?php
 class Muistiinpano extends BaseModel{
     public $id, $kayt_id, $name, $description, $added, $priority, $done;
     
     public function __construct($attributes) {
         parent::__construct($attributes);
         $this->validators = array('validate_name','validate_description','validate_priority');
     }
     public static function all($kayt_id){
         $query = DB::connection()->prepare('SELECT * FROM Muistiinpano WHERE kayt_id = :kayt_id');
         $query->execute(array('kayt_id' => $_SESSION['user']));
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
        $query = DB::connection()->prepare('INSERT INTO Muistiinpano (name, description, priority, added, kayt_id) VALUES (:name, :description, :priority, :added, :kayt_id) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'priority' => $this->priority, 'added' => date("Y-m-d"), 'kayt_id' => $_SESSION['user']));
        $row = $query->fetch();
//          Kint::trace();
//  Kint::dump($row);
        $this->id = $row['id'];
    }
    public function update(){
        $done;
        if(isset($_POST['done'])){
            $done = $_POST['done'];
        }else{
            $done=0;
        }
        $query = DB::connection()->prepare('UPDATE Muistiinpano SET '
                                        . 'description = \''.$this->description.'\', '
                                        . 'priority =\'' .$this->priority.'\', '
                                        . 'name =\''. $this->name. '\' WHERE id =' .$this->id);
        $query->execute();
        //$row = $query->fetch();
//          Kint::trace();
        //Kint::dump($row);
        //$this->id = $row['id'];
    }
    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Muistiinpano WHERE id =' . $this->id . ' RETURNING id');
        $query->execute();
        //$row = $query->fetch();
//          Kint::trace();
//  Kint::dump($row);
        //$this->id = $row['id'];
    }
    
    public function validate_name(){
        $errors = array();
//        if($this->name == '' || $this->name == null){
//            $errors[] = 'Nimi ei saa olla tyhjä';
//        }
//        if(strlen($this->name) < 3){
//            $errors[] = 'Nimen tulee olla vähintään kolme merkkiä';
//        }
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->name));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->name));
        return $errors;
    }
    public function validate_description(){
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->description));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->description));
        return $errors;
    }
    public function validate_priority(){
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->name));
        return $errors;
    }
 }
