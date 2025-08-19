<?php

// VERSION: 2.0 - Fixed branch routing and response format

declare(strict_types=1);

/**
 * Simple API Endpoints for Frontend
 * 
 * This file provides basic API endpoints for the frontend interfaces.
 * Standalone implementation - does not load MVC framework to avoid conflicts.
 */

// Set the application path
define('APP_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('ROOT_PATH', dirname(__DIR__));

// Prevent direct access to files
if (!defined('APP_PATH')) {
    exit('No direct access allowed');
}

// Load configuration directly (without MVC framework)
require_once __DIR__ . '/../../config/config.php';
\Config\Config::load();

// Load database wrapper
require_once __DIR__ . '/database.php';

// Set JSON response headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('X-API-Version: ' . '2.0');

// Handle preflight requests
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get the request path - SIMPLIFIED FOR .HTACCESS ROUTING
$request_uri = $_SERVER['REQUEST_URI'] ?? '/api';
$path = parse_url($request_uri, PHP_URL_PATH) ?: '/api';

// Extract the API endpoint from the path
// With .htaccess rule: RewriteRule ^api/(.*)$ api/index.php [QSA,L]
// The path will be something like /restaurant-management-system/public/api/branches
// We need to extract just the /branches part

// Remove the base path to get the clean endpoint
$base_path = '/restaurant-management-system/public/api';
if (strpos($path, $base_path) === 0) {
    $clean_path = substr($path, strlen($base_path));
} else {
    $clean_path = $path;
}

// Extract endpoint and potential ID
$path_parts = explode('/', trim($clean_path, '/'));
$endpoint = $path_parts[0] ?? '';
$id = $path_parts[1] ?? null;  // ID is now the second part, not third

// Build API path for routing
if ($endpoint && $id) {
    $api_path = '/' . $endpoint . '/' . $id;
} elseif ($endpoint) {
    $api_path = '/' . $endpoint;
} else {
    $api_path = '/';
}

// Also check for query string parameter as fallback
if (isset($_GET['endpoint'])) {
    $api_path = '/' . trim($_GET['endpoint'], '/');
}

// Debug output (remove in production)
if (\Config\Config::get('app.debug')) {
    error_log("API Debug: Request URI: $request_uri");
    error_log("API Debug: Parsed Path: $path");
    error_log("API Debug: Clean Path: $clean_path");
    error_log("API Debug: Endpoint: $endpoint");
    error_log("API Debug: ID: $id");
    error_log("API Debug: Final API Path: $api_path");
}

// Always add debug header for development
header('X-Debug-Path: ' . $api_path);
header('X-Debug-Endpoint: ' . $endpoint);
header('X-Debug-ID: ' . ($id ?: 'none'));

// Simple routing
switch ($api_path) {
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
        
    case '/orders/kitchen':
        handleKitchenOrders();
        break;
        
    case '/orders/' . $id:
        handleOrderDetails($id);
        break;
        
    case '/orders/' . $id . '/status':
        handleOrderStatusUpdate($id);
        break;
        
    case '/feedback':
        handleFeedback();
        break;
        
    case '/feedback/stats':
        handleFeedbackStats();
        break;
        
    case '':
    case '/':
        // API root - show available endpoints
        http_response_code(200);
        echo json_encode([
            'message' => 'Restaurant Management System API',
            'version' => '1.0.0',
            'endpoints' => [
                'GET /api/branches' => 'Get all branches',
                'GET /api/branches/{id}' => 'Get branch details',
                'GET /api/categories' => 'Get menu categories',
                'GET /api/menu-items' => 'Get menu items',
                'GET /api/tables' => 'Get tables',
                'GET /api/orders' => 'Get orders',
                'POST /api/orders' => 'Create order',
                'GET /api/orders/{id}' => 'Get order details',
                'PUT /api/orders/{id}/status' => 'Update order status',
                'GET /api/orders/kitchen' => 'Get kitchen orders',
                'GET /api/feedback' => 'Get feedback',
                'POST /api/feedback' => 'Submit feedback',
                'GET /api/feedback/stats' => 'Get feedback statistics'
            ]
        ]);
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found', 'path' => $api_path]);
        break;
}

// Handler functions
function handleBranches() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT * FROM branches WHERE status = 'active'";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND id = ?";
            $params[] = $branchId;
        }
        
        $result = $db->fetchAll($sql, $params);
        
        // Wrap result in data object for consistent API response format
        echo json_encode(['data' => $result]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
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
            echo json_encode(['error' => 'Branch not found']);
            return;
        }
        
        echo json_encode(['data' => $result]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleCategories() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT * FROM menu_categories WHERE is_active = 1";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND id IN (SELECT DISTINCT category_id FROM menu_items WHERE id IN (SELECT menu_item_id FROM branch_menu_items WHERE branch_id = ? AND is_available = 1))";
            $params[] = $branchId;
        }
        
        $sql .= " ORDER BY display_order, name_bn";
        
        $result = $db->fetchAll($sql, $params);
        
        echo json_encode(['data' => $result]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleMenuItems() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        $categoryId = $_GET['category_id'] ?? null;
        $available = $_GET['available'] ?? null;
        
        if ($branchId) {
            // Changed to INNER JOIN to only show menu items that are assigned to the branch
            $sql = "SELECT mi.*, bmi.price as branch_price, bmi.is_available as branch_available,
                           mc.name_bn as category_name_bn 
                    FROM menu_items mi 
                    INNER JOIN branch_menu_items bmi ON mi.id = bmi.menu_item_id AND bmi.branch_id = ?
                    LEFT JOIN menu_categories mc ON mi.category_id = mc.id 
                    WHERE 1=1";
            $params = [$branchId];
        } else {
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
        
        $sql .= " ORDER BY mc.display_order, mi.display_order, mi.name_bn";
        
        $result = $db->fetchAll($sql, $params);
        
        // Use branch price and availability
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
        
        echo json_encode(['data' => $result]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleTables() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        $available = $_GET['available'] ?? null;
        
        $sql = "SELECT * FROM tables WHERE status = 'available'";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND branch_id = ?";
            $params[] = $branchId;
        }
        
        if ($available === 'true') {
            $sql .= " AND status = 'available'";
        }
        
        $sql .= " ORDER BY table_number";
        
        $result = $db->fetchAll($sql, $params);
        
        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleOrders() {
    try {
        $db = Database::getInstance();
        
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Create new order
            $data = json_decode(file_get_contents('php://input'), true);
            
            $db->beginTransaction();
            
            try {
                // Insert order
                $sql = "INSERT INTO orders (
                    branch_id, table_id, order_number, customer_name, customer_phone, 
                    payment_method, notes, subtotal, vat_amount, service_charge, 
                    discount_amount, total_amount, order_type, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
                
                $orderNumber = 'ORD-' . date('YmdHis') . rand(1000, 9999);
                $params = [
                    $data['branch_id'],
                    $data['table_id'],
                    $orderNumber,
                    $data['customer_name'],
                    $data['customer_phone'],
                    $data['payment_method'],
                    $data['notes'] ?? '',
                    $data['subtotal'],
                    $data['vat_amount'],
                    $data['service_charge'],
                    $data['discount_amount'] ?? 0,
                    $data['total_amount'],
                    $data['order_type'] ?? 'dine_in'
                ];
                
                $db->execute($sql, $params);
                $orderId = $db->lastInsertId();
                
                // Insert order items
                foreach ($data['items'] as $item) {
                    $sql = "INSERT INTO order_items (
                        order_id, menu_item_id, quantity, unit_price, notes
                    ) VALUES (?, ?, ?, ?, ?)";
                    
                    $params = [
                        $orderId,
                        $item['menu_item_id'],
                        $item['quantity'],
                        $item['unit_price'],
                        $item['notes'] ?? ''
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
                    WHERE o.status != 'completed'";
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
            
            echo json_encode(['data' => $orders]);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
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
            echo json_encode(['error' => 'Order not found']);
            return;
        }
        
        // Get order items
        $sql = "SELECT oi.*, mi.name_bn 
                FROM order_items oi 
                LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                WHERE oi.order_id = ?";
        $order['items'] = $db->fetchAll($sql, [$id]);
        
        echo json_encode(['data' => $order]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
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
        
        echo json_encode(['data' => $orders]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleOrderStatusUpdate($id) {
    try {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        $db = Database::getInstance();
        $data = json_decode(file_get_contents('php://input'), true);
        
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $db->execute($sql, [$data['status'], $id]);
        
        echo json_encode(['success' => true]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleFeedback() {
    try {
        $db = Database::getInstance();
        
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Create new feedback
            $data = json_decode(file_get_contents('php://input'), true);
            
            $sql = "INSERT INTO customer_feedback (
                branch_id, order_id, customer_name, customer_phone,
                rating, feedback, feedback_type, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
            
            $params = [
                $data['branch_id'],
                $data['order_id'] ?? null,
                $data['customer_name'],
                $data['customer_phone'],
                $data['rating'],
                $data['feedback'],
                $data['feedback_type'] ?? 'compliment'
            ];
            
            $db->execute($sql, $params);
            
            echo json_encode(['success' => true]);
            
        } else {
            // Get feedback
            $branchId = $_GET['branch_id'] ?? null;
            $limit = $_GET['limit'] ?? 10;
            
            $sql = "SELECT * FROM customer_feedback WHERE status = 'reviewed'";
            $params = [];
            
            if ($branchId) {
                $sql .= " AND branch_id = ?";
                $params[] = $branchId;
            }
            
            $sql .= " ORDER BY created_at DESC LIMIT ?";
            $params[] = (int)$limit;
            
            $result = $db->fetchAll($sql, $params);
            
            echo json_encode(['data' => $result]);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function handleFeedbackStats() {
    try {
        $db = Database::getInstance();
        $branchId = $_GET['branch_id'] ?? null;
        
        $sql = "SELECT 
                    COUNT(*) as total_feedback,
                    AVG(rating) as average_rating,
                    SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) * 100 / COUNT(*) as satisfaction_rate
                FROM customer_feedback 
                WHERE status = 'reviewed'";
        $params = [];
        
        if ($branchId) {
            $sql .= " AND branch_id = ?";
            $params[] = $branchId;
        }
        
        $result = $db->fetch($sql, $params);
        
        // Calculate response rate (this is a mock calculation)
        $result['response_rate'] = 85; // Mock value
        
        echo json_encode(['data' => $result]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}