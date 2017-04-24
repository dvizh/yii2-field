if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.fieldvariant = {
    csrf_param: '_csrf',
    csrf_token: '',
    init: function() {
        jQuery(document).on('change', '.dvizh-field input[type=radio], input[type=checkbox], .dvizh-field select', this.choiceVariant);

        dvizh.fieldvariant.csrf_param = jQuery('meta[name="csrf-param"]').attr('content');
        dvizh.fieldvariant.csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
    },
    choiceVariant: function() {
        var li = jQuery(this).parent();

        jQuery(li).css('opacity', '0.3');

        var field_id = jQuery(this).parents('.field-data-container').data('id');
        var item_id = jQuery(this).parents('.field-data-container').data('item-id');
        var model_name = jQuery(this).parents('.field-data-container').data('model-name');

        var create_action = jQuery(this).parents('.field-data-container').data('create-action');
        var update_action = jQuery(this).parents('.field-data-container').data('update-action');
        var delete_action = jQuery(this).parents('.field-data-container').data('delete-action');

        if(jQuery(this).is('select') | jQuery(this).is('input[type=radio]')) {
            var variant_id = jQuery(this).val();
            if(variant_id <= 0) {
                jQuery.post(delete_action, {field_id: field_id, variant_id: variant_id, item_id: item_id},
                    function(json) {
                        if(json.result == 'success') {
                            jQuery(li).css('opacity', '1');
                        }
                        else {
                            alert('Error');
                        }
                    }, "json");
            }
            else {
                var data = {};
                data.FieldValue = {};
                data.FieldValue.variant_id = variant_id;
                data.FieldValue.field_id = field_id;
                data.FieldValue.model_name = model_name;
                data.FieldValue.item_id = item_id;
                data[dvizh.fieldvariant.csrf_param] = dvizh.fieldvariant.csrf_token;

                jQuery.post(update_action, data,
                    function(json) {
                        jQuery(li).css('opacity', '1');
                    }, "json");
            }
        }
        else if(jQuery(this).prop('checked')) {
            var variant_id = jQuery(this).data('id');
            var data = {};
            data.FieldValue = {};
            data.FieldValue.variant_id = variant_id;
            data.FieldValue.field_id = field_id;
            data.FieldValue.item_id = item_id;
            data[dvizh.fieldvariant.csrf_param] = dvizh.fieldvariant.csrf_token;

            jQuery.post(create_action, data,
                function(json) {
                    jQuery(li).css('opacity', '1');
                }, "json");
        }
        else {
            var variant_id = jQuery(this).data('id');
            jQuery.post(delete_action, {variant_id: variant_id, item_id: item_id},
                function(json) {
                    if(json.result == 'success') {
                        jQuery(li).css('opacity', '1');
                    }
                    else {
                        alert('Error');
                    }
                }, "json");
        }
    },
};

dvizh.fieldvariant.init();
