<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
defined('PHPFOX') or exit('NO DICE!');
?>
{literal}
    <script>
        $Ready(function(){
            runChange = function(value)
            {
                if (value == 'Odnoklassniki') {
                    $('#key').show();
                } else {
                    $('#key').hide();
                }

                $('.instructions div').hide();
                $('#' + value + '_instruction').show();
            }
        })
    </script>
    <style>
        .default_image img{
            display: none;
        }
        .instructions div{
            display: none;
            line-height: 25px;
            margin-bottom: 20px;
        }
    </style>
{/literal}
{if !empty($aForms)}
    {literal}
    <style>
        #{/literal}{$aForms.adapter}_instruction{literal}{
            display: block;
        }
    </style>
    {/literal}
{else}
    {literal}
    <style>
        #Facebook_instruction{
            display: block;
        }
    </style>
    {/literal}
{/if}
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{url link='admincp.socialconnect.add'}" enctype="multipart/form-data">
            {if $bIsEdit}
                <div><input type="hidden" name="edit" value="{$iEditId}" /></div>
            {/if}
            <div class="form-group">
                <label>{_p('Select adapter')}:</label>
                  <select  class="form-control" name="val[adapter]" onchange="runChange($(this).val())">
                      <option value="Facebook" {if $aForms.adapter == 'Facebook'}selected{/if}>{_p var='Facebook'}</option>
                      <option value="Twitter" {if $aForms.adapter == 'Twitter'}selected{/if}>{_p var='Twitter'}</option>
                      <option value="LinkedIn" {if $aForms.adapter == 'LinkedIn'}selected{/if}>{_p var='LinkedIn'}</option>
                      <option value="Yahoo" {if $aForms.adapter == 'Yahoo'}selected{/if}>{_p var='Yahoo'}</option>
                      <option value="WindowsLive" {if $aForms.adapter == 'WindowsLive'}selected{/if}>{_p var='WindowsLive'}</option>
                      <option value="Google" {if $aForms.adapter == 'Google'}selected{/if}>{_p var='Google'}</option>
                      <option value="Vkontakte" {if $aForms.adapter == 'Vkontakte'}selected{/if}>{_p var='Vkontakte'}</option>
                      <option value="TwitchTV" {if $aForms.adapter == 'TwitchTV'}selected{/if}>{_p var='Twitch'}</option>
                      <option value="Odnoklassniki" {if $aForms.adapter == 'Odnoklassniki'}selected{/if}>{_p var='Odnoklassniki'}</option>
                      <option value="GitHub" {if $aForms.adapter == 'GitHub'}selected{/if}>{_p var='GitHub'}</option>
                  </select>
            </div>

            <div class="form-group">
                <div class="default_image">
                    <img src="{$path}Facebook.png" id="Facebook" />
                    <img src="{$path}Twitter.png" id="Twitter" />
                    <img src="{$path}Yahoo.png" id="Yahoo" />
                    <img src="{$path}WindowsLive.png" id="WindowsLive" />
                    <img src="{$path}Google.png" id="Google" />
                    <img src="{$path}Vkontakte.png" id="Vkontakte" />
                    <img src="{$path}TwitchTV.png" id="TwitchTV" />
                    <img src="{$path}LinkedIn.png" id="LinkedIn" />
                    <img src="{$path}Odnoklassniki.png" id="Odnoklassniki" />
                    <img src="{$path}GitHub.png" id="GitHub" />
                </div>
                {if !empty($aForms.image_path)}
                    <div>
                        <img src="{$aForms.image_path}" style="max-width: 100px;" />
                    </div>
                {/if}
                <label>{_p('Image')}:</label>
                <input class="form-control" type="file" name="image_path" size="30" />
                <p class="help-block">
                    {_p var='If you want to replace DEFAULT image upload your version.'}
                </p>
            </div>
            <div class="form-group instructions">
                <label>{_p var='Instructions'}</label>
                <div id="Facebook_instruction">
                    Go to <a href="https://developers.facebook.com/apps">https://developers.facebook.com/apps</a> and create a new application by clicking "Create New App".<br/>
                    Fill out any required fields such as the application name and description.<br/>
                    Put your website domain in the Site Url field.<br/>
                    In Facebook Login  -> Settings You also need to add a Valid OAuth Redirect URIs<b> Exactly -  &nbsp; {$sitename}facebook/</b><br/>
                    Once you have registered, copy and past the created application credentials (App ID and Secret) into the Settings below.<br/>
                </div>
                <div id="Twitter_instruction">
                    Go to <a href="https://developer.twitter.com/">https://developer.twitter.com/</a> and create a new application (Before you need to get devaccess, please fill all data and wait until twitter team approve it).<br/>
                    Fill out any required fields such as the application name and description.<br/>
                    Put your website domain in the Website field.<br/>
                    Provide this URL as the Redirect URL for your application: <b> Exactly -  &nbsp; {$norm}twitter</b><br/>
                    Once you have registered, copy and past the created application credentials (Key and Secret) into the Settings below.<br/>
                </div>
                <div id="Yahoo_instruction">
                    Go to <a href="https://developer.yahoo.com/apps">https://developer.yahoo.com/apps</a> and create a new application by clicking "Create an App".<br/>
                    Fill out any required fields such as the Application Name.<br/>
                    Specify the domain to which your application will be returning after successfully authenticating. (<b>{$norm}</b>)<br/>
                    Select private user data APIs that your application needs to access.<br/>
                </div>
                <div id="WindowsLive_instruction">
                    Sign in to the Windows Live application management site (<a href="https://apps.dev.microsoft.com/">https://apps.dev.microsoft.com/</a>).<br/>
                    Click Add an app on this page.<br/>
                    Type an application name. This is the name that users will see in the Windows Live user interface (UI). The application name should include your company name or the name of your web site.<br/>
                    Generate Application Secret by clicking Generate New Password.<br/>
                    Select Web as a platform by clicking Add Platform.<br/>
                    Provide this URL as Redirect URLs: <b> Exactly -  &nbsp; {$sitename}windowslive/</b><br/>
                    Click Save. This action registers your application.<br/>
                    Once you have registered, copy and past the created application credentials (ID and Secret) into the Settings below.<br/>
                </div>
                <div id="Google_instruction">
                    Go to the Google Developers Console(<a href="https://console.cloud.google.com">https://console.cloud.google.com</a>).<br/>
                    From the project drop-down, select a project, or create a new one.<br/>
                    Enable the Google+ API service:<br/>
                    In the list of Google APIs, search for the Google+ API service.<br/>
                    Select Google+ API from the results list.<br/>
                    Press the Enable API button.<br/>
                    When the process completes, Google+ API appears in the list of enabled APIs. To access, select API Manager on the left sidebar menu, then select the Enabled APIs tab.<br/>
                    In the sidebar under "API Manager", select Credentials.<br/>
                    In the Credentials tab, select the New credentials drop-down list, and choose OAuth client ID.<br/>
                    From the Application type list, choose the Web application.<br/>
                    Enter a name and provide this URL as Authorized redirect URIs:<b> Exactly - &nbsp; {$sitename}google/</b> <br/>
                    Once you have registered, copy and past the created application credentials (ID and Secret) into the Settings below.<br/>
                </div>
                <div id="Vkontakte_instruction">
                    Go to <a href="https://vk.com/apps?act=manage">https://vk.com/apps?act=manage</a> and create a new application by clicking "Create an App".<br/>
                    Provide this URL as Authorized redirect URIs:<b> Exactly - &nbsp; {$sitename}vkontakte</b> <br/>
                    Once you have registered, copy and past the created application credentials (ID and Secret) into the Settings below.<br/>
                </div>
                <div id="TwitchTV_instruction">
                    Go to <a href="https://dev.twitch.tv/dashboard">https://dev.twitch.tv/dashboard</a> and create a new application.<br/>
                    Fill out any required fields such as the application name and description.<br/>
                    Provide this URL as the Redirect URI <b> Exactly - &nbsp; {$sitename}twitchtv/</b> <br/>
                    Once you have registered, copy and past the created application credentials (ID and Secret) into the Settings below.<br/>
                </div>
                <div id="LinkedIn_instruction">
                    Go to <a href="https://www.linkedin.com/developer/apps">https://www.linkedin.com/developer/apps</a> and create a new application by clicking "Create Application".<br/>
                    Fill out any required fields such as the application name and description.<br/>
                    Provide this URL as the Redirect URI  <b> Exactly - &nbsp; {$sitename}linkedin</b> <br/>
                    Once you have registered, copy and past the created application credentials (ID and Secret) into the Settings below.<br/>
                </div>
                <div id="Odnoklassniki_instruction">
                    <a href="https://ok.ru/devaccess">https://ok.ru/devaccess</a> get dev access here<br/>
                    <a href="https://ok.ru/vitrine/myuploaded">https://ok.ru/vitrine/myuploaded</a> create new app here<br/>
                    Provide this URL as the Redirect URI  <b> Exactly - &nbsp;{$sitename}odnoklassniki/</b> <br/>
                    After creating app, mail with your site information to api-support@odnoklassniki.ru and request to enable GET_EMAIL functions, after they approve this you may use this connection, <b>except no!</b> <br/>
                    Once you have registered, copy and past the created application credentials (ID, Key and Secret) into the Settings below.<br/>
                </div>
                <div id="GitHub_instruction">
                    Go to <a href="https://github.com/settings/applications/new">https://github.com/settings/applications/new</a> then create a new application. Fill required input <br/>
                    Once you have registered, copy and past the created application credentials (ID and Secret) into the Settings below.<br/>
                    Provide this URL as the Redirect URI <b> Exactly - &nbsp; {$norm}github</b> <br/>
                </div>
            </div>
            <div class="form-group">
                <label>{_p('App Id')}:</label>
                <input class="form-control" type="text" name="val[client]" value="{value id=client type='input'}" size="30" />
            </div>
            <div class="form-group">
                <label>{_p('Secret')}:</label>
                <input class="form-control" type="text" name="val[secret]" value="{value id=secret type='input'}" size="30" />
            </div>
            <div class="form-group" id="key" style="{if $aForms.adapter != 'Odnoklassniiki'}display: none;{/if}">
                <label>{_p('Key (only for Odnoklassniki)')}:</label>
                <input class="form-control" type="text" name="val[client_key]" value="{value id=client_key type='input'}" size="30" />
            </div>
            <div class="form-group">
                <input type="submit" value="{_p('submit')}" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>