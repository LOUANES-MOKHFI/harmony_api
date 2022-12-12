@extends('master')
@section('css')
<style>

.modal-dialog {
    max-width: 605px;
    margin: 1.75rem auto;
    
}
.qual{
    padding-bottom: 25px;
}
</style>
@endsection
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    @if($etat == 200)
                        <div class="alert alert-success text-center">
                            {{$msg}}
                        </div>
                    @elseif($etat == 401)
                        <div class="alert alert-danger text-center">
                            {{$msg}}
                        </div>
                    @endif
                    USER : {{$user}}
                    PASS : {{$user}}


                    <div>
                        <input type="text" name="agent_status" id="agent_status" value="">
                        <input type="text" value="{{$etatAgent}}" id="etat_agent">
                        <button class="btn btn-success" data-value="PAUSED" id="agentStatusButton">Vous etes en pause</button>
                        <!--a href="{{route('change_status',$etatAgent)}}" class="btn @if($etatAgent == 'PAUSED') btn-success @else($etatAgent == 'READY') btn-primary @endif">
                            @if($etatAgent == 'PAUSED') Vous etes en PAUSE @else($etatAgent == 'READY') Vous etes ACTIVE @endif
                        </a-->
                        <a href="{{route('logout')}}" class="btn btn-info">Logout</a>

                        <button class="btn btn-danger" onclick="hangup()">Hangup</button>
                        <input type="text" id="channel" value=''>
                        <input type="text" id="lead_id" value=''>

                    </div>


                </div>
            </div>
        </div>
        <div class="row">
            <div clas="col-md-12">
                <h3 class="panel-title">Information de contact</h3>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Title :</label>
                        <input name="title" type="text" class="form-control" id="title" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>First :</label>
                        <input name="first_name" type="text" class="form-control" id="first_name" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>MI :</label>
                        <input name="middle_initial" type="text" class="form-control" id="middle_initial" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Last :</label>
                        <input name="last_name" type="text" class="form-control" id="last_name" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address 1:</label>
                        <input name="address1" type="text" class="form-control" id="address1" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address 2:</label>
                        <input name="address2" type="text" class="form-control" id="address2" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address 3:</label>
                        <input name="address3" type="text" class="form-control" id="address3" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>City :</label>
                        <input name="city" type="text" class="form-control" id="city" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>State :</label>
                        <input name="state" type="text" class="form-control" id="state" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Post Code :</label>
                        <input name="postal_code" type="text" class="form-control" id="postal_code" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Province :</label>
                        <input name="province" type="text" class="form-control" id="province" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Vendor ID :</label>
                        <input name="vendor_lead_code" type="text" class="form-control" id="vendor_lead_code" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Gender :</label>
                        <input name="gender" type="text" class="form-control" id="gender" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone :</label>
                        <input name="phone_number" type="text" class="form-control" id="phone_number" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Dial Code :</label>
                        <input name="phone_code" type="text" class="form-control" id="phone_code" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Alt Phone :</label>
                        <input name="alt_phone" type="text" class="form-control" id="alt_phone" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Show :</label>
                        <input name="security_phrase" type="text" class="form-control" id="security_phrase" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email :</label>
                        <input name="email" type="text" class="form-control" id="email" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Comments :</label>
                        <textarea name="comments" class="form-control" id="comments"></textarea>
                    </div>
                </div>
                
            </div>
        </div>
        <div id="myModal2" class="modal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-body">
                <div class="container-fluid">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="myModalLabel"></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="Update_dispo">
                                @csrf
                                <input type="text" name="uniqueid" id="uniqueid">
                                <input type="text" name="list_id" id="list_id">
                                <input type="text" name="called_count" id="called_count">
                                <input type="text" name="lead_id" id="lead_id1">
                                <div class="row" id="ListQualification">
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-canter">
                                            <input type="checkbox" name="agent_status" id="agent_status" value="1"> Met en pause apres la qualificiation
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-center">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i>Valider</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{asset('assets/admin/js/jquery-2.1.1.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $("#agentStatusButton").click(function(){
        //alert($("#agentStatusButton").attr("data-value"));
        status = $("#agentStatusButton").attr("data-value");
        if(status == 'QUEUE' || status == 'INCALL'){
            status = 'READY';
        }
            $.ajax({
                url: 'change_status/'+status,
                type: "get",
                success:function(response)
                {
                    if(response.etat == 200){
                        $("#agentStatusButton").attr("data-value",response.etatAgent);                                
                        //$('#etat_agent').attr("value",response.etatAgent);
                        document.getElementById('etat_agent').value = response.etatAgent;
                        //alert(response.etatAgent);
                        if(response.etatAgent == 'PAUSED'){
                            $("#agentStatusButton").html('Vous etes en pause');
                            $("#agentStatusButton").addClass('btn-success');
                            $("#agentStatusButton").removeClass('btn-danger');
                        }
                        if(response.etatAgent == 'READY'){
                            $("#agentStatusButton").html('Vous etes active');
                            $("#agentStatusButton").addClass('btn-success');
                            $("#agentStatusButton").removeClass('btn-danger');

                        }

                    }
                },
            });
    });
     ///// get channel and leadId for agent
    $(document).ready(function(){
        getchannel = setInterval(function(){  
            //getLead = document.getElementById('lead_id').value = lead_id;
            var etat = $("#etat_agent").val();
            if(etat == 'READY'){
                chan = document.getElementById('channel').value;
                //alert(chan);
                if(chan == null || chan == ''){
                        /*if(getLead == null || getLead == ''){}
                        else{
                            //clearInterval(getchannel);
                        }*/
                        $.ajax({
                            url: 'get_channel/',
                            type: "GET",
                            success:function(response)
                            {
                                
                                status = response.etat;
                                msg = response.msg;
                            
                                if(status == 200){
                                    console.log(response);
                                    //var channel = document.getElementById('channel');
                                    //channel.setAttribute('value', channel);
                                    lead_id = response.lead_id;
                                    channel = response.channel;
                                    document.getElementById('channel').value = channel;
                                    document.getElementById('lead_id').value = lead_id;
                                }
                            },
                        });
                    }
                }  
            },1000);
    });

    ////change agent stat to incall and get contact information
    $(document).ready(function(){
        
        //channel1.setAttribute('value', 2121);
        call = setInterval(function(){
        phone = document.getElementById('phone_number').value;
        if(phone == null || phone == ''){}
        else{
            //clearInterval(call);
        }
                chan = document.getElementById('channel').value;
                if(chan == null || chan == ''){
                }else{    
                    
                    $.ajax({
                        url: 'change_to_incall/',
                        type: "GET",
                        success:function(response)
                        {
                            console.log(response);
                            status = response.etat;
                            msg = response.msg;
                            if(status == 200){
                                document.getElementById('title').value = response.title;
                                document.getElementById('first_name').value = response.first_name;
                                document.getElementById('middle_initial').value = response.middle_initial;
                                document.getElementById('last_name').value = response.last_name;
                                document.getElementById('address1').value = response.address1;
                                document.getElementById('address2').value = response.address2;
                                document.getElementById('address3').value = response.address3;
                                document.getElementById('city').value = response.city;
                                document.getElementById('state').value = response.state;
                                document.getElementById('postal_code').value = response.postal_code;
                                document.getElementById('province').value = response.province;
                                document.getElementById('vendor_lead_code').value = response.vendor_lead_code;
                                document.getElementById('gender').value = response.gender;
                                document.getElementById('phone_number').value = response.phone_number;
                                document.getElementById('phone_code').value = response.phone_code;
                                document.getElementById('alt_phone').value = response.alt_phone;
                                document.getElementById('security_phrase').value = response.security_phrase;
                                document.getElementById('email').value = response.email;
                                document.getElementById('comments').value = response.comments;
                                document.getElementById('uniqueid').value = response.uniqueid;
                                document.getElementById('list_id').value = response.list_id;
                                document.getElementById('lead_id').value = response.lead_id;
                                document.getElementById('lead_id1').value = response.lead_id;
                                document.getElementById('called_count').value = response.called_count;
                                //clearInterval(call);
                            }
                        },
                    });
                
                }
            
        
    },1000);
    
		
    });
    ///// hangup 
    function hangup() {
        $("#myModal2").modal("hide");
        //e.preventDefault();
        channel = document.getElementById('channel').value;
        
        if(channel == null || channel == ''){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Aucun appel en cours',
                showConfirmButton: true,
                timer: 5000
            });
        }
        else{
            called_count = document.getElementById('called_count').value;
            uniqueid = document.getElementById('uniqueid').value;
            lead_id = document.getElementById('lead_id1').value;
            list_id = document.getElementById('list_id').value;
            phone_number = document.getElementById('phone_number').value;
            phone_code = document.getElementById('phone_code').value;
            $.ajax({
                url: 'hangup/',
                data: {
                    called_count:called_count,
                    uniqueid:uniqueid,
                    lead_id:lead_id,
                    list_id:list_id,
                    phone_number:phone_number,
                    phone_code:phone_code,
                    channel:channel
                },
                type: "get",
                success:function(response)
                {
                    $("#myModal2").modal("show");
                    //console.log(response.statuses);
                    if(response.etat == 200){
                        //alert(response.statuses);
                        statuses = response.statuses;
                        $('#ListQualification').empty();
                        statuses.forEach(element =>
                                {
                                    $('#ListQualification').append(`
                                        <div class="col-md-4 col-xs-12 qual">
                                                <input type="radio" name="dispo_choice" id="dispo_choice" value="${element.status}"><span class="text_danger">${element.status} - </span> ${element.status_name}
                                        </div>
                                        `);
                                });    
                                document.getElementById('channel').value = '';
                                document.getElementById('lead_id').value = '';
                                document.getElementById('phone_number').value = '';
                                document.getElementById('phone_code').value = '';
                                document.getElementById('title').value = '';
                                document.getElementById('first_name').value = '';
                                document.getElementById('middle_initial').value = '';
                                document.getElementById('last_name').value = '';
                                document.getElementById('address1').value = '';
                                document.getElementById('address2').value = '';
                                document.getElementById('address3').value = '';
                                document.getElementById('city').value = '';
                                document.getElementById('state').value = '';
                                document.getElementById('postal_code').value = '';
                                document.getElementById('province').value = '';
                                document.getElementById('vendor_lead_code').value = '';
                                document.getElementById('gender').value = '';
                                document.getElementById('phone_number').value = '';
                                document.getElementById('phone_code').value = '';
                                document.getElementById('alt_phone').value = '';
                                document.getElementById('security_phrase').value = '';
                                document.getElementById('email').value = '';
                                document.getElementById('comments').value = '';                    
                    }
                },
            });
        }  
    }
    ///// change qualif for contact and save it
    $('#Update_dispo').on('submit',function(e){
        e.preventDefault();
        let uniqueid = $('#uniqueid').val();
        let list_id = $('#list_id').val();
        let called_count = $('#called_count').val();
        let lead_id1 = $('#lead_id1').val();
        let agent_status = $('#agent_status:checked').val();
        let dispo_choice = $('#dispo_choice').val();
       // alert(agent_status);
        
        $.ajax({
            url: 'Update_dispo/',
            type: "get",
            data:{
                    "_token":"{{csrf_token()}}",
                    uniqueid:uniqueid,
                    list_id:list_id,
                    called_count:called_count,
                    lead_id:lead_id1,
                    agent_status:agent_status,
                    dispo_choice:dispo_choice,
                },
            success:function(response)
            {   
                $("#myModal2").modal("hide");
                //console.log(response);
                status = response.etat;
                msg = response.msg;

                if(status == 200){
                    document.getElementById('channel').value = '';
                    document.getElementById('lead_id').value = '';
                    document.getElementById('phone_number').value = '';
                    document.getElementById('phone_code').value = '';
                    document.getElementById('title').value = '';
                    document.getElementById('first_name').value = '';
                    document.getElementById('middle_initial').value = '';
                    document.getElementById('last_name').value = '';
                    document.getElementById('address1').value = '';
                    document.getElementById('address2').value = '';
                    document.getElementById('address3').value = '';
                    document.getElementById('city').value = '';
                    document.getElementById('state').value = '';
                    document.getElementById('postal_code').value = '';
                    document.getElementById('province').value = '';
                    document.getElementById('vendor_lead_code').value = '';
                    document.getElementById('gender').value = '';
                    document.getElementById('phone_number').value = '';
                    document.getElementById('phone_code').value = '';
                    document.getElementById('alt_phone').value = '';
                    document.getElementById('security_phrase').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('comments').value = ''; 
                    $("#agentStatusButton").attr("data-value",response.etatAgent);                                
                    $("#agentStatusButton").html(response.etatAgent);
                    //$('#etat_agent').attr("value",response.etatAgent);
                    document.getElementById('etat_agent').value = response.etatAgent;
                    if(response.etatAgent == 'PAUSED'){
                        $("#agentStatusButton").html('Vous etes en pause');
                        $("#agentStatusButton").addClass('btn-success');
                        $("#agentStatusButton").removeClass('btn-danger');
                    }
                    if(response.etatAgent == 'READY'){
                        $("#agentStatusButton").html('Vous etes active');
                        $("#agentStatusButton").addClass('btn-success');
                        $("#agentStatusButton").removeClass('btn-danger');

                    }
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: msg + ' ' +dispo_choice,
                        showConfirmButton: true,
                        timer: 5000
                    });
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: true,
                        timer: 5000
                    });
                }
                    
                },
        });



    });
</script>
@endsection
