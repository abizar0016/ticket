<!DOCTYPE html>
<html lang="en">
@include('components.head.head')

<body>
    @include('components.preloader.preloader')

    
    @include('superAdmin.layouts.header')
    
    <div class="flex flex-col overflow-hidden">
        <div class="flex-1 transition-all duration-300 md:ml-80 py-6" id="mainContentSuperAdmin">
            
            @include('superAdmin.layouts.sidebar')

            @include('superAdmin.layouts.main')
        </div>
    </div>
</body>

</html>
