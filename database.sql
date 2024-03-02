
CREATE DATABASE grad
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'English_United States.1252'
    LC_CTYPE = 'English_United States.1252'
    LOCALE_PROVIDER = 'libc'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;


CREATE TABLE public.scripts
(
    name "char",
    script "char"
);

ALTER TABLE IF EXISTS public.test
    OWNER to postgres;



CREATE TABLE public.users
(
    email "char",
    password "char"
);

ALTER TABLE IF EXISTS public.test
    OWNER to postgres;