let ageclassesOption = '';
let disciplinesOption = '';
$(document).ready(function () {
    /* Load positions into postion <selec> */
    $("#competition_id").change(function () {
        window.location.href="/announciators/create/"+$(this).val();
    });

    $.each(disciplines, function (index, value) {
        disciplinesOption += '<option value="' + index + '">' + value + '</option>';
    });
    $.each(ageclasses, function (index, value) {
        ageclassesOption += '<option value="' + index + '">' + value + '</option>';
    });

    $('.dropdown-toggle').dropdown();

    $('#resultBoxShowHide').is(':checked') ? $('#resultBox').show() : $('#resultBox').hide();
    $('#resultBoxShowHide').click(function () {
        this.checked ? $('#resultBox').show(200) : $('#resultBox').hide(200);
    });
    var counter = 1;
    $('#participantGroup').on('click', '.remove', function () {
        $(this).parent().remove();
    });

    $("#addParticipant").click(function () {
        let ageclassSelect;
        let disciplineSelect;
        if(disciplinesOption.length) {
            disciplineSelect = '<select name=discipline[]  class="discipline_select form-control" required placeholder = "Disziplin*" style="width: 100%;">' + disciplinesOption + '</select></div></div>';
        }
        else {
            disciplineSelect = '<input class="form-control required" name="discipline[]" placeholder="Disziplin*" type="text" required></div></div>';
        }
        if (ageclassesOption.length){
            ageclassSelect = '<select name=ageclass[]  class="ageclass_select form-control" required placeholder = "Altersklasse*" style="width: 100%;">' + ageclassesOption + '</select></div></div>';
        }
        else {
            ageclassSelect = '<input class="form-control required" name="ageclass[]" placeholder="Altersklasse*" type="text" required></div></div>';
        }

        $(this).removeAttr("href");
        let newTextBoxDiv = $(document.createElement('div')).attr("id", 'participant' + counter);
        newTextBoxDiv.after().html('<hr>' +
            '<button type="button" style="font-size:2em; color:red" id="remove_' + counter + '" class="remove close btn   mb-2" aria-label="Close">' +
            '<i class="fa fa-close fa-fw"></i><span aria-hidden="true"></span></button>' +
            '<div class="form-group"><div class="input-group">' +
            '<input class="form-control required" name="vorname[]" placeholder="Vorname*" type="text" required></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<input class="form-control" name="nachname[]" placeholder="Nachname*" required type="text"></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang*" type="text" required></div></div>' +
            '<div class="form-group">' +
            '<div class="input-group">'+
             ageclassSelect +
            '<div class="form-group">' +
            '<div class="input-group ">' +
            disciplineSelect +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<input class="form-control" name="bestzeit[]" placeholder="Bestleistung" type="text"></div></div>');
        newTextBoxDiv.appendTo("#participantGroup");
        counter++;
    });
});