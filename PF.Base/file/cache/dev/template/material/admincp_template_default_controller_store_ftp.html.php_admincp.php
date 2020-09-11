<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:53 pm */ ?>
<?php

?>

<?php if ($this->_aVars['type'] != 'module'): ?>
<i class="fa fa-spin fa-circle-o-notch"></i>
<?php endif; ?>
<div id="admincp_install_ftp_information" <?php if ($this->_aVars['type'] != 'module'): ?> style="display:none;"<?php endif; ?>>
    <form method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.store.ftp', array('productName' => $this->_aVars['productName'],'type' => $this->_aVars['type'],'productId' => $this->_aVars['productId'],'extra_info' => $this->_aVars['extra_info'])); ?>" id="form_store_ftp" enctype="multipart/form-data">
        <div>
            <input type="hidden" name="val[type]" value="<?php echo $this->_aVars['type']; ?>"/>
            <input type="hidden" name="val[productName]" value="<?php echo $this->_aVars['productName']; ?>"/>
            <input type="hidden" name="val[productId]" value="<?php echo $this->_aVars['productId']; ?>"/>
            <input type="hidden" name="val[extra_info]" value="<?php echo $this->_aVars['extra_info']; ?>"/>
            <input type="hidden" name="val[targetDirectory]" value="<?php echo $this->_aVars['targetDirectory']; ?>">
            <input type="hidden" name="val[apps_dir]" value="<?php echo $this->_aVars['apps_dir']; ?>">
        </div>
        <div class="form-group">
            <label for="ftp_upload_method"><?php echo _p('file_upload_method'); ?></label>
            <select id="ftp_upload_method" name="val[method]"
                    onchange="if (this.value=='file_system') $('.hide_file_system_items').hide(); else $('.hide_file_system_items').show();">
<?php if (count((array)$this->_aVars['listMethod'])):  foreach ((array) $this->_aVars['listMethod'] as $this->_aVars['sKey'] => $this->_aVars['sMethod']): ?>
                    <option value="<?php echo $this->_aVars['sKey']; ?>" <?php if ($this->_aVars['sKey'] == $this->_aVars['currentUploadMethod']): ?> selected <?php endif; ?>>
<?php echo $this->_aVars['sMethod']; ?>
                    </option>
<?php endforeach; endif; ?>
            </select>
            <p class="help-block"><?php echo _p('sftp_require_extension'); ?></p>
        </div>
        <div class="hide_file_system_items" <?php if ('file_system' == $this->_aVars['currentUploadMethod']): ?> style="display: none" <?php endif; ?>>
            <div class="form-group">
                <label><?php echo _p('ftp_host_name'); ?></label>
                <input type="text" class="form-control" placeholder="<?php echo _p('ftp_host_name'); ?>" value="<?php echo $this->_aVars['currentHostName']; ?>" name="val[host_name]"/>
            </div>

            <div class="form-group">
                <label><?php echo _p('port'); ?></label>
                <input type="text" class="form-control" placeholder="Port" value="<?php echo $this->_aVars['currentPort']; ?>" name="val[port]"/>
            </div>

            <div class="form-group">
                <label><?php echo _p('ftp_user_name'); ?></label>
                <input type="text" class="form-control" placeholder="<?php echo _p('ftp_user_name'); ?>" value="<?php echo $this->_aVars['currentUsername']; ?>" name="val[user_name]"/>
            </div>

            <div class="form-group">
                <label><?php echo _p('ftp_password'); ?></label>
                <input type="text" class="form-control" placeholder="<?php echo _p('ftp_password'); ?>" value="" name="val[password]"/>
            </div>
        </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo _p('Check permission and finalize'); ?>" name="val[submit]"/>
    </div>
    
</form>

</div>

<?php if ($this->_aVars['type'] != 'module'):  echo '
<script>
	$Ready(function() {
		var f = $(\'#form_store_ftp\');
		$(\'#ftp_upload_method\').val(\'file_system\');
		if($(\'.error_message\').length ==0){
            f.trigger(\'submit\');
        }else{
		    $(\'.fa.fa-spin\').hide();
        }
	});
</script>
'; ?>

<?php endif; ?>
