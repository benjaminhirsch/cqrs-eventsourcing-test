create or replace function fn_trigger_building_created() returns trigger
    security definer
    language plpgsql
as $$
begin
    perform fn_building_created(new.uuid, new.body);
    return new;
end;
$$;

create or replace function fn_trigger_building_name_changed() returns trigger
    security definer
    language plpgsql
as $$
begin
    perform fn_building_name_changed(new.uuid, new.body);
    return new;
end;
$$;

create or replace function fn_trigger_building_checkIn() returns trigger
    security definer
    language plpgsql
as $$
begin
    perform fn_building_checkIn(new.uuid, new.body);
    return new;
end;
$$;

create or replace function fn_trigger_building_checkOut() returns trigger
    security definer
    language plpgsql
as $$
begin
    perform fn_building_checkOut(new.uuid, new.body);
    return new;
end;
$$;


create or replace function fn_trigger_building_deleted() returns trigger
    security definer
    language plpgsql
as $$
begin
    perform fn_building_deleted(new.uuid);
    return new;
end;
$$;

create or replace function fn_trigger_building_deletion_denied() returns trigger
    security definer
    language plpgsql
as $$
begin
    perform fn_building_deletion_denied(new.uuid, new.body);
    return new;
end;
$$;

--- Add triggers to events table
drop trigger event_building_created on events;
create constraint trigger event_building_created  after insert on events deferrable
    for each row
    when (new.type = 'building.created')
execute procedure fn_trigger_building_created();

drop trigger event_building_name_changed on events;
create constraint trigger event_building_name_changed  after insert on events deferrable
    for each row
    when (new.type = 'building.name_changed')
execute procedure fn_trigger_building_name_changed();

drop trigger event_building_user_checked_in on events;
create constraint trigger event_building_user_checked_in  after insert on events deferrable
    for each row
    when (new.type = 'building.checkIn')
execute procedure fn_trigger_building_checkIn();

drop trigger event_building_user_checked_out on events;
create constraint trigger event_building_user_checked_out  after insert on events deferrable
    for each row
    when (new.type = 'building.checkOut')
execute procedure fn_trigger_building_checkOut();

drop trigger event_building_deleted on events;
create constraint trigger event_building_deleted  after insert on events deferrable
    for each row
    when (new.type = 'building.deleted')
execute procedure fn_trigger_building_deleted();

drop trigger event_building_deletion_denied on events;
create constraint trigger event_building_deletion_denied  after insert on events deferrable
    for each row
    when (new.type = 'building.deletionDenied')
execute procedure fn_trigger_building_deletion_denied();

-- Create related functions
create or replace function fn_building_created(buildingId uuid, body jsonb) returns uuid
    security definer
    language plpgsql as $$
declare result uuid;
begin
    insert into buildings (id, name) values (buildingId, body->>'name') returning id into result;
    return result;
end;
$$;

create or replace function fn_building_name_changed(buildingId uuid, body jsonb) returns uuid
    security definer
    language plpgsql as $$
declare result uuid;
begin
    update buildings set name = body->>'name' where id = buildingId returning id into result;
    return result;
end;
$$;

create or replace function fn_building_checkIn(buildingId uuid, body jsonb) returns uuid
    security definer
    language plpgsql as $$
declare result uuid;
begin
    update buildings set "checkedIn" =
        COALESCE("checkedIn", '[]'::JSONB) || concat('["', body->>'userName', '"]')::jsonb
        where id = buildingId returning id into result;
    return result;
end;
$$;

create or replace function fn_building_checkOut(buildingId uuid, body jsonb) returns uuid
    security definer
    language plpgsql as $$
declare result uuid;
begin
    update buildings set "checkedIn" = "checkedIn"::jsonb-concat('{', body->>'userName', '}')::text[] where id = buildingId returning id into result;
    return result;
end;
$$;

create or replace function fn_building_deleted(buildingId uuid) returns void
    security definer
    language plpgsql as $$
begin
    delete from buildings where id = buildingId;
end;
$$;

create or replace function fn_building_deletion_denied(buildingId uuid, body jsonb) returns uuid
    security definer
    language plpgsql as $$
declare result uuid;
begin
    insert into buildings (id, name, "checkedIn") values (buildingId, body->>'name', (body->>'checkedIn')::jsonb) returning id into result;
    return result;
end;
$$;