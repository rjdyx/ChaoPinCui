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

    <form action="/home" method="POST">
        <input type="input">
        <input type="submit" value="提交">
    </form>
<!--     <form action="/api/home/comment" method="POST">
        内容<input type="input" name="content">
        星级<input type="input" name="level">
        用户<input type="input" name="user_id">
        产品<input type="input" name="product_id">
        <input type="submit" value="提交">
    </form> -->
<script>
    // $.ajax({url:'api/get/table', data:{tname:'users',whs:['type|=|0']}, success:function(data){
    //         console.log(data)
    //     }
    // })
</script>
@endsection

