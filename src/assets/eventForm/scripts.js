jQuery('#eventeventhandler-method').change(function () {
    var handlerId = jQuery('#eventeventhandler-event_handler_id').val();
    var methodName = jQuery(this).val();
    for (var index in handlersList) {
        if (handlersList[index]['id'] == handlerId && handlersList[index]['methodName'] == methodName) {
            jQuery('#php-doc').val(handlersList[index]['phpDoc']);
        }
    }
});
jQuery('#eventeventhandler-event_handler_id').change(function () {
    var id = jQuery(this).val();
    var $methods = jQuery('#eventeventhandler-method').empty();
    var eventClassName = eventsList[jQuery('#eventeventhandler-event_id').val()]['event_class_name'];
    for (var index in handlersList) {
        if (handlersList[index]['id'] == id && handlersList[index]['eventClassName'] == eventClassName) {
            jQuery('<option>').attr('value', handlersList[index]['methodName']).text(handlersList[index]['methodName']).appendTo($methods);
        }
    }
    $methods.trigger('change');
});
jQuery('#eventeventhandler-event_id').change(function () {
    var id = jQuery(this).val();
    var eventClassName = eventsList[id]['event_class_name'];
    var $handlers = jQuery('#eventeventhandler-event_handler_id').empty();
    var handlerIds = [];
    for (var index in handlersList) {
        if (handlersList[index]['eventClassName'] == eventClassName && handlerIds.indexOf(handlersList[index]['id']) == -1) {
            jQuery('<option>').attr('value', handlersList[index]['id']).text(handlersList[index]['name']).appendTo($handlers);
            handlerIds.push(handlersList[index]['id']);
        }
    }
    $handlers.trigger('change');
}).trigger('change');
