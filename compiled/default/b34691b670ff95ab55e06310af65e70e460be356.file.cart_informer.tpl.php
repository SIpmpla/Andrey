<?php /* Smarty version Smarty-3.1.18, created on 2015-02-12 00:27:38
         compiled from "Q:\home\localhost\www\simpla\design\default\html\cart_informer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1369054dbbb3ab00e35-35363801%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b34691b670ff95ab55e06310af65e70e460be356' => 
    array (
      0 => 'Q:\\home\\localhost\\www\\simpla\\design\\default\\html\\cart_informer.tpl',
      1 => 1328284806,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1369054dbbb3ab00e35-35363801',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cart' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54dbbb3ab57814_62932242',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54dbbb3ab57814_62932242')) {function content_54dbbb3ab57814_62932242($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['cart']->value->total_products>0) {?>
	В <a href="./cart/">корзине</a>
	<?php echo $_smarty_tpl->tpl_vars['cart']->value->total_products;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['cart']->value->total_products,'товар','товаров','товара');?>

	на <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->tpl_vars['cart']->value->total_price);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>

<?php } else { ?>
	Корзина пуста
<?php }?>
<?php }} ?>
