insert into faction (idF, nom, appartenance, influence, age) values 
(1, "L'Imperium de l'humanité", NULL, "Omniprésents dans la galaxie", "douze mille ans"),
(2, "Le Chaos", NULL, "Absolue dans le warp, omniprésents dans la galaxie", "génèse"),
(3, "Empire T'au", NULL, "modérée voir insignifiante", "environ deux mille ans"),
(4, "Aeldari", "Les Anciens", "Forte dans toute la galaxie", "plus de 60 millions d'années"),
(5, "Nécrons", "Nécrontyrs", "Moyenne dans toute la galaxie", "environ 70 millions d'années"),
(6, "Tyranids", NULL, "Omniprésents dans la galaxie", "deux mille ans dans notre galaxie, origine inconnue"),
(7, "Orcs", "Les Anciens", "Forte dans toute la galaxie", "plus de 60 millions d'années");

insert into personnage (nom, idF, sousFaction, age, taille, genre, statut, classe) values
("L'Empereur de l'humanité", 1, NULL, "environ 40 mille ans", "4,20 mètres", "homme", "Légume", "Divin"),
("Horus Lupercal", 2, "Sons of Horus", "environ 5 mille ans", "3,20 mètres", "homme", "Décédé", "Divin"),
("Eldrad Ulthran", 4, "Vaisseau Monde Ulthwé", "plus de 12 mille ans", "1,80 mètres", "homme", "Revenu à la vie", "Psychiquement surpuissant"),

insert into planete (nom, statut, idF) values
("Cadia", "Anéantie", 1),
("Terra", "Active", 1)

insert into minifigs_sets (nom, prix, stock, idF) values
("escouade d'intercesseurs", 51.25, 0, 1)