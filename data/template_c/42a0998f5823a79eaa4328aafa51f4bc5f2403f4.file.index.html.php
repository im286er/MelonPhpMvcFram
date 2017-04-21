<?php /* Smarty version Smarty-3.1.16, created on 2017-03-03 09:40:47
         compiled from "tpl\index.html" */ ?>
<?php /*%%SmartyHeaderCode:2496458a2af8166a303-42684035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42a0998f5823a79eaa4328aafa51f4bc5f2403f4' => 
    array (
      0 => 'tpl\\index.html',
      1 => 1488503979,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2496458a2af8166a303-42684035',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_58a2af816a8b02_04376961',
  'variables' => 
  array (
    'data' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a2af816a8b02_04376961')) {function content_58a2af816a8b02_04376961($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
	<?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>


<?php } ?><?php }} ?>
