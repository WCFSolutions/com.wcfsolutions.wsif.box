<div id="boxLayout">
	{if $boxLayout->getBoxesByPosition('top')|count}
		<div id="boxesTop">
			{include file='boxList' boxPosition='top'}
		</div>
	{/if}
	{assign var=leftBoxCount value=$boxLayout->getBoxesByPosition('left')|count}
	{assign var=rightBoxCount value=$boxLayout->getBoxesByPosition('right')|count}
	<div id="boxLayout-{if $leftBoxCount && $rightBoxCount}4{elseif $leftBoxCount}3{elseif $rightBoxCount}2{else}1{/if}">
		<div id="boxColumnContainer">
			{if $leftBoxCount}
				<div id="leftBoxColumn">
					<div class="boxColumnInner">
						{include file='boxList' boxPosition='left'}
					</div>
				</div>
			{/if}
			<div id="mainBoxColumn">
				<div class="boxColumnInner">