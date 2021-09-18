@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans('global.my_profile') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.updateProfile") }}">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="profile">{{ trans('cruds.user.fields.profile') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('profile') ? 'is-invalid' : '' }}" id="profile-dropzone">
                        </div>
                        @if($errors->has('profile'))
                            <span class="text-danger">{{ $errors->first('profile') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.profile_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans('global.change_password') }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.update") }}">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{ trans('global.delete_account') }}
            </div>

            <div class="card-body">
                <form id="frmDelete">
                    @csrf
                    <input type="text" name="email" value="{{ auth()->user()->email }}" hidden>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit" id="btnSubmmit">
                            {{ trans('global.delete') }}
                        </button>
                        <button class="btn btn-danger" type="button" disabled id="btnLoading" hidden>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
@parent
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Dropzone.options.profileDropzone = {
    url: '{{ route('profile.password.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="profile"]').remove()
      $('form').append('<input type="hidden" name="profile" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="profile"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
    @if(auth()->user() && auth()->user()->profile)
        var file = {!! json_encode(auth()->user()->profile) !!}
            this.options.addedfile.call(this, file)
        this.options.thumbnail.call(this, file, file.preview)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="profile" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
    @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

        return _results
    }
}
</script>
<script>
    $('#frmDelete').submit(function(e){
        e.preventDefault();

        $('#btnLoading').removeAttr('hidden');
        $('#btnSubmmit').attr('hidden', 'true');

        let _token = $('input[name="_token"]').val();
        let input_email = $('input[name="email"]').val();

        (async () => {
            const { value: email } = await Swal.fire({
                title: 'Are you sure you want to delete?',
                input: 'email',
                inputLabel: 'You will never recover it back.',
                inputPlaceholder: 'Enter email address'
            })
            if (email != input_email) {
                swal.fire({
                    title: 'Opss!',
                    text: 'Incorrect Email.',
                    icon: 'error'
                });
                $('#btnLoading').attr('hidden', 'true');
                $('#btnSubmmit').removeAttr('hidden');
            }
            if (email != '') {
                swal.fire({
                    title: 'XD &#128538;',
                    text: 'Your Account are safe.',
                    icon: 'success'
                });
                $('#btnLoading').attr('hidden', 'true');
                $('#btnSubmmit').removeAttr('hidden');
            }
            if (email == input_email) {
                $.ajax({
                    type: "POST",
                    url: "{{ route("profile.password.destroyProfile") }}",
                    data: {
                        _token: _token
                    },
                    success: function (response) {
                        if(response){
                            swal.fire({
                                title: 'Byeee!',
                                text: 'You are logging out.',
                                icon: 'error'
                            })
                            setTimeout((e) => {
                                location.reload()
                            },1500);
                        }
                    }
                });
            }
        })()
    })
</script>

@endsection