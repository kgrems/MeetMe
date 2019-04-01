<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php
if ( is_post_request() ) {
    $person = find_person_by_email($_SESSION['email']);

    $current_dir = getcwd();
    $upload_directory = "/uploads/";

    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp_name  = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $tmp = explode('.',$file_name);
    $file_extension = strtolower(end($tmp));

    $upload_path = $current_dir . $upload_directory . basename($file_name);

    $file_data['name'] = $file_name;
    $file_data['path'] = $upload_directory . basename($file_name);
    $file_data['extension'] = $file_extension;
    $file_data['size'] = $file_size;

    $result = update_avatar($person, $file_data);

    if ( $result === true ) {
        //passed validation (file size, type) now try to move
        $did_upload = move_uploaded_file($file_tmp_name, $upload_path);
        if($did_upload){
            redirect_to( url_for( '../public/home.php' ) );
        }else{
            $errors['file_other'] = "Unknown error occurred.";
        }

    } else {
        $errors = $result;
    }

}else{
    $person = find_person_by_email($_SESSION['email']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>

        Edit Avatar | MeetMe

    </title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="../css/toolkit.css" rel="stylesheet">

    <link href="../css/application.css" rel="stylesheet">

    <style>
        /* note: this is a hack for ios iframe for bootstrap themes shopify page */
        /* this chunk of css is not part of the toolkit :) */
        body {
            width: 1px;
            min-width: 100%;
            *width: 100%;
        }

    </style>

</head>


<body class="with-top-navbar">



<div class="growl" id="app-growl"></div>

<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary app-navbar">

    <a class="navbar-brand" href="index.html">
        <img src="../img/brand-white.png" alt="brand">
    </a>

    <button
        class="navbar-toggler navbar-toggler-right d-md-none"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
        aria-controls="navbarResponsive"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile/index.html">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" href="#msgModal">Messages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>

            <li class="nav-item d-md-none">
                <a class="nav-link" href="notifications/index.html">Notifications</a>
            </li>
            <li class="nav-item d-md-none">
                <a class="nav-link" data-action="growl">Growl</a>
            </li>
            <li class="nav-item d-md-none">
                <a class="nav-link" href="login/index.html">Logout</a>
            </li>

        </ul>

        <form class="form-inline float-right d-none d-md-flex">
            <input class="form-control" type="text" data-action="grow" placeholder="Search">
        </form>

        <ul id="#js-popoverContent" class="nav navbar-nav float-right mr-0 d-none d-md-flex">
            <li class="nav-item">
                <a class="app-notifications nav-link" href="notifications/index.html">
                    <span class="icon icon-bell"></span>
                </a>
            </li>
            <li class="nav-item ml-2">
                <button class="btn btn-default navbar-btn navbar-btn-avatar" data-toggle="popover">
                    <img class="rounded-circle" src="../img/avatar-dhg.png">
                </button>
            </li>
        </ul>

        <ul class="nav navbar-nav d-none" id="js-popoverContent">
            <li class="nav-item"><a class="nav-link" href="#" data-action="growl">Growl</a></li>
            <li class="nav-item"><a class="nav-link" href="login/index.html">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Messages</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body p-0 js-modalBody">
                <div class="modal-body-scroller">
                    <div class="media-list media-list-users list-group js-msgGroup">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-fat.jpg">
                                <div class="media-body">
                                    <strong>Jacob Thornton</strong> and <strong>1 other</strong>
                                    <div class="media-body-secondary">
                                        Aenean eu leo quam. Pellentesque ornare sem lacinia quam &hellip;
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-mdo.png">
                                <div class="media-body">
                                    <strong>Mark Otto</strong> and <strong>3 others</strong>
                                    <div class="media-body-secondary">
                                        Brunch sustainable placeat vegan bicycle rights yeah…
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-dhg.png">
                                <div class="media-body">
                                    <strong>Dave Gamache</strong>
                                    <div class="media-body-secondary">
                                        Brunch sustainable placeat vegan bicycle rights yeah…
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-fat.jpg">
                                <div class="media-body">
                                    <strong>Jacob Thornton</strong> and <strong>1 other</strong>
                                    <div class="media-body-secondary">
                                        Aenean eu leo quam. Pellentesque ornare sem lacinia quam &hellip;
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-mdo.png">
                                <div class="media-body">
                                    <strong>Mark Otto</strong> and <strong>3 others</strong>
                                    <div class="media-body-secondary">
                                        Brunch sustainable placeat vegan bicycle rights yeah…
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-dhg.png">
                                <div class="media-body">
                                    <strong>Dave Gamache</strong>
                                    <div class="media-body-secondary">
                                        Brunch sustainable placeat vegan bicycle rights yeah…
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-fat.jpg">
                                <div class="media-body">
                                    <strong>Jacob Thornton</strong> and <strong>1 other</strong>
                                    <div class="media-body-secondary">
                                        Aenean eu leo quam. Pellentesque ornare sem lacinia quam &hellip;
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-mdo.png">
                                <div class="media-body">
                                    <strong>Mark Otto</strong> and <strong>3 others</strong>
                                    <div class="media-body-secondary">
                                        Brunch sustainable placeat vegan bicycle rights yeah…
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="media">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-dhg.png">
                                <div class="media-body">
                                    <strong>Dave Gamache</strong>
                                    <div class="media-body-secondary">
                                        Brunch sustainable placeat vegan bicycle rights yeah…
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="d-none m-3 js-conversation">
                        <ul class="media-list media-list-conversation">
                            <li class="media media-current-user mb-4">
                                <div class="media-body">
                                    <div class="media-body-text">
                                        Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nulla vitae elit libero, a pharetra augue. Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Sed posuere consectetur est at lobortis.
                                    </div>
                                    <div class="media-footer">
                                        <small class="text-muted">
                                            <a href="#">Dave Gamache</a> at 4:20PM
                                        </small>
                                    </div>
                                </div>
                                <img class="rounded-circle media-object d-flex align-self-start ml-3" src="../img/avatar-dhg.png">
                            </li>

                            <li class="media mb-4">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-fat.jpg">
                                <div class="media-body">
                                    <div class="media-body-text">
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
                                    </div>
                                    <div class="media-body-text">
                                        Vestibulum id ligula porta felis euismod semper. Aenean lacinia bibendum nulla sed consectetur. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Nullam quis risus eget urna mollis ornare vel eu leo. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                                    </div>
                                    <div class="media-body-text">
                                        Cras mattis consectetur purus sit amet fermentum. Donec sed odio dui. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida at eget metus.
                                    </div>
                                    <div class="media-footer">
                                        <small class="text-muted">
                                            <a href="#">Fat</a> at 4:28PM
                                        </small>
                                    </div>
                                </div>
                            </li>

                            <li class="media mb-4">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-mdo.png">
                                <div class="media-body">
                                    <div class="media-body-text">
                                        Etiam porta sem malesuada magna mollis euismod. Donec id elit non mi porta gravida at eget metus. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Etiam porta sem malesuada magna mollis euismod. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Aenean lacinia bibendum nulla sed consectetur.
                                    </div>
                                    <div class="media-body-text">
                                        Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                                    </div>
                                    <div class="media-footer">
                                        <small class="text-muted">
                                            <a href="#">Mark Otto</a> at 4:20PM
                                        </small>
                                    </div>
                                </div>
                            </li>

                            <li class="media media-current-user mb-4">
                                <div class="media-body">
                                    <div class="media-body-text">
                                        Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nulla vitae elit libero, a pharetra augue. Maecenas sed diam eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Sed posuere consectetur est at lobortis.
                                    </div>
                                    <div class="media-footer">
                                        <small class="text-muted">
                                            <a href="#">Dave Gamache</a> at 4:20PM
                                        </small>
                                    </div>
                                </div>
                                <img class="rounded-circle media-object d-flex align-self-start ml-3" src="../img/avatar-dhg.png">
                            </li>

                            <li class="media mb-4">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-fat.jpg">
                                <div class="media-body">
                                    <div class="media-body-text">
                                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
                                    </div>
                                    <div class="media-body-text">
                                        Vestibulum id ligula porta felis euismod semper. Aenean lacinia bibendum nulla sed consectetur. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Nullam quis risus eget urna mollis ornare vel eu leo. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                                    </div>
                                    <div class="media-body-text">
                                        Cras mattis consectetur purus sit amet fermentum. Donec sed odio dui. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida at eget metus.
                                    </div>
                                    <div class="media-footer">
                                        <small class="text-muted">
                                            <a href="#">Fat</a> at 4:28PM
                                        </small>
                                    </div>
                                </div>
                            </li>

                            <li class="media mb-4">
                                <img class="rounded-circle media-object d-flex align-self-start mr-3" src="../img/avatar-mdo.png">
                                <div class="media-body">
                                    <div class="media-body-text">
                                        Etiam porta sem malesuada magna mollis euismod. Donec id elit non mi porta gravida at eget metus. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Etiam porta sem malesuada magna mollis euismod. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Aenean lacinia bibendum nulla sed consectetur.
                                    </div>
                                    <div class="media-body-text">
                                        Curabitur blandit tempus porttitor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                                    </div>
                                    <div class="media-footer">
                                        <small class="text-muted">
                                            <a href="#">Mark Otto</a> at 4:20PM
                                        </small>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Users</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body p-0">
                <div class="modal-body-scroller">
                    <ul class="media-list media-list-users list-group">
                        <li class="list-group-item">
                            <div class="media w-100">
                                <img class="media-object d-flex align-self-start mr-3" src="../img/avatar-fat.jpg">
                                <div class="media-body">
                                    <button class="btn btn-secondary btn-sm float-right">
                                        <span class="glyphicon glyphicon-user"></span> Follow
                                    </button>
                                    <strong>Jacob Thornton</strong>
                                    <p>@fat - San Francisco</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media w-100">
                                <img class="media-object d-flex align-self-start mr-3" src="../img/avatar-dhg.png">
                                <div class="media-body">
                                    <button class="btn btn-secondary btn-sm float-right">
                                        <span class="glyphicon glyphicon-user"></span> Follow
                                    </button>
                                    <strong>Dave Gamache</strong>
                                    <p>@dhg - Palo Alto</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media w-100">
                                <img class="media-object d-flex align-self-start mr-3" src="../img/avatar-mdo.png">
                                <div class="media-body">
                                    <button class="btn btn-secondary btn-sm float-right">
                                        <span class="glyphicon glyphicon-user"></span> Follow
                                    </button>
                                    <strong>Mark Otto</strong>
                                    <p>@mdo - San Francisco</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container pt-4 pb-5">
    <h1>Update Avatar</h1>
    <?php
        if($person['profile_pic'] == ''){
            echo "<div class=\"icon icon-user\"></div>";
        }else{
            echo "<img src=\"" . h($person['profile_pic']) . "\">";
        }
    ?>
    <form class="form-horizontal my-5" action="upload.php" method="POST" enctype="multipart/form-data" name="upload_form" id="upload_form">

        <div class="form-group">
            <label for="file" class="col-sm-2 control-label">Select Avatar</label>
            <div class="col-sm-10"><input type="file" name="file" id="file"></div>
            <div class="col-sm-10">
                <p class="help-block">
                    <?php  if(isset($errors['file_extension'])){ display_error($errors['file_extension']); } ?>
                </p>
                <p class="help-block">
                    <?php  if(isset($errors['file_size'])){ display_error($errors['file_size']); } ?>
                </p>
                <p class="help-block">
                    <?php  if(isset($errors['file_other'])){ display_error($errors['file_other']); } ?>
                </p>
            </div>

        </div>
        <div class="col-sm-10">
            <input type="submit" value="Create" class="btn btn-lg btn-success">
            <input type="button" value="Cancel" class="btn btn-lg btn-danger" onclick="location.href='../home.php';">
        </div>
</form>
</div>


<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/chart.js"></script>
<script src="../js/toolkit.js"></script>
<script src="../js/application.js"></script>
<script>
    // execute/clear BS loaders for docs
    $(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})
</script>
</body>
</html>

