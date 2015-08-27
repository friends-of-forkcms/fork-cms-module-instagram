{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
    <h2>{$lblInstagram|ucfirst}: {$lblAdd}</h2>
</div>

{form:add}
    <label for="name">{$lblUsername|ucfirst}</label>
    {$txtUsername} {$txtUsernameError}

    <div id="pageUrl">
        <div class="oneLiner">
            {option:detailURL}<p><span><a href="{$detailURL}{option:item}/{$item.url}{/option:item}">{$detailURL}/<span id="generatedUrl"></span></a></span></p>{/option:detailURL}
            {option:!detailURL}<p class="infoMessage">{$errNoModuleLinked}</p>{/option:!detailURL}
        </div>
    </div>


    {*<div class="tabs">*}
        {*<ul>*}
            {*<li><a href="#tabContent">{$lblContent|ucfirst}</a></li>*}
            {*<li><a href="#tabSEO">{$lblSEO|ucfirst}</a></li>*}
        {*</ul>*}

        {*<div id="tabContent">*}
            {*<table border="0" cellspacing="0" cellpadding="0" width="100%">*}
                {*<tr>*}
                    {*<td id="leftColumn">*}

                        {*<div class="box">*}
                            {*<div class="heading">*}
                                {*<h3>*}
                                    {*<label for="function">{$lblFunction|ucfirst}</label>*}
                                {*</h3>*}
                            {*</div>*}
                            {*<div class="options">*}
                                {*{$txtFunction} {$txtFunctionError}*}
                            {*</div>*}
                        {*</div>*}


                    {*</td>*}

                {*</tr>*}
            {*</table>*}
        {*</div>*}

        {*<div id="tabSEO">*}
            {*{include:{$BACKEND_CORE_PATH}/Layout/Templates/Seo.tpl}*}
        {*</div>*}

    {*</div>*}

    <div class="fullwidthOptions">
        <div class="buttonHolderRight">
            <input id="addButton" class="inputButton button mainButton" type="submit" name="add" value="{$lblPublish|ucfirst}" />
        </div>
    </div>
{/form:add}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
