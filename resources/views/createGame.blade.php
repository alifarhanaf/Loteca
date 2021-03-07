@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


<form action="{{ route('submit.game') }}" method="POST" enctype="multipart/form-data">
  @csrf
     
      <div class="az-content-header d-block d-md-flex mg-r-40 mg-l-40 mg-t-20 " style=" padding-left:25px;padding-bottom:10px;padding-top:10px; border:1px solid  #cdd4e0 ">
        <div class="row w-100">
            <div class="col-md-10 my-auto"style=" margin-left:0px; padding-left:0px" >
          <h4 style="color: #1c273c; margin-bottom: 0px;">Enter New Game</h4>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-indigo btn-rounded btn-block">Publish</button>
            </div>
        </div>

      </div><!-- az-content-header -->
      <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
       

        <div class="row">
            <div class="col-md-9">
                <div class="wd-xl-100p">
          
              
                    <div class="az-form-group">
                      <label class="form-label">Game Name</label>
                      <input name="name" type="text" class="form-control" placeholder="Enter Game Name" >
                    </div><!-- az-form-group -->
                    <div class="az-form-group mg-t-20">
                        <label class="form-label">Happening Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            </div>
                            <input name="happening_date"  id="datepickerNoOfMonths1" type="text" class="form-control" placeholder="MM/DD/YYYY">
                          </div>
                      </div><!-- az-form-group -->

                      
               
              </div>

              <div class="row mg-t-20">
                  <div class="col-md-6">
                    <div class="az-form-group">
                        <label class="form-label">First Team</label>
                        <input name="team_a" type="text" class="form-control" placeholder="Enter First Team" >

                       
                            
                          



                      </div><!-- az-form-group -->
                  </div>
                  <div class="col-md-6">
                    <div class="az-form-group">
                        <label class="form-label">Second Team</label>
                        <input name="team_b" type="text" class="form-control" placeholder="Enter Second Team" >

                        
                        
                      </div><!-- az-form-group -->
                  </div>
              </div>

              <div class="row mg-t-20" style="text-align: center">
                <div class="col-md-6">
                  <div class="az-form-group">
                 
                    <div class="wrapper">
                      <div class="file-upload">
                        <input type="file" name="flag_a" onchange="loadFile1(event)" />
                        <i id="wrap1" class="fa fa-arrow-up"></i>
                        <img style="height: 100px;width:100px ; display:none"  id="output1" src="" >
                      </div>
                    </div>
                    <label class="form-label">First Team Flag</label>
                    {{-- <p>First Team Flag</p> --}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="az-form-group">
                   
                   
                  <div class="wrapper">
                    <div class="file-upload">
                      <input type="file" name="flag_b" onchange="loadFile(event)" />
                      <i id="wrap" class="fa fa-arrow-up"></i>
                      <img style="height: 100px;width:100px ; display:none"  id="output" src="" >
                    </div>
                  </div>
                  <label class="form-label" style="font-size:0.875rem;font-weight: 500;">Second Team Flag</label>
                  {{-- <p>Second Team Flag</p> --}}
                
                </div>
                </div>
              </div>
             

              

              



            </div>
            <div class="col-md-3">

                <div class="wd-xl-100p" >
          
              
                    <div class="az-form-group" >
                      <label class="form-label" style="font-weight: 500; color:#1c273c; font-size:15px">Game Status</label>
                      
                      <div style="margin-top:10px;" >
                           <input type="radio" name="radio" id="radio1" checked="true" /> <label class="radio" for="radio1">Enable</label>
                      <br>
                           <input type="radio" name="radio" id="radio2" /> <label for="radio2">Disable</label> 
                      <br>
                      </div>



                    </div>
                    <!-- az-form-group -->


                   


                      

                      
               
              </div>
            </div>
        </div>
          


      </div><!-- az-content-body -->
</form>
<script>
  
  var loadFile = function(event) {
    document.getElementById("wrap").style.display ="none";
  document.getElementById("output").style.display ="inline-flex";
   var image = document.getElementById('output');
   image.src = URL.createObjectURL(event.target.files[0]);
 };
 var loadFile1 = function(event) {
    document.getElementById("wrap1").style.display ="none";
  document.getElementById("output1").style.display ="inline-flex";
   var image = document.getElementById('output1');
   image.src = URL.createObjectURL(event.target.files[0]);
 };

 </script>
 


      @include('includes.subfooter')
      @include('includes.footer')
     
      <script>
        @if(Session::has('success'))
       // console.log('Hi');
       toastr.success("{{ Session::get('success') }}") ;
      @endif
      @if(Session::has('error'))
       // console.log('Hi');
       toastr.error("{{ Session::get('error') }}") ;
      @endif
      </script>