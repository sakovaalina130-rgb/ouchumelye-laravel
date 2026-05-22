# CI/CD Pipeline Documentation

## Overview
This pipeline is triggered on push or pull request to branches:
- `main` (production)
- `uat` (user acceptance testing)
- `development` (development)

## Pipeline Stages

### 1. Linting (Laravel Pint)
- **Tool**: Laravel Pint with PSR-12 preset
- **Mode**: Test mode (--test flag)
- **Fail condition**: Any code style violation found

### 2. Static Analysis (PHPStan/Larastan)
- **Tool**: Larastan (PHPStan wrapper)
- **Level**: 5
- **Fail condition**: Any error found (warnings ignored)

### 3. Tests with Coverage
- **Tool**: PHPUnit with Xdebug
- **Minimum coverage**: 50%
- **Database**: SQLite in-memory (from .env.ci)
- **Fail condition**: Tests fail or coverage < 50%

### 4. Deployment Simulation
- **development** → uses `.env.dev`
- **uat** → uses `.env.uat`
- **main** → uses `.env.prod`
- **Condition**: Only runs if previous steps succeed

### 5. Production Approval (main only)
- **Environment**: GitHub Environments with required reviewer
- **Manual approval**: Required before deployment

## Environment Files
- `.env.dev` - Development environment
- `.env.uat` - UAT environment
- `.env.prod` - Production environment (APP_KEY left blank)
- `.env.ci` - CI pipeline (SQLite in-memory)

## Required Secrets
- None for basic pipeline (uses dummy values)

## Pipeline Triggers
- Push to any of the three long-lived branches
- Pull requests to these branches

## Artifacts
- Coverage reports uploaded to Codecov (if configured)

## Success Criteria
1. ✅ No linter violations
2. ✅ No static analysis errors
3. ✅ All tests pass
4. ✅ Test coverage >= 50%
5. ✅ Manual approval for production (if main branch)
