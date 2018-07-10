@component('admin.profiles.activities.activity')
    @slot('heading')
        @include('admin.profiles.activities.heading')
    @endslot

    @slot('body')
        <a href="../{{ $activity->component }}s/{{ $activity->subject->id  }}">{{ $activity->subject->header  }}</a>
    @endslot
@endcomponent