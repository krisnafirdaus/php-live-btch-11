<?php

// ==========================================
// SOAL 5: SISTEM KASIR MINI
// ==========================================

class MiniKasir {
    
    // Data master produk
    private $products = [
        "P001" => ["name" => "Beras 5kg", "price" => 65000, "category" => "sembako"],
        "P002" => ["name" => "Minyak Goreng 2L", "price" => 35000, "category" => "sembako"],
        "P003" => ["name" => "Gula 1kg", "price" => 15000, "category" => "sembako"],
        "P004" => ["name" => "Snack A", "price" => 5000, "category" => "snack"],
        "P005" => ["name" => "Minuman B", "price" => 8000, "category" => "minuman"],
    ];
    
    // Keranjang belanja
    private $cart = [];
    
    /**
     * 1. Menambahkan produk ke keranjang
     */
    public function addToCart($productCode, $quantity) {
        // Validasi: apakah produk ada?
        if (!isset($this->products[$productCode])) {
            echo "Error: Produk '$productCode' tidak ditemukan!\n";
            return false;
        }
        
        // Validasi: quantity harus > 0
        if ($quantity <= 0) {
            echo "Error: Quantity harus lebih dari 0!\n";
            return false;
        }
        
        $product = $this->products[$productCode];
        
        // Kalau produk sudah ada di cart, tambahkan quantity-nya
        if (isset($this->cart[$productCode])) {
            $this->cart[$productCode]['quantity'] += $quantity;
        } else {
            // Kalau belum ada, masukkan baru
            $this->cart[$productCode] = [
                'code'     => $productCode,
                'name'     => $product['name'],
                'price'    => $product['price'],
                'category' => $product['category'],
                'quantity' => $quantity
            ];
        }
        
        echo "Berhasil: {$product['name']} x$quantity ditambahkan ke keranjang.\n";
        return true;
    }
    
    /**
     * 2. Menghitung total belanja
     * Return array: subtotal, total_sembako
     */
    public function calculateTotal() {
        $subtotal = 0;
        $totalSembako = 0;
        
        foreach ($this->cart as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];
            $subtotal += $itemSubtotal;
            
            // Pisahkan total sembako untuk cek bonus diskon
            if ($item['category'] == 'sembako') {
                $totalSembako += $itemSubtotal;
            }
        }
        
        return [
            'subtotal'     => $subtotal,
            'total_sembako' => $totalSembako
        ];
    }
    
    /**
     * 3. Menghitung diskon
     * Return array rincian diskon
     */
    public function applyDiscount($memberType) {
        $totals = $this->calculateTotal();
        $subtotal = $totals['subtotal'];
        $totalSembako = $totals['total_sembako'];
        
        // --- Diskon Member ---
        $memberDiscountRate = 0;
        if ($memberType == 'Gold') {
            $memberDiscountRate = 0.15;
        } elseif ($memberType == 'Silver') {
            $memberDiscountRate = 0.10;
        }
        // Non-Member = 0%
        
        $memberDiscount = $subtotal * $memberDiscountRate;
        $afterMemberDiscount = $subtotal - $memberDiscount;
        
        // --- Bonus Diskon Sembako (> Rp 100.000) ---
        $sembakoDiscount = 0;
        if ($totalSembako > 100000) {
            $sembakoDiscount = $afterMemberDiscount * 0.05; // 5% dari total setelah diskon member
        }
        
        $grandTotal = $afterMemberDiscount - $sembakoDiscount;
        
        return [
            'subtotal'            => $subtotal,
            'member_type'         => $memberType,
            'member_discount'     => $memberDiscount,
            'member_discount_pct' => ($memberDiscountRate * 100) . '%',
            'total_sembako'       => $totalSembako,
            'sembako_discount'    => $sembakoDiscount,
            'sembako_bonus'       => ($totalSembako > 100000) ? 'Ya (5%)' : 'Tidak',
            'grand_total'         => $grandTotal
        ];
    }
    
    /**
     * 4. Mencetak struk belanja
     */
    public function printReceipt($memberType = 'Non-Member') {
        if (empty($this->cart)) {
            echo "Keranjang masih kosong!\n";
            return;
        }
        
        $discountInfo = $this->applyDiscount($memberType);
        
        echo "\n";
        echo "========================================\n";
        echo "         STRUK BELANJA MINI             \n";
        echo "========================================\n";
        echo str_pad("Item", 20) . str_pad("Qty", 6) . str_pad("Harga", 12) . str_pad("Subtotal", 12) . "\n";
        echo "----------------------------------------\n";
        
        foreach ($this->cart as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];
            echo str_pad($item['name'], 20);
            echo str_pad($item['quantity'], 6);
            echo str_pad("Rp " . number_format($item['price'], 0, ',', '.'), 12);
            echo str_pad("Rp " . number_format($itemSubtotal, 0, ',', '.'), 12);
            echo "\n";
        }
        
        echo "----------------------------------------\n";
        echo str_pad("Subtotal", 32) . "Rp " . number_format($discountInfo['subtotal'], 0, ',', '.') . "\n";
        
        if ($discountInfo['member_discount'] > 0) {
            echo str_pad("Diskon Member (" . $discountInfo['member_type'] . " " . $discountInfo['member_discount_pct'] . ")", 32);
            echo "- Rp " . number_format($discountInfo['member_discount'], 0, ',', '.') . "\n";
        }
        
        if ($discountInfo['sembako_discount'] > 0) {
            echo str_pad("Bonus Sembako (>100rb)", 32);
            echo "- Rp " . number_format($discountInfo['sembako_discount'], 0, ',', '.') . "\n";
        }
        
        echo "----------------------------------------\n";
        echo str_pad("TOTAL BAYAR", 32) . "Rp " . number_format($discountInfo['grand_total'], 0, ',', '.') . "\n";
        echo "========================================\n";
    }
    
    /**
     * 5. Menghitung kembalian
     */
    public function calculateChange($payment) {
        $totals = $this->applyDiscount('Non-Member'); // Default non-member kalau tidak disebutkan
        $grandTotal = $totals['grand_total'];
        
        if ($payment < $grandTotal) {
            echo "Error: Uang pembayaran kurang! Kurang: Rp " . number_format($grandTotal - $payment, 0, ',', '.') . "\n";
            return false;
        }
        
        $change = $payment - $grandTotal;
        echo "Total Bayar : Rp " . number_format($grandTotal, 0, ',', '.') . "\n";
        echo "Bayar       : Rp " . number_format($payment, 0, ',', '.') . "\n";
        echo "Kembalian   : Rp " . number_format($change, 0, ',', '.') . "\n";
        
        return $change;
    }
    
    // Helper: hitung kembalian dengan member type tertentu
    public function calculateChangeWithMember($payment, $memberType) {
        $totals = $this->applyDiscount($memberType);
        $grandTotal = $totals['grand_total'];
        
        if ($payment < $grandTotal) {
            echo "Error: Uang pembayaran kurang! Kurang: Rp " . number_format($grandTotal - $payment, 0, ',', '.') . "\n";
            return false;
        }
        
        $change = $payment - $grandTotal;
        echo "Total Bayar : Rp " . number_format($grandTotal, 0, ',', '.') . "\n";
        echo "Bayar       : Rp " . number_format($payment, 0, ',', '.') . "\n";
        echo "Kembalian   : Rp " . number_format($change, 0, ',', '.') . "\n";
        
        return $change;
    }
}

// ==========================================
// TESTING / SIMULASI
// ==========================================

echo "=== MEMBUAT OBJEK KASIR ===\n";
$kasir = new MiniKasir();

echo "\n=== MENAMBAH PRODUK KE KERANJANG ===\n";
$kasir->addToCart('P001', 2); // Beras 5kg x2 = 130rb (sembako)
$kasir->addToCart('P002', 1); // Minyak x1 = 35rb (sembako)
$kasir->addToCart('P004', 3); // Snack x3 = 15rb
$kasir->addToCart('P005', 2); // Minuman x2 = 16rb

echo "\n=== CEK TOTAL ===\n";
$totals = $kasir->calculateTotal();
echo "Subtotal     : Rp " . number_format($totals['subtotal'], 0, ',', '.') . "\n";
echo "Total Sembako: Rp " . number_format($totals['total_sembako'], 0, ',', '.') . "\n";

echo "\n=== STRUK NON-MEMBER ===\n";
$kasir->printReceipt('Non-Member');

echo "\n=== STRUK MEMBER GOLD (15% + Bonus Sembako 5%) ===\n";
$kasir->printReceipt('Gold');

echo "\n=== HITUNG KEMBALIAN (GOLD, Bayar 250rb) ===\n";
$kasir->calculateChangeWithMember(250000, 'Gold');

?>