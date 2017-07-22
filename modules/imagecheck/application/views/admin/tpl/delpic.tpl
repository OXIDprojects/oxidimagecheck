[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="delpic">
    <input type="hidden" name="editlanguage" value="[{ $editlanguage }]">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cur" value="[{ $oCurr->id }]">
    <input type="hidden" name="cl" value="delpic">
    <input type="hidden" name="fnc" value="delipic">
    <div class="form">
        <br />
        <input class="edittext" type="checkbox" name="autodelete" value='1' [{ $readonly }]>
        <b>Delete unneccesary images automatically.</b>
        <br /><br />
        <i>Be careful! This module thinks not beeing used means not beeing referenced by any categories or products.</i><br />
        <i>If you use images of your category and product-image directories elswhere (e.g. in other content elements, blogs, ...),</i><br />
        <i>automatically deleting them is not a wise decision.</i>
        <br />
        <br />
        <input class="edittext" type="submit" [{$readonly}] value="check or delete useless pics">
    </div>
</form>

[{include file="bottomitem.tpl"}]
