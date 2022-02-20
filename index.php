<?php require_once 'inc/header.php';
if (isset($_GET['category'])) {
    $slug = $_GET['category'];
    $post = Post::articleBycategory($slug);

} elseif (isset($_GET['language'])) {

    $slug = $_GET['language'];
    $post = Post::articleBylanguage($slug);

} elseif (isset($_GET['search'])) {
    $search = $_GET['search'];
    $post = Post::search($search);

} else {
    $post = Post::all();

}
// echo "<pre>";
// print_r($post);

// die();

?>

 <div class="card-body">
                     <a href="<?php echo $post['prev_page']; ?>" class="btn btn-danger">Prev Posts</a>
                     <a href="<?php echo $post['next_page']; ?>" class="btn btn-danger float-right"
                        >Next Posts</a
                     >
                  </div>
               </div>
               <div class="card card-dark">
                  <div class="card-body">
                     <div class="row">
                        <!-- Loop this -->
                        <?php

// echo "<pre>";
// print_r($post);

foreach ($post['data'] as $a) {?>

                           <div class="col-md-6 mt-3">
                           <div class="card" style="width: 15rem;margin-left:3px;">
                                  <img
                                 class="card-img-top "
                                 style="width:300px;height:150px;"
                                 src="<?php echo $a->image; ?>"
                                 alt="Card image cap"
                              />
                              <div class="card-body">
                                 <h6 class="text-dark"><?php echo $a->title; ?><h6>
                              </div>
                              <div class="card-footer">
                                 <div class="row">
                                    <div class="col-md-3 text-center">

                                       <i class="fas fa-heart text-warning">
                                       </i>
                                       <small class="text-muted"><?php echo $a->like_count; ?></small>
                                    </div>

                                    <div class="col-md-4 text-center">
                                       <i class="far fa-comment text-dark"></i>
                                       <small class="text-muted"><?php echo $a->comment_count; ?></small>
                                    </div>
                                    <div class="col-md-5 text-center">
                                       <a
                                          href="<?php echo "detail.php?slug=$a->slug"; ?>"
                                          class="badge badge-warning p-1"
                                          >View</a
                                       >
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <?php
}
?>




<?php require_once 'inc/footer.php';?>
