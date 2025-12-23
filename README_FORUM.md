# Reddit-Like Community Forum

A full-featured community forum built with Laravel, inspired by Reddit.

## Features

- User authentication (registration, login, logout)
- Community creation and management
- Post creation with multiple types (text, link, image)
- Nested comment threading
- Upvote/downvote system for posts and comments
- User karma tracking
- Community subscriptions
- User profiles with activity history

## Database Schema

- **Users**: User accounts with karma scores
- **Communities**: Subreddit-like communities
- **Posts**: User-submitted content
- **Comments**: Nested comments on posts
- **Votes**: Upvotes and downvotes
- **Community_User**: User subscriptions to communities

## Routes

- `/` - Home page with popular posts
- `/register` - User registration
- `/login` - User login
- `/communities` - Browse all communities
- `/r/{community}` - View community posts
- `/posts/{post}` - View post details and comments
- `/u/{user}` - View user profile

## Tech Stack

- Laravel 12
- Tailwind CSS
- Blade Templates
- MySQL/SQLite

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Generate application key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Start the server: `php artisan serve`
