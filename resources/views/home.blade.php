@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
    <a href="{{url('phone')}}?phone=15088132183">获取验证码</a>
<script>
    // $.ajax({url:'api/get/table', data:{tname:'users',whs:['type|=|0']}, success:function(data){
    //         console.log(data)
    //     }
    // })
</script>
@endsection

