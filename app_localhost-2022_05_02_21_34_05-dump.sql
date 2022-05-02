--
-- PostgreSQL database dump
--

-- Dumped from database version 14.1
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: fn_project_account_create(uuid, jsonb); Type: FUNCTION; Schema: public; Owner: app
--

CREATE FUNCTION public.fn_project_account_create(uuid uuid, body jsonb) RETURNS integer
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
declare result int;
begin
    insert into accounts("accountNumber", "accountHolderName", "createdAt")
    values(body->>'accountNumber', body->>'accountHolderName', NOW())
    returning "accountNumber" into result;
    return result;
end;
$$;


ALTER FUNCTION public.fn_project_account_create(uuid uuid, body jsonb) OWNER TO app;

--
-- Name: fn_trigger_account_create(); Type: FUNCTION; Schema: public; Owner: app
--

CREATE FUNCTION public.fn_trigger_account_create() RETURNS trigger
    LANGUAGE plpgsql SECURITY DEFINER
    AS $$
begin
    perform fn_project_account_create(new.uuid, new.body);
    return new;
end;
$$;


ALTER FUNCTION public.fn_trigger_account_create() OWNER TO app;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: accounts; Type: TABLE; Schema: public; Owner: app
--

CREATE TABLE public.accounts (
    "accountNumber" character varying NOT NULL,
    "accountHolderName" character varying NOT NULL,
    "createdAt" timestamp without time zone
);


ALTER TABLE public.accounts OWNER TO app;

--
-- Name: events; Type: TABLE; Schema: public; Owner: app
--

CREATE TABLE public.events (
    id integer NOT NULL,
    uuid uuid NOT NULL,
    type text NOT NULL,
    body jsonb NOT NULL,
    inserted_at timestamp(6) without time zone DEFAULT statement_timestamp() NOT NULL
);


ALTER TABLE public.events OWNER TO app;

--
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: app
--

CREATE SEQUENCE public.events_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.events_id_seq OWNER TO app;

--
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: app
--

ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


--
-- Name: events id; Type: DEFAULT; Schema: public; Owner: app
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


--
-- Data for Name: accounts; Type: TABLE DATA; Schema: public; Owner: app
--

COPY public.accounts ("accountNumber", "accountHolderName", "createdAt") FROM stdin;
356836	Benjamin	2022-05-02 19:29:27.587963
687250	Max	2022-05-02 19:29:27.587963
\.


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: app
--

COPY public.events (id, uuid, type, body, inserted_at) FROM stdin;
12	25cd9958-0211-411a-a0e3-ef5b02fba917	account_created	{"accountNumber": 356836, "accountHolderName": "Benjamin"}	2022-05-02 19:26:32.078234
13	0a5b66e0-c592-4ad1-8d5d-962570d11420	account_created	{"accountNumber": 687250, "accountHolderName": "Max"}	2022-05-02 19:26:42.144607
\.


--
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app
--

SELECT pg_catalog.setval('public.events_id_seq', 13, true);


--
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: app
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- Name: accounts table_name_pk; Type: CONSTRAINT; Schema: public; Owner: app
--

ALTER TABLE ONLY public.accounts
    ADD CONSTRAINT table_name_pk PRIMARY KEY ("accountNumber");


--
-- Name: table_name_accountnumber_uindex; Type: INDEX; Schema: public; Owner: app
--

CREATE UNIQUE INDEX table_name_accountnumber_uindex ON public.accounts USING btree ("accountNumber");


--
-- Name: events event_insert_account_create; Type: TRIGGER; Schema: public; Owner: app
--

CREATE TRIGGER event_insert_account_create AFTER INSERT ON public.events FOR EACH ROW WHEN ((new.type = 'account_created'::text)) EXECUTE FUNCTION public.fn_trigger_account_create();


--
-- PostgreSQL database dump complete
--

