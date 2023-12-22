--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.24
-- Dumped by pg_dump version 14.7 (Ubuntu 14.7-0ubuntu0.22.04.1)

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

SET default_tablespace = '';

--
-- Name: cliente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cliente (
    nit character varying(25),
    razon_social character varying,
    fec_cre_cliente timestamp without time zone,
    fec_act_cliente timestamp without time zone
);


ALTER TABLE public.cliente OWNER TO postgres;

--
-- Name: credenciales; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.credenciales (
    id_credencial integer NOT NULL,
    usuario character varying(100) NOT NULL,
    contrasenia character varying NOT NULL,
    id_func integer,
    fecha_creacion_credencial timestamp without time zone,
    fecha_actualizacion_credencial timestamp without time zone
);


ALTER TABLE public.credenciales OWNER TO postgres;

--
-- Name: credenciales_id_credencial_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.credenciales_id_credencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.credenciales_id_credencial_seq OWNER TO postgres;

--
-- Name: credenciales_id_credencial_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.credenciales_id_credencial_seq OWNED BY public.credenciales.id_credencial;


--
-- Name: detalle_venta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_venta (
    id_vent integer,
    id_cod_prod character varying(10),
    detalle character varying,
    cantidad integer,
    precio numeric(7,2),
    CONSTRAINT detalle_venta_cantidad_check CHECK ((cantidad > 0))
);


ALTER TABLE public.detalle_venta OWNER TO postgres;

--
-- Name: funcionario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.funcionario (
    id_funcionario integer NOT NULL,
    codigo_funcionario character varying(15),
    cargo character varying DEFAULT 'cajero'::character varying,
    email character varying(70),
    id_pers integer,
    fec_cre_funcionario timestamp without time zone,
    fec_act_funcionario timestamp without time zone
);


ALTER TABLE public.funcionario OWNER TO postgres;

--
-- Name: venta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.venta (
    id_venta integer NOT NULL,
    id_func integer,
    nit_cli character varying(25),
    total numeric(7,2),
    fecha_venta timestamp without time zone
);


ALTER TABLE public.venta OWNER TO postgres;

--
-- Name: detalleventasfuncionario; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.detalleventasfuncionario AS
 SELECT funcionario.id_funcionario,
    venta.id_venta,
    venta.fecha_venta,
    detalle_venta.id_vent,
    detalle_venta.id_cod_prod,
    detalle_venta.detalle,
    detalle_venta.cantidad,
    detalle_venta.precio
   FROM public.funcionario,
    public.venta,
    public.detalle_venta
  WHERE ((funcionario.id_funcionario = venta.id_func) AND (venta.id_venta = detalle_venta.id_vent));


ALTER TABLE public.detalleventasfuncionario OWNER TO postgres;

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: funcionario_id_funcionario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.funcionario_id_funcionario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.funcionario_id_funcionario_seq OWNER TO postgres;

--
-- Name: funcionario_id_funcionario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.funcionario_id_funcionario_seq OWNED BY public.funcionario.id_funcionario;


--
-- Name: log_accesos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_accesos (
    id_cred integer,
    fec_hora_acceso timestamp without time zone,
    direccion_ip inet
);


ALTER TABLE public.log_accesos OWNER TO postgres;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- Name: persona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.persona (
    id_persona integer NOT NULL,
    nombre character varying(200),
    ap_pat character varying(200),
    ap_mat character varying(200),
    ci character varying(15),
    fec_nac date,
    tel_cel character varying(12),
    domicilio text
);


ALTER TABLE public.persona OWNER TO postgres;

--
-- Name: persona_id_persona_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.persona_id_persona_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persona_id_persona_seq OWNER TO postgres;

--
-- Name: persona_id_persona_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.persona_id_persona_seq OWNED BY public.persona.id_persona;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.producto (
    id_codigo_producto character varying(10) NOT NULL,
    descripcion character varying NOT NULL,
    precio numeric(7,2) NOT NULL,
    fecha_creacion_plato timestamp without time zone,
    fecha_actualizacion_plato timestamp without time zone
);


ALTER TABLE public.producto OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: venta_id_venta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.venta_id_venta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.venta_id_venta_seq OWNER TO postgres;

--
-- Name: venta_id_venta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.venta_id_venta_seq OWNED BY public.venta.id_venta;


--
-- Name: credenciales id_credencial; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.credenciales ALTER COLUMN id_credencial SET DEFAULT nextval('public.credenciales_id_credencial_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: funcionario id_funcionario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario ALTER COLUMN id_funcionario SET DEFAULT nextval('public.funcionario_id_funcionario_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: persona id_persona; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona ALTER COLUMN id_persona SET DEFAULT nextval('public.persona_id_persona_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: venta id_venta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.venta ALTER COLUMN id_venta SET DEFAULT nextval('public.venta_id_venta_seq'::regclass);


--
-- Data for Name: cliente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cliente (nit, razon_social, fec_cre_cliente, fec_act_cliente) FROM stdin;
8362555	Castro	2023-02-28 23:24:10	2023-02-28 23:24:10
151522521	Rendon	2023-02-28 23:37:29	2023-02-28 23:37:29
83524521	Camacho	2023-02-28 23:39:36	2023-02-28 23:39:36
8362926015	Nicolas	2023-03-01 00:01:07	2023-03-01 00:01:07
4343585	Pajarito	2023-03-01 00:02:53	2023-03-01 00:02:53
868362926015	Peritonitis	2023-03-01 00:49:43	2023-03-01 00:49:43
15151515	Ron damon	2023-03-01 00:53:54	2023-03-01 00:53:54
853252012	Barriga	2023-03-01 00:57:03	2023-03-01 00:57:03
15152330201	pericales	2023-03-01 01:11:25	2023-03-01 01:11:25
8362926016	Bolanios	2023-03-01 01:30:30	2023-03-01 01:30:30
4956158	Mejia	2023-03-01 01:55:19	2023-03-01 01:55:19
2352215	Godinez	2023-03-01 02:37:50	2023-03-01 02:37:50
132508591	Cooperativa solucredit	2023-03-01 02:56:39	2023-03-01 02:56:39
151515248	GOnzales	2023-03-01 12:39:33	2023-03-01 12:39:33
8362926	Mejia	2023-03-02 21:49:27	2023-03-02 21:49:27
836292611	Mejia	2023-03-02 21:53:55	2023-03-02 21:53:55
151581422	Barriga	2023-03-02 21:54:53	2023-03-02 21:54:53
8356302	MOnila	2023-03-04 20:58:49	2023-03-04 20:58:49
8362926123456	Mejia	2023-03-06 09:52:18	2023-03-06 09:52:18
123456789	Mejia	2023-03-06 10:52:09	2023-03-07 16:26:59
123456	Salamanca	2023-03-07 16:42:22	2023-03-07 16:42:22
033333	Mejía	2023-03-07 17:02:46	2023-03-07 17:02:46
0	Sin Nombre	2023-02-28 23:15:25	2023-03-08 18:43:44
7362926	Mejia	2023-03-09 15:52:05	2023-03-09 15:52:05
\.


--
-- Data for Name: credenciales; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.credenciales (id_credencial, usuario, contrasenia, id_func, fecha_creacion_credencial, fecha_actualizacion_credencial) FROM stdin;
2	8362927	$2y$10$0gId58vQecN5eGMB0LB3su61FTgLO0Req7yjjtILOu7OJbqNzpFP.	2	2023-02-28 23:21:00	2023-02-28 23:21:00
3	8362928	$2y$10$0Qy2hduyfeDY9QLROLuWLufVZINEor6BgMoasca4i.XZYB66tqQ.6	3	2023-03-01 12:27:55	2023-03-01 12:27:55
4	8362925	$2y$10$lOh.7R29L00xbJyr7VVccestE2/zYdw00oxjuDXQaugsOVxe62Vaq	4	2023-03-02 22:11:54	2023-03-02 22:11:54
5	55555	$2y$10$vwM9bg7Z/hAjAYKCCMwDeO4EvZI3/ZANj.UwzT54F326kVafRCXPm	5	2023-03-01 19:40:19	2023-03-01 19:40:19
6	88888888	$2y$10$W8iSkw8ovVFZyhmhWcfoEOPIjEv/mFUZsSJj8EkzM7bongrQvGBSO	6	2023-03-07 13:23:56	2023-03-07 13:23:56
7	4428	$2y$10$G/Y1pfbRDVtfA4NT48wbL.afFPrnf9JV77BUVGU7rTwJG5/tmeeLa	7	2023-03-07 16:49:50	2023-03-07 16:49:50
8	485122548	$2y$10$0p9YLJtnlRMyfd5zn3a7me/RiHSp4bYYqK0xT3C7gg/nl6pFBNPKW	8	2023-03-09 14:54:08	2023-03-09 14:54:08
1	8362926	$2y$10$V/3JZvzkbY9bxvrpD2lx8O94AfmwWWEAghdJqEk0tAIb4mv3LZYze	1	2023-02-28 02:59:11	2023-03-10 15:09:27
9	5190078	$2y$10$PBJcajq8FNnx2Lxu5Cw9g.NbjTrU0QiKAL7A4DYnhgMPbuSlU9F/q	9	2023-03-10 15:15:16	2023-03-10 15:15:16
10	6030552	$2y$10$ZgR0F6zK5PMrQrr/clCzouGcP4iPx4xPfDuaeQF/vNkWmI.4SwoQq	10	2023-03-10 15:17:34	2023-03-10 15:17:34
\.


--
-- Data for Name: detalle_venta; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detalle_venta (id_vent, id_cod_prod, detalle, cantidad, precio) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: funcionario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.funcionario (id_funcionario, codigo_funcionario, cargo, email, id_pers, fec_cre_funcionario, fec_act_funcionario) FROM stdin;
1	HMM926	CAJERO	HMEJIA@GMAIL.COM	1	2023-02-28 02:59:11	2023-02-28 02:59:11
2	JSA927	CAJERO	JSALAMCA@GMAIL.COM	2	2023-02-28 23:21:00	2023-02-28 23:21:00
3	JSA928	ADMINISTRADOR	JSALAMCA@GMAIL.COM	3	2023-03-01 12:27:55	2023-03-01 12:27:55
4	MCO925	CAJERO	G.APAZA007@GMAIL.COM	4	2023-03-02 22:11:54	2023-03-02 22:11:54
5	GAA555	ADMINISTRADOR	G.APAZA007@GMAIL.COM	5	2023-03-01 19:40:19	2023-03-01 19:40:19
6	PCM888	CAJERO	PVIANCHI@CAMACO.COM	6	2023-03-07 13:23:56	2023-03-07 13:23:56
7	JMP428	CAJERO	JSALAMCA@GMAIL.COM	7	2023-03-07 16:49:50	2023-03-07 16:49:50
8	NMP548	CAJERO	NMALDINI@GMAIL.COM	8	2023-03-09 14:54:08	2023-03-09 14:54:08
9	NMT078	ADMINISTRADOR		9	2023-03-10 15:15:16	2023-03-10 15:15:16
10	LMC552	CAJERO		10	2023-03-10 15:17:34	2023-03-10 15:17:34
\.


--
-- Data for Name: log_accesos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.log_accesos (id_cred, fec_hora_acceso, direccion_ip) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
3	2019_08_19_000000_create_failed_jobs_table	1
4	2019_12_14_000001_create_personal_access_tokens_table	1
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.persona (id_persona, nombre, ap_pat, ap_mat, ci, fec_nac, tel_cel, domicilio) FROM stdin;
2	JUAN BRIAN	SALAMANCA	ALVARES	8362927	1987-11-27	75691319	EMILIO AGUIRRE #1043
3	JUAN	SALAMANCA	ALVAREZ	8362928	1879-11-27	75691319	CALLE TTE. ROSENDO VILLA # 1043
4	MIGUEL	CRIALES	OLIVARES	8362925	1989-05-17	77755522	VILLA PABON CALLE TTE. ROSENDO VILLA #1515
5	GEORGE	APAZA	APAZA	55555	1758-03-09	74685222	EL ALTO #3030
6	PABLO VIANCHO	CATARI	MALLEA	88888888	2020-10-10	74512125	ZONA EL TEJAR, VILLA SALOME #445
1	HELIO	MEJIA	MICHEL	8362926	1989-02-24	77633453	ZONA PERIFERICA PERES VELASCO #2424
7	JUAN GRANIER	MONASTERIOS	PALAVICINI	4427	1758-12-24	7251345	VILLA FATIMA #5
8	NICOALAS HELIO	MALDINI	PAZA	485122548	1800-03-09	75691319	PERU, ENTRE CALLES DE LAS LOMAS Y BRUJAS NO. 3030
9	NICOLAS	MAMANI	TICONA	5190078	1976-11-13	73060108	CALLE COLON NO. 595
10	LEONARDO	MAMANI	CALLE	6030552	2007-06-17	6030552	
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.producto (id_codigo_producto, descripcion, precio, fecha_creacion_plato, fecha_actualizacion_plato) FROM stdin;
1	ARROZ CON CHICHARRON DE POLLO	20.00	\N	\N
2	ARROZ CON PESCADO FRITO	20.00	\N	\N
3	ARROZ CON CARNE Y VERDURA	20.00	\N	\N
4	ARROZ CON CARNE Y PIMENTON	20.00	\N	\N
5	ARROZ CON CARNE Y CEBOLLA	20.00	\N	\N
6	ARROZ CON CERDO Y PIMENTON	20.00	\N	\N
7	ARROZ CON CERDO Y VERDURA	20.00	\N	\N
8	ARROZ CON CERDO Y CEBOLLA	20.00	\N	\N
9	ARROZ CON POLLO PICADO Y VERDURA	20.00	\N	\N
10	ARROZ CON POLLO Y PIMENTON	20.00	\N	\N
12	ARROZ CON POLLO AGRIDULCE	20.00	\N	\N
13	ARROZ CON CERDO AGRIDULCE	22.00	\N	\N
14	ARROZ CON PEZCADO AGRIDULCE	20.00	\N	\N
15	ARROZ CON CHULETA DE CERDO	22.00	\N	\N
16	ARROZ CON ASADO Y HUEVO	20.00	\N	\N
17	ARROZ CON HUEVO FRITO	15.00	\N	\N
18	ARROZ CHAUFA	15.00	\N	\N
19	ARROZ BLANCI	15.00	\N	\N
51	TALLARIN CON CHICHARRON DE POLLO	20.00	\N	\N
52	TALLARIN CON PESCADO FRITO	20.00	\N	\N
53	TALLARIN CON CARNE Y VERDURAS	20.00	\N	\N
54	TALLARIN CON CARNE Y PIMENTON	20.00	\N	\N
55	TALLARIN CON CARNE Y CEBOLLA	20.00	\N	\N
56	TALLARIN CON CERDO Y PIMENTON	20.00	\N	\N
57	TALLARIN CON CERDO Y VERDURAS	20.00	\N	\N
58	TALLARIN CON CERDO Y CEBOLLA	20.00	\N	\N
59	TALLARIN CON POLLO PICADO Y VERDURA	20.00	\N	\N
60	TALLARIN CON POLLO PICADO Y PIMENTON	20.00	\N	\N
62	TALLARIN CON POLLO AGRIDULCE	20.00	\N	\N
63	TALLARIN CON CERDO AGRIDULCE	22.00	\N	\N
64	TALLARIN CON PESCADO AGRIDULCE	20.00	\N	\N
65	TALLARIN CON CHULETA DE CERDO	22.00	\N	\N
66	TALLARIN CON ASADO Y HUEVO	20.00	\N	\N
67	TALLARIN CON HUEVO FRITO	15.00	\N	\N
68	TALLARIN CON VERDURA	12.00	\N	\N
101	MIXTO CON CHICHARRON DE POLLO	20.00	\N	\N
102	MIXTO CON PESCADO FRITO	20.00	\N	\N
103	MIXTO CON CARNE Y VERDURAS	20.00	\N	\N
104	MIXTO CON CARNE Y PIMENTON	20.00	\N	\N
105	MIXTO CON CARNE Y CEBOLLA	20.00	\N	\N
106	MIXTO CON CERDO Y PIMENTON	20.00	\N	\N
107	MIXTO CON CERDO Y VERDURAS	20.00	\N	\N
108	MIXTO CON CERDO Y CEBOLLA	20.00	\N	\N
109	MIXTO CON POLLO PICADO Y VERDURA	20.00	\N	\N
110	MIXTO CON POLLO PICADO Y PIMENTON	20.00	\N	\N
112	MIXTO CON POLLO AGRIDULCE	20.00	\N	\N
113	MIXTO CON CERDO AGRIDULCE	22.00	\N	\N
114	MIXTO CON PESCADO AGRIDULCE	20.00	\N	\N
115	MIXTO CON CHULETA DE CERDO	22.00	\N	\N
116	MIXTO CON ASADO Y HUEVO	20.00	\N	\N
117	MIXTO CON HUEVO FRITO	15.00	\N	\N
01	CHICHARRON DE POLLO COM PAPA	20.00	\N	\N
02	PESCADO FRITO CON PAPA	20.00	\N	\N
012	POLLO AGRIDUCE CON PAPA	20.00	\N	\N
013	CERDO AGRIDULCE CON PAPA	22.00	\N	\N
014	PESCADO AGRIDULCE CON PAPA	20.00	\N	\N
015	CHULETA DE CERDO CON PAPA	22.00	\N	\N
016	ASADO Y HUEVO CON PAPA	20.00	\N	\N
017	HUEVO CON PAPA	15.00	\N	\N
1P	ARROZ CON PAPA Y CHICHARRON DE POLLO	20.00	\N	\N
2P	ARROZ CON PAPA Y PESCADO FRITO	20.00	\N	\N
12P	ARROZ CON PAPA Y POLLO AGRIDULCE	20.00	\N	\N
13P	ARROZ CON PAPA Y CERDO AGRIDULCE	22.00	\N	\N
14P	ARROZ CON PAPA Y PESCADO AGRIDULCE	20.00	\N	\N
15P	ARROZ CON PAPA Y CHULETA DE CERDO	22.00	\N	\N
16P	ARROZ CON PAPA, ASADO Y HUEVO	20.00	\N	\N
17P	ARROZ CON PAPA Y HUEVO	15.00	\N	\N
51P	TALLARIN CON PAPA Y CHICHARRON DE POLLO	20.00	\N	\N
52P	TALLARIN CON PAPA Y PESCADO FRITO	20.00	\N	\N
62P	TALLARIN CON PAPA Y POLLO AGRIDULCE	20.00	\N	\N
63P	TALLARIN CON PAPA Y CERDO AGRIDULCE	22.00	\N	\N
64P	TALLARIN CON PAPA Y PESCADO AGRIDULCE	20.00	\N	\N
65P	TALLARIN CON PAPA Y CHULETA DE CERDO	22.00	\N	\N
66P	TALLARIN CON PAPA, ASADO Y HUEVO	20.00	\N	\N
67P	TALLARIN CON PAPA Y HUEVO	15.00	\N	\N
R2	1 LITRO	12.00	\N	\N
R3	3/4 POPULAR	8.00	\N	\N
R4	MINI	3.00	\N	\N
R6	JARRA LIMON	10.00	\N	\N
R7	1/2 JARRA LIMON	6.00	\N	\N
R8	VASO LIMON	3.00	\N	\N
M6	JARRA MOCOCHINCHI	10.00	\N	\N
M7	1/2 JARRA MOCOCHINCHI	6.00	\N	\N
M8	VASO COMOCHINCHI	3.00	\N	\N
H1	HAMBURGUESAS DE LENTEJA	20.00	2023-03-01 19:32:36	2023-03-01 19:32:36
R1	2 LITROS	30.00	\N	2023-03-07 16:58:20
R202	JUGO DE ARANDANO CON LECHE	8.00	2023-03-01 19:39:23	2023-03-09 15:12:24
R203	POLLO CON PLATANO FRITO	25.00	2023-03-09 15:59:47	2023-03-09 15:59:47
R205	PASPAS A LA HUANCANINA	30.00	2023-03-10 16:48:25	2023-03-10 16:58:06
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: venta; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.venta (id_venta, id_func, nit_cli, total, fecha_venta) FROM stdin;
\.


--
-- Name: credenciales_id_credencial_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.credenciales_id_credencial_seq', 10, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: funcionario_id_funcionario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.funcionario_id_funcionario_seq', 10, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 4, true);


--
-- Name: persona_id_persona_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.persona_id_persona_seq', 10, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: venta_id_venta_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.venta_id_venta_seq', 62, true);


--
-- Name: credenciales credenciales_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.credenciales
    ADD CONSTRAINT credenciales_pkey PRIMARY KEY (id_credencial);


--
-- Name: credenciales credenciales_usuario_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.credenciales
    ADD CONSTRAINT credenciales_usuario_key UNIQUE (usuario);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: funcionario funcionario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT funcionario_pkey PRIMARY KEY (id_funcionario);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_resets password_resets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_resets
    ADD CONSTRAINT password_resets_pkey PRIMARY KEY (email);


--
-- Name: persona persona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_pkey PRIMARY KEY (id_persona);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: producto producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_pkey PRIMARY KEY (id_codigo_producto);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: venta venta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.venta
    ADD CONSTRAINT venta_pkey PRIMARY KEY (id_venta);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: credenciales credenciales_id_func_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.credenciales
    ADD CONSTRAINT credenciales_id_func_fkey FOREIGN KEY (id_func) REFERENCES public.funcionario(id_funcionario);


--
-- Name: detalle_venta detalle_venta_id_cod_prod_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_venta
    ADD CONSTRAINT detalle_venta_id_cod_prod_fkey FOREIGN KEY (id_cod_prod) REFERENCES public.producto(id_codigo_producto);


--
-- Name: detalle_venta detalle_venta_id_vent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_venta
    ADD CONSTRAINT detalle_venta_id_vent_fkey FOREIGN KEY (id_vent) REFERENCES public.venta(id_venta);


--
-- Name: funcionario funcionario_id_pers_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT funcionario_id_pers_fkey FOREIGN KEY (id_pers) REFERENCES public.persona(id_persona);


--
-- Name: log_accesos log_accesos_id_cred_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_accesos
    ADD CONSTRAINT log_accesos_id_cred_fkey FOREIGN KEY (id_cred) REFERENCES public.credenciales(id_credencial);


--
-- Name: venta venta_id_func_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.venta
    ADD CONSTRAINT venta_id_func_fkey FOREIGN KEY (id_func) REFERENCES public.funcionario(id_funcionario);


--
-- PostgreSQL database dump complete
--

