<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:08 pm */ ?>
<?php 

 echo Phpfox::getLib('template')->addScript('share.js', 'module_attachment',true); ?>
<div class="attachment-holder" id="<?php echo $this->_aVars['holderId']; ?>">
    <div class="global_attachment global_attachment__has_file">
        <div class="global_attachment_header">
            <div class="global_attachment_manage">
                <a class="border_radius_4" role="button" onclick="$Core.Attachment.toggleAttachmentForm(this)" id="attachment-toggle-button">
                    <span class="ico ico-paperclip-alt"></span> <span class="item-label-text"><?php echo _p('attachments'); ?></span> <span class="attachment-counter"><?php if (! empty ( $this->_aVars['aForms']['total_attachment'] )): ?>(<?php echo $this->_aVars['aForms']['total_attachment']; ?>)<?php else: ?>(0)<?php endif; ?></span>
                    <span class="ico ico-angle-down"></span>
                </a>
            </div>
            <ul class="global_attachment_list" data-id="<?php echo $this->_aVars['id']; ?>">
                <li>
                    <a role="button" onclick="$Core.Attachment.attachPhoto(this)" class="js_global_position_photo js_hover_title">
                        <span class="ico ico-photo-plus-o"></span>
                        <span class="js_hover_info"><?php echo _p('insert_a_photo'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="attachment-form-holder" style="display: none;">
        <div id="attachment_params">
            <input type="hidden" name="category_name" value="<?php echo $this->_aVars['aAttachmentShare']['type']; ?>">
            <input type="hidden" name="attachment_obj_id" value="<?php echo $this->_aVars['aAttachmentShare']['id']; ?>">
            <input type="hidden" name="upload_id" value="js_new_temp_form_0_<?php echo $this->_aVars['aAttachmentShare']['type']; ?>">
            <input type="hidden" name="custom_attachment" value="">
            <input type="hidden" name="holder_id" value="<?php echo $this->_aVars['holderId']; ?>">
            <input type="hidden" name="textarea_id" value="<?php echo $this->_aVars['id']; ?>">
            <input type="hidden" name="has_attachment" value="0">
        </div>
<?php if (empty ( $this->_aVars['id'] )): ?>
<?php Phpfox::getBlock('core.upload-form', array('type' => 'attachment','current_photo' => '')); ?>
<?php else: ?>
<?php Phpfox::getBlock('core.upload-form', array('type' => 'attachment','current_photo' => '','id' => $this->_aVars['id'])); ?>
<?php endif; ?>
        <div class="js_attachment_list">
            <div class="js_attachment_list_holder">
                <div class="attachment_holder">
                    <div class="attachment_list">
<?php if (! empty ( $this->_aVars['aForms']['total_attachment'] ) && isset ( $this->_aVars['aAttachmentShare']['edit_id'] )): ?>
<?php Phpfox::getBlock('attachment.list', array('sType' => $this->_aVars['aAttachmentShare']['type'],'iItemId' => $this->_aVars['aAttachmentShare']['edit_id'],'attachment_no_header' => true,'bGetAttachmentList' => true,'editorId' => $this->_aVars['id'])); ?>
<?php endif; ?>
                        <span class="no-attachment <?php if (! empty ( $this->_aVars['aForms']['total_attachment'] )): ?>hide<?php endif; ?>"><?php echo _p('no_attachments_available'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="attachment-form-action">
            <a role="button" onclick="$Core.Attachment.deleteAll(this);" class="attachment-delete-all <?php if (empty ( $this->_aVars['aForms']['total_attachment'] )): ?>hide<?php endif; ?>">
<?php echo _p('delete_all'); ?>
            </a>
            <a role="button" class="btn attachment-close js_hover_title" onclick="$('#attachment-toggle-button', '#<?php echo $this->_aVars['holderId']; ?>').trigger('click')">
                <span class="ico ico-close"></span>
                <span class="js_hover_info"><?php echo _p('close_attachment'); ?></span>
            </a>
        </div>
    </div>
</div>

