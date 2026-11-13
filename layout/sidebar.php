<?php
$current_page = basename($_SERVER['PHP_SELF']);

if ($_SESSION['role'] === "admin") {
?>

    <!-- SIDEBAR ADMIN -->
    <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3 no-print">

        <h4 class="text-white mb-4">
            Pelanggaran Siswa
        </h4>

        <ul class="nav nav-pills flex-column">

            <li class="nav-item mb-2">
                <a href="dashboard.php"
                   class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : 'text-white' ?>">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_siswa.php"
                   class="nav-link <?= in_array($current_page, ['kelola_siswa.php','edit_siswa.php','tambah_siswa.php','hapus_siswa.php']) ? 'active' : 'text-white' ?>">
                    Data Siswa
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_guru.php"
                   class="nav-link <?= in_array($current_page, ['kelola_guru.php','edit_guru.php','tambah_guru.php','hapus_guru.php']) ? 'active' : 'text-white' ?>">
                    Data Guru
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_kelas.php"
                   class="nav-link <?= in_array($current_page, ['kelola_kelas.php','edit_kelas.php','tambah_kelas.php','hapus_kelas.php']) ? 'active' : 'text-white' ?>">
                    Data Kelas
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_tahun_ajaran.php"
                   class="nav-link <?= in_array($current_page, ['kelola_tahun_ajaran.php','edit_tahun_ajaran.php','tambah_tahun_ajaran.php','hapus_tahun_ajaran.php']) ? 'active' : 'text-white' ?>">
                    Data Tahun Ajaran
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_wali_kelas.php"
                   class="nav-link <?= in_array($current_page, ['kelola_wali_kelas.php','edit_wali_kelas.php','tambah_wali_kelas.php','hapus_wali_kelas.php']) ? 'active' : 'text-white' ?>">
                    Data Wali Kelas
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="penempatan_siswa.php"
                   class="nav-link <?= ($current_page == 'penempatan_siswa.php') ? 'active' : 'text-white' ?>">
                    Penempatan Siswa
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_pelanggaran_kategori.php"
                   class="nav-link <?= in_array($current_page, ['kelola_pelanggaran_kategori.php','edit_pelanggaran_kategori.php','tambah_pelanggaran_kategori.php','hapus_pelanggaran_kategori.php']) ? 'active' : 'text-white' ?>">
                    Kategori Pelanggaran
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="kelola_jenis_pelanggaran.php"
                   class="nav-link <?= in_array($current_page, ['kelola_jenis_pelanggaran.php','edit_jenis_pelanggaran.php','tambah_jenis_pelanggaran.php','hapus_jenis_pelanggaran.php']) ? 'active' : 'text-white' ?>">
                    Jenis Pelanggaran
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="laporan.php"
                   class="nav-link <?= ($current_page == 'laporan.php') ? 'active' : 'text-white' ?>">
                    Laporan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="about_me.php"
                   class="nav-link <?= ($current_page == 'about_me.php') ? 'active' : 'text-white' ?>">
                    About Me
                </a>
            </li>

            <hr class="text-secondary">

            <li class="nav-item">
                <a href="logout.php" class="nav-link text-danger">
                    Logout
                </a>
            </li>

        </ul>
    </div>

<?php
} elseif ($_SESSION['role'] === "guru") {
?>

    <!-- SIDEBAR GURU -->
    <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3 no-print">

        <h4 class="text-white mb-4">
            Pelanggaran Siswa
        </h4>

        <ul class="nav nav-pills flex-column">

            <li class="nav-item mb-2">
                <a href="dashboard.php"
                   class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : 'text-white' ?>">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="catat_pelanggaran.php"
                   class="nav-link <?= in_array($current_page, ['catat_pelanggaran.php','edit_catat_pelanggaran.php']) ? 'active' : 'text-white' ?>">
                    Catat Pelanggaran
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="tindakan.php"
                   class="nav-link <?= ($current_page == 'tindakan.php') ? 'active' : 'text-white' ?>">
                    Tindakan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="riwayat.php"
                   class="nav-link <?= ($current_page == 'riwayat.php') ? 'active' : 'text-white' ?>">
                    Riwayat
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="rekap_poin.php"
                   class="nav-link <?= ($current_page == 'rekap_poin.php') ? 'active' : 'text-white' ?>">
                    Rekap Poin
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="laporan.php"
                   class="nav-link <?= ($current_page == 'laporan.php') ? 'active' : 'text-white' ?>">
                    Laporan
                </a>
            </li>

            <hr class="text-secondary">

            <li class="nav-item">
                <a href="logout.php" class="nav-link text-danger">
                    Logout
                </a>
            </li>

        </ul>
    </div>

<?php
}
?>