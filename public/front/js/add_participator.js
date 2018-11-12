let ageclassesOption = '';
let disciplinesOption = '';

function disciplineSelectList(disciplinesOption, counter) {
    let disciplineSelect;
    if (disciplinesOption.length) {
        disciplineSelect = '<select name="discipline[' + counter + '][]" id="disciplineGroup_' + counter + '" class="discipline_select form-control" required placeholder = "Disziplin*" style="width: 100%;">' + disciplinesOption + '</select>';
    }
    else {
        disciplineSelect = '<input name="discipline[' + counter + '][]" class="form-control required"  placeholder="Disziplin*" type="text" required>';
    }
    return disciplineSelect;
}


function ageclassSelectList(ageclassesOption) {
    let ageclassSelect = '';
    if (ageclassesOption.length) {
        ageclassSelect = '<select name=ageclass[]  class="ageclass_select form-control" required placeholder = "Altersklasse*" style="width: 100%;">' + ageclassesOption + '</select>';
    }
    else {
        ageclassSelect = '<input class="form-control required" name="ageclass[]" placeholder="Altersklasse*" type="text" required>';
    }
    return ageclassSelect;
}

function setClubname(counter) {
    let clubnameColl = $("input[name='clubname[]']").map(function () {
        return $(this).val();
    }).get();

    if(clubnameColl[counter - 1] != 'undifined') {
        return clubnameColl[counter - 1];
    }
    return '';
}

$(document).ready(function () {

    /* Load positions into postion <selec> */
    $("#competition_id").change(function () {
        window.location.href = "/announciators/create/" + $(this).val();
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

    $('#participantGroup').on('click', '.remove_discipline', function () {
        let disciplineGroupId = $(this).attr("id");
        let arr = disciplineGroupId.split('_');
        $('.discipline_'+arr[1]+'_'+arr[2]).remove();

    });

    $('#participantGroup').on('click', '.remove', function () {
        let participantId = $(this).attr("id");
        let arr = participantId.split('_');
        $('#singleParticipant_'+arr[1]).remove();


    });
    let counter = 1;
    let disciplineCounter = 1;

    $('#participantGroup').on('click', '.addDiscipline', function () {
        let disciplineId = $(this).attr("id");
        let arr = disciplineId.split('_');
        let countering = arr[1];
        let disciplineSelect = disciplineSelectList(disciplinesOption, countering);

        $(this).removeAttr("href");

        let disciplineGroupId = $(this).parent().parent().attr("id");
        $(
            '<div class="form-group col-md-5 discipline_' + countering + '_' + disciplineCounter + '"> '+
            disciplineSelect +
            '</div>' +
            '<div class="form-group col-md-6 discipline_' + countering + '_' + disciplineCounter + '" id="besttimeGroup' + disciplineCounter + '">' +
            '<input class="form-control" name="bestzeit[' + countering + '][]" placeholder="Bestleistung" type="text">' +
            '</div>' +
            '<div class="form-group col-md-1 discipline_' + countering+ '_' + disciplineCounter + '">'+
            '<button type="button" id="remove_' + countering + '_' + disciplineCounter + '" class="remove_discipline btn-outline-danger btn-lg" aria-label="Close"><i class="fa fa-trash-o"></i><span aria-hidden="true"></span></button>'+
            '</div>'
        ).appendTo('#'+disciplineGroupId);
        disciplineCounter++;

    });

    $("#addParticipant").click(function () {

        let clubname            = setClubname(counter);
        let disciplineSelect    = disciplineSelectList(disciplinesOption, counter);
        let ageclassSelect      = ageclassSelectList(ageclassesOption);

        $(this).removeAttr("href");
        $('<div id="singleParticipant_' + counter +'">' +
            '<div class="form-row">' +
            '<button type="button" id="remove_' + counter + '" class="remove close btn-sm mb-2" aria-label="Close"><i class="fa fa-trash-o fa-fw"></i><span aria-hidden="true"></span></button>' +
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
            '<div class="form-group col-md-6">' +  ageclassSelect + '</div> ' +
            '<div class="form-group  col-md-6">' +
            '<input class="form-control" name="jahrgang[]" placeholder="Jahrgang*" type="text" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-row" id="disciplinegroup' + counter + '">' +
            '<div class="form-group col-md-5" >' +  disciplineSelect +'</div>' +
            '<div class="form-group col-md-6" id="besttimeGroup' + counter + '"">' +
            '<input class="form-control" name="bestzeit[' + counter + '][]" placeholder="Bestleistung" type="text">' +
            '</div>' +
            '<div class="form-group col-md-1">'+
                '<button id="addDiscipline_' + counter + '" name="addDiscipline" class="btn-lg btn-outline-success addDiscipline" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>'+
            '</div>' +
            '</div> ' +

            '<div class="form-group">' +
            '<div class="input-group">' +
            '<input class="form-control" name="clubname[]" value= "' + clubname + '" placeholder="Verein" type="text">' +
            '</div> ' +
            '</div>' +
            '<hr>').appendTo("#participantGroup");
        counter++;
    });
});
