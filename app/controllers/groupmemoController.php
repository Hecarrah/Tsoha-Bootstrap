<?php

class groupmemoController extends BaseController {

    public static function show($id) {
        self::check_logged_in();
        $memo = Memo::findwgroup($id);
        View::make('groupmemo/view.html', array('memo' => $memo));
    }

    public static function create() {
        self::check_logged_in();
        $group = Group::ryhmat($_SESSION['user']);
        View::make('groupmemo/new.html', array('group' => $group));
    }

    public static function edit($id) {
        self::check_logged_in();
        $memo = Memo::findwgroup($id);
        View::make('groupmemo/edit.html', array('attributes' => $memo));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'ryh_id' => $params['group'],
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
        );

        $memo = new Memo($attributes);
        $errors = $memo->errors();
//       Kint::dump($params);
        if (count($errors) == 0) {
            $memo->groupsave();
            Redirect::to('/groupmemo/' . $memo->id, array('message' => 'Muistiinpano lisätty.'));
        } else {
            $group = Group::ryhmat($_SESSION['user']);
            Kint::dump($group);
            View::make('groupmemo/new.html', array('errors' => $errors, 'attributes' => $attributes, 'group' => $group));
        }
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
            'done' => isset($_POST['done'])
        );
        //Kint::dump($params);
        $memo = new Memo($attributes);
        $errors = $memo->errors();

        if (count($errors) > 0) {
            View::make('groupmemo/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $memo->groupupdate();
            Redirect::to('/groupmemo/' . $memo->id, array('message' => 'Muistiinpanoa muokattu onnistuneesti'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $memo = new Memo(array('id' => $id));
        $memo->groupdestroy();
        Redirect::to('/groupmemo', array('message' => 'Muistiinpano poistettu'));
    }

}
