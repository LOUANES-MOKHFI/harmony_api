@extends('master_Admin')
@section('css')
<style>

    .modal-dialog {
        width: 1300px;
        margin: 30px auto;
    }
.multiselect {
  width: 200px;
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
                                        <select class="form-control" name="campaign_id">
                                            <option value="">-- choisir la compagne --</option>
                                            <option value="1000101">1000101 - UNAPEI</option>
                                            <option value="2000202">2000202 - UNADEV</option>
                                        </select>
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
                                    @if($etat == 200)
                                    @isset($agents)
                                    @foreach($agents as $key => $agent)
                                    
                                        <tr style="padding:5px">
                                            <td>{{$agent['Agent']}}</td>
                                            <td>{{$agent['Dat']}}</td>
                                            <td>{{$agent['Dc']}}</td>
                                            <td>{{$agent['Dmc']}}</td>
                                            <td>{{$agent['DT']}}</td>
                                            <td>{{$agent['Dprod']}}</td>
                                            <td>{{$agent['Dmprod']}}</td>
                                            <td>{{$agent['Dpa']}}</td>
                                            <td>{{$agent['appels']}}</td>
                                            <td>{{$agent['pos']}}</td>
                                            <td>{{$agent['pourcpos']}}</td>
                                            <td>{{$agent['pourcposArg']}}</td>
                                            <td>{{$agent['Arg']}}</td>
                                            <td>{{$agent['pourcArg']}}</td>
                                            <td>{{$agent['ArgH']}}</td>
                                            <td>{{$agent['Dhold']}}</td>
                                        </tr>
                                    @endforeach
                                    @endisset
                                    @elseif($etat == 401)
                                    <tr style="padding:5px">
                                        <td colspan="16" class="text-center">
                                            Aucune données existe !!
                                        </td>
                                    </tr>
                                    @endif
                                
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


    $('#FormSelectAgent').on('submit',function(e){
        e.preventDefault();
        
        $('#loader').show();
        $('.result').hide();

        var ids = $("input[type='checkbox'][name='agent[]']:checked").map(function () {
            return $(this).attr("id");
        }).get();
       // alert(ids);
        
        
        $.ajax({
            url: 'show_stat_agents/',
            type: "post",
            data:{
                    "_token":"{{csrf_token()}}",
                    ids:ids,
                },
            success:function(response)
            {   
                
                status = response.etat;
                agents = response.agents;
                totalAgentInfo = response.totalAgentInfo;
                console.log(agents);
                if(status == 200){
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
            complete: function(){
                $('#loader').hide();
                $('.result').show();
            }
        });
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
