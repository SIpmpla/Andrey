<?PHP

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simp.la
 * @author 		Denis Pikusov
 *
 * Этот класс использует шаблон index.tpl,
 * который содержит всю страницу кроме центрального блока
 * По get-параметру module мы определяем что сожержится в центральном блоке
 *
 */

require_once('View.php');

class IndexView extends View
{	
	public $modules_dir = 'view/';

	public function __construct()
	{
		parent::__construct();
	}

		
	/**
	 *
	 * Отображение
	 *
	 */
	function fetch()
	{
		/*fastorder*/
        if (isset($_POST['IsFastOrder'])) {
            // Если нажали оформить заказ
            if (isset($_POST['checkout'])) {                        
                //$order->delivery_id = $this->request->post('delivery_id', 'integer');
                $order->name        = $this->request->post('name');
                $order->email       = $this->request->post('email');
                $order->address     = $this->request->post('address');
                $order->phone       = $this->request->post('phone');
                $order->comment     = $this->request->post('comment');
                $order->ip      	= $_SERVER['REMOTE_ADDR'];

                //$this->design->assign('delivery_id', $order->delivery_id);
                $this->design->assign('name', $order->name);
                $this->design->assign('email', $order->email);
                $this->design->assign('phone', $order->phone);
                $this->design->assign('address', $order->address);

                $order->email="_______";
                $order->address = "_______";
                $order->comment = "Быстрый заказ";                        
                
                //$captcha_code =  $this->request->post('captcha_code', 'string');

                // Скидка
                $cart = $this->cart->get_cart();
                $order->discount = $cart->discount;

                if($cart->coupon){
                    $order->coupon_discount = $cart->coupon_discount;
                    $order->coupon_code = $cart->coupon->code;
                }
                //                        
                
                if(!empty($this->user->id))
                    $order->user_id = $this->user->id;

                if(empty($order->name)){
                    $this->design->assign('error', 'empty_name');
                }elseif (empty($order->phone)) {
                    $this->design->assign('error', 'empty_phone');
                /*} elseif($_SESSION['captcha_code'] != $captcha_code || empty($captcha_code)){
                    $this->design->assign('error', 'captcha');
                 */
                }else{
                        // Добавляем заказ в базу
                    $order_id = $this->orders->add_order($order);
                    $_SESSION['order_id'] = $order_id;

                    // Добавляем товары к заказу
                    $this->orders->add_purchase(array('order_id' => $order_id, 'variant_id' => intval($this->request->post('variant_id')), 'amount' => 1));

                    $order = $this->orders->get_order($order_id);
                    
                    // Отправляем письмо пользователю
                    $this->notify->email_order_user($order->id);
                    // Отправляем письмо администратору
                    $this->notify->email_order_admin($order->id);
                    // Перенаправляем на страницу заказа
                    header('Location: '.$this->config->root_url.'/order/'.$order->url);
                }                        
            }
        }            
        /*/fastorder*/
		
		// Содержимое корзины
		$this->design->assign('cart',		$this->cart->get_cart());
	
        // Категории товаров
		$this->design->assign('categories', $this->categories->get_categories_tree());
		
		// Страницы
		$pages = $this->pages->get_pages(array('visible'=>1));		
		$this->design->assign('pages', $pages);
							
		// Текущий модуль (для отображения центрального блока)
		$module = $this->request->get('module', 'string');
		$module = preg_replace("/[^A-Za-z0-9]+/", "", $module);

		// Если не задан - берем из настроек
		if(empty($module))
			return false;
		//$module = $this->settings->main_module;

		// Создаем соответствующий класс
		if (is_file($this->modules_dir."$module.php"))
		{
				include_once($this->modules_dir."$module.php");
				if (class_exists($module))
				{
					$this->main = new $module($this);
				} else return false;
		} else return false;

		// Создаем основной блок страницы
		if (!$content = $this->main->fetch())
		{
			return false;
		}		

		// Передаем основной блок в шаблон
		$this->design->assign('content', $content);		
		
		// Передаем название модуля в шаблон, это может пригодиться
		$this->design->assign('module', $module);
				
		// Создаем текущую обертку сайта (обычно index.tpl)
		$wrapper = $this->design->smarty->getTemplateVars('wrapper');
		if(is_null($wrapper))
			$wrapper = 'index.tpl';
			
		if(!empty($wrapper))
			return $this->body = $this->design->fetch($wrapper);
		else
			return $this->body = $content;

	}
}
