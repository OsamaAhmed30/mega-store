<x-front-layout title="Two Factor Authentication">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- Start Breadcrumbs -->
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Two Factor Authentication</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li>2FA</li>
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


                    <form action="{{ route('two-factor.enable') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authentication</h3>
                                <p>You can Enable/Disable 2FA.</p>
                            </div>
                            @if (session('status') == 'two-factor-authentication-confirmed')
                                <div class="mb-4 font-medium text-sm">
                                    Two factor authentication confirmed and enabled successfully.
                                </div>
                            @endif

                            @csrf
                            <div class="button">
                                @if (!$user->two_factor_secret)
                                    <button class="btn" type="submit">Enable</button>
                                @else
                                    <div class="pb-5">
                                        {!! $user->twoFactorQrCodeSvg() !!}
                                    </div>
                                    <div class="pb-5">
                                        <h3>Revovery Codes</h3>
                                        <ul>
                                            @foreach ($user->recoveryCodes() as $code)
                                            <li>{{$code}}</li>
                                            @endforeach
                                        </ul>
                                        
                                        
                                    </div>

                                    @method('delete')
                                    <button class="btn" type="submit">Disable</button>
                                @endif
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
</x-front-layout>
