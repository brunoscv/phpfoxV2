<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:21 pm */ ?>
<?php

?>

<?php if (isset ( $this->_aVars['error'] ) && $this->_aVars['error']): ?>
<div class="error_message">
<?php echo $this->_aVars['error']; ?>
</div>
<?php else: ?>
<div class="js_box_actions">
	<div>
<?php echo _p("Import File"); ?>
		<span>
			<input type="file" name="file" class="ajax_upload" data-url="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.app.add'); ?>">
		</span>
	</div>
</div>
<form method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.app.add'); ?>" class="ajax_post" id="create-app">
	<div class="vendor_create">
        <div class="panel panel-default">
            <div class="panel-body">
                <pre id="debug_info" class="hide alert alert-danger"></pre>
                <div class="form-group">
                    <label for="name">*<?php echo _p('App ID'); ?></label>
                    <input required type="text" name="val[name]" placeholder="<?php echo _p('App ID'); ?>" id="create-app-info" class="form-control">
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" value="<?php echo _p('submit'); ?>" class="btn btn-primary" />
            </div>
        </div>
	</div>

</form>

<script type="text/javascript">
		var pingApp = '<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.app.ping'); ?>';
		<?php echo '
		var runPing = function() {
			var scriptUrl = pingApp + \'?ping-no-session=1&url=\' + encodeURIComponent($(\'#create-app-info\').val()) + \'&t=\' + (new Date()).getTime();
			$(\'body\').append(\'<script src="\' + scriptUrl + \'"><\/script>\');
		};
		$Ready(function() {
			$(\'#create-app\').submit(function() {
				$(\'.table_clear\').hide();
				$(\'#debug_info\').show();
				runPing();
			});
		});
		'; ?>

</script>
<?php endif; ?>
