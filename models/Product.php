<?php
/**
 * Product Model
 * Handles product-related database operations
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

class Product {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get product by ID
     */
    public function getById($id) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.c_id = c.c_id 
                WHERE p.p_id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    /**
     * Get all products with pagination
     */
    public function getAll($page = 1, $limit = ITEMS_PER_PAGE, $categoryId = null, $search = null) {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.c_id = c.c_id 
                WHERE 1=1";
        
        if ($categoryId) {
            $sql .= " AND p.c_id = ?";
            $params[] = $categoryId;
        }
        
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY p.p_id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Get featured products
     */
    public function getFeatured($limit = 6) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.c_id = c.c_id 
                ORDER BY p.p_id DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    /**
     * Get products by category
     */
    public function getByCategory($categoryId, $page = 1, $limit = ITEMS_PER_PAGE) {
        return $this->getAll($page, $limit, $categoryId);
    }
    
    /**
     * Search products
     */
    public function search($search, $page = 1, $limit = ITEMS_PER_PAGE) {
        return $this->getAll($page, $limit, null, $search);
    }
    
    /**
     * Get total products count
     */
    public function getCount($categoryId = null, $search = null) {
        $params = [];
        
        $sql = "SELECT COUNT(*) as count FROM product p WHERE 1=1";
        
        if ($categoryId) {
            $sql .= " AND p.c_id = ?";
            $params[] = $categoryId;
        }
        
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $result = $this->db->fetch($sql, $params);
        return $result['count'] ?? 0;
    }
    
    /**
     * Create new product
     */
    public function create($data) {
        // Validate required fields
        if (empty($data['name']) || empty($data['description']) || empty($data['price'])) {
            throw new Exception('جميع الحقول مطلوبة');
        }
        
        // Validate price
        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            throw new Exception('السعر يجب أن يكون رقم موجب');
        }
        
        // Validate category
        if (empty($data['c_id'])) {
            throw new Exception('يجب اختيار فئة للمنتج');
        }
        
        $sql = "INSERT INTO product (name, description, img, price, c_id) VALUES (?, ?, ?, ?, ?)";
        $this->db->query($sql, [
            cleanInput($data['name']),
            cleanInput($data['description']),
            $data['img'] ?? '',
            (float)$data['price'],
            (int)$data['c_id']
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Update product
     */
    public function update($id, $data) {
        $product = $this->getById($id);
        if (!$product) {
            throw new Exception('المنتج غير موجود');
        }
        
        $updates = [];
        $params = [];
        
        if (!empty($data['name'])) {
            $updates[] = "name = ?";
            $params[] = cleanInput($data['name']);
        }
        
        if (!empty($data['description'])) {
            $updates[] = "description = ?";
            $params[] = cleanInput($data['description']);
        }
        
        if (!empty($data['price'])) {
            if (!is_numeric($data['price']) || $data['price'] <= 0) {
                throw new Exception('السعر يجب أن يكون رقم موجب');
            }
            $updates[] = "price = ?";
            $params[] = (float)$data['price'];
        }
        
        if (!empty($data['c_id'])) {
            $updates[] = "c_id = ?";
            $params[] = (int)$data['c_id'];
        }
        
        if (isset($data['img'])) {
            $updates[] = "img = ?";
            $params[] = $data['img'];
        }
        
        if (empty($updates)) {
            throw new Exception('لا توجد بيانات للتحديث');
        }
        
        $params[] = $id;
        $sql = "UPDATE product SET " . implode(', ', $updates) . " WHERE p_id = ?";
        
        return $this->db->query($sql, $params)->rowCount();
    }
    
    /**
     * Delete product
     */
    public function delete($id) {
        $product = $this->getById($id);
        if (!$product) {
            throw new Exception('المنتج غير موجود');
        }
        
        // Delete product image if exists
        if (!empty($product['img'])) {
            deleteFile($product['img'], 'products');
        }
        
        $sql = "DELETE FROM product WHERE p_id = ?";
        return $this->db->query($sql, [$id])->rowCount();
    }
    
    /**
     * Get related products
     */
    public function getRelated($productId, $limit = 4) {
        $product = $this->getById($productId);
        if (!$product) {
            return [];
        }
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.c_id = c.c_id 
                WHERE p.c_id = ? AND p.p_id != ? 
                ORDER BY p.p_id DESC 
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$product['c_id'], $productId, $limit]);
    }
} 