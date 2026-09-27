-- ClubHub : données de démonstration
-- Usage : mysql -u clubhub -p clubhub < database/seed.sql (après schema.sql)
-- Mot de passe de tous les comptes : demo1234
-- Les dates sont calculées à partir d'aujourd'hui : les événements sont toujours « à venir ».

SET NAMES utf8mb4;

INSERT INTO users (id, name, email, password_hash, role) VALUES
    (1, 'Amine Ben Salah', 'amine@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'student'),
    (2, 'Sarra Trabelsi', 'sarra@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'student'),
    (3, 'Club Robotique', 'robotique@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'organizer'),
    (4, 'Club Photo', 'photo@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'organizer'),
    (5, 'Club IA', 'ia@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'organizer'),
    (6, 'Club Échecs', 'echecs@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'organizer'),
    (7, 'Club Entrepreneuriat', 'entrepreneuriat@campus.example', '$2y$12$fhEds9o2hXMSIgRK1uoUeeiYU5z6dWa2PcQWId7DJBe45ty/gydHe', 'organizer');

INSERT INTO events (id, title, club, club_slug, description, program, bring, location, starts_at, ends_at, capacity, organizer_id) VALUES
    (1, 'Atelier Arduino pour débutants', 'Club Robotique', 'robotique',
     'Vous n''avez jamais touché un Arduino ? Cet atelier est fait pour vous. En trois heures, vous allez câbler vos premiers composants, écrire vos premiers programmes et repartir avec un petit projet qui fonctionne. Les cartes et les composants sont fournis par le club.',
     'Découvrir la carte Arduino Uno
Faire clignoter une LED
Lire un capteur de température
Mini projet : un thermomètre à LED',
     'Un ordinateur portable
Un câble USB (si vous en avez un)',
     'Salle B204', TIMESTAMP(CURDATE() + INTERVAL 5 DAY, '14:00:00'), TIMESTAMP(CURDATE() + INTERVAL 5 DAY, '17:00:00'), 20, 3),
    (2, 'Sortie photo en ville', 'Club Photo', 'photo',
     'Une matinée pour apprendre à composer une image : lumière, cadrage, portrait de rue. Tous les appareils sont acceptés, même un téléphone. On termine par une petite séance de tri des photos autour d''un café.',
     'Les règles de composition
Photographier la lumière du matin
Portrait de rue : demander, cadrer, remercier
Tri et partage des meilleures photos',
     'Un appareil photo ou un téléphone
De bonnes chaussures',
     'Entrée principale', TIMESTAMP(CURDATE() + INTERVAL 8 DAY, '09:00:00'), TIMESTAMP(CURDATE() + INTERVAL 8 DAY, '12:00:00'), 15, 4),
    (3, 'Conférence : l''IA dans l''industrie', 'Club IA', 'ia',
     'Trois ingénieurs viennent raconter comment ils utilisent l''intelligence artificielle dans leur travail : maintenance prédictive, contrôle qualité par vision, assistants pour les équipes. Une heure de présentations, une heure de questions.',
     'Maintenance prédictive dans une usine
Vision par ordinateur pour le contrôle qualité
Questions et échanges',
     'Vos questions',
     'Amphithéâtre A', TIMESTAMP(CURDATE() + INTERVAL 12 DAY, '10:00:00'), TIMESTAMP(CURDATE() + INTERVAL 12 DAY, '12:00:00'), 120, 5),
    (4, 'Tournoi blitz inter promo', 'Club Échecs', 'echecs',
     'Parties rapides de 5 minutes, système suisse en 7 rondes. Débutants bienvenus : une table d''initiation est ouverte pendant tout le tournoi. Le classement final donne des points pour le championnat annuel des promos.',
     'Accueil et tirage
7 rondes de blitz
Remise des prix',
     'Rien, les jeux et les pendules sont fournis',
     'Foyer des étudiants', TIMESTAMP(CURDATE() + INTERVAL 15 DAY, '15:00:00'), TIMESTAMP(CURDATE() + INTERVAL 15 DAY, '19:00:00'), 32, 6),
    (5, 'Hackathon impact social', 'Club Entrepreneuriat', 'entrepreneuriat',
     'Une journée pour imaginer et prototyper une solution à un problème réel proposé par une association locale. Équipes de 4, mentors sur place, présentation de 3 minutes devant un jury en fin de journée.',
     'Présentation des défis par les associations
Travail en équipe avec les mentors
Pitch de 3 minutes
Résultats',
     'Un ordinateur portable
Votre bonne humeur',
     'Salle C101', TIMESTAMP(CURDATE() + INTERVAL 22 DAY, '09:00:00'), TIMESTAMP(CURDATE() + INTERVAL 22 DAY, '18:00:00'), 40, 7),
    (6, 'Atelier soudure (passé)', 'Club Robotique', 'robotique',
     'Un atelier qui a déjà eu lieu : il ne doit plus apparaître dans la liste des événements à venir.',
     'Souder des composants',
     'Rien',
     'Salle B204', TIMESTAMP(CURDATE() - INTERVAL 10 DAY, '14:00:00'), TIMESTAMP(CURDATE() - INTERVAL 10 DAY, '16:00:00'), 12, 3),
    (7, 'Initiation aux échecs', 'Club Échecs', 'echecs',
     'Une heure pour apprendre les règles et jouer vos premières parties. Petit groupe : les places partent vite.',
     'Les règles
Premières parties
Questions',
     'Rien',
     'Foyer des étudiants', TIMESTAMP(CURDATE() + INTERVAL 9 DAY, '12:00:00'), TIMESTAMP(CURDATE() + INTERVAL 9 DAY, '13:00:00'), 2, 6);

-- Quelques inscriptions. L'événement 7 est complet (2 places, 2 inscrits).
INSERT INTO registrations (user_id, event_id, motivation) VALUES
    (1, 1, 'Je veux construire une station météo.'),
    (1, 3, ''),
    (2, 3, 'Mon projet de fin d''études porte sur la vision.'),
    (1, 7, ''),
    (2, 7, 'Je ne connais pas du tout les règles.');
