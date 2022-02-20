<?php

class Post
{
    public static function all()
    {
        $data = DB::table('articles')->orderBy('id', 'DESC')->paginate(4);
        foreach ($data['data'] as $k => $d) {

            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id', $d->id)->rowCount();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id', $d->id)->rowCount();

        }
        return $data;
    }

    public static function detail($slug)
    {
        $data = DB::table('articles')->where('slug', $slug)->getOne();

        //try to get like_count
        $data['like_count'] = DB::table('article_like')->where('article_id', $data['id'])->rowCount();

        //try to get comment_count
        $data['comment_count'] = DB::table('article_comment')->where('article_id', $data['id'])->rowCount();

        //try to get category
        $data['category'] = DB::table('category')->where('id', $data['category_id'])->getOne();

        //try to get languages
        $data['languages'] = DB::raw("SELECT language.id,language.slug,language.name from article_language
LEFT JOIN language on language.id=article_language.language_id
where article_id={$data['id']}")->get();

        //try to get comments
        $data['comments'] = DB::table('article_comment')->where('article_id', $data['id'])->get();
        return $data;
    }
    public static function articleBycategory($slug)
    {
        $category = DB::table('category')->where('slug', $slug)->getOne();
        $data = DB::table('articles')->where('category_id', $category['id'])->orderBy('id', 'DESC')->paginate(2, "category=$slug");
        foreach ($data['data'] as $k => $d) {

            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id', $d->id)->rowCount();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id', $d->id)->rowCount();

        }
        return $data;
    }
    public static function articleBylanguage($slug)
    {
        $language = DB::table('language')->where('slug', $slug)->getOne();
        $data = DB::raw("
        select * from article_language
inner join articles on articles.id=article_language.article_id
where article_language. language_id={$language['id']};
        ")->orderBy('articles.id', 'DESC')->paginate(2, "language=$slug");
        foreach ($data['data'] as $k => $d) {

            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id', $d->id)->rowCount();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id', $d->id)->rowCount();

        }
        return $data;
    }
    public static function create($request)
    {

        //image upload
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $path = "assets/article_img/$image_name";
        $tmp_name = $image['tmp_name'];
        if (move_uploaded_file($tmp_name, $path)) {
            //create articles
            $article = DB::create('articles', [
                'slug' => Helper::slug($request['title']),
                'title' => $request['title'],
                'image' => $path,
                'category_id' => $request['category_id'],
                'user_id' => User::auth()['id'],
                'description' => $request['description'],
            ]);

//insert many to many
            if ($article) {
                foreach ($request['language_id'] as $id) {
                    DB::create('article_language', [
                        'article_id' => $article['id'],
                        'language_id' => $id,
                    ]);
                    //return success

                    return 'success';

                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
    public static function search($search)
    {
        $data = DB::table('articles')->where('title', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(4, "search=$search");
        foreach ($data['data'] as $k => $d) {

            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id', $d->id)->rowCount();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id', $d->id)->rowCount();

        }
        return $data;
    }

    public static function mypost($id)
    {
        $data = DB::table('articles')->where('user_id', $id)->orderBy('id', 'DESC')->paginate(4, "id=$id");
        foreach ($data['data'] as $k => $d) {

            $data['data'][$k]->comment_count = DB::table('article_comment')->where('article_id', $d->id)->rowCount();
            $data['data'][$k]->like_count = DB::table('article_like')->where('article_id', $d->id)->rowCount();

        }
        return $data;
    }
}
