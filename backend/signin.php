<?php require_once("../inc/db.php"); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>SIGN IN || Admin Panel</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="js/all.min.js"></script>
        <script src="js/feather.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                            <?php
                                if(isset($_POST['submit']))
                                {
                                    $errors = array();
                                    $email = trim($_POST['email']);
                                    $pass  = trim($_POST['password']);

                                    $sql  = "SELECT * FROM users WHERE user_email = :email";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([
                                        ':email' => $email,
                                    ]);
                                    $count = $stmt->rowCount();

                                    if($count == 0)
                                    {
                                        $errors[] = "Email does not exist";
                                    }elseif($count > 1){
                                        $errors[] = "ERROR CREDINTIALS";
                                    }elseif($count == 1){

                                        $user      = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $hash_pass = $user['user_password'];

                                        if(password_verify($pass, $hash_pass)){
                                            $sucess = "Sign in successful!";
                                        }else{
                                            $errors[] = "Your password is invalid. Please try again.";
                                        }
                                    }
                                }

                            ?>
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="font-weight-light my-4">SIGN IN</h3></div>
                                    <div class="card-body">
                                        <form action="signin.php" method="post">
                                        <?php
                                            if(isset($errors)) {
                                                foreach($errors as $error):
                                                    echo "<div class='alert alert-danger text-center'>{$error}</div><br>";
                                                endforeach;
                                            }if(isset($sucess)) {
                                                echo "<div class='alert alert-success text-center'>
                                                        {$sucess}
                                                      </div>";
                                            }
                                        ?>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:'' ?>" class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input name="password" value="<?php echo isset($_POST['password'])?$_POST['password']:'' ?>" class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" required/>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="check" class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="#"></a>
                                                <button name="submit" class="btn btn-primary btn-block" href="index.html">SIGN IN</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="signup.html">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!--Script JS-->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
