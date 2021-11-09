/*
    Bianca Oliveira De Camargo - 03
    Carla Julia Franco de Toledo - 04
    Felipe Lima Estevanatto - 06
    Gabriel Gomes Nicolim - 08
    Samuel Sensolo Goldflus - 32
*/

/* =-=-=-=-= Data Última Atualização 07/11/2021 =-=-=-=-= */

SET datestyle = "ISO, DMY";

DROP SCHEMA IF EXISTS eq3 CASCADE;
CREATE SCHEMA IF NOT EXISTS eq3;

--DROP TABLE IF EXISTS eq3.pwdreset, eq3.order_products, eq3.orders, eq3.products, eq3.adresses, eq3.users CASCADE;

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
    type_product VARCHAR(128) NOT NULL, 
    quantity_product INT NOT NULL CHECK (quantity_product >= 0),
    price_product DECIMAL(10, 2) NOT NULL CHECK (quantity_product >= 0),
    base_cost_product NUMERIC(10,2) DEFAULT 0,
    profit_margin NUMERIC(10,2) DEFAULT 0,
    tax_product DECIMAL(10, 2) DEFAULT 18.0,
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

    fk_adress BIGINT NOT NULL
    --FOREIGN KEY (fk_adress) REFERENCES eq3.adresses (id_adress)
);

CREATE TABLE eq3.order_products (
    id_order_product SERIAL PRIMARY KEY,
    quantity_product INT NOT NULL DEFAULT 1,
    price_backup INT NOT NULL DEFAULT 0,

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
INSERT INTO eq3.products(code_product, name_product, photo_product, description_product, price_product, type_product, quantity_product, base_cost_product, profit_margin, deleted_at) 
VALUES
/* Caneca Attack on titan */
('011.11.00003-1','Caneca Attack on Titan Tropas', 'card1-image.png', 'Caneca da Tropa de Exploração - Asas da Liberdade de Shingeki no Kyojin com as logos da
Tropa de Exploração, Polícia Militar e Tropa Estacionária. Branca, 325ml', 33.50, 'Attack_on_Titan 325ml Branca Exploração', 100, 19.50, 40, null),	   
/* Caneca Bulbassaurica */
('010.16.00001-1', 'Caneca Bulbassauro Pokemon', 'card2-image.jpg', 'Caneca do Bulbassauro - Pokemon. Com cabo verde e muito bonito, recomendo de verdade. 
Branca, 325ml', 37.50, 'Bulbassauro Pokemon 325ml Branca', 51, 22, 40, null),	   
/* Caneca Goku */
('011.12.00006-1', 'Caneca Dragon Ball Goku', 'card3-image.jpg', 'Caneca do Goku de Dragon Ball Z, ou conhecido como: neto adotivo de Vovô Gohan, filho de 
Bardock e Gine, o irmão mais novo de Raditz, o marido de Chichi, pai de Gohan e Goten, avô de Pan e mais tarde tataravô de Goku Jr.
Branca, 325ml', 40.00, 'Goku Dragon_Ball_Z 325ml Laranja', 100, 23.50, 40, null),
/* Caneca Zelda Térmica */
('010.11.00007-1', 'Caneca Mágica Legend of Zelda Icons', 'card4-image.jpg', 'Caneca preta do Link - Legend of Zelda com os icones da saga que aparecem
quando a caneca é exposta ao calor. Branca, 325ml', 35.00, 'Legend_of_Zelda 325ml Térmica', 50, 20.50, 40, null),
/* Caneca Jinx */
('010.10.00002-1', 'Caneca League of Legends - Jinx', 'card5-image.jpg', 'Caneca League of Legend da Jinx, compre a caneca do seu main pra continuar
perdendo PDL mas dessa vez muito bem hidratado! Caneca Branca, 325ml', 35.00, 'Jinx League_of_Legends 325ml Branca', 100, 20.50, 40, null),
/* Caneca Genérico cafeina */
('012.10.00004-1', 'Caneca Genérico Cafenína', 'card6-image.jpg', 'Caneca "medicamento genérico", para ter uma representação da droga lícita mais 
importante para a produtividade mundial no século XXI. Branca, 335ml', 32.50, 'Generico Cafeina 325ml Branca', 100, 19.00, 40, null),
/* Caneca Windows BSOD */
('012.14.00008-1', 'Caneca Windows Tela Azul', 'card7-image.jpg', 'Caneca Windows com a Blue Screen of Death do Windows 10, as vezes nunca se sabe
exatamente o que invocou essa tela na sua frente, assim como não sabemos se alguem vai querer comprar uma comum causa de desespero.
Caneca Branca, 325ml', 40.00, 'Windows BSOD 325ml Térmica', 100, 23.50, 40, null),
/* Caneca NASA */
('012.14.00009-1', 'Caneca NASA', 'card8-image.jpg', 'Uma caneca da NASA, olha que legal, a industria descobriu que se você vender produtos estampados
como instituições governamentais americanas em produtos as pessoas compram, e você não precisa nem pagar direitos autorais, incrivel!
Caneca Branca, 325ml', 33.50, 'NASA foguete 325ml Branca', 100, 19.50, 40, null),
/* Caneca R2D2 */
('011.10.00005-1', 'Caneca R2D2', 'card9-image.jpg', 'Caneca Star Wars - R2D2 toda estampada, Star Wars é uma franquia muito legal, mas para chamar mais
a atenção o marketing decidiu tirar a foto com o cabo na caneca no outro lado, deu certo?.
Caneca Branca, 325ml', 37.50, 'R2D2 Star_Wars 325ml Branca', 100, 22.00, 40, null);

/*====================================================================================*/
/*Pedidos base e produtos dos pedidos*/
INSERT INTO eq3.orders(backup_adress_order, contact_order, date_order, fk_user, fk_adress)
VALUES 
-- Order 1 to 10 from client 1
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '01/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '02/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '08/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '09/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '15/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '16/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '22/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '23/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '29/10/2021',  1, 1),
('17050-753 - SP, Bauru, Centro, Rua Carminho da bica, Numero 42 - Quadra 7', 'Jorge Vieira', '30/10/2021',  1, 1),
-- Order 12 to 20 from client 2
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '01/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '02/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '08/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '09/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '15/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '16/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '22/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '29/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '30/10/2021',  2, 1),
('17030-310 - SP, Bauru, Vila Cardia Monlevade, Rua Dr. José Raniere, Numero 4 - Quadra 12', 'Pedro Golden', '30/10/2021',  2, 1),
-- Order 21 to 30 from client 3
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '01/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '02/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '08/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '09/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '15/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '16/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '22/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '23/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '29/10/2021',  3, 1),
('17010-753 - SP, Bauru, Guarajá, Rua Pedro de Melo, numero 09 - Quadra 12', 'Maria da Clara', '30/10/2021',  3, 1);

INSERT INTO eq3.order_products(fk_order, quantity_product, fk_product)
VALUES
-- Order 1 to 10 from client 1
(1, 3, 2), (1, 3, 9), (1, 4, 1), (1, 1, 4), (1, 1, 5), (1, 2, 8), --order 1
(2, 2, 2), (2 ,2 ,9), (2 ,2 ,6), (2 ,3 ,1), (2 ,2 ,5), (2 ,2 ,7), (2 ,1 ,8),-- order 2
(3, 1, 2), (3, 1, 9), (3, 1, 3),-- order 3
(4, 2, 2), (4, 2, 9), (4, 1, 6), (4, 1, 4), (4, 1, 8), -- order 4
(5, 1, 2), (5, 2, 9), (5, 1, 4), (5, 1, 8), -- order 5
(6, 3, 2), (6, 1, 9), (6, 1, 6), (6, 1, 3), -- order 6
(7, 2, 2), (7, 1, 9), (7, 2, 3), (7, 2, 8), -- order 7
(8, 1, 2), (8, 1, 9), (8, 1, 4), (8, 1, 8), -- order 8
(9, 1, 2), (9, 1, 6), (9, 1, 3), (9, 1, 5), -- order 9
(10, 1, 6), (10, 1, 3), (10, 2, 5), (10, 1, 8), -- order 10

-- Order 11 to 20 from client 2
(11, 2, 2), (11, 2, 9), (11, 1, 6), (11, 3, 1), (11, 1, 5), (11, 3, 8),-- order 11
(12, 1, 2), (12, 1, 9), (12, 2, 1), (12, 1, 4), (12, 1, 5), (12, 3, 7), (12, 1, 8),-- order 12
(13, 3, 2), (13, 1, 9), (14, 1, 3),-- order 13
(14, 2, 2), (14, 1, 3), (14, 1, 4), (14, 1, 5), (14, 2, 8),-- order 14
(15, 3, 2), (15, 1, 9), (15, 1, 6), (15, 2, 4), (15, 1, 8),-- order 15
(16, 1, 2), (16, 2, 9), -- order 16
(17, 1, 2), (17, 1, 9), (17, 1, 6), (17, 1, 3), (17, 1, 7), (17, 1, 8),-- order 17
(18, 1, 2), (18, 1, 6), (18, 1, 4), -- order 18
(19, 2, 9), (19, 2, 6), (19, 1, 3), (19, 1, 5),-- order 19
(20, 2, 2), (20, 1, 6), (20, 1, 3), (20, 1, 8),-- order 20

-- Order 21 to 30 from client 3
(21, 5, 2), (21, 2, 9), (21, 1, 6), (21, 2, 1), (21, 1, 4), (21, 1, 5), (21, 2, 8),-- order 21
(22, 1, 2), (22, 1, 9), (22, 2, 1), (22, 1, 5), (22, 1, 7), (22, 2, 8),-- order 22
(23, 1, 2), (23, 1, 9), (23, 1, 3), -- order 23
(24, 2, 2), (24, 1, 4), (24, 1, 8),-- order 24
(25, 3, 2), (25, 2, 9), (25, 1, 6), (25, 1, 4), (25, 2, 5), (25, 1, 8),-- order 25
(26, 2, 2), (26, 2, 7), -- order 26
(27, 2, 2), (27, 1, 9), (27, 1, 3), (27, 1, 4), (27, 1, 7), (27, 1, 8),-- order 27
(28, 1, 6), (28, 2, 3), (28, 2, 7),-- order 28
(29, 2, 2), (29, 1, 9), (29, 1, 3), (29, 1, 5),-- order 29
(30, 1, 2), (30, 1, 9), (30, 1, 6), (30, 2, 3), (30, 1, 5); -- order 30