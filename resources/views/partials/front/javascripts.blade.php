<script src="{{ url('/js/jquery-3.1.1.slim.min.js') }}"></script>
<script src="{{ url('/js/tether.min.js') }}"></script>
<script src="{{ url('/js/bootstrap.min.js') }}"></script>
<script>
    window._token = '{{ csrf_token() }}';
</script>

@yield('javascript')