<?php

// ==========================================
// SOAL 3: VALIDASI DAN FORMAT DATA
// ==========================================

/**
 * Function utama validasi input
 * @param array $data - ['email' => ..., 'password' => ..., 'phone' => ...]
 * @return array - ['status' => 'valid/invalid', 'errors' => [...]]
 */
function validateInput($data) {
    $errors = [];

    // -------- 1. Validasi Email --------
    $email = isset($data['email']) ? $data['email'] : '';
    if (empty($email)) {
        $errors['email'] = "Email wajib diisi!";
    } elseif (strpos($email, '@') === false || strpos($email, '.') === false) {
        $errors['email'] = "Email harus mengandung '@' dan '.'!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid!";
    }

    // -------- 2. Validasi Password --------
    $password = isset($data['password']) ? $data['password'] : '';
    if (empty($password)) {
        $errors['password'] = "Password wajib diisi!";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password minimal 8 karakter!";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors['password'] = "Password harus mengandung huruf besar (A-Z)!";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $errors['password'] = "Password harus mengandung huruf kecil (a-z)!";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors['password'] = "Password harus mengandung angka (0-9)!";
    }

    // -------- 3. Validasi Phone --------
    $phone = isset($data['phone']) ? $data['phone'] : '';
    if (empty($phone)) {
        $errors['phone'] = "Nomor telepon wajib diisi!";
    } else {
        // Bersihkan strip dan spasi dulu
        $cleanPhone = str_replace(['-', ' '], '', $phone);
        
        // Cek: hanya angka, diawali 08, panjang 10-13 digit
        if (!preg_match('/^08\d{8,11}$/', $cleanPhone)) {
            $errors['phone'] = "Format phone harus 08xx-xxxx-xxxx (10-13 digit)!";
        }
    }

    // -------- Return Hasil --------
    if (empty($errors)) {
        return [
            'status' => 'valid',
            'message' => 'Semua input valid!',
            'errors' => []
        ];
    } else {
        return [
            'status' => 'invalid',
            'message' => 'Validasi gagal, periksa kembali input Anda.',
            'errors' => $errors
        ];
    }
}

// ==========================================
// TEST CASE
// ==========================================

echo "=== TEST 1: Input Valid ===\n";
$result1 = validateInput([
    'email'    => 'user@example.com',
    'password' => 'Pass1234',
    'phone'    => '08123456789'
]);
print_r($result1);

echo "\n=== TEST 2: Semua Salah ===\n";
$result2 = validateInput([
    'email'    => 'userexamplecom',
    'password' => 'pass',
    'phone'    => '0212345678'
]);
print_r($result2);

echo "\n=== TEST 3: Password Kurang Kompleks ===\n";
$result3 = validateInput([
    'email'    => 'test@mail.co.id',
    'password' => 'password123', // tidak ada huruf besar
    'phone'    => '0812-3456-7890'
]);
print_r($result3);

echo "\n=== TEST 4: Phone Format dengan Strip ===\n";
$result4 = validateInput([
    'email'    => 'admin@stokla.id',
    'password' => 'Stokla2026',
    'phone'    => '0812-3456-7890'
]);
print_r($result4);

?>