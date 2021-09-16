/*
    Bianca Oliveira De Camargo - 03
    Carla Julia Franco de Toledo - 04
    Felipe Lima Estevanatto - 06
    Gabriel Gomes Nicolim - 08 
    Samuel Sensolo Goldflus - 32
*/

/* =-=-=-=-= Data Última Atualização 15/09/2021 =-=-=-=-= */

DROP TABLE IF EXISTS pwdreset, order_products, orders, products, adresses, users;

CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    name_user VARCHAR(256) NOT NULL,
    cpf_user CHAR(11) NOT NULL UNIQUE,
    email_user VARCHAR(255) NOT NULL UNIQUE,
    password_user VARCHAR(255) NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE,
    deleted BOOLEAN DEFAULT FALSE,
    deteted_at DATE DEFAULT NULL
);

CREATE TABLE adresses (
    id_adress SERIAL PRIMARY KEY,
    street_adress TEXT NOT NULL,
    district_adress TEXT NOT NULL,
    cep_adress CHAR(10) NOT NULL,
    number_adress INT NOT NULL,
    complement_adress TEXT,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

CREATE TABLE products (
    id_product SERIAL PRIMARY KEY,
    name_product VARCHAR(128) NOT NULL,
    photo_product TEXT DEFAULT NULL,
    description_product TEXT NOT NULL,
    price_product DECIMAL(10, 2) NOT NULL,
    type_product VARCHAR(128) NOT NULL, 
    quantity_product INT NOT NULL
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