<?php
/* Smarty version 5.7.0, created on 2026-02-05 05:39:01
  from 'file:studentForm.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69842cf5143b05_53982874',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c66cf754b004f22e6a5d030340df624cdde20ade' => 
    array (
      0 => 'studentForm.tpl',
      1 => 1770269732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69842cf5143b05_53982874 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\wamp64\\www\\ci-news\\app\\Views\\smarty';
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  <style>
    .custom-form {
      background-color: #ffe6c7 !important;
    }

    .error {
      color: #ff0000;
    }
    .customImg{
      position: relative;
    }
    .customBtn{
      position:relative;
      bottom: 45px;
      right:25px;
    }
    .customEyeBtn{
      background:none;
      border:none;
      position:relative
    }
    .customEye{
      position:absolute;
      bottom:30px;
      left:230px
    }
    .customEye:hover{
      color:grey;
      
    }
  </style>
</head>

<body>
  <div
    class="container bg-secondary bg-gradient bg-opacity-50 custom-form rounded w-50 shadow p-3 mb-5 bg-body rounded mt-3"
    id="myForm">
    <form class="w-75 mx-auto p-3" id="formId" enctype="multipart/form-data" onsubmit="return false" novalidate>
      <h4 class="text-center mb-3 p-3">Student Registration Form</h4>
      <div class="mb-3 row">
        <div class="col">
          <label for="rollNo" class="form-label">Roll no : </label>
        </div>
        <div class="col-8">
          <input type="text" id='rollno' name="rollno" class="form-control" maxlength="15"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['rollNo'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="fname" class="form-label">Student Name : </label>
        </div>
        <div class="col">
          <input type="text" id="fname" name="fname" class="ms-0 form-control" placeholder="firstname" maxlength="10"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['fname'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
        </div>
        <div class="col">
          <input type="text" id="lname" name="lname" class="form-control" placeholder="lastname" maxlength="10"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['lname'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="fatherName" class="form-label">Father's Name : </label>
        </div>
        <div class="col-8">
          <input type="text" class="form-control" id="fatherName" name="fatherName" maxlength="20"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['father_name'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="dateOfBirth" class="form-label">Date of birth : </label>
        </div>
        <div class="col-8">
          <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control" value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['dob'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
            required>
        </div>
      </div>

      <div class="mb-3 row">
        <div class="col">
          <label for="mobileNumber" class="form-label">Mobile Number : </label>
        </div>
        <div class="col-8">
          <input type="tel" id="mobileNumber" name="mobileNumber" class="form-control" maxlength="10"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['mobile'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
          <p><span id="errorMobile"></span></p>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="email" class="form-label">Email Id : </label>
        </div>
        <div class="col-8">
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" maxlength="25" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="password" class="form-label">Password : </label>
        </div>
        <div class="col-8">
          <input type="password" class="form-control" id="password" name="password" maxlength="8"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['password'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
            <button class="customEyeBtn"><i class="fa-solid fa-eye customEye" ></i></button>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col-4">
          <label for="checkmale">Gender : </label>
        </div>
        <div class="col-2">
          <div class="form-check">
            <input type="radio" id="checkmale" name="genderselect" value="male" class="form-check-input"
              <?php if ((true && (true && null !== ($_smarty_tpl->getValue('item')['gender'] ?? null))) && $_smarty_tpl->getValue('item')['gender'] == 'male') {?> checked <?php }?> required>
            <label for="checkmale" class="form-check-label">Male</label>
          </div>
        </div>
        <div class="col">
          <div class="form-check">
            <input type="radio" id="checkfemale" name="genderselect" value="female" class="form-check-input"
              <?php if ((true && (true && null !== ($_smarty_tpl->getValue('item')['gender'] ?? null))) && $_smarty_tpl->getValue('item')['gender'] == 'female') {?>checked<?php }?> required>
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
            <input type="checkbox" name="department[]" id="s-cse" value="cse" class="form-check-input"
              <?php if ($_smarty_tpl->getValue('item')['department'] == 'cse') {?>checked<?php }?> required>
            <label for="s-cse" class="form-check-label">CSE</label>
          </div>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-it" class="form-check-input" value="it"
              <?php if ($_smarty_tpl->getValue('item')['department'] == 'it') {?>checked<?php }?> required>
            <label for="s-it" class="form-check-label">IT</label>
          </div>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-ece" class="form-check-input" value="ece"
              <?php if ($_smarty_tpl->getValue('item')['department'] == 'ece') {?>checked<?php }?> required>
            <label for="s-ece" class="form-check-label">ECE</label>
          </div>
        </div>
        <div class="col-2">
          <div class="col form-check">
            <input type="checkbox" name="department[]" id="s-civil" class="form-check-input" value="civil"
              <?php if ($_smarty_tpl->getValue('item')['department'] == 'civil') {?>checked<?php }?> required>
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
            <option value="JAVA" <?php if ($_smarty_tpl->getValue('item')['course'] == 'JAVA') {?>selected<?php }?>>Java</option>
            <option value="DSA" <?php if ($_smarty_tpl->getValue('item')['course'] == 'DSA') {?>selected<?php }?>>DSA</option>
            <option value="C++" <?php if ($_smarty_tpl->getValue('item')['course'] == 'C++') {?>selected<?php }?>>C++</option>
            <option value="Web Technologies" <?php if ($_smarty_tpl->getValue('item')['course'] == 'Web Technologies') {?>selected<?php }?>>Web Technologies
            </option>
          </select>
        </div>
      </div>

      <div class="mb-3 row">
        <div class="col">
          <label for="studentPic" class="form-label">Student photo : </label>
        </div>
                <div class="col-8">
          <div class="previewImageFile">
            <img id="preview" src="<?php if (!( !true || empty($_smarty_tpl->getValue('item')['file']))) {
echo $_smarty_tpl->getValue('base_url');
echo $_smarty_tpl->getValue('item')['file'];
}?>" alt="No Student Pic"
              class="customImg" style="width:100px; height:100px;<?php if (( !true || empty($_smarty_tpl->getValue('item')['file']))) {?>display:none;<?php }?>">

            <button type="button" class="customBtn" title="delete"
              style="border:none; background:transparent;<?php if (( !true || empty($_smarty_tpl->getValue('item')['file']))) {?>display:none;<?php }?>">
              <i class="fa-regular fa-circle-xmark customicon" style="color:#dc3545;"></i>
            </button>
          </div>

          <input type="file" id="studentPic" name="studentPic" class="form-control form-control-sm mt-3"
            <?php if (( !true || empty($_smarty_tpl->getValue('item')['file']))) {?>required<?php }?>>

          <input type="hidden" id="old_file" name="old_file" value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['file'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
        </div>

      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="city" class="form-label">City : </label>
        </div>
        <div class="col-8">
          <input type="text" name="city" class="ms-0 form-control" id="city" maxlength="20"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['city'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" required>
        </div>
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label for="address">Address : </label>
        </div>
        <div class="col-8">
          <textarea name="address" spellcheck="false" id="address" class="form-control" maxlength="50"
            required><?php echo (($tmp = $_smarty_tpl->getValue('item')['address'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
 </textarea>
        </div>
      </div>

      <input type="hidden" name="edit_id" id="edit_id" value="<?php echo (($tmp = $_smarty_tpl->getValue('item')['id'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
     

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
