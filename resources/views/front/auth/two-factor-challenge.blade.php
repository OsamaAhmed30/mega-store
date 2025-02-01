
<x-front-layout title="Login">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
<!-- Start Breadcrumbs -->
<x-slot:breadcrumb>
<div class="breadcrumbs">
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="breadcrumbs-content">
                <h1 class="page-title">Login</h1>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <ul class="breadcrumb-nav">
                <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                <li>Login</li>
            </ul>
        </div>
    </div>
</div>
</div>
</x-slot:breadcrumb>
<!-- End Breadcrumbs -->

<!-- Start Account Login Area -->
<div class="account-login section">
<div class="container">
<div class="row">
    <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
        <form class="card login-form" action="{{ route('two-factor.login') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="title">
                    <h3>2FA</h3>
                </div>
            
                
                @if ($errors->has('code'))
                    <div class="alert alert-danger">
                        {{$errors->first('code')}}
                    </div>
                @endif
                <div class="form-group input-group">
                    <label for="reg-fn">Code</label>
                    <input class="form-control" name="code" type="text" id="reg-code" >
                </div>
                <div class="alt-option">
                    <span>Or</span>
                </div>
                <div class="form-group input-group">
                    <label for="reg-fn">Rcovery Code</label>
                    <input class="form-control" name="recovery_code" type="text" id="reg-recovery-code" >
                </div>
                <div class="button">
                    <button class="btn" type="submit">Submit</button>
                </div>
               
              
            </div>
        </form>
    </div>
</div>
</div>
</div>
<!-- End Account Login Area -->
</x-front-layout>


