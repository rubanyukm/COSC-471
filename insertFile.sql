insert into books values(123456789123,"book1","author1","publiser1", "adventure", 5.99);
insert into books values(123453389123,"book3","author2","publiser2", "fiction", 9.99);
insert into books values(123411789123,"book2","author1","publiser1", "horror", 10.99);
insert into books values(122256789123,"book4","author3","publiser3", "fantasy", 12.99);
insert into books values(122256775423,"book5","author3","publiser3", "fantasy", 12.99);


insert into customer values("user1","pin1","gary","smith",
                            "1234 street1 st","ypsilanti","MI", "visa", 44556677);
insert into customer values("user2","pin2","Greg","Ory",
                            "1234 street2 st","ypsilanti","MI", "visa", 44556677);

insert into reviews values(1,"book is good",123456789123);
insert into reviews values(2,"book is meh",123456789123);

insert into orders values(12, "user1", 123453389123, 3, "2023-04-14", 29.97);

insert into admin values("admin1", 12);