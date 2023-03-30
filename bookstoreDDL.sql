drop table books;
drop table reviews;
drop table orders;
drop table customer;

create table books(
    ISBN        numeric(13,0),
    title       text,
    Author      text,
    publisher   text,
    
    primary key (ISBN)
)

create table customer(
    username    text,
    pin         text,
    fname       text,
    lname       text,
    custaddress text,
    city        text,
    custState   char(2),
    cardType    text,
    cardNo      int,

    primary key(username)

)

create table reviews(
    reviewID    int,
    reviewText  text,
    ISBN        numeric(13,0),

    primary key(reviewID),
    foreign key( ISBN) references books(ISBN)

)

create table orders(
    orderID     int,
    customerUsername    text,
    ISBN    numeric(13,0),
    quantity    int,

    primary key(orderID,ISBN),
    foreign key(ISBN) references books(ISBN),
    foreign key(customerUsername) references customer(username)

)

