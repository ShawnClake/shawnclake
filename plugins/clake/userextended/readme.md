#User Extended

## Overview
User Extended provides simple components and User Utility functions for complex interactions with users.

User Extended currently offers friends lists, role management, and User Utilities.

User Extended is typically a dependency to my other plugins.

## Installation
1. Ensure you install the RainLab.User plugin for OctoberCMS first
2. Install this plugin and run
        php artisan october:up
3. You're done :)

## Usage
* Just add the components you require to a page and everything should work out of the box
* Feel free to add your own classes which extend mine

## Feature List
* Frontend User role management in the form of Groups.
* Restrict access to pages or parts of a page using the UserGroups component
* List, send, and accept friend requests using the ListFriendRequests component and the UserList component
* List your friends using the ListFriends component
* Utility user functions which can be used across other plugins and code

## Planned Features
* Searching for users via name, email, or username
* Blocking and deleting friends
* Adding a service provider
* Adding an easy way to pragmatically change a users group
* Adding a better User settings page and a brief user profile page

## Details
User Extended is not trying to be a social network plugin. We are providing functionality for more complex user functions which have use cases outside of social networks.

Websites specializing in online games, forums, blogs, news etc. can all benefit from User Extended.