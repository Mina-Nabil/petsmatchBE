@extends('layouts.app')

@section('content')
<div class="row">
    @php
    var_dump($errors);
@endphp
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $formTitle }}</h4>
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data">
                    @csrf
                    <input type=hidden name=id value="{{(isset($shop)) ? $shop->id : ''}}">
                    @if(isset($shop->SHOP_IMGE))
                    <input type=hidden name=oldPath value="{{$shop->SHOP_IMGE}}">
                    @endif
                    <div class="form-group">
                        <label>Shop Account Username*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name=username aria-label="Username" aria-describedby="basic-addon11"
                                value="{{ (isset($shop)) ? $shop->SHOP_USNM : old('username')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Shop Name*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon22"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name=shopName placeholder="Shop Name" value="{{ (isset($shop)) ? $shop->SHOP_NAME : old('shopName')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('fullname')}}</small>
                    </div>
                    <div class="form-group">
                        <label>City*</label>
                        <div class="input-group mb-3">
                            <select name=city class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                <option value="" disabled selected>Pick From Registered Cities</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" @if(isset($shop) && $city->id == $shop->SHOP_CITY_ID)
                                    selected
                                    @elseif(old('city')!==null && $city->id == old('city'))
                                    selected
                                    @endif
                                    >{{$city->CITY_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger">{{$errors->first('type')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class=" fas fa-at"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="Shop Info Mail Address" name=mail value="{{ (isset($shop)) ? $shop->SHOP_MAIL : old('mail')}}">
                        </div>
                        <small class="text-danger">{{$errors->first('ntid')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Record ID (Not Required)" name=phone value="{{ (isset($shop)) ? $shop->SHOP_PHNE : old('phone')}}">
                        </div>
                        <small class="text-danger">{{$errors->first('phone')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Shop Image</label>
                        <div class="input-group mb-3">
                            <button type=button id="upload_widget" class="cloudinary-button">Upload files</button>
                            <input type=hidden id=uploaded name=uploadedImage value="{{old('uploadedImage')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password*</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon33"><i class="ti-lock"></i></span>
                            </div>
                            <input type="text" class="form-control" name=password placeholder="Password" aria-label="Password" aria-describedby="basic-addon33" @if($isPassNeeded) required @endif>
                            <small class="text-danger">{{$errors->first('password')}}</small>

                        </div>
                    </div>

                    <div class="form-group">
                        <label>Commercial Record ID</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Record ID (Not Required)" name=ntid value="{{ (isset($shop)) ? $shop->SHOP_NTID : old('ntid')}}">
                        </div>
                        <small class="text-danger">{{$errors->first('ntid')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Location Latitude</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-map"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Google Maps Pin Latitude (Not Required)" name=latt value="{{ (isset($shop)) ? $shop->SHOP_LATT : old('latt')}}">
                        </div>
                        <small class="text-danger">{{$errors->first('latt')}}</small>
                    </div>


                    <div class="form-group">
                        <label>Location Longitude</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-map"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Google Maps Pin Logitude (Not Required)" name=long value="{{ (isset($shop)) ? $shop->SHOP_LONG : old('long')}}">
                        </div>
                        <small class="text-danger">{{$errors->first('long')}}</small>
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
    var myWidget = cloudinary.createUploadWidget({
    cloudName: 'msquareapps', 
    folder: "petmatch/shops",
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