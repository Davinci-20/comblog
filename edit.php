<?php require_once 'inc/header.php';
if (isset($_GET['user'])) {
    $slug = $_GET['user'];
    $user = DB::table('user')->where('slug', $slug)->getOne();
    if (!user) {
        Helper::redirect('404.php');
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $res = User::update($_POST);
        }
    }

} else {
    Helper::redirect('404.php');
}
?>


                                <div class="card card-dark">
                                        <div class="card-header bg-warning">
                                                <h3 style="text-align:center">Edit Your Profile</h3>
                                        </div>
                                        <div class="card-body">
                                                <!-- <div class="alert alert-danger">

                                                </div> -->
                                                 <?php
if (isset($res) and $res == 'success') {?>

                        <div class="alert alert-success">Profile Updated Success</div>
                    <?php
}

?>

                                                <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="slug" value="<?php echo $user['slug']; ?>">

                                                        <div class="form-group">

                                                                <input type="name" name="name" class="form-control"
                                                                value="<?php echo $user['name']; ?>">
                                                        </div>
                                                        <div class="form-group">

                                                                <input type="password" name="password" class="form-control"
                                                                placeholder="New Password">
                                                        </div>
                                                        <!-- <div class="form-group">

                                                                <input type="password" name="password" class="form-control"
                                                                        placeholder="New Password">
                                                        </div>
                                                        <div class="form-group">

                                                                <input type="password" name="password" class="form-control"
                                                                        placeholder="New Password Confirm">
                                                        </div> -->
                                                         <div class="form-group">

                                                                <input type="email" name="email" class="form-control"
                                                                        value="<?php echo $user['email']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="text-warning">Choose Image</label>
                           <input type="file" class="form-control" name="image" />
                           <img class="mt-3" src="<?php echo $user['image']; ?>" style="width:200px;border-radius:10px;" alt="pf">



                                                        </div>

                                                        <input type="submit" name="register" value="Create"
                                                                class="btn  btn-outline-warning mt-5">
                                                </form>
                                        </div>
                                </div>
<?php require_once 'inc/footer.php';?>