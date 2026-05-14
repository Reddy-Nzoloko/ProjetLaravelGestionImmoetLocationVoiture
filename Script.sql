CREATE DATABASE immo_auto_plus; 
use immo_auto_plus;

SELECT * FROM companies;
SELECT * FROM listings;

SELECT * FROM users;

SELECT * FROM users WHERE email = 'kalebo';
bon avant de continuer nous allons un peu modifier la stucture du projet et ajouter un secteur vestimentaire vue que maintenant nous avons que des immo et l'auto comme ça quelqu'un qui s'interesse dans la vente des habit peut aussi creer une entreprise... allons y faisons croitre le système. pour la deuxième chose à faire on va aussi chercher la manière de faire qu'un utilisateur d'une entreprise va chaque fois demader un badget et dire envoyer cette notification dans la page super admin et seul le super Admin donnera les badget après leurs conversation peut etre sur mail ou sur whatsapp