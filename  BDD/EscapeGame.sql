PGDMP     %                    {         
   EscapeGame    12.4    12.4     k           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            l           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            m           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            n           1262    37191 
   EscapeGame    DATABASE     �   CREATE DATABASE "EscapeGame" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'French_France.1252' LC_CTYPE = 'French_France.1252';
    DROP DATABASE "EscapeGame";
                postgres    false                        3079    38197    postgis 	   EXTENSION     ;   CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;
    DROP EXTENSION postgis;
                   false            o           0    0    EXTENSION postgis    COMMENT     g   COMMENT ON EXTENSION postgis IS 'PostGIS geometry, geography, and raster spatial types and functions';
                        false    2            �            1259    39214    drivers    TABLE     �   CREATE TABLE public.drivers (
    id integer NOT NULL,
    nom character varying(255),
    num integer,
    photo character varying(255),
    video character varying(255),
    team character varying(255)
);
    DROP TABLE public.drivers;
       public         heap    postgres    false            �            1259    39199    objets    TABLE     �   CREATE TABLE public.objets (
    id integer NOT NULL,
    nom character varying(255),
    coords public.geometry,
    icon character varying(255),
    ix integer,
    iy integer
);
    DROP TABLE public.objets;
       public         heap    postgres    false    2    2    2    2    2    2    2    2            �            1259    39222    player    TABLE     n   CREATE TABLE public.player (
    id integer NOT NULL,
    pseudo character varying(255),
    score integer
);
    DROP TABLE public.player;
       public         heap    postgres    false            g          0    39214    drivers 
   TABLE DATA           C   COPY public.drivers (id, nom, num, photo, video, team) FROM stdin;
    public          postgres    false    209   �       f          0    39199    objets 
   TABLE DATA           ?   COPY public.objets (id, nom, coords, icon, ix, iy) FROM stdin;
    public          postgres    false    208   �       h          0    39222    player 
   TABLE DATA           3   COPY public.player (id, pseudo, score) FROM stdin;
    public          postgres    false    210   A       �          0    38502    spatial_ref_sys 
   TABLE DATA           X   COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
    public          postgres    false    204   �       �           2606    39221    drivers drivers_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.drivers
    ADD CONSTRAINT drivers_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.drivers DROP CONSTRAINT drivers_pkey;
       public            postgres    false    209            �           2606    39206    objets objets_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.objets
    ADD CONSTRAINT objets_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.objets DROP CONSTRAINT objets_pkey;
       public            postgres    false    208            �           2606    39226    player player_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.player
    ADD CONSTRAINT player_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.player DROP CONSTRAINT player_pkey;
       public            postgres    false    210            g   2  x�u��r�0���)���|�H�f
	2�����A�<��B��������od�UsR:%�)�!!`< �aJ�K΅*�gZ7�s�^+M��	�~�aE:��L0��jA�-)6�p�����.��AZ����lE�E.?a4�|gՉO�`�'�#m
�s���O.d�7eCI�"Öt�[��O1u�u�����e�سҚ�)QU]��S���ISx1��ٚ�)4���)U�]�|����9q��k��+5ɍ���K
�O����(�K�$�=QSv�K�c��F'6�N
m�u��y�Bp�LF�T�����e�A����̫��3�[��Hro�1D��&m��U뛵@��~��l���FPB����p�:hK#����`�u�����p�&�;��^��3c��Wy��ՔR%Q��ζ�j��?�v(��4g��(���;��K�K^3�}��Fe��p
��d���Ӻzwy�I��P]��ʙP�(��|�t��5�T�����Z���ٟ��Z��Ce
%{+��AK��[`ƅ�a��UÝW���~� �1Y      f   6  x���Mo�0��1���=G�ت�k�S/�,�����*��f?���S�EBH<ϼ6��m�5�m�X�����[f��U�Ak�5g�$t���>����B�;�<T$,TR��u75_�iC��Y�H?�$�Mѥl,��ĕ��Ʃi6t�ŌJG�B�Z����w�C�q)kq����-�9vѳ�2֠
�c��ˠ�����@hU�8�����i�YE"e�=Wjq�����"\U����t_��V��N.�9��Ju��xj�>���%*.�k�q6ɤe��\kM9�W��w���/*E�Z{B�ل��0{2;��k�p�� Y!��ݰ��6lM��{m�7���D�T
���'��֥L)��}���:(�s����҄�F��]�7d������:C�ZK����I�2���X�ZLC|�J��%X쁐�̪P"�j���g��C�e���P��9=������yׇ��='v��r�hi�uƔ��M�H*i���߬2����������J,\4��M׵�5���K��aYbU��ҕ��/µ
�wUU�Ypb
      h   z   x�=̱
� ���܇)ژ�k�B�@J�.VTPK_?�:~��/����	R	!�=��`�ɏڠ�S
�X����Z���oꐂ����b�X�7�G
�7�9;Ň201ퟆ�R`k�(��BD��$�      �      x������ � �     