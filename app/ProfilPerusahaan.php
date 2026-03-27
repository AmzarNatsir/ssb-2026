<?php

namespace App;

class ProfilPerusahaan extends Singleton
{
    protected $nm_perusahaan, $alamat, $kelurahan, $kecamatan, $kabupaten, $provinsi, $no_telepon, $no_fax, $nm_email, $nm_pimpinan, $logo_perusahaan;

    protected function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $perusahaan = \App\Models\HRD\ProfilPerusahaanModel::first();

        if ($perusahaan) {
            $this->nm_perusahaan = $perusahaan->nm_perusahaan;
            $this->alamat = $perusahaan->alamat;
            $this->kelurahan = $perusahaan->kelurahan;
            $this->kecamatan = $perusahaan->kecamatan;
            $this->kabupaten = $perusahaan->kabupaten;
            $this->provinsi = $perusahaan->provinsi;
            $this->no_telepon = $perusahaan->no_telepon;
            $this->no_fax = $perusahaan->no_fax;
            $this->nm_email = $perusahaan->nm_email;
            $this->nm_pimpinan = $perusahaan->nm_pimpinan;
            $this->logo_perusahaan = $perusahaan->logo_perusahaan;
        }
    }

    public static function getNmPerusahaan()
    {
        $instance = self::getInstance();
        return $instance->nm_perusahaan;
    }

    public static function getAlamat()
    {
        $instance = self::getInstance();
        return $instance->alamat;
    }

    public static function getKelurahan()
    {
        $instance = self::getInstance();
        return $instance->kelurahan;
    }

    public static function getKecamatan()
    {
        $instance = self::getInstance();
        return $instance->kecamatan;
    }

    public static function getKabupaten()
    {
        $instance = self::getInstance();
        return $instance->kabupaten;
    }

    public static function getProvinsi()
    {
        $instance = self::getInstance();
        return $instance->provinsi;
    }

    public static function getNoTelepon()
    {
        $instance = self::getInstance();
        return $instance->no_telepon;
    }

    public static function getNoFax()
    {
        $instance = self::getInstance();
        return $instance->no_fax;
    }

    public static function getNmEmail()
    {
        $instance = self::getInstance();
        return $instance->nm_email;
    }

    public static function getNmPimpinan()
    {
        $instance = self::getInstance();
        return $instance->nm_pimpinan;
    }

    public static function getLogoPerusahaan()
    {
        $instance = self::getInstance();
        return $instance->logo_perusahaan;
    }

    public static function getLogoPerusahaanUrl()
    {
        $instance = self::getInstance();
        return url(\Illuminate\Support\Facades\Storage::url('logo_perusahaan/'.$instance->logo_perusahaan));
    }
}
