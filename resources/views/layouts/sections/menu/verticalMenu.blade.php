<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">clinic</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)
    {{-- adding active and open class if child is active --}}
    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">{{ $menu->menuHeader }}</span>
    </li>

    @else

    {{-- active menu method --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    }
    elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    else{
    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }

    }
    @endphp
   @can('user-list')
   @if($menu->name==="users") 
  
    {{-- main menu --}}
    <li class="menu-item {{$activeClass}}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
      </a>

      {{-- submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
      @endisset
    </li>
    @endif
    @endcan

    @can('role-list')
    @if($menu->name==="permissions") 
   
     {{-- main menu --}}
     <li class="menu-item {{$activeClass}}">
       <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
         @isset($menu->icon)
         <i class="{{ $menu->icon }}"></i>
         @endisset
         <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
       </a>
 
       {{-- submenu --}}
       @isset($menu->submenu)
       @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
       @endisset
     </li>
     @endif
     @endcan

     @canany(['area-list','insurance-list','service-list','addition-list'])
     @if($menu->name==="settings") 
    
      {{-- main menu --}}
      <li class="menu-item {{$activeClass}}">
        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
          @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
          @endisset
          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        </a>
  
        {{-- submenu --}}
        @isset($menu->submenu)
        @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
        @endisset
      </li>
      @endif
      @endcanany

      @can('expense-list')
      @if($menu->name==="expenses") 
     
       {{-- main menu --}}
       <li class="menu-item {{$activeClass}}">
         <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
           @isset($menu->icon)
           <i class="{{ $menu->icon }}"></i>
           @endisset
           <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
         </a>
   
         {{-- submenu --}}
         @isset($menu->submenu)
         @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
         @endisset
       </li>
       @endif
       @endcan

       @canany(['lab-list','labrequest-list'])
       @if($menu->name==="labs") 
      
        {{-- main menu --}}
        <li class="menu-item {{$activeClass}}">
          <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
            @isset($menu->icon)
            <i class="{{ $menu->icon }}"></i>
            @endisset
            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
          </a>
    
          {{-- submenu --}}
          @isset($menu->submenu)
          @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
          @endisset
        </li>
        @endif
        @endcan

        @can('medicine-list')
        @if($menu->name==="medicine") 
       
         {{-- main menu --}}
         <li class="menu-item {{$activeClass}}">
           <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
             @isset($menu->icon)
             <i class="{{ $menu->icon }}"></i>
             @endisset
             <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
           </a>
     
           {{-- submenu --}}
           @isset($menu->submenu)
           @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
           @endisset
         </li>
         @endif
         @endcan

         @can('todayvisit-list')
         @if($menu->name==="today visits") 
        
          {{-- main menu --}}
          <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
              <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
            </a>
      
            {{-- submenu --}}
            @isset($menu->submenu)
            @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
          </li>
          @endif
          @endcan

          @canany(['medicine-reports','expense-reports','appointment-reports','payment-reports'])
          @if($menu->name==="Reports") 
         
           {{-- main menu --}}
           <li class="menu-item {{$activeClass}}">
             <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
               @isset($menu->icon)
               <i class="{{ $menu->icon }}"></i>
               @endisset
               <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
             </a>
       
             {{-- submenu --}}
             @isset($menu->submenu)
             @include('layouts.sections.menu.submenu',['menu' =>$menu->submenu])
             @endisset
           </li>
           @endif
           @endcanany

           @can('paymenttransaction-list')
           @if($menu->name==="payment transactions") 
          
            {{-- main menu --}}
            <li class="menu-item {{$activeClass}}">
              <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
                @endisset
                <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
              </a>
        
              {{-- submenu --}}
              @isset($menu->submenu)
              @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
              @endisset
            </li>
            @endif
            @endcan
        
     @can('patient-list')
    @if($menu->name==="patients") 
   
     {{-- main menu --}}
     <li class="menu-item {{$activeClass}}">
       <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
         @isset($menu->icon)
         <i class="{{ $menu->icon }}"></i>
         @endisset
         <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
       </a>
 
       {{-- submenu --}}
       @isset($menu->submenu)
       @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
       @endisset
     </li>
      @endif
     @endcan

     @can('appointment-list')
     @if($menu->name==="appointment") 
    
      {{-- main menu --}}
      <li class="menu-item {{$activeClass}}">
        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
          @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
          @endisset
          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        </a>
  
        {{-- submenu --}}
        @isset($menu->submenu)
        @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
        @endisset
      </li>
       @endif
      @endcan
  

    @endif
    @endforeach
  </ul>

</aside>
