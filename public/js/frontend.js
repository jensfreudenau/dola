
$(document).ready(function () {
    $('.dropdown-toggle').dropdown();
    $('#cbxShowHide').is(':checked') ? $('#block').show() : $('#block').hide();
    $('#cbxShowHide').click(function () {
        this.checked ? $('#block').show(200) : $('#block').hide(200);
    });
    var counter = 2;

    $("#addParticipant").click(function () {
        $(this).removeAttr("href");
        let newTextBoxDiv = $(document.createElement('div')).attr("id", 'participant' + counter);
        newTextBoxDiv.after().html('<hr><div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
            '<input class="form-control required" name="vorname[]" placeholder="Vorname*" type="text" required></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
            '<input class="form-control" name="nachname[]" placeholder="Nachname" type="text"></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>' +
            '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang" type="text"></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>' +
            '<input class="form-control required" name="altersklasse[]" placeholder="Altersklasse" type="text" required></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span>' +
            '<input class="form-control required" name="wettkampf[]" placeholder="Disziplin*" type="text" required></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>' +
            '<input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text"></div></div>');
        newTextBoxDiv.appendTo("#participantGroup");
        counter++;
    });
});
$(".competition_select").select2();
/* Load positions into postion <selec> */
$("#competition_id").change(function () {
    $.getJSON("/announciators/competitions_select/" + $(this).val(), function (jsonData) {
        $('#organizer_name').val(jsonData.organizer.name);
        $('#header').val(jsonData.header);
        $('#start_date').val(jsonData.start_date);
    });
});