<?php
class memoController extends BaseController{
    public static function index(){
        self::check_logged_in();
        $ryhmemos = Muistiinpano::ryh_all(BaseController::get_user_logged_in());
        $memos = Muistiinpano::all(BaseController::get_user_logged_in());
        View::make('memo/index.html', array('memos' => $memos, 'ryhmemos' => $ryhmemos));
    }
    public static function show($id){
        self::check_logged_in();
        $memo = Muistiinpano::find($id);
        View::make('memo/view.html', array('memo' => $memo));
    }
    public static function groupshow($id){
        self::check_logged_in();
        $memo = Muistiinpano::findwgroup($id);
        View::make('groupmemo/view.html', array('memo' => $memo));
    }
    public static function create(){
        self::check_logged_in();
        View::make('memo/new.html');
    } 
    public static function groupcreate(){
        self::check_logged_in();
        $group = Group::ryhmat($_SESSION['user']);
        View::make('groupmemo/new.html', array('group' => $group));
    } 
    public static function store(){
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
        );
        
        $memo = new Muistiinpano($attributes);
        $errors = $memo->errors();
//       Kint::dump($params);
        if(count($errors) == 0){
            $memo->save();
            Redirect::to('/memo/'. $memo->id, array('message'=>'Muistiinpano lisätty.'));
        }
        else{
            View::make('memo/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    public static function groupstore(){
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'ryh_id' => $params['group'],
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
        );
        
        $memo = new Muistiinpano($attributes);
        $errors = $memo->errors();
//       Kint::dump($params);
        if(count($errors) == 0){
            $memo->groupsave();
            Redirect::to('/groupmemo/'. $memo->id, array('message'=>'Muistiinpano lisätty.'));
        }
        else{
            $group = Group::ryhmat($_SESSION['user']);
            Kint::dump($group);
            View::make('groupmemo/new.html', array('errors' => $errors, 'attributes' => $attributes, 'group' => $group));
            
        }
    }
    
    public static function edit($id){
        self::check_logged_in();
        $memo = Muistiinpano::find($id);
        View::make('memo/edit.html', array('attributes' => $memo));
    }
    public static function groupedit($id){
        self::check_logged_in();
        $memo = Muistiinpano::findwgroup($id);
        View::make('groupmemo/edit.html', array('attributes' => $memo));
    }
    
    public static function update($id){
        self::check_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
            //'kayt_id' => $params['kayt_id'],
           // 'added' => $params['added'],
            'done' => isset($_POST['done'])
        );
        Kint::dump($params);
        $memo = new Muistiinpano($attributes);
        $errors = $memo -> errors();
        
        if(count($errors) > 0){
            View::make('memo/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }else{
            $memo->update();
            Redirect::to('/memo/' . $memo->id, array('message' => 'Muistiinpanoa muokattu onnistuneesti'));
        }
    }
    public static function groupupdate($id){
        self::check_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
            'done' => isset($_POST['done'])
        );
        Kint::dump($params);
        $memo = new Muistiinpano($attributes);
        $errors = $memo -> errors();
        
        if(count($errors) > 0){
            View::make('groupmemo/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }else{
            $memo->groupupdate();
            Redirect::to('/groupmemo/' . $memo->id, array('message' => 'Muistiinpanoa muokattu onnistuneesti'));
        }
    }
    public static function destroy($id){
        self::check_logged_in();
        $memo = new Muistiinpano(array('id' => $id));
        $memo->destroy();
        Redirect::to('/memo', array('message' => 'Muistiinpano poistettu'));
    }
    public static function groupdestroy($id){
        self::check_logged_in();
        $memo = new Muistiinpano(array('id' => $id));
        $memo->groupdestroy();
        Redirect::to('/groupmemo', array('message' => 'Muistiinpano poistettu'));
    }
}

