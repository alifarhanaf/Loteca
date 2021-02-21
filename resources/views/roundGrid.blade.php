@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


    <div class="az-content-label mg-b-5">Rounds DataTable</div>
          <p class="mg-b-20">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>

          <div>
            <table id="example2" class="table">
              <thead>
                <tr>
                  <th class="wd-20p">Name</th>
                  <th class="wd-25p">Starting Date</th>
                  <th class="wd-20p">Ending Date</th>
                  <th class="wd-15p">Status</th>
                  <th class="wd-20p">Tag</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rounds as $round)
                <tr>
                  <td>{{$round->name}}</td>
                  <td>{{$round->starting_date}}</td>
                  <td>{{$round->ending_date}}</td>
                  <td >
                    <span class="{{$round->status == 1 ? 'badge badge-pill badge-primary': 'badge badge-pill badge-warning'}}" style="width: 50px;">
                        {{$round->status == 1 ? 'Live':'Closed'}}
                    </span>
                    
                  </td>
                  <td>
                    <span class="{{$round->tag == 'original' ? 'badge badge-pill badge-success': 'badge badge-pill badge-info'}}" style="width: 50px;">
                        {{$round->tag }}
                    </span>
                  </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>







    </div><!-- az-content-body -->




@include('includes.subfooter')
@include('includes.footer')