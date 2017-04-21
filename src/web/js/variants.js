if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.fieldvariant = {
    csrf_param: '_csrf',
    csrf_token: '',
    init: function() {
        $(document).on('change', '.dvizh-field input[type=radio], input[type=checkbox], .dvizh-field select', this.choiceVariant);

        dvizh.fieldvariant.csrf_param = $('meta[name="csrf-param"]').attr('content');
        dvizh.fieldvariant.csrf_token = $('meta[name="csrf-token"]').attr('content');
    },
    choiceVariant: function() {
        var li = $(this).parent();

        var field_id = $(this).parents('.field-data-container').data('id');
        var item_id = $(this).parents('.field-data-container').data('item-id');
        var model_name = $(this).parents('.field-data-container').data('model-name');

        var create_action = $(this).parents('.field-data-container').data('create-action');
        var update_action = $(this).parents('.field-data-container').data('update-action');
        var delete_action = $(this).parents('.field-data-container').data('delete-action');

        if($(this).is('select') | $(this).is('input[type=radio]')) {
            var variant_id = $(this).val();
            if(variant_id <= 0) {
                $.post(delete_action, {field_id: field_id, variant_id: variant_id, item_id: item_id},
                    function(json) {
                        if(json.result == 'success') {
                            $(li).css('opacity', '1');
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

                $.post(update_action, data,
                    function(json) {
                        $(li).css('opacity', '1');
                    }, "json");
            }
        }
        else if($(this).prop('checked')) {
            var variant_id = $(this).data('id');
            var data = {};
            data.FieldValue = {};
            data.FieldValue.variant_id = variant_id;
            data.FieldValue.field_id = field_id;
            data.FieldValue.item_id = item_id;
            data[dvizh.fieldvariant.csrf_param] = dvizh.fieldvariant.csrf_token;

            $.post(create_action, data,
                function(json) {
                    $(li).css('opacity', '1');
                }, "json");
        }
        else {
            var variant_id = $(this).data('id');
            $.post(delete_action, {variant_id: variant_id, item_id: item_id},
                function(json) {
                    if(json.result == 'success') {
                        $(li).css('opacity', '1');
                    }
                    else {
                        alert('Error');
                    }
                }, "json");
        }
    },
};

dvizh.fieldvariant.init();
