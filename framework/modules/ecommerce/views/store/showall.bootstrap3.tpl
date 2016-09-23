{css unique="storeListing" link="`$asset_path`css/storefront.css" corecss="button,clearfix"}

{/css}

<div class="module store showall scroll">
	<h2>{$current_category->title}</h2>
    <div class="listing-row">
          {counter assign="ipr" name="ipr" start=1}
          {foreach from=$page->records item=listing name=listings}
              {if $smarty.foreach.listings.first || $open_row}
                  <div class="row">
                  {$open_row=0}
              {/if}
              {include file=$listing->getForm('storeListing')}
              {if $smarty.foreach.listings.last || $ipr%4==0}
                  </div>
                  {$open_row=1}
              {/if}
              {counter name="ipr"}
          {/foreach}
     </div>
	 
 	{if $page->page < $page->total_pages}
    	<a class="jscroll-next" href="{$smarty.const.URL_FULL}index.php?controller=store&action=loadnextproducts&page={$page->page+1}&ajax_action=1&category={$current_category->id}&total={$page->total_pages}"> </a>
	{/if}
</div>

	{if $page->page < $page->total_pages}
	
	
	{script unique="autoloadproducts"}
	{literal}
		$(function () {
		
			
			
			$('.scroll').jscroll({
			    loadingHtml: '<img src="{/literal}{$smarty.const.URL_FULL}{literal}ajax-loader.gif" alt="Loading" />',
			    padding: 1500,
			    nextSelector: 'a.jscroll-next:last'
			});
			
		});
		
		
	{/literal}
	{/script}
	{/if}