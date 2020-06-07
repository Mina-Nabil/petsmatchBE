@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-7">
        <x-datatable id="myTable" :title="$title" :subtitle="$subTitle" :cols="$cols" :items="$items" :atts="$atts" />
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $formTitle }}</h4>
                <form class="form pt-3" method="post" action="{{ url($formURL) }}" enctype="multipart/form-data" >
                @csrf
                <input type=hidden name=id value="{{(isset($city)) ? $city->id : ''}}">

                    <div class="form-group">
                        <label>City Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="City Name" name=name value="{{ (isset($city)) ? $city->CITY_NAME : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Country*</label>
                        <div class="input-group mb-3">
                            <select name=country class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                <option value="" disabled selected >Pick From Countries</option>
                                @foreach($countries as $countr)
                                <option value="{{ $countr->id }}"
                                @if(isset($city) && $countr->id == $city->CITY_CNTR_ID)
                                    selected
                                @endif
                                >{{$countr->CNTR_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger">{{$errors->first('country')}}</small>
                    </div>
                    
                    

                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    @if($isCancel)
                        <a href="{{url($homeURL) }}" class="btn btn-dark">Cancel</a>
                    @endif
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $form2Title }}</h4>
                <form class="form pt-3" method="post" action="{{ url($form2URL) }}" enctype="multipart/form-data" >
                @csrf
                <input type=hidden name=id value="{{(isset($country)) ? $country->id : ''}}">

                    <div class="form-group">
                        <label>Country Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Country Name" name=name value="{{ (isset($country)) ? $country->CNTR_NAME : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>
                    
                    

                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    @if($isCancel2)
                        <a href="{{url($homeURL) }}" class="btn btn-dark">Cancel</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

</div>
@endsection