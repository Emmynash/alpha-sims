@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 20px;">
        
            <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      @include('layouts.message')
    </div>
        <!-- Classic tabs -->
<div class="classic-tabs mx-2">

    <div class="container">
        <h2>Alpha-Sims Introduction Page</h2>
        <br>
        <!-- Nav pills -->
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link show active" active data-toggle="pill" href="#home">New?</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#menu1">Add School</a>
          </li>
        </ul>
      
        <!-- Tab panes -->
        <div class="tab-content">
            
          <div id="home" class="container tab-pane active"><br>
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>Your registration was successfull, however, you are on this page because you don't belong to any school. To belong, get the below printout to your school but first upload your passport.</strong>
            </div>
            {{-- @include('layouts.message') --}}
            
            <h5 style="color: red;">System No: {{Auth::user()->id}}</h5>
            <div class="row">
                <div class="col-md-4" style="height: 100px;">
                    <i style="font-style: normal;">Firstname: {{Auth::user()->firstname}}</i><br>
                    <i style="font-style: normal;">Middlename: {{Auth::user()->middlename}}</i><br>
                    <i style="font-style: normal;">Lastname: {{Auth::user()->lastname}}</i><br>
                    <i style="font-style: normal;">PhoneNumber: {{Auth::user()->phonenumber}}</i>
                </div><br>
            </div>
            <div style="height: 100px; width: 100px; background-color: gray;">
                <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" alt="" width="100px; height: 100px;">
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <form id="uploadprofilepix" method="POST" action="/uploadProfilePix" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control-file border @error('profilepix') is-invalid @enderror" name="profilepix">
                            @error('profilepix')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                    </form>
                    <div>
                        <i>You need to upload your profile pix before printing slip</i>
                        <br>
                        <button type="submit" form="uploadprofilepix" class="btn btn-sm btn-info"><i class="fas fa-upload"></i></button>
                        @if(Auth::user()->profileimg != NULL)
                            <button class="btn btn-sm btn-danger" id="btnPrint">Print Slip</button>
                        @endif
                        
                    </div>
                </div>
            </div>
            
            <div style="display: none;">
                <div class="" id="printJS-form" style="width: 793px; height: 1123px; margin: 0 auto;">
                    

                    <div style="width: 793px; height: 1123px; border: 2px solid black; border-style: dashed;">
                        <div style="display: flex;">
                            <div style="width: 25%; height: 100px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" alt="" width="90px" height="90px">
                            </div>
                            <div style="width: 75%; height: 100px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                               <i style="font-size: 30px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">Alpha-Sims School Management System</i>
                               <i style="font-size: 15px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">Run your school with ease.</i>
                               
                            </div>
                        </div>
                        <br>
            
                        <div style="display:flex; width: 95%; margin: 0 auto;">
                            <div style="width: 95%;">
                                <div class="" style="width: 95%; display: flex; flex-direction: column; margin: 0 auto;">
                                    <table>
                                        <tr>
                                            <td><i style="font-size: 12px; font-style: normal;">Full Name:</i></td>
                                            <td><i id="studentname" style="font-size: 12px; font-style: normal; font-weight: bold;">{{Auth::user()->firstname}} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</i></td>
                                        </tr>
                                        <tr>
                                            <td><i style="font-size: 12px; font-style: normal;">System No:</i></td>
                                            <td><i id="studentclass" style="font-size: 12px; font-style: normal; font-weight: bold;">{{Auth::user()->id}}</i></td>
                                        </tr>
                                        <tr>
                                            <td><i style="font-size: 12px; font-style: normal;">Phone Number:</i></td>
                                            <td><i id="studentclass" style="font-size: 12px; font-style: normal; font-weight: bold;">{{Auth::user()->phonenumber}}</i></td>
                                        </tr>
                                        <tr>
                                            <td><i style="font-size: 12px; font-style: normal;">Email:</i></td>
                                            <td><i id="studentclass" style="font-size: 12px; font-style: normal; font-weight: bold;">{{Auth::user()->email}}</i></td>
                                        </tr>
                                    </table>
                                </div>
            
                            </div>
                        </div>
                        <br><br><br>
                        <center><i>Take this to your school admin</i></center>
                        <br>
                        <div style="display: flex; align-items: center; justify-content: center; margin-top: 750px;">
                            <i style="text-decoration: underline; font-style: normal; font-weight: bold;">Alpha-sims evidence of registration</i>
                        </div>
                        <br>
        
                        <input type="hidden" value="{{Session::get('term')}}" name="selectedterm" id="selectedterm">
                        <input type="hidden" value="{{Session::get('studentclass')}}" name="selectedclass" id="selectedclass">
                        <input type="hidden" value="{{Session::get('studentregno')}}" name="studentregno" id="studentregno">
                        <input type="hidden" value="{{Session::get('schoolsession')}}" name="schoolsession" id="schoolsession">
        
                    </div>
                </div>
                
                
            </div>
            
          </div>
          
          <div id="menu1" class="container tab-pane"><br>
            <h3>Add School</h3>

            @if (count($userschool) < 1)
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>Do not submit this form if you are not an Admin or representing a school. Every school submited will first be verifield. Also, Passport upload is required for school verification.</strong>
            </div>

            <form id="schoolregform" action="/shoolreg" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-style: normal;">Select SchoolType</i>
                            <select name="schooltypeselect" id="schooltypeselect" class="form-control @error('schooltypeselect') is-invalid @enderror">
                                <option value="">Choose school type</option>
                                <option value="Primary">Primary School</option>
                                <option value="Secondary">Secondary School</option>
                            </select>
                        </div>
                    </div>
                </div>

                <i style="font-style: normal; font-size: 20px;">School Details</i>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="schoolname" class="form-control @error('schoolname') is-invalid @enderror" value="{{old('schoolname')}}" placeholder="School Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="schoolemail" class="form-control @error('schoolemail') is-invalid @enderror" value="{{old('schoolemail')}}" placeholder="School email">
                        </div>
                        <div class="form-group">
                            <input type="text" name="mobilenumber" class="form-control @error('mobilenumber') is-invalid @enderror" value="{{old('mobilenumber')}}" placeholder="School PhoneNumber">
                        </div>
                        
                        <div class="form-group">
                            {{-- <input type="text" name="mobilenumber" class="form-control @error('mobilenumber') is-invalid @enderror" value="{{old('mobilenumber')}}" placeholder="School PhoneNumber"> --}}
                            <select name="schoolstate" id="schoolstate" class="form-control @error('schooltypeselect') is-invalid @enderror">
                                <option value="">Select State</option>
                                <option value="Abia">Abuja FCT</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="AkwaIbom">AkwaIbom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="FCT">FCT</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nasarawa">Nasarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamafara</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="schoolwebsite" class="form-control @error('schoolwebsite') is-invalid @enderror" value="{{old('schoolwebsite')}}" placeholder="School Website">
                        </div>
                        <div class="form-group">
                            <input type="text" name="dateestablished" class="form-control @error('dateestablished') is-invalid @enderror" value="{{old('dateestablished')}}" placeholder="Establish">
                        </div>
                        <div class="form-group">
                            <textarea name="schooladdress" id="" class="form-control @error('schooladdress') is-invalid @enderror" cols="30" rows="3" placeholder="School Address not P.O.Box">{{old('schooladdress')}}</textarea>
                        </div>

                    </div>
                </div>

                <i style="font-style: normal; font-size: 20px;">Images</i>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-style: normal;">School Logo(not more than 200kb)</i>
                            <input type="file" class="form-control-file border @error('schoolLogo') is-invalid @enderror" name="schoolLogo">
                            @error('schoolLogo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <i style="font-style: normal;">Principal Signature(not more than 200kb)</i>
                            <input type="file" class="form-control-file border @error('schoolprincipalsignature') is-invalid @enderror" name="schoolprincipalsignature">
                            @error('schoolprincipalsignature')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button id="schoolregbtn" class="btn btn-sm btn-info">Submit</button>
            </form>
            @else

            <div class="alert alert-info alert-block">
                {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                <strong>We have recieved your application to use our plateform Alpha-Sims to 
                    boost excellence in your school. Your school is under review we will 
                    contact you concerning the status of your school. Thank you.</strong>
            </div>
            <i style="font-style: normal;">Application ID: {{$userschool[0]['id']}}</i>

            @endif

          </div>
        </div>
      </div>
    </div>

@endsection
