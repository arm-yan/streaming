<div class="w3_info" style="{{ $style ?? '' }}">
    <h1>Welcome Back</h1>
    <p class="sub-para">Ant-Media Broadcast Platform</p>
    <h2>Log In</h2>
    <form action="{{ route('auth.login') }}" method="post">
        @csrf
        <div class="input-group">
            <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
            <input name="email" type="email" placeholder="Email" required="">
            @error('email')<div class="error-box"> {{ $message }} </div>@enderror
        </div>
        <div class="input-group two-group">
            <span><i class="fa fa-key" aria-hidden="true"></i></span>
            <input name="password" type="password" placeholder="Password" required="">
            @error('password')<div class="error-box"> {{ $message }} </div>@enderror
        </div>
        <button class="btn btn-primary btn-block" type="submit">Log In</button>
    </form>

    <p class="account">Don't have an account? <a href="{{ route('user.register') }}">Register</a></p>
</div>
