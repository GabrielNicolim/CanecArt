/*
    Bianca Oliveira De Camargo - 03
    Carla Julia Franco de Toledo - 04
    Felipe Lima Estevanatto - 06
    Gabriel Gomes Nicolim - 08 
    Samuel Sensolo Goldflus - 32
*/

/* =-=-=-=-= Data Última Atualização 24/09/2021 =-=-=-=-= */

DROP TABLE IF EXISTS pwdreset, order_products, orders, products, adresses, users;

CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    name_user VARCHAR(256) NOT NULL,
    cpf_user CHAR(11) NOT NULL UNIQUE,
    email_user VARCHAR(255) NOT NULL UNIQUE,
    password_user VARCHAR(255) NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE,
    deleted BOOLEAN DEFAULT FALSE,
    deleted_at DATE DEFAULT CURRENT_DATE
);

CREATE TABLE adresses (
    id_adress SERIAL PRIMARY KEY,
    contact_adress VARCHAR(255) NOT NULL,
    state_adress VARCHAR(255) NOT NULL,
    city_adress VARCHAR(255) NOT NULL,
    street_adress TEXT NOT NULL,
    district_adress TEXT NOT NULL,
    cep_adress CHAR(10) NOT NULL,
    number_adress INT NOT NULL,
    complement_adress TEXT,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES users (id_user),
	UNIQUE (id_adress, fk_user)
);

CREATE TABLE products (
    id_product SERIAL PRIMARY KEY,
    name_product VARCHAR(128) NOT NULL,
    photo_product TEXT DEFAULT NULL,
    description_product TEXT NOT NULL,
    price_product DECIMAL(10, 2) NOT NULL,
    type_product VARCHAR(128) NOT NULL, 
    quantity_product INT NOT NULL,
    deleted BOOLEAN DEFAULT FALSE,
    deleted_at DATE DEFAULT CURRENT_DATE
);

CREATE TABLE orders (
    id_order SERIAL PRIMARY KEY,
    status_order VARCHAR(128) NOT NULL,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES users (id_user),

    fk_adress BIGINT NOT NULL,
    FOREIGN KEY (fk_adress) REFERENCES adresses (id_adress)
);

CREATE TABLE order_products (
    id_order_product SERIAL PRIMARY KEY,

    fk_order BIGINT NOT NULL,
    FOREIGN KEY (fk_order) REFERENCES orders (id_order),

    fk_product BIGINT NOT NULL,
    FOREIGN KEY (fk_product) REFERENCES products (id_product)
);

CREATE TABLE pwdreset (
  id_pwdrequest SERIAL PRIMARY KEY NOT NULL,
  ip_pwdrequest VARCHAR(46) NOT NULL,
  date_pwdrequest TIMESTAMP NOT NULL DEFAULT now(),
  city_pwdrequest VARCHAR(128),
  region_pwdrequest VARCHAR(128),
  country_pwdrequest VARCHAR(128),
  selector_pwdrequest TEXT NOT NULL,
  token_pwdrequest TEXT NOT NULL,
  expires_pwdrequest VARCHAR(32) NOT NULL,

  fk_email VARCHAR(256) NOT NULL,
  FOREIGN KEY (fk_email) REFERENCES users (email_user)
);

/* Dummy data for first time insert */

/* jorge@gmail.com - jorge */
INSERT INTO users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES('Jorge', '21935947087', 'jorge@gmail.com', '$2y$10$lm52RriLOKv.j159jSfegu9NidmJarl54gQivT0azOeVsaSK/1L9O', null) ON CONFLICT DO NOTHING;

/* pedro@gmail.com - pedro */
INSERT INTO users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES('Pedro', '76106379041', 'pedro@gmail.com', '$2y$10$GF0IuWQmzOSzH8eYtVesx.LBsoAgC0kMRveGatE6W3Qs9dfPAmmHy', null) ON CONFLICT DO NOTHING;

/* joao@gmail.com - joao */
INSERT INTO users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES('João', '57865450087', 'joao@gmail.com', '$2y$10$Lpy.6dI1H.FPEYH2TIgkFeOZnQbDGORKIgrColL1xeiQofZaQg3M.', null) ON CONFLICT DO NOTHING;


/* Endereço Jorge */
INSERT INTO adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES('Jorge da Silva', 'SP', 'Bauru', 'Rua pedrinho zói de gato', 'Bela vista', '17040560', '28', 'Quadra 5', '1');

/* Endereço Pedro */
INSERT INTO adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES('Pedro Malboro', 'PA', 'Santarém', 'Avenida Maicá', 'Santana', '68010390', '11', 'Quadra 9', '2');

/* Endereço João */
INSERT INTO adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES('João Paulo', 'AL', 'Maceió', 'Rua Ricardo Cesar de Melo', 'Pinheiro', '57055670', '76', 'Quadra 2', '3');


/* Caneca Attack on titan */
INSERT INTO products(name_product, photo_product, description_product, price_product, type_product, quantity_product, deleted_at) 
VALUES('Caneca Attack on Titan', 'card1-image.png', 'Caneca da Tropa de Exploração - Asas da Liberdade de Shingeki no Kyojin
	   Branca, 335ml', 45.00, 'Attack_on_Titan 325ml Branca Exploração', '50', null);
	   
/* Caneca Bulbassaurica */
INSERT INTO products(name_product, photo_product, description_product, price_product, type_product, quantity_product, deleted_at) 
VALUES('Caneca Bulbassauro Pokemon', 'card2-image.jpg', 'Caneca do Bulbassauro - Pokemon. Com cabo verde
	   Branca, 335ml', 45.00, 'Bulbassauro Pokemon 325ml Branca', '30', null);
	   
/* Caneca Goku */
INSERT INTO products(name_product, photo_product, description_product, price_product, type_product, quantity_product, deleted_at) 
VALUES('Caneca Dragon Ball Goku', 'card3-image.jpg', 'Caneca do Goku - Dragon Ball Z
	   Branca, 335ml', 45.00, 'Goku Dragon_Ball_Z 325ml Branca', '20', null);