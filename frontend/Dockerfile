# =========================
# Étape 1 : Build
# =========================
FROM oven/bun:1.3.4-alpine AS builder

WORKDIR /app

# Copier les fichiers de dépendances pour profiter du cache Docker
COPY package.json bun.lock ./

# Installer les dépendances
RUN bun install --frozen-lockfile

# Copier le reste du code source
COPY . .

# Compiler le projet (adapter la commande selon ton package.json, ex: build)
RUN bun run build

# =========================
# Étape 2 : Production (Serveur de fichiers statiques)
# =========================
FROM nginx:alpine AS prod

# Copier les fichiers compilés depuis l'étape builder
# Note : vérifie si ton dossier de sortie est 'dist' ou 'build'
COPY --from=builder /app/dist /usr/share/nginx/html

# Optionnel : Copier une config Nginx personnalisée pour gérer le SPA routing (React/Vue)
# COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]