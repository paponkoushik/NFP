<div id="app" v-clock class="container-xxl flex-grow-1 container-p-y">
    <flash message="{{ session('flash_message') }}"
        level="{{ session('flash_message_level') }}"
        important="{{ session('flash_important') }}"
    ></flash>
    
    {{ $slot }}
</div>