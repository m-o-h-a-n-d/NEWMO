@extends('layouts.backend.app')

@section('admin_title')
    Settings
@endsection
@push('css')
    {{-- Dropify --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush


@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center w-100" style="font-size: 40px">Settings</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-11">
                <form action="{{ route('admin.settings.update', $Settings->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- General Info --}}
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">General Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                {{-- Site Name --}}
                                <div class="col-md-6">
                                    <label for="side_name">Site Name</label>
                                    <input type="text" name="side_name" class="form-control"
                                        value="{{ $Settings->side_name ?? '' }}" placeholder="Enter Site Name">
                                    @error('side_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ $Settings->phone ?? '' }}" placeholder="Enter Phone">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- Street --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="street">Street</label>
                                    <input type="text" name="street" class="form-control"
                                        value="{{ $Settings->street ?? '' }}" placeholder="Enter Street">

                                    @error('street')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- City --}}
                                <div class="col-md-4">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ $Settings->city ?? '' }}" placeholder="Enter City">
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- country --}}
                                <div class="col-md-4">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control"
                                        value="{{ $Settings->country ?? '' }}" placeholder="Enter Country">
                                    @error('country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ $Settings->email ?? '' }}" placeholder="Enter Email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label for="whatsapp">WhatsApp</label>
                                    <input type="text" name="whatsapp" class="form-control"
                                        value="{{ $Settings->whatsapp ?? '' }}" placeholder="Enter WhatsApp" readonly>
                                    @error('whatsapp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- Social Media --}}
                    <div class="card shadow mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Social Media</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                {{-- Facebook --}}
                                <div class="col-md-6">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" name="facebook" class="form-control"
                                        value="{{ $Settings->facebook ?? '' }}" placeholder="Facebook URL">
                                    @error('facebook')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- Instagram --}}
                                <div class="col-md-6">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" name="instagram" class="form-control"
                                        value="{{ $Settings->instagram ?? '' }}" placeholder="Instagram URL">
                                    @error('instagram')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- LinkedIn --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="linkedin">LinkedIn</label>
                                    <input type="text" name="linkedin" class="form-control"
                                        value="{{ $Settings->linkedin ?? '' }}" placeholder="LinkedIn URL">
                                    @error('linkedin')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- youtube --}}
                                <div class="col-md-6">
                                    <label for="youtube">YouTube</label>
                                    <input type="text" name="youtube" class="form-control"
                                        value="{{ $Settings->youtube ?? '' }}" placeholder="YouTube URL">
                                    @error('youtube')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- Twitter --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" name="twitter" class="form-control"
                                        value="{{ $Settings->twitter ?? '' }}" placeholder="Twitter URL">
                                    @error('twitter')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Drop & Drag Logo + Favicon --}}
                    <div class="card shadow mb-4">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Upload Logo & Favicon</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center align-items-center text-center">

                                {{-- Logo --}}
                                <div class="col-md-6 mb-3">

                                    <label for="Logo Input  ">
                                        Logo:
                                    </label>
                                    <input type="file" data-default-file="{{ asset($Settings->logo) }}"
                                        name="logo" class="dropify" data-show-errors="true" />
                                    @error('logo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                                {{-- Favicon --}}
                                <div class="col-md-6 mb-3">
                                    <label for="faviconInput">
                                        Favicon:
                                    </label>
                                    <input type="file" data-default-file="{{ asset($Settings->favicon) }}"
                                        class="dropify" name="favicon">
                                    @error('favicon')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="text-center mb-5">
                        <button type="submit" class="btn btn-primary px-5">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <!-- bropify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    'default': 'Drop a file here',
                    'replace': 'Click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong happended.'
                }
            });
        });
    </script>
@endpush
