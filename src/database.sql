drop database if exists pure;
create database pure;
use pure;

create table administrator
(
    idAdmin int(5) not null auto_increment,
    firstName varchar(25) not null,
    lastName varchar(25) not null,
    sexe varchar(25) not null,
    email varchar(25) not null,
    password varchar(255) not null,
    avatar varchar(25) null,
    primary key (idAdmin)
);

create table user
(
    idUser int(5) not null auto_increment,
    firstName varchar(25) not null,
    lastName varchar(25) not null,
    sexe varchar(25) not null,
    email varchar(25) not null,
    password varchar(255) not null,
    avatar varchar(25) null,
    primary key (idUser)
);

create table categoriesArticle
(
    idCategorie int(5) not null auto_increment,
    label varchar(25) not null,
    primary key (idCategorie)
);

create table article
(
    idArticle int(5) not null auto_increment,
    idCategorie int(5) not null,
    idAdmin int(5) not null,
    title varchar(25) not null,
    content varchar(25) not null,
    thumbnail varchar(25) not null,
    created date not null,
    primary key (idArticle),
    foreign key (idAdmin) references administrator(idAdmin),
    foreign key (idCategorie) references categoriesArticle(idCategorie)
);

create table comment
(
    idComment int(5) not null auto_increment,
    idArticle int(5) not null,
    idUser int(5) not null,
    rate int(1) not null,
    comment varchar(25) not null,
    created date not null,
    primary key (idComment),
    foreign key (idArticle) references article(idArticle),
    foreign key (idUser) references user(idUser)
);

create table categoriesForum
(
    idCategorie int(5) not null auto_increment,
    label varchar(25) not null,
    primary key (idCategorie)
);

create table topics
(
    idTopics int(5) not null auto_increment,
    idCategorie int(5) not null,
    idUser int(5) not null,
    topics varchar(25) not null,
    primary key (idTopics),
    foreign key (idCategorie) references categoriesForum(idCategorie),
    foreign key (idUser) references user(idUser)
);

create table post
(
    idPost int(5) not null auto_increment,
    idTopics int(5) not null,
    idUser int(5) not null,
    content varchar(25) not null,
    created date not null,
    primary key (idPost),
    foreign key (idTopics) references topics(idTopics),
    foreign key (idUser) references user(idUser)
);