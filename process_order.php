<?php
session_start();
include("connectdb.php"); // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $table_number = $_POST['table_number'];
    $products = $_POST['products'];
    
    // คำนวณราคารวม
    $total = 0;
    foreach ($products as $product) {
        $product_price = $product['price'];
        $quantity = $product['quantity'];
        $total += $product_price * $quantity;
    }

    // แทรกข้อมูลลูกค้าและเลขโต๊ะ
    $query = "INSERT INTO orders (customer_name, table_number, total) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $customer_name, $table_number, $total);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // ได้รับ ID ของคำสั่งซื้อที่สร้างขึ้น
        
        // แทรกข้อมูลสินค้าในคำสั่งซื้อ
        foreach ($products as $product) {
            $product_id = $product['id'];
            $product_name = $product['name'];
            $product_price = $product['price'];
            $quantity = $product['quantity'];

            $query_product = "INSERT INTO order_item (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)";
            $stmt_product = $conn->prepare($query_product);
            $stmt_product->bind_param("iisdi", $order_id, $product_id, $product_name, $product_price, $quantity);
            $stmt_product->execute();
        }

        // ล้างข้อมูลในเซสชันหลังจากสั่งซื้อสำเร็จ
        unset($_SESSION['sid']);
        unset($_SESSION['sname']);
        unset($_SESSION['sprice']);
        unset($_SESSION['sitem']);
        
        echo "สั่งซื้อสำเร็จ! รหัสคำสั่งซื้อของคุณคือ: " . $order_id;
        echo '<br><br>';
        echo '<a href="index.php" style="padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">กลับไปหน้าหลัก</a>';
		echo '<a href="view_order.php?order_id=' . $order_id . '" style="padding: 10px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px;">ดูรายละเอียดคำสั่งซื้อ</a>';
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
