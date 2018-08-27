@foreach($items as $item)
<?php 

#echo '<pre>'; print_r($item); exit();

?>
@if(isset($item->attributes['class']) and $item->attributes['class'] != 'dropdown-item'and $item->attributes['class'] != 'active')
  <li@lm-attrs($item) @if($item->hasChildren())class ="nav-item dropdown"@endif @lm-endattrs>
@endif
    @if($item->link) <a@lm-attrs($item->link) @if($item->hasChildren()) class="nav-link dropdown-toggle" data-toggle="dropdown" @endif @lm-endattrs href="{!! $item->url() !!}">
      {!! $item->title !!}
    </a>
    @else
      {!! $item->title !!}
    @endif
    @if($item->hasChildren())
      <div class="dropdown-menu">
        @include(config('laravel-menu.views.bootstrap-items'), 
array('items' => $item->children()))
      </div> 
    @endif
@if(isset($item->attributes['class']) and $item->attributes['class'] != 'dropdown-item'and $item->attributes['class'] != 'active')
  </li>
@endif
  @if($item->divider)
  	<li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
  @endif
@endforeach
