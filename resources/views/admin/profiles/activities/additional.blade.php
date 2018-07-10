@component('admin.profiles.activities.activity')
    @slot('heading')
        @include('admin.profiles.activities.heading')
    @endslot

    @slot('body')
        <a href="../competitions/{{ $activity->subject->competition_id  }}">
            Value: {{ $activity->subject->value }} <br>
            Key: {{ $activity->subject->key }}</a>
    @endslot
@endcomponent