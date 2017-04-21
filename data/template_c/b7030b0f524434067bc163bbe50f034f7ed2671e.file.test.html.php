<?php /* Smarty version Smarty-3.1.16, created on 2017-02-14 09:35:40
         compiled from "tpl\test.html" */ ?>
<?php /*%%SmartyHeaderCode:54845396dffd846957-81884614%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7030b0f524434067bc163bbe50f034f7ed2671e' => 
    array (
      0 => 'tpl\\test.html',
      1 => 1487036138,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54845396dffd846957-81884614',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5396dffd938311_63700952',
  'variables' => 
  array (
    'data' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5396dffd938311_63700952')) {function content_5396dffd938311_63700952($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
	<?php echo $_smarty_tpl->tpl_vars['value']->value['username'];?>

<?php } ?><?php }} ?>
