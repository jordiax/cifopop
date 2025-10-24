DROP DATABASE IF EXISTS cifopop;

CREATE DATABASE cifopop 
	DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE cifopop;

CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) NULL,
    cp VARCHAR(6) NULL,
    poblacion VARCHAR(255) NULL,
    provincia VARCHAR(255) NULL,
	roles VARCHAR(1024) NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users(id, displayname, email, phone, picture, password, roles) VALUES 
	(1, 'user', 'user@fastlight.org', '666666663', 'user.png', md5('1234'), '["ROLE_USER"]'), 
    (2, 'admin', 'admin@fastlight.org', '666666661', 'admin.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
    (3, 'test', 'test@fastlight.org', '666666662', 'user.png', md5('1234'), '["ROLE_USER"]');

CREATE TABLE anuncios(
	 id INT PRIMARY KEY auto_increment,
     iduser INT NOT NULL,
     titulo varchar(256) NOT NULL,
     descripcion text COLLATE utf8mb4_unicode_ci,
     precio float NOT NULL,
     imagen varchar(256),

	 FOREIGN KEY (iduser) REFERENCES users(id)
	 ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO anuncios (iduser, titulo, descripcion, precio, imagen) VALUES
(1, 'Bicicleta de montaña', 'Bicicleta en perfecto estado, poco uso.', 250.00, 'bicicleta.jpg'),
(1, 'iPhone 12', 'iPhone 12 de 128GB, color negro.', 600.00, 'iphone12.jpg'),
(1, 'Sofá 3 plazas', 'Sofá cómodo, color gris claro.', 120.00, 'sofa.jpg'),
(1, 'Mesa de comedor', 'Mesa de madera para 6 personas.', 200.00, 'mesa.jpg'),
(1, 'Monitor 27 pulgadas', 'Monitor IPS FullHD, poco uso.', 150.00, 'monitor.jpg'),
(1, 'Cámara Canon', 'Cámara réflex Canon EOS 4000D.', 300.00, 'camara.jpg'),
(1, 'Zapatillas deportivas', 'Zapatillas Nike, talla 42, nuevas.', 60.00, 'zapatillas.jpg'),
(1, 'Libro JavaScript', 'Libro para aprender JavaScript desde cero.', 15.00, 'libro.jpg'),
(1, 'Mochila viaje', 'Mochila grande, resistente al agua.', 40.00, 'mochila.jpg'),
(1, 'Patinete eléctrico', 'Patinete eléctrico con batería nueva.', 350.00, 'patinete.jpg'),
(3, 'Guitarra eléctrica', 'Guitarra Fender Stratocaster, excelente sonido.', 450.00, 'guitarra.jpg'),
(3, 'Silla gamer', 'Silla ergonómica para juegos y oficina.', 130.00, 'silla_gamer.jpg'),
(3, 'Cafetera Nespresso', 'Cafetera automática con cápsulas incluidas.', 60.00, 'cafetera.jpg'),
(3, 'Televisor 4K', 'Smart TV 55 pulgadas, UHD 4K, WiFi.', 700.00, 'televisor.jpg'),
(3, 'Escritorio moderno', 'Escritorio blanco con cajones, ideal para home office.', 90.00, 'escritorio.jpg'),
(3, 'Auriculares inalámbricos', 'Auriculares Bluetooth con cancelación de ruido.', 80.00, 'auriculares.jpg'),
(3, 'Aspiradora robot', 'Robot aspirador para limpieza automática.', 150.00, 'aspiradora.jpg'),
(3, 'Reloj inteligente', 'Smartwatch compatible con Android y iOS.', 55.00, 'reloj.jpg'),
(3, 'Cámara deportiva', 'Cámara GoPro resistente al agua.', 120.00, 'camara_sport.jpg'),
(3, 'Impresora multifunción', 'Impresora, escáner y copiadora HP.', 65.00, 'impresora.jpg');

-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type CHAR(3) NOT NULL DEFAULT 'WEB',
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(2048) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
	id INT PRIMARY KEY auto_increment,
    url VARCHAR(250) NOT NULL UNIQUE KEY,
	count INT NOT NULL DEFAULT 1,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL, 
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;