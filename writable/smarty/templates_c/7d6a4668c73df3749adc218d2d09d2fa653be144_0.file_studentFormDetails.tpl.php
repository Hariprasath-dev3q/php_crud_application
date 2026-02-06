<?php
/* Smarty version 5.7.0, created on 2026-02-06 13:45:32
  from 'file:studentFormDetails.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_6985f07c19f262_57934365',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7d6a4668c73df3749adc218d2d09d2fa653be144' => 
    array (
      0 => 'studentFormDetails.tpl',
      1 => 1770385528,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6985f07c19f262_57934365 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\wamp64\\www\\student-crud\\app\\Views\\smarty';
?><!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display Student Table</title>

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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

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
js/student-form.js"><?php echo '</script'; ?>
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

    .pagination {
      margin-top: 20px;

    }

    /* .my-alert-height {
      height: 40px !important;
      line-height: 40px !important;
      padding: 0px 35px !important;
      margin-left: 0 !important;
    } */
  </style>
</head>

<body>
  <div class="container-fluid mt-3">
    <div class="col-md-12 mb-3 d-flex justify-content-between">

      <div class="d-flex justify-content-start">

        <form method="post" enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getValue('base_url');?>
insertData/import-excel"
          id="importExcelForm">
          <label class="file-btn btn btn-warning mb-3 ms-3 text-white">
            Import <i class="fa-solid fa-file-import"></i>
            <input type="file" id="excelFile" name="excelFile" accept=".xls,.xlsx" style="display: none;"
              onchange=" if(confirm('Are you sure you want to import this file?')) return importDataJS(event)" />
          </label>
        </form>
        <button class="btn btn-success mb-3 ms-3 text-decoration-none text-white" onclick='exportDataJS()'>Export <i
            class="fas fa-file-excel"></i>
        </button>
        <button class="btn btn-danger mb-3 ms-3" onclick="deleteAllUsers()">Delete <i class="fa-solid fa-trash"></i>
        </button>
        <button class="btn btn-primary mb-3 ms-3 text-decoration-none text-white" onclick="sampleExport()">
          Sample Excel <i class="fa-solid fa-file-lines"></i>
        </button>
      </div>
      <div class="d-flex justify-content-end w-50">
        <?php if ($_smarty_tpl->getValue('error')) {?>
          <div class="alert alert-danger alert-dismissible fade show myAlert w-50"  role="alert">
            <?php echo $_smarty_tpl->getValue('error');?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php }?>
        <?php if ($_smarty_tpl->getValue('success')) {?>
          <div class="alert alert-success alert-dismissible fade show myAlert w-50" role="alert">
            <?php echo $_smarty_tpl->getValue('success');?>

            <button type="button" class="btn-close my-alert-height" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php }?>
      </div>
    </div>

    <table class="table border border-dark table-responsive">
      <thead class="table-success text-nowrap">
        <tr class="">
          <th scope="col"><input type="checkbox" id="multiselect" /></th>
          <th scope="col">S.No</th>
          <th scope="col">ROLL NO</th>
          <th scope="col">USER NAME</th>
          <th scope="col">FATHER</th>
          <th scope="col">DOB</th>
          <th scope="col">MOBILE</th>
          <th scope="col">EMAIL</th>
          <th scope="col">PASSWORD</th>
          <th scope="col">GENDER</th>
          <th scope="col">DEPARTMENT</th>
          <th scope="col">COURSE</th>
          <th scope="col">CITY</th>
          <th scope="col">ADDRESS</th>
        </tr>
      </thead>
      <tbody class="text-nowrap">
        <?php if (( !$_smarty_tpl->hasVariable('items') || empty($_smarty_tpl->getValue('items')))) {?>
          <tr>
            <td colspan="15" class="text-center"><?php echo $_smarty_tpl->getValue('no_data');?>
</td>
          </tr>
        <?php } else { ?>
                    <?php $_smarty_tpl->assign('itemsPerPage', 50, false, NULL);?>
          <?php $_smarty_tpl->assign('currentPage', $_smarty_tpl->getValue('pager')->getCurrentPage(), false, NULL);?>
          <?php $_smarty_tpl->assign('count', ($_smarty_tpl->getValue('currentPage')-1)*$_smarty_tpl->getValue('itemsPerPage')+1, false, NULL);?>

          <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('items'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
            <tr>
              <td><input type="checkbox" value="<?php echo $_smarty_tpl->getValue('item')['id'];?>
" /></td>
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
              <td><?php echo $_smarty_tpl->getValue('item')['city'];?>
</td>
              <td><?php echo $_smarty_tpl->getValue('item')['address'];?>
</td>
            </tr>

          <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        <?php }?>
      </tbody>
    </table>

        <div class="pagination">
      <?php if ((true && ($_smarty_tpl->hasVariable('pager') && null !== ($_smarty_tpl->getValue('pager') ?? null)))) {?>
        <?php echo $_smarty_tpl->getValue('pager')->links('default','custom');?>

      <?php }?>
    </div>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
