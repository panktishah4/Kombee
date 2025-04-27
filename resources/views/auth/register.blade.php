@extends('layouts.app')
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />    
    <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @endpush
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-secondary text-white fs-4">{{ __('Register') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data" id="register_form">
                                @csrf
                                <div class="row g-3">
                                    {{-- First Name --}}
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" placeholder="Enter first name" class="form-control" required pattern="[A-Za-z0-9]+" title="Alpha-numeric only">
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" placeholder="Enter last name" class="form-control" required pattern="[A-Za-z0-9]+" title="Alpha-numeric only">
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="Enter email address" class="form-control" required>
                                    </div>

                                    {{-- Contact Number --}}
                                    <div class="col-md-6">
                                        <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" name="contact_number" placeholder="Enter contact no" class="form-control" required pattern="[0-9]{10}" maxlength="10" title="10-digit contact number">
                                    </div>

                                    {{-- Postcode --}}
                                    <div class="col-md-6">
                                        <label for="postcode" class="form-label">Postcode <span class="text-danger">*</span></label>
                                        <input type="text" name="postcode" placeholder="Enter postcode" class="form-control" required pattern="[0-9]+" title="Numeric only">
                                    </div>

                                    {{-- Gender --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Gender <span class="text-danger">*</span></label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender_id" value="1" id="male" required>
                                            <label for="male" class="form-check-label">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender_id" value="2" id="female">
                                            <label for="female" class="form-check-label">Female</label>
                                        </div>
                                    </div>

                                    {{-- Hobbies --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Hobbies</label><br>
                                        @forelse ($hobbies as $hobby)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{$hobby->id}}" id="{{$hobby->id}}">
                                            <label for="{{$hobby->id}}" class="form-check-label">{{$hobby->name}}</label>
                                        </div>
                                        @empty
                                            <span>No records found</span>    
                                        @endforelse
                                    </div>

                                    {{-- Role Dropdown --}}
                                    <div class="col-md-6">
                                        <label for="roles" class="form-label">Select Roles <span class="text-danger">*</span></label>
                                        <select class="form-control roles-select" name="roles[]" multiple="multiple" required>
                                            {{-- Example roles for demo --}}
                                            <option value="1">Admin</option>
                                            <option value="2">Editor</option>
                                            <option value="3">User</option>
                                            <option value="4">Manager</option>
                                        </select>
                                    </div>

                                    {{-- State Dropdown --}}
                                    <div class="col-md-6">
                                        <label for="state" class="form-label">Select State <span class="text-danger">*</span></label>
                                        <select class="form-control state-select" id="state_id" name="state_id" required>
                                            @forelse ($states as $state )
                                                <option value="{{ $state->id}}">{{ $state->name}}</option>                                                
                                            @empty
                                                <option value="">No records found.</option>
                                            @endforelse
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    {{-- City Dropdown --}}
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">Select City <span class="text-danger">*</span></label>
                                        <select class="form-control city-select" id="city_id" name="city_id" required>
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    {{-- Files Upload --}}
                                    <div class="col-md-12">
                                        <label for="file_path" class="form-label">Upload Files <small class="text-muted">(You can upload multiple files)</small></label>
                                        <input type="file" class="form-control" name="file_path[]" multiple>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Enter password" name="password" class="form-control" required>
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="col-md-6">
                                        <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" placeholder="Enter confirm password" name="confirm_password" class="form-control" required>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" id="btnsubmit" class="btn btn-success px-5 py-2">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')


@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    let getCitiesURL = "{{ route('getCities', ['state_id' => '__STATE__']) }}"; 
</script>
<script src="{{asset('scripts/register.js')}}"></script>
@endpush
@endsection
