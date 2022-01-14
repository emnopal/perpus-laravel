create database if not exists `perpus-admin`;

-- run: php artisan make:migration create_anggota_table --create=anggota
-- run: php artisan make:migration create_transaksi_table --create=transaksi
-- run: php artisan make:migration create_buku_table --create=buku
-- run: php artisan make:model User
-- run: php artisan make:model Anggota
-- run: php artisan make:model Transaksi
-- run: php artisan make:model Buku
-- run: php artisan make:seeder UsersTableSeeder
-- run: php artisan make:seeder AnggotaTableSeeder
-- run: php artisan make:seeder BukuTableSeeder
-- run: php artisan migrate

-- make sure all data have been migrated:
show create table `perpus-admin`.`anggota`;
show create table `perpus-admin`.`users`;
show create table `perpus-admin`.`transaksi`;
show create table `perpus-admin`.`buku`;

select * from `perpus-admin`.`anggota`;
select * from `perpus-admin`.`users`;
select * from `perpus-admin`.`transaksi`;
select * from `perpus-admin`.`buku`;