# Unity Care Clinic — Backend (PHP 8.5 procédural & MySQLi)

Bienvenue dans le repository du backend de **Unity Care Clinic**, un système de gestion clinique développé en **PHP procédural** avec **MySQLi**.  
Ce backend fournit une base solide pour gérer les entités principales (patients, médecins, départements) ainsi qu’un tableau de bord interactif pour l’administration.

---

##  Objectif du projet

Développer la **version 1** du backend de la plateforme Unity Care Clinic, permettant :

- La gestion complète des entités de la clinique  
- Un tableau de bord dynamique affichant des statistiques  
- Un système d’internationalisation (i18n)  
- Une architecture simple, claire et facile à maintenir  

Durée : **6 jours** (cadre académique).

---

##  Stack technique

| Technologie | Usage |
|------------|--------|
| **PHP 8.5 (procédural)** | Backend |
| **MySQL / MySQLi** | Base de données |
| **Chart.js** | Graphiques du tableau de bord |
| **AJAX (optionnel)** | Actions asynchrones |
| **Docker** | Environnement d’exécution |
| **Jira** | Planification & suivi |

---

## Fonctionnalités

###  Gestion des entités (CRUD)
- Patients  
- Médecins  
- Départements  
- Association médecins ↔ départements  

###  Tableau de bord & statistiques
- Nombre total d’entités  
- Statistiques par catégorie  
- Graphiques dynamiques (Chart.js)

###  Internationalisation (i18n)
- Fichiers de langue : `fr.php`, `en.php`, `es.php`  
- Sélecteur de langue dans l’interface  

###  Bonus (optionnel)
- Opérations AJAX  
- Modals pour les formulaires  
- Graphiques avancés  

---

##  User Stories

- **US01 — Gestion des Patients** : CRUD complet  
- **US02 — Gestion des Départements** : Administration complète  
- **US03 — Gestion des Médecins** : CRUD + lien département  
- **US04 — Dashboard Statistiques** : Visualisation dynamique  
- **US05 — Internationalisation (i18n)** : Langues multiples  
- **US06 — Navigation AJAX** : Opérations asynchrones  

---

##  Installation & exécution (Docker)

###  Prérequis
- Docker  
- Docker Compose  

### ▶️ Démarrage

Clonez le projet :

git clone https://github.com/Oussama-Ait-Youss/UnityCareClinic-Backend.git
cd UnityCareClinic-Backend

- Lancez Docker :

docker-compose up -d


- Accédez au site :
 'http://localhost:80'

Accès MySQL :

Host : db

User : root

Password : défini dans docker-compose.yml


## Structure du projet
/project
│── /config
│     └── db.php
│
│── /patients
│     ├── add.php
│     ├── edit.php
│     ├── delete.php
│     └── list.php
│
│── /departments
│── /doctors
│── /dashboard
│
│── /languages
│     ├── fr.php
│     ├── en.php
│     └── es.php
│
│── /assets
│── index.php
│── README.md
│── script.sql
│── docker-compose.yml
└── Dockerfile

Sécurité & Bonnes Pratiques (PHP & MySQLi)
## Sécurité

Requêtes préparées (prévention SQL Injection)

Validation & sanitization des entrées (htmlspecialchars, filter_input)

Protection XSS

Séparation config / code

Pas d’identifiants en clair

## Bonnes Pratiques

DRY : fonctions réutilisables

Code divisé par modules

Convention de nommage cohérente

Commentaires clairs

## Gestion des erreurs & logs


Tests & Performance

Critères évalués :

⏱️ Temps de réponse du backend

💾 Mémoire utilisée

⚡ Optimisation des requêtes SQL

## Stabilité des connexions MySQL


Planification du Projet (Jira)

Tous les sprints, tasks et epics sont planifiés sur Jira.

👉 Lien Jira : https://oussamaaityouss.atlassian.net/jira/software/projects/UN/boards/5/backlog?epics=visible&atlOrigin=eyJpIjoiYTY3ZTJkN2FjYjBjNGUyYWEwNTEwMjU4YjI4YTFmZDEiLCJwIjoiaiJ9



Script SQL

Le fichier script.sql contient :

Création de la base de données

Tables : patients, doctors, departments

Contraintes & relations (clé étrangère)

Données initiales

📘 Documentation & Schémas

Livrables inclus :

ERD (diagramme entité–relation)

UML (diagramme de cas d’utilisation)

README complet

Compte rendu final du projet

## Licence

Projet académique — Usage libre à des fins pédagogiques.


## Auteur

Ait Youss Oussama
YouCode 