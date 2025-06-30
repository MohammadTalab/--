<?php
/**
 * Cart Model
 * Handles shopping cart operations
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

class Cart {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get cart items for user
     */
    public function getItems($userId) {
        $sql = "SELECT op.*, p.name, p.img, p.description, p.price as product_price 
                FROM order_product op 
                JOIN product p ON op.p_id = p.p_id 
                JOIN `order` o ON op.o_id = o.O_id 
                WHERE o.u_id = ? AND o.status = 'cart'";
        return $this->db->fetchAll($sql, [$userId]);
    }
    
    /**
     * Get cart count for user
     */
    public function getCount($userId) {
        $sql = "SELECT COUNT(*) as count 
                FROM order_product op 
                JOIN `order` o ON op.o_id = o.O_id 
                WHERE o.u_id = ? AND o.status = 'cart'";
        $result = $this->db->fetch($sql, [$userId]);
        return $result['count'] ?? 0;
    }
    
    /**
     * Get cart total for user
     */
    public function getTotal($userId) {
        $sql = "SELECT SUM(op.price * op.count) as total 
                FROM order_product op 
                JOIN `order` o ON op.o_id = o.O_id 
                WHERE o.u_id = ? AND o.status = 'cart'";
        $result = $this->db->fetch($sql, [$userId]);
        return $result['total'] ?? 0;
    }
    
    /**
     * Add item to cart
     */
    public function addItem($userId, $productId, $quantity = 1) {
        // Validate quantity
        if ($quantity <= 0) {
            throw new Exception('الكمية يجب أن تكون أكبر من صفر');
        }
        
        // Check if product exists
        $product = $this->db->fetch("SELECT * FROM product WHERE p_id = ?", [$productId]);
        if (!$product) {
            throw new Exception('المنتج غير موجود');
        }
        
        // Get or create cart order
        $orderId = $this->getCartOrderId($userId);
        
        // Check if product already in cart
        $existingItem = $this->db->fetch(
            "SELECT op.* FROM order_product op 
             JOIN `order` o ON op.o_id = o.O_id 
             WHERE o.u_id = ? AND o.status = 'cart' AND op.p_id = ?",
            [$userId, $productId]
        );
        
        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem['count'] + $quantity;
            $sql = "UPDATE order_product SET count = ?, price = ? WHERE p_id = ? AND o_id = ?";
            $this->db->query($sql, [$newQuantity, $product['price'], $productId, $orderId]);
        } else {
            // Add new item
            $sql = "INSERT INTO order_product (p_id, o_id, count, price) VALUES (?, ?, ?, ?)";
            $this->db->query($sql, [$productId, $orderId, $quantity, $product['price']]);
        }
        
        logActivity('cart_add', "User $userId added product $productId to cart");
    }
    
    /**
     * Update item quantity
     */
    public function updateQuantity($userId, $productId, $quantity) {
        if ($quantity <= 0) {
            $this->removeItem($userId, $productId);
            return;
        }
        
        $orderId = $this->getCartOrderId($userId);
        
        $sql = "UPDATE order_product op 
                JOIN `order` o ON op.o_id = o.O_id 
                SET op.count = ? 
                WHERE o.u_id = ? AND o.status = 'cart' AND op.p_id = ?";
        
        $result = $this->db->query($sql, [$quantity, $userId, $productId]);
        
        if ($result->rowCount() === 0) {
            throw new Exception('المنتج غير موجود في السلة');
        }
        
        logActivity('cart_update', "User $userId updated product $productId quantity to $quantity");
    }
    
    /**
     * Remove item from cart
     */
    public function removeItem($userId, $productId) {
        $orderId = $this->getCartOrderId($userId);
        
        $sql = "DELETE op FROM order_product op 
                JOIN `order` o ON op.o_id = o.O_id 
                WHERE o.u_id = ? AND o.status = 'cart' AND op.p_id = ?";
        
        $result = $this->db->query($sql, [$userId, $productId]);
        
        if ($result->rowCount() === 0) {
            throw new Exception('المنتج غير موجود في السلة');
        }
        
        logActivity('cart_remove', "User $userId removed product $productId from cart");
    }
    
    /**
     * Clear cart
     */
    public function clear($userId) {
        $orderId = $this->getCartOrderId($userId);
        
        $sql = "DELETE FROM order_product WHERE o_id = ?";
        $this->db->query($sql, [$orderId]);
        
        logActivity('cart_clear', "User $userId cleared cart");
    }
    
    /**
     * Get cart order ID (create if doesn't exist)
     */
    private function getCartOrderId($userId) {
        // Check if cart order exists
        $order = $this->db->fetch(
            "SELECT O_id FROM `order` WHERE u_id = ? AND status = 'cart'",
            [$userId]
        );
        
        if ($order) {
            return $order['O_id'];
        }
        
        // Create new cart order
        $sql = "INSERT INTO `order` (u_id, status, order_date) VALUES (?, 'cart', CURDATE())";
        $this->db->query($sql, [$userId]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Checkout cart
     */
    public function checkout($userId, $orderData) {
        // Validate order data
        if (empty($orderData['fullname']) || empty($orderData['address']) || empty($orderData['location'])) {
            throw new Exception('جميع بيانات الطلب مطلوبة');
        }
        
        $orderId = $this->getCartOrderId($userId);
        
        // Check if cart has items
        $itemCount = $this->getCount($userId);
        if ($itemCount === 0) {
            throw new Exception('السلة فارغة');
        }
        
        // Update order with checkout data
        $sql = "UPDATE `order` SET 
                fullname = ?, 
                address = ?, 
                location = ?, 
                `num-id` = ?, 
                status = 'قيد المعالجة' 
                WHERE O_id = ?";
        
        $this->db->query($sql, [
            cleanInput($orderData['fullname']),
            cleanInput($orderData['address']),
            cleanInput($orderData['location']),
            cleanInput($orderData['num-id'] ?? ''),
            $orderId
        ]);
        
        logActivity('checkout', "User $userId completed checkout for order $orderId");
        
        return $orderId;
    }
} 