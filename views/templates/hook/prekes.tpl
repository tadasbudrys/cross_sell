if isset($orderProducts) && count($orderProducts)}
<div id="crossselling">
	<script type="text/javascript">var cs_middle = {$middlePosition_crossselling};</script>
	<h2 class="productscategory_h2">{l s='Customers who bought this product also bought:' mod='crossselling'}</h2>
	<div id="{if count($orderProducts) > 5}crossselling{else}crossselling_noscroll{/if}">
		{if count($orderProducts) > 5}<a id="crossselling_scroll_left" title="{l s='Previous' mod='crossselling'}" href="javascript:{ldelim}{rdelim}">{l s='Previous' mod='crossselling'}</a>{/if}
		<div id="crossselling_list">
			<ul class="clearfix" {if count($orderProducts) > 5}style="width: {math equation="width * nbImages" width=107 nbImages=$orderProducts|@count}px"{/if}>
				{foreach from=$orderProducts item='orderProduct' name=orderProduct}
				<li>
					<a href="{$orderProduct.link}" title="{$orderProduct.name|htmlspecialchars}" class="lnk_img"><img src="{$orderProduct.image}" alt="{$orderProduct.name|htmlspecialchars}" /></a>
					<p class="product_name"><a href="{$orderProduct.link}" title="{$orderProduct.name|htmlspecialchars}">{$orderProduct.name|truncate:15:'...'|escape:'html':'UTF-8'}</a></p>
					{if $crossDisplayPrice AND $orderProduct.show_price == 1 AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
						<span class="price_display">
							<span class="price">{convertPrice price=$orderProduct.displayed_price}</span>
						</span><br />
					{else}
						<br />
					{/if}
					{if isset($orderProduct.description_short)}<p>{$orderProduct.description_short|strip_tags:'UTF-8'|truncate:50:'...'}</p>{/if}
					<!-- <a title="{l s='View' mod='crossselling'}" href="{$orderProduct.link}" class="button_small">{l s='View' mod='crossselling'}</a><br /> -->
				</li>
				{/foreach}
			</ul>
		</div>
	{if count($orderProducts) > 5}<a id="crossselling_scroll_right" title="{l s='Next' mod='crossselling'}" href="javascript:{ldelim}{rdelim}">{l s='Next' mod='crossselling'}</a>{/if}
	</div>
</div>
{/if}
