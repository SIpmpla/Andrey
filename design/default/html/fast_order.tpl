

<div style="display:none;">
    <div id="fast-order">
        <h2 class="fast-order-title">Быстрый заказ</h2>
        <h3 id="fast-order-product-name"></h3>
        <form class="form feedback_form" method="post" style="" action="{url}">
            {if $error_back_in_stock}
                <div class="fast-order-error">
                    {if $error_back_in_stock->email_message}{$error_back_in_stock->email_message}{/if}
                </div>
                <div class="fast-order-error">
                    {if $error_back_in_stock->name_message}{$error_back_in_stock->name_message}{/if}
                </div>                
            {/if}
            <p class="reset-margin-padding">
                <input id="fast-order-product-id" class="fast-order-inputarea" value="" name="variant_id" type="hidden"/>
                <input type="hidden" name="IsFastOrder" value="true">
            </p>                            
            <p class="reset-margin-padding back-in-stock-backlines">
                <label class="fast-order-labeldata">Имя*</label>
                <input class="fast-order-inputarea" data-format=".+" data-notice="Введите имя" value="{if $back_in_stock_form_data}{$back_in_stock_form_data->name}{/if}" name="name" maxlength="255" type="text"/>            
            </p>        
            <p class="reset-margin-padding back-in-stock-backlines">
                <label class="fast-order-labeldata">№ телефона*</label>
                <input class="fast-order-inputarea" data-format=".+" data-notice="Введите № телефона" value="{if $back_in_stock_form_data}{$back_in_stock_form_data->email}{/if}" name="phone" maxlength="255" type="text"/>            
            </p>
            <input class="button_description button"  type="submit" name="checkout" value="Заказать" />
        </form>
    </div>
</div>

{literal}
    <script type="text/javascript">
        $(function() {
            $('#fast-order-send-button').fancybox();
        });
    </script>
{/literal}