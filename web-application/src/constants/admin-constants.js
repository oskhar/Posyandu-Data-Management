export const ADMIN_ROLES = {
  PENANGGUNG_JAWAB: { id_jabatan: 1, nama_jabatan: "PENANGGUNG JAWAB" },
  KETUA: { id_jabatan: 2, nama_jabatan: "KETUA" },
  SEKRETARIS: { id_jabatan: 3, nama_jabatan: "SEKRETARIS" },
  BENDAHARA: { id_jabatan: 4, nama_jabatan: "BENDAHARA" },
  PENDAFTARAN: { id_jabatan: 5, nama_jabatan: "PENDAFTARAN" },
  PENIMBANGAN: { id_jabatan: 6, nama_jabatan: "PENIMBANGAN" },
  PENCATATAN: { id_jabatan: 7, nama_jabatan: "PENCATATAN" },
  PENYULUHAN: { id_jabatan: 8, nama_jabatan: "PENYULUHAN" },
  KERJASAMA_KADER: { id_jabatan: 9, nama_jabatan: "KERJASAMA KADER" },
  PENJUAL: { id_jabatan: 10, nama_jabatan: "PENJUAL" },
}

export const ADMIN_DASHBOARD_MENU = [
  {
    id_jabatan: ADMIN_ROLES.PENANGGUNG_JAWAB.id_jabatan,
    nama_jabatan: ADMIN_ROLES.PENANGGUNG_JAWAB.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        icon: "bx-data", 
        childrens: [
          { text: "Data Admin", route: "/admin/data/admin", icon: "bx-user" },
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "SiBinggo", route: "/admin/layanan/si-binggo", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.KETUA.id_jabatan,
    nama_jabatan: ADMIN_ROLES.KETUA.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        icon: "bx-data", 
        childrens: [
          { text: "Data Admin", route: "/admin/data/admin", icon: "bx-user" },
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "SiBinggo", route: "/admin/layanan/si-binggo", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.SEKRETARIS.id_jabatan,
    nama_jabatan: ADMIN_ROLES.SEKRETARIS.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        icon: "bx-data", 
        childrens: [
          { text: "Data Admin", route: "/admin/data/admin", icon: "bx-user" },
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "SiBinggo", route: "/admin/layanan/si-binggo", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.BENDAHARA.id_jabatan,
    nama_jabatan: ADMIN_ROLES.BENDAHARA.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        icon: "bx-data", 
        childrens: [
          { text: "Data Admin", route: "/admin/data/admin", icon: "bx-user" },
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "SiBinggo", route: "/admin/layanan/si-binggo", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.PENDAFTARAN.id_jabatan,
    nama_jabatan: ADMIN_ROLES.PENDAFTARAN.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        icon: "bx-data", 
        childrens: [
          { text: "Data Admin", route: "/admin/data/admin", icon: "bx-user" },
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.PENIMBANGAN.id_jabatan,
    nama_jabatan: ADMIN_ROLES.PENIMBANGAN.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        childrens: "bx-data", 
        childrens: [
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.PENCATATAN.id_jabatan,
    nama_jabatan: ADMIN_ROLES.PENCATATAN.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        childrens: "bx-data", 
        childrens: [
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },  
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.PENYULUHAN.id_jabatan,
    nama_jabatan: ADMIN_ROLES.PENYULUHAN.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      { text: "Events", route: "/admin/events", icon: "bx-news" },
      { text: "Edukasi", route: "/admin/edukasi", icon: "bx-book" },
      { text: "Galeri", route: "/admin/galeri", icon: "bx-image" },
      { 
        text: "Master Data", 
        childrens: "bx-data", 
        childrens: [
          { text: "Data Bayi", route: "/admin/data/format-1", icon: "bx-child" },
          { text: "WUS & PUS", route: "/admin/data/format-3", icon: "bx-book" },
          { text: "Ibu Hamil", route: "/admin/data/format-4", icon: "bx-book" },
        ],
       },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
          { text: "Resleting", route: "/admin/layanan/resleting", icon: "bx-book" },
          { text: "Screening Balita", route: "/admin/data/format-2", icon: "bx-book" },
        ],
      },
      { text: "Tentang", route: "/admin/tentang", icon: "bx-info-circle" },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.KERJASAMA_KADER.id_jabatan,
    nama_jabatan: ADMIN_ROLES.KERJASAMA_KADER.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "Kader Gendong", route: "/admin/layanan/kader-gendong", icon: "bx-book" },
        ],
      },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
  {
    id_jabatan: ADMIN_ROLES.PENJUAL.id_jabatan,
    nama_jabatan: ADMIN_ROLES.PENJUAL.nama_jabatan,
    menu: [
      { text: "Dashboard", route: "/admin/dashboard", icon: "bx-home" },
      {
        text: "Layanan",
        icon: "bx-image",
        childrens: [
          { text: "SiBinggo", route: "/admin/layanan/si-binggo", icon: "bx-book" },
        ],
      },
      { text: "Pengaturan Akun", route: "/admin/account-settings", icon: "bx-user" },
    ],
  },
]