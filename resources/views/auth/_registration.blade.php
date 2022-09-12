<div class="w3_info" style="{{ $style ?? '' }}">
    <h1>Join Us!</h1>
    <p class="sub-para">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
    <h2>Registration</h2>
    <form action="{{ route('auth.register') }}" method="post">
        @csrf
        <div class="input-group">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
            <input name="name" type="text" placeholder="Name" value="{{ old('name') }}">
            <span class="text-danger">@error('name') {{ $message }} @enderror</span>
        </div>
        <div class="input-group">
            <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
            <input name="email" type="email" placeholder="Email" value="{{ old('email') }}">
            <span class="text-danger">@error('email') {{ $message }} @enderror</span>
        </div>
        <div class="input-group two-group">
            <span><i class="fa fa-key" aria-hidden="true"></i></span>
            <input name="password" type="password" placeholder="Password">
            <span class="text-danger">@error('password') {{ $message }} @enderror</span>
        </div>
        <div class="input-group two-group">
            <span><i class="fa fa-key" aria-hidden="true"></i></span>
            <input name="password_confirmation" type="password" placeholder="Confirm Password">
            <span class="text-danger">@error('password_confirmation') {{ $message }} @enderror</span>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Register</button>
    </form>

    <p class="account">Do you have an account? <a href="{{ route('user.login') }}">Log In</a></p>
</div>
