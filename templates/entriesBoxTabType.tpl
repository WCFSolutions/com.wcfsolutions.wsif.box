{if $boxTabData|count}
	{if $boxTab->displayType == 'list'}
		<ul class="dataList">
			{foreach from=$boxTabData item=entry}
				<li class="{cycle values='container-1,container-2'}">
					<div class="containerIcon">
						<img src="{icon}entryM.png{/icon}" alt="" />
					</div>
					<div class="containerContent">
						<h4><a href="index.php?page=Entry&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}">{$entry->subject}</a></h4>
						<p class="firstPost smallFont light">{@$entry->time|time}</p>
					</div>
				</li>
			{/foreach}
		</ul>
	{else}
		<ul class="dataList thumbnailView squared floatContainer container-1">
			{foreach name='entries' from=$boxTabData item=entry}
				<li class="floatedElement{if $tpl.foreach.entries.iteration && ($tpl.foreach.entries.iteration % 5) == 0} last{/if}">
					<a href="index.php?page=Entry&amp;entryID={@$entry->entryID}{@SID_ARG_2ND}" title="{$entry->subject}">
						<span class="thumbnail" style="width: 75px;"><img src="{if $entry->defaultImageID}index.php?page=EntryImageShow&amp;imageID={@$entry->getImage()->imageID}{if $entry->getImage()->hasThumbnail}&amp;thumbnail=1{/if}{@SID_ARG_2ND}{else}images/noThumbnail.png{/if}" alt="" style="width: 75px;" /></span>
						<span class="avatarCaption">{$entry->subject}</span>
					</a>
					<p class="light smallFont">{@$entry->time|time}</p>
				</li>
			{/foreach}
		</ul>
	{/if}
{else}
	<div class="container-1">
		{lang}wsif.category.noEntries{/lang}
	</div>
{/if}