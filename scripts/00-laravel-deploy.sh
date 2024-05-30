#!/usr/bin/env bash
echo "================Running composer================"

# Optimization
php artisan optimize
npm install
npm run build
