--Creacion de base de datos DB205DWESMtoDepartamentosTema4
create database if not exists DB205DWESMtoDepartamentosTema4;

--Creacion de la tabla Departamento en la base de datos DB205DWESMtoDepartamentosTema4
create table DB205DWESMtoDepartamentosTema4.Departamento(
    CodDepartamento varchar(3),
    DescDepartamento varchar(255) NOT NULL,
    FechaBaja date NULL,
    VolumenNegocio float NULL,
    primary key(CodDepartamento)
)ENGINE=INNODB;

--Creacion de usuario
create user 'user205DWESMtoDepartamentosTema4'@'%' identified by 'P@ssw0rd';
grant all privileges on DB205DWESMtoDepartamentosTema4.* to 'user205DWESMtoDepartamentosTema4'@'%' with grant option;
