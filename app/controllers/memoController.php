<?php
class memoController extends BaseController{
    public static function index(){
        $memos = Muistiinpano::all();
        View::make('memo/index.html', array('memos' => $memos));
    }
    public static function show($id){
        $memo = Muistiinpano::find($id);
        View::make('memo/view.html', array('memo' => $memo));
    }
    public static function create(){
        View::make('memo/new.html');
    }
    
    public static function store(){
        $params = $_POST;
        $memo = new Muistiinpano(array(
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
        ));
//        Kint::dump($params);
        $memo->save();
        Redirect::to('/memo/'. $memo->id, array('message'=>'Muistiinpano lisätty.'));
    }
}

