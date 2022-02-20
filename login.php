<?php require_once 'inc/header.php';
if (User::auth()) {
    Helper::redirect('index.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $u = new User();
    $user = $u->login($_POST);

    if ($user == 'success') {

        Helper::redirect("index.php");

    }

}
?>
  <div class="card card-dark">
                                        <div class="card-header bg-warning">
                                                <h3 style="text-align:center">Login</h3>
                                        </div>
                                        <div class="card-body">
                                                <?php

if (isset($user) and is_array($user)) {
    foreach ($user as $e) {
        ?>


                                                <div class="alert alert-danger">
                                                        <?php echo $e; ?>
                                                </div>

                                                <?php
}
}
?>
                                                <form action="" method="post">
                                                         <div class="form-group">
                                                               <!-- <i class="far fa-envelope"></i> -->
                                                               <input type="email" class="form-control" name="email"
                                                                        placeholder="Email">
                                                        </div>
                                                        <div class="form-group">

                                                                <input type="password" class="form-control" name="password"
                                                                        placeholder="Password">
                                                        </div>
                                                        <input type="submit" value="Login"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>

<?php require_once 'inc/footer.php';?>