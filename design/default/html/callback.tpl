


<div style="display:none;">
    <form id="call" class="callback_form" method="post">
	
		<div class="callback_title">Заказ обратного звонка</div>
		
		<div class="callback_form_group">
			<label for="callback_name" class="callback_form_label">Имя</label>
			<input id="callback_name" class="callback_form_input" type="text" name="name" data-format=".+" data-notice="Введите имя" value=""/>
		</div>
		
		<div class="callback_form_group">
			<label for="callback_phone" class="callback_form_label">Номер телефона</label>
			<input id="callback_phone" class="callback_form_input" type="text" name="phone" data-format=".+" data-notice="Введите номер телефона" value="" maxlength="255"/>
		</div>
		
        <input class="callback_button button" type="submit" name="callback" value="Заказать"/>
		
    </form>
</div>

{if $module!='ProductView'}
    <script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"></script>
    <link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
{/if}
{literal}
    <script>
        $(function() {
            $('#callback a').fancybox();
        });
    </script>
{/literal}
{if $call_sent}
  {literal}
    <script>
      $(function() {
        alert("Ваша заявка принята. Мы свяжемся с Вами в ближайшее время");
      });
    </script>
  {/literal}
{/if}