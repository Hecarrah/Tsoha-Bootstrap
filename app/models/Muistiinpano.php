<?php
 class Muistiinpano extends BaseModel{
     public $id, $kayt_id, $name, $description, $added, $priority, $groupname, $username, $ryh_id;
     
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
                 'priority' => $row['priority']
             ));
         }
         return $memos;
     }
     public static function ryh_all($attr){
         $query = DB::connection()->prepare('SELECT RyhmaMuistiinpano.id, Ryhmamuistiinpano.kayt_id, Ryhmamuistiinpano.name,'
                 . 'Ryhmamuistiinpano.description, Ryhmamuistiinpano.added, Ryhmamuistiinpano.priority, ryhma.name as groupname FROM ryhma, RyhmaMuistiinpano, Kayttaja, Kayt_ryhma WHERE kayttaja.id = :attr AND ryhma.id = kayt_ryhma.ryhma_id AND kayttaja.id = kayt_ryhma.kayt_id AND RyhmaMuistiinpano.ryh_id = kayt_ryhma.ryhma_id;');
         $query->execute(array('attr' => $_SESSION['user']));
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
                 'groupname' => $row['groupname']
             ));
         }
         return $memos;
     }
     
     public static function find($id){
         $query = DB::connection()->prepare('SELECT muistiinpano.id, Muistiinpano.kayt_id, Muistiinpano.name, description, added, priority, kayttaja.name as username FROM Muistiinpano, kayttaja, ryhma WHERE muistiinpano.id = :id AND muistiinpano.kayt_id = kayttaja.id LIMIT 1');
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
                 'username' => $row['username'],
             ));
            return $memo;
         }
         return null;
     }
     public static function findwgroup($id){
         $query = DB::connection()->prepare('SELECT Ryhmamuistiinpano.id, RyhmaMuistiinpano.kayt_id, RyhmaMuistiinpano.name, description, added, priority, kayttaja.name as username, ryhma.name as groupname FROM RyhmaMuistiinpano, kayttaja, ryhma WHERE Ryhmamuistiinpano.id = :id LIMIT 1');
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
                 'username' => $row['username'],
                 'groupname' => $row['groupname'],
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
    public function groupsave(){
        $query = DB::connection()->prepare('INSERT INTO RyhmaMuistiinpano (name, description, priority, added, kayt_id, ryh_id) VALUES (:name, :description, :priority, :added, :kayt_id, :ryh_id) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'priority' => $this->priority, 'added' => date("Y-m-d"), 'kayt_id' => $_SESSION['user'], 'ryh_id' => $this->ryh_id));
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
    }
    public function groupupdate(){
        $done;
        if(isset($_POST['done'])){
            $done = $_POST['done'];
        }else{
            $done=0;
        }
        $query = DB::connection()->prepare('UPDATE RyhmaMuistiinpano SET '
                                        . 'description = \''.$this->description.'\', '
                                        . 'priority =\'' .$this->priority.'\', '
                                        . 'name =\''. $this->name. '\' WHERE id =' .$this->id);
        $query->execute();
    }
    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Muistiinpano WHERE id =' . $this->id . ' RETURNING id');
        $query->execute();
    }
    public function groupdestroy(){
        $query = DB::connection()->prepare('DELETE FROM RyhmaMuistiinpano WHERE id =' . $this->id . ' RETURNING id');
        $query->execute();
    }
    
    public function validate_name(){
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->name));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->name));
        $errors = array_merge($errors, BaseModel::validate_not_whitespace($this->name));
        return $errors;
    }
    public function validate_description(){
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->description));
        $errors = array_merge($errors, BaseModel::validate_String_lenght($this->description));
        $errors = array_merge($errors, BaseModel::validate_not_whitespace($this->name));
        return $errors;
    }
    public function validate_priority(){
        $errors = array();
        $errors = array_merge($errors, BaseModel::validate_String_not_null($this->priority));
        $errors = array_merge($errors, BaseModel::validate_not_whitespace($this->priority));
        return $errors;
    }
 }
