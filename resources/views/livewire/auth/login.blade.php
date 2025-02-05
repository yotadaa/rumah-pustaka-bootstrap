<div class="d-lg-flex half">
    <div class="order-1 bg order-md-2" style="background-image: url('{{ asset('componen/login/images/bg_1.jpg') }}');">
    </div>
    <div class="order-2 contents order-md-1">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <figure class="">
                        <img src="{{ asset('logo.png') }}" class="mb-2 w-100" />
                    </figure>
                    <h3>Login ke <strong>Perpustakaan Universitas Jambi</strong></h3>
                    <p class="mb-4">Silahkan isikan informasi akun anda di bawah.</p>
                    <form wire:submit.prevent="submit" method="post">
                        <div class="form-group first">
                            <label for="username">Email atau Username</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="your-email@gmail.com" id="username" name="email" wire:model="email" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 form-group last">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Your Password" id="password" name="password" wire:model="password" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 d-flex align-items-center">
                            <label class="mb-0 control control--checkbox"><span class="caption">Remember me</span>
                                <input type="checkbox" checked="checked" />
                                <div class="control__indicator"></div>
                            </label>
                            <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                        </div>

                        <input type="submit" value="Log In" class="btn btn-block btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
