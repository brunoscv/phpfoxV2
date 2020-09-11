

    <div class="panel panel-default">
        <table class="table table-bordered table-admin">
            <thead>
            <tr>
                <th>{_p var="name"}</th>
                <th>{_p var="url"}</th>
                <th>
                    {_p var="icon"}
                </th>
                <th class="t_center">{_p var='settings'}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$aMenus key=iKey item=aMenu}
                <tr>
                    <td class="w200">{$aMenu.name}</td>
                    <td>{$aMenu.url_value}</td>
                    <td>
                        {if !empty($aMenu.mobile_icon) || !empty($aMenu.image_path)}
                            {if !empty($aMenu.mobile_icon) && !empty($aMenu.image_path)}
                                <img src="{$aMenu.full_path}" alt="" width="32" height="32">
                            {else}
                                {if $aMenu.module_id == 'pages'}
                                    <i class="ico ico-flag-waving-o" style="color: #3b5998"></i>
                                {else}
                                    <i class="{$aMenu.mobile_icon}" style="color: #3b5998"></i>
                                {/if}
                            {/if}
                        {else}
                            <i class="ico ico-box-o"></i>
                        {/if}
                    </td>
                    <td class="w80 t_center">
                        <a class="js_drop_down_link" role="button"></a>
                        <div class="link_menu">
                            <ul class="dropdown-menu text-left dropdown-menu-right">
                                <li><a id="js_change_icon" href="{url link='admincp.yncfbclone.edit-icons' id=$aMenu.menu_id}" data-id="{$aMenu.menu_id}">{_p var='change_icon'}</a></li>
                                {if !empty($aMenu.suggested_icon)}
                                    <li><a href="{url link='admincp.yncfbclone.menu-icons' id=$aMenu.menu_id suggested_icon=$aMenu.suggested_icon}" class="sJsConfirm" data-message="{_p var='apply_facebook_clone_stock_icon_for_this_menu'}">{_p var='use_stock_icon'}</a></li>
                                {/if}
                                <li><a href="{url link='admincp.yncfbclone.menu-icons' reset=$aMenu.menu_id}" class="sJsConfirm" data-message="{_p var='are_you_sure_you_want_to_reset_the_menu_icon_to_default'}">{_p var='reset_to_default'}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>


