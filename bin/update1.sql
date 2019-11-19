update ad_types set type_accession_count=0;

-- remove PTI, PP, OOT affiliation
-- delete from honoree_guest_assoc where honoree_id IN (1, 5, 31);

update guests
  set pledge_2018=paid,
  paid=0,
  ad_sum=0,
  paid_seats=0,
  comp_seats=0,
  ads_previous=null
;

delete from ads;

-- add PP affiliation
insert into honoree_guest_assoc (honoree_id, guest_id)
    select 5, id from guests where pledge_2016 + pledge_2017 + pledge_2018 > 0
    ON DUPLICATE KEY UPDATE honoree_id = 5;
