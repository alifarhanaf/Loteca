@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')
<style>
    #star {
  margin-left: -5px !important;
  vertical-align: bottom !important;
  opacity: 0.5
}

.more {
  opacity: 0.5 !important
}

.btn:hover {
  color: black !important
}

.vl {
  margin: 8px !important;
  width: 2px;
  border-right: 1px solid #aaaaaa;
  height: 25px
}

#plus {
  opacity: 0.8
}

.card {
  border-radius: 10px !important;
   
}

a:hover {
  background-color: #ccc !important
}

.btn-outlined:active {
  color: #FFF;
  border-color: #fff !important
}

img {
  cursor: pointer;
  overflow: visible
}

.btn:focus,
.btn:active {
  outline: none !important;
  box-shadow: none !important
}

.container {
  margin-top: 100px !important
}
    </style>
<div class=" mg-t-20" style="padding: 0 40px 40px !important ; ">
    <div class=" card ">
        <div class="card-body ">
    <div class="az-content-label mg-b-5">Questions and Queries</div>
          <p class="mg-b-20">
            Deliver More Value for Users. An User's question helps you know what users want, what difficulties they are facing and how you can best deliver it to them. It'll be both reputition and economical effective.</p>
        </div>
    </div>
    @foreach ($questions as $qstn)
    <div class="row" style="width: 100%;margin-left:0px;margin-right:0px">
        <div class=" card " style="width: 100%">
        <div class="card-body ">
         
                    <h5 class="card-title "><b>
                        User's Question
                        
                    </b></h5>
              
                    <h6 class="card-subtitle mb-2 text-muted">
                        <p class="card-text text-muted small "> <img src="https://img.icons8.com/color/26/000000/christmas-star.png" class="mr-1 " width="19" height="19" id="star"> <span class="vl mr-2 ml-0"></span> <i class="fa fa-users text-muted "></i> Public <span class="vl ml-1 mr-2 "></span> <span></span>Sent by <span class="font-weight-bold"> {{$qstn['user_name']}}</span> &nbsp {{\Carbon\Carbon::parse($qstn->created_at)->diffForHumans()}}  </p>
                    </h6>
               
        </div>
        <div class="card-footer bg-white px-0 ">
            <p style="padding-left:20px;padding-right:20px">{{$qstn->content}}</p>
            
        </div>
    </div>
       
    </div>
        
    @endforeach
        
       

        
       
       
    
    
   
</div>


@include('includes.subfooter')
@include('includes.footer')