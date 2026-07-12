#!/bin/bash
# ================================================================
#  INTERSPORT Elverys - VPS Deployment Script
#  Run this on your VPS after cloning the repository
# ================================================================

set -e

echo "============================================"
echo "  INTERSPORT Elverys - Docker Deployment"
echo "============================================"
echo ""

# ─── 1. Check Prerequisites ────────────────────────────────
echo "📋 Step 1: Checking prerequisites..."

if ! command -v docker &> /dev/null; then
    echo "❌ Docker not found. Installing Docker..."
    curl -fsSL https://get.docker.com | sh
    sudo usermod -aG docker $USER
    echo "✅ Docker installed. Please log out and back in, then run this script again."
    exit 1
fi

if ! command -v docker compose &> /dev/null; then
    echo "❌ Docker Compose not found."
    echo "   Install it: sudo apt install docker-compose-plugin"
    exit 1
fi

echo "✅ Docker $(docker --version | cut -d' ' -f3)"
echo "✅ Docker Compose found"

# ─── 2. Setup Environment ──────────────────────────────────
echo ""
echo "📋 Step 2: Setting up environment..."

if [ ! -f .env ]; then
    cp .env.example .env
    echo "⚠️  Created .env file from .env.example"
    echo "   IMPORTANT: Edit .env with your actual credentials!"
    echo ""
    read -p "   Do you want to edit .env now? (y/n): " edit_env
    if [ "$edit_env" = "y" ]; then
        ${EDITOR:-nano} .env
    fi
else
    echo "✅ .env file exists"
fi

# Load env vars
source .env

# ─── 3. Export Database from Local ──────────────────────────
echo ""
echo "📋 Step 3: Database import..."

if [ -z "$(ls -A docker/db-init/ 2>/dev/null)" ]; then
    echo "⚠️  No database dump found in docker/db-init/"
    echo ""
    echo "   To export your local database, run this on your LOCAL machine:"
    echo ""
    echo "   mysqldump -u root ecom_wordpress > docker/db-init/001-database.sql"
    echo ""
    echo "   Then commit and push the dump, or scp it to the VPS:"
    echo "   scp docker/db-init/001-database.sql user@vps:/path/to/project/docker/db-init/"
    echo ""
    read -p "   Continue without database? (y/n): " continue_no_db
    if [ "$continue_no_db" != "y" ]; then
        exit 0
    fi
else
    echo "✅ Database dump found in docker/db-init/"
fi

# ─── 4. Set Permissions ────────────────────────────────────
echo ""
echo "📋 Step 4: Setting file permissions..."

# Ensure wp-content directories exist and are writable
mkdir -p wp-content/uploads
mkdir -p wp-content/cache
chmod -R 775 wp-content/uploads
chmod -R 775 wp-content/cache

echo "✅ Permissions set"

# ─── 5. Start Docker Containers ────────────────────────────
echo ""
echo "📋 Step 5: Starting Docker containers..."

docker compose up -d

echo ""
echo "⏳ Waiting for containers to be healthy..."
sleep 10

# Check if containers are running
docker compose ps

# ─── 6. Post-Setup ─────────────────────────────────────────
echo ""
echo "📋 Step 6: Post-deployment tasks..."

# Update site URL in database (if needed)
if [ ! -z "$SITE_URL" ]; then
    echo "   Updating WordPress URLs to: $SITE_URL"
    docker compose exec wordpress wp option update siteurl "$SITE_URL" --allow-root 2>/dev/null || \
        echo "   ⚠️  WP-CLI not available, update URLs manually in WP Admin > Settings"
fi

echo ""
echo "============================================"
echo "  ✅ Deployment Complete!"
echo "============================================"
echo ""
echo "  Your services are running at:"
echo "  ─────────────────────────────"
echo "  🌐 WordPress is listening locally on: http://127.0.0.1:8080"
echo ""
echo "  Next steps:"
echo "  ─────────────────────────────"
echo "  1. Import your database dump if not done"
echo "  2. Update WordPress URLs in Settings > General"
echo "  3. Configure your VPS Nginx to proxy_pass to http://127.0.0.1:8080"
echo ""
echo "  Useful commands:"
echo "  ─────────────────────────────"
echo "  docker compose logs -f          # View logs"
echo "  docker compose restart          # Restart all"
echo "  docker compose down             # Stop all"
echo "  docker compose exec db bash     # Access MySQL container"
echo ""
