@props(['item'])
<div class="row">
  <div class="col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">              
	              @foreach($item as $key => $value)
		              @if( $key === count($item) -1 )
		          		<li class="breadcrumb-item active" aria-current="page">{{ $value['item'] }}</li>
		          		@else
		          		<li class="breadcrumb-item">
		              	<a href="{{ isset($value['url']) ? $value['url'] : url('/') }}">
		              		{{ $value['item']}}
		              	</a>
		              </li>	
		              @endif	              
	              @endforeach
              </ul>
          </nav>
      </div>
  </div>
</div>