# Soccer Team Management System

A **Soccer Team Management System** built using **Laravel 10**, **MySQL**, and **RESTful APIs**.  
This project allows admins to manage soccer teams and players with full CRUD operations, validation, status management, and a simple admin UI.

---

## Features

### 🏟 Team Management
- Create, view, update, and delete teams
- Assign coach name to teams
- Activate / deactivate teams (AJAX-based)
- View team details with players

### Player Management
- Add players to a team
- Update player details (name, position, jersey number)
- Remove players from a team
- Activate / deactivate players
- Ensure player belongs to the correct team during updates

### REST API Support
- JSON-based REST APIs for teams and players
- Proper HTTP status codes
- Input validation with meaningful error messages
- Exception handling for reliability
- Designed for mobile or frontend integration

### Admin Interface
- Blade-based UI (no frontend framework)
- Tables for teams and players
- Forms for create/edit
- Validation error messages shown in UI
- AJAX actions for status toggle

---

## Tech Stack

- **Backend**: Laravel 10 (PHP 8+)
- **Database**: MySQL
- **Frontend**: Blade, HTML, CSS, JavaScript
- **API**: RESTful JSON APIs
- **Version Control**: Git & GitHub

---

## Database Structure

### teams table
| Column       | Type    |
|-------------|---------|
| id          | integer (PK) |
| name        | string |
| coach_name | string |
| status      | boolean (1 = active, 0 = inactive) |
| created_at | datetime |
| updated_at | datetime |

### players table
| Column        | Type    |
|--------------|---------|
| id           | integer (PK) |
| team_id      | integer (FK → teams.id) |
| name         | string |
| position     | string |
| jersey_number| integer |
| status       | boolean (1 = active, 0 = inactive) |
| created_at   | datetime |
| updated_at   | datetime |

---

## API Endpoints

### Teams API
| Method | Endpoint | Description |
|------|---------|------------|
| GET | /api/teams | List all teams |
| POST | /api/teams | Create new team |
| GET | /api/teams/{id} | Get team with players |
| PUT | /api/teams/{id} | Update team |
| DELETE | /api/teams/{id} | Delete team |

### Players API
| Method | Endpoint | Description |
|------|---------|------------|
| POST | /api/players | Add player |
| POST | /api/teams/{team_id}/players/{id} | Update player |
| DELETE | /api/players/{id} | Delete player |

---
    "position": "Midfielder"
}'
