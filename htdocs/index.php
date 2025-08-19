<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Digital Restaurant Menu - Order food online with real-time tracking">
    <meta name="keywords" content="restaurant, menu, food, order, delivery, dine-in">
    <title>QR Menu - ডিজিটাল রেস্তোরাঁ মেনু</title>
    
    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* CSS Variables for Theme */
        :root {
            /* Primary Colors */
            --primary-color: #dc2626;
            --primary-dark: #b91c1c;
            --primary-light: #ef4444;
            --primary-gradient: linear-gradient(135deg, #dc2626, #b91c1c);
            
            /* Secondary Colors */
            --secondary-color: #1e293b;
            --secondary-light: #334155;
            --secondary-dark: #0f172a;
            --secondary-gradient: linear-gradient(135deg, #1e293b, #0f172a);
            
            /* Accent Colors */
            --accent-color: #f59e0b;
            --accent-light: #fbbf24;
            --accent-dark: #d97706;
            --accent-gradient: linear-gradient(135deg, #f59e0b, #d97706);
            
            /* Status Colors */
            --success-color: #10b981;
            --success-light: #34d399;
            --success-dark: #059669;
            --success-gradient: linear-gradient(135deg, #10b981, #059669);
            
            --warning-color: #f59e0b;
            --warning-light: #fbbf24;
            --warning-dark: #d97706;
            --warning-gradient: linear-gradient(135deg, #f59e0b, #d97706);
            
            --danger-color: #ef4444;
            --danger-light: #f87171;
            --danger-dark: #dc2626;
            --danger-gradient: linear-gradient(135deg, #ef4444, #dc2626);
            
            /* Neutral Colors */
            --light-bg: #f8fafc;
            --light-border: #e2e8f0;
            --light-text: #64748b;
            --light-hover: #f1f5f9;
            --light-gradient: linear-gradient(135deg, #f8fafc, #f1f5f9);
            
            --dark-bg: #1e293b;
            --dark-border: #334155;
            --dark-text: #f1f5f9;
            --dark-hover: #334155;
            --dark-gradient: linear-gradient(135deg, #1e293b, #334155);
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-colored: 0 4px 14px 0 rgba(220, 38, 38, 0.25);
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;
            
            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            
            /* Animations */
            --bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --ease-out: cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --ease-in-out: cubic-bezier(0.42, 0, 0.58, 1);
        }
        
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background-color: var(--light-bg);
            color: var(--secondary-color);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Loading Screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity var(--transition-normal);
        }
        
        .loading-screen.hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Header Styles */
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: var(--spacing-md) 0;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }
        
        .restaurant-info {
            text-align: center;
            flex: 1;
        }
        
        .restaurant-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--spacing-sm);
        }
        
        .branch-name {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Button Styles */
        .btn {
            padding: var(--spacing-sm) var(--spacing-lg);
            border: none;
            border-radius: var(--radius-xl);
            cursor: pointer;
            font-weight: 600;
            transition: all var(--transition-normal);
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            text-decoration: none;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.025em;
            box-shadow: var(--shadow-md);
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left var(--transition-normal);
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
        
        .btn:active {
            transform: scale(0.98);
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: 1px solid transparent;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #991b1b);
            transform: translateY(-2px) scale(1.02);
            box-shadow: var(--shadow-colored), var(--shadow-lg);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .btn-success {
            background: var(--success-gradient);
            color: white;
            border: 1px solid transparent;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-dark), #047857);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.25);
        }
        
        .btn-danger {
            background: var(--danger-gradient);
            color: white;
            border: 1px solid transparent;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, var(--danger-dark), #b91c1c);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.25);
        }
        
        .btn:disabled {
            background: var(--light-border);
            color: var(--light-text);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.6;
        }
        
        .btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }
        
        .btn:disabled::before {
            display: none;
        }
        
        /* Header Actions */
        .header-actions {
            display: flex;
            gap: var(--spacing-md);
            align-items: center;
        }
        
        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            min-width: 300px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            margin-top: var(--spacing-sm);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all var(--transition-normal);
        }
        
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-header {
            padding: var(--spacing-md);
            border-bottom: 1px solid var(--light-border);
            font-weight: 600;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .dropdown-item {
            padding: var(--spacing-md) var(--spacing-md);
            border-bottom: 1px solid var(--light-hover);
            transition: background var(--transition-fast);
            cursor: pointer;
        }
        
        .dropdown-item:hover {
            background: var(--light-hover);
        }
        
        .dropdown-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-action {
            background: var(--light-bg);
            border: 1px solid var(--light-border);
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-lg);
            cursor: pointer;
            font-size: 0.85rem;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--secondary-color);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .dropdown-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-gradient);
            transition: width var(--transition-normal);
            z-index: -1;
        }
        
        .dropdown-action:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }
        
        .dropdown-action:hover::before {
            width: 100%;
        }
        
        .dropdown-action:hover {
            color: white;
        }
        
        .dropdown-action.add-to-cart {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            box-shadow: var(--shadow-colored);
        }
        
        .dropdown-action.add-to-cart:hover {
            background: linear-gradient(135deg, var(--primary-dark), #991b1b);
            transform: translateY(-2px) scale(1.05);
            box-shadow: var(--shadow-colored), var(--shadow-lg);
        }
        
        .dropdown-action.remove-favorite {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-color: #fecaca;
            color: var(--danger-color);
        }
        
        .dropdown-action.remove-favorite:hover {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-color: #fca5a5;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }
        
        .dropdown-action i {
            font-size: 0.75rem;
            transition: transform var(--transition-fast);
        }
        
        .dropdown-action:hover i {
            transform: scale(1.2);
        }
        
        .empty-state {
            padding: var(--spacing-2xl) var(--spacing-md);
            text-align: center;
            color: var(--light-text);
        }
        
        /* Icon Colors */
        .icon-favorite {
            color: var(--danger-color);
        }
        
        .icon-history {
            color: #3498db;
        }
        
        /* Search and Filter Section */
        .search-filter-section {
            background: white;
            padding: var(--spacing-md) 0;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 80px;
            z-index: 95;
        }
        
        .search-container {
            position: relative;
            margin-bottom: var(--spacing-md);
        }
        
        .search-input {
            width: 100%;
            padding: var(--spacing-md) var(--spacing-lg) var(--spacing-md) 3.5rem;
            border: 2px solid var(--light-border);
            border-radius: var(--radius-xl);
            font-size: 1rem;
            transition: all var(--transition-normal);
            background: var(--light-gradient);
            color: var(--secondary-color);
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1), var(--shadow-md);
            transform: translateY(-1px);
        }
        
        .search-input::placeholder {
            color: var(--light-text);
            font-weight: 400;
        }
        
        .search-icon {
            position: absolute;
            left: var(--spacing-lg);
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
            font-size: 1.1rem;
            transition: color var(--transition-normal);
        }
        
        .search-input:focus + .search-icon {
            color: var(--primary-color);
        }
        
        /* Filter Controls */
        .filter-controls {
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
            align-items: center;
        }
        
        .filter-btn {
            background: var(--light-gradient);
            border: 1px solid var(--light-border);
            color: var(--secondary-color);
            padding: var(--spacing-sm) var(--spacing-lg);
            border-radius: var(--radius-xl);
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: 0.9rem;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            font-weight: 500;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-gradient);
            transition: width var(--transition-normal);
            z-index: -1;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            color: white;
            transform: translateY(-2px) scale(1.02);
            box-shadow: var(--shadow-colored), var(--shadow-md);
            border-color: transparent;
        }
        
        .filter-btn:hover::before,
        .filter-btn.active::before {
            width: 100%;
        }
        
        .filter-btn i {
            transition: transform var(--transition-fast);
        }
        
        .filter-btn:hover i,
        .filter-btn.active i {
            transform: scale(1.1) rotate(5deg);
        }
        
        .filter-section {
            margin-bottom: var(--spacing-md);
        }
        
        .filter-section-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: var(--spacing-sm);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        /* Category Navigation */
        .category-nav {
            display: flex;
            gap: var(--spacing-sm);
            overflow-x: auto;
            padding-bottom: var(--spacing-sm);
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) var(--light-hover);
        }
        
        .category-nav::-webkit-scrollbar {
            height: 6px;
        }
        
        .category-nav::-webkit-scrollbar-track {
            background: var(--light-hover);
            border-radius: var(--radius-sm);
        }
        
        .category-nav::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: var(--radius-sm);
        }
        
        .category-btn {
            background: var(--light-gradient);
            border: 1px solid var(--light-border);
            color: var(--secondary-color);
            padding: var(--spacing-sm) var(--spacing-lg);
            border-radius: var(--radius-xl);
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: 0.9rem;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            font-weight: 500;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-gradient);
            transition: width var(--transition-normal);
            z-index: -1;
        }
        
        .category-btn:hover,
        .category-btn.active {
            color: white;
            transform: translateY(-2px) scale(1.02);
            box-shadow: var(--shadow-colored), var(--shadow-md);
            border-color: transparent;
        }
        
        .category-btn:hover::before,
        .category-btn.active::before {
            width: 100%;
        }
        
        .category-btn i {
            transition: transform var(--transition-fast);
        }
        
        .category-btn:hover i,
        .category-btn.active i {
            transform: scale(1.1) rotate(5deg);
        }
        
        .sort-select {
            padding: var(--spacing-sm) var(--spacing-lg);
            border: 2px solid var(--light-border);
            border-radius: var(--radius-xl);
            background: var(--light-gradient);
            color: var(--secondary-color);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-sm);
        }
        
        .sort-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            transform: translateY(-1px);
        }
        
        .sort-select:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-md);
        }
        
        /* Menu Container */
        .menu-container {
            padding: var(--spacing-2xl) var(--spacing-md);
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .menu-section {
            margin-bottom: var(--spacing-2xl);
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-sm);
            border-bottom: 3px solid var(--primary-color);
            display: inline-block;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-lg);
        }
        
        /* Menu Card */
        .menu-card {
            background: white;
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            cursor: pointer;
            border: 1px solid var(--light-hover);
            position: relative;
        }
        
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform var(--transition-normal);
            transform-origin: left;
        }
        
        .menu-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-xl), var(--shadow-colored);
            border-color: var(--primary-color);
        }
        
        .menu-card:hover::before {
            transform: scaleX(1);
        }
        
        .menu-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--light-hover), var(--light-border));
            position: relative;
        }
        
        .menu-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(30, 41, 59, 0.1));
        }
        
        .menu-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--danger-gradient);
            color: white;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-xl);
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 3;
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .menu-content {
            padding: var(--spacing-lg);
        }
        
        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: var(--spacing-sm);
        }
        
        .menu-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary-color);
            flex: 1;
            margin: 0;
        }
        
        .menu-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-left: var(--spacing-md);
        }
        
        .menu-description {
            color: var(--light-text);
            font-size: 0.9rem;
            margin-bottom: var(--spacing-md);
            line-height: 1.5;
        }
        
        .menu-meta {
            display: flex;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-md);
            flex-wrap: wrap;
        }
        
        .menu-tag {
            background: var(--light-hover);
            color: var(--secondary-color);
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-xl);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }
        
        .menu-tag.vegetarian {
            background: #dcfce7;
            color: var(--success-color);
        }
        
        .menu-tag.spicy {
            background: #fef2f2;
            color: var(--danger-color);
        }
        
        .menu-tag.popular {
            background: #fef3c7;
            color: var(--warning-color);
        }
        
        .menu-actions {
            display: flex;
            gap: var(--spacing-sm);
            align-items: center;
        }
        
        .favorite-btn {
            background: none;
            border: none;
            color: var(--light-border);
            font-size: 1.2rem;
            cursor: pointer;
            padding: var(--spacing-sm);
            border-radius: 50%;
            transition: all var(--transition-normal);
        }
        
        .favorite-btn:hover,
        .favorite-btn.active {
            color: var(--danger-color);
            background: rgba(231, 76, 60, 0.1);
        }
        
        .add-to-cart-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--radius-xl);
            cursor: pointer;
            font-weight: 600;
            transition: all var(--transition-normal);
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            flex: 1;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-colored);
            font-size: 0.8rem;
            letter-spacing: 0.025em;
        }

        .quantity-selector {
            display: none;
            align-items: center;
            gap: var(--spacing-xs);
            flex: 1;
        }

        .quantity-selector.active {
            display: flex;
        }

        .quantity-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: var(--radius-full);
            cursor: pointer;
            font-weight: 600;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
        }

        .quantity-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), #991b1b);
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .quantity-btn:active {
            transform: scale(0.95);
        }

        .quantity-display {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            min-width: 30px;
            height: 28px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .add-to-cart-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left var(--transition-normal);
        }
        
        .add-to-cart-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), #991b1b);
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--shadow-colored), var(--shadow-lg);
        }
        
        .add-to-cart-btn:hover::before {
            left: 100%;
        }
        
        .add-to-cart-btn:active {
            transform: translateY(-1px) scale(0.98);
        }
        
        .add-to-cart-btn:disabled {
            background: var(--light-gradient);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.7;
            border: 1px solid var(--light-border);
        }
        
        .add-to-cart-btn:disabled::before {
            display: none;
        }
        
        .add-to-cart-btn i {
            transition: transform var(--transition-fast);
        }
        
        .add-to-cart-btn:hover i {
            transform: scale(1.2) rotate(10deg);
        }
        
        /* Order Status Styles */
        .order-status {
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-xl);
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .order-status.pending {
            background: #fef3c7;
            color: var(--warning-color);
        }
        
        .order-status.confirmed {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .order-status.preparing {
            background: #e0e7ff;
            color: #4f46e5;
        }
        
        .order-status.ready {
            background: #d1fae5;
            color: var(--success-color);
        }
        
        .order-status.served {
            background: #e0e7ff;
            color: #4f46e5;
        }
        
        .order-status.completed {
            background: #dcfce7;
            color: var(--success-color);
        }
        
        .order-status.cancelled {
            background: #fee2e2;
            color: var(--danger-color);
        }
        
        /* Order Items Display */
        .order-items-section {
            margin-top: var(--spacing-lg);
            padding-top: var(--spacing-lg);
            border-top: 1px solid var(--light-border);
        }
        
        .order-items-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: var(--spacing-md);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .order-items-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
        }
        
        .order-item {
            display: flex;
            gap: var(--spacing-md);
            padding: var(--spacing-md);
            background: var(--light-bg);
            border-radius: var(--radius-lg);
            border: 1px solid var(--light-border);
            transition: all var(--transition-normal);
        }
        
        .order-item:hover {
            background: var(--light-hover);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .order-item-image {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-md);
            object-fit: cover;
            background: linear-gradient(135deg, var(--light-hover), var(--light-border));
        }
        
        .order-item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }
        
        .order-item-name {
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 1rem;
        }
        
        .order-item-description {
            font-size: 0.85rem;
            color: var(--light-text);
            line-height: 1.4;
        }
        
        .order-item-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .order-item-quantity {
            background: var(--primary-color);
            color: white;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-xl);
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .order-item-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1rem;
        }
        
        .order-item-preparation-time {
            font-size: 0.75rem;
            color: var(--light-text);
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }
        
        .order-item-image-container {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: all var(--transition-normal);
            flex-shrink: 0;
        }
        
        .order-item-image-container:hover {
            transform: scale(1.05);
        }
        
        .order-item-image-container.loading {
            background: linear-gradient(90deg, var(--light-hover) 25%, var(--light-border) 50%, var(--light-hover) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        .order-item-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: var(--radius-md);
        }
        
        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .menu-card {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .menu-card:nth-child(1) { animation-delay: 0.1s; }
        .menu-card:nth-child(2) { animation-delay: 0.2s; }
        .menu-card:nth-child(3) { animation-delay: 0.3s; }
        .menu-card:nth-child(4) { animation-delay: 0.4s; }
        .menu-card:nth-child(5) { animation-delay: 0.5s; }
        .menu-card:nth-child(6) { animation-delay: 0.6s; }
        
        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            right: -420px;
            top: 0;
            width: 420px;
            height: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1), -5px 0 20px rgba(0, 0, 0, 0.06);
            transition: right var(--transition-normal);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-left: 1px solid rgba(226, 232, 240, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .cart-sidebar.open {
            right: 0;
        }
        
        /* Desktop Responsiveness */
        @media (min-width: 1200px) {
            .cart-sidebar {
                width: 380px;
                right: -380px;
            }
            
            .cart-sidebar.open {
                right: 0;
            }
            
            .cart-header {
                padding: var(--spacing-lg);
            }
            
            .cart-title {
                font-size: 1.3rem;
                letter-spacing: 0.02em;
            }
            
            .close-cart {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }
            
            .cart-items {
                padding: var(--spacing-md);
            }
            
            .cart-item {
                padding: var(--spacing-md);
                margin-bottom: var(--spacing-sm);
            }
            
            .cart-item-info {
                padding-right: var(--spacing-md);
            }
            
            .cart-item-name {
                font-size: 0.95rem;
                margin-bottom: var(--spacing-xs);
                line-height: 1.3;
            }
            
            .cart-item-details {
                font-size: 0.75rem;
                margin-bottom: var(--spacing-xs);
                line-height: 1.3;
            }
            
            .cart-item-price {
                font-size: 0.85rem;
                padding: 2px 8px;
                margin-top: var(--spacing-xs);
            }
            
            .quantity-controls {
                gap: var(--spacing-xs);
                padding: var(--spacing-xs);
            }
            
            .quantity-btn {
                width: 28px;
                height: 28px;
                font-size: 0.85rem;
                box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
            }
            
            .quantity-btn:hover {
                transform: scale(1.1) translateY(-1px);
                box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            }
            
            .quantity {
                min-width: 32px;
                height: 28px;
                font-size: 0.9rem;
                font-weight: 700;
            }
            
            .cart-footer {
                padding: var(--spacing-md);
            }
            
            .cart-summary {
                padding: var(--spacing-xs);
                margin-bottom: var(--spacing-xs);
            }
            
            .summary-row {
                font-size: 0.75rem;
                margin-bottom: 1px;
                padding: 1px 0;
                line-height: 1.1;
            }
            
            .summary-row:last-child {
                margin-bottom: 0;
            }
            
            .summary-total {
                font-size: 0.85rem;
                padding: 2px var(--spacing-xs);
                margin: 1px calc(-1 * var(--spacing-xs));
            }
            
            .checkout-btn {
                padding: var(--spacing-sm);
                font-size: 0.9rem;
                font-weight: 600;
                letter-spacing: 0.02em;
                box-shadow: 0 2px 10px rgba(16, 185, 129, 0.2);
            }
            
            .checkout-btn:hover {
                transform: translateY(-2px) scale(1.02);
                box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            }
            
            .empty-cart {
                padding: var(--spacing-xl);
            }
            
            .empty-cart i {
                font-size: 3rem;
                margin-bottom: var(--spacing-lg);
            }
            
            .empty-cart h3 {
                font-size: 1.2rem;
                margin-bottom: var(--spacing-sm);
                font-weight: 600;
            }
            
            .empty-cart p {
                font-size: 0.85rem;
                margin-bottom: var(--spacing-md);
                line-height: 1.4;
            }
            
            /* Enhanced scrollbar for desktop */
            .cart-items::-webkit-scrollbar {
                width: 6px;
            }
            
            .cart-items::-webkit-scrollbar-track {
                background: rgba(226, 232, 240, 0.3);
                border-radius: var(--radius-full);
            }
            
            .cart-items::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
                border-radius: var(--radius-full);
                min-height: 30px;
            }
            
            .cart-items::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(135deg, var(--primary-dark), #991b1b);
            }
        }
        
        @media (min-width: 1400px) {
            .cart-sidebar {
                width: 420px;
                right: -420px;
            }
            
            .cart-sidebar.open {
                right: 0;
            }
            
            .cart-header {
                padding: var(--spacing-xl);
            }
            
            .cart-title {
                font-size: 1.4rem;
            }
            
            .close-cart {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            
            .cart-items {
                padding: var(--spacing-lg);
            }
            
            .cart-item {
                padding: var(--spacing-lg);
                margin-bottom: var(--spacing-md);
            }
            
            .cart-item-name {
                font-size: 1rem;
            }
            
            .cart-item-details {
                font-size: 0.8rem;
            }
            
            .cart-item-price {
                font-size: 0.9rem;
                padding: 4px 12px;
            }
            
            .quantity-controls {
                gap: var(--spacing-md);
            }
            
            .quantity-btn {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .quantity {
                min-width: 36px;
                height: 32px;
                font-size: 1rem;
            }
            
            .cart-footer {
                padding: var(--spacing-md);
            }
            
            .cart-summary {
                padding: var(--spacing-xs);
                margin-bottom: var(--spacing-xs);
            }
            
            .summary-row {
                font-size: 0.8rem;
                margin-bottom: 1px;
                padding: 1px 0;
                line-height: 1.1;
            }
            
            .summary-total {
                font-size: 0.9rem;
            }
            
            .checkout-btn {
                padding: var(--spacing-md);
                font-size: 0.95rem;
            }
            
            .empty-cart i {
                font-size: 3.5rem;
            }
            
            .empty-cart h3 {
                font-size: 1.3rem;
            }
            
            .empty-cart p {
                font-size: 0.9rem;
            }
        }
        
        .cart-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: var(--spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.2);
        }
        
        .cart-title {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.025em;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .close-cart {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            width: 44px;
            height: 44px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
            backdrop-filter: blur(10px);
        }
        
        .close-cart:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.1) rotate(90deg);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }
        
        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: var(--spacing-md);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }
        
        .cart-items::-webkit-scrollbar {
            width: 6px;
        }
        
        .cart-items::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.3);
            border-radius: var(--radius-full);
        }
        
        .cart-items::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: var(--radius-full);
        }
        
        .cart-items::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-dark), #991b1b);
        }
        
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-md);
            border: 1px solid rgba(226, 232, 240, 0.6);
            border-radius: var(--radius-xl);
            transition: all var(--transition-normal);
            position: relative;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }
        
        .cart-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: var(--radius-xl) 0 0 var(--radius-xl);
            transform: scaleY(0);
            transition: transform var(--transition-normal);
        }
        
        .cart-item:hover::before {
            transform: scaleY(1);
        }
        
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }
        
        .cart-item-info {
            flex: 1;
            padding-right: var(--spacing-md);
        }
        
        .cart-item-name {
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
            color: var(--secondary-color);
            font-size: 1rem;
            line-height: 1.3;
        }
        
        .cart-item-details {
            font-size: 0.8rem;
            color: var(--light-text);
            margin-bottom: var(--spacing-xs);
            line-height: 1.4;
        }
        
        .cart-item-price {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.95rem;
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            padding: 2px 8px;
            border-radius: var(--radius-lg);
            display: inline-block;
            margin-top: var(--spacing-xs);
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            padding: var(--spacing-xs);
            border-radius: var(--radius-xl);
            border: 1px solid rgba(226, 232, 240, 0.6);
        }
        
        .quantity-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-lg);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
            transition: all var(--transition-fast);
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .quantity-btn:hover {
            transform: scale(1.1) translateY(-1px);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
            background: linear-gradient(135deg, var(--primary-dark), #991b1b);
        }
        
        .quantity-btn:active {
            transform: scale(0.95);
        }
        
        .quantity {
            font-weight: 700;
            min-width: 32px;
            height: 32px;
            text-align: center;
            font-size: 1rem;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .cart-footer {
            padding: var(--spacing-md);
            border-top: 1px solid rgba(226, 232, 240, 0.6);
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.02);
        }
        
        .cart-summary {
            margin-bottom: var(--spacing-sm);
            background: white;
            padding: var(--spacing-sm);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: var(--spacing-xs);
            padding: 1px 0;
            font-size: 0.8rem;
            line-height: 1.2;
        }
        
        .summary-row:last-child {
            margin-bottom: 0;
        }
        
        .summary-total {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary-color);
            border-top: 1px solid var(--light-border);
            padding-top: var(--spacing-xs);
            margin-top: var(--spacing-xs);
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            margin: var(--spacing-xs) calc(-1 * var(--spacing-sm));
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }
        
        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--success-color), var(--success-dark));
            color: white;
            border: none;
            padding: var(--spacing-md);
            border-radius: var(--radius-lg);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
            letter-spacing: 0.025em;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .checkout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left var(--transition-normal);
        }
        
        .checkout-btn:hover {
            background: linear-gradient(135deg, var(--success-dark), #047857);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4);
        }
        
        .checkout-btn:hover::before {
            left: 100%;
        }
        
        .checkout-btn:active {
            transform: translateY(-1px) scale(0.98);
        }
        
        .empty-cart {
            text-align: center;
            padding: var(--spacing-2xl);
            color: var(--light-text);
        }
        
        .empty-cart i {
            font-size: 4rem;
            color: var(--light-border);
            margin-bottom: var(--spacing-lg);
            opacity: 0.5;
        }
        
        .empty-cart h3 {
            color: var(--secondary-color);
            margin-bottom: var(--spacing-sm);
            font-weight: 600;
        }
        
        .empty-cart p {
            font-size: 0.9rem;
            margin-bottom: var(--spacing-lg);
        }
        
        /* Cart Toggle Button */
        .cart-toggle {
            position: fixed;
            bottom: var(--spacing-xl);
            right: var(--spacing-xl);
            background: var(--primary-gradient);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: var(--radius-full);
            cursor: pointer;
            box-shadow: var(--shadow-xl), var(--shadow-colored);
            transition: all var(--transition-normal);
            z-index: 99;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .cart-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), transparent);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }
        
        .cart-toggle:hover {
            transform: scale(1.1) translateY(-3px);
            box-shadow: var(--shadow-2xl), var(--shadow-colored);
        }
        
        .cart-toggle:hover::before {
            opacity: 1;
        }
        
        .cart-toggle:active {
            transform: scale(1.05) translateY(-1px);
        }
        
        .cart-count {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--accent-gradient);
            color: white;
            border-radius: var(--radius-full);
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: var(--shadow-md);
            border: 2px solid white;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
            60% { transform: translateY(-3px); }
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeIn var(--transition-normal);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-content {
            background: white;
            border-radius: var(--radius-2xl);
            padding: var(--spacing-2xl);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-2xl);
            border: 1px solid var(--light-border);
            animation: slideUp var(--transition-normal) var(--bounce);
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to { 
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            padding-bottom: var(--spacing-md);
            border-bottom: 2px solid var(--light-border);
        }
        
        .modal-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--secondary-color);
            letter-spacing: 0.025em;
        }
        
        .close-modal {
            background: var(--light-hover);
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--light-text);
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
        }
        
        .close-modal:hover {
            background: var(--danger-color);
            color: white;
            transform: scale(1.1) rotate(90deg);
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: var(--spacing-xl);
        }
        
        .form-label {
            display: block;
            margin-bottom: var(--spacing-sm);
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 1rem;
            letter-spacing: 0.025em;
        }
        
        .form-control {
            width: 100%;
            padding: var(--spacing-md) var(--spacing-lg);
            border: 2px solid var(--light-border);
            border-radius: var(--radius-xl);
            font-size: 1rem;
            transition: all var(--transition-normal);
            background: var(--light-gradient);
            color: var(--secondary-color);
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1), var(--shadow-md);
            transform: translateY(-1px);
        }
        
        .form-control::placeholder {
            color: var(--light-text);
            font-weight: 400;
        }
        
        /* Payment Methods */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-md);
        }
        
        .payment-method {
            padding: var(--spacing-md);
            border: 2px solid var(--light-border);
            border-radius: var(--radius-md);
            cursor: pointer;
            text-align: center;
            transition: all var(--transition-normal);
        }
        
        .payment-method:hover {
            border-color: var(--primary-color);
        }
        
        .payment-method.selected {
            border-color: var(--primary-color);
            background: #fef2f2;
        }
        
        .payment-icon {
            font-size: 1.5rem;
            margin-bottom: var(--spacing-xs);
        }
        
        .payment-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }
        
        .payment-desc {
            font-size: 0.75rem;
            color: var(--light-text);
            margin-top: 2px;
        }
        
        /* Enhanced Order Modal Styles */
        .order-modal .modal-content {
            max-width: 600px;
            padding: var(--spacing-xl);
        }
        
        .form-section {
            margin-bottom: var(--spacing-xl);
            padding-bottom: var(--spacing-lg);
            border-bottom: 1px solid var(--light-border);
        }
        
        .form-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: var(--spacing-lg);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary-gradient);
            border-radius: var(--radius-sm);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-md);
        }
        
        /* Order Type Selector */
        .order-type-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--spacing-md);
        }
        
        .order-type-option {
            padding: var(--spacing-md);
            border: 2px solid var(--light-border);
            border-radius: var(--radius-lg);
            cursor: pointer;
            text-align: center;
            transition: all var(--transition-normal);
            background: white;
        }
        
        .order-type-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .order-type-option.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.15);
        }
        
        .order-type-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }
        
        .order-type-option.selected .order-type-icon {
            color: var(--primary-dark);
        }
        
        .order-type-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-bottom: 2px;
        }
        
        .order-type-desc {
            font-size: 0.75rem;
            color: var(--light-text);
        }
        
        /* Table Selection */
        .table-section {
            transition: all var(--transition-normal);
        }
        
        .table-selector {
            border: 2px solid var(--light-border);
            border-radius: var(--radius-lg);
            padding: var(--spacing-md);
            background: white;
            min-height: 120px;
        }
        
        .table-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--spacing-sm);
            color: var(--light-text);
            font-size: 0.9rem;
            padding: var(--spacing-lg);
        }
        
        .table-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: var(--spacing-sm);
        }
        
        .table-item {
            aspect-ratio: 1;
            border: 2px solid var(--light-border);
            border-radius: var(--radius-lg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-normal);
            background: white;
            position: relative;
        }
        
        .table-item:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }
        
        .table-item.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
        }
        
        .table-item.occupied {
            border-color: var(--danger-color);
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        .table-item.reserved {
            border-color: var(--warning-color);
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            cursor: not-allowed;
            opacity: 0.8;
        }
        
        .table-number {
            font-weight: 700;
            font-size: 1rem;
            color: var(--secondary-color);
        }
        
        .table-capacity {
            font-size: 0.7rem;
            color: var(--light-text);
            margin-top: 2px;
        }
        
        .table-status {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .table-item.available .table-status {
            background: var(--success-color);
        }
        
        .table-item.occupied .table-status {
            background: var(--danger-color);
        }
        
        .table-item.reserved .table-status {
            background: var(--warning-color);
        }
        
        /* Delivery Address */
        .delivery-section {
            transition: all var(--transition-normal);
        }
        
        .address-form {
            border: 2px solid var(--light-border);
            border-radius: var(--radius-lg);
            padding: var(--spacing-md);
            background: white;
        }
        
        /* Form Actions */
        .form-actions {
            display: flex;
            gap: var(--spacing-md);
            justify-content: flex-end;
            margin-top: var(--spacing-xl);
            padding-top: var(--spacing-lg);
            border-top: 1px solid var(--light-border);
        }
        
        .form-actions .btn {
            min-width: 120px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .order-modal .modal-content {
                padding: var(--spacing-lg);
                margin: var(--spacing-md);
                max-height: calc(100vh - 2rem);
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .order-type-selector {
                grid-template-columns: 1fr;
            }
            
            .payment-methods {
                grid-template-columns: 1fr;
            }
            
            .table-grid {
                grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .form-actions .btn {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .order-modal .modal-content {
                padding: var(--spacing-md);
                margin: var(--spacing-sm);
                border-radius: var(--radius-xl);
            }
            
            .section-title {
                font-size: 1rem;
            }
            
            .order-type-icon {
                font-size: 1.2rem;
            }
            
            .table-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: var(--spacing-xs);
            }
            
            .table-item {
                aspect-ratio: 1;
                padding: var(--spacing-xs);
            }
            
            .table-number {
                font-size: 0.8rem;
            }
            
            .table-capacity {
                font-size: 0.6rem;
            }
        }
        
        /* Order Status Modal */
        .order-status-modal {
            z-index: 3000;
        }
        
        /* Loading Overlay */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .loading-spinner {
            text-align: center;
            color: white;
        }
        
        .loading-spinner .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto var(--spacing-md);
        }
        
        .loading-text {
            font-size: 1.1rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .status-content {
            background: white;
            border-radius: var(--radius-xl);
            padding: var(--spacing-2xl);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .status-timeline {
            position: relative;
            margin: var(--spacing-2xl) 0;
        }
        
        .status-timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--light-border);
        }
        
        .status-step {
            position: relative;
            padding-left: 60px;
            margin-bottom: var(--spacing-lg);
        }
        
        .status-step::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--light-border);
            border: 2px solid var(--light-border);
        }
        
        .status-step.completed::before {
            background: var(--success-color);
            border-color: var(--success-color);
        }
        
        .status-step.active::before {
            background: var(--primary-color);
            border-color: var(--primary-color);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        
        .status-title {
            font-weight: 600;
            margin-bottom: var(--spacing-xs);
        }
        
        .status-time {
            font-size: 0.9rem;
            color: var(--light-text);
        }
        
        .preparation-time {
            background: #f0fdf4;
            border: 1px solid var(--success-color);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            margin: var(--spacing-md) 0;
            text-align: center;
        }
        
        .time-remaining {
            font-size: 2rem;
            font-weight: 700;
            color: var(--success-color);
        }
        
        /* Branch Modal */
        .branch-modal {
            z-index: 2500;
        }
        
        .branch-content {
            background: white;
            border-radius: var(--radius-xl);
            padding: var(--spacing-2xl);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .branch-list {
            margin-top: var(--spacing-md);
        }
        
        .branch-item {
            padding: var(--spacing-md);
            border: 1px solid var(--light-border);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-md);
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        
        .branch-item:hover {
            border-color: var(--primary-color);
            background: #fef2f2;
        }
        
        .branch-item.selected {
            border-color: var(--primary-color);
            background: #fef2f2;
        }
        
        .branch-name {
            font-weight: 600;
            margin-bottom: var(--spacing-xs);
        }
        
        .branch-address {
            font-size: 0.9rem;
            color: var(--light-text);
            margin-bottom: var(--spacing-xs);
        }
        
        .branch-status {
            font-size: 0.8rem;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-xl);
            display: inline-block;
        }
        
        .branch-status.open {
            background: #f0fdf4;
            color: var(--success-color);
        }
        
        .branch-status.closed {
            background: #fef2f2;
            color: var(--danger-color);
        }
        
        .branch-distance {
            font-size: 0.8rem;
            color: var(--primary-color);
            margin-top: var(--spacing-xs);
        }
        
        /* Customization Modal */
        .customization-modal {
            z-index: 2000;
        }
        
        .customization-option {
            margin-bottom: var(--spacing-lg);
        }
        
        .option-title {
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
            color: var(--secondary-color);
        }
        
        .option-buttons {
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }
        
        .option-btn {
            background: var(--light-hover);
            border: 1px solid var(--light-border);
            color: var(--secondary-color);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        
        .option-btn:hover,
        .option-btn.selected {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .price-adjustment {
            font-size: 0.9rem;
            color: var(--primary-color);
            font-weight: 500;
        }
        
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 100px;
            right: var(--spacing-md);
            z-index: 3000;
        }
        
        .toast {
            background: var(--success-color);
            color: white;
            padding: var(--spacing-md) var(--spacing-lg);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-sm);
            box-shadow: var(--shadow-lg);
            animation: slideIn var(--transition-normal);
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        
        /* No Results State */
        .no-results {
            text-align: center;
            padding: var(--spacing-2xl) var(--spacing-md);
            color: var(--light-text);
        }
        
        .no-results i {
            font-size: 3rem;
            margin-bottom: var(--spacing-md);
            color: var(--light-border);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: var(--spacing-md);
            }
            
            .header-actions {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .restaurant-name {
                font-size: 1.5rem;
            }
            
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: var(--spacing-md);
            }
            
            .dropdown-menu {
                min-width: 250px;
                right: -50px;
            }
            
            .cart-sidebar {
                width: 100%;
                right: -100%;
                max-width: 400px;
            }
            
            .cart-sidebar.open {
                right: 0;
            }
            
            .cart-header {
                padding: var(--spacing-lg);
            }
            
            .cart-title {
                font-size: 1.3rem;
            }
            
            .close-cart {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
            
            .cart-items {
                padding: var(--spacing-sm);
            }
            
            .cart-item {
                padding: var(--spacing-md);
                margin-bottom: var(--spacing-sm);
            }
            
            .cart-item-info {
                padding-right: var(--spacing-sm);
            }
            
            .cart-item-name {
                font-size: 0.95rem;
                margin-bottom: 2px;
            }
            
            .cart-item-details {
                font-size: 0.75rem;
                margin-bottom: 2px;
            }
            
            .cart-item-price {
                font-size: 0.85rem;
                padding: 1px 6px;
            }
            
            .quantity-controls {
                gap: var(--spacing-xs);
                padding: 2px;
            }
            
            .quantity-btn {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }
            
            .quantity {
                min-width: 28px;
                height: 28px;
                font-size: 0.9rem;
            }
            
            .cart-footer {
                padding: var(--spacing-lg);
            }
            
            .cart-summary {
                padding: var(--spacing-md);
                margin-bottom: var(--spacing-md);
            }
            
            .summary-row {
                font-size: 0.9rem;
            }
            
            .summary-total {
                font-size: 1.2rem;
                padding: var(--spacing-sm) var(--spacing-md);
                margin: var(--spacing-sm) calc(-1 * var(--spacing-md));
            }
            
            .checkout-btn {
                padding: var(--spacing-md);
                font-size: 1rem;
            }
            
            .empty-cart {
                padding: var(--spacing-xl);
            }
            
            .empty-cart i {
                font-size: 3rem;
            }
            
            .empty-cart h3 {
                font-size: 1.2rem;
            }
            
            .empty-cart p {
                font-size: 0.85rem;
            }
            
            .search-filter-section {
                top: 70px;
            }
            
            .category-tabs {
                top: 140px;
            }
            
            .branch-selector {
                position: static;
                margin-top: var(--spacing-sm);
            }
            
            .filter-controls {
                justify-content: center;
            }
            
            .payment-methods {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .header-dropdown-btn span {
                display: none;
            }
            
            .header-actions {
                gap: var(--spacing-sm);
            }
            
            .filter-controls {
                justify-content: center;
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
            }
            
            .cart-sidebar {
                max-width: 100%;
                border-left: none;
            }
            
            .cart-header {
                padding: var(--spacing-md);
            }
            
            .cart-title {
                font-size: 1.2rem;
            }
            
            .close-cart {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-sm);
                padding: var(--spacing-sm);
            }
            
            .cart-item-info {
                padding-right: 0;
                width: 100%;
            }
            
            .cart-item-name {
                font-size: 0.9rem;
            }
            
            .quantity-controls {
                align-self: flex-end;
            }
            
            .cart-footer {
                padding: var(--spacing-md);
            }
            
            .cart-summary {
                padding: var(--spacing-sm);
            }
            
            .summary-total {
                font-size: 1.1rem;
            }
            
            .checkout-btn {
                padding: var(--spacing-sm);
                font-size: 0.95rem;
            }
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .d-flex { display: flex; }
        .d-none { display: none; }
        .d-block { display: block; }
        
        .justify-content-center { justify-content: center; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        
        .mb-1 { margin-bottom: var(--spacing-sm); }
        .mb-2 { margin-bottom: var(--spacing-md); }
        .mb-3 { margin-bottom: var(--spacing-lg); }
        .mb-4 { margin-bottom: var(--spacing-xl); }
        
        .mt-1 { margin-top: var(--spacing-sm); }
        .mt-2 { margin-top: var(--spacing-md); }
        .mt-3 { margin-top: var(--spacing-lg); }
        .mt-4 { margin-top: var(--spacing-xl); }
        
        .p-1 { padding: var(--spacing-sm); }
        .p-2 { padding: var(--spacing-md); }
        .p-3 { padding: var(--spacing-lg); }
        .p-4 { padding: var(--spacing-xl); }
        
        .text-muted { color: var(--light-text); }
        .text-primary { color: var(--primary-color); }
        .text-success { color: var(--success-color); }
        .text-danger { color: var(--danger-color); }
        .text-warning { color: var(--warning-color); }
        
        .bg-light { background-color: var(--light-bg); }
        .bg-primary { background-color: var(--primary-color); }
        .bg-success { background-color: var(--success-color); }
        .bg-danger { background-color: var(--danger-color); }
        
        .rounded { border-radius: var(--radius-md); }
        .rounded-lg { border-radius: var(--radius-lg); }
        .rounded-xl { border-radius: var(--radius-xl); }
        
        .shadow { box-shadow: var(--shadow-md); }
        .shadow-lg { box-shadow: var(--shadow-lg); }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="spinner"></div>
    </div>
    
    <!-- NoScript Fallback -->
    <noscript>
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: white; z-index: 10000; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 20px;">
            <h2 style="color: #dc2626; margin-bottom: 20px;">JavaScript প্রয়োজন</h2>
            <p style="font-size: 18px; margin-bottom: 20px;">QR Menu সিস্টেম ব্যবহার করার জন্য JavaScript সক্রিয় করতে হবে।</p>
            <p style="color: #666;">অনুগ্রহ করে আপনার ব্রাউজারে JavaScript সক্রিয় করে পেজটি রিফ্রেশ করুন।</p>
        </div>
    </noscript>
    
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="restaurant-info">
                    <h1 class="restaurant-name" id="restaurantName">
                        <i class="fas fa-utensils"></i>
                        Loading...
                    </h1>
                    <p class="branch-name" id="branchName">Loading...</p>
                </div>
                
                <div class="header-actions">
                    <!-- Order History Dropdown -->
                    <div class="dropdown" id="orderHistoryDropdown">
                        <button class="btn btn-secondary" id="orderHistoryBtn">
                            <i class="fas fa-history icon-history"></i>
                            <span>অর্ডার ইতিহাস</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="orderHistoryMenu">
                            <div class="dropdown-header">
                                <span><i class="fas fa-history"></i> অর্ডার ইতিহাস</span>
                                <button onclick="clearOrderHistory()" style="background: none; border: none; color: #666; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div id="orderHistoryList">
                                <div class="empty-state">
                                    <i class="fas fa-receipt fa-2x" style="color: #ddd; margin-bottom: 1rem;"></i>
                                    <p>কোনো অর্ডার ইতিহাস পাওয়া যায়নি</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Favorites Dropdown -->
                    <div class="dropdown" id="favoritesDropdown">
                        <button class="btn btn-secondary" id="favoritesBtn">
                            <i class="fas fa-heart icon-favorite"></i>
                            <span>পছন্দের আইটেম</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="favoritesMenu">
                            <div class="dropdown-header">
                                <span><i class="fas fa-heart"></i> পছন্দের আইটেম</span>
                                <span id="favoritesCount">0</span>
                            </div>
                            <div id="favoritesList">
                                <div class="empty-state">
                                    <i class="fas fa-heart fa-2x" style="color: #ddd; margin-bottom: 1rem;"></i>
                                    <p>কোনো পছন্দের আইটেম পাওয়া যায়নি</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Branch Selector -->
                    <button class="btn btn-secondary" id="branchSelector">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>শাখা পরিবর্তন</span>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <div class="container">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="খাবার খুঁজুন...">
            </div>
            
            <!-- Filter Sections -->
            <div class="filter-section">
                <div class="filter-section-title">
                    <i class="fas fa-filter"></i>
                    <span>ফিল্টার করুন</span>
                </div>
                <div class="filter-controls">
                    <button class="filter-btn" data-filter="price-low">
                        <i class="fas fa-arrow-down"></i>
                        কম দাম
                    </button>
                    <button class="filter-btn" data-filter="price-high">
                        <i class="fas fa-arrow-up"></i>
                        বেশি দাম
                    </button>
                    <button class="filter-btn" data-filter="vegetarian">
                        <i class="fas fa-leaf"></i>
                        সবজি
                    </button>
                    <button class="filter-btn" data-filter="spicy">
                        <i class="fas fa-pepper-hot"></i>
                        ঝাল
                    </button>
                    <button class="filter-btn" data-filter="popular">
                        <i class="fas fa-star"></i>
                        জনপ্রিয়
                    </button>
                    <button class="filter-btn" data-filter="available">
                        <i class="fas fa-check-circle"></i>
                        পাওয়া যাচ্ছে
                    </button>
                </div>
            </div>
            
            <!-- Sort Section -->
            <div class="filter-section">
                <div class="filter-section-title">
                    <i class="fas fa-sort"></i>
                    <span>সাজান</span>
                </div>
                <select class="sort-select" id="sortSelect">
                    <option value="name">নাম অনুযায়ী</option>
                    <option value="price-low">কম দাম অনুযায়ী</option>
                    <option value="price-high">বেশি দাম অনুযায়ী</option>
                    <option value="popular">জনপ্রিয়তা অনুযায়ী</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Category Tabs -->
    <div class="category-tabs">
        <div class="container">
            <div class="category-nav" id="categoryNav">
                <!-- Categories will be loaded here -->
            </div>
        </div>
    </div>
    
    <!-- Menu Container -->
    <div class="menu-container" id="menuContainer">
        <!-- Menu items will be loaded here -->
    </div>
    
    <!-- Cart Toggle Button -->
    <button class="cart-toggle" id="cartToggle">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count" id="cartCount">0</span>
    </button>
    
    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3 class="cart-title">আপনার অর্ডার</h3>
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <!-- Cart items will be loaded here -->
        </div>
        <div class="cart-footer">
            <div class="cart-summary">
                <div class="summary-row">
                    <span>সাবটোটাল:</span>
                    <span id="subtotal">৳0</span>
                </div>
                <div class="summary-row">
                    <span>ভ্যাট (5%):</span>
                    <span id="vat">৳0</span>
                </div>
                <div class="summary-row">
                    <span>সার্ভিস চার্জ (10%):</span>
                    <span id="serviceCharge">৳0</span>
                </div>
                <div class="summary-row summary-total">
                    <span>সর্বমোট:</span>
                    <span id="total">৳0</span>
                </div>
            </div>
            <button class="checkout-btn" id="checkoutBtn">অর্ডার করুন</button>
        </div>
    </div>
    
    <!-- Customization Modal -->
    <div class="modal customization-modal" id="customizationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="customizationTitle">আইটেম কাস্টমাইজ করুন</h3>
                <button class="close-modal" id="closeCustomization">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="customization-options" id="customizationOptions">
                <!-- Customization options will be loaded here -->
            </div>
            <div class="form-group">
                <label class="form-label">বিশেষ নির্দেশনা:</label>
                <textarea class="form-control" id="specialNotes" rows="3" placeholder="কোনো বিশেষ নির্দেশনা থাকলে লিখুন..."></textarea>
            </div>
            <div class="menu-footer">
                <div class="menu-price" id="customizedPrice">৳0</div>
                <button class="btn btn-primary" id="addToCartCustomized">কার্টে যোগ করুন</button>
            </div>
        </div>
    </div>
    
    <!-- Order Modal -->
    <div class="modal order-modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">অর্ডার সম্পন্ন করুন</h3>
                <button class="close-modal" id="closeOrderModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="orderForm">
                <div class="form-section">
                    <h4 class="section-title">গ্রাহক তথ্য</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">নাম:</label>
                            <input type="text" class="form-control" id="customerName" required placeholder="আপনার নাম লিখুন">
                        </div>
                        <div class="form-group">
                            <label class="form-label">ফোন নম্বর:</label>
                            <input type="tel" class="form-control" id="customerPhone" required placeholder="01XXX-XXXXXX">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">অর্ডারের বিবরণ</h4>
                    <div class="form-group">
                        <label class="form-label">অর্ডারের ধরন:</label>
                        <div class="order-type-selector">
                            <div class="order-type-option" data-type="dine_in">
                                <div class="order-type-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="order-type-text">
                                    <div class="order-type-name">ডাইন-ইন</div>
                                    <div class="order-type-desc">রেস্তোরাঁয় খাবার</div>
                                </div>
                            </div>
                            <div class="order-type-option" data-type="takeaway">
                                <div class="order-type-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="order-type-text">
                                    <div class="order-type-name">টেকঅয়ে</div>
                                    <div class="order-type-desc">নিয়ে যাবেন</div>
                                </div>
                            </div>
                            <div class="order-type-option" data-type="delivery">
                                <div class="order-type-icon">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <div class="order-type-text">
                                    <div class="order-type-name">ডেলিভারি</div>
                                    <div class="order-type-desc">বাসায় ডেলিভারি</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="orderType" value="dine_in" required>
                    </div>

                    <!-- Table Selection (Dine-in Only) -->
                    <div class="form-group table-section" id="tableSection">
                        <label class="form-label">টেবিল নির্বাচন:</label>
                        <div class="table-selector">
                            <div class="table-loading">
                                <i class="fas fa-spinner fa-spin"></i> টেবিল লোড হচ্ছে...
                            </div>
                            <div class="table-grid" id="tableGrid" style="display: none;">
                                <!-- Tables will be loaded here -->
                            </div>
                        </div>
                        <input type="hidden" id="selectedTable" required>
                    </div>

                    <!-- Delivery Address (Delivery Only) -->
                    <div class="form-group delivery-section" id="deliverySection" style="display: none;">
                        <label class="form-label">ডেলিভারির ঠিকানা:</label>
                        <div class="address-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">ঠিকানা:</label>
                                    <textarea class="form-control" id="deliveryAddress" rows="2" placeholder="সম্পূর্ণ ঠিকানা লিখুন"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">এরিয়া:</label>
                                    <input type="text" class="form-control" id="deliveryArea" placeholder="এরিয়ার নাম">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">ল্যান্ডমার্ক:</label>
                                    <input type="text" class="form-control" id="deliveryLandmark" placeholder="নিকটবর্তী ল্যান্ডমার্ক">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ফ্ল্যাট/হাউস নং:</label>
                                    <input type="text" class="form-control" id="deliveryFlat" placeholder="ফ্ল্যাট বা হাউস নম্বর">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">পেমেন্ট তথ্য</h4>
                    <div class="form-group">
                        <label class="form-label">পেমেন্ট পদ্ধতি:</label>
                        <div class="payment-methods">
                            <div class="payment-method" data-payment="cash">
                                <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                                <div class="payment-name">ক্যাশ</div>
                                <div class="payment-desc">নগদ পেমেন্ট</div>
                            </div>
                            <div class="payment-method" data-payment="card">
                                <div class="payment-icon"><i class="fas fa-credit-card"></i></div>
                                <div class="payment-name">কার্ড</div>
                                <div class="payment-desc">ডেবিট/ক্রেডিট কার্ড</div>
                            </div>
                            <div class="payment-method" data-payment="bkash">
                                <div class="payment-icon"><i class="fas fa-mobile-alt"></i></div>
                                <div class="payment-name">bKash</div>
                                <div class="payment-desc">মোবাইল ব্যাংকিং</div>
                            </div>
                            <div class="payment-method" data-payment="nagad">
                                <div class="payment-icon"><i class="fas fa-mobile-alt"></i></div>
                                <div class="payment-name">Nagad</div>
                                <div class="payment-desc">মোবাইল ব্যাংকিং</div>
                            </div>
                            <div class="payment-method" data-payment="rocket">
                                <div class="payment-icon"><i class="fas fa-rocket"></i></div>
                                <div class="payment-name">Rocket</div>
                                <div class="payment-desc">মোবাইল ব্যাংকিং</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">অতিরিক্ত তথ্য</h4>
                    <div class="form-group">
                        <label class="form-label">বিশেষ নির্দেশনা:</label>
                        <textarea class="form-control" id="orderNotes" rows="3" placeholder="কোনো বিশেষ নির্দেশনা থাকলে লিখুন..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelOrder">বাতিল করুন</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i>
                        অর্ডার সম্পন্ন করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Order Status Modal -->
    <div class="modal order-status-modal" id="orderStatusModal">
        <div class="status-content">
            <div class="modal-header">
                <h3 class="modal-title">অর্ডার স্ট্যাটাস</h3>
                <button class="close-modal" id="closeStatusModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="order-info">
                <h4>অর্ডার #<span id="orderNumber"></span></h4>
                <p id="orderTime"></p>
            </div>
            <div class="preparation-time">
                <div>প্রস্তুতের সময়</div>
                <div class="time-remaining" id="timeRemaining">--:--</div>
                <div id="preparationStatus"></div>
            </div>
            <div class="status-timeline" id="statusTimeline">
                <div class="status-step completed">
                    <div class="status-title">অর্ডার গৃহীত</div>
                    <div class="status-time" id="orderReceivedTime"></div>
                </div>
                <div class="status-step" id="confirmedStep">
                    <div class="status-title">অর্ডার নিশ্চিত</div>
                    <div class="status-time"></div>
                </div>
                <div class="status-step" id="preparingStep">
                    <div class="status-title">প্রস্তুত হচ্ছে</div>
                    <div class="status-time"></div>
                </div>
                <div class="status-step" id="readyStep">
                    <div class="status-title">প্রস্তুত</div>
                    <div class="status-time"></div>
                </div>
                <div class="status-step" id="servedStep">
                    <div class="status-title">পরিবেশিত</div>
                    <div class="status-time"></div>
                </div>
            </div>
            
            <!-- Order Items Section -->
            <div class="order-items-section">
                <h3 class="order-items-title">
                    <i class="fas fa-utensils"></i>
                    অর্ডারকৃত আইটেম
                </h3>
                <div class="order-items-list" id="orderItemsList">
                    <!-- Items will be populated dynamically -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Branch Selector Modal -->
    <div class="modal branch-modal" id="branchModal">
        <div class="branch-content">
            <div class="modal-header">
                <h3 class="modal-title">শাখা নির্বাচন করুন</h3>
                <button class="close-modal" id="closeBranchModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="branch-list" id="branchList">
                <!-- Branches will be loaded here -->
            </div>
        </div>
    </div>
    
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <script>
        /**
         * Restaurant Management System - Digital Menu
         * JavaScript Application
         * 
         * A comprehensive digital menu system with real-time order tracking,
         * cart management, and multi-branch support.
         * 
         * @version 2.0.0
         * @author Restaurant Management System
         */
        
        // Global Application State
        const AppState = {
            // Data Storage
            cart: [],
            categories: [],
            menuItems: [],
            branches: [],
            itemQuantities: {},
            
            // User Preferences
            selectedPaymentMethod: '',
            branchId: new URLSearchParams(window.location.search).get('branch') || '1',
            tableId: new URLSearchParams(window.location.search).get('table') || '',
            
            // Filtering and Search
            currentFilters: {
                search: '',
                category: '',
                priceRange: null,
                dietary: [],
                spiceLevel: null,
                availability: null,
                popularity: null,
                sortBy: 'name'
            },
            
            // Order Management
            orderHistory: [],
            favorites: [],
            currentOrder: null,
            
            // Timers and Intervals
            statusUpdateInterval: null,
            backgroundUpdateInterval: null,
            
            // Configuration
            config: {
                apiBaseUrl: '/qrmenu/api',
                preparationTime: 20, // Fixed 20 minutes for all orders
                statusUpdateInterval: 10000, // 10 seconds
                backgroundUpdateInterval: 30000, // 30 seconds
                toastDuration: 3000,
                animationDelay: 100
            }
        };
        
        // Utility Functions
        const Utils = {
            /**
             * Safely parse JSON with error handling
             * @param {string} jsonString - JSON string to parse
             * @param {any} defaultValue - Default value if parsing fails
             * @returns {any} Parsed JSON or default value
             */
            safeJsonParse: (jsonString, defaultValue = null) => {
                try {
                    return JSON.parse(jsonString);
                } catch (error) {
                    console.warn('JSON parsing error:', error);
                    return defaultValue;
                }
            },
            
            /**
             * Format currency in Bangladeshi Taka
             * @param {number} amount - Amount to format
             * @returns {string} Formatted currency string
             */
            formatCurrency: (amount) => {
                return `৳${Math.round(amount)}`;
            },
            
            /**
             * Format date in Bengali locale
             * @param {Date|string} date - Date to format
             * @returns {string} Formatted date string
             */
            formatDate: (date) => {
                const dateObj = date instanceof Date ? date : new Date(date);
                if (isNaN(dateObj.getTime())) {
                    dateObj = new Date();
                }
                return dateObj.toLocaleDateString('bn-BD');
            },
            
            /**
             * Format time in Bengali locale
             * @param {Date|string} time - Time to format
             * @returns {string} Formatted time string
             */
            formatTime: (time) => {
                const timeObj = time instanceof Date ? time : new Date(time);
                if (isNaN(timeObj.getTime())) {
                    timeObj = new Date();
                }
                return timeObj.toLocaleTimeString('bn-BD');
            },
            
            /**
             * Debounce function to limit how often a function can be called
             * @param {Function} func - Function to debounce
             * @param {number} wait - Wait time in milliseconds
             * @returns {Function} Debounced function
             */
            debounce: (func, wait) => {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            },
            
            /**
             * Throttle function to limit how often a function can be called
             * @param {Function} func - Function to throttle
             * @param {number} limit - Limit time in milliseconds
             * @returns {Function} Throttled function
             */
            throttle: (func, limit) => {
                let inThrottle;
                return function() {
                    const args = arguments;
                    const context = this;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                };
            },
            
            /**
             * Generate unique ID
             * @returns {string} Unique ID
             */
            generateId: () => {
                return Date.now().toString(36) + Math.random().toString(36).substr(2);
            },
            
            /**
             * Validate email address
             * @param {string} email - Email to validate
             * @returns {boolean} True if valid email
             */
            validateEmail: (email) => {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            },
            
            /**
             * Validate phone number (Bangladeshi format)
             * @param {string} phone - Phone number to validate
             * @returns {boolean} True if valid phone number
             */
            validatePhone: (phone) => {
                const re = /^(?:\+?88)?01[3-9]\d{8}$/;
                return re.test(phone);
            },
            
            /**
             * Show loading state
             * @param {HTMLElement} element - Element to show loading state
             * @param {string} text - Loading text
             */
            showLoading: (element, text = 'Loading...') => {
                element.disabled = true;
                element.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${text}`;
            },
            
            /**
             * Hide loading state
             * @param {HTMLElement} element - Element to hide loading state
             * @param {string} text - Original text
             */
            hideLoading: (element, text) => {
                element.disabled = false;
                element.innerHTML = text;
            },
            
            /**
             * Scroll to element
             * @param {HTMLElement} element - Element to scroll to
             * @param {number} offset - Offset from top
             */
            scrollToElement: (element, offset = 0) => {
                const elementPosition = element.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        };
        
        // API Service
        const ApiService = {
            /**
             * Make API request with error handling
             * @param {string} endpoint - API endpoint
             * @param {Object} options - Request options
             * @returns {Promise} API response
             */
            async request(endpoint, options = {}) {
                const url = `${AppState.config.apiBaseUrl}${endpoint}`;
                const defaultOptions = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                };
                
                try {
                    // Add timeout to fetch request
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 15000); // 15 second timeout
                    
                    const fetchOptions = {
                        ...defaultOptions,
                        ...options,
                        signal: controller.signal
                    };
                    
                    const response = await fetch(url, fetchOptions);
                    clearTimeout(timeoutId);
                    
                    // Check if response is ok before parsing JSON
                    if (!response.ok) {
                        let errorMessage = `HTTP error! status: ${response.status}`;
                        try {
                            const errorResult = await response.json();
                            errorMessage = errorResult.message || errorMessage;
                        } catch (e) {
                            // If JSON parsing fails, use the status message
                        }
                        throw new Error(errorMessage);
                    }
                    
                    // Parse JSON response
                    const result = await response.json();
                    
                    // Check if API returned success: false
                    if (result.hasOwnProperty('success') && !result.success) {
                        throw new Error(result.error || 'API request failed');
                    }
                    
                    return result;
                } catch (error) {
                    console.error('API request failed:', error);
                    
                    // Handle specific error types
                    if (error.name === 'AbortError') {
                        throw new Error('Request timeout - API took too long to respond');
                    } else if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
                        throw new Error('Network error - Unable to connect to API');
                    }
                    
                    throw error;
                }
            },
            
            /**
             * Get restaurant info
             * @param {string} branchId - Branch ID
             * @returns {Promise} Restaurant info
             */
            async getRestaurantInfo(branchId) {
                return this.request(`/branches/${branchId}`);
            },
            
            /**
             * Get categories
             * @returns {Promise} Categories list
             */
            async getCategories() {
                return this.request('/categories');
            },
            
            /**
             * Get menu items
             * @param {string} branchId - Branch ID
             * @returns {Promise} Menu items list
             */
            async getMenuItems(branchId) {
                return this.request(`/menu-items?branch_id=${branchId}`);
            },
            
            /**
             * Get branches
             * @returns {Promise} Branches list
             */
            async getBranches() {
                return this.request('/branches');
            },
            
            /**
             * Get order details
             * @param {string} orderId - Order ID
             * @returns {Promise} Order details
             */
            async getOrder(orderId) {
                return this.request(`/orders/${orderId}`);
            },
            
            /**
             * Create order
             * @param {Object} orderData - Order data
             * @returns {Promise} Created order
             */
            async createOrder(orderData) {
                return this.request('/orders', {
                    method: 'POST',
                    body: JSON.stringify(orderData)
                });
            }
        };
        
        // UI Service
        const UIService = {
            /**
             * Show toast notification
             * @param {string} message - Message to show
             * @param {string} type - Toast type (success, error, info, warning)
             */
            showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.className = 'toast';
                toast.textContent = message;
                
                // Set toast color based on type
                const colors = {
                    success: 'var(--success-color)',
                    error: 'var(--danger-color)',
                    info: '#3498db',
                    warning: 'var(--warning-color)'
                };
                
                if (colors[type]) {
                    toast.style.background = colors[type];
                }
                
                toastContainer.appendChild(toast);
                
                // Auto-remove toast after duration
                setTimeout(() => {
                    toast.remove();
                }, AppState.config.toastDuration);
            },
            
            /**
             * Close all dropdowns
             */
            closeAllDropdowns() {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            },
            
            /**
             * Show modal
             * @param {string} modalId - Modal ID
             */
            showModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('show');
                }
            },
            
            /**
             * Hide modal
             * @param {string} modalId - Modal ID
             */
            hideModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('show');
                }
            },
            
            /**
             * Show loading indicator
             */
            showLoading() {
                // Create loading overlay if it doesn't exist
                let loadingOverlay = document.getElementById('loadingOverlay');
                if (!loadingOverlay) {
                    loadingOverlay = document.createElement('div');
                    loadingOverlay.id = 'loadingOverlay';
                    loadingOverlay.innerHTML = `
                        <div class="loading-spinner">
                            <div class="spinner"></div>
                            <div class="loading-text">লোড হচ্ছে...</div>
                        </div>
                    `;
                    document.body.appendChild(loadingOverlay);
                }
                loadingOverlay.style.display = 'flex';
            },
            
            /**
             * Hide loading indicator
             */
            hideLoading() {
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'none';
                }
            },
            
            /**
             * Toggle cart sidebar
             */
            toggleCart() {
                const cartSidebar = document.getElementById('cartSidebar');
                cartSidebar.classList.toggle('open');
            },
            
            /**
             * Update cart display
             */
            updateCartDisplay() {
                try {
                    const cartItems = document.getElementById('cartItems');
                    const cartCount = document.getElementById('cartCount');
                    const subtotal = document.getElementById('subtotal');
                    const vat = document.getElementById('vat');
                    const serviceCharge = document.getElementById('serviceCharge');
                    const total = document.getElementById('total');
                    
                    cartItems.innerHTML = '';
                    let itemCount = 0;
                    let subtotalAmount = 0;
                    
                    if (AppState.cart.length === 0) {
                        // Show empty cart state
                        cartItems.innerHTML = `
                            <div class="empty-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <h3>আপনার কার্ট খালি</h3>
                                <p>কিছু সুস্বাদু খাবার যোগ করে শুরু করুন!</p>
                            </div>
                        `;
                    } else {
                        AppState.cart.forEach(item => {
                            itemCount += item.quantity;
                            subtotalAmount += item.price * item.quantity;
                            
                            const cartItem = document.createElement('div');
                            cartItem.className = 'cart-item';
                            cartItem.innerHTML = `
                                <div class="cart-item-info">
                                    <div class="cart-item-name">${item.name}</div>
                                    ${item.customization.length > 0 ? `<div class="cart-item-details">${item.customization.join(', ')}</div>` : ''}
                                    ${item.specialNotes ? `<div class="cart-item-details">নোট: ${item.specialNotes}</div>` : ''}
                                    <div class="cart-item-price">${Utils.formatCurrency(item.price)} x ${item.quantity}</div>
                                </div>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="CartService.updateQuantity('${item.id}', -1)" title="কমান">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="quantity">${item.quantity}</span>
                                    <button class="quantity-btn" onclick="CartService.updateQuantity('${item.id}', 1)" title="বাড়ান">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            `;
                            cartItems.appendChild(cartItem);
                        });
                    }
                    
                    const vatAmount = subtotalAmount * 0.05;
                    const serviceChargeAmount = subtotalAmount * 0.10;
                    const totalAmount = subtotalAmount + vatAmount + serviceChargeAmount;
                    
                    cartCount.textContent = itemCount;
                    subtotal.textContent = Utils.formatCurrency(subtotalAmount);
                    vat.textContent = Utils.formatCurrency(vatAmount);
                    serviceCharge.textContent = Utils.formatCurrency(serviceChargeAmount);
                    total.textContent = Utils.formatCurrency(totalAmount);
                } catch (error) {
                    console.error('Error in updateCartDisplay:', error);
                }
            },
            
            /**
             * Create menu item card
             * @param {Object} item - Menu item data
             * @returns {HTMLElement} Menu item card element
             */
            createMenuItemCard(item) {
                const card = document.createElement('div');
                card.className = 'menu-card';
                
                const isFavorite = AppState.favorites.some(f => f.id === item.id);
                
                card.innerHTML = `
                    <div class="menu-image">
                        ${item.image ? 
                            `<img src="${item.image}" alt="${item.name_bn || item.name}" style="width: 100%; height: 100%; object-fit: cover;">` :
                            `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f1f5f9, #e2e8f0);">
                                <i class="fas fa-utensils fa-3x" style="color: #cbd5e1;"></i>
                            </div>`
                        }
                        ${!item.is_available ? '<div class="menu-badge">অনুপলব্ধ</div>' : ''}
                        ${item.is_popular ? '<div class="menu-badge" style="background: var(--warning-color);">জনপ্রিয়</div>' : ''}
                    </div>
                    <div class="menu-content">
                        <div class="menu-header">
                            <h3 class="menu-name">${item.name_bn || item.name}</h3>
                            <div class="menu-price">${Utils.formatCurrency(item.price)}</div>
                        </div>
                        <p class="menu-description">${item.description_bn || item.description || ''}</p>
                        <div class="menu-meta">
                            ${item.is_vegetarian ? 
                                `<span class="menu-tag vegetarian">
                                    <i class="fas fa-leaf"></i>
                                    সবজি
                                </span>` : ''
                            }
                            ${item.is_spicy && item.is_spicy !== 'none' ? 
                                `<span class="menu-tag spicy">
                                    <i class="fas fa-pepper-hot"></i>
                                    ${item.is_spicy === 'mild' ? 'মৃদু ঝাল' : 
                                      item.is_spicy === 'medium' ? 'মাঝারি ঝাল' : 
                                      item.is_spicy === 'hot' ? 'ঝাল' : 'ঝাল'}
                                </span>` : ''
                            }
                            ${item.preparation_time ? 
                                `<span class="menu-tag">
                                    <i class="fas fa-clock"></i>
                                    ${item.preparation_time}মিনিট
                                </span>` : ''
                            }
                        </div>
                        <div class="menu-actions">
                            <button class="favorite-btn ${isFavorite ? 'active' : ''}" onclick="FavoriteService.toggle(${item.id})" title="পছন্দের তালিকায় যোগ করুন">
                                <i class="fas fa-heart"></i>
                            </button>
                            <div class="menu-item-controls" data-item-id="${item.id}">
                                <button class="add-to-cart-btn" onclick="MenuService.showCustomization(${item.id})" ${!item.is_available ? 'disabled' : ''}>
                                    <i class="fas fa-plus"></i>
                                    <span>${!item.is_available ? 'অনুপলব্ধ' : 'কার্টে যোগ করুন'}</span>
                                </button>
                                <div class="quantity-selector">
                                    <button class="quantity-btn" onclick="MenuService.decreaseQuantity(${item.id})" title="কমান">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <div class="quantity-display" id="quantity-${item.id}">1</div>
                                    <button class="quantity-btn" onclick="MenuService.increaseQuantity(${item.id})" title="বাড়ান">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                return card;
            },
            
            /**
             * Render menu items
             */
            renderMenuItems() {
                const container = document.getElementById('menuContainer');
                container.innerHTML = '';
                
                if (!AppState.menuItems || AppState.menuItems.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center p-5">
                            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                            <h3 class="text-muted">কোনো মেনু আইটেম পাওয়া যায়নি</h3>
                            <p class="text-muted">এই শাখার জন্য কোনো মেনু আইটেম উপলব্ধ নেই</p>
                            <button class="btn btn-outline-primary" onclick="MenuService.loadMenuItems()">
                                <i class="fas fa-sync-alt"></i> পুনরায় চেষ্টা করুন
                            </button>
                        </div>
                    `;
                    return;
                }
                
                const filteredItems = MenuService.filterMenuItems();
                
                if (filteredItems.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center p-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3 class="text-muted">কোনো আইটেম পাওয়া যায়নি</h3>
                            <p class="text-muted">অন্য ফিল্টার বা সার্চ টার্ম চেষ্টা করুন</p>
                            <button class="btn btn-outline-primary" onclick="MenuService.clearFilters()">
                                <i class="fas fa-times"></i> ফিল্টার সাফ করুন
                            </button>
                        </div>
                    `;
                    return;
                }
                
                // Group by category
                const groupedItems = {};
                filteredItems.forEach(item => {
                    if (!groupedItems[item.category_id]) {
                        groupedItems[item.category_id] = [];
                    }
                    groupedItems[item.category_id].push(item);
                });
                
                // Render each category section
                Object.keys(groupedItems).forEach(categoryId => {
                    const category = AppState.categories.find(c => c.id == categoryId);
                    if (!category) return;
                    
                    const section = document.createElement('div');
                    section.className = 'menu-section';
                    
                    const title = document.createElement('h2');
                    title.className = 'section-title';
                    title.textContent = category.name_bn || category.name;
                    section.appendChild(title);
                    
                    const grid = document.createElement('div');
                    grid.className = 'menu-grid';
                    
                    groupedItems[categoryId].forEach(item => {
                        const card = this.createMenuItemCard(item);
                        grid.appendChild(card);
                    });
                    
                    section.appendChild(grid);
                    container.appendChild(section);
                });
            },
            
            /**
             * Render categories
             */
            renderCategories() {
                const categoryNav = document.getElementById('categoryNav');
                categoryNav.innerHTML = '';
                
                // Add "All" category
                const allBtn = document.createElement('button');
                allBtn.className = 'category-btn active';
                allBtn.textContent = 'সব';
                allBtn.onclick = () => MenuService.filterByCategory('all');
                categoryNav.appendChild(allBtn);
                
                AppState.categories.forEach(category => {
                    const btn = document.createElement('button');
                    btn.className = 'category-btn';
                    btn.textContent = category.name_bn || category.name;
                    btn.onclick = () => MenuService.filterByCategory(category.id);
                    categoryNav.appendChild(btn);
                });
            },
            
            /**
             * Render branches
             */
            renderBranches() {
                const branchList = document.getElementById('branchList');
                branchList.innerHTML = '';
                
                if (!AppState.branches || AppState.branches.length === 0) {
                    branchList.innerHTML = '<div class="text-center text-muted p-4">কোন শাখা পাওয়া যায়নি।</div>';
                    return;
                }
                
                AppState.branches.forEach(branch => {
                    const branchItem = document.createElement('div');
                    branchItem.className = 'branch-item';
                    if (branch.id == AppState.branchId) {
                        branchItem.classList.add('selected');
                    }
                    
                    const isOpen = BranchService.isBranchOpen(branch.opening_time, branch.closing_time);
                    const distance = BranchService.calculateDistance(branch.latitude, branch.longitude);
                    
                    branchItem.innerHTML = `
                        <div class="branch-name">${branch.name}</div>
                        <div class="branch-address">${branch.address}, ${branch.district}</div>
                        <div class="branch-status ${isOpen ? 'open' : 'closed'}">
                            ${isOpen ? 'খোলা' : 'বন্ধ'}
                        </div>
                        ${distance ? `<div class="branch-distance">দূরত্ব: ${distance} কিমি</div>` : ''}
                    `;
                    
                    branchItem.onclick = () => BranchService.switchBranch(branch.id);
                    branchList.appendChild(branchItem);
                });
            },
            
            /**
             * Load order history
             */
            loadOrderHistory() {
                const orderHistory = Utils.safeJsonParse(localStorage.getItem(`orderHistory_${AppState.branchId}`), []);
                const orderHistoryList = document.getElementById('orderHistoryList');
                
                if (orderHistory.length === 0) {
                    orderHistoryList.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-receipt fa-2x" style="color: #ddd; margin-bottom: 1rem;"></i>
                            <p>কোনো অর্ডার ইতিহাস পাওয়া যায়নি</p>
                        </div>
                    `;
                    return;
                }
                
                orderHistoryList.innerHTML = orderHistory.slice(0, 10).reverse().map(order => `
                    <div class="dropdown-item" onclick="OrderService.viewOrderDetails('${order.id}')">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <strong>অর্ডার #${order.id}</strong>
                            <span style="color: #666; font-size: 0.9rem;">${Utils.formatDate(order.date)}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--primary-color); font-weight: 600;">${Utils.formatCurrency(order.total)}</span>
                            <span class="order-status ${order.status}">${OrderService.getStatusText(order.status)}</span>
                        </div>
                    </div>
                `).join('');
            },
            
            /**
             * Load favorites
             */
            loadFavorites() {
                const favorites = Utils.safeJsonParse(localStorage.getItem(`favorites_${AppState.branchId}`), []);
                const favoritesList = document.getElementById('favoritesList');
                const favoritesCount = document.getElementById('favoritesCount');
                
                AppState.favorites = favorites;
                favoritesCount.textContent = favorites.length;
                
                if (favorites.length === 0) {
                    favoritesList.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-heart fa-2x" style="color: #ddd; margin-bottom: 1rem;"></i>
                            <p>কোনো পছন্দের আইটেম পাওয়া যায়নি</p>
                        </div>
                    `;
                    return;
                }
                
                favoritesList.innerHTML = favorites.map(item => `
                    <div class="dropdown-item">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <div>
                                <div style="font-weight: 600;">${item.name_bn}</div>
                                <div style="color: #666; font-size: 0.9rem;">${item.name}</div>
                            </div>
                            <span style="color: var(--primary-color); font-weight: 600;">${Utils.formatCurrency(item.price)}</span>
                        </div>
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <button class="dropdown-action add-to-cart" onclick="event.stopPropagation(); CartService.addToCartFromFavorites(${item.id})" title="কার্টে যোগ করুন">
                                <i class="fas fa-plus"></i> কার্টে যোগ করুন
                            </button>
                            <button class="dropdown-action remove-favorite" onclick="event.stopPropagation(); FavoriteService.removeFromFavorites(${item.id})" title="পছন্দ থেকে সরান">
                                <i class="fas fa-trash"></i> সরান
                            </button>
                        </div>
                    </div>
                `).join('');
            },
            
            /**
             * Display order items in status modal
             * @param {Array} items - Order items
             */
            displayOrderItems(items) {
                const orderItemsList = document.getElementById('orderItemsList');
                
                if (!items || items.length === 0) {
                    orderItemsList.innerHTML = '<div class="empty-state">কোনো আইটেম পাওয়া যায়নি</div>';
                    return;
                }
                
                orderItemsList.innerHTML = items.map(item => {
                    const preparationTime = item.preparation_time || 15;
                    const totalPrice = (item.unit_price * item.quantity).toFixed(2);
                    const itemName = item.name_bn || item.name_en || 'আইটেম';
                    let itemDescription = '';
                    
                    // Handle descriptions with fallback
                    if (item.description_bn && item.description_bn.trim() !== '') {
                        itemDescription = item.description_bn;
                    } else if (item.description_en && item.description_en.trim() !== '') {
                        itemDescription = item.description_en;
                    }
                    
                    // Handle image with same placeholder style as menu item cards
                    let imageContent;
                    if (item.image && item.image.trim() !== '') {
                        const imageUrl = item.image.trim();
                        const imageAltText = itemName;
                        
                        imageContent = `
                            <img src="${imageUrl}" 
                                 alt="${imageAltText}" 
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                                 loading="lazy"
                                 onload="this.parentElement.classList.remove('loading')"
                                 onerror="
                                     this.parentElement.classList.remove('loading');
                                     this.parentElement.innerHTML = '<div style=\\'width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 8px;\\'><i class=\\'fas fa-utensils fa-2x\\' style=\\'color: #cbd5e1;\\'></i></div>';
                                 ">
                        `;
                    } else {
                        imageContent = `
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 8px;">
                                <i class="fas fa-utensils fa-2x" style="color: #cbd5e1;"></i>
                            </div>
                        `;
                    }
                    
                    return `
                        <div class="order-item">
                            <div class="order-item-image-container loading" style="width: 80px; height: 80px; position: relative;">
                                ${imageContent}
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-name">${itemName}</div>
                                ${itemDescription ? `<div class="order-item-description">${itemDescription}</div>` : ''}
                                <div class="order-item-meta">
                                    <div class="order-item-quantity">পরিমাণ: ${item.quantity}</div>
                                    <div class="order-item-price">${Utils.formatCurrency(totalPrice)}</div>
                                </div>
                                <div class="order-item-preparation-time">
                                    <i class="fas fa-clock"></i>
                                    প্রস্তুতির সময়: ${preparationTime} মিনিট
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                // Remove loading class from containers that don't have loading images
                setTimeout(() => {
                    const containers = orderItemsList.querySelectorAll('.order-item-image-container');
                    containers.forEach(container => {
                        const img = container.querySelector('img');
                        if (!img || img.complete) {
                            container.classList.remove('loading');
                        }
                    });
                }, 100);
            }
        };
        
        // Menu Service
        const MenuService = {
            /**
             * Load menu items from API
             */
            async loadMenuItems() {
                try {
                    console.log('Loading menu items for branch:', AppState.branchId);
                    const response = await ApiService.getMenuItems(AppState.branchId);
                    
                    console.log('Menu Items API Response:', response);
                    
                    if (response.data && Array.isArray(response.data)) {
                        AppState.menuItems = response.data;
                        console.log('Loaded', AppState.menuItems.length, 'menu items');
                        UIService.renderMenuItems();
                    } else {
                        console.error('Invalid menu items data format:', response);
                        const container = document.getElementById('menuContainer');
                        container.innerHTML = '<div class="col-12 text-center text-danger p-4">মেনু আইটেম লোড করা যায়নি। দয়া করে পুনরায় চেষ্টা করুন।</div>';
                    }
                } catch (error) {
                    console.error('Error loading menu items:', error);
                    const container = document.getElementById('menuContainer');
                    container.innerHTML = '<div class="col-12 text-center text-danger p-4">মেনু আইটেম লোড করা যায়নি। দয়া করে পুনরায় চেষ্টা করুন।</div>';
                }
            },
            
            /**
             * Filter menu items based on current filters
             * @returns {Array} Filtered menu items
             */
            filterMenuItems() {
                let filtered = [...AppState.menuItems];
                
                // Apply search filter
                if (AppState.currentFilters.search) {
                    const searchTerm = AppState.currentFilters.search.toLowerCase();
                    filtered = filtered.filter(item => 
                        item.name.toLowerCase().includes(searchTerm) ||
                        item.name_bn.toLowerCase().includes(searchTerm) ||
                        item.description.toLowerCase().includes(searchTerm) ||
                        item.description_bn.toLowerCase().includes(searchTerm)
                    );
                }
                
                // Apply price filter
                if (AppState.currentFilters.priceRange === 'low') {
                    filtered = filtered.filter(item => item.price <= 200);
                } else if (AppState.currentFilters.priceRange === 'high') {
                    filtered = filtered.filter(item => item.price > 200);
                }
                
                // Apply dietary filters
                if (AppState.currentFilters.dietary.includes('vegetarian')) {
                    filtered = filtered.filter(item => item.is_vegetarian);
                }
                
                // Apply spice level filter
                if (AppState.currentFilters.spiceLevel === 'spicy') {
                    filtered = filtered.filter(item => item.is_spicy !== 'none');
                }
                
                // Apply availability filter
                if (AppState.currentFilters.availability === 'available') {
                    filtered = filtered.filter(item => item.is_available);
                }
                
                // Apply popularity filter
                if (AppState.currentFilters.popularity === 'popular') {
                    filtered = filtered.filter(item => item.is_popular);
                }
                
                // Apply sorting
                filtered.sort((a, b) => {
                    switch (AppState.currentFilters.sortBy) {
                        case 'name':
                            return a.name.localeCompare(b.name);
                        case 'price-low':
                            return a.price - b.price;
                        case 'price-high':
                            return b.price - a.price;
                        case 'popular':
                            return b.is_popular - a.is_popular;
                        default:
                            return 0;
                    }
                });
                
                return filtered;
            },
            
            /**
             * Filter by category
             * @param {string} categoryId - Category ID
             */
            filterByCategory(categoryId) {
                document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');
                
                if (categoryId === 'all') {
                    UIService.renderMenuItems();
                    return;
                }
                
                const container = document.getElementById('menuContainer');
                container.innerHTML = '';
                
                const category = AppState.categories.find(c => c.id == categoryId);
                if (!category) return;
                
                const filteredItems = this.filterMenuItems().filter(item => item.category_id == categoryId);
                
                if (filteredItems.length === 0) {
                    container.innerHTML = `
                        <div class="no-results">
                            <i class="fas fa-search"></i>
                            <h3>এই ক্যাটাগরিতে কোনো আইটেম পাওয়া যায়নি</h3>
                        </div>
                    `;
                    return;
                }
                
                const section = document.createElement('div');
                section.className = 'menu-section';
                
                const title = document.createElement('h2');
                title.className = 'section-title';
                title.textContent = category.name_bn || category.name;
                section.appendChild(title);
                
                const grid = document.createElement('div');
                grid.className = 'menu-grid';
                
                filteredItems.forEach(item => {
                    const card = UIService.createMenuItemCard(item);
                    grid.appendChild(card);
                });
                
                section.appendChild(grid);
                container.appendChild(section);
            },
            
            /**
             * Clear all filters
             */
            clearFilters() {
                // Reset all filters
                AppState.currentFilters = {
                    search: '',
                    category: '',
                    priceRange: null,
                    dietary: [],
                    spiceLevel: null,
                    popularity: null,
                    availability: null
                };
                
                // Clear search input
                document.getElementById('searchInput').value = '';
                
                // Reset category buttons
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Reset filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Re-render menu items
                UIService.renderMenuItems();
                
                // Show toast
                UIService.showToast('সকল ফিল্টার সাফ করা হয়েছে');
            },
            
            /**
             * Show customization modal
             * @param {number} itemId - Menu item ID
             */
            showCustomization(itemId) {
                try {
                    const item = AppState.menuItems.find(i => i.id === itemId);
                    if (!item) return;
                    
                    // Show quantity selector and hide add to cart button
                    const controls = document.querySelector(`[data-item-id="${itemId}"]`);
                    if (!controls) return;
                    
                    const addToCartBtn = controls.querySelector('.add-to-cart-btn');
                    const quantitySelector = controls.querySelector('.quantity-selector');
                    
                    if (addToCartBtn) addToCartBtn.style.display = 'none';
                    if (quantitySelector) quantitySelector.classList.add('active');
                    
                    // Initialize quantity for this item
                    if (!AppState.itemQuantities) {
                        AppState.itemQuantities = {};
                    }
                    AppState.itemQuantities[itemId] = AppState.itemQuantities[itemId] || 1;
                    
                    // Add to cart with current quantity
                    CartService.addToCartWithQuantity(item, AppState.itemQuantities[itemId]);
                } catch (error) {
                    console.error('Error in showCustomization:', error);
                }
            },

            /**
             * Increase quantity for an item
             * @param {number} itemId - Item ID
             */
            increaseQuantity(itemId) {
                try {
                    if (!AppState.itemQuantities) {
                        AppState.itemQuantities = {};
                    }
                    AppState.itemQuantities[itemId] = (AppState.itemQuantities[itemId] || 1) + 1;
                    
                    const quantityDisplay = document.getElementById(`quantity-${itemId}`);
                    if (quantityDisplay) {
                        quantityDisplay.textContent = AppState.itemQuantities[itemId];
                    }
                    
                    // Update cart
                    const item = AppState.menuItems.find(i => i.id === itemId);
                    if (item) {
                        CartService.updateItemQuantity(itemId, AppState.itemQuantities[itemId]);
                    }
                } catch (error) {
                    console.error('Error in increaseQuantity:', error);
                }
            },

            /**
             * Decrease quantity for an item
             * @param {number} itemId - Item ID
             */
            decreaseQuantity(itemId) {
                try {
                    if (!AppState.itemQuantities) {
                        AppState.itemQuantities = {};
                    }
                    
                    const currentQuantity = AppState.itemQuantities[itemId] || 1;
                    if (currentQuantity > 1) {
                        AppState.itemQuantities[itemId] = currentQuantity - 1;
                        
                        const quantityDisplay = document.getElementById(`quantity-${itemId}`);
                        if (quantityDisplay) {
                            quantityDisplay.textContent = AppState.itemQuantities[itemId];
                        }
                        
                        // Update cart
                        const item = AppState.menuItems.find(i => i.id === itemId);
                        if (item) {
                            CartService.updateItemQuantity(itemId, AppState.itemQuantities[itemId]);
                        }
                    } else {
                        // If quantity is 1, remove from cart and show add to cart button again
                        const item = AppState.menuItems.find(i => i.id === itemId);
                        if (item) {
                            CartService.removeFromCart(itemId);
                        }
                        
                        // Reset UI
                        AppState.itemQuantities[itemId] = 1;
                        
                        const quantityDisplay = document.getElementById(`quantity-${itemId}`);
                        if (quantityDisplay) {
                            quantityDisplay.textContent = '1';
                        }
                        
                        const controls = document.querySelector(`[data-item-id="${itemId}"]`);
                        if (controls) {
                            const addToCartBtn = controls.querySelector('.add-to-cart-btn');
                            const quantitySelector = controls.querySelector('.quantity-selector');
                            
                            if (addToCartBtn) addToCartBtn.style.display = 'flex';
                            if (quantitySelector) quantitySelector.classList.remove('active');
                        }
                    }
                } catch (error) {
                    console.error('Error in decreaseQuantity:', error);
                }
            },

            /**
             * Update customized price
             * @param {Object} item - Menu item
             */
            updateCustomizedPrice(item) {
                let totalPrice = item.price;
                
                // Add portion price
                const selectedPortion = document.querySelector('[data-portion].selected');
                if (selectedPortion) {
                    totalPrice += parseFloat(selectedPortion.dataset.price || 0);
                }
                
                // Add addon prices
                document.querySelectorAll('[data-addon].selected').forEach(addon => {
                    totalPrice += parseFloat(addon.dataset.price || 0);
                });
                
                document.getElementById('customizedPrice').textContent = Utils.formatCurrency(Math.round(totalPrice));
            }
        };
        
        // Cart Service
        const CartService = {
            /**
             * Add item to cart from favorites
             * @param {number} itemId - Item ID
             */
            addToCartFromFavorites(itemId) {
                event.stopPropagation();
                const item = AppState.menuItems.find(mi => mi.id === itemId);
                if (item) {
                    this.addToCart(item);
                    UIService.showToast('কার্টে যোগ করা হয়েছে');
                }
            },
            
            /**
             * Add item to cart
             * @param {Object} item - Menu item
             */
            addToCart(item) {
                const cartItem = {
                    id: Utils.generateId(),
                    menuItemId: item.id,
                    name: item.name_bn || item.name,
                    price: item.price,
                    quantity: 1,
                    customization: [],
                    specialNotes: '',
                    image: item.image
                };
                
                AppState.cart.push(cartItem);
                UIService.updateCartDisplay();
            },

            /**
             * Add item to cart with specific quantity
             * @param {Object} item - Menu item
             * @param {number} quantity - Quantity to add
             */
            addToCartWithQuantity(item, quantity) {
                try {
                    // Check if item already exists in cart
                    const existingItem = AppState.cart.find(cartItem => cartItem.menuItemId === item.id);
                    
                    if (existingItem) {
                        existingItem.quantity = quantity;
                    } else {
                        const cartItem = {
                            id: Utils.generateId(),
                            menuItemId: item.id,
                            name: item.name_bn || item.name,
                            price: item.price,
                            quantity: quantity,
                            customization: [],
                            specialNotes: '',
                            image: item.image
                        };
                        
                        AppState.cart.push(cartItem);
                    }
                    
                    UIService.updateCartDisplay();
                } catch (error) {
                    console.error('Error in addToCartWithQuantity:', error);
                }
            },

            /**
             * Update item quantity in cart
             * @param {number} itemId - Menu item ID
             * @param {number} quantity - New quantity
             */
            updateItemQuantity(itemId, quantity) {
                try {
                    const item = AppState.cart.find(i => i.menuItemId === itemId);
                    if (item) {
                        item.quantity = quantity;
                        UIService.updateCartDisplay();
                    }
                } catch (error) {
                    console.error('Error in updateItemQuantity:', error);
                }
            },

            /**
             * Remove item from cart
             * @param {number} itemId - Menu item ID
             */
            removeFromCart(itemId) {
                try {
                    AppState.cart = AppState.cart.filter(i => i.menuItemId !== itemId);
                    UIService.updateCartDisplay();
                } catch (error) {
                    console.error('Error in removeFromCart:', error);
                }
            },
            
            /**
             * Add customized item to cart
             * @param {Object} item - Menu item
             */
            addToCartCustomized(item) {
                const selectedPortion = document.querySelector('[data-portion].selected');
                const selectedSpice = document.querySelector('[data-spice].selected');
                const selectedAddons = Array.from(document.querySelectorAll('[data-addon].selected'));
                const specialNotes = document.getElementById('specialNotes').value;
                
                let totalPrice = item.price;
                let customizationDetails = [];
                
                if (selectedPortion && selectedPortion.dataset.portion !== 'regular') {
                    totalPrice += parseFloat(selectedPortion.dataset.price || 0);
                    customizationDetails.push(`পরিমাণ: ${selectedPortion.textContent}`);
                }
                
                if (selectedSpice && selectedSpice.dataset.spice !== 'none') {
                    customizationDetails.push(`ঝাল: ${selectedSpice.textContent}`);
                }
                
                selectedAddons.forEach(addon => {
                    totalPrice += parseFloat(addon.dataset.price || 0);
                    customizationDetails.push(addon.textContent);
                });
                
                const cartItem = {
                    id: Utils.generateId(),
                    menuItemId: item.id,
                    name: item.name_bn || item.name,
                    price: Math.round(totalPrice),
                    quantity: 1,
                    customization: customizationDetails,
                    specialNotes: specialNotes,
                    image: item.image
                };
                
                AppState.cart.push(cartItem);
                UIService.updateCartDisplay();
                UIService.hideModal('customizationModal');
                UIService.showToast('কার্টে যোগ করা হয়েছে');
            },
            
            /**
             * Update item quantity in cart
             * @param {string} itemId - Cart item ID
             * @param {number} change - Quantity change
             */
            updateQuantity(itemId, change) {
                try {
                    const item = AppState.cart.find(i => i.id === itemId);
                    if (!item) return;
                    
                    item.quantity += change;
                    
                    if (item.quantity <= 0) {
                        AppState.cart = AppState.cart.filter(i => i.id !== itemId);
                    }
                    
                    UIService.updateCartDisplay();
                } catch (error) {
                    console.error('Error in updateQuantity:', error);
                }
            }
        };
        
        // Favorite Service
        const FavoriteService = {
            /**
             * Toggle favorite status
             * @param {number} itemId - Menu item ID
             */
            toggle(itemId) {
                const item = AppState.menuItems.find(i => i.id === itemId);
                if (!item) return;
                
                const favorites = Utils.safeJsonParse(localStorage.getItem(`favorites_${AppState.branchId}`), []);
                const index = favorites.findIndex(f => f.id === itemId);
                
                if (index > -1) {
                    favorites.splice(index, 1);
                    UIService.showToast('পছন্দ থেকে সরানো হয়েছে');
                } else {
                    favorites.push({
                        id: item.id,
                        name_bn: item.name_bn,
                        name: item.name,
                        price: item.price,
                        image: item.image
                    });
                    UIService.showToast('পছন্দে যোগ করা হয়েছে');
                }
                
                localStorage.setItem(`favorites_${AppState.branchId}`, JSON.stringify(favorites));
                UIService.renderMenuItems();
                UIService.loadFavorites();
            },
            
            /**
             * Remove from favorites
             * @param {number} itemId - Item ID
             */
            removeFromFavorites(itemId) {
                event.stopPropagation();
                const favorites = Utils.safeJsonParse(localStorage.getItem(`favorites_${AppState.branchId}`), []);
                const index = favorites.findIndex(f => f.id === itemId);
                
                if (index > -1) {
                    favorites.splice(index, 1);
                    localStorage.setItem(`favorites_${AppState.branchId}`, JSON.stringify(favorites));
                    UIService.loadFavorites();
                    UIService.renderMenuItems();
                    UIService.showToast('পছন্দ থেকে সরানো হয়েছে');
                }
            }
        };
        
        // Order Service
        const OrderService = {
            /**
             * Get status text in Bengali
             * @param {string} status - Order status
             * @returns {string} Status text
             */
            getStatusText(status) {
                const statusMap = {
                    'pending': 'অপেক্ষমাণ',
                    'confirmed': 'নিশ্চিত',
                    'preparing': 'প্রস্তুত হচ্ছে',
                    'ready': 'প্রস্তুত',
                    'served': 'পরিবেশিত',
                    'completed': 'সম্পন্ন',
                    'cancelled': 'বাতিল'
                };
                return statusMap[status] || status;
            },
            
            /**
             * Clear order history
             */
            clearOrderHistory() {
                if (confirm('আপনি কি অর্ডার ইতিহাস মুছে ফেলতে চান?')) {
                    localStorage.removeItem(`orderHistory_${AppState.branchId}`);
                    UIService.loadOrderHistory();
                    UIService.showToast('অর্ডার ইতিহাস মুছে ফেলা হয়েছে');
                }
            },
            
            /**
             * View order details
             * @param {string} orderId - Order ID
             */
            async viewOrderDetails(orderId) {
                UIService.closeAllDropdowns();
                try {
                    const response = await ApiService.getOrder(orderId);
                    if (response.data) {
                        this.showOrderStatus(response.data);
                    } else {
                        UIService.showToast('অর্ডারের তথ্য পাওয়া যায়নি', 'error');
                    }
                } catch (error) {
                    console.error('Error fetching order details:', error);
                    UIService.showToast('অর্ডারের তথ্য পাওয়া যায়নি', 'error');
                }
            },
            
            /**
             * Submit order
             * @param {Event} e - Form submit event
             */
            async submitOrder(e) {
                e.preventDefault();
                
                // Validate payment method
                if (!AppState.selectedPaymentMethod) {
                    UIService.showToast('পেমেন্ট পদ্ধতি নির্বাচন করুন', 'error');
                    return;
                }
                
                // Get form values
                const customerName = document.getElementById('customerName').value.trim();
                const customerPhone = document.getElementById('customerPhone').value.trim();
                const orderType = document.getElementById('orderType').value;
                const selectedTable = document.getElementById('selectedTable').value;
                const orderNotes = document.getElementById('orderNotes').value.trim();
                
                // Validate required fields
                if (!customerName) {
                    UIService.showToast('নাম লিখুন', 'error');
                    return;
                }
                
                if (!customerPhone) {
                    UIService.showToast('ফোন নম্বর লিখুন', 'error');
                    return;
                }
                
                // Validate order type specific fields
                if (orderType === 'dine_in' && !selectedTable) {
                    UIService.showToast('টেবিল নির্বাচন করুন', 'error');
                    return;
                }
                
                if (orderType === 'delivery') {
                    const deliveryAddress = document.getElementById('deliveryAddress').value.trim();
                    const deliveryArea = document.getElementById('deliveryArea').value.trim();
                    
                    if (!deliveryAddress) {
                        UIService.showToast('ডেলিভারির ঠিকানা লিখুন', 'error');
                        return;
                    }
                    
                    if (!deliveryArea) {
                        UIService.showToast('এরিয়ার নাম লিখুন', 'error');
                        return;
                    }
                }
                
                const subtotal = AppState.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const vatAmount = subtotal * 0.05;
                const serviceChargeAmount = subtotal * 0.10;
                const totalAmount = subtotal + vatAmount + serviceChargeAmount;
                
                // Build order data
                const orderData = {
                    branch_id: parseInt(AppState.branchId),
                    table_id: orderType === 'dine_in' ? parseInt(selectedTable) : null,
                    customer_name: customerName,
                    customer_phone: customerPhone,
                    order_type: orderType,
                    payment_method: AppState.selectedPaymentMethod,
                    subtotal: subtotal,
                    vat_amount: vatAmount,
                    service_charge: serviceChargeAmount,
                    total_amount: totalAmount,
                    notes: orderNotes,
                    items: AppState.cart.map(item => ({
                        menu_item_id: item.menuItemId,
                        quantity: item.quantity,
                        unit_price: item.price,
                        notes: item.customization.length > 0 ? item.customization.join(', ') + (item.specialNotes ? '; ' + item.specialNotes : '') : item.specialNotes
                    }))
                };
                
                // Add delivery information if applicable
                if (orderType === 'delivery') {
                    orderData.delivery_address = {
                        address: document.getElementById('deliveryAddress').value.trim(),
                        area: document.getElementById('deliveryArea').value.trim(),
                        landmark: document.getElementById('deliveryLandmark').value.trim(),
                        flat: document.getElementById('deliveryFlat').value.trim()
                    };
                }
                
                try {
                    UIService.showLoading();
                    const response = await ApiService.createOrder(orderData);
                    
                    // Save to order history
                    const orderHistoryItem = {
                        id: response.data.id,
                        order_number: response.data.order_number,
                        date: new Date().toISOString(),
                        items: AppState.cart.map(item => ({
                            name: item.name,
                            quantity: item.quantity,
                            price: item.price
                        })),
                        total: totalAmount,
                        status: 'pending',
                        order_type: orderType
                    };
                    
                    // Save to order history with branch-specific storage
                    const orderHistory = Utils.safeJsonParse(localStorage.getItem(`orderHistory_${AppState.branchId}`), []);
                    orderHistory.unshift(orderHistoryItem);
                    localStorage.setItem(`orderHistory_${AppState.branchId}`, JSON.stringify(orderHistory));
                    
                    // Update order history dropdown in real-time
                    UIService.loadOrderHistory();
                    
                    UIService.showToast('অর্ডার সফলভাবে জমা দেওয়া হয়েছে!');
                    
                    // Show order status modal
                    AppState.currentOrder = response.data;
                    this.showOrderStatus(response.data);
                    
                    // Clear cart and reset form
                    AppState.cart = [];
                    UIService.updateCartDisplay();
                    UIService.hideModal('orderModal');
                    UIService.toggleCart();
                    this.resetOrderForm();
                } catch (error) {
                    console.error('Error submitting order:', error);
                    UIService.showToast('অর্ডার জমা দিতে ব্যর্থ হয়েছে', 'error');
                } finally {
                    UIService.hideLoading();
                }
            },
            
            /**
             * Reset order form to initial state
             */
            resetOrderForm() {
                document.getElementById('orderForm').reset();
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                document.querySelectorAll('.order-type-option').forEach(o => o.classList.remove('selected'));
                document.querySelectorAll('.table-item').forEach(t => t.classList.remove('selected'));
                
                // Reset to default order type
                document.querySelector('[data-type="dine_in"]').classList.add('selected');
                document.getElementById('orderType').value = 'dine_in';
                
                // Show/hide sections
                document.getElementById('tableSection').style.display = 'block';
                document.getElementById('deliverySection').style.display = 'none';
                
                // Clear hidden inputs
                document.getElementById('selectedTable').value = '';
                
                AppState.selectedPaymentMethod = '';
            },
            
            /**
             * Show order status modal
             * @param {Object} orderData - Order data
             */
            showOrderStatus(orderData) {
                const modal = document.getElementById('orderStatusModal');
                document.getElementById('orderNumber').textContent = orderData.order_number;
                
                // Handle created_at field with fallbacks
                let orderDate;
                if (orderData.created_at) {
                    orderDate = new Date(orderData.created_at);
                } else if (orderData.date) {
                    // Fallback to date field from order history
                    orderDate = new Date(orderData.date);
                } else {
                    // Fallback to current time
                    orderDate = new Date();
                }
                
                // Validate the date
                if (isNaN(orderDate.getTime())) {
                    orderDate = new Date(); // Use current time as final fallback
                }
                
                document.getElementById('orderTime').textContent = Utils.formatDate(orderDate);
                document.getElementById('orderReceivedTime').textContent = Utils.formatTime(orderDate);
                
                // Ensure orderData has the correct created_at field for future calculations
                if (!orderData.created_at) {
                    orderData.created_at = orderDate.toISOString();
                }
                
                // Display order items with images
                UIService.displayOrderItems(orderData.items || []);
                
                // Update status timeline based on current order status
                this.updateStatusTimeline(orderData.status, orderData);
                
                // Calculate preparation time based on order items and creation time
                const preparationTime = this.calculateOrderPreparationTime(orderData.items || [], orderData.created_at, orderData.status);
                this.updatePreparationTime(preparationTime.remainingSeconds);
                
                UIService.showModal('orderStatusModal');
                
                // Start status updates for active orders
                if (orderData.status !== 'completed' && orderData.status !== 'cancelled') {
                    this.updateOrderStatus(orderData.id);
                    AppState.statusUpdateInterval = setInterval(() => this.updateOrderStatus(orderData.id), AppState.config.statusUpdateInterval);
                }
            },
            
            /**
             * Calculate order preparation time
             * @param {Array} items - Order items
             * @param {string} createdAt - Order creation time
             * @param {string} currentStatus - Current order status
             * @returns {Object} Preparation time calculation
             */
            calculateOrderPreparationTime(items, createdAt, currentStatus) {
                // Fixed 20 minutes preparation time for all orders
                const totalPreparationTime = AppState.config.preparationTime;
                
                // Calculate elapsed time since order creation with fallback
                let orderCreatedAt;
                if (createdAt) {
                    orderCreatedAt = new Date(createdAt);
                    if (isNaN(orderCreatedAt.getTime())) {
                        orderCreatedAt = new Date(); // Fallback to current time
                    }
                } else {
                    orderCreatedAt = new Date(); // Fallback to current time
                }
                
                const currentTime = new Date();
                const elapsedMinutes = (currentTime - orderCreatedAt) / (1000 * 60);
                
                // Calculate remaining time based on current status and elapsed time
                let statusProgress = 0;
                let statusTimeMultiplier = 1;
                
                switch (currentStatus) {
                    case 'pending':
                        statusProgress = 0;
                        statusTimeMultiplier = 1; // Full 20 minutes from order creation
                        break;
                    case 'confirmed':
                        statusProgress = 0.2;
                        statusTimeMultiplier = 0.8; // 80% of 20 minutes = 16 minutes remaining
                        break;
                    case 'preparing':
                        statusProgress = 0.5;
                        statusTimeMultiplier = 0.5; // 50% of 20 minutes = 10 minutes remaining
                        break;
                    case 'ready':
                        statusProgress = 0.9;
                        statusTimeMultiplier = 0.1; // 10% of 20 minutes = 2 minutes remaining
                        break;
                    case 'served':
                    case 'completed':
                        statusProgress = 1;
                        statusTimeMultiplier = 0; // No time remaining
                        break;
                    default:
                        statusProgress = 0;
                        statusTimeMultiplier = 1;
                }
                
                // Calculate remaining time: (total time * status multiplier) - elapsed time
                const theoreticalRemainingMinutes = totalPreparationTime * statusTimeMultiplier;
                const actualRemainingMinutes = Math.max(0, theoreticalRemainingMinutes - elapsedMinutes);
                const remainingSeconds = Math.max(0, actualRemainingMinutes * 60);
                
                return {
                    totalMinutes: totalPreparationTime,
                    remainingSeconds: Math.floor(remainingSeconds),
                    elapsedMinutes: Math.floor(elapsedMinutes),
                    statusProgress: statusProgress,
                    theoreticalRemainingMinutes: theoreticalRemainingMinutes,
                    actualRemainingMinutes: actualRemainingMinutes
                };
            },
            
            /**
             * Update status timeline
             * @param {string} status - Order status
             * @param {Object} orderData - Order data
             */
            updateStatusTimeline(status, orderData = null) {
                // Reset all status steps
                document.querySelectorAll('.status-step').forEach(step => {
                    step.classList.remove('completed', 'active');
                    step.querySelector('.status-time').textContent = '';
                });
                
                // Define status order and corresponding step IDs
                const statusOrder = ['pending', 'confirmed', 'preparing', 'ready', 'served', 'completed'];
                const stepIds = ['pendingStep', 'confirmedStep', 'preparingStep', 'readyStep', 'servedStep'];
                const currentIndex = statusOrder.indexOf(status);
                
                // Mark completed steps and set timestamps
                let orderCreatedAt;
                if (orderData && orderData.created_at) {
                    orderCreatedAt = new Date(orderData.created_at);
                    if (isNaN(orderCreatedAt.getTime())) {
                        orderCreatedAt = new Date(); // Fallback to current time
                    }
                } else {
                    orderCreatedAt = new Date(); // Fallback to current time
                }
                
                for (let i = 0; i < currentIndex; i++) {
                    const step = document.getElementById(stepIds[i]);
                    if (step) {
                        step.classList.add('completed');
                        // Calculate estimated time for each status based on order creation time
                        const statusTime = new Date(orderCreatedAt.getTime() + (i * 5 * 60 * 1000)); // 5 minutes per status
                        step.querySelector('.status-time').textContent = Utils.formatTime(statusTime);
                    }
                }
                
                // Mark current step as active and set current time
                if (currentIndex < stepIds.length) {
                    const currentStep = document.getElementById(stepIds[currentIndex]);
                    if (currentStep) {
                        currentStep.classList.add('active');
                        currentStep.querySelector('.status-time').textContent = Utils.formatTime(new Date());
                    }
                }
                
                // Handle completed status
                if (status === 'completed') {
                    const servedStep = document.getElementById('servedStep');
                    if (servedStep) {
                        servedStep.classList.add('completed');
                        servedStep.querySelector('.status-time').textContent = Utils.formatTime(new Date());
                    }
                }
            },
            
            /**
             * Update preparation time display
             * @param {number} remainingSeconds - Remaining seconds
             */
            updatePreparationTime(remainingSeconds) {
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                
                const timeElement = document.getElementById('timeRemaining');
                const statusElement = document.getElementById('preparationStatus');
                
                timeElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (remainingSeconds > 0) {
                    if (minutes > 5) {
                        statusElement.textContent = `প্রায় ${minutes} মিনিট বাকি`;
                    } else if (minutes > 0) {
                        statusElement.textContent = `প্রায় ${minutes} মিনিট বাকি`;
                    } else {
                        statusElement.textContent = 'প্রায় প্রস্তুত';
                    }
                    setTimeout(() => this.updatePreparationTime(remainingSeconds - 1), 1000);
                } else {
                    statusElement.textContent = 'প্রস্তুত!';
                    timeElement.textContent = '00:00';
                }
            },
            
            /**
             * Update order status
             * @param {string} orderId - Order ID
             */
            async updateOrderStatus(orderId) {
                try {
                    const response = await ApiService.getOrder(orderId);
                    const order = response.data;
                    
                    this.updateStatusTimeline(order.status, order);
                    
                    // Update order status in local storage
                    this.updateOrderStatusInStorage(orderId, order.status);
                    
                    // Update preparation time if order is still active
                    if (order.status !== 'completed' && order.status !== 'cancelled') {
                        const preparationTime = this.calculateOrderPreparationTime(order.items || [], order.created_at, order.status);
                        this.updatePreparationTime(preparationTime.remainingSeconds);
                    }
                    
                    // Stop updates if order is completed or cancelled
                    if (order.status === 'completed' || order.status === 'cancelled') {
                        if (AppState.statusUpdateInterval) {
                            clearInterval(AppState.statusUpdateInterval);
                            AppState.statusUpdateInterval = null;
                        }
                    }
                } catch (error) {
                    console.error('Error updating order status:', error);
                }
            },
            
            /**
             * Update order status in storage
             * @param {string} orderId - Order ID
             * @param {string} newStatus - New status
             */
            updateOrderStatusInStorage(orderId, newStatus) {
                const orderHistory = Utils.safeJsonParse(localStorage.getItem(`orderHistory_${AppState.branchId}`), []);
                const orderIndex = orderHistory.findIndex(order => order.id == orderId);
                
                if (orderIndex > -1) {
                    orderHistory[orderIndex].status = newStatus;
                    localStorage.setItem(`orderHistory_${AppState.branchId}`, JSON.stringify(orderHistory));
                    
                    // Update the order history dropdown if it's visible
                    const orderHistoryMenu = document.getElementById('orderHistoryMenu');
                    if (orderHistoryMenu.classList.contains('show')) {
                        UIService.loadOrderHistory();
                    }
                }
            }
        };
        
        // Branch Service
        const BranchService = {
            /**
             * Load branches from API
             */
            async loadBranches() {
                try {
                    console.log('Loading branches...');
                    const response = await ApiService.getBranches();
                    
                    console.log('Branches API Response:', response);
                    
                    if (response.data && Array.isArray(response.data)) {
                        console.log('Rendering branches:', response.data.length, 'branches found');
                        AppState.branches = response.data;
                        UIService.renderBranches();
                    } else {
                        console.error('Invalid branches data format:', response);
                        const branchList = document.getElementById('branchList');
                        branchList.innerHTML = '<div class="text-center text-danger p-4">শাখা তালিকা লোড করা যায়নি। দয়া করে পুনরায় চেষ্টা করুন।</div>';
                    }
                } catch (error) {
                    console.error('Error loading branches:', error);
                    const branchList = document.getElementById('branchList');
                    branchList.innerHTML = '<div class="text-center text-danger p-4">শাখা তালিকা লোড করা যায়নি। দয়া করে পুনরায় চেষ্টা করুন।</div>';
                }
            },
            
            /**
             * Check if branch is open
             * @param {string} openingTime - Opening time
             * @param {string} closingTime - Closing time
             * @returns {boolean} True if branch is open
             */
            isBranchOpen(openingTime, closingTime) {
                const now = new Date();
                const currentTime = now.getHours() * 60 + now.getMinutes();
                
                const openTime = new Date(`2000-01-01 ${openingTime}`);
                const closeTime = new Date(`2000-01-01 ${closingTime}`);
                
                const openMinutes = openTime.getHours() * 60 + openTime.getMinutes();
                const closeMinutes = closeTime.getHours() * 60 + closeTime.getMinutes();
                
                return currentTime >= openMinutes && currentTime <= closeMinutes;
            },
            
            /**
             * Calculate distance to branch
             * @param {number} lat - Latitude
             * @param {number} lng - Longitude
             * @returns {string|null} Distance in km or null
             */
            calculateDistance(lat, lng) {
                if (!lat || !lng) return null;
                
                // For demo purposes, return a random distance
                // In a real application, you would use the user's actual location
                return (Math.random() * 10 + 1).toFixed(1);
            },
            
            /**
             * Switch to different branch
             * @param {string} newBranchId - New branch ID
             */
            switchBranch(newBranchId) {
                if (newBranchId == AppState.branchId) {
                    UIService.hideModal('branchModal');
                    return;
                }
                
                // Save cart state before switching
                localStorage.setItem(`cart_${AppState.branchId}`, JSON.stringify(AppState.cart));
                
                // Load cart for new branch if exists
                const savedCart = localStorage.getItem(`cart_${newBranchId}`);
                AppState.cart = savedCart ? Utils.safeJsonParse(savedCart, []) : [];
                
                // Update branch ID
                AppState.branchId = newBranchId;
                
                // Reload data
                this.loadRestaurantInfo();
                MenuService.loadMenuItems();
                UIService.updateCartDisplay();
                
                UIService.hideModal('branchModal');
                UIService.showToast('শাখা পরিবর্তন করা হয়েছে');
            },
            
            /**
             * Load restaurant info
             */
            async loadRestaurantInfo() {
                try {
                    const response = await ApiService.getRestaurantInfo(AppState.branchId);
                    
                    if (response.data) {
                        document.getElementById('restaurantName').textContent = response.data.headquarters_name || 'রেস্তোরাঁ';
                        document.getElementById('branchName').textContent = response.data.name || 'শাখা';
                    } else {
                        document.getElementById('restaurantName').textContent = 'রেস্তোরাঁ';
                        document.getElementById('branchName').textContent = 'শাখা';
                    }
                } catch (error) {
                    console.error('Error loading restaurant info:', error);
                    document.getElementById('restaurantName').textContent = 'রেস্তোরাঁ';
                    document.getElementById('branchName').textContent = 'শাখা';
                }
            }
        };
        
        // Background Service
        const BackgroundService = {
            /**
             * Start background status updates
             */
            startBackgroundStatusUpdates() {
                AppState.backgroundUpdateInterval = setInterval(() => {
                    this.updateOrderStatusesInBackground();
                }, AppState.config.backgroundUpdateInterval);
            },
            
            /**
             * Update order statuses in background
             */
            updateOrderStatusesInBackground() {
                const orderHistory = Utils.safeJsonParse(localStorage.getItem(`orderHistory_${AppState.branchId}`), []);
                const activeOrders = orderHistory.filter(order => 
                    order.status !== 'completed' && order.status !== 'cancelled'
                );
                
                if (activeOrders.length > 0) {
                    activeOrders.forEach(order => {
                        this.fetchOrderStatusUpdate(order.id);
                    });
                }
            },
            
            /**
             * Fetch order status update
             * @param {string} orderId - Order ID
             */
            async fetchOrderStatusUpdate(orderId) {
                try {
                    const response = await ApiService.getOrder(orderId);
                    const order = response.data;
                    
                    OrderService.updateOrderStatusInStorage(orderId, order.status);
                    
                    // Show notification for status changes
                    const orderHistory = Utils.safeJsonParse(localStorage.getItem(`orderHistory_${AppState.branchId}`), []);
                    const existingOrder = orderHistory.find(o => o.id == orderId);
                    
                    if (existingOrder && existingOrder.status !== order.status) {
                        UIService.showToast(`অর্ডার #${order.id} এর স্ট্যাটাস: ${OrderService.getStatusText(order.status)}`, 'info');
                    }
                } catch (error) {
                    console.error('Error fetching order status update:', error);
                }
            }
        };
        
        // Event Listeners
        const EventListeners = {
            /**
             * Setup all event listeners
             */
            setup() {
                // Search functionality
                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('input', Utils.debounce((e) => {
                    AppState.currentFilters.search = e.target.value;
                    UIService.renderMenuItems();
                }, 300));
                
                // Filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const filter = e.target.closest('.filter-btn').dataset.filter;
                        this.toggleFilter(filter, e.target.closest('.filter-btn'));
                    });
                });
                
                // Sort functionality
                const sortSelect = document.getElementById('sortSelect');
                sortSelect.addEventListener('change', (e) => {
                    AppState.currentFilters.sortBy = e.target.value;
                    UIService.renderMenuItems();
                });
                
                // Header dropdowns
                const orderHistoryBtn = document.getElementById('orderHistoryBtn');
                const orderHistoryDropdown = document.getElementById('orderHistoryDropdown');
                const orderHistoryMenu = document.getElementById('orderHistoryMenu');
                
                orderHistoryBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    UIService.closeAllDropdowns();
                    orderHistoryMenu.classList.toggle('show');
                });
                
                const favoritesBtn = document.getElementById('favoritesBtn');
                const favoritesDropdown = document.getElementById('favoritesDropdown');
                const favoritesMenu = document.getElementById('favoritesMenu');
                
                favoritesBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    UIService.closeAllDropdowns();
                    favoritesMenu.classList.toggle('show');
                });
                
                // Close dropdowns when clicking outside
                document.addEventListener('click', () => {
                    UIService.closeAllDropdowns();
                });
                
                // Prevent dropdown from closing when clicking inside
                orderHistoryMenu.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
                
                favoritesMenu.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
                
                // Cart toggle
                document.getElementById('cartToggle').addEventListener('click', () => {
                    UIService.toggleCart();
                });
                
                document.getElementById('closeCart').addEventListener('click', () => {
                    UIService.toggleCart();
                });
                
                // Checkout button
                document.getElementById('checkoutBtn').addEventListener('click', () => {
                    if (AppState.cart.length === 0) {
                        UIService.showToast('কার্ট খালি', 'error');
                        return;
                    }
                    
                    // Initialize order modal
                    OrderService.resetOrderForm();
                    
                    // Load tables if dine-in is default
                    if (document.getElementById('orderType').value === 'dine_in') {
                        EventListeners.loadTables();
                    }
                    
                    UIService.showModal('orderModal');
                });
                
                // Order form
                document.getElementById('orderForm').addEventListener('submit', OrderService.submitOrder.bind(OrderService));
                
                // Payment methods
                document.querySelectorAll('.payment-method').forEach(method => {
                    method.addEventListener('click', (e) => {
                        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                        e.currentTarget.classList.add('selected');
                        AppState.selectedPaymentMethod = e.currentTarget.dataset.payment;
                    });
                });
                
                // Modal close buttons
                document.getElementById('closeOrderModal').addEventListener('click', () => {
                    UIService.hideModal('orderModal');
                });
                
                // Cancel order button
                document.getElementById('cancelOrder').addEventListener('click', () => {
                    UIService.hideModal('orderModal');
                });
                
                // Order type selection
                document.querySelectorAll('.order-type-option').forEach(option => {
                    option.addEventListener('click', (e) => {
                        const orderType = e.currentTarget.dataset.type;
                        this.selectOrderType(orderType);
                    });
                });
                
                // Table selection
                document.getElementById('tableGrid').addEventListener('click', (e) => {
                    const tableItem = e.target.closest('.table-item');
                    if (tableItem && !tableItem.classList.contains('occupied') && !tableItem.classList.contains('reserved')) {
                        this.selectTable(tableItem);
                    }
                });
                
                document.getElementById('closeCustomization').addEventListener('click', () => {
                    UIService.hideModal('customizationModal');
                });
                
                document.getElementById('closeStatusModal').addEventListener('click', () => {
                    UIService.hideModal('orderStatusModal');
                    if (AppState.statusUpdateInterval) {
                        clearInterval(AppState.statusUpdateInterval);
                    }
                });
                
                // Branch selector
                document.getElementById('branchSelector').addEventListener('click', () => {
                    UIService.showModal('branchModal');
                });
                
                document.getElementById('closeBranchModal').addEventListener('click', () => {
                    UIService.hideModal('branchModal');
                });
            },
            
            /**
             * Toggle filter
             * @param {string} filter - Filter name
             * @param {HTMLElement} button - Filter button
             */
            toggleFilter(filter, button) {
                // Remove active class from all filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                button.classList.add('active');
                
                // Reset all filters first
                AppState.currentFilters = {
                    search: document.getElementById('searchInput').value,
                    category: AppState.currentFilters.category, // Keep category filter
                    priceRange: null,
                    dietary: [],
                    spiceLevel: null,
                    popularity: null,
                    availability: null
                };
                
                // Apply the selected filter
                switch (filter) {
                    case 'price-low':
                        AppState.currentFilters.priceRange = 'low';
                        break;
                    case 'price-high':
                        AppState.currentFilters.priceRange = 'high';
                        break;
                    case 'vegetarian':
                        AppState.currentFilters.dietary = ['vegetarian'];
                        break;
                    case 'spicy':
                        AppState.currentFilters.spiceLevel = 'spicy';
                        break;
                    case 'popular':
                        AppState.currentFilters.popularity = 'popular';
                        break;
                    case 'available':
                        AppState.currentFilters.availability = 'available';
                        break;
                }
                
                UIService.renderMenuItems();
            },
            
            /**
             * Select order type
             * @param {string} orderType - Order type (dine_in, takeaway, delivery)
             */
            selectOrderType(orderType) {
                // Update visual selection
                document.querySelectorAll('.order-type-option').forEach(option => {
                    option.classList.remove('selected');
                });
                document.querySelector(`[data-type="${orderType}"]`).classList.add('selected');
                
                // Update hidden input
                document.getElementById('orderType').value = orderType;
                
                // Show/hide sections based on order type
                const tableSection = document.getElementById('tableSection');
                const deliverySection = document.getElementById('deliverySection');
                
                if (orderType === 'dine_in') {
                    tableSection.style.display = 'block';
                    deliverySection.style.display = 'none';
                    this.loadTables();
                } else if (orderType === 'delivery') {
                    tableSection.style.display = 'none';
                    deliverySection.style.display = 'block';
                } else {
                    tableSection.style.display = 'none';
                    deliverySection.style.display = 'none';
                }
            },
            
            /**
             * Load tables for the current branch
             */
            async loadTables() {
                try {
                    const tableGrid = document.getElementById('tableGrid');
                    const tableLoading = document.querySelector('.table-loading');
                    
                    // Show loading
                    tableLoading.style.display = 'flex';
                    tableGrid.style.display = 'none';
                    
                    // Fetch tables from API using ApiService
                    const response = await ApiService.request(`/tables?branch_id=${AppState.branchId}`);
                    const tables = response.data;
                    
                    // Render tables
                    this.renderTables(tables);
                    
                    // Hide loading, show grid
                    tableLoading.style.display = 'none';
                    tableGrid.style.display = 'grid';
                } catch (error) {
                    console.error('Error loading tables:', error);
                    const tableLoading = document.querySelector('.table-loading');
                    tableLoading.innerHTML = '<i class="fas fa-exclamation-triangle"></i> টেবিল লোড করতে ব্যর্থ হয়েছে';
                }
            },
            
            /**
             * Render tables in the grid
             * @param {Array} tables - Array of table objects
             */
            renderTables(tables) {
                const tableGrid = document.getElementById('tableGrid');
                
                if (!tables || tables.length === 0) {
                    tableGrid.innerHTML = '<div class="empty-state">কোনো টেবিল পাওয়া যায়নি</div>';
                    return;
                }
                
                tableGrid.innerHTML = tables.map(table => `
                    <div class="table-item ${table.status}" data-table-id="${table.id}" data-table-number="${table.table_number}">
                        <div class="table-status"></div>
                        <div class="table-number">${table.table_number}</div>
                        <div class="table-capacity">${table.capacity} জন</div>
                    </div>
                `).join('');
            },
            
            /**
             * Select a table
             * @param {HTMLElement} tableItem - Table element
             */
            selectTable(tableItem) {
                // Remove previous selection
                document.querySelectorAll('.table-item').forEach(item => {
                    item.classList.remove('selected');
                });
                
                // Add selection to clicked table
                tableItem.classList.add('selected');
                
                // Update hidden input
                document.getElementById('selectedTable').value = tableItem.dataset.tableId;
            }
        };
        
        // Application Initialization
        const App = {
            /**
             * Initialize the application
             */
            async initialize() {
                try {
                    // Load initial data with error handling for each step
                    try {
                        await BranchService.loadRestaurantInfo();
                    } catch (error) {
                        console.error('Error loading restaurant info:', error);
                        // Continue with default values
                    }
                    
                    try {
                        const categoriesResponse = await ApiService.getCategories();
                        if (categoriesResponse.data) {
                            AppState.categories = categoriesResponse.data;
                            UIService.renderCategories();
                        }
                    } catch (error) {
                        console.error('Error loading categories:', error);
                        // Continue without categories
                    }
                    
                    try {
                        await MenuService.loadMenuItems();
                    } catch (error) {
                        console.error('Error loading menu items:', error);
                        // Continue without menu items
                    }
                    
                    try {
                        await BranchService.loadBranches();
                    } catch (error) {
                        console.error('Error loading branches:', error);
                        // Continue without branches
                    }
                    
                    // Setup event listeners
                    try {
                        EventListeners.setup();
                    } catch (error) {
                        console.error('Error setting up event listeners:', error);
                    }
                    
                    // Update UI
                    try {
                        UIService.updateCartDisplay();
                        UIService.loadOrderHistory();
                        UIService.loadFavorites();
                    } catch (error) {
                        console.error('Error updating UI:', error);
                    }
                    
                    // Start background services
                    try {
                        BackgroundService.startBackgroundStatusUpdates();
                    } catch (error) {
                        console.error('Error starting background services:', error);
                    }
                    
                    // Hide loading screen
                    setTimeout(() => {
                        document.getElementById('loadingScreen').classList.add('hidden');
                    }, 500);
                    
                    console.log('Application initialized successfully');
                } catch (error) {
                    console.error('Critical error initializing app:', error);
                    UIService.showToast('অ্যাপ্লিকেশন লোড করতে ব্যর্থ হয়েছে', 'error');
                    
                    // Hide loading screen even if there's an error
                    setTimeout(() => {
                        document.getElementById('loadingScreen').classList.add('hidden');
                    }, 500);
                }
            },
            
            /**
             * Cleanup function to stop intervals when page is closed
             */
            cleanup() {
                if (AppState.statusUpdateInterval) {
                    clearInterval(AppState.statusUpdateInterval);
                }
                if (AppState.backgroundUpdateInterval) {
                    clearInterval(AppState.backgroundUpdateInterval);
                }
            }
        };
        
        // Initialize application when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            App.initialize();
            
            // Fallback: Hide loading screen after 10 seconds even if initialization fails
            setTimeout(() => {
                const loadingScreen = document.getElementById('loadingScreen');
                if (loadingScreen && !loadingScreen.classList.contains('hidden')) {
                    console.warn('Loading screen forced to hide after timeout');
                    loadingScreen.classList.add('hidden');
                    UIService.showToast('অ্যাপ্লিকেশন লোডিং এ সমস্যা হয়েছে, অনুগ্রহ করে পেজ রিফ্রেশ করুন', 'warning');
                }
            }, 10000);
        });
        
        // Cleanup when page is unloaded
        window.addEventListener('beforeunload', () => {
            App.cleanup();
        });
        
        // Initialize quantities when menu items are loaded
        const originalLoadMenuItems = MenuService.loadMenuItems;
        MenuService.loadMenuItems = function() {
            return originalLoadMenuItems.call(this).then(() => {
                // Initialize quantities for all menu items
                if (AppState.menuItems) {
                    AppState.menuItems.forEach(item => {
                        if (!AppState.itemQuantities[item.id]) {
                            AppState.itemQuantities[item.id] = 1;
                        }
                    });
                }
            });
        };
        window.clearOrderHistory = OrderService.clearOrderHistory.bind(OrderService);
        window.MenuService = MenuService;
        window.CartService = CartService;
        window.FavoriteService = FavoriteService;
        window.OrderService = OrderService;
        window.BranchService = BranchService;
    </script>
</body>
</html>