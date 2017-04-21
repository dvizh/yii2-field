if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.fieldvalue = {
    csrf_param: '_csrf',
    csrf_token: '',
    init: function() {
        $(document).on('change', '.dvizh-field input[type=text], .dvizh-field input[type=number], .dvizh-field input[type=date], .dvizh-field textarea', this.setValue);

        $(document).on('click', '.field-save-value', function() {
            $(this).parent('span').siblings('input').change();
            return false;
        });

        $(document).on('keypress', '.dvizh-field input[type=text]', function(e) {
            if(e.which == 13) {
                $(this).change();
            }
        });

        dvizh.fieldvalue.csrf_param = $('meta[name="csrf-param"]').attr('content');
        dvizh.fieldvalue.csrf_token = $('meta[name="csrf-token"]').attr('content');
    },
    setValue: function() {
        var value = $(this).val();
        var field_id = $(this).data('id');
        var item_id = $(this).data('item-id');
        var model_name = $(this).data('model-name');
        var update_action = $(this).parents('.field-data-container').data('update-action');

        var data = {};
        data.FieldValue = {};
        data.FieldValue.field_id = field_id;
        data.FieldValue.item_id = item_id;
        data.FieldValue.model_name = model_name;
        data.FieldValue.value = value;
        data[dvizh.fieldvalue.csrf_param] = dvizh.fieldvalue.csrf_token;

        $.post(update_action, data,
            function(json) {
                
            }, "json");
    },
};

dvizh.fieldvalue.init();
