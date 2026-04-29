# Justification Technique - TP3 SchoolPrepar

## Modèle de données implémenté

### Entités créées

#### 1. Filiere
- **Rôle** : Gestion des filières académiques
- **Attributs** : nom, domaine, description, durée, langue, image
- **Relations** : 
  - N:N avec Etablissement (une filière peut être dans plusieurs établissements)
  - 1:N avec Evenement (une filière peut avoir plusieurs événements)

#### 2. Etablissement  
- **Rôle** : Gestion des établissements scolaires
- **Attributs** : nom, ville, description, téléphone, email, adresse, type
- **Relations** :
  - N:N avec Filiere (un établissement peut avoir plusieurs filières)
  - 1:N avec User (un établissement peut avoir plusieurs utilisateurs)

#### 3. User
- **Rôle** : Gestion des utilisateurs/acteurs (élèves, enseignants, administrateurs)
- **Attributs** : nom, prénom, email, password, role, téléphone
- **Relations** :
  - N:1 avec Etablissement (un utilisateur appartient à un établissement)
  - N:1 avec Filiere (un utilisateur peut être rattaché à une filière)
  - 1:N avec Evenement (un utilisateur peut organiser plusieurs événements)

#### 4. Evenement
- **Rôle** : Élément dynamique du système (événements, rendez-vous, etc.)
- **Attributs** : titre, description, dateDebut, dateFin, lieu, type, capacité
- **Relations** :
  - N:1 avec Filiere (un événement appartient à une filière)
  - N:1 avec User (un événement est organisé par un utilisateur)

## Relations implémentées

### Relation N:N : Filiere ↔ Etablissement
- **Justification** : Une filière peut être proposée dans plusieurs établissements, et un établissement peut proposer plusieurs filières
- **Implémentation** : Table de jointure `filiere_etablissement` générée automatiquement par Doctrine

### Relation 1:N : Etablissement → User
- **Justification** : Un établissement regroupe plusieurs utilisateurs, mais un utilisateur n'appartient qu'à un seul établissement
- **Implémentation** : Clé étrangère `etablissement_id` dans la table `user`

### Relation 1:N : Filiere → Evenement
- **Justification** : Une filière peut organiser plusieurs événements, mais un événement est rattaché à une seule filière
- **Implémentation** : Clé étrangère `filiere_id` dans la table `evenement`

### Relation 1:N : User → Evenement (organisateur)
- **Justification** : Un utilisateur peut organiser plusieurs événements, mais un événement n'a qu'un seul organisateur
- **Implémentation** : Clé étrangère `organisateur_id` dans la table `evenement`

## Choix techniques

### SGBD : PostgreSQL
- **Justification** : Robustesse, support des relations complexes, performances
- **Version** : 16
- **Encodage** : UTF8

### ORM : Doctrine
- **Justification** : Intégration native avec Symfony, gestion automatique des migrations
- **Configuration** : Annotations PHP pour le mapping

### Architecture MVC respectée
- **Entités** : `src/Entity/`
- **Contrôleurs** : `src/Controller/Admin/` et `src/Controller/Front/`
- **Templates** : `templates/admin/` et `templates/front/`

## Conformité avec les exigences du TP

### ✅ Gestion des filières
- Entité `Filiere` complète avec tous les attributs nécessaires

### ✅ Gestion des établissements  
- Entité `Etablissement` avec informations complètes

### ✅ Gestion des utilisateurs/acteurs
- Entité `User` avec gestion des rôles (élève, enseignant, admin)

### ✅ Élément dynamique
- Entité `Evenement` pour la gestion des événements/rendez-vous

### ✅ Relation 1:N
- Etablissement → User
- Filiere → Evenement  
- User → Evenement (organisateur)

### ✅ Relation N:N
- Filiere ↔ Etablissement

## Prochaines étapes

1. **Configuration PostgreSQL** (activation des extensions PHP)
2. **Génération des migrations** : `php bin/console make:migration`
3. **Création de la BDD** : `php bin/console doctrine:migrations:migrate`
4. **Développement des CRUD** pour les 3 entités principales
5. **Intégration back-office** dans `/admin`
6. **Création des données de test**

---
*Auteur : Glenn N'SOUGAN*  
*Filière : Génie Logiciel*  
*Année académique : 2025-2026*
