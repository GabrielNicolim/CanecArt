/*
    Bianca Oliveira De Camargo - 03
    Carla Julia Franco de Toledo - 04
    Felipe Lima Estevanatto - 06
    Gabriel Gomes Nicolim - 08
    Samuel Sensolo Goldflus - 32
*/

/* =-=-=-=-= Data Última Atualização 26/10/2021 =-=-=-=-= */

DROP SCHEMA IF EXISTS eq3 CASCADE;
CREATE SCHEMA IF NOT EXISTS eq3;

DROP TABLE IF EXISTS eq3.pwdreset, eq3.order_products, eq3.orders, eq3.products, eq3.adresses, eq3.users CASCADE;

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
    complement_adress TEXT DEFAULT NULL,
    deleted BOOLEAN DEFAULT FALSE,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES eq3.users (id_user),
	UNIQUE (id_adress, fk_user)
);

CREATE TABLE eq3.products (
    id_product SERIAL PRIMARY KEY,
    code_product VARCHAR(14) NOT NULL,
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
    backup_adress_order TEXT NOT NULL CHECK (backup_adress_order <> ''),
    contact_order VARCHAR(384) NOT NULL CHECK (contact_order <> ''),
    status_order VARCHAR(128) NOT NULL DEFAULT 'AGUARDANDO PAGAMENTO',
    date_order DATE DEFAULT CURRENT_DATE,
    track_order VARCHAR(32) DEFAULT NULL,

    fk_user BIGINT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES eq3.users (id_user),

    fk_adress BIGINT NOT NULL,
    FOREIGN KEY (fk_adress) REFERENCES eq3.adresses (id_adress)
);

CREATE TABLE eq3.order_products (
    id_order_product SERIAL PRIMARY KEY,
    quantity_product INT NOT NULL DEFAULT 1,

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


/* Function and trigger to deduct from stock */
CREATE OR REPLACE FUNCTION update_stock()
RETURNS trigger as $log$
 BEGIN

	-- If new order, check if there is stock for the order and deduct from quantity stock, if not, make data not able to the inserted
	IF (TG_OP = 'INSERT') THEN
		IF ((SELECT quantity_product FROM eq3.products WHERE id_product = new.fk_product) >= new.quantity_product) THEN
            UPDATE eq3.products
            SET quantity_product = quantity_product - new.quantity_product
            WHERE id_product = new.fk_product;
            RETURN NEW;
        ELSE
            DELETE FROM eq3.order_products WHERE fk_order = new.fk_order;
            DELETE FROM eq3.orders WHERE id_order = new.fk_order;
            RETURN NULL;
        END IF;

        
	END IF;

 END;
$log$ language plpgsql;

DROP TRIGGER IF EXISTS trigger_update_stock ON eq3.order_products;
CREATE TRIGGER trigger_update_stock
	BEFORE INSERT ON eq3.order_products
	FOR EACH ROW
EXECUTE PROCEDURE update_stock();

/* Dummy data for first time insert */

INSERT INTO eq3.users(name_user, cpf_user, email_user, password_user, deleted_at) 
VALUES
/* jorge@gmail.com - jorge */
('Jorge', '21935947087', 'jorge@gmail.com', '$2y$10$lm52RriLOKv.j159jSfegu9NidmJarl54gQivT0azOeVsaSK/1L9O', null),
/* pedro@gmail.com - pedro */
('Pedro', '76106379041', 'pedro@gmail.com', '$2y$10$GF0IuWQmzOSzH8eYtVesx.LBsoAgC0kMRveGatE6W3Qs9dfPAmmHy', null),
/* joao@gmail.com - joao */
('João', '57865450087', 'joao@gmail.com', '$2y$10$Lpy.6dI1H.FPEYH2TIgkFeOZnQbDGORKIgrColL1xeiQofZaQg3M.', null) ON CONFLICT DO NOTHING;

/* ============= ENDEREÇOS ============================================================================================= */
INSERT INTO eq3.adresses(contact_adress, state_adress, city_adress, street_adress, district_adress, cep_adress, number_adress, complement_adress, fk_user) 
VALUES
/* Endereços Jorge*/
('Jorge Vieira', 'SP', 'Bauru', 'Rua Carminho da bica', 'Centro', '17050-753', '42', 'Quadra 7', '1'),
('Jorge da Silva', 'SP', 'Bauru', 'Rua Pedrinho de Liberato', 'Bela vista', '17040-560', '28', 'Quadra 5', '1'),
/* Endereço Pedro */
('Pedro de Melo', 'PA', 'Santarém', 'Avenida Maicá', 'Santana', '68010-390', '11', 'Quadra 9', '2'),
/* Endereço João */
('João Paulo', 'AL', 'Maceió', 'Rua Ricardo Cesar de Melo', 'Pinheiro', '57055-670', '76', 'Quadra 2', '3');

/* ============= PRODUTOS ============================================================================================= */
INSERT INTO eq3.products(code_product, name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_product, tax_product, deleted_at) 
VALUES
/* Caneca Attack on titan */
('011.11.00003-1','Caneca Attack on Titan Tropas', 'card1-image.png', 'Caneca da Tropa de Exploração - Asas da Liberdade de Shingeki no Kyojin com as logos da
Tropa de Exploração, Polícia Militar e Tropa Estacionária. Branca, 325ml', 35.70, 'Attack_on_Titan 325ml Branca Exploração', 55, 10, 59.73, 18, null),	   
/* Caneca Bulbassaurica */
('010.16.00001-1', 'Caneca Bulbassauro Pokemon', 'card2-image.jpg', 'Caneca do Bulbassauro - Pokemon. Com cabo verde e muito bonito, recomendo de verdade. 
Branca, 325ml', 40.0, 'Bulbassauro Pokemon 325ml Branca', 38, 10, 61.96, 18, null),	   
/* Caneca Goku */
('011.12.00006-1', 'Caneca Dragon Ball Goku', 'card3-image.jpg', 'Caneca do Goku de Dragon Ball Z, ou conhecido como: neto adotivo de Vovô Gohan, filho de 
Bardock e Gine, o irmão mais novo de Raditz, o marido de Chichi, pai de Gohan e Goten, avô de Pan e mais tarde tataravô de Goku Jr.
Branca, 325ml', 41.50, 'Goku Dragon_Ball_Z 325ml Laranja', 25, 10, 57.00, 18, null),
/* Caneca Zelda Térmica */
('010.11.00007-1', 'Caneca Mágica Legend of Zelda Icons', 'card4-image.jpg', 'Caneca preta do Link - Legend of Zelda com os icones da saga que aparecem
quando a caneca é exposta ao calor. Branca, 325ml', 37.70, 'Legend_of_Zelda 325ml Térmica', 20, 10, 58.69, 18,  null),
/* Caneca Jinx */
('010.10.00002-1', 'Caneca League of Legends - Jinx', 'card5-image.jpg', 'Caneca League of Legend da Jinx, compre a caneca do seu main pra continuar
perdendo PDL mas dessa vez muito bem hidratado! Caneca Branca, 325ml', 37.50, 'Jinx League_of_Legends 325ml Branca', 30, 10, 48.56, 18, null),
/* Caneca Genérico cafeina */
('012.10.00004-1', 'Caneca Genérico Cafenína', 'card6-image.jpg', 'Caneca "medicamento genérico", para ter uma representação da droga lícita mais 
importante para a produtividade mundial no século XXI. Branca, 335ml', 45.00, 'Generico Cafeina 325ml Branca', 25, 10, 59.78, 18, null),
/* Caneca Windows BSOD */
('012.14.00008-1', 'Caneca Windows Tela Azul', 'card7-image.jpg', 'Caneca Windows com a Blue Screen of Death do Windows 10, as vezes nunca se sabe
exatamente o que invocou essa tela na sua frente, assim como não sabemos se alguem vai querer comprar uma comum causa de desespero.
Caneca Branca, 325ml', 35.00, 'Windows BSOD 325ml Térmica', 25, 10, 48.56, 18, null),
/* Caneca NASA */
('012.14.00009-1', 'Caneca NASA', 'card8-image.jpg', 'Uma caneca da NASA, olha que legal, a industria descobriu que se você vender produtos estampados
como instituições governamentais americanas em produtos as pessoas compram, e você não precisa nem pagar direitos autorais, incrivel!
Caneca Branca, 325ml', 35.70, 'NASA foguete 325ml Branca', 35, 10, 48.56, 18, null),
/* Caneca R2D2 */
('011.10.00005-1', 'Caneca R2D2', 'card9-image.jpg', 'Caneca Star Wars - R2D2 toda estampada, Star Wars é uma franquia muito legal, mas para chamar mais
a atenção o marketing decidiu tirar a foto com o cabo na caneca no outro lado, deu certo?.
Caneca Branca, 325ml', 40.00, 'R2D2 Star_Wars 325ml Branca', 40, 10, 58.69, 18, null);

/*====================================================================================*/
/*Pedidos base e produtos dos pedidos*/
INSERT INTO eq3.orders(backup_adress_order, contact_order, date_order, fk_user, fk_adress)
VALUES 
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '10/25/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '10/25/2021',  1, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '10/23/2021',  2, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '10/26/2021',  3, 1);

INSERT INTO eq3.order_products(quantity_product, fk_order, fk_product)
VALUES 
(1, 1, 1), (2, 1, 4), (1,1,7), 
(5, 2, 2), (1 ,2 ,5),
(1, 3, 4),
(2, 4, 4), (1, 4, 9);