<?php /* Smarty version Smarty-3.1.18, created on 2015-04-16 15:10:23
         compiled from "/home/simplama/simplamarket.com/test1993/design/default/html/cart_informer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1839236000552fa6af299ab3-64020234%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6f60744f35a96b15fc67f99bdfcb701fec32988' => 
    array (
      0 => '/home/simplama/simplamarket.com/test1993/design/default/html/cart_informer.tpl',
      1 => 1328292006,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1839236000552fa6af299ab3-64020234',
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
  'unifunc' => 'content_552fa6af2b11c7_00240440',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_552fa6af2b11c7_00240440')) {function content_552fa6af2b11c7_00240440($_smarty_tpl) {?>

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
