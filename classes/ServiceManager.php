<?php
class ServiceManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllServices($activeOnly = true) {
        $sql = "SELECT s.*, GROUP_CONCAT(CONCAT(sc.name, ':', sc.color, ':', sc.icon) SEPARATOR '|') as categories
                FROM services s
                LEFT JOIN service_category_relations scr ON s.id = scr.service_id
                LEFT JOIN service_categories sc ON scr.category_id = sc.id";
        
        if ($activeOnly) {
            $sql .= " WHERE s.is_active = 1";
        }
        
        $sql .= " GROUP BY s.id ORDER BY s.is_featured DESC, s.display_order ASC, s.title ASC";
        
        return $this->db->fetchAll($sql);
    }

    public function getServiceBySlug($slug) {
        $sql = "SELECT * FROM services WHERE slug = ? AND is_active = 1";
        return $this->db->fetch($sql, [$slug]);
    }

    public function getServiceCategories($serviceId = null) {
        if ($serviceId) {
            $sql = "SELECT sc.* FROM service_categories sc
                    JOIN service_category_relations scr ON sc.id = scr.category_id
                    WHERE scr.service_id = ? AND sc.is_active = 1
                    ORDER BY sc.display_order";
            return $this->db->fetchAll($sql, [$serviceId]);
        }
        
        $sql = "SELECT * FROM service_categories WHERE is_active = 1 ORDER BY display_order";
        return $this->db->fetchAll($sql);
    }

    public function getServicesByCategory($categorySlug) {
        $sql = "SELECT s.* FROM services s
                JOIN service_category_relations scr ON s.id = scr.service_id
                JOIN service_categories sc ON scr.category_id = sc.id
                WHERE sc.slug = ? AND s.is_active = 1 AND sc.is_active = 1
                ORDER BY s.is_featured DESC, s.display_order";
        return $this->db->fetchAll($sql, [$categorySlug]);
    }

    public function formatPrice($priceFrom, $priceTo) {
        if (!$priceFrom && !$priceTo) return 'Sur devis';
        if ($priceFrom && !$priceTo) return 'À partir de ' . number_format($priceFrom, 0, ',', ' ') . '€';
        if (!$priceFrom && $priceTo) return 'Jusqu\'à ' . number_format($priceTo, 0, ',', ' ') . '€';
        if ($priceFrom == $priceTo) return number_format($priceFrom, 0, ',', ' ') . '€';
        return number_format($priceFrom, 0, ',', ' ') . '€ - ' . number_format($priceTo, 0, ',', ' ') . '€';
    }

    public function getServiceUrl($slug) {
        return 'service-detail.php?service=' . urlencode($slug);
    }

    public function parseCategories($categoriesString) {
        if (empty($categoriesString)) return [];
        
        $categories = [];
        $parts = explode('|', $categoriesString);
        
        foreach ($parts as $part) {
            if (strpos($part, ':') !== false) {
                list($name, $color, $icon) = explode(':', $part);
                $categories[] = [
                    'name' => $name,
                    'color' => $color,
                    'icon' => $icon
                ];
            }
        }
        
        return $categories;
    }
}
?>