-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- flavors Table
CREATE TABLE flavors (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    name TEXT NOT NULL UNIQUE,
    main_flavor TEXT NOT NULL,
    allergen TEXT NOT NULL,
    calories INTEGER NOT NULL
);

INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (1, 'Barvarian Rasberry Fudge', 'Vanilla' ,'Rasberry', '300');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (2, 'Big Red Bear Tracks', 'Vanilla' ,'Milk', '320');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (3, 'Cookie Dough Dream', 'Vanilla' ,'Milk', '290');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (4, 'Cookies And Cream', 'Vanilla' ,'Milk', '280');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (5, 'Kahlua Fudge', 'Coffee' ,'Milk', '310');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (6, 'Mint Chocolate Chip', 'Mint' ,'Eggs', '330');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (7, 'Mint Cookies And Cream', 'Mint' ,'Eggs', '340');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (8, 'Traditional Chocolate', 'Chocolate' ,'Eggs', '350');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (9, 'Triple Caramel Bliss', 'Vanilla' ,'Coconut', '270');
INSERT INTO flavors (id,name,main_flavor,allergen,calories) VALUES (10, 'Triple Play Chocolate', 'Chocolate' ,'Milk', '300');



-- images Table
CREATE TABLE images (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    file_name TEXT NOT NULL UNIQUE,
    file_extension TEXT NOT NULL,
    description TEXT NOT NULL
);

INSERT INTO images (id,file_name,file_extension,description) VALUES (1, 'barvarian_rasberry_fudge.jpg', 'jpg', 'Barvarian Rasberry Fudge');
-- Source: https://foodscience.cals.cornell.edu/people/cornell-dairy-ice-cream/
INSERT INTO images (id,file_name,file_extension,description) VALUES (2, 'big_red_bear_tracks.jpg', 'jpg', 'Big Red Bear Tracks');
-- Source: https://foodscience.cals.cornell.edu/people/big-red-bear-tracks/
INSERT INTO images (id,file_name,file_extension,description) VALUES (3, 'cookie_dough_dream.jpg', 'jpg', 'Cookie Dough Dream');
-- Source: https://foodscience.cals.cornell.edu/people/cookie-dough-dream/
INSERT INTO images (id,file_name,file_extension,description) VALUES (4, 'cookies_and_cream.jpg', 'jpg', 'Cookies And Cream');
-- Source: https://foodscience.cals.cornell.edu/people/cookies-and-cream/
INSERT INTO images (id,file_name,file_extension,description) VALUES (5, 'kahlua_fudge.jpg', 'jpg', 'Kahlua Fudge');
-- Source: https://foodscience.cals.cornell.edu/people/kalhua-fudge/
INSERT INTO images (id,file_name,file_extension,description) VALUES (6, 'mint_chocolate_chip.jpg', 'jpg', 'Mint Chocolate Chip');
-- Source: https://foodscience.cals.cornell.edu/people/mint-chocolate-chip/
INSERT INTO images (id,file_name,file_extension,description) VALUES (7, 'mint_cookies_and_cream.jpg', 'jpg', 'Mint Cookies And Cream');
-- Source: https://foodscience.cals.cornell.edu/people/mint-cookies-and-cream/
INSERT INTO images (id,file_name,file_extension,description) VALUES (8, 'traditional_chocolate.jpg', 'jpg', 'Traditional Chocolate');
-- Source: https://foodscience.cals.cornell.edu/people/traditional-chocolate/
INSERT INTO images (id,file_name,file_extension,description) VALUES (9, 'triple_caramel_bliss.jpg', 'jpg', 'Triple Caramel Bliss');
-- Source: https://foodscience.cals.cornell.edu/people/caramel-cubed/
INSERT INTO images (id,file_name,file_extension,description) VALUES (10, 'triple_play_chocolate.jpg', 'jpg', 'Triple Play Chocolate');
-- Source: https://foodscience.cals.cornell.edu/people/triple-play-chocolate/



-- tags Table
CREATE TABLE tags (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    tag_name TEXT NOT NULL UNIQUE,
    tag_description TEXT NOT NULL
);

INSERT INTO tags (id,tag_name,tag_description) VALUES (1, 'All', 'all flavors');
INSERT INTO tags (id,tag_name,tag_description) VALUES (2, 'Popular', 'best selling flavor');
INSERT INTO tags (id,tag_name,tag_description) VALUES (3, 'New', 'new flavor');
INSERT INTO tags (id,tag_name,tag_description) VALUES (4, 'Classic', 'classic flavor');
INSERT INTO tags (id,tag_name,tag_description) VALUES (5, 'Gluten-Free', 'gluten-free flavor');
INSERT INTO tags (id,tag_name,tag_description) VALUES (6, 'Fruity', 'flavor with fruits');
INSERT INTO tags (id,tag_name,tag_description) VALUES (7, 'Nuts', 'flavor with nuts');


-- image_tags Table
CREATE TABLE image_tags (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    image_id INTEGER NOT NULL,
    tag_id TEXT NOT NULL
);


INSERT INTO image_tags (id,image_id,tag_id) VALUES (1,1,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (2,2,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (3,3,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (4,4,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (5,5,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (6,6,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (7,7,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (8,8,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (9,9,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (10,10,1);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (11,1,2);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (12,1,3);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (13,1,6);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (14,2,2);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (15,2,4);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (16,3,4);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (17,3,5);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (18,4,2);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (19,4,4);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (20,5,3);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (21,5,5);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (22,6,2);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (23,6,4);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (24,7,3);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (25,7,5);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (26,8,2);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (27,8,4);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (28,9,3);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (29,9,5);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (30,9,7);
INSERT INTO image_tags (id,image_id,tag_id) VALUES (31,10,4);


COMMIT;
