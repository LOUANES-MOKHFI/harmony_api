<style type="text/css">
     #timePAUSEDAgent
    {
        width: 200px;
        height: 50px;
        line-height: 50px;
        border: 1px dotted #333;
        text-align: center;
        margin-bottom: 20px;
        font-size: 22px;
    }
</style>
<div id="PauseModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelPause" aria-hidden="true">
    <div class="modal-body">
        <div class="container-fluid">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="myModalLabel"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body container">
                        <div class="row">
                            <div class="col-md-12 container">
                                <div class="text-canter">
                                    <div class="profile-userbuttons">
                                        <div class="row">
                                            <div class="col-md-6"><div id="timePAUSEDAgent"></div></div>
                                            <div class="col-md-6" style="display:none" id="imgDej">
                                                <img src="{{asset('assets/agents/pauseDej.png')}}" width="400" height="300">
                                            </div>
                                            <div class="col-md-6" style="display:none" id="imgCaf">
                                                <img src="{{asset('assets/agents/pauseCaf.png')}}" width="400" height="300">
                                            </div>
                                            <div class="col-md-6" style="display:none" id="imgBrief">
                                                <img src="{{asset('assets/agents/pauseBrief.png')}}" width="400" height="300">
                                            </div>
                                            <div class="col-md-6" style="display:none" id="imgForm">
                                                <img src="{{asset('assets/agents/pauseForm.png')}}" width="400" height="300">
                                            </div>
                                        </div>
                                        
                                        <button type="button" data-value="PAUSED"
                                                class="btn btn-circle green-haze btn-sm  agentStatusButton">Démarrer la production
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>