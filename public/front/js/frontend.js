$(".competition_select").select2({
    width: 'resolve'
});

/* Load positions into postion <selec> */
$("#competition_id").change(function () {
    window.location.href="/announciators/create/"+$(this).val();
});