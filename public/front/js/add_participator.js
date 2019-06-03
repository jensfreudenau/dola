let ageclassesOption = '';
let disciplinesOption = '';
let counterParticipant = 1;

function disciplineSelectList(disciplinesOption, counterParticipant, disciplineGroupId) {
    let disciplineSelect;
    if (disciplinesOption.length) {
        disciplineSelect = '<select name="discipline[' + counterParticipant + '][]" id="disciplineGroup_' + counterParticipant + '_' + disciplineGroupId + '" class="discipline_select form-control" required placeholder = "Disziplin*" style="width: 100%;">' + disciplinesOption + '</select>';
    } else {
        disciplineSelect = '<input name="discipline[' + counterParticipant + '][]" class="form-control required"  placeholder="Disziplin*" type="text" required>';
    }
    return disciplineSelect;
}


function ageclassSelectList(ageclassesOption) {
    let ageclassSelect = '';
    if (ageclassesOption.length) {
        ageclassSelect = '<select name=ageclass[]  class="ageclass_select form-control" required placeholder = "Altersklasse*" style="width: 100%;">' + ageclassesOption + '</select>';
    } else {
        ageclassSelect = '<input class="form-control required" name="ageclass[]" placeholder="Altersklasse*" type="text" required>';
    }
    return ageclassSelect;
}

function setClubname(counterParticipant) {
    let clubnameColl = $("input[name='clubname[]']").map(function () {
        return $(this).val();
    }).get();

    if (clubnameColl[counterParticipant - 1] != 'undifined') {
        return clubnameColl[counterParticipant - 1];
    }
    return '';
}

function addBestimeForms(countParticipant, counterDiscipline) {
    return '<div class="input-group besttime" id="time_' + countParticipant + '_' + counterDiscipline + '" style="display: none;">' +
        '<input id="besttimeGroup_h_' + countParticipant + '" class="form-control" placeholder="HH" name="bestzeit_h[' + countParticipant + '][]" type="text">' +
        '<div class="input-group-prepend"><span class="input-group-text">-</span></div>' +
        '<input id="besttimeGroup_m_' + countParticipant + '" class="form-control" placeholder="Min" name="bestzeit_m[' + countParticipant + '][]" type="text">' +
        '<div class="input-group-prepend"><span class="input-group-text">-</span></div>' +
        '<input id="besttimeGroup_s_' + countParticipant + '" class="form-control" placeholder="Sec" name="bestzeit_s[' + countParticipant + '][]" type="text">' +
        '<div class="input-group-prepend"><span class="input-group-text">,</span></div>' +
        '<input id="besttimeGroup_ms_' + countParticipant + '" class="form-control" placeholder="Zehntelsec." name="bestzeit_ms[' + countParticipant + '][]" type="text">' +
        '</div>';
}

function addRangForms(countParticipant, counterDiscipline) {
    return '<div class="input-group besttime" id="range_' + countParticipant + '_' + counterDiscipline + '" style="display: none;">' +
        '<input id="besttimeGroup_m_' + countParticipant + '" class="form-control" placeholder="m" name="bestweite_m[' + countParticipant + '][]" type="text">' +
        '<div class="input-group-prepend"><span class="input-group-text">,</span></div>' +
        '<input id="besttimeGroup_cm_' + countParticipant + '" class="form-control" placeholder="cm" name="bestweite_cm[' + countParticipant + '][]" type="text">' +
        '</div>';
}

function addPointsForms(countParticipant, counterDiscipline) {
    return '<div class="input-group besttime" id="points_' + countParticipant + '_' + counterDiscipline + '" style="display: none;">' +
        '<input id="besttimeGroup_h_' + countParticipant + '" class="form-control" placeholder="Punkte" name="bestweite_punkte[' + countParticipant + '][]" type="text">' +
        '</div>';
}

$(document).ready(function () {
    let whereAmIIdArr = '0_0'.split('_'); //init
    //////
    $(document).on('change', '.disciplines', function (event) {
        let whereAmIId = $(event.target).attr('id');
        let myVal = event.target.value;
        whereAmIIdArr = whereAmIId.split('_');
        if (disciplineFormats[myVal] == "METRISCH") {
            $('#time_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).hide();
            $('#range_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).show();
            $('#points_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).hide();
        }
        if (disciplineFormats[myVal] == "ZEIT") {
            $('#time_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).show();
            $('#range_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).hide();
            $('#points_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).hide();
        }
        if (disciplineFormats[myVal] == "PUNKTE") {
            $('#time_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).hide();
            $('#range_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).hide();
            $('#points_' + whereAmIIdArr[1] + '_' + whereAmIIdArr[2]).show();
        }
    });
    //////

    $(".disciplines").on('change', function () {
    });
    /* Load positions into postion <selec> */
    $("#competition_id").change(function () {
        window.location.href = "/announciators/create/" + $(this).val();
    });

    if (Object.keys(disciplines).length > 0) {
        disciplinesOption = '<option value="">Disziplin*</option>';
        $.each(disciplines, function (index, value) {
            disciplinesOption += '<option value="' + index + '">' + value + '</option>';
        });
    }
    $.each(ageclasses, function (index, value) {
        ageclassesOption += '<option value="' + index + '">' + value + '</option>';
    });

    $('.dropdown-toggle').dropdown();

    $('#resultBoxShowHide').is(':checked') ? $('#resultBox').show() : $('#resultBox').hide();

    $('#resultBoxShowHide').click(function () {
        this.checked ? $('#resultBox').show(200) : $('#resultBox').hide(200);
    });

    $('#participantGroup').on('click', '.remove_discipline', function () {
        let disciplineGroupId = $(this).attr("id");
        let arr = disciplineGroupId.split('_');
        $('.discipline_' + arr[1] + '_' + arr[2]).remove();
    });

    $('#participantGroup').on('click', '.remove', function () {
        let participantId = $(this).attr("id");
        let arr = participantId.split('_');
        $('#singleParticipant_' + arr[1]).remove();
    });

    let disciplineCounter = 1;

    $('#participantGroup').on('click', '.addDiscipline', function () {
        let disciplineId = $(this).attr("id");
        let arr = disciplineId.split('_');
        let countParticipant = arr[1];
        let disciplineGroupId = $(this).parent().parent().attr("id");
        let disciplineSelect = disciplineSelectList(disciplinesOption, countParticipant, disciplineCounter);
        $(this).removeAttr("href");
        $('<div class="form-group col-md-5 discipline_' + countParticipant + '_' + disciplineCounter + '"> ' + disciplineSelect + '</div>' +
            '<div class="form-group col-md-6 discipline_' + countParticipant + '_' + disciplineCounter + '" id="besttimeGroup' + disciplineCounter + '">' +
            addBestimeForms(countParticipant, disciplineCounter) +
            addRangForms(countParticipant, disciplineCounter) +
            addPointsForms(countParticipant, disciplineCounter) +
            '</div>' +
            '<div class="form-group col-md-1 discipline_' + countParticipant + '_' + disciplineCounter + '">' +
            '<button type="button" id="remove_' + countParticipant + '_' + disciplineCounter + '" class="remove_discipline btn-custom-delete btn-lg" aria-label="Close"><i class="fa fa-trash-o"></i><span aria-hidden="true"></span></button>' +
            '</div>'
        ).appendTo('#' + disciplineGroupId);
        disciplineCounter++;
    });

    $("#addParticipant").click(function () {

        let clubname = setClubname(counterParticipant);
        let disciplineSelect = disciplineSelectList(disciplinesOption, counterParticipant, 0);
        let ageclassSelect = ageclassSelectList(ageclassesOption);

        $(this).removeAttr("href");
        $('<div id="singleParticipant_' + counterParticipant + '">' +
            '<div class="form-row">' +
            '<button type="button" id="remove_' + counterParticipant + '" class="remove close btn-sm mb-2" aria-label="Close"><i class="fa fa-trash-o fa-fw"></i><span aria-hidden="true"></span></button>' +
            '</div>' +
            '<div class="form-row">' +
            '<div class="form-group col-md-6">' +
            '<input class="form-control required" name="vorname[]" placeholder="Vorname*" type="text" required>' +
            '</div>' +
            '<div class="form-group col-md-6">' +
            '<input class="form-control" name="nachname[]" placeholder="Nachname*" type="text" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-row">' +
            '<div class="form-group col-md-6">' + ageclassSelect + '</div> ' +
            '<div class="form-group  col-md-6">' +
            '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang*" type="text" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-row disciplines" id="disciplines' + counterParticipant + '">' +
            '<div class="form-group col-md-5 discipline_' + counterParticipant + '_0" >' + disciplineSelect + '</div>' +
            '<div class="form-group col-md-6" id="besttimeGroup' + counterParticipant + '_0"">' +
            addBestimeForms(counterParticipant, 0) +
            addRangForms(counterParticipant, 0) +
            addPointsForms(counterParticipant, 0) +
            '</div>' +
            '<div class="form-group col-md-1">' +
            '<button id="addDiscipline_' + counterParticipant + '" name="addDiscipline" class="btn-lg btn-custom-add addDiscipline" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>' +
            '</div>' +
            '</div> ' +
            '<div class="form-group">' +
            '<div class="input-group">' +
            '<input class="form-control" name="clubname[]" value= "' + clubname + '" placeholder="Verein" type="text">' +
            '</div> ' +
            '</div>' +
            '<hr>').appendTo("#participantGroup");
        counterParticipant++;
    });
});
