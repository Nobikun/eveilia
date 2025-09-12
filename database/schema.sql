CREATE DATABASE IF NOT EXISTS eveilparent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eveilparent;

-- Table des services
CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    short_description TEXT,
    full_description TEXT,
    included_services TEXT,
    icon VARCHAR(50) DEFAULT '🎈',
    price_from DECIMAL(10,2),
    price_to DECIMAL(10,2),
    duration VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE,
    meta_description TEXT,
	display_order DECIMAL(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des catégories
CREATE TABLE service_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    icon VARCHAR(50) DEFAULT '🏷️',
    color VARCHAR(7) DEFAULT '#8B4593',
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0
);

-- Table de liaison services-catégories
CREATE TABLE service_category_relations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    service_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_relation (service_id, category_id)
);

-- Données d'exemple
INSERT INTO service_categories (name, slug, icon, color, description) VALUES
('Célébrations', 'celebrations', '🎉', '#FF6B6B', 'Événements festifs et célébrations'),
('Photoshoots', 'photoshoots', '📸', '#4ECDC4', 'Séances photo maternité et bébé'),
('Décorations', 'decorations', '🎨', '#45B7D1', 'Décoration et aménagement d\'espaces'),
('Bien-être', 'bien-etre', '🧘', '#96CEB4', 'Services de détente pour futures mamans');

-- Services d'exemple
INSERT INTO services (title, slug, short_description, full_description, included_services, icon, price_from, price_to, duration, is_featured) VALUES
('Baby Shower', 'baby-shower', 'Organisation complète de votre baby shower de rêve', 
 'Célébrez l\'arrivée de votre petit trésor avec une baby shower inoubliable ! Je m\'occupe de chaque détail pour que vous puissiez profiter pleinement de ce moment magique entourée de vos proches.',
 'Conception du thème personnalisé|Décoration complète|Animation et jeux|Gâteau et buffet|Photobooth avec accessoires|Cadeaux souvenirs pour les invités|Coordination le jour J',
 '🎈', 450.00, 850.00, '4-6 heures', TRUE),

('Gender Reveal', 'gender-reveal', 'Révélation du sexe de bébé de façon spectaculaire',
 'Vivez un moment d\'émotion pure en découvrant le sexe de votre bébé de façon originale ! Ballons, fumigènes colorés, gâteau surprise... créons ensemble LA révélation parfaite.',
 'Consultation pour choisir le concept|Décoration thématique|Système de révélation (ballons, gâteau, fumigènes...)|Animation surprise|Captation photo/vidéo du moment|Kit souvenir personnalisé',
 '💙💖', 280.00, 480.00, '2-3 heures', TRUE),

('Baptême Laïque', 'bapteme-laique', 'Cérémonie d\'engagement familial personnalisée',
 'Créez une cérémonie d\'accueil unique pour présenter votre enfant à votre famille et vos amis, dans un cadre personnalisé qui vous ressemble.',
 'Création du déroulé de cérémonie|Décoration de l\'espace|Livret de cérémonie personnalisé|Coordination des intervenants|Musique et sonorisation|Vin d\'honneur ou cocktail',
 '🕊️', 380.00, 650.00, '3-4 heures', FALSE),

('Premier Anniversaire', 'premier-anniversaire', 'Célébration magique du premier anniversaire',
 'Le premier anniversaire de bébé est un moment si précieux ! Créons ensemble une fête à la fois mignonne et mémorable pour célébrer cette première année.',
 'Thème sur-mesure adapté aux tout-petits|Décoration sécurisée|Animation adaptée aux enfants|Gâteau smash cake|Zone photo dédiée|Cadeaux souvenirs|Gestion timing et siestes',
 '🎂', 320.00, 620.00, '3-4 heures', TRUE),

('Photoshoot Maternité', 'photoshoot-maternite', 'Séance photo pour immortaliser votre grossesse',
 'Capturez la beauté de votre grossesse avec une séance photo professionnelle dans un cadre enchanteur que nous créerons spécialement pour vous.',
 'Consultation styling et tenues|Décoration et mise en scène|Séance photo professionelle (2h)|Retouches des photos|Galerie numérique privée|Impressions haute qualité|Album souvenir en option',
 '📸', 180.00, 350.00, '2-3 heures', FALSE);

-- Relations services-catégories
INSERT INTO service_category_relations (service_id, category_id) VALUES
(1, 1), (1, 3), -- Baby Shower -> Célébrations, Décorations
(2, 1), (2, 3), -- Gender Reveal -> Célébrations, Décorations  
(3, 1), (3, 3), -- Baptême -> Célébrations, Décorations
(4, 1), (4, 3), -- Premier anniversaire -> Célébrations, Décorations
(5, 2), (5, 4); -- Photoshoot -> Photoshoots, Bien-être
