<?php
/* Smarty version 5.7.0, created on 2026-02-02 10:02:53
  from 'file:showData.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_6980764d4e0b51_89762784',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd5ab0b15e38c751c8d5bac6207a0cc121ad25c1d' => 
    array (
      0 => 'showData.tpl',
      1 => 1770026557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6980764d4e0b51_89762784 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\wamp64\\www\\ci-news\\app\\Views\\smarty';
?><!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display Table</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  <?php echo '</script'; ?>
>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
>
    var base_url='<?php echo $_smarty_tpl->getValue('base_url');?>
';
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('base_url');?>
js/data.js"><?php echo '</script'; ?>
>

  <style>
    .custom-edit-icon {
      color: black;
    }

    .custom-del-icon {
      color: red;
    }

    th,
    td {
      border: 1px solid black !important;
    }

    img {
      width: 150px;
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-3">
    <div class="col-md-12 mb-3 d-flex justify-content-between">
      <div class="d-flex justify-content-start">
        <a href="<?php echo $_smarty_tpl->getValue('addUserUrl');?>
" class="btn btn-primary mb-3 text-decoration-none text-white">Add User</a>
      </div>
      <div class="d-flex justify-content-end">
        <a href="javascript:void(0);" class="btn btn-success mb-3 text-decoration-none text-white"
          onclick='exportDataJS()'>Export <i class="fas fa-file-excel"></i></a>
      </div>
    </div>

    <table class="table border border-dark table-responsive">
      <thead class="table-success text-nowrap">
        <tr class="">
          <th scope="col">S.No</th>
          <th scope="col">Roll.No</th>
          <th scope="col">F_Name</th>
          <th scope="col">Father</th>
          <th scope="col">DOB</th>
          <th scope="col">Mobile</th>
          <th scope="col">Email</th>
          <th scope="col">Password</th>
          <th scope="col">Gender</th>
          <th scope="col">Department</th>
          <th scope="col">Course</th>
          <th scope="col">File</th>
          <th scope="col">City</th>
          <th scope="col">Address</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="text-nowrap">
        <?php if (( !true || empty($_smarty_tpl->getValue('items')['items']))) {?>
          <tr>
            <td colspan="15" class="text-center"><?php echo $_smarty_tpl->getValue('no_data');?>
</td>
          </tr>
        <?php } else { ?>
          <?php $_smarty_tpl->assign('count', '1', false, NULL);?>
          <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('items')['items'], 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
            <tr>
              <td><?php echo $_smarty_tpl->getVariable('count')->postIncDec('++');?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['rollNo'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['fname'];?>
 <?php echo $_smarty_tpl->getValue('item')['lname'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['father_name'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['dob'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['mobile'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['email'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['password'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['gender'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['department'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['course'];?>
</td>
              <td><img src=<?php echo $_smarty_tpl->getValue('base_url');
echo $_smarty_tpl->getValue('item')['file'];?>
 alt="item Image"></td>
              <td><?php echo $_smarty_tpl->getValue('item')['city'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['address'];?>
</td>
              <td>
                <a href="<?php echo $_smarty_tpl->getValue('editUrl');?>
/<?php echo $_smarty_tpl->getValue('item')['id'];?>
" class="me-2"><i class="fa-solid fa-pen-to-square custom-edit-icon"></i></a>
                <a href="javascript:void(0);" onclick="deleteOne('<?php echo $_smarty_tpl->getValue('item')['id'];?>
','<?php echo $_smarty_tpl->getValue('item')['file'];?>
')"><i
                    class="fa-solid fa-trash custom-del-icon"></i></a>
              </td>
            </tr>
          <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        <?php }?>
      </tbody>
    </table>
  </div>


</body>

</html><?php }
}
