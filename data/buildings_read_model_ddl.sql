drop table if exists buildings;
create table buildings
(
    id          uuid    not null constraint buildings_pk primary key,
    name        varchar not null,
    "checkedIn" jsonb
);

alter table buildings owner to app;

