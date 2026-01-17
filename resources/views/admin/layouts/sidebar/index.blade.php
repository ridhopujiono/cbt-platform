<nav class="pcoded-navbar menu-light">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">

            <ul class="nav pcoded-inner-navbar">

                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">Ujian</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('admin/questions')}}">Bank Soal</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.subjects.index') }}">Materi</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.exam-events.index') }}">Event Ujian</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.exam-schedules.index') }}">Jadwal Ujian</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.exam-results.index') }}">Hasil Ujian</a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>
