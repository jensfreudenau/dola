Dropzone.options.droppy = {
    maxFilesize: 10, // Mb+
    autoProcessQueue: false,
    processData: false,
    contentType: false,

    acceptedFiles: '.csv, .CSV',
    accept: function(file, done) {
        let reader = new FileReader();
        reader.onload = function(event) {
            let contents = event.target.result;
            processData(contents);
         $(".dz-progress").css("display", "none");
            $(".dz-error-mark").css("display", "none");


        };
        reader.onerror = function(event) {
            alert("File could not be read! Code " + event.target.error.code);
            $(".dz-error-mark svg").css("background", "red");
            $(".dz-success-mark").css("display", "none");
        };
        reader.readAsText(file);
        done();
        return file.previewElement.classList.add("dz-success");
    }
};

function processData(csv) {
    parseTableData(csv);
    return true;
}

function parseTableData(result) {

    let parsedData = Papa.parse(result, {
        delimiter: ';',
        skipEmptyLines: 'greedy'
    });
    let table = formDataTable(parsedData);

}

function formDataTable(response) {

    let allData = response.data;
    allData.shift();
    $errorOccures = false;
    $(allData).each(function(j) {
        let ageclass = ageclasses[allData[j][3]];
        let errorAgeclass = '';
        let errorDiscipline = '';
        let duration = allData[j][5];
      
        if (typeof ageclass == 'undefined') {
            errorAgeclass = 'is-invalid';
            if ($errorOccures === false) {
                $errorOccures = true;
            }
        }
        let discipline = disciplines[allData[j][4]];
        if (personalBestFormat[allData[j][4]] == 'ZEIT') {
            allData[j][5] = allData[j][5].replace(',', '.');
            let durationUnformat = moment.duration(allData[j][5]);
            duration = moment(durationUnformat._data).format("H:m:s,SS");
        }
        if (typeof discipline == 'undefined') {
            errorDiscipline = 'is-invalid';
            if ($errorOccures === false) {
                $errorOccures = true;
            }
        }
        $('<div class="form-row">\n' +
            '<div class="form-group col-md-2"><input class="form-control" value="' + allData[j][0] + ' " name="vorname[' + j + ']" type="text"></div>' +
            '<div class="form-group col-md-2"><input class="form-control" value="' + allData[j][1] + '" name="nachname[' + j + ']" type="text"></div>' +
            '<div class="form-group col-md-2"><input class="form-control" value="' + allData[j][2] + '" name="clubname[' + j + ']" type="text"></div>' +
            '<div class="form-group col-md-1"><input class="form-control ' + errorAgeclass + ' "  value="' + allData[j][3] + '" name="ageclass[' + j + ']" type="text"></div>' +
            '<div class="form-group col-md-1"><input class="form-control" value="' + allData[j][6] + '" name="jahrgang[' + j + ']" type="text"></div>' +
            '<div class="form-group col-md-2"><input class="form-control ' + errorDiscipline + ' " value="' + allData[j][4] + '" name="discipline[' + j + ']" type="text"></div>' +
            '<div class="form-group col-md-2"><input class="form-control" value="' + duration + '" name="best_time[' + j + ']" type="text"></div></div>'
        ).appendTo("#mycsvdata");
    });
    if ($errorOccures) {
        $('<div id="formerror" class="form-row red float-right form-text "><div class="form-group col-md-12"><h5>Es ist ein Fehler passiert</h5></div></div><br><br>').appendTo("#mycsvdata");
    }
}
$(document).on('mouseout', '#mycsvdata', function() {
    $('input[name^="ageclass"]').each(function(key, value) {
        let ageclass = ageclasses[value.value];
        if (typeof ageclass == 'undefined') {
            jQuery(value).addClass('is-invalid');

        } else {
            jQuery(value).removeClass('is-invalid');
        }
    });
    $('input[name^="discipline"]').each(function(key, value) {
        let discipline = disciplines[value.value];
        if (typeof discipline == 'undefined') {
            jQuery(value).addClass('is-invalid');

        } else {
            jQuery(value).removeClass('is-invalid');
        }
    });
});