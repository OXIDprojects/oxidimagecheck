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
        <tr>
            <td class="edittext"><b>autodelete</b></td>
            <td class="edittext" style="text-align:left;">
                <input class="edittext" type="checkbox" name="autodelete" value='1' [{ $readonly }]>
            </td>
        </tr>
        <tr>
            <td class="edittext" colspan="1">
                <input class="edittext" type="submit" [{$readonly}] value="check or delete useless pics">
            </td>
        </tr>

    </div>
</form>

[{include file="bottomitem.tpl"}]