# Appflame Test Task

## Project information

- Backend by default hosted on `http://localhost/`
- Frontend by default hosted on `http://localhost:3000/`
- API docs by default hosted on `http://localhost/docs/api`
- Bearer token are in env
- Project timezone are in env `APP_TIMEZONE=`, which would apply to both backend and frontend

## Local deployment instructions

1. Copy `.env.example` to `.env`
2. Fill application bearer token in env `API_SECRET=`
3. Run `bootstrap.sh` which would install all dependencies and start backend container
4. Run `./vendor/bin/sail npm run dev` to start frontend
