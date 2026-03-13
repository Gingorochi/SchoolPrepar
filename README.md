#  SchoolPrepar

> Plateforme de préparation aux examens scolaires développée avec **Symfony 7**



## 📋 Description

**SchoolPrepar** est une application web pédagogique qui permet aux élèves
de préparer efficacement leurs examens (BEPC, BAC).
Elle propose des cours structurés, des exercices corrigés
et des annales classés par matière et par niveau.

---

##  Installation

### Prérequis

| Outil | Version |
|-------|---------|
| PHP | 8.1+ |
| Composer | 2.x |
| Symfony | 7.x |
| MySQL | 8.0 |

### Étapes
```bash
# 1. Cloner le projet
git clone https://github.com/VOTRE-PSEUDO/schoolprepar.git
cd schoolprepar

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env .env.local

# 4. Lancer le serveur
wampserver
```

Accédez à l'application sur **http://localhost:8000**

---

##  Architecture MVC
```
SchoolPrepar/

Controller/
    HomeController.php    ← Contrôleur page d'accueil
    CourseController.php  ← Contrôleur des cours
templates/
base.html.twig            ← Layout principal
 home/
    index.html.twig       ← Page d'accueil
course/
    index.html.twig       ← Page des cours
config/
    packages/
        twig.yaml             ← Configuration Twig
    public/
        index.php                 ← Point d'entrée
    
```

---

##  Routes

| Route | Nom | Contrôleur | Description |
|-------|-----|------------|-------------|
| `GET /` | `app_home` | HomeController | Page d'accueil |
| `GET /course` | `course_index` | CourseController | Liste des cours |

---

##  Fonctionnalités TP1

- Page d'accueil dynamique avec statistiques
-  Affichage des matières en grille
-  Liste des cours disponibles
-  Layout principal Twig (navbar + footer)
- 2 contrôleurs configurés
-  Routes proprement définies

---

##  Acteurs identifiés

| Acteur | Rôle |
|--------|------|
| Élève | Consulte les cours, s'inscrit, suit sa progression |
| Enseignant | Crée et gère les ressources pédagogiques |
| Administrateur | Gère les utilisateurs, matières et niveaux |

---

##  Modèle de données

| Entité | Description |
|--------|-------------|
| User | Élève, Enseignant ou Administrateur |
| Course | Cours, exercice ou annale |
| Subject | Matière scolaire |
| Level | Niveau scolaire |
| Enrollment | Inscription d'un élève à un cours |

---


---

##  Commandes utiles
```bash
# Lister les routes
php bin/console debug:router

# Vider le cache
php bin/console cache:clear

# Créer un contrôleur
php bin/console make:controller NomController
```

---

*Projet pédagogique – IT 232 Développement Web II – 2025/2026*