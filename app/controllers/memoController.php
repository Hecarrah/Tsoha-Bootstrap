<?php
class memoController extends BaseController{
    public static function index(){
        self::check_logged_in();
        $memos = Muistiinpano::all(BaseController::get_user_logged_in());
        View::make('memo/index.html', array('memos' => $memos));
    }
    public static function show($id){
        self::check_logged_in();
        $memo = Muistiinpano::find($id);
        View::make('memo/view.html', array('memo' => $memo));
    }
    public static function create(){
        self::check_logged_in();
        View::make('memo/new.html');
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
    
    public static function edit($id){
        self::check_logged_in();
        $memo = Muistiinpano::find($id);
        View::make('memo/edit.html', array('attributes' => $memo));
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
    public static function destroy($id){
        self::check_logged_in();
        $memo = new Muistiinpano(array('id' => $id));
        $memo->destroy();
        Redirect::to('/memo', array('message' => 'Muistiinpano poistettu'));
    }
}

