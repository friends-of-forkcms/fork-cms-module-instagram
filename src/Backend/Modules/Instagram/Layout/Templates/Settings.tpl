{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
	<h2>{$lblModuleSettings|ucfirst}: {$lblInstagram}</h2>
</div>

{form:settings}
	{option:authenticate}
		<div class="box">
			<div class="heading">
				<h3>{$lblAuthentication|ucfirst}</h3>
			</div>
			<div class="options">
				<label for="clientId">{$lblClientId|ucfirst}</label>
				{$txtClientId} {$txtClientIdError}
			</div>
			<div class="options">
				<label for="clientSecret">{$lblClientSecret|ucfirst}</label>
				{$txtClientSecret} {$txtClientSecretError}
			</div>
			<div class="options longHelpTxt">
				{$msgAuthHelp}
			</div>
		</div>

		<div class="fullwidthOptions">
			<div class="buttonHolderRight">
				<input id="save" class="inputButton button mainButton" type="submit" name="save" value="{$lblAuthenticate|ucfirst}" />
			</div>
		</div>
	{/option:authenticate}

	{option:!authenticate}
		<div class="box">
			<div class="heading">
				<h3>{$lblSettings|ucfirst}</h3>
			</div>
			<div class="options">
				<label for="username">{$lblUsername|ucfirst}</label>
				{$txtUsername} {$txtUsernameError}
			</div>
			<div class="options">
				<label for="numberRecentItems">{$lblNumberOfRecentItems|ucfirst}</label>
				{$ddmNumRecentItems} {$ddmNumRecentItemsError}
			</div>
		</div>

		<div class="fullwidthOptions">
			<div class="buttonHolderLeft">
				<a class="inputButton button" href="{$var|geturl:'logout'}" name="logout">{$lblLogout|ucfirst}</a>
			</div>
			<div class="buttonHolderRight">
				<input id="save" class="inputButton button mainButton" type="submit" name="save" value="{$lblSave|ucfirst}" />
			</div>
		</div>
	{/option:!authenticate}

{/form:settings}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
