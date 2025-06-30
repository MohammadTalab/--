<?php
/**
 * Category Model
 * Handles category-related database operations
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

class Category {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get category by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM category WHERE c_id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    /**
     * Get all categories
     */
    public function getAll() {
        $sql = "SELECT * FROM category ORDER BY name";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Get categories with product count
     */
    public function getWithProductCount() {
        $sql = "SELECT c.*, COUNT(p.p_id) as product_count 
                FROM category c 
                LEFT JOIN product p ON c.c_id = p.c_id 
                GROUP BY c.c_id 
                ORDER BY c.name";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Create new category
     */
    public function create($data) {
        // Validate required fields
        if (empty($data['name']) || empty($data['description'])) {
            throw new Exception('جميع الحقول مطلوبة');
        }
        
        // Check if category name already exists
        $existing = $this->db->fetch("SELECT c_id FROM category WHERE name = ?", [cleanInput($data['name'])]);
        if ($existing) {
            throw new Exception('اسم الفئة مستخدم بالفعل');
        }
        
        $sql = "INSERT INTO category (name, img, description) VALUES (?, ?, ?)";
        $this->db->query($sql, [
            cleanInput($data['name']),
            $data['img'] ?? '',
            cleanInput($data['description'])
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Update category
     */
    public function update($id, $data) {
        $category = $this->getById($id);
        if (!$category) {
            throw new Exception('الفئة غير موجودة');
        }
        
        $updates = [];
        $params = [];
        
        if (!empty($data['name'])) {
            // Check if new name conflicts with existing category
            $existing = $this->db->fetch("SELECT c_id FROM category WHERE name = ? AND c_id != ?", [
                cleanInput($data['name']), $id
            ]);
            if ($existing) {
                throw new Exception('اسم الفئة مستخدم بالفعل');
            }
            
            $updates[] = "name = ?";
            $params[] = cleanInput($data['name']);
        }
        
        if (!empty($data['description'])) {
            $updates[] = "description = ?";
            $params[] = cleanInput($data['description']);
        }
        
        if (isset($data['img'])) {
            $updates[] = "img = ?";
            $params[] = $data['img'];
        }
        
        if (empty($updates)) {
            throw new Exception('لا توجد بيانات للتحديث');
        }
        
        $params[] = $id;
        $sql = "UPDATE category SET " . implode(', ', $updates) . " WHERE c_id = ?";
        
        return $this->db->query($sql, $params)->rowCount();
    }
    
    /**
     * Delete category
     */
    public function delete($id) {
        $category = $this->getById($id);
        if (!$category) {
            throw new Exception('الفئة غير موجودة');
        }
        
        // Check if category has products
        $productCount = $this->db->fetch("SELECT COUNT(*) as count FROM product WHERE c_id = ?", [$id])['count'];
        if ($productCount > 0) {
            throw new Exception('لا يمكن حذف الفئة لوجود منتجات مرتبطة بها');
        }
        
        // Delete category image if exists
        if (!empty($category['img'])) {
            deleteFile($category['img'], 'categories');
        }
        
        $sql = "DELETE FROM category WHERE c_id = ?";
        return $this->db->query($sql, [$id])->rowCount();
    }
    
    /**
     * Get category count
     */
    public function getCount() {
        $result = $this->db->fetch("SELECT COUNT(*) as count FROM category");
        return $result['count'] ?? 0;
    }
} 