
  <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <!-- <h3>General</h3> -->
        <ul class="nav side-menu">          
          @if(count($items)>0)
            @foreach($items as $item)
               <li class="{{ Request::is($item['common_route']) ? 'active' : ''}}">
                  <a href="{{ ($item['options']['action'] != '#')? action($item['options']['action']) : '#' }}">
                      <i class="{{ $item['icon'] }}"></i>
                      <span class="nav-label">{{ $item['title'] }} </span>
                      @if(isset($item['childrens']) && count($item['childrens'])>0)
                          <span class="fa fa-chevron-down"></span>
                      @endif
                  </a>
                  @if(isset($item['childrens']) && count($item['childrens'])>0)
                      <ul class="nav child_menu">
                          @foreach($item['childrens'] as $childitem)                             
                                  <li class="{{ Request::is($childitem['common_route']) ? 'active' : ''}}">
                                      <a href="{{ ($childitem['options']['action'] != '#')? action($childitem['options']['action']) : '#' }}">
                                          <i class="{{ $childitem['icon'] }}"></i>
                                           {{ $childitem['title'] }}
                                      </a>
                                  </li>

                                  @if($item['title'] == 'Settings')
                                      <li class="{{ Request::is('users.show') ? 'active' : ''}}">
                                          <a href="{{ url('admin/users/'.Auth::user()->id) }}">
                                              <i class="fa fa-lg fa-user"></i>
                                              <span class="nav-label">Profile </span>
                                          </a>
                                      </li>
                                  @endif
                          @endforeach
                      </ul>
                  @endif
              </li>
            @endforeach
          @endif
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->