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
                <input type=hidden name=id value="{{(isset($breed)) ? $breed->id : ''}}">

                    <div class="form-group">
                        <label>Breed Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Breed Name" name=name value="{{ (isset($breed)) ? $breed->BRED_NAME : old('name')}}" required>
                        </div>
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    </div>

                    <div class="form-group">
                        <label>Animal*</label>
                        <div class="input-group mb-3">
                            <select name=animal class="select2 form-control custom-select" style="width: 100%; height:36px;" required>
                                <option value="" disabled selected >Pick From Animals</option>
                                @foreach($animals as $countr)
                                <option value="{{ $countr->id }}"
                                @if(isset($breed) && $countr->id == $breed->BRED_ANML_ID)
                                    selected
                                @endif
                                >{{$countr->ANML_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger">{{$errors->first('animal')}}</small>
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
                <input type=hidden name=id value="{{(isset($animal)) ? $animal->id : ''}}">

                    <div class="form-group">
                        <label>Animal Name*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Animal Name" name=name value="{{ (isset($animal)) ? $animal->ANML_NAME : old('name')}}" required>
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