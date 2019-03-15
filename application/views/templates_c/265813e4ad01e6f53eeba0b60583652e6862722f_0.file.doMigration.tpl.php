<?php
/* Smarty version 3.1.33, created on 2019-03-15 13:47:48
  from '/home/lars/git/elyday/adrastea/application/views/templates/doMigration.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c8bad04b01fe6_63105432',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '265813e4ad01e6f53eeba0b60583652e6862722f' => 
    array (
      0 => '/home/lars/git/elyday/adrastea/application/views/templates/doMigration.tpl',
      1 => 1552657185,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5c8bad04b01fe6_63105432 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"Migration"), 0, false);
?>
<div class="container">
    <h1 class="mt-1">Migration</h1>

    <?php if ($_smarty_tpl->tpl_vars['successful']->value) {?>
        <div class="alert alert-success" role="alert">
            Successful
        </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
        <div class="alert alert-danger" role="alert">
            Error: <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

        </div>
    <?php }?>

    <form method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Pin</label>
            <input type="password" required class="form-control" id="pin" name="pin" placeholder="Enter Pin">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
