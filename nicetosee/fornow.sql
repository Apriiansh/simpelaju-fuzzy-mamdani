-- Adminer 5.4.1 PostgreSQL 14.5 dump

DROP TABLE IF EXISTS "cache";
CREATE TABLE "public"."cache" (
    "key" character varying(255) NOT NULL,
    "value" text NOT NULL,
    "expiration" integer NOT NULL,
    CONSTRAINT "cache_pkey" PRIMARY KEY ("key")
)
WITH (oids = false);

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


DROP TABLE IF EXISTS "cache_locks";
CREATE TABLE "public"."cache_locks" (
    "key" character varying(255) NOT NULL,
    "owner" character varying(255) NOT NULL,
    "expiration" integer NOT NULL,
    CONSTRAINT "cache_locks_pkey" PRIMARY KEY ("key")
)
WITH (oids = false);

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


DROP TABLE IF EXISTS "failed_jobs";
DROP SEQUENCE IF EXISTS failed_jobs_id_seq;
CREATE SEQUENCE failed_jobs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."failed_jobs" (
    "id" bigint DEFAULT nextval('failed_jobs_id_seq') NOT NULL,
    "uuid" character varying(255) NOT NULL,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX failed_jobs_uuid_unique ON public.failed_jobs USING btree (uuid);


DROP TABLE IF EXISTS "fuzzy_rule_details";
DROP SEQUENCE IF EXISTS fuzzy_rule_details_id_seq;
CREATE SEQUENCE fuzzy_rule_details_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."fuzzy_rule_details" (
    "id" bigint DEFAULT nextval('fuzzy_rule_details_id_seq') NOT NULL,
    "fuzzy_rule_id" bigint NOT NULL,
    "kriteria_id" bigint NOT NULL,
    "fuzzy_set_nama" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "fuzzy_rule_details_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "fuzzy_rule_details" ("id", "fuzzy_rule_id", "kriteria_id", "fuzzy_set_nama", "created_at", "updated_at") VALUES
(1,	1,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(2,	1,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(3,	1,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(4,	1,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(5,	2,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(6,	2,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(7,	2,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(8,	2,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(9,	3,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(10,	3,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(11,	3,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(12,	3,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(13,	4,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(14,	4,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(15,	4,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(16,	4,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(17,	5,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(18,	5,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(19,	5,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(20,	5,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(21,	6,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(22,	6,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(23,	6,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(24,	6,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(25,	7,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(26,	7,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(27,	7,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(28,	7,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(29,	8,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(30,	8,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(31,	8,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(32,	8,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(33,	9,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(34,	9,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(35,	9,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(36,	9,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(37,	10,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(38,	10,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(39,	10,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(40,	10,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(41,	11,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(42,	11,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(43,	11,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(44,	11,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(45,	12,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(46,	12,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(47,	12,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(48,	12,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(49,	13,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(50,	13,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(51,	13,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(52,	13,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(53,	14,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(54,	14,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(55,	14,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(56,	14,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(57,	15,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(58,	15,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(59,	15,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(60,	15,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(61,	16,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(62,	16,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(63,	16,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(64,	16,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(65,	17,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(66,	17,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(67,	17,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(68,	17,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(69,	18,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(70,	18,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(71,	18,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(72,	18,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(73,	19,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(74,	19,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(75,	19,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(76,	19,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(77,	20,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(78,	20,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(79,	20,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(80,	20,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(81,	21,	1,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(82,	21,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(83,	21,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(84,	21,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(85,	22,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(86,	22,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(87,	22,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(88,	22,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(89,	23,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(90,	23,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(91,	23,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(92,	23,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(93,	24,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(94,	24,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(95,	24,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(96,	24,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(97,	25,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(98,	25,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(99,	25,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(100,	25,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(101,	26,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(102,	26,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(103,	26,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(104,	26,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(105,	27,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(106,	27,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(107,	27,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(108,	27,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(109,	28,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(110,	28,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(111,	28,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(112,	28,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(113,	29,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(114,	29,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(115,	29,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(116,	29,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(117,	30,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(118,	30,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(119,	30,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(120,	30,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(121,	31,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(122,	31,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(123,	31,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(124,	31,	4,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(125,	32,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(126,	32,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(127,	32,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(128,	32,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(129,	33,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(130,	33,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(131,	33,	3,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(132,	33,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(133,	34,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(134,	34,	2,	'Tidak Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(135,	34,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(136,	34,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(137,	35,	1,	'Sedang',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(138,	35,	2,	'Cukup',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(139,	35,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(140,	35,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(141,	36,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(142,	36,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(143,	36,	3,	'Padat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(144,	36,	4,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(145,	37,	1,	'Baik',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(146,	37,	2,	'Sehat',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(147,	37,	3,	'Layak',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(148,	37,	4,	'Buruk',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41');

DROP TABLE IF EXISTS "fuzzy_rules";
DROP SEQUENCE IF EXISTS fuzzy_rules_id_seq;
CREATE SEQUENCE fuzzy_rules_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."fuzzy_rules" (
    "id" bigint DEFAULT nextval('fuzzy_rules_id_seq') NOT NULL,
    "nomor_rule" integer NOT NULL,
    "operator" character varying(255) DEFAULT 'AND' NOT NULL,
    "output_set" character varying(255) NOT NULL,
    "is_active" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "fuzzy_rules_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX fuzzy_rules_nomor_rule_unique ON public.fuzzy_rules USING btree (nomor_rule);

INSERT INTO "fuzzy_rules" ("id", "nomor_rule", "operator", "output_set", "is_active", "created_at", "updated_at") VALUES
(1,	1,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(2,	2,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(3,	3,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(4,	4,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(5,	5,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(6,	6,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(7,	7,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(8,	8,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(9,	9,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(10,	10,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(11,	11,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(12,	12,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(13,	13,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(14,	14,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(15,	15,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(16,	16,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(17,	17,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(18,	18,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(19,	19,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(20,	20,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(21,	21,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(22,	22,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(23,	23,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(24,	24,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(25,	25,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(26,	26,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(27,	27,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(28,	28,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(29,	29,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(30,	30,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(31,	31,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(32,	32,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(33,	33,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(34,	34,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(35,	35,	'AND',	'TIDAK LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(36,	36,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(37,	37,	'AND',	'LAYAK',	't',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41');

DROP TABLE IF EXISTS "fuzzy_sets";
DROP SEQUENCE IF EXISTS fuzzy_sets_id_seq;
CREATE SEQUENCE fuzzy_sets_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."fuzzy_sets" (
    "id" bigint DEFAULT nextval('fuzzy_sets_id_seq') NOT NULL,
    "kriteria_id" bigint,
    "nama" character varying(255) NOT NULL,
    "tipe" character varying(255) NOT NULL,
    "parameter" json NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "fuzzy_sets_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX fuzzy_sets_kriteria_id_nama_unique ON public.fuzzy_sets USING btree (kriteria_id, nama);

INSERT INTO "fuzzy_sets" ("id", "kriteria_id", "nama", "tipe", "parameter", "created_at", "updated_at") VALUES
(1,	1,	'Buruk',	'trapesium',	'[0,0,0.15,0.35]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(2,	1,	'Sedang',	'segitiga',	'[0.2,0.5,0.8]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(3,	1,	'Baik',	'trapesium',	'[0.65,0.85,1,1]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(4,	2,	'Tidak Sehat',	'trapesium',	'[0,0,0.15,0.35]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(5,	2,	'Cukup',	'segitiga',	'[0.2,0.5,0.8]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(6,	2,	'Sehat',	'trapesium',	'[0.65,0.85,1,1]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(7,	3,	'Padat',	'trapesium',	'[0,0,5,9]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(8,	3,	'Sedang',	'segitiga',	'[5,9.5,14]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(9,	3,	'Layak',	'trapesium',	'[10,14,30,30]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(10,	4,	'Buruk',	'trapesium',	'[0,0,0.15,0.35]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(11,	4,	'Sedang',	'segitiga',	'[0.2,0.5,0.8]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(12,	4,	'Baik',	'trapesium',	'[0.65,0.85,1,1]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(13,	NULL,	'TIDAK LAYAK',	'trapesium',	'[0,0,30,50]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(14,	NULL,	'LAYAK',	'trapesium',	'[50,70,100,100]',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41');

DROP TABLE IF EXISTS "hasil_spk";
DROP SEQUENCE IF EXISTS hasil_spk_id_seq;
CREATE SEQUENCE hasil_spk_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."hasil_spk" (
    "id" bigint DEFAULT nextval('hasil_spk_id_seq') NOT NULL,
    "penilaian_id" bigint NOT NULL,
    "nilai_defuzzifikasi" numeric(15,4) NOT NULL,
    "kategori_kelayakan" character varying(255) NOT NULL,
    "rekomendasi" text,
    "detail_perhitungan" json,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "hasil_spk_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "hasil_spk_kategori_kelayakan_check" CHECK (((kategori_kelayakan)::text = ANY ((ARRAY['TIDAK_LAYAK'::character varying, 'LAYAK'::character varying])::text[])))
)
WITH (oids = false);

CREATE UNIQUE INDEX hasil_spk_penilaian_id_unique ON public.hasil_spk USING btree (penilaian_id);

INSERT INTO "hasil_spk" ("id", "penilaian_id", "nilai_defuzzifikasi", "kategori_kelayakan", "rekomendasi", "detail_perhitungan", "created_at", "updated_at") VALUES
(1,	1,	78.7829,	'LAYAK',	'Direkomendasikan untuk menerima bantuan RTLH.',	'{"fuzzification":{"Aspek Keselamatan":{"Buruk":1,"Sedang":0,"Baik":0},"Aspek Kesehatan":{"Tidak Sehat":1,"Cukup":0,"Sehat":0},"Aspek Kepadatan":{"Padat":1,"Sedang":0,"Layak":0},"Aspek Komponen":{"Buruk":0.7499999999999999,"Sedang":0,"Baik":0}},"inference":{"LAYAK":0.7499999999999999,"TIDAK_LAYAK":0},"score_raw":78.78294573643412}',	'2026-04-24 19:15:00',	'2026-04-24 19:23:20');

DROP TABLE IF EXISTS "job_batches";
CREATE TABLE "public"."job_batches" (
    "id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "total_jobs" integer NOT NULL,
    "pending_jobs" integer NOT NULL,
    "failed_jobs" integer NOT NULL,
    "failed_job_ids" text NOT NULL,
    "options" text,
    "cancelled_at" integer,
    "created_at" integer NOT NULL,
    "finished_at" integer,
    CONSTRAINT "job_batches_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "jobs";
DROP SEQUENCE IF EXISTS jobs_id_seq;
CREATE SEQUENCE jobs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."jobs" (
    "id" bigint DEFAULT nextval('jobs_id_seq') NOT NULL,
    "queue" character varying(255) NOT NULL,
    "payload" text NOT NULL,
    "attempts" smallint NOT NULL,
    "reserved_at" integer,
    "available_at" integer NOT NULL,
    "created_at" integer NOT NULL,
    CONSTRAINT "jobs_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX jobs_queue_reserved_at_available_at_index ON public.jobs USING btree (queue, reserved_at, available_at);


DROP TABLE IF EXISTS "kelurahan";
DROP SEQUENCE IF EXISTS kelurahan_id_seq;
CREATE SEQUENCE kelurahan_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."kelurahan" (
    "id" bigint DEFAULT nextval('kelurahan_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "kode" character varying(255) NOT NULL,
    "batas_wilayah" json,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "kelurahan_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX kelurahan_kode_unique ON public.kelurahan USING btree (kode);

INSERT INTO "kelurahan" ("id", "nama", "kode", "batas_wilayah", "created_at", "updated_at") VALUES
(1,	'Plaju Darat',	'1671071001',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00'),
(2,	'Plaju Ilir',	'1671071002',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00'),
(3,	'Plaju Ulu',	'1671071003',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00'),
(4,	'Komperta',	'1671071004',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00'),
(5,	'Bagus Kuning',	'1671071005',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00'),
(6,	'Talang Bubuk',	'1671071006',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00'),
(7,	'Talang Putri',	'1671071007',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00');

DROP TABLE IF EXISTS "kriteria";
DROP SEQUENCE IF EXISTS kriteria_id_seq;
CREATE SEQUENCE kriteria_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."kriteria" (
    "id" bigint DEFAULT nextval('kriteria_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "kode" character varying(255) NOT NULL,
    "min_value" numeric(15,2) NOT NULL,
    "max_value" numeric(15,2) NOT NULL,
    "satuan" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "kriteria_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX kriteria_kode_unique ON public.kriteria USING btree (kode);

INSERT INTO "kriteria" ("id", "nama", "kode", "min_value", "max_value", "satuan", "created_at", "updated_at") VALUES
(1,	'Aspek Keselamatan',	'K1',	0.00,	1.00,	'Indeks',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(2,	'Aspek Kesehatan',	'K2',	0.00,	1.00,	'Indeks',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(3,	'Aspek Kepadatan',	'K3',	0.00,	30.00,	'm2/org',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41'),
(4,	'Aspek Komponen',	'K4',	0.00,	1.00,	'Indeks',	'2026-04-24 19:14:41',	'2026-04-24 19:14:41');

DROP TABLE IF EXISTS "migrations";
DROP SEQUENCE IF EXISTS migrations_id_seq;
CREATE SEQUENCE migrations_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."migrations" (
    "id" integer DEFAULT nextval('migrations_id_seq') NOT NULL,
    "migration" character varying(255) NOT NULL,
    "batch" integer NOT NULL,
    CONSTRAINT "migrations_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "migrations" ("id", "migration", "batch") VALUES
(1,	'0001_01_01_000000_create_users_table',	1),
(2,	'0001_01_01_000001_create_cache_table',	1),
(3,	'0001_01_01_000002_create_jobs_table',	1),
(4,	'2026_03_12_045501_create_kelurahan_table',	1),
(5,	'2026_03_12_045502_create_penduduk_table',	1),
(6,	'2026_03_12_045503_create_rumah_table',	1),
(7,	'2026_03_12_045504_create_kriteria_table',	1),
(8,	'2026_03_12_045505_create_fuzzy_sets_table',	1),
(9,	'2026_03_12_045506_create_fuzzy_rules_table',	1),
(10,	'2026_03_12_045507_create_fuzzy_rule_details_table',	1),
(11,	'2026_03_12_045508_create_penilaian_table',	1),
(12,	'2026_03_12_045509_create_nilai_kriteria_table',	1),
(13,	'2026_03_12_045510_create_hasil_spk_table',	1),
(14,	'2026_04_24_185607_make_kriteria_id_nullable_in_fuzzy_sets_table',	2);

DROP TABLE IF EXISTS "nilai_kriteria";
DROP SEQUENCE IF EXISTS nilai_kriteria_id_seq;
CREATE SEQUENCE nilai_kriteria_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."nilai_kriteria" (
    "id" bigint DEFAULT nextval('nilai_kriteria_id_seq') NOT NULL,
    "penilaian_id" bigint NOT NULL,
    "kriteria_id" bigint NOT NULL,
    "nilai_input" numeric(15,2) NOT NULL,
    "hasil_fuzzifikasi" json,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "nilai_kriteria_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "nilai_kriteria" ("id", "penilaian_id", "kriteria_id", "nilai_input", "hasil_fuzzifikasi", "created_at", "updated_at") VALUES
(1,	1,	1,	0.00,	'{"Buruk":1,"Sedang":0,"Baik":0}',	'2026-04-24 19:15:00',	'2026-04-24 19:23:20'),
(2,	1,	2,	0.00,	'{"Tidak Sehat":1,"Cukup":0,"Sehat":0}',	'2026-04-24 19:15:00',	'2026-04-24 19:23:20'),
(3,	1,	3,	4.00,	'{"Padat":1,"Sedang":0,"Layak":0}',	'2026-04-24 19:15:00',	'2026-04-24 19:23:20'),
(4,	1,	4,	0.20,	'{"Buruk":0.7499999999999999,"Sedang":0,"Baik":0}',	'2026-04-24 19:15:00',	'2026-04-24 19:23:20');

DROP TABLE IF EXISTS "password_reset_tokens";
CREATE TABLE "public"."password_reset_tokens" (
    "email" character varying(255) NOT NULL,
    "token" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    CONSTRAINT "password_reset_tokens_pkey" PRIMARY KEY ("email")
)
WITH (oids = false);


DROP TABLE IF EXISTS "penduduk";
DROP SEQUENCE IF EXISTS penduduk_id_seq;
CREATE SEQUENCE penduduk_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."penduduk" (
    "id" bigint DEFAULT nextval('penduduk_id_seq') NOT NULL,
    "nik" character varying(255) NOT NULL,
    "nama_lengkap" character varying(255) NOT NULL,
    "alamat" text NOT NULL,
    "kelurahan_id" bigint NOT NULL,
    "no_telepon" character varying(255),
    "status_pernikahan" character varying(255),
    "jumlah_tanggungan" integer DEFAULT '0' NOT NULL,
    "penghasilan" numeric(15,2) DEFAULT '0' NOT NULL,
    "latitude" numeric(10,8),
    "longitude" numeric(11,8),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "penduduk_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX penduduk_nik_unique ON public.penduduk USING btree (nik);

INSERT INTO "penduduk" ("id", "nik", "nama_lengkap", "alamat", "kelurahan_id", "no_telepon", "status_pernikahan", "jumlah_tanggungan", "penghasilan", "latitude", "longitude", "created_at", "updated_at") VALUES
(1,	'1671239129803019',	'Muhammad Sahrony Ansorry',	'Jl.D.I. Panjaitan',	5,	'082292847299',	'Kawin',	5,	4500000.00,	-2.99498700,	104.80895400,	'2026-04-24 16:51:59',	'2026-04-24 16:51:59');

DROP TABLE IF EXISTS "penilaian";
DROP SEQUENCE IF EXISTS penilaian_id_seq;
CREATE SEQUENCE penilaian_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."penilaian" (
    "id" bigint DEFAULT nextval('penilaian_id_seq') NOT NULL,
    "penduduk_id" bigint NOT NULL,
    "user_id" bigint NOT NULL,
    "periode" character varying(255) NOT NULL,
    "tanggal_penilaian" timestamp(0) DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "status" character varying(255) DEFAULT 'DRAFT' NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "penilaian_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "penilaian_status_check" CHECK (((status)::text = ANY ((ARRAY['DRAFT'::character varying, 'DIPROSES'::character varying, 'SELESAI'::character varying])::text[])))
)
WITH (oids = false);

INSERT INTO "penilaian" ("id", "penduduk_id", "user_id", "periode", "tanggal_penilaian", "status", "created_at", "updated_at") VALUES
(1,	1,	1,	'2026',	'2026-04-24 19:23:20',	'SELESAI',	'2026-04-24 19:15:00',	'2026-04-24 19:23:20');

DROP TABLE IF EXISTS "rumah";
DROP SEQUENCE IF EXISTS rumah_id_seq;
CREATE SEQUENCE rumah_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."rumah" (
    "id" bigint DEFAULT nextval('rumah_id_seq') NOT NULL,
    "penduduk_id" bigint NOT NULL,
    "pondasi" character varying(255) DEFAULT 'Tidak Ada' NOT NULL,
    "kolom_balok" character varying(255) DEFAULT 'Rusak Berat' NOT NULL,
    "konstruksi_atap" character varying(255) DEFAULT 'Rusak Berat' NOT NULL,
    "jendela" character varying(255) DEFAULT 'Tidak Ada' NOT NULL,
    "ventilasi" character varying(255) DEFAULT 'Tidak Ada' NOT NULL,
    "kamar_mandi" character varying(255) DEFAULT 'Tidak Ada' NOT NULL,
    "jarak_sumber_air" character varying(255) DEFAULT 'Kurang dari 10 meter' NOT NULL,
    "luas_bangunan" numeric(10,2) NOT NULL,
    "material_atap" character varying(255) DEFAULT 'Daun / Rumbia / Ijuk' NOT NULL,
    "kondisi_atap" character varying(255) DEFAULT 'Rusak Berat / Seluruhnya' NOT NULL,
    "material_dinding" character varying(255) DEFAULT 'Bambu / Anyaman' NOT NULL,
    "kondisi_dinding" character varying(255) DEFAULT 'Rusak Berat / Seluruhnya' NOT NULL,
    "material_lantai" character varying(255) DEFAULT 'Tanah' NOT NULL,
    "kondisi_lantai" character varying(255) DEFAULT 'Rusak Berat / Seluruhnya' NOT NULL,
    "status_kepemilikan" character varying(255),
    "foto_rumah" character varying(255),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "rumah_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "rumah" ("id", "penduduk_id", "pondasi", "kolom_balok", "konstruksi_atap", "jendela", "ventilasi", "kamar_mandi", "jarak_sumber_air", "luas_bangunan", "material_atap", "kondisi_atap", "material_dinding", "kondisi_dinding", "material_lantai", "kondisi_lantai", "status_kepemilikan", "foto_rumah", "created_at", "updated_at") VALUES
(1,	1,	'Tidak Ada',	'Rusak Berat / Seluruhnya',	'Rusak Berat / Seluruhnya',	'Tidak Ada',	'Tidak Ada',	'Tidak Ada',	'Kurang dari 10 meter',	20.00,	'Daun / Rumbia / Ijuk',	'Rusak Berat / Seluruhnya',	'Bambu / Anyaman',	'Rusak Berat / Seluruhnya',	'Tanah',	'Rusak Berat / Seluruhnya',	'Numpang',	NULL,	'2026-04-24 17:11:09',	'2026-04-24 19:21:10');

DROP TABLE IF EXISTS "sessions";
CREATE TABLE "public"."sessions" (
    "id" character varying(255) NOT NULL,
    "user_id" bigint,
    "ip_address" character varying(45),
    "user_agent" text,
    "payload" text NOT NULL,
    "last_activity" integer NOT NULL,
    CONSTRAINT "sessions_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);

INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
('mXJl67gRDUkix8NdK9ZotAzOpzkSLtewcqWyYLyY',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQkYycHVtTUNhTGdRcncyenpaV3FmN3JURTN1bHpEVDVSakRxY1FhciI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BlbmR1ZHVrIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5kdWR1ayI7czo1OiJyb3V0ZSI7czoxNDoicGVuZHVkdWsuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',	1777054815),
('0Dz7TembBFNxaoK59sXQ5ysvL9FPVJlkwjr8K9fA',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0',	'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnQ5Zk56RUFtallkTWRHZVJmVU1EUlFVZUl6cmZFU0ZrMmxVZGVUciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',	1777054815),
('b8rZDiJ1zMQU6i3xfcCGYSfh4FjDa6CUuIALvBXi',	1,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0',	'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ1hGOWtMZk5hd213RVhNdHVHR2xKdWdmVnhhZE1kRDJqV2ZnTTJ1QyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcGVuZHVkdWsvMSI7czo1OiJyb3V0ZSI7czoxMzoicGVuZHVkdWsuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',	1777058659);

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."users" (
    "id" bigint DEFAULT nextval('users_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "email_verified_at" timestamp(0),
    "password" character varying(255) NOT NULL,
    "remember_token" character varying(100),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX users_email_unique ON public.users USING btree (email);

INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at") VALUES
(1,	'Administrator',	'admin@plaju.go.id',	NULL,	'$2y$12$/Q6D2DlNPS74F6lM41EdIeB4HPLrlq4NeRhDxEJx3K5eIsxpVbsxW',	NULL,	'2026-04-24 16:46:00',	'2026-04-24 16:46:00');

ALTER TABLE ONLY "public"."fuzzy_rule_details" ADD CONSTRAINT "fuzzy_rule_details_fuzzy_rule_id_foreign" FOREIGN KEY (fuzzy_rule_id) REFERENCES fuzzy_rules(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."fuzzy_rule_details" ADD CONSTRAINT "fuzzy_rule_details_kriteria_id_foreign" FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."fuzzy_sets" ADD CONSTRAINT "fuzzy_sets_kriteria_id_foreign" FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."hasil_spk" ADD CONSTRAINT "hasil_spk_penilaian_id_foreign" FOREIGN KEY (penilaian_id) REFERENCES penilaian(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."nilai_kriteria" ADD CONSTRAINT "nilai_kriteria_kriteria_id_foreign" FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."nilai_kriteria" ADD CONSTRAINT "nilai_kriteria_penilaian_id_foreign" FOREIGN KEY (penilaian_id) REFERENCES penilaian(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."penduduk" ADD CONSTRAINT "penduduk_kelurahan_id_foreign" FOREIGN KEY (kelurahan_id) REFERENCES kelurahan(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."penilaian" ADD CONSTRAINT "penilaian_penduduk_id_foreign" FOREIGN KEY (penduduk_id) REFERENCES penduduk(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."penilaian" ADD CONSTRAINT "penilaian_user_id_foreign" FOREIGN KEY (user_id) REFERENCES users(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."rumah" ADD CONSTRAINT "rumah_penduduk_id_foreign" FOREIGN KEY (penduduk_id) REFERENCES penduduk(id) ON DELETE CASCADE NOT DEFERRABLE;

-- 2026-04-24 19:34:54 UTC
