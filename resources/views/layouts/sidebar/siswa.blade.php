@if (Auth::user()->role->name == 'siswa')
    <div id="sidebar-menu">
        <ul id="side-menu">
            <li>
                <a href="{{ route('siswa.dashboard') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Dashboard Siswa </span>
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.loan.index') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Pinjam Buku </span>
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.loan') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Daftar Pinjam </span>
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.loan.history') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> History Pinjam </span>
                </a>
            </li>
        </ul>
    </div>
@endif
