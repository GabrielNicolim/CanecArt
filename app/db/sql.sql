CREATE TABLE users (
    id_user SERIAL PRIMARY KEY NOT NULL,
    name_user VARCHAR(256) NOT NULL,
    cpf_user CHAR(11) NOT NULL,
    email_user VARCHAR(255) NOT NULL UNIQUE,
    password_user CHAR(72) NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE,
    deleted BOOLEAN DEFAULT FALSE,
    deteted_at DATE DEFAULT NULL,
    is_admin BOOLEAN DEFAULT FALSE
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
    description_produtc TEXT NOT NULL,
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
  id_pwdReset SERIAL PRIMARY KEY NOT NULL,
  ipRequest VARCHAR(46) NOT NULL,
  dateRequest TIMESTAMP NOT NULL DEFAULT now(),
  cityRequest VARCHAR(128),
  regionRequest VARCHAR(128),
  countryRequest VARCHAR(128),
  pwdResetEmail VARCHAR(256) NOT NULL,
  pwdResetSelector TEXT NOT NULL,
  pwdResetToken TEXT NOT NULL,
  pwdResetExpires VARCHAR(32) NOT NULL
);

/*

DROP TABLE pwdreset, order_products, orders, products, adresses, users;

*/