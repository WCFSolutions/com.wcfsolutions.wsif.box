				</div>
			</div>
			{if $rightBoxCount|count}
				<div id="rightBoxColumn">
					<div class="boxColumnInner">
						{include file='boxList' boxPosition='right'}
					</div>
				</div>
			{/if}
		</div>
	</div>
	{if $boxLayout->getBoxesByPosition('bottom')|count}
		<div id="boxesBottom">
			{include file='boxList' boxPosition='bottom'}
		</div>
	{/if}
</div>