@props(['menus' => [], 'vertical' => false])

<ul class="menu-sub">
    @foreach ($menus as $submenu)         
        {{-- active menu method --}}
        @php
            $activeClass = null;
            $active = 'active open';
            $currentRouteName = Route::currentRouteName();
            $slug = $menu['slug'] ?? app('router')->getRoutes()->match(app('request')->create($submenu['url'] ?? '#'))->getName();
            
            if ($currentRouteName === $slug) {
                $activeClass = 'active';
            }
            elseif (isset($submenu->submenu)) {
                if (gettype($slug) === 'array') {
                    foreach($slug as $slug){
                        if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                            $activeClass = $active;
                        }
                    }
                }
                else{
                    if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                        $activeClass = $active;
                    }
                } 
            }
        @endphp

        <li class="menu-item {{$activeClass}}">
            <a href="{{ $submenu['url'] ?? 'javascript:void(0)' }}" class="{{ isset($submenu['submenus']) ? 'menu-link menu-toggle' : 'menu-link' }}" 
                @if (isset($submenu['target']) and !empty($submenu['target'])) target="_blank" @endif
            > 
                @if (!$vertical && isset($submenu['icon']))
                    <i class="menu-icon tf-icons bx {{ $submenu['icon'] }}"></i>
                @endif

                <div>{{ isset($submenu['name']) ? __($submenu['name']) : '' }}</div>
            </a>

            {{-- submenu --}} 
            @isset($submenu['submenus']) 
                <x-menu.submenu :menus="$submenu['submenus']" :vertical="$vertical" />
            @endisset
        </li>
    @endforeach 
</ul>
