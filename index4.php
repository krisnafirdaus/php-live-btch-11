<?php

// ==========================================
// SOAL 4: PATTERN DAN LOOP
// ==========================================

/**
 * Pattern 1: Segitiga Angka
 * Baris ke-i mencetak angka 1 sampai i
 */
function patternSegitigaAngka($n) {
    echo "=== Pattern Segitiga Angka ($n baris) ===\n";
    
    for ($baris = 1; $baris <= $n; $baris++) {
        // Loop dalam: cetak angka dari 1 sampai nomor baris
        for ($angka = 1; $angka <= $baris; $angka++) {
            echo $angka;
        }
        echo "\n"; // Pindah ke baris baru
    }
}

/**
 * Pattern 2: Diamond Bintang
 * Kombinasi segitiga naik + segitiga turun
 */
function patternDiamondBintang($n) {
    echo "=== Pattern Diamond Bintang ($n baris) ===\n";
    
    // -------- FASE 1: Segitiga Naik (atas) --------
    for ($baris = 1; $baris <= $n; $baris++) {
        
        // Cetak spasi (semakin ke bawah, spasi semakin sedikit)
        for ($spasi = 1; $spasi <= ($n - $baris); $spasi++) {
            echo " ";
        }
        
        // Cetak bintang (ganjil: 1, 3, 5, 7...)
        $jumlahBintang = (2 * $baris) - 1;
        for ($bintang = 1; $bintang <= $jumlahBintang; $bintang++) {
            echo "*";
        }
        
        echo "\n";
    }
    
    // -------- FASE 2: Segitiga Turun (bawah) --------
    for ($baris = $n - 1; $baris >= 1; $baris--) {
        
        // Cetak spasi (semakin ke bawah, spasi semakin banyak)
        for ($spasi = 1; $spasi <= ($n - $baris); $spasi++) {
            echo " ";
        }
        
        // Cetak bintang
        $jumlahBintang = (2 * $baris) - 1;
        for ($bintang = 1; $bintang <= $jumlahBintang; $bintang++) {
            echo "*";
        }
        
        echo "\n";
    }
}

// ==========================================
// TESTING
// ==========================================

patternSegitigaAngka(5);

echo "\n";

patternDiamondBintang(5);

?>