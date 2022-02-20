<?php require_once 'inc/header.php';

if (User::auth()) {
    Helper::redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $user = $user->register($_POST);

    if ($user == 'success') {

        Helper::redirect("index.php");

    }
}
?>


                                <div class="card card-dark">
                                        <div class="card-header bg-warning">
                                                <h3 style="text-align:center">Create Account</h3>
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

                                                                <input type="name" name="name" class="form-control"
                                                                        placeholder="Username">
                                                        </div>
                                                        <div class="form-group">

                                                                <input type="password" name="password" class="form-control"
                                                                        placeholder="Password">
                                                        </div>
                                                         <div class="form-group">

                                                                <input type="email" name="email" class="form-control"
                                                                        placeholder="Email">
                                                        </div>


                                                        <input type="submit" name="register" value="Create"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>
<?php require_once 'inc/footer.php';?>