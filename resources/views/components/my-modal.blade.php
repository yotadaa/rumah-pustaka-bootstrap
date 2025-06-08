<div class="position-fixed d-flex left-0 top-0 w-100 h-100 align-items-start justify-content-center"
    style="
        overflow-y: auto;
        position: fixed;
        z-index: 99999999;
        width: 100%;
        height: 100vh;
        top: 0;
        left: 0;
        opacity: {{ $attributes['modal'] != null ? '1' : '0' }};
        visibility: {{ $attributes['modal'] != null ? 'visible' : 'hidden' }};
        transition: opacity 0.3s ease, visibility 0.3s ease;
     ">
    <div class="position-absolute"
        style="left: 0; top: 0; width: 100%; height: 100%; min-height: 100vh; background-color: rgba(0,0,0,.3);"
        wire:click='toggleModal("none", true)'></div>
    <div class="border shadow rounded p-4 bg-light"
        style="
            max-width: 500px;
            width: 100%;
            margin-top: 30px;
            transform: {{ $attributes['modal'] != null ? 'translateY(0)' : 'translateY(-20px)' }};
            transition: transform 0.3s ease;
         ">
        {{ $slot }}
    </div>
</div>
