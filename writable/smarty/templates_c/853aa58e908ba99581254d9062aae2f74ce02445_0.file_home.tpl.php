<?php
/* Smarty version 5.7.0, created on 2026-01-27 05:24:58
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69784c2a3620d0_56348782',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '853aa58e908ba99581254d9062aae2f74ce02445' => 
    array (
      0 => 'home.tpl',
      1 => 1769491494,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69784c2a3620d0_56348782 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\wamp64\\www\\ci-news\\app\\Views\\smarty';
?><!DOCTYPE html>
<html>
<?php
$_smarty_tpl->configLoad("config.tpl", null);
?>


<head>
  <title><?php echo $_smarty_tpl->getConfigVariable('title');?>
</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('base_url');?>
js/data.js"><?php echo '</script'; ?>
>
  <style>
    .custom-form {
      background-color: #ffe6c7 !important;
    }

    .error {
      color: #ff0000;
    }
  </style>
</head>

<body>
  <div
    class="container bg-secondary bg-gradient bg-opacity-50 custom-form rounded w-50 shadow p-3 mb-5 bg-body rounded mt-3"
    id="myForm">
    <form class="w-75 mx-auto p-3" id="formId" enctype="multipart/form-data" onsubmit="return false " novalidate>
            <h4 class="text-center mb-3 p-3">Student Registration Form</h4>
      <div class="mb-3 row">
        <div class="col">
          <label for="rollNo" class="form-label">Roll no : </label>
        </div>
        <div class="col-8">
          <input type="text" id='rollno' name="rollno" class="form-control" maxlength="15" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="fname" class="form-label">Student Name : </label>
        </div>
        <div class="col">
          <input type="text" id="fname" name="fname" class="ms-0 form-control" placeholder="firstname" maxlength="10"
            required>
        </div>
        <div class="col">
          <input type="text" id="lname" name="lname" class="form-control" placeholder="lastname" maxlength="10"
            required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="fatherName" class="form-label">Father's Name : </label>
        </div>
        <div class="col-8">
          <input type="text" class="form-control" id="fatherName" name="fatherName" maxlength="20" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="dateOfBirth" class="form-label">Date of birth : </label>
        </div>
        <div class="col-8">
          <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control" required>
        </div>
      </div>

      <div class="mb-3 row">
        <div class="col">
          <label for="mobileNumber" class="form-label">Mobile Number : </label>
        </div>
        <div class="col-8">
          <input type="tel" id="mobileNumber" name="mobileNumber" class="form-control" maxlength="10" required>
          <p><span id="errorMobile"></span></p>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="email" class="form-label">Email Id : </label>
        </div>
        <div class="col-8">
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" maxlength="25"
            required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="password" class="form-label">Password : </label>
        </div>
        <div class="col-8">
          <input type="password" class="form-control" id="password" name="password" maxlength="8" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col-4">
          <label for="checkmale">Gender : </label>
        </div>
        <div class="col-2">
          <div class="form-check">
            <input type="radio" id="checkmale" name="genderselect" value="male" class="form-check-input" required>
            <label for="checkmale" class="form-check-label">Male</label>
          </div>
        </div>
        <div class="col">
          <div class="form-check">
            <input type="radio" id="checkfemale" name="genderselect" value="female" class="form-check-input" required>
            <label for="checkfemale" class="form-check-label">Female</label>
          </div>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="s-cse">Department : </label>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-cse" value="cse" class="form-check-input" required>
            <label for="s-cse" class="form-check-label">CSE</label>
          </div>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-it" class="form-check-input" value="it" required>
            <label for="s-it" class="form-check-label">IT</label>
          </div>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-ece" class="form-check-input" value="ece" required>
            <label for="s-ece" class="form-check-label">ECE</label>
          </div>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-civil" class="form-check-input" value="civil" required>
            <label for="s-civil" class="form-check-label">CIVIL</label>
          </div>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="multi-select">Course : </label>
        </div>
        <div class="col-8">
          <select name="course_selection" id="multiSelect" class="form-select" required>
            <option value="">----Select Course----</option>
            <option value="JAVA">Java</option>
            <option value="DSA">DSA</option>
            <option value="C++">C++</option>
            <option value="Web Technologies">Web Technologies</option>
          </select>
        </div>
      </div>

      <div class="mb-3 row">
        <div class="col">
          <label for="studentPic" class="form-label">Student photo : </label>
        </div>
        <div class="col-8">
                              <input type="file" id="studentPic" name="studentPic" class="form-control form-control-sm mt-3" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="city" class="form-label">City : </label>
        </div>
        <div class="col-8">
          <input type="text" name="city" class="ms-0 form-control" id="city" maxlength="20" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="address">Address : </label>
        </div>
        <div class="col-8">
          <textarea name="address" spellcheck="false" id="address" class="form-control" maxlength="50"
            required> </textarea>
        </div>
      </div>
            <div class="d-flex justify-content-end">
        <div id="feedback" class="text-center w-75 "></div>
      </div>
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary" id="registerBtn" onclick="submitData(event)">Register</button>
      </div>
    </form>
  </div>
</body>

</html>
<?php echo '<script'; ?>
>
  var base_url='<?php echo $_smarty_tpl->getValue('base_url');?>
';
<?php echo '</script'; ?>
><?php }
}
