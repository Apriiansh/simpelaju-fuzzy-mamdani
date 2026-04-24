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


DROP TABLE IF EXISTS "fuzzy_sets";
DROP SEQUENCE IF EXISTS fuzzy_sets_id_seq;
CREATE SEQUENCE fuzzy_sets_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."fuzzy_sets" (
    "id" bigint DEFAULT nextval('fuzzy_sets_id_seq') NOT NULL,
    "kriteria_id" bigint NOT NULL,
    "nama" character varying(255) NOT NULL,
    "tipe" character varying(255) NOT NULL,
    "parameter" json NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "fuzzy_sets_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX fuzzy_sets_kriteria_id_nama_unique ON public.fuzzy_sets USING btree (kriteria_id, nama);


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
    CONSTRAINT "hasil_spk_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX hasil_spk_penilaian_id_unique ON public.hasil_spk USING btree (penilaian_id);


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
(13,	'2026_03_12_045510_create_hasil_spk_table',	1);

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
    CONSTRAINT "penilaian_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


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

-- 2026-04-24 16:29:57 UTC
