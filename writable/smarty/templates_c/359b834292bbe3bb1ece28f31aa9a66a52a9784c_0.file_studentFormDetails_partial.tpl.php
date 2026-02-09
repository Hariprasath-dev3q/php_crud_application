<?php
/* Smarty version 5.7.0, created on 2026-02-09 12:39:02
  from 'file:studentFormDetails_partial.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_6989d566b36179_61557977',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '359b834292bbe3bb1ece28f31aa9a66a52a9784c' => 
    array (
      0 => 'studentFormDetails_partial.tpl',
      1 => 1770637512,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6989d566b36179_61557977 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\wamp64\\www\\student-crud\\app\\Views\\smarty';
?><table class="table border border-dark table-responsive">
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
      <?php $_smarty_tpl->assign('itemsPerPage', 20, false, NULL);?>
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

<?php if ($_smarty_tpl->getValue('totalPages') > 1) {?>
  <div class="pagination-wrapper">
    <?php if ($_smarty_tpl->getValue('currentPage') > 1) {?>
      <a class="page-btn ajax-page" data-page="<?php echo $_smarty_tpl->getValue('currentPage')-1;?>
" href="javascript:void(0)">&#10094;</a>
    <?php }?>

    <a class="page-btn ajax-page <?php if ($_smarty_tpl->getValue('currentPage') == 1) {?>active<?php }?>" data-page="1" href="javascript:void(0)">1</a>

    <?php if ($_smarty_tpl->getValue('currentPage') > 4) {?>
      <span class="dots">...</span>
    <?php }?>

    <?php
$_smarty_tpl->assign('i', null);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->getValue('currentPage')+1+1 - ($_smarty_tpl->getValue('currentPage')-1) : $_smarty_tpl->getValue('currentPage')-1-($_smarty_tpl->getValue('currentPage')+1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->getValue('currentPage')-1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
      <?php if ($_smarty_tpl->getValue('i') > 1 && $_smarty_tpl->getValue('i') < $_smarty_tpl->getValue('totalPages')) {?>
        <a class="page-btn ajax-page <?php if ($_smarty_tpl->getValue('i') == $_smarty_tpl->getValue('currentPage')) {?>active<?php }?>" data-page="<?php echo $_smarty_tpl->getValue('i');?>
" href="javascript:void(0)"><?php echo $_smarty_tpl->getValue('i');?>
</a>
      <?php }?>
    <?php }
}
?>

    <?php if ($_smarty_tpl->getValue('currentPage') < $_smarty_tpl->getValue('totalPages')-3) {?>
      <span class="dots">...</span>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('totalPages') > 1) {?>
      <a class="page-btn ajax-page <?php if ($_smarty_tpl->getValue('currentPage') == $_smarty_tpl->getValue('totalPages')) {?>active<?php }?>" data-page="<?php echo $_smarty_tpl->getValue('totalPages');?>
"
        href="javascript:void(0)"><?php echo $_smarty_tpl->getValue('totalPages');?>
</a>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('currentPage') < $_smarty_tpl->getValue('totalPages')) {?>
      <a class="page-btn ajax-page" data-page="<?php echo $_smarty_tpl->getValue('currentPage')+1;?>
" href="javascript:void(0)">&#10095;</a>
    <?php }?>
  </div>
<?php }
}
}
