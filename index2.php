<?php

$products = [
    ["id" => 1, "name" => "Laptop", "price" => 15000000, "stock" => 5],
    ["id" => 2, "name" => "Mouse", "price" => 150000, "stock" => 20],
    ["id" => 3, "name" => "Keyboard", "price" => 500000, "stock" => 0],
    ["id" => 4, "name" => "Monitor", "price" => 2000000, "stock" => 8],
];

//  ["id" => 1, "name" => "Laptop", "price" => 15000000, "stock" => 5],
//  ["id" => 2, "name" => "Mouse", "price" => 150000, "stock" => 20],
//  ["id" => 3, "name" => "Keyboard", "price" => 500000, "stock" => 0],
//  ["id" => 4, "name" => "Monitor", "price" => 2000000, "stock" => 8],

// 1. menampilkan stock habis (stock = 0)
function getOutOfStock($products){
    $outOfStock = [];

    foreach($products as $product) {
        if ($product["stock"] == 0) {
            $outOfStock[] = $product;
        }
    }

    return $outOfStock;
}

// 2. menghitung total nilai inventory (price * stock)
function calculateInventoryValue($products){
    $total = 0;

    foreach ($products as $product) {
        $total += $product["price"] * $product["stock"];
    }

    return $total;
}

// 3. mengurutkan product
function sortByPriceDesc($products){
    // usort = user-defined sort, untuk mengurutkan array multidimensi berdasarkan kriteria tertentu
    // $b - $a = descending (termahal dulu)
    usort($products, function($a, $b) {
        return $b["price"] - $a["price"];
    });
    return $products;
}

// 4. menmabahkan diskon 10% untuk harga diatas 1 juta
function applyDiscount($products){
    $discountedProducts = [];

    foreach ($products as $product) {
       $newProduct = $product;

       if($product["price"] > 1000000){
        $discountAmount = $product["price"] * 0.10;
        $finalPrice = $product["price"] - $discountAmount;

        $newProduct["discount"] = $discountAmount;
        $newProduct["final_price"] = $finalPrice;
       } else {
        $newProduct["discount"] = 0;
        $newProduct["final_price"] = $product["price"];
       }

       $discountedProducts[] = $newProduct;
    } 

    return $discountedProducts;
}

// testing
echo "== DATA PRODUK ==\n";
print_r($products);

echo "\n== 1. PRODUCTSTOCK HABIS ==\n";
$outOfStock = getOutOfStock($products);
if(empty($outOfStock)){
    echo "Tidak ada produk stok habis.\n";
} else {
    print_r($outOfStock);
}

echo "\n== 2. TOTAL NILAI INVENTORY ==\n";
$totalValue = calculateInventoryValue($products);
echo "Total Nilai Inventory: Rp " . number_format($totalValue, 0, ",", ".") . "\n";

echo "\n== 3. PRODUK DI URUTKAN ==\n";
$sortedProducts = sortByPriceDesc($products);
print_r($sortedProducts);

echo "\n== 4. PRODUK DENGAN DISKON ==\n";
$discountedProducts = applyDiscount($products);
print_r($discountedProducts);

?>