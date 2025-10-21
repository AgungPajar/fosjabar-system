@extends('administrator.auth.layouts.main', [
    'label' => 'Sign In',
    'subtitle' => 'Administrator Gnc'
])

@section('content')
@include('administrator.components.alert-session')
<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('admin.login.perform') }}" method="POST">
    @csrf
    <div class="fv-row mb-10">
        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
        <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
    </div>
    <div class="fv-row mb-10">
        <label class="form-label fw-bolder text-dark fs-6 mb-2">Password</label>
        <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
        <div class="text-end mt-2">
            <a href="{{ route('ForgetPasswordGet') }}" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
            <span class="indicator-label">Continue</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
</form>
@endsection
@push('scripts')
    <script src="{{asset('assets/scripts/sign-in/validate.js')}}"></script>
@endpush
