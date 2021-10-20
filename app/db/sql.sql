/*
    Bianca Oliveira De Camargo - 03
    Carla Julia Franco de Toledo - 04
    Felipe Lima Estevanatto - 06
    Gabriel Gomes Nicolim - 08 
    Samuel Sensolo Goldflus - 32
*/

/* =-=-=-=-= Data Última Atualização 19/10/2021 =-=-=-=-= */

CREATE SCHEMA IF NOT EXISTS eq3;

DROP TABLE IF EXISTS eq3.pwdreset, eq3.order_products, eq3.orders, eq3.products, eq3.adresses, eq3.users;

CREATE TABLE eq3.users (
    id_user SERIAL PRIMARY KEY,
    name_user VARCHAR(256) NOT NULL,
    cpf_user CHAR(11) NOT NULL UNIQUE,
    email_user VARCHAR(255) NOT NULL UNIQUE,
    password_user VARCHAR(255) NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE,
    deleted BOOLEAN DEFAULT FALSE,
    deleted_at DATE DEFAULT CURRENT_DATE
);

CREATE TABLE eq3.adresses (
    id_adress SERIAL PRIMARY KEY,
    contact_adress VARCHAR(255) NOT NULL,
    state_adress VARCHAR(255) NOT NULL,
    city_adress VARCHAR(255) NOT NULL,
    street_adress TEXT NOT NULL,
    district_adress TEXT NOT NULL,
    cep_adress CHAR(10) NOT NULL,
    number_adress INT NOT NULL,
    complement_adress TEXT,
    deleted BOOLEAN DEFAULT FALSE,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES eq3.users (id_user),
	UNIQUE (id_adress, fk_user)
);

CREATE TABLE eq3.products (
    id_product SERIAL PRIMARY KEY,
    name_product VARCHAR(128) NOT NULL,
    photo_product TEXT DEFAULT NULL,
    description_product VARCHAR(512) NOT NULL,
    price_product DECIMAL(10, 2) NOT NULL,
    type_product VARCHAR(128) NOT NULL, 
    quantity_product INT NOT NULL CHECK (quantity_product >= 0),
    base_cost_product NUMERIC(10,2) DEFAULT 0,
    profit_product NUMERIC(10,2) DEFAULT 0,
    tax_product DECIMAL(10,2),
    deleted BOOLEAN DEFAULT FALSE,
    deleted_at DATE DEFAULT CURRENT_DATE
);

CREATE TABLE eq3.orders (
    id_order SERIAL PRIMARY KEY,
    status_order VARCHAR(128) NOT NULL,
    date_order DATE DEFAULT CURRENT_DATE,
    track_order VARCHAR(32) DEFAULT NULL,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES eq3.users (id_user),

    fk_adress BIGINT NOT NULL,
    FOREIGN KEY (fk_adress) REFERENCES eq3.adresses (id_adress)
);

CREATE TABLE eq3.order_products (
    id_order_product SERIAL PRIMARY KEY,
    quantity_product INT DEFAULT 1,

    fk_order INT NOT NULL,
    FOREIGN KEY (fk_order) REFERENCES eq3.orders (id_order),

    fk_product INT NOT NULL,
    FOREIGN KEY (fk_product) REFERENCES eq3.products (id_product) 
);

CREATE TABLE eq3.pwdreset (
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
  FOREIGN KEY (fk_email) REFERENCES eq3.users (email_user)
);

/* Dummy data for first time insert */

/* jorge@gmail.com - jorge */
INSERT INTO eq3.users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES('Jorge', '21935947087', 'jorge@gmail.com', '$2y$10$lm52RriLOKv.j159jSfegu9NidmJarl54gQivT0azOeVsaSK/1L9O', null) ON CONFLICT DO NOTHING;

/* pedro@gmail.com - pedro */
INSERT INTO eq3.users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES('Pedro', '76106379041', 'pedro@gmail.com', '$2y$10$GF0IuWQmzOSzH8eYtVesx.LBsoAgC0kMRveGatE6W3Qs9dfPAmmHy', null) ON CONFLICT DO NOTHING;

/* joao@gmail.com - joao */
INSERT INTO eq3.users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES('João', '57865450087', 'joao@gmail.com', '$2y$10$Lpy.6dI1H.FPEYH2TIgkFeOZnQbDGORKIgrColL1xeiQofZaQg3M.', null) ON CONFLICT DO NOTHING;

/* ========================================================================================================== */
/* Endereço Jorge */
INSERT INTO eq3.adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES('Jorge da Silva', 'SP', 'Bauru', 'Rua Pedrinho de Liberato', 'Bela vista', '17040560', '28', 'Quadra 5', '1');

/* Endereço Pedro */
INSERT INTO eq3.adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES('Pedro Malboro', 'PA', 'Santarém', 'Avenida Maicá', 'Santana', '68010390', '11', 'Quadra 9', '2');

/* Endereço João */
INSERT INTO eq3.adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES('João Paulo', 'AL', 'Maceió', 'Rua Ricardo Cesar de Melo', 'Pinheiro', '57055670', '76', 'Quadra 2', '3');

/* ========================================================================================================== */
/* Caneca Attack on titan */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca Attack on Titan Tropas', 'card1-image.png', 'Caneca da Tropa de Exploração - Asas da Liberdade de Shingeki no Kyojin com as logos da
Tropa de Exploração, Polícia Militar e Tropa Estacionária. Branca, 325ml', 44.90, 'Attack_on_Titan 325ml Branca Exploração', 50, 10, 59.73, 18, null);
	   
/* Caneca Bulbassaurica */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca Bulbassauro Pokemon', 'card2-image.jpg', 'Caneca do Bulbassauro - Pokemon. Com cabo verde e muito bonito, recomendo de verdade. 
Branca, 325ml', 49.90, 'Bulbassauro Pokemon 325ml Branca', 30, 10, 61.96, 18, null);
	   
/* Caneca Goku */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca Dragon Ball Goku', 'card3-image.jpg', 'Caneca do Goku de Dragon Ball Z, ou conhecido como: neto adotivo de Vovô Gohan, filho de 
Bardock e Gine, o irmão mais novo de Raditz, o marido de Chichi, pai de Gohan e Goten, avô de Pan e mais tarde tataravô de Goku Jr.
Branca, 325ml', 40.00, 'Goku Dragon_Ball_Z 325ml Laranja', 20, 10, 57.00, 18, null);

/* Caneca Zelda Térmica */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca Mágica Legend of Zelda Icons', 'card4-image.jpg', 'Caneca preta do Link - Legend of Zelda com os icones da saga que aparecem
quando a caneca é exposta ao calor. Branca, 325ml', 42.90, 'Legend_of_Zelda 325ml Térmica', 10, 10, 58.69, 18,  null);

/* Caneca Jinx */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca League of Legends - Jinx', 'card5-image.jpg', 'Caneca League of Legend da Jinx, compre a caneca do seu main pra continuar
perdendo PDL mas dessa vez muito bem hidratado! Caneca Branca, 325ml', 29.90, 'Jinx League_of_Legends 325ml Branca', 25, 10, 48.56, 18, null);

/* Caneca Genérico cafeina */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca Genérico Cafenína', 'card6-image.jpg', 'Caneca "medicamento genérico", para ter uma representação da droga lícita mais 
importante para a produtividade mundial no século XXI.
Branca, 335ml', 45.00, 'Generico Cafeina 325ml Branca', 20, 10, 59.78, 18, null);

/* Caneca Windows BSOD */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca Windows Tela Azul', 'card7-image.jpg', 'Caneca Windows com a Blue Screen of Death do Windows 10, as vezes nunca se sabe
exatamente o que invocou essa tela na sua frente, assim como não sabemos se alguem vai querer comprar uma comum causa de desespero.
Caneca Branca, 325ml', 29.90, 'Windows BSOD 325ml Térmica', 5, 10, 48.56, 18, null);

/* Caneca NASA */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca NASA', 'card8-image.jpg', 'Uma caneca da NASA, olha que legal, a industria descobriu que se você vender produtos estampados
como instituições governamentais americanas em produtos as pessoas compram, e você não precisa nem pagar direitos autorais, incrivel!
Caneca Branca, 325ml', 29.90, 'NASA foguete 325ml Branca', 25, 10, 48.56, 18, null);

/* Caneca R2D2 */
INSERT INTO eq3.products(name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES('Caneca R2D2', 'card9-image.jpg', 'Caneca Star Wars - R2D2 toda estampada, Star Wars é uma franquia muito legal, mas para chamar mais
a atenção o marketing decidiu tirar a foto com o cabo na caneca no outro lado, deu certo?.
Caneca Branca, 325ml', 42.90, 'R2D2 Star_Wars 325ml Branca', 10, 10, 58.69, 18, null);

/* Function and trigger to deduct from stock */

CREATE OR REPLACE FUNCTION update_stock()
RETURNS trigger as $log$
 BEGIN

	-- If new order, deduct from quantity stock
	IF (TG_OP = 'INSERT') THEN
		UPDATE eq3.products
		   SET quantity_product = quantity_product - new.quantity_product
		 WHERE id_product = new.fk_product;
		RETURN NEW;
	END IF;

 END;
$log$ language plpgsql;

DROP TRIGGER IF EXISTS trigger_update_stock ON eq3.order_products;
CREATE TRIGGER trigger_update_stock
	AFTER INSERT ON eq3.order_products
	FOR EACH ROW
EXECUTE PROCEDURE update_stock();