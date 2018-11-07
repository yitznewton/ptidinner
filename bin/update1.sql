update ad_types set type_accession_count=0;

alter table guests
  add column pledge_2017 float(8,2) not null default 0,
  drop column pledge_2014
;

-- remove PTI, PP, OOT affiliation
-- delete from honoree_guest_assoc where honoree_id IN (1, 5, 31);

update guests
  set pledge_2017=paid,
  pledge_current=0,
  paid=0,
  ad_sum=0,
  paid_seats=0,
  comp_seats=0,
  ads_previous=null
;

-- add PP affiliation
insert into honoree_guest_assoc (honoree_id, guest_id)
    select 5, id from guests where pledge_2015 + pledge_2016 + pledge_2017 > 0
    ON DUPLICATE KEY UPDATE honoree_id = 5;
