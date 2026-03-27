<div id="snackbar" class="alert text-white d-none {{ (\Session::has('danger') ? 'bg-danger' : 'bg-success') }}" role="alert" 
  style="position:absolute;top:5%;right:25;z-index:2000;">
    <div id="snackbar_message" class="iq-alert-text">
      @if (\Session::has('danger'))
      {{ trim(\Session::get('danger')) }}
      @elseif(\Session::has('success'))
      {{ trim(\Session::get('success')) }}
      @endif          
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ri-close-line"></i></button>
</div>