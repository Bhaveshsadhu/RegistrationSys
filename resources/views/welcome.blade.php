<!-- resources/views/welcome.blade.php -->

@if (auth()->check())
    <p>Welcome, {{ auth()->user()->name }}!</p>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@else
    <p>You are not logged in.</p>
@endif
