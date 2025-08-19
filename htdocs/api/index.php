<?php

// VERSION: 3.0 - Completely rewritten API for QR Menu System

declare(strict_types=1);

/**
 * QR Menu System API Endpoints
 * 
 * Complete API implementation for restaurant management system
 * Compatible with the provided database schema
 */

// Prevent direct access
if (!defined('APP_PATH')) {
    define('APP_PATH', dirname(__DIR__));
}

// Load configuration and database
require_once __DIR__ . '/../config/config.php';
Config::load();

require_once __DIR__ . '/../config/database.php';

// Set JSON response headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('X-API-Version: 3.0');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get the request path
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($request_uri, PHP_URL_PATH) ?: '/';

// Simple path routing - extract endpoint after /api/
$endpoint = '';
$id = null;

// Remove /qrmenu/api/ prefix if present
if (strpos($path, '/qrmenu/api/') === 0) {
    $path = substr($path, strlen('/qrmenu/api/'));
} elseif (strpos($path, '/api/') === 0) {
    $path = substr($path, strlen('/api/'));
}

// Parse endpoint and ID
$path_parts = array_filter(explode('/', trim($path, '/')));
if (!empty($path_parts)) {
    $endpoint = array_shift($path_parts);
    if (!empty($path_parts)) {
        $id = array_shift($path_parts);
    }
}

// Build API path
$api_path = '/' . $endpoint;
if ($id !== null) {
    $api_path .= '/' . $id;
}

// Debug headers
if (Config::get('app.debug')) {
    header('X-Debug-Endpoint: ' . $endpoint);
    header('X-Debug-ID: ' . ($id ?? 'none'));
    header('X-Debug-Path: ' . $api_path);
}

// Route requests
switch ($api_path) {
    case '/':
    case '':
        // API root - show available endpoints
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'QR Menu System API',
            'version' => '3.0',
            'endpoints' => [
                'GET /api/' => 'Show this help',
                'GET /api/branches' => 'Get all branches',
                'GET /api/branches/{id}' => 'Get specific branch',
                'GET /api/categories' => 'Get all menu categories',
                'GET /api/categories/{branch_id}' => 'Get categories for branch',
                'GET /api/menu-items' => 'Get all menu items',
                'GET /api/menu-items/{branch_id}' => 'Get menu items for branch',
                'GET /api/tables' => 'Get all tables',
                'GET /api/tables/{branch_id}' => 'Get tables for branch',
                'GET /api/orders' => 'Get orders',
                'POST /api/orders' => 'Create new order',
                'GET /api/orders/{id}' => 'Get order details',
                'PUT /api/orders/{id}/status' => 'Update order status',
                'GET /api/orders/kitchen' => 'Get kitchen orders',
                'GET /api/feedback' => 'Get feedback',
                'POST /api/feedback' => 'Submit feedback',
                'GET /api/feedback/stats' => 'Get feedback statistics'
            ]
        ]);
        break;

    case '/branches':
        handleBranches();
        break;

    case '/branches/' . $id:
        handleBranchDetails($id);
        break;

    case '/categories':
        handleCategories();
        break;

    case '/menu-items':
        handleMenuItems();
        break;

    case '/tables':
        handleTables();
        break;

    case '/orders':
        handleOrders();
        break;

    case '/orders/' . $id:
        handleOrderDetails($id);
        break;

    case '/orders/' . $id . '/status':
        handleOrderStatusUpdate($id);
        break;

    case '/orders/kitchen':
        handleKitchenOrders();
        break;

    case '/feedback':
        handleFeedback();
        break;

    case '/feedback/stats':
        handleFeedbackStats();
        break;

    default:
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'Endpoint not found',
            'path' => $api_path,
            'available_endpoints' => [
                '/', 'branches', 'categories', 'menu-items', 'tables', 'orders', 'feedback'
            ]
        ]);
        break;
}

// Handler Functions
function handleBranches() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT b.*, h.name as headquarters_name 
                FROM branches b 
                LEFT JOIN headquarters h ON b.headquarters_id = h.id 
                WHERE b.status = 'active'";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND b.id = ?";
            $params[] = $branchId;
        }
        
        $sql .= " ORDER BY b.name";
        
        $result = $db->fetchAll($sql, $params);
        
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleBranchDetails($id) {
    try {
        $db = Database::getInstance();
        
        $sql = "SELECT b.*, h.name as headquarters_name 
                FROM branches b 
                LEFT JOIN headquarters h ON b.headquarters_id = h.id 
                WHERE b.id = ? AND b.status = 'active'";
        $result = $db->fetch($sql, [$id]);
        
        if (!$result) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Branch not found'
            ]);
            return;
        }
        
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleCategories() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT * FROM menu_categories WHERE is_active = 1";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND id IN (
                SELECT DISTINCT category_id 
                FROM menu_items mi 
                INNER JOIN branch_menu_items bmi ON mi.id = bmi.menu_item_id 
                WHERE bmi.branch_id = ? AND bmi.is_available = 1
            )";
            $params[] = $branchId;
        }
        
        $sql .= " ORDER BY display_order, name";
        
        $result = $db->fetchAll($sql, $params);
        
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleMenuItems() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        $categoryId = $_GET['category_id'] ?? null;
        $available = $_GET['available'] ?? null;
        
        if ($branchId) {
            // Get menu items for specific branch with branch pricing
            $sql = "SELECT mi.*, bmi.price as branch_price, bmi.is_available as branch_available,
                           mc.name_bn as category_name_bn 
                    FROM menu_items mi 
                    INNER JOIN branch_menu_items bmi ON mi.id = bmi.menu_item_id AND bmi.branch_id = ?
                    LEFT JOIN menu_categories mc ON mi.category_id = mc.id 
                    WHERE mi.is_available = 1";
            $params = [$branchId];
        } else {
            // Get all menu items
            $sql = "SELECT mi.*, mc.name_bn as category_name_bn 
                    FROM menu_items mi 
                    LEFT JOIN menu_categories mc ON mi.category_id = mc.id 
                    WHERE mi.is_available = 1";
            $params = [];
        }
        
        if ($categoryId) {
            $sql .= " AND mi.category_id = ?";
            $params[] = $categoryId;
        }
        
        if ($available === 'true') {
            if ($branchId) {
                $sql .= " AND bmi.is_available = 1";
            } else {
                $sql .= " AND mi.is_available = 1";
            }
        }
        
        $sql .= " ORDER BY mc.display_order, mi.display_order, mi.name";
        
        $result = $db->fetchAll($sql, $params);
        
        // Use branch-specific price and availability when available
        foreach ($result as &$item) {
            if (isset($item['branch_price']) && $item['branch_price'] !== null) {
                $item['price'] = $item['branch_price'];
            }
            if (isset($item['branch_available']) && $item['branch_available'] !== null) {
                $item['is_available'] = $item['branch_available'];
            }
            unset($item['branch_price']);
            unset($item['branch_available']);
        }
        
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleTables() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        $status = $_GET['status'] ?? null;
        
        $sql = "SELECT * FROM tables";
        $params = [];
        
        if ($branchId) {
            $sql .= " WHERE branch_id = ?";
            $params[] = $branchId;
        }
        
        if ($status) {
            $sql .= $branchId ? " AND status = ?" : " WHERE status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY table_number";
        
        $result = $db->fetchAll($sql, $params);
        
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleOrders() {
    try {
        $db = Database::getInstance();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Create new order
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || !isset($data['branch_id']) || !isset($data['items'])) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'error' => 'Missing required fields: branch_id, items'
                ]);
                return;
            }
            
            $db->beginTransaction();
            
            try {
                // Generate order number
                $orderNumber = 'ORD-' . date('YmdHis') . rand(1000, 9999);
                
                // Insert order
                $sql = "INSERT INTO orders (
                    branch_id, table_id, order_number, customer_name, customer_phone, 
                    payment_method, notes, subtotal, vat_amount, service_charge, 
                    discount_amount, total_amount, order_type, status, payment_status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'pending')";
                
                $params = [
                    $data['branch_id'],
                    $data['table_id'] ?? null,
                    $orderNumber,
                    $data['customer_name'] ?? null,
                    $data['customer_phone'] ?? null,
                    $data['payment_method'] ?? 'cash',
                    $data['notes'] ?? null,
                    $data['subtotal'] ?? 0,
                    $data['vat_amount'] ?? 0,
                    $data['service_charge'] ?? 0,
                    $data['discount_amount'] ?? 0,
                    $data['total_amount'] ?? 0,
                    $data['order_type'] ?? 'dine_in'
                ];
                
                $db->execute($sql, $params);
                $orderId = $db->lastInsertId();
                
                // Insert order items
                foreach ($data['items'] as $item) {
                    if (!isset($item['menu_item_id']) || !isset($item['quantity']) || !isset($item['unit_price'])) {
                        throw new Exception('Invalid item data');
                    }
                    
                    $sql = "INSERT INTO order_items (
                        order_id, menu_item_id, quantity, unit_price, notes
                    ) VALUES (?, ?, ?, ?, ?)";
                    
                    $params = [
                        $orderId,
                        $item['menu_item_id'],
                        $item['quantity'],
                        $item['unit_price'],
                        $item['notes'] ?? null
                    ];
                    
                    $db->execute($sql, $params);
                }
                
                $db->commit();
                
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'id' => $orderId,
                        'order_number' => $orderNumber
                    ]
                ]);
                
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            
        } else {
            // Get orders
            $branchId = $_GET['branch_id'] ?? null;
            $status = $_GET['status'] ?? null;
            
            $sql = "SELECT o.*, t.table_number 
                    FROM orders o 
                    LEFT JOIN tables t ON o.table_id = t.id 
                    WHERE 1=1";
            $params = [];
            
            if ($branchId) {
                $sql .= " AND o.branch_id = ?";
                $params[] = $branchId;
            }
            
            if ($status) {
                $sql .= " AND o.status = ?";
                $params[] = $status;
            }
            
            $sql .= " ORDER BY o.created_at DESC";
            
            $orders = $db->fetchAll($sql, $params);
            
            // Get order items for each order
            foreach ($orders as &$order) {
                $sql = "SELECT oi.*, mi.name_bn 
                        FROM order_items oi 
                        LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                        WHERE oi.order_id = ?";
                $order['items'] = $db->fetchAll($sql, [$order['id']]);
            }
            
            echo json_encode([
                'success' => true,
                'data' => $orders
            ]);
        }
        
    } catch (Exception $e) {
    http_response_code(500);
    // Temporarily add more details to the error message for debugging
    $errorDetails = [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ];
    echo json_encode([
        'success' => false,
        'error' => 'An error occurred while placing the order.',
        'details' => $errorDetails // Add the detailed error info here
    ]);
}
}

function handleOrderDetails($id) {
    try {
        $db = Database::getInstance();
        
        $sql = "SELECT o.*, t.table_number 
                FROM orders o 
                LEFT JOIN tables t ON o.table_id = t.id 
                WHERE o.id = ?";
        $order = $db->fetch($sql, [$id]);
        
        if (!$order) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Order not found'
            ]);
            return;
        }
        
        // Get order items
        $sql = "SELECT oi.*, mi.name_bn, mi.name 
                FROM order_items oi 
                LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                WHERE oi.order_id = ?";
        $order['items'] = $db->fetchAll($sql, [$id]);
        
        echo json_encode([
            'success' => true,
            'data' => $order
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleOrderStatusUpdate($id) {
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'error' => 'Method not allowed'
            ]);
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data || !isset($data['status'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Status is required'
            ]);
            return;
        }
        
        $db = Database::getInstance();
        
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $affected = $db->execute($sql, [$data['status'], $id]);
        
        if ($affected) {
            echo json_encode([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Order not found'
            ]);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleKitchenOrders() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT o.*, t.table_number 
                FROM orders o 
                LEFT JOIN tables t ON o.table_id = t.id 
                WHERE o.status IN ('pending', 'confirmed', 'preparing', 'ready')";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND o.branch_id = ?";
            $params[] = $branchId;
        }
        
        $sql .= " ORDER BY 
            CASE o.status 
                WHEN 'pending' THEN 1 
                WHEN 'confirmed' THEN 2 
                WHEN 'preparing' THEN 3 
                WHEN 'ready' THEN 4 
                ELSE 5 
            END,
            o.created_at ASC";
        
        $orders = $db->fetchAll($sql, $params);
        
        // Get order items for each order
        foreach ($orders as &$order) {
            $sql = "SELECT oi.*, mi.name_bn 
                    FROM order_items oi 
                    LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                    WHERE oi.order_id = ?";
            $order['items'] = $db->fetchAll($sql, [$order['id']]);
        }
        
        echo json_encode([
            'success' => true,
            'data' => $orders
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleFeedback() {
    try {
        $db = Database::getInstance();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Submit new feedback
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data || !isset($data['branch_id']) || !isset($data['rating'])) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'error' => 'Missing required fields: branch_id, rating'
                ]);
                return;
            }
            
            $sql = "INSERT INTO customer_feedback (
                branch_id, order_id, customer_name, customer_phone, 
                rating, feedback, feedback_type, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
            
            $params = [
                $data['branch_id'],
                $data['order_id'] ?? null,
                $data['customer_name'] ?? null,
                $data['customer_phone'] ?? null,
                $data['rating'],
                $data['feedback'] ?? null,
                $data['feedback_type'] ?? 'compliment'
            ];
            
            $db->execute($sql, $params);
            $feedbackId = $db->lastInsertId();
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'id' => $feedbackId
                ]
            ]);
            
        } else {
            // Get feedback
            $branchId = $_GET['branch_id'] ?? null;
            $status = $_GET['status'] ?? null;
            
            $sql = "SELECT * FROM customer_feedback WHERE 1=1";
            $params = [];
            
            if ($branchId) {
                $sql .= " AND branch_id = ?";
                $params[] = $branchId;
            }
            
            if ($status) {
                $sql .= " AND status = ?";
                $params[] = $status;
            }
            
            $sql .= " ORDER BY created_at DESC";
            
            $result = $db->fetchAll($sql, $params);
            
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

function handleFeedbackStats() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT 
                COUNT(*) as total_feedback,
                AVG(rating) as average_rating,
                COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
                COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
                COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
                COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
                COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
                FROM customer_feedback";
        $params = [];
        
        if ($branchId) {
            $sql .= " WHERE branch_id = ?";
            $params[] = $branchId;
        }
        
        $stats = $db->fetch($sql, $params);
        
        echo json_encode([
            'success' => true,
            'data' => $stats
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}