drop database if exists pure;
create database pure;
use pure;

create table admin
(
    idAdmin int(5) not null auto_increment,
    firstName varchar(45) not null,
    lastName varchar(45) not null,
    sexe varchar(25) not null,
    email varchar(45) not null,
    password varchar(255) not null,
    avatar varchar(255) null,
    primary key (idAdmin)
);

create table user
(
    idUser int(5) not null auto_increment,
    firstName varchar(45) not null,
    lastName varchar(45) not null,
    sexe varchar(25) not null,
    email varchar(45) not null,
    password varchar(255) not null,
    avatar varchar(255) null,
    primary key (idUser)
);

create table categoriesArticle
(
    idCategorie int(5) not null auto_increment,
    label varchar(255) not null,
    primary key (idCategorie)
);

create table article
(
    idArticle int(5) not null auto_increment,
    idCategorie int(5) not null,
    idAdmin int(5) not null,
    title varchar(255) not null,
    content varchar(255) not null,
    thumbnail varchar(255) not null,
    created date not null,
    primary key (idArticle),
    foreign key (idAdmin) references admin(idAdmin),
    foreign key (idCategorie) references categoriesArticle(idCategorie)
);

create table eventUser
(
    idArticle int(5) not null,
    idUser int(5) not null auto_increment,
    firstName varchar(25) not null,
    lastName varchar(25) not null,
    email varchar(25) not null,
    phone int(12) not null,
    primary key (idUser),
    foreign key (idArticle) references article(idArticle)
);

create table comment
(
    idComment int(5) not null auto_increment,
    idArticle int(5) not null,
    idUser int(5) not null,
    rate int(1) not null,
    comment varchar(255) not null,
    created date not null,
    primary key (idComment),
    foreign key (idArticle) references article(idArticle),
    foreign key (idUser) references user(idUser)
);

create table categoriesForum
(
    idCategorie int(5) not null auto_increment,
    label varchar(255) not null,
    primary key (idCategorie)
);

create table topics
(
    idTopics int(5) not null auto_increment,
    idCategorie int(5) not null,
    idUser int(5) not null,
    topics varchar(255) not null,
    primary key (idTopics),
    foreign key (idCategorie) references categoriesForum(idCategorie),
    foreign key (idUser) references user(idUser)
);

create table post
(
    idPost int(5) not null auto_increment,
    idTopics int(5) not null,
    idUser int(5) not null,
    content varchar(255) not null,
    created datetime not null,
    primary key (idPost),
    foreign key (idTopics) references topics(idTopics),
    foreign key (idUser) references user(idUser)
);

create table brands
(
    idBrand int(5) not null auto_increment,
    label varchar(255) not null,
    categories varchar(255) not null,
    content varchar(255) not null,
    primary key (idBrand)
)

create table gallery
(
    idImage int(5) not null auto_increment,
    idBrand int(5) not null,
    image varchar(255) not null,
    primary key (idImage) references brands(idBrand)
);

insert into categoriesForum values (null, "parlons parfum");
insert into categoriesForum values (null, "les marques");
insert into categoriesForum values (null, "discussion");
insert into categoriesForum values (null, "pratiques de consom'acteurs");
insert into categoriesForum values (null, "remarque");

insert into categoriesArticle values (null, "actualité");
insert into categoriesArticle values (null, "événement");
insert into categoriesArticle values (null, "pédagogie");
insert into categoriesArticle values (null, "interview");
