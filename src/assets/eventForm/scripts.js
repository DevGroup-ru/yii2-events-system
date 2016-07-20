jQuery('#eventeventhandler-event_handler_id').change(function () {
    var id = jQuery(this).val();
    var $methods = jQuery('#eventeventhandler-method').empty();
    for (var index in handlersList) {
        if (handlersList[index]['id'] == id) {
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
