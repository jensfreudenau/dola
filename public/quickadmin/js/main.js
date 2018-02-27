$(document).ready(function () {
    $('.datepicker').datepicker({
        autoclose: true,
        format: "dd.mm.yyyy"
    });
    $('table[data-form="deleteForm"]').on('click', '.form-delete', function (e) {
        e.preventDefault();
        var $form = $(this);
        $('#confirm').modal({backdrop: 'static', keyboard: false})
            .on('click', '#delete-btn', function () {
                $form.submit();
            });
    });

    var handleCheckboxes = function (html, rowIndex, colIndex, cellNode) {
        var $cellNode = $(cellNode);
        var $check = $cellNode.find(':checked');
        return ($check.length) ? ($check.val() == 1 ? 'Yes' : 'No') : $cellNode.text();
    };

    var activeSub = $(document).find('.active-sub');
    if (activeSub.length > 0) {
        activeSub.parent().show();
        activeSub.parent().parent().find('.arrow').addClass('open');
        activeSub.parent().parent().addClass('open');
    }
    window.dtDefaultOptions = {
        retrieve: true,
        dom: 'lBfrtip<"actions">',
        columnDefs: [],
        "iDisplayLength": 400,
        "aLengthMenu": [[250, 500, 750, -1], [25, 50, 75, "All"]],
        "aaSorting": [],
        buttons: []
    };
    $('.datatable').each(function () {
        if ($(this).hasClass('dt-select')) {
            window.dtDefaultOptions.select = {
                style: 'multi',
                selector: 'td:first-child'
            };

            window.dtDefaultOptions.columnDefs.push({
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            });
        }
        $(this).dataTable(window.dtDefaultOptions);
    });
    if (typeof window.route_mass_crud_entries_destroy != 'undefined') {

        $('.datatable, .ajaxTable').siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
    }

    $(document).on('click', '.js-delete-selected', function () {
        if (confirm('Are you sure')) {
            var ids = [];

            $(this).closest('.actions').siblings('.datatable, .ajaxTable').find('tbody tr.selected').each(function () {
                console.log("selected", $(this).data('entry-id'));
                ids.push($(this).data('entry-id'));
            });

            $.ajax({
                method: 'POST',
                url: $(this).attr('href'),
                data: {
                    _token: _token,
                    ids: ids
                }
            }).done(function () {
                location.reload();
            });
        }

        return false;
    });

    $(document).on('click', '#select-all', function () {
        var selected = $(this).is(':checked');

        $(this).closest('table.datatable, table.ajaxTable').find('td:first-child').each(function () {
            if (selected != $(this).closest('tr').hasClass('selected')) {
                $(this).click();
            }
        });
    });

    $('.mass').click(function () {
        if ($(this).is(":checked")) {
            $('.single').each(function () {
                if ($(this).is(":checked") == false) {
                    $(this).click();
                }
            });
        } else {
            $('.single').each(function () {
                if ($(this).is(":checked") == true) {
                    $(this).click();
                }
            });
        }
    });

    $('.page-sidebar').on('click', 'li > a', function (e) {

        if ($('body').hasClass('page-sidebar-closed') && $(this).parent('li').parent('.page-sidebar-menu').size() === 1) {
            return;
        }

        var hasSubMenu = $(this).next().hasClass('sub-menu');

        if ($(this).next().hasClass('sub-menu always-open')) {
            return;
        }

        var parent = $(this).parent().parent();
        var the = $(this);
        var menu = $('.page-sidebar-menu');
        var sub = $(this).next();

        var autoScroll = menu.data("auto-scroll");
        var slideSpeed = parseInt(menu.data("slide-speed"));
        var keepExpand = menu.data("keep-expanded");

        if (keepExpand !== true) {
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
            parent.children('li.open').removeClass('open');
        }

        var slideOffeset = -200;

        if (sub.is(":visible")) {
            $('.arrow', $(this)).removeClass("open");
            $(this).parent().removeClass("open");
            sub.slideUp(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        } else if (hasSubMenu) {
            $('.arrow', $(this)).addClass("open");
            $(this).parent().addClass("open");
            sub.slideDown(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        }
        if (hasSubMenu == true || $(this).attr('href') == '#') {
            e.preventDefault();
        }
    });

    $('.select2').select2({
        width: '80%'
    });

    $('.datepicker').datepicker({
        autoclose: true,
        format: "dd.mm.yyyy",
        language: 'de-DE'
    });
    tinyMCE.init({
        mode: "textareas",
        themes: "modern",
        skin: "custom",
        removeformat: [
            {selector: 'b,strong,em,i,font,u,strike', remove : 'all', split : true, expand : false, block_expand: true, deep : true},
            {selector: 'span', attributes : ['style', 'class'], remove : 'empty', split : true, expand : false, deep : true},
            {selector: '*', attributes : ['style', 'class'], split : false, expand : false, deep : true}
        ],
        content_css: '/adminlte/css/tinymce_custom.css',
        plugins: [
            "advlist autolink lists link image charmap anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu"
        ],
        relative_urls: false,
        convert_urls: false,
        forced_root_block: "",
        remove_script_host: false,
//            document_base_url: "http://",
        toolbar: "undo redo paste | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media code table",
    });

    Dropzone.options.csvuploader = {
        maxFilesize: 10, // Mb+
        autoProcessQueue: false,
        accept: function (file, done) {
            var reader = new FileReader();
            reader.addEventListener("loadend", function (event) {
                event.preventDefault();
                processData(event.target.result);

            });
            reader.readAsText(file);
            done();
        }
    };
    Dropzone.options.fileuploader = {
        maxFilesize: 10, // Mb+
        autoProcessQueue: false,
        accept: function (file, done) {
            done();
        },
        sending: function (file, xhr, formData) {
            console.log('sending');
        },
        success: function (file, response) {
            console.log('success');
        },
        error: function(file, response) {
            console.log('acceerrorpte');
            if($.type(response) === "string")
                var message = response; //dropzone sends it's own error messages in string
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
            }
            console.log(message);
            return _results;
        },
    };

    Dropzone.options.participators = {
        maxFilesize: 10, // Mb
        params:{"type":"participators"},
        paramName: "uploader",
        sending: function (file, xhr, formData) {
        },
        success: function (file, response) {
        },
        error: function (file, error) {
            console.error(error);
        },
        accept: function (file, done) {
            location.reload();
            done();
        }
    };

    Dropzone.options.resultsets = {
        maxFilesize: 10, // Mb
        params:{"type":"resultsets"},
        paramName: "uploader",
        sending: function (file, xhr, formData) {
        },
        success: function (file, response) {
        },
        error: function (file, error) {
            console.error(error);
        },
        accept: function (file, done) {
            location.reload();
            done();
        }
    };

    Dropzone.options.additionals = {
        maxFilesize: 10, // Mb
        params:{"type":"additionals"},
        paramName: "uploader",
        sending: function (file, xhr, formData) {
        },
        success: function (file, response) {
        },
        error: function (file, error) {
            console.error(error);
        },
        accept: function (file, done) {
            location.reload();
            done();
        }
    };

    function parsedData(result) {
        let parsedData = Papa.parse(result, {
            delimiter: ';'
        });
        let $table = formDataTable(parsedData);
        $(tinymce.get('competition-timetable_1').getBody()).html($table);
    }

    function formDataTable(response) {
        var $th = '';
        var firstColumn = response.data[0];
        response.data.shift();
        var $table = $('<table>');
        var $thead = $('<thead>').appendTo($table);
        $tr = $('<tr>').appendTo($thead);
        $(firstColumn).each(function (i) {
            $th = $('<th>', {'html': firstColumn[i]}).appendTo($tr);
        });

        var allData = response.data;
        var $tbody = $('<tbody>').appendTo($table);

        $(allData).each(function (j) {
            $tr = $('<tr>').appendTo($tbody);
            $(allData[j]).each(function (k) {
                var $td = $('<td>', {'html': allData[j][k]}).appendTo($tr);
            });
        });
        return $table;
    }

    function processData(csv) {
        var allTextLines = csv.split(/\r\n|\n/);
        var lines = [];
        var table = '';
        // allTextLines.shift();
        let flag = -1;
        for (var i = 0; i < allTextLines.length; i++) {
            var data = allTextLines[i].split(';');
            var tarr = [];
            var anfang = allTextLines[i].indexOf("Zeit");
            var ende = allTextLines[i].indexOf("Elektr");
            if (anfang === 0) {
                flag = 1;
                setClasses(allTextLines[i]);
            }
            if (ende == 0 && flag == 1) {
                flag = -1;
            }
            if (flag === 1) {
                table += allTextLines[i] + '\r\n';
            }
            for (var j = 0; j < data.length; j++) {
                if (data[j].search("uszei") > 0) {
                    setAward(data[j]);
                }
                if (data[j].search("eldeschl") > 0) {
                    setMeldeschluss(data[j]);
                }
                if (data[j].includes("eldung")) {
                    setMeldungReceiver(data);
                }

                if (data[j].includes(' den ') || data[j].includes(' am ') ) {
                    let headerline = data[j].split(',');
                    setHeader(headerline[0]);
                    setRadioSeason(headerline[0]);
                    setStartDate(headerline[1]);
                }
                tarr.push(data[j]);
            }
            lines.push(tarr);
        }
        parsedData(table);

        return true;
    }
});

function setRadioSeason(headerline) {
    let season = headerline.indexOf("Halle");
    if (season > 0) {
        $('input:radio[name="season"][value=halle]').click();
    }
    season = headerline.indexOf("Stadion");
    if (season > 0) {
        $('input:radio[name="season"][value=stadion]').click();
    }
}

function setHeader(headerline) {
    $('#competition-headline').val(headerline);
}

function setStartDate(data) {
    let startStr = data.toString();
    startStr = startStr.replace(/am/g, "");
    startStr = startStr.replace(/den/g, "");
    console.log(startStr);
    if (!moment($.trim(startStr), ['DD. MMMM YYYY', 'DD.MMMM YYYY', 'DD.MM.YYYY'], true).isValid()) {
        return false;
    }
    var germanDate = moment(startStr, ['DD. MMMM YYYY', 'DD.MMMM YYYY', 'DD.MM.YYYY']);
    $('#competition-start_date').val(germanDate.format('DD.MM.YYYY'));
}

function setMeldeschluss(data) {
    let meldeschluss = data.split(':');
    let meldeschlussStr = meldeschluss[1].replace(/\s/g, '');
    var germanDate = moment(meldeschlussStr, ['DD.MMMM YYYY', 'DD.MM.YYYY']);
    $('#competition-submit_date').val(germanDate.format('DD.MM.YYYY'));
}

function setClasses(allTextLines) {
    let classes = allTextLines.split(';');
    let classStr = classes.join();
    classStr = classStr.replace(/Zeit/g, "");
    classStr = classStr.replace(/[*]/g, "");
    classStr = classStr.replace(/[,]/g, ", ");
    if (classStr.substring(0, 1) == ',') {
        classStr = classStr.substring(1);
    }
    $('#competition-classes').val($.trim(classStr));
}

function setMeldungReceiver(data) {
    let meldungName = data[1].split(',');
    let name = $.trim(meldungName[0]);

    $("#addresses_id option").each(function (a, b) {
        if ($(this).html() == name) $(this).attr("selected", "selected");
        $(this).change();
    });
}

function setAward(data) {
    let ausszeichnung = data.split(':');
    $('#competition-award').val($.trim(ausszeichnung[1]));
}


function processAjaxTables() {
    $('.ajaxTable').each(function () {
        window.dtDefaultOptions.processing = true;
        window.dtDefaultOptions.serverSide = true;
        if ($(this).hasClass('dt-select')) {
            window.dtDefaultOptions.select = {
                style: 'multi',
                selector: 'td:first-child'
            };

            window.dtDefaultOptions.columnDefs.push({
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            });
        }
        $(this).DataTable(window.dtDefaultOptions);
        if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
            $(this).siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
        }
    });

}
