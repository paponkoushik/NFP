@props([
    'menus' => [],
    'icon' => 'bx-folder-open',
    'role' => '*',
    'vertical' => false,
])

@foreach ($menus as $menu) 
    {{-- adding active and open class if child is active --}} {{-- menu headers --}} 
    @if (isset($menu['menuHeader']))
        @if($vertical)
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">{{ $menu['menuHeader'] }}</span>
            </li>
        @endif
    @else 
        {{-- active menu method --}} 
        @php 
            $activeClass = null; 
            $active = 'active open';
            $currentRouteName = Route::currentRouteName();
            $slug = $menu['slug'] ?? app('router')->getRoutes()->match(app('request')->create($menu['url'] ?? '#'))->getName();
            if ($currentRouteName === $slug) { 
                $activeClass = 'active'; 
            } elseif (isset($menu['submenus'])) { 
                if (gettype($slug) === 'array') { 
                    foreach($slug as $slug){ 
                        if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) { 
                            $activeClass = $active; 
                        } 
                    } 
                } else{
                    if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) { 
                        $activeClass = $active; 
                    } 
                } 
            }
        @endphp 

        {{-- main menu --}}
        <li class="menu-item {{ $activeClass }}">
            <a href="{{ $menu['url'] ?? 'javascript:void(0);' }}" class="{{ isset($menu['submenus']) ? 'menu-link menu-toggle' : 'menu-link' }}" 
                @if (isset($menu['target']) and !empty($menu['target'])) target="_blank" @endif
            > 
                @isset($menu['icon'])
                    <i class="menu-icon tf-icons bx {{ $menu['icon'] }}"></i>
                @endisset

                <div>{{ isset($menu['name']) ? __($menu['name']) : '' }}</div>
            </a>

            {{-- submenu --}} 
            @isset($menu['submenus']) 
                <x-menu.submenu :menus="$menu['submenus']" :vertical="$vertical" />
            @endisset
        </li>
    @endif 
@endforeach



