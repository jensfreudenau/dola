@component('admin.profiles.activities.activity')
    @slot('heading')
        @include('admin.profiles.activities.heading')
    @endslot
    @slot('body')
        @isset($activity->subject->id)
            <a href="../{{ $activity->component }}s/{{ $activity->subject->id  }}">{{ $activity->subject->name  }}</a>
        @endisset
    @endslot
@endcomponent