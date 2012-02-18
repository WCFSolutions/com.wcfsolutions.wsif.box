{if $boxTabData|count}
	<ul class="dataList">
		{foreach from=$boxTabData item=comment}
			<li class="{cycle values='container-1,container-2'}">
				<div class="containerIcon">
					<img src="{icon}messageM.png{/icon}" alt="" />
				</div>
				<div class="containerContent">
					<h4><a href="index.php?page=EntryComments&amp;commentID={@$comment->commentID}{@SID_ARG_2ND}">{$comment->subject}</a></h4>
					<p class="firstPost smallFont light">{lang}wsif.entry.by{/lang} {if $comment->userID}<a href="index.php?page=User&amp;userID={@$comment->userID}{@SID_ARG_2ND}">{$comment->username}</a>{else}{$comment->username}{/if} ({@$comment->time|time})</p>
				</div>
			</li>
		{/foreach}
	</ul>
{else}
	<div class="container-1">
		{lang}wsif.category.noEntries{/lang}
	</div>
{/if}