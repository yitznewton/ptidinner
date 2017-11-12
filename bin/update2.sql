-- remove PTI, PP, OOT
delete from honorees where id NOT IN (1, 5, 28);

insert into honorees (name, code) values
    ('Hamburger', 'HAM'),
    ('Kloor', 'KLR'),
    ('Novichenok', 'NOV')
;
