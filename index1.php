<?php

// 1. function validasi nilai
function validasiNilai($nilai, $namaNilai) {
    if(!is_numeric($nilai)) {
        return "$namaNilai harus berupa angka.";
    }
    if($nilai < 0 || $nilai > 100){
        return "$namaNilai harus antara 0 dan 100.";
    } 
    return true;
}

// 2. function nilai akhir
function hitungNilaiAkhir($tugas, $uts, $uas){
    $nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);
    return $nilaiAkhir;
}

// 3. function grade
function tentukanGrade($nilaiAkhir){
    echo "Nilai Akhir: " . number_format($nilaiAkhir,1) . "\n";
    if($nilaiAkhir >= 85 && $nilaiAkhir <= 100){
        return "A";
    } elseif($nilaiAkhir >= 70 && $nilaiAkhir < 85){
        return "B";
    } elseif($nilaiAkhir >= 60 && $nilaiAkhir < 70){
        return "C";
    } elseif ($nilaiAkhir >= 50 && $nilaiAkhir < 60){
        return "D";
    } else {
        return "E";
    }
}

function tentukanStatus($grade){
    if($grade == "D" || $grade == "E"){
        return "Tidak Lulus";
    } else {
        return "Lulus";
    }
}

function tampilkanPenilaian($tugas, $uts, $uas){
    $validasiTugas = validasiNilai($tugas, "Nilai Tugas");
    $validasiUTS = validasiNilai($uts, "Nilai UTS");
    $validasiUAS = validasiNilai($uas, "Nilai UAS");

    if($validasiTugas !== true) {
        return $validasiTugas;
    }
    if($validasiUTS !== true) {
        return $validasiUTS;
    }
    if($validasiUAS !== true) {
        return $validasiUAS;
    }

   $nilaiAkhir = hitungNilaiAkhir($tugas, $uts, $uas);
   $grade = tentukanGrade($nilaiAkhir);
   $status = tentukanStatus($grade);

   echo "Nilai Tugas: $tugas\n";
   echo "Nilai UTS: $uts\n";
   echo "Nilai UAS: $uas\n";
   echo "Nilai Akhir: " . number_format($nilaiAkhir,1) . "\n";
   echo "Grade: $grade\n";
   echo "Status: $status\n";

} 

tampilkanPenilaian(80, 40, 80);


?>