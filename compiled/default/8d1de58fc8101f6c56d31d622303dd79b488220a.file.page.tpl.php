<?php /* Smarty version Smarty-3.1.18, created on 2015-02-25 15:15:14
         compiled from "Q:\home\localhost\www\simpla\design\default\html\page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:571554edaec27be799-31399487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d1de58fc8101f6c56d31d622303dd79b488220a' => 
    array (
      0 => 'Q:\\home\\localhost\\www\\simpla\\design\\default\\html\\page.tpl',
      1 => 1394917418,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '571554edaec27be799-31399487',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54edaec2828163_76647347',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54edaec2828163_76647347')) {function content_54edaec2828163_76647347($_smarty_tpl) {?>


<?php $_smarty_tpl->tpl_vars['canonical'] = new Smarty_variable("/".((string)$_smarty_tpl->tpl_vars['page']->value->url), null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['canonical'] = clone $_smarty_tpl->tpl_vars['canonical'];?>

<!-- Заголовок страницы -->
<h1 data-page="<?php echo $_smarty_tpl->tpl_vars['page']->value->id;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value->header, ENT_QUOTES, 'UTF-8', true);?>
</h1>

<!-- Тело страницы -->
<?php echo $_smarty_tpl->tpl_vars['page']->value->body;?>
<?php }} ?>
