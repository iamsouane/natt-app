@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notifications</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($notifications->isEmpty())
        <p>Aucune notification à afficher.</p>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center 
                    {{ $notification->read_at ? 'bg-light' : '' }}">
                    <div>
                        <strong>{{ $notification->data['message'] ?? 'Pas de message' }}</strong><br>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Marquer comme lue</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection