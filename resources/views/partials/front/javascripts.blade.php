<script type="text/javascript" src="{{ url('front/js') }}/jquery-3.2.1.min.js"></script>
{{--<script src="{{ url('quickadmin/js') }}/bootstrap.min.js"></script>--}}
{{--<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>--}}
<script type="text/javascript" src="{{ url('front/js') }}/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{ url('front/js') }}/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ url('quickadmin/js') }}/select2.full.min.js"></script>
<!-- MDB core JavaScript -->

<script src="{{ url('/js') }}/frontend.js"></script>

<script>
    window._token = '{{ csrf_token() }}';
</script>
@yield('javascript')