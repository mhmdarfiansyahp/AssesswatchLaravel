<div class="polman-nav-static-top">
    <div class="float-left">
        {{-- <div id="iconmenu" class="fa fa-bars fa-2x " style="margin-right: 15px; cursor: pointer;" aria-hidden="true" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="menu"></div> --}}
        <a>
            <img src="{{asset('assets/image/palingbaru_logo.png') }}" style="height: 50px;" />
        </a>
    </div>

    <div class="polman-menu">
        <div style="padding-top: 15px; margin-right: -30px;">
            @if (session()->has('logged_in'))
                @php
                    $logged_in = session('logged_in'); 
                @endphp
                <a class="d-block"><b>Hai,</b>&nbsp;{{$logged_in->nama}}</a>
            @endif
        </div>
    </div>

    <div class="polman-menu-bar">
        <div class="float-right">
            <div class="fa fa-bars fa-2x" style="margin-top: 9px; cursor: pointer;" aria-hidden="true" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="menu"></div>
        </div>
    </div>
</div>

<div class="polman-nav-static-right collapse scrollstyle" id="menu">
    <div id="accordions" role="tablist" aria-multiselectable="true">
        <div class="list-group">
            <!-- <a class="list-group-item list-group-item-action polman-username" style="border-radius: 0px; border: none; background-color: #EEE;">
                Hai,&nbsp;<b></b>
            </a> -->

            <a href='{{ route ('login.logout') }}' class="list-group-item list-group-item-action" style="border-radius: 0px; border: none; padding-left: 23px;">
                <i class="fa fa-sign-out fa-lg fa-pull-left"></i>Logout
            </a>

            <a href='{{ route ('Dashboard.index') }}' class='list-group-item list-group-item-action' 
                style='border-radius: 0px; border: none; padding-left: 22px; display: inherit;'>
                <i class='fa fa-home fa-lg fa-pull-left'></i>Dashboard
            </a>

            @if(session()->has('logged_in') && session('logged_in')->role === 'SuperAdmin')                                       
                
                    <a href='{{ route ('pengguna.index') }}' class='list-group-item list-group-item-action' 
                        style='border-radius: 0px; border: none; padding-left: 22px; display: inherit;'>
                        <i class='fa fa-user fa-lg fa-pull-left'></i>Pengguna
                    </a>    
                
            @endif                    
            

            <a href='{{ route('prodi.index') }}' class='list-group-item list-group-item-action'
                style='border-radius: 0px; border: none; padding-left: 22px; display: inherit;'>
            
                <i class='fa fa-university fa-lg fa-pull-left'></i>Program Studi
            </a>
            
            <a href='{{ route('sertifikasi.index') }}' class='list-group-item list-group-item-action'
                style='border-radius: 0px; border: none; padding-left: 22px; display: inherit;'>
                <i class='fa fa-check-circle fa-lg fa-pull-left'></i>Sertifikasi
            </a>

        </div>
    </div>
</div>