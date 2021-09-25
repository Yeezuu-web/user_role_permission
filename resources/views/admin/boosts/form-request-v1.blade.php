<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" 
      type="image/png" 
      href="{{config('app.url')}}/storage/main-img/cbs_digital.png">
    <title>Boost Request</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropzone/dropzone.min.css') }}">
</head>

<body style="background: -webkit-linear-gradient(left, #3931af, #00c6ff);">
    <div class="register" style="padding-top: 30px !important;">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="{{asset('storage/main-img/cbs_digital.png')}}" alt="" />
                <h3>CBS Digital</h3>
                <p>Your Next Digital Exposure</p>
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Boost Request</h3>
                        <form action="{{ route('boosts.store') }}" method="POST" id="my-form">
                            @csrf
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <h3>Client Info</h3> <br>
                                    <div class="form-group">
                                        <label for="requester_name">Requester Name<small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="requester_name" id="requester_name" placeholder="Requester Name"/>
                                        {{-- <label class="text-danger"></label> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">Company Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name"/>
                                        {{-- <label class="text-danger"></label> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="group">Group <small class="text-danger">*</small></label>
                                        <select name="group" id="group" class="form-control">
                                            <option class="hidden" selected disabled>Where are from?
                                            </option>
                                            <option value="internal">Internal</option>
                                            <option value="client">Client</option>
                                        </select>
                                        <label class="text-danger" id="group-error"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="budget">Budget <small class="text-danger">*</small></label>
                                        <input type="number" class="form-control" name="budget" id="budget" placeholder="Boost Budget"/>
                                        <label class="text-danger" id="budget-error"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="reference">Reference <small class="text-danger">Optional</small></label>
                                        <div class="needsclick dropzone {{ $errors->has('reference') ? 'is-invalid' : '' }}" id="reference-dropzone">
                                        </div>
                                        @if($errors->has('reference'))
                                            <span class="text-danger">{{ $errors->first('reference') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3>Boost Info</h3> <br>
                                    <div class="form-group">
                                        <label for="program_name">Product / Program Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="program_name" id="program_name" placeholder="Product / Program name"/>
                                        {{-- <label class="text-danger"></label> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="target_url">Target URL<small class="text-danger">*</small></label>
                                        <input type="text" name="target_url" class="form-control" id="target_url" placeholder="Your Post URL"/>
                                        {{-- <label class="text-danger"></label> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="boost_start">Start Boost on <small class="text-danger">*</small></label>
                                        <input type="date" name="boost_start" class="form-control" id="boost_start" placeholder="Start Boost On"/>
                                        {{-- <label class="text-danger"></label> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="channel_id">Target Channel<small class="text-danger">*</small></label>
                                            <select class="js-example-basic-multiple w-100 select2-hidden-accessible" name="channel_id[]" multiple data-width="100%" aria-hidden="true">
                                                <option value=""​>--- Choose Channel ---</option>
                                                @foreach ($channels as $id => $channel)
                                                    <option value="{{ $id }}"​>{{ $channel }}</option>
                                                @endforeach
                                            </select>
                                        {{-- <label class="text-danger"></label> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="detail">More Detail <small class="text-danger">Optional</small></label>
                                        <input type="text" name="detail" id="detail" class="form-control" placeholder="More Detail"/>
                                    </div>
                                    <button type="submit" class="btnRegister">Request</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/dropzone/dropzone.min.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Boost\StoreBoostRequest', '#my-form'); !!}
    <script>
        Dropzone.options.referenceDropzone = {
        url: '{{ route('boosts.storeMedia') }}',
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
          $('form').find('input[name="reference"]').remove()
          $('form').append('<input type="hidden" name="reference" value="' + response.name + '">')
        },
        removedfile: function (file) {
          file.previewElement.remove()
          if (file.status !== 'error') {
            $('form').find('input[name="reference"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
          }
        },
        init: function () {
        @if(isset($boost) && $boost->reference)
            var file = {!! json_encode($boost->reference) !!}
                this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="reference" value="' + file.file_name + '">')
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
</body>

</html>
