<?php
$title = 'profile';
include_once "layouts/header.php";
include_once "app/middleware/auth.php";


include_once "app/models/User.php";

//validation en msabtsh input fady f ha3ml update
$userObject = new user;
$userObject->setEmail($_SESSION['user']->email);

if (isset($_POST['update-profile'])) {
    $errors = [];
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['phone']) || empty($_POST['gender'])) {
        $errors['all'] = "<div class='alert alert-danger'> all fields are required</div>";
    } //hnghyar byanato fe el db b3d m n3ml validation 
    //ll shakhs ely 3aml login f ha3rfo mn email bta3o

    $userObject->setFirstname($_POST['first_name']);
    $userObject->setLastname($_POST['last_name']);
    $userObject->setPhone($_POST['phone']);
    $userObject->setGender($_POST['gender']);
    //m2drsh a3mel set ll image w kda el sora gyaly fe el post w la file 3lshan myt3melsh m3aha k string
    //edet ll object kol el byanat 3lshan aghyrha fe el db
    if ($_FILES['image']['error'] == 0) {
        //photo exist
        //validate size,extension
        $maxUploadSize = 10 ** 6; //1 mega byte
        $megaBytes = $maxUploadSize / (10 ** 6);
        if ($_FILES['image']['size'] > $maxUploadSize) {
            $errors['image-size'] = "<div class='alert alert-danger'> max upload size of image is $megaByte bytes </div>";
        }
        //extension
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $availableExtensions = ['jpg', 'png', 'jpeg'];
        //bdawr 3la haga gwa array
        //hal msh fe el array el extension da
        //lw msh fe el array el extension da yb2a fe error
        //menf3sh a3mel concate array w string f bnstkhdm implode btdeha el array  bt7wlha l string
        if (!in_array($extension, $availableExtensions)) {
            $errors['image-extension'] = "<div class='alert alert-danger'>allowed extensions are " . implode(",", $availableExtensions) . "</div>";
        }
        //lazm a create folder 3ndy fe el server
        // flazm ykon esm el soraq unique
        if (empty($errors)) {
            $photoName = uniqid() . '.' . $extension;
            //path el sora
            $photoPath = "img/$photoName";
            //kda el sora etrf3t w gat 3la el server
            move_uploaded_file($_FILES['image']['tmp_name'], $photoPath);
            //set image
            $userObject->setImage($photoName);
            $_SESSION['user']->image = $photoName;
        }
    }
    if (empty($errors)) {
        $result = $userObject->update();
        //ba3ml update gwa el session kman msh fe el db bs
        $_SESSION['user']->first_name = $_POST['first_name'];
        $_SESSION['user']->last_name = $_POST['last_name'];
        $_SESSION['user']->phone = $_POST['phone'];
        $_SESSION['user']->gender = $_POST['gender'];
        if ($result) {
            $success = "<div class='alert alert-success'> updated successfully </div>";
        } else {
            $errors['all'] = "<div class='alert alert-danger'> something wen wrong </div>";
        }
    }
}

if (isset($_POST['update-password'])) {

    //hshafr el old password ely ktbto w ha3ml compare bl password ely mtshfr fe el db
    //old password=>required,regex,correct=>database
    //new password=>required,regex,confirmed
    //confirm password=>required


    //if no validation errors
    $userObject->setPassword($_POST['new_password']);
    $result = $userObject->updatePasswordByEmail();
    if ($result) {
        //print success message
    } else {
        //print failed message
    }
}

$result = $userObject->getUserByEmail();
$user = $result->fetch_object();
//3lshan el update ytem w b3d kda ytghyar fe el nav bar
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
?>


<div class="container rounded bg-white mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4 class="text-right">Edit Profile</h4>
                    <h5><?php if (!empty($errors)) {
                            foreach ($errors as $key => $error) {
                                echo $error;
                            }
                        }
                        if (isset($success)) {
                            echo $success;
                        }
                        ?>
                    </h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="col-md-4 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" id="image" src="img/<?= $user->image ?>" width="90" style="cursor: pointer;">
                            <input type="file" name="image" id="file" class="d-none">
                            <span class="font-weight-bold"><?= $user->first_name . " " . $user->last_name ?></span><span class="text-black-50"><?= $user->email ?></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><input type="text" name="first_name" class="form-control" placeholder="first name" value="<?= $user->first_name ?>"></div>
                        <div class="col-md-6"><input type="text" name="last_name" class="form-control" placeholder="last name" value="<?= $user->last_name ?>"></div>
                    </div>
                    <div class="row mt-3">

                        <div class="col-md-6"><input type="number" name="phone" class="form-control" value="<?= $user->phone ?>" placeholder="Phone number"></div>
                    </div>
                    <div class="row mt-3">
                        <h6 class="mb-2 pb-1">Gender: </h6>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="f" checked <?= $user->gender == 'f' ? 'checked' : '' ?> />
                            <label class="form-check-label">Female</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="m" <?= $user->gender == 'm' ? 'checked' : '' ?> />
                            <label class="form-check-label">Male</label>
                        </div>
                    </div>

                    <div class="mt-5 text-right">
                        <button name="update-profile" class="btn btn-primary profile-button" type="submit">Save Profile</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="container rounded bg-white mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Security</h4>
                        </div>
                        <form method="post">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-20 control-label">Current password</label>
                                    <div class="col-md-20">
                                        <input type="password" name="old_password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-20 control-label">New password</label>
                                    <div class="col-md-20">
                                        <input type="password" name="new_password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-20 control-label">password confirm</label>
                                    <div class="col-md-20">
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 text-right">
                                <button name="update-password" class="btn btn-primary profile-button" type="submit">update password</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>
<script>
    // document.getElementById('image').click(function(){
    //     document.getElementById('file').click();
    // });
    $('#image').on('click', function() {
        $('#file').click();
    });
</script>