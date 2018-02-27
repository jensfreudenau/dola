
{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
{{--<script src="{{ url('quickadmin/js') }}/bootstrap.min.js"></script>--}}
{{--<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>--}}
{{--<script type="text/javascript" src="{{ url('front/js') }}/popper.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>--}}
<!-- Bootstrap core JavaScript -->
{{--<script type="text/javascript" src="{{ url('front/js') }}/bootstrap.min.js"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>--}}
{{--<script type="text/javascript" src="{{ url('quickadmin/js') }}/select2.full.min.js"></script>--}}
<!-- MDB core JavaScript -->
{{--<script type="text/javascript" src="{{ url('front/js') }}/jquery-3.2.1.min.js"></script>--}}
{{--<script type="text/javascript" src="{{ url('front/js') }}/frontend.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
{{--<script>window.jQuery || document.write('<script src="{{ url('front/js') }}/jquery-3.2.1.min.js"><\/script>')</script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>
    window._token = '{{ csrf_token() }}';
</script>

<!-- Initialize Bootstrap functionality -->
<script>
    // Initialize tooltip component
    // $(function () {
    //     $('[data-toggle="tooltip"]').tooltip()
    // })
    //
    // // Initialize popover component
    // $(function () {
    //     $('[data-toggle="popover"]').popover()
    // })
</script>
@yield('javascript')