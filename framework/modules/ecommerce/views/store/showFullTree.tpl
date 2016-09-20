{*
 * Copyright (c) 2004-2015 OIC Group, Inc.
 *
 * This file is part of Exponent
 *
 * Exponent is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * GPL: http://www.gnu.org/licenses/gpl.txt
 *
 *}

<div class="module store show-top-level">
	<div id="catnav" class="catnav">
		<ul>	
			{foreach from=$categories_arr item=category}
    			{if $category->is_active==1 || $user->is_acting_admin}
                    <li class="{if $curcat->id==$category->id}current{/if}{if $category->is_active!=1} inactive{/if}">
                        <a href="{$category->sef_url}">{$category->title} <span class="productsincategory">{$category->product_count}</span></a>
                    </li>
				{/if}
			{/foreach}
		</ul>
	</div>
</div>
