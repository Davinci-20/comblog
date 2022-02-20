<?php
require_once 'core/autoload.php';
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8" />
      <meta
         name="viewport"
         content="width=device-width, initial-scale=1, shrink-to-fit=no"
      />

      <!--  Font Awesome for Bootstrap fonts and icons -->
      <link
         rel="stylesheet"
         href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
      />

      <!-- Material Design for Bootstrap CSS -->
      <link
         rel="stylesheet"
         href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css"
         integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX"
         crossorigin="anonymous"
      />

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
     <link rel="stylesheet" href="assets/style.css" />
      <title>Davinci-20</title>

   </head>

   <body>
      <!-- Start Nav -->
      <nav class="navbar navbar-expand-lg">
         <a class="navbar-brand text-warning" href="#"><h1>Davinci</h1></a>
         <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
         >
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="index.php"
                     >Home <span class="sr-only">(current)</span></a
                  >
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="index.php">Articles</a>
               </li>
               <li class="nav-item dropdown">
                  <a
                     class="nav-link dropdown-toggle"
                     href="#"
                     id="navbarDropdown"
                     role="button"
                     data-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false"
                  >
                     USER
                  </a>
                  <div class="dropdown-menu" style="width:15rem" aria-labelledby="navbarDropdown">
                     <?php
if (User::auth()) {?>
             <a class="dropdown-item" href=""><i class="fa fa-user-circle"></i>&nbsp;<?php echo User::auth()['name']; ?></a>
             <a class="dropdown-item" href="edit.php?user=<?php echo User::auth()['slug']; ?>"><i class='fas fa-wrench' style='font-size:18px'></i>&nbsp;Edit Profile</a>
               <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                     <?php
} else {?>
                        <!-- <a class="dropdown-item" href="index.php">Home</a> -->
                            <a class="dropdown-item" href="login.php"><i class="fas fa-sign-in-alt"></i>&nbsp;Login</a>
                              <a class="dropdown-item" href="register.php"><i class="fa fa-user-plus"></i>&nbsp;Create Acc</a>
                       <?php }
?>




                  </div>
                  <?php

if (User::auth()) {?>

                   <li class="nav-item">
                     <a class="nav-link" href="mypost.php?user=<?php echo User::auth()['id']; ?>"
>My Posts</a>
                  </li>

               <?php }?>
               <!-- </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.php">About</a>
               </li> -->
               <?php
if (User::auth()) {?>
               <li class="nav-item ml-5">
                  <a class="nav-link btn btn-sm btn-warning" href="create.php">
                     <i class="fas fa-plus"></i>
                     Create Article</a
                  >
               </li>
            <?php
}
?>

            </ul>
            <form action="index.php" class="form-inline my-2 my-lg-0" method="get">
               <input
                  class="form-control mr-sm-2"
                  type="search"
                  name="search"
                  placeholder="Search"
                  aria-label="Search"
               />
               <button
                  class="btn btn-outline-success my-2 my-sm-0"
                  type="submit"
               >
                  Search
               </button>
            </form>
         </div>
      </nav>

      <!-- Start Header -->

      <div class="jumbotron jumbotron-fluid header">
         <div class="container">


            <?php
if (User::auth()) {
    ?>
            <div class="effect"><h1>Welcome <?php echo User::auth()['name']; ?></h1></div>
         <?php
} else {?>
          <h1 class="display-4 text-white">
               Welcome From My Blog!
            </h1>

            <br />
         <a href="register.php" class="btn btn-warning">Create Account</a>
            <a href="login.php" class="btn btn-outline-success">Login</a>

      <?php

}

?>

         </div>
      </div>

      <!-- Content -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-4 pr-3 pl-3">
               <!-- Category List -->
               <div class="card card-dark">
                  <div class="card-header">
                     <h4>All Category</h4>
                  </div>
                  <div class="card-body">
                     <?php
$category = DB::raw('select * ,
                    (select count(id) from articles where category_id=category.id) as article_count from category;')->get();
?>

                     <ul class="list-group">
                        <?php
foreach ($category as $c) {
    ?>
                        <a href="index.php?category=<?php echo $c['slug']; ?>">
                     <li
                           class="list-group-item d-flex justify-content-between align-items-center"
                        >
                           <?php echo $c['name']; ?>
                           <span class="badge badge-primary badge-pill"
                              ><?php echo $c['article_count']; ?></span
                           >
                        </li>
               </a>
                        <?php
}
?>


                     </ul>
                  </div>
               </div>
               <hr />
               <!-- Language List -->
               <div class="card card-dark">
                  <div class="card-header">
                     <h4>All Languages</h4>
                  </div>

                  <div class="card-body">
                     <?php
$language = DB::raw('select * ,
                    (select count(id) from  article_language
                    where language_id=language.id) as article_count
                    from language;')->get();?>

   <ul class="list-group">
   <?php foreach ($language as $l) {?>
      <a href="index.php?language=<?php echo $l['slug']; ?>">
                        <li
                           class="list-group-item d-flex justify-content-between align-items-center"
                        >
                           <?php echo $l['name']; ?>
                           <span class="badge badge-primary badge-pill"
                              ><?php echo $l['article_count']; ?></span
                           >
                        </li>
   </a>
                     </ul>

<?php
}
?>

                  </div>
               </div>
            </div>

            <!-- Content -->
            <div class="col-md-8">
               <div class="card card-dark">