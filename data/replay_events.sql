-- Doing this on DB level, has the nice benefit,
-- that you don't have to take care of, that business logic is applied during the replay
truncate buildings;
do language plpgsql $$
    declare
        e record;
    begin
        for e in select type, uuid, body from events order by id loop
                case e.type
                    when 'building.created' then
                        perform fn_building_created(e.uuid, e.body);
                    when 'building.name_changed' then
                        perform fn_building_name_changed(e.uuid,e.body);
                    when 'building.checkIn' then
                        perform fn_building_checkin(e.uuid,e.body);
                    when 'building.checkOut' then
                        perform fn_building_checkout(e.uuid,e.body);
                    when 'building.deleted' then
                        perform fn_building_deleted(e.uuid);
                    when 'building.deletionDenied' then
                        perform fn_building_deletion_denied(e.uuid,e.body);
                    else end case;
            end loop;
    end;
$$;