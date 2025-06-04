create table faction (
    idF int(11) primary key,
    nom varchar(150),
    appartenance varchar(150),
    influence varchar(255),
    age varchar(150),
    bio varchar(2000), -- nouveau
);

create table personnage (
    idPers int(11) primary auto_increment,
    nom varchar(150),
    idF int(11),
    sousFaction varchar(150),
    age varchar(150),
    taille decimal(5,2),
    genre varchar(150),
    statut varchar(150),
    classe varchar(150),
    bio varchar(2000), -- nouveau
    foreign key idF references faction(idF) on delete cascade,
);

create table planete (
    idP int(11) primary key auto_increment,
    nom varchar(150),
    statut varchar(150),
    idF int(11),
    bio varchar(2000), -- nouveau
    foreign key idF references faction(idF) on delete cascade,
);

create table minifigs_sets (
    idM int(11) primary key,
    nom varchar(150),
    prix decimal(5,2),
    stock int(11),
    idF int(11),
    image varchar(255),
    foreign key idF references faction(idF) on delete cascade,
);

create table utilisateur (
    emailU varchar(150) primary key,
    mdpU varchar(36),
    pseudo varchar(50),
    ville varchar(300),
    codePostal int(11),
    numeroRue int(11),
    nomRue varchar(150),
    idF int(11),
    idPers int(11),
    foreign key idF references faction(idF) on delete cascade,
);

create table joueur (
    emailU varchar(150),
    idF int(11),
    pseudo varchar(255),
    pts int(11),
    primary key (emailU, idF),
);

create table achat (
    idA int(11) primary key auto_increment,
    emailU varchar(150),
    idM int(11),
    primary key (emailU, idF),
); 