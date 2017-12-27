$(".competition_select").select2({
    width: 'resolve'
});

/* Load positions into postion <selec> */
$("#competition_id").change(function () {
    $.getJSON("/announciators/competitions_select/" + $(this).val(), function (jsonData) {
        $('#organizer_name').val(jsonData.organizer.name);
        $('#header').val(jsonData.header);
        $('#start_date').val(jsonData.start_date);
    });
});