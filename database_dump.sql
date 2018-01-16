--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: clean_param_values(); Type: FUNCTION; Schema: public; Owner: danyamas_chat31
--

CREATE FUNCTION clean_param_values() RETURNS trigger
    LANGUAGE plpgsql
    AS $$BEGIN
IF TG_OP = 'DELETE' THEN
     DELETE FROM param_value WHERE realty_id = OLD.id;
     RETURN OLD;
 END IF;
END;$$;


ALTER FUNCTION public.clean_param_values() OWNER TO danyamas_chat31;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: type; Type: TABLE; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

CREATE TABLE type (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    counter integer DEFAULT 0 NOT NULL
);


ALTER TABLE type OWNER TO danyamas_chat31;

--
-- Name: type_id_seq; Type: SEQUENCE; Schema: public; Owner: danyamas_chat31
--

CREATE SEQUENCE type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE type_id_seq OWNER TO danyamas_chat31;

--
-- Name: type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: danyamas_chat31
--

ALTER SEQUENCE type_id_seq OWNED BY type.id;


--
-- Name: param; Type: TABLE; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

CREATE TABLE param (
    id integer DEFAULT nextval('type_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE param OWNER TO danyamas_chat31;

--
-- Name: param_value; Type: TABLE; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

CREATE TABLE param_value (
    id integer NOT NULL,
    realty_id integer,
    param_id integer,
    value character varying(255)
);


ALTER TABLE param_value OWNER TO danyamas_chat31;

--
-- Name: param_value_id_seq; Type: SEQUENCE; Schema: public; Owner: danyamas_chat31
--

CREATE SEQUENCE param_value_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE param_value_id_seq OWNER TO danyamas_chat31;

--
-- Name: param_value_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: danyamas_chat31
--

ALTER SEQUENCE param_value_id_seq OWNED BY param_value.id;


--
-- Name: realty; Type: TABLE; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

CREATE TABLE realty (
    id integer NOT NULL,
    address character varying(255) NOT NULL,
    type integer NOT NULL,
    price integer,
    date_created timestamp without time zone DEFAULT now()
);


ALTER TABLE realty OWNER TO danyamas_chat31;

--
-- Name: TABLE realty; Type: COMMENT; Schema: public; Owner: danyamas_chat31
--

COMMENT ON TABLE realty IS 'Объекты недвижимости';


--
-- Name: COLUMN realty.id; Type: COMMENT; Schema: public; Owner: danyamas_chat31
--

COMMENT ON COLUMN realty.id IS 'Идентификатор записи';


--
-- Name: COLUMN realty.address; Type: COMMENT; Schema: public; Owner: danyamas_chat31
--

COMMENT ON COLUMN realty.address IS 'Адрес объекта';


--
-- Name: COLUMN realty.type; Type: COMMENT; Schema: public; Owner: danyamas_chat31
--

COMMENT ON COLUMN realty.type IS 'Тип объекта';


--
-- Name: COLUMN realty.price; Type: COMMENT; Schema: public; Owner: danyamas_chat31
--

COMMENT ON COLUMN realty.price IS 'Стоимость';


--
-- Name: COLUMN realty.date_created; Type: COMMENT; Schema: public; Owner: danyamas_chat31
--

COMMENT ON COLUMN realty.date_created IS 'Дата и время создания записи';


--
-- Name: realty_id_seq; Type: SEQUENCE; Schema: public; Owner: danyamas_chat31
--

CREATE SEQUENCE realty_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE realty_id_seq OWNER TO danyamas_chat31;

--
-- Name: realty_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: danyamas_chat31
--

ALTER SEQUENCE realty_id_seq OWNED BY realty.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: danyamas_chat31
--

ALTER TABLE ONLY param_value ALTER COLUMN id SET DEFAULT nextval('param_value_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: danyamas_chat31
--

ALTER TABLE ONLY realty ALTER COLUMN id SET DEFAULT nextval('realty_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: danyamas_chat31
--

ALTER TABLE ONLY type ALTER COLUMN id SET DEFAULT nextval('type_id_seq'::regclass);


--
-- Name: param_name_key; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY param
    ADD CONSTRAINT param_name_key UNIQUE (name);


--
-- Name: param_pkey; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY param
    ADD CONSTRAINT param_pkey PRIMARY KEY (id);


--
-- Name: param_value_pkey; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY param_value
    ADD CONSTRAINT param_value_pkey PRIMARY KEY (id);


--
-- Name: realty_address_key; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY realty
    ADD CONSTRAINT realty_address_key UNIQUE (address);


--
-- Name: realty_pkey; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY realty
    ADD CONSTRAINT realty_pkey PRIMARY KEY (id);


--
-- Name: type_name_key; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY type
    ADD CONSTRAINT type_name_key UNIQUE (name);


--
-- Name: type_pkey; Type: CONSTRAINT; Schema: public; Owner: danyamas_chat31; Tablespace: 
--

ALTER TABLE ONLY type
    ADD CONSTRAINT type_pkey PRIMARY KEY (id);


--
-- Name: ad_realty; Type: TRIGGER; Schema: public; Owner: danyamas_chat31
--

CREATE TRIGGER ad_realty AFTER DELETE ON realty FOR EACH ROW EXECUTE PROCEDURE clean_param_values();


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--
