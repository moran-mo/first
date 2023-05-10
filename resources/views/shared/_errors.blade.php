{{--如果验证没有被通过，会自动重定向到提交页，并将错误信息存储到 session 中--}}
@if (count($errors) > 0)
    <div class="alert alert-danger" >
      <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
@endif
