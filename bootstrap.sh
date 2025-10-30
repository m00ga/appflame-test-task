#!/usr/bin/env bash
set -euo pipefail
#─── Configuration ─────────────────────────────────────────────────────────────
readonly SAIL_BIN="./vendor/bin/sail"
readonly COMPOSER_IMAGE="laravelsail/php84-composer:latest"
readonly WORKDIR="/var/www/html"
#─── ANSI color codes ───────────────────────────────────────────────────────────
readonly RED="\033[0;31m"
readonly GREEN="\033[0;32m"
readonly YELLOW="\033[0;33m"
readonly NC="\033[0m" # No Color
#─── Logging helpers ────────────────────────────────────────────────────────────
log()   { printf "${GREEN}✔%b${NC} %s\n" "" "$1"; }
warn()  { printf "${YELLOW}➜%b${NC} %s\n" "" "$1"; }
error() { printf "${RED}✖%b${NC} %s\n" "" "$1" >&2; }
#─── Preconditions ─────────────────────────────────────────────────────────────
require_cmd() {
  if ! command -v "$1" &>/dev/null; then
    error "Required command '$1' not found."
    exit 1
  fi
}
require_cmd docker
if [[ ! -f composer.json ]]; then
  error "composer.json not found. Run this script from your Laravel project root."
  exit 1
fi
#─── Flags & Environment ────────────────────────────────────────────────────────
# Default: run migrations
MIGRATE=true
# Default: generate app key
GENERATE_KEY=true

# Honor env var
if [[ "${SKIP_MIGRATIONS:-}" =~ ^(1|true|yes)$ ]]; then
  MIGRATE=false
fi
if [[ "${SKIP_KEY_GENERATION:-}" =~ ^(1|true|yes)$ ]]; then
  GENERATE_KEY=false
fi


# Parse CLI flags
for arg in "$@"; do
  case "$arg" in
    --skip-migrations|--no-migrations)
      MIGRATE=false
      ;;
    --migrations) # Explicitly enable, though it's default
      MIGRATE=true
      ;;
    --skip-key-generation|--no-key-generation)
      GENERATE_KEY=false
      ;;
    --key-generation) # Explicitly enable, though it's default
      GENERATE_KEY=true
      ;;
    *)
      # ignore other flags
      ;;
  esac
done
#─── Tasks ─────────────────────────────────────────────────────────────────────
install_php_deps() {
  if [[ -d vendor ]]; then
    warn "vendor/ exists; skipping Composer install"
  else
    log "Installing PHP dependencies (Composer via Docker)…"
    docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$(pwd):${WORKDIR}" \
      -w "${WORKDIR}" \
      "${COMPOSER_IMAGE}" \
      composer install --ignore-platform-reqs
  fi
}

start_sail() {
  log "Starting Laravel Sail in detached mode…"
  "${SAIL_BIN}" up -d
}

generate_app_key() {
  if [[ "${GENERATE_KEY}" == false ]]; then
    warn "Skipping Laravel application key generation"
  elif ! "${SAIL_BIN}" artisan env:get APP_KEY | grep -q "No application key has been specified."; then
    warn "Application key already exists; skipping generation"
  else
    log "Generating Laravel application key…"
    "${SAIL_BIN}" artisan key:generate
  fi
}

apply_migrations() {
  if [[ "${MIGRATE}" == false ]]; then
    warn "Skipping database migrations"
  else
    log "Applying database migrations…"
    "${SAIL_BIN}" artisan migrate --force
  fi
}

install_node_deps() {
  if [[ -d node_modules ]]; then
    warn "node_modules/ exists; skipping npm install"
  else
    log "Installing Node dependencies via Sail…"
    "${SAIL_BIN}" npm ci
  fi
}
#─── Main ──────────────────────────────────────────────────────────────────────
main() {
  install_php_deps
  start_sail
  generate_app_key
  apply_migrations
  install_node_deps
  log "Project setup complete!"
}
main "$@"
