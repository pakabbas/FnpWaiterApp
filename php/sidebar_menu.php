<?php
function getActiveClass($currentPage) {
    $color = $currentPage ? '#4cbb17' : '#bfbfbf';
    $span_color = $currentPage ? 'color: #4cbb17;' : '';
    return ['color' => $color, 'span_style' => $span_color];
}

function renderSidebarMenu($activePage = '') {
    $menuItems = [
        'profile' => [
            'url' => 'CustomerProfile.php',
            'icon' => 'fas fa-user',
            'text' => 'My Profile'
        ],
        'bookings' => [
            'url' => 'CustomerBookings.php',
            'icon' => 'far fa-file-alt',
            'text' => 'Booking History'
        ],
        'orders' => [
            'url' => 'CustomerOrders.php',
            'icon' => 'fas fa-store',
            'text' => 'Previous Orders'
        ],
        'reviews' => [
            'url' => 'CustomerReviews.php',
            'icon' => 'fas fa-star',
            'text' => 'Reviews & Rating'
        ],
        'delete' => [
            'url' => 'CustomerDeletion.php',
            'icon' => 'fas fa-trash-alt',
            'text' => 'Delete Account'
        ],
        // 'help' => [
        //     'url' => 'CustomerHelp.php',
        //     'icon' => 'fas fa-question-circle',
        //     'text' => 'Help Center'
        // ],
        // 'settings' => [
        //     'url' => 'CustomerSettings.php',
        //     'icon' => 'fas fa-cog',
        //     'text' => 'Setting'
        // ],
        'logout' => [
            'url' => 'logout.php',
            'icon' => 'fas fa-sign-out-alt',
            'text' => 'Log Out'
        ]
    ];

    $html = '
    <style>
        @media (max-width: 768px) {
            .mobile-menu-item {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 15px 20px !important;
                border-bottom: 1px solid #f0f0f0 !important;
                margin-bottom: 0px !important;
            }
            
            .mobile-menu-item:last-child {
                border-bottom: none !important;
            }
            
            .mobile-menu-link {
                display: flex !important;
                align-items: center !important;
                flex: 1 !important;
                text-decoration: none !important;
                color: inherit !important;
            }
            
            .mobile-menu-icon {
                font-size: 20px !important;
                margin-right: 15px !important;
                width: 20px !important;
            }
            
            .mobile-menu-text {
                flex: 1 !important;
                font-size: 16px !important;
            }
            
            .mobile-menu-arrow {
                color: #ccc !important;
                font-size: 14px !important;
                margin-left: 10px !important;
            }
            
            .mobile-menu-container {
                background: white !important;
                border-radius: 8px !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .mobile-menu-title {
                display: none !important;
            }
            
            .logout-item {
                color: #ff4444 !important;
            }
            
            .logout-item .mobile-menu-icon,
            .logout-item .mobile-menu-text {
                color: #ff4444 !important;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-menu-arrow {
                display: none !important;
            }
        }
    </style>
    
    <div class="mobile-menu-container" style="margin-left: 0%;">
            <br />
            <h5 class="mobile-menu-title" style="color: black;">My Account</h5>
            <br class="mobile-menu-title">
            <ul style="list-style-type: none; padding: 0;">';

    foreach ($menuItems as $key => $item) {
        $isActive = ($activePage === $key);
        $styles = getActiveClass($isActive);
        $logoutClass = ($key === 'logout') ? 'logout-item' : '';
        $deleteClass = ($key === 'delete') ? 'delete-item' : '';

        if ($key === 'delete') {
            $styles['color'] = '#d9534f'; 
            $styles['span_style'] = 'color: #d9534f;';
        }
        
        $html .= '
        <li class="mobile-menu-item ' . $logoutClass . ' ' . $deleteClass . '" style="display: flex; align-items: center; margin-bottom: 10px;">
            <a href="' . $item['url'] . '" class="mobile-menu-link" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
                <i class="' . $item['icon'] . ' mobile-menu-icon" style="font-size: 20px; margin-right: 10px; color: ' . $styles['color'] . ';"></i>
                <span class="mobile-menu-text" style="' . $styles['span_style'] . '">' . $item['text'] . '</span>
            </a>
            <i class="fas fa-chevron-right mobile-menu-arrow"></i>
        </li>';
    }

    $html .= '
            </ul>
    </div>';

    return $html;
}
?>