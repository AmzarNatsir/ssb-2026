@if ($message = Session::get('success'))
  <div class="alert text-white bg-success" role="alert">
    <div class="iq-alert-text">
      {{ $message }}
    </div>
    <button type="button" class="close" data-dismiss="alert"><i class="ri-close-line"></i></button>
  </div>
@endif

@if ($message = Session::get('error'))
  <div class="alert text-white bg-danger" role="alert">
    <div class="iq-alert-text">
      @if(is_array($message))
        <ul>
          @forelse($message as $msg)
            <li>{{ $msg }}</li>
          @empty
          @endforelse
        </ul>
      @else
        {{ $message }}
      @endif
    </div>
    <button type="button" class="close" data-dismiss="alert"><i class="ri-close-line"></i></button>
  </div>
@endif

@if ($message = Session::get('warning'))
  <div class="alert text-white bg-warning" role="alert">
    <div class="iq-alert-text">
      {{ $message }}
    </div>
    <button type="button" class="close" data-dismiss="alert"><i class="ri-close-line"></i></button>
  </div>
@endif

@if ($message = Session::get('info'))
  <div class="alert text-white bg-info" role="alert">
    <div class="iq-alert-text">
      {{ $message }}
    </div>
    <button type="button" class="close" data-dismiss="alert"><i class="ri-close-line"></i></button>
  </div>
@endif
