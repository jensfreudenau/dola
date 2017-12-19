
$(document).ready(function () {
    let disciplinesOption = '';
    $.each(disciplines, function( index, value ) {
        disciplinesOption += '<option value="'+index+'">'+ value +'</option>';
    });
    let ageclassesOption = '';
    $.each(ageclasses, function( index, value ) {
        ageclassesOption += '<option value="'+index+'">'+ value +'</option>';
    });

    $('.dropdown-toggle').dropdown();
    $('#cbxShowHide').is(':checked') ? $('#block').show() : $('#block').hide();
    $('#cbxShowHide').click(function () {
        this.checked ? $('#block').show(200) : $('#block').hide(200);
    });

    var counter = 1;
    $('#participantGroup').on('click', '.remove', function () {
        $(this).parent().remove();
    });

    $("#addParticipant").click(function () {

        $(this).removeAttr("href");
        let newTextBoxDiv = $(document.createElement('div')).attr("id", 'participant' + counter);
        newTextBoxDiv.after().html('<hr>' +
            '<button type="button" id="remove_' + counter + '" class="remove close btn btn-outline-danger mb-2" aria-label="Close">' +
            '<i class="fa fa-close fa-fw"></i><span aria-hidden="true"></span></button>' +
            '<div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
            '<input class="form-control required" name="vorname[]" placeholder="Vorname*" type="text" required></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-book fa-fw"></i></span>' +
            '<input class="form-control" name="nachname[]" placeholder="Nachname*" required type="text"></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-circle-o fa-fw"></i></span>' +
            '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang" type="text"></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>' +
            '<select name=ageclass[]  class="ageclass_select form-control" required placeholder = "Altersklasse*" style="width: 100%;">' + ageclassesOption + '</select></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group ">' +
            '<span class="input-group-addon"><i class="fa fa-sun-o fa-fw"></i></span> ' +
            '<select name=discipline[]  class="discipline_select form-control" required placeholder = "Disziplin*" style="width: 100%;">' + disciplinesOption + '</select>'+
            '</div></div>'+
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<span class="input-group-addon"><i class="fa fa-clock-o fa-fw"></i></span>' +
            '<input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text"></div></div>');
        newTextBoxDiv.appendTo("#participantGroup");



        counter++;
    });
});
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