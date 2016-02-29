<?php
class groupController extends BaseController{
    public static function index(){
        self::check_logged_in();
        self::check_admin();
        $groups = Group::all();
        View::make('group/index.html', array('groups' => $groups));
    }
    public static function show($id){
        self::check_admin();
        self::check_logged_in();
        $users = User::jasenet($id);
        $group = Group::find($id);
        View::make('group/view.html', array('attributes' => $group, 'users' => $users));
    }
        public static function create(){
        self::check_logged_in();
        View::make('group/new.html');
    } 
    public static function store(){
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
        );
        $group = new Group($attributes);
        $errors = $group->errors();
        
        if(count($errors) == 0){
            $group->save();
            Redirect::to('/group/'. $group->id, array('message'=>'Ryhmä lisätty.'));
        }
        else{
            View::make('group/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function edit($id){
        self::check_logged_in();
        $group = Group::find($id);
        View::make('group/edit.html', array('attributes' => $group));
    }
    
    public static function update($id){
        self::check_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
        );
        $group = new Group($attributes);
        $errors = $group -> errors();
        
        if(count($errors) > 0){
            View::make('group/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }else{
            $group->update();
            Redirect::to('/group/' . $group->id, array('message' => 'Ryhmää muokattu onnistuneesti'));
        }
    }
    public static function destroy($id){
        self::check_logged_in();
        $group = new User(array('id' => $id));
        $group->destroy();
        Redirect::to('/group', array('message' => 'Ryhmä poistettu'));
    }
}
