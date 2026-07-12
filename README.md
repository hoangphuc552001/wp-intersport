# INTERSPORT Elverys - WordPress E-Commerce

This repository contains the WordPress e-commerce application for INTERSPORT Elverys. It is fully Dockerized to ensure consistent environments across local development and production deployments.

## 🚀 Prerequisites

Make sure you have the following installed on your machine or server:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

---

## 💻 Local Development Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/hoangphuc552001/wp-intersport.git
   cd wp-intersport
   ```

2. **Set up environment variables:**
   Copy the example environment file and update it with your local database credentials if needed.
   ```bash
   cp .env.example .env
   ```

3. **Start the Docker containers:**
   ```bash
   docker compose up -d
   ```

4. **Access the site:**
   The WordPress site will be available at: [http://localhost:8081](http://localhost:8081)

---

## 🌍 VPS / Production Deployment

Deploying to a production server (VPS) is streamlined using the provided `deploy.sh` script.

1. **SSH into your VPS:**
   ```bash
   ssh root@your_server_ip
   ```

2. **Clone the repository:**
   ```bash
   git clone https://github.com/hoangphuc552001/wp-intersport.git /path/to/wp-intersport
   cd /path/to/wp-intersport
   ```

3. **Run the deployment script:**
   The script will check prerequisites, set up `.env`, adjust file permissions for `wp-content/uploads` and `cache`, and start the Docker containers.
   ```bash
   chmod +x deploy.sh
   ./deploy.sh
   ```

4. **Updating the application later:**
   To pull new changes (like updated plugins, themes, or images) to the server:
   ```bash
   cd /path/to/wp-intersport
   git pull
   docker compose down
   docker compose up -d
   ```

---

## 📂 Repository Structure

- `docker-compose.yml`: Defines the WordPress service, database connections, PHP limits, and volume mounts.
- `deploy.sh`: Automated shell script for VPS deployment.
- `wp-content/themes/`: Custom and installed WordPress themes.
- `wp-content/plugins/`: WordPress plugins (including custom plugins like `intersport-footer`).
- `wp-content/uploads/`: Media library uploads and images (tracked via Git).
- `.env.example`: Template for environment variables (DB credentials, etc.).

---

## 🛠️ Notes & Troubleshooting

- **Missing Images/Assets:** Ensure that the `wp-content/uploads` directory is properly mounted in `docker-compose.yml` and that you have pulled the latest changes on the VPS.
- **Database URLs:** If moving between environments (e.g., Localhost to VPS), you may need to update the `siteurl` and `home` values in the `wp_options` table, and perform a search-replace for URLs in the database content.
- **File Permissions:** If WordPress asks for FTP credentials to update plugins/themes, ensure that the permissions on `wp-content` are correctly set (the `deploy.sh` script handles this for `uploads` and `cache`).
