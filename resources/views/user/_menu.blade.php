<div class="form-info">
    <div class="w3_info">
        <h1>Welcome {{ Auth::user()->name }}!</h1>
        <a href="{{ route('home') }}" class="btn btn-primary btn-block" type="button">Home</a>
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-warning btn-block" type="button">Dashboard</a>
        <a href="{{ route('auth.logout') }}" class="btn btn-primary btn-danger btn-block" type="button">Log Out</a>
    </div>
</div>
