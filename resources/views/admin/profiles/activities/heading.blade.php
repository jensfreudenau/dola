{{ $user->name }} {{ $activity->type }} a <strong>{{ $activity->component }}</strong> @ {{ \Carbon\Carbon::parse($activity->created_at)->formatLocalized('%A %d.%B.%Y %H:%I:%S') }}
