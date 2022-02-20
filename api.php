<?php
require_once 'core/autoload.php';
$request = $_GET;
if (isset($request['like'])) {
    $user_id = $request['user_id'];
    $article_id = $request['article_id'];

    $u = DB::table('article_like')->where('user_id', $user_id)->andwhere('article_id', $article_id)->getOne();

    if ($u) {
        echo 'already_liked';

    } else {

        $user = DB::create('article_like', [
            'user_id' => $user_id,
            'article_id' => $article_id,
        ]);
        if ($user) {
            $count = DB::table('article_like')->where('article_id', $article_id)->rowCount();

            echo $count;
        }

    }
}
if ($_POST['comment']) {
    $user_id = User::auth()['id'];
    $article_id = $_POST['article_id'];
    $comment = $_POST['comment'];

    $comment = DB::create('article_comment', [
        'user_id' => $user_id,
        'article_id' => $article_id,
        'comment' => $comment,
    ]);
    if ($comment) {
        // $count = DB::table('article_like')->where('article_id', $article_id)->rowCount();
        // echo $count;

        $cmt = DB::table('article_comment')->where('article_id', $article_id)->orderBy('id', DESC)->get();
        $html = "";
        foreach ($cmt as $c) {
            $user = DB::table('user')->where('id', $c['user_id'])->getOne();
            $html .= "
                                                            <div class='card-body'>
                                                                               <div class='row'>
                                                                                        <div class='col-md-1'>
                                                                                                <img src='{$user['image']}'
                                                                                                        style='width:50px;height:40px;border-radius:50%'
                                                                                                        alt=''>
                                                                                        </div>
                                                                                        <div
                                                                                                class='col-md-4 d-flex align-items-center'>
                                                                                              {$user['name']}
                                                                                        </div>
                                                                                </div>
                                                                                <hr>
                                                                                <p>
                                                                                {$c['comment']}
                                                                                </p>
                                                                        </div>
                                                                </div>
            ";
        }
        echo $html;

    }

}
