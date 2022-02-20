<?php

class User
{

    //auth
    public static function auth()
    {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            return DB::table('user')->where('id', $user_id)->getOne();

        }
        return false;
    }

    public function login($request)
    {
        $error = [];
        $email = Helper::filter($request['email']);
        $password = $request['password'];

        //check email
        $user = DB::table('user')->where('email', $email)->getOne();

        //password verify
        if ($user) {
            $db_password = $user['password'];

            if (password_verify($password, $db_password)) //hash pass
            {
                $_SESSION['user_id'] = $user['id'];
                return 'success';
            } else {
                //password wrong
                $error[] = "Password Wrong!";
            }
        } else {
            //email not found
            $error[] = "Email not found!";
        }
        return $error;
    }

    public function register($request)
    {
        $error = [];
        if (isset($request)) {
            if (empty($request['name'])) {
                $error[] = "Name is Required";
            }
            if (empty($request['password'])) {
                $error[] = "Password is Required";
            }
            if (empty($request['email'])) {
                $error[] = "Email is Required";
            }
            if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                $error[] = "Invalid email format";
            }
            //check email already exist?
            $user = DB::table('user')->where('email', $request['email'])->getOne();
            if ($user) {
                $error[] = "This email is already exist.";
            }

            if (count($error)) {
                return $error;
            } else {

                //insert
                $user = DB::create('user', [
                    'name' => Helper::filter($request['name']),
                    'email' => Helper::filter($request['email']),
                    'password' => password_hash($request['password'], PASSWORD_BCRYPT),
                    'slug' => Helper::slug($request['name']),
                ]);

                //session

                $_SESSION['user_id'] = $user['id'];

                return 'success';
            }

        }

    }
    public function update($request)
    {
        $user = DB::table('user')->where('slug', $request['slug'])->getOne();

        if ($request['password']) {
            $password = password_hash($request['password'], PASSWORD_BCRYPT);
        } else {
            $password = $user['password'];
        }

        if (isset($_FILES['image'])) {
            $image = $_FILES['image'];
            $image_name = $image['name'];
            $path = "assets/edit_img/$image_name";
            $tmp_name = $image['tmp_name'];
            move_uploaded_file($tmp_name, $path);
        } else {
            $path = $user['image'];
        }

        //insert
        $edit_user = DB::update('user', [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $password,
            'image' => $path,

        ], $user['id']);

        return 'success';
    }

}
