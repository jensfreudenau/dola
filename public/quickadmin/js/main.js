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


    Dropzone.options.csvuploader = {
        maxFilesize: 10, // Mb+
        autoProcessQueue: false,
        accept: function (file, done) {
            let reader = new FileReader();
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
        error: function (file, response) {
            message = '';
            console.log(response);
            if ($.type(response) === "string")
                message = response; //dropzone sends it's own error messages in string
            else
                message = response.message;
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

        params: {"type": "participators"},
        paramName: "uploader",
        init: function () {
            this.on("success", function (file, response) {
                file.serverId = response;
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    location.reload();
                }
            });
        }
    };

    Dropzone.options.resultsets = {

        params: {"type": "resultsets"},
        paramName: "uploader",
        init: function () {
            this.on("success", function (file, response) {
                file.serverId = response;
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    location.reload();
                }
            });
        }
    };

    Dropzone.options.additionals = {
        params: {"type": "additionals"},
        paramName: "uploader",
        init: function () {
            this.on("success", function (file, response) {
                file.serverId = response;
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    location.reload();
                }
            });
        }
    };

    function formDataTable(response) {
        let th = '';
        let firstColumn = response.data[1];
        response.data.shift();
        let table = $('<table>');
        let thead = $('<thead>').appendTo(table);
        tr = $('<tr>').appendTo(thead);

        $(firstColumn).each(function (i) {
            th = $('<th>', {'html': firstColumn[i]}).appendTo(tr);
        });

        let allData = response.data;
        let tbody = $('<tbody>').appendTo(table);

        $(allData).each(function (j) {
            if (allData[j].length == 1 || allData[j].length == 0) {
                return;
            }
            tr = $('<tr>').appendTo(tbody);
            $(allData[j]).each(function (k) {
                let td = $('<td>', {'html': allData[j][k]}).appendTo(tr);
            });
        });

        return table;
    }

    function processData(csv) {
        let allTextLines = csv.split(/\r\n|\n/);
        let table = csv.substring(csv.lastIndexOf("#start"), csv.lastIndexOf("#ende"));
        for (let i = 0; i < allTextLines.length; i++) {
            let rowCsv = allTextLines[i].replace(/;/g, "");

            if (rowCsv.search("szeichnung") > 0) {
                setAward(rowCsv);
            }
            if (rowCsv.search("ldeschlu") > 0) {
                setMeldeschluss(rowCsv);
            }
            if (rowCsv.includes('den') && rowCsv.includes('am')) {
                let headerline = rowCsv.split('den');
                setHeader(headerline[0]);
                setRadioSeason(rowCsv);
                setStartDate(headerline[1]);
            }
        }
        parseTableData(table);
        return true;
    }

    function parseTableData(result) {
        let parsedData = Papa.parse(result, {
            delimiter: ';'
        });
        $(tinyMCE.get('competition-timetable_1').getBody()).html(formDataTable(parsedData));
    }

    function setRadioSeason(headerline) {
        if (headerline.includes("Halle")) {
            $("#halle").prop("checked", true);
        }
        if (headerline.includes("Stadion")) {
            $("#bahn").prop("checked", true);
        }
    }

    function setHeader(header) {
        let headerline = header.split('am');
        $('#competition-headline').val(headerline[0]);
    }

    function setStartDate(rawStartDate) {
        let startStr = '';
        if (rawStartDate.includes(',')) {
            let rawStartDateArr = [];
            rawStartDateArr = rawStartDate.split(',');
            startStr = rawStartDateArr[0];
        }
        else {
            startStr = rawStartDate;
        }
        startStr = startStr.replace(/am/g, "");
        startStr = startStr.replace(/den/g, "");
        if (!moment($.trim(startStr), ['DD. MMMM YYYY', 'DD.MMMM YYYY', 'DD.MM.YYYY'], true).isValid()) {
            return false;
        }
        let germanDate = moment(startStr, ['DD. MMMM YYYY', 'DD.MMMM YYYY', 'DD.MM.YYYY']);
        $('#competition-start_date').val(germanDate.format('DD.MM.YYYY'));
    }

    function setAward(ausszeichnungStr) {
        let ausszeichnung = ausszeichnungStr.split(':');
        $('#competition-award').val($.trim(ausszeichnung[1]));
    }

    function setMeldeschluss(meldeschlussStr) {
        let meldeschlussArr =[];
        if (meldeschlussStr.includes(':')) {
            meldeschlussArr = meldeschlussStr.split(':');
        }
        else {
            return false;
        }
        let meldeschluss = meldeschlussArr[1].replace(/\s/g, '');
        let germanDate = moment(meldeschluss, ['DD. MMMM YYYY', 'DD.MMMM YYYY', 'DD.MM.YYYY']);
        $('#competition-submit_date').val(germanDate.format('DD.MM.YYYY'));
    }
});


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
tinyMCE.init({
    mode: "textareas",
    themes: "modern",
    skin: "custom",
    removeformat: [
        {selector: 'b,strong,em,i,font,u,strike', remove: 'all', split: true, expand: false, block_expand: true, deep: true},
        {selector: 'span', attributes: ['style', 'class'], remove: 'empty', split: true, expand: false, deep: true},
        {selector: '*', attributes: ['style', 'class'], split: false, expand: false, deep: true}
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