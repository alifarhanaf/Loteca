@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


<form action="{{ route('submit.register') }}" method="POST" >
  @csrf
     
      <div class="az-content-header d-block d-md-flex mg-r-40 mg-l-40 mg-t-20 " style=" padding-left:25px;padding-bottom:10px;padding-top:10px; border:1px solid  #cdd4e0 ">
        <div class="row w-100">
            <div class="col-md-10 my-auto"style=" margin-left:0px; padding-left:0px" >
          <h4 style="color: #1c273c; margin-bottom: 0px;">Enter New Agent</h4>
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
                      <label class="form-label">Name</label>
                      <input name="name" type="text" class="form-control" placeholder="Enter Name" >
                    </div><!-- az-form-group -->
                    <div class="az-form-group mg-t-20">
                        <label class="form-label">Email</label>
                        <input name="email" type="text" class="form-control" placeholder="Enter Email" >
                      </div><!-- az-form-group -->
                    <div class="az-form-group mg-t-20">
                        <label class="form-label">Password</label>
                      <input name="password" type="password" class="form-control" placeholder="Enter Password" >
                      </div><!-- az-form-group -->
                      <div class="az-form-group mg-t-20">
                        <label class="form-label">Phone</label>
                        <input name="phone" type="text" class="form-control" placeholder="Enter Phone" >
                      </div><!-- az-form-group -->
                      <div class="az-form-group mg-t-20">
                        <label class="form-label">WhatsApp Phone</label>
                        <input name="whatsapp_phone" type="text" class="form-control" placeholder="Enter Whatsapp Phone" >
                      </div><!-- az-form-group -->
                      <div class="az-form-group mg-t-20">
                        <label class="form-label">Comission Percentage</label>
                        <input name="percent" type="text" class="form-control" placeholder="Enter Comission Percentage" >
                      </div><!-- az-form-group -->
                      <input type="hidden" name="admin" value="1">
                      <input type="hidden" name="role" value="3">

                      
               
              </div>

             



             

              

              



            </div>
            <div class="col-md-3">

                <div class="wd-xl-100p" >
          
              
                    <div class="az-form-group" >
                      <label class="form-label" style="font-weight: 500; color:#1c273c; font-size:15px"> Status</label>
                      
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