$(document).ready(function () {
    var counter = 0;

    $('#additionalGroup').on('click', '.remove', function () {
        $(this).parent().remove();
    });

    $("#addValues").click(function () {
        $(this).removeAttr("href");
        let newTextBoxDiv = $(document.createElement('div'));
        newTextBoxDiv.after().html(
            '<button type="button" id="remove_' + counter + '" class="remove close btn btn-outline-danger mb-2" aria-label="Close">' +
            '<i class="fa fa-close fa-fw"></i><span aria-hidden="true"></span></button>'+
            '<div class="form-group"><div class="input-group">' +
            '<label for="additional-key_' + counter + '">Key</label>' +
            '<input id="additional-key_' + counter + '" class="form-control" name="keyvalue[' + counter + '][key]" type="text">' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<label for="additional-value_' + counter + '">Value</label>' +
            '<input id="additional-value_' + counter + '" class="form-control" name="keyvalue[' + counter + '][value]" type="text">' +
            '</div>' +
            '</div>'
        );
        newTextBoxDiv.appendTo("#additionalGroup");
        counter++;
    });
});