
    
	 
	 
	 <div class="listing-row">
	       {counter assign="ipr" name="ipr" start=1}
	       {foreach from=$products item=listing name=listings}
	           {if $smarty.foreach.listings.first || $open_row}
	               <div class="row">
	               {$open_row=0}
	           {/if}
	           {include file=$listing->getForm('storeListing')}
	           {if $smarty.foreach.listings.last || $ipr%$config.images_per_row==0}
	               </div>
	               {$open_row=1}
	           {/if}
	           {counter name="ipr"}
	       {/foreach}
	  </div>
	  
	{if $total > $page}
 	<a class="jscroll-next" href="{$smarty.const.URL_FULL}index.php?controller=store&action=loadnextproducts&page={$nextpage}&ajax_action=1&category={$current_category->id}&total={$total}">Loading...</a>
	{/if}