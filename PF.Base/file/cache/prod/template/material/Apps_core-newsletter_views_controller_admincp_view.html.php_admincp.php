<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:59 pm */ ?>
<?php

?>
<div class="table form-inline">
    <div class="form-group">
        <label for="select_category"><strong><?php echo _p('view_in'); ?></strong>
            <select id="js_mode" class="form-control" onchange="$Core.Newsletter.toggleMode(this);">
                <option value="html"><?php echo _p('html'); ?></option>
                <option value="plain"><?php echo _p('plain'); ?></option>
            </select>
    </div>
</div>
<div>
<?php if ($this->_aVars['aNewsletter']['text_plain'] != '' && $this->_aVars['aNewsletter']['text_html'] != ''): ?>
    <div id="js_view_newsletter_html" class="js_view_newsletter_content" <?php if ($this->_aVars['aNewsletter']['mode'] != 'html'): ?>style="display:none;"<?php endif; ?>>
<?php echo $this->_aVars['aNewsletter']['text_html']; ?>
    </div>
    <div id="js_view_newsletter_plain" class="js_view_newsletter_content" <?php if ($this->_aVars['aNewsletter']['mode'] != 'plain'): ?>style="display:none;"<?php endif; ?>>
<?php echo $this->_aVars['aNewsletter']['text_plain']; ?>
    </div>
<?php else: ?>
<?php echo _p('this_newsletter_is_empty');  endif; ?>
</div>

<?php echo '
<script type="text/javascript">
	$Core.Newsletter = {
		toggleMode : function(obj) {
			var sMode = $(obj).val();
			$(\'.js_view_newsletter_content\').hide();
			$(\'#js_view_newsletter_\'+sMode).show();
		}
	}
</script>
'; ?>


