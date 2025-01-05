-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."tbl_follow" (
    "followed" varchar(255),
    "follower" varchar(255),
    CONSTRAINT "tbl_follow_following_fkey" FOREIGN KEY ("followed") REFERENCES "public"."tbl_user"("username"),
    CONSTRAINT "tbl_follow_followers_fkey" FOREIGN KEY ("follower") REFERENCES "public"."tbl_user"("username"),
    CONSTRAINT "followd_fk" FOREIGN KEY ("followed") REFERENCES "public"."tbl_user"("username")
);

-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."tbl_like" (
    "fan" varchar(255),
    "owner_post" varchar(255),
    "slug" varchar(255),
    CONSTRAINT "tbl_like_fan_fkey" FOREIGN KEY ("fan") REFERENCES "public"."tbl_user"("username") ON DELETE CASCADE,
    CONSTRAINT "tbl_like_owner_post_fkey" FOREIGN KEY ("owner_post") REFERENCES "public"."tbl_user"("username") ON DELETE CASCADE,
    CONSTRAINT "tbl_like_slug_fkey" FOREIGN KEY ("slug") REFERENCES "public"."tbl_post"("slug") ON DELETE CASCADE
);

-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS tbl_post_id_post_seq;

-- Table Definition
CREATE TABLE "public"."tbl_post" (
    "id_post" int4 NOT NULL DEFAULT nextval('tbl_post_id_post_seq'::regclass),
    "username" varchar(255),
    "body_post" text,
    "media" varchar,
    "slug" varchar,
    "create_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    "reply" varchar,
    CONSTRAINT "user_fk" FOREIGN KEY ("username") REFERENCES "public"."tbl_user"("username") ON DELETE CASCADE,
    PRIMARY KEY ("id_post")
);


-- Indices
CREATE INDEX slug_post ON public.tbl_post USING btree (slug)
CREATE UNIQUE INDEX unq_slug ON public.tbl_post USING btree (slug);

-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."tbl_save" (
    "saver" varchar(255),
    "owner_post" varchar(255),
    "slug" varchar(255),
    CONSTRAINT "tbl_save_saver_fkey" FOREIGN KEY ("saver") REFERENCES "public"."tbl_user"("username") ON DELETE CASCADE,
    CONSTRAINT "tbl_save_owner_post_fkey" FOREIGN KEY ("owner_post") REFERENCES "public"."tbl_user"("username") ON DELETE CASCADE,
    CONSTRAINT "tbl_save_slug_fkey" FOREIGN KEY ("slug") REFERENCES "public"."tbl_post"("slug") ON DELETE CASCADE
);

-- This script only contains the table creation statements and does not fully represent the table in the database. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS tbl_user_id_user_seq;

-- Table Definition
CREATE TABLE "public"."tbl_user" (
    "id_user" int4 NOT NULL DEFAULT nextval('tbl_user_id_user_seq'::regclass),
    "username" varchar(255) NOT NULL,
    "display_name" varchar(255),
    "email" varchar(255),
    "password" text,
    "photo_profile" varchar,
    PRIMARY KEY ("username")
);


-- Indices
CREATE UNIQUE INDEX tbl_user_id_user_key ON public.tbl_user USING btree (id_user);

