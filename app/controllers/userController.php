<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos'));
    }

    public static function handle_login() {
        $params = $_POST;
        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttätunnus tai salasana', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/memo', array('message' => 'Tervetuloa takaisin ' . $user->name . '.'));
        }
    }

    public static function index() {
        self::check_logged_in();
        self::check_admin();
        $users = User::all();
        View::make('user/index.html', array('users' => $users));
    }

    public static function show($id) {
        self::check_admin();
        self::check_logged_in();
        $user = User::find($id);
        $ryhmat = Group::ryhmat($id);
        View::make('user/view.html', array('attributes' => $user, 'ryhmat' => $ryhmat));
    }

    public static function create() {
        self::check_logged_in();
        View::make('user/new.html');
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        if (isset($_POST['is_admin'])) {
            $attributes = array(
                'name' => $params['name'],
                'password' => $params['password'],
                'is_admin' => 1
            );
        } else {
            $attributes = array(
                'name' => $params['name'],
                'password' => $params['password'],
                'is_admin' => 0
            );
        }
        $user = new User($attributes);
        $errors = $user->errors();
        //Kint::dump($params);
        if (count($errors) == 0) {
            $user->save();
            Redirect::to('/user/' . $user->id, array('message' => 'Käyttäjä lisätty.'));
        } else {
            View::make('user/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $user = User::find($id);
        View::make('user/edit.html', array('attributes' => $user));
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        if (isset($_POST['is_admin'])) {
            $attributes = array(
                'id' => $id,
                'name' => $params['name'],
                'password' => $params['password'],
                'is_admin' => 1
            );
        } else {
            $attributes = array(
                'id' => $id,
                'name' => $params['name'],
                'password' => $params['password'],
                'is_admin' => 0
            );
        }
        //Kint::dump($params);
        $user = new User($attributes);
        $errors = $user->errors();

        if (count($errors) > 0) {
            View::make('user/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $user->update();
            Redirect::to('/user/' . $user->id, array('message' => 'Käyttäjää muokattu onnistuneesti'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $user = new User(array('id' => $id));
        $user->destroy();
        Redirect::to('/user', array('message' => 'Käyttäjä poistettu'));
    }

}
