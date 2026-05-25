# CI/CD Pipeline Documentation

## Overview
This pipeline is triggered on push or pull request to branches:
- `main` (production)
- `uat` (user acceptance testing)
- `development` (development)

## Pipeline Stages

### 1. Tests (PHPUnit)
- Minimum coverage: 50%
- Fail condition: Tests fail or coverage < 50%

### 2. Static Analysis (PHPStan/Larastan)
- Level: 5
- Fail condition: Any error found

### 3. Linting (Laravel Pint)
- Preset: PSR-12
- Mode: --test (no auto-fix)
- Fail condition: Any style violation

### 4. Deployment Simulation
- development → .env.dev
- uat → .env.uat
- main → .env.prod

### 5. Manual Approval (production only)
- Required for main branch
- GitHub Environments with reviewer

## Environment Files
- `.env.dev` - Development environment
- `.env.uat` - UAT environment
- `.env.prod` - Production environment
- `.env.ci` - CI pipeline (SQLite in-memory)

## Pipeline Triggers
- Push to main, development, uat branches
- Pull requests to these branches

## Success Criteria
1. All tests pass + coverage >= 50%
2. No static analysis errors
3. No linter violations
4. Manual approval for production
