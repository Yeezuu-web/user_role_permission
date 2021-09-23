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
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/sweetalert2/sweetalert2.min.css')}}">
    
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
                        <form id="frmRequestBoost">
                            @csrf
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <h3>Client Info</h3> <br>
                                    <div class="form-group">
                                        <label for="requester">Requester Name<small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="requester" id="requester" placeholder="Requester Name"/>
                                        <span class="text-danger" id="requester-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="company">Company Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="company" id="company" placeholder="Company Name"/>
                                        <span class="text-danger" id="company-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="group">Group <small class="text-danger">*</small></label>
                                        <select name="group" id="group" class="form-control">
                                            <option class="hidden" selected disabled>Where are from?
                                            </option>
                                            <option value="internal">Internal</option>
                                            <option value="client">Client</option>
                                        </select>
                                        <span class="text-danger" id="group-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="budget">Budget <small class="text-danger">*</small></label>
                                        <input type="number" class="form-control" name="budget" id="budget" placeholder="Boost Budget"/>
                                        <span class="text-danger" id="budget-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3>Boost Info</h3> <br>
                                    <div class="form-group">
                                        <label for="pnp">Product / Program Name <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="pnp" id="pnp" placeholder="Product / Program name"/>
                                        <span class="text-danger" id="pnp-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Boost URL<small class="text-danger">*</small></label>
                                        <input type="text" name="url" class="form-control" id="url" placeholder="Your Post URL"/>
                                        <span class="text-danger" id="url-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Start Boost on <small class="text-danger">*</small></label>
                                        <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Start Boost On"/>
                                        <span class="text-danger" id="start_date-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="detail">More Detail <small class="text-danger">Optional</small></label>
                                        <input type="text" name="detail" id="detail" class="form-control" placeholder="More Detail"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="channel_id">Target Channel<small class="text-danger">*</small></label>
                                        <div class="form-group">
                                                
                                        </div>
                                        <span class="text-danger" id="channel-error"></span>
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
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
</body>

</html>
