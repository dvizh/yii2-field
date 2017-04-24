if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.fieldvalue = {
    csrf_param: '_csrf',
    csrf_token: '',
    update_action: '',
    init: function() {
        jQuery(document).on('change', '.dvizh-field input[type=text],.dvizh-field input[type=number],.dvizh-field input[type=date],.dvizh-field textarea', this.changeListener);

        jQuery(document).on('click', '.field-save-value', function() {
            jQuery(this).parent('span').siblings('input,textarea').change();
            jQuery(this).parent('div').siblings('div').find('input,textarea').change();
            return false;
        });

        jQuery(document).on('keypress', '.dvizh-field input[type=text]', function(e) {
            if(e.which == 13) {
                jQuery(this).change();
            }
        });

        dvizh.fieldvalue.csrf_param = jQuery('meta[name="csrf-param"]').attr('content');
        dvizh.fieldvalue.csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
    },
    changeListener: function() {
        var value = jQuery(this).val();
        var field_id = jQuery(this).data('id');
        var item_id = jQuery(this).data('item-id');
        var model_name = jQuery(this).data('model-name');
        dvizh.fieldvalue.update_action = jQuery(this).parents('.field-data-container').data('update-action');

        jQuery('.field-save-value').css('opacity', '0.4');

        dvizh.fieldvalue.setValue(field_id, model_name, item_id, value);
    },
    setValue: function(field_id, model_name, item_id, value) {
        var data = {};
        data.FieldValue = {};
        data.FieldValue.field_id = field_id;
        data.FieldValue.item_id = item_id;
        data.FieldValue.model_name = model_name;
        data.FieldValue.value = value;
        data[dvizh.fieldvalue.csrf_param] = dvizh.fieldvalue.csrf_token;

        jQuery.post(dvizh.fieldvalue.update_action, data,
            function(json) {
                jQuery('.field-save-value').css('opacity', '1');

                if(json.error) {
                    jQuery(json.error).each(function(i, el) {
                        alert('Error');
                    });
                }
            }, "json");
    },
};

dvizh.fieldvalue.init();
