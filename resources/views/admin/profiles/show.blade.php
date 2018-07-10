@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse ($activities as $date => $activity)
                    @foreach ($activity as $component)
                        @if (view()->exists("admin.profiles.activities.{$component->component}"))
                            @include ("admin.profiles.activities.{$component->component}", ['activity' => $component])
                        @endif
                    @endforeach
                @empty
                    <p>There is no activity for this user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection