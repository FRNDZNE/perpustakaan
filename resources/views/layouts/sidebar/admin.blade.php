@if (Auth::user()->role->name == 'admin')
    <div id="sidebar-menu">
        <ul id="side-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Dashboard Admin </span>
                </a>
            </li>
            <li class="menu-title">Siswa</li>
            <li>
                <a href="{{ route('index.user') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Daftar Siswa </span>
                </a>
            </li>
            <li class="menu-title">Peminjaman</li>
            <li>
                <a href="{{ route('admin.permintaan.index') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Daftar Permintaan </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pinjaman.index') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Daftar Pinjam </span>
                </a>
            </li>
            <li class="menu-title">Utilitas</li>
            <li>
                <a href="{{ route('index.kategori') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Kategori Buku </span>
                </a>
            </li>
            <li>
                <a href="{{ route('index.buku') }}">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span> Daftar Buku </span>
                </a>
            </li>
        </ul>
    </div>
@endif


