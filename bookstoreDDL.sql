drop table books;
drop table reviews;
drop table orders;
drop table customer;

create table books(
    ISBN        numeric(13,0),
    title       text,
    Author      text,
    publisher   text,

)