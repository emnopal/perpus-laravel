<ul class="nav" style="position: fixed">
    <li class="nav-item nav-profile">
        <div class="nav-link">
            <div class="user-wrapper">
                <div class="profile-image">
                    @if(Auth::user()->avatar == '')
                        <img src="{{asset('images/user/default.png')}}" alt="profile image">
                    @else
                        <img src="{{asset('images/user/'. Auth::user()->avatar)}}" alt="profile image">
                    @endif
                </div>
                <div class="text-wrapper">
                    <p class="profile-name"><a href="user/{{ Auth::user()->id }}" style="text-decoration: none; color: #2d3748">{{Auth::user()->name}}</a></p>
                    <div>
                        <small class="designation text-muted"
                               style="text-transform: uppercase;letter-spacing: 1px;">{{ Auth::user()->role }}</small>
                        <span class="status-indicator online"></span>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item {{ \App\Helper\Helper::setActive(['/', 'home']) }}">
        <a class="nav-link" href="{{url('/')}}">
            <i class="menu-icon mdi mdi-television"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->role == 'admin')
        <li class="nav-item {{ \App\Helper\Helper::setActive(['anggota*', 'buku*', 'user*']) }}">
            <a class="nav-link " data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-content-copy"></i>
                <span class="menu-title">Master Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ \App\Helper\Helper::setActive(['anggota*', 'buku*', 'user*']) }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ \App\Helper\Helper::setActive(['anggota*']) }}"
                           href="{{route('anggota.index')}}">Data
                            Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ \App\Helper\Helper::setActive(['buku*']) }}"
                           href="{{route('buku.index')}}">Data Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ \App\Helper\Helper::setActive(['user*']) }}"
                           href="{{route('user.index')}}">Data User</a>
                    </li>
                </ul>
            </div>
        </li>
    @endif

    <li class="nav-item {{ \App\Helper\Helper::setActive(['transaksi*']) }}">
        <a class="nav-link" href="{{route('transaksi.index')}}">
            <i class="menu-icon mdi mdi-backup-restore"></i>
            <span class="menu-title">Transaksi</span>
        </a>
    </li>

    <li class="nav-item {{ \App\Helper\Helper::setActive(['laporan*']) }}">
        <a class="nav-link" href="{{route('laporan_cetak')}}">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan</span>
        </a>
    </li>

</ul>
