<?php
// abstract
abstract class KegiatanKampus {
    protected string $nama;

    public function __construct(string $nama) {
        if(trim($nama) === ""){
            throw new InvalidArgumentException("error: nama tidak boleh kosong \n");
        }
        $this->nama = $nama;

    }
    // Getter
    public function getNama(): string {
        return $this->nama;
    }
    abstract public function infoKegiatan(): string;
}

class UKM extends KegiatanKampus {
    public function infoKegiatan(): string {
        return "UKM: {$this->nama}"; 
    }
}

class KSM extends KegiatanKampus {
    public function infoKegiatan(): string {
        return "KSM: {$this->nama}"; 
    }
}

function tampilkanKegiatan(KegiatanKampus $kegiatan){
    echo $kegiatan->infoKegiatan() . PHP_EOL;
}

class Mahasiswa {
    private string $nim;
    private string $nama;
    private string $angkatan;
    private string $minat;
    private array $riwayatPendaftaran = [];

    public function __construct(string $nim, string $nama, string $angkatan, string $minat) {
        if(trim($nim) === ""){
            throw new InvalidArgumentException("error: nim tidak boleh kosong \n");
        }
        if(trim($nama) === ""){
            throw new InvalidArgumentException("error: nama tidak boleh kosong \n");
        }
        if(trim($angkatan) === ""){
            throw new InvalidArgumentException("error: angkatan tidak boleh kosong \n");
        }
        if(trim($minat) === ""){
            throw new InvalidArgumentException("error: minat tidak boleh kosong \n");
        }

        $this->nim = $nim;
        $this->nama = $nama;
        $this->angkatan = $angkatan;
        $this->minat = $minat;
    }

    // Getter
    public function getNim(): string {
        return $this->nim;
    }
    public function getNama(): string {
        return $this->nama;
    }
    public function getAngkatan(): string {
        return $this->angkatan;
    }
    public function getMinat(): string {
        return $this->minat;
    }

    // Setter
    public function tampilkanProfil(): void {
        echo "PROFIL MAHASISWA \n";
        echo str_repeat("=", 30) . "\n";
        echo"NIM        : {$this->nim} \n";
        echo"Nama       : {$this->nama} \n";
        echo"Angkatan   : {$this->angkatan} \n";
        echo"Minat      : {$this->minat} \n";
        echo str_repeat("=", 30) . "\n" . "\n";
    }

    public function ajukanPendaftaran(KegiatanKampus $kegiatan): void {
        $pendaftaran = new Pendaftaran($this, $kegiatan);
        $this->riwayatPendaftaran[] = $pendaftaran;
        echo "sukses" . $pendaftaran->ringkasan() . PHP_EOL;
    }   

    public function lihatRiwayat(): void {
        echo"Riwayat Pendaftaran: " . PHP_EOL;
        if (empty($this->riwayatPendaftaran)) {
            echo "Belum mendaftar ke UKM/KSM manapun" . PHP_EOL;
        } else {
            foreach ($this->riwayatPendaftaran as $index => $pendaftaran) {
                echo ($index + 1) . ". " . $pendaftaran->ringkasan() . PHP_EOL;
               
            }
        }
        echo PHP_EOL;
    }
}

class Pendaftaran{
    private Mahasiswa $mahasiswa;
    private KegiatanKampus $kegiatan;

    public function __construct(Mahasiswa $mahasiswa, KegiatanKampus $kegiatan){
        $this->mahasiswa = $mahasiswa;
        $this->kegiatan = $kegiatan;
    }

    public function ringkasan(): string {
        return $this->mahasiswa->getNama(). " mendaftar ke " . $this->kegiatan->infoKegiatan();
    }
}

$mahasiswa = new Mahasiswa(
    "20251020014",
    "Nanda",
    "2026",
    "TI"
);

$ukm = new UKM("AI Engineer");
$ksm = new KSM("Cyber Security");

echo "=== DAFTAR KEGIATAN ===" . PHP_EOL;

foreach ([$ukm, $ksm] as $kegiatan) {
    tampilkanKegiatan($kegiatan);
}

echo PHP_EOL;
echo "=== PENDAFTARAN MAHASISWA ===" . PHP_EOL;

$mahasiswa->tampilkanProfil();
$mahasiswa->ajukanPendaftaran($ukm);
$mahasiswa->ajukanPendaftaran($ksm);
$mahasiswa->lihatRiwayat();


?>