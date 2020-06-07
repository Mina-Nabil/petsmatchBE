@extends('layouts.app')

@section('content')



<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $formTitle }}</h4>
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data">
                    @csrf
                    <input type=hidden name=id value="{{(isset($user)) ? $user->id : ''}}">

                    <div class="form-group">
                        <label>Username*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="User Name" name=name value="{{ (isset($user)) ? $user->USER_NAME : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Password*</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name=pass {{(isset($user) ? "" : "required")}}>
                        </div>
                        <small class="text-danger">{{$errors->first('pass')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Mobile Number*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Mobile Number" name=mob value="{{ (isset($user)) ? $user->USER_MOBN : old('mob') }}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('mob')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Full Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" name=fullName value="{{ (isset($user)) ? $user->USER_FLNM : old('fullName')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('fullName')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Birth Date</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" name=bdate value="{{ (isset($user)) ? $user->USER_BRDT->format("Y-m-d") : old('bdate')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('bdate')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Email*</label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name=mail placeholder="User email" value="{{ (isset($user)) ? $user->USER_MAIL : old('mail')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('mail')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Type*</label>
                        <div class="input-group mb-3">
                            <select name=type class="select2" onchange='toggleTrainer()' id=typeSelect form-control custom-select" style="width: 100%; height:36px;" required>
                                <option value="" disabled selected>Select User Type</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}" @if(isset($user) && $type->id == $user->USER_USTP_ID)
                                    selected
                                    @elseif($type->id == old('type'))
                                    selected
                                    @endif
                                    >{{$type->USTP_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger">{{$errors->first('type')}}</small>
                    </div>

                    <div id=trainerDiv style="display: 
                    @if((isset($user) && $user->USER_USTP_ID == 2) || old('type')==2)
                    block
                    @else
                    none
                    @endif
                    ">
                        <div class="form-group">
                            <label>Trainer Years of Experience</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name=trainerExp placeholder="Enter current years of experience"
                                    value="{{ (isset($user->trainer)) ? $user->trainer->TRNR_XPYR : old('trainerExp')}}" >
                            </div>
                            <small class="text-danger">{{$errors->first('trainerExp')}}</small>
                        </div>
                        <div class="form-group">
                            <label>Trainer's Organization</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name=trainerOrgn placeholder="Enter current organization name"
                                    value="{{ (isset($user->trainer)) ? $user->trainer->TRNR_ORGN : old('trainerOrgn')}}" >
                            </div>
                            <small class="text-danger">{{$errors->first('trainerOrgn')}}</small>
                        </div>
                        <div class="form-group">
                            <label>Trainer's "About You"</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="trainerAbout">{{(isset($user->trainer)) ? $user->trainer->TRNR_ABUT : old('trainerAbout')}}</textarea>
                            </div>
                            <small class="text-danger">{{$errors->first('trainerAbout')}}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>City*</label>
                        <div class="input-group mb-3">
                            <select name=city class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                <option value="" disabled selected>Pick From Available Cities</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" @if(isset($user) && $city->id == $user->USER_CITY_ID)
                                    selected
                                    @elseif($city->id == old('city'))
                                    selected
                                    @endif
                                    >{{$city->CITY_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger">{{$errors->first('city')}}</small>
                    </div>

                    <div class="form-group">
                        <label>User Image</label>
                        <div class="input-group mb-3">
                            <button type=button id="upload_widget" class="cloudinary-button">Upload files</button>
                            <input type=hidden id=uploaded name=uploadedImage value="{{old('uploadedImage')}}" />
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    @if($isCancel)
                    <a href="{{url($homeURL) }}" class="btn btn-dark">Cancel</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section("js_content")
<script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>

<script>
    function toggleTrainer(){
        var selectaya = document.getElementById("typeSelect");
        var trainerDiv = document.getElementById("trainerDiv");
        if(selectaya.value == "2") // Trainer
        {
            trainerDiv.style.display = "block";
        } else {
            // other users
            trainerDiv.style.display = "none";
        }
    }
    
    var myWidget = cloudinary.createUploadWidget({
    cloudName: 'msquareapps', 
    folder: "petmatch/users",
    uploadPreset: 'petmatch'}, (error, result) => { 
      if (!error && result && result.event === "success") { 
        document.getElementById('uploaded').value = result.info.url;
      }
    }
  )
  
  document.getElementById("upload_widget").addEventListener("click", function(){
      myWidget.open();
    }, false);
</script>
@endsection