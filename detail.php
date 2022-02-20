<?php require_once 'inc/header.php';
if (!isset($_GET['slug'])) {
    Helper::redirect('404.php');
} else {
    $slug = $_GET['slug'];
    $article = Post::detail($slug);
//        echo "<pre>";
    //        print_r($article);
}

?>

                <div class="card-body">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="card card-dark">
                                                                        <div class="card-body">
                                                                                           <div class="row">
                                                                                        <!-- icons -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div class="col-md-4 text-center">
                                                                                                                <?php
$user_id = User::auth() ? User::auth()['id'] : 0;
$article_id = $article['id'];
?>


                                                                                                                <i id="like" class="fas fa-heart text-warning" user_id="<?php echo $user_id; ?>" article_id="<?php echo $article_id; ?>"></i>


                                                                                                                <small id="like_count"
                                                                                                                        class="text-muted"><?php echo $article['like_count']; ?></small>
                                                                                                        </div>
                                                                                                        <div class="col-md-4 text-center">
                                                                                                                <i
                                                                                                                        class="far fa-comment text-dark"></i>
                                                                                                                <small id="comment_count"
                                                                                                                        class="text-muted"><?php echo $article['comment_count']; ?></small>
                                                                                                        </div>

                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- Icons -->

                                                                                        <!-- Category -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div
                                                                                                                class="col-md-12">
                                                                                                                <a href=""
                                                                                                                        class="badge badge-primary"><?php echo $article['category']['name']; ?></a>

                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>


                                                                                        <!-- language -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div
                                                                                                                class="col-md-12">
                                                                                                                <?php foreach ($article['languages'] as $l) {?>

                                                                                                                   <a href=""
                                                                                                                        class="badge badge-success"><?php echo $l['name'];
    ?>
                                                                                                                </a>
                                                                                                                <?php
}
?>


                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>


                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                        <h3 class="text text-center"><?php echo $article['title']; ?></h3>
                                                        <p>
                                                                <?php echo $article['description']; ?>

                                                        </p>
                                                </div>
                                                <!-- Create comments -->
                                                <div class="card card-dark w-100">

                                                                <?php
if (User::auth()) {
    ?>                                                           <div class="card-body">
                                                                <form method="POST" action="" id="frmCmt">
                                                                        <input type="text" id="comment" placeholder="Write Comment" class="form-control">
                                                                        <input type="submit" value="Create" class="btn btn-outline-warning mt-3 float-right">
                                                                </form>
                                                                </div>
                                                        <?php }?>



                                                </div>
                                                <!-- Comments -->
                                                <div class="card card-dark">
                                                        <div class="card-header">
                                                                <h4>Comments</h4>
                                                        </div>

                                                <div class="card-body">
                                                        <div id="comment_list">
                                                                          <!-- Loop Comment -->
                                                                <?php foreach ($article['comments'] as $c) {?>

                                                                <div class="card-dark mt-1">
                                                                        <div class="card-body">
                                                                                <div class="row">
                                                                                        <div class="col-md-1">
                                                                                                <img src="<?php $image = DB::table('user')->where('id', $c['user_id'])->getOne();
    echo $image['image'];?>"
                                                                                                        style="width:50px;height:50px;border-radius:60%"
                                                                                                        alt="">
                                                                                        </div>
                                                                                        <div
                                                                                                class="col-md-4 d-flex align-items-center">
                                                                                               <?php $user = DB::table('user')->where('id', $c['user_id'])->getOne();
    echo $user['name'];
    ?>
                                                                                        </div>
                                                                                </div>
                                                                                <hr>
                                                                                <p><?php echo $c['comment']; ?></p>
                                                                        </div>

                                                                </div>
                                                                 <?php
}
?>


<div>

                                                </div>
</div>

</div>







<?php require_once 'inc/footer.php';?>
<script>

//comment
//var comment_count=document.querySelector('#comment_count');
var frmCmt=document.getElementById("frmCmt");
frmCmt.addEventListener("submit",function(event){
        event.preventDefault();

        var data=new FormData();
        data.append('comment',document.getElementById('comment').value);
        data.append('article_id',<?php echo $article['id']; ?>);
        //console.log(data);



        axios.post('api.php',data)
        .then(function(res){

        document.getElementById('comment_list').innerHTML=res.data;

        })
})

//like
var like=document.querySelector('#like');
var like_count=document.querySelector('#like_count');
like.addEventListener("click",function(){
        var user_id=like.getAttribute('user_id');
        var article_id=like.getAttribute('article_id');

        if(user_id==0){
                location.href='login.php';
        }


axios.get(`api.php?like&user_id=${user_id}&article_id=${article_id}`)
.then(function(res){
        if(res.data=='already_liked'){
              toastr.warning("Already Liked");

        }

        if(Number.isInteger(res.data)){
                like_count.innerHTML=res.data;
                toastr.success("Success");


        }


})


})
</script>