-- remove PTI, PP, OOT
delete from honorees where id NOT IN (1, 5, 31);

insert into honorees (name, code) values
    ('Bodenheim', 'BOD'),
    ('Bernstein', 'BER'),
    ('Rozanski', 'ROZ'),
    ('Stein', 'STE')
;
