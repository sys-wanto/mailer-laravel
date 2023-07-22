<ul class="nav">
    <li class="nav-item nav-profile">
        <div class="nav-link">
            <div class="user-wrapper">
                <div class="profile-image">
                    @if(Auth::user()->gambar == '')

                    <img src="{{asset('images/user/default.png')}}" alt="profile image">
                    @else

                    <img src="{{asset('images/user/'. Auth::user()->gambar)}}" alt="profile image">
                    @endif
                </div>
                <div class="text-wrapper">
                    <p class="profile-name">{{Auth::user()->name}}</p>
                    <div>
                        <small class="designation text-muted"
                            style="text-transform: uppercase;letter-spacing: 1px;">{{ Auth::user()->level }}</small>
                        <span class="status-indicator online"></span>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item {{ setActive(['/', 'home']) }}">
        <a class="nav-link" href="{{url('/home')}}">
            <i class="menu-icon mdi mdi-television"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->level == 'admin_user')
    <li class="nav-item {{ setActive(['user*', 'seksi*', 'pegawai*']) }}">
        <a class="nav-link " data-toggle="collapse" href="#ui-user" aria-expanded="false" aria-controls="ui-user">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Data User</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ setShow(['user*', 'seksi*']) }}" id="ui-user">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['user*']) }}" href="{{route('user.index')}}">Data User</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['seksi*']) }}" href="{{route('seksi.index')}}">Data Seksi</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['pegawai*']) }}" href="{{route('pegawai.index')}}">Data Pegawai</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan_user" aria-expanded="false"
            aria-controls="ui-laporan_user">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan PDF</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan_user">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_user/user')}}">Laporan User</a>
                </li>
            </ul>
        </div>
    </li>
    @endif
    @if(Auth::user()->level == 'admin_data')
    <li class="nav-item {{ setActive(['data_utama*', 'jenis_data*', 'tahun_data*', 'input_data*']) }}">
        <a class="nav-link " data-toggle="collapse" href="#ui-data" aria-expanded="false" aria-controls="ui-data">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Data Sekjen</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ setShow(['data_utama*', 'jenis_data*', 'tahun_data*', 'input_data*', 'laporan_data*']) }}"
            id="ui-data">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['tahun_data*']) }}" href="{{route('tahun_data.index')}}">Tahun
                        Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['data_utama*']) }}" href="{{route('data_utama.index')}}">Data
                        Utama</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['jenis_data*']) }}" href="{{route('jenis_data.index')}}">Jenis
                        Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ setActive(['input_data*']) }}" href="{{route('input_data.index')}}">Input
                        Data</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan_data" aria-expanded="false"
            aria-controls="ui-laporan_data">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan PDF</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan_data">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_data/data')}}">Laporan Data</a>
                </li>
            </ul>
        </div>
    </li>
    @endif
    @if(Auth::user()->level == 'admin_arsip')
    <li class="nav-item {{ setActive(['klasifikasi_surat']) }}">
        <a class="nav-link" href="{{url('/klasifikasi_surat')}}">
            <i class="menu-icon mdi mdi-notebook"></i>
            <span class="menu-title">Klasifikasi Surat</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['surat_masuk']) }}">
        <a class="nav-link" href="{{url('/surat_masuk')}}">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Surat Masuk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-surat" aria-expanded="false" aria-controls="ui-surat">
            <i class="menu-icon mdi mdi-folder"></i>
            <span class="menu-title">Surat Keluar</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-surat">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_keluar')}}">Surat Keluar</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('nota_dinas')}}">Nota Dinas</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_tugas')}}">Surat Tugas</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item {{ setActive(['generate_nomor_surat']) }}">
        <a class="nav-link" href="{{url('/generate_nomor_surat')}}">
            <i class="menu-icon mdi mdi-key"></i>
            <span class="menu-title">Generate Nomor Surat</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan Surat</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_surat/surat')}}">Laporan Surat</a>
                </li>
            </ul>
        </div>
    </li>
    @endif
    @if(Auth::user()->level == 'kepala_kantor')
    <li class="nav-item {{ setActive(['klasifikasi_surat_kepala_kantor']) }}">
        <a class="nav-link" href="{{url('/klasifikasi_surat_kepala_kantor')}}">
            <i class="menu-icon mdi mdi-notebook"></i>
            <span class="menu-title">Klasifikasi Surat</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['surat_masuk_kepala_kantor']) }}">
        <a class="nav-link" href="{{url('/surat_masuk_kepala_kantor')}}">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Surat Masuk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-disposisi" aria-expanded="false"
            aria-controls="ui-disposisi">
            <i class="menu-icon mdi mdi-book-open"></i>
            <span class="menu-title">Disposisi</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-disposisi">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.index')}}">Input Disposisi</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.done')}}">Done Disposisi</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-surat" aria-expanded="false" aria-controls="ui-surat">
            <i class="menu-icon mdi mdi-folder"></i>
            <span class="menu-title">Surat Keluar</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-surat">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_keluar_kepala_kantor')}}">Surat Keluar</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('nota_dinas_kepala_kantor')}}">Nota Dinas</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_tugas_kepala_kantor')}}">Surat Tugas</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-setujui" aria-expanded="false"
            aria-controls="ui-setujui">
            <i class="menu-icon mdi mdi-note"></i>
            <span class="menu-title">Persetujuan</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-setujui">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('persetujuan.index')}}">Input Setujui</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('persetujuan.done')}}">Done Setujui</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan Surat</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_surat/surat')}}">Laporan Surat</a>
                </li>
            </ul>
        </div>
    </li>
    @endif

    @if(Auth::user()->level == 'kepala_tu')
    <li class="nav-item {{ setActive(['klasifikasi_surat_kepala_seksi']) }}">
        <a class="nav-link" href="{{url('/klasifikasi_surat_kepala_seksi')}}">
            <i class="menu-icon mdi mdi-notebook"></i>
            <span class="menu-title">Klasifikasi Surat</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['surat_masuk_kepala_tu']) }}">
        <a class="nav-link" href="{{url('/surat_masuk_kepala_tu')}}">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Surat Masuk</span>
        </a>
    </li>  
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-disposisi" aria-expanded="false"
            aria-controls="ui-disposisi">
            <i class="menu-icon mdi mdi-book-open"></i>
            <span class="menu-title">Disposisi</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-disposisi">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.index')}}">Input Disposisi</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.done')}}">Done Disposisi</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-surat" aria-expanded="false" aria-controls="ui-surat">
            <i class="menu-icon mdi mdi-folder"></i>
            <span class="menu-title">Surat Keluar</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-surat">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_keluar_kepala_tu')}}">Surat Keluar</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('nota_dinas_kepala_tu')}}">Nota Dinas</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_tugas_kepala_tu')}}">Surat Tugas</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-setujui" aria-expanded="false"
            aria-controls="ui-setujui">
            <i class="menu-icon mdi mdi-note"></i>
            <span class="menu-title">Persetujuan</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-setujui">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('persetujuan.index')}}">Input Setujui</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('persetujuan.done')}}">Done Setujui</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan Surat</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_surat/surat')}}">Laporan Surat</a>
                </li>
            </ul>
        </div>
    </li>
    @endif

    @if(Auth::user()->level == 'kepala_seksi')
    <li class="nav-item {{ setActive(['klasifikasi_surat_kepala_seksi']) }}">
        <a class="nav-link" href="{{url('/klasifikasi_surat_kepala_seksi')}}">
            <i class="menu-icon mdi mdi-notebook"></i>
            <span class="menu-title">Klasifikasi Surat</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['surat_masuk_kepala_seksi']) }}">
        <a class="nav-link" href="{{url('/surat_masuk_kepala_seksi')}}">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Surat Masuk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-disposisi" aria-expanded="false"
            aria-controls="ui-disposisi">
            <i class="menu-icon mdi mdi-book-open"></i>
            <span class="menu-title">Disposisi</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-disposisi">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.index')}}">Input Disposisi</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.done')}}">Done Disposisi</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-surat" aria-expanded="false" aria-controls="ui-surat">
            <i class="menu-icon mdi mdi-folder"></i>
            <span class="menu-title">Surat Keluar</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-surat">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_keluar_kepala_seksi')}}">Surat Keluar</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('nota_dinas_kepala_seksi')}}">Nota Dinas</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_tugas_kepala_seksi')}}">Surat Tugas</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-setujui" aria-expanded="false"
            aria-controls="ui-setujui">
            <i class="menu-icon mdi mdi-note"></i>
            <span class="menu-title">Persetujuan</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-setujui">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('persetujuan.index')}}">Input Setujui</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('persetujuan.done')}}">Done Setujui</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan Surat</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_surat/surat')}}">Laporan Surat</a>
                </li>
            </ul>
        </div>
    </li>
    @endif
    @if(Auth::user()->level == 'staff_tu')
    <li class="nav-item {{ setActive(['klasifikasi_surat_staff_seksi']) }}">
        <a class="nav-link" href="{{url('/klasifikasi_surat_staff_seksi')}}">
            <i class="menu-icon mdi mdi-notebook"></i>
            <span class="menu-title">Klasifikasi Surat</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['surat_masuk_staff_seksi']) }}">
        <a class="nav-link" href="{{url('/surat_masuk_staff_seksi')}}">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Surat Masuk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-disposisi" aria-expanded="false"
            aria-controls="ui-disposisi">
            <i class="menu-icon mdi mdi-book-open"></i>
            <span class="menu-title">Disposisi</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-disposisi">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.index')}}">Input Disposisi</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.done')}}">Done Disposisi</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-surat" aria-expanded="false" aria-controls="ui-surat">
            <i class="menu-icon mdi mdi-folder"></i>
            <span class="menu-title">Surat Keluar</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-surat">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_keluar_staff_seksi')}}">Surat Keluar</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('nota_dinas_staff_seksi')}}">Nota Dinas</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_tugas_staff_seksi')}}">Surat Tugas</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan Surat</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_surat/surat')}}">Laporan Surat</a>
                </li>
            </ul>
        </div>
    </li>
    @endif
    @if(Auth::user()->level == 'staff_seksi')
    <li class="nav-item {{ setActive(['klasifikasi_surat_staff_seksi']) }}">
        <a class="nav-link" href="{{url('/klasifikasi_surat_staff_seksi')}}">
            <i class="menu-icon mdi mdi-notebook"></i>
            <span class="menu-title">Klasifikasi Surat</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['surat_masuk_staff_seksi']) }}">
        <a class="nav-link" href="{{url('/surat_masuk_staff_seksi')}}">
            <i class="menu-icon mdi mdi-content-copy"></i>
            <span class="menu-title">Surat Masuk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-disposisi" aria-expanded="false"
            aria-controls="ui-disposisi">
            <i class="menu-icon mdi mdi-book-open"></i>
            <span class="menu-title">Disposisi</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-disposisi">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.index')}}">Input Disposisi</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('disposisi.done')}}">Done Disposisi</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-surat" aria-expanded="false" aria-controls="ui-surat">
            <i class="menu-icon mdi mdi-folder"></i>
            <span class="menu-title">Surat Keluar</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-surat">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_keluar_staff_seksi')}}">Surat Keluar</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('nota_dinas_staff_seksi')}}">Nota Dinas</a>
                </li>
            </ul>
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('surat_tugas_staff_seksi')}}">Surat Tugas</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-laporan" aria-expanded="false" aria-controls="ui-laporan">
            <i class="menu-icon mdi mdi-table"></i>
            <span class="menu-title">Laporan Surat</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-laporan">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('laporan_surat/surat')}}">Laporan Surat</a>
                </li>
            </ul>
        </div>
    </li>
    @endif
</ul>