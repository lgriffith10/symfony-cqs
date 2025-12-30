# 📝 Task Manager — Symfony & Vue.js (TDD / CQS)

Task management application built as a **learning / experimental project** to practice:

- **CQS (Command Query Separation)**
- **TDD (Test Driven Development)**
- **Backend: Symfony**
- **Frontend: Vue.js**
- **Testing: PHPUnit, Vitest**
- **JavaScript runtime: Bun**
- **Local infrastructure: Docker Compose (Databases)**
- **Server infrastructure: Docker Compose + Traefik**

---

## 🎯 Project Goals

- Strictly apply **Command / Query Separation**
- Develop **exclusively using TDD**
- Build a clean, testable, and maintainable architecture
- Test each layer independently
- Implement a clean frontend/backend communication

---

## 🧱 Global Architecture

```text
task-manager/
│
├── backend/        # Symfony API
├── frontend/       # Vue.js SPA
└── docker/         # Docker configuration (DB)
