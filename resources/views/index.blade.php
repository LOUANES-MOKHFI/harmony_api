@extends('login')
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Bienvenu Chez CapCorp CRM</h3>
                    <div class="card-body text-center">
                        <div class="form-group mb-3">
                            <a href="{{route('admin.login')}}" style="width:200px" class="btn btn-info">ADMINISTRATEUR</a>
                        </div>
                        <div class="form-group mb-3">
                            <a href="{{route('agent.login')}}" style="width:200px" class="btn btn-success">AGENT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
