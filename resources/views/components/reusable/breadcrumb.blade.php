<div class="col-lg-12">
  <div class="navbar-breadcrumb">
      <nav aria-label="breadcrumb">          
          <ul class="breadcrumb">
            @foreach ($list as $item)
              @if($loop->first)
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ $item['title'] }}</a></li>        
              @else
                <li class="breadcrumb-item">{{ $item['title'] }}</li>
              @endif
            @endforeach
          </ul>
      </nav>
  </div>
</div>