@extends('master_Admin')
@section('css')
<style>

    .modal-dialog {
        width: 1300px;
        margin: 30px auto;
    }
.multiselect {
  width: auto;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
#checkboxesCampaigns {
  display: none;
  border: 1px #dadada solid;
}

#checkboxesCampaigns label {
  display: block;
}

#checkboxesCampaigns label:hover {
  background-color: #1e90ff;
}
#checkboxeslists {
  display: none;
  border: 1px #dadada solid;
}

#checkboxeslists label {
  display: block;
}

#checkboxeslists label:hover {
  background-color: #1e90ff;
}


.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  border-bottom: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">


@endsection
@section('title')
Dashboard Agent
@endsection
@section('content')


      

<div class="page-content">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 dashboard_panel ">
                <div class="portlet light row">
                    <div class="col-md-12">
                        <div class=" row">
                            <div class="col-md-3" >
                                <div class="caption caption-md">
                                    <i class="fa fa-file font-blue-madison"></i> 
                                    <span class="caption-subject font-blue-madison bold uppercase">Export Model Amel</span>
                                </div>
                                @if(session()->has('error'))
                                    <div class="alert alert-danger text-center" id="msg">
                                    {{ session()->get('error') }}
                                    </div>
                                @endif
                                <form action="{{route('ExportList')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="radio" name="type" value="1" class="type"> Tout les contacts
                                        <input type="radio" name="type" value="0" class="type"> Les contact Traitées
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                              <div class="multiselect" style="z-index:100">
                                                <div class="selectBox" onclick="showCheckboxesList()">
                                                  <select class="form-control">
                                                    <option>Select an option</option>
                                                  </select>
                                                  <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxeslists">
                                                        <!-- <label for="14112022">
                                                            <input type="radio" name="list" id="14112022" value="14112022" /> unadev_harmony
                                                        </label>
                                                        <label for="1000101">
                                                            <input type="radio" name="list" id="1000101" value="1000101" /> unapei_harmony
                                                        </label> -->
                                                    @foreach($lists as $campaign => $list)
                                                        
                                                        <label for="{{$list->list_id}}">
                                                            <input type="checkbox" name="list[]" id="{{$list->list_id}}" value="{{$list->list_id}}" /> {{$list->list_name}}
                                                        </label>
                                                       
                                                    @endforeach
                                                    
                                                </div>
                                                <br>
                                              </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none" id="all_contacts">
                                        <input type="date" class="form-control" name="date_injection"><br>

                                        <button type="submit" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Export all contact</button>
                                    </div>
                                    <div class="form-group" id="contacts">
                                        <input type="date" class="form-control" name="date"><br>

                                        <button type="submit" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Export List</button>
                                    </div>
                                </form> 
                            </div>
                            <div class="col-md-4" >
                                <div class="caption caption-md">
                                    <i class="fa fa-file font-blue-madison"></i> 
                                    <span class="caption-subject font-blue-madison bold uppercase">Agent Time Details</span>
                                </div>
                                @if(session()->has('error1'))
                                    <div class="alert alert-danger text-center" id="msg">
                                    {{ session()->get('error1') }}
                                    </div>
                                @endif

                                <form action="{{route('ExportTimeAgent')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="datetime_start"><br>
                                        </div>
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="datetime_end"><br>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Export List</button>
                                        </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="container">
                        <form id="FormSelectAgent">
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <label>Selectionner les fichiers</label>
                                      <div class="multiselect" style="z-index:100">
                                        <div class="selectBox" onclick="showCheckboxesCampaign()">
                                          <select class="form-control">
                                            <option>Select an option</option>
                                          </select>
                                          <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxesCampaigns">
                                            @foreach($campaigns as $campaign)
                                                <label for="{{$campaign->campaign_id}}">
                                                    <input type="radio" name="campaigns" id="{{$campaign->campaign_id}}" value="{{$campaign->campaign_id}}" /> {{$campaign->campaign_name}}
                                                </label>
                                            @endforeach
                                            
                                        </div>
                                      </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Selectionner les agents</label>
                                      <div class="multiselect" style="z-index:100">
                                        <div class="selectBox" onclick="showCheckboxes()">
                                          <select class="form-control">
                                            <option>Select an option</option>
                                          </select>
                                          <div class="overSelect"></div>
                                        </div>

                                        
                                            
                                            <div id="checkboxes">
                                                @foreach ($agentslive as $key => $agentt)
                                                    <label for="{{$agentt->user}}">
                                                        <input type="checkbox" name="agent[]" id="{{$agentt->user}}" value="{{$agentt->user}}" /> {{$agentt->full_name}}
                                                    </label>
                                                @endforeach
                                            </div>
                                                
                                            
                                        
                                        
                                      </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> Choisir le jour</label>
                                        <input type="date" name="day" id="day" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row"><br>
                                <div class="col-md-3">
                                    <button class="btn btn-info"><i class="fa fa-search"></i>Rechercher</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 text-center" id="loader" style="display:none">
                        <div class="loader text-center"></div>
                    </div>
                    <div class="col-md-12 result"><br>
                        <div class="portlet-title" style="background-color:#0dcaf0;padding:7px">
                            <div class="caption caption-md" style="color:white">
                                <i class="fa fa-list"></i> 
                                <span class="caption-subject bold">Statistique personalisée</span>
                            </div>
                        </div>

                        
                        <div class="portlet-body flip-scroll">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                            <th>Agent</th>
                                            <th>Dat</th>
                                            <th>Dc</th>
                                            <th>Dmc</th>
                                            <th>Dt</th>
                                            <th>Dprod</th>
                                            <th>Dmprod</th>
                                            <th>Dpa</th>
                                            <th>Appels</th>
                                            <th>Pos.</th>
                                            <th>%Pos.</th>
                                            <th>%Pos/Arg</th>
                                            <th>Arg.</th>
                                            <th>%Arg.</th>
                                            <th>ArgH</th>
                                            <th>Dhold</th>
                                    </tr>
                                </thead>
                                <tbody id="agentsStat">
                                    
                                    
                                    
                                  
                                
                                </tbody>
                                <tfoot id="TotalAgentStat">
                                    @if($etat == 200)
                                    <tr>
                                        <td>TOTAL</td>
                                        <td>{{$totalAgentInfo['Dat']}}</td>
                                        <td>{{$totalAgentInfo['Dc']}}</td>
                                        <td>{{$totalAgentInfo['Dmc']}}</td>
                                        <td>{{$totalAgentInfo['Dt']}}</td>
                                        <td>{{$totalAgentInfo['Dprod']}}</td>
                                        <td>{{$totalAgentInfo['Dmprod']}}</td>
                                        <td>{{$totalAgentInfo['Dpa']}}</td>
                                        <td>{{$totalAgentInfo['appels']}}</td>
                                        <td>{{$totalAgentInfo['pos']}}</td>
                                        <td>{{$totalAgentInfo['pourcpos']}}</td>
                                        <td>{{$totalAgentInfo['pourcposArg']}}</td>
                                        <td>{{$totalAgentInfo['Arg']}}</td>
                                        <td>{{$totalAgentInfo['pourcArg']}}</td>
                                        <td>{{$totalAgentInfo['ArgH']}}</td>
                                        <td>{{$totalAgentInfo['Dhold']}}</td>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>            
        </div> 
    </div>
</div>

<script src="{{asset('assets/admin/js/jquery-2.1.1.min.js')}}"></script>
<script>
    var expanded = false;

    function showCheckboxes() {
      var checkboxes = document.getElementById("checkboxes");
      
      if (!expanded) {
        checkboxes.style.display = "block";
        //$(".campaigns").css('display','block');
        expanded = true;
      } else {
        checkboxes.style.display = "none";
        //$(".campaigns").css('display','none');
        expanded = false;
      }
    }

    function showCheckboxesCampaign() {
      var checkboxesCampaigns = document.getElementById("checkboxesCampaigns");
      
      if (!expanded) {
        checkboxesCampaigns.style.display = "block";
        //$(".campaigns").css('display','block');
        expanded = true;
      } else {
        checkboxesCampaigns.style.display = "none";
        //$(".campaigns").css('display','none');
        expanded = false;
      }
    }
    function showCheckboxesList() {
      var checkboxeslists = document.getElementById("checkboxeslists");
      
      if (!expanded) {
        checkboxeslists.style.display = "block";
        //$(".campaigns").css('display','block');
        expanded = true;
      } else {
        checkboxeslists.style.display = "none";
        //$(".campaigns").css('display','none');
        expanded = false;
      }
    }


    $('#FormSelectAgent').on('submit',function(e){
        e.preventDefault();


        var ids = $("input[type='checkbox'][name='agent[]']:checked").map(function () {
            return $(this).attr("id");
        }).get();
        var campaigns = $("input[type='radio'][name='campaigns']:checked").map(function () {
            return $(this).attr("id");
        }).get();
        var day = $('#day').val();
        //var campaigns = $('#campaigns').val();
        //alert(campaigns);
        

        
        if(ids.length == 0){
            //alert(ids == ''); 
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: response.msg,
                showConfirmButton: true,
                timer: 1500
            });
        }else if(day.length == 0){
            //alert(day == ''); 
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: response.msg,
                showConfirmButton: true,
                timer: 1500
            });
        }else if(ids.length > 0 && day.length > 0){
            //alert('eeeee')
            $('#loader').show();
            $('.result').hide();
            $.ajax({
                url: 'new_show_stat_agents/',
                type: "post",
                data:{
                        "_token":"{{csrf_token()}}",
                        ids:ids,
                        //campaignsids:campaignsids,
                        day:day,
                        campaigns:campaigns,
                    },
                success:function(response)
                {   
                    
                    status = response.etat;
                    //alert(status);
                    //console.log(totalAgentInfo);
                    if(status == 200){
                        agents = response.agents;
                        totalAgentInfo = response.totalAgentInfo;
                        $('#agentsStat').empty();
                        $('#TotalAgentStat').empty();
                        agents.forEach(element =>{                              
                            $('#agentsStat').append(`
                                <tr style="padding:5px">
                                    <td>${element.Agent}</td>
                                    <td>${element.Dat}</td>
                                    <td>${element.Dc}</td>
                                    <td>${element.Dmc}</td>
                                    <td>${element.DT}</td>
                                    <td>${element.Dprod}</td>
                                    <td>${element.Dmprod}</td>
                                    <td>${element.Dpa}</td>
                                    <td>${element.appels}</td>
                                    <td>${element.pos}</td>
                                    <td>${element.pourcpos}</td>
                                    <td>${element.pourcposArg}</td>
                                    <td>${element.Arg}</td>
                                    <td>${element.pourcArg}</td>
                                    <td>${element.ArgH}</td>
                                    <td>${element.Dhold}</td>
                                </tr>
                            `); 
                        });
                        $('#TotalAgentStat').append(`
                                <tr style="padding:5px">
                                    <td>TOTAL</td>
                                    <td>${totalAgentInfo.Dat}</td>
                                    <td>${totalAgentInfo.Dc}</td>
                                    <td>${totalAgentInfo.Dmc}</td>
                                    <td>${totalAgentInfo.Dt}</td>
                                    <td>${totalAgentInfo.Dprod}</td>
                                    <td>${totalAgentInfo.Dmprod}</td>
                                    <td>${totalAgentInfo.Dpa}</td>
                                    <td>${totalAgentInfo.appels}</td>
                                    <td>${totalAgentInfo.pos}</td>
                                    <td>${totalAgentInfo.pourcpos}</td>
                                    <td>${totalAgentInfo.pourcposArg}</td>
                                    <td>${totalAgentInfo.Arg}</td>
                                    <td>${totalAgentInfo.pourcArg}</td>
                                    <td>${totalAgentInfo.ArgH}</td>
                                    <td>${totalAgentInfo.Dhold}</td>
                                </tr>
                            `); 
                    }
                        
                },
                complete: function(response){

                    $('#loader').hide();
                    $('.result').show();
                }
            });
        }
    });
</script>
<script type="text/javascript">
    
</script>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});
$('.type').on('change',function(){
    if(this.value == 1){
        $('#contacts').css('display','none');
        $('#all_contacts').css('display','block');
    }else{
        $('#all_contacts').css('display','none');
        $('#contacts').css('display','block');
    }
})
</script>





@endsection
