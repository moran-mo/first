{{-- has() 判断是否存在且不为null --}}
@foreach(['danger','warning','success','info'] as $msg)
  @if(session()->has($msg))
    <div class="flash-message" >
      <p class="alert alert-{{ $msg }}" >
        {{ session()->get($msg) }}
      </p>
    </div>
  @endif
@endforeach
