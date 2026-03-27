<?php
return [
    "agama" => [
        "1" => "Islam",
        "2" => "Kristen Katolik",
        "3" => "Kristen Protestan",
        "4" => "Hindu",
        "5" => "Budha",
        "6" => "Kong Hu Cu"
    ],
    "jenjang_pendidikan" => [
        "1" => "TK/Play Group",
        "2" => "Sekolah Dasar (SD)",
        "3" => "Sekolah Menengah Pertama (SMP) / Sederajat",
        "4" => "Sekolah Menengah Atas (SMA) / Sederajat",
        "5" => "Diploma Tiga (D3)",
        "6" => "Strata Satu (S1)",
        "7" => "Strata Dua (S2)",
        "8" => "Strata Tiga (S3)"
    ],
    "status_pernikahan" => [
        "1" => "Menikah",
        "2" => "Belum Menikah",
        "3" => "Duda",
        "4" => "Janda"
    ],
    "hubungan_lbkeluarga" => [
        "1" => "Ayah",
        "2" => "Ibu",
        "3" => "Saudara"
    ],
    "hubungan_keluarga" => [
        "1" => "Suami",
        "2" => "Istri",
        "3" => "Anak"
    ],
    "status_karyawan" => [
        "1" => "Training",
        "2" => "Kontrak",
        "3" => "Tetap",
        "4" => "Resign",
        "5" => "PHK",
        "6" => "Pensiun",
        "7" => "Harian"
    ],
    "kategori_mutasi" => [
        "1" => "Promosi",
        "2" => "Mutasi",
        "3" => "Demosi"
    ],
    "status_pengajuan" => [
        "1" => "Disetujui",
        "2" => "Ditolak"
    ],
    "bulan" => [
        "01" => "Januari",
        "02" => "Februari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember"
    ],
    "project" => [
        "target_tender" => [
            "1" => "antam",
            "2" => "non antam"
        ],
        "jenis" => [
            "1" => "perseorangan",
            "2" => "badan usaha"
        ],
        "status" => [
            [
                "kode" => 1,
                "ketera" => "dalam proses"
            ], [
                "kode" => 2,
                "ketera" => "aktif"
            ], [
                "kode" => 3,
                "ketera" => "closed"
            ]
        ],
        "status_sub" => [
            "1" => "registrasi",
            "2" => "undangan",
            "3" => "analisa"
        ]
    ],
    "preanalyst" => [
        "opsi_rekomendasi" => [
            "1" => "rekomendasi setuju",
            "0" => "rekomendasi tolak"
        ]
    ],
    "alat_berat" => [
        "1" => "wheel loader",
        "2" => "dump truck"
    ],

    "menu" => [
        "hrd" => [
            "dashboard" => [
                "icon" => "ri-pie-chart-box-line",
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => 'route("dashboard")',
                "submenu" => null
            ],
            "master_data" => [
                "icon" => "ri-chat-check-line",
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => 'route("master_data")',
                "submenu" => null
            ],
            "setup" => [
                "icon" => "fa fa-gear",
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false
                ],
                "url" => 'route("setup")',
                "submenu" => null
            ],
            "job_description" => [
                "icon" => "ri-folder-line",
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                ],
                "url" => 'route("jobdesc")',
                "submenu" => null
            ],
            "key_performance_indicator" => [
                "icon" => "ri-key-line",
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                ],
                "url" => 'route("kpi")',
                "submenu" => [
                    "penyusunan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                        ],
                        "url" => 'route("kpi/penyusunan")',
                        "submenu" => null
                    ],
                    "penilaian" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                        ],
                        "url" => 'route("kpi/penilaian")',
                        "submenu" => null
                    ],
                ]
            ],

            "recruitment" => [
                "icon" => "ri-profile-line",
                "permission" => [
                    "view" => false,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                ],
                "url" => null,
                "submenu" => [
                    "permintaan_tenaga_kerja" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                        ],
                        "url" => 'route("permintaan_tenaga_kerja")',
                        "submenu" => null
                    ],
                    "aplikasi_pelamar" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                        ],
                        "url" => 'route("aplikasi_pelamar")',
                        "submenu" => null
                    ],
                    "rekapitulasi_hasil_tes" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                        ],
                        "url" => 'route("rekapitulasi_hasil_tes")',
                        "submenu" => null
                    ]
                ]
            ],
            "karyawan" => [
                "icon" => "ri-profile-line",
                "permission" => [
                    "view" => false,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => null,
                "submenu" => [
                    "karyawan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("karyawan")',
                        "submenu" => null
                    ],
                    "karyawan_bpjs" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("karyawan_bpjs")',
                        "submenu" => null
                    ],
                    "perubahan_status" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("perubahan_status")',
                        "submenu" => null
                    ],
                    "mutasi" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("mutasi")',
                        "submenu" => null
                    ],
                    "cuti_izin" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("cuti_izin")',
                        "submenu" => null
                    ],
                    "perjalanan_dinas" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("perjalanan_dinas")',
                        "submenu" => null
                    ],
                    "surat_peringatan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("surat_peringatan")',
                        "submenu" => null
                    ],
                    "absensi" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("absensi")',
                        "submenu" => null
                    ],
                    "pinjaman_karyawan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("pinjaman_karyawan")',
                        "submenu" => null
                    ],
                    "lembur" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("lembur")',
                        "submenu" => null
                    ],
                    "resign" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("resign")',
                        "submenu" => null
                    ]
                ]

            ],
            "penggajian" => [
                "icon" => "ri-user-line",
                "permission" => [
                    "view" => false
                ],
                "url" => null,
                "submenu" => [
                    "pengaturan_gapok" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("setup_gaji_karyawan")',
                        "submenu" => null
                    ],
                    "pengaturan_bpjs" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("setup_bpjs")',
                        "submenu" => null
                    ],
                    "penggajian" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => 'route("penggajian")',
                        "submenu" => null
                    ],
                    "thr" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => 'route("thr_karyawan")',
                        "submenu" => null
                    ],
                    "pembuatan_slip_gaji" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => 'route("slip_gaji")',
                        "submenu" => null
                    ]
                ]
            ],
            "pengajuan" => [
                "icon" => "ri-user-line",
                "permission" => [
                    "view" => false,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => null,
                "submenu" => [
                    "permintaan_tenaga_kerja" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("permintaan_tenaga_kerja")',
                        "submenu" => null
                    ],
                    "perubahan_status" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("perubahan_status")',
                        "submenu" => null
                    ],
                    "mutasi_rotasi" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("mutasi_rotasi")',
                        "submenu" => null
                    ],
                    "perjalanan_dinas" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("perjalanan_dinas")',
                        "submenu" => null
                    ],
                    "surat_peringatan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("surat_peringatan")',
                        "submenu" => null
                    ]
                ]
            ],
            "pelatihan" =>
            [
                "icon" => "ri-pie-chart-box-lines",
                "permission" => [
                    "view" => false,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => null,
                "submenu" => [
                    "pelatihan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("pelatihan")',
                        "submenu" => null
                    ],
                    "pengajuan" => [
                        "permission" => [
                            "view" => false,
                            "create" => false,
                            "edit" => false,
                            "delete" => false,
                            "print" => false,
                            "approve" => false
                        ],
                        "url" => 'route("pelatihan/pengajuan")',
                        "submenu" => null
                    ],
                ]
            ],
            "persetujuan" => [
                "icon" => "ri-pie-chart-box-line",
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => 'route("persetujuan")',
                "submenu" => null
            ],
            "pelaporan" =>
            [
                "icon" => "ri-pie-chart-box-lines",
                "permission" => [
                    "view" => false,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "url" => null,
                "submenu" => [
                    "karyawan" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => 'route("laporan_karyawan")',
                        "submenu" => null
                    ],
                    "penggajian" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => null,
                        "submenu" => [
                            "penggajian" => [
                                "permission" => [
                                    "view" => false
                                ],
                                "url" => 'route("laporan_gaji")',
                                "submenu" => null
                            ],
                            "bpjs_ketenagakerjaan" => [
                                "permission" => [
                                    "view" => false
                                ],
                                "url" => 'route("laporan_bpjs_tk")',
                                "submenu" => null
                            ],
                            "bpjs_kesehatan" => [
                                "permission" => [
                                    "view" => false
                                ],
                                "url" => 'route("laporan_bpjs_ks")',
                                "submenu" => null
                            ]
                        ]
                    ],
                    "perubahan_status" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => 'route("laporan_perubahan_status")',
                        "submenu" => null
                    ],
                    "mutasi" => [
                        "permission" => [
                            "view" => false
                        ],
                        "url" => 'route("laporan_mutasi")',
                        "submenu" => null
                    ],
                    "cuti_izin" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("laporan_cuti_izin")',
                        "submenu" => null
                    ],
                    "perjalanan_dinas" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("laporan_perdis")',
                        "submenu" => null
                    ],
                    "surat_peringatan" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("laporan_sp")',
                        "submenu" => null
                    ],
                    "absensi" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("laporan_absensi")',
                        "submenu" => null
                    ],
                    "pinjaman_karyawan" => [
                        "permission" => [
                            "view" => false,
                        ],
                        "url" => 'route("laporan_pinjaman_karyawan")',
                        "submenu" => null
                    ]
                ]
            ]
        ],
        "warehouse" => [
            "dashboard" => [
                "icon" => 'ri-home-4-line',
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "submenu" => false,
            ],
            "spare_part" => [
                'submenu' => [
                    "purchasing_request" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "purchasing_comparison" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "purchasing_order" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "receiving" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "return" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "issued" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],

            "bbm" => [
                "submenu" => [
                    "receiving" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],

            "bbm_consumption/issued" => [
                "submenu" => [
                    "fuel_tank" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "fuel_truck" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],

            "master_data" => [
                "submenu" => [
                    "spare_part" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "uom" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "brand" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "supplier" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "kategori" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "fuel_tank" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "fuel_truck" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],

        ],
        "workshop" => [
            "dashboard" => [
                "icon" => 'ri-home-4-line',
                "permission" => [
                    "view" => true,
                    "create" => false,
                    "edit" => false,
                    "delete" => false,
                    "print" => false,
                    "approve" => false
                ],
                "submenu" => false,
            ],
            "operating_sheet" => [
                'icon' => 'ri-home-4-line',
                'permission' => [
                    "view" => true,
                    "create" => true,
                    "edit" => true,
                    "delete" => true,
                    "print" => true,
                    "approve" => false
                ]
            ],
            "work_request" => [
                'icon' => 'ri-home-4-line',
                'permission' => [
                    "view" => true,
                    "create" => true,
                    "edit" => true,
                    "delete" => true,
                    "print" => true,
                    "approve" => true
                ]
            ],
            "work_order" => [
                'icon' => 'ri-home-4-line',
                'permission' => [
                    "view" => true,
                    "create" => true,
                    "edit" => true,
                    "delete" => true,
                    "print" => true,
                    "approve" => true
                ]
            ],
            "tool_management" => [
                "submenu" => [
                    "tool_usage" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "tool_receiving" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],

            "scrap_management" => [
                "submenu" => [
                    "scrap" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],

            "master_data" => [
                "submenu" => [
                    "equipment" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "equipment_category" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "tools" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "tool_category" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                    "setting" => [
                        'icon' => 'ri-home-4-line',
                        'permission' => [
                            "view" => true,
                            "create" => true,
                            "edit" => true,
                            "delete" => true,
                            "print" => true,
                            "approve" => false
                        ]
                    ],
                ]
            ],
        ]
    ]
];

// "master_data" => [
//     "icon" => "ri-chat-check-line",
//     "permission" => [
//         "view" => false,
//         "create" => false,
//         "edit" => false,
//         "delete" => false,
//         "print" => false,
//         "approve" => false
//     ],
//     "url" => null,
//     "submenu" => [
//         "profil_perusahaan" => [
//             "permission" => [
//                 "view" => true,
//                 "create" => true,
//                 "edit" => true,
//                 "delete" => true,
//                 "print" => true,
//                 "approve" => null
//             ],
//             "url" => 'route("profil_perusahaan)',
//             "submenu" => null
//         ],
//         "struktur" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => null,
//             "submenu" => [
//                 "level_jabatan" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("level_jabatan")',
//                     "submenu" => null
//                 ],
//                 "divisi" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("master_divisi")',
//                     "submenu" => false
//                 ],
//                 "departemen" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("departemen")',
//                     "submenu" => null
//                 ],
//                 "sub_departemen" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("sub_departemen")',
//                     "submenu" => false
//                 ],
//                 "jabatan" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("jabatan")',
//                     "submenu" => null
//                 ]
//             ],
//         ],
//         "bank_penggajian" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("bank_penggajian")',
//             "submenu" => null
//         ],
//         "dokumen_karyawan" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("dokumen_karyawan")',
//             "submenu" => null
//         ],
//         "jenis_cuti" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("jenis_cuti")',
//             "submenu" => null
//         ],
//         "perjalanan_dinas" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("perjalanan_dinas")',
//             "submenu" => [
//                 "fasilitas" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("fasilitas")',
//                     "submenu" => null
//                 ],
//                 "uang_saku" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("uangsaku")',
//                     "submenu" => null
//                 ]
//             ]
//         ],
//         "lembaga_pelaksanaan_diklat" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("lembaga_diklat")',
//             'submenu' => null
//         ],
//         "pelatihan" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("pelatihan")',
//             'submenu' => null
//         ],
//         "tingkatan_sp" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("tingkatan_sp")',
//             "submenu" => null
//         ],
//         "jenis_pelanggaran" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("jenisPelanggaran")',
//             "submenu" => null
//         ],
//         "kpi" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => null,
//             "submenu" => [
//                 "perspektif_kpi" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("masterdata/perspektifKPI")',
//                     "submenu" => null
//                 ],
//                 "sasaran_strategi_kpi" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("masterdata/sasaranKPI")',
//                     "submenu" => null
//                 ],
//                 "tipe_kpi" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("masterdata/tipeKPI")',
//                     "submenu" => null
//                 ],
//                 "satuan_kpi" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("masterdata/satuanKPI")',
//                     "submenu" => null
//                 ]
//             ]
//         ],
//     ]
// ],
// "pendataan" => [
//     "icon" => "ri-profile-line",
//     "permission" => [
//         "view" => false,
//         "create" => false,
//         "edit" => false,
//         "delete" => false,
//         "print" => false,
//         "approve" => false
//     ],
//     "url" => null,
//     "submenu" => [
//         "recruitment" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => null,
//             "submenu" => [
//                 "permintaan_tenaga_kerja" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("permintaan_tenaga_kerja")',
//                     "submenu" => null
//                 ],
//                 "aplikasi_pelamar" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("aplikasi_pelamar")',
//                     "submenu" => null
//                 ]
//             ]
//         ],
//         "karyawan" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("karyawan")',
//             "submenu" => null
//         ],
//         "perubahan_status" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("perubahan_status")',
//             "submenu" => null
//         ],
        // "mutasi" => [
        //     "permission" => [
        //         "view" => false,
        //         "create" => false,
        //         "edit" => false,
        //         "delete" => false,
        //         "print" => false,
        //         "approve" => false
        //     ],
        //     "url" => 'route("mutasi")',
        //     "submenu" => null
        // ],
        // "cuti_izin" => [
        //     "permission" => [
        //         "view" => false,
        //         "create" => false,
        //         "edit" => false,
        //         "delete" => false,
        //         "print" => false,
        //         "approve" => false
        //     ],
        //     "url" => 'route("cuti_izin")',
        //     "submenu" => null
        // ],
        // "perjalanan_dinas" => [
        //     "permission" => [
        //         "view" => false,
        //         "create" => false,
        //         "edit" => false,
        //         "delete" => false,
        //         "print" => false,
        //         "approve" => false
        //     ],
        //     "url" => 'route("perjalanan_dinas")',
        //     "submenu" => null
        // ],
        // "surat_peringatan" => [
        //     "permission" => [
        //         "view" => false,
        //         "create" => false,
        //         "edit" => false,
        //         "delete" => false,
        //         "print" => false,
        //         "approve" => false
        //     ],
        //     "url" => 'route("surat_peringatan")',
        //     "submenu" => null
        // ],
        // "pendidikan_dan_pelatihan" => [
        //     "permission" => [
        //         "view" => false,
        //         "create" => false,
        //         "edit" => false,
        //         "delete" => false,
        //         "print" => false,
        //         "approve" => false
        //     ],
        //     "url" => 'route("diklat")',
        //     "submenu" => null
        // ],
        // "absensi" => [
        //     "permission" => [
        //         "view" => false,
        //         "create" => false,
        //         "edit" => false,
        //         "delete" => false,
        //         "print" => false,
        //         "approve" => false
        //     ],
        //     "url" => 'route("absensi")',
        //     "submenu" => null
        // ],
// "setup" => [
//     "icon" => "fa fa-gear",
//     "permission" => [
//         "view" => false,
//         "create" => false,
//         "edit" => false,
//         "delete" => false,
//         "print" => false,
//         "approve" => false
//     ],
//     "url" => null,
//     "submenu" => [
//         "pengaturan_hari_libur" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("setup_hari_libur")',
//             "submenu" => null
//         ],
//         "pengaturan_persetujuan" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("setup_persetujuan")',
//             "submenu" => null
//         ],
//         "manajemen_pengguna" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => null,
//             "submenu" =>
//             [
//                 "manajemen_group" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("manajemen_group")',
//                     "submenu" => null
//                 ],
//                 "manajemen_pengguna" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("manajemen_user")',
//                     "submenu" => null
//                 ]
//             ]
//         ],
//         "memo_internal" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("memo_internal")',
//             "submenu" => null
//         ],
//         "penggajian" =>
//         [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => null,
//             "submenu" => [
//                 "pengaturan_gaji_karyawan" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("setup_gaji_karyawan")',
//                     "submenu" => null
//                 ],
//                 "pengaturan_bpjs" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("setup_bpjs")',
//                     "submenu" => null
//                 ]
//             ]
//         ]
//     ]
// ],
//         "penggajian" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => null,
//             "submenu" => [
//                 "penggajian" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("penggajian")',
//                     "submenu" => null
//                 ],
//                 "pembuatan_slip_gaji" => [
//                     "permission" => [
//                         "view" => false,
//                         "create" => false,
//                         "edit" => false,
//                         "delete" => false,
//                         "print" => false,
//                         "approve" => false
//                     ],
//                     "url" => 'route("slip_gaji")',
//                     "submenu" => null
//                 ]
//             ]
//         ],
//         "pinjaman_karyawan" => [
//             "permission" => [
//                 "view" => false,
//                 "create" => false,
//                 "edit" => false,
//                 "delete" => false,
//                 "print" => false,
//                 "approve" => false
//             ],
//             "url" => 'route("pinjaman_karyawan")',
//             "submenu" => null
//         ],
//     ]
// ],
