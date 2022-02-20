<?php require_once 'inc/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $d = Post::create($_POST);

}

?>

                  <div class="card-header bg-warning">
                     <h3 style="text-align:center">Create New Article</h3>
                  </div>
                  <div class="card-body mt-5">
                    <?php
if (isset($d) and $d == 'success') {?>

                        <div class="alert alert-success">Article Created Success</div>
                    <?php
}

?>
                     <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="" class="text-warning">Enter Title</label>
                           <input
                              type="text"
                              name="title"
                              class="form-control"
                               placeholder="enter title"
                           />
                    </div>
                    <div class="form-group">
                           <label for="" class="text-warning">Choose Category</label>


                           <select name="category_id" id="" class="form-control">
                            <?php
$cat = DB::table('category')->get();
foreach ($cat as $c) {
    ?>
                              <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                            <?php
}
?>
                           </select>
                    </div>
                    <div class="form-check form-check-inline">
                       <?php
$lan = DB::table('language')->get();
foreach ($lan as $l) {
    ?>
                              <span class="mr-2">
                              <input
                                 class="form-check-input"
                                 type="checkbox"
                                 name="language_id[]"
                                 value="<?php echo $l['id']; ?>"
                              />
                              <label
                                 class="form-check-label"
                                 for="inlineCheckbox1"
                                 ><?php echo $l['name']; ?></label
                              >
                           </span>
                            <?php
}
?>
                    </div>
                        <br /><br />
                    <div class="form-group">
                           <label for="" class="text-warning">Choose Image</label>
                           <input
                              type="file"
                              class="form-control"
                              name="image"
                           />
                    </div>
                    <div class="form-group">
                           <label for="" class="text-warning"
                              >Enter Articles</label
                           >
                           <textarea
                              name="description"
                              class="form-control"
                              id=""
                              cols="30"
                              rows="10"
                           ></textarea>
                    </div>
                        <input
                           type="submit"
                           value="Create"
                           class="btn btn-outline-warning"
                        />
                     </form>
                  </div>
               </div>

<?php require_once 'inc/footer.php';?>
